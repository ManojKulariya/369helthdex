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
@php
    /* Display-only mask: keep the last 3 digits visible (e.g. XXXXXXX664). */
    $hdOtpPhone = (string) $phone;
    $hdOtpMasked = strlen($hdOtpPhone) > 3
        ? str_repeat('X', strlen($hdOtpPhone) - 3) . substr($hdOtpPhone, -3)
        : $hdOtpPhone;
@endphp
<section class="hd-auth-section">
    <div class="hd-auth-bg" aria-hidden="true">
        <span class="hd-auth-blob hd-auth-blob-1"></span>
        <span class="hd-auth-blob hd-auth-blob-2"></span>
        <span class="hd-auth-pattern"></span>
    </div>
    <div class="auto-container">
        <nav class="hd-auth-breadcrumb" aria-label="Breadcrumb">
            <a href="{{route('home')}}">{{__("message.Home")}}</a>
            <i data-lucide="chevron-right"></i>
            <a href="{{route('user-login')}}">{{__("message.Login")}}</a>
            <i data-lucide="chevron-right"></i>
            <span>OTP Verify</span>
        </nav>

        <div class="hd-otp-split">
            <!-- Left: trust visual (decorative) -->
            <aside class="hd-otp-visual" aria-hidden="true">
                <span class="hd-otp-visual-pattern"></span>
                <span class="hd-otp-visual-glow hd-otp-visual-glow-1"></span>
                <span class="hd-otp-visual-glow hd-otp-visual-glow-2"></span>

                <span class="hd-otp-float hd-otp-float-1"><i data-lucide="heart-pulse"></i></span>
                <span class="hd-otp-float hd-otp-float-2"><i data-lucide="flask-conical"></i></span>
                <span class="hd-otp-float hd-otp-float-3"><i data-lucide="stethoscope"></i></span>
                <span class="hd-otp-float hd-otp-float-4"><i data-lucide="file-text"></i></span>

                <div class="hd-otp-visual-content">
                    <span class="hd-otp-visual-icon"><i data-lucide="shield-check"></i></span>
                    <h2 class="hd-otp-visual-title">Your health, secured</h2>
                    <p class="hd-otp-visual-text">We verify every login with a one-time password so your reports and bookings stay private to you.</p>
                    <div class="hd-otp-visual-points">
                        <span><i data-lucide="lock"></i>OTP-protected account access</span>
                        <span><i data-lucide="shield-check"></i>NABL accredited partner labs</span>
                        <span><i data-lucide="house"></i>Free home sample collection</span>
                    </div>
                </div>
            </aside>

            <!-- Right: OTP card -->
            <div class="hd-auth-card hd-otp-card">
                <div class="hd-auth-head">
                    <span class="hd-auth-icon"><i data-lucide="smartphone"></i></span>
                    <h1 class="hd-auth-title">Verify Your Mobile Number</h1>
                    <p class="hd-auth-subtitle">Enter the 4-digit OTP sent to your registered mobile number</p>
                    <div class="hd-otp-phone-row">
                        <span>OTP sent to</span>
                        <strong>{{ $hdOtpMasked }}</strong>
                        <a href="{{route('user-login')}}" class="hd-otp-edit">
                            <i data-lucide="pencil"></i>
                            Edit Number
                        </a>
                    </div>
                </div>

                @if(Session::has('message'))
                    <div class="col-sm-12">
                       <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                       </div>
                    </div>
                    @endif

                <label class="hd-otp-label" for="hdOtpBox1">One Time Password</label>
                <div class="hd-otp-boxes" id="hdOtpBoxes">
                    <input type="text" class="hd-otp-box" id="hdOtpBox1" inputmode="numeric" pattern="[0-9]*" maxlength="4" autocomplete="one-time-code" aria-label="OTP digit 1 of 4">
                    <input type="text" class="hd-otp-box" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="off" aria-label="OTP digit 2 of 4">
                    <input type="text" class="hd-otp-box" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="off" aria-label="OTP digit 3 of 4">
                    <input type="text" class="hd-otp-box" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="off" aria-label="OTP digit 4 of 4">
                </div>

                <input type="hidden" name="otp" required="" id="otpInput">
                <input type="hidden" name="phone" required="" id="phoneInput" value="{{ $phone }}">

                <div class="alert hd-otp-message" id="messageotp" role="alert" aria-live="polite"></div>

                <button type="submit" class="theme-btn-one hd-auth-submit" id="verifyButton">
                    <span class="hd-otp-spinner" aria-hidden="true"></span>
                    Verify
                    <i data-lucide="arrow-right" class="hd-otp-submit-arrow"></i>
                </button>

                <div class="hd-otp-resend">
                    Didn't receive the code?
                    <a href="javascript:void(0)" id="resendOtp">Resend OTP</a>
                    <span id="resendTimer"></span>
                </div>
            </div>
        </div>

        <div class="hd-auth-hints">
            <span><i data-lucide="shield-check"></i>Secure OTP login</span>
            <span><i data-lucide="clock"></i>OTP expires in {{ (int) config('auth.otp.expiry_minutes', 5) }} minutes</span>
            <span><i data-lucide="headphones"></i>Need help? {{ $setting->phone }}</span>
        </div>
    </div>
