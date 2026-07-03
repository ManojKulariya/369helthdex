@extends('front.layout')
@section('title')
    {{__("message.Login")}}
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
            <span>{{__("message.Login")}}</span>
        </nav>

        <div class="hd-auth-card">
            <div class="hd-auth-head">
                <span class="hd-auth-icon"><i data-lucide="user-round"></i></span>
                <h1 class="hd-auth-title">{{__("message.User Login")}}</h1>
                <p class="hd-auth-subtitle">Welcome back — sign in with your phone number to manage your bookings and reports</p>
                <a href="{{route('user-register')}}" class="hd-auth-switch">
                    {{__("message.Not a User")}}?
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

            <form action="{{route('post-user-login')}}" method="post" class="registration-form hd-auth-form">
                 {{csrf_field()}}
                <div class="hd-field">
                    <label>Phone Number</label>
                    <div class="hd-input-wrap">
                        <i data-lucide="phone"></i>
                        <input type="number" name="phone" placeholder="{{__('message.Enter Phone')}}" required="" value="{{ old('phone', isset($_COOKIE['phone'])?$_COOKIE['phone']:'') }}">
                    </div>
                    @error('phone')
                        <div class="hd-field-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="theme-btn-one hd-auth-submit">Send OTP<i data-lucide="arrow-right"></i></button>
            </form>

            <div class="hd-auth-divider">{{__("message.or")}}</div>
           <!-- <ul class="social-links clearfix">
                <li><a href="#">{{__("message.Login with Facebook")}}</a></li>
                <li><a href="#">{{__("message.Login with Google Plus")}}</a></li>
            </ul>-->
            <div class="login-now"><p>{{__("message.don't have an account")}}? <a href="{{route('user-register')}}">{{__("message.Register Now")}}</a></p></div>
        </div>

        <div class="hd-auth-hints">
            <span><i data-lucide="shield-check"></i>Secure OTP login</span>
            <span><i data-lucide="file-text"></i>Access your reports</span>
            <span><i data-lucide="calendar-check"></i>Track your bookings</span>
        </div>
    </div>
</section>

@stop
@section('footer')
@stop