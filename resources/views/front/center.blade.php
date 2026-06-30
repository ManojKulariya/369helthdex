@extends('front.layout')
<?php 
$cityName = session()->get('cityName');
 if($cityName == ''){
     $cityName='jaipur';
 }
?>
@section('title')
  Nearest Center {{$cityName}}
@stop
@section('meta-data')

<link rel="canonical" href="{{ url()->current() }}">
 <meta name="description" content="Book medical tests, blood testing services online in {{$cityName}} with free home sample collection. Book your appointment at Reliable Diagnostic Centre in {{$cityName}}.">
 <meta name="keywords" content="Nearest Center {{$cityName}}">
    
<meta name="robots" content="index, follow" />

<meta property="og:type" content="website"/>
<meta property="og:url" content="{{ url()->current() }}"/>
<meta property="og:title" content="Book a Blood Test at home Online in {{$cityName}}, Best Diagnostic lab in {{$cityName}}"/>
<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}"/>
<meta property="og:image:width" content="250px"/>
<meta property="og:image:height" content="250px"/>
<meta property="og:site_name" content="{{__('message.site_name')}}"/>
<meta property="og:description" content="Book medical tests, blood testing services online in {{$cityName}} with free home sample collection. Book your appointment at Reliable Diagnostic Centre in {{$cityName}}."/>
<meta property="og:keyword" content="Book medical test in {{$cityName}}, blood test online in {{$cityName}}, free home collection in {{$cityName}}, Lipid profile test, thyroid test, kidney function test, liver function test, blood sugar test, hb1ac test, diabetes test"/>
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
                        <h1>Nearest Center </h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                        <li>Nearest Center</li>
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
             
              
              </div>
              </div>
                <div class="btn-box row" style="margin-top: 30px; display: flex;justify-content: center;">
                
                <button id="load-more-button" class="theme-btn-one">View More</button>
                
                </div>
              
            </div>
         </section>
         <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include other libraries or scripts if needed -->

<!-- Include your custom JavaScript file that contains the Ajax code -->
<script src="{{ asset('js/your-custom-script.js') }}"></script>

        <script>
            var page = 1;
            var lastPage = {{ $data->lastPage() }}; // Get the last page number from Blade
           


function loadData() {
    if (page > lastPage) {
        $('#load-more-button').hide(); // Hide the button if all data is loaded
        return;
    }
   
          
    $.ajax({
          url: '/get-center?page=' + page,
  
        method: 'GET',
        success: function (data) {
            if (data.data.length > 0) {
                var container = $('#data-container');
                $.each(data.data, function (index, df) {
                    var html = `
                    <div class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 15px;">
                        <div class="testimonial-block-two">
                            <div class="inner-box">
                                <div class="text">
                                    <div class="location">
                                        <div class="loc_1">${df.name.slice(0, 85)}</div>
                                    </div>
                                    <p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color:black;">
                                        <i class="fa fa-map-marker" style="color:#eb0401;"></i>
                                        <small>: ${df.distance.toFixed(2)} KM</small>
                                        <hr style="border: 0; border-top: 0.1px dashed black; margin-top: 0;">
                                    </p>
                                    <div class="d-flex" style="min-height:90px; overflow: hidden;">
                                        <small><i class="fas fa-map" style="color:#eb0401;"></i>&nbsp;</small>
                                        <span style="color:black;">: ${df.address}</span>
                                    </div>
                                    <div class="col-12 px-4" style="background-color:white; align-items: center; text-align: center;"> 
                                        <a href="javascript:void(0)" onclick="getDirections(${df.location.lat}, ${df.location.lng})" 
                                           class="book_now" style="display: inline-block; text-align: center; padding: 5px 21px;">
                                            Get Direction
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    
                    container.append(html);
                });

                // $.each(data.data, function (index, df) {
                //     var html = ' <div class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 15px;"><div class="testimonial-block-two">' +
                //         '<div class="inner-box">' +
                //         '<div class="text" style="height: 180px;">' +
                //         '<p> <small><b>' + df.name.slice(0, 85) + ' <br>(' + df.branch_code.slice(0, 85) + ')</b> </small></p>' +
                //         '<p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><small class="designation"><i class="fa fa-phone"></i> : ' + df.phone + '</small></p>' +
                //         '<p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><small class="designation"><i class="fas fa-map"></i> : ' + df.location.name + '</small></p>' +
                //         '<p style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><small class="designation"><i class="fas fa-map-pin"></i> : ' + df.distance.toFixed(2) + ' KM</small></p>' +
                //         '<a style="text-decoration: none; color: black;" href="javascript:void(0);" onclick="getDirections(' + df.location.lat + ',' + df.location.lng + ')">' +
                //         '<i class="fas fa-street-view"></i>: Direction <i class="fas fa-location-arrow"></i></a>' +
   
                //         '</div>' +
                //         '</div>' +
                //         '</div></div>';
                //     container.append(html);
                // });
                page++;
                if (page > lastPage) {
        $('#load-more-button').hide(); // Hide the button if all data is loaded
        return;
    }
            }
        },
    });
}

//loadData();
 $(document).ready(function () {
         loadData();

      });
$(document).on('click', '#load-more-button', function () {
    loadData();
});

        </script>
@stop
@section('footer')
@stop