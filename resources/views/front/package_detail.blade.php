@extends('front.layout')

<?php $res_curr = explode("-", $setting->currency);

$sharp70 = asset('public/front/Docpro/assets/images/shape/shape-70.png');

$sharp71 = asset('public/front/Docpro/assets/images/shape/shape-71.png');

$cityName = ucfirst(session()->get('cityName'));

if ($cityName == '') {

   $cityName = 'Jaipur';

}

$profile = array();

if (isset($data->testdetails)) {

   foreach ($data->testdetails as $td) {

      if ($td->type == 2) {

         foreach ($profiles_list as $pl) {

            if ($td->type_id == $pl->id) {

               $profile[] = $pl->profile_name;

            }

         }

      }

   }

}

$profile_name = implode(',', $profile);

$cate = array();

foreach ($category as $pl) {

   $cate[] = $pl->name;

}

$cate_name = implode(',', $cate);

$description = COMMAN::replace($data->description, $cityName);

?>

@section('title')

   Book {{isset($data->name)?$data->name:''}} | {{isset($data->parameter)?$data->parameter:''}} Parameters{{$res_curr[1]}}{{number_format($data->mrp,2,'.','')}} in {{$cityName}}

@stop

@section('content')

@section('meta-data')

<link rel="canonical" href="{{ url()->current() }}">

<meta name="description" content="Book {{isset($data->name)?$data->name:''}} Online in {{$cityName}} with Reliable Diagnostic. It Covers Health Test like {{$cate_name}} and {{$profile_name}}">

<meta name="keywords" content="{{isset($data->name)?$data->name:''}} name in {{$cityName}}, with {{$profile_name}} in {{$cityName}}, complete body checkup in {{$cityName}}, Free Sample Home Collection in {{$cityName}}">

<meta name="robots" content="index, follow" />

<meta property="og:type" content="website"/>

<meta property="og:url" content="{{ url()->current() }}"/>

<meta property="og:title" content="Book {{isset($data->name)?$data->name:''}} | {{isset($data->parameter)?$data->parameter:''}} Parameters{{$res_curr[1]}}{{number_format($data->mrp,2,'.','')}} in {{$cityName}}"/>

<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}"/>

<meta property="og:image:width" content="250px"/>

<meta property="og:image:height" content="250px"/>

<meta property="og:site_name" content="{{__('message.site_name')}}"/>

<meta property="og:description" content="Book {{isset($data->name)?$data->name:''}} Online in {{$cityName}} with Reliable Diagnostic. It Covers Health Test like {{$cate_name}} and {{$profile_name}}">

<meta property="og:keyword" content="{{isset($data->name)?$data->name:''}} name in {{$cityName}}, with {{$profile_name}} in {{$cityName}}, complete body checkup in {{$cityName}}, Free Sample Home Collection in {{$cityName}}"/>

<link rel="shortcut icon" href="{{asset('public/img/').'/'.$setting->favicon}}">

<meta name="viewport" content="width=device-width, initial-scale=1">

@stop

<section class="page-title-two">

   <div class="lower-content">

      <div class="auto-container">

         <ul class="bread-crumb clearfix">

            <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>

            <li>{{isset($data->name)?$data->name:''}} {{__('message.Package Detail')}}</li>

         </ul>

      </div>

   </div>

</section>

