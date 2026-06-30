@extends('manager.layout.index')
@section('title')
Sample Boy
@stop 
@section('content')
<div class="page-header">
	<h3 class="page-title">Sample Boy</h3>
	<nav aria-label="breadcrumb">	      		
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('manager-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">Sample Boy</li>
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
            <a href="{{url('savesampleboy/0')}}"  class="btn btn-success" style="margin-bottom: 10px">Add User</a>
            <div class="table-responsive">
                 <table id="SampleTable" class="table table-bordered text-nowrap dataTable no-footer">
                   	<thead>
                     <tr>
                       	 <th>{{__("message.ID")}}</th>
                         <th>{{__("message.Image")}}</th>
                         <th>{{__("message.Name")}}</th>
                         <th>{{__("message.email")}}</th>
                         <th>{{__("message.City")}}</th>
                         <th>{{__("message.Action")}}</th>
                     </tr>
                   	</thead>
                   	<tbody>                        
                   	</tbody>
                   	<tfoot>
                        <tr>
                           <th>{{__("message.ID")}}</th>
                           <th>{{__("message.Image")}}</th>
                           <th>{{__("message.Name")}}</th>
                           <th>{{__("message.email")}}</th>
                           <th>{{__("message.City")}}</th>
                           <th>{{__("message.Action")}}</th>
                        </tr>
                     </tfoot>
                 </table>
              </div>
         </div>
       </div>
     </div>
</div>
@endsection