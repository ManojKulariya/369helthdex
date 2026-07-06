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

<!-- Luxury Hero Section -->
<section class="luxury-hero">
  <div class="luxury-hero-bg" aria-hidden="true">
    <span class="luxury-hero-blob luxury-hero-blob-1"></span>
    <span class="luxury-hero-blob luxury-hero-blob-2"></span>
    <span class="luxury-hero-pattern"></span>
  </div>
  <div class="container">
    <div class="luxury-hero-grid">
      <!-- Left Content -->
      <div class="luxury-hero-content">
        <div class="luxury-hero-badge">
          <span class="luxury-hero-badge-dot"></span>
          <i data-lucide="shield-check"></i>
          NABL Accredited Labs
        </div>

        <h1 class="luxury-hero-title">
          Strong Body.<br>
          <span class="luxury-hero-title-accent">Strong Life.</span>
        </h1>

        <p class="luxury-hero-subtitle">
          Health tests, full body checkups and diagnostics at your doorstep. Book trusted health packages and individual tests with certified laboratories.
        </p>

        <!-- Search Box (functionality preserved) -->
        <form action="{{ route('search') }}" method="get" class="luxury-hero-search-form">
          {{ csrf_field() }}
          <div class="luxury-hero-search">
            <span class="luxury-hero-search-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
              </svg>
            </span>
            <input type="text" name="tags" class="luxury-hero-search-input" placeholder="Search for tests, health packages or checkups…" required>
            <button class="btn btn-primary btn-lg luxury-hero-search-btn" type="submit">
              <span>Search</span>
              <i data-lucide="arrow-right"></i>
            </button>
          </div>
        </form>

        <!-- Feature Cards (functionality preserved) -->
        <div class="luxury-hero-quick-actions">
          <a href="{{route('Upload_Prescription')}}" class="luxury-hero-action-card">
            <span class="luxury-hero-action-icon">
              <i data-lucide="file-text"></i>
            </span>
            <span class="luxury-hero-action-body">
              <span class="luxury-hero-action-title">Upload Prescription</span>
              <span class="luxury-hero-action-desc">Get a tailored package</span>
            </span>
            <i data-lucide="arrow-up-right" class="luxury-hero-action-arrow"></i>
          </a>
          <a href="{{route('download-report')}}" class="luxury-hero-action-card">
            <span class="luxury-hero-action-icon">
              <i data-lucide="download"></i>
            </span>
            <span class="luxury-hero-action-body">
              <span class="luxury-hero-action-title">Download Reports</span>
              <span class="luxury-hero-action-desc">Access your results</span>
            </span>
            <i data-lucide="arrow-up-right" class="luxury-hero-action-arrow"></i>
          </a>
        </div>

      </div>

      <!-- Right Visual -->
      <div class="luxury-hero-visual">
        <div class="luxury-hero-visual-frame" data-hd-parallax="12">
          <img src="{{ asset('public/img/hero-quality-trust.png') }}" alt="Quality diagnostics you can trust — NABL accredited labs, home sample collection and accurate reports" class="luxury-hero-main-image" fetchpriority="high" decoding="async">
        </div>

        <div class="luxury-hero-chip luxury-hero-chip-1" data-hd-parallax="26">
          <span class="luxury-hero-chip-icon"><i data-lucide="shield-check"></i></span>
          <span class="luxury-hero-chip-body">
            <strong>NABL</strong>
            <span>Certified Labs</span>
          </span>
        </div>
        <div class="luxury-hero-chip luxury-hero-chip-2" data-hd-parallax="20">
          <span class="luxury-hero-chip-icon"><i data-lucide="clock"></i></span>
          <span class="luxury-hero-chip-body">
            <strong>24h</strong>
            <span>Fast Reports</span>
          </span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- End Luxury Hero -->

