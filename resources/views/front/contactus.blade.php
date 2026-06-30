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
<style>
    .single-information-block .inner-box-us {
        /*position: relative;*/
        display: block;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        padding: 56px 30px 49px 30px;
        /*padding:15px;*/
    }

    .form-control-sm {
        height: 35px !important; /* default is ~38px or 45px */
        font-size: 14px;
    }

    textarea.form-control-sm {
        height: auto;
        min-height: 80px; /* optional, just to keep some space */
    }

    .contactsubmit {
        padding: 6px 15px;
        font-size: 14px;
        border: 1px solid #2aa48c;
        color: #2aa48c;
        background-color: white;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .contactsubmit:hover {
        background-color: #2aa48c;
        color: white;
    }

</style>

<section class="page-title-two">
           
    <div class="lower-content">
        <div class="auto-container">
            <ul class="bread-crumb clearfix">
                <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                <li> {{__('message.Contact Us')}}</li>
            </ul>
        </div>
    </div>
</section>
<section class="information-section sec-pad bg-color-3">
    <div class="auto-container">
        <div class="row clearfix">

            <!-- Contact Info Column -->
            <div class="col-lg-6 col-md-6 col-sm-12 information-column">
                <div class="single-information-block wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                    <div class="inner-box-us">
                        <h6>Contact Us</h6>
                        <h4 class="mb-2 mt-2"><strong>{{__('message.site_name')}}</strong></h4>
                        <ul style="padding-left: 0; list-style: none;">
                            <li style="display: flex; align-items: center; margin-bottom: 15px;">
                                 <figure style="margin: 0 10px 0 0;" class="icon-box"><img src="{{asset('public/front/Docpro/assets/images/icons/icon-20.png')}}" style="width:35px;height:35px;" alt=""></figure>
                                 {{$setting->email}}
                            </li>
                            <li style="display: flex; align-items: center; margin-bottom: 15px;">
                                <figure style="margin: 0 10px 0 0;" class="icon-box"><img src="{{asset('public/front/Docpro/assets/images/icons/icon-21.png')}}" style="width:35px;height:35px;"  alt=""></figure>
                                {{$setting->phone}}
                            </li>
                            <!--<li style="display: flex; align-items: center; margin-bottom: 15px;">-->
                            <!--    <figure style="margin: 0 10px 0 0;" class="icon-box"><img src="{{asset('public/front/Docpro/assets/images/icons/icon-22.png')}}" style="width:35px;height:35px;"  alt=""></figure>-->
                                
                            <!--    {{$setting->address}}-->
                            <!--</li>-->
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contact Form Column -->
            <div class="col-lg-6 col-md-6 col-sm-12 information-column">
                <div class="single-information-block wow fadeInUp" data-wow-delay="00ms" data-wow-duration="1500ms">
                    <div class="inner-box-us">
                        <!--<h6>{{__('message.Contact Us')}}</h6>-->
                        @if(Session::has('message'))
                           <div class="col-sm-12">
                              <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span></button>
                              </div>
                           </div>
                           @endif 
                        <h4 class="mb-2"><strong>Send Message</strong></h4>
                        
                        <form method="post" action="{{route('save-contact')}}" id="contact-form" class="default-form">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="text" name="name" placeholder="{{__('message.Your name')}}" required class="form-control form-control-sm">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="email" name="email" placeholder="{{__('message.Your email')}}" required class="form-control form-control-sm">
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                                    <input type="number" name="phone" placeholder="{{__('message.Phone number')}}" required class="form-control form-control-sm">
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                                    <input type="text" name="subject" placeholder="{{__('message.Subject')}}" required class="form-control form-control-sm">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <textarea name="message" placeholder="{{__('message.Your Message ...')}}" class="form-control form-control-sm" rows="1.5"></textarea>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <label>CAPTCHA <span style="color:red;">*</span></label><br>
                                    <img src="{{ url('/custom-captcha') }}" id="captcha-img" alt="CAPTCHA">
                                    <button type="button" onclick="reloadCaptcha()" style="border: none; background: none;color:#EB0401;"><i class="fa fa-repeat"></i></button>
                                    <input type="text" name="captcha_input" class="form-control mt-2" placeholder="Enter CAPTCHA" required>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                    <button class="btn btn-sm contactsubmit" type="submit" name="submit-form">
                                        {{__('message.Send Message')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@stop
@section('footer')
@stop