@extends('front.layout')
@section('title')
 {{__('message.Forgot Password')}}
@stop
@section('meta-data')
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('forgotpassword')}}"/>
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
                        <h1>{{__('message.Forgot Password')}}</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                        <li>{{__('message.Forgot Password')}}</li>
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
                            <h3>{{__('message.Forgot Password')}}</h3>
                            <a href="{{route('user-register')}}">{{__('message.Login')}}?</a>
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
                            <form action="{{route('post-forgotpassword')}}" method="post" class="registration-form">
                                 {{csrf_field()}}
                                <div class="row clearfix">
                                   
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label>{{__('message.email')}}</label>
                                        <input type="email" name="email" placeholder="{{__('message.Enter Email')}}" required="">
                                    </div>
                                   
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn-one">{{__('message.Forgot Password')}}<i class="icon-Arrow-Right"></i></button>
                                    </div>
                                </div>
                            </form>
                           
                        </div>
                    </div>
                </div>
            </div>
        </section>
 
@stop
@section('footer')
@stop