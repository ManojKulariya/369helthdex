@extends('admin.layout.index')
@section('title')
{{__("message.Save Blog")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.Save Blog")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin-blog')}}">{{__("message.Blog")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.Save Blog")}}</li>
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

{{-- ============ Save blog form card ============ --}}
<div class="adm-form adm-form-page">
   <div class="adm-form-card">
      <div class="adm-form-card-head">
         <div class="adm-form-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
            {{__("message.Save Blog")}}
         </div>
      </div>
      <form action="{{route('update_blog')}}" method="post" enctype="multipart/form-data">
         {{csrf_field()}}
         <input type="hidden" name="id" id="id" value="{{$id}}">
         <div class="row">
            <div class="col-md-6 adm-field">
               <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
               <input type="text" id="name" name="name" class="form-control" placeholder='{{__("message.Enter Blog Name")}}' required="" value="{{isset($data->name)?$data->name:''}}">
            </div>
            <?php
               $selectedTags = (isset($data->tag) && $data->tag != null) ? explode(',', $data->tag) : [];
            ?>
            <div class="col-md-6 adm-field">
               <label for="tag">Select Tag<span class="reqfield">*</span></label>
               <select id="tag" name="tag[]" class="form-control select2" multiple required>
                  @foreach($tag as $row)
                  <option value="{{ $row->id }}" <?=(!empty($selectedTags) && in_array($row->id, $selectedTags))?'selected="selected"':''?>>{{ $row->name }}</option>
                  @endforeach
               </select>
            </div>

            <div class="col-12 adm-field">
               <label for="short_desc">{{__("message.Short Description")}}<span class="reqfield">*</span></label>
               <input type="text" id="short_desc" name="short_desc" class="form-control" placeholder="{{__('message.Enter Short Description')}}" required="" value="{{isset($data->short_desc)?$data->short_desc:''}}">
            </div>

            <div class="col-12 adm-field">
               <label for="description">{{__("message.Description")}}<span class="reqfield">*</span></label>
               <textarea id="description" name="description" required class="ckeditor form-control">{{isset($data->description)?$data->description:''}}</textarea>
            </div>

            <div class="col-12 adm-field">
               <label for="upload_image">{{__("message.Blog Image")}}<span class="reqfield">*</span></label>
               <?php
                  if(isset($data->image)){
                      $path=url('/')."/storage/Blog"."/".$data->image;
                  }
                  else{
                      $path=asset('public/upload/default.jpg');
                  }
                  ?>
               <div class="adm-upload">
                  <span class="adm-upload-thumb"><img src="{{$path}}" alt="..." id="basic_img"></span>
                  <div class="adm-upload-control">
                     <input type="hidden" name="real_basic_img" id="real_basic_img" value="<?= isset($data->image)?$data->image:""?>"/>
                     <input type="hidden" name="basic_img" id="basic_img1"/>
                     @if(isset($data->image))
                     <input type="file" name="upload_image" id="upload_image" class="form-control" />
                     @else
                     <input type="file" class="form-control" required="" name="upload_image" id="upload_image" />
                     @endif
                     <span class="adm-upload-hint"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>PNG or JPG</span>
                  </div>
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
               <a href="{{route('admin-blog')}}" class="btn-secondary">{{__("message.Cancel")}}</a>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection
