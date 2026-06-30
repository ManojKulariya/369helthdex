@extends('manager.layout.index')
@section('title')
Save User Profile
@stop
@section('content')
<!--Page header-->
<div class="page-header">
   <h3 class="page-title">Save User </h3>
   <div class="col-sm-6">
    
      <ol class="breadcrumb float-sm-right">
    
         <li class="breadcrumb-item"><a href="{{route('manager-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">Save User</li>
      </ol>
   </div>
</div>

	<div class="col-xl-12 col-lg-12">
		<div class="card">
			<div class="card-header ">
					<div class="card-title">Save User</div>
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
			 	<form  action="{{route('update-sample-profile-admin')}}" method="post" enctype="multipart/form-data" class="row">
			 		{{csrf_field()}}
				 
						<input type="hidden" name="id" value="{{$id}}">
						<input type="hidden" name="user_type" value="4">
						<div class="col-6">
							<div class="form-group">
								<label class="form-label">{{__("message.Name")}}</label>
								<input type="text" required class="form-control" id="name" name="name" placeholder="{{__('message.Enter Name')}}" value="{{isset($data->name)?$data->name:''}}" >
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="form-label">{{__("message.Phone")}}</label>
								<input type="text" required class="form-control" id="name" name="phone" placeholder="{{__('message.Enter Phone')}}" value="{{isset($data->phone)?$data->phone:''}}" >
							</div>
						</div>
						
						<!--<div class="col-6">-->
						<!--	<div class="form-group">-->
						<!--		<label class="form-label">{{ __("message.Email Id") }}</label>-->
						<!--		<input type="text" required class="form-control" id="email" name="email" placeholder="{{__('message.Enter Emial')}}" value="{{isset($data->email)?$data->email:''}}">-->
						<!--	</div>-->
						<!--</div>-->
						<!--<div class="col-6">-->
						<!--	<div class="form-group">-->
						<!--		<label class="form-label" >User type</label>-->
						<!--		<select required class="form-control" name="user_type">-->
      <!--                              <option value="4" {{ isset($data->user_type) && $data->user_type == 4 ? 'selected' : '' }}>Sample Boy</option>-->
                                    <!--<option value="5" {{ isset($data->user_type) && $data->user_type == 5 ? 'selected' : '' }}>Transport Boy</option>-->
                                    
                                    <!--<option value="6" {{ isset($data->user_type) && $data->user_type == 6 ? 'selected' : '' }}>Parcel Receiver</option>-->
      <!--                          </select>-->
						<!--	</div>-->
						<!--</div>-->
						
						<!--<div class="col-6">-->
						<!--	<div class="form-group">-->
						<!--		<label class="form-label">Full Address</label>-->
						<!--		<textarea type="text" required class="form-control" id="email" name="address" placeholder="Full Address">{{isset($data->address)?$data->address:''}} </textarea>-->
						<!--	</div>-->
						<!--</div>-->
						<!--<div class="col-6">-->
						<!--	<div class="form-group">-->
						<!--		<label class="form-label">Description</label>-->
						<!--		<textarea type="text" required class="form-control" id="email" name="description" placeholder="Description">{{isset($data->description)?$data->description:''}} </textarea>-->
						<!--	</div>-->
						<!--</div>-->
						
						<!--<div class="col-6">-->
						<!--	<div class="form-group">-->
						<!--		<label class="form-label">{{__('message.password')}}</label>-->
						<!--		<input type="password" class="form-control" id="password" required name="password" placeholder="{{__('message.Enter Password')}}"  >-->
						<!--	</div>-->
						<!--</div>-->
						<!--<div class="col-6">-->
						<!--	<div class="form-group">-->
						<!--		<label class="form-label">{{__('message.Confirm Password')}}</label>-->
						<!--		<input type="password" class="form-control" id="cpassword" required name="cpassword" placeholder="{{__('message.Enter Confirm Password')}}" onchange="checkconfirmpassword(this.value)" >-->
						<!--	</div>-->
						<!--</div>-->
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