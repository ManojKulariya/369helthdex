@extends('admin.layout.index')
@section('title')
{{__("message.User")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.User")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.User")}}</li>
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

{{-- ============ Site Users card: toolbar + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admUserSearch" placeholder="Search name, email…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admUserCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="UserTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:6%">
            <col style="width:10%">
            <col style="width:20%">
            <col style="width:22%">
            <col style="width:14%">
            <col style="width:14%">
            <col style="width:14%">
         </colgroup>
         <thead>
            <tr>
               <th>{{__("message.ID")}}</th>
               <th>{{__("message.Image")}}</th>
               <th>{{__("message.Name")}}</th>
               <th>{{__("message.email")}}</th>
               <th>{{__("message.Member")}}</th>
               <th>{{__("message.Address")}}</th>
               <th>{{__("message.Action")}}</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>

{{-- ============ Family Members modal (populated by the existing view_member() AJAX call in admin.js — only the wrapper markup is restyled) ============ --}}
<div class="modal fade adm-modal" id="normalmodal" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">{{__("message.Family Members Detail")}}</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="adm-table-wrap">
               <table class="table adm-orders-table no-footer" id="itemdata">
                  <tbody>
                     <tr>
                        <th>#</th>
                        <th>{{__("message.Name")}}</th>
                        <th>{{__("message.Phone")}}</th>
                        <th>{{__("message.Age")}}</th>
                        <th>{{__("message.DOB")}}</th>
                        <th>{{__("message.Relation")}}</th>
                        <th>{{__("message.Gender")}}</th>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>

{{-- ============ Address modal (populated by the existing view_address() AJAX call in admin.js — only the wrapper markup is restyled) ============ --}}
<div class="modal fade adm-modal" id="addressmodal" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">{{__("message.Address")}}</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="adm-table-wrap">
               <table class="table adm-orders-table no-footer" id="addressdata">
                  <tbody>
                     <tr>
                        <th>#</th>
                        <th>{{__("message.Address")}}</th>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   /* ==========================================================================
      Redesign notes: markup/classes only. #UserTable's ajax URL/columns are
      initialised by public/admin.js exactly as before (now also with
      autoWidth:false). The Members/Address/Delete buttons and the
      view_member()/view_address() AJAX handlers that populate #itemdata/
      #addressdata are unchanged — only their generated markup/classes were
      restyled (.adm-act instead of the old blue btn-info).
      ========================================================================== */
   function decorate($) {
      var $empty = $('#UserTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>' +
            '<b>No users yet</b><span>Customers who register on the site will show up here.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#UserTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admUserCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#UserTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admUserSearch').on('input', function () {
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
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#UserTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
