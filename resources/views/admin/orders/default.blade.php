@extends('admin.layout.index')
@section('title')
{{__("message.Orders List")}}
@stop
@section('content')
<style>
    /* Print only the order-details modal when it is open */
    @media print {
        body * { visibility: hidden !important; }
        #normalmodal, #normalmodal * { visibility: visible !important; }
        #normalmodal { position: absolute !important; left: 0; top: 0; width: 100%; margin: 0; padding: 0; overflow: visible !important; }
        #normalmodal .modal-dialog { max-width: 100% !important; margin: 0 !important; }
        #normalmodal .modal-content { border: none !important; box-shadow: none !important; }
        #normalmodal .modal-footer { display: none !important; }
    }
</style>

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.Orders List")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.Orders List")}}</li>
         </ol>
      </nav>
   </div>
   <a href="{{url('make_booking')}}" class="btn btn-success adm-btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
      Create Booking
   </a>
</div>

@if(Session::has('message'))
<div class="adm-toast-wrap">
   <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show adm-toast" role="alert">{{ Session::get('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
</div>
@endif

{{-- ============ Stats (computed client-side from the existing OrdersTable feed — no new endpoints) ============ --}}
<div class="adm-orders-stats">
   <button type="button" class="adm-stat" data-stat="total" data-filter="">
      <span class="adm-stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></span>
      <span class="adm-stat-value">—</span>
      <span class="adm-stat-label">Total Orders</span>
      <span class="adm-stat-trend" data-trend="total"></span>
   </button>
   <div class="adm-stat is-static" data-stat="today">
      <span class="adm-stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg></span>
      <span class="adm-stat-value">—</span>
      <span class="adm-stat-label">Today's Orders</span>
      <span class="adm-stat-trend">placed today</span>
   </div>
   <button type="button" class="adm-stat" data-stat="pending" data-filter="Pending">
      <span class="adm-stat-icon is-amber"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></span>
      <span class="adm-stat-value">—</span>
      <span class="adm-stat-label">{{__('message.Pending')}}</span>
      <span class="adm-stat-trend" data-trend="pending"></span>
   </button>
   <button type="button" class="adm-stat" data-stat="accepted" data-filter="Accepted">
      <span class="adm-stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></span>
      <span class="adm-stat-value">—</span>
      <span class="adm-stat-label">{{__('message.Accepted')}}</span>
      <span class="adm-stat-trend" data-trend="accepted"></span>
   </button>
   <button type="button" class="adm-stat" data-stat="collected" data-filter="Sample collected">
      <span class="adm-stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg></span>
      <span class="adm-stat-value">—</span>
      <span class="adm-stat-label">Sample Collected</span>
      <span class="adm-stat-trend" data-trend="collected"></span>
   </button>
   <button type="button" class="adm-stat" data-stat="partial" data-filter="Partial Report Send">
      <span class="adm-stat-icon is-amber"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg></span>
      <span class="adm-stat-value">—</span>
      <span class="adm-stat-label">Partial Report</span>
      <span class="adm-stat-trend" data-trend="partial"></span>
   </button>
   <button type="button" class="adm-stat" data-stat="complete" data-filter="Complete">
      <span class="adm-stat-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></span>
      <span class="adm-stat-value">—</span>
      <span class="adm-stat-label">{{__('message.Complete')}}</span>
      <span class="adm-stat-trend" data-trend="complete"></span>
   </button>
   <button type="button" class="adm-stat" data-stat="rejected" data-filter="Rejected">
      <span class="adm-stat-icon is-red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg></span>
      <span class="adm-stat-value">—</span>
      <span class="adm-stat-label">{{__('message.Rejected')}}</span>
      <span class="adm-stat-trend" data-trend="rejected"></span>
   </button>
</div>

