@extends('admin.layout.index')
@section('title')
{{__("message.Save Popular Package")}}
@stop
@section('content')
<div class="page-header">
	<h3 class="page-title">{{__("message.Save Popular Package")}}</h3>
	<div class="col-sm-6">
      @if(__("message.Is_rtl")=='1')
             <ol class="breadcrumb float-sm-left">
         @else
            <ol class="breadcrumb float-sm-right">
         @endif
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item"><a href="{{route('popular-package')}}">Popular Package</a></li>
         <li class="breadcrumb-item active">{{__("message.Save Popular Package")}}</li>
      </ol>
   </div>	      	
</div>
<div class="row">
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
            <form action="{{route('update-popular-package')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               	<input type="hidden" name="id" id="id" value="{{$id}}">
                  <div class="form-group">
                     <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="name" class="form-control" placeholder='{{__("message.Enter Package Name")}}' required="" value="{{isset($data->name)?$data->name:''}}">
                  </div> 

                  <div class="row">
                      <div class="form-group col-md-6">
                           <label for="name">{{__("message.Type")}}<span class="reqfield">*</span></label>
                           <select class="form-control" name="type" id="type" onchange="changepopulartype(this.value)">
                              <option value="">{{__("message.Select Type")}}</option>
                              <option value="1" <?= isset($data->type)&&$data->type==1?'selected="selected"':''?> >Package</option>
                              <option value="2" <?= isset($data->type)&&$data->type==2?'selected="selected"':''?>>Parameter</option>
                              <option value="3" <?= isset($data->type)&&$data->type==3?'selected="selected"':''?>>Profile</option>
                           </select>
                      </div>
                      <div class="form-group col-md-6">
                           <label for="name">{{__("message.Type Id")}}<span class="reqfield">*</span></label>
                           <select class="form-control" name="type_id" id="type_id">
                              <option value="">{{__("message.Select Type Id")}}</option>
                               @if(isset($data->type_id)&&$data->type_id==1)
                                    @foreach($data->typedata as $dt)
                                       <option value="{{$dt->id}}" <?= isset($data->type_id)&&$data->type_id==$dt->id?'selected="selected"':''?> >{{$dt->name}}</option>
                                    @endforeach
                               @endif
                               @if(isset($data->type_id)&&$data->type_id==2)
                                    @foreach($data->typedata as $dt)
                                       <option value="{{$dt->id}}" <?= isset($data->type_id)&&$data->type_id==$dt->id?'selected="selected"':''?>>{{$dt->name}}</option>
                                    @endforeach
                               @endif
                               @if(isset($data->type_id)&&$data->type_id==3)
                                    @foreach($data->typedata as $dt)
                                       <option value="{{$dt->id}}" <?= isset($data->type_id)&&$data->type_id==$dt->id?'selected="selected"':''?>>{{$dt->profile_name}}</option>
                                    @endforeach
                               @endif
                                 
                           </select>
                      </div>
                  </div>
                   
                  <div class="row">
                     <div class="col-12">
                     	 @if(Session::get("is_demo")==1)
                      <button type="button" class="btn btn-success" onclick="disablebtn()">{{__('message.Save')}}</button>
                      @else
                     <button type="submit" class="btn btn-success">{{__('message.Save')}}</button>
                       @endif
                        
                     </div>
                  </div>
           	</form>
       	</div>
     </div>
</div>
@endsection