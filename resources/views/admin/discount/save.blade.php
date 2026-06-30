@extends('admin.layout.index')
@section('title')
{{__("message.Save Discount")}}
@stop
@section('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="page-header">
	<h3 class="page-title">{{__("message.Save Discount")}}</h3>
	<div class="col-sm-6">
      @if(__("message.Is_rtl")=='1')
             <ol class="breadcrumb float-sm-left">
         @else
            <ol class="breadcrumb float-sm-right">
         @endif
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item"><a href="{{route('admin-discount')}}">{{__("message.Discounts")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Save Discount")}}</li>
      </ol>
   </div>	      	
</div>
<div class="row">
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
            <form action="{{route('update-discount')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               	<input type="hidden" name="id" id="id" value="{{$id}}">
               	<div class="row">
               	    <div class="form-group col-6">
                     <label for="dis_name">Discoun Name<span class="reqfield">*</span></label>
                     <input type="text" name="dis_name" class="form-control" placeholder='Location ' required="" value="{{isset($data->dis_name)?$data->dis_name:''}}">
                  </div> 
               	    <div class="form-group col-6">
                     <label for="name">Discount Type<span class="reqfield">*</span></label>
                     <select id="dis_type" name="dis_type" class="form-control" required>
                         <option value="per" @if(isset($data->dis_type) && $data->dis_type == 'per') selected @endif>%</option>
                         <option value="fixed" @if(isset($data->fixed) && $data->dis_type == 'fixed') selected @endif>Fixed</option>
                     </select>
                  </div>  
                  <div class="form-group col-6">
                     <label for="name">Discount<span class="reqfield">*</span></label>
                     <input type="number" id="discount" name="discount" class="form-control" placeholder='Location ' required="" value="{{isset($data->discount)?$data->discount:''}}">
                  </div> 
                  <div class="form-group col-6">
                        <label for="date_range">Select Date Range:</label>
                        @php
                        $dateRange = isset($data->start_date) ? $data->start_date . ' to ' . $data->end_date : '';
                        @endphp
                        <input type="text" id="date-range" class="form-control" name="date_range" placeholder="Select Date Range" value="{{$dateRange}}">
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
					<select class="form-control select2" multiple   name="select_pera[]" >
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
					<select class="form-control select2" multiple   name="select_package[]" >
					  
					    @if($packages->isEmpty())
						@else
						@foreach($packages as $p_key => $p_value)
							<option value="{{$p_value->id}}" <?=in_array($p_value->id,$ids)?'selected="selected"':''?>>{{$p_value->name}}</option>
						@endforeach
						@endif
					</select>
                  </div>
                  <div class="form-group test-hide col-6">
                    <label class="form-label" for="default-01">Select Test</label>
                    <select class="form-control select2" multiple   name="select_test[]" >
                       
                        @if($test->isEmpty())
                        @else
                        @foreach($test as $t_key => $t_value)
                        <option value="{{$t_value->id}}" <?=in_array($t_value->id,$ids)?'selected="selected"':''?>>{{$t_value->profile_name}}</option>
                        @endforeach
                        @endif
                    </select>
                  </div>
                    
                  </div>
                  <div class="row">
                     <div class="col-12">
                     	  @if(Session::get("is_demo")==1)  
                             <input type="button" value='Save Discount' class="btn btn-success" onclick="disablebtn()">
                          @else
                             <input type="submit" value='Save Discount' class="btn btn-success">
                          @endif
                        <a href="{{route('admin-discount')}}" class="btn btn-danger">{{__("message.Cancel")}}</a>
                     </div>
                  </div>
           	</form>
       	</div>
     </div>
</div>

<!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Flatpickr Range Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/rangePlugin/rangePlugin.js"></script>
    <script>
        flatpickr("#date-range", {
            mode: "range",
            dateFormat: "Y-m-d",
        });
    
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