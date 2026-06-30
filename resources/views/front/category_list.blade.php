@extends('front.layout')

@section('title')

 Book Blood Tests For Heart, Liver, diabetes, Cancer, Fever, Pregnancy

@stop

<?php 

$cityName = ucfirst(session()->get('cityName'));

 if($cityName == ''){

     $cityName='jaipur';

 }

?>

@section('meta-data')

<link rel="canonical" href="{{ url()->current() }}">

<meta name="description" content="Book Tests for @foreach($subcategory as $row){{$row->name}}, @endforeach Check Symptoms, Causes, Price"/>

<meta name="keywords" content="@foreach($subcategory as $row){{$row->name}}, @endforeach Tests in {{$cityName}} "/>

<meta name="robots" content="index, follow" />

<meta property="og:type" content="website"/>

<meta property="og:url" content="{{ url()->current() }}"/>

<meta property="og:title" content="Book Blood Tests For Heart, Liver, diabetes, Cancer, Fever, Pregnancy"/>

<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}"/>

<meta property="og:image:width" content="250px"/>

<meta property="og:image:height" content="250px"/>

<meta property="og:site_name" content="{{__('message.site_name')}}"/>

<meta property="og:description" content="Book Tests for @foreach($subcategory as $row){{$row->name}}, @endforeach Check Symptoms, Causes, Price"/>

<meta property="og:keyword" content="@foreach($subcategory as $row){{$row->name}}, @endforeach Tests in {{$cityName}} "/>

<link rel="shortcut icon" href="{{asset('public/img/').'/'.$setting->favicon}}">

<meta name="viewport" content="width=device-width, initial-scale=1">

@stop

@section('content')

<section class="page-title-two">

          

            <div class="lower-content">

                <div class="auto-container">

                    <ul class="bread-crumb clearfix">

                        <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>

                        <li>{{__('message.Browse by')}}  {{__('Lifestyle Disorder')}}</li>

                    </ul>

                </div>

            </div>

        </section>

        <section class="doctor-details bg-color-3 pt-4" >

   <div class="auto-container" style="margin-bottom:-10%">
              <div class="row clearfix">

         <div class="col-lg-12 col-md-12 col-sm-12 content-side">

            <div class="clinic-details-content doctor-details-content">

                 <div class="clinic-block-one">
                  <div class="inner-box" style="padding: 34px 34px 37px 34px !important;">

                      <div class="row">

                          <div class="col-12">

                              <div class="content-box">

                                    <ul class="name-box clearfix">

                                       <li class="name">

                                          <h2 id="package_name">Book Blood Tests For Heart, Liver, diabetes, Cancer, Fever, Pregnancy</h2>

                                       </li>

                                    </ul>

                                    <div class="text">

                                       <p>Book Tests for @foreach($subcategory as $row){{$row->name}}, @endforeach Check Symptoms, Causes, Price</p>

                                    </div>

                                    

                                 </div>

                          </div>

                      </div>

                     

                  </div>

               </div>

                </div>

                 </div>

                  </div>

                  </div>

                <!---->

        </section>

<section class="centred sec-pad" style="background: #F5F5F5;">


            <div class="auto-container">

              

               <div class="inner-content">

                  <div class="row clearfix">

                        @foreach($subcategory as $c)

                           <div class="col-lg-3 col-md-6 col-sm-12 category-block">

                              <div class="category-block-one wow fadeInUp animated animated" data-wow-delay="00ms" data-wow-duration="1500ms">

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

                           </div>

                      

                        @endforeach

                    

                  </div>

               </div>

            </div>

         </section>
         
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
                            @if($cn->page_name == "Lifestyle-Disorder")
                            <div class="content-box">
                             <ul class="name-box clearfix">
                               <li class="name">
                                 <h3>{{ $cn->name }}</h3>
                               </li>
                             </ul>
                             <div class="text">
                                @php
                            $description = COMMAN::replace($cn->description,$cityName) ;
                         @endphp
                       <p>{!! $description !!}</p>
                             </div>
                           </div>
                           @endif
                           @endforeach
                           
                         </div>
                         
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

@stop