@extends('front.layout')
@section('title')
   Feedback/Complaints
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('user-login')}}"/>
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

<section class="page-title-two">
            <div class="title-box centred bg-color-2">
                <div class="pattern-layer">
                    <div class="pattern-1" style="background-image: url(assets/images/shape/shape-70.png);"></div>
                    <div class="pattern-2" style="background-image: url(assets/images/shape/shape-71.png);"></div>
                </div>
                <div class="auto-container">
                    <div class="title">
                        <h1> Feedback/Complaints</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__("message.Home")}}</a></li>
                        <li>Feedback/Complaints</li>
                    </ul>
                </div>
            </div>
        </section>
     
 
        <section class="doctors-dashboard bg-color-3">
   
   <div class="right-panel">
      <div class="content-container">
         <div class="outer-container">
            <div class="add-listing change-password">
               @if(Session::has('message'))
               <div class="col-sm-12">
                  <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>
                  </div>
               </div>
               @endif 
               <form action="{{route('save_feedback')}}" method="post" enctype="multipart/form-data" >
                  {{csrf_field()}}
                  <div class="single-box">
                     <div class="title-box">
                        <h3> Feedback/Complaints</h3>
                     </div>
                     <div class="inner-box">
                        <div class="row clearfix">
                          
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                              <label>{{__('message.Name')}}<span style="color:red;">*</span></label>
                              <input type="text" name="name" id="name" maxlength="70" required="" >
                           </div>
                          
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                              <label>{{__('message.email')}} ID<span style="color:red;">*</span></label>
                              <input type="email" name="email" id="email" >
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                              <label>Number<span style="color:red;">*</span></label>
                              <input type="text" name="number" id="email" required>
                           </div>
                          
                            <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                                
                              <label>Message<span style="color:red;">*</span> (500 words)</label>
                              <textarea  maxlength="500" name="message" id="email" required></textarea>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                                    <label>CAPTCHA <span style="color:red;">*</span></label><br>
                                    <img src="{{ url('/custom-captcha') }}" id="captcha-img" alt="CAPTCHA">
                                      <button type="button" onclick="reloadCaptcha()" style="border: none; background: none;color:#EB0401;"><i class="fa fa-repeat"></i></button>
                                  <input type="text" name="captcha_input" class="form-control mt-2" placeholder="Enter CAPTCHA" required>
                                </div>
                        </div>
                     </div>
                  </div>
                  <div class="btn-box">
                     <button type="submit" class="theme-btn-one">Send Feedback<i class="icon-Arrow-Right"></i>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>


@stop
@section('footer')
<script>
    function getlab(city) {
        var cityId = city;
        var optionsHTML = ' <select id="" name="lab_id" required="" >'; // Initialize optionsHTML to an empty string
        // Perform the AJAX request
        $.ajax({
            url: '/get-users-by-city/' + cityId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Populate the dropdown with the fetched data
                var select = $('.labid');
                select.empty(); // Clear existing options

                if (Array.isArray(data)) {
                    // Generate HTML for options based on the received data
                    $.each(data, function (index, user) {
                     optionsHTML += '  <option value="' + user.id + '">' + user.name + '</option>';
                    });
                     optionsHTML += ' </select>  ';
                    console.log(optionsHTML);
                    

                    select.html(optionsHTML);
                } else {
                    console.log('Error: Data is not an array.');
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
 $('#cityid').change(function () {
            var selectedCity = $(this).val();
            getlab(selectedCity);
        });

</script>

@stop


