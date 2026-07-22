@extends('admin.layout.index')
@section('title')
{{__("message.City")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">Location</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">Location</li>
         </ol>
      </nav>
   </div>
   <a href="{{url('savecity/0')}}" class="btn btn-success adm-btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
      Add Location
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

{{-- ============ Location card: toolbar + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admCitySearch" placeholder="Search location, city…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admCityCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="CityTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:8%">
            <col style="width:28%">
            <col style="width:22%">
            <col style="width:14%">
            <col style="width:28%">
         </colgroup>
         <thead>
            <tr>
               <th>{{__("message.ID")}}</th>
               <th>Location</th>
               <th>City</th>
               <th>Default</th>
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
      Redesign notes: markup/classes only, same pattern as Category
      (Subcategory). #CityTable's ajax URL/columns are initialised by
      public/admin.js exactly as before (now also with autoWidth:false).
      Action buttons restyled server-side in CityController::citydatatable()
      (.adm-act icons, same as Category's Edit/Delete pattern) — delete
      already goes through the admNotify.confirm() modal from the
      alert()-replacement pass.
      ========================================================================== */
   function decorate($) {
      var $empty = $('#CityTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>' +
            '<b>No locations yet</b><span>Click "Add Location" to create the first one.</span></div>'
         );
      }
      $('#CityTable td:nth-child(4)').each(function () {
         var $td = $(this);
         if ($td.data('adm') || !$td.text().trim()) { return; }
         $td.data('adm', 1);
         var isYes = $td.text().trim() === 'Yes';
         $td.html('<span class="adm-chip adm-chip--' + (isYes ? 'green' : 'ink') + '">' + $td.text().trim() + '</span>');
      });
   }

   function init($) {
      var table = $('#CityTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admCityCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#CityTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admCitySearch').on('input', function () {
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
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#CityTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
