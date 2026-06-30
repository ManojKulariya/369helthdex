@extends('admin.layout.index')
@section('title')
Sample Type
@stop
@section('content')
<div class="page-header">
	<h3 class="page-title">Sample Type </h3>
	<nav aria-label="breadcrumb">	      		
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">Sample Type</li>
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
            <a href="{{url('savesample/0')}}"  class="btn btn-success" style="margin-bottom: 10px">Add Sample Type</a>
            <div class="table-responsive">
                 <table id="sampletypeTable" class="table table-bordered text-nowrap dataTable no-footer">
                   	<thead>
                     <tr>
                       	<th>{{__("message.ID")}}</th>
                         <th>Sample {{__("message.Name")}}</th>
                         <th>{{__("message.Action")}}</th>
                     </tr>
                   	</thead>
                   	<tbody>                        
                   	</tbody>
                   	<tfoot>
                        <tr>
                           <th>{{__("message.ID")}}</th>
                           <th>{{__("message.Name")}}</th>
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