@extends('front.layout')

@section('title')

{{__('message.title_home')}}

@stop

@section('meta-data')
<?php $res_curr = explode("-", $setting->currency); ?>
<link rel="canonical" href="{{route('home')}}">
<meta name="description" content="{{__('message.meta_description_home')}}">
<meta name="keywords" content="{{__('message.meta_keyword_home')}}">
<meta name="robots" content="index, follow" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{route('home')}}" />
<meta property="og:title" content="{{__('message.title_home')}}" />
<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}" />
<meta property="og:image:width" content="250px" />
<meta property="og:image:height" content="250px" />
<meta property="og:site_name" content="{{__('message.site_name')}}" />
<meta property="og:description" content="{{__('message.meta_description_home')}}" />
<meta property="og:keyword" content="{{__('message.meta_keyword_home')}}" />
<link rel="shortcut icon" href="{{asset('public/img/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop

@section('content')

@php

$imagePaths = unserialize($setting->main_banner);

$search_banner = asset('public/img') . '/' . $setting->search_banner;

$cityName = ucfirst(session()->get('cityName'));

if ($cityName == '') {

    $cityName = 'Jaipur';

}

@endphp
<section class="banner-section">
  <div class="container-fluid">
    <div class="row  col-12 mx-0 pt-3 pb-3">
      <div class="col-lg-7 col-md-7 col-12">
          <h4><p style="color:white;font-weight: 600;" class="pb-3">Search for test & packages</p></h4>
          <!-- Search Bar -->
          <form action="{{ route('search') }}" method="get" class="w-100">
            {{ csrf_field() }}
            
            <div class="input-group position-relative">
                
                <span class="position-absolute" style="z-index: 10;left: 12px; top: 50%; transform: translateY(-50%); color: black; font-size: 16px;">
                    <i class="fas fa-search"></i>
                </span>
              <input type="text" name="tags" class="form-control" id="tags" placeholder="Search Packages, Parameters" style="padding-left: 35px;" required>
              <div class="input-group-append">
                <button class="btn px-3" style="background-color:#e6ae05;color:white;" type="submit">Search</button>
              </div>
            </div>
          </form>
          <!-- Buttons -->
          <div class="row mt-3">
            <div class="col-6 mx-0 pr-1">
              <a href="{{route('Upload_Prescription')}}" class="custom-btn w-100 py-3">
                <!--<i class="fa fa-heart"></i>-->
                <i class="fa fa-file"></i>
                Upload Prescription
              </a>
            </div>
            <div class="col-6 mx-0 pl-1">
              <a href="{{route('download-report')}}" class="custom-btn w-100 py-3">
                <i class="fa fa-download"></i> Download Reports
              </a>
            </div>
          </div>
      </div> 

      <!-- Second Column for Iage (Visible only on lg and md screens) -->
      <div class="col-lg-5 col-md-5 d-none d-md-block">
        <img src="{{ asset('public/bannerbg.png') }}" alt="Side Banner" style="width:100%;height:auto;" class="img-fluid w-100">
      </div> 

    </div> <!-- row -->
  </div> <!-- container -->
</section>


<section class="life_style_section alternat-2 centred d-none">
  <div class="auto-container">
    
    <div class="row col-12 mb-4" >
        <div class="col-md-6 pl-0" style="text-align:left">
            <h4 class="newstyle" >{{__('Tests by Lifestyle Disorder')}}</h4>
        </div>
        <div class="col-md-6 d-none d-md-block">
            <div class="custom-swiper-nav">
                <button class="swiper-button-prev btn-pre"><i class="fa fa-chevron-right"></i></button>
                <button class="swiper-button-next btn-next"><i class="fa fa-chevron-left"></i></button>
            </div>
        </div>
    </div>
    
    <div class="inner-content">
      <div class="row clearfix">
        <div class="swiper mySwiper">
          <div class="swiper-wrapper section-padding">
            @foreach($category as $c)
            <div class="swiper-slide">
              <a href="{{ route('lifestyledisorder', ['city'=>$cityName, 'slug' => $c->slug]) }}">
                <div class="single-logo">
                  <div class="category-block-one">
                    <div class="inner-box d-flex align-items-center justify-content-center p-3">
                      <figure class="mb-0 me-1">
                        <img src="{{asset('storage/app/public/Subcategory').'/'.$c->image}}" style="width: 40px; height: 40px;" alt="">
                      </figure>
                      <h6 class="mb-0 ml-2"><h7>{{$c->name}}</h7></h6>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="pricing-section bg-color-3 pt-5">
  <div class="auto-container">
    <div class="sec-title">
        <h4 class="newstyle">Top Health Packages</h4>
        <div class="custom-swiper-nav">
          <a href="{{route('popular-packages',['city'=>$cityName])}}" style="color:#1F3E6D;">View All</a>
          <button class="packageswiper-button-prev btn-pre d-none d-md-block"><i class="fa fa-chevron-left"></i></button>
          <button class="packageswiper-button-next btn-next d-none d-md-block"><i class="fa fa-chevron-right"></i></button>
        </div>
    </div>
  </div>

  <div class="tabs-box px-2">
    <div class="tabs-content">
      <div class="tab active-tab" id="tab-1">
        <div class="swiper packageSwiper">
          <div class="swiper-wrapper">
            @foreach($data_popular as $pl)
              <?php 
                $discount = 0;
                if($pl->price > 0 ){
                  $discount = 100 * ($pl->price - $pl->mrp) / $pl->price;
                }
              ?>
              <div class="swiper-slide category-block">
                @include('front.card')
              </div>
            @endforeach
          </div>
          <!-- Pagination for mobile -->
          <div class="swiper-pagination d-md-none" style="position: relative !important;  margin-top: -10px; text-align: center;"></div>
        </div>
      </div>
    </div>
  </div>
