@extends('admin.layout.index')
@section('title')
{{__("message.Setting")}}
@stop
@section('content')

<!--Page header-->
<div class="page-header">
   <h3 class="page-title">{{__("message.Settings")}} </h3>
   <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Settings")}}</li>
      </ol>
   </div>
</div>
@if(Session::has('message'))
<div class="col-sm-12">
   <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
</div>
@endif
<div class="row">
   <div class="col-9 grid-margin stretch-card">
      <div class="card">
         <div class="card-body">
            <div class="panel panel-primary">
               <div class="tab-menu-heading p-0">
                  <div class="tabs-menu ">
                     <!-- Tabs --> 
                     <ul class="nav panel-tabs">
                        <li class=""><a href="#tab1" class="<?= $id==1?'active':""?>" data-bs-toggle="tab">{{__("message.Basic Information")}}</a></li>
                        <li><a href="#tab2" data-bs-toggle="tab" class="<?= $id==2?'active':""?>">{{__("message.Server Key")}}</a></li>
                       <!--  <li><a href="#tab3" data-bs-toggle="tab" class="<?= $id==3?'active':""?>">{{__("message.Payment Detail")}}</a></li> -->
                        <li><a href="#tab4" data-bs-toggle="tab" class="<?= $id==4?'active':""?>">{{__("message.Website Setting")}}</a></li>
                        <li><a href="#tab8" data-bs-toggle="tab" class="<?= $id==8?'active':""?>">Wallet Setting</a></li>
                        <li><a href="#tab9" data-bs-toggle="tab" class="<?= $id==9?'active':""?>">About US</a></li>
                        <li><a href="#tab10" data-bs-toggle="tab" class="<?= $id==10?'active':""?>">Terms of Service</a></li>
                        <li><a href="#tab11" data-bs-toggle="tab" class="<?= $id==11?'active':""?>">Privacy Policy</a></li>
                        <li><a href="#tab12" data-bs-toggle="tab" class="<?= $id==12?'active':""?>">Franchise</a></li>
                        <li><a href="#tab13" data-bs-toggle="tab" class="<?= $id==13?'active':""?>">Refund Policy</a></li>
                     </ul>
                  </div>
               </div>
               <div class="panel-body tabs-menu-body">
                  <div class="tab-content">
                     <div class="tab-pane <?= $id==1?'active':""?>" id="tab1">
                        <form  action="{{route('savebasicsetting')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="{{$id}}">
                            <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                
                                 <label class="custom-control custom-checkbox">                                
                                 <input type="checkbox" name="is_rtl" <?= isset($data->is_rtl)&&$data->is_rtl=='1'?'checked="checked"':''?> id="is_rtl" value="1" class="custom-control-input"> 
                                
                                 <span class="custom-control-label"> {{__("message.Site RTL")}}</span> 
                                 </label>
                              </div>
                           </div>
                            <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <!-- <div class="form-group"> -->
                                 <label for="name">{{__("message.Logo")}}<span class="reqfield">*</span></label>
                                 <?php 
                                    if(isset($data->logo)){
                                        $path= env('APP_URL')."public/img"."/".$data->logo;
                                    }
                                    else{
                                        $path=asset('public/upload/default.jpg');
                                    }
                                    ?>
                                 <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img">
                                 <input type="hidden" name="old_logo" id="old_logo" value="{{isset($data->logo)?$data->logo:''}}">
                                 <input type="file" name="logo_image" class="form-control" id="logo_image" />                                
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <!-- <div class="form-group"> -->
                                 <label for="name">{{__("message.Favicon")}}<span class="reqfield">*</span></label>
                                 <?php 
                                    if(isset($data->favicon)){
                                        $path= env('APP_URL')."public/img"."/".$data->favicon;
                                    }
                                    else{
                                        $path=asset('public/upload/default.jpg');
                                    }
                                    ?>
                                 <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img">
                                 <input type="hidden" name="old_favicon" id="old_favicon" value="{{isset($data->favicon)?$data->favicon:''}}">
                                 <input type="file" name="favicon_image" class="form-control" id="favicon_image" />                                
                              </div>
                           </div>
                           <div class="row">
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{ __("message.Email Id") }} <span class="reqfield">*</span></label>
                                 <input type="text" required class="form-control" id="email" name="email" placeholder="{{ __('message.Enter Email') }}" value="{{isset($data->email)?$data->email:''}}">
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Phone")}} <span class="reqfield">*</span></label>
                                 <input type="text" required class="form-control" id="phone" name="phone" placeholder="{{ __('message.Enter Phone') }}" value="{{isset($data->phone)?$data->phone:''}}" >
                              </div>
                           </div>
                             <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Address")}} <span class="reqfield">*</span></label>
                                 <textarea required class="form-control" id="address" name="address" placeholder="{{ __('message.Enter Address') }}">{{isset($data->address)?$data->address:''}}</textarea>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Currency")}} <span class="reqfield">*</span></label>
                                 <select id="currency" name="currency" required="" class="form-control">
                                 	  <option value="{{$data->currency}}" selected>{{$data->currency}}</option>
                              @include('admin.setting.currency')
                                 </select>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Tax Charge")}} <span class="reqfield">*</span></label>
                                 <input type="text" required class="form-control" id="txt_charge" name="txt_charge" placeholder="{{__('message.Enter Tax charge')}}" value="{{isset($data->txt_charge)?$data->txt_charge:''}}" >
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Time Zone")}} <span class="reqfield">*</span></label>
                                 <select id="timezone" name="timezone" required="" class="form-control">
                                 	  <option value="">{{__('messages.select_timezone')}}</option>
			                              @foreach($timezone_list as $tz=>$value)
			                              <option value="{{$tz}}" <?=$data->timezone ==$tz ? ' selected="selected"' : '';?>>{{$value}}</option>
			                              @endforeach
                                 </select>
                                 
                              </div>
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
                           <!-- </div> -->
                        </form>
                     </div>
                     <div class="tab-pane <?= $id==2?'active':""?>" id="tab2">
                        <form  action="{{route('server_key')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="{{$id}}">
                           <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Android Server Key")}}<span class="reqfield">*</span></label>
                                 <textarea required class="form-control" id="android_server_key" name="android_server_key" placeholder="{{__('message.Enter Android Server Key')}}">{{isset($data->android_server_key)?$data->android_server_key:''}}</textarea>
                              </div>
                           </div>
                           <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Iphone Server Key")}}<span class="reqfield">*</span></label>
                                 <textarea required class="form-control" id="ios_server_key" name="ios_server_key" placeholder="{{__('message.Enter Iphone Server Key')}}">{{isset($data->ios_server_key)?$data->ios_server_key:''}}</textarea>
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="text-end">
                                 <input type="submit" value='{{__("message.Submit")}}' class="btn btn-success btn-lg">
                              </div>
                           </div>
                           <!-- </div> -->
                        </form>
                     </div>
                     <div class="tab-pane <?= $id==3?'active':""?>" id="tab3">
                        <div class="tab-menu-heading p-0">
                           <div class="tabs-menu ">
                              <!-- Tabs --> 
                              <ul class="nav panel-tabs">
                                 <li class=""><a href="#tab_1" class="active" data-bs-toggle="tab">{{__("message.Braintree")}}</a></li>
                                 <li><a href="#tab_2" data-bs-toggle="tab" class="">{{__("message.Stripe")}}</a></li>
                              </ul>
                           </div>
                        </div>
                        <div class="panel-body tabs-menu-body">
                           <div class="tab-content">
                              <div class="tab-pane active" id="tab_1">
                                 <form  action="{{route('change-payment-detail')}}" method="post" enctype="multipart/form-data">
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
                                          <select  required class="form-control" id="environment" name="environment" placeholder="{{__('message.Enter Environment')}}">
                                          	<option <?= isset($payment['Braintree_environment'])&&$payment['Braintree_environment']=='sandbox'?'selected="selected"':''?> value="sandbox">{{__("message.sandbox")}}</option>
                                          	<option <?= isset($payment['Braintree_environment'])&&$payment['Braintree_environment']=='live'?'selected="selected"':''?> value="live">{{__("message.live")}}</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                       <div class="form-group">
                                          <label class="form-label">{{__("message.MerchantId")}} <span class="reqfield">*</span></label>
                                          <input type="text" required class="form-control" id="merchantId" name="merchantId" placeholder="{{__('message.Enter MerchantId')}}" value="{{isset($payment['Braintree_merchantId'])?$payment['Braintree_merchantId']:''}}" >
                                       </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                       <div class="form-group">
                                          <label class="form-label">{{__("message.PublicKey")}} <span class="reqfield">*</span></label>
                                          <input type="text" required class="form-control" id="publicKey" name="publicKey" placeholder="{{__('message.Enter PublicKey')}}" value="{{isset($payment['Braintree_publicKey'])?$payment['Braintree_publicKey']:''}}" >
                                       </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                       <div class="form-group">
                                          <label class="form-label">{{__('message.PrivateKey')}} <span class="reqfield">*</span></label>
                                          <input type="text" required class="form-control" id="privateKey" name="privateKey" placeholder="{{__('message.Enter PrivateKey')}}" value="{{isset($payment['Braintree_privateKey'])?$payment['Braintree_privateKey']:''}}" >
                                       </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                       <div class="form-group">
                                          <label class="form-label">{{__('message.Tokenization Keys')}} <span class="reqfield">*</span></label>
                                          <input type="text" required class="form-control" id="TokenizationKeys" name="TokenizationKeys" placeholder="{{__('message.Enter Tokenization Keys')}}" value="{{isset($payment['Braintree_TokenizationKeys'])?$payment['Braintree_TokenizationKeys']:''}}" >
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
                                 <form  action="{{route('change-payment-detail')}}" method="post" enctype="multipart/form-data">
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
                                          <input type="text" required class="form-control" id="public_key" name="public_key" placeholder="{{__('message.Enter PublicKey')}}" value="{{isset($payment['Stripe_public_key'])?$payment['Stripe_public_key']:''}}" >
                                       </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                       <div class="form-group">
                                          <label class="form-label">{{__("message.Secert key")}} <span class="reqfield">*</span></label>
                                          <input type="text" required class="form-control" id="secert_key" name="secert_key" placeholder="{{__('message.Enter Secert key')}}" value="{{isset($payment['Stripe_secert_key'])?$payment['Stripe_secert_key']:''}}" >
                                       </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                       <div class="form-group">
                                          <label class="form-label">{{__("message.Currency")}} <span class="reqfield">*</span></label>
                                          <input type="text" required class="form-control" id="currency" name="currency" placeholder="{{__('message.Enter Stripe currency')}}" value="{{isset($payment['Stripe_currency'])?$payment['Stripe_currency']:''}}" >
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
                     <div class="tab-pane <?= $id==4?'active':""?>" id="tab4">
                        <form  action="{{route('update-website-details')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="{{$id}}">
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Appstore url")}} <span class="reqfield">*</span></label>
                                 <input type="text" required class="form-control" id="appstore_url" name="appstore_url" placeholder="{{__('message.Enter Appstore url')}}" value="{{isset($data->appstore_url)?$data->appstore_url:''}}">
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Playstore url")}} <span class="reqfield">*</span></label>
                                 <input type="text" required class="form-control" id="playstore_url" name="playstore_url" placeholder="{{__('message.Enter Playstore url')}}" value="{{isset($data->playstore_url)?$data->playstore_url:''}}" >
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Phlebotomist")}} <span class="reqfield">*</span></label>
                                 <input type="text" required class="form-control" id="largest_phlebotomist" name="largest_phlebotomist" placeholder="{{__('message.Enter Phlebotomist')}}" value="{{isset($data->largest_phlebotomist)?$data->largest_phlebotomist:''}}" >
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Satisfied Customers")}} <span class="reqfield">*</span></label>
                                 <input type="text" required class="form-control" id="satisfied_customers" name="satisfied_customers" placeholder="{{__('message.Enter Satisfied Customers')}}" value="{{isset($data->satisfied_customers)?$data->satisfied_customers:''}}" >
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Total Test")}} <span class="reqfield">*</span></label>
                                 <input type="text" required class="form-control" id="total_test" name="total_test" placeholder="{{__('message.Enter Total Test')}}" value="{{isset($data->total_test)?$data->total_test:''}}" >
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">{{__("message.Presence Cities")}} <span class="reqfield">*</span></label>
                                 <input type="text" required class="form-control" id="presence_cities" name="presence_cities" placeholder="{{__('message.Enter Presence Cities')}}" value="{{isset($data->presence_cities)?$data->presence_cities:''}}" >
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label for="name">{{__("message.Footer Logo")}}<span class="reqfield">*</span></label>
                                 <?php 
                                    if(isset($data->footer_logo)){
                                        $path= env('APP_URL')."public/img"."/".$data->footer_logo;
                                    }
                                    else{
                                        $path=asset('public/upload/default.jpg');
                                    }
                                    ?>
                                 <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" width="200px">
                                 <input type="hidden" name="old_footer_logo" id="old_footer_logo" value="{{isset($data->footer_logo)?$data->footer_logo:''}}">
                                 <input type="file" name="footer_logo" class="form-control" id="footer_logo" />                                
                              </div>
                           </div>
                           <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                 <label for="name">{{__("message.Main Banner")}}<span class="reqfield">*</span></label>
                                 <div class="row">
                                 <?php 
                                    if(isset($data->main_banner)){
                                        $imagePaths = unserialize($data->main_banner); 
                                       
                                        foreach($imagePaths as $index=>$bannerIMG){
                                           
                                            $path= env('APP_URL')."public/"."/".$bannerIMG; 
                                            
                                            ?> 
                                            <div class="col-4">
                                             <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" width="200px"> 
                                             <a href="{{url('remove_slider')}}/{{$index}}/main_banner">
                                             <i style="color:red;" class="fa fa-trash"></i>
                                             </a>
                                            </div>
                                             <?php
                                        }
                                        
                                    }
                                    else{
                                        $path=asset('public/upload/default.jpg');
                                        ?>
                                           <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" width="200px">
                                           <?php
                                    }
                                    ?>
                                </div>
                                 <input type="hidden" name="old_main_banner" id="old_main_banner" value="{{isset($data->main_banner)?$data->main_banner:''}}" >
                                 <input type="file" name="main_banner[]" class="form-control" id="main_banner" multiple />                                
                              </div>
                           </div>
                           <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                  <div class="row">
                                 <label for="name">App Banner<span class="reqfield">*</span></label>
                                 <?php 
                                    if(isset($data->app_banner)){
                                        $imagePaths = unserialize($data->app_banner); 
                                       
                                        foreach($imagePaths as $index=>$bannerIMG){
                                           
                                            $path= env('APP_URL')."public/"."/".$bannerIMG; 
                                            
                                            ?> 
                                            <div class="col-4">
                                             <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" width="200px">
                                              <a href="{{url('remove_slider')}}/{{$index}}/app_banner">
                                             <i style="color:red;" class="fa fa-trash"></i>
                                             </a>
                                             </div>
                                             <?php
                                        }
                                        
                                    }
                                    else{
                                        $path=asset('public/upload/default.jpg');
                                        ?>
                                           <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" width="200px">
                                           <?php
                                    }
                                    ?>
                                    </div>
                                 <input type="hidden" name="old_app_banner" id="old_app_banner" value="{{isset($data->app_banner)?$data->app_banner:''}}" >
                                 <input type="file" name="app_banner[]" class="form-control" id="app_banner" multiple />                                
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label for="name">{{__("message.Search Banner")}}<span class="reqfield">*</span></label>
                                 <?php 
                                    if(isset($data->search_banner)){
                                        $path= env('APP_URL')."public/img"."/".$data->search_banner;
                                    }
                                    else{
                                        $path=asset('public/upload/default.jpg');
                                    }
                                    ?>
                                 <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" width="200px">
                                 <input type="hidden" name="old_search_banner" id="old_search_banner" value="{{isset($data->search_banner)?$data->search_banner:''}}">
                                 <input type="file" name="search_banner" class="form-control" id="search_banner" />                                
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label for="name">{{__("message.Mobile App Banner")}}<span class="reqfield">*</span></label>
                                 <?php 
                                    if(isset($data->mobile_app_banner)){
                                        $path= env('APP_URL')."public/img"."/".$data->mobile_app_banner;
                                    }
                                    else{
                                        $path=asset('public/upload/default.jpg');
                                    }
                                    ?>
                                 <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" width="200px">
                                 <input type="hidden" name="old_mobile_app_banner" id="old_mobile_app_banner" value="{{isset($data->mobile_app_banner)?$data->mobile_app_banner:''}}">
                                 <input type="file" name="mobile_app_banner" class="form-control" id="mobile_app_banner" />                                
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
                           <!-- </div> -->
                        </form>
                     </div>
                     
                     <div class="tab-pane <?= $id==8?'active':""?>" id="tab8">
                        <form  action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="{{$id}}">
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">Cash Back (%)<span class="reqfield">*</span></label>
                                 <input type="text" required class="form-control" id="appstore_url" name="wallet_cashback_per"  value="{{isset($data->wallet_cashback_per)?$data->wallet_cashback_per:''}}">
                              </div>
                           </div>
                           <div class="col-sm-6 col-md-6">
                              <div class="form-group">
                                 <label class="form-label">Cash Back Point (Per Rs.)<span class="reqfield">*</span></label>
                                 <input type="text" required class="form-control" id="playstore_url" name="wallet_cashback_point" value="{{isset($data->wallet_cashback_point)?$data->wallet_cashback_point:''}}" >
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
                           <!-- </div> -->
                        </form>
                     </div>
                     
                     <!-------------------------t&c------------------>
                     <div class="tab-pane <?= $id==10?'active':""?>" id="tab10">
                        <form  action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="{{$id}}">
                           <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                 <label class="form-label">Terms of Service<span class="reqfield">*</span></label>
                                 <textarea id="myTextarea" name="t_s"  value=""  
                                 class="form-control">
                                     {{isset($data->t_s)?$data->t_s:''}}
                                 </textarea>
                                 
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
                           <!-- </div> -->
                        </form>
                     </div>
                      <!-------------------------P & P------------------>
                     <div class="tab-pane <?= $id==11?'active':""?>" id="tab11">
                        <form  action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="{{$id}}">
                           <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                 <label class="form-label"> Privacy Policy<span class="reqfield">*</span></label>
                                 <textarea id="myTextarea" name="privacy"  value=""  
                                 class="form-control">{{isset($data->privacy)?$data->privacy:''}}</textarea>
                                 
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
                           <!-- </div> -->
                        </form>
                     </div>
                     <!-------------------------franchise ------------------>
                     <div class="tab-pane <?= $id==12?'active':""?>" id="tab12">
                        <form  action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="{{$id}}">
                           <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                 <label class="form-label">franchise<span class="reqfield">*</span></label>
                                 <textarea id="myTextarea" name="franchise"  value=""  
                                 class="form-control">{{isset($data->franchise )?$data->franchise :''}}</textarea>
                                 
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
                           <!-- </div> -->
                        </form>
                     </div>
                        <!-------------------------refund ------------------>
                     <div class="tab-pane <?= $id==13?'active':""?>" id="tab13">
                        <form  action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="{{$id}}">
                           <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                 <label class="form-label">franchise<span class="reqfield">*</span></label>
                                 <textarea id="refund_policy" name="refund_policy"  value=""  
                                 class="form-control">{{isset($data->refund_policy )?$data->refund_policy :''}}</textarea>
                                 
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
                           <!-- </div> -->
                        </form>
                     </div>
                  
                      <!-------------------------about------------------>
                     <div class="tab-pane <?= $id==9?'active':""?>" id="tab9">
                        <form  action="{{route('update-wallet-details')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="{{$id}}">
                           <div class="col-sm-12 col-md-12">
                              <div class="form-group">
                                 <label class="form-label">About US<span class="reqfield">*</span></label>
                                 <textarea id="myTextarea" name="about"
                                 class="form-control">{{isset($data->about)?$data->about:''}}</textarea>
                                 
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
                           <!-- </div> -->
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
         CKEDITOR.replace( 'about' );     
         CKEDITOR.replace( 't_s' );      
         CKEDITOR.replace( 'privacy' );
         CKEDITOR.replace( 'franchise' );
         CKEDITOR.replace( 'refund_policy' );
</script>



<!-- </div> -->
<!-- End Row-->
@endsection