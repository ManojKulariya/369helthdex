@extends('admin.layout.index')
@section('title')
{{__("message.Contact Us")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.Contact Us")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.Contact Us")}}</li>
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

{{-- ============ Contact Us card: toolbar + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admContactSearch" placeholder="Search name, email, subject…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admContactCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="ContactTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:5%">
            <col style="width:14%">
            <col style="width:17%">
            <col style="width:11%">
            <col style="width:15%">
            <col style="width:24%">
            <col style="width:14%">
         </colgroup>
         <thead>
            <tr>
               <th>{{__("message.ID")}}</th>
               <th>{{__("message.Name")}}</th>
               <th>{{__("message.email")}}</th>
               <th>{{__("message.Phone")}}</th>
               <th>{{__("message.Subject")}}</th>
               <th>{{__("message.Message")}}</th>
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
      Redesign notes: markup/classes only. #ContactTable's ajax URL/columns
      are initialised by public/admin.js exactly as before (now also with
      autoWidth:false). The "reply by email" and Delete actions are restyled
      server-side in AdminController::contact_datatable() — a genuine bug
      was also fixed there: the Gmail-compose link concatenated the contact's
      raw subject/message into the URL unencoded, breaking for any message
      containing "&", "#", "%", or a newline (all common in free-text
      submissions) — now urlencode()'d.
      ========================================================================== */
   function decorate($) {
      var $empty = $('#ContactTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22 6 12 13 2 6"/></svg>' +
            '<b>No messages yet</b><span>Messages submitted through the Contact Us form will show up here.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#ContactTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admContactCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#ContactTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admContactSearch').on('input', function () {
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
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#ContactTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