</section>

  @include('front.how_book')
<!---------------------------------test--------------------->

<section class="pricing-section bg-color-3 pt-5">
  <div class="auto-container">
    <div class="sec-title">
      <h4 class="newstyle">Popular Tests</h4>
      
      <div class="custom-swiper-nav">
        <a href="{{route('popular-blood-tests',['city'=>$cityName])}}" class="mr-2" style="color:#1F3E6D;"> View All</a>
        <button class="testswiper-button-prev btn-pre d-none d-md-block"><i class="fa fa-chevron-left"></i></button>
        <button class="testswiper-button-next btn-next d-none d-md-block"><i class="fa fa-chevron-right"></i></button>
      </div>
    </div>
  </div>

  <div class="tabs-box px-2">
    <div class="tabs-content">
      <div class="tab active-tab" id="tab-1">
        <div class="swiper testSwiper">
          <div class="swiper-wrapper">
            @foreach($test as $pl)
              <?php 
                $discount = 0;
                if($pl->price > 0 ){
                  $discount = 100 * ($pl->price - $pl->mrp) / $pl->price;
                }
              ?>
              <div class="swiper-slide category-block">
                @include('front.card_test')
              </div>
            @endforeach
          </div>
          <!-- Pagination for mobile -->
          <div class="swiper-pagination d-md-none" style="position: relative !important;  margin-top: -10px; text-align: center;"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!------------------------------end test-------------------->

<section class="cta-section alternat-2 bg-color-2" id="download_app">

  <div class="auto-container">
    <div class="row align-items-center clearfix">
      <div class="col-lg-6 col-md-12 col-sm-12 content-column">
        <div class="content_block_2">
          <div class="content-box py-2">
            <div class="sec-title light">
                <div>
                    <p>{{__('message.Download apps')}}</p>
                    <h2>{{__('Download HealthDex Centre App Now')}}</h2>
                </div>
            </div>
            <div class="text">
              <p>Book HealthDex Centre Health Tests and access your smart reports and health  trackers anytime anywhere. Now available on both Google Play Store and App Store.</p>
            </div>
          
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6 d-flex justify-content-center">
        <div class="image-box wow fadeInUp animated animated" data-wow-delay="00ms" data-wow-duration="1500ms">
            <figure class="image">
                <a href="{{$setting->appstore_url}}" target="_blank">
                    <img src="https://rdccare.com/public/img/App_Store.png"></a>
            </figure>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6 d-flex justify-content-center">
        <div class="image-box wow fadeInUp animated animated" data-wow-delay="00ms" data-wow-duration="1500ms">
          <figure class="image">
              <a href="{{$setting->playstore_url}}" target="_blank">
                  <img src="https://rdccare.com/public/img/google-play.png">
                </a>
          </figure>
        </div>
      </div>
    </div>
  </div>
</section>

<!----------------------- Why Pathkind Labs ----------------->
 @include('front.why_rdc')

<section class="process-style-two alternat-2 centred">
  <div class="auto-container">
    <div class="sec-title" >
      <h4 class="newstyle">Our Offers</h4>
      <div class="custom-swiper-nav d-none d-md-block" >
        <button class="offerSwiper-button-prev btn-pre"><i class="fa fa-chevron-left"></i></button>
        <button class="offerSwiper-button-next btn-next"><i class="fa fa-chevron-right"></i></button>
      </div>
    </div>
    <div class="inner-content">
      <div class="swiper offerSwiper">
        <div class="swiper-wrapper">
          @foreach($offer as $c)
          <div class="swiper-slide">
            <div class="category-block">
              <img src="{{asset('storage/app/public/category').'/'.$c->image}}" width="100%" alt="">
            </div>
          </div>
          @endforeach
        </div>
        <!-- Pagination for mobile -->
        <div class="swiper-pagination d-md-none"></div>
      </div>
    </div>
  </div> 
</section>

<section class="testimonial-style-two">
  <div class="auto-container">
    <div class="sec-title">
      <h4 class="newstyle">Our {{ count($lab) }}+ Labs Network</h4>
      <div class="custom-swiper-nav">
        <button class="labSwiper-button-prev btn-pre d-none d-md-block"><i class="fa fa-chevron-left"></i></button>
        <button class="labSwiper-button-next btn-next d-none d-md-block"><i class="fa fa-chevron-right"></i></button>
      </div>
    </div>
    <div class="swiper labSwiper">
      <div class="swiper-wrapper">
        @foreach($lab as $df)
          <div class="swiper-slide">
            @include('front.centercard')
          </div>
        @endforeach 
      </div>
      
      <div class="swiper-pagination d-md-none " style="position: relative !important;  margin-top: 15px; text-align: center;"></div>
    </div>
  </div>
</section>
@include('front.blogcard')


@if(isset($contentdata) && !empty($contentdata))
    <section class="doctor-details bg-color-3" style="margin-top:-5%">
        <div class="auto-container" style="margin-bottom:-10%">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                    <div class="clinic-details-content doctor-details-content">
                        <div class="clinic-block-one">
                            <div class="inner-box" style="padding: 34px 40px 37px 34px !important;">
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach($contentdata as $cn)
                                            @if($cn->page_name == "Home")
                                                <div class="content-box">
                                                    <ul class="name-box clearfix">
                                                        <li class="name">
                                                            <h3>{{ $cn->name }}</h3>
                                                        </li>
                                                    </ul>
                                                    <div class="text content-collapse">
                                                        <div class="descriptiontxt">
                                                            <p>{!! $cn->description !!}</p>
                                                            <p style="font-size: 4px;">Powered By: <a title="Web Development Company in Ahmedabad" href="https://www.icreators.in/web-development-company-in-ahmedabad">Web Development Company in Ahmedabad</a>, <a href="https://www.icreators.in/web-design-company-in-ahmedabad">Web Design Company in Ahmedabad</a>,<a href="https://www.icreators.in/seo-company-in-ahmedabad">Seo Company in Ahmedabad</a>. Design By: <a href="https://www.icreators.in/web-design-company-in-jaipur">Web Design Company in Jaipur</a>, <a href="https://www.icreators.in/web-development-company-in-jaipur">Web Development Company in Jaipur</a>, <a href="https://www.icreators.in/seo-company-in-jaipur">Seo Company in Jaipur</a></p>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="read-more-btn">Read More</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><br>
@endif


@stop

@section('footer') 
<script>

$(document).ready(function () {
    // Show the modal after 5 seconds (first time)
    // setTimeout(function() {
    //     $('#needhelp').modal('show');
    // }, 100000);

});

    document.querySelectorAll('.more-link').forEach(function (link) {

        link.addEventListener('click', function () {

            var parameterList = this.parentElement.querySelector('.list');

            var hiddenItems = parameterList.querySelectorAll('li:not(:nth-child(-n+4))');

            for (var i = 0; i < hiddenItems.length; i++) {

                hiddenItems[i].style.display = 'block';

            }

            this.style.display = 'none';

            this.parentElement.querySelector('.less-link').style.display = 'inline';

        });

    });

    document.querySelectorAll('.less-link').forEach(function (link) {

        link.addEventListener('click', function () {

            var parameterList = this.parentElement.querySelector('.list');

            var hiddenItems = parameterList.querySelectorAll('li:not(:nth-child(-n+4))');



            for (var i = 0; i < hiddenItems.length; i++) {

                hiddenItems[i].style.display = 'none';

            }

            this.style.display = 'none';

            this.parentElement.querySelector('.more-link').style.display = 'inline';

        });

    });

    

    if (navigator.geolocation) {

        // Get the user's current location

        navigator.geolocation.getCurrentPosition(

            function (position) {

                const latitude = position.coords.latitude;

                const longitude = position.coords.longitude;

                const apiEndpoint = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`;



                fetch(apiEndpoint)

                    .then(response => response.json())

                    .then(data => {

                        // Log the city name to the console

                       

                    })

                    .catch(error => {

                        console.error('Failed to get city:', error);

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

@stop