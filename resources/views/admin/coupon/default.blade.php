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
                   	</tbody>
                   	
                  </table>
               </div>
         </div>
       </div>
     </div>
</div>
@endsection