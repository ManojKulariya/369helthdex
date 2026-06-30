@extends('admin.layout.index')
@section('title')
{{__("message.Save City")}}
@stop
@section('content')
<div class="page-header">
	<h3 class="page-title">Save Location </h3>
	<div class="col-sm-6">
      @if(__("message.Is_rtl")=='1')
             <ol class="breadcrumb float-sm-left">
         @else
            <ol class="breadcrumb float-sm-right">
         @endif
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item"><a href="{{route('admin-category')}}">{{__("message.City")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Save City")}}</li>
      </ol>
   </div>	      	
</div>
<div class="row">
	<div class="col-12 grid-margin stretch-card">
     <div class="card">
       	<div class="card-body">
       		@if(Session::has('message'))
      		<div class="col-sm-12">
               <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
            </div>
      		@endif
            <form action="{{route('update-city')}}" method="post" enctype="multipart/form-data" class="row">
               {{csrf_field()}}
               	<input type="hidden" name="id" id="id" value="{{$id}}">
                  <div class="form-group col-6">
                     <label for="name">Location<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="name" class="form-control" placeholder='Location ' required="" value="{{isset($data->name)?$data->name:''}}">
                  </div>  
                   <div class="form-group col-6">
                     <label for="name">City<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="city" class="form-control" placeholder='city ' required="" value="{{isset($data->city)?$data->city:''}}">
                  </div>  
                   <div class="form-group col-6">
                     <label for="name">Default<span class="reqfield">*</span></label>
                     <select name="default" class="form-control">
                         
                         <option value="No" <?= isset($data->default)&& "No" ==$data->default?'selected="selected"':''?>>No</option>
                         <option value="Yes" <?= isset($data->default)&& "Yes" ==$data->default?'selected="selected"':''?>>Yes</option>
                     </select>
                  </div> 
                  <div class="form-group col-6">
                     <label for="name">Latitude<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="lat" class="form-control" placeholder='Latitude' required="" value="{{isset($data->lat)?$data->lat:''}}">
                  </div> 
                  <div class="form-group col-6">
                     <label for="name">Longitude<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="lng" class="form-control" placeholder='Longitude' required="" value="{{isset($data->lng)?$data->lng:''}}">
                  </div> 
                  <div class="row">
                     <div class="col-12">
                     	  @if(Session::get("is_demo")==1)  
                             <input type="button" value='Save Location' class="btn btn-success" onclick="disablebtn()">
                          @else
                             <input type="submit" value='Save Location' class="btn btn-success">
                          @endif
                        <a href="{{route('admin-category')}}" class="btn btn-danger">{{__("message.Cancel")}}</a>
                     </div>
                  </div>
           	</form>
       	</div>
     </div>
</div>
@endsection