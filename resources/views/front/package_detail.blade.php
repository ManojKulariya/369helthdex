@extends('front.layout')

<?php $res_curr = explode("-", $setting->currency);

$cityName = ucfirst(session()->get('cityName'));

if ($cityName == '') {

   $cityName = 'rajkot';

}

$profile = array();

if (isset($data->testdetails)) {

   foreach ($data->testdetails as $td) {

      if ($td->type == 2) {

         foreach ($profiles_list as $pl) {

            if ($td->type_id == $pl->id) {

               $profile[] = $pl->profile_name;

            }

         }

      }

   }

}

$profile_name = implode(',', $profile);

$cate = array();

foreach ($category as $pl) {

   $cate[] = $pl->name;

}

$cate_name = implode(',', $cate);

$description = COMMAN::replace($data->description, $cityName);

/* Hero/pricing helpers — display-only, no backend logic touched.
   In this codebase's convention: $data->mrp is the CURRENT/offer price,
   $data->price is the ORIGINAL (pre-discount) price. */
$hdOriginal = (float) ($data->price ?? 0);
$hdCurrent = (float) ($data->mrp ?? 0);
$hdHasDiscount = $hdOriginal > 0 && $hdCurrent > 0 && round($hdOriginal) > round($hdCurrent);
$hdSaved = $hdHasDiscount ? ($hdOriginal - $hdCurrent) : 0;
$hdDiscountPer = is_array($data->discount ?? null) ? ($data->discount['per'] ?? 0) : 0;
$hdDiscountPct = $hdDiscountPer > 0 ? round($hdDiscountPer) : ($hdHasDiscount ? round(100 * $hdSaved / $hdOriginal) : 0);

$hdStars = explode(".", (string) ($data->avg_review ?? '0'));
$hdFullStars = isset($hdStars[0]) ? (int) $hdStars[0] : 0;
$hdHasHalfStar = isset($hdStars[1]) && (int) $hdStars[1] > 0;

$hdWhatsappNumber = '919828112340';
$hdWhatsappText = rawurlencode('Hi! I want to book ' . ($data->name ?? 'this package') . ' in ' . $cityName . '.');

$hdShortDescription = trim(strip_tags(html_entity_decode($description)));
if (function_exists('mb_strlen') && mb_strlen($hdShortDescription) > 180) {
    $hdShortDescription = mb_substr($hdShortDescription, 0, 177) . '...';
}
?>

@section('title')

   Book {{isset($data->name)?$data->name:''}} | {{isset($data->parameter)?$data->parameter:''}} Parameters{{$res_curr[1]}}{{number_format($data->mrp,2,'.','')}} in {{$cityName}}

@stop

@section('content')

@section('meta-data')

<link rel="canonical" href="{{ url()->current() }}">

<meta name="description" content="Book {{isset($data->name)?$data->name:''}} Online in {{$cityName}} with Reliable Diagnostic. It Covers Health Test like {{$cate_name}} and {{$profile_name}}">

<meta name="keywords" content="{{isset($data->name)?$data->name:''}} name in {{$cityName}}, with {{$profile_name}} in {{$cityName}}, complete body checkup in {{$cityName}}, Free Sample Home Collection in {{$cityName}}">

<meta name="robots" content="index, follow" />

<meta property="og:type" content="website"/>

<meta property="og:url" content="{{ url()->current() }}"/>

<meta property="og:title" content="Book {{isset($data->name)?$data->name:''}} | {{isset($data->parameter)?$data->parameter:''}} Parameters{{$res_curr[1]}}{{number_format($data->mrp,2,'.','')}} in {{$cityName}}"/>

<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}"/>

<meta property="og:image:width" content="250px"/>

<meta property="og:image:height" content="250px"/>

<meta property="og:site_name" content="{{__('message.site_name')}}"/>

<meta property="og:description" content="Book {{isset($data->name)?$data->name:''}} Online in {{$cityName}} with Reliable Diagnostic. It Covers Health Test like {{$cate_name}} and {{$profile_name}}">

