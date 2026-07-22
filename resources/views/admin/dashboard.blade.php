@extends('admin.layout.index')
@section('title')
{{__("message.Dashboard")}}
@stop
@section('content')

@php
   /* ------------------------------------------------------------------
      Display-only read queries. Nothing here writes, and no controller /
      route / model was changed — the 13 totals the controller already
      passes are all still used below; these queries only add the finer
      slices (today / per-status / recent rows) that the premium widgets
      need. All lightweight aggregates over small tables.
      ------------------------------------------------------------------ */
   $hdNow = \Carbon\Carbon::now();

   // Today + month-over-month slices (for KPI secondary lines / trends)
   $hdTodayOrders   = \App\Models\Orders::whereDate('created_at', $hdNow->toDateString())->count();
   $hdTodayRevenue  = (float) \App\Models\Orders::whereDate('created_at', $hdNow->toDateString())->sum('final_total');
   $hdMonthOrders   = \App\Models\Orders::whereBetween('created_at', [$hdNow->copy()->startOfMonth(), $hdNow])->count();
   $hdLastMonthOrders = \App\Models\Orders::whereBetween('created_at', [$hdNow->copy()->subMonthNoOverflow()->startOfMonth(), $hdNow->copy()->subMonthNoOverflow()->endOfMonth()])->count();
   $hdMonthRevenue  = (float) \App\Models\Orders::whereBetween('created_at', [$hdNow->copy()->startOfMonth(), $hdNow])->sum('final_total');
   $hdLastMonthRevenue = (float) \App\Models\Orders::whereBetween('created_at', [$hdNow->copy()->subMonthNoOverflow()->startOfMonth(), $hdNow->copy()->subMonthNoOverflow()->endOfMonth()])->sum('final_total');
   $hdMonthUsers    = \App\Models\User::where('user_type', '3')->whereBetween('created_at', [$hdNow->copy()->startOfMonth(), $hdNow])->count();

   $hdTrend = function ($current, $previous) {
      if ($previous <= 0) { return null; } // no baseline — show a neutral chip, never a fake %
      return round((($current - $previous) / $previous) * 100);
   };
   $hdOrdersTrend  = $hdTrend($hdMonthOrders, $hdLastMonthOrders);
   $hdRevenueTrend = $hdTrend($hdMonthRevenue, $hdLastMonthRevenue);

   // Full per-status breakdown (codes are the same ones OrderControllers
   // uses for its own labels: 1 Pending … 8 Partial Report Send)
   $hdStatusCounts = \App\Models\Orders::selectRaw('status, count(*) c')->groupBy('status')->pluck('c', 'status');
   $hdStatusMeta = [
      1 => ['label' => __('message.Pending'),          'tone' => 'warning'],
      2 => ['label' => __('message.Accepted'),         'tone' => 'info'],
      5 => ['label' => __('message.Sample collected'), 'tone' => 'brand'],
      6 => ['label' => __('message.Preparing Report'), 'tone' => 'info'],
      8 => ['label' => 'Partial Report Send',          'tone' => 'warning'],
      7 => ['label' => __('message.Complete'),         'tone' => 'success'],
      3 => ['label' => __('message.Rejected'),         'tone' => 'danger'],
      4 => ['label' => __('message.Refunded'),         'tone' => 'muted'],
   ];

   // Last 6 calendar months for the revenue/bookings chart
   $hdMonthlyRaw = \App\Models\Orders::selectRaw("DATE_FORMAT(created_at, '%Y-%m') ym, count(*) c, COALESCE(sum(final_total),0) rev")
      ->where('created_at', '>=', $hdNow->copy()->subMonthsNoOverflow(5)->startOfMonth())
      ->groupBy('ym')->get()->keyBy('ym');
   $hdChartLabels = []; $hdChartRevenue = []; $hdChartOrders = [];
   for ($i = 5; $i >= 0; $i--) {
      $m = $hdNow->copy()->subMonthsNoOverflow($i);
      $row = $hdMonthlyRaw[$m->format('Y-m')] ?? null;
      $hdChartLabels[]  = $m->format('M Y');
      $hdChartRevenue[] = $row ? (float) $row->rev : 0;
      $hdChartOrders[]  = $row ? (int) $row->c : 0;
   }

   // Recent orders (with customer for the avatar/name)
   $hdRecentOrders = \App\Models\Orders::with('customer')->orderByDesc('created_at')->limit(7)->get();

   // Top selling packages — orders_data stores a denormalized item_name,
   // type '1' = package (same convention as the checkout route)
   $hdTopPackages = \App\Models\OrdersData::where('type', '1')
      ->selectRaw('item_name, count(*) bookings, COALESCE(sum(price),0) revenue')
      ->groupBy('item_name')->orderByDesc('bookings')->limit(5)->get();
   $hdTopPackageMax = max(1, (int) ($hdTopPackages->max('bookings') ?? 1));

   // Top labs — orders.manager_id → users (user_type 2 = branch/lab).
   // Joining on user_type=2 naturally excludes admin-created rows.
   $hdTopLabs = \App\Models\Orders::join('users', function ($j) {
         $j->on('users.id', '=', 'orders.manager_id')->where('users.user_type', '2');
      })
      ->selectRaw('users.name lab_name, count(orders.id) orders_count, COALESCE(sum(orders.final_total),0) revenue')
      ->groupBy('users.name')->orderByDesc('orders_count')->limit(5)->get();

   // Recent activity — merge the three real event streams we have
   $hdActivity = collect();
   foreach (\App\Models\Orders::orderByDesc('created_at')->limit(5)->get() as $o) {
      $hdActivity->push(['icon' => 'order', 'at' => $o->created_at,
         'text' => 'New order #' . $o->id . ' — ' . $currency . number_format($o->final_total, 0)]);
   }
   foreach (\App\Models\User::where('user_type', '3')->orderByDesc('created_at')->limit(4)->get() as $u) {
      $hdActivity->push(['icon' => 'user', 'at' => $u->created_at,
         'text' => ($u->name ?: 'New user') . ' registered']);
   }
   foreach (\App\Models\Package::orderByDesc('updated_at')->limit(3)->get() as $p) {
      $hdActivity->push(['icon' => 'package', 'at' => $p->updated_at,
         'text' => 'Package updated — ' . $p->name]);
   }
   $hdActivity = $hdActivity->sortByDesc('at')->take(8);

   $hdCallbacks = \App\Models\Callback::count();
   $hdAdminName = \Illuminate\Support\Facades\Auth::user()->name ?? 'Admin';
   $hdHour = (int) $hdNow->format('H');
   $hdGreeting = $hdHour < 12 ? 'Good morning' : ($hdHour < 17 ? 'Good afternoon' : 'Good evening');

   $hdInitial = function ($name) {
      $name = trim((string) $name);
      return $name === '' ? '?' : strtoupper(mb_substr($name, 0, 1));
   };
