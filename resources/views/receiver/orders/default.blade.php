@extends('receiver.layout.index')
@section('title')
Parcel List
@stop
@section('content')
<div class="page-header">
   <h3 class="page-title">Parcel List</h3>
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('transport-admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">Parcel List</li>
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
               <table id="receiverOrdersTable" class="table table-bordered text-nowrap dataTable no-footer">
                  <thead>
                     <tr>
                        <th>{{__("message.Id")}}</th>
                        <th>{{__("message.Send From")}}</th>
                        <th>{{__("message.Send To")}}</th>
                        <th>{{__("message.Date")}}</th>
                        <th>{{__("message.Time")}}</th>
                        <th>{{__("message.courier_type")}}</th>
                        <th>{{__("message.qty")}}</th>
                        <th>{{__("message.More")}}</th>
                        <th>{{__("message.Status")}}</th>
                     </tr>
                  </thead>
                  <tbody>                        
                  </tbody>
                  <tfoot>
                     <th>{{__("message.Id")}}</th>
                     <th>{{__("message.Send From")}}</th>
                     <th>{{__("message.Send To")}}</th>
                     <th>{{__("message.Date")}}</th>
                     <th>{{__("message.Time")}}</th>
                     <th>{{__("message.courier_type")}}</th>
                     <th>{{__("message.qty")}}</th>
                     <th>{{__("message.More")}}</th>
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
            <h5 class="modal-title" id="normalmodal1"> Parcel Details <h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> 
         </div>
         <div class="modal-body">
            <div style="margin-bottom: 10px;" data-baseurl="{{ asset('storage/app/public/parcel/') }}">
                <img id="parcelImg" src="" alt="Dynamic Image">
            </div>
            <table class="table">
                 <thead>
                     <tr>
                        <td><p><b>Parcel Type:</b> <span id="email"></span></p></td>
                        <td><p><b>{{__("message.courier_type")}}:</b> <span id="customer_name"></span></p></td>
                        <td><p><b>Quantity :</b> <span id="order_no"></span></p></td>
                     </tr>
                     <tr>
                         <td><p><b>Weight:</b> <span id="address"></span></p></td>
                         <td><p><b>Vehicle_no :</b> <span id="order_place_date"> </span></p></td>
                         <td><p><b>driver_name :</b> <span id="payment_method"> </span></p></td>
                     </tr>
                     <tr>
                         <td><p><b>Driver Phon :</b> <span id="driver_phon"> </span></p></td>
                         <td><p><b>Date :</b> <span id="date"> </span></p></td>
                         <td><p><b>Time :</b> <span id="time"> </span></p></td>
                     </tr>
                     <tr>
                         <!--<td><p><b>Driver Phon :</b> <span id="driver_phon"> </span></p></td>-->
                         <td><p><b>Pickup Point :</b> <span id="pickup_point"> </span></p></td>
                     </tr>
                     <!--<tr>-->
                     <!--    <td></td>-->
                     <!--    <td></td>-->
                     <!--    <td></td>-->
                     <!--</tr>-->
                 </thead>
                 

            </table>
         </div>
         <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
         </div>
      </div>
   </div>
</div>
@endsection