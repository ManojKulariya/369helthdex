@extends('front.layout')

@php

$cityName = session()->get('cityName');

 if($cityName == ''){
     $cityName='jaipur';
 }
 
@endphp

@section('title')

Book a Blood Test at home Online in {{$cityName}}, Best Diagnostic lab in {{$cityName}}

@stop

@section('meta-data')
<link rel="canonical" href="{{ url()->current() }}">
<meta name="description"

    content="Book medical tests, blood testing services online in {{$cityName}} with free home sample collection. Book your appointment at Reliable Diagnostic Centre in {{$cityName}}.">
<meta name="keywords"

    content="Book medical test in {{$cityName}}, blood test online in {{$cityName}}, free home collection in {{$cityName}}, Lipid profile test, thyroid test, kidney function test, liver function test, blood sugar test, hb1ac test, diabetes test">
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
  <!--<div class="title-box centred bg-color-2">
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
        <h1>Test List</h1>
      </div>
    </div>
  </div> -->
  <div class="lower-content">
    <div class="auto-container">
      <ul class="bread-crumb clearfix">
        <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
        <li>Test List</li>
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
<!---->
<div class="clinic-block-one">
  <div class="inner-box" style="padding: 34px 40px 37px 34px !important;">
    <div class="row">
      <div class="col-md-6">
        <div class="content-box">
          <ul class="name-box clearfix">
            <li class="name">
              <h2 id="package_name">Book a Blood Test at home Online in {{$cityName}}, Best
                
                Diagnostic lab in {{$cityName}}</h2>
            </li>
          </ul>
          <div class="text">
            <p>Book medical tests, blood testing services online in {{$cityName}} with free home
              
              sample collection. Book your appointment at Reliable Diagnostic Centre in
              
              {{$cityName}}.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="brand-carousel-lab owl-carousel m-0" style="border: 1px solid #233646;padding: 10px;"> @foreach($labs as $df)
          <div class="testimonial-block-two">
            <div class="text">
              <p><b> <?php echo substr($df->name, 0, 85) ?> <br>
                <?php echo substr($df->branch_code, 0, 85) ?> </b></p>
              <p style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;"><i

                                            class="fa fa-envelope"></i> : {{$df->email}}</p>
              <p style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;"><i

                                            class="fa fa-phone"></i> : {{$df->phone}}</p>
              <p style=""><i class="fas fa-map"></i> : {{$df->location['name']}}</p>
            </div>
          </div>
          @endforeach </div>
      </div>
    </div>
  </div>
  <!---->
  <div class="sec-title centred">
    <p></p>
    <h2>Popular Tests</h2>
  </div>
  <div class="inner-content">
    <div class="row clearfix appendtest">
         @foreach($popular_package as $pl)
      <?php $discount = 100 * ($pl->mrp - $pl->price) / $pl->mrp; ?>
      <div class="col-lg-4 col-md-6 col-sm-12 pricing-block">
        <div class="pricing-block-one">
          <div class="pricing-table">
            <div class="box_badges" style="font-size:11px;">{{$pl->no_of_parameter}}<br/>Parameters</div>
            
            
            <div class="table-header"> 
              <h2><a href="{{ route('profile', ['city'=>$cityName,'id' => $pl->slug ]) }}" style="text-decoration: none; color: inherit;">{{$pl->profile_name}} ({{$pl->test_short_code}})</a></h2>
           
            </div>
            <div class="table-content">
                <div class="row" style="font-size:12px;line-height:1.2;">
                    @php
                        $arr = explode(",", $pl->paramater_data); // Convert the data to an array
                        $arr = array_slice($arr, 0, 8); // Limit to the first 8 items
                        $chunks = array_chunk($arr, 4); // Split into chunks of 4
                    @endphp
            
                    @foreach ($chunks as $chunk)
                        <div class="col-6">
                                @foreach ($chunk as $item)
                                    &#10003; {{ $item }}
                                    <br>
                                @endforeach
                        </div>
                    @endforeach
                    
                </div>
                <a href="{{ route('profile', ['city'=>$cityName,'id' => $pl->slug ]) }}" class="more-link">+ Know More</a>

            
            </div>
            <?php $res_curr = explode("-", $setting->currency); ?>
            <div class="table-footer"> 
            		@if($pl->price > 0 )
            		
                	<h4><span class="price">{{$res_curr[1]}}{{number_format($pl->price,2,'.','')}}</span> / <span class="discount_price">{{$res_curr[1]}}{{number_format($pl->mrp,2,'.','')}}</span> </h4>
                    @else
                    <h4><span class="discount_price">{{$res_curr[1]}}{{number_format($pl->mrp,2,'.','')}}</span></h4>
                    @endif
                        <div class="btn-box">
                            <a href="{{ route('checkouts', ['id' => $pl->id, 'type' => 3, 'parameter' => $pl->no_of_parameter ?? '0']) }}" class="theme-btn-one">
                                {{ __('message.Book Now') }}<i class="icon-Arrow-Right"></i>
                            </a>
                            <!--<a href="{{ route('profile', ['city'=>$cityName,'id' => $pl->slug ]) }}" class="book_now">{{__('message.Book Now')}}<i class="icon-Arrow-Right"></i></a>-->
                        </div>
                    </div>
            <!-- <div class="table-footer">
              <div class="link"> <a  href="{{ route('profile', ['city'=>$cityName,'id' => $pl->slug ]) }}"><i

                                                class="icon-Arrow-Right"></i></a></div>
              <i class="icon-Arrow-Right"></i>               <div class="btn-box"> <a href=""

                                            class="book_now">{{__('message.Book Now')}}</a> </div>
            </div>-->

          </div>
        </div>
      </div>
      @endforeach </div>
  </div>
</div>
<!--<div class="auto-container">-->
<!--  <div class="sec-title centred">-->
<!--    <p></p>-->
<!--    <h2>Popular Parameter</h2>-->
<!--  </div>-->
<!--  <div class="inner-content">-->
<!--    <div class="row clearfix " id="appendpera"> </div>-->
<!--  </div>-->
<!--  <div class="btn-box row" style="margin-top: 30px; display: flex;justify-content: center;">-->
<!--    <button id="loadMoreButton" class="theme-btn-one">View More</button>-->
<!--  </div>-->
<!--</div>-->
</section>


@if(isset($contentdata) && !empty($contentdata))
 <section class="doctor-details bg-color-3" style="margin-top:-5%">
   <div class="auto-container" style="margin-bottom:-10%">
       
     <div class="row clearfix">
       <div class="col-lg-12 col-md-12 col-sm-12 content-side">
         <div class="clinic-details-content doctor-details-content">
           <div class="clinic-block-one">
               
             <div class="inner-box" style="padding: 34px 40px 37px 34px !important;">
               <div class="row">
                 <div class="col-md-12">
                    @foreach($contentdata as $cn)
                    @if($cn->page_name == "Popular-Test")
                    <div class="content-box">
                     <ul class="name-box clearfix">
                       <li class="name">
                         <h3>{{ $cn->name }}</h3>
                       </li>
                     </ul>
                     <div class="text">
                         @php
                            $description = COMMAN::replace($cn->description,$cityName) ;
                         @endphp
                       <p>{!! $description !!}</p>
                     </div>
                   </div>
                   @endif
                   @endforeach
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section><br>
@endif



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script>

    document.querySelectorAll('.more-link').forEach(function (link) {

        link.addEventListener('click', function () {
            var parameterList = this.parentElement.querySelector('.list');
            var hiddenItems = parameterList.querySelectorAll('li:not(:nth-child(-n+4))');
            for (var i = 0; i < hiddenItems.length; i++) {

                hiddenItems[i].style.display = 'block';

            }
            this.style.display = 'none';
            this.parentElement.querySelector('.less-link').style.display = 'inline';

        });

    });
    document.querySelectorAll('.less-link').forEach(function (link) {

        link.addEventListener('click', function () {

            var parameterList = this.parentElement.querySelector('.list');

            var hiddenItems = parameterList.querySelectorAll('li:not(:nth-child(-n+4))');

            for (var i = 0; i < hiddenItems.length; i++) {
                hiddenItems[i].style.display = 'none';
            }
            this.style.display = 'none';
            this.parentElement.querySelector('.more-link').style.display = 'inline';

        });

    });



    var cname = '{{ $cityName }}';

    var itemsPerPage = 25;

    var currentItems = 0;



    function loadData() {

        $.ajax({

            url: '/get-aj-pera',
            method: 'GET',

            success: function (data) {

                var dataLength = data.length;

                var html = '';

                for (var i = currentItems; i < Math.min(currentItems + itemsPerPage, dataLength); i++) {

                    var df = data[i];

                    var discount = 0;



                    if (df.mrp !== 0) {

                        discount = Math.round(100 * (df.mrp - df.price) / df.mrp);

                    }

                    var route = '{{ route('parameter', ['city' => 'CITY_PLACEHOLDER', 'id' => 'rg_slug']) }}';

                    route = route.replace('CITY_PLACEHOLDER', cname);

                    route = route.replace('rg_slug', df.slug);



                    html += '<div class="col-lg-4 col-md-6 col-sm-12 pricing-block">';

                    html += '<div class="pricing-block-one">';

                    html += '<div class="pricing-table" style="height:auto;">';

                    html += '<div class="pattern">';
                    if(df.discount['fixed'] > 0){
                    html += '<span class="discount">' + df.discount['per'] + ' %</span>';
                    }

                    html += '<div class="pattern-1" style="background-image: url(\'' + df.sharp75 + '\');"></div>';

                    html += '<div class="pattern-2" style="background-image: url(\'' + df.sharp76 + '\');"></div>';

                    html += '<div class="pattern-3" style="background-image: url(\'' + df.sharp77 + '\');"></div>';

                    html += '</div>';

                    html += '<div class="table-header" style="height: 150px;">';

                    html += '<h3>' + df.name + ' (' + df.test_short_code + ')</h3>';
                    if(df.discount['fixed'] > 0){
                    var dis = df.mrp - df.discount['fixed'];
                    html += '<h4><span style="text-decoration: line-through;">Rs. ' + df.mrp + '</span> / Rs. ' + dis + '</h4>';

                    }else{
                    html += '<h4><span>Rs. ' + df.mrp + '</span></h4>';   
                    }
                    html += '</div>';

                    html += '<div class="table-footer">';

                    html += '<div class="link"><a href="' + route + '"><i class="icon-Arrow-Right"></i></a></div>';

                    html += '<div class="btn-box"><a href="' + route + '" class="theme-btn-one">Know More<i class="icon-Arrow-Right"></i></a></div>';

                    html += '</div>';

                    html += '</div>';

                    html += '</div>';

                    html += '</div>';

                }

                $('#appendpera').append(html); // Append new data

                currentItems += itemsPerPage; // Update the number of items displayed

                // Check if there are more items to display

                if (currentItems < dataLength) {

                    $('#loadMoreButton').show(); // Show the "View More" button

                } else {

                    $('#loadMoreButton').hide(); // Hide the button if all items are displayed

                }

               

            },

        });

    }



    $(document).ready(function () {

        loadData();

        $('#loadMoreButton').click(function () {

            loadData(); // Load more data when the "View More" button is clicked

        });

    });



</script> 
@stop

@section('footer')

@stop