@endphp

<!-- ===================== WELCOME HEADER ===================== -->
<div class="adm-dash-hero">
   <div class="adm-dash-hero-glow" aria-hidden="true"></div>
   <div class="adm-dash-hero-main">
      <p class="adm-dash-hero-greet">{{ $hdGreeting }},</p>
      <h1 class="adm-dash-hero-name">{{ $hdAdminName }}</h1>
      <p class="adm-dash-hero-date">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
         {{ $hdNow->format('l, d F Y') }} · <span id="admDashClock">{{ $hdNow->format('h:i A') }}</span>
      </p>
   </div>
   <div class="adm-dash-hero-actions">
      <a href="{{ route('save-package', ['id' => '0', 'tab' => '1']) }}" class="adm-dash-hero-btn">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/></svg>
         Add Package
      </a>
      <a href="{{ route('save-parameter', ['id' => '0', 'tab' => '1']) }}" class="adm-dash-hero-btn">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2v6.5L19 16v5a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-5l4.5-7.5V2"/><path d="M8.5 2h7"/></svg>
         Add Test
      </a>
      <a href="{{ url('savemanager/0') }}" class="adm-dash-hero-btn">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/></svg>
         Add Lab
      </a>
      <a href="{{ route('make_booking') }}" class="adm-dash-hero-btn is-primary">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
         Create Order
      </a>
   </div>