<!-- Premium Packages Section -->
<section class="packages-premium-section reveal">
  <div class="auto-container">
    <!-- Section Header -->
    <div class="packages-section-header">
      <div class="packages-section-title-wrapper">
        <div class="packages-section-badge">
          <span class="packages-section-badge-icon">
            <i data-lucide="check"></i>
          </span>
          <span class="packages-section-badge-text">Health Packages</span>
        </div>
        <h2 class="packages-section-title">Top Health Packages</h2>
        <p class="packages-section-description">Comprehensive health checkup packages at affordable prices with free home collection</p>
      </div>
      
      <!-- Action Group: View All + Navigation -->
      <div class="packages-action-group">
        <a href="{{route('popular-packages',['city'=>$cityName])}}" class="packages-view-all-btn">
          View All Packages
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
          </svg>
        </a>
        <div class="packages-swiper-nav">
          <button class="packages-swiper-btn packageswiper-button-prev" aria-label="Previous packages">
            <i data-lucide="chevron-left"></i>
          </button>
          <button class="packages-swiper-btn packageswiper-button-next" aria-label="Next packages">
            <i data-lucide="chevron-right"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Packages Slider -->
    <div class="packages-slider-wrapper">
      <div class="swiper packageSwiper">
        <div class="swiper-wrapper">
          @foreach($data_popular as $pl)
            @php
              $discount = 0;
              if($pl->price > 0){
                $discount = 100 * ($pl->price - $pl->mrp) / $pl->price;
              }
            @endphp
            <div class="swiper-slide">
              @include('front.card')
            </div>
          @endforeach
        </div>
        <!-- Pagination for mobile -->
        <div class="swiper-pagination packageSwiper-pagination d-md-none"></div>
      </div>
    </div>
  </div>
</section>

<!-- Premium Categories Section -->
@if(isset($category) && count($category) > 0)
<section class="categories-premium-section reveal">
  <div class="auto-container">
    <!-- Section Header -->
    <div class="categories-section-header">
      <div class="categories-section-title-wrapper">
        <div class="categories-section-badge">
          <span class="categories-section-badge-icon">
            <i data-lucide="layout-grid"></i>
          </span>
          <span class="categories-section-badge-text">Health Concerns</span>
        </div>
        <h2 class="categories-section-title">Browse Tests by Health Concern</h2>
        <p class="categories-section-description">Find the right tests for your specific health needs — from lifestyle disorders to preventive care</p>
      </div>

      <div class="categories-action-group">
        <a href="{{ route('lifestyle-disorder', ['city'=>$cityName]) }}" class="categories-view-all-btn">
          View All Concerns
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
          </svg>
        </a>
        <div class="categories-swiper-nav d-none d-md-flex">
          <button class="categories-swiper-btn categorySwiper-button-prev" aria-label="Previous categories">
            <i data-lucide="chevron-left"></i>
          </button>
          <button class="categories-swiper-btn categorySwiper-button-next" aria-label="Next categories">
            <i data-lucide="chevron-right"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Categories Slider -->
    <div class="swiper categorySwiper">
      <div class="swiper-wrapper">
        @foreach($category as $c)
        <div class="swiper-slide">
          <a href="{{ route('lifestyledisorder', ['city'=>$cityName, 'slug' => $c->slug]) }}" class="hd-category-card">
            <span class="hd-category-icon">
              <img src="{{asset('storage/app/public/Subcategory').'/'.$c->image}}" alt="{{$c->name}}" loading="lazy" decoding="async">
            </span>
            <span class="hd-category-name">{{$c->name}}</span>
            <span class="hd-category-link">
              Explore Tests
              <i data-lucide="arrow-right"></i>
            </span>
          </a>
        </div>
        @endforeach
      </div>
      <div class="swiper-pagination categorySwiper-pagination d-md-none"></div>
    </div>
  </div>
</section>
@endif

  @include('front.how_book')

<!-- Premium Tests Section -->
<section class="tests-premium-section reveal">
  <div class="auto-container">
    <!-- Section Header -->
    <div class="tests-section-header">
      <div class="tests-section-title-wrapper">
        <div class="tests-section-badge">
          <span class="tests-section-badge-icon">
            <i data-lucide="check"></i>
          </span>
          <span class="tests-section-badge-text">Popular Tests</span>
        </div>
        <h2 class="tests-section-title">Popular Tests</h2>
        <p class="tests-section-description">Choose from our most booked diagnostic tests with affordable pricing</p>
      </div>
      
      <!-- Action Group: View All + Navigation -->
      <div class="tests-action-group">
        <a href="{{route('popular-blood-tests',['city'=>$cityName])}}" class="tests-view-all-btn">
          View All Tests
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
          </svg>
        </a>
        <div class="tests-swiper-nav d-none d-md-flex">
          <button class="tests-swiper-btn testswiper-button-prev" aria-label="Previous tests">
            <i data-lucide="chevron-left"></i>
          </button>
          <button class="tests-swiper-btn testswiper-button-next" aria-label="Next tests">
            <i data-lucide="chevron-right"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Tests Slider -->
    <div class="tests-slider-wrapper">
      <div class="swiper testSwiper">
        <div class="swiper-wrapper">
          @foreach($test as $pl)
            @php
              $discount = 0;
              if($pl->price > 0){
                $discount = 100 * ($pl->price - $pl->mrp) / $pl->price;
              }
            @endphp
            <div class="swiper-slide">
              @include('front.card_test')
            </div>
          @endforeach
        </div>
        <!-- Pagination for mobile -->
        <div class="swiper-pagination testSwiper-pagination d-md-none"></div>
      </div>
    </div>
  </div>
