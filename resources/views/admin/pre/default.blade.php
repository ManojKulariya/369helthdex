@extends('admin.layout.index')
@section('title')
{{__("message.User Prescription")}}
@stop
@section('content')
<div class="page-header">
   <h3 class="page-title">{{__("message.User Prescription")}}</h3>
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('manager-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.User Prescription")}}</li>
      </ol>
   </nav>
</div>
<div class="row">
   <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
         <div class="card-body">
            
            <div class="table-responsive">
               <table id="preTable" class="table table-bordered text-nowrap dataTable no-footer">
                  <thead>
                     <tr>
                        <th>{{__("message.Id")}}</th>
                        <th>DOC</th>
                        <th>Name</th>
                        <th>{{__("message.email")}}</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Number</th>
                        <th>Branch</th>
                     </tr>
                  </thead>
                  <tbody>                        
                  </tbody>
                  <tfoot>
                     <th>{{__("message.Id")}}</th>
                        <th>DOC</th>
                        <th>Name</th>
                        <th>{{__("message.email")}}</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Number</th>
                        <th>Branch</th>
                  </tfoot>
               </table>
            </div>
           
         </div>
      </div>
   </div>
</div>
@endsection