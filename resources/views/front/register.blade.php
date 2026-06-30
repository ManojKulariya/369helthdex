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
<section class="page-title-two">
            <div class="title-box centred bg-color-2">
                <div class="pattern-layer">
                    <div class="pattern-1" style="background-image: url(assets/images/shape/shape-70.png);"></div>
                    <div class="pattern-2" style="background-image: url(assets/images/shape/shape-71.png);"></div>
                </div>
                <div class="auto-container">
                    <div class="title">
                        <h1>{{__("message.Register")}}</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__("message.Home")}}</a></li>
                        <li>{{__("message.Register")}}</li>
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
                            <h3>{{__("message.User Register")}}</h3>
                            <a href="{{route('user-login')}}">{{__("message.Already User")}}?</a>
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
                            <form action="{{route('post-user-register')}}" method="post" class="registration-form">
                                {{csrf_field()}}
                                <div class="row clearfix">
                                   <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                                        <label>{{__("message.Name")}}</label>
                                        <input type="text" name="name" id="name" placeholder="{{__('message.Enter Name')}}" required="">
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                                        <label>Mobile</label>
                                        <input type="text" name="phone" id="name" placeholder="Enter Mobile" required="">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label>{{__("message.email")}}</label>
                                        <input type="email" name="email" id="email" placeholder="{{__('message.Enter Email')}}" required="">
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                                        <label>Date of Birth</label>
                                        <input type="date" name="d_o_b" id="name" placeholder="Enter Date Of Birth" required="">
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                                        <label>Age</label>
                                        <input type="text" name="age" id="name" placeholder="Enter Age" required="">
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                                        <label>Gender</label>
                                        <select name="sex">
                                            <option value='Male'>Male</option>
                                             <option value='Male'>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label>{{__("message.password")}}</label>
                                        <input type="password" name="password" id="password" placeholder="{{__('message.Enter Password')}}" required="">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label>{{__("message.Confirm Password")}}</label>
                                        <input type="password" name="cpassword" id="cpassword" placeholder="{{__('message.Confirm Password')}}" required="" onchange="checkconfirmpassword(this.value)">
                                    </div>
                                    
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
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
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn-one">{{__("message.Register")}}<i class="icon-Arrow-Right"></i></button>
                                    </div>
                                </div>
                            </form>
                            <div class="login-now"><p>{{__("message.Already have an account")}}? <a href="{{route('user-login')}}">{{__("message.Login Now")}}</a></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
 
@stop
@section('footer')
@stop