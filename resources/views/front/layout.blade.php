<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>@yield('title')</title>
    @yield('meta-data')
    <link rel="icon" href="{{asset('public/img').'/'.$setting->favicon}}" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href="{{asset('public/front/Docpro/assets/css/font-awesome-all.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/Docpro/assets/css/flaticon.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/Docpro/assets/css/owl.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/Docpro/assets/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/Docpro/assets/css/jquery.fancybox.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/Docpro/assets/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/Docpro/assets/css/color.css')}}" rel="stylesheet">
    <link href="{{asset('public/front/Docpro/assets/css/nice-select.css')}}" rel="stylesheet">
    @if($setting->is_rtl==1)
    <link href="{{ asset('public/front/Docpro/assets/css/app-rtl.min.css?v=fvdsjg') }}" rel="stylesheet" />
    @else
    <link href="{{asset('public/front/Docpro/assets/css/style.css?v=fdsf')}}" rel="stylesheet">
    @endif
    <link href="{{asset('public/front/Docpro/assets/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('public/front.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    @include('front.cssclass')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- HealthDex Homepage Design System (single consolidated stylesheet) -->
    <link rel="stylesheet" href="{{asset('public/hd-home.css')}}?v=hd24">

    <!-- Add these links in the <head> section of your HTML file -->

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google tag (gtag.js) -->

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-67TV67XTPF"></script>
   
    <style>
        #cityModal .modal-body {
            line-height: 1.6; /* Adjust line height as needed */
        }


    </style>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5JQ635HR');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JQ635HR" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="boxed_wrapper">
        <div class="preloader"></div>
        
        <!-- Luxury Header -->
        <header class="luxury-header" id="luxuryHeader">
            <!-- Top Bar -->
            <div class="luxury-top-bar">
                <div class="container">
                    <div class="luxury-top-bar-content">
                        <div class="luxury-top-bar-text">
                            <span><i data-lucide="phone"></i> {{$setting->phone}}</span>
                            <span><i data-lucide="mail"></i> {{$setting->email}}</span>
                        </div>
                        <div class="luxury-top-bar-text">
                            <span><i data-lucide="clock"></i> 24/7 Support Available</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Header -->
            <div class="luxury-main-header">
                <div class="container">
                    <div class="luxury-header-grid">
                        <!-- Logo -->
                        <div class="luxury-logo">
                            <a href="{{route('home')}}">
                                <img src="{{asset('public/img').'/'.$setting->logo}}" alt="369 HealthDex">
                            </a>
                        </div>
                        
                        <!-- Navigation -->
                        <nav class="luxury-nav d-none d-lg-flex">
                            <a href="{{route('home')}}" class="luxury-nav-link {{Session::get('active_menu')==1 ? 'active' : ''}}">Home</a>
                            <a href="{{route('popular-packages',['city'=>$cityName ?? 'rajkot'])}}" class="luxury-nav-link {{Session::get('active_menu')==4 ? 'active' : ''}}">Packages</a>
                            <a href="{{route('popular-blood-tests',['city'=>$cityName ?? 'rajkot'])}}" class="luxury-nav-link {{Session::get('active_menu')==11 ? 'active' : ''}}">Tests</a>
                            <a href="{{route('aboutus')}}" class="luxury-nav-link {{Session::get('active_menu')==7 ? 'active' : ''}}">About</a>
                            <a href="{{route('blog')}}" class="luxury-nav-link {{Session::get('active_menu')==71 ? 'active' : ''}}">Blog</a>
                            <a href="{{route('contact-us')}}" class="luxury-nav-link {{Session::get('active_menu')==6 ? 'active' : ''}}">Contact</a>
                        </nav>
                        
                        <!-- Right Actions -->
                        <div class="luxury-header-actions">
                                    <div class="rightpanel"> @php
                                        $loctionID = session()->get('loctionID');
                                        $userLat = session()->get('latitudes');

                                        $cityName = session()->get('cityName');
                                        if($cityName == ''){
                                        $cityName='rajkot';
                                        }

                                        $userLng = session()->get('longitudes');
                                        if($userLat == ''){
                                        $userLat = 26.9124;
                                        $userLng= 75.7873;
                                        }

                                        $citydata = \App\Models\City::select('*',DB::raw('(6371 * acos(cos(radians(' .
                                        $userLat . ')) * cos(radians(lat)) * cos(radians(lng) - radians('. $userLng .
                                        ')) + sin(radians(' . $userLat . ')) * sin(radians(lat)))) as
                                        distance'))->orderBy('distance', 'asc')->where('default','=','Yes')->get();
                                        $groupedCities = $citydata->groupBy('state');

                                        $popular_package = \App\Models\Package::whereNull('deleted_at')->take(6)->get();
                                        @endphp
                                        
                                        <!-- Location -->
                                        <a href="javascript:void(0)" onclick="openCityModal()" class="luxury-header-action">
                                            <i data-lucide="map-pin"></i>
                                            <span class="d-none d-md-inline">
                                                @php $i = 0; @endphp
                                                @foreach($citydata as $lab)
                                                    @if($lab->id == session()->get('loctionID'))
                                                        @php $i = 2; @endphp
                                                        {{$lab->city}}
                                                    @endif
                                                @endforeach
                                                @if($i == 0)
                                                    {{$citydata[0]['city']}}
                                                @endif
                                            </span>
                                        </a>
                                        
                                        <!-- User -->
                                        @if(Auth::id())
                                        <div class="dropdown">
                                            <a class="luxury-header-action dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i data-lucide="user"></i>
                                                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                                <a class="dropdown-item" href="{{ route('dashboard') }}">{{ __('message.My Account') }}</a>
                                                <a class="dropdown-item" href="{{ route('user-logout') }}">Sign Out</a>
                                            </div>
                                        </div>
                                        @else
                                        <a href="{{route('user-login')}}" class="luxury-header-action">
                                            <i data-lucide="user"></i>
                                            <span class="d-none d-md-inline">Sign In</span>
                                        </a>
                                        @endif

                                        <!-- Cart -->
                                        <a href="{{ route('checkout') }}" class="luxury-header-action luxury-header-cart">
                                            <i data-lucide="shopping-cart"></i>
                                            @if(isset($totalcartmember) && $totalcartmember > 0)
                                            <span class="luxury-cart-badge">{{ $totalcartmember }}</span>
                                            @endif
                                        </a>

                                        <!-- Sticky CTA -->
                                        <a href="{{route('popular-packages',['city'=>$cityName ?? 'rajkot'])}}" class="luxury-header-cta d-none d-xl-inline-flex">
                                            <span>Book a Test</span>
                                            <i data-lucide="arrow-right"></i>
                                        </a>

                                        <!-- Mobile Menu Toggle -->
                                        <button class="luxury-header-action luxury-hamburger d-lg-none" id="mobileMenuToggle" aria-label="Open menu" aria-expanded="false">
                                            <span class="luxury-hamburger-box" aria-hidden="true">
                                                <span class="luxury-hamburger-bar"></span>
                                                <span class="luxury-hamburger-bar"></span>
                                                <span class="luxury-hamburger-bar"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </header>


                        <!-- City Modal -->
                        <div class="modal" id="cityModal">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
                                    <div class="modal-header" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border-bottom: 1px solid rgba(16, 185, 129, 0.1); padding: 20px 24px;">
                                        <h5 class="modal-title" style="font-weight: 700; color: #111827;">Change Location</h5>
                                        <input type="text" id="citySearch" onkeyup="filterCities()" class="form-control" placeholder="Search for a Location..." style="border-radius: 12px; border: 2px solid #e5e7eb; padding: 12px 16px; max-width: 300px;">
                                        <button type="button" class="close" data-dismiss="modal" onclick="closeCityModal()" style="opacity: 0.5;">&times;</button>
                                    </div>
                                    <div class="modal-body" style="padding: 24px;">
                                        <div id="cityList">
                                            @foreach($groupedCities as $state => $cities)
                                                <div class="state-group" style="margin-bottom: 20px;">
                                                    <h6 style="font-weight: 700; color: #374151; margin-bottom: 12px; font-size: 14px;">{{$state}}</h6>
                                                    <div class="row">
                                                        @foreach($cities as $lab)
                                                            <div class="col-md-3 col-6 city-item" data-city="{{$lab->city}}" data-state="{{$state}}" style="margin-bottom: 8px;">
                                                                @if($lab->id == session()->get('loctionID'))
                                                                    <a href="javascript:void(0);" onclick="onCityClick('{{$lab->id}}', '{{$lab->slug}}')" class="hd-city-link hd-city-link-active">{{$lab->city}}</a>
                                                                @else
                                                                    <a href="javascript:void(0);" class="hd-city-link @if($lab->status == 0) hd-city-link-soon @endif" @if($lab->status != 0) onclick="onCityClick('{{$lab->id}}', '{{$lab->slug}}')" @endif>
                                                                        {{$lab->city}}
                                                                        @if($lab->status == 0)
                                                                            <small>(Coming soon)</small>
                                                                        @endif
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Menu -->
                        <div class="mobile-menu d-lg-none">
                            <div class="menu-backdrop"></div>
                            <div class="close-btn" role="button" aria-label="Close menu" tabindex="0"><i data-lucide="x"></i></div>
                            <nav class="menu-box" aria-label="Mobile navigation">
                                <div class="hd-mobile-logo">
                                    <a href="{{route('home')}}"><img src="{{asset('public/img').'/'.$setting->footer_logo}}" alt="{{__('message.site_name')}}"></a>
                                </div>
                                <div class="hd-mobile-nav">
                                    <ul>
                                        <li><a href="{{route('home')}}" class="{{Session::get('active_menu')==1 ? 'active' : ''}}"><i data-lucide="house"></i>Home<i data-lucide="chevron-right" class="hd-mobile-nav-arrow"></i></a></li>
                                        <li><a href="{{route('popular-packages',['city'=>$cityName])}}" class="{{Session::get('active_menu')==4 ? 'active' : ''}}"><i data-lucide="package"></i>Packages<i data-lucide="chevron-right" class="hd-mobile-nav-arrow"></i></a></li>
                                        <li><a href="{{route('popular-blood-tests',['city'=>$cityName])}}" class="{{Session::get('active_menu')==11 ? 'active' : ''}}"><i data-lucide="test-tubes"></i>Tests<i data-lucide="chevron-right" class="hd-mobile-nav-arrow"></i></a></li>
                                        <li><a href="{{route('aboutus')}}" class="{{Session::get('active_menu')==7 ? 'active' : ''}}"><i data-lucide="heart-handshake"></i>About<i data-lucide="chevron-right" class="hd-mobile-nav-arrow"></i></a></li>
                                        <li><a href="{{route('blog')}}" class="{{Session::get('active_menu')==71 ? 'active' : ''}}"><i data-lucide="newspaper"></i>Blog<i data-lucide="chevron-right" class="hd-mobile-nav-arrow"></i></a></li>
                                        <li><a href="{{route('contact-us')}}" class="{{Session::get('active_menu')==6 ? 'active' : ''}}"><i data-lucide="phone"></i>Contact<i data-lucide="chevron-right" class="hd-mobile-nav-arrow"></i></a></li>
                                    </ul>
                                </div>
                                <div class="hd-mobile-cta">
                                    <a href="{{route('popular-packages',['city'=>$cityName])}}" class="premium-btn premium-btn-primary">
                                        Book a Test
                                        <i data-lucide="arrow-right"></i>
                                    </a>
                                </div>
                                <div class="hd-mobile-contact">
                                    <h4>Contact Info</h4>
                                    <ul>
                                        <li><i data-lucide="phone"></i><a href="tel:{{$setting->phone}}">{{$setting->phone}}</a></li>
                                        <li><i data-lucide="mail"></i><a href="mailto:{{$setting->email}}">{{$setting->email}}</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
        
        @yield('content')
        
        <!-- Premium Footer -->
        <footer class="premium-footer">
            <div class="footer-glow-1"></div>
            <div class="footer-glow-2"></div>
            
            <div class="container">
                <!-- CTA Strip -->
                <div class="footer-cta-strip">
                    <div class="footer-cta-content">
                        <h3 class="footer-cta-title">Need Help Booking Your Health Test?</h3>
                        <p class="footer-cta-description">Our team is ready to assist you with test selection and home sample collection</p>
                    </div>
                    <div class="footer-cta-buttons">
                        <a href="{{route('popular-packages',['city'=>$cityName ?? 'rajkot'])}}" class="footer-btn footer-btn-primary">
                            Book Now
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="{{route('contact-us')}}" class="footer-btn footer-btn-secondary">
                            <i data-lucide="phone"></i>
                            Contact Us
                        </a>
                    </div>
                </div>
                
                <!-- Main Footer -->
                <div class="footer-main">
                    <div class="footer-grid">
                        <!-- Brand Column -->
                        <div class="footer-brand">
                            <a href="{{route('home')}}" class="footer-logo">
                                <img src="{{asset('public/img').'/'.$setting->footer_logo}}" alt="369 HealthDex">
                            </a>
                            <p class="footer-description">{{__('message.footer text')}}</p>
                            
                            <!-- Trust Badges -->
                            <div class="footer-trust-badges">
                                <span class="footer-trust-badge">
                                    <i data-lucide="check"></i>
                                    NABL Certified
                                </span>
                                <span class="footer-trust-badge">
                                    <i data-lucide="check"></i>
                                    Trusted Healthcare
                                </span>
                                <span class="footer-trust-badge">
                                    <i data-lucide="check"></i>
                                    Secure Reports
                                </span>
                                <span class="footer-trust-badge">
                                    <i data-lucide="check"></i>
                                    Home Collection
                                </span>
                            </div>
                            
                            <!-- Social Media -->
                            <div class="footer-social">
                                <a href="https://x.com/Healthdex369" target="_blank" class="footer-social-link">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.facebook.com/share/1DWpjpUHcy/" target="_blank" class="footer-social-link">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://www.linkedin.com" target="_blank" class="footer-social-link">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://www.instagram.com/healthdex369" target="_blank" class="footer-social-link">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Quick Links -->
                        <div class="footer-column">
                            <h4 class="footer-title">{{__('message.Useful Links')}}</h4>
                            <div class="footer-links">
                                <a href="{{route('aboutus')}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    {{__('message.About Us')}}
                                </a>
                                <a href="{{route('blog')}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    Blog
                                </a>
                                <a href="{{route('career')}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    Careers
                                </a>
                                <a href="{{route('contact-us')}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    {{__('message.Contact Us')}}
                                </a>
                                <a href="{{route('feedback')}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    Feedback
                                </a>
                                <a href="{{route('Privacy_Policy')}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    {{__("message.Privacy Policy")}}
                                </a>
                                <a href="{{route('Terms_of_Service')}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    {{__("message.Terms of Service")}}
                                </a>
                                <a href="{{route('refund_policy')}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    Refund Policy
                                </a>
                            </div>
                        </div>
                        
                        <!-- Services -->
                        <div class="footer-column">
                            <h4 class="footer-title">Patients</h4>
                            <div class="footer-links">
                                <a href="{{route('popular-blood-tests',['city'=>$cityName ?? 'rajkot'])}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    Popular Tests
                                </a>
                                <a href="{{route('popular-packages',['city'=>$cityName ?? 'rajkot'])}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    {{__('message.Popular Package')}}
                                </a>
                                <a href="{{route('nearest_center')}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    Nearest Centre
                                </a>
                                <a href="{{route('download-report')}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    Download Report
                                </a>
                                @if(Auth::id())
                                <a href="{{route('dashboard')}}" class="footer-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                    {{__('message.My Account')}}
                                </a>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Contact Info -->
                        <div class="footer-column">
                            <h4 class="footer-title">{{__('message.Contacts')}}</h4>
                            <div class="footer-contact-items">
                                <div class="footer-contact-item">
                                    <div class="footer-contact-icon">
                                        <i data-lucide="phone"></i>
                                    </div>
                                    <div class="footer-contact-content">
                                        <p class="footer-contact-label">Phone</p>
                                        <a href="tel:{{$setting->phone}}" class="footer-contact-value">{{$setting->phone}}</a>
                                    </div>
                                </div>
                                <div class="footer-contact-item">
                                    <div class="footer-contact-icon">
                                        <i data-lucide="mail"></i>
                                    </div>
                                    <div class="footer-contact-content">
                                        <p class="footer-contact-label">Email</p>
                                        <a href="mailto:{{$setting->email}}" class="footer-contact-value">{{$setting->email}}</a>
                                    </div>
                                </div>
                                <div class="footer-contact-item">
                                    <div class="footer-contact-icon">
                                        <i data-lucide="map-pin"></i>
                                    </div>
                                    <div class="footer-contact-content">
                                        <p class="footer-contact-label">Address</p>
                                        <p class="footer-contact-value">{{$setting->address}}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Download App Card -->
                            <div class="footer-app-card">
                                <h4 class="footer-app-title">Download Our App</h4>
                                <div class="footer-app-buttons">
                                    <a href="{{$setting->appstore_url}}" target="_blank" class="footer-app-btn">
                                        <i class="fab fa-apple"></i>
                                        <div class="footer-app-btn-text">
                                            <span class="footer-app-btn-label">Download on</span>
                                            <span class="footer-app-btn-name">App Store</span>
                                        </div>
                                    </a>
                                    <a href="{{$setting->playstore_url}}" target="_blank" class="footer-app-btn">
                                        <i class="fab fa-google-play"></i>
                                        <div class="footer-app-btn-text">
                                            <span class="footer-app-btn-label">Get it on</span>
                                            <span class="footer-app-btn-name">Google Play</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </footer>
        <!--<button class="scroll-top scroll-to-target" data-target="html"> <span class="fa fa-arrow-up"></span> </button>-->
    </div>
    <button type="button" id="request-button" class="hd-callback-fab" aria-label="Request a callback">
        <span class="hd-callback-fab-icon"><i data-lucide="phone-call"></i></span>
        <span class="hd-callback-fab-label">Need Help?</span>
    </button>
    <div class="floating-whatsapp-a">
        <a aria-label="WhatsApp"
        href="https://wa.me/919828112340?text=Hi%21%20I%27m%20interested%20in%20your%20diagnostic%20services.%20Please%20help%20me%20with%20test%20booking%20and%20available%20health%20packages."
        target="_blank">
            <img src="https://rdccare.com/public/img/whatsapp.png" alt="Chat with us on WhatsApp" loading="lazy" />
        </a>
    </div>
    <div class="modal" id="addaddress">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="member_list">

                <!-- Modal Header -->

                <div class="modal-header">
                    <h4 class="modal-title">{{__("message.Select Member")}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->

                <div class="modal-body" id="memeber_list">
                    <form action="{{route('add-cart-member')}}" method="post" id="user_address"
                        class="registration-form boxed">
                        {{csrf_field()}}
                        <input type="hidden" name="type" id="book_type" value="">
                        <input type="hidden" name="type_id" id="book_type_id" value="">
                        <input type="hidden" name="mrp" id="book_mrp" value="">
                        <input type="hidden" name="price" id="book_price" value="">
                        <input type="hidden" name="parameter" id="book_parameter" value="">
                        <div id="member_list_div"> @if(isset($member_list))

                            @foreach($member_list as $ml)
                            <input type="checkbox" id="member_{{$ml->id}}" name="member[]" value="{{$ml->id}}"
                                class="check">
                            <label for="member_{{$ml->id}}">
                                {{$ml->name}}</br>
                                <p>{{$ml->relation}}</p>
                                <p>{{$ml->gender}} | {{$ml->age}}</p>
                            </label>
                            @endforeach

                            @endif
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="address_submit_button" onclick="closecontent('member_list','add_member')"
                        class="btn btn-success">{{__("message.Add Member")}}</button>
                    <button type="submit" id="address_submit_button" class="btn btn-success">{{__("message.Book Now")}}</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{__("message.Close")}}</button>
                </div>
                </form>
            </div>
            <div class="modal-content " id="add_member" style="display: none;">

                <!-- Modal Header -->

                <div class="modal-header">
                    <h4 class="modal-title">{{__("message.Add New Family Member")}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="#" method="post" id="member_form" class="registration-form">

                    <!-- Modal body -->

                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                <label>{{__("message.Relation")}}<span class="error">*</span></label>
                                <select class="form-control" name="relation" id="relation" required="">
                                    <option value="">{{__("message.Select Relation")}}</option>

                                    <!--<option value="Self">{{__("message.Self")}}</option>-->

                                    <option value="Spouse">{{__("message.Spouse")}}</option>
                                    <option value="Child">{{__("message.Child")}}</option>
                                    <option value="Parent">{{__("message.Parent")}}</option>
                                    <option value="Grand Parent">{{__("message.Grand Parent")}}</option>
                                    <option value="Sibling">{{__("message.Sibling")}}</option>
                                    <option value="Friend">{{__("message.Friend")}}</option>
                                    <option value="Relative">{{__("message.Relative")}}</option>
                                    <option value="Neighbour">{{__("message.Neighbour")}}</option>
                                    <option value="Colleague">{{__("message.Colleague")}}</option>
                                    <option value="Others">{{__("message.Others")}}</option>
                                </select>
                                <span id="error_relation" class="error"></span>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                <label>{{__("message.Name")}}<span class="error">*</span></label>
                                <input type="text" name="name" id="member_name"
                                    placeholder="{{__('message.Enter Name')}}" required="">
                                <span id="error_name" class="error"></span>
                            </div>
                            <!--<div class="col-lg-4 col-md-12 col-sm-12 form-group">-->
                            <!--    <label>{{__("message.email")}}<span class="error">*</span></label>-->
                            <!--    <input type="email" name="email" id="member_email"-->
                            <!--        placeholder="{{__('message.Enter Email')}}" required="">-->
                            <!--    <span id="error_email" class="error"></span>-->
                            <!--</div>-->
                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                <label>{{__("message.Phone")}}<span class="error">*</span></label>
                                <input type="text" name="phone" id="member_phone"
                                    placeholder="{{__('message.Enter Phone')}}" required="">
                                <span id="error_phone" class="error"></span>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                <label>{{__("message.Age")}}<span class="error">*</span></label>
                                <input type="number" name="age" id="member_age"
                                    placeholder="{{__('message.Enter Age')}}" required="">
                                <span id="error_age" class="error"></span>
                            </div>
                            <!--<div class="col-lg-4 col-md-6 col-sm-12 form-group">-->
                            <!--    <label>{{__("message.DOB")}}<span class="error">*</span></label>-->
                            <!--    <input type="date" name="dob" id="member_dob" required="">-->
                            <!--    <span id="error_dob" class="error"></span>-->
                            <!--</div>-->
                            <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                                <label>{{__("message.Gender")}}<span class="error">*</span></label>
                                <div class="custom-check-box">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control material-checkbox">
                                            <input type="radio" name="gender" id="gender_1" value="Male"
                                                class="material-control-input">
                                            <span class="material-control-indicator"></span> <span
                                                class="description">{{__("message.Male")}}</span> </label>
                                    </div>
                                </div>
                                <div class="custom-check-box">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control material-checkbox">
                                            <input type="radio" name="gender" id="gender_2" value="Female"
                                                class="material-control-input">
                                            <span class="material-control-indicator"></span> <span
                                                class="description">{{__("message.Female")}}</span> </label>
                                    </div>
                                </div>
                                <span id="error_gender" class="error"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="addmemberdata()">{{__("message.Add Member")}}</button>
                        <button type="button" class="btn btn-success"
                            onclick="closecontent('add_member','member_list')">{{__("message.Back to list")}}</button>
                        <button type="button" class="btn btn-danger"
                            data-dismiss="modal">{{__("message.Close")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="url_path" value="{{url('/')}}">
    <input type="hidden" name="password_match_error" id="password_match_error"
        value="{{__('message.Password and Confirm Password Must Be Same')}}">
    <input type="hidden" name="package_add_cart" id="package_add_cart"
        value="{{__('message.Package Add Into Cart Successfully')}}">
    <input type="hidden" name="email_enter_error" id="email_enter_error"
        value="{{__('message.Please Enter Your Email')}}">
    <input type="hidden" name="thanks_msg" id="thanks_msg" value="{{__('message.Thank you for getting in touch!')}}">
    <input type="hidden" name="email_invalid_err" id="email_invalid_err" value="{{__('message.Email Id Is Invaild')}}">
    <input type="hidden" name="delete_member_err" id="delete_member_err"
        value="{{__('message.Are You Sure Want To Delete This Member')}}?">
    <input type="hidden" name="delete_address_err" id="delete_address_err"
        value="{{__('message.Are You Sure Want To Delete This Address')}}?">
    <input type="hidden" name="currect_pass_err" id="currect_pass_err"
        value="{{__('message.Please Enter Correct Currect Password')}}">
    <input type="hidden" name="new_con_pass_err" id="new_con_pass_err"
        value="{{__('message.New Password And Re-enter Password Must Be Same')}}">
    <script type="text/javascript"
        src='https://maps.google.com/maps/api/js?key={{Config::get("mapdetail.key")}}&sensor=false&libraries=places'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="{{asset('public/front/Docpro/assets/js/jquery.js')}}"></script>
    <script src="{{asset('public/front/Docpro/assets/js/popper.min.js')}}"></script>
    <script src="{{asset('public/front/Docpro/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/front/Docpro/assets/js/owl.js')}}"></script>
    <script src="{{asset('public/front/Docpro/assets/js/wow.js')}}"></script>
    <script src="{{asset('public/front/Docpro/assets/js/swiper.js')}}?v=hd4"></script>
    <script src="{{asset('public/front/Docpro/assets/js/validation.js')}}"></script>
    <script src="{{asset('public/front/Docpro/assets/js/jquery.fancybox.js')}}"></script>
    <script src="{{asset('public/front/Docpro/assets/js/appear.js')}}"></script>
    <script src="{{asset('public/front/Docpro/assets/js/scrollbar.js')}}"></script>
    <script src="{{asset('public/front/Docpro/assets/js/tilt.jquery.js')}}"></script>
    <script src="{{asset('public/front/Docpro/assets/js/jquery.paroller.min.js')}}"></script>
    <script src="{{asset('public/front/Docpro/assets/js/jquery.nice-select.js')}}"></script>
    @if($setting->is_rtl==1)
    <script src="{{asset('public/front/Docpro/assets/js/script_rtl.js')}}"></script>
    @else
    <script src="{{asset('public/front/Docpro/assets/js/script.js')}}"></script>
    @endif
    <script src="{{asset('public/locationpicker.js')}}"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.0/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="{{asset('public/front.js')}}"></script>

    <div class="modal fade hd-help-modal" id="needhelp">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header hd-help-head">
                <span class="hd-help-glow" aria-hidden="true"></span>
                <span class="hd-help-icon"><i data-lucide="headset"></i></span>
                <div class="hd-help-head-text">
                    <h5 class="modal-title">Need help in booking tests?</h5>
                    <p>Our healthcare experts will help you book the right test.</p>
                </div>
                <!-- Close Button -->
                <button type="button" class="close hd-help-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body hd-help-body">
                <p class="hd-help-sub">Share your details and our health advisor will call you back shortly.</p>
                <form action="{{route('save_callback')}}" method="post" id="callback-form">
                @csrf
                    <div class="form-group hd-help-field">
                        <i data-lucide="user-round"></i>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name" required>
                    </div>
                    <div class="form-group hd-help-field">
                        <i data-lucide="phone"></i>
                        <input type="text" class="form-control" name="number" id="phone" placeholder="Enter Your Number" required>
                    </div>
                    <button type="submit" class="hd-help-submit">Request Callback<i data-lucide="arrow-right"></i></button>
                </form>
                <div class="hd-help-divider">or reach us directly</div>
                <div class="hd-help-contacts">
                    <a href="tel:{{$setting->phone}}" class="hd-help-call">
                        <i data-lucide="phone-call"></i>
                        {{$setting->phone}}
                    </a>
                    <a href="https://wa.me/919828112340?text=hi" target="_blank" rel="noopener noreferrer" class="hd-help-wa">
                        <i class="fab fa-whatsapp"></i>
                        WhatsApp
                    </a>
                </div>
                <p class="hd-help-trust"><i data-lucide="shield-check"></i>NABL certified labs &middot; Free home sample collection</p>
            </div>

        </div>
    </div>
</div>
    <div class="popup" id="popup">
        <div class="popup-content"> <span class="close-popup" id="close-popup">&times;</span>
            <h2>Request a Callback</h2>
            <form action="{{route('save_callback')}}" method="post" id="callback-form">
                @csrf
                <div class="form-group">
                    <input type="text" placeholder="Name" name="name" required>
                </div>
                <div class="form-group">
                    <input type="tel" placeholder="Phone Number" name="number" required>
                </div>
                <div class="form-group">
                    <textarea placeholder="Message" name="message"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-button">Submit</button>
                </div>
            </form>
        </div>
    </div>
   
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Please Login Your Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You need to log in to continue.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="loginButton">Login</button>
            </div>
        </div>
    </div>
</div>

    <script>

        document.getElementById("request-button").addEventListener("click", function () {

            // document.getElementById("popup").style.display = "block";
             $('#needhelp').modal('show');

        });



        document.getElementById("close-popup").addEventListener("click", function () {

            document.getElementById("popup").style.display = "none";

        });



        document.getElementById("popup").addEventListener("click", function (event) {

            if (event.target === this) {

                document.getElementById("popup").style.display = "none";

            }

        });



        function showmember(id, mrp, price, parameter, type) {

            $("#book_type_id").val(id);

            $("#book_mrp").val(mrp);

            $("#book_price").val(price);

            $("#book_parameter").val(parameter);

            $("#book_type").val(type);

        }

        function notlogin(){

            swal({

                title: "Please Login Your Account",

                text: "",

                type: "warning",

                confirmButtonText: "Login",

                showCancelButton: true

            })

                .then((result) => {

                    if (result.value) {

                        window.location = $("#url_path").val() + '/login';

                    } else if (result.dismiss === 'cancel') {

                        swal(

                            'Cancelled',

                            'Your stay here :)',

                            'error'

                        )

                    }

                })

        }



        function closecontent(close, open) {

            $("#" + close).css("display", "none");

            $("#" + open).css("display", "block");

        }



        function addmemberdata() {

            var relation = $("#relation").val();

            var name = $("#member_name").val();

            var email = $("#member_email").val();

            var phone = $("#member_phone").val();

            var age = $("#member_age").val();

            var dob = $("#member_dob").val();

            var gender = $('input[name=gender]:checked').val();

            var msg = "";

            if (relation == "") {

                $("#error_relation").html("Please Select Relation");

                msg = 1;

            }

            if (name == "") {

                $("#error_name").html("Please Add Member Name");

                msg = 1;

            }

           

            if (phone == "") {

                $("#error_phone").html("Please Enter Phone no");

                msg = 1;

            }

            if (age == "") {

                $("#error_age").html("Please Enter Member Age");

                msg = 1;

            }

           

            if (gender == "") {

                $("#error_gender").html("Please Select Gender");

                msg = 1;

            }

            if (msg == "") {

                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });

                $.ajax({

                    url: $("#url_path").val() + '/save_member_detail',

                    method: 'post',

                    data: $('#member_form').serialize(),

                    success: function (response) {

                        $("#relation").val("");

                        $("#member_name").val("");

                        $("#member_email").val("");

                        $("#member_phone").val("");

                        $("#member_age").val("");

                        $("#member_dob").val("");

                        $("#error_relation").html("");

                        $("#error_name").html("");

                        $("#error_email").html("");

                        $("#error_phone").html("");

                        $("#error_age").html("");

                        $("#error_dob").html("");

                        $("#error_gender").html("");

                        $("#gender").attr("checked", true);

                        $("#gender").attr("checked", false);

                        var txt = ' <input type="checkbox" id="member_' + response + '" name="member[]" value="' + response + '"><label for="member_' + response + '">' + name + '</br> <p>' + relation + '</p><p>' + gender + ' | ' + age + '</p></label>';

                        $("#member_list_div").append(txt);

                        $("#add_member").css("display", "none");

                        $("#member_list").css("display", "block");



                    }

                });

            }

        }



    </script>
    <script>

        // Check if geolocation is available in the browser

        if (navigator.geolocation) {

            // Get the user's current location

            navigator.geolocation.getCurrentPosition(

                function (position) {

                    // Get the latitude and longitude values

                    const latitude = position.coords.latitude;

                    const longitude = position.coords.longitude;

                    // Store the coordinates in the session so lab distances are
                    // computed from the visitor's real position. Skip the call
                    // when this tab already sent the same coordinates.

                    const queryString = `latitude=${latitude}&longitude=${longitude}`;

                    const url = $("#url_path").val() + `/update-location?${queryString}`;

                    const geoKey = latitude.toFixed(4) + ',' + longitude.toFixed(4);

                    if (sessionStorage.getItem('hdGeoSent') !== geoKey) {

                        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })

                            .then(function (response) {

                                if (response.ok) {

                                    sessionStorage.setItem('hdGeoSent', geoKey);

                                }

                            })

                            .catch(function (error) {

                                console.error('Failed to store location:', error);

                            });

                    }

                },

                function (error) {

                    console.error('Error getting location:', error);

                }

            );

        } else {

            console.error('Geolocation is not available in this browser.');

        }
        function reloadCaptcha() {
            document.getElementById('captcha-img').src = '{{ url("/custom-captcha") }}?' + Math.random();
        }
        
        // Luxury Header Scroll Effect
        (function() {
            const header = document.getElementById('luxuryHeader');
            if (header) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 50) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }
                });
            }
        })();
        
        // Mobile Menu Toggle
        (function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenu = document.querySelector('.mobile-menu');
            const menuBackdrop = document.querySelector('.menu-backdrop');
            const closeBtn = document.querySelector('.mobile-menu .close-btn');
            
            function setMenuState(open) {
                mobileMenu.classList.toggle('active', open);
                mobileMenuToggle.classList.toggle('is-open', open);
                mobileMenuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                document.body.classList.toggle('hd-menu-open', open);
            }

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    setMenuState(!mobileMenu.classList.contains('active'));
                });

                if (closeBtn) {
                    closeBtn.addEventListener('click', function() {
                        setMenuState(false);
                    });
                }

                if (menuBackdrop) {
                    menuBackdrop.addEventListener('click', function() {
                        setMenuState(false);
                    });
                }

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                        setMenuState(false);
                    }
                });
            }
        })();
        
        // Scroll Reveal Animation
        (function() {
            const reveals = document.querySelectorAll('.reveal');
            
            function revealOnScroll() {
                reveals.forEach(function(element) {
                    const windowHeight = window.innerHeight;
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < windowHeight - elementVisible) {
                        element.classList.add('active');
                    }
                });
            }
            
            window.addEventListener('scroll', revealOnScroll);
            revealOnScroll();
        })();
    </script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        (function initLucide() {
            if (window.lucide && typeof window.lucide.createIcons === 'function') {
                window.lucide.createIcons();
            } else {
                setTimeout(initLucide, 60);
            }
        })();
    </script>
    <!-- HealthDex premium interactions (reveals, counters, parallax, ripple, FAQ) -->
    <script src="{{asset('public/hd-home.js')}}?v=hd4"></script>
    @yield('footer')
</body>

</html>