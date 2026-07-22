@extends('admin.layout.index')
@section('title')
{{__("message.Save Manager Profile")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">Save Branch</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('manager')}}">Branches</a></li>
            <li class="breadcrumb-item active">Save Branch</li>
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

{{-- ============ Save Branch form card ============ --}}
<div class="adm-form adm-form-page" style="max-width: 780px;">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
            Save Branch
         </div>
      </div>
      <form action="{{route('update-manager-profile-admin')}}" method="post" enctype="multipart/form-data">
         {{csrf_field()}}
         <input type="hidden" name="id" value="{{$id}}">
         <div class="row">
            <div class="col-md-6 adm-field">
               <label for="name">{{__("message.Name")}}</label>
               <input type="text" required class="form-control" id="name" name="name" placeholder="{{__('message.Enter Name')}}" value="{{isset($data->name)?$data->name:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="company_name">Company {{__("message.Name")}}</label>
               <input type="text" required class="form-control" id="company_name" name="company_name" placeholder="Company {{__('message.Enter Name')}}" value="{{isset($data->company_name)?$data->company_name:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="branch_code">Branch Code</label>
               <input type="text" required class="form-control" id="branch_code" name="branch_code" placeholder="Branch Code" value="{{isset($data->branch_code)?$data->branch_code:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="email">{{ __("message.Email Id") }}</label>
               <input type="text" required class="form-control" id="email" name="email" placeholder="{{__('message.Enter Emial')}}" value="{{isset($data->email)?$data->email:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="phone">{{ __("message.Phone") }}</label>
               <input type="text" required class="form-control" id="phone" name="phone" placeholder="{{__('message.Enter Phone')}}" value="{{isset($data->phone)?$data->phone:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="city">{{__('message.City')}}</label>
               <select class="form-control" name="city" id="city" required="">
                  <option value="">{{__('message.Select City')}}</option>
                  @foreach($city as $c)
                  <option value="{{$c->id}}" <?= isset($data->city)&&$data->city==$c->id?'selected="selected"':''?>>{{$c->name}}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-md-6 adm-field">
               <label for="upload_image">{{__("message.Profile Image")}} <span class="reqfield">*</span></label>
               <?php
                   if(isset($data->profile_pic)){
                       $path= env('APP_URL')."/storage/profile/".$data->profile_pic;
                   }
                   else{
                       $path=asset('public/upload/default.jpg');
                   }
               ?>
               <div class="adm-upload">
                  <span class="adm-upload-thumb"><img src="{{$path}}" alt="..." id="basic_img"></span>
                  <div class="adm-upload-control">
                     <input type="hidden" id="basic_img1"/>
                     @if(isset($data->profile_pic))
                     <input type="file" name="upload_image" class="form-control" id="upload_image" />
                     @else
                     <input type="file" required="" class="form-control" name="upload_image" id="upload_image" />
                     @endif
                     <span class="adm-upload-hint"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>PNG or JPG</span>
                  </div>
               </div>
            </div>
            <div class="col-md-6 adm-field">
               <label for="address">Full Address</label>
               <textarea class="form-control" id="address" name="address" placeholder="Full Address" required>{{isset($data->address)?$data->address:''}}</textarea>
            </div>
            <div class="col-12 adm-field">
               <label for="description">Description</label>
               <textarea class="form-control" id="description" name="description" placeholder="Description" required>{{isset($data->description)?$data->description:''}}</textarea>
            </div>
            <div class="col-md-6 adm-field">
               <label for="password">{{__('message.password')}}</label>
               <input type="password" class="form-control" id="password" name="password" placeholder="{{__('message.Enter Password')}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="cpassword">{{__('message.Confirm Password')}}</label>
               <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="{{__('message.Enter Confirm Password')}}">
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
               <a href="{{route('manager')}}" class="btn-secondary">{{__("message.Cancel")}}</a>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection
