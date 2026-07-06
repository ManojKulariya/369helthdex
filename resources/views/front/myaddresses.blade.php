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
<section class="hd-dash-section">
    <div class="auto-container">
        <!-- Page head -->
        <div class="hd-dash-head">
            <nav class="hd-dash-breadcrumb" aria-label="Breadcrumb">
                <a href="{{route('home')}}">{{__('message.Home')}}</a>
                <i data-lucide="chevron-right"></i>
                <a href="{{route('dashboard')}}">{{__('message.Dashboard')}}</a>
                <i data-lucide="chevron-right"></i>
                <span>{{__("message.My Addresses")}}</span>
            </nav>
            <h1 class="hd-dash-title">{{__("message.My Addresses")}}</h1>
        </div>

        <div class="hd-dash-layout">
            @include('front.hd_account_sidebar', ['hdSidebarActive' => 'addresses'])

            <main class="hd-dash-main">
                @if(Session::has('message'))
                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                    </div>
                    @endif

                <!-- Header row -->
                <div class="hd-fam-header">
                    <div class="hd-fam-header-text">
                        <h2>{{__("message.My Addresses")}}</h2>
                        <p>Saved locations for quick home sample collection.</p>
                    </div>
                    <a href="javascript::void(0)" class="premium-btn premium-btn-primary" data-toggle="modal" data-target="#addaddress">
                        <i data-lucide="map-pin-plus"></i>
                        {{__("message.Add Address")}}
                    </a>
                </div>

                @if(count($myaddresses)>0)
                <div class="hd-fam-grid hd-addr-grid">
                    @foreach($myaddresses as $ma)
                    <div class="hd-fam-card">
                        <div class="hd-fam-top">
                            <span class="hd-fam-avatar"><i data-lucide="map-pin"></i></span>
                            <div class="hd-fam-id">
                                <h3>{{$ma->name}}</h3>
                                @if($ma->is_default=='1')
                                <span class="hd-fam-relation">{{__("message.Default")}}</span>
                                @endif
                            </div>
                        </div>

                        <ul class="hd-fam-meta">
                            <li><i data-lucide="navigation"></i>{{$ma->house_no}} , {{$ma->address}} , {{$ma->city}} , {{$ma->state}} , {{$ma->pincode}}</li>
                        </ul>

                        <div class="hd-fam-actions">
                            <button type="button" class="hd-fam-btn hd-fam-btn-edit" data-toggle="modal" data-target="#editaddress" onclick="editaddress('{{$ma->id}}')">
                                <i data-lucide="pencil"></i>
                                {{__("message.Edit")}}
                            </button>
                            <button type="submit" class="hd-fam-btn hd-fam-btn-delete" onclick="deleteaddress('{{$ma->id}}')">
                                <i data-lucide="trash-2"></i>
                                Delete
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="hd-dash-card hd-fam-empty">
                    <div class="hd-fam-empty-icon"><i data-lucide="map-pin"></i></div>
                    <h3>No addresses saved yet.</h3>
                    <p>Add an address so our phlebotomist knows exactly where to collect your sample.</p>
                    <a href="javascript::void(0)" class="premium-btn premium-btn-primary" data-toggle="modal" data-target="#addaddress">
                        <i data-lucide="map-pin-plus"></i>
                        {{__("message.Add Address")}}
                    </a>
                </div>
                @endif
            </main>
        </div>
    </div>
</section>
<div class="modal hd-form-modal" id="addaddress">
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
<div class="modal hd-form-modal" id="editaddress">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__("message.Edit Address")}}</h4>
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
