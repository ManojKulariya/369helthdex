@extends('front.layout')
@section('title')
My Prescription
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('my-addresses')}}"/>
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
<section class="doctors-dashboard bg-color-3">
   <div class="left-panel">
      <div class="profile-box patient-profile">
         <div class="upper-box">
            <?php 
                              if(Auth::user()->profile_pic!=""){
                                  $path=url('/')."/storage/app/public/profile"."/".Auth::user()->profile_pic;
                              }
                              else{
                                  $path=asset('public/img/default_user.png');
                              }
                              ?>
           
            <figure class="profile-image"><img src="{{$path}}" alt=""></figure>
            <div class="title-box centred">
               <div class="inner">
                  <h3>{{Auth::user()->name}}</h3>
                  <p><i class="fas fa-envelope"></i>{{Auth::user()->email}}</p>
               </div>
            </div>
         </div>
         <div class="profile-info">
            <ul class="list clearfix">
               <li><a href="{{route('dashboard')}}"><i class="fas fa-columns"></i>{{__("message.Dashboard")}}</a></li>
               
               <li><a href="{{route('my-family-member')}}"><i class="fas fa-clock"></i>{{__("message.My Family Members")}}</a></li>
               <li><a href="{{route('my-addresses')}}" class="current"><i class="fas fa-comments"></i>{{__("message.My Addresses")}}</li>
                <li><a href="{{route('my-home')}}"><i class="fas fa-comments"></i>Home Visit</li>
                            <li><a href="{{route('my_prescription')}}"><i class="fas fa-comments"></i>My Prescription</li>
               <li><a href="{{route('user-profile')}}"><i class="fas fa-user"></i>{{__("message.My Profile")}}</a></li>
               <li><a href="{{route('user-change-password')}}"><i class="fas fa-unlock-alt"></i>{{__("message.Change Password")}}</a></li>
               <li><a href="{{route('user-logout')}}"><i class="fas fa-sign-out-alt"></i>{{__("message.Logout")}}</a></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="right-panel">
                <div class="content-container">
                    <div class="outer-container">
                        <div class="favourite-doctors">
                            <div class="title-box row">
                                <h3 class="col-md-6">My Prescription</h3>
                                <div class="btn-box col-md-6 tdr"><a href="{{route('prescription')}}" class="theme-btn-one"><i class="icon-image" ></i> Prescription</a></div>
                            </div>
                            <div class="doctors-list">
                                <div class="row clearfix">
                                 @if(count($myaddresses)>0)
                                    @foreach($myaddresses as $ma)
                                       <div class="col-12 doctors-block">
                                           <div class="team-block-three">
                                               <div class="inner-box">
                                                   <div class="lower-content">
                                                       <ul class="name-box clearfix">
                                                           <li class="name"><h3><a href="doctors-details.html">{{$ma->name}}, </a></h3></li>
                                                            <li class="name"><h3><a href="doctors-details.html">{{$ma->number}}, </a></h3></li>
                                                             <li class="name"><h3><a href="doctors-details.html">{{$ma->email}}</a></h3></li>
                                                       </ul>
                                                   
                                                       <span class="designation"><i class="fas fa-map-marker-alt"></i>  Location : {{$ma->location->name}}</span>
                                                    
                                                       <!--<div class="btn-box row">  <button type="submit" style="position: relative;display: inline-block;float: left;font-size: 15px;Line-height: 26px;font-weight: 600;border: 2px solid #ebeef1;border-radius: 30px;   -->
                                                       <!--     padding: 7px 27px;text-align: center;background: #f01634;color: white;" onclick="deletevisit('{{$ma->id}}')">Delete <i class="fa fa-trash"></i></button>-->
                                                       <!-- </div>-->

                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                    @endforeach
                                 @endif 
                                </div>
                            </div>
                         
                        </div>
                    </div>
                </div>
            </div>
</section>


@stop
@section('footer')
@stop