<meta property="og:keyword" content="{{isset($data->name)?$data->name:''}} name in {{$cityName}}, with {{$profile_name}} in {{$cityName}}, complete body checkup in {{$cityName}}, Free Sample Home Collection in {{$cityName}}"/>

<link rel="shortcut icon" href="{{asset('public/img/').'/'.$setting->favicon}}">

<meta name="viewport" content="width=device-width, initial-scale=1">

@stop

<section class="page-title-two">

   <div class="lower-content">

      <div class="auto-container">

         <ul class="bread-crumb clearfix">

            <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>

            <li>{{isset($data->name)?$data->name:''}} {{__('message.Package Detail')}}</li>

         </ul>

      </div>

   </div>

</section>

<section class="pkg-hero-section reveal">
   <div class="auto-container">
      <div class="pkg-hero-grid">

         <!-- ===================== LEFT: package info + pricing ===================== -->
         <div class="pkg-hero-main">

            <div class="pkg-hero-badges">
               <span class="pkg-badge"><i data-lucide="shield-check"></i> NABL Certified</span>
               @if(isset($data->sample_collection) && $data->sample_collection=='1')
                  <span class="pkg-badge"><i data-lucide="home"></i> Home Collection</span>
               @endif
               <span class="pkg-badge"><i data-lucide="zap"></i> Fast Reports</span>
               @if(isset($data->fasting_time) && $data->fasting_time=='1')
                  <span class="pkg-badge"><i data-lucide="clock"></i> Fasting Required</span>
               @else
                  <span class="pkg-badge"><i data-lucide="check-circle"></i> No Fasting Needed</span>
               @endif
            </div>

            <h1 id="package_name" class="pkg-hero-title">{{isset($data->name)?$data->name:''}} <span>in {{ ucfirst($cityName)}}</span></h1>

            @if($hdShortDescription !== '')
               <p class="pkg-hero-desc">{{ $hdShortDescription }}</p>
            @endif

            <div class="pkg-hero-meta">
               <div class="pkg-hero-meta-item">
                  <i data-lucide="flask-conical"></i>
                  <span><strong>{{isset($data->parameter)?$data->parameter:0}}</strong> {{__('message.Parameter Included')}}</span>
               </div>
               <div class="pkg-hero-meta-item pkg-hero-rating" aria-label="Rated {{$data->avg_review}} out of 5">
                  <span class="pkg-hero-stars">
                     @for($i=0;$i<5;$i++)
                        <i data-lucide="star" class="{{ $i < $hdFullStars || ($i == $hdFullStars && $hdHasHalfStar) ? 'is-filled' : '' }}"></i>
                     @endfor
                  </span>
                  <strong>{{$data->avg_review}}</strong>/5
                  @if((int)$data->total_review > 0)
                     <span class="pkg-hero-review-count">({{$data->total_review}} {{__('message.Reviews')}})</span>
                  @endif
               </div>
            </div>

            <!-- Mobile/tablet pricing card (desktop uses the sticky sidebar) -->
            <div class="pkg-price-card pkg-price-card--inline">
               <div class="pkg-price-card-row">
                  <div>
                     @if($hdHasDiscount)
                        <span class="pkg-price-original">₹{{ number_format($hdOriginal, 0) }}</span>
                     @endif
                     <span class="pkg-price-current">₹{{ number_format($hdCurrent, 0) }}</span>
                  </div>
                  @if($hdDiscountPct > 0)
                     <span class="pkg-discount-chip">{{ $hdDiscountPct }}% OFF</span>
                  @endif
               </div>
               @if($hdHasDiscount && $hdSaved > 0)
                  <div class="pkg-price-saved"><i data-lucide="badge-percent"></i> You save ₹{{ number_format($hdSaved, 0) }}</div>
               @endif

               <div class="pkg-cta-row">
                  <a href="{{ route('checkouts', ['id' => $data->id, 'type' => 1, 'parameter' => $data->parameter ?? '0']) }}" class="premium-btn premium-btn-primary pkg-cta-book">
                     {{ __('message.Book Now') }}
                     <i data-lucide="arrow-right"></i>
                  </a>
                  <a href="javascript:void(0)" class="premium-btn premium-btn-secondary pkg-cta-cart js-request-callback">
                     <i data-lucide="phone-call"></i> Get a Free Call
                  </a>
               </div>
               <div class="pkg-cta-row pkg-cta-row--secondary">
                  <a href="https://wa.me/{{ $hdWhatsappNumber }}?text={{ $hdWhatsappText }}" target="_blank" rel="noopener noreferrer" class="pkg-cta-icon-btn pkg-cta-whatsapp" aria-label="Chat on WhatsApp">
                     <i class="fab fa-whatsapp"></i> WhatsApp
                  </a>
                  <a href="tel:{{ $setting->phone }}" class="pkg-cta-icon-btn pkg-cta-call" aria-label="Call us">
                     <i data-lucide="phone"></i> {{ $setting->phone }}
                  </a>
               </div>
            </div>
         </div>

         <!-- ===================== RIGHT: sticky summary card (desktop) ===================== -->
         <aside class="pkg-hero-aside">
            <div class="pkg-summary-card">
               <div class="pkg-summary-icon"><i data-lucide="heart-pulse"></i></div>
               <h3 class="pkg-summary-name">{{isset($data->name)?$data->name:''}}</h3>

               <div class="pkg-price-card">
                  <div class="pkg-price-card-row">
                     <div>
                        @if($hdHasDiscount)
                           <span class="pkg-price-original">₹{{ number_format($hdOriginal, 0) }}</span>
                        @endif
                        <span class="pkg-price-current">₹{{ number_format($hdCurrent, 0) }}</span>
                     </div>
                     @if($hdDiscountPct > 0)
                        <span class="pkg-discount-chip">{{ $hdDiscountPct }}% OFF</span>
                     @endif
                  </div>
                  @if($hdHasDiscount && $hdSaved > 0)
                     <div class="pkg-price-saved"><i data-lucide="badge-percent"></i> You save ₹{{ number_format($hdSaved, 0) }}</div>
                  @endif
               </div>

               <ul class="pkg-summary-list">
                  @if(isset($data->sample_collection) && $data->sample_collection=='1')
                     <li><i data-lucide="home"></i> Free Home Collection</li>
                  @endif
                  @if(isset($data->report_time) && $data->report_time !== '')
                     <li><i data-lucide="clock"></i> Reports in {{ $data->report_time }}</li>
                  @endif
                  <li><i data-lucide="building-2"></i> {{ __('message.site_name') }}</li>
                  <li><i data-lucide="users"></i> 100+ Booked This Month</li>
               </ul>

               <div class="pkg-cta-row">
                  <a href="{{ route('checkouts', ['id' => $data->id, 'type' => 1, 'parameter' => $data->parameter ?? '0']) }}" class="premium-btn premium-btn-primary pkg-cta-book">
                     {{ __('message.Book Now') }}
                     <i data-lucide="arrow-right"></i>
                  </a>
                  <a href="javascript:void(0)" class="premium-btn premium-btn-secondary pkg-cta-cart js-request-callback">
                     <i data-lucide="phone-call"></i> Get a Free Call
                  </a>
               </div>
               <div class="pkg-cta-row pkg-cta-row--secondary">
                  <a href="https://wa.me/{{ $hdWhatsappNumber }}?text={{ $hdWhatsappText }}" target="_blank" rel="noopener noreferrer" class="pkg-cta-icon-btn pkg-cta-whatsapp" aria-label="Chat on WhatsApp">
                     <i class="fab fa-whatsapp"></i>
                  </a>
                  <a href="tel:{{ $setting->phone }}" class="pkg-cta-icon-btn pkg-cta-call" aria-label="Call us">
                     <i data-lucide="phone"></i>
                  </a>
               </div>

               <div class="pkg-summary-trust">
                  <span><i data-lucide="shield-check"></i> NABL Certified</span>
                  <span><i data-lucide="lock"></i> Secure Reports</span>
               </div>
            </div>
         </aside>

      </div>
   </div>