{{-- ============ Orders card: toolbar + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admOrdersSearch" placeholder="Search order id, customer, package, address…" autocomplete="off">
      </div>
      <select id="admFilterStatus" class="adm-ot-select" aria-label="Order status">
         <option value="">All statuses</option>
         <option value="Pending">{{__('message.Pending')}}</option>
         <option value="Accepted">{{__('message.Accepted')}}</option>
         <option value="Sample Assigned">Sample Assigned</option>
         <option value="Sample collected">{{__('message.Sample collected')}}</option>
         <option value="Preparing Report">{{__('message.Preparing Report')}}</option>
         <option value="Partial Report Send">Partial Report Send</option>
         <option value="Complete">{{__('message.Complete')}}</option>
         <option value="Rejected">{{__('message.Rejected')}}</option>
         <option value="Refunded">{{__('message.Refunded')}}</option>
         <option value="Cancel Visit">Visit Cancelled</option>
      </select>
      <select id="admFilterPay" class="adm-ot-select" aria-label="Payment method">
         <option value="">All payments</option>
         <option value="cod">COD</option>
         <option value="razorpay">Razorpay</option>
      </select>
      <select id="admFilterSource" class="adm-ot-select" aria-label="Order source">
         <option value="">All sources</option>
         <option value="WEB">Website</option>
         <option value="APP">App</option>
      </select>
      <input type="date" id="admFilterDate" class="adm-ot-select adm-ot-date" aria-label="Collection date">
      <select id="admPageLen" class="adm-ot-select adm-ot-len" aria-label="Rows per page">
         <option value="10">10 rows</option>
         <option value="25" selected>25 rows</option>
         <option value="50">50 rows</option>
         <option value="100">100 rows</option>
      </select>
      <button type="button" id="admFiltersReset" class="adm-ot-btn" title="Reset filters">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
         Reset
      </button>
      <button type="button" id="admExportCsv" class="adm-ot-btn adm-ot-btn--green" title="Export the current page to CSV">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
         Export
      </button>
      <span class="adm-ot-count" id="admResultCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="OrdersTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col class="adm-col-id">
            <col class="adm-col-customer">
            <col class="adm-col-items">
            <col class="adm-col-address">
            <col class="adm-col-when">
            <col class="adm-col-amount">
            <col class="adm-col-details">
            <col class="adm-col-status">
            <col class="adm-col-actions">
         </colgroup>
         <thead>
            <tr>
               <th>{{__("message.Id")}}</th>
               <th>{{__("message.Customer Name")}}</th>
               <th>Package/Test</th>
               <th>{{__("message.Address")}}</th>
               <th>Collection<br>Schedule</th>
               <th>Amount &amp;<br>Payment</th>
               <th>Details</th>
               <th>{{__("message.Status")}}</th>
               <th>{{__("message.Action")}}</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>

{{-- ============ Order details modal (all ids consumed by admin.js moreinfo() are preserved) ============ --}}
<div class="modal fade adm-modal" id="normalmodal" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">
               <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></span>
               {{__("message.Order No")}} : #<span id="order_no"></span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
         </div>
         <div class="modal-body">
            <div class="adm-od-grid">
               <div class="adm-od-card">
                  <div class="adm-od-card-title">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                     Customer
                  </div>
                  <div class="adm-od-row"><span>{{__("message.Name")}}</span><b id="customer_name"></b></div>
                  <div class="adm-od-row"><span>{{__("message.Phone")}}</span><b id="customer_phone"></b></div>
                  <div class="adm-od-row"><span>{{__("message.email")}}</span><b id="email"></b></div>
                  <div class="adm-od-row adm-od-row--block"><span>{{__("message.Address")}}</span><b id="address"></b></div>
               </div>
               <div class="adm-od-card">
                  <div class="adm-od-card-title">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                     Order
                  </div>
                  <div class="adm-od-row"><span>{{__("message.Order Place Date")}}</span><b id="order_place_date"></b></div>
                  <div class="adm-od-row"><span>{{__("message.Payment Method")}}</span><b id="payment_method"></b></div>
                  <div class="adm-od-row"><span>{{__("message.Sample Collection Date")}}</span><b id="date"></b></div>
                  <div class="adm-od-row"><span>{{__("message.Sample Collection time")}}</span><b id="time"></b></div>
               </div>
            </div>

            <div class="adm-od-card adm-od-items">
               <div class="adm-od-card-title">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/></svg>
                  Selected Tests
               </div>
               <table class="table adm-od-table">
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
                     <tr class="adm-od-taxrow">
                        <td></td>
                        <th>Tax</th>
                        <td id="txt_charge"></td>
                     </tr>
                     <tr class="adm-od-total">
                        <td></td>
                        <th>{{__("message.Total")}}</th>
                        <th id="total"></th>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-success adm-btn-primary" onclick="window.print()">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
               {{__("message.Print")}}
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
         </div>
      </div>
   </div>
</div>

{{-- ============ Reject order modal ============ --}}
<div class="modal fade adm-modal" id="reject_order" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header adm-modal-header--red">
            <h5 class="modal-title" id="normalmodal1">
               <span class="adm-modal-icon is-red"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg></span>
               {{__("message.Add Reject Description")}}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
         </div>
         <form method="get" id="rejectorderurl" action="#">
            <div class="modal-body">
               <p class="adm-modal-hint">The customer will see this reason against their order. Please describe why the order is being rejected.</p>
               <div class="form-group">
                  <label for="name">{{__("message.Description")}}<span class="reqfield">*</span></label>
                  <textarea class="form-control" name="reject_description" id="reject_description" rows="4" required=""></textarea>
               </div>
               <p id="calculatetime" style="display: flex;justify-content: center;margin-top: 20px;"></p>
            </div>
            <div class="modal-footer">
               <input type="submit" value='{{__("message.Send")}}' class="btn btn-danger adm-btn-danger">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
            </div>
         </form>
      </div>
   </div>
</div>

{{-- ============ Complete order modal ============ --}}
<div class="modal fade adm-modal" id="complete_order" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">
               <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></span>
               {{__("message.Complete Order")}}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
         </div>
         <form method="post" action="{{route('complete-order-admin')}}" id="completeorderurl
         " enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" id="com_order_id">
            <div class="modal-body">
               <p class="adm-modal-hint mb-0">Mark this order as complete? The customer will be notified that their reports are finalised.</p>
            </div>
            <div class="modal-footer">
               <input type="submit" value='{{__("message.Send")}}' class="btn btn-primary adm-btn-primary">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
            </div>
         </form>
      </div>
   </div>
</div>

{{-- ============ Upload report modal ============ --}}
<div class="modal fade adm-modal" id="Report_order" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">
               <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg></span>
               Upload Report
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
         </div>
         <form id="uploadreporturl">
            {{csrf_field()}}
            <input type="hidden" name="id" id="report_order_id">
            <div class="modal-body">
               <div class="form-group">
                  <label for="report_no">How many Reports<span class="reqfield">*</span></label>
                  <input type="number" step="1" name="no_of_report" min="1" required="" class="form-control" id="report_no" />
               </div>
               <div class="row report_sec" id="report_details">
                  <!-- Dynamic report detail fields will be appended here -->
               </div>
               <p id="calculatetime" style="display: flex;justify-content: center;margin-top: 20px;"></p>
            </div>
            <div class="modal-footer">
               <input type="submit" value='{{__("message.Send")}}' class="btn btn-primary adm-btn-primary">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
            </div>
         </form>
      </div>
   </div>
</div>

{{-- ============ Assign to Lab modal — same form fields (POST report-order-lab-admin, lab_id), labs as selectable cards ============ --}}
<div class="modal fade adm-modal" id="lab_order" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">
               <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg></span>
               Assign To Lab
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
         </div>
         <form method="post" action="{{route('report-order-lab-admin')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" id="lab_order_id">
            <div class="modal-body">
               <div class="form-group" hidden>
                  <label for="name" id="sampleboy_address_id"></label>
               </div>
               <div class="adm-ot-search adm-lab-search">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                  <input type="text" id="admLabSearch" placeholder="Search labs…" autocomplete="off">
               </div>
               <div class="adm-lab-list">
                  @foreach($labs as $row)
                  <label class="adm-lab-card">
                     <input type="radio" name="lab_id" value="{{$row->id}}" required>
                     <span class="adm-lab-check"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                     <span class="adm-lab-body">
                        <span class="adm-lab-name">{{$row->name}}</span>
                        @if(!empty($row->phone))
                        <span class="adm-lab-meta"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>{{$row->phone}}</span>
                        @endif
                        @if(!empty($row->address))
                        <span class="adm-lab-meta"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>{{ \Illuminate\Support\Str::limit(str_replace(["\r","\n"], ' ', $row->address), 90) }}</span>
                        @endif
                     </span>
                  </label>
                  @endforeach
               </div>
               <p id="calculatetime" style="display: flex;justify-content: center;margin-top: 20px;"></p>
            </div>
            <div class="modal-footer">
               <input type="submit" value='{{__("message.Send")}}' class="btn btn-primary adm-btn-primary">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
            </div>
         </form>
      </div>
   </div>
</div>

{{-- ============ Assign SampleBoy modal (select is populated by admin.js assignsampleboy()) ============ --}}
<div class="modal fade adm-modal" id="Sample_order" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">
               <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg></span>
               Assign SampleBoy
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
         </div>
         <form method="post" action="{{route('report-order-sample-admin')}}" id="completeorderurl
         " enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" id="sampleboy_order_id">
            <div class="modal-body">
               <div class="form-group" hidden>
                  <label for="name" id="sampleboy_address_id"></label>
               </div>
               <div class="form-group">
                  <label for="name">Select SampleBoy<span class="reqfield">*</span></label>
                  <select class="form-control" name="sm_boy_id" required>
                  </select>
               </div>
               <p id="calculatetime" style="display: flex;justify-content: center;margin-top: 20px;"></p>
            </div>
            <div class="modal-footer">
               <input type="submit" value='{{__("message.Send")}}' class="btn btn-primary adm-btn-primary">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("message.Close")}}</button>
            </div>
         </form>
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
                admNotify.error(response.responseText, 'Request Failed');
            }
    });
});
});

      </script>

