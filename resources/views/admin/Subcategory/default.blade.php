@extends('admin.layout.index')
@section('title')
{{__("message.Category")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.Category")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.Category")}}</li>
         </ol>
      </nav>
   </div>
   <a href="{{url('savesubcategory/0')}}" class="btn btn-success adm-btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
      {{__("message.Add Category")}}
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

{{-- ============ Category card: toolbar + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admSubcategorySearch" placeholder="Search name…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admSubcategoryCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="SubcategoryTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:10%">
            <col style="width:36%">
            <col style="width:24%">
            <col style="width:30%">
         </colgroup>
         <thead>
            <tr>
               <th>{{__("message.ID")}}</th>
               <th>{{__("message.Name")}}</th>
               <th>{{__("message.Image")}}</th>
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
      Redesign notes: markup/classes only, same pattern as the previous
      modules. #SubcategoryTable's ajax URL/columns are initialised by
      public/admin.js exactly as before (now also with autoWidth:false).
      The image cell's <img> render (admin.js) and the Edit/Delete action
      buttons (SubcategoryController::subcategorydatatable) are unchanged in
      behavior — only their generated markup/classes were updated (SVG icons,
      .adm-act button skin) to match the design system, plus two genuine
      backend fixes: a null-image URL that produced a broken <img src> for
      any subcategory with no image (defensive — no existing row currently
      hits this, since the create form requires an image), and the delete
      confirmation (delete_record()) already uses the new admNotify modal
      from the earlier alert()-replacement pass.
      ========================================================================== */
   function decorate($) {
      var $empty = $('#SubcategoryTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>' +
            '<b>No categories yet</b><span>Click "Add Category" to create the first one.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#SubcategoryTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admSubcategoryCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#SubcategoryTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admSubcategorySearch').on('input', function () {
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
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#SubcategoryTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
