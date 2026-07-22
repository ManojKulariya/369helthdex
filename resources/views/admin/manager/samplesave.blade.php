@extends('admin.layout.index')
@section('title')
{{__("message.Save Manager Profile")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">Save Sample Boy</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('sampleuser')}}">SampleBoy</a></li>
            <li class="breadcrumb-item active">Save Sample Boy</li>
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

{{-- ============ Save Sample Boy form card ============ --}}
<div class="adm-form adm-form-page" style="max-width: 640px;">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
            Save Sample Boy
         </div>
      </div>
      <form action="{{route('update-manager-profile-admin-sample')}}" method="post" enctype="multipart/form-data">
         {{csrf_field()}}
         <input type="hidden" name="id" value="{{$id}}">
         <div class="row">
            <div class="col-md-6 adm-field">
               <label for="name">{{__("message.Name")}}</label>
               <input type="text" required class="form-control" id="name" name="name" placeholder="{{__('message.Enter Name')}}" value="{{isset($data->name)?$data->name:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="phone">{{ __("message.Phone") }}</label>
               <input type="text" required class="form-control" id="phone" name="phone" placeholder="{{__('message.Enter Phone')}}" value="{{isset($data->phone)?$data->phone:''}}">
            </div>
            <div class="col-12 adm-field">
               <label for="sample_branch">Select Lab</label>
               <select class="form-control select2" id="sample_branch" name="sample_branch">
                  <option value="">--Select Lab--</option>
                  @foreach($labs as $p_key => $p_value)
                  {{-- Previously checked $data->reciever_lab (a different,
                       always-null field for this user type) instead of the
                       actual sample_branch value that gets saved/read —
                       meaning the currently-assigned lab never showed as
                       selected when editing. --}}
                  <option value="{{$p_value->id}}" <?=isset($data->sample_branch)&&$data->sample_branch==$p_value->id?'selected="selected"':''?>>{{$p_value->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-12 adm-form-actions">
               @if(Session::get("is_demo")==1)
               <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                  Save Branch
               </button>
               @else
               <button type="submit" class="btn btn-success adm-btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                  Save Branch
               </button>
               @endif
               <a href="{{route('sampleuser')}}" class="btn-secondary">{{__("message.Cancel")}}</a>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection
