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
        color:#EB0401;
    }
    .13px{
        font-size:13px;
    }
    .about-main {
    display: flex;
    flex-wrap: wrap; /* Ensure responsiveness */
    justify-content: center; /* Center the boxes */
    gap: 20px; /* Add space between boxes */
    background-color:#1F3E6D;
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
        background-color: #1F3E6D;
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
        /*background-color: #1F3E6D;*/
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
    background-color: #f9f9f9;
    padding: 12px;
    border-radius: 12px;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    width: calc(100% / 6 - 10px);
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
    color: #1f3e6d;
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
        width: calc(100% / 3 - 10px);
    }
}

@media (max-width: 768px) {
    .about-box {
        width: calc(50% - 10px);
    }
}

@media (max-width: 480px) {
    .about-box {
        width: 45%;
        /*font-size:10px !important;*/
    }
}
.about-box.active {
    background-color: #EB0401;
    color: #fff;
    border-color: #EB0401;
}

.about-box.active i,
.about-box.active h6 {
    color: #fff !important;
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
        <h4 class="newstyle">About Us</h4>
        <div class=" about-main mt-2">
            <div class="about-box" data-tab="inception">
                <i class="fas fa-seedling"></i>
                <h6>Inception</h6>
            </div>
            <div class="about-box" data-tab="brand">
                <i class="fas fa-briefcase"></i>
                <h6>Brand</h6>
            </div>
            <div class="about-box" data-tab="Team">
                <i class="fas fa-users"></i>
                <h6>Management Team</h6>
            </div>
            <div class="about-box" data-tab="CEOStatement">
                <i class="fas fa-user-tie"></i>
                <h6>CEO Statement</h6>
            </div>
            <!--<div class="about-box" data-tab="Certification">-->
            <!--    <i class="fas fa-scroll"></i>-->
            <!--    <h6>Certification</h6>-->
            <!--</div>-->

        </div>
    
    </section>
    <div id="inception" class="tab-section">
        <section class="about-style-two px-4 Inception">
            <div class="about-21">
                <h5 class="newstyle">Inception</h5>
                <p>Reliable Diagnostic Centre was established in 2004 as a referral histopathology and
                Cytology centre catering to laboratory and hospitals. In 2008 a complete diagnostic
                facility was launched. Since then, we have been constantly evolving, innovating,
                collaborating, and broadening our scope of work to meet the dynamic needs of our
                clinicians, patients and the clients we serve.
                We are sincerely striving to establish RDC as the most advanced diagnostic centre
                which fully caters to end- to-end needs of our clients.
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
                        color: #1F3E6D; font-size: 28px;
                    }
                </style>
                <div class="about-21-row mt-2">
                    <div class="about-card-1">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <div class="about_icon_box">
                                    <i class="fa-solid fa-hand-holding-heart"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <span class="about_icon_box_txt">
                                    <b>22M+ tests</b><br>
                                    conducted with utmost professionalism
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="about-card-1">
                        <div class="row align-items-center">
                            <div class="col-3 ">
                                <div class="about_icon_box">
                                    <i class="fa-solid fa-bed-pulse"></i>
                                    
                                </div>
                            </div>
                            <div class="col-9">
                                <span class="about_icon_box_txt">
                                    <b>6.5M+ patients</b><br>
                                    served with complete care
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="about-card-1">
                        <div class="row align-items-centerm ">
                            <div class="col-3">
                                <div class="about_icon_box">
                                    <i class="fa-solid fa-hospital"></i>
                                </div>
                            </div>
                            <div class="col-9 ">
                                <span class="about_icon_box_txt ">
                                    <b>150+ centres</b><br>
                                    centres across India
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="about-card-1">
                        <div class="row align-items-center">
                            <div class="col-3 ">
                                <div class="about_icon_box">
                                    <i class="fa-solid fa-vial"></i>
                                </div>
                            </div>
                            <div class="col-9">
                                <span class="about_icon_box_txt">
                                    <b>4,500+ tests offered</b><br>
                                    across pathology, radiology, cardiology, and others
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="about-style-two px-4 mt-2 Inception">
            <div class="about-21">
                <h5 class="newstyle pb-2">UNBURDENING HEALTHCARE</h5>
                <div class="row mx-0">
                    <div class="col-12">
                        <p class="services-text">One of the prominent names in the Indian Diagnostics Industry, Reliable Diagnostics
                            commenced its journey in the year 2004. Over the last 2 decades, we have built a network of
                            100+ centres in more than 55+ cities across North, West, East, Central India. With more than
                            4,500 tests across various specializations, best-in-class infrastructure, a panel of experts, and a
                            strong will to unburden healthcare, Reliable Diagnostics has come to be known for its efficient
                            processes that strive towards minimal error and customer-centricity. Driven by its purpose to
                            be the most preferred diagnostics brand, the company strives each day to truly impact health
                            outcomes and #Unburdenyourhealth.
                        </p>
                    </div>
                    <div class="col-12 p-15">
                        <img src="{{asset('public/img/svg/s5.png')}}" >
                    </div>
                </div>
            </div>
        </section>
        
        <section class="about-style-two px-4 mt-2 Inception">
            <div class="about-21 row mx-0">
                <h6>Reliable Diagnostics Lab Network</h6>
                <p>Reliable operates 80+ franchise labs, 35+ hospital labs, 10,000+ Pickup Centres in India, and 4
                    Labs in Nepal —offering convenient, tech-driven diagnostic services.</p>
                <div class="col-md-6 col-lg-6 col-sm-12 row">
                    <div class="col-12 mb-0">
                        <p class="red">RAJASTHAN</p>
                        <div class="row">
                            <div class="col-4">
                                <ul class="about-ul">
                                      <li>Mahua</li>
                                      <li>Neem Ka Thana</li>
                                      <li>Nimbahera</li>
                                      <li>Nohar (upcoming)</li>
                                      <li>Ringus</li>
                                      <li>Shahpura</li>
                                      <li>Sikar</li>
                                      <li>Sri Ganganagar</li>
                                      <li>Tara Nagar</li>
                                      <li>Tonk</li>
                                      <li>Udaipur</li>
                                </ul>
                            </div>
                            <div class="col-4">
                                <ul class="about-ul">
                                      <li>Dholpur</li>
                                      <li>Gangapur</li>
                                      <li>Hanumangarh</li>
                                      <li>Hindaun City</li>
                                      <li>Jaipur</li>
                                      <li>Jodhpur</li>
                                      <li>Kota</li>
                                      <li>Kotputli</li>
                                      <li>Khairtal</li>
                                      <li>Jhalawar</li>
                                      <li>Jhunjhunu</li>
                                      
                                          <li>Deeg</li>
                                </ul>
                            </div>
                            <div class="col-4">
                                <ul class="about-ul">
                                          <li>Ajmer</li>
                                          <li>Alwar</li>
                                          <li>Baran</li>
                                          <li>Bandikui</li>
                                          <li>Bayana</li>
                                          <li>Bijainagar</li>
                                          <li>Bharatpur</li>
                                          <li>Bhilwara</li>
                                          <li>Bikaner</li>
                                          <li>Chittorgarh</li>
                                          <li>Chomu</li>
                                          <li>Dausa</li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-6">
                                <p class="red">BIHAR</p>
                                <ul class="about-ul">
                                    <li>Khagaria</li>
                                    <li>Patna</li>
                                </ul>
                                
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-6">
                                <p class="red">PUNJAB</p>
                                <ul class="about-ul">
                                    <li>Abohar</li>
                                    <li>Chandigarh</li>
                                </ul>
                                
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-6">
                                <p class="red">MADHYA PRADESH</p>
                                <ul class="about-ul">
                                    <li>Gwalior</li>
                                    <li>Morena</li>
                                    <li>Datia</li>
                                    <li>Guna</li>
                                </ul>
                                
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-6">
                                <p class="red">JAMMU & KASHMIR</p>
                                <ul class="about-ul">
                                    <li>Srinagar</li>
                                    
                                </ul>
                                
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-6">
                                <p class="red">ODISHA</p>
                                <ul class="about-ul">
                                    <li>Rourkela</li>
                                    
                                </ul>
                                
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-6">
                                <p class="red">ASSAM</p>
                                <ul class="about-ul">
                                    <li>Tezpur</li>
                                    
                                </ul>
                                
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-6">
                                <p class="red">GUJARAT</p>
                                <ul class="about-ul">
                                    <li>Bhavnagar</li>
                                    
                                </ul>
                                
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-6">
                                <p class="red">HARYANA</p>
                                <ul class="about-ul">
                                    <li>Bahadurgarh</li>
                                    <li>Kurukshetra</li>
                                    <li>Narnaul</li>
                                    <li>Ellanabad</li>
                                </ul>
                                
                            </div>
                            <div class="col-md-6 col-lg-4 col-sm-6">
                                <p class="red">UTTAR PRADESH</p>
                                <ul class="about-ul">
                                    <li>Agra</li>
                                    <li>Auraiya</li>
                                    <li>Ghaziabad</li>
                                    <li>Saharanpur</li>
                                    <li>Sitapur</li>
                                    <li>Hardoi</li>
                                    <li>Etawah</li>
                                </ul>
                                
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col-md-6 col-lg-6 col-sm-12">
                    <img src="{{asset('public/img/svg/mapnew.png')}}" style="width:100%;height:auto;" class="icon-svg" alt="Inception">
                </div>
            </div>
        </section>
       
        <section class="about-style-two px-4 Inception">
            <div class="about-210- about-21">
                <h5 class="newstyle">Our Services</h5>
                <div class="about-21-row mt-2">
                    <div class="about-card-12">
                        <h6 class="newstyle mb-2">Clinical Chemistry, Immunoassays & ELISA<h6>
                        <p class="services-text">We offer advanced clinical chemistry and immunoassay tests for accurate diagnosis, ensuring precise, reliable, and timely results for effective patient care.</p>
                    </div>
                    <div class="about-card-12"><h6 class="newstyle mb-2">Hematology & Coagulation Studies<h6>
                        <p class="services-text">We provide advanced hematology and coagulation tests, ensuring accurate diagnosis with cutting-edge technology, expert professionals, and rapid, precise, and reliable results.</p></div>
                    <div class="about-card-12"><h6 class="newstyle mb-2">Clinical Pathology<h6>
                        <p class="services-text">We offer advanced clinical pathology testing for body fluids using automation and flow cytometry, ensuring accurate, timely results for effective patient care.</p></div>
                    <div class="about-card-12"><h6 class="newstyle mb-2">Histopathology & Cytopathology<h6>
                        <p class="services-text">We provide advanced histopathology and cytopathology services, immunohistochemistry, expert microscopy, and cutting-edge technology, ensuring accurate, timely, and reliable pathology reports for optimal patient care.</p></div>
                    <div class="about-card-12"><h6 class="newstyle mb-2">Microbiology<h6>
                        <p class="services-text">Our microbiology lab specializes in rapid, accurate infectious disease diagnosis using advanced automation, FDA-approved instruments, and international guidelines, ensuring precise and reliable results.
    
                            
                        </p></div>
                    <div class="about-card-12"><h6 class="newstyle mb-2">Serology<h6>
                        <p class="services-text">Our serology lab detects infections and immune responses using advanced automation, ensuring rapid, accurate results for STDs, dengue, malaria, typhoid, and more.</p></div>
                    <div class="about-card-12"><h6 class="newstyle mb-2">Molecular Pathology<h6>
                        <p class="services-text">Our molecular diagnostics lab uses advanced PCR technology for accurate testing in cancer genetics, infectious diseases, and women’s health, processing 14,000 tests daily.
                    </p></div>
                </div>
            </div>
        </section>
    </div>
    <div id="brand" class="tab-section" style="display:none;">
        <section class="about-style-two px-4 Inception">
            <div class="about-21 about-21">
                <h5 class="newstyle">Values</h5>
                <p>The aim and objectives of this center is to provide quality diagnostic services at affordable price with stress on both accuracy and precision with minimum turn around time to guide clinicians through patient care.</p>
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
                        <img src="{{asset('public/img/svg/v1.png')}}" alt="Vision">
                        <div>
                            <h6><strong>Vision</strong></h6>
                            <p style="line-height: 1.1;rem;font-size:13px;">Our vision is to make Pathologist and Microbiologist part of treating team so that patient is benefitted the most by continuous mutual interaction with Clinician and change the present scenario by which diagnostic facilities are functioning.</p>
                        </div>
                        
                      </div>
                    
                      <div class="grid-item value">
                        <img src="{{asset('public/img/svg/v2.png')}}" alt="Mission">
                        <div>
                            <h6><strong>Mission</strong></h6>
                            <p style="line-height: 1.1rem;font-size:13px;">Our Motto is to deliver “Best Quality and Reliable result at Affordable cost at your door step”.</p>
                        </div>
                        
                      </div>
                    </div>
                    <style>
                        .about_icon_box_val{
                        background-color: #1F3E6D;
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
                <div class="grid-container  m-2">
                    <div class="grid-item" style="border:1px solid black;">
                        <div class="">
                            <div class="about_icon_box_val">
                                    <i class="fa-solid 	fas fa-bolt"></i>
                                    
                            </div>
                        </div>
                        <div class="pl-4 pr-0">
                            <p>Enthusiasm</p>
                                <ul class="about-ul">
                                    <li>
                                        Enthusiastic workforce that exceed customer expectations.
                                    </li>
                                    <li>
                                        Driven to understand & meet customer needs.
                                    </li>
                                    <li>
                                        Keen to receive feedback and improve our services.
                                    </li>
                                </ul>
                            
                        </div>
                    </div>
                    <div class="grid-item " style="border:1px solid black;">
                        <div>
                            <div class="about_icon_box_val">
                                <i class="fa-solid fas fa-stethoscope"></i>
                            </div>
                        </div>
                        <div class="pl-4">
                            <p>Genuine Care</p>
                                <ul class="about-ul">
                                    <li>“Pathologist on call” service.
                                    </li>
                                    <li>
                                        Rigorously trained staff for a pain-free sample collection.
                                    </li>
                                    <li>
                                        Enable a hassle-free customer experience.
                                    </li>
                                </ul>
                            
                        </div>
                    </div>
                    <div class="grid-item " style="border:1px solid black;">
                        <div>
                            <div class="about_icon_box_val">
                                    <i class="fa-solid fa-handshake" style="color:#fff;"></i>
                            </div>
                        </div>
                        <div class="pl-4">
                            <p>Building Great Relationships</p>
                                <ul class="about-ul">
                                    <li>Prioritizing health and well-being of our customers and community.
                                    </li>
                                    <li>
                                        Taking proactive steps to engage with customers beyond diagnostics.
                                    </li>
                                    <li>
                                        All ears to queries, complaints & compliments.
                                    </li>
                                </ul>
                            
                        </div>
                    </div>
                    <div class="grid-item " style="border:1px solid black;">
                        <div>
                            <div class="about_icon_box_val">
                                <i class="fa-solid fa-brain"></i>
                            </div>
                        </div>
                        <div class="pl-4">
                            <p>Display Diligence And Attention To Detail</p>
                                <ul class="about-ul">
                                    <li>Deliver state-of-the-art diagnostic healthcare at all times.
                                    </li>
                                    <li>
                                        Ensure minimal error.
                                    </li>
                                    <li>
                                        Perform a 3 level checking with experts for accurate report delivery.
                                    </li>
                                </ul>
                            
                        </div>
                    </div>
                    <div class="grid-item " style="border:1px solid black;">
                        <div>
                            <div class="about_icon_box_val">
                                    <i class="fa-solid fa-eye" style="color:#fff;"></i>
                            </div>
                        </div>
                        <div class="pl-4">
                            <p>Attention To Detail</p>
                                <ul class="about-ul">
                                    <li>Transparent communication.
                                    </li>
                                    <li>
                                        Multiple micro-checkpoints to ensure accurate results.
                                    </li>
                                    <li>Highly skilled and experienced team of pathologists and lab technicians.
                                    </li>
                                </ul>
                            
                        </div>
                    </div>
                    <div class="grid-item " style="border:1px solid black;">
                        <div>
                            <div class="about_icon_box_val">
                                   <i class="fas fa-bullseye"></i>
                            </div>
                        </div>
                        <div class="pl-4">
                            <p>Strive Towards Zero Error</p>
                                <ul class="about-ul">
                                    <li>3 level expert-check of reports before finalizing.
                                    </li>
                                    <li>
                                       Dynamic centralized softwares to offer precise diagnostic support.
                                    </li>
                                    <li>Best in class customer sample handling.
                                    </li>
                                </ul>
                            
                        </div>
                    </div>
                    <div class="grid-item " style="border:1px solid black;">
                        <div>
                            <div class="about_icon_box_val">
                                    
                                    <i class="fa-solid fa-lightbulb"></i>
                            </div>
                        </div>
                        <div class="pl-4">
                            <p>Don’t Settle; Innovate And Evolve</p>
                                <ul class="about-ul">
                                    <li>Always striving to better our offerings and services.
                                    </li>
                                    <li>
                                       To provide the highest specialised tests for precise diagnosis.
                                    </li>
                                   
                                </ul>
                            
                        </div>
                    </div>
                    <div class="grid-item " style="border:1px solid black;">
                        <div>
                            <div class="about_icon_box_val">
                                    
                                    <i class="fa-solid fa-crown"></i>
                            </div>
                        </div>
                        <div class="pl-4">
                            <p>Lead by example</p>
                                <ul class="about-ul">
                                    <li>Frontrunner in the nation’s fight against COVID-19.
                                    </li>
                                    <li>Uphold best industrial practices.
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
                <h5 class="newstyle">Our Team</h5>
                <!--<div class="col-12 my-4 p-2" style="border:1px solid black;">-->
                <!--    <div class="row">-->
                <!--        <div class="col-md-2 col-lg-2 col-sm-12 centred">-->
                <!--            <img src="{{asset('public/img/svg/1.png')}}" style="width:150px;height:150px;border-radius:15px;">-->
                            
                <!--        </div>-->
                <!--        <div class="col-md-10 col-lg-10 col-sm-12 ">-->
                <!--            <p><b>Mr. Dishebh Gupta</b></p>-->
                <!--            <p><b class="red">Managing Director</b></p>-->
                <!--            <p class="13px"><span class="red">Turning a Family Legacy into a National Vision</span><br>-->
                <!--            When Mr. Dishebh Gupta joined Reliable Diagnostics in 2014, he didn’t just inherit a business —-->
                <!--                he saw a canvas for innovation, scale, and impact. With sharp vision and unwavering passion, he-->
                <!--                transformed Reliable from a trusted name into a nationwide diagnostic powerhouse.-->
                <!--             Today, under his leadership, Reliable Diagnostics spans 50+ cities, operates 80 advanced labs,-->
                <!--                35 hospital-based labs, and connects patients through 10,000+ pickup centers in India &-->
                <!--                Nepal. His strategic foresight helped the company grow to turnover,-->
                <!--                without ever compromising on quality or trust.-->
                            
                <!--                But Mr. Gupta’s journey goes far beyond numbers. He’s building the future of diagnostics —-->
                <!--                investing in cutting-edge QA technologies, manufacturing quality controls in-house, running-->
                <!--                a paramedical college, and helping countless labs across India achieve NABL, NABH, and other-->
                <!--                certifications with expert guidance.-->
                <!--               A frequent feature on leading healthcare platforms, Mr. Dishebh Gupta is not just leading-->
                <!--                Reliable — he’s redefining what diagnostics can be in a fast-changing world. With every-->
                <!--                milestone, he brings the industry closer to a future that’s more accurate, accessible, and-->
                <!--                advanced for everyone.-->
                <!--                </p>-->
                <!--        </div>-->
                <!--    </div>-->
                    
                    
                <!--</div>-->
                <div class="col-12 my-4 p-2" style="border:1px solid black;">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12 centred">
                            <img src="{{asset('public/img/svg/2.png')}}" style="width:150px;height:150px;border-radius:15px;">
                            
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-12 ">
                            <p><b>RAJ K. AHUJA</b></p>
                            <p><b class="red">Chief Financial Officer (CFO)</b></p>
                            <p class="13px">Mr. Raj Ahuja, a Chartered Accountant with 23+ years of experience, has led financial and operational
                            strategies at top institutions like Apollo Hospitals, Shalby Hospitals, and Primus Hospital. Now serving as CFO
                            of Reliable Diagnostics, he brings deep expertise in hospital project execution, cost control, fundraising, and
                            EBIDTA turnarounds, contributing significantly to Reliable’s sustainable growth and nationwide expansion.
                            </p>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="col-12 my-4 p-2" style="border:1px solid black;">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12 centred">
                            <img src="{{asset('public/img/svg/3.png')}}" style="width:150px;height:150px;border-radius:15px;">
                            
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-12">
                            <p><b>Dr. Tarun Katiyar</b></p>
                            <p><b class="red">Chief Operating Officer (COO)</b></p>
                            <p class="13px">Dr. Tarun Katiyar is an award-winning healthcare entrepreneur with over 18 years of experience in hospital
                                administration and consulting. As COO of Reliable Diagnostics, he drives innovation and growth. He is also the
                                Co-founder of Hospaccx Healthcare and MD of Vasudev Hospitals. With 5 national awards and a Doctorate in
                                Hospital Administration, he is known for transforming healthcare ventures and promoting affordable care across
                                India.                            </p>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="col-12 my-4 p-2" style="border:1px solid black;">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-12 centred">
                            <img src="{{asset('public/img/svg/4.png')}}" style="width:150px;height:150px;border-radius:15px;">
                            
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-12">
                            <p><b>Mr. Jitendra Sharma</b></p>
                            <p><b class="red">Business Development Head</b></p>
                            <p class="13px">Mr. Jitendra Kumar Sharma brings 24+ years of experience in diagnostics and healthcare business development.
                            He has held leadership roles at Krsnaa Diagnostics, Pathkind Labs, and Dr. Lal PathLabs, successfully launching
                            and managing diagnostic networks across Rajasthan and Himachal Pradesh. At Reliable Diagnostics, he drives
                            strategic expansion, government partnerships, and B2B growth, playing a key role in scaling the company’s
                            nationwide reach and impact  </p>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </section>
    </div>
    <div id="CEOStatement" class="tab-section" style="display:none;">
        <section class="about-style-two px-4 Inception">
            <div class="about-21">
                <h5 class="newstyle">CEO Statement</h5>
                <div class="row mt-2">
                    <div class="col-lg-4 col-md-4 col-sm-6 p-4">
                        <img src="{{asset('public/img/svg/ceo.jpg')}}" style="width:100%;height:auto">
                        <div>
                            <p style="font-size: 1rem;line-height: 1.2rem;font-size:14px;text-align:right;"><strong>Dr. Gajendra Nath Gupta<br> (MD Pathology, MBBS)</strong></p>
                            <p style="font-size: 1rem;line-height: 1.2rem;font-size:14px;padding-top:15px;">Precision in every test, care in every result. Committed to innovation, quality, and trust for better healthcare diagnostics.</p>
                        </div>
                  </div>
                  <div class="col-lg-8 col-md-8 col-sm-6">
                    <p style="font-size: 1rem;line-height: 1.2rem;font-size:14px;">At Reliable Diagnostic Centre, our mission is to provide accurate and high-quality diagnostics for better healthcare. With vast experience in Pathology and Transfusion Medicine, I have worked towards setting global quality standards in laboratories and blood banks.

                        Our commitment to innovation, precision, and excellence ensures trust and reliability in every test. We will continue to serve with integrity and advanced diagnostic care.
                        
                    </p><br>
                    <style>
                      .about-ul li{
                        list-style-type: disc; 
                        font-size: 1rem;line-height: 1.2rem;font-size:13px;
                      }
                    </style>
                    <ul class="pl-4 about-ul">
                      <li>Chief Consultant Pathologist of <b><span class="red">Reliable Diagnostic Centre, Jaipur</span></b></li>
                      <li>Chairman AATM India Chapter - <b><span class="red">Asian Association of Transfusion Medicine</span></b></li>
                      <li>Member ISQua - <b><span class="red">International Society for Quality Assurance</span></b></li>
                      <li>Founder member & Chairperson of technical committee in <b><span class="red">Quality Council of India (QCI)</span></b></li>
                      <li>Technical and accreditation committee member of <b><span class="red">NABH</span></b> — till 2017</li>
                      <!--<li>Former NABL - Accreditation committee member & Lead assessor for accreditation of laboratories</li>-->
                      <li>Former <b><span class="red">NABH</span></b> - Principal assessor accreditation of Blood banks and laboratories</li>
                      <li><b><span class="red">NACO</span></b> — technical expert member for QMS in blood banks</li>
                      <li><b><span class="red">BEQAS</span></b> — founder member of <b><span class="red">NACO-BEQAS</span></b> team for Blood bank EQAS of all NACO supported Blood banks</li>
                      <li><b><span class="red">CDC-CMAI-QMS</span></b> trainer of trainers in blood banks - 2017</li>
                      <li><b><span class="red">NBTC</span></b> — Member of technical expert group of Dept of AIDS Control with <b><span class="red">Min of health GOI</span></b></li>
                      <li><b><span class="red">QCSS</span></b> — Project Director for QA in laboratories in Tier 2 and 3 cities India (Till 2016)</li>
                      <li>Founding member of <b><span class="red">ISTM</span></b> & Founder editor of <b><span class="red">International Journal-GTJM</span></b></li>
                      <li>Awarded the Best Blood Bank of India at <b><span class="red">ISBTI conference</span></b> at Udaipur in 2005 & Kota in 2017</li>
                      <li><b><span class="red">FICCI Award for the project “PRAYTANA”</span></b> — 2014</li>
                      <li>Chikitsa Vibhushan Award by<b><span class="red"> Jaipur Medical Association & Jaipur Association</span></b> of Private Practitioners</li>
                      <li><b><span class="red">Rajasthan Medical Council Doctors Day Award</span></b> for Excellence in Diagnostic and Imagi</b>ng Services - 2017</li>
                      <li>Editor & Reviewer of <b><span class="red">Global Journal of Transfusion Medicine</span></b> and <b><span class="red">Asian Journal of Transfusion Medicine</span></b> till 2017</li>
                      <li>Achievement Award for outstanding contribution in field of Pathology and Transfusion Medicine in Rajasthan by <b><span class="red">Rajasthan chapter of IAPM</span></b> at Kota in 2010</li>
                    </ul>

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
                border: 2px solid #1F3E6D;
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
                background: #1F3E6D;
                color: white;
                border-color: #1F3E6D;
            }
            
            /* Shared description box under all */
            #shared-description {
                margin-top: 5px;
                /*padding: 2px;*/
                /*border: 1px solid #1F3E6D;*/
                font-size: 14px;
                /*border-radius: 4px;*/
                /*background-color: #1F3E6D;*/
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
                    <i class="{{ $box['icon'] }}" style="color: {{ $box['color'] }};"></i> <!-- Font Awesome icon -->
                </div>
                <div class="title">{!! $box['title'] !!}</div>
            </div>
        </div>
    @endforeach
    <div id="shared-description" ></div>
</div>

<!-- Shared description under all boxes -->


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


@include('front.why_rdc')
@stop
@section('footer')
@stop