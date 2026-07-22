@extends('admin.layout.index')
@section('title')
Save Vacancie
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">Save Vacancie</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('vacancies')}}">Vacancies</a></li>
            <li class="breadcrumb-item active">Save Vacancie</li>
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

{{-- ============ Save vacancie form card ============ --}}
<div class="adm-form adm-form-page">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7h-3V6a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3v1H4a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8a1 1 0 0 0-1-1Z"/><path d="M9 6a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1H9Z"/></svg>
            Save Vacancie
         </div>
      </div>
      <form action="{{route('update-job')}}" method="post" enctype="multipart/form-data">
         {{csrf_field()}}
         <input type="hidden" name="id" id="id" value="{{$id}}">
         <div class="row">
            <div class="col-md-6 adm-field">
               <label for="job_title">Job Title<span class="reqfield">*</span></label>
               <input type="text" id="job_title" name="title" class="form-control" placeholder='Enter Job Title' required="" value="{{isset($data->title)?$data->title:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="openings">No of Opening<span class="reqfield">*</span></label>
               <input type="number" id="openings" name="openings" class="form-control" placeholder='No of Opening' required="" value="{{isset($data->openings)?$data->openings:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="job_locations">Location<span class="reqfield">*</span></label>
               <input type="text" id="job_locations" name="locations" class="form-control" placeholder='Enter Location' required="" value="{{isset($data->locations)?$data->locations:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="experince">Experince<span class="reqfield">*</span></label>
               <input type="text" id="experince" name="experince" class="form-control" placeholder='Enter Experince' required="" value="{{isset($data->experince)?$data->experince:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="qualification">Qualification<span class="reqfield">*</span></label>
               <input type="text" id="qualification" name="qualification" class="form-control" placeholder='Enter Qualification' required="" value="{{isset($data->qualification)?$data->qualification:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="skills">Skills<span class="reqfield">*</span></label>
               <input type="text" id="skills" name="skills" class="form-control" placeholder='Enter Skills' required="" value="{{isset($data->skills)?$data->skills:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="department">Department<span class="reqfield">*</span></label>
               <input type="text" id="department" name="department" class="form-control" placeholder='Enter Department' required="" value="{{isset($data->department)?$data->department:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="designations">Designations<span class="reqfield">*</span></label>
               <input type="text" id="designations" name="designations" class="form-control" placeholder='Enter Designations' required="" value="{{isset($data->designations)?$data->designations:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="salary">Salary<span class="reqfield">*</span></label>
               <input type="text" id="salary" name="salary" class="form-control" placeholder='Enter Salary' required="" value="{{isset($data->salary)?$data->salary:''}}">
            </div>
            <div class="col-md-6 adm-field">
               <label for="status">Status<span class="reqfield">*</span></label>
               <select name="status" id="status" class="form-control">
                  <option value="1" {{ isset($data->status) && $data->status == 1 ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ isset($data->status) && $data->status == 0 ? 'selected' : '' }}>Inactive</option>
               </select>
            </div>
            <div class="col-12 adm-field">
               <label for="description">{{__("message.Description")}}<span class="reqfield">*</span></label>
               <textarea id="description" name="description" required class="ckeditor form-control">{{isset($data->description)?$data->description:''}}</textarea>
            </div>

            <div class="col-12 adm-form-actions">
               @if(Session::get("is_demo")==1)
               <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                  Save
               </button>
               @else
               <button type="submit" class="btn btn-success adm-btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                  Save
               </button>
               @endif
               <a href="{{route('vacancies')}}" class="btn-secondary">{{__("message.Cancel")}}</a>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection
