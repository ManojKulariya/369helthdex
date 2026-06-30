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
         <li class="breadcrumb-item active">Save Branch</li>
      </ol>
   </div>
</div>

	<div class="col-12">
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
			 	<form  action="{{route('update-manager-profile-admin-sample')}}" method="post" enctype="multipart/form-data" class="row">
			 		{{csrf_field()}}
				 
						<input type="hidden" name="id" value="{{$id}}">
				
							<div class="form-group col-6">
								<label class="form-label">{{__("message.Name")}}</label>
								<input type="text" required class="form-control" id="name" name="name" placeholder="{{__('message.Enter Name')}}" required value="{{isset($data->name)?$data->name:''}}" >
							</div>
						
						
				
							<div class="form-group col-6">
								<label class="form-label">{{ __("message.Phone") }}</label>
								<input type="text" required class="form-control" id="email" name="phone" placeholder="{{__('message.Enter Phone')}}" required value="{{isset($data->phone)?$data->phone:''}}">
							</div>
						
						
						<?php $arr = array();
                                     if(isset($data->reciever_lab)){
                                           $arr = explode(",",$data->reciever_lab);
                                           
                                     }
                                    ?>
                    
                          
                              <div class="form-group col-6">
                            <label class="form-label" for="default-01">Select  Labs</label>
        					<select class="form-control select2"   name="sample_branch" >
        					    
        						@foreach($labs as $p_key => $p_value)
        							<option value="{{$p_value->id}}" <?=in_array($p_value->id,$arr)?'selected="selected"':''?>>{{$p_value->name}}</option>
        						@endforeach
        					
        					</select>
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