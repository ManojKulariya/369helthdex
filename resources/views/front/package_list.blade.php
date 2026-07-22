@extends('front.layout')

@php

$cityName = ucfirst(session()->get('cityName'));

if($cityName == ''){

$cityName='rajkot';

}

@endphp

@section('title')

Book Full Body Health Checkup Packages in {{$cityName}} | Reliable

@stop

@section('meta-data')

<link rel="canonical" href="{{ url()->current() }}">
<meta name="description" content="Book your Entire Full Body Health Checkup test packages online in {{$cityName}} with a home sample collection facility from Reliable Diagnostic Centre at best price.">
<meta name="keywords" content="Full Body Checkup Packages in {{$cityName}}, Health Checkup Packages in {{$cityName}},Entire Body Checkup Packages in {{$cityName}}, Reliable Pathology lab in {{$cityName}}">
<meta name="robots" content="index, follow" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title" content="Book Full Body Health Checkup Packages in {{$cityName}} | Reliable" />
<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}" />
<meta property="og:image:width" content="250px" />
<meta property="og:image:height" content="250px" />
<meta property="og:site_name" content="{{__('message.site_name')}}" />
<meta property="og:description"

    content="Book your Entire Full Body Health Checkup test packages online in {{$cityName}} with a home sample collection facility from Reliable Diagnostic Centre at best price." />
<meta property="og:keyword"

    content="Full Body Checkup Packages in {{$cityName}}, Health Checkup Packages in {{$cityName}},Entire Body Checkup Packages in {{$cityName}}, Reliable Pathology lab in {{$cityName}}" />
<link rel="shortcut icon" href="{{asset('public/img/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop

@section('content')
<section class="page-title-two">
 
  <div class="lower-content" style="padding:0px;">
        <img class="img_gif" src="{{asset('public/front/Docpro/assets/images/banner/1.png')}}" />
  </div>
</section>
<section class="pricing-section bg-color-3 sec-pad">

  <div class="auto-container"> 
        <div class="inner-box" style="padding: 1px 1px 14px 1px !important;">
           <h3 style="color:#0a6c79 !important;">Full Body Health Checkup in {{ucfirst($cityName)}}</h3>
        </div>
    <div class="inner-content">
      <div class="row clearfix"> 
        @foreach($popular_package as $pl)
            <?php
            $discount=0;
            if($pl->price > 0 ){
                $discount = 100 * ($pl->price - $pl->mrp) / $pl->price; 
            }
            ?>
            <div class="col-lg-4 col-md-6 col-sm-12 pricing-block">
            @include('front.card')
            </div>
        @endforeach 
        </div>
    </div>
  </div>
</section>
  @include('front.how_book')
 
@stop

@section('footer') 
@stop