</section>

<!-- ===================== PACKAGE OVERVIEW ===================== -->
<section class="pkg-overview-section reveal">
   <div class="auto-container">
      <div class="pkg-section-header">
         <h2 class="pkg-section-title">Package Overview</h2>
      </div>
      <div class="pkg-overview-grid">
         <div class="pkg-overview-card">
            <div class="pkg-overview-icon"><i data-lucide="list-checks"></i></div>
            <h4>Package Includes</h4>
            <p>{{ isset($data->parameter) ? $data->parameter : 0 }} health parameters</p>
         </div>
         @if(isset($data->test_recommended_for) && $data->test_recommended_for !== '')
         <div class="pkg-overview-card">
            <div class="pkg-overview-icon"><i data-lucide="user-check"></i></div>
            <h4>Ideal For</h4>
            <p>{{ $data->test_recommended_for }}</p>
         </div>
         @endif
         <div class="pkg-overview-card">
            <div class="pkg-overview-icon"><i data-lucide="clipboard-list"></i></div>
            <h4>Preparation</h4>
            <p>
               @if(isset($data->fasting_time) && $data->fasting_time=='1')
                  Fasting required{{ isset($data->fast_time) && $data->fast_time !== '' ? ' ('.$data->fast_time.')' : '' }}
               @else
                  No special preparation needed
               @endif
            </p>
         </div>
         @if(isset($data->report_time) && $data->report_time !== '')
         <div class="pkg-overview-card">
            <div class="pkg-overview-icon"><i data-lucide="file-clock"></i></div>
            <h4>Report Time</h4>
            <p>{{ $data->report_time }}</p>
         </div>
         @endif
         <div class="pkg-overview-card">
            <div class="pkg-overview-icon"><i data-lucide="car"></i></div>
            <h4>Home Collection</h4>
            <p>
               @if(isset($data->sample_collection) && $data->sample_collection=='1')
                  Free home sample collection
               @else
                  Available at partner labs
               @endif
            </p>
         </div>
         <div class="pkg-overview-card">
            <div class="pkg-overview-icon"><i data-lucide="clock"></i></div>
            <h4>Fasting</h4>
            <p>
               @if(isset($data->fasting_time) && $data->fasting_time=='0')
                  {{ __('message.Free') }} / Not required
               @elseif(isset($data->fasting_time) && $data->fasting_time=='1')
                  {{ isset($data->fast_time) ? $data->fast_time : 'Required' }}
               @endif
            </p>
         </div>
         @if(isset($data->test_recommended_for_age) && $data->test_recommended_for_age !== '')
         <div class="pkg-overview-card">
            <div class="pkg-overview-icon"><i data-lucide="cake"></i></div>
            <h4>Recommended Age</h4>
            <p>{{ $data->test_recommended_for_age }}</p>
         </div>
         @endif
      </div>

      <div class="pkg-description-block">
         <div class="descriptiontxt">
            <?= html_entity_decode($description);?>
         </div>
         <button class="read-more-btn">Read More</button>
      </div>
   </div>
