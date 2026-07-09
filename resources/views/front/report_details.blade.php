@extends('front.layout')
@section('title')
    {{ $title }}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('helthdex-report')}}"/>
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
    $hdRegnId = $report['TestRegnID'];
    $hdStatus = $report['hd_status'];
    $hdCollection = trim((string) ($report['strSampleCollectionDate'] ?? ''));
    $hdCollected = $hdStatus == 'processing' || $hdStatus == 'ready' ;
    $hdStatusMeta = [
        'ready'      => ['label' => 'Report Ready', 'icon' => 'circle-check-big'],
        'processing' => ['label' => 'Processing',   'icon' => 'flask-conical'],
        'pending'    => ['label' => 'Pending',      'icon' => 'clock'],
    ];
    /* Report generated date is embedded in the PDF file name, e.g.
       Mr_NAME_20_02_2026_05_30_53_PM.pdf */
    $hdGenerated = null;
    if (preg_match('/(\d{2})_(\d{2})_(\d{4})_(\d{2})_(\d{2})_\d{2}_(AM|PM)/', (string) ($report['PDFFileName'] ?? ''), $hdGenM)) {
        $hdGenerated = $hdGenM[1] . '-' . $hdGenM[2] . '-' . $hdGenM[3] . ' ' . $hdGenM[4] . ':' . $hdGenM[5] . ' ' . $hdGenM[6];
    }
    $hdSteps = [
        ['label' => 'Test Booked', 'icon' => 'calendar-check', 'date' => $report['RegnDateTimeString'], 'state' => 'done'],
        ['label' => 'Sample Collected', 'icon' => 'syringe', 'date' => $hdCollection !== '' ? $hdCollection : null, 'state' => $hdCollected ? 'done' : 'current'],
        ['label' => 'Lab Processing', 'icon' => 'flask-conical', 'date' => null, 'state' => $hdStatus == 'ready' ? 'done' : ($hdStatus == 'processing' ? 'current' : 'pending')],
        ['label' => 'Report Ready', 'icon' => 'file-check-2', 'date' => $hdGenerated, 'state' => $hdStatus == 'ready' ? 'done' : 'pending'],
    ];
    $hdTests = isset($report['RegnTestData_Mobile']) && is_array($report['RegnTestData_Mobile']) ? $report['RegnTestData_Mobile'] : [];
    $hdMoney = function ($v) { return rtrim(rtrim(number_format((float) $v, 2), '0'), '.'); };
    $hdDownloadBase = url('helthdex-report-download-api');