</div>

<!-- ===================== KPI CARDS ===================== -->
<div class="adm-kpi-grid adm-kpi-grid--dash">
   <div class="adm-kpi-card adm-kpi-accent--brand">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></span>
         @if($hdRevenueTrend !== null)
            <span class="adm-kpi-trend {{ $hdRevenueTrend < 0 ? 'is-down' : '' }}">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">@if($hdRevenueTrend < 0)<polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/>@else<polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>@endif</svg>
               {{ abs($hdRevenueTrend) }}%
            </span>
         @else
            <span class="adm-kpi-trend is-muted">this month</span>
         @endif
      </div>
      <div class="adm-kpi-value">{{ $currency }}{{ number_format($totalsales, 0, '.', ',') }}</div>
      <div class="adm-kpi-label">{{ __("message.Total Sales") }}</div>
   </div>

   <div class="adm-kpi-card adm-kpi-accent--success">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="m17 7-5-5-5 5"/><rect x="3" y="14" width="18" height="8" rx="2"/></svg></span>
         <span class="adm-kpi-trend is-muted">today</span>
      </div>
      <div class="adm-kpi-value">{{ $currency }}{{ number_format($hdTodayRevenue, 0, '.', ',') }}</div>
      <div class="adm-kpi-label">Today's Revenue</div>
   </div>

   <div class="adm-kpi-card adm-kpi-accent--info">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></span>
         @if($hdOrdersTrend !== null)
            <span class="adm-kpi-trend {{ $hdOrdersTrend < 0 ? 'is-down' : '' }}">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">@if($hdOrdersTrend < 0)<polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/>@else<polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>@endif</svg>
               {{ abs($hdOrdersTrend) }}%
            </span>
         @else
            <span class="adm-kpi-trend is-muted">this month</span>
         @endif
      </div>
      <div class="adm-kpi-value">{{ $totalorder }}</div>
      <div class="adm-kpi-label">{{ __("message.Total Orders") }}</div>
   </div>

   <div class="adm-kpi-card adm-kpi-accent--info">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg></span>
         <span class="adm-kpi-trend is-muted">today</span>
      </div>
      <div class="adm-kpi-value">{{ $hdTodayOrders }}</div>
      <div class="adm-kpi-label">Today's Orders</div>
   </div>

   <div class="adm-kpi-card adm-kpi-accent--warning">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></span>
         <span class="adm-kpi-trend is-muted">{{ $totalorder > 0 ? round($pendingorders / $totalorder * 100) : 0 }}% of all</span>
      </div>
      <div class="adm-kpi-value">{{ $pendingorders }}</div>
      <div class="adm-kpi-label">{{ __("message.Pending Orders") }}</div>
   </div>

   <div class="adm-kpi-card adm-kpi-accent--success">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>
         <span class="adm-kpi-trend is-muted">{{ $totalorder > 0 ? round($completeorder / $totalorder * 100) : 0 }}% of all</span>
      </div>
      <div class="adm-kpi-value">{{ $completeorder }}</div>
      <div class="adm-kpi-label">{{ __("message.Complete Orders") }}</div>
   </div>

   <div class="adm-kpi-card adm-kpi-accent--info">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
         <span class="adm-kpi-trend {{ $hdMonthUsers > 0 ? '' : 'is-muted' }}">+{{ $hdMonthUsers }} this month</span>
      </div>
      <div class="adm-kpi-value">{{ $totalusers }}</div>
      <div class="adm-kpi-label">{{ __("message.Total Users") }}</div>
   </div>

   <div class="adm-kpi-card adm-kpi-accent--brand">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg></span>
         <span class="adm-kpi-trend is-muted">active</span>
      </div>
      <div class="adm-kpi-value">{{ $totalmanager }}</div>
      <div class="adm-kpi-label">Active Labs</div>
   </div>