</section>

<!-- ===================== PARAMETERS SECTION ===================== -->
<section class="pkg-params-section reveal">
   <div class="auto-container">
      <div class="pkg-section-header">
         <h2 class="pkg-section-title">{{__('message.Test Details')}} <span>({{isset($data->parameter)?$data->parameter:0}} Parameters Included)</span></h2>
         <div class="pkg-params-search">
            <i data-lucide="search"></i>
            <input type="text" id="pkgParamSearch" placeholder="Search parameters...">
         </div>
      </div>

      <div class="pkg-params-list" id="pkgParamsList">
         @if(isset($data->testdetails))
            @foreach($data->testdetails as $td)

               @if($td->type==1)
                  @foreach($parameter_list as $pl)
                     @if($td->type_id==$pl->id)
                        <div class="pkg-param-card" data-search="{{ strtolower($pl->name) }}">
                           <button type="button" class="pkg-param-card-head" onclick="gotoparam('{{$pl->slug}}')">
                              <span class="pkg-param-card-icon"><i data-lucide="flask-conical"></i></span>
                              <span class="pkg-param-card-name">{{$pl->name}}</span>
                              @if(isset($pl->short_desc) && $pl->short_desc !== '')
                                 <span class="pkg-param-card-desc">{{ $pl->short_desc }}</span>
                              @endif
                              <span class="pkg-param-card-arrow"><i data-lucide="arrow-right"></i></span>
                           </button>
                        </div>
                     @endif
                  @endforeach
               @endif

               @if($td->type==2)
                  @foreach($profiles_list as $pl)
                     @if($td->type_id==$pl->id)
                        <?php $arr = explode(",", $pl->no_of_parameter); ?>
                        <div class="pkg-param-card pkg-param-card--profile" data-search="{{ strtolower($pl->profile_name) }}">
                           <button type="button" class="pkg-param-card-head" type="button" data-toggle="collapse" data-parent="#pkgParamsList" href="#collapse{{$td->type_id}}" aria-expanded="false" aria-controls="collapse{{$td->type_id}}">
                              <span class="pkg-param-card-icon"><i data-lucide="layers"></i></span>
                              <span class="pkg-param-card-name" onclick="event.stopPropagation();gotoprofile('{{$pl->slug}}');">{{$pl->profile_name}}</span>
                              <span class="pkg-param-card-desc">{{ count($arr) }} tests included</span>
                              <span class="pkg-param-card-arrow"><i data-lucide="chevron-down"></i></span>
                           </button>
                           <div id="collapse{{$td->type_id}}" class="panel-collapse collapse pkg-param-card-body">
                              <ul class="pkg-param-sublist">
                                 @foreach($parameter_list as $a)
                                    @if(in_array($a->id,$arr))
                                       <li>
                                          <i data-lucide="check"></i> {{$a->name}}
                                       </li>
                                    @endif
                                 @endforeach
                              </ul>
                           </div>
                        </div>
                     @endif
                  @endforeach
               @endif

            @endforeach
         @endif
      </div>
      <p class="pkg-params-empty" id="pkgParamsEmpty" style="display:none;">No parameters match your search.</p>
   </div>
