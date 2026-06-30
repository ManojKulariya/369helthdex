@extends('front.layout')
@section('title')
      {{__('message.CheckOut')}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('checkout')}}"/>
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
<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css"></style>
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
            <h1>{{__('message.CheckOut')}}</h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <div class="auto-container">
         <ul class="bread-crumb clearfix">
            <li><a href="{{route('home')}}">{{__('message.Home')}}</a></li>
            <li>{{__('message.CheckOut')}}</li>
         </ul>
      </div>
   </div>
</section>
<section class="clinic-details bg-color-3">
   <div class="auto-container">
       <p id="msg" style="color: white;background: red;padding: 11px;margin-bottom: 12px;display:none" ></p>
        @if(Session::has('message1'))
         <div class="col-sm-12">
            <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message1') }}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
         </div>
      @endif
   <div class="row clearfix">
     
   <div class="col-lg-8 col-md-12 col-sm-12 content-side">
      <div class="clinic-details-content">
         <div class="panel-group " id="accordion" role="tablist" aria-multiselectable="true">
            
               
                  <div class="panel panel-default">
                     <div class="panel-heading" role="tab" id="heading3">
                        <h4 class="panel-title">
                           @if(Auth::id())
                           <a role="button"  data-parent="#accordion" data-toggle="collapse"  href="#collapse3" aria-expanded="true" aria-controls="collapse3"><i class="fa fa-address-card checkicon"></i>{{__('message.Add Sample Collection Address, Date & Time')}}</a>
                           @else
                           <a role="button" data-toggle="collapse"  href="javascript::void(0)" aria-expanded="true" aria-controls="collapse3"><i class="fa fa-address-card checkicon"></i>{{__('message.Add Sample Collection Address, Date & Time')}}</a>
                           @endif
                        </h4>
                     </div>
                     <div id="collapse3" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="heading3">
                         
                        <div class="panel-body">
                           <div class="row boxed" id="users_address_list">
                              @if(count($useraddress)>0)
                              @foreach($useraddress as $ua)
                              <input type="radio" id="is_default_{{$ua->id}}" name="is_default_address"  onchange="getlab('{{$ua->id}}')" city="{{$ua->id}}" value="{{$ua->id}}" <?= isset($ua->is_default) && $ua->is_default == '1' ? 'checked="checked"' : '' ?>>
                                <label for="is_default_{{$ua->id}}">{{__('message.House no')}}: {{$ua->house_no}} {{$ua->address}} {{$ua->city}} {{$ua->state}} - {{$ua->pincode}}</label>

                              @endforeach
                              @endif
                              <br>
                           </div>
                           <div class="row " style="display: flex;justify-content: right; margin-top: 20px;margin-bottom: 30px;"><button  data-toggle="modal" data-target="#addaddressmodel" type="button" class="checkout-btn theme-btn-one" style="margin-right: 12px;">{{__('message.Add Address')}}</button><button type="button" class="checkout-btn theme-btn-one" onclick="opennewpanel(3,4)">{{__('message.Next')}}</button></div>
                            <div class="row ">
                             <div class="col-lg-6 col-md-12 col-sm-12 form-group branchlab">
                               
                                
                            </div>
                           
                            
                              <div class="col-lg-6 col-md-12 col-sm-12 form-group" >
                                 <label>Visit Type</label>
                                    <div class="row">
                                       <div class="col-6" >
                                        <label>
                                        <input type="radio" name="is_visit_type" onclick="togglevisit(0)"  value="0" checked>
                                        Home Visit
                                        </label></div>
                                         <div class="col-6" >
                                        <label>
                                        <input type="radio" name="is_visit_type" onclick="togglevisit(1)" value="1">
                                        Lab visit
                                        </label>
                                        </div>
                                   </div> 

                              </div>
                            
                              <div class="col-lg-6 col-md-12 col-sm-12 form-group" >
                                 <label>{{__('message.Select sample collection date')}}</label>
                                <input type="date" name="collection_date" id="collection_date" class="form-control" min="{{ date('Y-m-d') }}">

                              </div>
                              <div class="col-lg-6 col-md-12 col-sm-12 form-group" >
                                 <label>{{__('message.Select sample collection time')}}</label>
                                    <select name="collection_time" id="collection_time" size="3" class="form-control">
                                        
                                        <option value="">Select Time slot</option>
                                        @foreach ($timeslot as $slot)
                                            <?php
                                            $time_in_am_pm = date("g:i A", strtotime($slot->timeslot));
                                            ?>
                                            <option value="{{ $slot->timeslot }}">{{ $time_in_am_pm }}</option>
                                        @endforeach
                                    </select>

                              </div>
                            
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-------------------coupon--------------------------->
                   @if(count($coupon)>0)
                  <div class="panel panel-default">
                     <div class="panel-heading" role="tab" id="heading3">
                        <h4 class="panel-title">
                           @if(Auth::id())
                           <a role="button"  data-parent="#accordion" data-toggle="collapse"  href="#collapse3" aria-expanded="true" aria-controls="collapse3"><i class="fa fa-address-card checkicon"></i>Apply Coupon </a>
                           @else
                           <a role="button" data-toggle="collapse"  href="javascript::void(0)" aria-expanded="true" aria-controls="collapse3"><i class="fa fa-address-card checkicon"></i>Apply Coupon </a>
                           @endif
                        </h4>
                     </div>
                     <div id="collapse3" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="heading3">
                        <div class="cards-container row">
                              @foreach($coupon as $cp)
                             <div class="cardcp col-4 col-sm-3 col-6" id="coupon{{ $cp->id }}">
                                <div class="coupon-code">{{ $cp->coupon_code }}</div>
                                <div class="coupon-value">{{ $cp->coupon_value }} @if($cp->coupon_type == 'percent' ) % @else Rs @endif off On</div>
                                <div class="coupon-type" > @if($cp->type == 4) {{ 'All'}} @endif 
                                @if($cp->type == 1) {{ 'Package'}} @endif
                                @if($cp->type == 3)  {{ 'Profile' }} @endif 
                                @if($cp->type == 2)  {{ 'Parameter' }} @endif
                                </div>
                                <div class="coupon-type" > {{$cp->day}} </div>
                                 <?php
                                 $price = 0;
                                 ?>
                                <button class="apply-button" onclick="toggleCoupon('{{ $cp->id }}','{{ $price }}','{{ $cp->coupon_type }}','{{ $cp->coupon_value }}')">
                                    {{ $cp->is_applied ? 'Applied' : 'Apply Coupon' }}
                                </button>
                            </div>
                              @endforeach
                        </div>
                       
                     </div>
                  </div>
                  
                  @endif
                  <div class="panel panel-default">
                     <div class="panel-heading" role="tab" id="heading3">
                        <h4 class="panel-title">
                           @if(Auth::id())
                           <a role="button"  data-parent="#accordion" data-toggle="collapse"  href="#collapse3" aria-expanded="true" aria-controls="collapse3"><i class="fa fa-address-card checkicon"></i>Wallet Points  ( {{$point->wallet_amount}} Points)</a>
                           @else
                           <a role="button" data-toggle="collapse"  href="javascript::void(0)" aria-expanded="true" aria-controls="collapse3"><i class="fa fa-address-card checkicon"></i>Wallet Points</a>
                           @endif
                        </h4>
                     </div>
                     <div id="collapse3" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="heading3">
                        
                        <div class="panel-body">
                            <!--<label>Wallet Points  ( {{$point->wallet_amount}} Points)</label>-->
                            <div class="row">
                              <div class="col-6" style="padding-left: 0px;">
                                    
                                    <input type="number" name="wallet_points" id="wallet_points" min="0" max="{{$point->wallet_amount}}" class="form-control" >

                              </div>
                              <div class="col-6" style="padding-left: 0px;">
                                <button class="wallet-btn theme-btn-one" onclick="toggleWallet()">
                                    Apply Wallet
                                </button>
                            </div>
                             </div>
                        </div>
                     </div>
                  </div>
                  
                  <div class="panel panel-default">
                     <div class="panel-heading" role="tab" id="heading4">
                        <h4 class="panel-title">
                           @if(Auth::id())
                                 <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapse4"><i class="fa fa-money-bill-wave checkicon"></i> {{__('message.Payment Option')}}</a>
                           @else
                                <a role="button"  data-parent="#accordion" href="javascript::void(0)" aria-expanded="true" aria-controls="collapse4"><i class="fa fa-money-bill-wave checkicon"></i> {{__('message.Payment Option')}}</a>
                           @endif
                        </h4>
                     </div>
                     <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                        <div class="panel-body">
                           <div class="cc-selector">
                             <input id="payment_type_stripe" type="radio"  onchange="changeform(this.value)" name="payment_method" value="stripe" />
                                 <?php $stripe_img = asset("public/img/cc.jpg"); ?>
                                 
                                 <label class="drinkcard-cc" style="background-image:url('{{$stripe_img}}')" for="payment_type_stripe"></label>
                              
                                 <input id="payment_type_cod" type="radio"  onchange="changeform(this.value)" name="payment_method" value="cod" />
                                 <?php $cod_img = asset("public/img/cod.png"); ?>
                                 <label class="drinkcard-cc" style="background-image:url('{{$cod_img}}')" for="payment_type_cod"></label>
                             
                           </div>
                            <div id="braintree_div" style="display:none;">
                                   <form action="{{route('book-order')}}" method="post" id="payment-form">
                                       {{csrf_field()}}
                                        <input type="hidden" name="sample_collection_address_id" id="sample_collection_address_id_braintree">
                                        <input type="hidden" name="date" id="date_braintree">
                                        <input type="hidden" name="time" id="time_braintree">
                                        <input type="hidden" name="member_id" class="member_id">
                                        <input type="hidden" name="coupon_id" class="coupon_id">
                                        <input type="hidden" name="visit_type" class="is_visit_type" value="0">
                                        <input type="hidden" name="wallet_point" class="wallet_point">
                                        <input type="hidden" name="subtotal" id="subtotal_braintree">
                                        <input type="hidden" name="tax" id="tax_braintree">
                                        <input type="hidden" name="final_total" id="final_total_braintree">
                                        <input type="hidden" name="payment_type" value="braintree">
                                             <div class="bt-drop-in-wrapper">
                                                <div id="bt-dropin"></div>
                                             </div>
                                             <input id="nonce" name="payment_method_nonce" type="hidden" />
                                             <div class="btn-box" id="btnappointment">
                                                <button class="theme-btn-one" type="submit">{{__('message.
                                                ')}}<i class="icon-Arrow-Right"></i></button>       
                                             </div>
                                    </form> 
                           </div>

                           <div id="stripe_div" style="display:none;">
                                <form action="{{route('book_payment')}}" method="get" id="stripe-form">
                                 {{csrf_field()}}
                                      <input type="hidden" name="sample_collection_address_id" id="sample_collection_address_id_stripe" >
                                        <input type="hidden" name="date" id="date_stripe">
                                        <input type="hidden" name="time" id="time_stripe">
                                         <input type="hidden" name="member_id" class="member_id">
                                         <input type="hidden" name="coupon_id" class="coupon_id">
                                        <input type="hidden" name="wallet_point" class="wallet_point">
                                        <input type="hidden" name="visit_type" class="is_visit_type" value="0">
                                        <input type="hidden" name="subtotal" id="subtotal_stripe">
                                        <input type="hidden" name="tax" id="tax_stripe">
                                        <input type="hidden" name="final_total" id="final_total_stripe">
                                        <input type="hidden" name="payment_type" value="ccavenue">
                                        <div class="btn-box" id="btnappointment">
                                            <button class="theme-btn-one" type="submit">{{__('message.Book Now')}}<i class="icon-Arrow-Right"></i></button>       
                                        </div>

                              </form> 
                           </div>

                           <div id="cod_div" style="display:none;">
                                <form action="{{route('book-order')}}" method="post" id="stripe-form-2">
                                 {{csrf_field()}}
                                      <input type="hidden" name="sample_collection_address_id" id="sample_collection_address_id_cod" >
                                        <input type="hidden" name="date" id="date_cod">
                                        <input type="hidden" name="time" id="time_cod">
                                         <input type="hidden" name="member_id" class="member_id">
                                         <input type="hidden" name="coupon_id" class="coupon_id">
                                        <input type="hidden" name="wallet_point" class="wallet_point">
                                        <input type="hidden" name="visit_type" class="is_visit_type" value="0">
                                        <input type="hidden" name="subtotal" id="subtotal_cod">
                                        <input type="hidden" name="tax" id="tax_cod">
                                        <input type="hidden" name="final_total" id="final_total_cod">
                                        <input type="hidden" name="payment_type" value="cod">
                                        <div class="btn-box" id="btnappointment">
                                            <button class="theme-btn-one" type="submit">{{__('message.Book Now')}}<i class="icon-Arrow-Right"></i></button>       
                                        </div>
                                   
                              </form> 
                           </div>
                          
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
            <div class="clinic-sidebar">
               <div class="form-widget">
                  <div class="form-title">
                     <h3>{{__('message.CART DETAILS')}}</h3>
                     <p></p>
                  </div>
                  
                     <?php $total = 0; ?>
                     <div id="member_on_cart">
                     @if(count($cartdata)>0)
                     @foreach($cartdata as $cm)
                        <div class="col-xl-12 col-lg-12 col-md-12 doctors-block member_Cart" id="cart_member_{{$cm['member_id']}}">
                           <div class="team-block-three">
                              <div class="inner-box">
                                 <div class="lower-content">
                                    <ul class="name-box clearfix">
                                       <li class="name">
                                          <h3><a href="#">{{$cm['member_name']}} | {{$cm['relation']}}</a></h3>
                                       </li>
                                    </ul>
                                    <span class="designation">{{$cm['gender']}}, {{$cm['age']}} years</span>
                                    <?php $discount = 0 ?>
                                    @foreach($cm['testdata'] as $item)
                                    
                                    <?php
                                    if ($item['mrp'] != 0.00 && $item['price'] != 0.00) {
                                        // $discount = 100 * ($item['mrp'] - $item['price']) / $item['mrp'];
                                    }

                                    ?>
                                    <div class="row" id="member_{{$item['id']}}" style="border-top: 1px solid white;">
                                       <div class="col-md-9">
                                          <p style="color: #ffffff;">{{$item['test_name']}}</p>
                                          <span>Parameters Included : {{$item['parameter']}}</span>
                                          <p><span >
                                               <!--{{$item['mrp']}}-->
                                               </span></p></div>
                                       <?php $total = $total + (float)$item['mrp']; ?>
                                       <div class="col-md-3" >
                                          <p style="margin-top: 8px;margin-bottom: 19px;"><span style="background: green;color: white;    padding: 2px;">
                                              {{$item['mrp']}}
                                              </span></p>
                                          <p><span></span></p>

                                          <?php $member_id = $item['id'];
                                          $cart_member_id = $cm['member_id']; ?>
                                          <span><a style="color: white;" href="javascript:void(0)" onclick="removememberitemoncart('{{$member_id}}','{{$cart_member_id}}')"><i class="fa fa-trash"></i></a></span>
                                       </div>
                                    </div>
                                    @endforeach
                                 </div>
                              </div>
                           </div>
                        </div>
                        @endforeach
                        @endif
                 </div>
                 
                  <div class="col-xl-12 col-lg-12 col-md-12 doctors-block" style="margin-top: 10px;">
                     <div class="team-block-three">
                        <div class="inner-box">
                           <div class="lower-content">
                              <ul class="name-box clearfix">
                                 <li class="name" style="display: list-item;">
                                    <div class="row">
                                       <div class="col-md-8">
                                          <h3><a href="#">{{__('message.Sub Total')}}</a></h3>
                                       </div>
                                       <div class="col-md-4">
                                          <p style="float: right;">{{$currency}}<span id="subtotal">{{number_format($total,2,'.','')}}</span></p>
                                       </div>
                                    </div>
                                 </li>
                                 <li class="name" style="display: list-item;">
                                    <div class="row">
                                       <div class="col-md-8">
                                          <h3><a href="#">Coupon Discount</a></h3>
                                       </div>
                                       <div class="col-md-4">
                                          <p style="float: right;">{{$currency}}<span id="discount">0</span></p>
                                       </div>
                                    </div>
                                 </li>
                                 <li class="name" style="display: list-item;">
                                    <div class="row">
                                       <div class="col-md-8">
                                          <h3><a href="#">Wallet Point Discount</a></h3>
                                       </div>
                                       <div class="col-md-4">
                                          <p style="float: right;">{{$currency}}<span id="wal_discount">0</span></p>
                                       </div>
                                    </div>
                                 </li>
                                 <li class="name" style="display: list-item;" >
                                    <div class="row">
                                       <div class="col-md-8">
                                          <h3><a href="#">{{__('message.Txt')}}</a></h3>
                                       </div>
                                       <div class="col-md-4">
                                          <?php $txt = ($total * $setting->txt_charge) / 100; ?>
                                          <p style="float: right;">{{$currency}}<span id="txt_charges">{{number_format($txt,2,'.','')}}</span></p>
                                       </div>
                                    </div>
                                 </li>
                                 <li class="name" style="display: list-item;">
                                    <div class="row">
                                       <div class="col-md-8">

                                          <h3><a href="#">{{__('message.Total')}}</a></h3>
                                       </div>
                                       <div class="col-md-4">
                                          <?php $final_total = $total + $txt; ?>
                                          <p style="float: right;">{{$currency}}<span id="main_total">{{number_format($final_total,2,'.','')}}</span></p>
                                       </div>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<div class="modal" id="addmember">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__('message.Add New Family Member')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{route('update-user-family')}}" method="post" class="registration-form">
         <!-- Modal body -->
         <div class="modal-body">
            
               {{csrf_field()}}
               <div class="row clearfix">
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>{{__('message.Relation')}}</label>
                     <select id="relation" name="relation" required="">
                        <option value="">{{__('message.Select Relation')}}</option>
                        <option value="Self">{{__('message.Self')}}</option>
                        <option value="Spouse">{{__('message.Spouse')}}</option>
                        <option value="Child">{{__('message.Child')}}</option>
                        <option value="Parent">{{__('message.Parent')}}</option>
                        <option value="Grand Parent">{{__('message.Grand Parent')}}</option>
                        <option value="Sibling">{{__('message.Sibling')}}</option>
                        <option value="Friend">{{__('message.Friend')}}</option>
                        <option value="Relative">{{__('message.Relative')}}</option>
                        <option value="Neighbour">{{__('message.Neighbour')}}</option>
                        <option value="Colleague">{{__('message.Colleague')}}</option>
                        <option value="Others">{{__('message.Others')}}</option>
                     </select>
                  </div>
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>{{__('message.Name')}}</label>
                     <input type="text" name="name" id="name" placeholder="{{__('message.Enter Name')}}" required="">
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                     <label>{{__('message.email')}}</label>
                     <input type="email" name="email" id="email" placeholder="{{__('message.Enter Email')}}" required="">
                  </div>
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>{{__('message.Phone')}}</label>
                     <input type="text" name="phone" id="phone" placeholder="{{__('message.Enter Phone')}}" required="">
                  </div>
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>{{__('message.Age')}}</label>
                     <input type="text" name="age" id="age" placeholder="{{__('message.Enter Age')}}" required="">
                  </div>
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>{{__('message.DOB')}}</label>
                     <input type="date" name="dob" id="dob"  required="">
                  </div>
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>{{__('message.Gender')}}</label>
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="gender" id="gender_1" value="Male" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__('message.Male')}}</span>
                           </label>
                        </div>
                     </div>
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="gender" id="gender_2" value="Female" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__('message.Female')}}</span>
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
         <button type="submit" class="btn btn-success" >{{__('message.Add Member')}}</button>
         </div>
         </form>
      </div>
   </div>
