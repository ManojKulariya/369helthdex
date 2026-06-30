@extends('front.layout')
@section('title')
Home Visit
@stop
@section('meta-data')
<meta property="og:type" content="website" />
<meta property="og:url" content="{{route('user-login')}}" />
<meta property="og:title" content="{{__('message.site_name')}}" />
<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}" />
<meta property="og:image:width" content="250px" />
<meta property="og:image:height" content="250px" />
<meta property="og:site_name" content="{{__('message.site_name')}}" />
<meta property="og:description" content="{{__('message.meta_description')}}" />
<meta property="og:keyword" content="{{__('message.meta_keyword')}}" />
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
                <h1>Home Visit</h1>
            </div>
        </div>
    </div>
    <div class="lower-content">
        <div class="auto-container">
            <ul class="bread-crumb clearfix">
                <li><a href="{{route('home')}}">{{__("message.Home")}}</a></li>
                <li>Home Visit</li>
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
                        <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show"
                            role="alert">{{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                    @endif
                    <form action="{{route('save-home-visit')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="single-box">
                            <div class="title-box">
                                <h3>Home Visit</h3>
                            </div>
                            <div class="inner-box">
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group" id="addressorder">
                                        <label>{{__('message.Address')}}<span class="reqfield">*</span></label>
                                        <input type="text" id="us2-address" name="address" placeholder='Search Location'
                                            required data-parsley-required="true" required="" />
                                    </div>
                                    <div class="map col-lg-12 col-md-6 col-sm-12 form-group" id="maporder">
                                        <div class="form-group">
                                            <div class="col-md-12 p-0">
                                                <div id="us2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                            $inputLatitude =  session('latitude');
                            $inputLongitude = session('longitude');
                            if($inputLatitude == ''){
                            $inputLatitude =  env('MAP_LAT');
                            $inputLongitude=  env('MAP_LONG');
                            }
                            ?>
                                    <input type="hidden" name="lat" id="us2-lat" value="{{$inputLatitude}}" />
                                    <input type="hidden" name="long" id="us2-lon" value="{{$inputLongitude}}" />
                                    <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                                        <label>{{__('message.Name')}}</label>
                                        <input type="text" name="user_name" id="name"
                                            placeholder="{{__('message.Enter Name')}}" required="">
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                                        <label>Email</label>
                                        <input type="text" name="user_email" id="name" placeholder="Enter Email"
                                            required="">
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                                        <label>Number</label>
                                        <input type="text" name="user_number" id="name" placeholder="Enter Number"
                                            required="">
                                    </div>

                                    <div class="col-12 form-group">
                                        <label>City</label>
                                        <select id="cityid" name="city" required="" size="3" class="form-control">
                                            <option value="">{{__('message.Select City')}}</option>
                                            @foreach($city as $c)
                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!--<div class="col-12 form-group"><label>Labs</label>-->
                                    <!--    <div class=" labid">-->

                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <label>{{__('message.State')}}</label>
                                        <input type="text" name="state" id="state"
                                            placeholder="{{__('message.Enter State')}}" required="">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <label>{{__('message.Pincode')}}</label>
                                        <input type="text" name="pincode" id="pincode"
                                            placeholder="{{__('message.Enter Pincode')}}" required="">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn-one">Save<i
                                                class="icon-Arrow-Right"></i></button>
                                    </div>
                                </div>
                            </div>
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

        var optionsHTML = '<select size="3" class="form-control" name="lab_id" required="" >'; // Initialize optionsHTML to an empty string
        // Perform the AJAX request
        $.ajax({
            url: '/get-users-by-city-home/' + cityId,
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

                    select.html(optionsHTML);
                } else {

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