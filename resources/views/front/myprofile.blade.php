@extends('front.layout')
@section('title')
   {{__('message.My Profile')}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('user-profile')}}"/>
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
               <li><a href="{{route('dashboard')}}"><i class="fas fa-columns"></i>{{__('message.Dashboard')}}</a></li>
               
               <li><a href="{{route('my-family-member')}}"><i class="fas fa-clock"></i>{{__('message.My Family Members')}}</a></li>
               <li><a href="{{route('my-addresses')}}"><i class="fas fa-comments"></i>{{__('message.My Addresses')}}</li>
                <li><a href="{{route('my-home')}}"><i class="fas fa-comments"></i>Home Visit</li>
                <li><a href="{{route('my_prescription')}}"><i class="fas fa-comments"></i>My Prescription</li>
               <li><a href="{{route('user-profile')}}" class="current"><i class="fas fa-user"></i>{{__('message.My Profile')}}</a></li>
               <li><a href="{{route('user-change-password')}}"><i class="fas fa-unlock-alt"></i>{{__('message.Change Password')}}</a></li>
               <li><a href="{{route('user-logout')}}"><i class="fas fa-sign-out-alt"></i>{{__('message.Logout')}}</a></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="right-panel">
      <div class="content-container">
         <div class="outer-container">
            <div class="add-listing change-password">
               @if(Session::has('message'))
               <div class="col-sm-12">
                  <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>
                  </div>
               </div>
               @endif 
               <form action="{{route('update-profile-info')}}" method="post" enctype="multipart/form-data" >
                  {{csrf_field()}}
                  <div class="single-box">
                     <div class="title-box">
                        <h3>{{__('message.My Profile')}}</h3>
                     </div>
                     <div class="inner-box">
                        <div class="row clearfix">
                           <div class="form-group col-lg-6 col-md-12 col-sm-12 form-group">
                     <label for="name">{{__('message.Profile Picture')}}<span class="reqfield">*</span></label>
                     <div id="uploaded_image" >
                        <div class="upload-btn-wrapper">
                           <button class="btn imgcatlog">
                           <input type="hidden" name="real_basic_img" id="real_basic_img" value="<?= isset($data->image)?$data->image:""?>"/>
                           <?php 
                              if(Auth::user()->profile_pic!=""){
                                  $path=url('/')."/storage/app/public/profile"."/".Auth::user()->profile_pic;
                              }
                              else{
                                  $path=asset('public/img/default_user.png');
                              }
                              ?>
                           <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" >
                           </button>
                           <input type="hidden" name="basic_img" id="basic_img1"/>
                           @if(Auth::user()->profile_pic!="")
                           <input type="file" name="upload_image" id="upload_image" class="form-control" />
                           @else
                            <input type="file" class="form-control" required="" name="upload_image" id="upload_image" />
                           @endif
                        </div>
                     </div>
                  </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                              <label>{{__('message.Name')}}</label>
                              <input type="text" name="name" id="name" required="" value="{{Auth::user()->name}}">
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                              <label>{{__('message.email')}}</label>
                              <input type="email" name="email" id="email" value="{{Auth::user()->email}}" required="">
                           </div>
                           <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="btn-box">
                     <button type="submit" class="theme-btn-one">{{__('message.Save Change')}}<i class="icon-Arrow-Right"></i></button>
                     <a href="javascript::void(0)" onclick="resetpassword()" class="cancel-btn">{{__('message.Cancel')}}</a>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
@stop
@section('footer')
@stop