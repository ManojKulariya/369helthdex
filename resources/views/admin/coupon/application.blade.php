@extends('admin.layout.index')
@section('title')
{{__("message.Application")}}
@stop
@section('content')

<div class="page-header">
	<h3 class="page-title">{{__("message.Application")}}</h3>
	<nav aria-label="breadcrumb">	      		
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Application")}}</li>
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
                  <table id="ApplicationTable" style="width: 100%;" class="table table-bordered text-nowrap dataTable no-footer">
                   	<thead>
                     <tr>
                       	<th>Sr.no</th>
                       	<th>{{__("message.Vacancies")}}</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Number</th>
                        <th>Adhar Number</th>
                        <th>{{__("message.current_ctc")}}</th>
                        <th>{{__("message.expected_ctc")}}</th>
                        <th style="width: 10%;">{{__("message.Address")}}</th>
                        <th>{{__("message.Resume")}}</th>
                      
                     </tr>
                   	</thead>
                   	<tbody> 
                   
                   	</tbody>
                   	<tfoot>
                        <tr>
                        <th>Sr.no</th>
                        <th>{{__("message.Vacancies")}}</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Number</th>
                        <th>Adhar Number</th>
                        <th>{{__("message.current_ctc")}}</th>
                        <th>{{__("message.expected_ctc")}}</th>
                         <th>{{__("message.Address")}}</th>
                        <th>{{__("message.Resume")}}</th>
                        </tr>
                     </tfoot>
                   	
                  </table>
               </div>
         </div>
       </div>
     </div>
</div>
@endsection