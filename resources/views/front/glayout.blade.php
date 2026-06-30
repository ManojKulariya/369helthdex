<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>@yield('title')</title>
@yield('meta-data')
<link rel="icon" href="{{asset('public/img').'/'.$setting->favicon}}" type="image/x-icon">
<link

        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"

        rel="stylesheet">
<link

        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"

        rel="stylesheet">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link href="{{asset('public/front/Docpro/assets/css/font-awesome-all.css')}}" rel="stylesheet">
<link href="{{asset('public/front/Docpro/assets/css/flaticon.css')}}" rel="stylesheet">
<link href="{{asset('public/front/Docpro/assets/css/owl.css')}}" rel="stylesheet">
<link href="{{asset('public/front/Docpro/assets/css/bootstrap.css')}}" rel="stylesheet">
<link href="{{asset('public/front/Docpro/assets/css/jquery.fancybox.min.css')}}" rel="stylesheet">
<link href="{{asset('public/front/Docpro/assets/css/animate.css')}}" rel="stylesheet">
<link href="{{asset('public/front/Docpro/assets/css/color.css')}}" rel="stylesheet">
<link href="{{asset('public/front/Docpro/assets/css/nice-select.css')}}" rel="stylesheet">
@if($setting->is_rtl==1)
<link href="{{ asset('public/front/Docpro/assets/css/app-rtl.min.css?v=fvdsjg') }}" rel="stylesheet" />
@else
<link href="{{asset('public/front/Docpro/assets/css/style.css?v=fdsf')}}" rel="stylesheet">
@endif
<link href="{{asset('public/front/Docpro/assets/css/responsive.css')}}" rel="stylesheet">
<link href="{{asset('public/front.css')}}" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
@include('front.cssclass')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">

<!-- Add these links in the <head> section of your HTML file -->

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Google tag (gtag.js) -->

<script async src="https://www.googletagmanager.com/gtag/js?id=G-67TV67XTPF"></script>
<script>

        window.dataLayer = window.dataLayer || [];

        function gtag() { dataLayer.push(arguments); }

        gtag('js', new Date());

        gtag('config', 'G-67TV67XTPF');

    </script>
