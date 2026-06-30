@extends('admin.layout.index')
@section('title')
{{__("message.Orders List")}}
@stop
@section('content')
<div class="page-header">
   <h3 class="page-title">{{__("message.Orders List")}}</h3>
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
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
            <div class="table-responsive">
               <table id="OrdersTable" class="table table-bordered text-nowrap dataTable no-footer">
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
                     </tr>
                  </thead>
                  <tbody>                        
                  </tbody>
                  <tfoot>
                     <th>{{__("message.Id")}}</th>
                     <th>{{__("message.Customer Name")}}</th>
                     <th>{{__("message.Address")}}</th>
                     <th>{{__("message.Sample Collection DateTime")}}</th>
                     <th>{{__("message.Payment Method")}}</th>
                     <th>{{__("message.Paid Amount")}}</th>
                     <th>{{__("message.More")}}</th>
                     <th>{{__("message.Print")}}</th>
                     <th>{{__("message.Status")}}</th>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="normalmodal" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">{{__("message.Order No")}} : <span id="order_no">5</span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> 
         </div>
         <div class="modal-body">
            <div style="margin-bottom: 10px;">
                 <p><b>{{__("message.Name")}} :</b> <span id="customer_name"></span></p>
                 <p><b>{{__("message.email")}} :</b> <span id="email"></span></p>
                 <p><b>{{__("message.Address")}} :</b> <span id="address"></span></p>
                 <p><b>{{__("message.Order Place Date")}} :</b> <span id="order_place_date"> </span></p>
                 <p><b>{{__("message.Payment Method")}} :</b> <span id="payment_method"> </span></p>
                 <p><b>{{__("message.Sample Collection Date")}} :</b> <span id="date"> </span></p>
                 <p><b>{{__("message.Sample Collection time")}} :</b> <span id="time"> </span></p>
            </div>
            <table class="table">
                 <thead>
                     <tr>
                        <td>{{__("message.Person Info")}}</td>
                        <td>{{__("message.Item Info")}}</td>
                        <td>{{__("message.Price")}}</td>
                     </tr>
                 </thead>
                 <tbody id="tableinfo">
                    
                 </tbody>
                 <tfoot>
                     <tr>
                                <td></td>
                                <th>{{__("message.Subtotal")}}</th>
                                <td id="subtotal"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <th>{{__("message.Txt Charges")}}</th>
                                <td id="txt_charge"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <th>{{__("message.Total")}}</th>
                                <th id="total"></th>
                            </tr>
                 </tfoot>

            </table>
         </div>
         <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
         </div>
      </div>
   </div>
</div>
@endsection