</div>
<div class="modal" id="addaddressmodel">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__('message.Add New Address')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <form action="{{route('post-user-address')}}" method="post" id="user_address" class="registration-form">
               {{csrf_field()}}
               <div class="row clearfix">
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group"  id="addressorder">
                     <label>{{__('message.Address')}}<span class="reqfield">*</span></label>
                     <input  type="text" id="us2-address" name="address" placeholder='Search Location' required data-parsley-required="true" required=""/>
                  </div>
                  <div class="map col-lg-12 col-md-6 col-sm-12 form-group" id="maporder">
                     <div class="form-group">
                        <div class="col-md-12 p-0">
                           <div id="us2"></div>
                        </div>
                     </div>
                  </div>
                  <?php
                  $inputLatitude = session('latitude');
                  $inputLongitude = session('longitude');
                  if ($inputLatitude == '') {
                      $inputLatitude = env('MAP_LAT');
                      $inputLongitude = env('MAP_LONG');
                  }
                  ?>
                  <input type="hidden" name="lat" id="us2-lat" value="{{$inputLatitude}}" />
                  <input type="hidden" name="long" id="us2-lon" value="{{$inputLongitude}}" />
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>{{__('message.Name')}}</label>
                     <input type="text" name="name" id="name" placeholder="{{__('message.Enter Name')}}" required="">
                  </div>
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>House No</label>
                     <input type="text" name="house_no" id="house_no" placeholder="{{__('message.Enter House No')}}" required="">
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                     <label>City</label>                     
                     <input type="text" name="city" id="house_no"  required="">
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>{{__('message.State')}}</label>
                     <input type="text" name="state" id="state" placeholder="{{__('message.Enter State')}}" required="">
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label>{{__('message.Pincode')}}</label>
                     <input type="text" name="pincode" id="pincode" placeholder="{{__('message.Enter Pincode')}}"  required="">
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12 form-group" style="margin-top: 35px;">
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="checkbox" name="is_default" id="is_default" value="1" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__('message.Make Default Address')}}</span>
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
         <button type="submit" id="address_submit_button" class="btn btn-success">{{__('message.Add Address')}}</button>
         </div>
         </form>
      </div>
   </div>
