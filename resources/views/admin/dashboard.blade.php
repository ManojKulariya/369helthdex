@extends('admin.layout.index')
@section('title')
{{__("message.Dashboard")}}
@stop
@section('content')
<!--Page header-->
<div class="page-header">
   <div class="page-leftheader">
      <h4 class="page-title mb-0 text-primary">{{__("message.Dashboard")}}</h4>
      <p class="adm-page-sub">Here's an overview of your business today</p>
   </div>
</div>
<!--End Page header-->

<!-- KPI cards — same 12 values the controller already computes, nothing new fetched -->
<div class="adm-kpi-grid">
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$currency.number_format($totalsales,0,'.',',')}}</div>
      <div class="adm-kpi-label">{{__("message.Total Sales")}}</div>
   </div>
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$totalorder}}</div>
      <div class="adm-kpi-label">{{__("message.Total Orders")}}</div>
   </div>
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$pendingorders}}</div>
      <div class="adm-kpi-label">{{__("message.Pending Orders")}}</div>
   </div>
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$completeorder}}</div>
      <div class="adm-kpi-label">{{__("message.Complete Orders")}}</div>
   </div>
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$totalcategory}}</div>
      <div class="adm-kpi-label">{{__("message.Total Category")}}</div>
   </div>
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$totalcity}}</div>
      <div class="adm-kpi-label">{{__("message.Total City")}}</div>
   </div>
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$totalusers}}</div>
      <div class="adm-kpi-label">{{__("message.Total Users")}}</div>
   </div>
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$totalmanager}}</div>
      <div class="adm-kpi-label">{{__("message.Total Managers")}}</div>
   </div>
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$totalpackage}}</div>
      <div class="adm-kpi-label">{{__("message.Total Packages")}}</div>
   </div>
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$totalprofile}}</div>
      <div class="adm-kpi-label">{{__("message.Total Parameters")}}</div>
   </div>
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$totalparameter}}</div>
      <div class="adm-kpi-label">{{__("message.Total Profiles")}}</div>
   </div>
   <div class="adm-kpi-card">
      <div class="adm-kpi-top">
         <span class="adm-kpi-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></span>
      </div>
      <div class="adm-kpi-value">{{$totalpopular}}</div>
      <div class="adm-kpi-label">{{__("message.Total Popular Package")}}</div>
   </div>
</div>

@php
   /* Charts below are rendered entirely from the same numbers already
      displayed in the KPI cards above — no new query, no new controller
      data. "Other" absorbs any order not flagged complete/pending so the
      three slices always add up to $totalorder exactly. */
   $hdOtherOrders = max(0, $totalorder - $completeorder - $pendingorders);
@endphp

<!-- Charts -->
<div class="adm-section">
   <div class="adm-section-head">
      <div>
         <h3 class="adm-section-title"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>Overview</h3>
         <p class="adm-section-sub">Derived from the same order &amp; catalog totals shown above</p>
      </div>
   </div>
   <div class="adm-charts-grid">
      <div class="adm-card adm-chart-card">
         <h4 class="adm-section-title" style="font-size:.92rem;">Order Status</h4>
         <div class="adm-chart-canvas-wrap"><canvas id="admOrderStatusChart"></canvas></div>
         <div class="adm-chart-legend">
            <span class="adm-chart-legend-item"><span class="adm-chart-legend-dot" style="background:#059669;"></span>Completed ({{$completeorder}})</span>
            <span class="adm-chart-legend-item"><span class="adm-chart-legend-dot" style="background:#f59e0b;"></span>Pending ({{$pendingorders}})</span>
            <span class="adm-chart-legend-item"><span class="adm-chart-legend-dot" style="background:#cbd5e1;"></span>Other ({{$hdOtherOrders}})</span>
         </div>
      </div>
      <div class="adm-card adm-chart-card">
         <h4 class="adm-section-title" style="font-size:.92rem;">Catalog Breakdown</h4>
         <div class="adm-chart-canvas-wrap"><canvas id="admCatalogChart"></canvas></div>
      </div>
   </div>
</div>

<!-- Quick Actions -->
<div class="adm-section">
   <div class="adm-section-head">
      <div>
         <h3 class="adm-section-title"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>Quick Actions</h3>
         <p class="adm-section-sub">Jump straight to the modules you use most</p>
      </div>
   </div>
   <div class="adm-quick-grid">
      <a href="{{ route('show-package') }}" class="adm-quick-card">
         <span class="adm-quick-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg></span>
         <span class="adm-quick-title">{{__("message.Packages")}}</span>
         <span class="adm-quick-desc">Manage health packages</span>
      </a>
      <a href="{{ route('profiles') }}" class="adm-quick-card">
         <span class="adm-quick-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></span>
         <span class="adm-quick-title">{{__("message.Profiles")}}</span>
         <span class="adm-quick-desc">Manage test profiles</span>
      </a>
      <a href="{{ route('manager') }}" class="adm-quick-card">
         <span class="adm-quick-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg></span>
         <span class="adm-quick-title">Branch / Lab Users</span>
         <span class="adm-quick-desc">Manage lab &amp; branch accounts</span>
      </a>
      <a href="{{ route('admin-orders') }}" class="adm-quick-card">
         <span class="adm-quick-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></span>
         <span class="adm-quick-title">{{__("message.Orders")}}</span>
         <span class="adm-quick-desc">View &amp; manage all orders</span>
      </a>
      <a href="{{ route('user') }}" class="adm-quick-card">
         <span class="adm-quick-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
         <span class="adm-quick-title">{{__("message.Site Users")}}</span>
         <span class="adm-quick-desc">Manage registered users</span>
      </a>
   </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') { return; }

    var statusCtx = document.getElementById('admOrderStatusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'Other'],
                datasets: [{
                    data: [{{ $completeorder }}, {{ $pendingorders }}, {{ $hdOtherOrders }}],
                    backgroundColor: ['#059669', '#f59e0b', '#cbd5e1'],
                    borderWidth: 0
                }]
            },
            options: {
                cutoutPercentage: 68,
                legend: { display: false },
                tooltips: { enabled: true }
            }
        });
    }

    var catalogCtx = document.getElementById('admCatalogChart');
    if (catalogCtx) {
        new Chart(catalogCtx, {
            type: 'bar',
            data: {
                labels: ['Packages', 'Profiles', 'Parameters', 'Popular'],
                datasets: [{
                    label: 'Total',
                    data: [{{ $totalpackage }}, {{ $totalprofile }}, {{ $totalparameter }}, {{ $totalpopular }}],
                    backgroundColor: '#10b981',
                    borderRadius: 6,
                    maxBarThickness: 42
                }]
            },
            options: {
                legend: { display: false },
                scales: {
                    yAxes: [{ ticks: { beginAtZero: true, precision: 0 }, gridLines: { color: '#eef2f1' } }],
                    xAxes: [{ gridLines: { display: false } }]
                }
            }
        });
    }
});
</script>
@endsection
