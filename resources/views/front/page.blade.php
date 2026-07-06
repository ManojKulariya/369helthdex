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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .red{
        color:#e6ae05;
    }
    .13px{
        font-size:13px;
    }
    .about-main {
    display: flex;
    flex-wrap: wrap; /* Ensure responsiveness */
    justify-content: center; /* Center the boxes */
    gap: 20px; /* Add space between boxes */
    background-color:#2aa48c;
    border-radius:5px;
    padding-top:10px;
    padding-bottom:10px;
    }
    .about-21{
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
        border-radius: 5px; /* Rounded corners */
        /*border: 2px solid black; */
        padding:15px;
    }
    
    .about-box {
        background-color: white; /* White background */
        padding: 10px; /* Padding inside */
        border-radius: 10px; /* Rounded corners */
        border: 2px solid black; /* Black border */
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2); /* Shadow effect */
        /*display: flex;*/
        align-content: center;
        justify-content: center;
        gap: 8px; /* Space between icon and text */
        width: calc(100% / 6 - 10px); /* Ensure equal width (adjust as needed) */
        height: 180px; /* Fixed height for all boxes */
        text-align: center;
    }
    
    /* Responsive fix for smaller screens */
    @media (max-width: 768px) {
        .about-box {
            width: calc(50% - 10px); /* Two items per row */
        }
    }
    
    @media (max-width: 480px) {
        .about-box {
            width: 100%; /* Full width for smaller screens */
        }
    }

    /* Zoom Effect on Hover */
    .about-box:hover {
        transform: scale(1.1); /* Zoom effect */
        box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3); /* Stronger shadow */
    }
    .about-box i {
        font-size: 20px; /* Adjust icon size */
    }
    .icon-svg {
        width: 65px; /* Adjust icon size */
        height: 65px;
        transition: transform 0.3s ease-in-out; /* Smooth transition */
    }
    
    
    .about-21-row {
        display: flex;
        flex-wrap: wrap;
        gap: 15px; /* Space between boxes */
        justify-content: center;
        
    }
    
    .about-card-1 {
        background-color: #2aa48c;
        padding: 12px;
        border-radius: 10px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
        text-align: center;
        font-size: 16px;
        min-height: 90px;
        flex: 1 1 calc(25% - 15px); /* 4 items per row, accounting for spacing */
        display: flex;
        align-items: center;
        /*justify-content: center;*/
        color:white;
    }
    .services-text{
        font-size: 0.9rem;
        line-height: 1.5rem;
        --tw-text-opacity: 1;
        color: rgb(103 103 103 / var(--tw-text-opacity));
    }
    .about-card-12 {
        /*background-color: #2aa48c;*/
        padding: 15px;
        border-radius: 10px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
        /*text-align: center;*/
        font-size: 14px;
        /*min-height: 100px;*/
        flex: 1 1 calc(25% - 15px); /* 4 items per row, accounting for spacing */
        /*display: flex;*/
        /*align-items: center;*/
        /*justify-content: center;*/
        /*color:white;*/
    }
    
    /* Responsive Breakpoints */
    @media (max-width: 992px) {
        .about-card-1 {
            flex: 1 1 calc(50% - 15px); /* 2 items per row on tablets */
        }
        .about-card-12 {
            flex: 1 1 calc(50% - 15px); /* 2 items per row on tablets */
        }
    }
    
    @media (max-width: 576px) {
        .about-card-1 {
            flex: 1 1 100%; /* 1 item per row on small screens */
        }
    }
    .about-box {
            cursor: pointer;
    background-color: #f9f9f9;
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    height: auto;
    min-height: 140px;
    text-align: center;
    transition: all 0.3s ease-in-out;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.about-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    background-color: #eef6ff;
}

.about-box i {
    font-size: 32px;
    margin-bottom: 10px;
    color: #2aa48c;
}

.about-box h6 {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

/* Responsive styles */
@media (max-width: 992px) {
    .about-box {
        width: calc(100% / 2 - 10px);
    }
}

@media (max-width: 768px) {
    .about-box {
        width: calc(50% - 10px);
    }
}

@media (max-width: 480px) {
    .about-box {
        width: 100%;
        /*font-size:10px !important;*/
    }
}
.about-box.active {
    background-color: #e6ae05;
    color: #fff;
    border-color: #e6ae05;
}

.about-box.active i,
.about-box.active h6 {
    color: #fff !important;
}

.steps-row {
        display: flex; /* <-- Flexbox enable kiya gaya */
        flex-wrap: wrap; 
        align-items: stretch; /* <-- Yeh ensure karega ki saare items ki height barabar ho */
        /* width set karne ki zarurat nahi, col-equal-5 sambhal lega */
    }
    
    .steps-row .col-equal-5 {
        width: 20%; 
        padding: 8px; 
    }

    /* Fixed Height aur content centering ke liye, ab min-height ko hata diya gaya hai */
    .steps-box-inner {
        height: 100%; /* <-- Ab inner box parent (col-equal-5) ki poori height lega */
        display: flex;
        flex-direction: column;
        justify-content: center; /* Content ko center mein rakhega */
    }
    
    /* Responsive Fix: Tablet aur Mobile par 2 ya 1 box dikhega */
    @media (max-width: 991.98px) {
        .steps-row .col-equal-5 {
            width: 33.33%; 
        }
    }
    @media (max-width: 767.98px) {
        .steps-row .col-equal-5 {
            width: 50%; 
        }
    }
    @media (max-width: 575.98px) {
        .steps-row .col-equal-5 {
            width: 100%; 
        }
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
</section>
<section class="about-main-sec p-2">
    <section class="about-style-two px-4">
        <h4 class="newstyle">Lab on boarding process</h4>
        <div class=" about-main mt-2">
            <div class="about-box" data-tab="inception">
                <i class="fas fa-microscope"></i>
                <h6>About & Why Choose Us</h6>
            </div>
            <div class="about-box" data-tab="brand">
                <i class="fas fa-hand-holding-usd"></i>
                <h6>Business Advantages & Revenue</h6>
            </div>
            <div class="about-box" data-tab="Team">
                <i class="fas fa-cogs"></i>
                <h6>Company Support & Setup</h6>
            </div>
            <div class="about-box" data-tab="CEOStatement">
                <i class="fas fa-bullhorn"></i>
                <h6>Marketing & Next Steps</h6>
            </div>
            </div>
    
    </section>
    <div id="inception" class="tab-section">
        <section class="about-style-two px-4 Inception">
            <div class="about-21">
                <h5 class="newstyle">1. About 369 HealthDex</h5>
                <p>369 HealthDex is one of India’s leading and fastest-growing diagnostic networks, powered by fully automated technology, accurate reporting, and strong customer trust. We aim to build a transparent, profitable, and sustainable diagnostic franchise model across India.
                </p>
                <style>
                    .about_icon_box{
                        background-color: #fff;
                        border-radius: 10%;
                        width: 70px;
                        height: 70px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        /*margin: auto;*/
                         margin-left: 0;
                    }
                    .about_icon_box_txt{
                        font-size: 13px; 
                        color: #fff;
                        line-height: 0.1rem;
                    }
                    .about_icon_box i{
                        color: #2aa48c; font-size: 28px;
                    }
                </style>
                <h5 class="newstyle mt-4">2. Franchisee Setup Requirements (Key Investment)</h5>
                <div class="about-21-row mt-2">
                    <div class="about-card-1">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <div class="about_icon_box">
                                    <i class="fa-solid fa-map-marker-alt"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <span class="about_icon_box_txt">
                                    <b>Space</b><br>
                                    160–200 sq. ft. area with attached washroom
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="about-card-1">
                        <div class="row align-items-center">
                            <div class="col-3 ">
                                <div class="about_icon_box">
                                    <i class="fa-solid fa-chair"></i>
                                    
                                </div>
                            </div>
                            <div class="col-9">
                                <span class="about_icon_box_txt">
                                    <b>Furniture</b><br>
                                    Table, chairs, waiting area chairs
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="about-card-1">
                        <div class="row align-items-centerm ">
                            <div class="col-3">
                                <div class="about_icon_box">
                                    <i class="fa-solid fa-flask"></i>
                                </div>
                            </div>
                            <div class="col-9 ">
                                <span class="about_icon_box_txt ">
                                    <b>Equipment</b><br>
                                    Centrifuge, refrigerator, sample collection chair
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="about-card-1">
                        <div class="row align-items-center">
                            <div class="col-3 ">
                                <div class="about_icon_box">
                                    <i class="fa-solid fa-rupee-sign"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <span class="about_icon_box_txt">
                                    <b>Franchise Fee</b><br>
                                    ₹1,00,000 (One-Time Investment)
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="about-style-two px-4 mt-2 Inception">
            <div class="about-21">
                <h5 class="newstyle pb-2">3. Why Choose 369 HealthDex for Franchisee Partnership</h5>
                <div class="row mx-0">
                    <div class="col-12">
                        <ul class="about-ul">
                            <li><b class="red">India’s Largest Automated Laboratory</b></li>
                            <li>Lowest B2B Prices in the Industry</li>
                            <li>Attractive Volume Discount Schemes</li>
                            <li>Best Preventive Health Check-up Packages</li>
                            <li>Advanced IT & LIS (Laboratory Information System)</li>
                            <li>Robust Logistics Network for Sample Collection & Delivery</li>
                            <li>Dedicated Sales & Marketing Support</li>
                            <li>Transparent B2B & B2C Data System</li>
                        </ul>
                    </div>
                    <div class="col-12 p-15">
                        </div>
                </div>
            </div>
        </section>
        
        <section class="about-style-two px-4 mt-2 Inception">
            <div class="about-21 row mx-0">
                <h6>4. Eligibility & Space Requirement</h6>
                <p>Set up in a medically active, high-visibility area.</p>
                <div class="col-md-6 col-lg-6 col-sm-12 row">
                    <div class="col-12 mb-0">
                        <ul class="about-ul">
                              <li><b class="red">Space:</b> 160–200 sq. ft. on ground floor with toilet</li>
                              <li><b class="red">Location:</b> Main road visibility and easy access</li>
                              <li><b class="red">Background:</b> Preferred background: medical/pharma/healthcare</li>
                              <li><b class="red">Mindset:</b> Entrepreneurial, customer-first mindset</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
       
        <section class="about-style-two px-4 Inception">
            <div class="about-210- about-21">
                <h5 class="newstyle">5. Revenue Streams & 6. Infrastructure</h5>
                <div class="about-21-row mt-2">
                    <div class="about-card-12">
                        <h6 class="newstyle mb-2">Revenue Streams<h6>
                        <p class="services-text">Multiple ways to grow your center's income:</p>
                        <ul class="about-ul pl-3">
                            <li>Commission per test (Sample collection fees)</li>
                            <li>Health check-up packages (Individual & corporate)</li>
                            <li>Home collection services (Additional charges)</li>
                            <li>Corporate tie-ups: Hospitals, clinics, companies</li>
                        </ul>
                    </div>
                    <div class="about-card-12"><h6 class="newstyle mb-2">Infrastructure & Equipment<h6>
                        <p class="services-text">Quality-first setup to ensure sample integrity and comfort.</p>
                        <ul class="about-ul pl-3">
                            <li>Reception & waiting area</li>
                            <li>Sample collection room</li>
                            <li>Refrigerator for sample storage</li>
                            <li>Blood collection kit and centrifuge</li>
                            <li>Computer with internet & LIMS/CLIMS software</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="brand" class="tab-section" style="display:none;">
        <section class="about-style-two px-4 Inception">
            <div class="about-21 about-21">
                <h5 class="newstyle">7. Business Advantages</h5>
                <p>369 HealthDex ke saath partnership ke yeh mukhya faide hain:</p>
                <style>
                    .value{
                        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
                        border-radius: 5px; /* Rounded corners */
                        /*border: 2px solid black; */
                        padding:15px;
                    }
                </style>
                <style>
                      .grid-container {
                        display: grid;
                        grid-template-columns: 1fr;
                        gap: 1rem;
                      }
                    
                      @media (min-width: 768px) {
                        .grid-container {
                          grid-template-columns: repeat(2, 1fr);
                        }
                      }
                    
                      .grid-item {
                        display: flex;
                        align-items: top;
                        padding: 1rem;
                        border: 1px solid #ddd;
                        border-radius: 8px;
                      }
                    
                      .grid-item img {
                        width: 75px;
                        height: 75px;
                        margin-right: 1rem;
                      }
                      
                    </style>
                    
                    <div class="grid-container mt-2">
                      <div class="grid-item value">
                        <img src="{{asset('public/img/svg/v1.png')}}" alt="Investment">
                        <div>
                            <h6><strong>Low Investment, High Return Model</strong></h6>
                            <p style="line-height: 1.1;rem;font-size:13px;">No Hidden or Royalty Charges. Fast Breakeven within 6–9 Months.</p>
                        </div>
                        
                      </div>
                    
                      <div class="grid-item value">
                        <img src="{{asset('public/img/svg/v2.png')}}" alt="Support">
                        <div>
                            <h6><strong>Dedicated & Transparent Operations</strong></h6>
                            <p style="line-height: 1.1rem;font-size:13px;">Transparent Operation Process and Dedicated Support from Company.</p>
                        </div>
                        
                      </div>
                    </div>
                    <style>
                        .about_icon_box_val{
                        background-color: #2aa48c;
                        border-radius: 10%;
                        width: 73px;
                        height: 73px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        /*margin: auto;*/
                         margin-left: 0;
                    }
                    .about_icon_box_val i{
                        color: #FFF; font-size: 30px;
                    }
                    </style>
                    <h5 class="newstyle mt-4">8. Additional Benefits</h5>
                <div class="grid-container  m-2">
                    <div class="grid-item" style="border:1px solid black;">
                        <div class="">
                            <div class="about_icon_box_val">
                                    <i class="fa-solid fas fa-chart-line"></i>
                                    
                            </div>
                        </div>
                        <div class="pl-4 pr-0">
                            <p>Performance & Incentives</p>
                                <ul class="about-ul">
                                    <li>
                                        Regular Performance Incentives.
                                    </li>
                                    <li>
                                        Special Discounts for High-Volume Centers.
                                    </li>
                                </ul>
                            
                        </div>
                    </div>
                    <div class="grid-item " style="border:1px solid black;">
                        <div>
                            <div class="about_icon_box_val">
                                <i class="fa-solid fas fa-hospital-alt"></i>
                            </div>
                        </div>
                        <div class="pl-4">
                            <p>Continuous Tie-Ups</p>
                                <ul class="about-ul">
                                    <li>Continuous Corporate & Hospital Tie-Ups.
                                    </li>
                                    <li>Marketing & Digital Promotion Assistance.
                                    </li>
                                </ul>
                            
                        </div>
                    </div>
                    <div class="grid-item " style="border:1px solid black;">
                        <div>
                            <div class="about_icon_box_val">
                                    <i class="fa-solid fa-headset" style="color:#fff;"></i>
                            </div>
                        </div>
                        <div class="pl-4">
                            <p>24x7 Support</p>
                                <ul class="about-ul">
                                    <li>24x7 Customer Care & Technical Support.
                                    </li>
                                </ul>
                            
                        </div>
                    </div>
                    <div class="grid-item " style="border:1px solid black;">
                        <div>
                            <div class="about_icon_box_val">
                                <i class="fa-solid fa-desktop"></i>
                            </div>
                        </div>
                        <div class="pl-4">
                            <p>Technology Setup</p>
                                <ul class="about-ul">
                                    <li>Computer, printer, Wi-Fi connection.
                                    </li>
                                </ul>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="Team" class="tab-section" style="display:none;">
        <section class="about-style-two px-4 Inception">
            <div class="about-21">
                <h5 class="newstyle">9. Company Support</h5>
                <div class="col-12 my-4 p-2" style="border:1px solid black;">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12 centred">
                            <i class="fas fa-hammer" style="font-size: 40px; color: #2aa48c;"></i>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-12 ">
                            <p><b>Infrastructure Support</b></p>
                            <p class="13px">Layout plan, branding, and signage design.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 my-4 p-2" style="border:1px solid black;">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12 centred">
                            <i class="fas fa-graduation-cap" style="font-size: 40px; color: #2aa48c;"></i>
                            
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-12 ">
                            <p><b>Training Support</b></p>
                            <p class="13px">Staff training on operations and sample handling.
                            </p>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="col-12 my-4 p-2" style="border:1px solid black;">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12 centred">
                            <i class="fas fa-handshake" style="font-size: 40px; color: #2aa48c;"></i>
                            
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-12">
                            <p><b>Sales Support</b></p>
                            <p class="13px">Field assistance and marketing activities.</p>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="col-12 my-4 p-2" style="border:1px solid black;">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12 centred">
                            <i class="fas fa-desktop" style="font-size: 40px; color: #2aa48c;"></i>
                            
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-12">
                            <p><b>IT Support</b></p>
                            <p class="13px">LIS software, report management, and digital access.</p>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="col-12 my-4 p-2" style="border:1px solid black;">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12 centred">
                            <i class="fas fa-box-open" style="font-size: 40px; color: #2aa48c;"></i>
                            
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-12">
                            <p><b>Welcome Kit & Stationery</b></p>
                            <p class="13px">Reporting papers, envelopes, marketing materials, report pads, and forms.</p>
                        </div>
                    </div>
                    
                    
                </div>
                <h5 class="newstyle mt-4">10. Staff & Roles (Manpower)</h5>
                <div class="col-12 my-4 p-2" style="border:1px solid black;">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12 centred">
                            <i class="fas fa-user-nurse" style="font-size: 40px; color: #e6ae05;"></i>
                            
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-12">
                            <p><b>Phlebotomist/Lab Technician</b></p>
                            <p class="13px">Qualified Phlebotomist (DMLT/BMLT) trained for sample collection.</p>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="col-12 my-4 p-2" style="border:1px solid black;">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12 centred">
                            <i class="fas fa-user-tie" style="font-size: 40px; color: #e6ae05;"></i>
                            
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-12">
                            <p><b>Receptionist/Admin (Optional)</b></p>
                            <p class="13px">For patient flow & billing — optional.</p>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </section>
    </div>
    <div id="CEOStatement" class="tab-section" style="display:none;">
        <section class="about-style-two px-4 Inception">
            <div class="about-21">
                <h5 class="newstyle">11. Marketing & Branding</h5>
                <p>Drive footfall with local activations and digital reach.</p>
                <div class="row mt-2">
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <h6 class="newstyle mt-4">Local & Corporate Marketing</h6>
                    <ul class="pl-4 about-ul">
                      <li>Doctor referrals and clinic partnerships</li>
                      <li>369 HealthDex's branding inside and outside the center</li>
                      <li>Local advertising: flyers, banners, newspaper</li>
                      <li>Discounted health check-up packages</li>
                      <li>Corporate tie-ups and institutional camps</li>
                      <li>Bulk check-ups for companies & societies</li>
                      <li>On-site check-ups in offices & schools</li>
                      <li>Partner with gyms, spas & wellness centers</li>
                    </ul>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6">
                    <h6 class="newstyle mt-4">Digital Marketing</h6>
                    <ul class="pl-4 about-ul">
                      <li>Google My Business for local search</li>
                      <li>WhatsApp & SMS marketing</li>
                      <li>Social Media Ads: Facebook, Instagram, Google Ads</li>
                      <li>Website integration with appointment booking</li>
                    </ul>
                  </div>
                </div>
                
                <h5 class="newstyle mt-4">12. Next Steps to Get Started</h5>
<p>Kickstart your franchise journey in 5 simple steps.</p>
<div class="row mt-2 steps-row">
    <div class="col-equal-5 p-2">
        <div class="p-3 text-center steps-box-inner" style="border: 2px solid #e6ae05; border-radius: 8px;">
            <h5 class="red">1.</h5>
            <p class="13px mb-0"><b>Select Location</b>: Choose high-visibility medically active area.</p>
        </div>
    </div>
    <div class="col-equal-5 p-2">
        <div class="p-3 text-center steps-box-inner" style="border: 2px solid #2aa48c; border-radius: 8px;">
            <h5 style="color: #2aa48c;">2.</h5>
            <p class="13px mb-0"><b>Agreement</b>: Complete franchise registration and KYC.</p>
        </div>
    </div>
    <div class="col-equal-5 p-2">
        <div class="p-3 text-center steps-box-inner" style="border: 2px solid #e6ae05; border-radius: 8px;">
            <h5 class="red">3.</h5>
            <p class="13px mb-0"><b>Set Up</b>: Install infrastructure, IT and branding.</p>
        </div>
    </div>
    <div class="col-equal-5 p-2">
        <div class="p-3 text-center steps-box-inner" style="border: 2px solid #2aa48c; border-radius: 8px;">
            <h5 style="color: #2aa48c;">4.</h5>
            <p class="13px mb-0"><b>Marketing</b>: Launch local and digital outreach.</p>
        </div>
    </div>
    <div class="col-equal-5 p-2">
        <div class="p-3 text-center steps-box-inner" style="border: 2px solid #e6ae05; border-radius: 8px;">
            <h5 class="red">5.</h5>
            <p class="13px mb-0"><b>Go Live</b>: Start operations and build business.</p>
        </div>
    </div>
</div>
            </div>
        </section>
    </div>
    <div id="Certification" class="tab-section" style="display:none;">
        <section class="about-style-two px-4 Inception">
            <div class="about-21">
                
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <H6>Accreditations</H6>
                        <p>National Accreditation Board for Testing and Calibration Laboratories (NABL) accreditations ensure that labs follow the stringent quality protocols set up by these bodies. This, in turn, ensures control over man, machine, environment and processes to stay healthier.</p>
                        <span><a href="{{ route('certification') }}">Read More</a></span>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 centred">
                          <img src="{{asset('public/img/svg/NABL.png')}}" style="width:190px;height:auto">
                    </div>
                </div>
                
            </div>
            <h6 class="newstyle mt-4">Internal Quality Assurance Protocols</h6>
                <p>Quality is a dynamic concept which is ultimately defined by customer expectations and satisfaction. At Reliable Diagnostics, we ensure customer satisfaction is achieved with QMS through the alignment of people, process and technology.</p>
                
            <style>
            .container {
                display: flex;
                flex-wrap: wrap;
                /*padding: 10px;*/
            }
            
            .box-wrapper {
                width: 12.5%;
                
                box-sizing: border-box;
                padding: 4px;
                text-align: center;
            }
            
            .box {
                border: 2px solid #2aa48c;
                border-radius: 5px;
                padding: 4px;
                background: white;
                cursor: pointer;
                transition: all 0.3s ease;
                height:100px;
                
                display: flex; /* Use flexbox to center the content */
                flex-direction: column; /* Stack icon and text vertically */
                justify-content: center; /* Vertically center content */
                align-items: center; /* Horizontally center content */
            }
            
            .box .icon {
                font-size: 24px;
            }
            
            .box .title {
                /*font-weight: bold;*/
                line-height: 1.25rem;
                font-size:13px;
                margin-top: 5px;
            }
            
            .box-wrapper.active .box {
                background: #2aa48c;
                color: white;
                border-color: #2aa48c;
            }
            
            /* Shared description box under all */
            #shared-description {
                margin-top: 5px;
                /*padding: 2px;*/
                /*border: 1px solid #2aa48c;*/
                font-size: 14px;
                /*border-radius: 4px;*/
                /*background-color: #2aa48c;*/
            }
            
            
            @media (max-width: 992px) { /* md devices */
                .box-wrapper {
                    width: 33.33%; /* 3 per row on md */
                }
            }
            
            @media (max-width: 768px) { /* sm devices */
                .box-wrapper {
                    width: 50%; /* 2 per row on sm */
                }
            }
           
            </style>

    @php
        $boxes = [
            ['title' => 'Personnel', 'icon' => 'fas fa-users', 'color' => '#7FDBFF', 'description' => '<h5 class="my-2">Personnel</h5>
                    <h6>Training, Competency & CMEs</h6><ul class="about-ul mt-2"><li>Ensure hiring of qualified staff as per role-based qualification criteria</li><li>Detailed training programs for each level of staff (Star desk staff to Pathologist)</li><li>Enrollment in CAP Competency programs for all technical lab staff</li><li>Competency assessment scores are compared with worldwide peer group</li><li>Internal & external CMEs for all</li></ul>'],
      
            ['title' => 'Equipment', 'icon' => 'fas fa-tools', 'color' => '#2ECC40', 'description' =>'<h5 class="my-2">Equipment</h5>
                    <h6>The control and calibration of equipment used to measure the quality are integral to the success of QMS. To ensure high-quality results:
                    </h6>
                    <ul class="about-ul mt-2">
                        <li>All validated equipment is used after in-house verification</li>
                        <li>All equipment is calibrated periodically</li>
                        <li>Equipment service and maintenance programs are strictly followed</li>    
                    </ul>'
                          ],
            ['title' => 'Process Control', 'icon' => 'fas fa-cogs', 'color' => '#FFDC00', 'description' =>'<h5 class="my-2">Process Control</h5>
                    <h6>QMS are inherently process-driven approaches to quality control and assurance. Internal quality control (IQC) and external quality assurance (EQA) are distinct processes that contribute to ensure the overall quality (i.e., correctness) of laboratory test procedures.</h6>
                    <ul class="about-ul mt-2">
                        <li>IQC ensures day-to-day consistency of an analytical process, centrally monitored by the QA team through BIORAD Unity Software</li>
                        <li>EQA programs are used to periodically assess the quality of a lab’s performance as compared with peer performance, achieving added confidence in patient test results. We participate in international and national PT programs like CAP Proficiency Testing, BIORAD, AIIMS, CMC Vellore, RML, TATA</li>
                    
                    </ul>'
                          ],
            ['title' => 'Occurrence Management', 'icon' => 'fas fa-exclamation-circle', 'color' => '#FF851B', 'description' => '<h5 class="my-2">Occurrence Management</h5>
                    <h6>Dedicated team for handling occurrences.</h6>
                    <ul class="about-ul mt-2">
                        <li>Each occurrence is logged detailed root cause analysis is done, and immediate, corrective & preventive actions are taken and documented.</li>
                    </ul>'],
            ['title' => 'Internal Audits', 'icon' => 'fas fa-check-circle', 'color' => '#FF4136', 'description' =>'<h5 class="my-2">Internal Audits</h5>
                    <h6>An internal audit is an important component to ensure optimal performance of a quality management system.</h6>
                    <ul class="about-ul mt-2">
                        <li>Periodic audits are conducted for all the locations to ensure test result accuracy, reliability, and on-time delivery</li>
                        <li>Audits are done as per ISO 15189 standard checklists</li>
                        <li>The findings are documented and corrected within a defined time frame to ensure compliance</li>
                    </ul>'
                          ],
            ['title' => 'Document Control', 'icon' => 'fas fa-file-alt', 'color' => '#B10DC9', 'description' => '<h5 class="my-2">Document Control</h5>
                    <h6>Effective records-keeping is crucial to the success of the QMS, the ability to obtain certification with QMS standards, and for regulatory compliance.</h6>
                    <ul class="about-ul mt-2">
                        <li>All the control documents reflect the current processes and are reviewed and approved by authorised designees.</li>
                        <li>The documents and records are retained as per defined retention periods</li>
                    </ul>'
                          ],
            ['title' => 'Continuous Improvement', 'icon' => 'fas fa-arrow-up', 'color' => '#01FF70', 'description' => '<h5 class="my-2">Continuous Improvement</h5>
                    <h6>Continuous improvement and adaptations are necessary for organizations to drive benefits with the QMS and maintain customer satisfaction.</h6>
                    <ul class="about-ul mt-2">
                        <li>Quality Indicators: The key improvement area is identified from each phase of pre-analytic, analytic and post-analytic. Targets are defined for achievements and are monitored on a regular interval. Corrective actions are taken for observed gaps.</li>
                        <li>Risk Analysis: Risk analysis is done for identified critical processes to mitigate the risk and the outcome is monitored and audited periodically.</li>
                    </ul>'
                          ],
            ['title' => 'Facilities and Safety', 'icon' => 'fas fa-shield-alt', 'color' => '#39CCCC', 'description' => '<h5 class="my-2">Facilities and Safety</h5>
                    <h6>We grow a culture of safety within the organization, with safety protocols and its implementation. The programs are defined to prevent accidents, illness and injuries while reducing environmental toxins and spillage</h6>
                    <ul class="about-ul mt-2">
                        <li>Safety training programs for all staff</li> 
                        <li>Sample transport management</li>  
                        <li>Waste management</li>
                        <li>Ergonomics</li>
                    </ul>'
                          ],
        ];
    @endphp
    



<div class="container my-6" id="box-container">
    @foreach ($boxes as $index => $box)
        <div class="box-wrapper" id="box-wrapper-{{ $index }}" onclick="selectBox({{ $index }})">
            <div class="box mt-2">
                 <div class="icon">
                    <i class="{{ $box['icon'] }}" style="color: {{ $box['color'] }};"></i> </div>
                <div class="title">{!! $box['title'] !!}</div>
            </div>
        </div>
    @endforeach
    <div id="shared-description" ></div>
</div>

<script>
    const boxes = @json($boxes);

    function selectBox(index) {
        // Remove active class from all box wrappers
        document.querySelectorAll('.box-wrapper').forEach(el => el.classList.remove('active'));
        
        // Add active class to the selected box
        document.getElementById('box-wrapper-' + index).classList.add('active');
        
        // Show description under all boxes, use innerHTML to render HTML tags in description
        document.getElementById('shared-description').innerHTML = boxes[index].description;
    }

    document.addEventListener('DOMContentLoaded', () => {
        selectBox(0); // default select first box
    });
</script>

        </section>
    </div>

</section>
<script>
    document.querySelectorAll('.about-box').forEach(tab => {
        tab.addEventListener('click', function () {
            const targetId = this.getAttribute('data-tab');

            // Hide all tab sections
            document.querySelectorAll('.tab-section').forEach(section => {
                section.style.display = 'none';
            });

            // Show the selected one
            const target = document.getElementById(targetId);
            if (target) {
                target.style.display = 'block';
            }

            // Toggle active class
            document.querySelectorAll('.about-box').forEach(box => box.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Automatically select the first tab on load
    document.addEventListener('DOMContentLoaded', function () {
        const firstTab = document.querySelector('.about-box');
        if (firstTab) {
            firstTab.click(); // This triggers all the behavior (description + active class)
        }
    });
</script>
 
@stop
@section('footer')
@stop