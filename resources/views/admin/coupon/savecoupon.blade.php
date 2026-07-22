@extends('admin.layout.index')
@section('title')
Coupon
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">Save Coupon</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin-coupon')}}">Coupon</a></li>
            <li class="breadcrumb-item active">Save Coupon</li>
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

{{-- ============ Save coupon form card ============ --}}
<div class="adm-form adm-form-page">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.25L3 3a1 1 0 0 0-1 1l.25 6.59a2 2 0 0 0 .58 1.42l9.59 9.59a2 2 0 0 0 2.82 0l5.35-5.35a2 2 0 0 0 0-2.83Z"/><circle cx="7.5" cy="7.5" r="1.5"/></svg>
            Save Coupon
         </div>
      </div>
      <form action="{{route('update-coupon')}}" method="post" enctype="multipart/form-data">
         {{csrf_field()}}
         <input type="hidden" name="id" id="id" value="{{$id}}">
         <div class="row">
            <div class="col-md-6 adm-field">
               <label for="name">Coupon Code<span class="reqfield">*</span></label>
               <input type="text" id="name" name="coupon_code" class="form-control" placeholder='Coupon Code' required="" value="{{isset($data->coupon_code)?$data->coupon_code:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="available_for_select">Available For<span class="reqfield">*</span></label>
               <select class="form-control" id="available_for_select" name="available_for">
                  <option value="user" @if(isset($data->available_for) && $data->available_for == 'user') selected @endif>User</option>
                  <option value="admin" @if(isset($data->available_for) && $data->available_for == 'admin') selected @endif>Admin</option>
               </select>
            </div>

            <div class="col-md-6 adm-field">
               <label for="type">Type<span class="reqfield">*</span></label>
               <select class="form-control" name="type" id="type">
                  <option value="4">All</option>
                  <option value="1" @if(isset($data->coupon_code) && $data->type == 1) selected @endif>Package</option>
                  <option value="2" @if(isset($data->coupon_code) && $data->type == 2) selected @endif>Parameter</option>
                  <option value="3" @if(isset($data->coupon_code) && $data->type == 3) selected @endif>Test</option>
               </select>
            </div>
            <div class="col-md-6 adm-field"></div>

            <?php $arr = array();
                  if(isset($data->product_ids)){
                        $arr = explode(",",$data->product_ids);
                  }
            ?>
            <div class="col-md-6 adm-field parameter-hide">
               <label for="select_pera">Select Parameter</label>
               <select class="form-control select2" id="select_pera" multiple name="select_pera[]">
                  @if($parameter->isEmpty())
                  @else
                  <option value="all">All</option>
                  @foreach($parameter as $p_key => $p_value)
                  <option value="{{$p_value->id}}" <?=in_array($p_value->id,$arr)?'selected="selected"':''?>>{{$p_value->name}}</option>
                  @endforeach
                  @endif
               </select>
            </div>
            <div class="col-md-6 adm-field package-hide">
               <label for="select_package">Select Package</label>
               <select class="form-control select2" id="select_package" multiple name="select_package[]">
                  @if($packages->isEmpty())
                  @else
                  @foreach($packages as $p_key => $p_value)
                  <option value="{{$p_value->id}}" <?=in_array($p_value->id,$arr)?'selected="selected"':''?>>{{$p_value->name}}</option>
                  @endforeach
                  @endif
               </select>
            </div>
            <div class="col-md-6 adm-field test-hide">
               <label for="select_test">Select Test</label>
               <select class="form-control select2" id="select_test" multiple name="select_test[]">
                  @if($test->isEmpty())
                  @else
                  @foreach($test as $t_key => $t_value)
                  <option value="{{$t_value->id}}" <?=in_array($t_value->id,$arr)?'selected="selected"':''?>>{{$t_value->profile_name}}</option>
                  @endforeach
                  @endif
               </select>
            </div>

            <?php $dayArr = array();
                  if(isset($data->day)){
                        $dayArr = explode(",",$data->day);
                  }
            ?>
            <div class="col-md-6 adm-field">
               <label for="day_select">Select Days</label>
               <select class="form-control select2" id="day_select" multiple name="day[]">
                  @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                  <option value="{{ $day }}" <?=in_array($day,$dayArr)?'selected="selected"':''?>>{{ $day }}</option>
                  @endforeach
               </select>
            </div>

            <div class="col-md-6 adm-field">
               <label for="coupon_type">Coupon Type</label>
               <select class="form-control" id="coupon_type" name="coupon_type">
                  <option value="fixed">Fixed</option>
                  <option value="percent">Percent</option>
               </select>
               @error('coupon_type')
               <span class="invalid-feedback" role="alert">
               <strong style="color: red">{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="col-md-6 adm-field">
               <label for="coupon_value">Coupon Value</label>
               <input type="text" id="coupon_value" class="form-control price-input" placeholder="Coupon Value" name="coupon_value" value="{{isset($data->coupon_value)?$data->coupon_value:''}}">
               @error('coupon_value')
               <span class="invalid-feedback" role="alert">
               <strong style="color: red">{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="col-md-6 adm-field">
               <label for="coupon_start_date">Coupon Start Date</label>
               <input type="date" id="coupon_start_date" class="form-control datepicker" placeholder="Coupon Start Date" name="coupon_start_date" value="{{isset($data->coupon_start_date)?$data->coupon_start_date:''}}">
               @error('coupon_start_date')
               <span class="invalid-feedback" role="alert">
               <strong style="color: red">{{ $message }}</strong>
               </span>
               @enderror
            </div>
            <div class="col-md-6 adm-field">
               <label for="coupon_end_date">Coupon End Date</label>
               <input type="date" id="coupon_end_date" class="form-control datepicker" placeholder="Coupon End Date" name="coupon_end_date" value="{{isset($data->coupon_end_date)?$data->coupon_end_date:''}}">
               @error('coupon_end_date')
               <span class="invalid-feedback" role="alert">
               <strong style="color: red">{{ $message }}</strong>
               </span>
               @enderror
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
               <a href="{{route('admin-coupon')}}" class="btn-secondary">{{__("message.Cancel")}}</a>
            </div>
         </div>
      </form>
   </div>
</div>

<script>
   /* ==========================================================================
      Redesign notes: markup/classes only. Field names, the type-based
      show/hide logic, the price-input numeric guard, and the "select all"
      behaviour for the Parameter multi-select are unchanged from before.
      Fixed the breadcrumb + Cancel link, which pointed to
      route('admin-subcategory') instead of route('admin-coupon').
      Genuine bug fixed: this whole block used to run inside a bare
      $(document).ready(...) call, but jQuery's own <script> tag is placed
      near the bottom of the layout (after this content section), so $ was
      undefined at the time this script executed — every call below threw
      "$ is not defined" and was silently skipped. In practice this meant
      the Select Package/Parameter/Test show-only-the-relevant-one behavior,
      the numeric guard on Coupon Value, and the "select all" convenience
      option never actually ran. Now deferred to window 'load' (same
      wait-for-jQuery pattern already used elsewhere, e.g. Parameter's save
      page), by which point jQuery has loaded.
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
      jq('.price-input').on('keypress', function (e) {
          return isNumber(e, this, jq)
      });
      jq('.package-hide').hide();
      jq('.parameter-hide').hide();
      jq('.test-hide').hide();

       if(jq('#type').val()==1){
          jq('.package-hide').show();
          jq('.test-hide').hide();
          jq('.parameter-hide').hide();
      }
      if(jq('#type').val()==3){
          jq('.package-hide').hide();
          jq('.test-hide').show();
          jq('.parameter-hide').hide();
      }
       if(jq('#type').val()==2){
          jq('.package-hide').hide();
          jq('.test-hide').hide();
          jq('.parameter-hide').show();
      }
      jq('#type').on('change', function (e) {
          if(this.value== 1){
              jq('.package-hide').show();
              jq('.test-hide').hide();
               jq('.parameter-hide').hide();
          }
          if(this.value ==2){
          jq('.package-hide').hide();
          jq('.test-hide').hide();
          jq('.parameter-hide').show();
      }
              if(this.value==3){
              jq('.package-hide').hide();
              jq('.test-hide').show();
              jq('.parameter-hide').hide();
      }
      });

      jq('#select_pera').on('change', function () {
         let selected = jq(this).val();

         // If "Select All" is selected
         if (selected && selected.includes('all')) {

             // Select all except "all"
             let allValues = [];
             jq('#select_pera option').each(function () {
                 if (jq(this).val() !== 'all') {
                     allValues.push(jq(this).val());
                 }
             });

             jq('#select_pera').val(allValues).trigger('change.select2');
         }
      });
   }

   function isNumber(e, element, jq) {
       var charCode = (e.which) ? e.which : event.keyCode
       if (
           (charCode != 45 || jq(element).val().indexOf('-') != -1) && // Check minus and only once.
           (charCode != 46 || jq(element).val().indexOf('.') != -1) &&  // Check dot and only once.
           (charCode < 48 || charCode > 57))
           return false;
       return true;
   }
</script>
@endsection
