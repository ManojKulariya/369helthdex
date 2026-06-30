@extends('admin.layout.index')
@section('title')
{{__("message.Save Category")}}
@stop
@section('content')
<div class="page-header">
	<h3 class="page-title">{{__("message.Save Category")}} </h3>
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
            <form action="{{route('update-offer')}}" method="post" enctype="multipart/form-data" class="row">
               {{csrf_field()}}
               	<input type="hidden" name="id" id="id" value="{{$id}}">
                  <div class="form-group col-6">
                     <label for="name">{{__("message.Name")}}<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="name" class="form-control" placeholder='{{__("message.Enter Category Name")}}' required="" value="{{isset($data->name)?$data->name:''}}">
                  </div>
                 	<div class="form-group col-6">
                     <label for="name">{{__("message.Category Image")}}<span class="reqfield">*</span></label>
                     <div id="uploaded_image">
                        <div class="upload-btn-wrapper">
                           <button class="btn imgcatlog">
                           <input type="hidden" name="real_basic_img" id="real_basic_img" value="<?= isset($data->image)?$data->image:""?>"/>
                           <?php 
                              if(isset($data->image)){
                                  $path=env('APP_URL')."storage/app/public/category"."/".$data->image;
                              }
                              else{
                                  $path=asset('public/upload/default.jpg');
                              }
                              ?>
                           <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" >
                           </button>
                           <input type="hidden" name="basic_img" id="basic_img1"/>
                           @if(isset($data->image))
                           <input type="file" name="upload_image" id="upload_image" class="form-control" />
                           @else
                            <input type="file" class="form-control" required="" name="upload_image" id="upload_image" />
                           @endif
                        </div>
                     </div>
                  </div>
                  <div class="form-group col-6">
                     <label for="name">Select Category<span class="reqfield">*</span></label>
                     <select class="form-control" name="type_id" id="type" @if(isset($data->type_id)) readonly @endif>
                        <option value="">--Select type--</option>
                        <option @if(isset($data->type_id) && $data->type_id == 'Package') selected @endif>Package</option>
                    	<option @if(isset($data->type_id) && $data->type_id == 'Parameter') selected @endif>Parameter</option>
                    	<option value="Profiles" @if(isset($data->type_id) && $data->type_id == 'Profiles') selected @endif>Test Profiles</option>
                    </select>
                  </div>
                  <div class="form-group parameter-hide col-6" >
                    <label class="form-label" for="default-01">Select Parameter</label>
					<select class="form-control select2" name="select_pera" >
					    @if($parameter->isEmpty())
						@else
						
						@foreach($parameter as $p_key => $p_value)
							<option value="{{$p_value->id}}" <?=in_array($p_value->id,$ids)?'selected="selected"':''?>>{{$p_value->name}}</option>
						@endforeach
						@endif
					</select>
                  </div>
                  <div class="form-group package-hide col-6" >
                    <label class="form-label" for="default-01">Select Package</label>
					<select class="form-control select2"    name="select_package" >
					  
					    @if($packages->isEmpty())
						@else
						@foreach($packages as $p_key => $p_value)
							<option value="{{$p_value->id}}" <?=in_array($p_value->id,$ids)?'selected="selected"':''?>>{{$p_value->name}}</option>
						@endforeach
						@endif
					</select>
                  </div>
                  <div class="form-group test-hide  col-6">
                    <label class="form-label" for="default-01">Select Test</label>
                    <select class="form-control select2"    name="select_test" >
                       
                        @if($test->isEmpty())
                        @else
                        @foreach($test as $t_key => $t_value)
                        <option value="{{$t_value->id}}" <?=in_array($t_value->id,$ids)?'selected="selected"':''?>>{{$t_value->profile_name}}</option>
                        @endforeach
                        @endif
                    </select>
                  </div>
                  <div class="row">
                     <div class="col-12">
                     	 @if(Session::get("is_demo")==1)
                        <input type="button" value='Save Offer' class="btn btn-success" onclick="disablebtn()">
                         @else
                        <input type="submit" value='Save Offer' class="btn btn-success">
                         @endif
                        <a href="{{route('admin-offer')}}" class="btn btn-danger">{{__("message.Cancel")}}</a>
                     </div>
                  </div>
           	</form>
       	</div>
     </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 $(document).ready(function() {
       
        $('.package-hide').hide();
        $('.parameter-hide').hide();
        $('.test-hide').hide();
        
         if($('#type').val()== 'Package'){
            $('.package-hide').show();
            $('.test-hide').hide();
            $('.parameter-hide').hide();
        }
        if($('#type').val()== 'Profiles'){
            $('.package-hide').hide();
            $('.test-hide').show();
            $('.parameter-hide').hide();
        }
         if($('#type').val()== 'Parameter'){
            $('.package-hide').hide();
            $('.test-hide').hide();
            $('.parameter-hide').show();
        }
        $('#type').on('change', function (e) {
            
            if(this.value== 'Package'){
                $('.package-hide').show();
                $('.test-hide').hide();
                 $('.parameter-hide').hide();
            }
            if(this.value == 'Parameter'){
            $('.package-hide').hide();
            $('.test-hide').hide();
            $('.parameter-hide').show();
        }
                if(this.value=='Profiles'){
                $('.package-hide').hide();
                $('.test-hide').show();
                $('.parameter-hide').hide();
        }
        });
        
        
    });
    </script>
@endsection