</section>
@stop
@section('footer')
<script>
    $(document).ready(function() {
        var $boxes = $('.hd-otp-box');
        var $wrap = $('#hdOtpBoxes');
        var $hidden = $('#otpInput');
        var boxCount = $boxes.length;

        function syncHidden() {
            var value = '';
            $boxes.each(function() { value += this.value; });
            $hidden.val(value);
            return value;
        }
        function clearStates() { $wrap.removeClass('hd-otp-error hd-otp-success'); }
        function fillFromString(digits, startIdx) {
            for (var i = 0; i < digits.length && (startIdx + i) < boxCount; i++) {
                $boxes.eq(startIdx + i).val(digits[i]).addClass('hd-otp-filled');
            }
            var focusIdx = Math.min(startIdx + digits.length, boxCount - 1);
            $boxes.eq(focusIdx).trigger('focus');
            syncHidden();
        }

        $boxes.first().trigger('focus');

        $boxes.on('input', function() {
            clearStates();
            var idx = $boxes.index(this);
            var digits = this.value.replace(/[^0-9]/g, '');
            this.value = '';
            if (digits.length > 0) {
                fillFromString(digits.split(''), idx);
            } else {
                $(this).removeClass('hd-otp-filled');
                syncHidden();
            }
        });

        $boxes.on('keydown', function(e) {
            var idx = $boxes.index(this);
            if (e.key === 'Backspace') {
                clearStates();
                if (this.value) {
                    this.value = '';
                    $(this).removeClass('hd-otp-filled');
                } else if (idx > 0) {
                    $boxes.eq(idx - 1).val('').removeClass('hd-otp-filled').trigger('focus');
                }
                syncHidden();
                e.preventDefault();
            } else if (e.key === 'ArrowLeft' && idx > 0) {
                $boxes.eq(idx - 1).trigger('focus');
                e.preventDefault();
            } else if (e.key === 'ArrowRight' && idx < boxCount - 1) {
                $boxes.eq(idx + 1).trigger('focus');
                e.preventDefault();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                $('#verifyButton').trigger('click');
            }
        });

        $boxes.on('paste', function(e) {
            e.preventDefault();
            clearStates();
            var text = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('text') || '';
            var digits = text.replace(/[^0-9]/g, '').slice(0, boxCount);
            if (!digits.length) return;
            $boxes.val('').removeClass('hd-otp-filled');
            fillFromString(digits.split(''), 0);
        });

        $('#verifyButton').click(function() {
            var otp = syncHidden();
            var phone = $('#phoneInput').val();

            if (otp.length < boxCount) {
                $wrap.addClass('hd-otp-error');
                $('#messageotp').removeClass('alert-success').addClass('alert-danger').text('Please enter the complete ' + boxCount + '-digit OTP.');
                return;
            }

            var $btn = $(this).addClass('is-loading').prop('disabled', true);

            $.ajax({
                url: 'otpverify',
                type: 'GET',
                data: { otp: otp,phone:phone },
                success: function(response) {
                    if (response.success) {
                        $wrap.removeClass('hd-otp-error').addClass('hd-otp-success');
                        $('#messageotp').removeClass('alert-danger').addClass('alert-success').text('Verified! Redirecting…');

                        // New user: continue to registration with the verified number.
                        if (response.register && response.redirect) {
                            window.location.href = response.redirect;
                            return;
                        }

                        var intendedUrl = response.intended_url;
                        if (intendedUrl == '' || intendedUrl == null) {
                            window.location.href = '{{ route("dashboard") }}';
                        } else {
                            window.location.href = intendedUrl;
                        }
                    } else {
                        $btn.removeClass('is-loading').prop('disabled', false);
                        $wrap.addClass('hd-otp-error');
                        $('#messageotp').removeClass('alert-success').addClass('alert-danger').text(response.msg || 'Invalid OTP.');
                    }
                },
                error: function() {
                    $btn.removeClass('is-loading').prop('disabled', false);
                    $wrap.addClass('hd-otp-error');
                    $('#messageotp').removeClass('alert-success').addClass('alert-danger').text('An error occurred during OTP verification');
                }
            });
        });

        // ---- Resend OTP with cool-down ----
        var resendSeconds = {{ (int) config('auth.otp.resend_seconds', 45) }};
        var timerId = null;

        function formatTimer(totalSeconds) {
            var m = Math.floor(totalSeconds / 60);
            var s = totalSeconds % 60;
            return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
        }

        function startCooldown(seconds) {
            var left = seconds;
            clearInterval(timerId);
            $('#resendOtp').css({ 'pointer-events': 'none', 'opacity': '.5' });
            $('#resendTimer').text('in ' + formatTimer(left));
            timerId = setInterval(function() {
                left--;
                if (left <= 0) {
                    clearInterval(timerId);
                    $('#resendOtp').css({ 'pointer-events': '', 'opacity': '' });
                    $('#resendTimer').text('');
                } else {
                    $('#resendTimer').text('in ' + formatTimer(left));
                }
            }, 1000);
        }

        startCooldown(resendSeconds);

        $('#resendOtp').click(function() {
            var phone = $('#phoneInput').val();
            $.ajax({
                url: '{{ route("resend-login-otp") }}',
                type: 'GET',
                data: { phone: phone },
                success: function(response) {
                    if (response.success) {
                        clearStates();
                        $boxes.val('').removeClass('hd-otp-filled');
                        syncHidden();
                        $boxes.first().trigger('focus');
                        $('#messageotp').removeClass('alert-danger').addClass('alert-success').text(response.msg || 'OTP sent again.');
                        startCooldown(resendSeconds);
                    } else {
                        $('#messageotp').removeClass('alert-success').addClass('alert-danger').text(response.msg || 'Could not resend OTP.');
                    }
                },
                error: function() {
                    $('#messageotp').removeClass('alert-success').addClass('alert-danger').text('Could not resend OTP.');
                }
            });
        });
    });
</script>
@stop
