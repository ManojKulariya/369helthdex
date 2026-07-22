@extends('admin.layout.index')
@section('title')
{{__("message.Change Password")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.Change Password")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.Change Password")}}</li>
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

{{-- ============ Change Password form card ============ --}}
<div class="adm-form adm-form-page">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            {{__("message.Change Password")}}
         </div>
      </div>
      <form action="{{route('update_admin_change_password')}}" method="post">
         {{csrf_field()}}
         <div class="row">
            <div class="col-12 adm-field">
               <label for="oldPassword">{{__("message.Old Password")}}</label>
               <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="{{__('message.Old Password')}}" onchange="checkcurrentpwd(this.value)">
               <input type="hidden" name="cpwd" id="cpwd" value="{{__('message.Please Enter Correct Cureent Password')}}">
            </div>
            <div class="col-12 adm-field">
               <label for="newPassword">{{__("message.New Password")}}</label>
               <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="{{__('message.New Password')}}">
            </div>
            <div class="col-12 adm-field">
               <label for="confirmPassword">{{__("message.Confirm Password")}}</label>
               <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="{{__('message.Confirm Password')}}" onchange="checkbothpassword(this.value)">
               <input type="hidden" name="newpwd" id="newpwd" value="{{__('message.New Password And Re Enter Password Must Be Same')}}">
            </div>
            <div class="col-12 adm-form-actions">
               @if(Session::get("is_demo")==1)
               <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                  {{__('message.Change Password')}}
               </button>
               @else
               <button type="submit" class="btn btn-success adm-btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                  {{__('message.Change Password')}}
               </button>
               @endif
               <a href="{{route('admin-dashboard')}}" class="btn-secondary">{{__("message.Cancel")}}</a>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection
