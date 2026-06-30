@extends('manager.layout.index')
@section('title')
{{__("message.Orders List")}}
@stop
@section('content')
<div class="page-header">
   <h3 class="page-title">{{__("message.Orders List")}}</h3>
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('manager-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Orders List")}}</li>
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
            <!--        #Lab           -->
            @if(auth()->user()->user_type == 2)
                
            <div class="table-responsive">
               <table id="preTable" class="table table-bordered text-nowrap dataTable no-footer">
                  <thead>
                     <tr>
                        <th>{{__("message.Id")}}</th>
                        <th>{{__("message.Customer Name")}}</th>
                        <th>{{__("message.Address")}}</th>
                        <th>{{__("message.Sample Collection DateTime")}}</th>
                        <th>{{__("message.Payment Method")}}</th>
                        <th>{{__("message.Paid Amount")}}</th>
                        <th>{{__("message.More")}}</th>
                        <th>{{__("message.Print")}}</th>
                        <th>{{__("message.Status")}}</th>
                        <th>{{__("message.Action")}}</th>
                     </tr>
                  </thead>
                  <tbody>                        
                  </tbody>
                  <tfoot>
                     <th>{{__("message.Id")}}</th>
                     <th>{{__("message.Customer Name")}}e</th>
                     <th>{{__("message.Address")}}</th>
                     <th>{{__("message.Sample Collection DateTime")}}</th>
                     <th>{{__("message.Payment Method")}}</th>
                     <th>{{__("message.Paid Amount")}}</th>
                     <th>{{__("message.More")}}</th>
                     <th>{{__("message.Print")}}</th>
                     <th>{{__("message.Status")}}</th>
                     <th>{{__("message.Action")}}</th>
                  </tfoot>
               </table>
            </div>
            
            @endif
            <!--        #sample boy              -->
            
            @if(auth()->user()->user_type != 2)
            <div class="table-responsive">
               <table id="OrdersTableSample" class="table table-bordered text-nowrap dataTable no-footer">
                  <thead>
                     <tr>
                        <th>{{__("message.Id")}}</th>
                        <th>{{__("message.Customer Name")}}</th>
                        <th>{{__("message.Address")}}</th>
                        <th>{{__("message.Sample Collection DateTime")}}</th>
                        <th>{{__("message.Payment Method")}}</th>
                        <th>{{__("message.Paid Amount")}}</th>
                        <th>Reschedule</th>
                        <!--<th>{{__("message.Print")}}</th>-->
                        <th>{{__("message.Status")}}</th>
                        <th>{{__("message.Action")}}</th>
                     </tr>
                  </thead>
                  <tbody>                        
                  </tbody>
                  <tfoot>
                     <th>{{__("message.Id")}}</th>
                     <th>{{__("message.Customer Name")}}e</th>
                     <th>{{__("message.Address")}}</th>
                     <th>{{__("message.Sample Collection DateTime")}}</th>
                     <th>{{__("message.Payment Method")}}</th>
                     <th>{{__("message.Paid Amount")}}</th>
                     <th>Reschedule</th>
                     <!--<th>{{__("message.Print")}}</th>-->
                     <th>{{__("message.Status")}}</th>
                     <th>{{__("message.Action")}}</th>
                  </tfoot>
               </table>
            </div>
            @endif
         </div>
      </div>
   </div>
</div>
@endsection