@extends('manager.layout.index')
@section('title')
{{__("message.Edit Profile")}}
@stop
@section('content')
<!--Page header-->
<div class="page-header">
   <h3 class="page-title">{{__("message.Edit Profile")}} </h3>
   <div class="col-sm-6">
    
      <ol class="breadcrumb float-sm-right">
    
         <li class="breadcrumb-item"><a href="{{route('manager-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Edit Profile")}}</li>
      </ol>
   </div>
</div>

	<div class="col-xl-4 col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="card-header ">
					<div class="card-title">{{__("message.Edit Profile")}}</div>
				</div>
				@if(Session::has('message'))
          		<div class="col-sm-12">
                     <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                </div>
             	@endif
			 	<form  action="{{route('update-manager-profile')}}" method="post" enctype="multipart/form-data">
			 		{{csrf_field()}}
				 
						
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">{{ __("message.Name") }}</label>
								<input type="text" class="form-control" id="name" name="name" value="{{Auth::user()->name}}"placeholder="{{ __('message.Enter Name') }}" >
							</div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">{{ __("message.Email Id") }}</label>
								<input type="text" class="form-control" id="emailId" name="emailId" placeholder="{{ __('message.Enter Email') }}" value="{{Auth::user()->email}}">
							</div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
	              				<!-- <div class="form-group"> -->
	                   			<label for="name">{{__("message.Profile Image")}} <span class="reqfield">*</span></label>
				                  	<div id="uploaded_image">
				                     	<div class="upload-btn-wrapper">
					                        <button class="btn imgcatlog">
						                        <?php 
						                            if(isset(Auth::user()->profile_pic)){
						                                $path= env('APP_URL')."storage/app/public/profile"."/".Auth::user()->profile_pic;
						                            }
						                            else{
						                                $path=asset('/upload/default.jpg');
						                            }
						                        ?>
					                        	<img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" >
					                        </button>
					                        <input type="hidden" id="basic_img1"/>
					                        @if(isset(Auth::user()->profile_pic))
					                        	<input type="file" name="upload_image" class="form-control" id="upload_image" />
					                        @else
					                        	<input type="file" required="" class="form-control" name="upload_image" id="upload_image" />
					                        @endif
					                    </div>
				                   	</div>                
	              			</div> 
						</div>
						<div class="card-footer text-end">
							<input type="submit" value='{{__("message.Edit Profile")}}' class="btn btn-success">
							<a href="javascript:void0;" class="btn btn-danger">{{__("message.Cancel")}}</a>
						</div>
					<!-- </div> -->
            	</form>
        	</div>
		</div>
	</div>
<!-- </div> -->
<!-- End Row-->
@endsection