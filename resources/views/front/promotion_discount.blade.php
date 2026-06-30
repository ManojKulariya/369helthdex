@extends('front.layout')
<?php 
$cityName = session()->get('cityName');
 if($cityName == ''){
     $cityName='jaipur';
 }
?>
@section('title')
  Offers & Discount {{$cityName}}
@stop
@section('meta-data')

<link rel="canonical" href="{{ url()->current() }}">
 <meta name="description" content="Offers & Discount">
 <meta name="keywords" content="Offers & Discount">
    
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
<style>
    .coupon-code {
            font-weight: bold;
        }
    .coupon-value {
           
            color: #4CAF50;
            margin: 3% 0;
        }

        .coupon-type {
            color: #888;
            padding: 2%;
            overflow:hidden;
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
                        <h1>Offers & Discount</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
                        <li>Offers & Discount</li>
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
                    <div class="row clearfix">
                        @foreach($offer as $c)
                       
                           <div class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 15px;">
                               
                             
                                    <img src="{{asset('storage/app/public/category').'/'.$c->image}}" width="100%" alt="">
                                    
                              
                           </div>
                       
                        @endforeach
                       @foreach($cp as $row)
                            <div class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 15px;">
                                <div class="testimonial-block-two">
                                   
                                        <div class="category-block-one animated animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                                            <div class="inner-box">
                                                <div class="pattern">
                                                    <div class="pattern-1" style="background-image: url('{{$sharp45}}');"></div>
                                                    <div class="pattern-2" style="background-image: url('{{$sharp46}}');"></div>
                                                </div>
                                                <h3>{{ $row->coupon_code }}</h3>
                                                <span class="coupon-value">{{ $row->coupon_value }} @if($row->coupon_type == 'percent') % @else Rs @endif off On
                                    
                                                @if($row->type == 4) {{ 'All' }}
                                                @elseif($row->type == 1) {{ 'Package' }}
                                                @elseif($row->type == 3) {{ 'Profile' }}
                                                @elseif($row->type == 2) {{ 'Parameter' }}
                                                @endif
                                                
                                                </span>
                        
                                                <p>{{$row->day}}</p>
                                            </div>
                                        </div>
                                   
                                </div>
                            </div>
                        @endforeach

                        </div>
                    </div>
            </div>
           </section>
         <script>
    document.querySelectorAll('.more-link').forEach(function(link) {
        link.addEventListener('click', function() {
            var parameterList = this.parentElement.querySelector('.list');
            var hiddenItems = parameterList.querySelectorAll('li:not(:nth-child(-n+4))');
            
            for (var i = 0; i < hiddenItems.length; i++) {
                hiddenItems[i].style.display = 'block';
            }
            
            this.style.display = 'none';
            this.parentElement.querySelector('.less-link').style.display = 'inline';
        });
    });

    document.querySelectorAll('.less-link').forEach(function(link) {
        link.addEventListener('click', function() {
            var parameterList = this.parentElement.querySelector('.list');
            var hiddenItems = parameterList.querySelectorAll('li:not(:nth-child(-n+4))');
            
            for (var i = 0; i < hiddenItems.length; i++) {
                hiddenItems[i].style.display = 'none';
            }
            
            this.style.display = 'none';
            this.parentElement.querySelector('.more-link').style.display = 'inline';
        });
    });
</script>

@stop
@section('footer')
@stop