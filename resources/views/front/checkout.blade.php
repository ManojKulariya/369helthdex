
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style type="text/css"></style>
<style>
    .yellow-radio:checked {
        accent-color: #FF9800;
    }
    select.underline-select {
    border-radius:0;
    appearance: none; /* Remove default appearance */
    -webkit-appearance: none; /* Remove styling for Safari */
    -moz-appearance: none; /* Remove styling for Firefox */
    border: none; /* Remove all borders */
    border-bottom: 1px solid #000; /* Only bottom border */
    outline: none; /* Remove outline */
    box-shadow: none; /* Remove any box shadow */
    width: 100%; /* Optional: Full width */
    padding:0; /* Adjust padding */
    background: transparent; /* Remove background color */
    cursor: pointer; /* Show pointer cursor */
    }

    select.underline-select:focus {
        border-bottom-color: ; 
    }
    .panel-title > a{
    padding:6px 18px;
    font-size:15px;
    }
    .otp-container {
        display: flex;
        /*justify-content: center;*/
        gap: 10px;
    }

    .otp-input {
        width: 35px;
        height: 35px;
        font-size: 16px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .otp-input:focus {
        border-color: #007bff;
        outline: none;
    }
    .modal {
        z-index: 1050; /* Adjust as necessary */
    }
        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 15px;
            height: 15px;
            border: 2px solid #555;
            border-radius: 50%; /* Make it round */
            outline: none;
            cursor: pointer;
            position: relative;
        }

        input[type="checkbox"]:checked {
            background-color: #FF9800;
            border-color: #FF9800;
        }

        /* Add a checkmark for checked state */
        input[type="checkbox"]:checked::before {
            content: '\2713';
            color: white;
            font-size: 16px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

    option {
            font-size: 13px; 
        }
    .card-box-city{
        padding: 6px;
        background-color: #FFFFFF;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        margin-bottom: 10px;
        line-height: 1.4;
        font-size: 13px;
        font-weight: 300;
        overflow-wrap: break-word; 
        white-space: normal;
        min-height:90px;
    }
    .card-box-member {
        padding: 15px;
        min-height:75px;
        background-color: #FFFFFF;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        margin-bottom: 10px;
        line-height: 1.2;
        font-size: 12px; 
        font-weight: 200;
        overflow-wrap: break-word;
        white-space: normal;
    }
    .card-box {
        padding: 18px;
        min-height:115px;
        background-color: #FFFFFF;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        margin-bottom: 10px;
        line-height: 1.4;
        font-size: 13px; 
        font-weight: 300;
        overflow-wrap: break-word;
        white-space: normal;
    }
        
    .selected-address {
        font-weight: bold;
    }
    .dropdown-menu {
        max-width: 100%;
        white-space: normal;
        word-wrap: break-word;
    }
    .dropdown-item {
        width:100%;
        border-bottom: 0.5px  dashed black;
        font-size: 14px; /* Make the font a bit smaller */
        font-weight: 300; /* Make the font thinner */
         overflow-wrap: break-word;
    }
    .address-details {
    
        padding:2px;
        color: #333;
        line-height: 1.4;
        font-size: 13px; /* Smaller font for address details */
        font-weight: 300; /* Thinner font */
         overflow-wrap: break-word; /* Allow breaking long words */
        white-space: normal;
    }
    .house-number {
    background-color: #868AA2; /* Background color */
    color: white; /* Text color */
    padding:  1px 7px; /* Padding for better spacing */
    border-radius: 0.5px; /* Rounded corners */
    line-height: 1.4;
        font-size: 13px; /* Smaller font for address details */
        font-weight: 300; 
    }
      .house-number-select {
        background-color: #FF9800; /* Background color */
        color: white; /* Text color */
        padding:  1px 7px; /* Padding for better spacing */
        margin-bottom:1px;
        border-radius: 0.5px; /* Rounded corners */
        line-height: 1.4;
            font-size: 13px; /* Smaller font for address details */
            font-weight: 300; 
    }


    .border-bottom {
        border: none;
        border-bottom: 1px solid #000; /* Change to your desired color */
        outline: none; /* Remove outline when focused */
        background-color: transparent; /* Make the background transparent */
        padding: 5px 0; /* Optional: space around the text */
        width: 100%;
    }

    .border-bottom option {
        background-color: white; /* Ensure the background of options is white */
    }
    /* Style specifically for input type="date" */
input[type="date"].underline-input {
    border-radius:0;
    appearance: none; /* Remove default appearance */
    -webkit-appearance: none; /* For Safari */
    -moz-appearance: none; /* For Firefox */
    border: none; /* Remove all borders */
    border-bottom: 0.5px solid #000; /* Add only bottom border */
    outline: none; /* Remove outline on focus */
    box-shadow: none; /* Remove any box shadow */
    width: 100%; /* Optional: Full width */
    padding:0; /* Optional: Adjust padding */
    font-size:13px;height:42px
}

input[type="date"].underline-input:focus {
    border-bottom-color: #007bff; /* Optional: Change bottom border color on focus */
}

            .input-bottom-line {
            border: none; /* Remove default borders */
            border-bottom: 2px solid #000000; /* Bottom border */
            outline: none; /* Remove outline on focus */
            width: 100%; /* Full width */
            padding: 8px 0; /* Padding for better appearance */
            font-size: 16px; /* Font size */
        }

        .input-bottom-line:focus {
            border-bottom: 2px solid #0056b3; /* Change color on focus */
        }

        .input-bottom-line::placeholder {
            color: #999; /* Placeholder color */
            opacity: 1; /* Ensure opacity */
        }
</style>
<?php
     $txt =0;
     $currentTime = date("H:i");
     $selected='';
     $timeAfterTwoHours = date("H:i", strtotime('+2 hours'));
?>
<section class="clinic-details bg-color-3 hd-checkout">
   <div class="auto-container hd-checkout-head">
      <nav class="hd-dash-breadcrumb" aria-label="Breadcrumb">
         <a href="{{route('home')}}">{{__('message.Home')}}</a>
         <i data-lucide="chevron-right"></i>
         <span>{{__('message.CheckOut')}}</span>
      </nav>
      <h1 class="hd-dash-title">{{__('message.CheckOut')}}</h1>
      <p class="hd-checkout-sub"><i data-lucide="shield-check"></i> Secure checkout — your details are protected</p>
   </div>
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
                     <div class="panel-heading" role="tab" id="heading1">
                        <h4 class="panel-title">
                           @if(Auth::check())
                           <a role="button" class="text-decoration"  data-parent="#accordion" data-toggle=""  href="#" aria-expanded="true" aria-controls="collapse1">
                               <i class="fa fa-address-card checkicon"></i>{{auth()->user()->name}}</a>
                           @else
                           <a role="button" class="text-decoration" data-toggle="collapse"  href="javascript::void(0)" aria-expanded="true" aria-controls="collapse1"><i class="fa fa-address-card checkicon"></i>Login Account</a>
                           @endif
                        </h4>
                     </div>
                     
                     <div id="collapse1" class="panel-collapse collapse {{ !Auth::check() ? 'show' : '' }}" role="tabpanel" aria-labelledby="heading1">
                         
                        <div class="panel-body">
                            @if(!Auth::check())
                            <!--#------------------------->
                            <div class="row">
                                <div class="col-md-7">
                                    <input type="tel" id="phone" name="phon" placeholder="Enter mobile number" class="input-bottom-line phone" maxlength="10" pattern="[0-9]{10}" required />
                                    <!--<input type="tel"  name="otp" placeholder="Enter OTP" class="otp input-bottom-line" maxlength="10" pattern="[0-9]{10}" required />-->
                                    <div class="otp">
                                        <lable style="font-size:13px;">Please enter verification code (OTP) sent to: <span id="num"></span></lable></br>
                                        <div class="otp-container" >
                                        <input type="tel" id="otp-1" maxlength="1" pattern="[0-9]" class="otp-input" required />
                                        <input type="tel" id="otp-2" maxlength="1" pattern="[0-9]" class="otp-input" required />
                                        <input type="tel" id="otp-3" maxlength="1" pattern="[0-9]" class="otp-input" required />
                                        <input type="tel" id="otp-4" maxlength="1" pattern="[0-9]" class="otp-input" required />
                                        </div>
                                    </div>
                                    <div class="alert" id="messageotp" ></div>
                                </div>
                            </div>
                            <!--#------------------------------>
                             <style>
                                .input-bottom-lines {
                                    border: none !important;
                                    border-bottom: 2px solid #000 !important; /* Bottom border only */
                                    outline: none !important;
                                    width: 100% !important;
                                    font-size: 16px !important;
                                    padding: 5px 0 !important;
                                    background: transparent !important;
                                    border-radius: unset !important;
                                }
                        
                                .input-bottom-lines:focus {
                                    border-bottom: 2px solid #007bff; /* Blue bottom border on focus */
                                }
                        
                        
                                
                            </style>
                            <div id="additionalDetails" class="ml-2" style="display:none" >
                                <h6>Please fill your name & date of birth & age & gender </h6>
                                <div class="row ">
                                    <input type="text" id="name" placeholder="Enter your name" required class="input-bottom-lines col-5 mr-2"/>
                                    <input type="date" id="dob" required class="col-5 input-bottom-lines" />
                                    <input type="number" id="userage" placeholder="Enter your age" required class="input-bottom-lines col-5 mr-2"/>
                                    <div class="col-5 gender-container pt-3">
                                        
                                        <label><input type="radio" name="usergender" value="Male" required> Male</label>
                                        <label><input type="radio" name="usergender" value="Female" required> Female</label>
                                        <label><input type="radio" name="usergender" value="Other" required> Other</label>
                                    </div>
                                    
                                </div>
                                
                                <!--<select id="gender">-->
                                <!--    <option value="">Select Gender</option>-->
                                <!--    <option value="male">Male</option>-->
                                <!--    <option value="female">Female</option>-->
                                <!--</select>-->
                                
                            </div>

                           
                            <div class="row" style="display: flex;justify-content: right; margin-top:10px;margin-bottom:10px;">
                                <button type="submit" id="sendotpButton" class="theme-btn-one mr-5 phone" >CONTINUE</button>        
                                <button type="submit" id="verifyButton" class="theme-btn-one mr-5 otp" >CONTINUE</button>
                                <button type="submit" id="saveDetails" class="theme-btn-one mr-5">CONTINUE</button>
                                    
                            </div>
                            @endif
                            
                        </div>
                     </div>
                  </div>
               <div class="panel panel-default">
                     <div class="panel-heading" role="tab" id="heading2">
                        <h4 class="panel-title">
                           @if(Auth::id())
                           <a role="button" class="text-decoration" data-parent="#accordion" data-toggle="collapse"  href="#collapse2" aria-expanded="true" aria-controls="collapse2"><i class="fa fa-address-card checkicon"></i>{{__('message.Add Member')}}</a>
                           @else
                           <a role="button" class="text-decoration" data-toggle="collapse"  href="javascript::void(0)" aria-expanded="true" aria-controls="collapse2"><i class="fa fa-address-card checkicon"></i>{{__('message.Add Member')}}</a>
                           @endif
                        </h4>
                     </div>
                     <div id="collapse2" class="panel-collapse collapse {{ Auth::check() ? 'show' : '' }}" role="tabpanel" aria-labelledby="heading2">
                        <div class="panel-body">
                            <!--#------------------------->
                            <div class="row memberapend">
                                <!-- Div A: Card with light shading -->
                                
                                <input type="hidden" name="type" id="book_type" value="{{ $new_card_data['test_type'] }}">
                                <input type="hidden" name="book_type_id" id="book_type_id" value="{{ $new_card_data['test_id'] }}">
                                <input type="hidden" name="parameter" id="parameter" value="{{ $new_card_data['parameter'] }}">
                                @foreach($getfamilymemenber as $row)
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <div class="card-box-member">
                                        <div class="row">
                                            <!-- Left: Radio button -->
                                            <div class="col-2">
                                                <input type="checkbox"  @if(empty($new_card_data['test_id'])) disabled @endif 
                                                id="family_member" name="family_member[]" onclick="this.checked ? addmemberitemoncart(this) : rvmmemberitemoncart(this)" value="{{ $row->id }}" id="member_{{ $row->id }}" class="yellow-radio">
                                            </div>
                            
                                            <!-- Right: Member name and icon -->
                                            <div class="col-10">
                                                
                                                <label for="member_{{ $row->id }}" style="margin: 0;">
                                                    <span class="hd-mem-avatar" aria-hidden="true">{{ strtoupper(substr(trim((string) $row->name), 0, 1)) ?: '?' }}</span>
                                                    <span class="hd-mem-info">
                                                    <b>{{ $row->name }}</b> <br>
                                                    {{$row->relation}}<br>
                                                    {{$row->gender}} | {{$row->age}}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!--#------------------------------>
                           
                            <div class="row " style="display: flex;justify-content: right; margin-top:10px;margin-bottom:10px;">
                            
                                <button type="button" data-toggle="modal" data-target="#add_members" id="address_submit_button"  class="checkout-btn theme-btn-one mr-5" >{{__("message.Add Member")}}</button>
                               <button type="button" class="checkout-btn theme-btn-one mr-5" onclick="opennewpanel(2,3)">{{__('message.Next')}}</button>
                            </div>
                            
                        </div>
                     </div>
                  </div>
                  
                  <div class="panel panel-default">
                     <div class="panel-heading" role="tab" id="heading3">
                        <h4 class="panel-title">
                           @if(Auth::id())
                           <a role="button"  class="text-decoration" data-parent="#accordion" data-toggle="collapse"  href="#collapse3" aria-expanded="true" aria-controls="collapse3"><i class="fa fa-address-card checkicon"></i>{{__('message.Add Sample Collection Address, Date & Time')}}</a>
                           @else
                           <a role="button" class="text-decoration" data-toggle="collapse"  href="javascript::void(0)" aria-expanded="true" aria-controls="collapse3"><i class="fa fa-address-card checkicon"></i>{{__('message.Add Sample Collection Address, Date & Time')}}</a>
                           @endif
                        </h4>
                     </div>
                     
                     <div id="collapse3" class="panel-collapse collapse {{ empty($new_card_data['test_id']) ? 'show' : '' }}"  role="tabpanel" aria-labelledby="heading3">
                         
                        <div class="panel-body">
                            <!--#------------------------->
                            <div class="row">
                                <!-- Div A: Card with light shading -->
                                <div class="col-md-6">
                                    <div id="cardA" class="col-12 card-box"><i class="fa fa-check" style="color:#FF9800;"></i>
                                         <span id="selectedAddress"></span>
                                    </div>
                                </div>
                        
                                <!-- Div B: Card with Dropdown -->
                                <div class="col-md-6">
                                   <div class="card-box">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" onclick="tgl();" aria-haspopup="true" aria-expanded="false">
                                                View Saved Address
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-address" aria-labelledby="dropdownMenuButton">
                                                @if(count($useraddress) > 0)
                                                    @foreach($useraddress as $ua)
                                                    <div class="dropdown-item">
                                                        <input type="radio" name="is_default_address" class="yellow-radio" onchange="tgl(); getlab('{{$ua->id}}'); " city="{{$ua->id}}" data-name="{{$ua->name}}" data-value="{{$ua->house_no}},{{$ua->apartment}},{{$ua->landmark}}, {{$ua->address}}, {{$ua->city}}, {{$ua->state}} - {{$ua->pincode}}" id="address{{$loop->index}}"
                                                        value="{{$ua->id}}" <?= isset($ua->is_default) && $ua->is_default == '1' ? 'checked="checked"' : '' ?>> 
                                                        <strong class="house-number">{{$ua->name}}</strong>
                                                        @php
                                                        $ads = $ua->house_no.', '.$ua->address.', '.$ua->city.', '.$ua->state.'-'.$ua->pincode;
                                                        @endphp
                                                        <p class="address-details">
                                                            {{$ads}}
                                                        </p>
                                                    </div>
                                                    @endforeach
                                                @else
                                                    <div class="dropdown-item">No saved addresses found</div>
                                                @endif
                                                <div class="dropdown-item">
                                                     <button  data-toggle="modal" data-target="#addaddressmodel" type="button" class="checkout-btn theme-btn-one" style="margin-left: 20%;margin-top:5px;">{{__('message.Add Address')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <!--#--------------------------->
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="card-box-city">
                                       <div class="col-12 form-group branchlab">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="card-box-city">
                                      <div class="col-12  form-group" >
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
                                    </div>
                                </div>
                            </div>
                            <!--#----------------------------->
                            <lable style="color:#1E4169;font-size:13px;">CHOOSE DATE & TIME FOR HOME SAMPLE COLLECTION *</lable>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>{{__('message.Select sample collection date')}}</label>
                                    <input type="date" name="collection_date" id="collection_date" class="underline-input form-control" min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6">
                                    <label>{{__('message.Select sample collection time')}}</label>
                                    <select name="collection_time" id="collection_time"  class="form-control select-input underline-select">
                                        <option value="">Select Time slot</option>
                                        @foreach ($timeslot as $slot)
                                            <?php 
                                                $time_in_am_pm = date("g:i A", strtotime($slot->timeslot));
                                                $isNextSlot = strtotime($slot->timeslot) > strtotime($timeAfterTwoHours);
                                            ?>
                                            <option value="{{ $slot->timeslot }}" {{ $isNextSlot && !$selected ? 'selected' : '' }}>
                                                {{ $time_in_am_pm }}
                                            </option>
                                            @php
                                                if ($isNextSlot && !$selected) $selected = true; // Mark the first next slot as selected
                                            @endphp
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!--#------------------------------>
                           
                            <div class="row " style="display: flex;justify-content: right; margin-top:10px;margin-bottom:10px;">
                               <button type="button" class="checkout-btn theme-btn-one" onclick="opennewpanel(3,4)">{{__('message.Next')}}</button>
                            </div>
                            
                        </div>
                     </div>
                  </div>
                  <!-------------------coupon--------------------------->
                  
                  <div class="panel panel-default">
                     <div class="panel-heading" role="tab" id="heading4">
                        <h4 class="panel-title">
                           @if(Auth::id())
                                 <a role="button" class="text-decoration" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapse4"><i class="fa fa-money"></i> {{__('message.Payment Option')}}</a>
                           @else
                                <a role="button" class="text-decoration"  data-parent="#accordion" href="javascript::void(0)" aria-expanded="true" aria-controls="collapse4"><i class="fa fa-money"></i> {{__('message.Payment Option')}}</a>
                           @endif
                        </h4>
                     </div>
                     <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                        <div class="panel-body">
                            <div class="card-box">
                                <lable style="font-size:13px;font-weight:700;">Available Wallet  Point :-  @if(Auth::id()) {{$wallet_points}} @endif 
                                 <br> Use Wallet point (Max 20% of Wallet point can be used)</lable><br>
                                 @php
                                                    $max_wallet_amt = ($wallet_points * 20) / 100;
                                                    $max_wallet_amount = number_format($max_wallet_amt, 2);
                                  @endphp
                                <div class="row">
                                  <div class="col-md-6">
                                        @if(Auth::id())
                                        <input type="number" style="font-size:13px;height:39px;" name="wallet_points" id="wallet_points" min="0" max="{{ $max_wallet_amount }}" class="form-control"  >
                                        @endif
                                  </div>
                                  <div class="col-md-6">
                                    <button class="wallet-btn theme-btn-one mt-1" onclick="toggleWallet()">
                                        Apply Wallet
                                    </button>
                                    </div>
                                </div>
                             </div>
                             <div class="card-box">
                                <lable style="font-size:13px;font-weight:700;">Apply Coupon</lable><br>
                                <div class="row">
                                  <div class="col-md-6">
                                        @if(Auth::id())
                                        <input type="hidden" id="cp_id">
                                        <input type="text" style="font-size:13px;height:39px;" id="cp_code"  class="form-control" >
                                        @endif
                                  </div>
                                  <div class="col-md-6">
                                    <button class="wallet-btn theme-btn-one mt-1" onclick="toggleWallet()">
                                        Add
                                    </button>
                                    </div>
                                </div>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#couponModal" style="color: red; font-size: 10px; text-decoration: underline;">Available Coupon</a>
                             </div>
                            
                           <div class="cc-selectors m-2">
                               <div class="row">
                                    <input id="payment_type_stripe " type="radio"   onchange="changeform(this.value)" name="payment_method" value="RAZORPAY" />
                                    <?php $stripe_img = asset("public/img/rz.png"); ?>
                                    <label class="drinkcard-ccs ml-2 mt-2" for="payment_type_stripe"><i data-lucide="credit-card"></i>UPI/ Credit Card/ Debit Card/ Netbanking</label>
                              
                              </div>
                               <div class="row">
                                   <input id="payment_type_cod" type="radio"  onchange="changeform(this.value)" name="payment_method" value="cod" />
                                 <?php $cod_img = asset("public/img/cod.png"); ?>
                                 <label class="drinkcard-csc ml-2 mt-2"  for="payment_type_cod"><i data-lucide="banknote"></i>Cash/ Card on Sample Collection</label>
                             
                             
                               </div>
                           </div>
                           <div id="cod_div">
                                <form action="{{route('book-order')}}" method="post" id="stripe-form-2"> 
                                 {{csrf_field()}}
                                        <input type="hidden" name="sample_collection_address_id" id="sample_collection_address_ids" >
                                        <input type="hidden" name="date" id="dates">
                                        <input type="hidden" name="time" id="times">
                                        <input type="hidden" name="member_id" class="member_id">
                                        <input type="hidden" name="coupon_id" class="coupon_id">
                                        <input type="hidden" name="coupon_dis" class="coupon_dis">
                                        <input type="hidden" name="wallet_point" class="wallet_point">
                                        <input type="hidden" name="visit_type" class="is_visit_type" value="0">
                                        <input type="hidden" name="subtotal" id="subtotals">
                                        <input type="hidden" name="tax" id="tax">
                                        <input type="hidden" name="final_total" id="final_totals">
                                        <input type="hidden" name="payment_type" id="payment_type" value="cod">
                                        {{-- Cart items will be injected here --}}
                                        <div class="cart_items_hidden"></div>
                                        <div class="btn-box" id="btnappointment">
                                            <button class="theme-btn-one" type="submit">{{__('message.Book Now')}}<i class="icon-Arrow-Right"></i></button>       
                                        </div>
                                        <div class="hd-checkout-trust" aria-hidden="false">
                                            <span><i data-lucide="shield-check"></i>Secure Payment</span>
                                            <span><i data-lucide="lock"></i>SSL Protected</span>
                                            <span><i data-lucide="badge-check"></i>NABL Certified Labs</span>
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
             @if(isset($selectedtest->name))
             @php
                /* Display-only breakdown of the selected test/package so pricing
                   is visible immediately on load. Handles either column order:
                   the lower of price/mrp is the selling price. */
                $hdSelPrice = (float) ($selectedtest->price ?? 0);
                $hdSelMrp = (float) ($selectedtest->mrp ?? 0);
                $hdSelFinal = $hdSelMrp > 0 ? $hdSelMrp : $hdSelPrice;
                $hdSelOriginal = 0;
                $hdSelDiscountPer = 0;
                $hdSelDiscountAmt = 0;
                if ($hdSelPrice > 0 && $hdSelMrp > 0 && round($hdSelPrice) != round($hdSelMrp)) {
                    $hdSelFinal = min($hdSelPrice, $hdSelMrp);
                    $hdSelOriginal = max($hdSelPrice, $hdSelMrp);
                    $hdSelDiscountAmt = $hdSelOriginal - $hdSelFinal;
                    $hdSelDiscountPer = round(100 * $hdSelDiscountAmt / $hdSelOriginal);
                }
             @endphp
             <div class="clinic-sidebar">
               <div class="form-widget">
                  <div class="form-title">
                     <h3 style="font-size:16px;">Selected Test/Package</h3>
                     <span style="color:white;">{{$selectedtest->name}} </span>
                  </div>
                  <ul class="hd-sel-breakdown">
                     @if($hdSelOriginal > 0)
                     <li>
                        <span>Original Price</span>
                        <span class="hd-sel-strike">{{$currency ?? '₹'}}{{ number_format($hdSelOriginal, 2, '.', '') }}</span>
                     </li>
                     <li>
                        <span>Discount <em class="hd-sel-badge">{{ $hdSelDiscountPer }}% OFF</em></span>
                        <span class="hd-sel-save">- {{$currency ?? '₹'}}{{ number_format($hdSelDiscountAmt, 2, '.', '') }}</span>
                     </li>
                     @endif
                     <li>
                        <span>Final Price</span>
                        <span>{{$currency ?? '₹'}}{{ number_format($hdSelFinal, 2, '.', '') }}</span>
                     </li>
                     <li class="hd-sel-note">
                        <span>Home Collection Charge</span>
                        <span>Calculated after address selection</span>
                     </li>
                     <li class="hd-sel-total">
                        <span>Total Payable</span>
                        <span>{{$currency ?? '₹'}}{{ number_format($hdSelFinal, 2, '.', '') }}</span>
                     </li>
                  </ul>
                  <p class="hd-sel-hint"><i data-lucide="info"></i>Select a family member above to add this to your cart.</p>
                </div>
             </div>
             @endif
            <div class="clinic-sidebar">
               <div class="form-widget">
                  <div class="form-title">
                     <h3 style="font-size:17px;">{{__('message.CART DETAILS')}}</h3>
                     <p></p>
                  </div>
                     <?php $total = 0; ?>
                     <div id="member_on_cart" >
                     @if(count($cartdata)>0)
                     @foreach($cartdata as $cm)
                        <div class="col-xl-12 col-lg-12 col-md-12 doctors-block member_Cart" id="cart_member_{{$cm['member_id']}}">
                           <div class="team-block-three" >
                              <div class="inner-box">
                                 <div class="lower-content"  style="padding-top: 5px;padding-bottom: 5px;">
                                    <ul class="name-box clearfix">
                                       <li class="name">
                                          <h5><a href="#">{{$cm['member_name']}} | {{$cm['relation']}}</a></h5>
                                       </li>
                                    </ul>
                                    <span class="designation">{{$cm['gender']}}, {{$cm['age']}} years</span>
                                    
                                    @foreach($cm['testdata'] as $item)
                                        <?php 
                                        // print_r($cm);
                                        // die();
                                        $discount = 0;$per=0; 
                                        if ($item['price'] > 0 ) {
                                                $discount = 100 * ($item['price'] - $item['mrp']) / $item['price']; 
                                            
                                        }
    
                                        ?>
                                    <div class="row cart-item"  id="member_{{$item['id']}}" 
                                             data-typeid="{{$item['type_id']}}"
                                             data-parameter="{{$item['parameter']}}"
                                             data-family_member_id="{{$cm['member_id']}}"
                                             data-type="{{$item['type']}}" 
                                             data-price="{{$item['price']}}" data-mrp="{{$item['mrp']}}" 
                                             id="member_{{$item['id']}}" style="border-top: 1px solid white;">
                                       <div class="col-md-9">
                                          <p style="color: #ffffff;">{{$item['test_name']}}<br>
                                          <small>Parameters Included : {{$item['parameter']}}</small></p>
                                          @if($item['price'] > 0 )
                                          <p><span style="text-decoration:line-through;color:#f9f9f9;" > {{$item['price']}}</span> |
                                                <span style="color:#fff;" >{{  $item['mrp'] }}</span></p></div>
                                          @else
                                          <p><span style="color:#fff;" > {{$item['mrp']}}</span></p></div>
                                          @endif
                                       <?php 
                                        $total = $total +  $item['mrp']; 
                                       ?>
                                       <div class="col-md-3" >
                                            @if($discount > 0.00 ) 
                                            <p style="margin-top: 8px;margin-bottom: 19px;">
                                              <span style="background: green;color: white;    padding: 2px;">{{round($discount)}}%</span>
                                            </p>
                                            @endif
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
                                       <div class="col-6">
                                          <h3 style="font-size:16px;"><a href="#">{{__('message.Sub Total')}}</a></h3>
                                       </div>
                                       <div class="col-6">
                                          <p class=" text-white" style="float: right;font-size:16px;">{{$currency}}<span id="subtotal">{{number_format($total,2,'.','')}}</span></p>
                                       </div>
                                    </div>
                                 </li>
                                 <li class="name" style="display: list-item;">
                                    <div class="row">
                                       <div class="col-6">
                                          <h3 style="font-size:16px;"><a href="#">Coupon Discount</a></h3>
                                       </div>
                                       <div class="col-6">
                                          <p class=" text-white" style="float: right;font-size:16px;">{{$currency}}<span id="discount">0</span></p>
                                       </div>
                                    </div>
                                 </li>
                                 <li class="name" style="display: list-item;">
                                    <div class="row">
                                       <div class="col-8">
                                          <h3 style="font-size:16px;"><a href="#">Wallet Point Discount</a></h3>
                                       </div>
                                       <div class="col-4">
                                          <p class=" text-white" style="float: right;font-size:16px;">{{$currency}}<span id="wal_discount">0</span></p>
                                       </div>
                                    </div>
                                 </li>
                                 
                                 <li class="name" style="display: list-item;">
                                    <div class="row">
                                       <div class="col-6">
                                          <h3 style="font-size:16px;"><a href="#">{{__('message.Total')}}</a></h3>
                                       </div>
                                       <div class="col-6">
                                          <?php $final_total = $total; ?>
                                          <p class=" text-white" style="float: right;font-size:16px;">{{$currency}}<span id="main_total">{{number_format($final_total,2,'.','')}}</span></p>
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
<div class="modal fade hd-form-modal" id="addmember">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__('message.Add New Family Member')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="" id="addmembersForms" method="post" class="">
         <!-- Modal body -->
         <div class="modal-body">
            
               <div class="row clearfix">
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>{{__('message.Relation')}}</label>
                     <select  name="relation" required>
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
<div class="modal fade hd-form-modal" id="addaddressmodel">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__('message.Add New Address')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <form  id="user_address_data">
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
                     <label>Save As</label>
                     <select name="name">
                         <option>Home</option>
                         <option>Work</option>
                         <option>Other</option>
                     </select>
                  </div>
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>House No./ Flat No.</label>
                     <input type="text" name="house_no" id="house_no" placeholder="Enter House No./ Flat No." required="">
                  </div>
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>Apartment/Building Name/Colony</label>
                     <input type="text" name="apartment" id="apartment" placeholder="Enter Apartment/Building Name/Colony" required="">
                  </div>
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label>Landmark</label>
                     <input type="text" name="landmark" id="landmark" placeholder="Enter Landmark" required="">
                  </div>
                  <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                     <label>City</label>                     
                     <!--<input type="text" name="city" id="house_no"  required="">-->
                     <select  name="city" required="" >
                              <option value="">{{__("message.Select City")}}</option>
                              @foreach($city as $c)
                                   <option value="{{$c->id}}">{{$c->name}}</option>
                              @endforeach
                        </select>  
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
         <button type="button" onclick="addmemberaddressdatas()" class="btn btn-success">{{__('message.Add Address')}}</button>
         </div>
         </form>
      </div>
    </div>
</div>
<div class="modal fade hd-form-modal" id="add_members">
   <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{__("message.Add New Family Member")}}</h4>
                <button type="button"  class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="#" method="post" id="member_form" >
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <label>{{__("message.Relation")}}<span class="error">*</span></label>
                            <select class="form-control" name="relation" id="relation" required>
                                <option value="">{{__("message.Select Relation")}}</option>
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
                            <span id="error_relation" class="error"></span>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <label>{{__("message.Name")}}<span class="error">*</span></label>
                            <input type="text" name="name" id="member_name"   placeholder="{{__('message.Enter Name')}}" required="">
                            <span id="error_name" class="error"></span>
                        </div>
                       
                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <label>{{__("message.Phone")}}<span class="error">*</span></label>
                            <input type="text" name="phone" id="member_phone"
                                placeholder="{{__('message.Enter Phone')}}" required="">
                            <span id="error_phone" class="error"></span>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <label>{{__("message.Age")}}<span class="error">*</span></label>
                            <input type="number" name="age" id="member_age"
                                placeholder="{{__('message.Enter Age')}}" required="">
                            <span id="error_age" class="error"></span>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                            <label>{{__("message.Gender")}}<span class="error">*</span></label>
                            <div class="custom-check-box">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control material-checkbox">
                                        <input type="radio" name="gender" id="gender_1" value="Male"
                                            class="material-control-input">
                                        <span class="material-control-indicator"></span> <span
                                            class="description">{{__("message.Male")}}</span> </label>
                                </div>
                            </div>
                            <div class="custom-check-box">
                                <div class="custom-controls-stacked">
                                    <label class="custom-control material-checkbox">
                                        <input type="radio" name="gender" id="gender_2" value="Female"
                                            class="material-control-input">
                                        <span class="material-control-indicator"></span> <span
                                            class="description">{{__("message.Female")}}</span> </label>
                                </div>
                            </div>
                            <span id="error_gender" class="error"></span>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="addmemberdatas()">{{__("message.Add Member")}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Structure -->
<div class="modal fade hd-form-modal" id="couponModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="couponModalLabel">Available Coupons</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div class="cards-container row">
                    @foreach($coupon as $cp)
                    <div class="cardcp col-4 col-sm-3 col-6" id="coupon{{ $cp->id }}">
                        <div class="coupon-code">{{ $cp->coupon_code }}</div>
                        <div class="coupon-value">{{ $cp->coupon_value }} 
                            @if($cp->coupon_type == 'percent' ) % @else Rs @endif off On
                        </div>
                        <div class="coupon-type">
                            @if($cp->type == 4) {{ 'All'}} @endif 
                            @if($cp->type == 1) {{ 'Package'}} @endif
                            @if($cp->type == 3) {{ 'Profile' }} @endif 
                            @if($cp->type == 2) {{ 'Parameter' }} @endif
                        </div>
                        <div class="coupon-type">{{ $cp->day }}</div>
                        <?php $price = 0; ?>
                        <button class="apply-button" onclick="toggleCoupon('{{ $cp->id }}', '{{ $price }}', '{{ $cp->coupon_type }}', '{{ $cp->coupon_value }}','{{$cp->coupon_code}}')">
                            {{ $cp->is_applied ? 'Applied' : 'Apply Coupon' }}
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<style>
    .theme-btn-one{
        padding:6px 18px;
        font-size:14px;
        box-shadow:0 0px 0px #233646 !important;
    }
</style>
@stop
@section('footer')
<script>
    function getlab(city) {
        var cityId = city;
        // Perform the AJAX request
        $.ajax({
            url: '/get-users-by-city/' + cityId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // console.log(data.length);
                if(data.length < 1){
                    alert('Lab not available at this location !')
                }
                var optionsHTML = ' <label>Select Lab</label><select  class="form-control select-input underline-select" name="member_ids" id="branchid" onchange="selectlab()" >';
                // Generate HTML for options based on the received data
                $.each(data, function (index, user) {
                     var isSelected = user.default === "Yes";
                      optionsHTML += '<option value="' + user.id + '" ' + (isSelected ? 'selected' : '') + '>' + user.name + '</option>';
                });
                  optionsHTML += '</select>';
                // Set the HTML for the <select> element
                $('.branchlab').html(optionsHTML);
                
                var member = data?.[0]?.id ?? null;
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
   function changeform(val){
       
      var errro_msg_for_add = $(".errro_msg_for_add").val();
      var errro_msg_for_date  = $(".errro_msg_for_date").val();
      var errro_msg_for_time  = $(".errro_msg_for_time").val();

      var sample_collection_address_id = $('input[name="is_default_address"]:checked').val();
      var date = $("#collection_date").val();
      var time = $("#collection_time").val();
      var subtotal = $('#subtotal').html();
      if(subtotal < 1){
          alert('Please select test first!!');
          return;
      }
      var tax = 0;
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
        //   console.log(val);
        // if(val != 'cod'){
        //      $("#stripe_div").css("display","block");
        //      $("#cod_div").css("display","none");
        // }
        // if(val == 'cod'){
        //      $("#stripe_div").css("display","none");
        //      $("#cod_div").css("display","block");
        // }
             $("#sample_collection_address_ids").val(sample_collection_address_id);
             $("#dates").val(date);
             $("#times").val(time);
             $("#subtotals").val(subtotal);
             $("#payment_type").val(val);
             $("#tax").val(tax);
             $("#final_totals").val(final_total);
      }
   }
  
  
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
<script>
        function togglevisit(visit) {
            
        $(".is_visit_type").val(visit);
        
        }
        function toggleWallet() {
            
        var wallet_points = $("#wallet_points").val();
        var wallet_cashback_point = <?php echo $walletsetting->wallet_cashback_point; ?> ;
        var discount = wallet_points / wallet_cashback_point;
                // Disable button if the entered value is the maximum allowed
        var walletpoints = parseFloat($("#wallet_points").val());  // Convert to number
        var maxPoints = parseFloat(document.getElementById('wallet_points').max);

        if(walletpoints > maxPoints) {
            alert('please enter valid points!')
            return;
        } 
        
        $(".wallet_point").val(wallet_points);
         var cp_discount = parseFloat($("#discount").html()) || 0; // Convert to float, default to 0 if NaN
        var sub_ttl = parseFloat($("#subtotal").html()) || 0;
        var final_total = sub_ttl - cp_discount - discount ;
        
        
        $("#wal_discount").html(discount.toFixed(2));
        $("#main_total").html(final_total.toFixed(2));
        
        }
        
        function toggleCoupon(couponId,price,type,value,code) {
            let cartItems = [];
            $(".cart-item").each(function () {
                cartItems.push({
                    type_id: $(this).data("typeid"),   // backend needs type_id
                    type: $(this).data("type"),   // Package / Parameter / Profile
                    price: parseFloat($(this).data("price")) || 0,
                    mrp: parseFloat($(this).data("mrp")) || 0
                });
            });
            console.log("---->");
            console.log(cartItems);
            // return;
            var  subtotal = parseFloat($("#subtotal").html()) || 0;
             $("#cp_code").val(code);
            $.ajax({
            url: '/applycoupon/',
            type: 'GET',
            data: {
                code: code,
                subtotal: subtotal,
                cart: cartItems
            },
            dataType: 'json',
                success: function (data) {
                    closemodal('couponModal');
                    var wal_discount = parseFloat($("#wal_discount").html()) || 0; // Convert to float, default to 0 if NaN
               
                    var final_total = subtotal - wal_discount - data ;
                    $("#discount").html(data);
                    $("#main_total").html(final_total.toFixed(2));
                    $(".coupon_id").val(couponId);
                    $(".coupon_dis").val(data);
                    
                },
            });
        }
    document.getElementById("collection_date").onchange = function() {
        updateTimeSlots();
    };
    
    document.getElementById("collection_time").onchange = function() {
        validateDateTime();
    };
    
    function updateTimeSlots() {
        var selectedDate = document.getElementById("collection_date").value;
        var timeSelect = document.getElementById("collection_time");
        var now = new Date();
        var currentTime = now.getHours() + ":" + now.getMinutes(); // Current time in "HH:mm" format
    
        timeSelect.innerHTML = '<option value="">Select Time slot</option>'; // Reset time slots
    
        let firstSlotAdded = false; // To track if the first slot has been added
    
        @foreach ($timeslot as $slot)
            var slotTime = "{{ $slot->timeslot }}";
            var slotTimeFormatted = new Date(now.toDateString() + ' ' + slotTime);
    
            // If the selected date is today, disable time slots before the current time + 2 hours
            if (selectedDate === now.toISOString().split('T')[0]) {
                var timeAfterTwoHours = new Date(now.getTime() + 2 * 60 * 60 * 1000); // Current time + 2 hours
    
                if (slotTimeFormatted > timeAfterTwoHours) {
                    var option = new Option('{{ date("g:i A", strtotime($slot->timeslot)) }}', '{{ $slot->timeslot }}');
                    timeSelect.add(option);
    
                    // Automatically select the first available future time slot
                    if (!firstSlotAdded) {
                        option.selected = true; // Select the first valid slot
                        firstSlotAdded = true; // Mark that the first slot has been added
                    }
                }
            } else {
                // For future dates, allow all time slots
                var option = new Option('{{ date("g:i A", strtotime($slot->timeslot)) }}', '{{ $slot->timeslot }}');
                timeSelect.add(option);
    
                // Automatically select the first time slot for future dates
                if (!firstSlotAdded) {
                    option.selected = true; // Select the first slot
                    firstSlotAdded = true; // Mark that the first slot has been added
                }
            }
        @endforeach
    
        // Check if it's past 7 PM and the selected date is today
        if (selectedDate === now.toISOString().split('T')[0] && now.getHours() >= 19) {
            // Automatically move to the next day's first slot
            document.getElementById("collection_date").value = new Date(now.setDate(now.getDate() + 1)).toISOString().split('T')[0];
            alert('It\'s past 7 PM. Please select a slot for the next day.');
            updateTimeSlots();
        }
    }
    function validateDateTime(event) {
        var selectedDate = document.getElementById("collection_date").value;
        var selectedTime = document.getElementById("collection_time").value;
    
        if (!selectedDate || !selectedTime) {
            alert('Please select both date and time.');
            event.preventDefault();
            return false;
        }
    
        var selectedDateTime = new Date(selectedDate + ' ' + selectedTime);
        var currentDateTime = new Date();
    
        if (selectedDateTime <= currentDateTime) {
            alert('Please select a future date and time.');
            document.getElementById("collection_time").selectedIndex = 0;
            event.preventDefault();
            return false;
        }
        return true;
    }
    // Attach the event listener to the form's submit event
    document.getElementById("payment-form").addEventListener("submit", validateDateTime);
    document.getElementById("stripe-form").addEventListener("submit", validateDateTime);
    document.getElementById("stripe-form-2").addEventListener("submit", validateDateTime);
</script>

<script>
    // Update the selected address in Div A when an address is chosen in the dropdown
    $('input[name="is_default_address"]').change(function() {
        var selected = $('input[name="is_default_address"]:checked').val(); 
        var selectedval = $('input[name="is_default_address"]:checked').attr('data-value');
        var selectedname = $('input[name="is_default_address"]:checked').attr('data-name'); // Corrected method name
         var html = "<strong class='house-number-select'>" + selectedname + "</strong><br> " + selectedval;
        // Use .html() to set HTML content
        $('#selectedAddress').html(html);
    });
    
     $(document).ready(function() {
        var defaultCity = $('input[name="is_default_address"]:checked').attr('city');
        var selected = $('input[name="is_default_address"]:checked').val(); 
        var selectedval = $('input[name="is_default_address"]:checked').attr('data-value');
        var selectedname = $('input[name="is_default_address"]:checked').attr('data-name'); // Corrected method name
        
        if (defaultCity) {
              getlab(defaultCity);
        } else {
            selectedname='Please Select Address';
            selectedval = '';
            
        }
        var html = "<strong class='house-number-select'>" + selectedname + "</strong><br> " + selectedval;
        $('#selectedAddress').html(html);
      
         let num ;
         $('.otp').hide();
         $('#saveDetails').hide();
        $('#sendotpButton').click(function() {
            var phone = $('#phone').val();
            num = phone;
            $.ajax({
                url: '/otpsend',
                type: 'GET',
                data: { phone:phone },
                success: function(response) {
                   
                    if (response.success) {
                        $('.phone').hide();
                        $('.otp').show();
                        $('#num').html(num);
                        $('#messageotp').removeClass('alert-danger').addClass('alert-success').text('OTP send successfuly!');
                    } else {
                        $('.phone').show();
                        $('.otp').hide();
                         $('#num').html('');
                    }
                },
                error: function() {
                    alert('An error occurred during OTP verification');
                }
            });
        });
        $('#saveDetails').click(function() {
            var name = $('#name').val();
            var dob = $('#dob').val();
            var age = $('#userage').val();
            var usergender = $('input[name="usergender"]:checked').val();
           
            $.ajax({
                url: '/save_user_details',
                type: 'get',
                data: { name: name, dob: dob ,age:age,gender:usergender },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.success) {
                        window.location.reload();
                    } else {
                        alert('Failed to save details.');
                    }
                },
                error: function() {
                    alert('An error occurred while saving details.');
                }
            });
        });

        $('#verifyButton').click(function() {
            var otp = $('#otp-1').val() + $('#otp-2').val() + $('#otp-3').val() + $('#otp-4').val();
            $.ajax({
                url: '/otpverify',
                type: 'GET',
                data: { otp: otp,phone:num},
                success: function(response) {
                    // console.log(response);
                    if (response.success) {
                        if (response.new_user) {
                            // Show new user form
                            $('.otp').hide();
                            $('#additionalDetails').show();
                            $('#saveDetails').show();
                        } else {
                            window.location.reload(); 
                        }
                    } else {
                        $('#messageotp').removeClass('alert-success').addClass('alert-danger').text('Invalid OTP.');
                    }
                },
                error: function() {
                    alert('An error occurred during OTP verification');
                }
            });
        });
        
    });
    const otpInputs = document.querySelectorAll('.otp-input');

    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (input.value.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus(); // Automatically focus the next input
            }
        });
    
        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && input.value.length === 0 && index > 0) {
                otpInputs[index - 1].focus(); // Move back on backspace
            }
        });
    });
    
    function addmemberaddressdatas(){
        // console.log('test--------------->>>>>>>');
        // return;
        $.ajax({
            type: 'GET',
            url: $("#url_path").val()+'/update_user_address_ajax', // Get the form action URL
            data: $('#user_address_data').serialize(),
            success: function(response) {
                debugger;
                if (response.success) {
                    closemodal('addaddressmodel');
                        // Append the new address to the dropdown and select it
                        let newAddress = `
                        <div class="dropdown-item">
                            <input type="radio" name="is_default_address" class="yellow-radio" 
                                   onchange="getlab('${response.address.id}')" city="${response.address.id}" 
                                   data-name="${response.address.name}" 
                                   data-value="${response.address.house_no}, ${response.address.apartment}, ${response.address.landmark}, ${response.address.address}, ${response.address.city}, ${response.address.state} - ${response.address.pincode}" 
                                   id="address${response.address.id}" value="${response.address.id}" checked /> 
                            <strong class="house-number">${response.address.name}</strong>
                            <p class="address-details">${response.address.house_no}, ${response.address.apartment}, ${response.address.landmark}, ${response.address.address}, ${response.address.city}, ${response.address.state} - ${response.address.pincode}</p>
                        </div>
                        `;
                        $('.dropdown-menu-address').prepend(newAddress); // Prepend the new address to the dropdown menu

                        // Automatically select and display the new address
                        $('input[name="is_default_address"]').last().prop('checked', true).change(); // Check the newly added address and trigger change event
                        var selected = $('input[name="is_default_address"]:checked').val(); 
                        var selectedval = $('input[name="is_default_address"]:checked').attr('data-value');
                        var selectedname = $('input[name="is_default_address"]:checked').attr('data-name'); 
                        var html = "<strong class='house-number-select'>" + selectedname + "</strong><br> " + selectedval;
                        $('#selectedAddress').html(html);

                        $('#user_address')[0].reset(); // Reset the form
                    }
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Handle errors
            }
        });
     }
  function tgl(){
    $('.dropdown-menu').toggle();
    }
document.getElementById('collection_date').addEventListener('click', function () {
    this.showPicker(); // For modern browsers that support showPicker
});
function prepareCartItemsForForm() {
    let hiddenContainer = $(".cart_items_hidden");
    hiddenContainer.empty(); 

    $(".cart-item").each(function (index) {
        let typeId = $(this).data("typeid");
        let type = $(this).data("type");
        let price = parseFloat($(this).data("price")) || 0;
        let mrp= parseFloat($(this).data("mrp")) || 0;
        let family_member_id = $(this).data("family_member_id") || 0;
        let parameter = $(this).data("parameter")  || 0;

        hiddenContainer.append(`
            <input type="hidden" name="cart[${index}][type_id]" value="${typeId}">
            <input type="hidden" name="cart[${index}][type]" value="${type}">
            <input type="hidden" name="cart[${index}][price]" value="${price}">
            <input type="hidden" name="cart[${index}][mrp]" value="${mrp}">
            <input type="hidden" name="cart[${index}][family_member_id]" value="${family_member_id}">
            <input type="hidden" name="cart[${index}][parameter]" value="${parameter}">
        `);
    });
}

// Run before submit
$("#stripe-form-2").on("submit", function () {
    prepareCartItemsForForm();
});

</script>
@stop