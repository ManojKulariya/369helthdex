@extends('front.layout')
@php 
$cityName = session()->get('cityName');
if($cityName == ''){
$cityName='jaipur';
}
@endphp
@section('title')
Book Test for {{isset($subcategory->name)?$subcategory->name:''}} in {{$cityName}} Check {{isset($subcategory->name)?$subcategory->name:''}} Causes, Symptoms.
@stop

@section('meta-data')
<link rel="canonical" href="{{ url()->current() }}">
 <meta name="description" content="Book Test for {{isset($subcategory->name)?$subcategory->name:''}} in {{$cityName}} at discounted price from Reliable. Check {{isset($subcategory->name)?$subcategory->name:''}} Causes, Symptoms and Treatment. Free Sample Home Collection. Money Back Guarantee.">
 <meta name="keywords" content="{{isset($subcategory->name)?$subcategory->name:''}} test in {{$cityName}}, {{isset($subcategory->name)?$subcategory->name:''}} causes in {{$cityName}}, {{isset($subcategory->name)?$subcategory->name:''}} symptoms, {{isset($subcategory->name)?$subcategory->name:''}} studies test in {{$cityName}},{{isset($subcategory->name)?$subcategory->name:''}} tests in {{$cityName}}, {{isset($subcategory->name)?$subcategory->name:''}} packages in {{$cityName}}">
<meta name="robots" content="index, follow" />
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('service')}}"/>
<meta property="og:title" content="Book Test for {{isset($subcategory->name)?$subcategory->name:''}} in {{$cityName}} Check {{isset($subcategory->name)?$subcategory->name:''}} Causes, Symptoms."/>
<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}"/>
<meta property="og:image:width" content="250px"/>
<meta property="og:image:height" content="250px"/>
<meta property="og:site_name" content="{{__('message.site_name')}}"/>
<meta property="og:description" content="Book Test for {{isset($subcategory->name)?$subcategory->name:''}} in {{$cityName}} at discounted price from Reliable. Check {{isset($subcategory->name)?$subcategory->name:''}} Causes, Symptoms and Treatment. Free Sample Home Collection. Money Back Guarantee."/>
<meta property="og:keyword" content="{{isset($subcategory->name)?$subcategory->name:''}} test in {{$cityName}}, {{isset($subcategory->name)?$subcategory->name:''}} causes in {{$cityName}}, {{isset($subcategory->name)?$subcategory->name:''}} symptoms, {{isset($subcategory->name)?$subcategory->name:''}} studies test in {{$cityName}},{{isset($subcategory->name)?$subcategory->name:''}} tests in {{$cityName}}, {{isset($subcategory->name)?$subcategory->name:''}} packages in {{$cityName}}"/>
<link rel="shortcut icon" href="{{asset('public/img/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')
<?php $res_curr = explode("-",$setting->currency);?>
<section class="page-title-two">
  
   <div class="lower-content">
      <div class="auto-container">
         <ul class="bread-crumb clearfix">
            <li><a href="{{route('home')}}">Home</a></li>
            <li>{{isset($subcategory->name)?$subcategory->name:''}} {{__("message.Detail")}} </li>
         </ul>
      </div>
   </div>
</section>
@if(count($package_list)>0)
<section class="pricing-section bg-color-3 sec-pad">
   <div class="auto-container">
      <div class="tabs-box">
        
         <div class="tabs-content">
            <div class="tab active-tab" id="tab-1">
               <div class="row clearfix">
                  <div class="section-padding owl-carousel" id="packagelist">
                      <?php $discount= 0;?>
                    @foreach($package_list as $pl)
                    <?php 
                        $discount = 0;
                        if($pl['price'] > 0 ){
                          $discount = 100 * ($pl['price'] - $pl['mrp']) / $pl['price'];
                        }
                     ?> 
                     <div class="single-logo">
                        <div class="col-lg-12 col-md-6 col-sm-12 pricing-block">
                           <div class="pricing-block-one">
                             
                                       @if($pl['type']==1)
                                           @include('front.card')
                                       @elseif($pl['type']==3)
                                           @include('front.card_test')
                                       @elseif($pl['type']==2)
                                       
                                       @endif
                                 
                           </div>
                        </div>
                     </div>
                    @endforeach                    
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endif
  @include('front.how_book')
<section class="sidebar-page-container" style="padding: 0px;">
   <div class="auto-container">
      <div class="row clearfix">
         <div class="col-lg-12 col-md-12 col-sm-12 content-side">
            <div class="blog-details-content">
               <div class="news-block-one">
                  <div class="inner-box">
                     <div class="lower-content">
                        <h3>{{isset($subcategory->name)?$subcategory->name:''}} {{__('message.Tests')}}</h3>
                        <p><?= html_entity_decode($subcategory->description)?></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

@stop
@section('footer')
<script>
    <?php if($setting->is_rtl==1){ ?>
   $('#packagelist').owlCarousel({
              loop:true,
              margin:10,
              rtl:true,
              autoplay:true,
              responsive:{
                0:{
                  items:1
                },
                600:{
                  items:3
                },
                1000:{
                  items:3
                }
              }
            })
<?php }else{?>
   $('#packagelist').owlCarousel({
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
                  items:3
                }
              }
            })
<?php }?>
</script>
@stop