</div>

<!-- ===================== REVENUE ANALYTICS ===================== -->
<div class="adm-section">
   <div class="adm-section-head">
      <div>
         <h3 class="adm-section-title"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>Revenue Analytics</h3>
         <p class="adm-section-sub">Monthly revenue and booking trends — last 6 months</p>
      </div>
   </div>
   <div class="adm-charts-grid adm-charts-grid--analytics">
      <div class="adm-card adm-chart-card">
         <h4 class="adm-chart-title">Revenue &amp; Bookings</h4>
         <div class="adm-chart-canvas-wrap"><canvas id="admRevenueChart"></canvas></div>
         <div class="adm-chart-legend">
            <span class="adm-chart-legend-item"><span class="adm-chart-legend-dot" style="background:var(--accent-color);"></span>Revenue ({{ $currency }})</span>
            <span class="adm-chart-legend-item"><span class="adm-chart-legend-dot" style="background:var(--primary-color);"></span>Orders</span>
         </div>
      </div>
      <div class="adm-card adm-chart-card">
         <h4 class="adm-chart-title">Order Status Split</h4>
         <div class="adm-chart-canvas-wrap"><canvas id="admOrderStatusChart"></canvas></div>
         <div class="adm-chart-legend" id="admStatusLegend"></div>
      </div>
   </div>
</div>

<!-- ===================== ORDER STATUS OVERVIEW ===================== -->
<div class="adm-section">
   <div class="adm-section-head">
      <div>
         <h3 class="adm-section-title"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>Order Status Overview</h3>
         <p class="adm-section-sub">Live breakdown of all {{ $totalorder }} orders by status</p>
      </div>
   </div>
   <div class="adm-status-grid">
      @foreach($hdStatusMeta as $code => $meta)
         @php
            $c = (int) ($hdStatusCounts[$code] ?? 0);
            $pct = $totalorder > 0 ? round($c / $totalorder * 100) : 0;
         @endphp
         <div class="adm-status-card">
            <div class="adm-status-card-head">
               <span class="adm-status-dot adm-tone--{{ $meta['tone'] }}"></span>
               <span class="adm-status-label">{{ $meta['label'] }}</span>
            </div>
            <div class="adm-status-figures">
               <span class="adm-status-count">{{ $c }}</span>
               <span class="adm-status-pct">{{ $pct }}%</span>
            </div>
            <div class="adm-progress"><span class="adm-progress-bar adm-tone--{{ $meta['tone'] }}" style="width: {{ $pct }}%;"></span></div>
         </div>
      @endforeach
   </div>
</div>