</section>

<!-- Premium App Download Section -->
<section class="app-download-section reveal" id="download_app">
  <div class="auto-container">
    <div class="app-gradient-card">
      <!-- Background Elements -->
      <div class="app-medical-pattern"></div>
      <div class="app-floating-shape app-floating-shape-1"></div>
      <div class="app-floating-shape app-floating-shape-2"></div>
      <div class="app-floating-shape app-floating-shape-3"></div>
      
      <div class="app-content-grid">
        <!-- Left Side - Phone Mockup -->
        <div class="app-phone-wrapper">
          <!-- Floating Healthcare Icons -->
          <div class="app-floating-icon app-floating-icon-1">
            <i data-lucide="pill"></i>
          </div>
          <div class="app-floating-icon app-floating-icon-2">
            <i data-lucide="heart-pulse"></i>
          </div>
          <div class="app-floating-icon app-floating-icon-3">
            <i data-lucide="flask-conical"></i>
          </div>
          <div class="app-floating-icon app-floating-icon-4">
            <i data-lucide="map-pin"></i>
          </div>
          <div class="app-floating-icon app-floating-icon-5">
            <i data-lucide="shield-check"></i>
          </div>
          
          <!-- Phone Mockup -->
          <div class="app-phone-mockup">
            <div class="app-phone-notch"></div>
            <div class="app-phone-screen">
              <div class="app-phone-content">
                <div class="app-phone-logo">
                  <i data-lucide="heart-pulse"></i>
                </div>
                <div class="app-phone-title">369 HealthDex</div>
                <div class="app-phone-subtitle">Your Health Partner</div>
                <div class="app-phone-cards">
                  <div class="app-phone-card">
                    <div class="app-phone-card-icon">
                      <i data-lucide="calendar-check"></i>
                    </div>
                    <div class="app-phone-card-text">
                      <div class="app-phone-card-title">Book Tests</div>
                      <div class="app-phone-card-desc">Schedule easily</div>
                    </div>
                  </div>
                  <div class="app-phone-card">
                    <div class="app-phone-card-icon">
                      <i data-lucide="file-text"></i>
                    </div>
                    <div class="app-phone-card-text">
                      <div class="app-phone-card-title">View Reports</div>
                      <div class="app-phone-card-desc">Instant access</div>
                    </div>
                  </div>
                  <div class="app-phone-card">
                    <div class="app-phone-card-icon">
                      <i data-lucide="house"></i>
                    </div>
                    <div class="app-phone-card-text">
                      <div class="app-phone-card-title">Home Collection</div>
                      <div class="app-phone-card-desc">Free pickup</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Right Side - Content -->
        <div class="app-content-wrapper">
          <div class="app-section-badge">
            <span class="app-section-badge-icon">
              <i data-lucide="smartphone"></i>
            </span>
            <span class="app-section-badge-text">{{__('message.Download apps')}}</span>
          </div>
          
          <h2 class="app-section-title">{{__('Download HealthDex Centre App Now')}}</h2>
          
          <p class="app-section-description">Book health packages, schedule home sample collection, access reports instantly and manage your family's health from one place. Now available on both Google Play Store and App Store.</p>
          
          <!-- Feature List -->
          <div class="app-features-grid">
            <div class="app-feature-item">
              <span class="app-feature-icon"><i data-lucide="check"></i></span>
              Book Tests Instantly
            </div>
            <div class="app-feature-item">
              <span class="app-feature-icon"><i data-lucide="check"></i></span>
              Download Reports
            </div>
            <div class="app-feature-item">
              <span class="app-feature-icon"><i data-lucide="check"></i></span>
              Home Sample Collection
            </div>
            <div class="app-feature-item">
              <span class="app-feature-icon"><i data-lucide="check"></i></span>
              Track Orders
            </div>
            <div class="app-feature-item">
              <span class="app-feature-icon"><i data-lucide="check"></i></span>
              Secure Payments
            </div>
            <div class="app-feature-item">
              <span class="app-feature-icon"><i data-lucide="check"></i></span>
              24×7 Support
            </div>
          </div>
          
          <!-- App Store Buttons -->
          <div class="app-buttons-wrapper">
            <a href="{{$setting->appstore_url}}" target="_blank" class="app-store-btn">
              <i class="fab fa-apple app-store-btn-icon"></i>
              <div class="app-store-btn-text">
                <span class="app-store-btn-label">Download on the</span>
                <span class="app-store-btn-name">App Store</span>
              </div>
            </a>
            
            <a href="{{$setting->playstore_url}}" target="_blank" class="app-store-btn">
              <i class="fab fa-google-play app-store-btn-icon"></i>
              <div class="app-store-btn-text">
                <span class="app-store-btn-label">Get it on</span>
                <span class="app-store-btn-name">Google Play</span>
              </div>
            </a>
          </div>
          
          <!-- QR Code -->
          <div class="app-qr-wrapper">
            <div class="app-qr-card">
              <div class="app-qr-image">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{$setting->playstore_url ?? 'https://healthdex369.com'}}" alt="Scan to Download">
              </div>
              <div class="app-qr-text">
                <div class="app-qr-label">Scan to Download</div>
                <div class="app-qr-desc">Point your camera at this QR code</div>
              </div>
            </div>
          </div>
          
          <!-- Rating & Stats -->
          <div class="app-stats-wrapper">
            <div class="app-rating">
              <div class="app-rating-stars">
                <i data-lucide="star" style="fill: currentColor;"></i>
                <i data-lucide="star" style="fill: currentColor;"></i>
                <i data-lucide="star" style="fill: currentColor;"></i>
                <i data-lucide="star" style="fill: currentColor;"></i>
                <i data-lucide="star" style="fill: currentColor;"></i>
              </div>
              <span class="app-rating-value">4.9 Rating</span>
            </div>
            <div class="app-stat-item">
              <span class="app-stat-value">25M+</span>
              <span class="app-stat-label">Downloads</span>
            </div>
            <div class="app-stat-item">
              <span class="app-stat-value">Trusted</span>
              <span class="app-stat-label">by Thousands</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!----------------------- Why Pathkind Labs ----------------->
 @include('front.why_rdc')