</section>

<!-- ===================== BENEFITS ===================== -->
<section class="pkg-benefits-section reveal">
   <div class="auto-container">
      <div class="pkg-section-header">
         <h2 class="pkg-section-title">Benefits of This Package</h2>
      </div>
      <div class="pkg-benefits-grid">
         <div class="pkg-benefit-card">
            <div class="pkg-benefit-icon"><i data-lucide="flask-conical"></i></div>
            <h4>{{isset($data->parameter)?$data->parameter:0}} Parameters Covered</h4>
            <p>Comprehensive testing across multiple health markers in one booking.</p>
         </div>
         @if(isset($data->sample_collection) && $data->sample_collection=='1')
         <div class="pkg-benefit-card">
            <div class="pkg-benefit-icon"><i data-lucide="car"></i></div>
            <h4>Free Home Collection</h4>
            <p>Our phlebotomist visits your home at a time slot that suits you.</p>
         </div>
         @endif
         <div class="pkg-benefit-card">
            <div class="pkg-benefit-icon"><i data-lucide="stethoscope"></i></div>
            <h4>Free Doctor Consultation</h4>
            <p>Get expert guidance on interpreting your results after the report is ready.</p>
         </div>
         <div class="pkg-benefit-card">
            <div class="pkg-benefit-icon"><i data-lucide="file-text"></i></div>
            <h4>Digital Reports</h4>
            <p>Access secure, downloadable reports online as soon as they're ready.</p>
         </div>
      </div>
   </div>
</section>

