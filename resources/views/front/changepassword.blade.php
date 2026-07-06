@extends('front.layout')
@section('title')
 {{__('message.Change Password')}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('user-change-password')}}"/>
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
<section class="hd-dash-section">
    <div class="auto-container">
        <!-- Page head -->
        <div class="hd-dash-head">
            <nav class="hd-dash-breadcrumb" aria-label="Breadcrumb">
                <a href="{{route('home')}}">{{__('message.Home')}}</a>
                <i data-lucide="chevron-right"></i>
                <a href="{{route('dashboard')}}">{{__('message.Dashboard')}}</a>
                <i data-lucide="chevron-right"></i>
                <span>{{__('message.Change Password')}}</span>
            </nav>
            <h1 class="hd-dash-title">{{__('message.Change Password')}}</h1>
        </div>

        <div class="hd-dash-layout">
            @include('front.hd_account_sidebar', ['hdSidebarActive' => 'password'])

            <main class="hd-dash-main">
                @if(Session::has('message'))
                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                    </div>
                    @endif

                <div class="hd-dash-card hd-dash-form">
                    <h3 class="hd-dash-card-title"><i data-lucide="lock-keyhole"></i>{{__('message.Change Password')}}</h3>

                    <form action="{{route('update-change-password')}}" method="post">
                        {{csrf_field()}}
                        <div class="hd-auth-grid hd-pass-grid">
                            <div class="hd-field-full form-group">
                                <label>{{__('message.Old Password')}}</label>
                                <input type="password" name="old_password" id="old_password" required="" onchange="checkcurrentpassword(this.value)">
                            </div>
                            <div class="hd-field-full form-group">
                                <label>{{__('message.New Password')}}</label>
                                <input type="password" name="npassword" id="npassword" required="">
                            </div>
                            <div class="hd-field-full form-group">
                                <label>{{__('message.Confirm Password')}}</label>
                                <input type="password" onchange="checkbothpassword(this.value)" name="cpassword" id="cpassword" required="">
                            </div>
                        </div>

                        <div class="hd-dash-form-actions">
                            <button type="submit" class="theme-btn-one">{{__('message.Save Change')}}<i data-lucide="arrow-right"></i></button>
                            <a href="javascript::void(0)" onclick="resetpassword()" class="cancel-btn">{{__('message.Cancel')}}</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</section>
@stop
@section('footer')
@stop
