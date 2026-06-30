@extends('manager.layout.index')
@section('title')
Report List
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
            <div class="table-responsive">
               <table  class="table table-bordered text-nowrap dataTable no-footer">
                  <thead>
                     <tr>
                        <th>{{__("message.Id")}}</th>
                        <th>Report Title</th>
                        <th>TestId</th>
                        <!--<th>{{__("message.Action")}}</th>-->
                     </tr>
                  </thead>
                  <tbody>  
                  @foreach($reportdata as $index =>$row)
                  <tr>
                      <td>{{ ++$index }}</td>
                      <td>{{ $row->report_name }}</td>
                      <td>
                          {{$row->test_reg_id}}
                          <!--<a href="javascript:void(0)" onclick="fnGetPatientReport(this, '{{ $row->test_reg_id }}')"><i class="fas fa-eye"></i> View Report</a> -->
                      <!--<a href="{{asset('storage/app/public/report').'/'.$row->report}}"  target="_blank"><i class="fas fa-eye"></i> View Report</a>-->
                      </td>
                  </tr>
                  @endforeach
                  </tbody>
                 
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
                    <!--<tr>-->
                    <!--    <td></td>-->
                    <!--    <th>{{__("message.Txt Charges")}}</th>-->
                    <!--    <td id="txt_charge"></td>-->
                    <!--</tr>-->
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

<div class="modal fade" id="reject_order" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">{{__("message.Add Reject Description")}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> 
         </div>
         <form method="get" id="rejectorderurl" action="#">

         <div class="modal-body">
             
               <div class="form-group">
                        <label for="name">{{__("message.Description")}}<span class="reqfield">*</span></label>
                       <textarea class="form-control" name="reject_description" id="reject_description" required="" ></textarea>
                     </div>
              
              <p id="calculatetime" style="display: flex;justify-content: center;    margin-top: 20px;"></p>
              <div class="row">
                        
                     </div>
                   
         </div>
         <div class="modal-footer">
                                  
                           <input type="submit" value='{{__("message.Send")}}' class="btn btn-primary ">
                       
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
         </div>
          </form>
      </div>
   </div>
</div>

<div class="modal fade" id="complete_order" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">{{__("message.Complete Order")}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> 
         </div>
         <form method="post" action="{{route('complete-order')}}" id="completeorderurl
         " enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" id="com_order_id">
         <!--<div class="modal-body">             -->
         <!--      <div class="form-group">-->
         <!--         <label for="name">{{__("message.Upload Report")}}<span class="reqfield">*</span></label>-->
         <!--          <input type="file" name="report" required="" class="form-control" id="report" />-->
         <!--            </div>-->
         <!--     <p id="calculatetime" style="display: flex;justify-content: center;    margin-top: 20px;"></p>-->
         <!--     <div class="row">-->
         <!--    </div>-->
         <!--</div>-->
         <div class="modal-footer">
          <input type="submit" value='{{__("message.Send")}}' class="btn btn-primary">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
         </div>
          </form>
      </div>
   </div>
</div>
<div class="modal fade" id="Report_order" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">Upload Report</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> 
         </div>
         <form method="post" action="{{route('report-order')}}" id="completeorderurl
         " enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" id="report_order_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Report Name<span class="reqfield">*</span></label>
                            <input type="text" name="report_name" required="" class="form-control" id="report" />
                     </div>             
               <div class="form-group">
                  <label for="name">{{__("message.Upload Report")}}<span class="reqfield">*</span></label>
                   <input type="file" name="report" required="" class="form-control" id="report" />
                     </div>
              <p id="calculatetime" style="display: flex;justify-content: center;    margin-top: 20px;"></p>
              <div class="row">
             </div>
         </div>
         <div class="modal-footer">
          <input type="submit" value='{{__("message.Send")}}' class="btn btn-primary">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
         </div>
          </form>
      </div>
   </div>
</div>
@endsection