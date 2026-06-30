@extends('front.layout')
@section('title')
Prescription
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
                <h1>Upload Prescription</h1>
            </div>
        </div>
    </div>
    <div class="lower-content">
        <div class="auto-container">
            <ul class="bread-crumb clearfix">
                <li><a href="{{route('home')}}">{{__("message.Home")}}</a></li>
                <li>Prescription</li>
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
                    <form action="{{route('save_prescription')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="single-box">
                            <div class="title-box">
                                <h3>Upload Prescription</h3>
                            </div>
                            <div class="inner-box">
                                <div class="row clearfix">

                                    <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                                        <label>Prescription (jpeg, jpg, png, pdf)</label>
                                        <input type="file" name="prescription" accept=".jpeg,.jpg,.png,.pdf"
                                            required="">
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                                        <label>{{__('message.Name')}}</label>
                                        <input type="text" name="name" id="name" required="">
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                                        <label>{{__('message.email')}}</label>
                                        <input type="email" name="email" id="email">
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                                        <label>Number</label>
                                        <input type="text" name="number" id="email" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <label>Location</label>
                                        <select id="cityid" name="location_id" size="3" required class="form-control">
                                            <option value="">Select Location</option>
                                            @foreach($city as $c)
                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <label>Gender</label>
                                        <select name="gender" required size="3" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                        <label>Date Of Birth</label>
                                        <input type="date" name="d_o_b" max="{{ date('Y-m-d') }}" required="">
                                    </div>
                                    <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                                        <input type="checkbox" value="1" name="is_agree" required="">
                                        <label>I agree to Terms of use and Privacy Policey </label>
                                    </div>
                                </div>
                                <div class="btn-box">
                            <button type="submit" class="theme-btn-one">{{__('message.Save')}}<i
                                    class="icon-Arrow-Right"></i>
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