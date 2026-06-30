@extends('front.layout')
@section('title')
    {{ $title }}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('aboutus')}}"/>
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
    .about-21{
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
        border-radius: 5px; /* Rounded corners */
        /*border: 2px solid black; */
        padding:15px;
    }
</style>
<section class="page-title-two">
    
    <div class="lower-content">
        <div class="auto-container">
            <ul class="bread-crumb clearfix">
                <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                <li>{{$title}}</li>
            </ul>
        </div>
    </div>
    <section class="about-main-sec p-2">
        <section class="about-style-two px-4">
            <div class="about-21">
                <h6><strong>NABL ACCREDITED</strong></h6>
                <p style="font-size: 1rem;line-height: 1.2rem;font-size:14px;">
                The accreditation of Reliable Diagnostics by <strong>NABL (ISO 15189)</strong> validates our ability to perform high quality clinical testing and clinical interpretation to international quality standards in every facility that we operate.
                
                </p>
                <h6 class="my-2"><strong>EXPERIENCE CERTIFICATE BY - NWR</strong></h6>
                <p style="font-size: 1rem;line-height: 1.2rem;font-size:14px;">
                <strong>North Western Railway (NWR)</strong> is highly satisfied with Reliable's laboratory services, praising their professionalism and timely delivery
                </p>
            </div>
            <div class="row mt-2">
                <div class="col-md-6 col-lg-6 col-sm-12 centred p-4">
                    <img src="{{asset('public/img/svg/c1.png')}}" style="width:65%;height:auto">
                </div>
                 <div class="col-md-6 col-lg-6 col-sm-12 centred p-4">
                     <img src="{{asset('public/img/svg/c2.png')}}" style="width:65%;height:100%">
                 </div>
                 <div class="col-12 centred mt-5">
                     <img src="{{asset('public/img/svg/c3.png')}}" style="width:380px;height:280px">
                 </div>
                
            </div>
        </section>
    </section>
</section>
@include('front.why_rdc')
@stop
@section('footer')
@stop