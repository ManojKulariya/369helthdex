@extends('admin.layout.index')
@section('title')
Call Back Requests
@stop
@section('content')
<div class="page-header">
	<h3 class="page-title">Call Back Requests</h3>
	<nav aria-label="breadcrumb">	      		
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">Call Back Requests</li>
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
          
               <div class="table-responsive">
                  <table id="CouponTable" class="table table-bordered text-nowrap dataTable no-footer">
                   	<thead>
                     <tr>
                       	<th>Sr.no</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Message</th>
                      
                     </tr>
                   	</thead>
                   	<tbody> 
                   	 @if($data['coupons']->isEmpty())
                                                {{-- <h1>Record Not found</h1> --}}
                                            @else
                                                @foreach($data['coupons'] as $c_key => $c_value)
                                                    <tr>
                                                        <td>{{$c_key++}}</td>
                                                        <td>{{$c_value->name}}</td>
                                                       
                                                        <td>{{$c_value->number}}</td>
                                                        <td>{{$c_value->message}}</td>
                                                      
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