</div>
@stop
@section('footer')
<script src="https://js.braintreegateway.com/web/dropin/1.23.0/js/dropin.min.js"></script>
<script>
    function getlab(city) {
       
        var cityId = city;
       // console.log(city);
        // Perform the AJAX request
        $.ajax({
            url: '/get-users-by-city/' + cityId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
           
                var optionsHTML = ' <label>Select Lab</label><select size="3" class="form-control " name="member_ids" id="branchid" onchange="selectlab()" >';
                      
                
                // Generate HTML for options based on the received data
                $.each(data, function (index, user) {
                     var isSelected = user.default === "Yes";
                      optionsHTML += '<option value="' + user.id + '" ' + (isSelected ? 'selected' : '') + '>' + user.name + '</option>';
                });
                  optionsHTML += '</select>';
                // Set the HTML for the <select> element
                $('.branchlab').html(optionsHTML);
                var member =data[0]['id'];
                 $(".member_id").val(member);
       
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
    
     function selectlab() {
         
          var member = $('#branchid').val();
         $(".member_id").val(member);
     }
    
     $(document).ready(function() {
        // Assuming you want to call getlab with the default city on page load
        var defaultCity = $('input[name="is_default_address"]:checked').attr('city');
        
        getlab(defaultCity);
    });

   function changeform(val){
       console.log(val);
      var errro_msg_for_add = $(".errro_msg_for_add").val();
      var errro_msg_for_date  = $(".errro_msg_for_date").val();
      var errro_msg_for_time  = $(".errro_msg_for_time").val();
      // alert(errro_msg_for_add);
      var sample_collection_address_id = $('input[name="is_default_address"]:checked').val();
      var date = $("#collection_date").val();
      var time = $("#collection_time").val();
      var subtotal = $('#subtotal').html();
      var tax = $('#txt_charges').html();
      var final_total = $('#main_total').html();
      var msg = 0;
      var msg_txt ="";
      if(sample_collection_address_id==""){
         msg_txt = msg_txt+errro_msg_for_add+"</br>";
         msg = 1;
      }
      if(date==""){
         msg_txt = msg_txt+errro_msg_for_date+"</br>";
         msg = 1;
      }
      if(time==""){
         msg_txt = msg_txt+errro_msg_for_time+"</br>";
         msg = 1;
      }
      if(msg==1){
            $("#msg").html(msg_txt);
            $("#msg").css("display","block");
      }else{
            if($("#payment_type_braintree").prop("checked")==true){
                 $("#braintree_div").css("display","block");
                 $("#stripe_div").css("display","none");
                 $("#cod_div").css("display","none");
                
            }

            if($("#payment_type_stripe").prop("checked")==true){
                 $("#braintree_div").css("display","none");
                 $("#stripe_div").css("display","block");
                 $("#cod_div").css("display","none");
            }
            if($("#payment_type_cod").prop("checked")==true){
                 $("#braintree_div").css("display","none");
                 $("#stripe_div").css("display","none");
                 $("#cod_div").css("display","block");
            }
            
                 $("#sample_collection_address_id_"+val).val(sample_collection_address_id);
                 $("#date_"+val).val(date);
                 $("#time_"+val).val(time);
                 $("#subtotal_"+val).val(subtotal);
                 $("#tax_"+val).val(tax);
                 $("#final_total_"+val).val(final_total);
      }
   }


   var form = document.querySelector('#payment-form');
   
   var client_token = "{{$token}}";
   
   braintree.dropin.create({
     authorization: client_token,
     selector: '#bt-dropin',
     paypal: {
       flow: 'vault'
     }
   }, function (createErr, instance) {
     if (createErr) {
       console.log('Create Error', createErr);
       return;
     }
     form.addEventListener('submit', function (event) {
       event.preventDefault();
   
       instance.requestPaymentMethod(function (err, payload) {
         if (err) {
           console.log('Request Payment Method Error', err);
           return;
         }
        
        
         document.querySelector('#nonce').value = payload.nonce;
         form.submit();
       });
     });
   });
</script>
<script>
        function togglevisit(visit) {
            
        $(".is_visit_type").val(visit);
        
        }
        function toggleWallet() {
            
        var wallet_points = $("#wallet_points").val();
        var wallet_cashback_point = <?php echo $walletsetting->wallet_cashback_point; ?> ;
        var discount = wallet_points / wallet_cashback_point;
        $(".wallet_point").val(wallet_points);
        var final_total = <?php echo $final_total; ?>- $("#discount").html() - discount ;
        
        
        $("#wal_discount").html(discount.toFixed(2));
        $("#main_total").html(final_total.toFixed(2));
        
        }
        function toggleCoupon(couponId,price,type,value) {
            var subtotal = <?php echo $final_total; ?>  ;
            $.ajax({
            url: '/applycoupon/',
            type: 'GET',
            data: {
                id: couponId,
                subtotal: subtotal
            },
            dataType: 'json',
                success: function (data) {
                    
                    console.log(data);
                  //  if(data != 0){
                        const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.classList.remove('applied-coupon');
                const button = card.querySelector('.apply-button');
                button.innerText = 'Apply Coupon';
            });

            const selectedCard = document.getElementById(`coupon${couponId}`);
            if (selectedCard) {
                selectedCard.classList.add('applied-coupon');
                const button = selectedCard.querySelector('.apply-button');
                button.innerText = 'Applied';
                const couponCode = selectedCard.querySelector('.coupon-code').innerText;
                const couponValue = selectedCard.querySelector('.coupon-value').innerText;
                const couponType = selectedCard.querySelector('.coupon-type').innerText;
                
             
                
              var final_total = <?php echo $final_total; ?> -  $("#wal_discount").html() - data ;

                 $("#discount").html(data);
                 $("#main_total").html(final_total.toFixed(2));
                 $(".coupon_id").val(couponId);
           // }
                    }
                },
            });
            
        }
        
document.getElementById("collection_time").onchange = function() {
    // Get the selected date and time from the inputs
    var selectedDate = $("#collection_date").val();
    var selectedTime = $("#collection_time").val();

    if (selectedDate === '' || selectedTime === '') {
        alert('Please select both date and time.');
    } else {
        // Convert the selected date and time to a Date object
        var selectedDateTime = new Date(selectedDate + ' ' + selectedTime);

        // Get the current date and time
        var currentDateTime = new Date();

        // Compare the selected date and time with the current date and time
        if (selectedDateTime <= currentDateTime) {
            alert('Please select a future date and time.');
                
        }
    }
};

    // Function to validate the selected date and time
    function validateDateTime(event) {
        // Get the selected date and time from the inputs
        var selectedDate = document.getElementById("collection_date").value;
        var selectedTime = document.getElementById("collection_time").value;

        if (selectedDate === '' || selectedTime === '') {
            // Reset the "collection_time" select element to the "Select Time Slot" option
            document.getElementById("collection_time").selectedIndex = 0;
            alert('Please select both date and time.');
            event.preventDefault(); // Prevent form submission
        } else {
            // Convert the selected date and time to a Date object
            var selectedDateTime = new Date(selectedDate + ' ' + selectedTime);

            // Get the current date and time
            var currentDateTime = new Date();

            // Compare the selected date and time with the current date and time
            if (selectedDateTime <= currentDateTime) {
                // Reset the "collection_time" select element to the "Select Time Slot" option
                document.getElementById("collection_time").selectedIndex = 0;
                alert('Please select a future date and time.');
                event.preventDefault(); // Prevent form submission
            }
        }
    }

    // Attach the event listener to the form's submit event
    document.getElementById("payment-form").addEventListener("submit", validateDateTime);
    document.getElementById("stripe-form").addEventListener("submit", validateDateTime);
     document.getElementById("stripe-form-2").addEventListener("submit", validateDateTime);
</script>


@stop