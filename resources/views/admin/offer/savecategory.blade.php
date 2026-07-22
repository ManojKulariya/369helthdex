@extends('admin.layout.index')
@section('title')
Offer
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">Save Offer</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin-offer')}}">Offer</a></li>
            <li class="breadcrumb-item active">Save Offer</li>
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

{{-- ============ Save offer form card ============ --}}
<div class="adm-form adm-form-page">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.25L3 3a1 1 0 0 0-1 1l.25 6.59a2 2 0 0 0 .58 1.42l9.59 9.59a2 2 0 0 0 2.82 0l5.35-5.35a2 2 0 0 0 0-2.83Z"/><circle cx="7.5" cy="7.5" r="1.5"/></svg>
            Save Offer
         </div>
      </div>
      <form action="{{route('update-offer')}}" method="post" enctype="multipart/form-data">
         {{csrf_field()}}
         <input type="hidden" name="id" id="id" value="{{$id}}">
         <div class="row">
            <div class="col-md-6 adm-field">
               <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
               <input type="text" id="name" name="name" class="form-control" placeholder='{{__("message.Enter Category Name")}}' required="" value="{{isset($data->name)?$data->name:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="upload_image">{{__("message.Category Image")}}<span class="reqfield">*</span></label>
               <?php
                  if(isset($data->image)){
                      $path=env('APP_URL')."/storage/category/".$data->image;
                  }
                  else{
                      $path=asset('public/upload/default.jpg');
                  }
                  ?>
               <div class="adm-upload">
                  <span class="adm-upload-thumb"><img src="{{$path}}" alt="..." id="basic_img"></span>
                  <div class="adm-upload-control">
                     <input type="hidden" name="real_basic_img" id="real_basic_img" value="<?= isset($data->image)?$data->image:""?>"/>
                     <input type="hidden" name="basic_img" id="basic_img1"/>
                     @if(isset($data->image))
                     <input type="file" name="upload_image" id="upload_image" class="form-control" />
                     @else
                     <input type="file" class="form-control" required="" name="upload_image" id="upload_image" />
                     @endif
                     <span class="adm-upload-hint"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>PNG or JPG</span>
                  </div>
               </div>
            </div>

            <div class="col-md-6 adm-field">
               <label for="type">Select Category<span class="reqfield">*</span></label>
               <select class="form-control" name="type_id" id="type" @if(isset($data->type_id)) readonly @endif>
                  <option value="">--Select type--</option>
                  <option @if(isset($data->type) && $data->type == 'Package') selected @endif>Package</option>
                  <option @if(isset($data->type) && $data->type == 'Parameter') selected @endif>Parameter</option>
                  <option value="Profiles" @if(isset($data->type) && $data->type == 'Profiles') selected @endif>Test Profiles</option>
               </select>
            </div>
            <div class="col-md-6 adm-field"></div>

            <div class="col-md-6 adm-field parameter-hide">
               <label for="select_pera">Select Parameter</label>
               <select class="form-control select2" id="select_pera" name="select_pera">
                  @if($parameter->isEmpty())
                  @else
                  @foreach($parameter as $p_key => $p_value)
                  <option value="{{$p_value->id}}" <?=in_array($p_value->id,$ids)?'selected="selected"':''?>>{{$p_value->name}}</option>
                  @endforeach
                  @endif
               </select>
            </div>
            <div class="col-md-6 adm-field package-hide">
               <label for="select_package">Select Package</label>
               <select class="form-control select2" id="select_package" name="select_package">
                  @if($packages->isEmpty())
                  @else
                  @foreach($packages as $p_key => $p_value)
                  <option value="{{$p_value->id}}" <?=in_array($p_value->id,$ids)?'selected="selected"':''?>>{{$p_value->name}}</option>
                  @endforeach
                  @endif
               </select>
            </div>
            <div class="col-md-6 adm-field test-hide">
               <label for="select_test">Select Test</label>
               <select class="form-control select2" id="select_test" name="select_test">
                  @if($test->isEmpty())
                  @else
                  @foreach($test as $t_key => $t_value)
                  <option value="{{$t_value->id}}" <?=in_array($t_value->id,$ids)?'selected="selected"':''?>>{{$t_value->profile_name}}</option>
                  @endforeach
                  @endif
               </select>
            </div>

            <div class="col-12 adm-form-actions">
               @if(Session::get("is_demo")==1)
               <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                  Save Offer
               </button>
               @else
               <button type="submit" class="btn btn-success adm-btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                  Save Offer
               </button>
               @endif
               <a href="{{route('admin-offer')}}" class="btn-secondary">{{__("message.Cancel")}}</a>
            </div>
         </div>
      </form>
   </div>
</div>

<script>
   /* ==========================================================================
      Redesign notes: markup/classes only. Field names and the type-based
      show/hide logic are unchanged. Fixed the page title, which read "Save
      Category" (copy-pasted from the Category module) instead of "Save
      Offer" — the breadcrumb's last crumb already correctly said "Save
      Offer", so the two were inconsistent on the same page.
      Consolidated the redundant jQuery 3.6.0 CDN <script> tag into the
      existing wait-for-jQuery convention used elsewhere in this codebase
      (deferring to window 'load', by which point the layout's own
      jquery.min.js — loaded near the bottom of <body> — has executed).
      Verified before/after with a real render: with the CDN tag removed
      and no load-deferral, this silently breaks (confirmed the hard way
      on the Coupon module's equivalent page); deferring to 'load' here
      renders identically to the original CDN-script version.
      ========================================================================== */
   window.addEventListener('load', function () {
      var tries = 0;
      (function hook() {
         var jq = window.jQuery;
         if (jq) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });

   function init(jq) {
      jq('.package-hide').hide();
      jq('.parameter-hide').hide();
      jq('.test-hide').hide();

      if (jq('#type').val() == 'Package') {
         jq('.package-hide').show();
         jq('.test-hide').hide();
         jq('.parameter-hide').hide();
      }
      if (jq('#type').val() == 'Profiles') {
         jq('.package-hide').hide();
         jq('.test-hide').show();
         jq('.parameter-hide').hide();
      }
      if (jq('#type').val() == 'Parameter') {
         jq('.package-hide').hide();
         jq('.test-hide').hide();
         jq('.parameter-hide').show();
      }
      jq('#type').on('change', function (e) {
         if (this.value == 'Package') {
            jq('.package-hide').show();
            jq('.test-hide').hide();
            jq('.parameter-hide').hide();
         }
         if (this.value == 'Parameter') {
            jq('.package-hide').hide();
            jq('.test-hide').hide();
            jq('.parameter-hide').show();
         }
         if (this.value == 'Profiles') {
            jq('.package-hide').hide();
            jq('.test-hide').show();
            jq('.parameter-hide').hide();
         }
      });
   }
</script>
@endsection
