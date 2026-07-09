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
@php
    $hdMapQuery = urlencode(trim((string) $setting->address));
@endphp

<!-- Premium Contact Hero -->
<section class="contact-hero-section reveal">
  <div class="contact-hero-bg" aria-hidden="true">
    <span class="contact-hero-blob contact-hero-blob-1"></span>
    <span class="contact-hero-blob contact-hero-blob-2"></span>
    <span class="contact-hero-pattern"></span>
  </div>
  <div class="auto-container">
    <nav class="contact-hero-breadcrumb" aria-label="Breadcrumb">
      <a href="{{route('home')}}">{{__('message.Home')}}</a>
      <i data-lucide="chevron-right"></i>
      <span>{{__('message.Contact Us')}}</span>
    </nav>

    <div class="contact-hero-grid">
      <div class="contact-hero-content">
        <div class="contact-hero-badge">
          <span class="contact-hero-badge-icon"><i data-lucide="headset"></i></span>
          <span>We're Here To Help</span>
        </div>
        <h1 class="contact-hero-title">Contact <span class="contact-hero-title-accent">369 HealthDex</span></h1>
        <p class="contact-hero-subtitle">Questions about booking a test, your report, or free home sample collection? Reach out — our healthcare support team responds fast.</p>
        <div class="contact-hero-quicklinks">
          <a href="tel:{{$setting->phone}}" class="premium-btn premium-btn-primary">
            <i data-lucide="phone"></i>{{$setting->phone}}
          </a>
          <a href="mailto:{{$setting->email}}" class="premium-btn premium-btn-secondary">
            <i data-lucide="mail"></i>Email Us
          </a>
        </div>
      </div>

      <div class="contact-hero-visual" aria-hidden="true">
        <span class="contact-hero-float contact-hero-float-1"><i data-lucide="phone-call"></i></span>
        <span class="contact-hero-float contact-hero-float-2"><i data-lucide="mail"></i></span>
        <span class="contact-hero-float contact-hero-float-3"><i data-lucide="map-pin"></i></span>
        <span class="contact-hero-float contact-hero-float-4"><i data-lucide="message-circle-heart"></i></span>
        <div class="contact-hero-visual-ring">
          <div class="contact-hero-visual-core">
            <i data-lucide="headset"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Form + Info -->
<section class="contact-main-section reveal">
  <div class="auto-container">
    <div class="contact-section-header">
      <div class="contact-section-title-wrapper">
        <div class="contact-section-badge">
          <span class="contact-section-badge-icon"><i data-lucide="message-square-text"></i></span>
          <span>Get In Touch</span>
        </div>
        <h2 class="contact-section-title">Send Us a Message</h2>
        <p class="contact-section-description">Fill in the form and our team will connect with you shortly — or reach us directly using the details alongside.</p>
      </div>
    </div>

    <div class="contact-grid">
      <!-- Contact Form Column -->
      <div class="contact-form-card">
        <span class="contact-form-card-glow" aria-hidden="true"></span>

        @if(Session::has('message'))
        <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show hd-contact-alert" role="alert">
            <span class="hd-contact-alert-icon">
                <i data-lucide="{{ Session::get('alert-class') == 'alert-success' ? 'circle-check-big' : 'circle-alert' }}"></i>
            </span>
            <span>{{ Session::get('message') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        @endif

        <form method="post" action="{{route('save-contact')}}" id="contact-form" class="default-form hd-contact-form">
            {{ csrf_field() }}
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                    <div class="hd-float-field">
                        <i data-lucide="user-round" class="hd-float-icon"></i>
                        <input type="text" name="name" id="hdContactName" placeholder=" " required class="form-control">
                        <label for="hdContactName">{{__('message.Your name')}}</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                    <div class="hd-float-field">
                        <i data-lucide="mail" class="hd-float-icon"></i>
                        <input type="email" name="email" id="hdContactEmail" placeholder=" " required class="form-control">
                        <label for="hdContactEmail">{{__('message.Your email')}}</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                    <div class="hd-float-field">
                        <i data-lucide="phone" class="hd-float-icon"></i>
                        <input type="number" name="phone" id="hdContactPhone" placeholder=" " required class="form-control">
                        <label for="hdContactPhone">{{__('message.Phone number')}}</label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                    <div class="hd-float-field">
                        <i data-lucide="file-text" class="hd-float-icon"></i>
                        <input type="text" name="subject" id="hdContactSubject" placeholder=" " required class="form-control">
                        <label for="hdContactSubject">{{__('message.Subject')}}</label>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <div class="hd-float-field hd-float-field-textarea">
                        <i data-lucide="message-square" class="hd-float-icon"></i>
                        <textarea name="message" id="hdContactMessage" placeholder=" " class="form-control" rows="4"></textarea>
                        <label for="hdContactMessage">{{__('message.Your Message ...')}}</label>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <div class="hd-contact-captcha">
                        <label class="hd-contact-captcha-label">CAPTCHA <span style="color:#dc2626;">*</span></label>
                        <div class="hd-contact-captcha-row">
                            <span class="hd-contact-captcha-img-wrap">
                                <img src="{{ url('/custom-captcha') }}" id="captcha-img" alt="CAPTCHA">
                                <button type="button" class="hd-contact-captcha-reload" onclick="reloadCaptcha()" aria-label="Reload CAPTCHA"><i data-lucide="refresh-cw"></i></button>
                            </span>
                            <input type="text" name="captcha_input" class="form-control hd-contact-captcha-input" placeholder="Enter CAPTCHA" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                    <button class="hd-contact-submit" type="submit" name="submit-form" id="hdContactSubmitBtn">
                        <span class="hd-contact-submit-text">{{__('message.Send Message')}}</span>
                        <i data-lucide="send" class="hd-contact-submit-icon"></i>
                        <span class="hd-contact-submit-spinner" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>
      </div>

      <!-- Contact Info Column -->
      <div class="contact-info-stack">
        <a href="tel:{{$setting->phone}}" class="contact-info-card">
            <span class="contact-info-icon"><i data-lucide="phone-call"></i></span>
            <span class="contact-info-text">
                <strong>Call Us</strong>
                <span>{{$setting->phone}}</span>
            </span>
            <i data-lucide="arrow-up-right" class="contact-info-arrow"></i>
        </a>

        <a href="mailto:{{$setting->email}}" class="contact-info-card">
            <span class="contact-info-icon"><i data-lucide="mail"></i></span>
            <span class="contact-info-text">
                <strong>Email Us</strong>
                <span>{{$setting->email}}</span>
            </span>
            <i data-lucide="arrow-up-right" class="contact-info-arrow"></i>
        </a>

        @if(trim((string) $setting->address) !== '')
        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $hdMapQuery }}" target="_blank" rel="noopener noreferrer" class="contact-info-card">
            <span class="contact-info-icon"><i data-lucide="map-pin"></i></span>
            <span class="contact-info-text">
                <strong>Head Office</strong>
                <span>{{$setting->address}}</span>
            </span>
            <i data-lucide="arrow-up-right" class="contact-info-arrow"></i>
        </a>
        @endif

        <div class="contact-info-card contact-info-card-static">
            <span class="contact-info-icon"><i data-lucide="clock"></i></span>
            <span class="contact-info-text">
                <strong>Working Hours</strong>
                <span>24/7 — We're always here to help</span>
            </span>
        </div>

        @if(trim((string) $setting->address) !== '')
        <div class="contact-map-card">
            <iframe
                src="https://www.google.com/maps?q={{ $hdMapQuery }}&output=embed"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                aria-label="{{__('message.site_name')}} location on Google Maps"></iframe>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>

