@extends('front.layout')
@section('title')
    OTP verify
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('user-login')}}"/>
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
<section class="page-title-two">
            <div class="title-box centred bg-color-2">
                <div class="pattern-layer">
                    <div class="pattern-1" style="background-image: url(assets/images/shape/shape-70.png);"></div>
                    <div class="pattern-2" style="background-image: url(assets/images/shape/shape-71.png);"></div>
                </div>
                <div class="auto-container">
                    <div class="title">
                        <h1>{{__("message.Login")}}</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__("message.Home")}}</a></li>
                        <li>{{__("message.Login")}}</li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="registration-section bg-color-3">
            <div class="pattern">
                <div class="pattern-1" style="background-image: url(assets/images/shape/shape-85.png);"></div>
                <div class="pattern-2" style="background-image: url(assets/images/shape/shape-86.png);"></div>
            </div>
            <div class="auto-container">
                <div class="inner-box">
                    <div class="content-box">
                        <div class="title-box">
                            <h3>OTP Verify</h3>
                            <!--<a href="{{route('user-register')}}">{{__("message.Not a User")}}?</a>-->
                        </div>
                        <div class="inner">
                             @if(Session::has('message'))
                                 <div class="col-sm-12">
                                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                       <span aria-hidden="true">&times;</span></button>
                                    </div>
                                 </div>
                                 @endif
                           
                                <div class="row clearfix">
                                   
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label>OTP</label>
                                        <input type="text" name="otp" placeholder="Enter OTP" required="" id="otpInput" >
                                       <div class="alert" id="messageotp" ></div>

                                        <input type="hidden" name="phone" required="" id="phoneInput" value="{{ $phone }}">
                                    </div>
                                    
                                   
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn-one" id="verifyButton">Verify</button>
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
            var otp = $('#otpInput').val();
            var phone = $('#phoneInput').val();

            $.ajax({
                url: 'otpverify',
                type: 'GET',
                data: { otp: otp,phone:phone },
                success: function(response) {
                  //  console.log(response);
                    if (response.success) {
                       
                        var intendedUrl = response.intended_url; 
                        if (intendedUrl == '') {
                        window.location.href = '{{ route("dashboard") }}';
                    } else {
                        window.location.href = intendedUrl;
                    }
                       
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