@extends('admin.layout.index')
@section('title')
{{__("message.Save City")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">Save Location</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin-city')}}">{{__("message.City")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.Save City")}}</li>
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

{{-- ============ Save location form card ============ --}}
<div class="adm-form adm-form-page">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            Save Location
         </div>
      </div>
      <form action="{{route('update-city')}}" method="post" enctype="multipart/form-data">
         {{csrf_field()}}
         <input type="hidden" name="id" id="id" value="{{$id}}">
         <div class="row">
            <div class="col-md-6 adm-field">
               <label for="location_name">Location<span class="reqfield">*</span></label>
               <input type="text" id="location_name" name="name" class="form-control" placeholder="Location" required="" value="{{isset($data->name)?$data->name:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="city_name_field">City<span class="reqfield">*</span></label>
               <input type="text" id="city_name_field" name="city" class="form-control" placeholder="City" required="" value="{{isset($data->city)?$data->city:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="default_select">Default<span class="reqfield">*</span></label>
               <select id="default_select" name="default" class="form-control">
                  <option value="No" <?= isset($data->default)&& "No" ==$data->default?'selected="selected"':''?>>No</option>
                  <option value="Yes" <?= isset($data->default)&& "Yes" ==$data->default?'selected="selected"':''?>>Yes</option>
               </select>
            </div>
            <div class="col-md-6 adm-field"></div>
            <div class="col-md-6 adm-field">
               <label for="lat_field">Latitude<span class="reqfield">*</span></label>
               <input type="text" id="lat_field" name="lat" class="form-control" placeholder="Latitude" required="" value="{{isset($data->lat)?$data->lat:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="lng_field">Longitude<span class="reqfield">*</span></label>
               <input type="text" id="lng_field" name="lng" class="form-control" placeholder="Longitude" required="" value="{{isset($data->lng)?$data->lng:''}}">
            </div>
            <div class="col-12 adm-form-actions">
               @if(Session::get("is_demo")==1)
               <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                  Save Location
               </button>
               @else
               <button type="submit" class="btn btn-success adm-btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                  Save Location
               </button>
               @endif
               <a href="{{route('admin-city')}}" class="btn-secondary">{{__("message.Cancel")}}</a>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection
