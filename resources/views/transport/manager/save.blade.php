@extends('transport.layout.index')
@section('title')
{{__("message.Save Manager Profile")}}
@stop
@section('content')
<!--Page header-->
<div class="page-header">
   <h3 class="page-title">Save Branch </h3>
   <div class="col-sm-6">
    
      <ol class="breadcrumb float-sm-right">
    
         <li class="breadcrumb-item"><a href="{{route('transport-admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">Save Branch</li>
      </ol>
   </div>
</div>

	<div class="col-xl-12 col-lg-12">
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
			 	<form  action="{{route('update-transport-manager-profile-admin')}}" method="post" enctype="multipart/form-data" class="row">
			 		{{csrf_field()}}
				 
						<input type="hidden" name="id" value="{{$id}}">
						<div class="col-6">
							<div class="form-group">
								<label class="form-label">{{__("message.Name")}}</label>
								<input type="text" required class="form-control" id="name" readonly name="name" placeholder="{{__('message.Enter Name')}}" value="{{isset($data->name)?$data->name:''}}" >
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="form-label">Company {{__("message.Name")}}</label>
								<input type="text" required class="form-control" id="name" readonly name="company_name" placeholder="Company {{__('message.Enter Name')}}" value="{{isset($data->company_name)?$data->company_name:''}}" >
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="form-label">Branch Code</label>
								<input type="text" required class="form-control" id="name" readonly name="branch_code" placeholder="Branch Code" value="{{isset($data->branch_code)?$data->branch_code:''}}" >
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="form-label">{{ __("message.Email Id") }}</label>
								<input type="text" required class="form-control" readonly id="email" name="email" placeholder="{{__('message.Enter Emial')}}" value="{{isset($data->email)?$data->email:''}}">
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="form-label">{{ __("message.Phone") }}</label>
								<input type="text" required class="form-control" readonly id="email" name="phone" placeholder="{{__('message.Enter Phone')}}" value="{{isset($data->phone)?$data->phone:''}}">
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="form-label">{{__('message.City')}}</label>
								<select class="form-control" name="city" id="city"  readonly>
									<option value="">{{__('message.Select City')}}</option>
									@foreach($city as $c)
									<option value="{{$c->id}}" <?= isset($data->city)&&$data->city==$c->id?'selected="selected"':''?> >{{$c->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="form-label">Host lab</label>
								<select class="form-control" name="is_head" id="is_head" required="">
									
									<option value="No" <?= isset($data->is_head)&&$data->is_head=='No'?'selected="selected"':''?> >No</option>
									
									<option value="Yes" <?= isset($data->is_head)&&$data->is_head=='Yes'?'selected="selected"':''?> >Yes</option>
									
								</select>
							</div>
						</div>
						<?php $arr = array();
                                     if(isset($data->reciever_lab)){
                                           $arr = explode(",",$data->reciever_lab);
                                           
                                     }
                                    ?>
                  <div class="col-6 parameter-hide" >
                      <div class="form-group">
                    <label class="form-label" for="default-01">Select Receiver Labs</label>
					<select class="form-control select2" multiple   name="reciever_lab[]" >
					    @if($labs->isEmpty())
						@else
						
						@foreach($labs as $p_key => $p_value)
							<option value="{{$p_value->id}}" <?=in_array($p_value->id,$arr)?'selected="selected"':''?>>{{$p_value->name}}</option>
						@endforeach
						@endif
					</select>
					</div>
                  </div>
						<div class="col-6">
							<div class="form-group">
	              				<!-- <div class="form-group"> -->
	                   			<label for="name">{{__("message.Profile Image")}} <span class="reqfield">*</span></label>
				                  	<div id="uploaded_image">
				                     	<div class="upload-btn-wrapper">
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
					                       
				                   	</div>                
	              			</div> 
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="form-label">Full Address</label>
								<textarea type="text" required class="form-control" readonly id="email" name="address" placeholder="Full Address">{{isset($data->address)?$data->address:''}} </textarea>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="form-label">Description</label>
								<textarea type="text" required class="form-control" readonly id="email" name="description" placeholder="Description">{{isset($data->description)?$data->description:''}} </textarea>
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
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script type="text/javascript">
	
    $(document).ready(function() {
      
        $('.parameter-hide').hide();
        
         if($('#is_head').val()=='Yes'){
            $('.parameter-hide').hide();
        }
        if($('#is_head').val()=='No'){
            $('.parameter-hide').show();
        }
         
        $('#is_head').on('change', function (e) {
           
            if(this.value== 'Yes'){
                 $('.parameter-hide').hide();
            }
            if(this.value =='No'){
            $('.parameter-hide').show();
            }
                
        });
        
        
    });
</script>
<!-- </div> -->
<!-- End Row-->
@endsection