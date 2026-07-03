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
 
  <div class="lower-content" style="padding:0px;">
        <img class="img_gif" src="{{asset('public/front/Docpro/assets/images/banner/banner01.gif')}}" />
     
  </div>
  
</section>
<section class="pricing-section bg-color-3 sec-pad">

<div class="auto-container">
    <div class="inner-box" style="padding: 1px 1px 14px 1px !important;">
           <h3 style="color:#2aa48c !important;">Popular Tests</h3>
        </div>

<div class="clinic-block-one">

  <div class="inner-content">
    <div class="row clearfix appendtest">
        @foreach($popular_package as $pl)
            <?php 
                $discount=0;
                if($pl->price > 0 ){
                $discount = 100 * ($pl->price - $pl->mrp) / $pl->price; 
                }
            ?>
            
          <div class="col-lg-4 col-md-6 col-sm-12 pricing-block">
              @include('front.card_test')
            </div>
        @endforeach 
      </div>
  </div>
</div>
</section>

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