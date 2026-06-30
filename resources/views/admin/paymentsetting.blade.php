@extends('admin.layout.index')
@section('title')
{{__("message.Payment Gateway Setting")}}
@stop
@section('content')
<!--Page header-->
<div class="page-header">
   <h3 class="page-title">{{__("message.Payment Gateway Setting")}} </h3>
   <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Payment Gateway Setting")}}</li>
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
                        <li class=""><a href="#tab1" class="<?= Session::get("payment_next")==1?'active':""?>" data-bs-toggle="tab">{{__("message.BrainTree")}}</a></li>
                        <li><a href="#tab2" data-bs-toggle="tab" class="<?= Session::get("payment_next")==2?'active':""?>">{{__("message.Razor Pay")}}</a></li>
                        <li><a href="#tab3" data-bs-toggle="tab" class="<?= Session::get("payment_next")==3?'active':""?>">{{__("message.PayStack")}}</a></li>
                        <li><a href="#tab4" data-bs-toggle="tab" class="<?= Session::get("payment_next")==4?'active':""?>">{{__("message.Paytm")}}</a></li>
                        <li><a href="#tab5" data-bs-toggle="tab" class="<?= Session::get("payment_next")==5?'active':""?>">{{__("message.Flutter Wave")}}</a></li>
                     </ul>
                  </div>
               </div>
               <div class="panel-body tabs-menu-body">
                  <div class="tab-content">
                     <div class="tab-pane <?= Session::get("payment_next")==1?'active':""?>" id="tab1">
                        <form action="{{route('updategateway')}}" method="post">
                           <input type="hidden" name="payment_gateway" value="braintree">

                           {{csrf_field()}}
                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label for="environment">{{__("message.environment")}}<span class="reqfield">*</span></label>
                                 <select name="environment" id="environment" class="form-control" required="">
                                    <option value="sandbox" <?= isset($arr['braintree_environment'])&&$arr['braintree_environment']=='local'?"selected='selected'":''?> >{{__("message.sandbox")}}</option>
                                    <option value="production" <?= isset($arr['braintree_environment'])&&$arr['braintree_environment']=='production'?"selected='selected'":''?>>{{__("message.Production")}}</option>
                                 </select>
                              </div>
                              <div class="form-group col-md-6">
                                 <label for="merchant_id">{{__("message.Merchant ID")}}<span class="reqfield">*</span></label>
                                 <input type="text" id="merchant_id" name="merchant_id" class="form-control" required="" placeholder="{{__('message.Enter BrainTree Merchant ID')}}" value="{{isset($arr['braintree_merchant_id'])?$arr['braintree_merchant_id']:''}}">
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label for="public_key">{{__("message.Public Key")}}<span class="reqfield">*</span></label>
                                 <input type="text" id="public_key" name="public_key" class="form-control" required="" placeholder="{{__('message.Enter BrainTree Public Key')}}" value="{{isset($arr['braintree_public_key'])?$arr['braintree_public_key']:''}}">
                              </div>
                              <div class="form-group col-md-6">
                                 <label for="private_key">{{__("message.Private Key")}}<span class="reqfield">*</span></label>
                                 <input type="text" id="private_key" name="private_key" class="form-control" required="" placeholder="{{__('message.Enter BrainTree Private Key')}}" value="{{isset($arr['braintree_private_key'])?$arr['braintree_private_key']:''}}">
                              </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label for="tokenization_key">{{__("message.tokenization key")}}<span class="reqfield">*</span></label>
                                 <input type="text" id="tokenization_key" name="tokenization_key" class="form-control" required="" placeholder="{{__('message.Enter BrainTree Tokenization Key')}}" value="{{isset($arr['braintree_tokenization_key'])?$arr['braintree_tokenization_key']:''}}">
                              </div>
                              <div class="form-group col-md-6">
                                 <label for="name">{{__("message.Is Payment Gateway Is Active")}}<span class="reqfield">*</span></label>
                                 <select name="is_active" id="is_active" class="form-control" required="">
                                    <option value="1" <?= isset($arr['braintree_is_active'])&&$arr['braintree_is_active']=='1'?"selected='selected'":''?>>{{__("message.Yes")}}</option>
                                    <option value="0" <?= isset($arr['braintree_is_active'])&&$arr['braintree_is_active']=='0'?"selected='selected'":''?>>{{__("message.No")}}</option>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-12">      
                                 <input type="submit" value='{{__("message.submit")}}' class="btn btn-success float-right">
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="tab-pane <?= Session::get("payment_next")==2?'active':""?>" id="tab2">
                        <form action="{{route('updategateway')}}" method="post">
                           {{csrf_field()}}
                           <input type="hidden" name="payment_gateway" value="razorpay">
                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label for="name">{{__("message.Key")}}<span class="reqfield">*</span></label>
                                 <input type="text" id="razorpay_key" name="razorpay_key" class="form-control" required="" placeholder="{{__('message.Enter Razorpay Key')}}" value="{{isset($arr['razorpay_razorpay_key'])?$arr['razorpay_razorpay_key']:''}}">
                              </div>
                              <div class="form-group col-md-6">
                                 <label for="name">{{__("message.Secert")}}<span class="reqfield">*</span></label>
                                 <input type="text" id="razorpay_secert" name="razorpay_secert" class="form-control" required="" placeholder="{{__('message.Enter Razorpay Secert')}}" value="{{isset($arr['razorpay_razorpay_secert'])?$arr['razorpay_razorpay_secert']:''}}">
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="name">{{__("message.Is Payment Gateway Is Active")}}<span class="reqfield">*</span></label>
                              <select name="is_active" id="is_active" class="form-control" required="">
                                 <option value="1" <?= isset($arr['razorpay_is_active'])&&$arr['razorpay_is_active']=='1'?"selected='selected'":''?>>{{__("message.Yes")}}</option>
                                 <option value="0" <?= isset($arr['razorpay_is_active'])&&$arr['razorpay_is_active']=='0'?"selected='selected'":''?> >{{__("message.No")}}</option>
                              </select>
                           </div>
                           <div class="row">
                              <div class="col-12">      
                                 <input type="submit" value='{{__("message.submit")}}' class="btn btn-success float-right">
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="tab-pane <?= Session::get("payment_next")==3?'active':""?>" id="tab3">
                        <form action="{{route('updategateway')}}" method="post">
                           {{csrf_field()}}  
                           <input type="hidden" name="payment_gateway" value="paystack"> 
                           <input type="hidden" name="paystack_payment_url" value="https://api.paystack.co">  
                           <input type="hidden" name="MERCHANT_EMAIL" value="{{Auth::user()->email}}">                  
                           <div class="row">
                              <div class="form-group col-md-6">
                                 <label for="name">{{__("message.Public Key")}}<span class="reqfield">*</span></label>
                                 <input type="text" id="public_key" name="public_key" class="form-control" required="" placeholder="{{__('message.Enter PAYSTACK PUBLIC KEY')}}" value="{{isset($arr['paystack_public_key'])?$arr['paystack_public_key']:''}}">
                              </div>
                              <div class="form-group col-md-6">
                                 <label for="name">{{__("message.Secert Key")}}<span class="reqfield">*</span></label>
                                 <input type="text" id="secert_key" name="secert_key" class="form-control" required="" placeholder="{{__('message.Enter PAYSTACK_SECRET_KEY')}}" value="{{isset($arr['paystack_secert_key'])?$arr['paystack_secert_key']:''}}">
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="name">{{__("message.Is Payment Gateway Is Active")}}<span class="reqfield">*</span></label>
                              <select name="is_active" id="is_active" class="form-control" required="">
                                 <option value="1" <?= isset($arr['paystack_is_active'])&&$arr['paystack_is_active']=='1'?"selected='selected'":''?>>{{__("message.Yes")}}</option>
                                 <option value="0" <?= isset($arr['paystack_is_active'])&&$arr['paystack_is_active']=='0'?"selected='selected'":''?>>{{__("message.No")}}</option>
                              </select>
                           </div>
                           <div class="row">
                              <div class="col-12">      
                                 <input type="submit" value='{{__("message.submit")}}' class="btn btn-success float-right">
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="tab-pane <?= Session::get("payment_next")==4?'active':""?>" id="tab4">
                        <form action="{{route('updategateway')}}" method="post">
                           {{csrf_field()}}  
                           <input type="hidden" name="payment_gateway" value="paytm">
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="merchant_id">{{__("message.PAYTM MERCHANT ID")}} :</label>
                                 <input type="text" class="form-control" id="merchant_id" placeholder='{{__("message.Enter PAYTM MERCHANT ID")}}' name="merchant_id" value="{{isset($arr['paytm_merchant_id'])?$arr['paytm_merchant_id']:''}}">
                              </div>
                              <div class="col-md-6">
                                 <label for="pwd">{{__("message.PAYTM MERCHANT KEY")}}:</label>
                                 <input type="text" class="form-control" id="merchant_key" placeholder='{{__("message.Enter PAYTM MERCHANT KEY")}}' name="merchant_key" value="{{isset($arr['paytm_merchant_key'])?$arr['paytm_merchant_key']:''}}">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="pwd">{{__("message.PAYTM MERCHANT WEBSITE")}} :</label>
                                 <input type="text" class="form-control" id="merchant_website" placeholder="{{__('message.Enter PAYTM MERCHANT WEBSITE')}}" name="merchant_website" value="{{isset($arr['paytm_merchant_website'])?$arr['paytm_merchant_website']:''}}">
                              </div>
                              <div class="col-md-6">
                                 <label for="pwd">{{__("message.PAYTM ENVIRONMENT")}}:</label>
                                 <select name="environment" id="environment" class="form-control" required="">
                                 <?php $class1 = isset($arr['paytm_is_active'])&&$arr['paytm_is_active'] =="local"?'selected':'';
                                    $class2= isset($arr['paytm_is_active'])&&$arr['paytm_is_active'] =="production"?'selected':'';
                                    ?>
                                 <option value="local" {{$class1}}>{{__("message.Local")}}</option>
                                 <option value="production" {{$class2}}>{{__("message.Production")}}</option>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="pwd">{{__("message.PAYTM CHANNEL")}} :</label>
                                 <input type="text" class="form-control" id="channel" placeholder='{{__("message.Enter PAYTM CHANNEL")}}' name="channel"  value="{{isset($arr['paytm_channel'])?$arr['paytm_channel']:''}}">
                              </div>
                              <div class="col-md-6">
                                 <label for="pwd">{{__("message.PAYTM INDUSTRY TYPE")}}:</label>
                                 <input type="text" class="form-control" id="industry_type" placeholder='{{__("message.Enter PAYTM INDUSTRY TYPE")}}' name="industry_type" value="{{isset($arr['paytm_industry_type'])?$arr['paytm_industry_type']:''}}">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <label for="name">{{__("message.Is Payment Gateway Is Active")}}<span class="reqfield">*</span></label>
                              <select name="is_active" id="is_active" class="form-control" required="">
                                 <option value="1" <?= isset($arr['paytm_is_active'])&&$arr['paytm_is_active']=='1'?"selected='selected'":''?>>{{__("message.Yes")}}</option>
                                 <option value="0" <?= isset($arr['paytm_is_active'])&&$arr['paytm_is_active']=='0'?"selected='selected'":''?>>{{__("message.No")}}</option>
                              </select>
                           </div>
                           <div class="row">
                              <div class="col-12">      
                                 <input type="submit" value='{{__("message.submit")}}' class="btn btn-success float-right">
                              </div>
                           </div>
                        </form>
                     </div>
                     <div class="tab-pane <?= Session::get("payment_next")==5?'active':""?>" id="tab5">
                        <form action="{{route('updategateway')}}" method="post">
                           {{csrf_field()}}  
                           <input type="hidden" name="payment_gateway" value="rave">
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="email">{{__("message.RAVE PUBLIC KEY")}} :</label>
                                 <input type="text" class="form-control" id="public_key" placeholder='{{__("message.Enter RAVE PUBLIC KEY")}}' name="public_key" value="{{isset($arr['rave_public_key'])?$arr['rave_public_key']:''}}">
                              </div>
                              <div class="col-md-6">
                                 <label for="pwd">{{__("message.RAVE SECRET KEY")}}:</label>
                                 <input type="text" class="form-control" id="secert_key" placeholder='{{__("message.Enter RAVE SECRET KEY")}}' name="secert_key"  value="{{isset($arr['rave_secert_key'])?$arr['rave_secert_key']:''}}">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="email">{{__("message.RAVE TITLE")}} :</label>
                                 <input type="text" class="form-control" id="title" placeholder='{{__("message.Enter RAVE TITLE")}}' name="title" value="{{isset($arr['rave_title'])?$arr['rave_title']:''}}">
                              </div>
                              <div class="col-md-6">
                                 <label for="pwd">{{__("message.RAVE_ENVIRONMENT")}}:</label>
                                 <select name="environment" id="environment" class="form-control" required="">
                                    <option <?= isset($arr['rave_environment'])&&$arr['rave_environment']=='staging'?"selected='selected'":''?> value="staging">{{__("message.staging")}}</option>
                                    <option <?= isset($arr['rave_environment'])&&$arr['rave_environment']=='live'?"selected='selected'":''?> value="live">{{__("message.live")}}</option>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="email">{{__("message.RAVE LOGO URL")}} :</label>
                                 <input type="text" class="form-control" id="logo" placeholder='{{__("message.Enter RAVE LOGO URL")}}' name="logo" value="{{isset($arr['rave_logo'])?$arr['rave_logo']:''}}">
                              </div>
                              <div class="form-group col-md-6">
                                 <label for="name">{{__("message.Is Payment Gateway Is Active")}}<span class="reqfield">*</span></label>
                                 <select name="is_active" id="is_active" class="form-control" required="">
                                    <option value="1" <?= isset($arr['rave_is_active'])&&$arr['rave_is_active']=='1'?"selected='selected'":''?> >{{__("message.Yes")}}</option>
                                    <option value="0" <?= isset($arr['rave_is_active'])&&$arr['rave_is_active']=='0'?"selected='selected'":''?>>{{__("message.No")}}</option>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="email">{{__("message.Country")}} :</label>
                                 <input type="text" class="form-control" id="country" placeholder='{{__("message.Country")}}' name="country" value="{{isset($arr['rave_country'])?$arr['rave_country']:''}}">
                              </div>
                              <div class="col-md-6">
                                 <label for="email">{{__("message.Currency")}} :</label>
                                 <input type="text" class="form-control" id="currency" placeholder='{{__("message.Currency")}}' name="currency" value="{{isset($arr['rave_currency'])?$arr['rave_currency']:''}}">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <label for="email">{{__("message.RAVE Encryption Key")}} :</label>
                              <input type="text" class="form-control" id="encryption_key" placeholder='{{__("message.Enter RAVE Encryption Key")}}' name="encryption_key" value="{{isset($arr['rave_encryption_key'])?$arr['rave_encryption_key']:''}}">
                           </div>
                           <div class="row">
                              <div class="col-12">      
                                 <input type="submit" value='{{__("message.submit")}}' class="btn btn-success float-right">
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- </div> -->
<!-- End Row-->
@endsection