<section class="doctor-details bg-color-3" style="padding-top: 18px !important;">

   <div class="auto-container" >

      <div class="row clearfix">

         <div class="col-lg-12 col-md-12 col-sm-12 content-side">

            <div class="clinic-details-content doctor-details-content">
                <div class="clinic-block-one">
                   <div  class="inner-box2">
                   <div class="content-box">
                             <div class="col-12 row px-4 py-4">
                                 <div class="col-12 col-md-8 col-lg-8">
                                    <ul class="name-box clearfix col-12 mx-0 px-0">
                                       <li class="name">
                                          <h3 id="package_name" class="white">{{isset($data->name)?$data->name:''}} In {{ ucfirst($cityName)}}</h3>
                                       </li>
                                       <li><i class="icon-Trust-1"></i></li>
                                       <li><i class="icon-Trust-2"></i></li>
                                    </ul>
                                    <p class="col-12 mx-0 px-0 white">{{__('message.Parameter Included')}}: {{isset($data->parameter)?$data->parameter:''}}</p>
                                  
                                    <div class="col-12 row">
                                      <div class="rating-box clearfix px-4 py-1 mb-2" style="background-color:white;border-radius:5px;">
                                         <ul class="rating clearfix ">
                                            <?php 
                                            $a = explode(".",$data->avg_review);
                                            
                                               if(isset($a[0])){
                                                   for($i=0;$i<$a[0];$i++){
                                                        echo '<li><i class="icon-Star"></i></li>';
                                                   }
                                                   if(isset($a[1])){
                                                      for($j=$i;$j<5;$j++){
                                                           echo '<li><i class="icon-Star"></i></li>';
                                                      }
                                                   }
                                               }else{
                                                  for($i=0;$i<5;$i++){
                                                        echo '<li><i class="icon-Star light"></i></li>';
                                                  }
                                               }
                                            ?>
                                            <!--<li><a href="#">({{$data->total_review}} {{__("message.Reviews")}})</a></li>-->
                                            <li>{{$data->avg_review}}/5</li>
                                         </ul>
                                        </div>
                                    </div>
                                 </div>
                                 

                                <div class="col-12 col-md-4 col-lg-4 mt-1 row text-right-custom" >
                                   @if($data->price > 0)
                                       <div class="pl-2 stretched-text" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: 18px;">
                                            <h6 class="white " style="font-weight: bold;">Offer Price</h6>
                                            <h4 style="font-weight: bold; color: #eb0401 !important;">₹ {{$data->mrp}}/-</h4>
                                            <h6 class="white" style="text-decoration: line-through;font-weight: bold;">₹ {{$data->price}}/-</h6>
                                        </div>
                                        <div style="margin-top: 16px;"> 
                                            <a href="{{ route('checkouts', ['id' => $data->id, 'type' => 1, 'parameter' => $data->parameter ?? '0']) }}" 
                                               class="book_now ml-5 stretched-text" 
                                               style="display: inline-block; text-align: center;padding: 2px 15px;">
                                                {{ __('message.Book Now') }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="pl-2" style="display: flex; flex-direction: column; align-items: center; text-align: center; ">
                                            <h6 class="white" style="font-weight: bold;">Price</h6>
                                            <h4 style="font-weight: bold; color: #eb0401 !important;">₹ {{$data->mrp}}/-</h4>
                                        </div>
                                        <div style="margin-top: 8px;"> 
                                            <a href="{{ route('checkouts', ['id' => $data->id, 'type' => 1, 'parameter' => $data->parameter ?? '0']) }}" 
                                               class="book_now ml-4" 
                                               style="display: inline-block; text-align: center;padding: 5px 15px;">
                                                {{ __('message.Book Now') }}
                                            </a>
                                        </div>
                                       <!--<h6 class="mb-2 white">{{__('message.Healthians Price')}} :  <span>{{$res_curr[1]}}{{number_format($data->mrp,2,'.','')}} </span> </h6>-->
                                    
                                    @endif
                                </div>
                                 </div>
                             <div class="col-12 pt-2" style="background-color:white !important;">
                                 <div class="content-collapse">
                                     <div class="descriptiontxt">
                                      <?= html_entity_decode($description);?>
                                    </div>
                                 </div>
                                 <button class="read-more-btn">Read More</button>
                             </div>
                             <div class="col-12 mx-0 px-0 row" style="background-color:white !important;">
                                <div class="col-md-3 col-lg-3  col-6 row p-4 mx-0" >
                                    <figure class="icon-box-i"><i class="fa fa-flask"></i></figure>
                                    <h6 class="pl-2 usplevel"><b>{{isset($data->parameter)?$data->parameter:''}}</b> Parameter <br>Included</h6>
                                </div>
                                <div class="col-md-3 col-6 row p-4 mx-0" >
                                    <figure class="icon-box-i"><i class="fa fa-car"></i></figure>
                                        @if(isset($data->sample_collection)&&$data->sample_collection=='1')
                                            <h6 class="pl-2 usplevel"><b>{{__('message.Free')}}</b> Sample <br>Collection</h6>
                                        @endif
                                </div>
                                <div class="col-md-3 col-6 row p-4 mx-0">
                                    <figure class="icon-box-i"><i class="fa fa-stethoscope"></i></figure>
                                    <h6 class="pl-2 usplevel"><b>{{__('message.Free')}}</b> Doctor <br>Consultation</h6>
                                </div>
                                <div class="col-md-3 col-6 row p-4 mx-0">
                                    <figure class="icon-box-i"><i class="fa fa-thumbs-up"></i></figure>
                                    <h6 class="pl-2 usplevel">{{__('message.Test booked')}}<br><b>100+</b></h6>
                                </div>
                             </div>
                            
                                
                             <div class="custom-row py-4">
                                    <div class="custom-col">
                                        <p>{{ __('message.Report Time') }}:<br><strong>{{ isset($data->report_time) ? $data->report_time : '' }}</strong></p>
                                    </div>
                                    <div class="custom-col">
                                        <p>{{ __('message.Fasting Time') }}:<br><strong>
                                            @if(isset($data->fasting_time) && $data->fasting_time == '0')
                                                {{ __('message.Free') }}
                                            @elseif(isset($data->fasting_time) && $data->fasting_time == '1')
                                                {{ isset($data->fast_time) ? $data->fast_time : 'No' }}
                                            @endif</strong>
                                        </p>
                                    </div>
                                    <div class="custom-col">
                                        <p>Recommended Test:<br><strong>{{ isset($data->test_recommended_for) ? $data->test_recommended_for : '' }}</strong></p>
                                    </div>
                                    <div class="custom-col">
                                        <p>{{ __('message.Recommended age') }}:<br><strong>{{ isset($data->test_recommended_for_age) ? $data->test_recommended_for_age : '' }}</strong></p>
                                    </div>
                                </div>
                             <div class="col-12 px-4 py-4" style="background-color:white;align-items: center;text-align: center; "> 
                                <div>
                                    <a href="{{ route('checkouts', ['id' => $data->id, 'type' => 1, 'parameter' => $data->parameter ?? '0']) }}" 
                                       class="book_now" 
                                       style="display: inline-block; text-align: center;padding: 5px 21px;">
                                        {{ __('message.Book Now') }}
                                    </a>
                                    <a href="javascript:void(0)"  id="request-button" 
                                       class="book_now ml-2" 
                                       style="display: inline-block; text-align: center;padding: 5px 21px;">
                                        Get a free call
                                    </a>
                                </div>
                             </div>
                      </div>
                   </div>
                  </div>


               <div class="tabs-box mb-4">

                  <div class="tabs-content">

                     <div class="tab active-tab" id="tab-2">

                        <div class="experience-box">
                              <h5 class="mb-2">{{__('message.Test Details')}} <b>{{isset($data->parameter)?$data->parameter:''}}</b> Parameter Included</h5>
                           <div class="text">

                              <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                                 @if(isset($data->testdetails))

                                    @foreach($data->testdetails as $td)

                                       @if($td->type==1)

                                        @foreach($parameter_list as $pl)

                                                           @if($td->type_id==$pl->id)

                                         <div class="panel panel-default">

                                             <div class="panel-heading" role="tab" id="headingOne">

                                                <h4 class="panel-title">

                                                   <a role="button"  data-parent="#accordion" href="javascript:gotoparam('{{$pl->slug}}')"  aria-expanded="true" aria-controls="collapseOne">

                                                      <i class="more-less glyphicon glyphicon-plus"></i>
                                                      <div class="row">
                                                            <div class="col-md-4"> {{$pl->name}}</div>
                                                            <div class="col-md-8" style="text-align: right;">
                                                              
                                                            </div>
                                                      </div>

                                                   </a>

                                                </h4>

                                             </div>

                                          </div>

                                           @endif

                                                         @endforeach

                                       @endif

                                      @if($td->type==2)

    <div class="panel panel-default">

        <div class="panel-heading" role="tab" id="headingOne">

            <h4 class="panel-title">

                <a >

                    <div class="row">

                        @foreach($profiles_list as $pl)

                            @if($td->type_id==$pl->id)

                                <div class="col-md-4 profile-name" onclick="gotoprofile('{{$pl->slug}}');" style="cursor: pointer;" >

                                    {{$pl->profile_name}}

                                </div>

                                <?php $arr = explode(",", $pl->no_of_parameter); ?>

                                <div class="col-md-4">

                                    <span>{{count($arr)}}</span>

                                </div>

                                <div class="col-md-4" style="text-align: right;">

                                    <!--<button type="button" onclick="gotoprofile('{{$pl->slug}}');" class="view_btn">View</button>-->
                                    <span role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$td->type_id}}" aria-expanded="true" aria-controls="collapse{{$td->type_id}}" style="cursor: pointer;">
                                        <i class="fa fa-angle-down" style="font-size: 25px;"></i>
                                    </span>
                                </div>

                            @endif

                        @endforeach

                    </div>

                </a>

            </h4>

        </div>

        <div id="collapse{{$td->type_id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$td->type_id}}">

            <div class="panel-body">

                <ul>

                    @foreach($profiles_list as $pl)

                        @if($td->type_id==$pl->id)

                            <?php $arr = explode(",", $pl->no_of_parameter); ?>

                            @foreach($parameter_list as $a)

                                @if(in_array($a->id,$arr))

                                    <li class="row" style="width: 100%;border: 1px solid #1e4169;padding: 8px;margin-bottom: 5px;">

                                        <div class="col-md-6">

                                            <a href="#" style="color: black;">{{$a->name}}</a>

                                        </div>

                                        <div class="col-md-6" style="text-align: right;">

                                        </div>

                                    </li>

                                @endif

                            @endforeach

                        @endif

                    @endforeach

                </ul>

            </div>

        </div>

    </div>

