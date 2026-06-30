@extends('admin.layout.index')
@section('title')
{{__("message.Save Manager Profile")}}
@stop
@section('content')
<!--Page header-->
<div class="page-header">
   <h3 class="page-title">Save Branch </h3>
   <div class="col-sm-6">
    
      <ol class="breadcrumb float-sm-right">
    
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">Save Branch<</li>
      </ol>
   </div>
</div>

	<div class="col-xl-4 col-lg-12">
		<div class="card">
			<div class="card-header ">
					<div class="card-title">Save Branch</div>
				</div>
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
			 	<form  action="{{route('update-manager-profile-admin')}}" method="post" enctype="multipart/form-data">
			 		{{csrf_field()}}
				 
						<input type="hidden" name="id" value="{{$id}}">
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">{{__("message.Name")}}</label>
								<input type="text" required class="form-control" id="name" name="name" placeholder="{{__('message.Enter Name')}}" value="{{isset($data->name)?$data->name:''}}" >
							</div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">Company {{__("message.Name")}}</label>
								<input type="text" required class="form-control" id="name" name="company_name" placeholder="Company {{__('message.Enter Name')}}" value="{{isset($data->company_name)?$data->company_name:''}}" >
							</div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">Branch Code</label>
								<input type="text" required class="form-control" id="name" name="branch_code" placeholder="Branch Code" value="{{isset($data->branch_code)?$data->branch_code:''}}" >
							</div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">{{ __("message.Email Id") }}</label>
								<input type="text" required class="form-control" id="email" name="email" placeholder="{{__('message.Enter Emial')}}" value="{{isset($data->email)?$data->email:''}}">
							</div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">{{__('message.City')}}</label>
								<select class="form-control" name="city" id="city" required="">
									<option value="">{{__('message.Select City')}}</option>
									@foreach($city as $c)
									<option value="{{$c->id}}" <?= isset($data->city)&&$data->city==$c->id?'selected="selected"':''?> >{{$c->name}}</option>
									@endforeach
								</select>
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
						                            if(isset($data->profile_pic)){
						                                $path= env('APP_URL')."storage/app/public/profile"."/".$data->profile_pic;
						                            }
						                            else{
						                                $path=asset('public/upload/default.jpg');
						                            }
						                        ?>
					                        	<img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" >
					                        </button>
					                        <input type="hidden" id="basic_img1"/>
					                        @if(isset($data->profile_pic))
					                        	<input type="file" name="upload_image" class="form-control" id="upload_image" />
					                        @else
					                        	<input type="file" required="" class="form-control" name="upload_image" id="upload_image" />
					                        @endif
					                    </div>
				                   	</div>                
	              			</div> 
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">Full Address</label>
								<textarea type="text" required class="form-control" id="email" name="address" placeholder="Full Address">{{isset($data->address)?$data->address:''}} </textarea>
							</div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">Description</label>
								<textarea type="text" required class="form-control" id="email" name="description" placeholder="Description">{{isset($data->description)?$data->description:''}} </textarea>
							</div>
						</div>
						
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">{{__('message.password')}}</label>
								<input type="password" class="form-control" id="password" required name="password" placeholder="{{__('message.Enter Password')}}"  >
							</div>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="form-group">
								<label class="form-label">{{__('message.Confirm Password')}}</label>
								<input type="password" class="form-control" id="cpassword" required name="cpassword" placeholder="{{__('message.Enter Confirm Password')}}" onchange="checkconfirmpassword(this.value)" >
							</div>
						</div>
						<div class="card-footer text-end">
							 @if(Session::get("is_demo")==1)
                      <button type="button" class="btn btn-success" onclick="disablebtn()">Save Branch</button>
                      @else
                     <button type="submit" class="btn btn-success">Save Branch</button>
                       @endif
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