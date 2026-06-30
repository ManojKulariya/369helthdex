@extends('front.layout')
@section('title')
  {{__("message.My Addresses")}}
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
                                <h3 class="col-md-6">{{__("message.My Addresses")}}</h3>
                                <div class="btn-box col-md-6 tdr"><a href="javascript::void(0)" class="theme-btn-one" data-toggle="modal" data-target="#addaddress"><i class="icon-image" ></i>{{__("message.Add Address")}}</a></div>
                            </div>
                            <div class="doctors-list">
                                <div class="row clearfix">
                                 @if(count($myaddresses)>0)
                                    @foreach($myaddresses as $ma)
                                       <div class="col-xl-6 col-lg-6 col-md-12 doctors-block">
                                           <div class="team-block-three">
                                               <div class="inner-box">
                                                   <div class="lower-content">
                                                       <ul class="name-box clearfix">
                                                           <li class="name"><h3><a href="doctors-details.html">{{$ma->name}}</a></h3></li>
                                                           @if($ma->is_default=='1')
                                                           <li><span style="font-size: small;">{{__("message.Default")}} </span></li>
                                                           @endif
                                                       </ul>
                                                       <span class="designation"><i class="fas fa-map-marker-alt"></i> {{$ma->house_no}} , {{$ma->address}} , {{$ma->city}} , {{$ma->state}} , {{$ma->pincode}}</span>
                                                       

                                                       <div class="btn-box row">
                     <button type="button" style="position: relative;display: inline-block;float: left;
    font-size: 15px;Line-height: 26px;font-weight: 600;border: 2px solid #ebeef1;border-radius: 30px;   
    padding: 7px 27px;text-align: center;background: #453f85;color: white;" data-toggle="modal" data-target="#editaddress" onclick="editaddress('{{$ma->id}}')">{{__("message.Edit")}} <i class="fa fa-edit"></i></button>
                      <button type="submit" style="position: relative;display: inline-block;float: left;
    font-size: 15px;Line-height: 26px;font-weight: 600;border: 2px solid #ebeef1;border-radius: 30px;   
    padding: 7px 27px;text-align: center;background: #f01634;color: white;" onclick="deleteaddress('{{$ma->id}}')">Delete <i class="fa fa-trash"></i></button>
                  </div>
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
<div class="modal" id="addaddress">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__("message.Add New Address")}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <form action="{{route('post-user-address')}}" method="post" id="user_address" class="registration-form">
               {{csrf_field()}}
               <div class="row clearfix">
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group"  id="addressorder">
                     <label>{{__("message.Address")}}<span class="reqfield">*</span></label>
                     <input  type="text" id="us2-address" name="address" placeholder='{{__("message.Search Location")}}' required data-parsley-required="true" required=""/>
                  </div>
                  <div class="map col-lg-12 col-md-6 col-sm-12 form-group" id="maporder">
                     <div class="form-group">
                        <div class="col-md-12 p-0">
                           <div id="us2"></div>
                        </div>
                     </div>
                  </div>
                   <?php
                    $inputLatitude =  session('latitude');
                    $inputLongitude = session('longitude');
                        if($inputLatitude == ''){
                            $inputLatitude =  env('MAP_LAT');
                            $inputLongitude=  env('MAP_LONG');
                        }
                    ?>
                  <input type="hidden" name="lat" id="us2-lat" value="{{$inputLatitude}}" />
                  <input type="hidden" name="long" id="us2-lon" value="{{$inputLongitude}}" />
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>Save As</label>
                     <select name="name">
                         <option>Home</option>
                         <option>Work</option>
                         <option>Other</option>
                     </select>
                     <!--<input type="text" name="name"  placeholder="{{__('message.Enter Name')}}" required="">-->
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>House No./ Flat No.</label>
                     <input type="text" name="house_no" placeholder="Enter House No./ Flat No." required="">
                  </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>Apartment/Building Name/Colony</label>
                     <input type="text" name="apartment" placeholder="Enter Apartment/Building Name/Colony" required="">
                  </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>Landmark</label>
                     <input type="text" name="landmark" placeholder="Enter Landmark" required="">
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                     <label>{{__("message.City")}}</label>
                      <select  name="city" required="" >
                              <option value="">{{__("message.Select City")}}</option>
                              @foreach($city as $c)
                                   <option value="{{$c->id}}">{{$c->name}}</option>
                              @endforeach
                        </select>  
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.State")}}</label>
                     <input type="text" name="state" placeholder="{{__('message.Enter State')}}" required="">
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Pincode")}}</label>
                     <input type="text" name="pincode"  placeholder="{{__('message.Enter Pincode')}}"  required="">
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12 form-group" style="margin-top: 35px;">
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="is_default" id="is_default" value="1" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__("message.Make Default Address")}}</span>
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
         <button type="submit" id="address_submit_button" class="btn btn-success">{{__("message.Add Address")}}</button>
         <button type="button" class="btn btn-danger" data-dismiss="modal" >{{__("message.Close")}}</button>
         </div>
         </form>
      </div>
   </div>
