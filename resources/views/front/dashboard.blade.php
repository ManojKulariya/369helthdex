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
<section class="page-title-two">
            <div class="title-box centred bg-color-2">
                <div class="pattern-layer">
                   <?php 
                          $sharp70 = asset('public/front/Docpro/assets/images/shape/shape-70.png');
                          $sharp71 = asset('public/front/Docpro/assets/images/shape/shape-71.png');
                    ?>
                    <div class="pattern-1" style="background-image: url('{{$sharp70}}');"></div>
                    <div class="pattern-2" style="background-image: url('{{$sharp71}}');"></div>
                </div>
                <div class="auto-container">
                    <div class="title">
                        <h1>{{__('message.Dashboard')}}</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                        <li>{{__('message.Dashboard')}}</li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="doctors-dashboard bg-color-3">
            <div class="left-panel">
                <div class="profile-box">
                     <div class="upper-box">
                         <?php 
                              if(Auth::user()->profile_pic!=""){
                                  $path=env('APP_URL')."storage/app/public/profile"."/".Auth::user()->profile_pic;
                              }
                              else{
                                  $path=asset('public/img/default_user.png');
                              }
                              ?>
           
            <figure class="profile-image"><img src="{{$path}}" alt=""></figure>
                        <div class="title-box centred">
                           <div class="inner">
                              <h3>{{Auth::user()->name}}</h3>
                              <p><i class="fas fa-envelope"></i>{{Auth::user()->email}}</p>
                           </div>
                        </div>
                     </div>
                     <div class="profile-info">
                        <ul class="list clearfix">
                           <li><a href="{{route('dashboard')}}" class="current"><i class="fas fa-columns"></i>{{__('message.Dashboard')}}</a></li>
                          
                           <li><a href="{{route('my-family-member')}}"><i class="fas fa-clock"></i>{{__('message.My Family Members')}}</a></li>
                           <li><a href="{{route('my-addresses')}}"><i class="fas fa-comments"></i>{{__('message.My Addresses')}}</li>
                            <li><a href="{{route('my-home')}}"><i class="fas fa-comments"></i>Home Visit</li>
                            <li><a href="{{route('my_prescription')}}"><i class="fas fa-comments"></i>My Prescription</li>
                           <li><a href="{{route('user-profile')}}"><i class="fas fa-user"></i>{{__('message.My Profile')}}</a></li>
                           <li><a href="{{route('user-change-password')}}"><i class="fas fa-unlock-alt"></i>{{__('message.Change Password')}}</a></li>
                           <li><a href="{{route('user-logout')}}"><i class="fas fa-sign-out-alt"></i>{{__('message.Logout')}}</a></li>
                        </ul>
                     </div>
                </div>
            </div>
            <div class="right-panel">
                <div class="content-container">
                    <div class="outer-container">
                        <div class="feature-content">
                            <div class="row clearfix">
                                <div class="col-xl-6 col-lg-12 col-md-12 feature-block">
                                    <div class="feature-block-two">
                                        <div class="inner-box">
                                            <div class="pattern">
                                                 <?php 
                                                  $sharp70 = asset('public/front/Docpro/assets/images/shape/shape-79.png');
                                                  $sharp71 = asset('public/front/Docpro/assets/images/shape/shape-80.png');
                                                  $sharp81 = asset('public/front/Docpro/assets/images/shape/shape-81.png');
                                                  $sharp82 = asset('public/front/Docpro/assets/images/shape/shape-82.png');
                                                  $sharp83 = asset('public/front/Docpro/assets/images/shape/shape-83.png');
                                                  $sharp84 = asset('public/front/Docpro/assets/images/shape/shape-84.png');
                                                    ?>
                                                <div class="pattern-1" style="background-image: url('{{$sharp70}}');"></div>
                                                <div class="pattern-2" style="background-image: url('{{$sharp71}}');"></div>
                                            </div>
                                            <div class="icon-box"> &#8377;</div>
                                            <h3>{{number_format($wallet_points,2)}}</h3>
                                            <h5>Total Wallet Point</h5>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-xl-6 col-lg-12 col-md-12 feature-block" style="margin-bottom: 15px">
                                    <div class="feature-block-two">
                                        <div class="inner-box">
                                            <div class="pattern">
                                                 <?php 
                                                  $sharp70 = asset('public/front/Docpro/assets/images/shape/shape-79.png');
                                                  $sharp71 = asset('public/front/Docpro/assets/images/shape/shape-80.png');
                                                  $sharp81 = asset('public/front/Docpro/assets/images/shape/shape-81.png');
                                                  $sharp82 = asset('public/front/Docpro/assets/images/shape/shape-82.png');
                                                  $sharp83 = asset('public/front/Docpro/assets/images/shape/shape-83.png');
                                                  $sharp84 = asset('public/front/Docpro/assets/images/shape/shape-84.png');
                                                    ?>
                                                <div class="pattern-1" style="background-image: url('{{$sharp70}}');"></div>
                                                <div class="pattern-2" style="background-image: url('{{$sharp71}}');"></div>
                                            </div>
                                            <div class="icon-box"><i class="icon-Dashboard-1"></i></div>
                                            <h3>{{$totalorders}}</h3>
                                            <h5>{{__('message.Total Appointment')}}</h5>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-12 feature-block">
                                    <div class="feature-block-two">
                                        <div class="inner-box">
                                            <div class="pattern">
                                                <div class="pattern-1" style="background-image: url('{{$sharp81}}');"></div>
                                                <div class="pattern-2" style="background-image: url('{{$sharp82}}');"></div>
                                            </div>
                                            <div class="icon-box"><i class="icon-Dashboard-2"></i></div>
                                            <h3>{{$pendingorders}}</h3>
                                            <h5>{{__('message.Pending Appointment')}}</h5>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-12 feature-block">
                                    <div class="feature-block-two">
                                        <div class="inner-box">
                                            <div class="pattern">
                                                <div class="pattern-1" style="background-image: url('{{$sharp83}}');"></div>
                                                <div class="pattern-2" style="background-image: url('{{$sharp84}}');"></div>
                                            </div>
                                            <div class="icon-box"><i class="icon-Dashboard-3"></i></div>
                                            <h3>{{$completeorders}}</h3>
                                            <h5>{{__('message.Complete Appointment')}}</h5>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="doctors-appointment">
                            <div class="title-box">
                                <h3>{{__('message.Your Appointments')}}</h3>
                                <div class="btn-box">
                                    <a href="{{ route('dashboard', ['type' => 'past' ]) }}" class="theme-btn-<?=$type==1?'one':'two'?>">{{__('message.Past')}}</a>
                                    <a href="{{ route('dashboard', ['type' => 'upcomming' ]) }}" class="theme-btn-<?=$type==2?'one':'two'?>">{{__('message.Upcoming')}}</a>
                                    <a href="{{ route('dashboard')}}" class="theme-btn-<?=$type==3?'one':'two'?>">{{__('message.Today')}}</a>
                                </div>
                            </div>

                            <div class="doctors-list" style="padding: 5px 24px;">
                                <div class="table-outer">
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
                        </div>
                    </div>
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