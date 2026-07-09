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

<!-- Premium Hero -->
<section class="about-hero-section reveal">
  <div class="about-hero-bg" aria-hidden="true">
    <span class="about-hero-blob about-hero-blob-1"></span>
    <span class="about-hero-blob about-hero-blob-2"></span>
    <span class="about-hero-pattern"></span>
  </div>
  <div class="auto-container">
    <nav class="about-hero-breadcrumb" aria-label="Breadcrumb">
      <a href="{{route('home')}}">{{__('message.Home')}}</a>
      <i data-lucide="chevron-right"></i>
      <span>{{$title}}</span>
    </nav>
    <div class="about-hero-content">
      <div class="about-section-badge">
        <span class="about-section-badge-icon"><i data-lucide="heart-handshake"></i></span>
        <span>{{ $title }} {{__('message.site_name')}}</span>
      </div>
      <h1 class="about-hero-title">{{ $title }}</h1>
    </div>
  </div>
</section>

<section class="about-main-section reveal">
  <div class="auto-container">

    <!-- Intro -->
    <div class="about-intro-card">
      <p class="about-tagline">
        Healthcare should not begin at the hospital. It should begin at home.  At <span class="about-highlight">369 HealthDex</span>, we are not just building a healthcare platform —
        we are leading a movement to transform how India experiences health.
      </p>
      <p>In a world where people often wait for illness before taking action, we stand for something radically different:</p>
        <ul class="about-dot-list">
          <li>Prevention before prescription</li>
          <li>Guidance before diagnosis</li>
          <li>Care before crisis</li>
        </ul>
      <p>Our belief is simple yet powerful — every family deserves a trusted health partner.</p>
    </div>

    <!-- Our Purpose -->
    <div class="about-content-block">
      <div class="about-section-header">
        <div class="about-section-title-wrapper">
          <h2 class="about-section-title"><i data-lucide="target" class="about-section-title-icon"></i>Our Purpose</h2>
        </div>
      </div>
      <div class="about-prose">
        <p>India is home to over a billion dreams. But those dreams can only thrive when the nation is healthy. Lifestyle disorders, delayed diagnoses, rising medical costs, and confusing health choices
        have created a system where people react to disease rather than prevent it.</p>
        <p><strong>369 HealthDex</strong> was created to change that story.</p>
        <p>We exist to empower every individual and every family with:</p>
        <ul class="about-dot-list">
          <li>Early health insights</li>
          <li>Affordable diagnostics</li>
          <li>Personal health guidance</li>
          <li>Science-backed wellness</li>
          <li>Technology-driven convenience</li>
        </ul>
        <p>Because true wealth is not measured in currency —
        it is measured in energy, longevity, and quality of life.</p>
      </div>
    </div>

    <!-- What Makes Us Different -->
    <div class="about-content-block">
      <div class="about-section-header">
        <div class="about-section-title-wrapper">
          <h2 class="about-section-title"><i data-lucide="sparkles" class="about-section-title-icon"></i>What Makes Us Different</h2>
          <p class="about-section-description">We are pioneering a new healthcare model for India — one that blends advanced technology with human compassion.</p>
        </div>
      </div>
      <div class="why-features-grid about-values-grid">
        <div class="why-feature-card">
          <div class="why-feature-icon-wrapper"><i data-lucide="users-round" class="why-feature-icon"></i></div>
          <h4 class="why-feature-title">🔹 Family-First Healthcare</h4>
          <p class="why-feature-description">We don’t see users as transactions. We see families as ecosystems of care.</p>
        </div>
        <div class="why-feature-card">
          <div class="why-feature-icon-wrapper"><i data-lucide="compass" class="why-feature-icon"></i></div>
          <h4 class="why-feature-title">🔹 Your Personal Health Coach</h4>
          <p class="why-feature-description">Imagine having a dedicated health mentor guiding your family toward better choices — every single day.</p>
        </div>
        <div class="why-feature-card">
          <div class="why-feature-icon-wrapper"><i data-lucide="shield-check" class="why-feature-icon"></i></div>
          <h4 class="why-feature-title">🔹 Prevention as a Lifestyle</h4>
          <p class="why-feature-description">Why treat disease when you can stop it before it starts?</p>
        </div>
        <div class="why-feature-card">
          <div class="why-feature-icon-wrapper"><i data-lucide="hand-heart" class="why-feature-icon"></i></div>
          <h4 class="why-feature-title">🔹 Affordable, Ethical Care</h4>
          <p class="why-feature-description">Quality healthcare should never be a privilege. It should be a basic right.</p>
        </div>
        <div class="why-feature-card">
          <div class="why-feature-icon-wrapper"><i data-lucide="cpu" class="why-feature-icon"></i></div>
          <h4 class="why-feature-title">🔹 Tech with a Human Touch</h4>
          <p class="why-feature-description">Our intelligent platform simplifies health decisions while keeping empathy at the center.</p>
        </div>
      </div>
    </div>

    <!-- Our Vision -->
    <div class="about-content-block">
      <div class="about-section-header">
        <div class="about-section-title-wrapper">
          <h2 class="about-section-title"><i data-lucide="eye" class="about-section-title-icon"></i>Our Vision</h2>
        </div>
      </div>
      <div class="about-prose">
        <p>To build a healthier, stronger, disease-aware India — where prevention becomes culture, not a choice.</p>
        <p>We envision a future where:</p>
        <ul class="about-dot-list">
          <li>Families detect risks early</li>
          <li>Chronic diseases decline</li>
          <li>Healthcare becomes proactive</li>
          <li>People live longer, stronger, and happier lives</li>
        </ul>
        <p>A future where healthcare shifts from <strong>“sick care”</strong> to <strong>“self care.”</strong></p>
      </div>
    </div>

    <!-- National Mission -->
    <div class="about-mission-banner">
      <span class="about-mission-pattern" aria-hidden="true"></span>
      <span class="about-mission-icon"><i data-lucide="flag"></i></span>
      <h2 class="about-mission-title">More Than a Platform — A National Health Mission</h2>
      <p class="about-mission-text">369 HealthDex is not just an app. It is a step toward a national transformation. Every test booked, every insight delivered, every family guided —
      brings us closer to a powerful vision:</p>
      <p class="about-mission-highlight">🇮🇳 A Disease-Aware India… and eventually, a Disease-Free India.</p>
    </div>

    <!-- Our Promise -->
    <div class="about-promise-card">
      <span class="about-promise-icon"><i data-lucide="handshake"></i></span>
      <h2 class="about-promise-title">Our Promise</h2>
      <p>We promise to walk beside you — not just when you are unwell,
        but every day you choose to stay well.</p>
      <p>Because your health is not a report. It is your life’s foundation.</p>
      <p>And when families become healthier, India becomes stronger.</p>
    </div>

    <!-- Closing brand statement -->
    <div class="about-closing-brand">
      <h3>369 HealthDex</h3>
      <p>Your Family’s Health Companion.<br>
        Your Preventive Care Partner.<br>
        Your Trusted Guide to Lifelong Wellness.</p>
    </div>

  </div>
</section>

@stop
@section('footer')
@stop
