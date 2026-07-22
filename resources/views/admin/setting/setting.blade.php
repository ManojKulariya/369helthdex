@extends('admin.layout.index')
@section('title')
{{__("message.Setting")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.Settings")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.Settings")}}</li>
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

{{-- ============ Settings card: pill tabs + one form per tab ============ --}}
<div class="adm-form adm-form-page adm-form-page--wide">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2Z"/><circle cx="12" cy="12" r="3"/></svg>
            {{__("message.Settings")}}
         </div>
         <ul class="nav nav-tabs adm-cat-tabs" id="settingTabs">
            <li class="nav-item"><a class="nav-link <?= $id==1?'active':''?>" data-bs-toggle="tab" href="#tab1">{{__("message.Basic Information")}}</a></li>
            <li class="nav-item"><a class="nav-link <?= $id==2?'active':''?>" data-bs-toggle="tab" href="#tab2">{{__("message.Server Key")}}</a></li>
            <li class="nav-item"><a class="nav-link <?= $id==4?'active':''?>" data-bs-toggle="tab" href="#tab4">{{__("message.Website Setting")}}</a></li>
            <li class="nav-item"><a class="nav-link <?= $id==8?'active':''?>" data-bs-toggle="tab" href="#tab8">Wallet Setting</a></li>
            <li class="nav-item"><a class="nav-link <?= $id==9?'active':''?>" data-bs-toggle="tab" href="#tab9">About US</a></li>
            <li class="nav-item"><a class="nav-link <?= $id==10?'active':''?>" data-bs-toggle="tab" href="#tab10">Terms of Service</a></li>
            <li class="nav-item"><a class="nav-link <?= $id==11?'active':''?>" data-bs-toggle="tab" href="#tab11">Privacy Policy</a></li>
            <li class="nav-item"><a class="nav-link <?= $id==12?'active':''?>" data-bs-toggle="tab" href="#tab12">Franchise</a></li>
            <li class="nav-item"><a class="nav-link <?= $id==13?'active':''?>" data-bs-toggle="tab" href="#tab13">Refund Policy</a></li>
         </ul>
      </div>
      <div class="tab-content">

         {{-- ============ Tab 1: Basic Information ============ --}}
         <div class="tab-pane <?= $id==1?'active':''?>" id="tab1">
            <form action="{{route('savebasicsetting')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{$id}}">
               <div class="row">
                  <div class="col-12 adm-field">
                     <label class="custom-control custom-checkbox">
                        <input type="checkbox" name="is_rtl" <?= isset($data->is_rtl)&&$data->is_rtl=='1'?'checked="checked"':''?> id="is_rtl" value="1" class="custom-control-input">
                        <span class="custom-control-label"> {{__("message.Site RTL")}}</span>
                     </label>
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="logo_image">{{__("message.Logo")}}<span class="reqfield">*</span></label>
                     <?php
                        if(isset($data->logo)){
                            $path= env('APP_URL')."/public/img/".$data->logo;
                        }
                        else{
                            $path=asset('public/upload/default.jpg');
                        }
                        ?>
                     <div class="adm-upload">
                        <span class="adm-upload-thumb"><img src="{{$path}}" alt="..." id="basic_img_logo"></span>
                        <div class="adm-upload-control">
                           <input type="hidden" name="old_logo" id="old_logo" value="{{isset($data->logo)?$data->logo:''}}">
                           <input type="file" name="logo_image" class="form-control" id="logo_image" />
                           <span class="adm-upload-hint"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>PNG or JPG</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="favicon_image">{{__("message.Favicon")}}<span class="reqfield">*</span></label>
                     <?php
                        if(isset($data->favicon)){
                            $path= env('APP_URL')."/public/img/".$data->favicon;
                        }
                        else{
                            $path=asset('public/upload/default.jpg');
                        }
                        ?>
                     <div class="adm-upload">
                        <span class="adm-upload-thumb"><img src="{{$path}}" alt="..." id="basic_img_favicon"></span>
                        <div class="adm-upload-control">
                           <input type="hidden" name="old_favicon" id="old_favicon" value="{{isset($data->favicon)?$data->favicon:''}}">
                           <input type="file" name="favicon_image" class="form-control" id="favicon_image" />
                           <span class="adm-upload-hint"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>PNG or ICO</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="email">{{ __("message.Email Id") }}<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="email" name="email" placeholder="{{ __('message.Enter Email') }}" value="{{isset($data->email)?$data->email:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="phone">{{__("message.Phone")}}<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="phone" name="phone" placeholder="{{ __('message.Enter Phone') }}" value="{{isset($data->phone)?$data->phone:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="address">{{__("message.Address")}}<span class="reqfield">*</span></label>
                     <textarea required class="form-control" id="address" name="address" placeholder="{{ __('message.Enter Address') }}">{{isset($data->address)?$data->address:''}}</textarea>
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="currency">{{__("message.Currency")}}<span class="reqfield">*</span></label>
                     <select id="currency" name="currency" required="" class="form-control">
                        <option value="{{$data->currency}}" selected>{{$data->currency}}</option>
                        @include('admin.setting.currency')
                     </select>
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="txt_charge">{{__("message.Tax Charge")}}<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="txt_charge" name="txt_charge" placeholder="{{__('message.Enter Tax charge')}}" value="{{isset($data->txt_charge)?$data->txt_charge:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="timezone">{{__("message.Time Zone")}}<span class="reqfield">*</span></label>
                     <select id="timezone" name="timezone" required="" class="form-control">
                        <option value="">Select Timezone</option>
                        @foreach($timezone_list as $tz=>$value)
                        <option value="{{$tz}}" <?=$data->timezone ==$tz ? ' selected="selected"' : '';?>>{{$value}}</option>
                        @endforeach
                     </select>
                  </div>
                  <div class="col-12 adm-form-actions">
                     @if(Session::get("is_demo")==1)
                     <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__('message.Save')}}
                     </button>
                     @else
                     <button type="submit" class="btn btn-success adm-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__('message.Save')}}
                     </button>
                     @endif
                  </div>
               </div>
            </form>
         </div>

         {{-- ============ Tab 2: Server Key ============ --}}
         <div class="tab-pane <?= $id==2?'active':''?>" id="tab2">
            <form action="{{route('server_key')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{$id}}">
               <div class="row">
                  <div class="col-12 adm-field">
                     <label for="android_server_key">{{__("message.Android Server Key")}}<span class="reqfield">*</span></label>
                     <textarea required class="form-control" id="android_server_key" name="android_server_key" placeholder="{{__('message.Enter Android Server Key')}}">{{isset($data->android_server_key)?$data->android_server_key:''}}</textarea>
                  </div>
                  <div class="col-12 adm-field">
                     <label for="ios_server_key">{{__("message.Iphone Server Key")}}<span class="reqfield">*</span></label>
                     <textarea required class="form-control" id="ios_server_key" name="ios_server_key" placeholder="{{__('message.Enter Iphone Server Key')}}">{{isset($data->ios_server_key)?$data->ios_server_key:''}}</textarea>
                  </div>
                  <div class="col-12 adm-form-actions">
                     <button type="submit" class="btn btn-success adm-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__("message.Submit")}}
                     </button>
                  </div>
               </div>
            </form>
         </div>

         {{-- Tab 3 "Payment Detail" (Braintree/Stripe) intentionally has no nav link, exactly as
              before — the original file already had this <li> commented out, unreachable via the
              UI. Payment gateway configuration now lives in the separate, dedicated Payment
              Setting page (payment-setting route). Preserving the original, already-dead
              tab-pane markup unchanged rather than deleting or redesigning genuinely-unreachable
              code. --}}
         <div class="tab-pane <?= $id==3?'active':''?>" id="tab3" style="display:none;">
            <div class="tab-menu-heading p-0">
               <div class="tabs-menu ">
                  <ul class="nav panel-tabs">
                     <li class=""><a href="#tab_1" class="active" data-bs-toggle="tab">{{__("message.Braintree")}}</a></li>
                     <li><a href="#tab_2" data-bs-toggle="tab" class="">{{__("message.Stripe")}}</a></li>
                  </ul>
               </div>
            </div>
            <div class="panel-body tabs-menu-body">
               <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                     <form action="{{route('change-payment-detail')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="payment_method" value="Braintree">
                        <div class="col-sm-6 col-md-6">
                           <div class="form-group">
                              <label class="form-label">{{__("message.Status")}} <span class="reqfield">*</span></label>
                              <select name="status" class="form-control">
                                 <option value="1" <?= $payment['Braintree_is_active']=1?'selected':""?>>{{__("message.Active")}}</option>
                                 <option value="0" <?= $payment['Braintree_is_active']=0?'selected':""?>>{{__("message.Deactive")}}</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                           <div class="form-group">
                              <label class="form-label">{{__("message.Environment")}} <span class="reqfield">*</span></label>
                              <select required class="form-control" id="environment" name="environment" placeholder="{{__('message.Enter Environment')}}">
                                 <option <?= isset($payment['Braintree_environment'])&&$payment['Braintree_environment']=='sandbox'?'selected="selected"':''?> value="sandbox">{{__("message.sandbox")}}</option>
                                 <option <?= isset($payment['Braintree_environment'])&&$payment['Braintree_environment']=='live'?'selected="selected"':''?> value="live">{{__("message.live")}}</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                           <div class="form-group">
                              <label class="form-label">{{__("message.MerchantId")}} <span class="reqfield">*</span></label>
                              <input type="text" required class="form-control" id="merchantId" name="merchantId" placeholder="{{__('message.Enter MerchantId')}}" value="{{isset($payment['Braintree_merchantId'])?$payment['Braintree_merchantId']:''}}">
                           </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                           <div class="form-group">
                              <label class="form-label">{{__("message.PublicKey")}} <span class="reqfield">*</span></label>
                              <input type="text" required class="form-control" id="publicKey" name="publicKey" placeholder="{{__('message.Enter PublicKey')}}" value="{{isset($payment['Braintree_publicKey'])?$payment['Braintree_publicKey']:''}}">
                           </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                           <div class="form-group">
                              <label class="form-label">{{__('message.PrivateKey')}} <span class="reqfield">*</span></label>
                              <input type="text" required class="form-control" id="privateKey" name="privateKey" placeholder="{{__('message.Enter PrivateKey')}}" value="{{isset($payment['Braintree_privateKey'])?$payment['Braintree_privateKey']:''}}">
                           </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                           <div class="form-group">
                              <label class="form-label">{{__('message.Tokenization Keys')}} <span class="reqfield">*</span></label>
                              <input type="text" required class="form-control" id="TokenizationKeys" name="TokenizationKeys" placeholder="{{__('message.Enter Tokenization Keys')}}" value="{{isset($payment['Braintree_TokenizationKeys'])?$payment['Braintree_TokenizationKeys']:''}}">
                           </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                           <div class="card-footer text-end">
                              <input type="submit" value='{{__("message.Submit")}}' class="btn btn-success btn-lg">
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="tab-pane " id="tab_2">
                     <form action="{{route('change-payment-detail')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="payment_method" value="Stripe">
                        <div class="col-sm-6 col-md-6">
                           <div class="form-group">
                              <label class="form-label">{{__("message.Status")}} <span class="reqfield">*</span></label>
                              <select name="status" class="form-control">
                                 <option value="1" <?= $payment['Stripe_is_active']=1?'selected':""?>>{{__("message.Active")}}</option>
                                 <option value="0" <?= $payment['Stripe_is_active']=0?'selected':""?>>{{__("message.Deactive")}}</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                           <div class="form-group">
                              <label class="form-label">{{__("message.PublicKey")}} <span class="reqfield">*</span></label>
                              <input type="text" required class="form-control" id="public_key" name="public_key" placeholder="{{__('message.Enter PublicKey')}}" value="{{isset($payment['Stripe_public_key'])?$payment['Stripe_public_key']:''}}">
                           </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                           <div class="form-group">
                              <label class="form-label">{{__("message.Secert key")}} <span class="reqfield">*</span></label>
                              <input type="text" required class="form-control" id="secert_key" name="secert_key" placeholder="{{__('message.Enter Secert key')}}" value="{{isset($payment['Stripe_secert_key'])?$payment['Stripe_secert_key']:''}}">
                           </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                           <div class="form-group">
                              <label class="form-label">{{__("message.Currency")}} <span class="reqfield">*</span></label>
                              <input type="text" required class="form-control" id="currency" name="currency" placeholder="{{__('message.Enter Stripe currency')}}" value="{{isset($payment['Stripe_currency'])?$payment['Stripe_currency']:''}}">
                           </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                           <div class="card-footer text-end">
                              @if(Session::get("is_demo")==1)
                              <button type="button" class="btn btn-success" onclick="disablebtn()">{{__('message.Save')}}</button>
                              @else
                              <button type="submit" class="btn btn-success">{{__('message.Save')}}</button>
                              @endif
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>

         {{-- ============ Tab 4: Website Setting ============ --}}
         <div class="tab-pane <?= $id==4?'active':''?>" id="tab4">
            <form action="{{route('update-website-details')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{$id}}">
               <div class="row">
                  <div class="col-md-6 adm-field">
                     <label for="appstore_url">{{__("message.Appstore url")}}<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="appstore_url" name="appstore_url" placeholder="{{__('message.Enter Appstore url')}}" value="{{isset($data->appstore_url)?$data->appstore_url:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="playstore_url">{{__("message.Playstore url")}}<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="playstore_url" name="playstore_url" placeholder="{{__('message.Enter Playstore url')}}" value="{{isset($data->playstore_url)?$data->playstore_url:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="largest_phlebotomist">{{__("message.Phlebotomist")}}<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="largest_phlebotomist" name="largest_phlebotomist" placeholder="{{__('message.Enter Phlebotomist')}}" value="{{isset($data->largest_phlebotomist)?$data->largest_phlebotomist:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="satisfied_customers">{{__("message.Satisfied Customers")}}<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="satisfied_customers" name="satisfied_customers" placeholder="{{__('message.Enter Satisfied Customers')}}" value="{{isset($data->satisfied_customers)?$data->satisfied_customers:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="total_test">{{__("message.Total Test")}}<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="total_test" name="total_test" placeholder="{{__('message.Enter Total Test')}}" value="{{isset($data->total_test)?$data->total_test:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="presence_cities">{{__("message.Presence Cities")}}<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="presence_cities" name="presence_cities" placeholder="{{__('message.Enter Presence Cities')}}" value="{{isset($data->presence_cities)?$data->presence_cities:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="footer_logo">{{__("message.Footer Logo")}}<span class="reqfield">*</span></label>
                     <?php
                        if(isset($data->footer_logo)){
                            $path= env('APP_URL')."/public/img/".$data->footer_logo;
                        }
                        else{
                            $path=asset('public/upload/default.jpg');
                        }
                        ?>
                     <div class="adm-upload">
                        <span class="adm-upload-thumb"><img src="{{$path}}" alt="..." id="basic_img_footer"></span>
                        <div class="adm-upload-control">
                           <input type="hidden" name="old_footer_logo" id="old_footer_logo" value="{{isset($data->footer_logo)?$data->footer_logo:''}}">
                           <input type="file" name="footer_logo" class="form-control" id="footer_logo" />
                           <span class="adm-upload-hint"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>PNG or JPG</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 adm-field">
                     <label for="main_banner">{{__("message.Main Banner")}}<span class="reqfield">*</span></label>
                     <div class="adm-banner-grid">
                        <?php
                           if(isset($data->main_banner)){
                               $imagePaths = unserialize($data->main_banner);
                               foreach($imagePaths as $index=>$bannerIMG){
                                   $path= env('APP_URL')."/public/".$bannerIMG;
                                   ?>
                                   <div class="adm-banner-item">
                                      <img src="{{$path}}" alt="...">
                                      <a href="{{url('remove_slider')}}/{{$index}}/main_banner" class="adm-act adm-act--red">
                                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                         Remove
                                      </a>
                                   </div>
                                   <?php
                               }
                           }
                           else{
                               $path=asset('public/upload/default.jpg');
                               ?>
                               <div class="adm-banner-item"><img src="{{$path}}" alt="..."></div>
                               <?php
                           }
                           ?>
                     </div>
                     <input type="hidden" name="old_main_banner" id="old_main_banner" value="{{isset($data->main_banner)?$data->main_banner:''}}">
                     <input type="file" name="main_banner[]" class="form-control" id="main_banner" multiple />
                  </div>
                  <div class="col-12 adm-field">
                     <label for="app_banner">App Banner<span class="reqfield">*</span></label>
                     <div class="adm-banner-grid">
                        <?php
                           if(isset($data->app_banner)){
                               $imagePaths = unserialize($data->app_banner);
                               foreach($imagePaths as $index=>$bannerIMG){
                                   $path= env('APP_URL')."/public/".$bannerIMG;
                                   ?>
                                   <div class="adm-banner-item">
                                      <img src="{{$path}}" alt="...">
                                      <a href="{{url('remove_slider')}}/{{$index}}/app_banner" class="adm-act adm-act--red">
                                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                         Remove
                                      </a>
                                   </div>
                                   <?php
                               }
                           }
                           else{
                               $path=asset('public/upload/default.jpg');
                               ?>
                               <div class="adm-banner-item"><img src="{{$path}}" alt="..."></div>
                               <?php
                           }
                           ?>
                     </div>
                     <input type="hidden" name="old_app_banner" id="old_app_banner" value="{{isset($data->app_banner)?$data->app_banner:''}}">
                     <input type="file" name="app_banner[]" class="form-control" id="app_banner" multiple />
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="search_banner">{{__("message.Search Banner")}}<span class="reqfield">*</span></label>
                     <?php
                        if(isset($data->search_banner)){
                            $path= env('APP_URL')."/public/img/".$data->search_banner;
                        }
                        else{
                            $path=asset('public/upload/default.jpg');
                        }
                        ?>
                     <div class="adm-upload">
                        <span class="adm-upload-thumb"><img src="{{$path}}" alt="..." id="basic_img_search"></span>
                        <div class="adm-upload-control">
                           <input type="hidden" name="old_search_banner" id="old_search_banner" value="{{isset($data->search_banner)?$data->search_banner:''}}">
                           <input type="file" name="search_banner" class="form-control" id="search_banner" />
                           <span class="adm-upload-hint"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>PNG or JPG</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="mobile_app_banner">{{__("message.Mobile App Banner")}}<span class="reqfield">*</span></label>
                     <?php
                        if(isset($data->mobile_app_banner)){
                            $path= env('APP_URL')."/public/img/".$data->mobile_app_banner;
                        }
                        else{
                            $path=asset('public/upload/default.jpg');
                        }
                        ?>
                     <div class="adm-upload">
                        <span class="adm-upload-thumb"><img src="{{$path}}" alt="..." id="basic_img_mobile"></span>
                        <div class="adm-upload-control">
                           <input type="hidden" name="old_mobile_app_banner" id="old_mobile_app_banner" value="{{isset($data->mobile_app_banner)?$data->mobile_app_banner:''}}">
                           <input type="file" name="mobile_app_banner" class="form-control" id="mobile_app_banner" />
                           <span class="adm-upload-hint"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>PNG or JPG</span>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 adm-form-actions">
                     @if(Session::get("is_demo")==1)
                     <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__('message.Save')}}
                     </button>
                     @else
                     <button type="submit" class="btn btn-success adm-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__('message.Save')}}
                     </button>
                     @endif
                  </div>
               </div>
            </form>
         </div>

         {{-- ============ Tab 8: Wallet Setting ============ --}}
         <div class="tab-pane <?= $id==8?'active':''?>" id="tab8">
            <form action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{$id}}">
               <div class="row">
                  <div class="col-md-6 adm-field">
                     <label for="wallet_cashback_per">Cash Back (%)<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="wallet_cashback_per" name="wallet_cashback_per" value="{{isset($data->wallet_cashback_per)?$data->wallet_cashback_per:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="wallet_cashback_point">Cash Back Point (Per Rs.)<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="wallet_cashback_point" name="wallet_cashback_point" value="{{isset($data->wallet_cashback_point)?$data->wallet_cashback_point:''}}">
                  </div>
                  <div class="col-md-6 adm-field">
                     <label for="wallet_point_on_register">Cash Back Point on Register<span class="reqfield">*</span></label>
                     <input type="text" required class="form-control" id="wallet_point_on_register" name="wallet_point_on_register" value="{{isset($data->wallet_point_on_register)?$data->wallet_point_on_register:''}}">
                  </div>
                  <div class="col-12 adm-form-actions">
                     @if(Session::get("is_demo")==1)
                     <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__('message.Save')}}
                     </button>
                     @else
                     <button type="submit" class="btn btn-success adm-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        {{__('message.Save')}}
                     </button>
                     @endif
                  </div>
               </div>
            </form>
         </div>

         {{-- ============ Tab 9: About US ============ --}}
         <div class="tab-pane <?= $id==9?'active':''?>" id="tab9">
            <form action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{$id}}">
               <div class="row">
                  <div class="col-12 adm-field">
                     <label for="about">About US<span class="reqfield">*</span></label>
                     <textarea id="about" name="about" class="ckeditor form-control">{{isset($data->about)?$data->about:''}}</textarea>
                  </div>
                  <div class="col-12 adm-form-actions">
                     @if(Session::get("is_demo")==1)
                     <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">{{__('message.Save')}}</button>
                     @else
                     <button type="submit" class="btn btn-success adm-btn-primary">{{__('message.Save')}}</button>
                     @endif
                  </div>
               </div>
            </form>
         </div>

         {{-- ============ Tab 10: Terms of Service ============ --}}
         <div class="tab-pane <?= $id==10?'active':''?>" id="tab10">
            <form action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{$id}}">
               <div class="row">
                  <div class="col-12 adm-field">
                     <label for="t_s">Terms of Service<span class="reqfield">*</span></label>
                     <textarea id="t_s" name="t_s" class="ckeditor form-control">{{isset($data->t_s)?$data->t_s:''}}</textarea>
                  </div>
                  <div class="col-12 adm-form-actions">
                     @if(Session::get("is_demo")==1)
                     <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">{{__('message.Save')}}</button>
                     @else
                     <button type="submit" class="btn btn-success adm-btn-primary">{{__('message.Save')}}</button>
                     @endif
                  </div>
               </div>
            </form>
         </div>

         {{-- ============ Tab 11: Privacy Policy ============ --}}
         <div class="tab-pane <?= $id==11?'active':''?>" id="tab11">
            <form action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{$id}}">
               <div class="row">
                  <div class="col-12 adm-field">
                     <label for="privacy">Privacy Policy<span class="reqfield">*</span></label>
                     <textarea id="privacy" name="privacy" class="ckeditor form-control">{{isset($data->privacy)?$data->privacy:''}}</textarea>
                  </div>
                  <div class="col-12 adm-form-actions">
                     @if(Session::get("is_demo")==1)
                     <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">{{__('message.Save')}}</button>
                     @else
                     <button type="submit" class="btn btn-success adm-btn-primary">{{__('message.Save')}}</button>
                     @endif
                  </div>
               </div>
            </form>
         </div>

         {{-- ============ Tab 12: Franchise ============ --}}
         <div class="tab-pane <?= $id==12?'active':''?>" id="tab12">
            <form action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{$id}}">
               <div class="row">
                  <div class="col-12 adm-field">
                     <label for="franchise">Franchise<span class="reqfield">*</span></label>
                     <textarea id="franchise" name="franchise" class="ckeditor form-control">{{isset($data->franchise)?$data->franchise:''}}</textarea>
                  </div>
                  <div class="col-12 adm-form-actions">
                     @if(Session::get("is_demo")==1)
                     <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">{{__('message.Save')}}</button>
                     @else
                     <button type="submit" class="btn btn-success adm-btn-primary">{{__('message.Save')}}</button>
                     @endif
                  </div>
               </div>
            </form>
         </div>

         {{-- ============ Tab 13: Refund Policy ============ --}}
         <div class="tab-pane <?= $id==13?'active':''?>" id="tab13">
            <form action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" value="{{$id}}">
               <div class="row">
                  <div class="col-12 adm-field">
                     <label for="refund_policy">Refund Policy<span class="reqfield">*</span></label>
                     <textarea id="refund_policy" name="refund_policy" class="ckeditor form-control">{{isset($data->refund_policy)?$data->refund_policy:''}}</textarea>
                  </div>
                  <div class="col-12 adm-form-actions">
                     @if(Session::get("is_demo")==1)
                     <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">{{__('message.Save')}}</button>
                     @else
                     <button type="submit" class="btn btn-success adm-btn-primary">{{__('message.Save')}}</button>
                     @endif
                  </div>
               </div>
            </form>
         </div>

      </div>
   </div>
