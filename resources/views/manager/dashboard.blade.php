@extends('manager.layout.index')
@section('title')
{{__("message.Dashboard")}}
@stop
@section('content')
<?php
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return "#".random_color_part() . random_color_part() . random_color_part();
}
$totalsales = 0;
$currency = '$';
 ?>
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0 text-primary">{{__("message.Dashboard")}}</h4>
	</div>				
</div>
<!--End Page header-->
<!-- Row-1 -->
<div class="row">
	<div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Orders")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalorder}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fab fa-first-order fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   	<div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Complete Orders")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalcomplete}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-tasks fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   	<div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Pending Orders")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalpending}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-spinner fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Rejected Orders")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalreject}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-spinner fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>			
</div>
<!--<div class="row">-->
<!--	<div class="col-lg-12 grid-margin stretch-card">-->
<!--       <div class="card">  -->
<!--         <div class="card-header">-->
<!--         	<div class="card-title">{{__("message.Today Collecting Order")}}</div>-->
<!--         </div>              	-->
<!--         <div class="card-body">-->
             <!--        #Lab           -->
<!--            @if(auth()->user()->user_type == 2)-->
                
<!--            <div class="table-responsive">-->
<!--               <table id="TodayOrdersTable" class="table table-bordered text-nowrap dataTable ">-->
<!--                  <thead>-->
<!--                     <tr>-->
<!--                        <th>{{__("message.Id")}}</th>-->
<!--                        <th>{{__("message.Customer Name")}}</th>-->
<!--                        <th>{{__("message.Address")}}</th>-->
<!--                        <th>{{__("message.Sample Collection DateTime")}}</th>-->
<!--                        <th>{{__("message.Payment Method")}}</th>-->
<!--                        <th>{{__("message.Paid Amount")}}</th>-->
<!--                        <th>{{__("message.More")}}</th>-->
<!--                        <th>{{__("message.Print")}}</th>-->
<!--                        <th>{{__("message.Status")}}</th>-->
<!--                        <th>{{__("message.Action")}}</th>-->
<!--                     </tr>-->
<!--                  </thead>-->
<!--                  <tbody>                        -->
<!--                  </tbody>-->
<!--                  <tfoot>-->
<!--                     <th>{{__("message.Id")}}</th>-->
<!--                     <th>{{__("message.Customer Name")}}e</th>-->
<!--                     <th>{{__("message.Address")}}</th>-->
<!--                     <th>{{__("message.Sample Collection DateTime")}}</th>-->
<!--                     <th>{{__("message.Payment Method")}}</th>-->
<!--                     <th>{{__("message.Paid Amount")}}</th>-->
<!--                     <th>{{__("message.More")}}</th>-->
<!--                     <th>{{__("message.Print")}}</th>-->
<!--                     <th>{{__("message.Status")}}</th>-->
<!--                     <th>{{__("message.Action")}}</th>-->
<!--                  </tfoot>-->
<!--               </table>-->
<!--            </div>-->
            
<!--            @endif-->
            <!--        #sample boy              -->
            
<!--            @if(auth()->user()->user_type != 2)-->
<!--            <div class="table-responsive">-->
<!--               <table id="TodayOrdersTableSample" class="table table-bordered text-nowrap dataTable no-footer">-->
<!--                  <thead>-->
<!--                     <tr>-->
<!--                        <th>{{__("message.Id")}}</th>-->
<!--                        <th>{{__("message.Customer Name")}}</th>-->
<!--                        <th>{{__("message.Address")}}</th>-->
<!--                        <th>{{__("message.Sample Collection DateTime")}}</th>-->
<!--                        <th>{{__("message.Payment Method")}}</th>-->
<!--                        <th>{{__("message.Paid Amount")}}</th>-->
<!--                        <th>Reschedule</th>-->
                        <!--<th>{{__("message.Print")}}</th>-->
<!--                        <th>{{__("message.Status")}}</th>-->
<!--                        <th>{{__("message.Action")}}</th>-->
<!--                     </tr>-->
<!--                  </thead>-->
<!--                  <tbody>                        -->
<!--                  </tbody>-->
<!--                  <tfoot>-->
<!--                     <th>{{__("message.Id")}}</th>-->
<!--                     <th>{{__("message.Customer Name")}}e</th>-->
<!--                     <th>{{__("message.Address")}}</th>-->
<!--                     <th>{{__("message.Sample Collection DateTime")}}</th>-->
<!--                     <th>{{__("message.Payment Method")}}</th>-->
<!--                     <th>{{__("message.Paid Amount")}}</th>-->
<!--                     <th>Reschedule</th>-->
                     <!--<th>{{__("message.Print")}}</th>-->
<!--                     <th>{{__("message.Status")}}</th>-->
<!--                     <th>{{__("message.Action")}}</th>-->
<!--                  </tfoot>-->
<!--               </table>-->
<!--            </div>-->
<!--            @endif-->
	       
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--</div>-->
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
                 <p><b>{{__("message.Phone")}} :</b> <span id="customer_phone"></span></p>
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
                        <th>Wallet Discount</th>
                        <td id="wallet"></td>
                    </tr>
                                        <tr>
                        <td></td>
                        <th>Coupon Discount</th>
                        <td id="coupon"></td>
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
        
         <div class="modal-footer">
          <input type="submit" value='{{__("message.Send")}}' class="btn btn-primary">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
         </div>
          </form>
      </div>
   </div>
</div>
<div class="modal fade" id="Report_order" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">Upload Report</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> 
         </div>
         <form  id="uploadreporturl">
               {{csrf_field()}}
               <input type="hidden" name="id" id="report_order_id">
                    <div class="modal-body">
                        <div class="form-group">
                        <label for="report_no">How many Reports<span class="reqfield">*</span></label>
                        <input type="number" step="1" name="no_of_report" min="1" required="" class="form-control" id="report_no" />
                    </div> 
                        <!--<span>Reports details</span>-->
                        <div class="row report_sec" id="report_details">
                            <!-- Dynamic report detail fields will be appended here -->
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
<div class="modal fade" id="Sample_order" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">Assign SampleBoy</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> 
         </div>
         <form method="post" action="{{route('report-order-sample')}}" id="completeorderurl
         " enctype="multipart/form-data">
               {{csrf_field()}}
               <input type="hidden" name="id" id="sampleboy_order_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" id="sampleboy_address_id"></label>
                        </div>             
                     <div class="form-group">
                        <label for="name">Select SampleBoy<span class="reqfield">*</span></label>
                        <select class="form-control" name="sm_boy_id" required>
                           <option value="">Select SampleBoy</option>
                           @foreach($user as $row)
                              <option value="{{ $row->id }}" > {{$row->name}}</option>
                           @endforeach
                        </select>
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
    <div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModal" style="display: none;" aria-hidden="true">
 
        <div class="modal-dialog">
          <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Select Date and Time</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
              
         <form method="post" action="{{route('reschedule-order-sample')}}">
               {{csrf_field()}}
               <input type="hidden" name="id" id="reschedule_order_id">
                <div class="form-group">
                  <label for="date">Select Date:</label>
                  <input type="date" min="<?php echo date('Y-m-d'); ?>" class="form-control" id="date" name="date" required>
                </div>
                <div class="form-group">
                  <label for="time">Select Time:</label>
                  <input type="time" class="form-control" id="time" name="time" required>
                </div>
                <div class="form-group">
                  <label for="time">Remark:</label>
                  <input type="text" class="form-control" id="time" name="remark" maxlength="100" required>
                </div>
                <button type="submit" class="btn btn-primary">Reschedule</button>
              </form>
            </div>
          </div>
        </div>
      </div>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
      $(document).ready(function() {
    $('#uploadreporturl').on('submit', function(event) {
        event.preventDefault();  
        var formData = new FormData(this); // Capture form data
        $.ajax({
            url: "{{ route('report-order') }}", // The route to handle the request
            type: "POST",
            data: formData,
            contentType: false,  // Required for file uploads
            processData: false,  // Required for file uploads
            success: function(response) {
                console.log(response);
                if (response && response.no_of_report > 0) {
                    $('#report_details').empty();
                    // Set the number of reports
                    $('#report_no').val(response.no_of_report);
                    var id = response.orderid;
                    // Loop through the reports provided in the response
                    for (let i = 0; i < response.no_of_report; i++) {
                        // Check if the current report exists in the response.Report array
                        let report = response.Report[i] || { report_name: '', test_reg_id: '' };
    
                        // Create the form fields for each report
                        const reportDetail = `
                            <form class="report_form" data-report-index="${i}">
                                <input type="hidden" name="report_id" id="report_id_${i}" value="${report.id}">
                                <input type="hidden" name="order_id" id="order_id_${i}" value="${id}">
                                <div class="row mb-3">
                                    <div class="form-group col-4">
                                        <label for="report_name_${i}">Report Name<span class="reqfield">*</span></label>
                                        <input type="text" name="report_name" class="form-control" id="report_name_${i}" value="${report.report_name}" required />
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="test_reg_id_${i}">Test Registration ID<span class="reqfield">*</span></label>
                                        <input type="text" name="test_reg_id" class="form-control" id="test_reg_id_${i}" value="${report.test_reg_id}" required />
                                    </div>
                                    <div class="col-4">
                                    
                                    <button type="button" class="btn btn-primary submit-report-btn btn-sm mt-6" data-index="${i}">Submit Report ${i + 1}</button>
                                    </div>
                                </div>
                            </form>
                        `;
    
                        // Append the report detail to the report_details container
                        $('#report_details').append(reportDetail);
                    }
                
                    
                }
            
            },
            error: function(response) {
                // Handle server-side errors
                alert('Error: ' + response.responseText);
            }
    });
});
});

      </script>
<!-- End Row-1 -->
@endsection