<script>
/* ==========================================================================
   Orders UI enhancement layer — display only.
   admin.js still owns the DataTable init, its AJAX feed, the 2-minute
   auto-refresh, and every modal function (moreinfo/assignLab/…). This layer
   waits for that table, then decorates rendered cells (badges, icon
   buttons), wires the toolbar filters through the DataTables API, and
   computes the stat cards from the same feed. No new endpoints, no
   changed requests other than standard DataTables search/paging params.
   ========================================================================== */
(function () {
   'use strict';

   var ICONS = {
      check: '<path d="M20 6 9 17l-5-5"/>',
      'check-circle': '<circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>',
      'x-circle': '<circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>',
      x: '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
      building: '<rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/>',
      'user-plus': '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/>',
      'user-check': '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>',
      droplet: '<path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/>',
      upload: '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/>',
      send: '<path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>',
      refund: '<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/>',
      eye: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>',
      clock: '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
      'refresh-cw': '<path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/>',
      calendar: '<rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/>'
   };
   function svg(name) {
      return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + (ICONS[name] || '') + '</svg>';
   }
   /* order matters: longer/more specific labels first. Color communicates
      intent: green = positive, red = reject, blue = assign/informational. */
   var ACTION_META = [
      ['ReAssign SampleBoy', 'user-plus', 'blue'], ['Assign SampleBoy', 'user-plus', 'blue'],
      ['Change Lab', 'building', 'blue'],
      ['Sample Collected', 'droplet', 'green'],
      ['Sample Accept', 'check', 'green'], ['Sample Reject', 'x', 'red'],
      ['Upload Report', 'upload', 'blue'], ['Partial Report Send', 'send', 'blue'],
      ['Complete', 'check-circle', 'green'], ['Refund', 'refund', 'red'],
      ['Accept', 'check', 'green'], ['Reject', 'x', 'red']
   ];
   var BADGES = [
      ['Sample Assigned', 'Sample Assigned', 'blue', 'user-check'],
      ['Cancel Visit',    'Visit Cancelled', 'red', 'x-circle'],
      ['Partial Report Send', 'Partial Report', 'orange', 'send'],
      ['Sample collected','Sample Collected', 'purple', 'droplet'],
      ['Preparing Report','Processing', 'orange', 'refresh-cw'],
      ['Pending',         'Pending',   'amber', 'clock'],
      ['Accepted',        'Accepted',  'green', 'check-circle'],
      ['Rejected',        'Rejected',  'red', 'x-circle'],
      ['Refunded',        'Refunded',  'ink', 'refund'],
      ['Complete',        'Completed', 'solid', 'check-circle']
   ];
   var MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

   function stripHtml(html) {
      var d = document.createElement('div');
      d.innerHTML = html == null ? '' : String(html);
      return (d.textContent || '').replace(/\s+/g, ' ').trim();
   }
   /* like stripHtml, but keeps <br> as line breaks instead of collapsing
      them to a space — needed to pull apart name/family-members and
      date/time, which the controller joins with <br> */
   function htmlToLines(html) {
      var d = document.createElement('div');
      d.innerHTML = String(html == null ? '' : html).replace(/<br\s*\/?>/gi, '\n');
      return (d.textContent || '').split('\n').map(function (s) { return s.trim(); }).filter(Boolean);
   }
   function escapeHtml(s) {
      return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
         return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
      });
   }
   function formatDatePretty(s) {
      var m = /^(\d{4})-(\d{2})-(\d{2})/.exec(s || '');
      return m ? (m[3] + ' ' + MONTHS[parseInt(m[2], 10) - 1] + ' ' + m[1]) : (s || '');
   }
   function formatTimePretty(s) {
      var m = /^(\d{1,2}):(\d{2})/.exec(s || '');
      if (!m) { return s || ''; }
      var h = parseInt(m[1], 10), ap = h >= 12 ? 'PM' : 'AM', h12 = h % 12 || 12;
      return (h12 < 10 ? '0' : '') + h12 + ':' + m[2] + ' ' + ap;
   }

   var COL_LABELS = ['Order', 'Customer', 'Package/Test', 'Address', 'Collection', 'Amount', 'Details', 'Status', 'Actions'];

   function decorate($) {
      $('#OrdersTable tbody tr').each(function () {
         var $tds = $(this).children('td');
         if ($tds.length < 9) { return; } /* empty-state row */

         /* mobile card-view labels (CSS reads these via ::before) */
         $tds.each(function (i) {
            if (COL_LABELS[i] && !this.hasAttribute('data-label')) { this.setAttribute('data-label', COL_LABELS[i]); }
         });

         /* Order id pill */
         var $id = $tds.eq(0);
         if (!$id.data('adm')) {
            $id.data('adm', 1).html('<span class="adm-oid">#' + $id.text().trim() + '</span>');
         }

         /* Customer cell: Name (bold) + up to 2 family-member lines (muted),
            "+N more" if there are more. No mobile number is added here — the
            "name" column's server payload never included one (only address
            is a separate column, with no phone), so there's nothing to show
            without a backend change, which is out of scope. */
         var $cust = $tds.eq(1);
         if (!$cust.data('adm')) {
            $cust.data('adm', 1).addClass('adm-cell-customer');
            var custLines = htmlToLines($cust.html());
            var custName = custLines[0] || '';
            var family = custLines.slice(1).filter(function (l) { return !/^[\s-]+$/.test(l); });
            var famHtml = '';
            if (family.length) {
               var shown = family.slice(0, 2).map(escapeHtml).join('<br>');
               famHtml = '<span class="adm-cust-meta">' + shown +
                  (family.length > 2 ? '<br><span class="adm-cust-more">+' + (family.length - 2) + ' more</span>' : '') +
                  '</span>';
            }
            $cust.html('<span class="adm-cust-name">' + escapeHtml(custName) + '</span>' + famHtml);
         }

         /* Package/Test: clamp to 2 lines, full text available on hover */
         var $items = $tds.eq(2);
         if (!$items.data('adm')) {
            var itemsText = stripHtml($items.html());
            $items.data('adm', 1).addClass('adm-cell-items').attr('title', itemsText)
                  .html('<span class="adm-clamp2">' + escapeHtml(itemsText) + '</span>');
         }

         /* Address: same 2-line clamp + hover tooltip */
         var $addr = $tds.eq(3);
         if (!$addr.data('adm')) {
            var addrText = $addr.text().trim();
            $addr.data('adm', 1).addClass('adm-cell-addr').attr('title', addrText)
                 .html('<span class="adm-clamp2">' + escapeHtml(addrText) + '</span>');
         }

         /* Collection schedule: date and time on their own rows with icons */
         var $when = $tds.eq(4);
         if (!$when.data('adm')) {
            var whenLines = htmlToLines($when.html());
            $when.data('adm', 1).addClass('adm-cell-when').html(
               '<span class="adm-when-row">' + svg('calendar') + escapeHtml(formatDatePretty(whenLines[0])) + '</span>' +
               (whenLines[1] ? '<span class="adm-when-row">' + svg('clock') + escapeHtml(formatTimePretty(whenLines[1])) + '</span>' : '')
            );
         }

         /* Amount cell: bold amount + payment/source chips, centered to
            match the Status/Details/Action column family */
         var $amt = $tds.eq(5);
         if (!$amt.data('adm')) {
            $amt.data('adm', 1).addClass('adm-cell-amount');
            var parts = $amt.html().split(/<br\s*\/?>/i);
            if (parts.length >= 2) {
               var method = stripHtml(parts[1]);
               var src = stripHtml(parts.slice(2).join(' ')).replace(/^From:\s*/i, '');
               $amt.html(
                  '<div class="adm-col-stack">' +
                  '<span class="adm-amt">' + stripHtml(parts[0]) + '</span>' +
                  '<span class="adm-chip-row">' +
                  (method ? '<span class="adm-chip ' + (method.toLowerCase() === 'cod' ? 'adm-chip--ink' : 'adm-chip--green') + '">' + method.toUpperCase() + '</span>' : '') +
                  (src ? '<span class="adm-chip adm-chip--ghost">' + src + '</span>' : '') +
                  '</span>' +
                  '</div>'
               );
            }
         }

         /* Status: fixed-width pill, icon + label, per-status color */
         var $st = $tds.eq(7);
         if (!$st.data('adm')) {
            $st.data('adm', 1).addClass('adm-cell-status');
            var raw = $st.html() || '';
            var plain = stripHtml(raw);
            for (var i = 0; i < BADGES.length; i++) {
               if (plain.indexOf(BADGES[i][0]) !== -1) {
                  var rest = plain.replace(BADGES[i][0], '').replace(/^[\s:,-]+|[\s:,-]+$/g, '');
                  $st.html('<div class="adm-col-stack">' +
                           '<span class="adm-badge adm-badge--' + BADGES[i][2] + '">' + svg(BADGES[i][3]) + '<span>' + BADGES[i][1] + '</span></span>' +
                           (rest ? '<span class="adm-badge-sub">' + escapeHtml(rest) + '</span>' : '') +
                           '</div>');
                  break;
               }
            }
         }

         /* Details: single fixed-width icon+label button, native tooltip */
         var $details = $tds.eq(6);
         if (!$details.data('adm')) {
            $details.data('adm', 1).addClass('adm-cell-details');
            $details.find('a').each(function () {
               var $a = $(this);
               if ($a.data('adm')) { return; }
               $a.data('adm', 1).removeAttr('style').addClass('adm-view-btn')
                 .attr('title', 'View order details')
                 .html(svg('eye') + '<span>View</span>');
            });
            $details.wrapInner('<div class="adm-col-stack"></div>');
         }

         /* Action: keep every anchor (same hrefs/onclick) — equal width via
            CSS stretch, recolored by intent (green=positive, red=reject,
            blue=assign) instead of the original bootstrap btn-* class */
         var $actions = $tds.eq(8);
         if (!$actions.data('adm')) {
            $actions.data('adm', 1).addClass('adm-cell-actions');
            /* Once an order is fully complete the controller returns a bare
               "Completed" string instead of any buttons — give that plain
               text node the same visual weight as everything else in this
               column instead of leaving it as stray unstyled text. */
            if (!$actions.find('a, span').length) {
               var doneText = $actions.text().trim();
               if (doneText) {
                  $actions.html('<span class="adm-act-note">' + svg('check-circle') + escapeHtml(doneText) + '</span>');
               }
            }
            $actions.find('a').each(function () {
               var $a = $(this);
               if ($a.data('adm')) { return; }
               $a.data('adm', 1).removeAttr('style').addClass('adm-act');
               var label = $a.text().trim();
               var matched = false;
               for (var i = 0; i < ACTION_META.length; i++) {
                  if (label.indexOf(ACTION_META[i][0]) !== -1) {
                     $a.prepend(svg(ACTION_META[i][1])).addClass('adm-act--' + ACTION_META[i][2]);
                     matched = true;
                     break;
                  }
               }
               if (!matched) { $a.addClass('adm-act--blue'); }
               if (label.indexOf('Refund') !== -1) {
                  $a.on('click', function (e) {
                     e.preventDefault();
                     var href = $a.attr('href');
                     admNotify.confirm('This cannot be undone.', {
                        title: 'Refund this order?',
                        confirmText: 'Refund',
                        cancelText: 'Cancel',
                        danger: true
                     }).then(function (ok) { if (ok) { window.location.href = href; } });
                  });
               }
            });
            $actions.find('> span').addClass('adm-cell-manager');
            $actions.wrapInner('<div class="adm-col-stack"></div>');
         }
      });

      /* Empty state */
      var $empty = $('#OrdersTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>' +
            '<b>No orders found</b><span>Try adjusting the search or filters above.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#OrdersTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      /* ---------- stats ---------- */
      function todayPrefix() { /* orderplace_date is stored dd-mm-YYYY H:i:s */
         var d = new Date(), p = function (n) { return (n < 10 ? '0' : '') + n; };
         return p(d.getDate()) + '-' + p(d.getMonth() + 1) + '-' + d.getFullYear();
      }
      function setStat(key, val) { $('[data-stat="' + key + '"] .adm-stat-value').text(val); }
      function setTrend(key, txt) { $('[data-trend="' + key + '"]').text(txt); }
      function pct(n, t) { return t ? Math.round(n * 100 / t) + '% of total' : ''; }

      var counted = false;
      function computeCounts(json) {
         if (counted) { return; }
         var total = json && json.recordsTotal;
         if (typeof total === 'undefined') { return; }
         setStat('total', total);
         if (total > 800) { return; } /* don't pull huge datasets just for card counts */
         counted = true;
         var params = $.extend(true, {}, table.ajax.params());
         params.start = 0; params.length = -1;
         $.getJSON(table.ajax.url(), params).done(function (full) {
            var c = { today: 0, pending: 0, accepted: 0, collected: 0, partial: 0, complete: 0, rejected: 0 };
            var tp = todayPrefix();
            (full.data || []).forEach(function (row) {
               var s = stripHtml(row.status);
               if ((row.orderplace_date || '').indexOf(tp) === 0) { c.today++; }
               if (s.indexOf('Partial Report Send') !== -1) { c.partial++; }
               else if (s.indexOf('Sample collected') !== -1) { c.collected++; }
               else if (s.indexOf('Pending') !== -1) { c.pending++; }
               else if (s.indexOf('Rejected') !== -1) { c.rejected++; }
               else if (s.indexOf('Refunded') !== -1) { }
               else if (s.indexOf('Complete') !== -1) { c.complete++; }
               else if (s.indexOf('Accepted') !== -1 || s.indexOf('Sample Assigned') !== -1 || s.indexOf('Cancel Visit') !== -1) { c.accepted++; }
            });
            var t = (full.data || []).length || total;
            setStat('today', c.today); setStat('pending', c.pending); setStat('accepted', c.accepted);
            setStat('collected', c.collected); setStat('partial', c.partial);
            setStat('complete', c.complete); setStat('rejected', c.rejected);
            setTrend('total', '+' + c.today + ' today');
            setTrend('pending', pct(c.pending, t)); setTrend('accepted', pct(c.accepted, t));
            setTrend('collected', pct(c.collected, t)); setTrend('partial', pct(c.partial, t));
            setTrend('complete', pct(c.complete, t)); setTrend('rejected', pct(c.rejected, t));
         });
      }

      /* stat cards double as one-click status filters */
      $('.adm-stat[data-filter]').on('click', function () {
         var v = $(this).data('filter') || '';
         $('#admFilterStatus').val(
            $('#admFilterStatus option[value="' + v + '"]').length ? v : ''
         );
         $('.adm-stat').removeClass('is-active');
         if (v) { $(this).addClass('is-active'); }
         table.column(7).search(v).draw();
      });

      /* ---------- toolbar filters (all via the DataTables API) ---------- */
      var deb;
      $('#admOrdersSearch').on('input', function () {
         var v = this.value;
         clearTimeout(deb);
         deb = setTimeout(function () { table.search(v).draw(); }, 400);
      });
      $('#admFilterStatus').on('change', function () {
         $('.adm-stat').removeClass('is-active');
         table.column(7).search(this.value).draw();
      });
      function payAndSource() {
         var v = [$('#admFilterPay').val(), $('#admFilterSource').val()].filter(Boolean).join(' ');
         table.column(5).search(v).draw();
      }
      $('#admFilterPay, #admFilterSource').on('change', payAndSource);
      $('#admFilterDate').on('change', function () {
         table.column(4).search(this.value).draw();
      });
      $('#admPageLen').on('change', function () {
         table.page.len(parseInt(this.value, 10) || 25).draw();
      });
      $('#admFiltersReset').on('click', function () {
         $('#admOrdersSearch').val('');
         $('#admFilterStatus, #admFilterPay, #admFilterSource').val('');
         $('#admFilterDate').val('');
         $('.adm-stat').removeClass('is-active');
         table.search('').columns().search('').draw();
      });

      /* ---------- export current page as CSV (client-side only) ---------- */
      $('#admExportCsv').on('click', function () {
         var cols = [0, 1, 2, 3, 4, 5, 7];
         var head = ['Order', 'Customer', 'Package/Test', 'Address', 'Collection', 'Amount', 'Status'];
         var lines = [head.join(',')];
         table.rows({ page: 'current' }).every(function () {
            var d = this.data();
            var keys = ['id', 'name', 'item_name', 'address', 'datetime', 'paid_amount', 'status'];
            lines.push(keys.map(function (k) {
               return '"' + stripHtml(d[k]).replace(/"/g, '""') + '"';
            }).join(','));
         });
         var blob = new Blob(['﻿' + lines.join('\n')], { type: 'text/csv;charset=utf-8;' });
         var a = document.createElement('a');
         a.href = URL.createObjectURL(blob);
         a.download = 'orders-' + new Date().toISOString().slice(0, 10) + '.csv';
         document.body.appendChild(a); a.click();
         setTimeout(function () { URL.revokeObjectURL(a.href); a.remove(); }, 500);
      });

      /* ---------- draw pipeline ---------- */
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admResultCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
         computeCounts(json);
      });
      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      /* the table may already have drawn before this script hooked in */
      if ($('#OrdersTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
         var j = table.ajax.json();
         if (j) {
            $('#admResultCount').text(j.recordsFiltered + ' result' + (j.recordsFiltered === 1 ? '' : 's'));
            computeCounts(j);
         }
      }

      /* lab card selected state */
      $(document).on('change', '.adm-lab-card input[type=radio]', function () {
         $('.adm-lab-card').removeClass('is-selected');
         $(this).closest('.adm-lab-card').addClass('is-selected');
      });
      /* lab card search */
      $('#admLabSearch').on('input', function () {
         var t = this.value.toLowerCase();
         $('.adm-lab-card').each(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(t) !== -1);
         });
      });

      /* session flash auto-dismiss */
      setTimeout(function () { $('.adm-toast').fadeOut(400); }, 4500);
   }

   /* Wait for admin.js to finish initialising the DataTable */
   window.addEventListener('load', function () {
      var tries = 0;
      (function hook() {
         var jq = window.jQuery;
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#OrdersTable')) { init(jq); }
         else if (++tries < 80) { setTimeout(hook, 150); }
      })();
   });
})();
</script>
@endsection