<!-- ===================== WHY CHOOSE THIS PACKAGE ===================== -->
<section class="pkg-why-section reveal">
   <div class="auto-container">
      <div class="pkg-section-header">
         <h2 class="pkg-section-title">Why Choose This Package</h2>
      </div>
      <div class="pkg-why-grid">
         <div class="pkg-why-card">
            <div class="pkg-why-icon"><i data-lucide="shield-check"></i></div>
            <h4>Certified Labs</h4>
            <p>Processed at NABL accredited partner laboratories.</p>
         </div>
         <div class="pkg-why-card">
            <div class="pkg-why-icon"><i data-lucide="user-round-check"></i></div>
            <h4>Expert Pathologists</h4>
            <p>Every sample is reviewed by experienced pathologists.</p>
         </div>
         <div class="pkg-why-card">
            <div class="pkg-why-icon"><i data-lucide="home"></i></div>
            <h4>Home Collection</h4>
            <p>Skip the queue — give your sample from the comfort of home.</p>
         </div>
         <div class="pkg-why-card">
            <div class="pkg-why-icon"><i data-lucide="lock"></i></div>
            <h4>Secure Reports</h4>
            <p>Your health data is encrypted and accessible only to you.</p>
         </div>
         <div class="pkg-why-card">
            <div class="pkg-why-icon"><i data-lucide="badge-percent"></i></div>
            <h4>Affordable Pricing</h4>
            <p>Transparent pricing with genuine discounts, no hidden charges.</p>
         </div>
         <div class="pkg-why-card">
            <div class="pkg-why-icon"><i data-lucide="zap"></i></div>
            <h4>Fast Reports</h4>
            <p>{{ isset($data->report_time) && $data->report_time !== '' ? 'Reports in '.$data->report_time : 'Quick turnaround on results' }}.</p>
         </div>
      </div>
   </div>
</section>

@include('front.how_book')

<!-- ===================== LABS SECTION ===================== -->
@if(isset($labs) && count($labs) > 0)
<section class="pkg-labs-section reveal">
   <div class="auto-container">
      <div class="pkg-section-header">
         <h2 class="pkg-section-title">Labs Near You in {{ ucfirst($cityName) }}</h2>
      </div>
      <div class="pkg-labs-grid">
         @foreach($labs as $df)
            @include('front.centercard')
         @endforeach
      </div>
   </div>
</section>
@endif

<!-- ===================== FAQs ===================== -->
@if(count($data->package_frq)>0)
<section class="pkg-faq-section reveal">
   <div class="auto-container">
      <div class="pkg-section-header">
         <h2 class="pkg-section-title">{{__('message.FRQ')}}</h2>
      </div>
      <div class="faq-accordion" id="pkgFaqAccordion">
         @foreach($data->package_frq as $dp)
            <div class="hd-faq-item">
               <button type="button" class="hd-faq-question" aria-expanded="false">
                  <span>{{$dp->question}}</span>
                  <span class="hd-faq-icon" aria-hidden="true"><i data-lucide="plus"></i></span>
               </button>
               <div class="hd-faq-answer">
                  <div class="hd-faq-answer-inner">
                     <p>{{$dp->ans}}</p>
                  </div>
               </div>
            </div>
         @endforeach
      </div>
   </div>
</section>
@endif

<!-- ===================== RELATED PACKAGES ===================== -->
@if(isset($data->realted_package) && count($data->realted_package) > 0)
<section class="pkg-related-section reveal">
   <div class="auto-container">
      <div class="pkg-section-header">
         <h2 class="pkg-section-title">Related Packages</h2>
      </div>
      <div class="pkg-related-scroller">
         @foreach($data->realted_package as $pl)
            <div class="pkg-related-item">
               @include('front.card')
            </div>
         @endforeach
      </div>
   </div>
</section>
@endif

<!-- ===================== CUSTOMER REVIEWS ===================== -->
@if(isset($reviewlist) && count($reviewlist) > 0)
<section class="pkg-reviews-section reveal">
   <div class="auto-container">
      <div class="pkg-section-header">
         <h2 class="pkg-section-title">Customer Reviews <span>({{ $data->total_review }})</span></h2>
      </div>
      <div class="pkg-reviews-grid">
         @foreach($reviewlist as $rv)
            <?php
               $rvName = $rv->userdata->name ?? 'Anonymous';
               $rvInitial = strtoupper(substr(trim($rvName), 0, 1)) ?: '?';
               $rvStars = (int) explode('.', (string) $rv->ratting)[0];
            ?>
            <div class="pkg-review-card">
               <div class="pkg-review-head">
                  <span class="pkg-review-avatar">{{ $rvInitial }}</span>
                  <div>
                     <h5 class="pkg-review-name">{{ $rvName }}</h5>
                     <span class="pkg-review-stars">
                        @for($i=0;$i<5;$i++)
                           <i data-lucide="star" class="{{ $i < $rvStars ? 'is-filled' : '' }}"></i>
                        @endfor
                     </span>
                  </div>
                  <span class="pkg-review-date">{{ \Carbon\Carbon::parse($rv->created_at)->format('d M Y') }}</span>
               </div>
               <p class="pkg-review-text">{{ $rv->description }}</p>
            </div>
         @endforeach
      </div>
   </div>