<!-- Premium Vision Section -->
<section class="vision-premium-section reveal">
  <div class="vision-bg" aria-hidden="true">
    <span class="vision-blob vision-blob-1"></span>
    <span class="vision-blob vision-blob-2"></span>
    <span class="vision-pattern"></span>
  </div>
  <div class="auto-container">
    <!-- Section Header -->
    <div class="vision-section-header">
      <div class="vision-section-title-wrapper">
        <div class="vision-section-badge">
          <span class="vision-section-badge-icon">
            <i data-lucide="eye"></i>
          </span>
          <span class="vision-section-badge-text">Our Vision</span>
        </div>
        <h2 class="vision-section-title">Our Vision</h2>
        <p class="vision-section-description">Building India's Most Trusted Preventive Healthcare Ecosystem</p>
      </div>
    </div>

    <div class="vision-grid">
      <!-- Left: the 2030 goal -->
      <div class="vision-stat-card">
        <span class="vision-float vision-float-1" aria-hidden="true"><i data-lucide="heart-pulse"></i></span>
        <span class="vision-float vision-float-2" aria-hidden="true"><i data-lucide="users"></i></span>
        <span class="vision-float vision-float-3" aria-hidden="true"><i data-lucide="activity"></i></span>

        <div class="vision-stat-number" data-hd-counter>10 Crore</div>
        <p class="vision-stat-label">Indians proactively managing their health through annual checkups, smart reports, and lifestyle coaching — by 2030.</p>

        <div class="vision-illustration" aria-hidden="true">
          <svg viewBox="0 0 300 150" xmlns="http://www.w3.org/2000/svg" fill="none" role="presentation">
            <rect x="24" y="92" width="34" height="44" rx="9" fill="#d1fae5"/>
            <rect x="76" y="72" width="34" height="64" rx="9" fill="#a7f3d0"/>
            <rect x="128" y="50" width="34" height="86" rx="9" fill="#6ee7b7"/>
            <rect x="180" y="28" width="34" height="108" rx="9" fill="#34d399"/>
            <path d="M14 78 H70 L84 52 L102 96 L116 70 H150 L162 84 H186" stroke="#047857" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="186" cy="84" r="6" fill="#047857"/>
            <path d="M247 44c-8.6-8.4-22.6-8.4-31.2 0-8.6 8.4-8.6 22 0 30.4L247 105l31.2-30.6c8.6-8.4 8.6-22 0-30.4-8.6-8.4-22.6-8.4-31.2 0z" fill="#10b981"/>
            <path d="M229 74h9l5-9 7 16 5-7h13" stroke="#ffffff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>

      <!-- Right: the narrative -->
      <div class="vision-content">
        <p class="vision-lead">&ldquo;We want to become India's most trusted preventive healthcare ecosystem &mdash; not the largest, not the loudest, but <span>the most trusted</span>.&rdquo;</p>

        <ul class="vision-points">
          <li>
            <span class="vision-point-icon"><i data-lucide="calendar-check"></i></span>
            A future where the annual health checkup is as routine as paying a phone bill.
          </li>
          <li>
            <span class="vision-point-icon"><i data-lucide="file-text"></i></span>
            Where a diagnostic report is the beginning of a conversation &mdash; not a piece of paper filed away and forgotten.
          </li>
          <li>
            <span class="vision-point-icon"><i data-lucide="heart-handshake"></i></span>
            Where a health coach is not a luxury for the wealthy few, but a resource every Indian family can access.
          </li>
        </ul>

        <p class="vision-callout">That future starts in Jamnagar.</p>
        <p class="vision-closing">And it doesn't stop until it reaches every Tier-2 and Tier-3 city in India where quality preventive healthcare has been missing for too long.</p>
      </div>
    </div>

    <!-- Mission quote -->
    <div class="vision-quote-card">
      <span class="vision-quote-pattern" aria-hidden="true"></span>
      <span class="vision-quote-mark" aria-hidden="true">&rdquo;</span>
      <span class="vision-quote-icon"><i data-lucide="quote"></i></span>
      <p class="vision-quote-text">
        Our mission isn't to become India's biggest healthcare company.<br>
        <span>Our mission is to become the healthcare company India trusts the most.</span>
      </p>
    </div>
  </div>
