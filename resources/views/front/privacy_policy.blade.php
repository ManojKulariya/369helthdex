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
    background-color: #EB0401;
    color: #fff;
    border-color: #EB0401;
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
        <h4 class="newstyle">HealthDex 369 – Privacy Policy</h4>
        <!--<div class=" about-main mt-2">-->
        <!--    <div class="about-box" data-tab="inception">-->
        <!--        <i class="fas fa-microscope"></i>-->
        <!--        <h6>Privacy Policy & Why Choose Us</h6>-->
        <!--    </div>-->
        <!--    <div class="about-box" data-tab="brand">-->
        <!--        <i class="fas fa-hand-holding-usd"></i>-->
        <!--        <h6>Business Advantages & Revenue</h6>-->
        <!--    </div>-->
        <!--    <div class="about-box" data-tab="Team">-->
        <!--        <i class="fas fa-cogs"></i>-->
        <!--        <h6>Company Support & Setup</h6>-->
        <!--    </div>-->
        <!--    <div class="about-box" data-tab="CEOStatement">-->
        <!--        <i class="fas fa-bullhorn"></i>-->
        <!--        <h6>Marketing & Next Steps</h6>-->
        <!--    </div>-->
        <!--    </div>-->
    
    </section>
    <div id="inception" class="tab-section">
        <section class="about-style-two px-4 Inception">
            <div class="about-21">
                <h5 class="newstyle">Privacy Policy</h5>
                <p>This privacy policy ("Privacy Policy") sets forth our commitment to respect your online privacy and recognize your need for appropriate protection and management of any Personal Information (as defined below) you share with us. The Privacy Policy applies to our Services available under the domain www.lalpathlabs.com (hereinafter referred to as the "Website/App").
By visiting the Website/App or going through the Privacy Policy, as detailed below or the Terms of Use, which prescribes Terms and Conditions for use of Website/App or availing our Services, you agree to be bound by this Privacy Policy and to the use and disclosure of your personal information in accordance with the Privacy Policy.
IF YOU DO NOT AGREE PLEASE DO NOT USE OR ACCESS THE WEBSITE/APP.

The words "you" or "your" or "User" or "Customer" as used herein, refer to all individuals and/or entities accessing or using the Website/App for any reason. The words "we" or "us" or "our" or the "Company" as used herein, refer to HEalthDex 369 Ltd. and/or any of its Associate/Subsidiary/Group Company.
This Privacy Policy describes the information, which as part of our normal operations; we collect from you and what may happen to that information. Although this policy may seem long, we have prepared a detailed policy because we believe you should know as much as possible about the Website/App, our Services, and practices so that you can make informed decisions.
This Privacy Policy is incorporated into and is subject to Terms of Use and the terms not defined here, have their meanings ascribed to them in the Terms of Use. This Privacy Policy and the Terms of Use are effective upon your visit of our Website/App, or you are going through the same. We encourage you to read the terms of the Privacy Policy and the Terms of Use in their entirety before you use the Website/App and / or avail of our Services.
</p>
                <h5 class="newstyle"> 1. Your Privacy - Our Commitment</h5>
                <p>We are extremely proud of our commitment to protect your privacy. We value your trust in us. We will work hard to earn your confidence so that you can enthusiastically use our Services and recommend us to friends and family. Please read the following policy to understand how your Personal Information will be treated as you make full use of our Website/App / avail our services.
For the purposes of this Privacy Policy, the term "Personal Information" shall mean any information that may be used to identify you including, but not limited to, (i) first and last name with salutation, a home or other physical address and an email address or other contact information, whether at work or at home, (ii) age and gender (iii) correspondence address (iv) physical, physiological and mental health condition (v) sexual orientation (vi) Medical Records and History (vii) Biometric Information (the amount of information you choose to keep confidential is entirely up to your discretion; you may enter as much or as little information as you choose, except for the information which is mandatorily required).The information essentially required for conducting the test may be gathered at the time when the patient gets registered at any authorized centre of the company.
</p>
                <h5 class="newstyle">2.Information we collect</h5>
                <p>When you use our Website/App, we collect and store your Personal Information. Our primary goal in doing so is to provide a safe, efficient, and customized experience to our Users. This allows us to provide services and features that most likely meet your needs, and to customize our Website/App to make your experience safer and easier. Importantly, we only collect Personal Information about you that we consider necessary for achieving this purpose.
