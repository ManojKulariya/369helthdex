@extends('front.layout')
@section('title')
  Track Appointment
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('dashboard')}}"/>
<meta property="og:title" content="{{__('message.site_name')}}"/>
<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}"/>
<meta property="og:image:width" content="250px"/>
<meta property="og:image:height" content="250px"/>
<meta property="og:site_name" content="{{__('message.site_name')}}"/>
<meta property="og:description" content="{{__('message.meta_description')}}"/>
<meta property="og:keyword" content="{{__('message.meta_keyword')}}"/>
<link rel="shortcut icon" href="{{asset('public/img/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')
@php
    /* ---- Display-only mapping over existing order fields ---- */
    $hdStatus = (int) $data->status;
    $hdCancelled = in_array($hdStatus, [3, 4]);
    $hdAssigned = !empty($data->sample_collection_boy_id) && $data->sampleboyDetails;

    // Live badge
    if ($hdStatus == 3)      { $hdBadge = 'Cancelled';    $hdBadgeClass = 'cancel'; }
    elseif ($hdStatus == 4)  { $hdBadge = 'Refunded';     $hdBadgeClass = 'cancel'; }
    elseif ($hdStatus == 7)  { $hdBadge = 'Completed';    $hdBadgeClass = 'done'; }
    elseif ($hdStatus == 8)  { $hdBadge = 'Report Ready'; $hdBadgeClass = 'done'; }
    elseif ($hdStatus == 6)  { $hdBadge = 'Testing';      $hdBadgeClass = 'progress'; }
    elseif ($hdStatus == 5)  { $hdBadge = 'Collected';    $hdBadgeClass = 'progress'; }
    elseif ($hdStatus == 2)  { $hdBadge = $hdAssigned ? 'Assigned' : 'Confirmed'; $hdBadgeClass = 'progress'; }
    else                     { $hdBadge = 'Pending';      $hdBadgeClass = 'pending'; }

    $hdFmt = function ($dt) {
        return $dt ? date('d M Y, g:i A', strtotime($dt)) : null;
    };

    // Timeline steps derived from real status codes + timestamps
    $hdPayLabel = strtoupper((string) $data->payment_method) == 'COD' ? 'Pay on Sample Collection (COD)' : 'Payment Confirmed';
    $hdSteps = [
        ['label' => 'Order Placed', 'done' => true, 'time' => $hdFmt($data->orderplace_date ?: $data->created_at), 'icon' => 'shopping-cart'],
        ['label' => $hdPayLabel, 'done' => true, 'time' => null, 'icon' => 'credit-card'],
        ['label' => 'Appointment Confirmed', 'done' => $hdStatus >= 2 && !$hdCancelled, 'time' => $hdFmt($data->accept_datetime), 'icon' => 'calendar-check'],
        ['label' => 'Sample Collection Assigned', 'done' => $hdAssigned && !$hdCancelled, 'time' => $hdAssigned ? ($data->sampleboyDetails->name ?? null) : null, 'icon' => 'user-round-check'],
        ['label' => 'Sample Collected', 'done' => in_array($hdStatus, [5, 6, 7, 8]), 'time' => $hdFmt($data->collected_datetime), 'icon' => 'flask-conical'],
        ['label' => 'Testing In Progress', 'done' => in_array($hdStatus, [6, 7, 8]), 'time' => null, 'icon' => 'microscope'],
        ['label' => 'Report Ready', 'done' => in_array($hdStatus, [7, 8]), 'time' => null, 'icon' => 'file-text'],
        ['label' => 'Report Delivered', 'done' => $hdStatus == 7, 'time' => $hdFmt($data->complete_datetime), 'icon' => 'badge-check'],
    ];
    // Mark the current (first not-done) step
    $hdCurrentIdx = null;
    if (!$hdCancelled) {
        foreach ($hdSteps as $hdI => $hdS) {
            if (!$hdS['done']) { $hdCurrentIdx = $hdI; break; }
        }
    }

    $hdReportReady = in_array($hdStatus, [7, 8]);
    $hdTrackCity = session()->get('cityName');
    if ($hdTrackCity == '') { $hdTrackCity = 'rajkot'; }
