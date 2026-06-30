@extends('manager.layout.index')
@section('title')
{{__("message.Change Password")}}
@stop
@section('content')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0 text-primary">{{__("message.Change Password")}}</h4>
	</div>	
</div>
<!--End Page header-->
<div class="row">
	<div class="col-xl-4 col-lg-12">
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
				<form  action="{{route('update_manager_change_password')}}" method="post"> {{csrf_field()}}
			 		<!-- <div class="row"> -->
					<div class="col-sm-12 col-md-12">
						<div class="form-group">
							<label class="form-label">{{__("message.Old Password")}}</label>
							<input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="{{__('message.Old Password')}}" onchange="checkcurrentpwd(this.value)">
                        	<input type="hidden" name="cpwd" id="cpwd" value="{{__('message.Please Enter Correct Cureent Password')}}">
						</div>
					</div>
					<div class="col-sm-12 col-md-12">
						<div class="form-group">
							<label class="form-label">{{__("message.New Password")}}</label>
							<input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="{{__('message.New Password')}}">
						</div>
					</div>
					<div class="col-sm-12 col-md-12">
						<div class="form-group">
							<label class="form-label">{{__("message.Confirm Password")}}</label>
							<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="{{__('message.Confirm Password')}}" onchange="checkbothpassword(this.value)">
                    		<input type="hidden" name="newpwd" id="newpwd" value="{{__('message.New Password And Re Enter Password Must Be Same')}}">
						</div>
					</div>
					<div class="card-footer text-end">
						<input type="submit" value='{{__("message.Change Password")}}' class="btn btn-success">
						<a href="javascript:void0;" class="btn btn-danger">{{__("message.Cancel")}}</a>
					</div>
					<!-- </div> -->
            	</form>
        	</div>
		</div>
	</div>
</div>
@endsection