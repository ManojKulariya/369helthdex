@extends('front.layout')
<?php
$cityName = session()->get('cityName');
if ($cityName == '') {
    $cityName = 'jaipur';
}
?>
@section('title')
Opportunities {{$cityName}}
@stop
@section('meta-data')

<link rel="canonical" href="{{ url()->current() }}">
<meta name="description"
    content="Book medical tests, blood testing services online in {{$cityName}} with free home sample collection. Book your appointment at Reliable Diagnostic Centre in {{$cityName}}.">
<meta name="keywords" content="Opportunities {{$cityName}}">

<meta name="robots" content="index, follow" />

<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:title"
    content="Book a Blood Test at home Online in {{$cityName}}, Best Diagnostic lab in {{$cityName}}" />
<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}" />
<meta property="og:image:width" content="250px" />
<meta property="og:image:height" content="250px" />
<meta property="og:site_name" content="{{__('message.site_name')}}" />
<meta property="og:description"
    content="Book medical tests, blood testing services online in {{$cityName}} with free home sample collection. Book your appointment at Reliable Diagnostic Centre in {{$cityName}}." />
<meta property="og:keyword"
    content="Book medical test in {{$cityName}}, blood test online in {{$cityName}}, free home collection in {{$cityName}}, Lipid profile test, thyroid test, kidney function test, liver function test, blood sugar test, hb1ac test, diabetes test" />
<link rel="shortcut icon" href="{{asset('public/img/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')

<section class="page-title-two">
    <div class="title-box centred bg-color-2">
        <div class="pattern-layer">
            <?php
            $sharp70 = asset('public/front/Docpro/assets/images/shape/shape-70.png');
            $sharp71 = asset('public/front/Docpro/assets/images/shape/shape-71.png');
            ?>
            <div class="pattern-1" style="background-image: url('{{$sharp70}}');"></div>
            <div class="pattern-2" style="background-image: url('{{$sharp71}}');"></div>
        </div>
        <div class="auto-container">
            <div class="title">
                <h1>Opportunities </h1>
            </div>
        </div>
    </div>
    <div class="lower-content">
        <div class="auto-container">
            <ul class="bread-crumb clearfix">
                <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                <li>Opportunities</li>
            </ul>
        </div>
    </div>
</section>
<section class="pricing-section bg-color-3 sec-pad">
    <div class="pattern-layer">
        <?php
        $path1 = asset('public/front/Docpro/assets/images/shape/shape-39.png');
        $path2 = asset('public/front/Docpro/assets/images/shape/shape-42.png');
        $arrow1 = asset('public/front/Docpro/assets/images/icons/arrow-1.png');
        $sharp45 = asset('public/front/Docpro/assets/images/shape/shape-45.png');
        $sharp46 = asset('public/front/Docpro/assets/images/shape/shape-46.png');
        $sharp75 = asset('public/front/Docpro/assets/images/shape/shape-75.png');
        $sharp76 = asset('public/front/Docpro/assets/images/shape/shape-76.png');
        $sharp77 = asset('public/front/Docpro/assets/images/shape/shape-77.png');
        ?>
        <div class="pattern-1" style="background-image: url('{{$path1}}');"></div>
        <div class="pattern-4" style="background-image: url('{{$path2}}');"></div>
    </div>
    <div class="auto-container">

        <div class="inner-content">
            <div class="row clearfix" id="data-container">
                <div class="col-lg-12 col-md-12 col-sm-12 " style="margin-bottom: 10px;">

                    <div class="testimonial-block-two">
                        <div class="inner-box">
                            <div class="text">
                                <p>Job details</p>
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-sm-4"><small><b>Job title</b><br>
                                        {{$data->title}}</small>
                                    </div>
                                    <div class="col-sm-4"><small><b>Number of openings</b><br>
                                        {{$data->openings}}</small>
                                    </div>
                                    <div class="col-sm-4"><small><b>location</b><br>
                                        {{$data->locations}}</small>
                                    </div>
                                    
                                </div>
                            </div>
                            <hr>
                            <div class="text">
                                <p>Job description</p>
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-sm-12"><small>
                                        {!! $data->description !!}</small>
                                    </div>
                                    <div class="col-sm-4"><small><b>Experience</b><br>
                                        {{$data->experince}}</small>
                                    </div>
                                    <div class="col-sm-4"><small><b>Qualification</b><br>
                                        {{$data->qualification}}</small>
                                    </div>
                                    <div class="col-sm-4"><small><b>Salary</b><br>
                                        {{$data->salary}}</small>
                                    </div>
                                    <div class="col-sm-4"><small><b>Skills</b><br>
                                        {{$data->skills}}</small>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text">
                                <p>Organization unit</p>
                            </div>
                            <div class="">
                                <div class="row">
                                    <div class="col-sm-4"><small><b>Department</b><br>
                                        {{$data->department}}</small>
                                    </div>
                                    <div class="col-sm-4"><small><b>Designation</b><br>
                                        {{$data->designations}}</small>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                    <div class="col-12">
                                        <button class="btn btn-sm" onclick="openForm()" style="color: #233646; border-color: #233646;">APPLY HERE</button>
               
                                    </div>
                                </div>
                        </div>
                        

                    </div>
                </div>
            </div>


        </div>
       
</div>
</section>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include other libraries or scripts if needed -->

<!-- Include your custom JavaScript file that contains the Ajax code -->
<script src="{{ asset('js/your-custom-script.js') }}"></script>
<!-- resources/views/apply/form.blade.php -->

<div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applyModalLabel"><small>Enter your phone number to apply. We will send you an OTP on the phone number you provide</small></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('apply-job-otp') }}" method="post">
                    @csrf
                    <label for="mobile_number"><small>Mobile Number:</small></label>
                    <input type="hidden"  name="v_id" class="form-control" value="{{$data->id}}" required>
                    <input type="text" id="mobile_number" maxlength="10" name="mobile" class="form-control" required>
                    <br>
                    <!-- Add other form fields as needed -->

                    <button type="submit" class=" theme-btn-one"  ><small>NEXT</small></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openForm() {
        $('#applyModal').modal('show');
    }

    // Optional: Close the modal if the user clicks outside of it
    $(document).on('click', function (e) {
        if ($(e.target).hasClass('modal')) {
            $('#applyModal').modal('hide');
        }
    });
</script>

@stop
@section('footer')
@stop