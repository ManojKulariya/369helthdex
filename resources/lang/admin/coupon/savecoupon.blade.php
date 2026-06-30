@extends('admin.layout.index')
@section('title')
Coupon
@stop
@section('content')

<div class="page-header">
	<h3 class="page-title">Save Coupon </h3>
	<div class="col-sm-6">
      @if(__("message.Is_rtl")=='1')
             <ol class="breadcrumb float-sm-left">
         @else
            <ol class="breadcrumb float-sm-right">
         @endif
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item"><a href="{{route('admin-subcategory')}}">Coupon</a></li>
         <li class="breadcrumb-item active">Save Coupon</li>
      </ol>
   </div>	      	
</div>
<div class="row">
	<div class="col-6 grid-margin stretch-card">
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
            <form action="{{route('update-coupon')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               	<input type="hidden" name="id" id="id" value="{{$id}}">
                  <div class="form-group">
                     <label for="name">Coupon Code<span class="reqfield">*</span></label>
                     <input type="text" id="name" name="coupon_code" class="form-control" placeholder='Coupon Code' required="" value="{{isset($data->coupon_code)?$data->coupon_code:''}}">
                  </div>
                 
                  <div class="form-group">
                    <label for="short_desc">Type<span class="reqfield">*</span></label>
                    <select class="form-control" name="type" id="type"  >
                        <option value="4">All</option>
                        <option value="1" @if(isset($data->coupon_code) && $data->type == 1) selected @endif>Package</option>

                    	<option value="2" @if(isset($data->coupon_code) && $data->type == 2) selected @endif>Parameter</option>
                    	<option value="3" @if(isset($data->coupon_code) && $data->type == 3) selected @endif>Test</option>
                    </select>
                  </div>
                  <?php $arr = array();
                                     if(isset($data->product_ids)){
                                           $arr = explode(",",$data->product_ids);
                                           
                                     }
                                    ?>
                  <div class="form-group parameter-hide" >
                    <label class="form-label" for="default-01">Select Parameter</label>
					<select class="form-control select2" multiple   name="select_pera[]" >
					    @if($parameter->isEmpty())
						@else
						
						@foreach($parameter as $p_key => $p_value)
							<option value="{{$p_value->id}}" <?=in_array($p_value->id,$arr)?'selected="selected"':''?>>{{$p_value->name}}</option>
						@endforeach
						@endif
					</select>
                  </div>
                  <div class="form-group package-hide" >
                    <label class="form-label" for="default-01">Select Package</label>
					<select class="form-control select2" multiple   name="select_package[]" >
					  
					    @if($packages->isEmpty())
						@else
						@foreach($packages as $p_key => $p_value)
							<option value="{{$p_value->id}}" <?=in_array($p_value->id,$arr)?'selected="selected"':''?>>{{$p_value->name}}</option>
						@endforeach
						@endif
					</select>
                  </div>
                  <div class="form-group test-hide">
                    <label class="form-label" for="default-01">Select Test</label>
                    <select class="form-control select2" multiple   name="select_test[]" >
                       
                        @if($test->isEmpty())
                        @else
                        @foreach($test as $t_key => $t_value)
                        <option value="{{$t_value->id}}" <?=in_array($t_value->id,$arr)?'selected="selected"':''?>>{{$t_value->profile_name}}</option>
                        @endforeach
                        @endif
                    </select>
                  </div>
                  <div class="form-group ">
                    <label class="form-label" for="default-01">Select Days</label>
                    <select class="form-control select2" multiple   name="day[]" >
                        <?php $arr = array();
                                     if(isset($data->day)){
                                           $arr = explode(",",$data->day);
                                           
                                     }
                              
                                    ?>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <option value="{{ $day }}" <?=in_array($day,$arr)?'selected="selected"':''?>>{{ $day }}</option>
                        @endforeach
                    </select>
                  </div>
                    <div class="form-group">
    					<label class="form-label" for="default-01">Coupon Type</label>
    					<select class="form-control" name="coupon_type" >
    						<option value="fixed">Fixed</option>
    						<option value="percent">Percent</option>
    					</select>
    					@error('coupon_type')
    						<span class="invalid-feedback" role="alert">
    						<strong style="color: red">{{ $message }}</strong>
    						</span>
    					@enderror
    				</div>
    				<div class="form-group">
						<label class="form-label" for="default-01">Coupon Value</label>
						<input type="text" class="form-control price-input" placeholder="Coupon Value" name="coupon_value" value="{{isset($data->coupon_value)?$data->coupon_value:''}}">
						@error('coupon_value')
							<span class="invalid-feedback" role="alert">
							<strong style="color: red">{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="form-group">
						<label class="form-label" for="default-01">Coupon Start Date</label>
						<input type="date" class="form-control datepicker" placeholder="Coupon Start Date" name="coupon_start_date" value="{{isset($data->coupon_start_date)?$data->coupon_start_date:''}}">
						@error('coupon_start_date')
							<span class="invalid-feedback" role="alert">
							<strong style="color: red">{{ $message }}</strong>
							</span>
						@enderror
					</div>
					<div class="form-group">
						<label class="form-label" for="default-01">Coupon End Date</label>
						<input type="date" class="form-control datepicker" placeholder="Coupon End Date" name="coupon_end_date" value="{{isset($data->coupon_end_date)?$data->coupon_end_date:''}}">
						@error('coupon_end_date')
							<span class="invalid-feedback" role="alert">
							<strong style="color: red">{{ $message }}</strong>
							</span>
						@enderror
					</div>

                 
                  
                 	
                  <div class="row">
                     <div class="col-12">
                     	 @if(Session::get("is_demo")==1)
                      <button type="button" class="btn btn-success" onclick="disablebtn()">{{__('message.Save')}}</button>
                      @else
                     <button type="submit" class="btn btn-success">{{__('message.Save')}}</button>
                       @endif
                        <a href="{{route('admin-subcategory')}}" class="btn btn-danger">{{__("message.Cancel")}}</a>
                     </div>
                  </div>
           	</form>
       	</div>
     </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
	
    $(document).ready(function() {
        console.log('test log');
        $('.price-input').on('keypress', function (e) {
            return isNumber(e, this)
        });
        $('.package-hide').hide();
        $('.parameter-hide').hide();
        $('.test-hide').hide();
        
         if($('#type').val()==1){
            $('.package-hide').show();
            $('.test-hide').hide();
            $('.parameter-hide').hide();
        }
        if($('#type').val()==3){
            $('.package-hide').hide();
            $('.test-hide').show();
            $('.parameter-hide').hide();
        }
         if($('#type').val()==2){
            $('.package-hide').hide();
            $('.test-hide').hide();
            $('.parameter-hide').show();
        }
        $('#type').on('change', function (e) {
            console.log(this.value);
            if(this.value== 1){
                $('.package-hide').show();
                $('.test-hide').hide();
                 $('.parameter-hide').hide();
            }
            if(this.value ==2){
            $('.package-hide').hide();
            $('.test-hide').hide();
            $('.parameter-hide').show();
        }
                if(this.value==3){
                $('.package-hide').hide();
                $('.test-hide').show();
                $('.parameter-hide').hide();
        }
        });
        
        
    });
    
    function isNumber(e, element) {
        var charCode = (e.which) ? e.which : event.keyCode
        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) && // Check minus and only once.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&  // Check dot and only once.
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }    
</script>
@endsection