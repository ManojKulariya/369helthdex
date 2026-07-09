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
    $hdRptStatusMeta = [
        'ready'      => ['label' => 'Ready',      'icon' => 'circle-check-big'],
        'processing' => ['label' => 'Processing', 'icon' => 'flask-conical'],
        'pending'    => ['label' => 'Pending',    'icon' => 'clock'],
    ];
    $hdDownloadBase = url('helthdex-report-download-api');
@endphp
<section class="hd-dash-section">
    <div class="auto-container">
        <!-- Page head -->
        <div class="hd-dash-head">
            <nav class="hd-dash-breadcrumb" aria-label="Breadcrumb">
                <a href="{{route('home')}}">{{__('message.Home')}}</a>
                <i data-lucide="chevron-right"></i>
                <span>{{ $title }}</span>
            </nav>
            <h1 class="hd-dash-title">{{ $title }}</h1>
        </div>

        @if (session('payment_status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('payment_status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        @endif

        <!-- User summary -->
        <div class="hd-dash-card hd-rpt-user">
            <div class="hd-rpt-user-id">
                <span class="hd-fam-avatar">{{ strtoupper(substr(trim((string) $hdReportUser['name']), 0, 1)) ?: '?' }}</span>
                <div class="hd-rpt-user-text">
                    <h2>{{ $hdReportUser['name'] }}</h2>
                    <ul>
                        @if($hdReportUser['phone'])<li><i data-lucide="phone"></i>{{ $hdReportUser['phone'] }}</li>@endif
                        @if($hdReportUser['email'])<li><i data-lucide="mail"></i>{{ $hdReportUser['email'] }}</li>@endif
                    </ul>
                </div>
            </div>
            <div class="hd-rpt-user-stats">
                <div class="hd-rpt-user-stat">
                    <span class="hd-dash-stat-icon"><i data-lucide="files"></i></span>
                    <div>
                        <div class="hd-dash-stat-value" data-hd-counter>{{ $hdReportUser['total'] }}</div>
                        <div class="hd-dash-stat-label">Total Reports</div>
                    </div>
                </div>
                <div class="hd-rpt-user-stat">
                    <span class="hd-dash-stat-icon"><i data-lucide="circle-check-big"></i></span>
                    <div>
                        <div class="hd-dash-stat-value" data-hd-counter>{{ $hdReportUser['ready'] }}</div>
                        <div class="hd-dash-stat-label">Ready to Download</div>
                    </div>
                </div>
                <div class="hd-rpt-user-stat">
                    <span class="hd-dash-stat-icon"><i data-lucide="calendar-clock"></i></span>
                    <div>
                        <div class="hd-dash-stat-value hd-rpt-stat-date">{{ $hdReportUser['latest'] ? trim(explode(' ', $hdReportUser['latest'])[0]) : '—' }}</div>
                        <div class="hd-dash-stat-label">Latest Report</div>
                    </div>
                </div>
            </div>
        </div>

        @if(count($data['reportlist']) > 0)
        <div class="hd-rpt-grid">
            @foreach($data['reportlist'] as $row)
            @php
                $hdStatus = $hdRptStatusMeta[$row['hd_status']];
                $hdRegnId = $row['TestRegnID'];
                $hdCollection = trim((string) ($row['strSampleCollectionDate'] ?? ''));
            @endphp
            <article class="hd-dash-card hd-rpt-card" data-regn-id="{{ $hdRegnId }}">
                <div class="hd-rpt-card-head">
                    <div class="hd-rpt-card-title">
                        <h3>{{ $row['PatientName'] }}</h3>
                        <div class="hd-rpt-ids">
                            <span><i data-lucide="hash"></i>Report ID: {{ $hdRegnId }}</span>
                            <span><i data-lucide="bookmark"></i>Booking ID: {{ $row['LabCode'] ?: $hdRegnId }}</span>
                        </div>
                    </div>
                    <div class="hd-rpt-badges">
                        <span class="hd-rpt-badge hd-rpt-badge-{{ $row['hd_status'] }}" data-rpt-badge><i data-lucide="{{ $hdStatus['icon'] }}"></i>{{ $hdStatus['label'] }}</span>
                        @if($row['hd_pay_due'])
                        <span class="hd-rpt-badge hd-rpt-badge-due"><i data-lucide="indian-rupee"></i>Balance ₹{{ rtrim(rtrim(number_format((float)$row['BalanceAmt'], 2), '0'), '.') }}</span>
                        @endif
                    </div>
                </div>

                <ul class="hd-rpt-meta">
                    <li><i data-lucide="flask-conical"></i><span>Test / Package</span><strong>{{ $row['SelectedTest'] }}</strong></li>
                    <li><i data-lucide="calendar"></i><span>Booking Date</span><strong>{{ $row['RegnDateTimeString'] }}</strong></li>
                    <li><i data-lucide="syringe"></i><span>Sample Collection</span><strong>{{ $hdCollection !== '' ? $hdCollection : 'Awaiting collection' }}</strong></li>
                    <li><i data-lucide="building-2"></i><span>Lab</span><strong>{{ trim((string)($row['CollectionCenterName'] ?? '')) !== '' ? ucwords(strtolower($row['CollectionCenterName'])) : '369 HealthDex' }}</strong></li>
                    <li><i data-lucide="receipt"></i><span>Amount</span><strong>₹{{ rtrim(rtrim(number_format((float)$row['Net'], 2), '0'), '.') }} <em>(Paid ₹{{ rtrim(rtrim(number_format((float)$row['AmountPaid'], 2), '0'), '.') }})</em></strong></li>
                </ul>

                @if(!$row['hd_can_download'] && !$row['hd_pay_due'])
                <div class="hd-rpt-progress">
                    <div class="hd-rpt-progress-track" aria-hidden="true">
                        <span class="hd-rpt-progress-step done"></span>
                        <span class="hd-rpt-progress-step {{ $row['hd_status'] == 'processing' ? 'done' : '' }}"></span>
                        <span class="hd-rpt-progress-step"></span>
                    </div>
                    <p><i data-lucide="info"></i>
                        @if($row['hd_status'] == 'pending')
                            Your sample is awaiting collection. The report is usually ready within 24–48 hours after collection.
                        @else
                            Your sample is being processed at the lab. Estimated completion: within 24–48 hours of collection.
                        @endif
                    </p>
                </div>
                @endif

                <div class="hd-rpt-actions">
                    @if($row['hd_pay_due'])
                    <span class="hd-rpt-note">Pay the balance amount to unlock your report.</span>
                    <button type="button" class="premium-btn premium-btn-primary" data-toggle="modal" data-target="#commonModal" onclick="updateModal('{{ addslashes($row['PatientName']) }}', '{{ $row['BalanceAmt'] }}', '{{ $hdRegnId }}')">
                        <i data-lucide="credit-card"></i>Pay Online
                    </button>
                    @elseif($row['hd_can_download'])
                    <a href="{{ route('report-details', ['id' => $hdRegnId]) }}" class="hd-rpt-btn"><i data-lucide="eye"></i>View Report</a>
                    <a href="{{ $hdDownloadBase }}?testRegnID={{ $hdRegnId }}" class="hd-rpt-btn hd-rpt-btn-primary" data-rpt-download="{{ $hdRegnId }}"><i data-lucide="download"></i>Download PDF</a>
                    <button type="button" class="hd-rpt-btn" onclick="hdRptPrint('{{ $hdRegnId }}')"><i data-lucide="printer"></i>Print</button>
                    <button type="button" class="hd-rpt-btn" data-rpt-share="{{ $hdRegnId }}" data-rpt-patient="{{ $row['PatientName'] }}"><i data-lucide="share-2"></i>Share</button>
                    @else
                    <a href="{{ route('report-details', ['id' => $hdRegnId]) }}" class="hd-rpt-btn"><i data-lucide="eye"></i>View Details</a>
                    @endif
                </div>
            </article>
            @endforeach
        </div>
        @else
        <!-- Empty state -->
        <div class="hd-dash-card hd-fam-empty">
            <div class="hd-fam-empty-icon"><i data-lucide="file-search"></i></div>
            <h3>No reports available yet.</h3>
            <p>Once you book a test and your sample is processed, your reports will appear here for download.</p>
            <a href="{{ route('popular-packages', ['city' => session()->get('cityName') ?: 'Jaipur']) }}" class="premium-btn premium-btn-primary">
                <i data-lucide="flask-conical"></i>
                Book a Test
            </a>
        </div>
        @endif
    </div>
</section>

<!--    Pay Modal       -->
<div class="modal fade hd-form-modal" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Patient Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{route('cc_request')}}" method="Get">

                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label for="modalPatientName" class="form-label">Patient Name</label>
                        <input id="modalPatientName" type="text" class="form-control" name="patientname" readonly>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="modalPaymentAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="modalPaymentAmount" name="paymentAmount" readonly>
                    </div>
                    <input type="hidden" id="modalTestRegnID" name="testregnid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary premium-btn premium-btn-primary">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!------------------------>

 <script>
 function updateModal(patientName, balanceAmt, testRegnID) {

    document.getElementById('modalPatientName').value = patientName;
    document.getElementById('modalPaymentAmount').value = balanceAmt;
    document.getElementById('modalTestRegnID').value = testRegnID;
}

var hdRptDownloadBase = '{{ $hdDownloadBase }}';
function hdRptPrint(id) {
    window.open(hdRptDownloadBase + '?testRegnID=' + id + '&inline=1', '_blank');
}
(function () {
    /* Mark reports the user has already downloaded on this device. */
    var KEY = 'hdRptDownloaded';
    function downloaded() {
        try { return JSON.parse(localStorage.getItem(KEY)) || []; } catch (e) { return []; }
    }
    function markBadges() {
        var list = downloaded();
        document.querySelectorAll('.hd-rpt-card').forEach(function (card) {
            if (list.indexOf(card.getAttribute('data-regn-id')) === -1) return;
            var badge = card.querySelector('[data-rpt-badge].hd-rpt-badge-ready');
            if (badge) {
                badge.classList.remove('hd-rpt-badge-ready');
                badge.classList.add('hd-rpt-badge-delivered');
                badge.innerHTML = '<i data-lucide="badge-check"></i>Downloaded';
            }
        });
        if (window.lucide) { lucide.createIcons(); }
    }
    document.addEventListener('click', function (e) {
        var dl = e.target.closest ? e.target.closest('[data-rpt-download]') : null;
        if (dl) {
            var list = downloaded();
            var id = dl.getAttribute('data-rpt-download');
            if (list.indexOf(id) === -1) { list.push(id); }
            try { localStorage.setItem(KEY, JSON.stringify(list)); } catch (err) {}
            setTimeout(markBadges, 400);
        }
        var share = e.target.closest ? e.target.closest('[data-rpt-share]') : null;
        if (share) {
            var rid = share.getAttribute('data-rpt-share');
            var patient = share.getAttribute('data-rpt-patient') || '';
            var text = 'Lab report for ' + patient + ' (Report ID: ' + rid + ') from 369 HealthDex is ready. Download it at ' + '{{ route('download-report') }}';
            if (navigator.share) {
                navigator.share({ title: '369 HealthDex Report', text: text }).catch(function () {});
            } else {
                window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
            }
        }
    });
    markBadges();
})();
 </script>
@stop
@section('footer')
@stop
