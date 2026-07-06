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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')
<style>
    .dot-list li {
    position: relative;
    padding-left: 16px;
    margin-bottom: 8px;
}

.dot-list li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 10px;
    width: 6px;
    height: 6px;
    background: #1b7f6b;
    border-radius: 50%;
}

</style>
<section class="page-title-two">
            <div class="title-box centred bg-color-2">
                <div class="pattern-layer">
                    <?php 
                          $sharp70 = asset('public/front/Docpro/assets/images/shape/shape-70.png');
                          $sharp71 = asset('public/front/Docpro/assets/images/shape/shape-71.png');
                          $sharp49 = asset('public/front/Docpro/assets/images/shape/shape-49.png');
                          $sharp50 = asset('public/front/Docpro/assets/images/shape/shape-50.png');
                          $sharp54 = asset('public/front/Docpro/assets/images/shape/shape-54.png');
                    ?>
                    <div class="pattern-1" style="background-image: url('{{$sharp70}}');"></div>
                    <div class="pattern-2" style="background-image: url('{{$sharp71}}');"></div>
                </div>
                <div class="auto-container">
                    <div class="title">
                        <h1>{{ $title }}</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                        <li>{{$title}}</li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="about-style-two">
            <div class="auto-container">
                <div class="row align-items-center clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 content-column">
                        <div class="content_block_1">
                            <div class="content-box mr-50">
                                <div class="sec-title">
                                    <p>{{ $title }} {{__('message.site_name')}}</p>
                                    <h2>{{ $title }}</h2>
                                </div>
                                <div class="text">
                                    <p class="tagline">
        Healthcare should not begin at the hospital. It should begin at home.  At <span class="highlight">369 HealthDex</span>, we are not just building a healthcare platform —
        we are leading a movement to transform how India experiences health.
    </p>

    <p>
        In a world where people often wait for illness before taking action, we stand for something radically different:
    </p>

    <ul class="list-unstyled dot-list">
    <li>Prevention before prescription</li>
    <li>Guidance before diagnosis</li>
    <li>Care before crisis</li>
</ul>


    <p>
        Our belief is simple yet powerful — every family deserves a trusted health partner.
    </p>

    <h2>Our Purpose</h2>

    <p>
        India is home to over a billion dreams. But those dreams can only thrive when the nation is healthy. Lifestyle disorders, delayed diagnoses, rising medical costs, and confusing health choices
        have created a system where people react to disease rather than prevent it.
    </p>

    <p>
        <strong>369 HealthDex</strong> was created to change that story.
    </p>

    <p>We exist to empower every individual and every family with:</p>

    <ul class="list-unstyled dot-list">
        <li> Early health insights</li>
        <li> Affordable diagnostics</li>
        <li> Personal health guidance</li>
        <li> Science-backed wellness</li>
        <li> Technology-driven convenience</li>
    </ul>

    <p>
        Because true wealth is not measured in currency —
        it is measured in energy, longevity, and quality of life.
    </p>

    <h2>What Makes Us Different</h2>

    <p>
        We are pioneering a new healthcare model for India — one that blends advanced technology with human compassion.
    </p>

    <ul>
        <li><strong>🔹 Family-First Healthcare</strong> We don’t see users as transactions. We see families as ecosystems of care.
        </li>

        <li><strong>🔹 Your Personal Health Coach</strong> Imagine having a dedicated health mentor guiding your family toward better choices — every single day.
        </li>

        <li><strong>🔹 Prevention as a Lifestyle</strong> Why treat disease when you can stop it before it starts?
        </li>

        <li><strong>🔹 Affordable, Ethical Care</strong> Quality healthcare should never be a privilege. It should be a basic right.
        </li>

        <li><strong>🔹 Tech with a Human Touch</strong> Our intelligent platform simplifies health decisions while keeping empathy at the center.
        </li>
    </ul>

    <h2>Our Vision</h2>

    <p>
        To build a healthier, stronger, disease-aware India — where prevention becomes culture, not a choice.
    </p>

    <p>We envision a future where:</p>

    <ul class="list-unstyled dot-list">
        <li>Families detect risks early</li>
        <li>Chronic diseases decline</li>
        <li>Healthcare becomes proactive</li>
        <li>People live longer, stronger, and happier lives</li>
    </ul>

    <p>
        A future where healthcare shifts from <strong>“sick care”</strong> to <strong>“self care.”</strong>
    </p>

    <h2>More Than a Platform — A National Health Mission</h2>

    <p>
        369 HealthDex is not just an app. It is a step toward a national transformation. Every test booked, every insight delivered, every family guided —
        brings us closer to a powerful vision:
    </p>

    <p class="highlight">
        🇮🇳 A Disease-Aware India… and eventually, a Disease-Free India.
    </p>

    <div class="promise">
        <h2>Our Promise</h2>

        <p>
            We promise to walk beside you — not just when you are unwell,
            but every day you choose to stay well.
        </p>

        <p>
            Because your health is not a report. It is your life’s foundation.
        </p>

        <p>
            And when families become healthier, India becomes stronger.
        </p>
    </div>

    <div class="footer-brand">
        <h3> 369 HealthDex</h3>
        <p>
            Your Family’s Health Companion.<br>
            Your Preventive Care Partner.<br>
            Your Trusted Guide to Lifelong Wellness.
        </p>
   

                                </div>
                                
                                   
                            
                                <!--<div class="btn-box"><a href="{{route('aboutus')}}" class="theme-btn-one">About Us<i class="icon-Arrow-Right"></i></a></div>-->
                            </div>
                        </div>
                    </div>
                    <!--<div class="col-lg-6 col-md-12 col-sm-12 image-column">-->
                    <!--    <div class="image_block_3">-->
                    <!--        <div class="image-box">-->
                    <!--            <div class="pattern">-->
                    <!--                <div class="pattern-1" style="background-image: url('{{$sharp49}}');"></div>-->
                    <!--                <div class="pattern-2" style="background-image: url('{{$sharp50}}');"></div>-->
                    <!--                <div class="pattern-3"></div>-->
                    <!--            </div>-->
                    <!--            <figure class="image image-1 paroller" style="transform: unset; transition: transform 0.6s cubic-bezier(0, 0, 0, 1) 0s; will-change: transform;"><img src="{{asset('public/front/Docpro/assets/images/resource/about-4.jpg')}}" alt=""></figure>-->
                    <!--            <figure class="image image-2 paroller-2" style="transform: unset; transition: transform 0.6s cubic-bezier(0, 0, 0, 1) 0s; will-change: transform;"><img src="{{asset('public/front/Docpro/assets/images/resource/about-3.jpg')}}" alt=""></figure>-->
                              
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
            </div>
        </section>
 
@stop
@section('footer')
@stop