@endphp
<section class="hd-dash-section">
    <div class="auto-container">
        <!-- Page head -->
        <div class="hd-dash-head">
            <nav class="hd-dash-breadcrumb" aria-label="Breadcrumb">
                <a href="{{route('home')}}">{{__('message.Home')}}</a>
                <i data-lucide="chevron-right"></i>
                <a href="{{route('helthdex-report')}}">Download Report</a>
                <i data-lucide="chevron-right"></i>
                <span>Report #{{ $hdRegnId }}</span>
            </nav>
            <h1 class="hd-dash-title">Report Details</h1>
        </div>

        <!-- Status hero -->
        <div class="hd-dash-card hd-rpt-card hd-rpt-hero">
            <div class="hd-rpt-card-head">
                <div class="hd-rpt-card-title">
                    <h3>{{ $report['PatientName'] }}</h3>
                    <div class="hd-rpt-ids">
                        <span><i data-lucide="hash"></i>Report ID: {{ $hdRegnId }}</span>
                        <span><i data-lucide="bookmark"></i>Booking ID: {{ $report['LabCode'] ?: $hdRegnId }}</span>
                        @if($hdGenerated)<span><i data-lucide="file-clock"></i>Report Generated: {{ $hdGenerated }}</span>@endif
                    </div>
                </div>
                <div class="hd-rpt-badges">
                    <span class="hd-rpt-badge hd-rpt-badge-{{ $hdStatus }}"><i data-lucide="{{ $hdStatusMeta[$hdStatus]['icon'] }}"></i>{{ $hdStatusMeta[$hdStatus]['label'] }}</span>
                    @if($report['hd_pay_due'])
                    <span class="hd-rpt-badge hd-rpt-badge-due"><i data-lucide="indian-rupee"></i>Balance ₹{{ $hdMoney($report['BalanceAmt']) }}</span>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="hd-rpt-timeline">
                @foreach($hdSteps as $step)
                <div class="hd-rpt-tl-step {{ $step['state'] }}">
                    <span class="hd-rpt-tl-dot"><i data-lucide="{{ $step['icon'] }}"></i></span>
                    <div class="hd-rpt-tl-text">
                        <strong>{{ $step['label'] }}</strong>
                        @if($step['date'])<small>{{ $step['date'] }}</small>
                        @elseif($step['state'] == 'current')<small>In progress</small>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="hd-rpt-actions">
                @if($report['hd_pay_due'])
                <span class="hd-rpt-note">Pay the balance amount to unlock your report.</span>
                <a href="{{ route('cc_request', ['patientname' => $report['PatientName'], 'paymentAmount' => $report['BalanceAmt'], 'testregnid' => $hdRegnId]) }}" class="premium-btn premium-btn-primary"><i data-lucide="credit-card"></i>Pay Online</a>
                @elseif($report['hd_can_download'])
                <a href="{{ $hdDownloadBase }}?testRegnID={{ $hdRegnId }}" class="hd-rpt-btn hd-rpt-btn-primary"><i data-lucide="download"></i>Download PDF</a>
                <button type="button" class="hd-rpt-btn" onclick="hdRptPrint('{{ $hdRegnId }}')"><i data-lucide="printer"></i>Print</button>
                <button type="button" class="hd-rpt-btn" data-rpt-share="{{ $hdRegnId }}" data-rpt-patient="{{ $report['PatientName'] }}"><i data-lucide="share-2"></i>Share</button>
                @else
                <span class="hd-rpt-note"><i data-lucide="info"></i>Your report is being prepared — it is usually ready within 24–48 hours of sample collection.</span>
                @endif
                <a href="{{ route('helthdex-report') }}" class="hd-rpt-btn hd-rpt-btn-back"><i data-lucide="arrow-left"></i>All Reports</a>
            </div>
        </div>

        <div class="hd-rpt-detail-grid">
            <!-- Patient details -->
            <div class="hd-dash-card hd-rpt-panel">
                <h3 class="hd-dash-card-title"><i data-lucide="user-round"></i>Patient Details</h3>
                <ul class="hd-rpt-meta hd-rpt-meta-col">
                    <li><i data-lucide="user-round"></i><span>Name</span><strong>{{ $report['PatientName'] }}</strong></li>
                    @if((int)($report['PatientAge'] ?? 0) > 0)
                    <li><i data-lucide="cake"></i><span>Age</span><strong>{{ $report['PatientAge'] }} years</strong></li>
                    @endif
                    @if(trim((string)($report['PatientMobile'] ?? '')) !== '')
                    <li><i data-lucide="phone"></i><span>Mobile</span><strong>{{ $report['PatientMobile'] }}</strong></li>
                    @endif
                    @if(trim((string)($report['PatientEmail'] ?? '')) !== '')
                    <li><i data-lucide="mail"></i><span>Email</span><strong>{{ $report['PatientEmail'] }}</strong></li>
                    @endif
                    @if(trim((string)($report['DoctorName'] ?? '')) !== '')
                    <li><i data-lucide="stethoscope"></i><span>Referred By</span><strong>{{ trim($report['DoctorName']) }}</strong></li>
                    @endif
                </ul>
            </div>

            <!-- Booking details -->
            <div class="hd-dash-card hd-rpt-panel">
                <h3 class="hd-dash-card-title"><i data-lucide="calendar-check"></i>Booking Details</h3>
                <ul class="hd-rpt-meta hd-rpt-meta-col">
                    <li><i data-lucide="hash"></i><span>Report ID</span><strong>{{ $hdRegnId }}</strong></li>
                    <li><i data-lucide="bookmark"></i><span>Booking ID</span><strong>{{ $report['LabCode'] ?: $hdRegnId }}</strong></li>
                    <li><i data-lucide="calendar"></i><span>Booking Date</span><strong>{{ $report['RegnDateTimeString'] }}</strong></li>
                    <li><i data-lucide="syringe"></i><span>Sample Collection</span><strong>{{ $hdCollection !== '' ? $hdCollection : 'Awaiting collection' }}</strong></li>
                    <li><i data-lucide="receipt"></i><span>Amount</span><strong>₹{{ $hdMoney($report['Net']) }} <em>(Paid ₹{{ $hdMoney($report['AmountPaid']) }}, Balance ₹{{ $hdMoney($report['BalanceAmt']) }})</em></strong></li>
                </ul>
            </div>

            <!-- Lab details -->
            <div class="hd-dash-card hd-rpt-panel">
                <h3 class="hd-dash-card-title"><i data-lucide="building-2"></i>Lab Details</h3>
                <ul class="hd-rpt-meta hd-rpt-meta-col">
                    <li><i data-lucide="building-2"></i><span>Collection Centre</span><strong>{{ trim((string)($report['CollectionCenterName'] ?? '')) !== '' ? ucwords(strtolower($report['CollectionCenterName'])) : '369 HealthDex' }}</strong></li>
                    <li><i data-lucide="badge-check"></i><span>Network</span><strong>369 HealthDex — NABL certified labs</strong></li>
                    <li><i data-lucide="headset"></i><span>Support</span><strong><a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a></strong></li>
                </ul>
            </div>
        </div>

        <!-- Test list -->
        <div class="hd-dash-card hd-rpt-panel">
            <h3 class="hd-dash-card-title"><i data-lucide="flask-conical"></i>Tests in this Booking</h3>
            @if(count($hdTests))
            <ul class="hd-rpt-tests">
                @foreach($hdTests as $t)
                <li>
                    <span class="hd-rpt-test-icon"><i data-lucide="test-tube"></i></span>
                    <div class="hd-rpt-test-name">
                        <strong>{{ trim((string)($t['DisplayName'] ?? '')) !== '' ? $t['DisplayName'] : ($t['TestProfileName'] ?? 'Test') }}</strong>
                        @if(trim((string)($t['strWorkflowStatus'] ?? '')) !== '')<small>{{ $t['strWorkflowStatus'] }}</small>@endif
                    </div>
                    <span class="hd-rpt-test-price">₹{{ $hdMoney($t['TestPrice'] ?? 0) }}</span>
                </li>
                @endforeach
            </ul>
            @else
            <p class="hd-rpt-note">{{ $report['SelectedTest'] }}</p>
            @endif
        </div>
    </div>
</section>

<script>
var hdRptDownloadBase = '{{ $hdDownloadBase }}';
function hdRptPrint(id) {
    window.open(hdRptDownloadBase + '?testRegnID=' + id + '&inline=1', '_blank');
}
document.addEventListener('click', function (e) {
    var share = e.target.closest ? e.target.closest('[data-rpt-share]') : null;
    if (!share) return;
    var rid = share.getAttribute('data-rpt-share');
    var patient = share.getAttribute('data-rpt-patient') || '';
    var text = 'Lab report for ' + patient + ' (Report ID: ' + rid + ') from 369 HealthDex is ready. Download it at ' + '{{ route('download-report') }}';
    if (navigator.share) {
        navigator.share({ title: '369 HealthDex Report', text: text }).catch(function () {});
    } else {
        window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
    }
});
</script>
@stop
@section('footer')
@stop
