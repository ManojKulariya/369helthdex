@extends('admin.layout.index')
@section('title')
Save Vacancie
@stop
@section('content')
<div class="page-header">
	<h3 class="page-title">Save Vacancie </h3>
	<div class="col-sm-6">
      @if(__("message.Is_rtl")=='1')
             <ol class="breadcrumb float-sm-left">
         @else
            <ol class="breadcrumb float-sm-right">
         @endif
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item"><a href="{{route('admin-offer')}}">{{__("message.Category")}}</a></li>
         <li class="breadcrumb-item active">Save Offer</li>
      </ol>
   </div>	      	
</div>
<div class="row" style="display: flex;justify-content: center;">
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
            <form action="{{route('update-job')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               	<input type="hidden" name="id" id="id" value="{{$id}}">
               	<div class="row">
                  <div class="form-group col-6">
                     <label for="name">Job Title<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="title" class="form-control" placeholder='Enter Job Title' required="" value="{{isset($data->title)?$data->title:''}}">
                  </div>
                  <div class="form-group col-6">
                     <label for="name">No of Opening<span class="reqfield">*</span></label>
                     <input type="number" id="name" name="openings" class="form-control" placeholder='No of Opening' required="" value="{{isset($data->openings)?$data->openings:''}}">
                  </div>
                  <div class="form-group col-6">
                     <label for="name">Location<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="locations" class="form-control" placeholder='Enter Location' required="" value="{{isset($data->locations)?$data->locations:''}}">
                  </div>
                  <div class="form-group col-6">
                     <label for="name">Experince<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="experince" class="form-control" placeholder='Enter Experince' required="" value="{{isset($data->experince)?$data->experince:''}}">
                  </div>
                  <div class="form-group col-6">
                     <label for="name">Qualification<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="qualification" class="form-control" placeholder='Enter Qualification' required="" value="{{isset($data->qualification)?$data->qualification:''}}">
                  </div>
                  <div class="form-group col-6">
                     <label for="name">Skills<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="skills" class="form-control" placeholder='Enter Skills' required="" value="{{isset($data->skills)?$data->skills:''}}">
                  </div>
                   <div class="form-group col-6">
                     <label for="name">Department<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="department" class="form-control" placeholder='Enter Department' required="" value="{{isset($data->department)?$data->department:''}}">
                  </div>
                   <div class="form-group col-6">
                     <label for="name">Designations<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="designations" class="form-control" placeholder='Enter Designations' required="" value="{{isset($data->designations)?$data->designations:''}}">
                  </div>
                  <div class="form-group col-6">
                     <label for="name">Salary<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="salary" class="form-control" placeholder='Enter Salary' required="" value="{{isset($data->salary)?$data->salary:''}}">
                  </div>
                  <div class="form-group col-6">
                     <label for="name">Status<span class="reqfield">*</span></label>
                        <select name="status" class="form-control">
                            <option value="1" {{ isset($data->status) && $data->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ isset($data->status) && $data->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>

                  </div>
                  <div class="form-group">
                     <label for="name">{{__("message.Description")}}<span class="reqfield">*</span></label>
                     <textarea id="description" name="description" required class="ckeditor form-control">
                        {{isset($data->description)?$data->description:''}}
                     </textarea>                           
                  </div>
                 </div>
                  <div class="row">
                     <div class="col-12">
                     	 @if(Session::get("is_demo")==1)
                        <input type="button" value='Save' class="btn btn-success" onclick="disablebtn()">
                         @else
                        <input type="submit" value='Save' class="btn btn-success">
                         @endif
                        <a href="{{route('admin-offer')}}" class="btn btn-danger">{{__("message.Cancel")}}</a>
                     </div>
                  </div>
           	</form>
       	</div>
     </div>
</div>
@endsection