Additionally, we also (i) collect the location data of our service provider personnel / phlebotomists when the website/app is running in the foreground or background of their mobile device through GPS, IP address, to track their trips to our Customers location and keep them updated about their real time location status (ii) Customer from their mobile devices through GPS,if they enable us to do so, as to reach their serving location accurately and also to enhance your use of our app, including to improving pick-up locations, enabling safety features and preventing and detecting fraud; (iii) Ask for permissions to capture and access your Media Gallery and Camera to allow you uploading your prescription or downloading your test reports.
In general, you can browse the Website without telling us who you are or revealing any personal information about yourself, However, to fully use our Website/App, you will need to register using our online registration form, where you may be required to provide us with your contact and identity information and other Personal Information as may be requested to and complete the Registration Process. Once you give us your Personal Information, and initiate Registration Process, you are not anonymous to us. Wherever possible, we indicate which fields are mandatorily required and which fields are optional. You always have the option to not provide information by choosing not to use a particular service or feature on the Website/App unless we require it so.
We may automatically track certain information about you based upon your behaviour on our Website/App. You agree that we may use such information to do internal research on our users’ demographics and medical history to better understand, protect and serve our Users. This information is compiled and analysed on an aggregated basis. This information may include, but is not limited to, the URL that you just came from (whether this URL is on our site or not), which URL you next go to (whether this URL is on our Website/App or not), your computer/mobile browser information, and your Internet Protocol ("IP") address.
We use data collection devices such as "cookies" on certain pages of the Website/App to help analyse our web page flow, measure promotional effectiveness, and promote trust and safety. "Cookies" are small files placed on your hard drive that assist us in providing our services. We offer certain features that are only available through the use of a "cookie". We also use cookies to allow you to enter your password less frequently during a session. Cookies can also help us provide information that is targeted to your interests. Most cookies are "session cookies," meaning that they are automatically deleted from your hard drive at the end of a session. You are always free to decline our cookies if your browser permits, although in that case you may not be able to use certain features on the Website/App and you may be required to re-enter your password more frequently during a session.
Website/App
You agree that if you or any third-party shares correspondences with us in any electronic form such as emails, letters etc, containing your personal information, we may collect or store the same, as part of your query/query resolution or for the purposes as mentioned in Clause 3 or 4 below.
You agree that we may collect your IP address Website/App as a visitor to our Website/App. An IP address is a number that is automatically assigned to your computer/mobile when you use the internet. We use IP addresses to help diagnose problems with our server, administer our Website/App, analyse trends, track users' movement, gather broad demographic information for aggregate use for us to improve the Website/App, and deliver customized, personalized content.
</p>
                <h5 class="newstyle">3. Use of your Personal Information</h5>
                <p>You agree that we may use your Personal Information to facilitate the Services you request. You agree that we may use your Personal Information and other information we obtain on the Website/App or at the time of patient registration to enable detailed examination of the medical tests conducted, inform you about online and offline offers, products, services, password retrieval and updates; customize your experience; enforce Terms of Use; and as otherwise described to you at the time of collection.
Further, you hereby consent that we may use your anonymized sample/ data for research and development purposes. You agree that we may use Personal Information about you to improve our marketing and promotional efforts, to analyse site usage, improve the Website/App's content and service offerings, and customize the Website/App's content, layout, and services. These uses improve the Website/App and better tailor it to meet your needs, so as to provide you with an efficient, safe, and customized experience while using the Website/App.
You agree that we may use your Personal Information to contact you and deliver information to you that, in some cases, are targeted to your interests, such as targeted banner advertisements, administrative notices, services offerings, and communications relevant to your use of the Website/App. If you do not wish to receive these communications, we encourage you to unsubscribe / opt out of the receipt of certain communications in your profile or contact our grievance officer.
</p>
                <h5 class="newstyle">4. Disclosure of your Personal Information</h5>
                <p>You agree and confirm that we do not rent, sell, or share Personal Information about you with other people (save with your consent) or non-affiliated companies except to provide products or Services under the Terms of Use or this Privacy Policy, or under the following circumstances:
to provide the Personal Information to physicians and other authorized health care professionals who need to access your laboratory report for your proper diagnosis.
to insurance companies, hospitals, physicians or third parties with our billing department for payment purpose.
to support our healthcare operations, such as performing quality checks on your testing, for teaching purposes, or for developing normal reference ranges for the tests we perform.
to respond to summons, court orders, or legal process, or to establish or exercise our legal rights or defend against legal claims.
to health department or any other Government body as and when required by them for collecting or processing health information of the state/country.
to other laboratories/medical institutions for research and development purposes from time to time, to reveal general statistical information about our Website/App and visitors, such as number of visitors, number and type of services purchased, etc.
to transfer/disclose Personal Information about you to trusted partners, may or may not be for gain, to promote certain products/services for commercial purposes, without any prior notice to you.
Further, you agree that we may share your Personal Information for the following categories of activities from time-to-time:
Advertisements
When you enter Personal Information on any forum of an advertiser, such information is simultaneously collected by Website/App and the advertiser. The Personal Information is used by Website/App in accordance with the terms of this Privacy Policy and is used by the advertiser as per the advertiser's prevalent privacy policies. Because we do not control the privacy practices of these advertisers, you should evaluate their practices before deciding to provide the said information.
Website/App may also aggregate (gather up data across all accounts) Personal Information and disclose such information in a non-personally identifiable manner to advertisers and other third parties for other marketing and promotional purposes.
Other Corporate Entities.
The Company shares much of the data, including Personal Information about you, with its parent, affiliates, subsidiaries, and joint ventures that are committed to serving your online needs and related services, throughout the world. To the extent that these entities have access to your Personal Information, they will treat it at least as protectively as they treat information they obtain from their other users. The Company's parent, affiliates, subsidiaries, and joint ventures follow privacy practices no less protective for all users than our practices described in this document, to the extent allowed by applicable law. The Company, its parent, affiliates, subsidiaries, its joint ventures, or any combination of such, will share some or all your Personal Information with another business entity should we plan to, merge with, or be acquired by that business entity.
Posting to public areas of the Website/App
Please remember that if you post any of your Personal Information in public areas of the Website/App such as in online forums or chat rooms, or on the Website/App's searchable database, such information may be collected and used by others over whom we have no control. We are not responsible for the use of information by third parties based on information you post or otherwise make available in public areas of the Website/App.
</p>
                <h5 class="newstyle">5. Access or change your Personal Information</h5>
                <p>You may review, correct, update, or change your account information at any time. To protect your privacy and security, we will verify your identity before granting access or making changes to your Personal Information. If you have registered your profile on the Website/App, your ID and Password are required to access your Account.
Your Personal Information shall be retained till such time as is required for the Purpose or required under applicable law, whichever is later.
</p>
                <h5 class="newstyle">6. Information security</h5>
                <p>The Company has implemented appropriate security practices and standards and has a comprehensive documented information security programme and information security policies that contain managerial, technical, operational, and physical security control measures that are commensurate with the information assets being protected with the nature of business. Further, the Company takes appropriate security measures to protect against unauthorized access to or unauthorized alteration, disclosure or destruction of data and restricts access to your personal data to the Company’s employees who need to have that information in order to fulfil your request or supply our services.
</p>
                <h5 class="newstyle">7. Other Website/Apps</h5>
                <p>Our Website/App may contain links to other Website/Apps. Please note that when you click on one of these links, you are entering another Website/App over which the Website/App has no control and will bear no responsibility. Often these Website/Apps require you to enter your Personal Information. We encourage you to read the privacy statements on all such Website/Apps as their policies may differ from ours. You agree that we shall not be liable for any breach of your privacy of Personal Information or loss incurred by your use of these Website/Apps.
</p>
                <h5 class="newstyle">8. Changes to this Privacy Policy</h5>
                <p>We reserve the right to update, change or modify this Privacy Policy at any time. The amendment to this Privacy Policy shall come to effect from the time of such update, change or modification and the same will be published on this Website/App.
</p>
                <h5 class="newstyle">9. Disclaimer</h5>
                <p>The Company does not access, store, or keep credit card data. All credit card transactions happen using Secure Server Software (SSL) for 128-bit encryption through third-party gateways and the Company plays no role in the transaction, except for directing the customers to gateways or the relevant webpage. Accordingly, the Company shall not be responsible or liable for any loss or damage due to any disclosure whatsoever of Personal Information or any other information collected by the gateways or such Website/Apps.
The Company shall not be liable for any loss or damage sustained by reason of any disclosure (inadvertent or otherwise) of any Personal Information concerning the User's account and / or information relating to or regarding online transactions using credit cards / debit cards /cash cards and / or their verification process and particulars nor for any error, omission, or inaccuracy with respect to any information so disclosed and used on such third-party gateways.
</p>
                <h5 class="newstyle">10. Governing law and Dispute Resolution</h5>
                <p>This Privacy Policy and Terms of Use shall be governed by and constructed in accordance with the laws of India only without reference to conflict of laws principles and disputes arising in relation hereto and shall be subject to the exclusive jurisdiction of the competent courts of New Delhi, India.
</p>
                <h5 class="newstyle">11. Assignability</h5>
                <p>The Company may assign any of its responsibilities/obligations to any other person without notice to the User, at its sole discretion. However, you shall not assign, sub-licence or otherwise transfer any of your rights under this Privacy Policy to any other party, unless a written consent is taken from the Company.
</p>
                <h5 class="newstyle">12. Contacting the Website/App</h5>
                <p>If you have any questions about this Privacy Policy, the privacy practices of this Website/App, or if you want to exercise any of the rights that you are given under this Privacy Policy, you can contact the grievance officer Mr. Vinay Gujral at cs@lalpathlabs.com
The details of the grievance officer may be changed by us from time to time by updating this Privacy Policy.
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
                
            </div>
        </section>
        
    </div>
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