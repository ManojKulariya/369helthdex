@extends('front.layout')
@section('title')
  {{__("message.Family Members")}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('my-family-member')}}"/>
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
               <li><a href="{{route('dashboard')}}" ><i class="fas fa-columns"></i>{{__("message.Dashboard")}}</a></li>
              
               <li><a href="{{route('my-family-member')}}" class="current"><i class="fas fa-clock"></i>{{__("message.My Family Members")}}</a></li>
               <li><a href="{{route('my-addresses')}}"><i class="fas fa-comments"></i>{{__("message.My Addresses")}}</li>
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
                                <h3 class="col-md-6">{{__("message.My Family Members")}}</h3>
                                <div class="btn-box col-md-6 tdr"><button data-toggle="modal" data-target="#addmember" class="theme-btn-one"><i class="icon-image"></i> {{__("message.Add Family Members")}}</button>
                                </div>
                            </div>
                            <div class="doctors-list">
@if(Session::has('message'))
               <div class="col-sm-12">
                  <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>
                  </div>
               </div>
               @endif 
                                <div class="row clearfix">
                                    
                                 @if(count($myfamily)>0)
                                    @foreach($myfamily as $ma)
                                       <div class="col-xl-6 col-lg-6 col-md-12 doctors-block">
                                        <div class="team-block-three">
                                            <div class="inner-box">
                                                <div class="lower-content">
                                                    <ul class="name-box clearfix">
                                                        <li class="name"><h3><a href="doctors-details.html">{{$ma->name}}</a></h3></li>
                                                        <li style="font-size: small;top: 0px !important;">{{$ma->relation}}</li>
                                                    </ul>
                                                    <span class="designation" >{{$ma->gender}}</span>
                                                    <div class="rating-box clearfix">
                                                       <i class="fa fa-phone"></i> {{$ma->mobile_no}}
                                                    </div>
                                                    <!--<div class="rating-box clearfix">-->
                                                    <!--   <i class="fa fa-envelope"></i>  {{$ma->email}}-->
                                                    <!--</div>-->
                                                    <!--<div class="rating-box clearfix">-->
                                                    <!--   <i class="fa fa-birthday-cake"></i> {{$ma->dob}}-->
                                                    <!--</div>-->
                                                    
                                                    <div class="btn-box row">
                     <button type="button" style="position: relative;display: inline-block;float: left;
    font-size: 15px;Line-height: 26px;font-weight: 600;border: 2px solid #ebeef1;border-radius: 30px;   
    padding: 7px 27px;text-align: center;background: #453f85;color: white;" data-toggle="modal" data-target="#editmember" onclick="editmember('{{$ma->id}}')">{{__("message.Edit")}} <i class="fa fa-edit"></i></button>
                      <button type="submit" style="position: relative;display: inline-block;float: left;
    font-size: 15px;Line-height: 26px;font-weight: 600;border: 2px solid #ebeef1;border-radius: 30px;   
    padding: 7px 27px;text-align: center;background: #f01634;color: white;" onclick="deletemember('{{$ma->id}}')">{{__("message.Delete")}} <i class="fa fa-trash"></i></button>
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
<div class="modal" id="addmember">
   <div class="modal-dialog modal-lg">
      <div class="modal-content ">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__("message.Add New Family Member")}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{route('update-user-family')}}" method="post" class="registration-form">
         <!-- Modal body -->
         <div class="modal-body">
            
               {{csrf_field()}}
               <div class="row clearfix">
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Relation")}}</label>
                     <select  name="relation" required="">
                        <option value="">{{__("message.Select Relation")}}</option>
                        <option value="Self">{{__("message.Self")}}</option>
                        <option value="Spouse">{{__("message.Spouse")}}</option>
                        <option value="Child">{{__("message.Child")}}</option>
                        <option value="Parent">{{__("message.Parent")}}</option>
                        <option value="Grand Parent">{{__("message.Grand Parent")}}</option>
                        <option value="Sibling">{{__("message.Sibling")}}</option>
                        <option value="Friend">{{__("message.Friend")}}</option>
                        <option value="Relative">{{__("message.Relative")}}</option>
                        <option value="Neighbour">{{__("message.Neighbour")}}</option>
                        <option value="Colleague">{{__("message.Colleague")}}</option>
                        <option value="Others">{{__("message.Others")}}</option>
                     </select>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Name")}}</label>
                     <input type="text" name="name"  placeholder="{{__('message.Enter Name')}}" required="">
                  </div>
                  <!--<div class="col-lg-4 col-md-12 col-sm-12 form-group">-->
                  <!--   <label>{{__("message.email")}}</label>-->
                  <!--   <input type="email" name="email"  placeholder="{{__('message.Enter Email')}}" required="">-->
                  <!--</div>-->
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Phone")}}</label>
                     <input type="text" name="phone"  placeholder="{{__('message.Enter Phone')}}" required="">
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Age")}}</label>
                     <input type="text" name="age"  placeholder="{{__('message.Enter Age')}}" required="">
                  </div>
                  <!--<div class="col-lg-4 col-md-6 col-sm-12 form-group">-->
                  <!--   <label>{{__("message.DOB")}}</label>-->
                  <!--   <input type="date" name="dob"   required="">-->
                  <!--</div>-->
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Gender")}}</label>
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="gender" id="gender_1" value="Male" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__("message.Male")}}</span>
                           </label>
                        </div>
                     </div>
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="gender" id="gender_2" value="Female" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__("message.Female")}}</span>
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
         <button type="submit" class="btn btn-success" >{{__("message.Add Member")}}</button>
         <button type="button" class="btn btn-danger" data-dismiss="modal" >{{__("message.Close")}}</button>
         </div>
         </form>
      </div>
   </div>
