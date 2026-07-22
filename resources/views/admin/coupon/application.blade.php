@extends('admin.layout.index')
@section('title')
{{__("message.Application")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.Application")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.Application")}}</li>
         </ol>
      </nav>
   </div>
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

{{-- ============ Job applications card: toolbar + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admApplicationSearch" placeholder="Search name, mobile…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admApplicationCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="ApplicationTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:5%">
            <col style="width:14%">
            <col style="width:11%">
            <col style="width:8%">
            <col style="width:9%">
            <col style="width:10%">
            <col style="width:8%">
            <col style="width:8%">
            <col style="width:18%">
            <col style="width:6%">
         </colgroup>
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
               <th>{{__("message.Address")}}</th>
               <th>{{__("message.Resume")}}</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>

<script>
   /* ==========================================================================
      Redesign notes: markup/classes only, same pattern as Feedback/Complaints,
      Call Back Requests, and User Prescription. #ApplicationTable's ajax
      URL/columns are initialised by public/admin.js exactly as before (now
      also with autoWidth:false — see the Feedback module notes on the
      skeleton+DataTables width bug). The "resume" column's icon is built
      server-side in ControllerCoupon::application_datatable() — it already
      returns an inline SVG (swapped from Font Awesome) wrapped in
      rawColumns(['resume']) so the browser renders it instead of showing
      escaped HTML as text.
      ========================================================================== */
   function decorate($) {
      var $empty = $('#ApplicationTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>' +
            '<b>No applications yet</b><span>Submitted job applications will show up here.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#ApplicationTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admApplicationCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#ApplicationTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admApplicationSearch').on('input', function () {
         var v = this.value;
         clearTimeout(deb);
         deb = setTimeout(function () { table.search(v).draw(); }, 300);
      });

      setTimeout(function () { $('.adm-toast').fadeOut(400); }, 4500);
   }

   /* Wait for admin.js to finish initialising the DataTable (same pattern as
      the Orders page — admin.js loads after this inline script and creates
      the DataTable on $(document).ready). */
   window.addEventListener('load', function () {
      var tries = 0;
      (function hook() {
         var jq = window.jQuery;
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#ApplicationTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
