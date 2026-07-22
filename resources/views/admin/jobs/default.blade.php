@extends('admin.layout.index')
@section('title')
Vacancies
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">Vacancies</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">Vacancies</li>
         </ol>
      </nav>
   </div>
   <a href="{{url('savevacancies/0')}}" class="btn btn-primary adm-btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
      Add Vacancies
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

{{-- ============ Vacancies card: toolbar + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admJobSearch" placeholder="Search title, department…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admJobCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="JobTable" class="table adm-orders-table dataTable no-footer" style="min-width:1350px;">
         <colgroup>
            <col style="width:5%">
            <col style="width:13%">
            <col style="width:9%">
            <col style="width:10%">
            <col style="width:9%">
            <col style="width:8%">
            <col style="width:11%">
            <col style="width:11%">
            <col style="width:8%">
            <col style="width:16%">
         </colgroup>
         <thead>
            <tr>
               <th>{{__("message.ID")}}</th>
               <th>Title</th>
               <th>Openings</th>
               <th>Location</th>
               <th>Experince</th>
               <th>Salary</th>
               <th>Department</th>
               <th>Designations</th>
               <th>Status</th>
               <th>{{__("message.Action")}}</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>

<script>
   /* ==========================================================================
      Redesign notes: markup/classes only. #JobTable's ajax URL/columns are
      initialised by public/admin.js exactly as before (now also with
      autoWidth:false). Edit/Delete already both worked in the original
      action column — only restyled. Status now uses the shared
      .adm-chip--green/.adm-chip--ink badge classes instead of plain text.
      ========================================================================== */
   function decorate($) {
      var $empty = $('#JobTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7h-3V6a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3v1H4a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8a1 1 0 0 0-1-1Z"/><path d="M9 6a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1H9Z"/></svg>' +
            '<b>No vacancies yet</b><span>Click "Add Vacancies" to post the first one.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#JobTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admJobCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#JobTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admJobSearch').on('input', function () {
         var v = this.value;
         clearTimeout(deb);
         deb = setTimeout(function () { table.search(v).draw(); }, 300);
      });

      setTimeout(function () { $('.adm-toast').fadeOut(400); }, 4500);
   }

   window.addEventListener('load', function () {
      var tries = 0;
      (function hook() {
         var jq = window.jQuery;
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#JobTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