@endif



                                       

                                    @endforeach

                                 @endif

                              </div>

                           </div>

                        </div>

                     </div>



                  </div>

               </div>
               @include('front.how_book')
               @if(count($data->package_frq)>0)
               <div class="tabs-box mb-4 mt-4">


                  <div class="tabs-content">


                     <div class="tab active-tab" id="tab-3">

                        <div class="location-box">
                             <h6>{{__('message.FRQ')}}</h6>
                           <div class="content_block_5">

                              <div class="content-box">

                                 <ul class="accordion-box">

                                    @if(count($data->package_frq)>0)

                                    @foreach($data->package_frq as $dp)

                                    <li class="accordion block">

                                       <div class="acc-btn">

                                          <div class="icon-outer"></div>

                                          <h4>{{$dp->question}}</h4>

                                       </div>

                                       <div class="acc-content">

                                          <div class="text">

                                             <p>{{$dp->ans}}</p>

                                          </div>

                                       </div>

                                    </li>

                                    @endforeach

                                    @endif

                                 </ul>

                              </div>

                           </div>

                        </div>

                     </div>


                  </div>

               </div>
               
            @endif
            </div>

         </div>

      </div>

   </div>

</section>


@stop

@section('footer')

<script type="text/javascript">

    document.querySelector('.show-btn').addEventListener('click', function() {

     document.querySelector('.sm-menu').classList.toggle('active');

   });



    function gotoparam(val){

         cityname = "<?php echo $cityName; ?>";

      window.location.href="{{url('parameter')}}/"+cityname+"/"+val;

    }



    function gotoprofile(val){

    //    console.log(val);

     cityname = "<?php echo $cityName; ?>";

      window.location.href="{{url('profile')}}/"+cityname+"/"+val;

    }



</script>



@stop