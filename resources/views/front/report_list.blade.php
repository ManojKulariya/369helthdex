@extends('front.layout')
@section('title')
    {{ $title }}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('aboutus')}}"/>
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

<style>
    .red-btn{
        border: 1px solid red;color: red;
    }
    .red-btn:hover {
    background-color: red; /* Red background on hover */
    color: white; /* White text on hover */
    border-color: red; /* Keep the red border */
}
</style>
<section class="page-title-two">
            <div class="title-box centred bg-color-2">
                <div class="pattern-layer">
                    <?php 
                          $sharp70 = asset('public/front/Docpro/assets/images/shape/shape-70.png');
                          $sharp71 = asset('public/front/Docpro/assets/images/shape/shape-71.png');
                          $sharp49 = asset('public/front/Docpro/assets/images/shape/shape-49.png');
                          $sharp50 = asset('public/front/Docpro/assets/images/shape/shape-50.png');
                          $sharp54 = asset('public/front/Docpro/assets/images/shape/shape-54.png');
                    ?>
                    <div class="pattern-1" style="background-image: url('{{$sharp70}}');"></div>
                    <div class="pattern-2" style="background-image: url('{{$sharp71}}');"></div>
                </div>
                <div class="auto-container">
                    <div class="title">
                        <h1>{{ $title }}</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                        <li>{{$title}}</li>
                    </ul>
                </div>
            </div>
            @if (session('payment_status'))
    <div class="alert alert-success">
        {{ session('payment_status') }}
    </div>
@endif

        </section>
        <section class="about-style-two pt-2">
            <div class="auto-container">
                <div class="row align-items-center clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 content-column">
                        <div class="content_block_1">
                            <div class="content-box mr-50">
                                <div class="sec-title">
                                    <h6>{{ $title }}</h6>
                                </div>
                                
                            </div>
                        </div>
                        <div class="wrapper list">
                            <div class="clinic-list-content list-item">
                                @foreach($data['reportlist'] as $row)
                                <div class="clinic-block-one p-0 mb-0">
                                    <div class="inner-box">
                                        <div class="content-box">
                                            <!--<div class="like-box"><a href="doctors-details.html"><i class="far fa-heart"></i></a></div>-->
                                            <ul class="name-box clearfix">
                                                <li class="name"><h5><a >{{$row['PatientName']}} | <span style="color:red;">Test Registration ID :</span> {{$row['TestRegnID']}} | <span style="color:red;">Balance Amount :</span> {{$row["BalanceAmt"]}}</a></h5></li>
                                                
                                            </ul>
                                            <span class="designation" style="line-height:1.2;">Date Of Registration : {{$row["RegnDateTimeString"]}}<br>Test Description : {{$row['SelectedTest']}}</br>
                                            Registration :- Net Amount : {{ $row['Net'] }} Rs.,Paid Amount : {{ $row['AmountPaid'] }} Rs.,
                                                Balance Amount: {{ $row['BalanceAmt'] }} Rs.</span>
                                            <?php if ($row['BalanceAmt'] <= 0) { ?>
                                                    <span style="line-height:1.2;">Report Availability:</span> 
                                                        <div class="btn-box">
                                                            <a href="javascript:void(0)" style="line-height:1.2;font-size:12px;" onclick="fnGetPatientReport('{{ $row['TestRegnID'] }}')" testregnid="{{ $row['TestRegnID'] }}">Download Report</a>
                                                        </div>
                                                    
                                                <?php } else { ?>
                                                    <span style="line-height:1.2;">Pay Balance Amount for report: </span>
                                                        <div class="btn-box">
                                                            <a href="javascript:void(0)" style="line-height:1.2;font-size:12px;" data-bs-toggle="modal" data-bs-target="#commonModal" onclick="updateModal('{{ $row['PatientName'] }}', '{{ $row['BalanceAmt'] }}', '{{ $row['TestRegnID'] }}')">Pay Online</a>
                                                        </div>
                                                    
                                                <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        
        <!--    Pay Modal       -->
            <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Patient Information</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('cc_request')}}" method="Get">
               
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modalPatientName" class="form-label">Patient Name</label>
                        <input id="modalPatientName" type="text" class="form-control" name="patientname" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modalPaymentAmount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="modalPaymentAmount" name="paymentAmount" readonly>
                    </div>
                    <input type="hidden" id="modalTestRegnID" name="testregnid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>
            <!------------------------>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 <script>
 function updateModal(patientName, balanceAmt, testRegnID) {
     
    document.getElementById('modalPatientName').value = patientName;
    document.getElementById('modalPaymentAmount').value = balanceAmt;
    document.getElementById('modalTestRegnID').value = testRegnID;
}


 </script>
@stop
@section('footer')
@stop