<!-- ===================== RECENT ORDERS + ACTIVITY ===================== -->
<div class="adm-section">
   <div class="adm-dash-cols">
      <div class="adm-card adm-dash-col-main">
         <div class="adm-card-head">
            <h4 class="adm-chart-title"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>Recent Orders</h4>
            <a href="{{ route('admin-orders') }}" class="adm-card-head-link">View all
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
         </div>
         @if(count($hdRecentOrders) > 0)
         <div class="adm-recent-table-wrap">
            <table class="adm-recent-table">
               <thead>
                  <tr><th>Order</th><th>Customer</th><th>Amount</th><th>Status</th><th>Placed</th></tr>
               </thead>
               <tbody>
                  @foreach($hdRecentOrders as $o)
                     @php
                        $meta = $hdStatusMeta[(int) $o->status] ?? ['label' => '—', 'tone' => 'muted'];
                        $custName = $o->customer->name ?? 'Guest';
                     @endphp
                     <tr>
                        <td class="adm-recent-id">#{{ $o->id }}</td>
                        <td>
                           <span class="adm-recent-user">
                              <span class="adm-avatar-initial">{{ $hdInitial($custName) }}</span>
                              {{ $custName }}
                           </span>
                        </td>
                        <td class="adm-recent-amount">{{ $currency }}{{ number_format($o->final_total, 0) }}</td>
                        <td><span class="adm-status-chip adm-tone--{{ $meta['tone'] }}">{{ $meta['label'] }}</span></td>
                        <td class="adm-recent-date">{{ \Carbon\Carbon::parse($o->created_at)->format('d M, h:i A') }}</td>
                     </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
         @else
            <p class="adm-dash-empty">No orders yet.</p>
         @endif
      </div>

      <div class="adm-card adm-dash-col-side">
         <div class="adm-card-head">
            <h4 class="adm-chart-title"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>Recent Activity</h4>
         </div>
         <ul class="adm-activity">
            @forelse($hdActivity as $a)
               <li class="adm-activity-item">
                  <span class="adm-activity-icon adm-activity-icon--{{ $a['icon'] }}">
                     @if($a['icon'] === 'order')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                     @elseif($a['icon'] === 'user')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                     @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/></svg>
                     @endif
                  </span>
                  <div class="adm-activity-body">
                     <p class="adm-activity-text">{{ $a['text'] }}</p>
                     <span class="adm-activity-time">{{ \Carbon\Carbon::parse($a['at'])->diffForHumans() }}</span>
                  </div>
               </li>
            @empty
               <li class="adm-dash-empty">No recent activity.</li>
            @endforelse
         </ul>
      </div>
   </div>
</div>

<!-- ===================== TOP PACKAGES + TOP LABS ===================== -->
<div class="adm-section">
   <div class="adm-dash-cols adm-dash-cols--even">
      <div class="adm-card">
         <div class="adm-card-head">
            <h4 class="adm-chart-title"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>Top Selling Packages</h4>
            <a href="{{ route('show-package') }}" class="adm-card-head-link">All packages
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
         </div>
         <ul class="adm-top-list">
            @forelse($hdTopPackages as $tp)
               <li class="adm-top-item">
                  <div class="adm-top-item-row">
                     <span class="adm-top-name">{{ $tp->item_name }}</span>
                     <span class="adm-top-figures">{{ $tp->bookings }} bookings · {{ $currency }}{{ number_format($tp->revenue, 0) }}</span>
                  </div>
                  <div class="adm-progress"><span class="adm-progress-bar adm-tone--brand" style="width: {{ round($tp->bookings / $hdTopPackageMax * 100) }}%;"></span></div>
               </li>
            @empty
               <li class="adm-dash-empty">No package bookings yet.</li>
            @endforelse
         </ul>
      </div>

      <div class="adm-card">
         <div class="adm-card-head">
            <h4 class="adm-chart-title"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/></svg>Top Labs</h4>
            <a href="{{ route('manager') }}" class="adm-card-head-link">All labs
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
         </div>
         <ul class="adm-top-list">
            @forelse($hdTopLabs as $i => $lab)
               <li class="adm-top-item adm-top-item--rank">
                  <span class="adm-rank-badge {{ $i === 0 ? 'is-first' : '' }}">{{ $i + 1 }}</span>
                  <div class="adm-top-item-grow">
                     <div class="adm-top-item-row">
                        <span class="adm-top-name">{{ $lab->lab_name }}</span>
                        <span class="adm-top-figures">{{ $lab->orders_count }} orders</span>
                     </div>
                     <span class="adm-top-sub">{{ $currency }}{{ number_format($lab->revenue, 0) }} revenue</span>
                  </div>
               </li>
            @empty
               <li class="adm-dash-empty">No lab orders yet.</li>
            @endforelse
         </ul>
      </div>
   </div>
