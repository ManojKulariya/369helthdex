@extends('front.layout')
@section('title')
  {{__('message.Dashboard')}}
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
<?php $res_curr = explode("-",$setting->currency);?>
@php
    /* Display helpers only — all data stays exactly as the controller sends it. */
    $hdDashCity = session()->get('cityName');
    if ($hdDashCity == '') {
        $hdDashCity = 'rajkot';
    }
    $hdDashHour = (int) date('H');
    if ($hdDashHour < 12) {
        $hdDashGreeting = 'Good Morning';
    } elseif ($hdDashHour < 17) {
        $hdDashGreeting = 'Good Afternoon';
    } else {
        $hdDashGreeting = 'Good Evening';
    }
@endphp
<section class="hd-dash-section">
    <div class="auto-container">
        <!-- Page head (title + breadcrumb preserved from the old banner) -->
        <div class="hd-dash-head">
            <nav class="hd-dash-breadcrumb" aria-label="Breadcrumb">
                <a href="{{route('home')}}">{{__('message.Home')}}</a>
                <i data-lucide="chevron-right"></i>
                <span>{{__('message.Dashboard')}}</span>
            </nav>
            <h1 class="hd-dash-title">{{__('message.Dashboard')}}</h1>
        </div>

        <div class="hd-dash-layout">
            <!-- Sidebar -->
            <aside class="hd-dash-sidebar" id="hdDashSidebar">
                <div class="hd-dash-profile">
                     <?php
                          if(Auth::user()->profile_pic!=""){
                              $path=env('APP_URL')."/storage/profile"."/".Auth::user()->profile_pic;
                          }
                          else{
                              $path=asset('public/img/default_user.png');
                          }
                          ?>
                    <div class="hd-dash-avatar">
                        <img src="{{$path}}" alt="{{Auth::user()->name}}">
                    </div>
                    <h3>{{Auth::user()->name}}</h3>
                    <p><i data-lucide="mail"></i>{{Auth::user()->email}}</p>
                </div>

                <button type="button" class="hd-dash-nav-toggle" id="hdDashNavToggle" aria-expanded="false" aria-controls="hdDashNav">
                    <i data-lucide="menu"></i>
                    Account Menu
                </button>

                <nav class="hd-dash-nav" id="hdDashNav">
                    <ul>
                       <li><a href="{{route('dashboard')}}" class="current"><i data-lucide="layout-dashboard"></i>{{__('message.Dashboard')}}</a></li>
                       <li><a href="{{route('my-family-member')}}"><i data-lucide="users"></i>{{__('message.My Family Members')}}</a></li>
                       <li><a href="{{route('my-addresses')}}"><i data-lucide="map-pin"></i>{{__('message.My Addresses')}}</a></li>
                       <li><a href="{{route('my-home')}}"><i data-lucide="house"></i>Home Visit</a></li>
                       <li><a href="{{route('my_prescription')}}"><i data-lucide="file-text"></i>My Prescription</a></li>
                       <li><a href="{{route('user-profile')}}"><i data-lucide="user-round"></i>{{__('message.My Profile')}}</a></li>
                       <!-- <li><a href="{{route('user-change-password')}}"><i data-lucide="lock-keyhole"></i>{{__('message.Change Password')}}</a></li> -->
                       <li><a href="{{route('user-logout')}}" class="hd-dash-logout"><i data-lucide="log-out"></i>{{__('message.Logout')}}</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Main -->
            <main class="hd-dash-main">
                <!-- Welcome card -->
                <div class="hd-dash-welcome">
                    <span class="hd-dash-welcome-pattern" aria-hidden="true"></span>
                    <span class="hd-dash-welcome-glow" aria-hidden="true"></span>
                    <div class="hd-dash-welcome-inner">
                        <div>
                            <p class="hd-dash-greeting">{{ $hdDashGreeting }},</p>
                            <h2>{{Auth::user()->name}}</h2>
                            <p class="hd-dash-welcome-sub">Take care of your health today.</p>
                        </div>
                        <div class="hd-dash-welcome-actions">
                            <a href="{{route('popular-packages',['city'=>$hdDashCity])}}" class="hd-dash-btn-light">
                                <i data-lucide="flask-conical"></i>
                                Book a Test
                            </a>
                            <a href="{{route('download-report')}}" class="hd-dash-btn-ghost">
                                <i data-lucide="download"></i>
                                Download Reports
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Health summary (same variables as before) -->
                <div class="hd-dash-stats">
                    <div class="hd-dash-stat">
                        <span class="hd-dash-stat-icon"><i data-lucide="wallet"></i></span>
                        <div class="hd-dash-stat-value">{{number_format($wallet_points,2)}}</div>
                        <div class="hd-dash-stat-label">Total Wallet Point</div>
                    </div>
                    <div class="hd-dash-stat">
                        <span class="hd-dash-stat-icon"><i data-lucide="calendar-check"></i></span>
                        <div class="hd-dash-stat-value" data-hd-counter>{{$totalorders}}</div>
                        <div class="hd-dash-stat-label">{{__('message.Total Appointment')}}</div>
                    </div>
                    <div class="hd-dash-stat">
                        <span class="hd-dash-stat-icon"><i data-lucide="clock"></i></span>
                        <div class="hd-dash-stat-value" data-hd-counter>{{$pendingorders}}</div>
                        <div class="hd-dash-stat-label">{{__('message.Pending Appointment')}}</div>
                    </div>
                    <div class="hd-dash-stat">
                        <span class="hd-dash-stat-icon"><i data-lucide="clipboard-check"></i></span>
                        <div class="hd-dash-stat-value" data-hd-counter>{{$completeorders}}</div>
                        <div class="hd-dash-stat-label">{{__('message.Complete Appointment')}}</div>
                    </div>
                </div>

                <!-- Quick actions (existing routes only) -->
                <div class="hd-dash-card">
                    <h3 class="hd-dash-card-title"><i data-lucide="zap"></i>Quick Actions</h3>
                    <div class="hd-dash-actions">
                        <a href="{{route('popular-packages',['city'=>$hdDashCity])}}" class="hd-dash-action">
                            <span class="hd-dash-action-icon"><i data-lucide="flask-conical"></i></span>
                            <span>Book Test</span>
                        </a>
                        <a href="{{route('download-report')}}" class="hd-dash-action">
                            <span class="hd-dash-action-icon"><i data-lucide="download"></i></span>
                            <span>Download Reports</span>
                        </a>
                        <a href="{{route('my-family-member')}}" class="hd-dash-action">
                            <span class="hd-dash-action-icon"><i data-lucide="users"></i></span>
                            <span>My Family</span>
                        </a>
                        <a href="{{route('my-addresses')}}" class="hd-dash-action">
                            <span class="hd-dash-action-icon"><i data-lucide="map-pin"></i></span>
                            <span>My Addresses</span>
                        </a>
                        <a href="{{route('my-home')}}" class="hd-dash-action">
                            <span class="hd-dash-action-icon"><i data-lucide="house"></i></span>
                            <span>Home Visit</span>
                        </a>
                        <a href="{{route('my_prescription')}}" class="hd-dash-action">
                            <span class="hd-dash-action-icon"><i data-lucide="file-text"></i></span>
                            <span>My Prescription</span>
                        </a>
                    </div>
                </div>

                <!-- Appointments (same filters, same table, same DataTable id) -->
                <div class="hd-dash-card">
                    <div class="hd-dash-appts-head">
                        <h3 class="hd-dash-card-title" style="margin: 0;"><i data-lucide="calendar-days"></i>{{__('message.Your Appointments')}}</h3>
                        <div class="hd-dash-filters">
                            <a href="{{ route('dashboard', ['type' => 'past' ]) }}" class="theme-btn-<?=$type==1?'one':'two'?>">{{__('message.Past')}}</a>
                            <a href="{{ route('dashboard', ['type' => 'upcomming' ]) }}" class="theme-btn-<?=$type==2?'one':'two'?>">{{__('message.Upcoming')}}</a>
                            <a href="{{ route('dashboard')}}" class="theme-btn-<?=$type==3?'one':'two'?>">{{__('message.Today')}}</a>
                        </div>
                    </div>

                    <div class="hd-dash-table-scroll">
                        <table class="doctors-table table" id="userdatatable" style="text-align: center;">
                            <thead class="table-header">
                                <tr>
                                    <th>Visit Type</th>
                                    <th>{{__('message.Appt Date')}}</th>
                                    <th>{{__('message.Appt Time')}}</th>
                                    <!--<th>Sample collection Date & time</th> -->
                                    <th>Sample Boy</th>
                                    <th>{{__('message.Paid Amount')}}</th>
                                    <th>{{__('message.Print')}}</th>
                                    <th>Track</th>
                                    <th>{{__('message.Status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                    <tr>
                                        <td>@if($d->visit_type == 0 )  Home Visit @else Lab Visit @endif</td>
                                        <td>{{$d->date}}</td>
                                        <td>{{$d->time}}</td>
                                        <!--<td>{{$d->time}}</td>-->
                                        <td>
                                            @if($d->sampleboyDetails == null)
                                            Not Assigned
                                            @else
                                            {{$d->sampleboyDetails->name}}
                                            {{$d->sampleboyDetails->phone}}
                                            @endif
                                        </td>
                                        <td>{{$res_curr[1].number_format($d->final_total,2,'.','')}}</td>
                                        <td>
                                            <a href="{{route('printorder', ['id' => $d->id ])}}" target="_blank"><span class="print" style="float: unset;"><i class="fas fa-print"></i>Print</span>
                                            </a>


                                        </td>
                                        <td>
                                            <a href="{{route('track-order', ['id' => $d->id ])}}" class="hd-track-btn">
                                                <i data-lucide="map-pin-check-inside"></i>Track
                                            </a>
                                        </td>
                                        <td>
                                            @if($d->status=='1')
                                                <span class="status pending">{{__('message.Pending')}}</span>
                                            @endif
                                            @if($d->status=='2')
                                                <span class="status pending">{{__('message.Accepted')}}</span>
                                            @endif
                                            @if($d->status=='3')
                                                <span class="status cancel">{{__('message.Rejected')}}</span>
                                            @endif
                                            @if($d->status=='4')
                                                <span class="status cancel">{{__('message.Refunded')}}</span>
                                            @endif
                                            @if($d->status=='5')
                                                <span class="status pending">{{__('message.Collected')}}</span>
                                            @endif
                                            @if($d->status=='6')
                                                <span class="status pending">{{__('message.Preparing')}}</span>
                                            @endif
                                            @if($d->status=='8')
                                                <span class="status pending"><small>Partial Report Send</small></span>
                                            @endif
                                            @if($d->status=='7')
                                              @if($d->is_feedback=='0')
                                                 <a href="javascript:void(0)" onclick="storeorderfeedback('{{$d->id}}')" data-toggle="modal" data-target="#addfeedback" style="padding: 5px;" class="theme-btn-one"><small>Add Feedback</small></a>
                                              @endif
                                                <!--<a type="button" class=" view_report" data-report="{{ json_encode($d->partiallyreports) }}" data-toggle="modal" data-target="#reportModal">-->
                                                <!--  <span class="print" style="float: unset;"><small>View Report</small></span>-->
                                                <!--</a>-->
                                                <a href="{{route('download-report')}}" target="_blank"><span class="print" style="float: unset;"><small>View Report</small></span>
                                                    </a>
                                                <span class="status"><small>{{__('message.Complete')}}</small></span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>
<div class="modal" id="addfeedback">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__('message.Add Feedback')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <form action="{{route('post-user-feedback')}}" method="post" id="" class="registration-form">
                <input type="hidden" name="order_id" id="feedback_order_id">
               {{csrf_field()}}
               <div class="row clearfix">
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>{{__('message.Description')}}</label>
                     <textarea name="description" rows="5" type="text" id="description"></textarea>
                  </div>
               </div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
         <button type="submit" id="address_submit_button" class="btn btn-success">{{__('message.Add Feedback')}}</button>
         </div>
         </form>
      </div>
   </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Report Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Placeholder to display the report details -->
                <div id="reportDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@stop
@section('footer')
<script type="text/javascript">


$(document).ready( function () {
    $('#userdatatable').DataTable();
} );

</script>
<script>
    $(document).ready(function () {
        // Attach a click event to the "View Report" button
        $('.view_report').on('click', function () {
            // Get the data from the button's data attribute
            var data = $(this).data('report');
        var customReportPath = '{{ asset('storage/app/public/report') }}/';

            // Generate the HTML to display the reports dynamically
            var html = '';
            data.forEach(function (report) {
                html += '<h5>Report Name: ' + report.report_name + '</h5>';
                html += '<p>Report File: ' + report.test_reg_id + '</p>';
                // Add a download link for each report
                html += '<a href="javascript:void(0)" onclick="fnGetPatientReport('+ report.test_reg_id +')">';
                html += '<i class="fas fa-download"></i> Download Report</a>';
                html += '<hr>';
            });


            // Set the generated HTML into the modal's content
            $('#reportDetails').html(html);

            // Show the modal
            $('#reportModal').modal('show');
        });
    });
</script>
@stop
