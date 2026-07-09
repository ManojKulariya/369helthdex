@extends('front.layout')
@section('title')
    {{ $title }}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('download-report')}}"/>
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
<section class="hd-auth-section">
    <div class="hd-auth-bg" aria-hidden="true">
        <span class="hd-auth-blob hd-auth-blob-1"></span>
        <span class="hd-auth-blob hd-auth-blob-2"></span>
        <span class="hd-auth-pattern"></span>
    </div>
    <div class="auto-container">
        <nav class="hd-auth-breadcrumb" aria-label="Breadcrumb">
            <a href="{{route('home')}}">{{__('message.Home')}}</a>
            <i data-lucide="chevron-right"></i>
            <span>{{ $title }}</span>
        </nav>

        <div class="hd-auth-card">
            <div class="hd-auth-head">
                <span class="hd-auth-icon"><i data-lucide="file-down"></i></span>
                <h1 class="hd-auth-title">Download Your Reports</h1>
                <p class="hd-auth-subtitle">Verify your mobile number with a one-time password to securely access your test reports</p>
            </div>

            <!-- Step 1: phone -->
            <div class="hd-auth-form phone">
                <div class="hd-field">
                    <label for="phone">Mobile Number</label>
                    <div class="hd-input-wrap">
                        <i data-lucide="phone"></i>
                        <input type="tel" id="phone" name="phon" autocomplete="tel" placeholder="Enter your Mobile Number" maxlength="10" pattern="[0-9]{10}" />
                    </div>
                </div>
                <button type="submit" class="theme-btn-one hd-auth-submit" id="sendotpButton">Send OTP<i data-lucide="arrow-right"></i></button>
            </div>

            <!-- Step 2: OTP -->
            <div class="hd-auth-form otp">
                <div class="hd-rpt-otp-sent">
                    <i data-lucide="message-square-lock"></i>
                    <p>We&rsquo;ve sent a 4-digit OTP to <strong id="num"></strong></p>
                </div>
                <div class="hd-field">
                    <label for="otp-1">One Time Password</label>
                    <div class="hd-otp-boxes hd-rpt-otp-boxes">
                        <input type="tel" id="otp-1" maxlength="1" pattern="[0-9]" class="otp-input hd-otp-box" inputmode="numeric" autocomplete="one-time-code" aria-label="OTP digit 1 of 4" required />
                        <input type="tel" id="otp-2" maxlength="1" pattern="[0-9]" class="otp-input hd-otp-box" inputmode="numeric" autocomplete="off" aria-label="OTP digit 2 of 4" required />
                        <input type="tel" id="otp-3" maxlength="1" pattern="[0-9]" class="otp-input hd-otp-box" inputmode="numeric" autocomplete="off" aria-label="OTP digit 3 of 4" required />
                        <input type="tel" id="otp-4" maxlength="1" pattern="[0-9]" class="otp-input hd-otp-box" inputmode="numeric" autocomplete="off" aria-label="OTP digit 4 of 4" required />
                    </div>
                </div>
                <button type="submit" class="theme-btn-one hd-auth-submit" id="verifyButton">Verify &amp; View Reports<i data-lucide="arrow-right"></i></button>
            </div>

            <div class="alert hd-rpt-message" id="messageotp" role="alert" aria-live="polite"></div>
        </div>

        <div class="hd-auth-hints">
            <span><i data-lucide="shield-check"></i>Secure OTP verification</span>
            <span><i data-lucide="file-text"></i>NABL certified reports</span>
            <span><i data-lucide="download"></i>Instant PDF download</span>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
     $(document).ready(function() {

         let num ;
         $('.otp').hide();
         $('#messageotp').hide();
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
                        $('#otp-1').trigger('focus');
                        $('#messageotp').show().removeClass('alert-danger').addClass('alert-success').text('OTP sent successfully!');
                    } else {
                        $('.phone').show();
                        $('.otp').hide();
                         $('#num').html('');
                         $('#messageotp').show().removeClass('alert-success').addClass('alert-danger').text(response.msg || 'Please enter a valid mobile number.');
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
                        $('#messageotp').show().removeClass('alert-danger').addClass('alert-success').text('OTP verified. Fetching your reports...');
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
                                window.location.href = '/helthdex-report';

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
                        $('#messageotp').show().removeClass('alert-success').addClass('alert-danger').text('Invalid OTP. Please try again.');
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