</section>

<!-- Premium Offers Section -->
<section class="offers-premium-section reveal">
  <div class="auto-container">
    <!-- Section Header -->
    <div class="offers-section-header">
      <div class="offers-section-title-wrapper">
        <div class="offers-section-badge">
          <span class="offers-section-badge-icon">
            <i data-lucide="badge-percent"></i>
          </span>
          <span class="offers-section-badge-text">Limited Time</span>
        </div>
        <h2 class="offers-section-title">Our Offers</h2>
        <p class="offers-section-description">Save more on health checkups with our exclusive seasonal deals and discounts</p>
      </div>
      <div class="custom-swiper-nav d-none d-md-flex">
        <button class="offerSwiper-button-prev btn-pre" aria-label="Previous offers"><i data-lucide="chevron-left"></i></button>
        <button class="offerSwiper-button-next btn-next" aria-label="Next offers"><i data-lucide="chevron-right"></i></button>
      </div>
    </div>
    <div class="inner-content">
      <div class="swiper offerSwiper">
        <div class="swiper-wrapper">
          @foreach($offer as $c)
          <div class="swiper-slide">
            <div class="hd-offer-card">
              <img src="{{asset('storage/app/public/category').'/'.$c->image}}" width="100%" alt="HealthDex offer" loading="lazy" decoding="async">
              <span class="hd-offer-card-shine" aria-hidden="true"></span>
            </div>
          </div>
          @endforeach
        </div>
        <!-- Pagination for mobile -->
        <div class="swiper-pagination offerSwiper-pagination d-md-none"></div>
      </div>
    </div>
  </div>
</section>

