@extends('front.layout')
@section('title')
 {{__("message.Register")}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('user-register')}}"/>
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
            <a href="{{route('home')}}">{{__("message.Home")}}</a>
            <i data-lucide="chevron-right"></i>
            <span>{{__("message.Register")}}</span>
        </nav>

        <div class="hd-auth-card hd-auth-card-lg">
            <div class="hd-auth-head">
                <span class="hd-auth-icon"><i data-lucide="user-round-plus"></i></span>
                <h1 class="hd-auth-title">{{__("message.User Register")}}</h1>
                <p class="hd-auth-subtitle">Create your account to book tests, schedule home collection and access reports</p>
                <a href="{{route('user-login')}}" class="hd-auth-switch">
                    {{__("message.Already User")}}?
                    <i data-lucide="arrow-right"></i>
                </a>
            </div>

            @if(Session::has('message'))
                <div class="col-sm-12">
                   <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                   </div>
                </div>
                @endif

            <form action="{{route('post-user-register')}}" method="post" class="registration-form hd-auth-form">
                {{csrf_field()}}
                <div class="hd-auth-grid">
                    <div class="hd-field">
                        <label>{{__("message.Name")}}</label>
                        <div class="hd-input-wrap">
                            <i data-lucide="user-round"></i>
                            <input type="text" name="name" id="name" placeholder="{{__('message.Enter Name')}}" required="" value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <div class="hd-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="hd-field">
                        <label>Mobile <span class="hd-field-verified"><i data-lucide="badge-check"></i> OTP verified</span></label>
                        <div class="hd-input-wrap">
                            <i data-lucide="phone"></i>
                            <input type="text" name="phone" id="phone" placeholder="Enter Mobile" required="" readonly value="{{ old('phone', session('otp_verified_phone')) }}">
                        </div>
                        @error('phone')
                            <div class="hd-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="hd-field hd-field-full">
                        <label>{{__("message.email")}}</label>
                        <div class="hd-input-wrap">
                            <i data-lucide="mail"></i>
                            <input type="email" name="email" id="email" placeholder="{{__('message.Enter Email')}}" required="" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <div class="hd-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="hd-field">
                        <label>Date of Birth</label>
                        <div class="hd-input-wrap">
                            <i data-lucide="calendar"></i>
                            <input type="date" name="d_o_b" id="d_o_b" placeholder="Enter Date Of Birth" required="" max="{{ date('Y-m-d') }}" value="{{ old('d_o_b') }}">
                        </div>
                        @error('d_o_b')
                            <div class="hd-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="hd-field">
                        <label>Age</label>
                        <div class="hd-input-wrap">
                            <i data-lucide="hash"></i>
                            <input type="text" name="age" id="age" placeholder="Auto-calculated from DOB" readonly value="{{ old('age') }}">
                        </div>
                        @error('age')
                            <div class="hd-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="hd-field hd-field-full">
                        <label>Gender</label>
                        <div class="hd-input-wrap">
                            <i data-lucide="users"></i>
                            <select name="sex">
                                <option value='Male' {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                 <option value='Female' {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        @error('sex')
                            <div class="hd-field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="hd-field hd-field-full">
                        <div class="custom-check-box">
                            <div class="custom-controls-stacked">
                                <label class="custom-control material-checkbox">
                                    <input type="checkbox" class="material-control-input">
                                    <span class="material-control-indicator"></span>
                                    <span class="description">{{__("message.I accept")}} <a href="#">{{__("message.terms")}}</a> and <a href="#">{{__("message.conditions")}}</a> {{__("message.and general policy")}}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="theme-btn-one hd-auth-submit">{{__("message.Register")}}<i data-lucide="arrow-right"></i></button>
            </form>

            <div class="hd-auth-divider">{{__("message.or")}}</div>
            <div class="login-now"><p>{{__("message.Already have an account")}}? <a href="{{route('user-login')}}">{{__("message.Login Now")}}</a></p></div>
        </div>

        <div class="hd-auth-hints">
            <span><i data-lucide="shield-check"></i>Your data stays private</span>
            <span><i data-lucide="house"></i>Free home sample collection</span>
            <span><i data-lucide="file-text"></i>Digital reports anytime</span>
        </div>
    </div>
</section>

@stop
@section('footer')
<script>
    // Age auto-calculates from Date of Birth; the field itself is read-only.
    (function () {
        var dob = document.getElementById('d_o_b');
        var age = document.getElementById('age');
        if (!dob || !age) return;

        function calcAge() {
            if (!dob.value) { age.value = ''; return; }
            var d = new Date(dob.value);
            if (isNaN(d.getTime())) { age.value = ''; return; }
            var today = new Date();
            var years = today.getFullYear() - d.getFullYear();
            var m = today.getMonth() - d.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < d.getDate())) {
                years--;
            }
            age.value = years >= 0 ? years : '';
        }

        dob.addEventListener('change', calcAge);
        dob.addEventListener('input', calcAge);
        if (dob.value && !age.value) calcAge();
    })();
</script>
@stop