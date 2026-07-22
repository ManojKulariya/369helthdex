@extends('admin.layout.index')
@section('title')
Feedback/Complaints
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">Feedback/Complaints</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">Feedback/Complaints</li>
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

{{-- ============ Feedback card: toolbar + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admComplaintSearch" placeholder="Search name, email, mobile…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admComplaintCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="complaintTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:8%">
            <col style="width:18%">
            <col style="width:22%">
            <col style="width:14%">
            <col style="width:38%">
         </colgroup>
         <thead>
            <tr>
               <th>Sr.no</th>
               <th>Name</th>
               <th>Email</th>
               <th>Number</th>
               <th>Message</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>

<script>
   /* ==========================================================================
      Redesign notes: markup/classes only. The DataTable itself (#complaintTable,
      its ajax URL, and column list) is initialised by public/admin.js exactly
      as before — untouched. This script only adds the same presentational
      touches used on the Orders page: skeleton-to-table swap, empty state,
      row styling, live result count, and a custom search box wired to the
      DataTables API (native filter box removed from the markup above).
      ========================================================================== */
   function decorate($) {
      var $empty = $('#complaintTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>' +
            '<b>No feedback yet</b><span>Submitted feedback and complaints will show up here.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#complaintTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admComplaintCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#complaintTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admComplaintSearch').on('input', function () {
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
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#complaintTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
