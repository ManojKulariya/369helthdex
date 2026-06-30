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
<style>
        #fileInput {
            display: none;
        }

        #imageContainer {
            position: relative;
            cursor: pointer;
            border: 2px dashed #3498db;
            padding: 20px;
            text-align: center;
        }

        #fileLabel {
            display: block;
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 8px;
            box-sizing: border-box;
            cursor: pointer;
        }
</style>
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
                            <form action="{{route('submit-application')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <input type="hidden" name="id" id="id" value="{{$data->id}}">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
                                        <input type="text" id="name" maxlength="70" name="name" class="form-control" placeholder='Enter Full Name' required="" value="{{isset($data->name)?$data->name:''}}">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="name">Date Of Birth<span class="reqfield">*</span></label>
                                        <input type="date" id="name" name="dob" class="form-control" placeholder='Enter Full Name' required="" value="{{isset($data->dob)?$data->dob:''}}">
                                    </div>
                                    
                                    <div class="form-group col-4">
                                        <label for="name">Adhar Number<span class="reqfield">*</span></label>
                                        <input type="text" id="name" maxlength="15" name="adhar_no" class="form-control" placeholder='Enter Adhar NUmber' required="" value="{{isset($data->adhar_no)?$data->adhar_no:''}}">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="name">Number<span class="reqfield">*</span></label>
                                        <input type="text" maxlength="10" id="name" name="number" class="form-control" placeholder='Enter NUmber' required="" value="{{isset($data->number)?$data->number:''}}">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="name">Current CTC<span class="reqfield">*</span></label>
                                        <input type="text" maxlength="10" id="name" name="current_ctc" class="form-control" placeholder='Enter Current CTC' required="" value="{{isset($data->current_ctc)?$data->current_ctc:''}}">
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="name">Expected CTC<span class="reqfield">*</span></label>
                                        <input type="text" maxlength="10" id="name" name="adhar_no" class="form-control" placeholder='Enter Expected CTC' required="" value="{{isset($data->expected_ctc)?$data->expected_ctc:''}}">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="name" >Address<span class="reqfield">*</span></label>
                                        <input type="text" maxlength="150" id="name" name="address" class="form-control" placeholder='Enter Address' required="" value="{{isset($data->address)?$data->address:''}}">
                                    </div>
                                    <div class="form-group col-12">
                                        <div id="imageContainer" onclick="triggerFileInput()" ondragover="allowDrop(event)" ondrop="handleDrop(event)">
                                            <label id="fileLabel">Click or Drag Resume file here</label>
                                            <input type="file" id="fileInput" name="resume" onchange="displayFileName()">
                                        </div>
                                    </div>
                                    
                     <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
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



<script>
    function triggerFileInput() {
        var fileInput = document.getElementById('fileInput');
        fileInput.click();
    }

    function allowDrop(event) {
        event.preventDefault();
    }

    function handleDrop(event) {
        event.preventDefault();
        var fileInput = document.getElementById('fileInput');
        fileInput.files = event.dataTransfer.files;
        displayFileName();
    }

    function displayFileName() {
        var fileInput = document.getElementById('fileInput');
        var fileLabel = document.getElementById('fileLabel');

        var file = fileInput.files[0];

        if (file) {
            fileLabel.innerHTML = "File selected: " + file.name;
        } else {
            fileLabel.innerHTML = "Click or Drag PDF file here";
        }
    }
</script>

@stop
@section('footer')
@stop