</div>

<script>
   /* ==========================================================================
      Redesign notes: markup/classes only, tab nav converted to the shared
      .adm-cat-tabs pill style (same as Parameter's save page). Every field
      name and every form's action route is unchanged. The dead "Payment
      Detail" tab (tab3) already had no clickable nav link in the original
      file (its <li> was commented out) — payment gateway config now lives
      on the separate, dedicated Payment Setting page — so it's carried
      forward exactly as unreachable, not redesigned or deleted.

      Two genuine, confirmed bugs fixed here:

      (1) about/t_s/privacy/franchise all shared id="myTextarea" (only
      refund_policy had a real, unique id) while CKEDITOR.replace('about'),
      replace('t_s'), replace('privacy'), replace('franchise') each tried to
      bind by that name. Verified live (via a scripted test: set data on
      each field, trigger the real Save button, read the actual submitted
      FormData) that only whichever one instance ends up registered under
      the shared id actually synced — edits to the other three were always
      silently discarded on save, permanently reverting to the original DB
      content no matter what was typed. Every duplicate id is now unique and
      matches its CKEDITOR.replace() argument; re-verified after the fix
      that all five fields now correctly sync.

      (2) This page loaded its own separate CKEditor 4.22.1 CDN copy and
      called CKEDITOR.replace(...) immediately/synchronously — on top of
      the shared layout's own CKEditor 4.21.0 (loaded later, near the
      bottom of <body>, after this content section). Consolidated to rely
      on the shared layout's copy only, deferring the replace() calls to
      window 'load' (same wait-for-CKEDITOR pattern already used
      elsewhere) — this removes a redundant ~300KB+ duplicate library load
      and avoids the same "script runs before its dependency has loaded"
      trap already hit and fixed on the Coupon and Blog modules.

      Also fixed: the Time Zone dropdown's placeholder called
      __('messages.select_timezone') — note "messages", not "message" —
      which doesn't exist in resources/lang/en/message.php, so it echoed
      the literal string "messages.select_timezone"; replaced with plain
      "Select Timezone" text, matching how other placeholder-only options
      elsewhere in this app are written directly instead of through a
      non-resolving translation call.
      ========================================================================== */
   window.addEventListener('load', function () {
      var tries = 0;
      (function hook() {
         if (window.CKEDITOR) {
            CKEDITOR.replace('about', {versionCheck: false});
            CKEDITOR.replace('t_s', {versionCheck: false});
            CKEDITOR.replace('privacy', {versionCheck: false});
            CKEDITOR.replace('franchise', {versionCheck: false});
            CKEDITOR.replace('refund_policy', {versionCheck: false});
            return;
         }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