@endphp
<section class="hd-dash-section">
    <div class="auto-container">
        <!-- Page head -->
        <div class="hd-dash-head">
            <nav class="hd-dash-breadcrumb" aria-label="Breadcrumb">
                <a href="{{route('home')}}">{{__('message.Home')}}</a>
                <i data-lucide="chevron-right"></i>
                <a href="{{route('dashboard')}}">{{__('message.Dashboard')}}</a>
                <i data-lucide="chevron-right"></i>
                <span>Track Appointment</span>
            </nav>
            <h1 class="hd-dash-title">Track Appointment</h1>
        </div>

        <div class="hd-dash-layout">
            @include('front.hd_account_sidebar', ['hdSidebarActive' => 'dashboard'])

            <main class="hd-dash-main">
                <!-- Status hero -->
                <div class="hd-dash-welcome hd-track-hero">
                    <span class="hd-dash-welcome-pattern" aria-hidden="true"></span>
                    <span class="hd-dash-welcome-glow" aria-hidden="true"></span>
                    <div class="hd-dash-welcome-inner">
                        <div>
                            <p class="hd-dash-greeting">Booking ID #{{ $data->id }} @if($data->token) &middot; Order ID {{ $data->token }} @endif</p>
                            <h2>
                                <span class="hd-track-badge hd-track-badge-{{ $hdBadgeClass }}">{{ $hdBadge }}</span>
                            </h2>
                            <p class="hd-dash-welcome-sub">Booked on {{ $hdFmt($data->orderplace_date ?: $data->created_at) }}</p>
                        </div>
                        <div class="hd-track-hero-meta">
                            <span><i data-lucide="calendar"></i>{{ $data->date }}</span>
                            <span><i data-lucide="clock"></i>{{ $data->time }}</span>
                            <span><i data-lucide="{{ $data->visit_type == 0 ? 'house' : 'building-2' }}"></i>{{ $data->visit_type == 0 ? 'Home Visit' : 'Lab Visit' }}</span>
                        </div>
                    </div>
                </div>

                <div class="hd-track-grid">
                    <!-- Timeline -->
                    <div class="hd-dash-card">
                        <h3 class="hd-dash-card-title"><i data-lucide="route"></i>Appointment Status</h3>
                        <ol class="hd-track-timeline">
                            @foreach($hdSteps as $hdI => $hdStep)
                            <li class="{{ $hdStep['done'] ? 'is-done' : '' }} {{ $hdCurrentIdx === $hdI ? 'is-current' : '' }}">
                                <span class="hd-track-node">
                                    @if($hdStep['done'])
                                        <i data-lucide="check"></i>
                                    @else
                                        <i data-lucide="{{ $hdStep['icon'] }}"></i>
                                    @endif
                                </span>
                                <div class="hd-track-step-body">
                                    <span class="hd-track-step-label">{{ $hdStep['label'] }}</span>
                                    @if($hdStep['time'])
                                    <span class="hd-track-step-time">{{ $hdStep['time'] }}</span>
                                    @elseif($hdCurrentIdx === $hdI)
                                    <span class="hd-track-step-time">In progress</span>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                            @if($hdCancelled)
                            <li class="is-cancelled">
                                <span class="hd-track-node"><i data-lucide="x"></i></span>
                                <div class="hd-track-step-body">
                                    <span class="hd-track-step-label">{{ $hdStatus == 3 ? 'Appointment Cancelled' : 'Amount Refunded' }}</span>
                                    <span class="hd-track-step-time">{{ $hdFmt($hdStatus == 3 ? $data->reject_datetime : $data->refund_datetime) }}</span>
                                    @if($data->reject_description)
                                    <span class="hd-track-step-time">{{ $data->reject_description }}</span>
                                    @endif
                                </div>
                            </li>
                            @endif
                        </ol>
                    </div>

                    <div class="hd-track-side">
                        <!-- Booking details -->
                        <div class="hd-dash-card">
                            <h3 class="hd-dash-card-title"><i data-lucide="clipboard-list"></i>Booking Details</h3>
                            <ul class="hd-track-list">
                                @foreach($data->orderdata as $od)
                                <li class="hd-track-item">
                                    <span class="hd-track-item-icon"><i data-lucide="{{ $od->type == 'Package' ? 'heart-pulse' : 'test-tubes' }}"></i></span>
                                    <span class="hd-track-item-body">
                                        <b>{{ $od->item_name }}</b>
                                        <small>
                                            @if($od->memberdetails) {{ $od->memberdetails->name }} ({{ $od->memberdetails->relation }}) &middot; @endif
                                            @if($od->parameter) {{ $od->parameter }} Parameters @endif
                                        </small>
                                    </span>
                                    <span class="hd-track-item-price">{{ $currency }}{{ number_format($od->mrp, 2, '.', '') }}</span>
                                </li>
                                @endforeach
                            </ul>
                            <ul class="hd-track-meta">
                                <li><i data-lucide="user-round"></i><span>Patient</span><b>{{ Auth::user()->name }}</b></li>
                                @if($data->franchise)
                                <li><i data-lucide="building-2"></i><span>Assigned Lab</span><b>{{ $data->franchise->name }}</b></li>
                                @endif
                                @if($hdAssigned)
                                <li><i data-lucide="user-round-check"></i><span>Technician</span><b>{{ $data->sampleboyDetails->name }} @if($data->sampleboyDetails->phone)&middot; <a href="tel:{{ $data->sampleboyDetails->phone }}">{{ $data->sampleboyDetails->phone }}</a>@endif</b></li>
                                @endif
                                @if($data->useraddressdetails)
                                <li><i data-lucide="map-pin"></i><span>Collection Address</span><b>{{ $data->useraddressdetails->house_no }}, {{ $data->useraddressdetails->address }}, {{ $data->useraddressdetails->city }}, {{ $data->useraddressdetails->state }} - {{ $data->useraddressdetails->pincode }}</b></li>
                                @endif
                            </ul>
                        </div>

                        <!-- Payment summary -->
                        <div class="hd-dash-card">
                            <h3 class="hd-dash-card-title"><i data-lucide="receipt"></i>Payment Summary</h3>
                            <ul class="hd-track-pay">
                                <li><span>Order Amount</span><b>{{ $currency }}{{ number_format($data->subtotal, 2, '.', '') }}</b></li>
                                @if((float) $data->coupon_discount > 0)
                                <li><span>Coupon Discount</span><b class="hd-track-save">- {{ $currency }}{{ number_format($data->coupon_discount, 2, '.', '') }}</b></li>
                                @endif
                                @if((float) $data->wallet_discount > 0)
                                <li><span>Wallet Discount</span><b class="hd-track-save">- {{ $currency }}{{ number_format($data->wallet_discount, 2, '.', '') }}</b></li>
                                @endif
                                @if((float) $data->tax > 0)
                                <li><span>Tax</span><b>{{ $currency }}{{ number_format($data->tax, 2, '.', '') }}</b></li>
                                @endif
                                <li class="hd-track-pay-total"><span>Final Amount</span><b>{{ $currency }}{{ number_format($data->final_total, 2, '.', '') }}</b></li>
                                <li><span>Payment Method</span><b>{{ strtoupper((string) $data->payment_method) == 'COD' ? 'Cash on Collection' : strtoupper((string) $data->payment_method) }}</b></li>
                                <li><span>Payment Status</span><b>{{ strtoupper((string) $data->payment_method) == 'COD' && !in_array($hdStatus, [5,6,7,8]) ? 'Payable on Collection' : 'Paid' }}</b></li>
                            </ul>
                        </div>

                        <!-- Actions -->
                        <div class="hd-dash-card">
                            <h3 class="hd-dash-card-title"><i data-lucide="zap"></i>Actions</h3>
                            <div class="hd-track-actions">
                                <a href="{{route('printorder', ['id' => $data->id ])}}" target="_blank" class="premium-btn premium-btn-primary">
                                    <i data-lucide="download"></i>
                                    Download Invoice
                                </a>
                                @if($hdReportReady)
                                <a href="{{route('download-report')}}" target="_blank" class="premium-btn premium-btn-primary">
                                    <i data-lucide="file-down"></i>
                                    Download Report
                                </a>
                                @endif
                                <a href="tel:{{$setting->phone}}" class="premium-btn premium-btn-secondary">
                                    <i data-lucide="phone"></i>
                                    Call Support
                                </a>
                                <a href="{{route('contact-us')}}" class="premium-btn premium-btn-secondary">
                                    <i data-lucide="circle-help"></i>
                                    Need Help
                                </a>
                                <a href="{{route('popular-packages',['city'=>$hdTrackCity])}}" class="premium-btn premium-btn-secondary">
                                    <i data-lucide="rotate-ccw"></i>
                                    Book Again
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>
@stop
@section('footer')
@stop