<!-- Why Contact 369 HealthDex -->
<section class="why-choose-section reveal">
  <div class="why-floating-shape why-floating-shape-1"></div>
  <div class="why-floating-shape why-floating-shape-2"></div>
  <div class="why-floating-shape why-floating-shape-3"></div>

  <div class="auto-container">
    <div class="why-section-header">
      <div class="why-section-title-wrapper">
        <div class="why-section-badge">
          <span class="why-section-badge-icon"><i data-lucide="sparkles"></i></span>
          <span class="why-section-badge-text">Why Reach Out</span>
        </div>
        <h2 class="why-section-title">Why Contact 369 HealthDex?</h2>
        <p class="why-section-description">Whatever you need help with, our team makes it simple to get an answer</p>
      </div>
    </div>

    <div class="why-features-grid">
      <div class="why-feature-card">
        <div class="why-feature-icon-wrapper">
          <i data-lucide="zap" class="why-feature-icon"></i>
        </div>
        <h4 class="why-feature-title">Fast Response</h4>
        <p class="why-feature-description">Our support team typically responds within minutes, not days — call, email or message us anytime.</p>
        <div class="why-trust-badge">
          <i data-lucide="check" class="why-trust-badge-icon"></i>
          Quick Turnaround
        </div>
      </div>

      <div class="why-feature-card">
        <div class="why-feature-icon-wrapper">
          <i data-lucide="stethoscope" class="why-feature-icon"></i>
        </div>
        <h4 class="why-feature-title">Expert Support</h4>
        <p class="why-feature-description">Trained healthcare advisors are on hand to guide you on tests, packages and reports.</p>
        <div class="why-trust-badge">
          <i data-lucide="check" class="why-trust-badge-icon"></i>
          Trained Advisors
        </div>
      </div>

      <div class="why-feature-card">
        <div class="why-feature-icon-wrapper">
          <i data-lucide="house" class="why-feature-icon"></i>
        </div>
        <h4 class="why-feature-title">Home Collection Assistance</h4>
        <p class="why-feature-description">Need help scheduling or rescheduling a home sample collection? We'll sort it out for you.</p>
        <div class="why-trust-badge">
          <i data-lucide="check" class="why-trust-badge-icon"></i>
          Free Home Visit
        </div>
      </div>

      <div class="why-feature-card">
        <div class="why-feature-icon-wrapper">
          <i data-lucide="calendar-check" class="why-feature-icon"></i>
        </div>
        <h4 class="why-feature-title">Booking Help</h4>
        <p class="why-feature-description">Not sure which test or package to choose? Reach out and we'll help you book the right one.</p>
        <div class="why-trust-badge">
          <i data-lucide="check" class="why-trust-badge-icon"></i>
          Guided Booking
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact & Support FAQ -->
<section class="faq-premium-section reveal">
  <div class="auto-container">
    <div class="faq-section-header">
      <div class="faq-section-title-wrapper">
        <div class="faq-section-badge">
          <span class="faq-section-badge-icon">
            <i data-lucide="circle-help"></i>
          </span>
          <span class="faq-section-badge-text">FAQ</span>
        </div>
        <h2 class="faq-section-title">Contact &amp; Support Questions</h2>
        <p class="faq-section-description">Quick answers about reaching our team and getting help with your bookings</p>
      </div>

      <a href="tel:{{$setting->phone}}" class="premium-btn premium-btn-primary faq-header-cta">
        <i data-lucide="phone"></i>
        {{$setting->phone}}
      </a>
    </div>

    <div class="faq-accordion" id="hdFaqAccordion">
        <div class="hd-faq-item">
          <button type="button" class="hd-faq-question" aria-expanded="false">
            <span>What is the fastest way to reach 369 HealthDex support?</span>
            <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
          </button>
          <div class="hd-faq-answer">
            <div class="hd-faq-answer-inner">
              <p>Calling us at {{$setting->phone}} gets you the fastest response. You can also email {{$setting->email}} or use the contact form on this page — our team replies quickly.</p>
            </div>
          </div>
        </div>

        <div class="hd-faq-item">
          <button type="button" class="hd-faq-question" aria-expanded="false">
            <span>How long does it take to get a reply after submitting the form?</span>
            <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
          </button>
          <div class="hd-faq-answer">
            <div class="hd-faq-answer-inner">
              <p>Our support team aims to respond to every message the same day. For urgent queries about an ongoing booking or sample collection, calling us directly is quicker.</p>
            </div>
          </div>
        </div>

        <div class="hd-faq-item">
          <button type="button" class="hd-faq-question" aria-expanded="false">
            <span>Can I get help choosing the right test or package?</span>
            <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
          </button>
          <div class="hd-faq-answer">
            <div class="hd-faq-answer-inner">
              <p>Absolutely. Mention your requirement in the message or call our advisors — they'll guide you to the right test or health package based on your needs.</p>
            </div>
          </div>
        </div>

        <div class="hd-faq-item">
          <button type="button" class="hd-faq-question" aria-expanded="false">
            <span>I need to reschedule my home sample collection — who do I contact?</span>
            <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
          </button>
          <div class="hd-faq-answer">
            <div class="hd-faq-answer-inner">
              <p>Call our support line or send us a message with your booking details, and our team will help you reschedule your home visit at a convenient time.</p>
            </div>
          </div>
        </div>

        <div class="hd-faq-item">
          <button type="button" class="hd-faq-question" aria-expanded="false">
            <span>Where is 369 HealthDex's head office located?</span>
            <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
          </button>
          <div class="hd-faq-answer">
            <div class="hd-faq-answer-inner">
              <p>{{$setting->address}} — you can find directions using the map on this page.</p>
            </div>
          </div>
        </div>
    </div>
  </div>
</section>

<script>
(function () {
    var form = document.getElementById('contact-form');
    var btn = document.getElementById('hdContactSubmitBtn');
    if (form && btn) {
        form.addEventListener('submit', function () {
            /* Progressive enhancement only — the native submit has already
               been triggered; this just prevents double-submits and shows
               a loading state while the page navigates. */
            btn.classList.add('is-loading');
            btn.disabled = true;
        });
    }
})();
</script>
@stop
@section('footer')
@stop
