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
    .otp-container {
        display: flex;
        /*justify-content: center;*/
        gap: 10px;
    }

    .otp-input {
        width: 35px;
        height: 35px;
        font-size: 16px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .otp-input:focus {
        border-color: #007bff;
        outline: none;
    }
        .login-section {
            /*padding: 80px 0;*/
            background-color: #f7f7f7;
        }
        .card {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .card-body {
            padding: 10px;
        }
        h2 {
            font-weight: 600;
            color: #333;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px 15px;
        }
        .form-group label {
            font-weight: 500;
            color: #666;
        }
        .form-check-label {
            color: #666;
        }
        .btn-link {
            color: #007bff;
        }
    </style>
    <?php 
          $rpt_img = asset('public/front/Docpro/assets/images/rpt_img.jpg');
    ?>
        <section class="page-title-two">
            <!--<div class="title-box centred bg-color-2 py-5">-->
            <!--    <div class="auto-container">-->
            <!--        <div class="title">-->
            <!--            <h5 class="white">{{ $title }}</h5>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                        <li>{{$title}}</li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="about-style-two pt-3">
            <div class="auto-container">
                <div class="row align-items-center clearfix">
                    <div class="row col-lg-12 col-md-12 col-sm-12 content-column">
                        <div class="col-md-6">
                            <!--here login-->
                            <div class="login-container">
                                <h2 class="text-center mt-3">Login For Get Report</h2>

                                    <div class="mb-3 mt-3 phone">
                                        <label for="username" class="form-label">Mobile No</label>
                                        <input type="tel" id="phone" name="phon" class="form-control" autocomplete=""  id="username" placeholder="Enter your Mobile Number" maxlength="10" pattern="[0-9]{10}" />
                                    </div>
                                    <div class="mb-3 mt-3 otp" >
                                        <label for="password" class="form-label">Otp</label>
                                        <div class="otp-container" >
                                            <input type="tel" id="otp-1" maxlength="1" pattern="[0-9]" class="otp-input" required />
                                            <input type="tel" id="otp-2" maxlength="1" pattern="[0-9]" class="otp-input" required />
                                            <input type="tel" id="otp-3" maxlength="1" pattern="[0-9]" class="otp-input" required />
                                            <input type="tel" id="otp-4" maxlength="1" pattern="[0-9]" class="otp-input" required />
                                        </div>
                                    </div>
                                     <div class="alert" id="messageotp" ></div>
                                    <button type="submit" class="btn btn-primary w-100 otp"  id="verifyButton" style="background-color: #243847;color: white;border-color: #243847;border-radius:8px;">Sign IN</button>
                               
                                    <button type="submit" class="btn btn-primary w-100 phone"  id="sendotpButton" style="background-color: #243847;color: white;border-color: #243847;border-radius:8px;">Sign IN</button>
                               
                            </div>
                            </br>
                        </div>
                        <div class="col-md-6">
                            <img src="{{$rpt_img}}" style="width:100%;" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
     $(document).ready(function() {
        
         let num ;
         $('.otp').hide();
        $('#sendotpButton').click(function() {
            var phone = $('#phone').val();
            num = phone;
            $.ajax({
                url: '/otpsend_report',
                type: 'GET',
                data: { phone:phone },
                success: function(response) {
                    if (response.success) {
                        $('.phone').hide();
                        $('.otp').show();
                        $('#num').html(num);
                        $('#messageotp').removeClass('alert-danger').addClass('alert-success').text('OTP send successfuly!');
                    } else {
                        $('.phone').show();
                        $('.otp').hide();
                         $('#num').html('');
                    }
                },
                error: function() {
                    alert('An error occurred during OTP verification');
                }
            });
        });
        $('#verifyButton').click(function() {
            var otp = $('#otp-1').val() + $('#otp-2').val() + $('#otp-3').val() + $('#otp-4').val();
            
            $.ajax({
                url: '/otpverify_report',
                type: 'GET',
                data: { otp: otp},
                success: function(response) {
                    if (response.success) {
                        $('#messageotp').removeClass('alert-danger').addClass('alert-success').text('Login success.');
                            var objUserData = {
                                UserName: num,
                                Password: num,
                                Task: 3,
                                AppID: "4bee96ca-3ea8-4e89-a575-04d2beed400c"
                            };
                            $.ajax({
                            type: "GET",
                            url: '/check_login', 
                            data: objUserData,
                            success: function(response) {
                        
                            if (response) {
                                var scriptContent = response.match(/<script\b[^>]*>([\s\S]*?)<\/script>/i);
                                var scriptCode = scriptContent ? scriptContent[1] : null; // Extracts the code inside <script> tags
                                var response = response.replace(/<script.*?>.*?<\/script>/g, '');
                                // Now parse the cleaned response as JSON
                                var objresult = JSON.parse(response);
                                var objres = objresult.d;
                                if (objres) {
                                if (objres.Result == 'Success') {
                                window.location.href = '/reliable-report';
                                
                                }else {
                                    alert('Report Not Found')
                                    window.location.href = '/';
                                
                                }
                                
                                }
                            
                            } else {
                                alert('Report Not Found')
                                    window.location.href = '/';
                            
                            }
                            
                            },
                            
                            error: function(result) {
                            }
                            
                            });
                    } else {
                        $('#messageotp').removeClass('alert-success').addClass('alert-danger').text('Invalid OTP.');
                    }
                },
                error: function() {
                    alert('An error occurred during OTP verification');
                }
            });
        });
        const otpInputs = document.querySelectorAll('.otp-input');

    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (input.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus(); // Automatically focus the next input
            }
        });
    
        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && input.value.length === 0 && index > 0) {
                otpInputs[index - 1].focus(); // Move back on backspace
            }
        });
    });
    });
 </script>
@stop
@section('footer')
@stop