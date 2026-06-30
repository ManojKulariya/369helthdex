@extends('admin.layout.index')
@section('title')
{{__("message.Save Category")}}
@stop
@section('content')
<div class="page-header">
	<h3 class="page-title">{{__("message.Save Category")}} </h3>
	<div class="col-sm-6">
      @if(__("message.Is_rtl")=='1')
             <ol class="breadcrumb float-sm-left">
         @else
            <ol class="breadcrumb float-sm-right">
         @endif
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item"><a href="{{route('admin-category')}}">{{__("message.Category")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Save Category")}}</li>
      </ol>
   </div>	      	
</div>
<div class="row" style="display: flex;justify-content: center;">
	<div class="col-6 grid-margin stretch-card">
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
            <form action="{{route('update-category')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               	<input type="hidden" name="id" id="id" value="{{$id}}">
                  <div class="form-group">
                     <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="name" class="form-control" placeholder='{{__("message.Enter Category Name")}}' required="" value="{{isset($data->name)?$data->name:''}}">
                  </div>
                 	<div class="form-group">
                     <label for="name">{{__("message.Category Image")}}<span class="reqfield">*</span></label>
                     <div id="uploaded_image">
                        <div class="upload-btn-wrapper">
                           <button class="btn imgcatlog">
                           <input type="hidden" name="real_basic_img" id="real_basic_img" value="<?= isset($data->image)?$data->image:""?>"/>
                           <?php 
                              if(isset($data->image)){
                                  $path=env('APP_URL')."storage/app/public/category"."/".$data->image;
                              }
                              else{
                                  $path=asset('public/upload/default.jpg');
                              }
                              ?>
                           <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" >
                           </button>
                           <input type="hidden" name="basic_img" id="basic_img1"/>
                           @if(isset($data->image))
                           <input type="file" name="upload_image" id="upload_image" class="form-control" />
                           @else
                            <input type="file" class="form-control" required="" name="upload_image" id="upload_image" />
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-12">
                     	 @if(Session::get("is_demo")==1)
                        <input type="button" value='{{__("message.Save Category")}}' class="btn btn-success" onclick="disablebtn()">
                         @else
                        <input type="submit" value='{{__("message.Save Category")}}' class="btn btn-success">
                         @endif
                        <a href="{{route('admin-category')}}" class="btn btn-danger">{{__("message.Cancel")}}</a>
                     </div>
                  </div>
           	</form>
       	</div>
     </div>
</div>
@endsection