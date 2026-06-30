@extends('front.layout')
<?php
$cityName = session()->get('cityName');
if ($cityName == '') {
    $cityName = 'jaipur';
}
?>
@section('title')
Opportunities {{$cityName}}
@stop
@section('meta-data')

<link rel="canonical" href="{{ url()->current() }}">
<meta name="description"
    content="Book medical tests, blood testing services online in {{$cityName}} with free home sample collection. Book your appointment at Reliable Diagnostic Centre in {{$cityName}}.">
<meta name="keywords" content="Opportunities {{$cityName}}">

<meta name="robots" content="index, follow" />

<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title"
    content="Book a Blood Test at home Online in {{$cityName}}, Best Diagnostic lab in {{$cityName}}" />
<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}" />
<meta property="og:image:width" content="250px" />
<meta property="og:image:height" content="250px" />
<meta property="og:site_name" content="{{__('message.site_name')}}" />
<meta property="og:description"
    content="Book medical tests, blood testing services online in {{$cityName}} with free home sample collection. Book your appointment at Reliable Diagnostic Centre in {{$cityName}}." />
<meta property="og:keyword"
    content="Book medical test in {{$cityName}}, blood test online in {{$cityName}}, free home collection in {{$cityName}}, Lipid profile test, thyroid test, kidney function test, liver function test, blood sugar test, hb1ac test, diabetes test" />
<link rel="shortcut icon" href="{{asset('public/img/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')

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
                <h1>Opportunities </h1>
            </div>
        </div>
    </div>
    <div class="lower-content">
        <div class="auto-container">
            <ul class="bread-crumb clearfix">
                <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                <li>Opportunities</li>
            </ul>
        </div>
    </div>
</section>
<section class="pricing-section bg-color-3 sec-pad">
    <div class="pattern-layer">
        <?php
        $path1 = asset('public/front/Docpro/assets/images/shape/shape-39.png');
        $path2 = asset('public/front/Docpro/assets/images/shape/shape-42.png');
        $arrow1 = asset('public/front/Docpro/assets/images/icons/arrow-1.png');
        $sharp45 = asset('public/front/Docpro/assets/images/shape/shape-45.png');
        $sharp46 = asset('public/front/Docpro/assets/images/shape/shape-46.png');
        $sharp75 = asset('public/front/Docpro/assets/images/shape/shape-75.png');
        $sharp76 = asset('public/front/Docpro/assets/images/shape/shape-76.png');
        $sharp77 = asset('public/front/Docpro/assets/images/shape/shape-77.png');
        ?>
        <div class="pattern-1" style="background-image: url('{{$path1}}');"></div>
        <div class="pattern-4" style="background-image: url('{{$path2}}');"></div>
    </div>
    <div class="auto-container">

        <div class="inner-content">
            <div class="row clearfix" id="data-container">
                <div class="col-lg-12 col-md-12 col-sm-12 " style="margin-bottom: 10px;">

                    <div class="testimonial-block-two">
                        <div class="inner-box">
                            <div class="">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="applyModalLabel">Enter OTP to apply for the job<small><br>We've just shared an OTP on your phone number</small></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                                <label for="mobile_number"><small>Enter OTP:</small></label>
                                                <input type="hidden"  name="v_id" class="form-control" value="{{$data->v_id}}" required>
                                                <input type="hidden"  name="id" id="id" class="form-control" value="{{$data->id}}" required>
                                                <div class="alert" id="messageotp" ></div>
                                                <input type="text" id="otp" name="otp" class="form-control" required>
                                                <br>
                                                <button type="submit" class=" theme-btn-one" id="verifyButton"  ><small>NEXT</small></button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                            
                            
                        </div>
                        

                    </div>
                </div>
            </div>


        </div>
       
</div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#verifyButton').click(function() {
            var otp = $('#otp').val();
            var id = $('#id').val();

            $.ajax({
                url: 'otp-job-verify',
                type: 'GET',
                data: { otp: otp,id:id },
                success: function(response) {
                    console.log(id);
                    if (response.success) {
                        
                        window.location.href = `appId/${id}`;
                    } else {
                        $('#messageotp').removeClass('alert-success').addClass('alert-danger').text('Invalid OTP.');
                    }
                },
                error: function() {
                    alert('An error occurred during OTP verification');
                }
            });
        });
    });
</script>

@stop
@section('footer')
@stop