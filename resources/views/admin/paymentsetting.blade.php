@extends('admin.layout.index')
@section('title')
{{__("message.Payment Gateway Setting")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.Payment Gateway Setting")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.Payment Gateway Setting")}}</li>
         </ol>
      </nav>
   </div>
</div>

@if(Session::has('message'))
<div class="adm-toast-wrap">
   <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show adm-toast" role="alert">{{ Session::get('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
</div>
@endif

{{-- ============ Payment gateway card: pill tabs + one form per gateway ============ --}}
<div class="adm-form adm-form-page adm-form-page--wide">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
            {{__("message.Payment Gateway Setting")}}
         </div>
         <ul class="nav nav-tabs adm-cat-tabs" id="paymentTabs">
            <li class="nav-item"><a class="nav-link <?= Session::get("payment_next")==1?'active':''?>" data-bs-toggle="tab" href="#tab1">{{__("message.BrainTree")}}</a></li>
            <li class="nav-item"><a class="nav-link <?= Session::get("payment_next")==2?'active':''?>" data-bs-toggle="tab" href="#tab2">{{__("message.Razor Pay")}}</a></li>
            <li class="nav-item"><a class="nav-link <?= Session::get("payment_next")==3?'active':''?>" data-bs-toggle="tab" href="#tab3">{{__("message.PayStack")}}</a></li>
            <li class="nav-item"><a class="nav-link <?= Session::get("payment_next")==4?'active':''?>" data-bs-toggle="tab" href="#tab4">{{__("message.Paytm")}}</a></li>
            <li class="nav-item"><a class="nav-link <?= Session::get("payment_next")==5?'active':''?>" data-bs-toggle="tab" href="#tab5">{{__("message.Flutter Wave")}}</a></li>
         </ul>
      </div>
      <div class="tab-content">

         {{-- ============ Tab 1: BrainTree ============ --}}
         <div class="tab-pane <?= Session::get("payment_next")==1?'active':''?>" id="tab1">
            <form action="{{route('updategateway')}}" method="post">
               {{csrf_field()}}
               <input type="hidden" name="payment_gateway" value="braintree">
               <div class="row">
                  <div class="col-md-6 adm-field">
                     <label for="braintree_environment">{{__("message.environment")}}<span class="reqfield">*</span></label>
                     <select name="environment" id="braintree_environment" class="form-control" required="">
                        <option value="sandbox" <?= isset($arr['braintree_environment'])&&$arr['braintree_environment']=='sandbox'?"selected='selected'":''?>>{{__("message.sandbox")}}</option>
                        <option value="production" <?= isset($arr['braintree_environment'])&&$arr['braintree_environment']=='production'?"selected='selected'":''?>>{{__("message.Production")}}</option>
                     </select>
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="braintree_merchant_id">{{__("message.Merchant ID")}}<span class="reqfield">*</span></label>
                     <input type="text" id="braintree_merchant_id" name="merchant_id" class="form-control" required="" placeholder="{{__('message.Enter BrainTree Merchant ID')}}" value="{{isset($arr['braintree_merchant_id'])?$arr['braintree_merchant_id']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="braintree_public_key">{{__("message.Public Key")}}<span class="reqfield">*</span></label>
                     <input type="text" id="braintree_public_key" name="public_key" class="form-control" required="" placeholder="{{__('message.Enter BrainTree Public Key')}}" value="{{isset($arr['braintree_public_key'])?$arr['braintree_public_key']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="braintree_private_key">{{__("message.Private Key")}}<span class="reqfield">*</span></label>
                     <input type="text" id="braintree_private_key" name="private_key" class="form-control" required="" placeholder="{{__('message.Enter BrainTree Private Key')}}" value="{{isset($arr['braintree_private_key'])?$arr['braintree_private_key']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="braintree_tokenization_key">{{__("message.tokenization key")}}<span class="reqfield">*</span></label>
                     <input type="text" id="braintree_tokenization_key" name="tokenization_key" class="form-control" required="" placeholder="{{__('message.Enter BrainTree Tokenization Key')}}" value="{{isset($arr['braintree_tokenization_key'])?$arr['braintree_tokenization_key']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="braintree_is_active">{{__("message.Is Payment Gateway Is Active")}}<span class="reqfield">*</span></label>
                     <select name="is_active" id="braintree_is_active" class="form-control" required="">
                        <option value="1" <?= isset($arr['braintree_is_active'])&&$arr['braintree_is_active']=='1'?"selected='selected'":''?>>{{__("message.Yes")}}</option>
                        <option value="0" <?= isset($arr['braintree_is_active'])&&$arr['braintree_is_active']=='0'?"selected='selected'":''?>>{{__("message.No")}}</option>
                     </select>
                  </div>
                  <div class="col-12 adm-form-actions">
                     <button type="submit" class="btn btn-success adm-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__("message.submit")}}
                     </button>
                  </div>
               </div>
            </form>
         </div>

         {{-- ============ Tab 2: Razorpay ============ --}}
         <div class="tab-pane <?= Session::get("payment_next")==2?'active':''?>" id="tab2">
            <form action="{{route('updategateway')}}" method="post">
               {{csrf_field()}}
               <input type="hidden" name="payment_gateway" value="razorpay">
               <div class="row">
                  <div class="col-md-6 adm-field">
                     <label for="razorpay_key">{{__("message.Key")}}<span class="reqfield">*</span></label>
                     <input type="text" id="razorpay_key" name="razorpay_key" class="form-control" required="" placeholder="{{__('message.Enter Razorpay Key')}}" value="{{isset($arr['razorpay_razorpay_key'])?$arr['razorpay_razorpay_key']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="razorpay_secert">{{__("message.Secert")}}<span class="reqfield">*</span></label>
                     <input type="text" id="razorpay_secert" name="razorpay_secert" class="form-control" required="" placeholder="{{__('message.Enter Razorpay Secert')}}" value="{{isset($arr['razorpay_razorpay_secert'])?$arr['razorpay_razorpay_secert']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="razorpay_is_active">{{__("message.Is Payment Gateway Is Active")}}<span class="reqfield">*</span></label>
                     <select name="is_active" id="razorpay_is_active" class="form-control" required="">
                        <option value="1" <?= isset($arr['razorpay_is_active'])&&$arr['razorpay_is_active']=='1'?"selected='selected'":''?>>{{__("message.Yes")}}</option>
                        <option value="0" <?= isset($arr['razorpay_is_active'])&&$arr['razorpay_is_active']=='0'?"selected='selected'":''?>>{{__("message.No")}}</option>
                     </select>
                  </div>
                  <div class="col-12 adm-form-actions">
                     <button type="submit" class="btn btn-success adm-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__("message.submit")}}
                     </button>
                  </div>
               </div>
            </form>
         </div>

         {{-- ============ Tab 3: PayStack ============ --}}
         <div class="tab-pane <?= Session::get("payment_next")==3?'active':''?>" id="tab3">
            <form action="{{route('updategateway')}}" method="post">
               {{csrf_field()}}
               <input type="hidden" name="payment_gateway" value="paystack">
               <div class="row">
                  <div class="col-md-6 adm-field">
                     <label for="paystack_public_key">{{__("message.Public Key")}}<span class="reqfield">*</span></label>
                     <input type="text" id="paystack_public_key" name="public_key" class="form-control" required="" placeholder="{{__('message.Enter PAYSTACK PUBLIC KEY')}}" value="{{isset($arr['paystack_public_key'])?$arr['paystack_public_key']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="paystack_secert_key">{{__("message.Secert Key")}}<span class="reqfield">*</span></label>
                     <input type="text" id="paystack_secert_key" name="secert_key" class="form-control" required="" placeholder="{{__('message.Enter PAYSTACK_SECRET_KEY')}}" value="{{isset($arr['paystack_secert_key'])?$arr['paystack_secert_key']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="paystack_is_active">{{__("message.Is Payment Gateway Is Active")}}<span class="reqfield">*</span></label>
                     <select name="is_active" id="paystack_is_active" class="form-control" required="">
                        <option value="1" <?= isset($arr['paystack_is_active'])&&$arr['paystack_is_active']=='1'?"selected='selected'":''?>>{{__("message.Yes")}}</option>
                        <option value="0" <?= isset($arr['paystack_is_active'])&&$arr['paystack_is_active']=='0'?"selected='selected'":''?>>{{__("message.No")}}</option>
                     </select>
                  </div>
                  <div class="col-12 adm-form-actions">
                     <button type="submit" class="btn btn-success adm-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__("message.submit")}}
                     </button>
                  </div>
               </div>
            </form>
         </div>

         {{-- ============ Tab 4: Paytm ============ --}}
         <div class="tab-pane <?= Session::get("payment_next")==4?'active':''?>" id="tab4">
            <form action="{{route('updategateway')}}" method="post">
               {{csrf_field()}}
               <input type="hidden" name="payment_gateway" value="paytm">
               <div class="row">
                  <div class="col-md-6 adm-field">
                     <label for="paytm_merchant_id">{{__("message.PAYTM MERCHANT ID")}}</label>
                     <input type="text" class="form-control" id="paytm_merchant_id" placeholder='{{__("message.Enter PAYTM MERCHANT ID")}}' name="merchant_id" value="{{isset($arr['paytm_merchant_id'])?$arr['paytm_merchant_id']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="merchant_key">{{__("message.PAYTM MERCHANT KEY")}}</label>
                     <input type="text" class="form-control" id="merchant_key" placeholder='{{__("message.Enter PAYTM MERCHANT KEY")}}' name="merchant_key" value="{{isset($arr['paytm_merchant_key'])?$arr['paytm_merchant_key']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="merchant_website">{{__("message.PAYTM MERCHANT WEBSITE")}}</label>
                     <input type="text" class="form-control" id="merchant_website" placeholder="{{__('message.Enter PAYTM MERCHANT WEBSITE')}}" name="merchant_website" value="{{isset($arr['paytm_merchant_website'])?$arr['paytm_merchant_website']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="paytm_environment">{{__("message.PAYTM ENVIRONMENT")}}</label>
                     <?php
                        $class1 = isset($arr['paytm_environment'])&&$arr['paytm_environment']=="local"?'selected':'';
                        $class2 = isset($arr['paytm_environment'])&&$arr['paytm_environment']=="production"?'selected':'';
                        ?>
                     <select name="environment" id="paytm_environment" class="form-control" required="">
                        <option value="local" {{$class1}}>{{__("message.Local")}}</option>
                        <option value="production" {{$class2}}>{{__("message.Production")}}</option>
                     </select>
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="channel">{{__("message.PAYTM CHANNEL")}}</label>
                     <input type="text" class="form-control" id="channel" placeholder='{{__("message.Enter PAYTM CHANNEL")}}' name="channel" value="{{isset($arr['paytm_channel'])?$arr['paytm_channel']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="industry_type">{{__("message.PAYTM INDUSTRY TYPE")}}</label>
                     <input type="text" class="form-control" id="industry_type" placeholder='{{__("message.Enter PAYTM INDUSTRY TYPE")}}' name="industry_type" value="{{isset($arr['paytm_industry_type'])?$arr['paytm_industry_type']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="paytm_is_active">{{__("message.Is Payment Gateway Is Active")}}<span class="reqfield">*</span></label>
                     <select name="is_active" id="paytm_is_active" class="form-control" required="">
                        <option value="1" <?= isset($arr['paytm_is_active'])&&$arr['paytm_is_active']=='1'?"selected='selected'":''?>>{{__("message.Yes")}}</option>
                        <option value="0" <?= isset($arr['paytm_is_active'])&&$arr['paytm_is_active']=='0'?"selected='selected'":''?>>{{__("message.No")}}</option>
                     </select>
                  </div>
                  <div class="col-12 adm-form-actions">
                     <button type="submit" class="btn btn-success adm-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__("message.submit")}}
                     </button>
                  </div>
               </div>
            </form>
         </div>

         {{-- ============ Tab 5: Flutter Wave (Rave) ============ --}}
         <div class="tab-pane <?= Session::get("payment_next")==5?'active':''?>" id="tab5">
            <form action="{{route('updategateway')}}" method="post">
               {{csrf_field()}}
               <input type="hidden" name="payment_gateway" value="rave">
               <div class="row">
                  <div class="col-md-6 adm-field">
                     <label for="rave_public_key">{{__("message.RAVE PUBLIC KEY")}}</label>
                     <input type="text" class="form-control" id="rave_public_key" placeholder='{{__("message.Enter RAVE PUBLIC KEY")}}' name="public_key" value="{{isset($arr['rave_public_key'])?$arr['rave_public_key']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="rave_secert_key">{{__("message.RAVE SECRET KEY")}}</label>
                     <input type="text" class="form-control" id="rave_secert_key" placeholder='{{__("message.Enter RAVE SECRET KEY")}}' name="secert_key" value="{{isset($arr['rave_secert_key'])?$arr['rave_secert_key']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="title">{{__("message.RAVE TITLE")}}</label>
                     <input type="text" class="form-control" id="title" placeholder='{{__("message.Enter RAVE TITLE")}}' name="title" value="{{isset($arr['rave_title'])?$arr['rave_title']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="rave_environment">{{__("message.RAVE_ENVIRONMENT")}}</label>
                     <select name="environment" id="rave_environment" class="form-control" required="">
                        <option <?= isset($arr['rave_environment'])&&$arr['rave_environment']=='staging'?"selected='selected'":''?> value="staging">{{__("message.staging")}}</option>
                        <option <?= isset($arr['rave_environment'])&&$arr['rave_environment']=='live'?"selected='selected'":''?> value="live">{{__("message.live")}}</option>
                     </select>
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="logo">{{__("message.RAVE LOGO URL")}}</label>
                     <input type="text" class="form-control" id="logo" placeholder='{{__("message.Enter RAVE LOGO URL")}}' name="logo" value="{{isset($arr['rave_logo'])?$arr['rave_logo']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="rave_is_active">{{__("message.Is Payment Gateway Is Active")}}<span class="reqfield">*</span></label>
                     <select name="is_active" id="rave_is_active" class="form-control" required="">
                        <option value="1" <?= isset($arr['rave_is_active'])&&$arr['rave_is_active']=='1'?"selected='selected'":''?>>{{__("message.Yes")}}</option>
                        <option value="0" <?= isset($arr['rave_is_active'])&&$arr['rave_is_active']=='0'?"selected='selected'":''?>>{{__("message.No")}}</option>
                     </select>
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="country">{{__("message.Country")}}</label>
                     <input type="text" class="form-control" id="country" placeholder='{{__("message.Country")}}' name="country" value="{{isset($arr['rave_country'])?$arr['rave_country']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="rave_currency">{{__("message.Currency")}}</label>
                     <input type="text" class="form-control" id="rave_currency" placeholder='{{__("message.Currency")}}' name="currency" value="{{isset($arr['rave_currency'])?$arr['rave_currency']:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="encryption_key">{{__("message.RAVE Encryption Key")}}</label>
                     <input type="text" class="form-control" id="encryption_key" placeholder='{{__("message.Enter RAVE Encryption Key")}}' name="encryption_key" value="{{isset($arr['rave_encryption_key'])?$arr['rave_encryption_key']:''}}">
                  </div>
                  <div class="col-12 adm-form-actions">
                     <button type="submit" class="btn btn-success adm-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__("message.submit")}}
                     </button>
                  </div>
               </div>
            </form>
         </div>

      </div>
   </div>
</div>
@endsection
