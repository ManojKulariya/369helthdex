@extends('admin.layout.index')
@section('title')
{{__("message.Manager")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">SampleBoy</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">SampleBoy</li>
         </ol>
      </nav>
   </div>
   <a href="{{url('save_cc_boy/0')}}" class="btn btn-success adm-btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
      Add Sample Boy
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

{{-- ============ SampleBoy card: toolbar + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admSampleSearch" placeholder="Search name, phone…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admSampleCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="sampleTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:8%">
            <col style="width:28%">
            <col style="width:20%">
            <col style="width:20%">
            <col style="width:24%">
         </colgroup>
         <thead>
            <tr>
               <th>{{__("message.ID")}}</th>
               <th>{{__("message.Name")}}</th>
               <th>{{__("message.Phone")}}</th>
               <th>Branch</th>
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
      Redesign notes: markup/classes only. #sampleTable's ajax URL/columns
      are initialised by public/admin.js exactly as before (now also with
      autoWidth:false). Edit/Delete buttons restyled server-side in
      UserController::show_sampleTable().
      ========================================================================== */
   function decorate($) {
      var $empty = $('#sampleTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>' +
            '<b>No sample boys yet</b><span>Click "Add Sample Boy" to create the first one.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#sampleTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admSampleCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#sampleTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admSampleSearch').on('input', function () {
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
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#sampleTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
