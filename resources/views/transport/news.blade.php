@extends('admin.layout.index')
@section('title')
{{__("message.News")}}
@stop
@section('content')
<!--Page header-->
<div class="page-header">
   <h3 class="page-title">{{__("message.News")}}</h3>
   <div class="col-sm-6">
    
      <ol class="breadcrumb float-sm-right">
    
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.News")}}</li>
      </ol>
   </div>
</div>

	<div class="col-xl-6 col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="card-header ">
					<div class="card-title">{{__("message.News")}}</div>
				</div>
				<div class="card-body ">
				@if(Session::has('message'))
				
          		<div class="col-sm-12">
                     <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                </div>
             	@endif
			 	<form  action="{{route('post-news')}}" method="post" enctype="multipart/form-data">
			 		{{csrf_field()}}
				 
						 <div class="form-group">
                     <label for="name">{{__("message.Description")}}<span class="reqfield">*</span></label>
                     <textarea id="description" name="news" required class="ckeditor form-control">
                        {{isset($data->description)?$data->description:''}}
                     </textarea>                           
                  </div>
						<div class="card-footer text-end">
							@if(Session::get("is_demo")==1)
                      <button type="button" class="btn btn-success" onclick="disablebtn()">{{__('message.Send News')}}</button>
                      @else
                     <button type="submit" class="btn btn-success">{{__('message.Send News')}}</button>
                       @endif
							<a href="javascript:void0;" class="btn btn-danger">{{__("message.Cancel")}}</a>
						</div>
					<!-- </div> -->
            	</form>
        	</div>
        </div>
		</div>
	</div>
<!-- </div> -->
<!-- End Row-->
@endsection