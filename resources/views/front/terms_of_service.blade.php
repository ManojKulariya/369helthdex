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
.about-21 ol li {
    
    list-style-type: decimal !important;
}
.about-21 li {
    list-style-type: decimal !important;
}
.about-21 ol{ 
   padding-left: 10px !important;
}
.about-21 ul{ 
   padding-left: 10px important;
}
html, body {
    overflow-x: hidden !important;
}
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
        <h4 class="newstyle">369 HealthDex – Terms of Use</h4>
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
                <h5 class="newstyle">Terms of Use</h5>
                <p>These terms of use (this 'Agreement') set forth the standards of use of www.lalpathlabs.com located at https://369healthdex.com/ and all of its associated pages and websites and Patient app. The link www.lalpathlabs.com and all such associated pages and websites are collectively referred to herein as the 'Website.'
                The words 'You' or 'User' 'Your' as used herein refer to all individuals accessing or using the Website for any reason.
                By using the Website/App, You represent that you have read and agree to be bound by the terms of this Agreement, as well as any other guidelines, privacy policy, rules and additional terms referenced herein, collectively referred to as 'Terms of Use'. These Terms of Use set out the legally binding terms with respect to your access and use of the Website/App and our provision of the Services (as defined below).
                Please read these Terms of Use carefully. Your access to Website/App and/or use of the Service constitutes your acceptance of all the provisions of these Terms of Use. If you are unwilling to be bound by these Terms of Use, do not access Website/App and/or use the Service.
                </p>
               <h5 class="newstyle"> 1.DEFINITIONS AND INTERPRETATIONS</h5>
                <p>We are extremely proud of our commitment to protect your privacy. We value your trust in us. We will work hard to earn your confidence so that you can enthusiastically use our Services and recommend us to friends and family. Please read the following policy to understand how your Personal Information will be treated as you make full use of our Website/App / avail our services.
                For the purposes of this Privacy Policy, the term "Personal Information" shall mean any information that may be used to identify you including, but not limited to:</p>
               <ol>
                    <li>
                        <b>Definitions :</b>
                        <p>
                            'Account' means the account successfully opened by the User on the Company's Website/App by inserting information such as name, age, sex, contact details, user name, password as required to be filled in the webpage during the registration process and includes any further changes and additions to the information from time to time.
                            <br>
                            'Company' means Shree labs Ltd or any of its assignee, incorporated under the Companies Act, 1956.
                            <br>
                            'Customer' means any User who accesses the Website/App completes the registration according to clause 6.
                            <br>
                            'E-Health Packages' means the exclusive and customized health diagnostic packages being offered by the Company and any such other packages which the Company may be introduced from time to time through web portal / Patient App.
                            <br>
                            'Fee' means the price prescribed by the Company for the E- Health Packages/Services as notified on its Website/App from time to time.
                            <br>
                            'Home Service' means the facility provided by the Company to facilitate sample collection at the Customer's door step.
                            <br>
                            'Order ID' means the unique identification identity allotted to a Customer upon placing a request for booking the Services/E-Health Packages.
                            <br>
                            'Registration Process' means the entire process which a Customer/User undergoes while registering himself on the Website/App in accordance with clause 6.
                            <br>
                            'Services' means the services as mentioned in clause 3.2.
                            <br>
                            'User' means any person who accesses the Website/App.
                        </p>
                    </li>
                    <li>
                        <b>Interpretation :</b>
                        <p>In this Agreement, unless the context otherwise requires references to recitals, clauses and sub-clauses are to recitals, clauses and sub-clauses of this Agreement; headings are inserted for ease of reference only and are not to be used to define, interpret or limit any of the provisions of this Agreement; references to the singular number shall include references to the plural number and vice versa; words denoting one gender include all genders; any reference in this Agreement to a statutory provision includes that provision and any regulation made in pursuance thereof, as from time to time modified or re-enacted, whether before or after the date of this Agreement; and any reference to a time limit in this Agreement means the time limit set out in the relevant clause or sub-clause or such other time limit which may be mutually agreed by the parties in writing.</p>
                    </li>
               </ol>
                <h5 class="newstyle">2. ELIGIBILITY</h5>
                <p>You, if an individual, must be 18 or above, or the legal age to form a binding contract in your jurisdiction if that age is greater than 18 years of age, be a member or use the Website/App and Services. Membership or use of this Website/App is void where prohibited by applicable law, and the right to access the Website/App will be deemed to be revoked in such jurisdictions ab initio. By using the Website/App and/or the Services, You represent and warrant that You have the right, authority, and capacity to enter into these Terms of Use and to abide by all of the terms and conditions set forth herein. You also represent and warrant to the Company that You will use Website/App in a manner consistent with any and all applicable laws and regulations.
                </p>
               <h5 class="newstyle">3. SERVICES</h5>
                <ol>
                    <li>The use of this Website/App entitles the User, whether a User or a Customer, to avail certain services as provided in the following clauses ('Services') and interpretation of the term 'Services' shall be done accordingly depending upon the context.</li>
                    <li>The Users are entitled to the following Services:
                        <ol> <li>If You have not completed the registration as per clause 6, You are entitled to view the snapshots of various E-Health Packages or other offers being offered on the Website/App. i.e Home collection requests, customer feedback form etc.</li>
                            <li>
                                 If You have completed the registration as per clause 6, on the payment of Fee, You are entitled:
                                <ol> <li>to view the snapshots of various E-Health Packages or other offers being offered on the Website/App;</li>
                                    <li>to book one or more E-Health Package/s or other offers;</li>
                                    <li>to opt for Home Service (if available at that period of time) wherein the Company shall send its representatives to your door step for the sample collection or You may visit the nearest center (at which the service is currently available) of the Company to give the sample. However, You shall have to visit the designated test centers/ laboratories if the Company requires You to do so;</li>
                                    <li>to receive email/sms/phone calls/letters which shall provide You with the Order ID, the E-Health Package's details and the other details;</li>
                                    <li>to receive the test reports within the suggested time.</li>
                                    <li>By clicking the button Get Call Now use , I agree to be called on behalf of Shree labs, using an automatic telephone dialling system.</li>
                                </ol>
                            </li>
                        </ol>
                    </li>
                    <li>The Services are non-transferable i.e. only the person on whose name the E-Health Package is assigned at the time of booking will be eligible to avail the Services at the lab or through home collection.</li>
                    <li>In case a booking is made before 4 pm on a business day, the Company shall endeavour to give a confirmation call to the Customer on the same day and if it is received after 4 pm, the Company shall endeavour to give a confirmation call to the Customer the next business day.</li>
                    <li>The Customer is required to carry a photo-identification card, a copy of the invoice and Order ID or the transaction number at the time of visit to the Lab or when availing Home Service.</li>
                    <li>You are advised to go through the list of instructions/guidelines that is provided by the Company on its Website/App detailing the dos and don'ts before taking the various tests laid down in the E-Health Packages.</li>
                    <li>The Company may put further terms and conditions with every E-Health Package or Services and in case of any conflict with the Terms of Use or Privacy Policy, the term and conditions put specifically with the E-Heath Package shall prevail.</li>
                    <li>The Company reserves the right to change the nature of Services as mentioned in clause 3.2 at its sole discretion. Such change may be notified to the User/Customer by publishing the same on the Website/App.</li>
                </ol>
               <h5 class="newstyle">4.RESTRICTIONS ON USE</h5>
                <ol>
                    <li>You shall not use the Website/App in order to transmit, distribute, store or destroy material, including without limitation content provided by the Company:
                         <ol> 
                            <li>for any unlawful purpose or in violation of any applicable law, regulation, international law or laws of any other country; or</li>
                            <li>in a manner that will infringe the copyright, trademark, trade secret or other intellectual property rights of others or violate the privacy, publicity or other personal rights of others, or;</li>
                            <li>that is defamatory, libelous, obscene, threatening, abusive or is offensive to users of the Website/App, such as content or messages that promotes racism, bigotry, hatred or physical harm of any kind against any group or individual; or</li>
                            <li>that is false or misleading; or</li>
                            <li>that harasses or advocates harassment of another person..</li>
                         </ol>
                    </li>
                    <li>You are also prohibited from violating or attempting to violate the security of the Website/App, including, without limitation the following activities: (a) accessing data not intended for You or logging into a server or account which You are not authorized to access; (b) attempting to probe, scan or test the vulnerability of a system or network or to breach security or authentication measures without proper authorization; (c) attempting to interfere with service to any user, host or network, including, without limitation, via means of submitting a virus to Website/App, overloading, 'flooding', 'spamming', 'mail bombing', 'hacking' or 'crashing'; or (d) forging any TCP/IP packet header or any part of the header information in any e-mail or newsgroup posting. Violations of system or network security may result in civil or criminal liability.
                    </li>
                    <li>Specific Restrictions on Rights to Use: In addition to the above, You shall not:
                        <ol>
                            <li>modify, adapt, translate, or reverse engineer any portion of the Website/App and/or Services;</li>
                            <li>remove any copyright, trademark or other proprietary rights notices contained in or on the Website/App and/or Service;;</li>
                            <li>use any robot, spider, site search/retrieval application, or other device to retrieve or index any portion of the Website/App and/or Service or for crawling the Website/App and scraping content or to circumvent the technological methods adopted by the Website/App to prevent such prohibited use;</li>
                            <li>reformat or frame any portion of the web pages that are part of the Website and/or Service;</li>
                            <li>create user accounts by automated means or under false or fraudulent pretenses;</li>
                            <li>create or transmit unwanted electronic communications such as 'spam' to other users/customers of the Website/App and/or Service or otherwise interfere with other User's or Customer's enjoyment of the Website/App and/or Service;</li>
                            <li>submit any content or material that falsely express or imply that such content or material is sponsored or endorsed by the Company or the Website/App;</li>
                            <li>transmit any viruses, worms, defects, Trojan horses or other items of a destructive nature;</li>
                            <li>make use of the Website/App or Services to violate the security of any computer network, crack passwords or security encryption codes, transfer or store illegal material including that are deemed threatening or obscene;</li>
                            <li>copy or store any content offered on the Website/App for other than Your own use;</li>
                            <li>take any action that imposes, or may impose in our sole discretion, an unreasonable or disproportionately large load on the Company's IT infrastructure;</li>
                        </ol>
                    </li>
                  </ol>
                <h5 class="newstyle">5.REMEDIES WITH THE COMPANY</h5>
                    <li>You understand and agree that the Company or the Website/App may review any content and in case the Company finds, in its sole discretion, that the User violates any terms of this Agreement especially clause 4, the Company and/or the Website/App reserves the right to take actions to prevent/control such violation including without limitation, removing the offending communication or content from the Website/App and/or terminating the membership of such violators and/or blocking their use of the Website/App and/or Service.</li>
                    <li>The Company shall also be entitled to investigate occurrences which may involve such violations and may and take appropriate legal action, involve and cooperate with law enforcement authorities in prosecuting Users/Customers who are involved in such violations.</li>
                <h5 class="newstyle">6. REGISTRATION PROCESS</h5>
                    <li>The User to be entitled to avail the Services shall have to complete the registration process ('Registration Process') as provided below:
                        <ol>
                            <li>The Registration Process involves the creating of a login id by the User in accordance with clause 3.2.2.</li>
                            <li>Registration is mandatory for the Customers and requires them to provide certain basic information about themselves such as name, age, sex, email address, billing address, collection address, zip/postal code and phone number and accordingly create an Account.</li>
                        </ol>
                    </li>
                    <li>Only after completing the Registration Process, the Users become Customers and become entitled to avail the Services as mentioned in the Clause 3.2, subject to payment of the Fee.</li>
                    <li>The Website/App may provide the facility of 'masking' which allows You to hide or keep confidential or not to fill any information except the information which are considered mandatory by the Company and which will indicated by asterisks. The Company further reserved the right to seek further information, even though masked by You, if in its sole view such information is necessary.</li>
                    <li>The Customers understand and agree that the Company may screen and verify the information provided by the Customer/User and at its sole discretion, increase the amount or number of information for the Registration Process and may ask for further information even after Registration Process. The Company may in its sole discretion, close the Account, if any information provided is found to be false or the information provided is not sufficient.</li>
                <h5 class="newstyle">7. PAYMENT</h5>
                 <ol>
                    <li>The Company shall endeavour to provide the Customer with facilities/gateways to pay the Fee through credit cards (American Express, visa and mastercard), debit cards, cash cards and internet banking.</li>
                    <li>It is understood and agreed by the User/Customer that the Services shall only commence after realization of money in the accounts of the Company incase online payment is being opted for by them.</li>
                    <li>It is understood and agreed by the User/Customer that payment mechanisms may be governed by separate/additional terms of use prescribed by the Company.</li>
                    <li>The Company reserves the right to refuse or cancel any order placed for a product/package that is listed at an incorrect price. This shall be regardless of whether the order has been confirmed and/or payment been levied via credit card. In the event the payment has been processed by the Company, the same shall be credited to your credit card account within 7-14 working days and duly notified to you by email. Once the order has been placed and in case You wish to cancel/modify the same You may do so subject to cancellation/modification charges as prescribed.</li>
                    <li>It is understood and agreed by the User/Customer that payment mechanisms may be governed by separate agreements between the third parties who provide facilities for such payment mechanism and the Company.</li>
                    <li>It is understood and agreed by the User/Customer that in no event whatsoever, the Company shall take any responsibility or liability for malfunctioning or defect in any payment procedure. Payment of the Price shall be the sole responsibility of the User/Customer.</li>
                    <li>The Company reserves the right to charge listing fees for certain listings, as well as transaction fees based on certain completed transactions using the Services through the Website/App or any other fee. The Company further reserves the right to alter any and all fees from time to time, without notice.</li>
                    <li>The User/Customer may be liable to pay all applicable charges, fees, duties, taxes, levies and assessments for availing the Services through the Website/App. Further, the Company reserves the right o change the Fees upon its sole discretion without any prior notice to the Customers/Users.</li>
                  </ol>  
                <h5 class="newstyle">8. REFUND AND CANCELLATION POLICY</h5>
                 <ol>
                    <li>The E-Health Package is valid for the [7] days from the time and date of invoice generation. After 7 days, the Customer shall not be entitled to claim for Services and the company shall have the right to forfeit the fees already paid in such a case.</li>
                    <li>Cancellation shall be acceptable only if the Customer informs the Company within 72 hours from the time of booking. The Customer can contact us through e-mail id, ehealth@lalpathlabs.com in case of cancellation and refund.</li>
                    <li>The refund amount will be sent to the respective debit card/credit card/account from where payment was made and amount will not be refundable by any other mode.</li>
                 </ol>
                <h5 class="newstyle">9. DELIVERY</h5>
                 <ol>
                    <li>The Company shall endeavour to release the test report/s to the Customer if so opted for by him/her within seven working days, unless it is required otherwise. Please allow the minimum time required for processing as specified for the test. Time taken during transit/shipping in case it is delivered by courier is extra to the processing time displayed on the site. Delivery shall be made in the course of the day, and the Customer agrees to refrain from requesting deliveries at very early or late hours of the day. All attempts will be made to deliver on the preferred date of delivery, but the Company will not be held liable if the delivery does not take place on that day. If the customer has made partial payment against the desired services to be availed, in such circumstances, the company may not be able to release the test reports due to administrative/technical reasons.</li>
                    <li>We do not deliver on Sundays and public holidays in India.</li>
                    <li>The Customer/s may also collect the reports by hand during working hours on the date mentioned on the receipt from the designated collection center/branch of the Company.</li>
                    <li>The test reports may also be displayed on the Website/App within the prescribed period, and You may track the same by entering your Order ID.</li>
                 </ol>
                <h5 class="newstyle">10. MODIFICATION OF TERMS OF USE</h5>
                 <ol>
                    <li>You understand and agree that these Terms of Use, the Website/App and the Services can be modified by the Company at its sole discretion, at any time without prior notice, and such modifications will be effective upon such new terms and/or upon implementation of the new changes on the Website/App. You agree to review the Terms of Use periodically so that you are aware of any such modifications and the Company shall not be liable for any loss suffered by You on your failure to review such modified Terms of Use. Unless expressly stated otherwise, any new features, new services, enhancements or modifications to the Website/App or Service implemented after your initial access of Website/App or use of the Service shall be subject to these Terms of Use.</li>
                 </ol>
                <h5 class="newstyle">11. MAINTENANCE</h5>
                 <ol>
                    <li>The Company may at its sole discretion and without assigning any reason whatsoever at any time deactivate or/and suspend the User's/Customer's access to the Website/App and/or the Services (as the case may be) without giving any prior notice, to carry out system maintenance or/and upgrading or/and testing or/and repairs or/and other related work. Without prejudice to any other provisions of this Agreement, the Company shall not be liable to indemnify the User for any loss or/and damage or/and costs or/and expense that the User may suffer or incur, and no fees or/and charges payable by the User to the Company shall be deducted or refunded or rebated, as a result of such deactivation or/and suspension.</li>
                 </ol>
                <h5 class="newstyle">12. TERM, TERMINATION AND DEACTIVATION PROCESS OF ACCOUNT</h5>
                 <ol>
                    <li>These Terms of Use, with modifications as contemplated, shall remain in full force and effect during the user of the Website/App for all Users.</li>
                    <li>For Customers, the Terms of Use shall commence from the time the Registration Process is concluded as per clause 6 of this Agreement and shall be valid until terminated as provided below or till the time the Account is maintained.</li>
                    <li>The User may deactivate their account by contacting Customer Care team to raise a request for their account deactivation or deletion. A reference ID for such raised request shall be provided to User. The Request will be processed within Seven (7) Working days from the date of raise of request and once the request is processed for the account is deactivation or deletion, the User shall be informed through SMS or call.</li>
                    <li>The Company may terminate this Agreement with immediate effect, without prior notice and without assigning any reason/s whatsoever and without any prejudice to any/all other rights in the following events:
                        <ol>
                            <li>where the Account remains unused for a period of six months or more; or</li>
                            <li>if in the opinion of the Company, the User has breached any of the terms and conditions of this Agreement or/and the Terms of Use; or breached any prevailing laws, rules and regulations; or</li>
                            <li>if, in the opinion of the Company or/and any regulatory authority, it is not in the public interest to continue providing the use or Service to the User for any reason.</li>
                        </ol>
                    </li>
                    <li>Notwithstanding anything contained in the Terms of Use, clauses 5, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20 and 21 shall survive any termination or expiration of these Terms of Use.</li>
                 </ol>
                <h5 class="newstyle">13. LIABILITIES UPON TERMINATION</h5>
                 <ol>
                    <li>If the Terms of Use is terminated pursuant to clauses set out in clause 12 above, without prejudice to any other remedies available to the Company, You shall not be refunded whether a part or whole of the Fee.</li>
                 </ol>
                <h5 class="newstyle">14. OWNERSHIP</h5>
                 <ol>
                    <li>Any material, content or logos, marks, software on or part of the Website/App and all aspects thereof, including all copyrights and other intellectual property or proprietary rights therein, is owned by the Company or its licensors. You acknowledge that the Website/App and any underlying technology or software on the Website/App or used in connection with rendering the Services are proprietary information owned or duly licensed to the Company, except where it is indicated otherwise. You are prohibited to modify, reproduce, distribute, create derivative works of, publicly display or in any way exploit, any of the content, software, marks, logos, and/or materials available on the Website/App in whole or in part except as expressly allowed under the Terms of Use. You have no other express or implied rights to use, in any manner whatsoever, the content, software, marks, logos, and/or materials available on the Website/App.</li>
                 </ol>
                <h5 class="newstyle">15. COPYRIGHT DISPUTE POLICY</h5>
                 <ol>
                    <li>The Company has adopted the following general policy towards copyright infringement:</li>
                    <li>If the Company believes in good faith any material on its Website/App has been illegally copied or is posted, uploaded or made accessible through the Website/App or Services and distributed by any advertisers, its affiliates, content providers, members or Users; it shall send an Infringement Notice and remove and discontinue Services to offenders.</li>
                    <li>If despite the Infringement Notice, the offender does not take the requisite steps, the Company shall have the right to proceed against the offender by filing a suit in the appropriate court of law or any other appropriate legal action on ground of such infringement.</li>
                 </ol>
                <h5 class="newstyle">16. DISCLAIMER</h5>
                 <ol>    
                    <li>THE WEBSITE/APP IS PROVIDED BY THE COMPANY ON AN 'AS IS' BASIS THE COMPANY AND ITS LICENSORS AND AFFILIATES MAKE NO REPRESENTATIONS OR WARRANTIES OF ANY KIND, EXPRESS, STATUTORY OR IMPLIED AS TO THE OPERATION OF THE WEBSITE/APP, PROVISION OF SERVICES OR SOFTWARE OR THE INFORMATION, CONTENT, MATERIALS, OR PRODUCTS INCLUDED ON THE WEBSITE/APP OR IN ASSOCIATION WITH THE SERVICES. TO THE FULLEST EXTENT PERMISSIBLE BY APPLICABLE LAW, THE COMPANY AND ITS LICENSORS AND AFFILIATES DISCLAIM ALL WARRANTIES, EXPRESS, STATUTORY, OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. THE COMPANY AND ITS LICENSORS AND AFFILIATES FURTHER DO NOT WARRANT THE ACCURACY OR COMPLETENESS OF THE INFORMATION, TEXT, GRAPHICS, LINKS OR OTHER ITEMS CONTAINED WITHIN THE WEBSITE/APP. THE COMPANY IS NOT RESPONSIBLE FOR THE CONDUCT, OF ANY USER OF THE WEBSITE/APP. THE COMPANY DOES NOT WARRANT OR COVENANT THAT THE SERVICES WILL BE AVAILABLE AT ANY TIME OR FROM ANY PARTICULAR LOCATION, WILL BE SECURE OR ERROR-FREE, THAT DEFECTS WILL BE CORRECTED, OR THAT THE SERVICES AND ACCESS TO THE WEBSITE/APP IS FREE OF VIRUSES OR OTHER POTENTIALLY HARMFUL COMPONENTS. ANY MATERIAL OR CONTENT DOWNLOADED OR OTHERWISE OBTAINED THROUGH THE USE OF THE SERVICES OR THE WEBSITE/APP IS ACCESSED AT YOUR OWN DISCRETION AND RISK AND YOU WILL BE SOLELY RESPONSIBLE FOR ANY DAMAGE TO YOUR COMPUTER SYSTEM OR LOSS OF DATA THAT RESULTS FROM THE DOWNLOAD OF ANY SUCH MATERIAL. NO ADVICE OR INFORMATION, WHETHER ORAL OR WRITTEN, OBTAINED BY ANY USER FROM THE COMPANY, THE WEBSITE/APP OR THROUGH OR FROM THE SERVICES, THE INFORMATION, CONTENT, MATERIALS, OR PRODUCTS ON THE WEBSITE/APP SHALL CREATE ANY WARRANTY NOT EXPRESSLY STATED HEREIN.</li>
                    <li>ALL THE CONTENTS OF THIS WEBSITE/APP ARE ONLY FOR GENERAL INFORMATION OR USE. THEY DO NOT CONSTITUTE ANY MEDICAL ADVICE AND SHOULD NOT BE RELIED UPON IN MAKING (OR REFRAINING FROM MAKING) ANY DECISION. ALTHOUGH THE LABORATORY PROVIDES THE LARGEST SINGLE SOURCE OF OBJECTIVE, SCIENTIFIC DATA ON PATIENT STATUS, IT IS ONLY ONE PART OF A COMPLEX BIOLOGICAL PICTURE OF HEALTH OR DISEASE. AS PROFESSIONAL CLINICAL LABORATORY SCIENTISTS, OUR GOAL IS TO ASSIST YOU IN UNDERSTANDING THE PURPOSE OF LABORATORY TESTS AND THE GENERAL MEANING OF YOUR LABORATORY RESULTS.IT IS IMPORTANT THAT YOU COMMUNICATE WITH YOUR PHYSICIAN SO THAT TOGETHER YOU CAN INTEGRATE THE PERTINENT INFORMATION, SUCH AS AGE, ETHNICITY, HEALTH HISTORY, SIGNS AND SYMPTOMS, LABORATORY AND OTHER PROCEDURES (RADIOLOGY, ENDOSCOPY, ETC.), TO DETERMINE YOUR HEALTH STATUS. THE INFORMATION PROVIDED THROUGH THIS SERVICE IS NOT INTENDED TO SUBSTITUTE FOR SUCH CONSULTATIONS WITH YOUR PHYSICIAN NOR MEDICAL ADVICE SPECIFIC TO YOUR HEALTH CONDITION. DISCLAIM ANY LIABILITY ARISING OUT OF YOUR USE OF THIS SERVICE OR FOR ANY ADVERSE OUTCOME FROM YOUR USE OF THE INFORMATION PROVIDED BY THIS SERVICE FOR ANY REASON, INCLUDING BUT NOT LIMITED TO ANY MISUNDERSTANDING OR MISINTERPRETATION OF THE INFORMATION PROVIDED THROUGH THIS SERVICE.ANY SPECIFIC ADVICE OR OPINION IN ANY PART OF THE REPORT IS/ARE THE PERSONAL OPINION OF SUCH EXPERTS/CONSULTANTS/PERSONS AND ARE NOT SUBSCRIBED TO BY THIS WEBSITE/APP. FURTHER IT SHALL BE THE SOLE RESPONSIBILITY OF THE USERS/CUSTOMERS TO PROVIDE ANY INFORMATION AND/OR DISCLOSE TRUE AND CORRECT INFORMATION ABOUT THEIR MEDICAL HISTORY AT THE TIME OF SUBSCRIBING FOR THE SERVICES AND THE COMPANY DOES NOT TAKE ANY RESPONSIBILITY FOR THE ACCURACY OR VALIDITY OR TRUTH OF THE REPORT POSTED ON THE WEBSITE/APP AND THE COMPANY SHALL NOT BE LIABLE ON THIS ACCOUNT BASED ON ANY INCORRECT/FASLE INFORMATION HAVING BEEN PROVIDED BY THE UER/CUSTOMER.</li>
                    <li>SINCE THE COMPANY ACTS ONLY AS A SERVICE PORTAL FOR THE USERS/CUSTOMERS, IT SHALL NOT HAVE ANY LIABILITY WHATSOEVER FOR ANY ASPECT OF THE PAYMENT BETWEEN THE THIRD PARTY AND THE CUSTOMER/USER.</li>
                    <li>IN NO EVENT SHALL THE COMPANY BE LIABLE FOR ANY DIRECT, INDIRECT, PUNITIVE, INCIDENTAL, SPECIAL, CONSEQUENTIAL DAMAGES OR ANY OTHER DAMAGES RESULTING FROM: (A) THE USE OR THE INABILITY TO USE THE SERVICES; (B) UNAUTHORIZED ACCESS TO OR ALTERATION OF THE USER'S TRANSMISSIONS OR DATA; (C) ANY OTHER MATTER RELATING TO THE SERVICES; INCLUDING, WITHOUT LIMITATION, DAMAGES FOR ANY LOSS WHATSOEVER ARISING OUT OF OR IN ANY WAY CONNECTED WITH THE USE OR PERFORMANCE OF THE WEBSITE/APP</li>
                    <li>NEITHER SHALL THE COMPANY BE RESPONSIBLE FOR THE DELAY OR INABILITY TO USE THE WEBSITE/APP OR RELATED SERVICES, THE PROVISION OF OR FAILURE TO PROVIDE SERVICES, OR FOR ANY INFORMATION, SOFTWARE, PRODUCTS, SERVICES AND RELATED GRAPHICS OBTAINED THROUGH THE WEBSITE/APP, OR OTHERWISE ARISING OUT OF THE USE OF THE WEBSITE/APP, WHETHER BASED ON CONTRACT, TORT, NEGLIGENCE, STRICT LIABILITY OR OTHERWISE. FURTHER, THE COMPANY SHALL NOT BE HELD RESPONSIBLE FOR NON-AVAILABILITY OF THE WEBSITE/APP DURING PERIODIC MAINTENANCE OPERATIONS OR ANY UNPLANNED SUSPENSION OF ACCESS TO THE WEBSITE/APP THAT MAY OCCUR DUE TO TECHNICAL REASONS OR FOR ANY REASON BEYOND THE COMPANY'S CONTROL. THE USER/CUSTOMER UNDERSTANDS AND AGREES THAT ANY MATERIAL AND/OR DATA DOWNLOADED OR OTHERWISE OBTAINED THROUGH THE WEBSITE/APP IS DONE ENTIRELY AT THEIR OWN DISCRETION AND RISK AND THEY WILL BE SOLELY RESPONSIBLE FOR ANY DAMAGE TO THEIR COMPUTER SYSTEMS OR LOSS OF DATA THAT RESULTS FROM THE DOWNLOAD OF SUCH MATERIAL AND/OR DATA.</li>
                    <li>THESE LIMITATIONS, DISCLAIMER OF WARRANTIES AND EXCLUSIONS APPLY WITHOUT REGARD TO WHETHER THE DAMAGES ARISE FROM (A) BREACH OF CONTRACT, (B) BREACH OF WARRANTY, (C) NEGLIGENCE, OR (D) ANY OTHER CAUSE OF ACTION, TO THE EXTENT SUCH EXCLUSION AND LIMITATIONS ARE NOT PROHIBITED BY APPLICABLE LAW.</li>
                 </ol>
                <h5 class="newstyle">17. LIMITATION ON LIABILITY</h5>
                 <ol>    
                    <li>The Company shall not be liable for any failure to perform its obligations hereunder where such failure results from any cause beyond the Company's reasonable control, including, without limitation, mechanical, electronic or communications failure or degradation (including 'line-noise' interference). WITHOUT LIMITING THE FOREGOING, THE COMPANY AND ITS AFFILIATES AND SUPPLIERS WILL NOT BE LIABLE UNDER ANY LAW, FOR ANY INDIRECT, INCIDENTAL, PUNITIVE, AND CONSEQUENTIAL DAMAGES, INCLUDING, BUT NOT LIMITED TO LOSS OF PROFITS, SERVICE INTERRUPTION, AND/OR LOSS OF INFORMATION OR DATA.</li>
                 </ol>
                <h5 class="newstyle">18. INDEMNITY</h5>
                 <ol>
                    <li>You agree to indemnify and hold the Company, its parents, subsidiaries, affiliates, officers and employees, harmless, including costs and attorneys' fees, from any claim or demand made by any third party due to or arising out of (i) your access to the Website/App, (ii) your use of the Services, (iii) the violation of these Terms of Use by You, or (iv) the infringement by You, or any third party using Your account or User ID or password, of any intellectual property or other right of any person or entity.</li>
                 </ol>
                <h5 class="newstyle">19. PRIVACY</h5>
                 <ol>
                    <li>Use of the Website/App and/or the Services is also governed by our Privacy Policy.</li>
                 </ol>
                <h5 clasz="newstyle">20. CONFIDENTIALITY</h5>
                 <ol>
                    <li>For the purpose of this Agreement and attachments thereto and all renewals, 'Confidential Information' means all information (including any information relating to the Account, username or password etc.), methods developed for analysis, examination and verification and other such details (the 'Disclosing Party') or, which may be supplied to or may otherwise come into the possession of the other (the 'Receiving Party'), whether orally or in writing or in any other form, and which is confidential or proprietary in nature or otherwise expressed by the Disclosing Party to be confidential and is not generally available to the public.</li>
                    <li>The Receiving Party shall keep confidential and secret and not disclose to any third party the Confidential Information or any part of it. The Receiving Party agrees to take all possible precautions with regard to protecting Confidential Information from any third party.</li>
                    <li>Further no use, reproduction, transformation or storage of the Confidential Information shall be made by the User without the prior written permission of the Company, except where required to be disclosed pursuant to any applicable law or legal process issued by any court or the rules of any competent regulatory body.</li>
                    <li>All information and data submitted by the User shall become the property of the Company and all such information shall be disclosed in accordance with the Terms of Use. Notwithstanding anything contained in the Terms of Use, the User/Customer gives his unconditional consent to the Company that it may sell or license or permit third parties to use such data or information, on payment of consideration or otherwise.</li>
                    <li>The User has access to only his own data and information stored in the database at Website/App (subject to prior confirmation of identity) and nothing more. The User may edit or amend such data and information from time to time, if Company provides such an option.</li>
                    <li>All Confidential Information (including name, e-mail address etc.) voluntarily revealed by the User in chat and bulletin board areas, is done at the sole discretion and risk of the User. The Company shall not be responsible for misuse of any such information, collected by a third party, or any unsolicited messages from such third parties.</li>
                    <li>If the User is neither a genuine Customer nor an intended recipient and are using or accessing the Website/App to gain Confidential Information and if such an User has obtained access to the Confidential Information, it shall be a breach of this Agreement and shall be kept absolutely confidential. Any use or divulgence of such Confidential Information by such User, shall entitle the Company to inquire and investigate and seek legal remedy against such User including to seek temporary and permanent injunction.</li>
                 </ol>
                <h5 class="newstyle">21. MISCELLANEOUS</h5>
                 <ol>
                    <li>Governing law and Dispute Resolution- This Agreement and Terms of Use shall be governed by and constructed in accordance with the laws of India only without reference to conflict of laws principles and all disputes arising in relation hereto shall be subject to the exclusive jurisdiction of the courts of New Delhi, India.</li>
                    <li>Assignability -The Company may assign any of its responsibilities/obligations to any other Person without notice to the User, at its sole discretion. However, You shall not assign, sub-licence or otherwise transfer any of your rights under these Terms of Use to any other party, unless a written consent is taken from the Company.</li>
                    <li>Severability - If any provision of these Terms of Use is found to be invalid, the invalidity of that provision will not affect the validity of the remaining provisions of the Terms of Use, which shall remain in full force and effect.</li>
                    <li>Waiver - Failure by the Company to exercise any right or remedy under these Terms of Use does not constitute a waiver of that right or remedy.</li>
                    <li>Force Majeure - The Company is not liable for failure to perform any of its obligations if such failure is as a result of Acts of God (including fire, flood, earthquake, storm, hurricane or other natural disaster), war, invasion, act of foreign enemies, hostilities (regardless of whether war is declared), civil war, rebellion, revolution, insurrection, military or usurped power or confiscation, terrorist activities, nationalisation, government sanction, blockage, embargo, labor dispute, strike, bandh, lockout or any interruption or any failure of electricity or server, system, computer, internet or telephone service.</li>
                    <li>Grievance Redressal: The Company shall endeavour to address grievance or complaints of the Users to the extent possible. Towards this the user can contact the Grievance/Nodal Officer of the Company MR. Vinay Gujral, cs@lalpathlabs.com</li>
                    <li>Links to third party sites
                        <ol>
                            <li>The Website/App may contain links to other websites ('Linked Sites'). The Linked Sites are not under the control of the Company or the Website/App and the Company is not responsible for the contents of any Linked Site, including without limitation any link contained in a Linked Site, or any changes or updates to a Linked Site. The Company is not responsible for any form of transmission, whatsoever, received by the User from any Linked Site. The Company is providing these links to the User only as a convenience, and the inclusion of any link does not imply endorsement by the Company or the Website/App of the Linked Sites or any association with its operators or owners including the legal heirs or assigns thereof.</li>
                            <li>The Company is not responsible for any errors, omissions or representations on any Linked Site. The Company does not endorse any advertiser on any Linked Site in any manner. The Users are requested to verify the accuracy of all information on their own before undertaking any reliance on such information.</li>
                        </ol>
                    </li>
                 </ol>
                <h5 class="newstyle">22. USERS COMMUNICATIONS</h5>
                 
                    <p>When you visit the Website/App or use it to send emails/SMS, provide information or communicate to us, you understand and agree that you are communicating with us through electronic records. You hereby provide your consent to receive communications via electronic records from us periodically or as and when required. Further, you allow us to communicate with you through email or by such other mode of communication, electronic or otherwise as the need may be.</p>
                <h5 class="newstyle">23. MARKETING COMMUNICATION</h5>
                    <p>Shree labs strongly recommend that you consult a medical professional before availing any diagnostic tests/services mentioned through digital platforms, social networks, newspapers, flyers, or SMS sent by Shree labs. This consultation is essential to ensure that the professional is able to check all related parameters and suggest tests or services that are appropriate for your specific medical needs.
                        You understand and accept that the promotions and advertisements provided by Shree labs are for informational purposes only and do not constitute medical advice. These promotions and advertisements are not a substitute for professional medical guidance.
                        Shree labs disclaims any liability for decisions made solely based on promotions or advertisements. We are not responsible for any adverse consequences resulting from not consulting a healthcare professional before undergoing tests or services.
                        The promotions and advertisements provided by Shree labs on digital platforms, social networks, newspapers, flyers, or SMS or other are for informational purposes only. Our intention is to raise awareness of the services available at Shree labs and the constituents of the same.
                    </p>
                <h6 class="newstyle">1. Contests/Polls/Engagement Activities on Social Media</h6>
                    <p>By participating in the social media (Facebook, Instagram, WhatsApp, Twitter, Threads, etc) contests, polls, engagement activities, etc. that would be posted on social media or shared through email, SMS, or WhatsApp, participants acknowledge that they have read, understood, and agreed to abide by these terms and conditions.
                        The above-mentioned activities are only engagement activities of Shree labs Limited, having its registered office at Block E, Sector 18, Rohini, New Dehi-110085. Participation in the contest is voluntary. Please read the terms and conditions carefully.
                        Participants must be human individuals and may not be automated bots or machines. You shall be legally competent to enter a binding contract under the applicable laws of India. All who fulfil the eligibility criteria to participate in the Contest shall individually be considered and referred to as “Participant” and collectively “Participants” for the purpose of these T&Cs
                    </p>
                 <ol>
                    <li>This contest is open to all Indian Citizens aged 18 years and over, except for employees of Shree labs Ltd, its immediate family members, affiliate, subsidiaries, distributors, dealers, principals (including the promoter(s) being hired by) and suppliers as well as it's other creative, marketing and other agencies etc.</li>
                    <li>The participant is allowed to submit multiple entries/single entry as would be mentioned in the launch post, but each person stands a chance to win one (1) Giveaway only.</li>
                    <li>Shree labs has the right to decide the winner(s) for each contest basis unbiased approach.</li>
                    <li>The decision of the Company is final and conclusive. The giveaway is non-refundable, non-transferable, non-exchangeable for cash, credit or any other item. No correspondence, queries, appeals or protests will be entertained.</li>
                    <li>Giveaways must be claimed within the specified time as advised. If in any case, the Company elects to post or courier a giveaway to a winner, the courier service fee will be charged to the participant and no responsibility will be accepted by Shree labs Ltd. for any damage occurred during the transition.</li>
                    <li>For the safe and effective postal delivery of the giveaway, Shree labs Ltd disclaims all liabilities arising from any lost or unsuccessful transmission of Giveaways.</li>
                    <li>Shree labs Ltd reserves the right to substitute the giveaway with an alternative giveaway of the same value, wherever it deems appropriate. Shree labs Ltd reserves the right to disqualify any entries from any participant in the contest and prohibit that Person from further participating in the contest in the event there is suspicion that there has been an attempt to tamper with the outcomes/results</li>
                    <li>Shree labs Ltd may, at any time at its sole discretion and without prior notice, vary, modify, delete or discontinue any aspect of the contest (including the cancellation or discontinuation of the contest and/or replacements and/or substitutions of the giveaway being offered) or any part of these terms & conditions and the participant agrees to be bound by such amendments.</li>
                    <li>The winner(s) will be selected from the entries during the campaign’s period only. It is the participant’s responsibility to ensure adherence to the contest’s instructions to qualify for participation.</li>
                    <li>The result of the contest will be announced on our Facebook and/or Instagram wall post. The winner(s) shall revert with their contact details to claim the giveaway within 14 days of the announcement and else it would be deemed cancelled.</li>
                    <li>Any giveaway, which remains unclaimed after FOURTEEN (14) DAYS from the date of announcement shall be forfeited and stays non-transferable. The winner whose Giveaway has been forfeited is not entitled to any payment or compensation.</li>
                    <li>By entering this competition, an entrant is indicating his/her agreement to be bound by these terms and conditions.</li>
                    <li>By joining the contest, the customer has agreed to provide their contact details to Shree labs Ltd. for future marketing purposes. We respect your privacy and will not share it with a third party.</li>
                    <li>Giveaway can be a prize or a coupon but not cash.</li>
                    <li>Shree labs reserves the right to cancel or amend the competition and these terms and conditions without notice.</li>
                  </ol>
                    <p>The competition and these terms and conditions will be governed by Indian law and any disputes will be subject to the exclusive jurisdiction of the courts of Delhi.
                        We, in our sole discretion reserves our right to exclude you from the Contest and/or not to attribute the Prize, and/or to cancel all or part of the Contest, without any liability on our part, if We believe You have (a) breached any of these T&Cs; (b) acted or have the intention of acting in a dishonest or fraudulent manner, or in bad faith; (c) tampered with the entry process or the operation of the Contest; (d) acted in an unsportsmanlike or disruptive manner or with intent to annoy, abuse, threaten or harass any other person
                    </p>
                    <p>If there are any Government restrictions imposed which may impact the operation of the Contest as usually planned, Shree labs cannot be held liable due to such restrictions including for inability to provide the Prizes or changing the Prizes due to such restrictions. Any delay or inability to operate the Contest in that regard will be treated as a Force Majeure Event. In the event of any directions of the Government applicable for consumers/Participants/Prize Winners, you shall ensure due compliance to the same and Shree labs cannot be held liable for any non-compliance in that regard.
                        For any disputes, complaints, queries pertaining to this Contest, please reach out to us.
                    </p>
                <h6 class="newstyle">2. Brand Communication Bharat Ka Vishwas</h6>
                 <ol>
                    <li>Tests mentioned are referred to as the main test and its components, known as analyte in medical terms.</li>
                    <li>All prices are subject to change and Shree labs reserves the right to change it at any time.</li>
                    <li>Location level pricing applicable.</li>
                    <li>In case of any dispute, Delhi courts will have exclusive jurisdiction.</li>
                    <li>All numbers & images are integral property of Shree labs and copying/replicating or utilizing them in any manner may result in legal consequences.</li>
                 </ol>
                <h5 class="newstyle">24. USERS COMMUNICATIONS</h5>
                  <h6 class="newstyle">What is Swasth Point?</h6>
                    <p>Swasth Point is the promotional amount given by Shree labs to its customers in the Shree labs Wallet. Each mobile number registered with LPL & having up to 50 registered patients (PIDs) will have Shree labs Wallet Activated by Default.</p>
                  <h6 class="newstyle">Terms & Conditions</h6>
                    <ol>
                    <li>Shree labs Loyalty Program (Wallet program) is open to Indian citizens.</li>
                    <li>No two offers or discounts can be clubbed together unless specified otherwise.</li>
                    <li>Shree labs Loyalty Program is for individuals only - it is not a corporate program</li>
                    <li>Any misuse of Program benefits may result in termination or withdrawal of benefits at the sole discretion of Shree labs Ltd.</li>
                    <li>Shree labs Loyalty Program can be revoked or refused if anyone is involved in any act of fraud, cheating with or without cause and without notice.</li>
                    <li>Benefits and offers may change or be withdrawn without prior intimation. Shree labs will not be responsible for any liability arising from such situations.</li>
                    <li>By availing benefits of Shree labs Loyalty Program, you agree that you have read and understood the Terms and Conditions that govern the Loyalty Program and give consent to Shree labs to contact you for promotions, product information and discount. This will override registry on NDNC/DND.</li>
                    <li>Shree labs reserves the right to refuse offer/Loyalty benefits to an applicant without assigning any reason whatsoever</li>
                    <li>Shree labs reserves the right to amend these terms and conditions or close the Loyalty Program at any time without any prior notice. Modifications of these terms will be effective from the time they are updated in the Terms and Conditions section.</li>
                    <li>Any dispute arising will fall under the jurisdiction of courts in Delhi only.</li>
                   </ol>
                  <h6 class="newstyle">Earning Loyalty Points</h6>
                   <ol>
                    <li>Loyalty Points will be credited within 24 hours once the final report is generated.</li>
                    <li>Earned Points will be linked to the mobile number of users.</li>
                    <li>Earned Points will have a pre-defined validity. In case of non-usage, it will expire.</li>
                    <li>The number of loyalty points will be defined on the basis of the coupon code/promotional campaign.</li>
                    <li>No two offers or discounts available can be clubbed together unless specified otherwise.</li>
                    <li>Loyalty Points cannot be earned with other discounts like geography specific discount, and corporate discount.</li>
                    <li>Loyalty Points earned as a result of fraudulent activities will be revoked and deemed invalid.</li>
                    <li>Shree labs reserves the right to change the validity of points.</li>
                    <li>Any dispute arising will fall under the jurisdiction of courts in New Delhi only</li>
                    <li>Special Price Tests/Discounted Tests will not be considered for earning of loyalty points</li>
                    <li>Fair Usage policy: Any patient is eligible to earn loyalty points only twice a day and five times in a month.</li>
                  </ol>
                  <h6 class="newstyle">Redeeming Loyalty Points</h6>
                  <ol>
                      <li>Points will be redeemed in FIFO manner. Early expiring points will be redeemed first</li>
                      <li>Points are not redeemable in cash. They are not transferable.</li>
                      <li>On redemption, the Points so redeemed would be automatically subtracted from the accumulated points.</li>
                      <li>No discount of any other type can be availed of when points are being used/redeemed</li>
                      <li>Once points are redeemed or expired, they cannot be reinstated under any circumstances.</li>
                      <li>Points cannot be redeemed on purchase of tests that are already offered at some discount like, geography specific discount, corporate discount and select set of tests wherein prices are determined by government.</li>
                      <li>Shree labs reserves the right to change the max usage limit of Loyalty Points.</li>
                      <li>Any dispute arising will fall under the jurisdiction of courts in Delhi only.</li>
                  </ol>
                  <h6 class="newstyle">No Liability</h6>
                      <p>Shree labs and/or Partners shall not be liable to any Customer or his/her family or companion, for any indirect or consequential loss, damage or expense of any kind whatsoever, arising out of or in connection with the program and/or the provision or the refusal to provide any benefits, whether such loss, damage or expense is caused by negligence or otherwise, and whether Shree labs/Partners have any control over the circumstances giving rise to the claim or not.</p>
                  <h6 class="newstyle">Usage Restrictions</h6>
                    <ol>
                        <li>Certain Tests & packages are excluded from the wallet program.</li>
                        <li>100 % of the Cart value can be redeemed through Swasth points and there will be no restriction on the burning of points while placing the order.</li>
                        <li>Earning will be done as per promotional campaign. Senior citizens (above 65 years age) will earn 10% of transaction amount as Swasth points. Points can be earned only on eligible test codes.</li>
                        <li>Loyalty Points can only be availed by following business entities:
                            <ol>
                                <li>Walk-in Lab</li>
                                <li>Coco PSC</li>
                                <li>Franchise PSC</li>
                                <li>Cash Collection Centre</li>
                                <li>Credit Collection Centre</li>
                                <li>Franchise Home Collection</li>
                                <li>Franchise Home Collection-Credit</li>
                                <li>Home Collection</li>
                            </ol>
                        </li>
                    </ol>
                <h6 class="newstyle">Order cancellation & Refunds - Stating the scenarios.</h6>
                    <ol>
                        <li>In case of order cancellation, refunds to be processed on the basis of the source of payment. For example - If 200 points were used while making the payment of Rs 1000, Rs 200 will be Auto refunded in Swasth Points and balance to be refunded in actual payment mode</li>
                        <li>In case of order cancellation, any cashbacks/rewards earned on that order will be deducted from the total amount.</li>
                    </ol>
                <h6 class="newstyle">Validity of Swasth Points</h6>
                    <ol>
                        <li>Swasth Points will have a standard 180 days validity, unless mentioned otherwise.</li>
                        <li>The points will be redeemed by FIFO method. (First In First Out)</li>
                    </ol>
               <h5 class="newstyle">25. EMI PAYMENT OPTION</h5>
                <h6 class="newstyle">Eligibility</h6>
                <ol>
                    <li>The EMI option is available only for patients with a Net Amount Payable of ₹ 2500/- or above.</li>
                    <li>EMI options can only be claimed against Credit Cards issued by eligible banks.</li>
                </ol>
                
                <h6 class="newstyle">Bank Information</h6>
                <ol>
                    <li> EMI options are available with different banks, and each bank may have its own minimum amount requirement for availing the EMI facility.</li>
                    <li>The names of banks offering EMI, their respective interest rates, and tenures will be visible on the payment page once the EMI option is selected.</li>
                    <li>Shree labs has no control over the interest rate and tenure offered by the banks, it is solely at the bank's discretion.</li>
                </ol>
                
                <h6 class="newstyle">Interest Rate and Tenure</h6>
                <ol>
                    <li>The interest rate and tenure for the EMI option will be determined by the selected bank and displayed during the payment process.</li>
                    <li>The patient agrees to the terms set by the bank upon selecting the EMI option.</li>
                </ol>
                
                <h6 class="newstyle">Order Modification and Cancellation</h6>
                <ol>
                    <li>Orders booked via the EMI option cannot be modified later. If any changes are required, the patient must cancel the previous order and create a new one</li>
                    <li>On cancellation of orders, Shree labs will refund the Cart Value (exclusive of any interest paid to the bank).</li>
                    <li>The EMI agreement with the bank will not be automatically canceled with the order cancellation. Patients must contact their respective bank to close the EMI, if desired.</li>
                    <li>Terms and Conditions of EMI</li>
                    <p>The following terms & conditions apply to any transactions made using EMI as a payment option on 
                        <a href="https://369healthdex.com/" target="_blank">https://369healthdex.com/</a>
                    </p>
                </ol>
                
                <ol>
                    <li>Shree labs facilitates Equated Monthly Installments (EMI) payment method on all purchases worth: (a) Rs. 2,500 and above made at 
                        <a href="https://369healthdex.com/" target="_blank">https://369healthdex.com/</a> using eligible credit cards.
                    </li>
                    <li>EMI facility can only be claimed against Credit Cards issued by eligible banks and is not available on purchases made using Net Banking or Cash on Delivery payment methods.</li>
                    <li>The EMI facility is being offered by the respective banks to the customer and Shree labs has no role to play in the approval, extension, pricing, modification, pre-closure, closure or any matter incidental thereto pertaining to offering of the EMI facility, which is decided at the sole discretion of the bank.</li>
                    <li>The EMI facility being offered by the banks to the customers is governed by the respective terms and conditions of each bank/issuer and the customer is advised to approach the bank/issuer in case of any complaint, dispute or enquiry about an EMI transaction</li>
                    <li>Shree labs reserves the right to stop facilitating this service on 
                        <a href="https://369healthdex.com/" target="_blank">https://369healthdex.com/</a> without any prior notice.
                    </li>
                    <li>Shree labs on a best effort basis displays representative EMI related information (EMI amount, Interest rate charged, Total amount payable) for the customer's purchase on 
                        <a href="https://369healthdex.com/" target="_blank">https://369healthdex.com/</a> 
                        as per the information shared with it by the respective banks on an 'AS IS' basis.
                    </li>
                    <li>Shree labs does not charge the customer any processing or convenience fee for the purpose of facilitating the EMI facility for its customers.</li>
                    <li>Orders booked via the EMI option cannot be modified later. If any changes are required, the customer must cancel the previous order and create a new one.</li>
                    <li>In the case of customer cancellations on EMI, Shree labs will facilitate the refunds as per the relevant refund policy. The customer is advised to check with the respective bank/issuer offering the EMI how the cancellations will affect the EMI terms and of any pre-closure or interest charges levied on the customer.</li>
                    <li>Shree labs shall not be held liable for any dispute arising out of or in connection with such EMI facility being offered by the respective banks/issuer including but not limited to the authenticity and/or accuracy of any EMI information supplied by the banks to Shree labs for displaying on 
                        <a href="https://369healthdex.com/" target="_blank">https://369healthdex.com/</a>
                    </li>
                </ol>
                
                <h5 class="newstyle">26. Smart Report – Terms & Conditions</h5>
                <ol>
                    <li>No part of Shree labs Smart Report should be reproduced, extracted, distributed, or transmitted in any form or by any means, including photocopying, or other electronic or mechanical methods, without the prior express written permission of Shree labs.</li>
                    <li>Shree labs shall not be liable for any indirect, direct, special, consequential or other damages. This report is not intended to replace your doctor or professional medical advice, diagnosis, or treatment. We strongly recommend that you consult with the doctor for clinical correlation and further medical intervention</li>
                    <li>Please be careful of any food allergies or intolerances that you may be sensitive to. Analysis uses Blood data only. The analyzed information in this Smart Report is not applicable for individuals less than 18 years of age and for pregnant women.</li>
                    <li>The Smart Report is generated through a third-party service provider “360 Health Vectors Pvt Ltd”. Shree labs reserves the right to replace the service provider in future, as may be necessary.</li>
                    <li>The report is intended for informational purposes related to wellness and should not be used for legal, insurance, employment or any other purposes without verification.</li>
                    <li>The customer is responsible for ensuring the accuracy of personal information provided to Shree labs for report generation. I understand that Shree labs Ltd. will utilize personal information in accordance with Shree labs Privacy Policy as stated in the link: 
                        <a href="https://369healthdex.com/Privacy_Policy" target="_blank">https://369healthdex.com/Privacy_Policy</a>
                    </li>
                    <li>The current price of the Smart Report is Rs. 200 which includes all applicable taxes.</li>
                    <li>The price of the Smart Report is subject to change without prior notice. Any price changes will not affect previously purchased reports</li>
                    <li>Shree labs reserves the right to update or modify the terms and conditions, commercials, offerings as needed, with prior notice to customers.</li>
                    <li>Smart Report is only applicable with any Swasthfit packages currently.</li>
                    <li>For any queries, complaints of Smart Report please reach out to 01149885050.</li>
                    <li>The aggregate liability of Shree labs Ltd. with regard to the Smart Report, or any errors and omissions shall be limited to price paid by the customer</li>
                    <li>The Terms and Conditions automatically include all the Terms of Use of the company (Shree labs) pertaining to legal clauses and dispute settlements</li>
                </ol>

                <h5 class="newstyle">27. How does 60-minute home collection work</h5>
                    <p>We provide the fastest home sample collection within 60 minutes of order placement in Delhi, Faridabad, Ghaziabad, Gurgaon, Greater Noida, Noida, Bangalore, Chandigarh, Ludhiana, Jalandhar, Srinagar & Amritsar. Our skilled, vaccinated eMedics will arrive at your door at your chosen time, ensuring convenience and safety. Samples are meticulously handled, kept at optimal temperatures, and transported to our NABL accredited and ICMR approved lab. You can trust that your results will be delivered promptly and efficiently.</p>
                    <p>These 'Terms of Use' and 'Privacy Policy' of the Website/App constitute a binding agreement between You and the Company, and is accepted by You upon your use of the Website/App.</p>
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