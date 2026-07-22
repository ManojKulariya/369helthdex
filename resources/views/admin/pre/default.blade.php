@extends('admin.layout.index')
@section('title')
{{__("message.User Prescription")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.User Prescription")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.User Prescription")}}</li>
         </ol>
      </nav>
   </div>
</div>

{{-- ============ User prescription card: toolbar + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admPreSearch" placeholder="Search name, email, mobile…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admPreCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="preTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:6%">
            <col style="width:8%">
            <col style="width:16%">
            <col style="width:18%">
            <col style="width:8%">
            <col style="width:10%">
            <col style="width:12%">
            <col style="width:22%">
         </colgroup>
         <thead>
            <tr>
               <th>{{__("message.Id")}}</th>
               <th>Doc</th>
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
      </table>
   </div>
</div>

<script>
   /* ==========================================================================
      Redesign notes: markup/classes only, same pattern as the Feedback and
      Call Back Requests pages. #preTable's ajax URL/columns are initialised
      by public/admin.js exactly as before (now also with autoWidth:false —
      see the Feedback module notes on the skeleton+DataTables width bug).
      The "doc" column's render function was also switched from a Font
      Awesome icon (<i class="fa fa-download">) to an inline SVG to match
      the SVG-only icon system used everywhere else — same download glyph
      already used on the Orders page's Export button.
      ========================================================================== */
   function decorate($) {
      var $empty = $('#preTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M9 15h6"/><path d="M12 12v6"/></svg>' +
            '<b>No prescriptions yet</b><span>Prescriptions uploaded by customers will show up here.</span></div>'
         );
      }
      $('#preTable .adm-doc-link').addClass('adm-cat-eye');
   }

   function init($) {
      var table = $('#preTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admPreCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#preTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admPreSearch').on('input', function () {
         var v = this.value;
         clearTimeout(deb);
         deb = setTimeout(function () { table.search(v).draw(); }, 300);
      });
   }

   /* Wait for admin.js to finish initialising the DataTable (same pattern as
      the Orders page — admin.js loads after this inline script and creates
      the DataTable on $(document).ready). */
   window.addEventListener('load', function () {
      var tries = 0;
      (function hook() {
         var jq = window.jQuery;
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#preTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
