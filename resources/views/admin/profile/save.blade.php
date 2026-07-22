@extends('admin.layout.index')
@section('title')
{{__("message.Save Profile")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.Save Profile")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('profiles')}}">{{__("message.Profiles")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.Save Profile")}}</li>
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

{{-- ============ Save Profile form card ============ --}}
<div class="adm-form adm-form-page adm-form-page--wide">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
            {{__("message.Save Profile")}}
         </div>
      </div>
      <form action="{{route('update-profile')}}" method="post" enctype="multipart/form-data">
         {{csrf_field()}}
         <input type="hidden" name="id" id="id" value="{{$id}}">
         <div class="row">
            <div class="col-md-6 adm-field">
               <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
               <input type="text" id="name" name="name" class="form-control" placeholder='{{__("message.Enter Profile Name")}}' required="" value="{{isset($data->profile_name)?$data->profile_name:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="sort_order">Sort Order<span class="reqfield">*</span></label>
               <input type="number" id="sort_order" name="sort_order" class="form-control" min="1" max="100" value="{{isset($data->sort_order)?$data->sort_order:'0'}}">
            </div>
            <div class="col-12 adm-field">
               <label for="short_desc">{{__("message.Short Description")}}</label>
               <input type="text" id="short_desc" name="short_desc" class="form-control" placeholder='{{__("message.Enter Short Description")}}' value="{{isset($data->short_desc)?$data->short_desc:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="mrps">{{__("message.MRP")}}<span class="reqfield">*</span></label>
               <input type="number" step="0.00" id="mrps" name="mrp" class="form-control" placeholder='{{__("message.Enter MRP")}}' required="" value="{{isset($data->mrp)?$data->mrp:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="category_select">{{__("message.Category")}}<span class="reqfield">*</span></label>
               <select id="category_select" name="category[]" required="" class="form-control select2" multiple>
                  <?php $arr = array();
                  if(isset($data->category_id)){
                        $arr = explode(",",$data->category_id);
                  }
                  ?>
                  <option value="">{{__("message.Select Category")}}</option>
                  @foreach($category as $c)
                  <option value="{{$c->id}}" <?=in_array($c->id,$arr)?'selected="selected"':''?>>{{$c->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-12 adm-field">
               <label style="display:inline-flex;align-items:center;gap:.5rem;text-transform:none;">
                  <input type="checkbox" name="is_featured" value="0" {{ isset($data->is_featured) && $data->is_featured ? 'checked' : '' }}> Is Featured?
               </label>
            </div>
            <div class="col-12 adm-field">
               <label for="description">{{__("message.Description")}}<span class="reqfield">*</span></label>
               <textarea id="description" name="description" required class="ckeditor form-control">{{isset($data->description)?$data->description:''}}</textarea>
            </div>
            <div class="col-12 adm-field">
               <label for="report_time">{{__("message.Report Time")}}<span class="reqfield">*</span></label>
               <input type="text" id="report_time" name="report_time" class="form-control" placeholder='{{__("message.Enter Report Time")}}' required="" value="{{isset($data->report_time)?$data->report_time:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="sample_collection">{{__("message.Sample Collection")}}<span class="reqfield">*</span></label>
               <select id="sample_collection" name="sample_collection" class="form-control" required="" onchange="samplecollectionchange(this.value)">
                  <option value="1" <?=isset($data->sample_collection)&&$data->sample_collection=='1'?'selected="selected"':''?>>{{__("message.Free")}}</option>
                  <option value="2" <?=isset($data->sample_collection)&&$data->sample_collection=='2'?'selected="selected"':''?>>{{__("message.Paid")}}</option>
               </select>
            </div>
            <div class="col-md-6 adm-field">
               <label for="sample_type_select">Sample Type<span class="reqfield">*</span></label>
               <select id="sample_type_select" name="sample_type[]" class="form-control select2" multiple required="">
                  <?php $arrs = array();
                  if(isset($data->sample_type)){
                        $arrs = explode(",",$data->sample_type);
                  }
                  ?>
                  <option value="">--Select SampleType--</option>
                  @foreach($sampleType as $sample)
                  <option value="{{$sample->id}}" <?=in_array($sample->id,$arrs)?'selected="selected"':''?>>{{$sample->sample_name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-md-6 adm-field" id="sample_collection_fee_div" @if(!(isset($data->sample_collection_fee)&&$data->sample_collection_fee!="")) style="display:none;" @endif>
               <label for="sample_collection_fee">{{__("message.Sample Collection Fee")}}<span class="reqfield">*</span></label>
               <input type="text" id="sample_collection_fee" name="sample_collection_fee" class="form-control" placeholder='{{__("message.Enter Sample Collection Fee")}}' value="{{isset($data->sample_collection_fee)?$data->sample_collection_fee:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="fasting_time">{{__("message.Is Fast Required")}}<span class="reqfield">*</span></label>
               <select id="fasting_time" name="fasting_time" class="form-control" required="" onchange="fasttimedivhcnage(this.value)">
                  <option value="0" <?=isset($data->fasting_time)&&$data->fasting_time=='0'?'selected="selected"':''?>>{{__("message.No")}}</option>
                  <option value="1" <?=isset($data->fasting_time)&&$data->fasting_time=='1'?'selected="selected"':''?>>{{__("message.Yes")}}</option>
               </select>
            </div>
            <div class="col-md-6 adm-field" id="fast_time_div" @if(!isset($data->fast_time)) style="display:none;" @endif>
               <label for="fast_time">{{__("message.Fast Time")}}<span class="reqfield">*</span></label>
               <input type="text" id="fast_time" name="fast_time" class="form-control" placeholder='{{__("message.Enter Fast Time")}}' value="{{isset($data->fast_time)?$data->fast_time:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label>Tag <span class="reqfield">(Enter tag coma separated )*</span></label>
               <input type="text" name="tag" class="form-control" value="{{isset($data->tag)?$data->tag:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="test_recommended_for">{{__("message.Test Recommended For")}}<span class="reqfield">*</span></label>
               <?php $arr = array(); isset($data->test_recommended_for)?$arr = explode(",",$data->test_recommended_for):''; ?>
               <select id="test_recommended_for" name="test_recommended_for[]" class="form-control select2" required="" multiple>
                  <option value="Male" <?=isset($data->test_recommended_for)&&in_array("Male", $arr)?'selected="selected"':''?>>{{__("message.Male")}}</option>
                  <option value="Female" <?=isset($data->test_recommended_for)&&in_array("Female", $arr)?'selected="selected"':''?>>{{__("message.Female")}}</option>
               </select>
            </div>
            <div class="col-md-6 adm-field">
               <label for="test_recommended_for_age">{{__("message.Recommended For Age")}}<span class="reqfield">*</span></label>
               <input type="text" id="test_recommended_for_age" name="test_recommended_for_age" class="form-control" placeholder='{{__("message.Enter Age Recommended For Report")}}' required="" value="{{isset($data->test_recommended_for_age)?$data->test_recommended_for_age:''}}">
            </div>
            <div class="col-12 adm-field">
               <label for="lab_report">{{__("message.Sample Lab Report")}}<span class="reqfield">*</span></label>
               <input type="file" id="lab_report" name="lab_report" class="form-control" @if(!isset($data->lab_report)) required="" @endif>
            </div>
            <div class="col-12 adm-field">
               <label for="parameter_select">{{__("message.Select Parameter")}}</label>
               <?php $arr = array();
                     if(isset($data->no_of_parameter)){
                           $arr = explode(",",$data->no_of_parameter);
                     }
               ?>
               <select id="parameter_select" class="form-control select2" name="no_of_parameter[]" data-placeholder="Choose Browser" multiple>
                  @foreach($get_parameter as $p)
                  <option value="{{$p->id}}" <?=in_array($p->id,$arr)?'selected="selected"':''?>>{{$p->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-12 adm-field">
               <label class="form-label">Branch User</label>
               <div style="margin-bottom:.6rem;">
                  <label style="display:inline-flex;align-items:center;gap:.5rem;text-transform:none;">
                     <input type="checkbox" id="check-all" onclick="toggleCheckboxes(this)"> Check All
                  </label>
               </div>
               <?php $arruser = array();
                     if(isset($data->branch_id)){
                           $arruser = $data->branch_id;
                     }
               ?>
               <div class="adm-table-wrap">
                  <table class="table adm-orders-table no-footer">
                     <thead>
                        <tr>
                           <th style="width:6%"></th>
                           <th style="width:48%">Center</th>
                           <th style="width:23%">Price</th>
                           <th style="width:23%">Saleable Price</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($branch as $row)
                        @php
                            $profileBranch = optional($data->branches ?? collect())->where('profile_id',$id)->where('branch_id', $row->id)->first();
                        @endphp
                        <tr>
                           <td><input type="checkbox" name="branch_id[]" value="{{ $row->id }}" {{ in_array($row->id, $arruser) ? 'checked' : '' }}></td>
                           <td>{{ $row->name }} - {{ $row->company_name }}</td>
                           <td><input type="text" name="branchmrp[{{ $row->id }}]" value="{{ $profileBranch->price ?? '' }}" class="form-control"></td>
                           <td><input type="text" name="branchprice[{{ $row->id }}]" value="{{ $profileBranch->mrp ?? '' }}" class="form-control"></td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
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
</div>

<script>
   function toggleCheckboxes(source) {
      var checkboxes = document.querySelectorAll('input[name="branch_id[]"]');
      for (var i = 0; i < checkboxes.length; i++) {
         checkboxes[i].checked = source.checked;
      }
   }
</script>
@endsection