</div>

<!-- ===================== CATALOG AT A GLANCE ===================== -->
<div class="adm-section">
   <div class="adm-card adm-glance-card">
      <div class="adm-card-head">
         <h4 class="adm-chart-title"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Catalog &amp; Support at a Glance</h4>
      </div>
      <div class="adm-glance-grid">
         <div class="adm-glance-item"><span class="adm-glance-value">{{ $totalpackage }}</span><span class="adm-glance-label">{{ __("message.Total Packages") }}</span></div>
         <div class="adm-glance-item"><span class="adm-glance-value">{{ $totalprofile }}</span><span class="adm-glance-label">Profiles</span></div>
         <div class="adm-glance-item"><span class="adm-glance-value">{{ $totalparameter }}</span><span class="adm-glance-label">Parameters</span></div>
         <div class="adm-glance-item"><span class="adm-glance-value">{{ $totalpopular }}</span><span class="adm-glance-label">Popular Packages</span></div>
         <div class="adm-glance-item"><span class="adm-glance-value">{{ $totalcategory }}</span><span class="adm-glance-label">Categories</span></div>
         <div class="adm-glance-item"><span class="adm-glance-value">{{ $totalcity }}</span><span class="adm-glance-label">Cities</span></div>
         <div class="adm-glance-item"><span class="adm-glance-value">{{ $hdCallbacks }}</span><span class="adm-glance-label">Callback Requests</span></div>
      </div>
   </div>
</div>

