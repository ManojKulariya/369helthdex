@extends('front.layout')
@section('title')
   {{__('message.Contact Us')}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('contact-us')}}"/>
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
            <!--<div class="title-box centred bg-color-2">
                <div class="pattern-layer">
                   <?php 
                          $sharp70 = asset('public/front/Docpro/assets/images/shape/shape-70.png');
                          $sharp71 = asset('public/front/Docpro/assets/images/shape/shape-71.png');
                    ?>
                    <div class="pattern-1" style="background-image: url('{{$sharp70}}');"></div>
                    <div class="pattern-2" style="background-image: url('{{$sharp71}}');"></div>
                </div>
                <div class="auto-container">
                    <div class="title">
                        <h1>{{__('message.Contact Us')}}</h1>
                    </div>
                </div>
            </div>-->
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                        <li> {{__('message.Contact Us')}}</li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="information-section sec-pad centred bg-color-3">
            <div class="pattern-layer">
                 <?php 
                          $sharp87 = asset('public/front/Docpro/assets/images/shape/shape-87.png');
                          $sharp88 = asset('public/front/Docpro/assets/images/shape/shape-88.png');
                          $sharp89 = asset('public/front/Docpro/assets/images/shape/shape-89.png');
                          $sharp90 = asset('public/front/Docpro/assets/images/shape/shape-90.png');
                    ?>
                <div class="pattern-1" style="background-image: url('{{$sharp88}}');"></div>
                <div class="pattern-2" style="background-image: url('{{$sharp89}}');"></div>
            </div>
            <div class="auto-container">
                <div class="sec-title centred">
                    <p>{{__('message.Information')}}</p>
                    <h2>{{__('message.Get In Touch')}}</h2>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-6 col-sm-12 information-column">
                        <div class="single-information-block wow fadeInUp animated animated animated" data-wow-delay="00ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
                            <div class="inner-box">
                                <div class="pattern" style="background-image: url('{{$sharp87}}');"></div>
                                <figure class="icon-box"><img src="{{asset('public/front/Docpro/assets/images/icons/icon-20.png')}}" alt=""></figure>
                                <h3>{{__('message.Email Address')}}</h3>
                                <p>
                                    <a href="javascript::void(0)">{{$setting->email}}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 information-column">
                        <div class="single-information-block wow fadeInUp animated animated animated" data-wow-delay="300ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 300ms; animation-name: fadeInUp;">
                            <div class="inner-box">
                                <div class="pattern" style="background-image: url('{{$sharp87}}');"></div>
                                <figure class="icon-box"><img src="{{asset('public/front/Docpro/assets/images/icons/icon-21.png')}}" alt=""></figure>
                                <h3>{{__('message.Phone Number')}}</h3>
                                <p>
                                    <a href="javascript::void(0)">{{$setting->phone}}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 information-column">
                        <div class="single-information-block wow fadeInUp animated animated animated" data-wow-delay="600ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 600ms; animation-name: fadeInUp;">
                            <div class="inner-box">
                                <div class="pattern" style="background-image: url('{{$sharp87}}');"></div>
                                <figure class="icon-box"><img src="{{asset('public/front/Docpro/assets/images/icons/icon-22.png')}}" alt=""></figure>
                                <h3>{{__('message.Address')}}</h3>
                                <p>
                                   {{$setting->address}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
          <section class="contact-section">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-12 col-sm-12 form-column">
                        <div class="form-inner">
                            <div class="sec-title">
                                <p>{{__('message.Contact')}}</p>
                                <h2>{{__('message.Contact Us')}}</h2>
                            </div>
                             @if(Session::has('message'))
                                 <div class="col-sm-12">
                                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                       <span aria-hidden="true">&times;</span></button>
                                    </div>
                                 </div>
                                 @endif
                            <form method="post" action="{{route('save-contact')}}" id="contact-form" class="default-form"> 
                                 {{csrf_field()}}
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <input type="text" name="name" placeholder="{{__('message.Your name')}}" required="">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <input type="email" name="email" placeholder="{{__('message.Your email')}}" required="">
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                                        <input type="text" name="phone" required="" placeholder="{{__('message.Phone number')}}">
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                                        <input type="text" name="subject" required="" placeholder="{{__('message.Subject')}}">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <textarea name="message" placeholder="{{__('message.Your Message ...')}}"></textarea>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button class="theme-btn-one" type="submit" name="submit-form">{{__('message.Send Message')}}<i class="icon-Arrow-Right"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 map-column">
                        <div class="image_block_3">
                            <div class="image-box">
                                <div class="pattern">
                                       <?php 
                                            $sharp49 = asset('public/front/Docpro/assets/images/shape/shape-49.png');
                                            $sharp50 = asset('public/front/Docpro/assets/images/shape/shape-50.png');
                                        ?>
                                    <div class="pattern-1" style="background-image: url('{{$sharp49}}');"></div>
                                    <div class="pattern-2" style="background-image: url('{{$sharp50}}');"></div>
                                    <div class="pattern-3"></div>
                                </div>
                                <figure class="image image-1 paroller" style="transform: translateY(33px); transition: transform 0.6s cubic-bezier(0, 0, 0, 1) 0s; will-change: transform;"><img src="{{asset('public/front/Docpro/assets/images/resource/about-4.jpg')}}" alt=""></figure>
                                <figure class="image image-2 paroller-2" style="transform: translateY(-39px); transition: transform 0.6s cubic-bezier(0, 0, 0, 1) 0s; will-change: transform;"><img src="{{asset('public/front/Docpro/assets/images/resource/about-3.jpg')}}" alt=""></figure>
                                <div class="image-content">
                                    <figure class="icon-box"><img src="{{asset('public/front/Docpro/assets/images/icons/icon-8.png')}}" alt=""></figure>
                                    <span>{{__('message.Contact With')}}</span>
                                    <h4>{{__('message.Us')}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@stop
@section('footer')
@stop