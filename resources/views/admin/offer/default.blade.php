@extends('admin.layout.index')
@section('title')
Offer
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">Offer</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">Offer</li>
         </ol>
      </nav>
   </div>
   <a href="{{url('saveoffer/0')}}" class="btn btn-primary adm-btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
      Add Offer
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

{{-- ============ Offer card: toolbar + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admOfferSearch" placeholder="Search offer name…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admOfferCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="OfferTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:6%">
            <col style="width:22%">
            <col style="width:14%">
            <col style="width:14%">
            <col style="width:22%">
            <col style="width:22%">
         </colgroup>
         <thead>
            <tr>
               <th>{{__("message.ID")}}</th>
               <th>{{__("message.Name")}}</th>
               <th>{{__("message.Image")}}</th>
               <th>Type</th>
               <th>Test</th>
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
      Redesign notes: markup/classes only. #OfferTable's ajax URL/columns are
      initialised by public/admin.js exactly as before (now also with
      autoWidth:false). Genuine fixes made in
      CategoryController::offerdatatable(): the action column computed an
      $edit URL (pointed at the wrong route name too — "savecategory"
      instead of "saveoffer") but never actually used it — only Delete was
      ever rendered, even though the save-offer create/edit page fully
      works. Edit is now wired up the same way as every other module. Also
      fixed the page title/breadcrumb, which read "Category" (copy-pasted
      from the separate Category module) instead of "Offer".
      ========================================================================== */
   function decorate($) {
      var $empty = $('#OfferTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.25L3 3a1 1 0 0 0-1 1l.25 6.59a2 2 0 0 0 .58 1.42l9.59 9.59a2 2 0 0 0 2.82 0l5.35-5.35a2 2 0 0 0 0-2.83Z"/><circle cx="7.5" cy="7.5" r="1.5"/></svg>' +
            '<b>No offers yet</b><span>Click "Add Offer" to create the first one.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#OfferTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admOfferCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#OfferTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admOfferSearch').on('input', function () {
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
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#OfferTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