<!-- ===================== QUICK ACTIONS ===================== -->
<div class="adm-section">
   <div class="adm-section-head">
      <div>
         <h3 class="adm-section-title"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>Quick Actions</h3>
         <p class="adm-section-sub">Jump straight to the modules you use most</p>
      </div>
   </div>
   <div class="adm-quick-grid">
      <a href="{{ route('save-package', ['id' => '0', 'tab' => '1']) }}" class="adm-quick-card">
         <span class="adm-quick-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg></span>
         <span class="adm-quick-title">Add Package</span>
         <span class="adm-quick-desc">Create a new health package</span>
      </a>
      <a href="{{ route('save-parameter', ['id' => '0', 'tab' => '1']) }}" class="adm-quick-card">
         <span class="adm-quick-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2v6.5L19 16v5a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-5l4.5-7.5V2"/><path d="M8.5 2h7"/></svg></span>
         <span class="adm-quick-title">Add Test</span>
         <span class="adm-quick-desc">Create a new lab parameter</span>
      </a>
      <a href="{{ route('save-profile', ['id' => '0']) }}" class="adm-quick-card">
         <span class="adm-quick-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></span>
         <span class="adm-quick-title">Add Profile</span>
         <span class="adm-quick-desc">Bundle tests into a profile</span>
      </a>
      <a href="{{ url('savemanager/0') }}" class="adm-quick-card">
         <span class="adm-quick-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/></svg></span>
         <span class="adm-quick-title">Add Lab</span>
         <span class="adm-quick-desc">Register a branch or lab</span>
      </a>
      <a href="{{ route('user') }}" class="adm-quick-card">
         <span class="adm-quick-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
         <span class="adm-quick-title">Manage Users</span>
         <span class="adm-quick-desc">View registered customers</span>
      </a>
      <a href="{{ route('admin-orders') }}" class="adm-quick-card">
         <span class="adm-quick-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></span>
         <span class="adm-quick-title">Manage Orders</span>
         <span class="adm-quick-desc">View &amp; manage all orders</span>
      </a>
   </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* Live clock in the welcome header — display only */
    (function () {
        var el = document.getElementById('admDashClock');
        if (!el) return;
        function tick() {
            var d = new Date();
            var h = d.getHours(), m = d.getMinutes();
            var ampm = h >= 12 ? 'PM' : 'AM';
            h = h % 12; if (h === 0) h = 12;
            el.textContent = (h < 10 ? '0' + h : h) + ':' + (m < 10 ? '0' + m : m) + ' ' + ampm;
        }
        tick();
        setInterval(tick, 30000);
    })();

    if (typeof Chart === 'undefined') { return; }

    /* Chart.js needs real color strings, not CSS var() syntax — read the
       current theme.css values at runtime instead of hardcoding a second
       copy, so charts stay in sync if the palette ever changes. */
    var rootStyle = getComputedStyle(document.documentElement);
    var cssVar = function (name, fallback) {
        var v = rootStyle.getPropertyValue(name).trim();
        return v || fallback;
    };
    var accentColor  = cssVar('--accent-color', '#f67f2d');
    var primaryColor = cssVar('--primary-color', '#0a6c79');
    var toneColors = {
        warning: cssVar('--warning-color', '#f59e0b'),
        info:    cssVar('--info-color', '#2563eb'),
        brand:   primaryColor,
        success: cssVar('--success-strong', '#059669'),
        danger:  cssVar('--danger-color', '#dc2626'),
        muted:   '#cbd5e1'
    };

    /* --- Revenue & bookings combo (line = revenue, bars = orders) --- */
    var revCtx = document.getElementById('admRevenueChart');
    if (revCtx) {
        new Chart(revCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($hdChartLabels) !!},
                datasets: [{
                    label: 'Revenue',
                    type: 'line',
                    data: {!! json_encode($hdChartRevenue) !!},
                    borderColor: accentColor,
                    backgroundColor: 'transparent',
                    pointBackgroundColor: accentColor,
                    lineTension: 0.35,
                    borderWidth: 2.5,
                    yAxisID: 'y-rev'
                }, {
                    label: 'Orders',
                    data: {!! json_encode($hdChartOrders) !!},
                    backgroundColor: primaryColor,
                    borderRadius: 6,
                    maxBarThickness: 34,
                    yAxisID: 'y-ord'
                }]
            },
            options: {
                legend: { display: false },
                tooltips: { mode: 'index', intersect: false },
                scales: {
                    yAxes: [
                        { id: 'y-rev', position: 'left', ticks: { beginAtZero: true }, gridLines: { color: '#eef2f1' } },
                        { id: 'y-ord', position: 'right', ticks: { beginAtZero: true, precision: 0 }, gridLines: { display: false } }
                    ],
                    xAxes: [{ gridLines: { display: false } }]
                }
            }
        });
    }

    /* --- Status doughnut, built from the same per-status counts as the
           overview cards; zero-count statuses are skipped --- */
    var statusData = [
        @foreach($hdStatusMeta as $code => $meta)
            { label: @json($meta['label']), tone: @json($meta['tone']), count: {{ (int) ($hdStatusCounts[$code] ?? 0) }} },
        @endforeach
    ].filter(function (s) { return s.count > 0; });

    var statusCtx = document.getElementById('admOrderStatusChart');
    if (statusCtx && statusData.length) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusData.map(function (s) { return s.label; }),
                datasets: [{
                    data: statusData.map(function (s) { return s.count; }),
                    backgroundColor: statusData.map(function (s) { return toneColors[s.tone] || toneColors.muted; }),
                    borderWidth: 0
                }]
            },
            options: {
                cutoutPercentage: 68,
                legend: { display: false },
                tooltips: { enabled: true }
            }
        });

        var legend = document.getElementById('admStatusLegend');
        if (legend) {
            statusData.forEach(function (s) {
                var item = document.createElement('span');
                item.className = 'adm-chart-legend-item';
                var dot = document.createElement('span');
                dot.className = 'adm-chart-legend-dot';
                dot.style.background = toneColors[s.tone] || toneColors.muted;
                item.appendChild(dot);
                item.appendChild(document.createTextNode(s.label + ' (' + s.count + ')'));
                legend.appendChild(item);
            });
        }
    }
});
</script>
@endsection