<style>
.font_aw_icon {
	display: inline-block;
	margin-right: 10px;
}
.locaion_text a {
	display: inline-block;
	vertical-align: top;
	font-size: 13px;
	text-align: left;
	line-height: 18px;
	margin-left: 0px;
	color: #1e4169;
}
.font_aw_icon i {
	background: #1e4169;
	border-radius: 40px;
	width: 32px;
	height: 32px;
	font-size: 19px;
	color: #fff;
	padding: 7px 9px 7px 9px;
}
.rightpanel {
	display: flex;
}
.locaion_text {
	margin-left: 15px;
	display: flex;
	align-items: center
}
.header-top-new {
	padding-top:15px;
	padding-bottom:15px;
}
.top-box label {
	margin-bottom: 0px !important;
	font-weight: bold;
	color: #1e4169;
}
.cart-count {
	position: absolute;
	top: -5px;
	right: 0px;
	font-size: 14px;
	background: #1e4169;
	padding:  2px 6px;
	border-radius: 50%;
	color: #fff;
}
.shoping-cart i {
	font-size: 22px;
}
.top-right-new ul li {
	display: inline-block;
	padding: 0px 10px !important;
}
.main-menu-rdacre .main-menu li {
	padding:0px !important;
}
.header-secoundry-new {
	padding: 10px 0px;
	background: #e45c6d;
}
.header-secoundry-new .main-menu .navigation > li > a {
	color: #fff;
}
.header-secoundry-new .main-menu .navigation > li.current > a, .header-secoundry-new .main-menu .navigation > li:hover > a {
	color: #fff !important;
}
.top-right-new ul li a {
	color: #fff;
}
.header-secoundry-new .main-menu .navigation > li > a:before {
	color:#fff !important;
}
.app_icon {
	display: flex;
}
.app_icon img {
	width: 150px;
	padding: 6px;
}
.why_reliable img {
	max-width: 50px;
	height: auto;
}
.why_reliable .text-heading {
	font-weight: 600;
	line-height: 26px;
	color: #233646;
}
.why_reliable .card {
	text-align: left;
	min-height: 195px;
	margin-bottom: 20px;
}
.pricing-table .table-footer h3 {
	font-size: 18px !important;
}
</style>
</head>
<body>
<div class="boxed_wrapper">
  <div class="preloader"></div>
  <header class="main-header style-two"> 
  <div class="header-top-new">
      <div class="container">
        <div class="row">
          <div class="col-md-2 d-none d-sm-block">
            <figure class="logo"><a href="{{route('home')}}"> <img src="{{asset('public/img').'/'.$setting->logo}}" alt=""></a> </figure>
          </div>
          <div class="col-md-10 d-flex justify-content-end">
            <div class="rightpanel"> @php
              $loctionID = session()->get('loctionID');
              $userLat = session()->get('latitudes');
              
              $cityName = session()->get('cityName');
              if($cityName == ''){
              $cityName='jaipur';
              }
              
              $userLng = session()->get('longitudes');
              if($userLat == ''){
              $userLat = 26.9124;
              $userLng= 75.7873;
              }
              
              $citydata = \App\Models\City::select('*',DB::raw('(6371 * acos(cos(radians(' . $userLat . ')) * cos(radians(lat)) * cos(radians(lng) - radians('. $userLng . ')) + sin(radians(' . $userLat . ')) * sin(radians(lat)))) as distance'))->orderBy('distance', 'asc')->where('default','=','Yes')->get();
              
              $popular_package = \App\Models\Package::whereNull('deleted_at')->take(6)->get();
              @endphp
              <div class="locaion_text top-box"> <span class="font_aw_icon"><i class="fa fa-map-marker"></i></span>
                <?php $i = 0; ?>
                @foreach($citydata as $lab)
                
                
                
                @if($lab->id == session()->get('loctionID'))
                <?php $i = 2; ?>
                <a href="javascript:void(0)" onclick="openCityModal()">
                <label>Your Location</label>
                {{$lab->city}}</a> @endif      
                @endforeach
                
                @if($i == 0) <a href="javascript:void(0)" onclick="openCityModal()">
                <label>Your Location</label>
                {{$citydata[0]['city']}}</a> @endif</div>
              <div class="locaion_text top-box"> <span class="font_aw_icon"><i class="fa fa-user"></i></span> @if(Auth::id()) <a href="{{route('dashboard')}}">{{__('message.My Account')}}</a> @else <a href="{{route('user-login')}}">{{__('message.Sign In')}}</a> @endif </div>
              <div class="locaion_text top-box"> <span class="font_aw_icon"><i class="fa fa-phone"></i></span> <a onclick="openCityModal()">
                <label>Customer Support </label>
                +91-9828112340</a> </div>
              <div class="locaion_text top-box shoping-cart"> <a href="{{route('checkout')}}"><i class="fa fa-shopping-cart"></i>
                <div class="cart-count">
                  <?php $cartCollection = Cart::getContent(); ?>
                  {{isset($totalcartmember)?$totalcartmember:''}}</div>
                </a> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div class="header-lower">
    <div class="outer-container">
      <div class="outer-box">
        <div class="logo-box">
          <figure class="logo"><a href="{{route('home')}}"><img

                                            src="{{asset('public/img').'/'.$setting->logo}}" alt=""></a></figure>
        </div>
        <div class="menu-area">
          <div class="mobile-nav-toggler"> <i class="icon-bar"></i> <i class="icon-bar"></i> <i class="icon-bar"></i> </div>
          <nav class="main-menu navbar-expand-md navbar-light">
            <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
              <ul class="navigation clearfix">
                <li class="<?= Session::get("active_menu") == 1 ? 'current' : '' ?>"><a

                                                    href="{{route('home')}}">{{__('message.Home')}}</a></li>
                <li class="<?= Session::get("active_menu") == 11 ? 'current' : '' ?>"><a

                                                    href="{{route('popular-blood-tests',['city'=>$cityName])}}">Popular
                  
                  Test</a></li>
                <li class=" <?= Session::get("active_menu") == 4 ? 'current' : '' ?>"> <a href="{{route('popular-packages',['city'=>$cityName])}}">{{__('message.Popular Package')}}</a> </li>
                <li class="<?= Session::get("active_menu") == 5 ? 'current' : '' ?>"> <a href="{{route('lifestyle-disorder',['city'=>$cityName])}}">{{__('Lifestyle
                  
                  Disorder')}}</a> </li>
                <li class="<?= Session::get("active_menu") == 6 ? 'current' : '' ?>"><a

                                                    href="{{route('contact-us')}}">{{__('message.Contact Us')}}</a></li>
              </ul>
            </div>
          </nav>
        </div>
        @if(Auth::id())
        <div class="btn-box">{{auth()->user()->name}}</div>
        @else
        <div class="btn-box"><a href="{{route('user-register')}}" class="theme-btn-one"><i

                                        class="icon-image"></i>{{__('Register Now')}}</a></div>
        @endif </div>
    </div>
  </div>
  <div class="sticky-header">
    <div class="auto-container">
      <div class="outer-box">
        <div class="logo-box">
          <figure class="logo"><a href="{{route('home')}}"><img

                                            src="{{asset('public/img').'/'.$setting->logo}}" alt=""></a></figure>
        </div>
        <div class="menu-area">
          <nav class="main-menu clearfix"> </nav>
        </div>
        <div class="btn-box"><a href="{{route('user-register')}}" class="theme-btn-one"><i

                                        class="icon-image"></i>{{__('message.Register Now')}}</a></div>
      </div>
    </div>
  </div>
  </header>
  <div class="mobile-menu">
    <div class="menu-backdrop"></div>
    <div class="close-btn"><i class="fas fa-times"></i></div>
    <nav class="menu-box">
      <div class="nav-logo"><a href="#"><img src="{{asset('public/img').'/'.$setting->footer_logo}}" alt=""

                            title=""></a></div>
      <div class="menu-outer"> </div>
      <div class="contact-info">
        <h4>{{__('message.Contact Info')}}</h4>
        <ul>
          <li>{{$setting->address}}</li>
          <li><a href="javascript::void(0)">{{$setting->phone}}</a></li>
          <li><a href="javascript::void(0)">{{$setting->email}}</a></li>
        </ul>
      </div>
      <div class="social-links">
        <ul class="clearfix">
          <li><a href="https://twitter.com/rdccare" target="_blank"><span

                                    class="fab fa-twitter"></span></a></li>
          <li><a href="https://www.facebook.com/rdccare" target="_blank"><span

                                    class="fab fa-facebook-square"></span></a></li>
          <li><a href="https://www.linkedin.com/company/reliable-diagnostic-centre-private-limited/"

                                target="_blank"><span class="fab fa-linkedin"></span></a></li>
          <li><a href="https://www.instagram.com/rdccare"><span class="fab fa-instagram"

                                    target="_blank"></span></a></li>
        </ul>
      </div>
    </nav>
  </div>
  
  @yield('content')
  <section class="agent-section newsletter" style="display:none;">
    <div class="auto-container">
      <div class="inner-container bg-color-2">
        <div class="row clearfix">
          <div class="col-lg-6 col-md-12 col-sm-12 left-column">
            <div class="content_block_3">
              <div class="content-box">
                <h3>{{__('message.Emergency call')}}</h3>
                <div class="support-box">
                  <div class="icon-box"><i class="fas fa-phone"></i></div>
                  <span>{{__('message.Telephone')}}</span>
                  <h3><a href="javascript::void(0)">{{$setting->phone}}</a></h3>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-12 col-sm-12 right-column">
            <div class="content_block_4">
              <div class="content-box">
                <h3>{{__('message.Sign up for Email')}}</h3>
                <form action="#" method="post" class="subscribe-form">
                  <div class="form-group">
                    <input type="email" name="email" id="emailnews"

                                                placeholder="{{__('message.Enter Email')}}" required="">
                    <button type="button" onclick="addnewsletter()"

                                                class="theme-btn-one">{{__('message.Submit now')}}<i

                                                    class="icon-Arrow-Right"></i></button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer class="main-footer">
    <div class="footer-top">
      <div class="auto-container">
        <div class="inner-box clearfix">
          <div class="row">
            <div class="col-12 copyright pull-left" style="display: flex; align-items: center;">
              <p style="color:#FFFFFF"><b>{{__("message.Our_Presence")}} </b> </p>
              <hr style="border-color: #FFFFFF; flex-grow: 1;">
            </div>
          </div>
          <div id="our_presence"></div>
          <div class="inner-box clearfix">
            <div class="row">
              <div class="col-12 copyright pull-left" style="display: flex; align-items: center;">
                <p style="color:#FFFFFF"><b>{{__("message.Browse_Popular_Blood_Tests")}} </b> </p>
                <hr style="border-color: #FFFFFF; flex-grow: 1;">
              </div>
            </div>
            <div id="Browse_Popular_Blood_Tests"></div>
          </div>
          <div class="inner-box clearfix">
            <div class="row">
              <div class="col-12 copyright pull-left" style="display: flex; align-items: center;">
                <p style="color:#FFFFFF"><b>{{__("message.Browse_Popular_Blood_Packages")}} </b> </p>
                <hr style="border-color: #FFFFFF; flex-grow: 1;">
              </div>
            </div>
            <div id="Browse_Popular_Blood_Packages"></div>
          </div>
          <div class="inner-box clearfix">
            <div class="row">
              <div class="col-12 copyright pull-left" style="display: flex; align-items: center;">
                <p style="color:#FFFFFF"><b>{{__("message.Browse_Tests_by_Lifestyl_Disorder")}} </b> </p>
                <hr style="border-color: #FFFFFF; flex-grow: 1;">
              </div>
            </div>
            <div id="Browse_Tests_by_Lifestyl_Disorder"></div>
          </div>
        </div>
      </div>
      <div class="pattern-layer">
        <?php

                    $sharp30 = asset('public/front/Docpro/assets/images/shape/shape-30.png');

                    $sharp31 = asset('public/front/Docpro/assets/images/shape/shape-31.png');

                    ?>
        <div class="pattern-1" style="background-image: url('{{$sharp30}}');"></div>
        <div class="pattern-2" style="background-image: url('{{$sharp31}}');"></div>
      </div>
      <div class="auto-container">
        <div class="widget-section">
          <div class="row clearfix">
            <div class="col-lg-4 col-md-6 col-sm-12 footer-column">
              <div class="footer-widget logo-widget">
                <figure class="footer-logo"> <a href="#"><img src="{{asset('public/img').'/'.$setting->footer_logo}}" alt=""></a> </figure>
                <div class="text">
                  <p>{{__('message.footer text')}}</p>
                </div>
              </div>
              <p style="font-size:18px;font-weight:bold;margin-top:20px;color:#fff;">Download App</p>
              <ul class="app_icon">
                <li><a href="https://apps.apple.com/in/app/reliable-laboratory/id6467195854" target="_blank"><img src="https://rdccare.com/public/img/App_Store.png"></a></li>
                <li><a href="" target="_blank"><img src="https://rdccare.com/public/img/google-play.png"></a></li>
              </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
              <div class="footer-widget links-widget">
                <div class="widget-title">
                  <h3>{{__('message.Useful Links')}}</h3>
                </div>
                <div class="widget-content">
                  <ul class="links clearfix">
                    <li><a href="{{route('aboutus')}}">{{__('message.About Us')}}</a></li>
                    <li><a href="{{route('blog')}}">Blog</a></li>
                    <li><a href="{{route('career')}}">Careers</a></li>
                    <li><a href="{{route('service')}}">{{__('message.Our Services')}}</a></li>
                    <li><a href="{{route('contact-us')}}">{{__('message.Contact Us')}}</a></li>
                    <li><a href="{{url('/#download_app')}}">{{__('message.Download apps')}}</a></li>
                    <li><a href="{{route('feedback')}}">Feedback/Complaints</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
              <div class="footer-widget links-widget">
                <div class="widget-title">
                  <h3>Patients</h3>
                </div>
                <div class="widget-content">
                  <ul class="links clearfix">
                    <li><a href="{{route('popular-blood-tests',['city'=>$cityName])}}">Popular Blood Tests</a></li>
                    <li><a href="{{route('popular-packages',['city'=>$cityName])}}">{{__('message.Popular Package')}}</a></li>
                    <li><a href="{{route('nearest_center')}}">Nearest Centre</a></li>
                    <li><a href="">Download Report</a></li>
                    <li><a href="{{route('promotion_discount')}}">Promotion & Discounts</a></li>
                    <li><a href="">How to Book a Tests</a></li>
                    @if(Auth::id())
                    <li><a href="{{route('dashboard')}}">{{__('message.My Account')}}</a></li>
                    <li><a href="{{route('home_visit')}}">{{__('message.Home')}} Visit</a></li>
                    <li><a href="{{route('checkout')}}">{{__('message.CheckOut')}}</a></li>
                    @else
                    <li><a href="{{route('user-login')}}">{{__('message.Sign In')}}</a></li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-12 footer-column">
              <div class="footer-widget contact-widget">
                <div class="widget-title">
                  <h3>{{__('message.Contacts')}}</h3>
                </div>
                <div class="widget-content">
                  <ul class="info-list clearfix">
                    <li><i class="fas fa-map-marker-alt"></i> {{$setting->address}} </li>
                    <li><i class="fas fa-microphone"></i> <a href="javascript::void(0)">{{$setting->phone}}</a> </li>
                    <li><i class="fas fa-envelope"></i> <a href="javascript::void(0)">{{$setting->email}}</a> </li>
                  </ul>
                </div>
                <div class="footer_social_links">
                  <p style="font-size:18px;font-weight:bold;margin-top:20px;color:#fff;">Follow Us</p>
                  <ul class="clearfix">
                    <li><a href="https://twitter.com/rdccare" target="_blank"><span class="fab fa-twitter"></span></a></li>
                    <li><a href="https://www.facebook.com/rdccare" target="_blank"><span class="fab fa-facebook-square"></span></a></li>
                    <li><a href="https://www.linkedin.com/company/reliable-diagnostic-centre-private-limited/"
target="_blank"><span class="fab fa-linkedin"></span></a></li>
                    <li><a href="https://www.instagram.com/rdccare"><span class="fab fa-instagram" target="_blank"></span></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="auto-container">
        <div class="inner-box clearfix">
          <div class="copyright pull-left">
            <p><a href="https://www.rdccare.com">{{__("message.site_name")}}</a> &copy; {{date('Y')}} {{__("message.All Right Reserved")}}</p>
           
          </div>
          <ul class="footer-nav pull-right clearfix">
            <li><a href="{{route('refund_policy')}}">Refund Policy</a></li>
            <li><a href="{{route('Terms_of_Service')}}">{{__("message.Terms of Service")}}</a></li>
            <li><a href="{{route('Privacy_Policy')}}">{{__("message.Privacy Policy")}}</a></li>
            <li><a href="{{route('franchise')}}">Franchise</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container">
    <div class="row"> 
    	<div class="col-12">
        <div class="sticky-bar">
    	<!--<a href="tel:+919828112340" class="phone-button"> <i class="fa fa-phone"></i> +91-9828112340 </a>-->
      <div>
      	<a href="#" class="request-button" id="request-button"> Get a call back from our Health Advisor
 </a> @if(Session::has('messagecall'))
        <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show"

                        role="alert">{{ Session::get('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        </div>
        @endif </div>
      <!--<div class="social-icons"> 
      <a href="https://api.whatsapp.com/send?phone=919828112340" target="_blank" rel="nofollow">
      <i class="fa fa-whatsapp" aria-hidden="true"></i>Talk with Health Advisor</a> </div></div>-->
    </div>
  </div>
</div>
  </footer>
  <!--<button class="scroll-top scroll-to-target" data-target="html"> <span class="fa fa-arrow-up"></span> </button>-->
</div>
<div class="floating-whatsapp-a">
    <a aria-label="whatsapp" href="https://wa.me/919828112340?text=hi">
       <img src="https://rdccare.com/public/img/whatsapp.png"/>
    </a>
</div>
<div class="modal" id="addaddress">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="member_list"> 
      
      <!-- Modal Header -->
      
      <div class="modal-header">
        <h4 class="modal-title">{{__("message.Select Member")}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      
      <div class="modal-body" id="memeber_list">
      <form action="{{route('add-cart-member')}}" method="post" id="user_address"

                        class="registration-form boxed">
        {{csrf_field()}}
        <input type="hidden" name="type" id="book_type" value="">
        <input type="hidden" name="type_id" id="book_type_id" value="">
        <input type="hidden" name="mrp" id="book_mrp" value="">
        <input type="hidden" name="price" id="book_price" value="">
        <input type="hidden" name="parameter" id="book_parameter" value="">
        <div id="member_list_div"> @if(isset($member_list))
          
          @foreach($member_list as $ml)
          <input type="checkbox" id="member_{{$ml->id}}" name="member[]" value="{{$ml->id}}"

                                class="check">
          <label for="member_{{$ml->id}}">
          {{$ml->name}}</br>
          <p>{{$ml->relation}}</p>
          <p>{{$ml->gender}} | {{$ml->age}}</p>
          </label>
          @endforeach
          
          @endif </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="address_submit_button" onclick="closecontent('member_list','add_member')"

                        class="btn btn-success">{{__("message.Add Member")}}</button>
          <button type="submit" id="address_submit_button" class="btn btn-success">{{__("message.Book Now")}}</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">{{__("message.Close")}}</button>
        </div>
      </form>
    </div>
    <div class="modal-content " id="add_member" style="display: none;"> 
      
      <!-- Modal Header -->
      
      <div class="modal-header">
        <h4 class="modal-title">{{__("message.Add New Family Member")}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="#" method="post" id="member_form" class="registration-form">
        
        <!-- Modal body -->
        
        <div class="modal-body">
          <div class="row clearfix">
            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
              <label>{{__("message.Relation")}}<span class="error">*</span></label>
              <select class="form-control" name="relation" id="relation" required="">
                <option value="">{{__("message.Select Relation")}}</option>
                
                <!--<option value="Self">{{__("message.Self")}}</option>-->
                
                <option value="Spouse">{{__("message.Spouse")}}</option>
                <option value="Child">{{__("message.Child")}}</option>
                <option value="Parent">{{__("message.Parent")}}</option>
                <option value="Grand Parent">{{__("message.Grand Parent")}}</option>
                <option value="Sibling">{{__("message.Sibling")}}</option>
                <option value="Friend">{{__("message.Friend")}}</option>
                <option value="Relative">{{__("message.Relative")}}</option>
                <option value="Neighbour">{{__("message.Neighbour")}}</option>
                <option value="Colleague">{{__("message.Colleague")}}</option>
                <option value="Others">{{__("message.Others")}}</option>
              </select>
              <span id="error_relation" class="error"></span> </div>
            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
              <label>{{__("message.Name")}}<span class="error">*</span></label>
              <input type="text" name="name" id="member_name"

                                    placeholder="{{__('message.Enter Name')}}" required="">
              <span id="error_name" class="error"></span> </div>
            <div class="col-lg-4 col-md-12 col-sm-12 form-group">
              <label>{{__("message.email")}}<span class="error">*</span></label>
              <input type="email" name="email" id="member_email"

                                    placeholder="{{__('message.Enter Email')}}" required="">
              <span id="error_email" class="error"></span> </div>
            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
              <label>{{__("message.Phone")}}<span class="error">*</span></label>
              <input type="text" name="phone" id="member_phone"

                                    placeholder="{{__('message.Enter Phone')}}" required="">
              <span id="error_phone" class="error"></span> </div>
            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
              <label>{{__("message.Age")}}<span class="error">*</span></label>
              <input type="number" name="age" id="member_age"

                                    placeholder="{{__('message.Enter Age')}}" required="">
              <span id="error_age" class="error"></span> </div>
            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
              <label>{{__("message.DOB")}}<span class="error">*</span></label>
              <input type="date" name="dob" id="member_dob" required="">
              <span id="error_dob" class="error"></span> </div>
            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
              <label>{{__("message.Gender")}}<span class="error">*</span></label>
              <div class="custom-check-box">
                <div class="custom-controls-stacked">
                  <label class="custom-control material-checkbox">
                    <input type="radio" name="gender" id="gender_1" value="Male"

                                                class="material-control-input">
                    <span class="material-control-indicator"></span> <span class="description">{{__("message.Male")}}</span> </label>
                </div>
              </div>
              <div class="custom-check-box">
                <div class="custom-controls-stacked">
                  <label class="custom-control material-checkbox">
                    <input type="radio" name="gender" id="gender_2" value="Female"

                                                class="material-control-input">
                    <span class="material-control-indicator"></span> <span class="description">{{__("message.Female")}}</span> </label>
                </div>
              </div>
              <span id="error_gender" class="error"></span> </div>
          </div>
        </div>
        
        <!-- Modal footer -->
        
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="addmemberdata()">{{__("message.Add Member")}}</button>
          <button type="button" class="btn btn-success"

                            onclick="closecontent('add_member','member_list')">{{__("message.Back to list")}}</button>
          <button type="button" class="btn btn-danger"

                            data-dismiss="modal">{{__("message.Close")}}</button>
        </div>
      </form>
    </div>
  </div>
</div>
<input type="hidden" id="url_path" value="{{url('/')}}">
<input type="hidden" name="password_match_error" id="password_match_error"

        value="{{__('message.Password and Confirm Password Must Be Same')}}">
<input type="hidden" name="package_add_cart" id="package_add_cart"

        value="{{__('message.Package Add Into Cart Successfully')}}">
<input type="hidden" name="email_enter_error" id="email_enter_error"

        value="{{__('message.Please Enter Your Email')}}">
<input type="hidden" name="thanks_msg" id="thanks_msg" value="{{__('message.Thank you for getting in touch!')}}">
<input type="hidden" name="email_invalid_err" id="email_invalid_err" value="{{__('message.Email Id Is Invaild')}}">
<input type="hidden" name="delete_member_err" id="delete_member_err"

        value="{{__('message.Are You Sure Want To Delete This Member')}}?">
<input type="hidden" name="delete_address_err" id="delete_address_err"

        value="{{__('message.Are You Sure Want To Delete This Address')}}?">
<input type="hidden" name="currect_pass_err" id="currect_pass_err"

        value="{{__('message.Please Enter Correct Currect Password')}}">
<input type="hidden" name="new_con_pass_err" id="new_con_pass_err"

        value="{{__('message.New Password And Re-enter Password Must Be Same')}}">
<script type="text/javascript"

        src='https://maps.google.com/maps/api/js?key={{Config::get("mapdetail.key")}}&sensor=false&libraries=places'></script> 
<script src="https://code.jquery.com/jquery-3.6.0.js"></script> 
<script src="{{asset('public/front/Docpro/assets/js/jquery.js')}}"></script> 
<script src="{{asset('public/front/Docpro/assets/js/popper.min.js')}}"></script> 
<script src="{{asset('public/front/Docpro/assets/js/bootstrap.min.js')}}"></script> 
<script src="{{asset('public/front/Docpro/assets/js/owl.js')}}"></script> 
<script src="{{asset('public/front/Docpro/assets/js/wow.js')}}"></script> 
<script src="{{asset('public/front/Docpro/assets/js/validation.js')}}"></script> 
<script src="{{asset('public/front/Docpro/assets/js/jquery.fancybox.js')}}"></script> 
<script src="{{asset('public/front/Docpro/assets/js/appear.js')}}"></script> 
<script src="{{asset('public/front/Docpro/assets/js/scrollbar.js')}}"></script> 
<script src="{{asset('public/front/Docpro/assets/js/tilt.jquery.js')}}"></script> 
<script src="{{asset('public/front/Docpro/assets/js/jquery.paroller.min.js')}}"></script> 
<script src="{{asset('public/front/Docpro/assets/js/jquery.nice-select.js')}}"></script> 
@if($setting->is_rtl==1) 
<script src="{{asset('public/front/Docpro/assets/js/script_rtl.js')}}"></script> 
@else 
<script src="{{asset('public/front/Docpro/assets/js/script.js')}}"></script> 
@endif 
<script src="{{asset('public/locationpicker.js')}}"></script> 
<script type="text/javascript"

        src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.0/sweetalert.min.js"></script> 
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script> 
<script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script> 
<script src="{{asset('public/front.js')}}"></script>

  
<div class="popup" id="popup">
  <div class="popup-content"> <span class="close-popup" id="close-popup">&times;</span>
    <h2>Request a Callback</h2>
    <form action="{{route('save_callback')}}" method="post" id="callback-form">
      @csrf
      <div class="form-group">
        <input type="text" placeholder="Name" name="name" required>
      </div>
      <div class="form-group">
        <input type="tel" placeholder="Phone Number" name="number" required>
      </div>
      <div class="form-group">
        <textarea placeholder="Message" name="message"></textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="submit-button">Submit</button>
      </div>
    </form>
  </div>
</div>
<!--<div class="icon-bar"> <a href="https://www.facebook.com/rdccare" class="facebook" target="_blank"><i class="fa fa-facebook"></i></a> <a href="https://twitter.com/rdccare" class="twitter" target="_blank"><i class="fa fa-twitter"></i></a> <a href="https://www.instagram.com/rdccare" class="google" target="_blank"><i class="fa fa-instagram"></i></a> <a href="https://www.linkedin.com/company/reliable-diagnostic-centre-private-limited/" class="linkedin"

            target="_blank"><i class="fa fa-linkedin"></i></a> </div>-->
<script>

        document.getElementById("request-button").addEventListener("click", function () {

            document.getElementById("popup").style.display = "block";

        });



        document.getElementById("close-popup").addEventListener("click", function () {

            document.getElementById("popup").style.display = "none";

        });



        document.getElementById("popup").addEventListener("click", function (event) {

            if (event.target === this) {

                document.getElementById("popup").style.display = "none";

            }

        });



        function showmember(id, mrp, price, parameter, type) {

            // alert(parameter);

            $("#book_type_id").val(id);

            $("#book_mrp").val(mrp);

            $("#book_price").val(price);

            $("#book_parameter").val(parameter);

            $("#book_type").val(type);

        }

        $(document).on('click', '#link', function (e) {

            swal({

                title: "Please Login Your Account",

                text: "",

                type: "warning",

                confirmButtonText: "Login",

                showCancelButton: true

            })

                .then((result) => {

                    if (result.value) {

                        window.location = $("#url_path").val() + '/login';

                    } else if (result.dismiss === 'cancel') {

                        swal(

                            'Cancelled',

                            'Your stay here :)',

                            'error'

                        )

                    }

                })

        });



        function closecontent(close, open) {

            $("#" + close).css("display", "none");

            $("#" + open).css("display", "block");

        }



        function addmemberdata() {

            var relation = $("#relation").val();

            var name = $("#member_name").val();

            var email = $("#member_email").val();

            var phone = $("#member_phone").val();

            var age = $("#member_age").val();

            var dob = $("#member_dob").val();

            var gender = $('input[name=gender]:checked').val();

            var msg = "";

            if (relation == "") {

                $("#error_relation").html("Please Select Relation");

                msg = 1;

            }

            if (name == "") {

                $("#error_name").html("Please Add Member Name");

                msg = 1;

            }

            if (email == "") {

                $("#error_email").html("Please Enter Your Email");

                msg = 1;

            } else {

                if (!validateEmail(email)) {

                    $("#error_email").html("Please Enter Vaild Email");

                    msg = 1;

                }

            }

            if (phone == "") {

                $("#error_phone").html("Please Enter Phone no");

                msg = 1;

            }

            if (age == "") {

                $("#error_age").html("Please Enter Member Age");

                msg = 1;

            }

            if ($("#dob").val() == "") {

                $("#error_dob").html("Please Enter DOB");

                msg = 1;

            }

            if (gender == "") {

                $("#error_gender").html("Please Select Gender");

                msg = 1;

            }



            if (msg == "") {

                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });

                $.ajax({

                    url: $("#url_path").val() + '/save_member_detail',

                    method: 'post',

                    data: $('#member_form').serialize(),

                    success: function (response) {

                        $("#relation").val("");

                        $("#member_name").val("");

                        $("#member_email").val("");

                        $("#member_phone").val("");

                        $("#member_age").val("");

                        $("#member_dob").val("");

                        $("#error_relation").html("");

                        $("#error_name").html("");

                        $("#error_email").html("");

                        $("#error_phone").html("");

                        $("#error_age").html("");

                        $("#error_dob").html("");

                        $("#error_gender").html("");

                        $("#gender").attr("checked", true);

                        $("#gender").attr("checked", false);

                        var txt = ' <input type="checkbox" id="member_' + response + '" name="member[]" value="' + response + '"><label for="member_' + response + '">' + name + '</br> <p>' + relation + '</p><p>' + gender + ' | ' + age + '</p></label>';

                        $("#member_list_div").append(txt);

                        $("#add_member").css("display", "none");

                        $("#member_list").css("display", "block");



                    }

                });

            }

        }



    </script> 
<script>

        // Check if geolocation is available in the browser

        if (navigator.geolocation) {

            // Get the user's current location

            navigator.geolocation.getCurrentPosition(

                function (position) {

                    // Get the latitude and longitude values

                    const latitude = position.coords.latitude;

                    const longitude = position.coords.longitude;



                    // Make an AJAX request to store the lat and long in session

                    const queryString = `latitude=${latitude}&longitude=${longitude}`;

                    const url = `/update-location?${queryString}`;



                    fetch(url, {

                        method: 'GET'

                    })

                        .then(response => response.json())

                        .then(data => {

                           

                        })

                        .catch(error => {

                            console.error('Failed to update location:', error);

                        });

                },

                function (error) {

                    console.error('Error getting location:', error);

                }

            );

        } else {

            console.error('Geolocation is not available in this browser.');

        }

    </script> 
@yield('footer')
</body>
</html>