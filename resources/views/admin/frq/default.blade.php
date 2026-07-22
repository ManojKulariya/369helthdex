@extends('admin.layout.index')
@section('title')
{{__("message.FRQ")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.FRQ")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.FRQ")}}</li>
         </ol>
      </nav>
   </div>
   <button type="button" class="btn btn-primary adm-btn-primary" data-bs-toggle="modal" data-bs-target="#normalmodal">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
      {{__("message.Add FRQ")}}
   </button>
</div>

<input type="hidden" name="package_id" id="package_id" value="{{$id}}">
<input type="hidden" name="type" id="type" value="{{$type}}">

@if(Session::has('message'))
<div class="adm-toast-wrap">
   <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show adm-toast" role="alert">{{ Session::get('message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>
</div>
@endif

{{-- ============ FRQ card: table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admFrqSearch" placeholder="Search question…" autocomplete="off">
      </div>
      <span class="adm-ot-count" id="admFrqCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div>
      </div>
      <table id="FRQTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:8%">
            <col style="width:36%">
            <col style="width:36%">
            <col style="width:20%">
         </colgroup>
         <thead>
            <tr>
               <th>{{__("message.ID")}}</th>
               <th>{{__("message.Question")}}</th>
               <th>{{__("message.Answer")}}</th>
               <th>{{__("message.Action")}}</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>

{{-- ============ Add FRQ modal ============ --}}
<div class="modal fade adm-modal" id="normalmodal" tabindex="-1" aria-labelledby="normalmodal" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">
               <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg></span>
               {{__("message.Add FRQ")}}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
         </div>
         <form action="{{route('update-frq')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="package_id" value="{{$id}}">
            <input type="hidden" name="type" value="{{$type}}">
            <input type="hidden" name="id" value="0">
            <div class="modal-body">
               <div class="row">
                  <div class="col-12 adm-field">
                     <label for="question">{{__("message.Question")}}</label>
                     <textarea class="form-control" name="question" id="question" required="" placeholder="{{__('message.Enter Question')}}"></textarea>
                  </div>
                  <div class="col-12 adm-form-actions">
                     <label for="answer">{{__("message.Answer")}}</label>
                     <textarea class="form-control" name="answer" id="answer" required="" placeholder="{{__('message.Enter Answer')}}"></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn-secondary" data-bs-dismiss="modal">{{__('message.Close')}}</button>
               @if(Session::get("is_demo")==1)
               <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">{{__('message.Save')}}</button>
               @else
               <button type="submit" class="btn btn-success adm-btn-primary">{{__('message.Save')}}</button>
               @endif
            </div>
         </form>
      </div>
   </div>
</div>

{{-- ============ Edit FRQ modal ============ --}}
<div class="modal fade adm-modal" id="editfrq" tabindex="-1" aria-labelledby="editfrq" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">
               <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg></span>
               {{__('message.Edit FRQ')}}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
         </div>
         <form action="{{route('update-frq')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="package_id" value="{{$id}}">
            <input type="hidden" name="type" value="{{$type}}">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-body">
               <div class="row">
                  <div class="col-12 adm-field">
                     <label for="edit_question">{{__("message.Question")}}</label>
                     <textarea class="form-control" name="question" id="edit_question" required="" placeholder="{{__('message.Enter Question')}}"></textarea>
                  </div>
                  <div class="col-12 adm-form-actions">
                     <label for="edit_answer">{{__("message.Answer")}}</label>
                     <textarea class="form-control" name="answer" id="edit_answer" required="" placeholder="{{__('message.Enter Answer')}}"></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn-secondary" data-bs-dismiss="modal">{{__('message.Close')}}</button>
               @if(Session::get("is_demo")==1)
               <button type="button" class="btn btn-success adm-btn-primary" onclick="disablebtn()">{{__('message.Save')}}</button>
               @else
               <button type="submit" class="btn btn-success adm-btn-primary">{{__('message.Save')}}</button>
               @endif
            </div>
         </form>
      </div>
   </div>
</div>

<script>
   /* ==========================================================================
      Redesign notes: markup/classes only. #FRQTable's ajax URL/columns are
      initialised by public/admin.js exactly as before (now also with
      autoWidth:false). Edit/Delete already both worked in the original
      action column — only restyled. edit_frq()/getfrq AJAX flow (populates
      the Edit modal) is unchanged.
      ========================================================================== */
   function decorate($) {
      var $empty = $('#FRQTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>' +
            '<b>No FRQs yet</b><span>Click "Add FRQ" to create the first one.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#FRQTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admFrqCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#FRQTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admFrqSearch').on('input', function () {
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
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#FRQTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
