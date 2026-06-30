@extends('admin.layout.index')
@section('title')
Coupon
@stop
@section('content')
<div class="page-header">
	<h3 class="page-title">Coupon</h3>
	<nav aria-label="breadcrumb">	      		
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">Coupon</li>
       </ol>
     </nav>	      	
</div>
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
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
            <a href="{{url('savecoupon/0')}}"  class="btn btn-success" style="margin-bottom: 10px">Add Coupon</a>
               <div class="table-responsive">
                  <table id="CouponTable" class="table table-bordered text-nowrap dataTable no-footer">
                   	<thead>
                     <tr>
                       	  <th>Sr.no</th>
                        <th>Coupon Code</th>
                        <th>Product Name</th>
                        <th>Coupon Value</th>
                        <th>Coupon Start Date</th>
                        <th>Coupon End Date</th>
                        <th>Action</th>
                     </tr>
                   	</thead>
                   	<tbody> 
                   	 @if($data['coupons']->isEmpty())
                                                {{-- <h1>Record Not found</h1> --}}
                                            @else
                                                @foreach($data['coupons'] as $c_key => $c_value)
                                                    <tr>
                                                        <td>{{$c_key++}}</td>
                                                        <td>{{$c_value->coupon_code}}</td>
                                                        <td>
                                                            @if($c_value->type=='1')
                                                                {{$c_value->package->name}}
                                                            @elseif($c_value->type=='2')
                                                                {{$c_value->parameter->name}}
                                                            @elseif($c_value->type=='3')
                                                                {{$c_value->test->profile_name}}
                                                            @else
                                                            ALL
                                                            @endif
                                                        </td>
                                                        
                                                        <td>{{$c_value->coupon_value}}  @if($c_value->coupon_type=='fixed') Rs.  @else % @endif   </td>
                                                        <td>{{$c_value->coupon_start_date}}</td>
                                                        <td>{{$c_value->coupon_end_date}}</td>
                                                        
                                                        <td>
                                                            <a href="{{url('savecoupon/'.$c_value->id)}}"><em class="icon ni ni-edit"></em><span>Edit</span></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                   	</tbody>
                   	
                  </table>
               </div>
         </div>
       </div>
     </div>
</div>
@endsection