</section>
@endif

<!-- ===================== MOBILE STICKY BOOKING BAR ===================== -->
<div class="pkg-mobile-bar">
   <div class="pkg-mobile-bar-price">
      @if($hdHasDiscount)
         <span class="pkg-mobile-bar-original">₹{{ number_format($hdOriginal, 0) }}</span>
      @endif
      <span class="pkg-mobile-bar-current">₹{{ number_format($hdCurrent, 0) }}</span>
   </div>
   <a href="tel:{{ $setting->phone }}" class="pkg-mobile-bar-call" aria-label="Call us"><i data-lucide="phone"></i></a>
   <a href="{{ route('checkouts', ['id' => $data->id, 'type' => 1, 'parameter' => $data->parameter ?? '0']) }}" class="pkg-mobile-bar-book">
      {{ __('message.Book Now') }}
   </a>
</div>

@stop

@section('footer')

<script type="text/javascript">

    document.querySelector('.show-btn').addEventListener('click', function() {

     document.querySelector('.sm-menu').classList.toggle('active');

   });



    function gotoparam(val){

         cityname = "<?php echo $cityName; ?>";

      window.location.href="{{url('parameter')}}/"+cityname+"/"+val;

    }



    function gotoprofile(val){

    //    console.log(val);

     cityname = "<?php echo $cityName; ?>";

      window.location.href="{{url('profile')}}/"+cityname+"/"+val;

    }

    // Profile accordion open/close (mirrors Bootstrap collapse behaviour
    // without requiring jQuery/Bootstrap JS on this page).
    document.querySelectorAll('#pkgParamsList .pkg-param-card--profile .pkg-param-card-head').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var card = btn.closest('.pkg-param-card--profile');
            var body = card.querySelector('.pkg-param-card-body');
            var isOpen = body.classList.contains('show');
            body.classList.toggle('show', !isOpen);
            btn.setAttribute('aria-expanded', String(!isOpen));
        });
    });

    // Parameter/profile search filter.
    (function () {
        var input = document.getElementById('pkgParamSearch');
        var list = document.getElementById('pkgParamsList');
        var empty = document.getElementById('pkgParamsEmpty');
        if (!input || !list) return;
        input.addEventListener('input', function () {
            var q = input.value.trim().toLowerCase();
            var visible = 0;
            list.querySelectorAll('.pkg-param-card').forEach(function (card) {
                var match = card.getAttribute('data-search').indexOf(q) !== -1;
                card.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            if (empty) empty.style.display = visible === 0 ? '' : 'none';
        });
    })();

    // "Get a free call" triggers on this page open the same global
    // #needhelp modal as the site-wide callback FAB (id="request-button"
    // in front.layout) — reuses that modal instead of duplicating its id.
    document.querySelectorAll('.js-request-callback').forEach(function (btn) {
        btn.addEventListener('click', function () {
            $('#needhelp').modal('show');
        });
    });

    // FAQ accordion on this page (separate accordion container id from
    // the homepage's #hdFaqAccordion, same open/close behaviour).
    (function () {
        var accordion = document.getElementById('pkgFaqAccordion');
        if (!accordion) return;
        accordion.addEventListener('click', function (e) {
            var button = e.target.closest ? e.target.closest('.hd-faq-question') : null;
            if (!button) return;
            var item = button.parentElement;
            var isOpen = item.classList.contains('open');
            accordion.querySelectorAll('.hd-faq-item.open').forEach(function (other) {
                other.classList.remove('open');
                var q = other.querySelector('.hd-faq-question');
                if (q) q.setAttribute('aria-expanded', 'false');
            });
            if (!isOpen) {
                item.classList.add('open');
                button.setAttribute('aria-expanded', 'true');
            }
        });
    })();

</script>

@stop
