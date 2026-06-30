@extends('front.layout')
@section('title')
 {{__("message.Service")}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('service')}}"/>
<meta property="og:title" content="{{__('message.Service')}}"/>
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
<?php 
    $sharp70 = asset('public/front/Docpro/assets/images/shape/shape-70.png');
    $sharp71 = asset('public/front/Docpro/assets/images/shape/shape-71.png');
?>
<section class="page-title-two">
            <div class="title-box centred bg-color-2">
                <div class="pattern-layer">
                    <div class="pattern-1" style="background-image: url('{{$sharp70}}');"></div>
                    <div class="pattern-2" style="background-image: url('{{$sharp71}}');"></div>
                </div>
                <div class="auto-container">
                    <div class="title">
                        <h1>{{__("message.Service")}}</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__("message.Home")}}</a></li>
                        <li> {{__("message.Service")}}</li>
                    </ul>
                </div>
            </div>
        </section>
   <section class="process-style-two bg-color-3 centred">
            <div class="pattern-layer">
                <?php 
                        $sharp39 = asset('public/front/Docpro/assets/images/shape/shape-39.png');
                        $sharp40 = asset('public/front/Docpro/assets/images/shape/shape-40.png');
                        $sharp41 = asset('public/front/Docpro/assets/images/shape/shape-41.png');
                        $sharp42 = asset('public/front/Docpro/assets/images/shape/shape-42.png');
                        $arrow1 = asset('public/front/Docpro/assets/images/icons/arrow-1.png');
                        $sharp54 = asset('public/front/Docpro/assets/images/shape/shape-54.png');
                        
                ?>
                <div class="pattern-1" style="background-image: url('{{$sharp39}}');"></div>
                <div class="pattern-2" style="background-image: url('{{$sharp40}}');"></div>
                <div class="pattern-3" style="background-image: url('{{$sharp41}}');"></div>
                <div class="pattern-4" style="background-image: url('{{$sharp42}}');"></div>
            </div>
            <div class="auto-container">
                <div class="sec-title centred">
                    <p>Process</p>
                    <h2>Test Process</h2>
                </div>
                <div class="inner-content">
                    <div class="arrow" style="background-image: url('{{$arrow1}}');"></div>
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                            <div class="processing-block-two">
                                <div class="inner-box">
                                    <figure class="icon-box"><img src="{{asset('public/front/Docpro/assets/images/icons/icon-9.png')}}" alt=""></figure>
                                    <h3>Search Best Online Test</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                            <div class="processing-block-two">
                                <div class="inner-box">
                                    <figure class="icon-box"><img src="{{asset('public/front/Docpro/assets/images/icons/icon-10.png')}}" alt=""></figure>
                                    <h3>View Test Profile</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                            <div class="processing-block-two">
                                <div class="inner-box">
                                    <figure class="icon-box"><img src="{{asset('public/front/Docpro/assets/images/icons/icon-11.png')}}" alt=""></figure>
                                    <h3>Get Instant Book Test</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="faq-section pt-125">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-12 col-sm-12 image-column">
                        <div class="image_block_4">
                            <div class="image-box">
                                <div class="pattern" style="background-image: url('{{$sharp54}}');"></div>
                                <figure class="image"><img src="{{asset('public/front/Docpro/assets/images/resource/faq-1.png')}}" alt=""></figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                        <div class="content_block_5">
                            <div class="content-box">
                                <div class="sec-title">
                                    <p>Faq’s</p>
                                    <h2>Frequently Asked Questions.</h2>
                                </div>
                                <ul class="accordion-box">
                                    <li class="accordion block">
                                        <div class="acc-btn">
                                            <div class="icon-outer"></div>
                                            <h4>How can I book a blood test?</h4>
                                        </div>
                                        <div class="acc-content">
                                            <div class="text">
                                                <p>You can easily book a blood test by visiting our website, calling our customer care number, or visiting our diagnostic center. Simply select the test you need, choose a convenient time, and complete the booking.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="accordion block active-block">
                                        <div class="acc-btn active">
                                            <div class="icon-outer"></div>
                                            <h4>Do I need a doctor’s prescription to book a blood test?</h4>
                                        </div>
                                        <div class="acc-content current">
                                            <div class="text">
                                                <p>While a prescription is not always necessary, we recommend consulting your doctor to ensure you book the appropriate tests.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="accordion block">
                                         <div class="acc-btn">
                                            <div class="icon-outer"></div>
                                            <h4>Can I book a home sample collection for my blood test?</h4>
                                        </div>
                                        <div class="acc-content">
                                            <div class="text">
                                                <p>Yes, we offer home sample collection services for your convenience. During booking, select the home collection option and provide your address. Our phlebotomist will come to your location at the scheduled time.</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
         <section class="testimonial-style-two bg-color-3">
            <div class="pattern-layer">
               <?php 
                  $sharp55 = asset('public/front/Docpro/assets/images/shape/shape-55.png');
                  $sharp56 = asset('public/front/Docpro/assets/images/shape/shape-56.png');
                  $sharp57 = asset('public/front/Docpro/assets/images/shape/shape-57.png');
                  $sharp58 = asset('public/front/Docpro/assets/images/shape/shape-58.png');
                  $sharp59 = asset('public/front/Docpro/assets/images/shape/shape-59.png');
                  ?>
               <div class="pattern-1" style="background-image: url('{{$sharp55}}');"></div>
               <div class="pattern-2" style="background-image: url('{{$sharp56}}');"></div>
               <div class="pattern-3" style="background-image: url('{{$sharp57}}');"></div>
               <div class="pattern-4" style="background-image: url('{{$sharp58}}');"></div>
               <div class="pattern-5" style="background-image: url('{{$sharp59}}');"></div>
            </div>
            <div class="auto-container">
               <div class="sec-title centred">
                  <p></p>
                  <h2>{{__('message.Customers Review')}}</h2>
               </div>
               <div class="three-item-carousel owl-carousel owl-theme owl-nav-none">
                  @foreach($data_feedback as $df)
                  <div class="testimonial-block-two">
                     <div class="inner-box">
                        <div class="text">
                           <p>{{ \Illuminate\Support\Str::limit($df->description,55, $end='...') }}</p>
                        </div>
                        @if(isset($df->userdata->name))
                        <div class="author-info">
                           <figure class="author-thumb"><img src="{{asset('storage/app/public/profile').'/'.$df->userdata->profile_pic}}" alt="" style="height:50px;"></figure>
                           <h4>{{$df->userdata->name}}</h4>
                           <span class="designation"></span>
                        </div>
                        @endif
                     </div>
                  </div>
                @endforeach
               </div>
            </div>
         </section>
@stop
@section('footer')
<script type="text/javascript">
   <?php
         if($setting->is_rtl==1){
   ?>
         $('.brand-carousel').owlCarousel({
               loop:true,
               rtl:true,
               margin:10,
               autoplay:true,
               responsive:{
                 0:{
                   items:1
                 },
                 600:{
                   items:3
                 },
                 1000:{
                   items:4
                 }
               }
             })
         
      <?php }else{?>
         $('.brand-carousel').owlCarousel({
               loop:true,
             
               margin:10,
               autoplay:true,
               responsive:{
                 0:{
                   items:1
                 },
                 600:{
                   items:3
                 },
                 1000:{
                   items:4
                 }
               }
             })
   <?php }?>
      </script>
@stop