</div>
<div class="modal" id="editaddress">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__("message.Edit Address")}} s</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <form action="{{route('post-user-address')}}" method="post" id="user_address" class="registration-form">
               {{csrf_field()}}
               <input type="hidden" name="id" id="edit_id">
               <div class="row clearfix">
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group"  id="addressorder">
                     <label>{{__("message.Address")}}<span class="reqfield">*</span></label>
                     <input  type="text" id="us2-address_edit" name="address" placeholder='{{__("message.Search Location")}}' required data-parsley-required="true" required=""/>
                  </div>
                  <div class="map col-lg-12 col-md-6 col-sm-12 form-group" id="maporder">
                     <div class="form-group">
                        <div class="col-md-12 p-0">
                           <div id="us2_edit"></div>
                        </div>
                     </div>
                  </div>
                  
                  <input type="hidden" name="lat" id="us2-lat-edit" value="{{$inputLatitude}}" />
                  <input type="hidden" name="long" id="us2-lon-edit" value="{{$inputLongitude}}" />
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>Save As</label>
                     <select name="name" id="name">
                         <option>Home</option>
                         <option>Work</option>
                         <option>Other</option>
                     </select>
                     <!--<input type="text" name="name" id="name" placeholder="{{__('message.Enter Name')}}" required="">-->
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>House No./ Flat No.</label>
                     <input type="text" name="house_no" id="house_no" placeholder="Enter House No./ Flat No." required="">
                  </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>Apartment/Building Name/Colony</label>
                     <input type="text" name="apartment" id="apartment" placeholder="Enter Apartment/Building Name/Colony" required="">
                  </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>Landmark</label>
                     <input type="text" name="landmark" id="landmark" placeholder="Enter Landmark" required="">
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                     <label>{{__("message.City")}}</label>
                      <select id="city" name="city" required="" >
                              <option value="">{{__("message.Select City")}}</option>
                              @foreach($city as $c)
                                   <option value="{{$c->id}}">{{$c->name}}</option>
                              @endforeach
                        </select>  
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.State")}}</label>
                     <input type="text" name="state" id="state" placeholder="{{__('message.Enter State')}}" required="">
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Pincode")}}</label>
                     <input type="text" name="pincode" id="pincode" placeholder="{{__('message.Enter Pincode')}}"  required="">
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12 form-group" style="margin-top: 35px;">
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="is_default" id="is_default_edit" value="1" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__("message.Make Default Address")}}</span>
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
         <button type="submit" id="address_submit_button" class="btn btn-success">{{__("message.Update Address")}}</button>
         <button type="button" class="btn btn-danger" data-dismiss="modal" >{{__("message.Close")}}</button>
         </div>
         </form>
      </div>
   </div>
</div>
@stop
@section('footer')
@stop