<!-- Premium Labs Network Section -->
<section class="labs-premium-section reveal">
  <div class="auto-container">
    <!-- Section Header -->
    <div class="labs-section-header">
      <div class="labs-section-title-wrapper">
        <div class="labs-section-badge">
          <span class="labs-section-badge-icon">
            <i data-lucide="map-pin"></i>
          </span>
          <span class="labs-section-badge-text">Near You</span>
        </div>
        <h2 class="labs-section-title">Our {{ count($lab) }}+ Labs Network</h2>
        <p class="labs-section-description">Certified collection centres near you — walk in or book a free home visit</p>
      </div>
      <div class="custom-swiper-nav d-none d-md-flex">
        <button class="labSwiper-button-prev btn-pre" aria-label="Previous labs"><i data-lucide="chevron-left"></i></button>
        <button class="labSwiper-button-next btn-next" aria-label="Next labs"><i data-lucide="chevron-right"></i></button>
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

      <div class="swiper-pagination labSwiper-pagination d-md-none"></div>
    </div>
  </div>
</section>

<!-- Premium FAQ Section -->
<section class="faq-premium-section reveal">
  <div class="auto-container">
    <!-- Section Header -->
    <div class="faq-section-header">
      <div class="faq-section-title-wrapper">
        <div class="faq-section-badge">
          <span class="faq-section-badge-icon">
            <i data-lucide="circle-help"></i>
          </span>
          <span class="faq-section-badge-text">FAQ</span>
        </div>
        <h2 class="faq-section-title">Frequently Asked Questions</h2>
        <p class="faq-section-description">Everything you need to know about booking tests, home collection and reports</p>
      </div>

      <a href="tel:{{$setting->phone}}" class="premium-btn premium-btn-primary faq-header-cta">
        <i data-lucide="phone"></i>
        {{$setting->phone}}
      </a>
    </div>

    <!-- Accordion -->
    <div class="faq-accordion" id="hdFaqAccordion">
        <div class="hd-faq-item">
          <button type="button" class="hd-faq-question" aria-expanded="false">
            <span>How do I book a test or health package?</span>
            <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
          </button>
          <div class="hd-faq-answer">
            <div class="hd-faq-answer-inner">
              <p>Simply search for your test or package, add it to your cart and choose a convenient slot. Our expert phlebotomist will visit your home to collect the sample — or you can visit any of our partner labs.</p>
            </div>
          </div>
        </div>

        <div class="hd-faq-item">
          <button type="button" class="hd-faq-question" aria-expanded="false">
            <span>Is home sample collection really free?</span>
            <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
          </button>
          <div class="hd-faq-answer">
            <div class="hd-faq-answer-inner">
              <p>Yes. Home sample collection is completely free on our tests and health packages. A trained phlebotomist visits your home at the time slot you choose.</p>
            </div>
          </div>
        </div>

        <div class="hd-faq-item">
          <button type="button" class="hd-faq-question" aria-expanded="false">
            <span>How and when will I receive my reports?</span>
            <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
          </button>
          <div class="hd-faq-answer">
            <div class="hd-faq-answer-inner">
              <p>Reports are shared digitally as soon as they are ready. You can download them anytime from the website or app under Download Reports, and most routine test reports are available within 24–48 hours.</p>
            </div>
          </div>
        </div>

        <div class="hd-faq-item">
          <button type="button" class="hd-faq-question" aria-expanded="false">
            <span>Are your labs certified?</span>
            <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
          </button>
          <div class="hd-faq-answer">
            <div class="hd-faq-answer-inner">
              <p>Yes. Samples are processed at NABL accredited partner laboratories with strict quality controls, so you can trust the accuracy of every report.</p>
            </div>
          </div>
        </div>

        <div class="hd-faq-item">
          <button type="button" class="hd-faq-question" aria-expanded="false">
            <span>Do I need a doctor's prescription to book?</span>
            <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
          </button>
          <div class="hd-faq-answer">
            <div class="hd-faq-answer-inner">
              <p>Most tests and health packages can be booked without a prescription. If you have one, you can upload it and our team will help you book exactly what your doctor advised.</p>
            </div>
          </div>
        </div>

        <div class="hd-faq-item">
          <button type="button" class="hd-faq-question" aria-expanded="false">
            <span>What payment options are available?</span>
            <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
          </button>
          <div class="hd-faq-answer">
            <div class="hd-faq-answer-inner">
              <p>You can pay securely online using cards, UPI and popular wallets. All payments are processed over a secure, SSL-protected gateway.</p>
            </div>
          </div>
        </div>
      </div>
  </div>
</section>

@include('front.blogcard')

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