</div>

<div class="modal" id="editmember">
   <div class="modal-dialog modal-lg">
      <div class="modal-content ">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__("message.Edit Family Member")}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{route('update-user-family')}}" method="post" class="registration-form">
         <!-- Modal body -->
         <div class="modal-body">
              <input type="hidden" name="id" id="edit_id" >
               {{csrf_field()}}
               <div class="row clearfix">
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Relation")}}</label>
                     <select  name="relation" id="edit_relation" required="">
                        <option value="">{{__("message.Select Relation")}}</option>
                        <option value="Self">{{__("message.Self")}}</option>
                        <option value="Spouse">{{__("message.Spouse")}}</option>
                        <option value="Child">{{__("message.Child")}}</option>
                        <option value="Parent">{{__("message.Parent")}}</option>
                        <option value="Grand Parent">{{__("message.Grand Parent")}}</option>
                        <option value="Sibling">{{__("message.Sibling")}}</option>
                        <option value="Friend">{{__("message.Friend")}}</option>
                        <option value="Relative">{{__("message.Relative")}}</option>
                        <option value="Neighbour">{{__("message.Neighbour")}}</option>
                        <option value="Colleague">{{__("message.Colleague")}}</option>
                        <option value="Others">{{__("message.Others")}}</option>
                     </select>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Name")}}</label>
                     <input type="text" name="name"  id="name" placeholder="{{__('message.Enter Name')}}" required="">
                  </div>
                  <!--<div class="col-lg-4 col-md-12 col-sm-12 form-group">-->
                  <!--   <label>{{__("message.email")}}</label>-->
                  <!--   <input type="email" name="email" id="email" placeholder="{{__('message.Enter Email')}}" required="">-->
                  <!--</div>-->
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Phone")}}</label>
                     <input type="text" name="phone"  id="phone" placeholder="{{__('message.Enter Phone')}}" required="">
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Age")}}</label>
                     <input type="text" name="age"  id="age" placeholder="{{__('message.Enter Age')}}" required="">
                  </div>
                  <!--<div class="col-lg-4 col-md-6 col-sm-12 form-group">-->
                  <!--   <label>{{__("message.DOB")}}</label>-->
                  <!--   <input type="date" name="dob" id="dob"  required="">-->
                  <!--</div>-->
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Gender")}}</label>
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="gender" id="edit_gender_1" value="Male" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__("message.Male")}}</span>
                           </label>
                        </div>
                     </div>
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="gender" id="edit_gender_2" value="Female" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__("message.Female")}}</span>
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
         <button type="submit" class="btn btn-success" >{{__("message.Update Member")}}</button>
         <button type="button" class="btn btn-danger" data-dismiss="modal" >{{__("message.Close")}}</button>
         </div>
         </form>
      </div>
   </div>
</div>
@stop
@section('footer')
@stop