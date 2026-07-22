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
   <a href="{{url('savecategory/0')}}" class="btn btn-primary adm-btn-primary">
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
         <input type="text" id="admCategorySearch" placeholder="Search category name…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admCategoryCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="CategoryTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:8%">
            <col style="width:34%">
            <col style="width:22%">
            <col style="width:22%">
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
      Redesign notes: markup/classes only. #CategoryTable's ajax URL/columns
      are initialised by public/admin.js exactly as before (now also with
      autoWidth:false). Genuine fix made in
      CategoryController::categorydatatable(): the action column computed
      an $edit URL pointing at the wrong route name ("savecategory" via
      url('savecategory', ['id'=>...]) — this one actually resolves
      correctly since url() appends by position not name, but was left
      unused/dead in the original, matching the exact pattern already
      found and fixed on the Offer module) — only Delete was ever rendered
      even though the save-category create/edit page fully works. Edit is
      now wired up the same way as every other module. This standalone
      Category module (separate from Subcategory, which the sidebar's
      "Category" link actually opens) still has no sidebar entry of its
      own — left that reachability question untouched, only the UI/bugs
      here were in scope for this pass.
      ========================================================================== */
   function decorate($) {
      var $empty = $('#CategoryTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.1-3.1a2 2 0 0 0-2.8 0L6 21"/></svg>' +
            '<b>No categories yet</b><span>Click "Add Category" to create the first one.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#CategoryTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admCategoryCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#CategoryTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admCategorySearch').on('input', function () {
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
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#CategoryTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
