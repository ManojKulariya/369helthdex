@extends('admin.layout.index')
@section('title')
{{__("message.Package")}}
@stop
@section('content')

{{-- ============ Page header ============ --}}
<div class="page-header adm-orders-header">
   <div>
      <h3 class="page-title mb-0">{{__("message.Package")}}</h3>
      <nav aria-label="breadcrumb">
         <ol class="breadcrumb adm-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
            <li class="breadcrumb-item active">{{__("message.Package")}}</li>
         </ol>
      </nav>
   </div>
   <a href="{{ route('save-package', ['id' => '0','tab'=>'1']) }}" class="btn btn-primary adm-btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
      {{__("message.Add Package")}}
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

{{-- ============ Package card: toolbar (search + utility actions) + table ============ --}}
<div class="adm-orders-card">
   <div class="adm-orders-toolbar">
      <div class="adm-ot-search">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
         <input type="text" id="admPackageSearch" placeholder="Search name…" autocomplete="off">
      </div>
      <a href="{{ route('export_master_data', ['type' => 'package']) }}" class="adm-ot-btn">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
         Export All
      </a>
      <a class="adm-ot-btn" data-bs-toggle="modal" data-bs-target="#centerprices">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
         Export Center Prices
      </a>
      <a class="adm-ot-btn" data-bs-toggle="modal" data-bs-target="#centerpricesimp">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
         Import Center Prices
      </a>
      <span class="adm-ot-count" id="admPackageCount"></span>
   </div>

   <div class="adm-table-wrap">
      <div class="adm-orders-skeleton" aria-hidden="true">
         <div></div><div></div><div></div><div></div><div></div><div></div>
      </div>
      <table id="PackageTable" class="table adm-orders-table dataTable no-footer">
         <colgroup>
            <col style="width:6%">
            <col style="width:30%">
            <col style="width:14%">
            <col style="width:16%">
            <col style="width:10%">
            <col style="width:24%">
         </colgroup>
         <thead>
            <tr>
               <th>{{__("message.ID")}}</th>
               <th>{{__("message.Name")}}</th>
               <th>MRP-PRICE</th>
               <th>Recommended For</th>
               <th>Status</th>
               <th>{{__("message.Action")}}</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>
   </div>
</div>

{{-- ============ Package Details modal (shared showPackageDetails() from admin.js, already used and proven on the Create Booking page — only the wrapper markup is restyled here) ============ --}}
<div class="modal fade adm-modal" id="packageDetailsModal" tabindex="-1" aria-labelledby="packageDetailsModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="packageTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <ul id="parameterList"></ul>
         </div>
      </div>
   </div>
</div>

{{-- ============ Export Center Prices modal ============ --}}
<div class="modal fade adm-modal" id="centerprices" tabindex="-1" aria-labelledby="centerpricesModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">
               <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M8 12h8"/><path d="M12 8v8"/></svg></span>
               Center prices
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="{{ url('export_multiple_center_prices') }}" method="POST" enctype="multipart/form-data">
               @csrf
               <div class="row">
                  <div class="form-group col-12 mb-2 adm-field">
                     <label style="display:inline-flex;align-items:center;gap:.5rem;text-transform:none;">
                        <input type="checkbox" id="checkAll"> <strong>Select All Centers</strong>
                     </label>
                  </div>
                  <input type="hidden" name="test_type" value="package" />
                  @foreach($branch as $row)
                  <div class="form-group col-4 adm-field">
                     <label style="display:inline-flex;align-items:center;gap:.5rem;text-transform:none;font-weight:400;">
                        <input type="checkbox" class="center-checkbox" name="center[]" value="{{ $row->id }}"> {{ $row->name }} - {{ $row->company_name }}
                     </label>
                  </div>
                  @endforeach
               </div>
               <button type="submit" class="btn btn-primary adm-btn-primary mt-2">Submit</button>
            </form>
         </div>
      </div>
   </div>
</div>

{{-- ============ Import Center Prices modal ============ --}}
<div class="modal fade adm-modal" id="centerpricesimp" tabindex="-1" aria-labelledby="centerpricesModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">
               <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg></span>
               Import Center Prices
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
         </div>
         <div class="modal-body">
            <form action="{{ url('import_multiple_center_prices') }}" method="POST" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name="test_type" value="package" />
               <div id="center-price-rows">
                  <div class="row center-price-row">
                     <div class="form-group col-5 adm-field">
                        <select name="center[]" class="form-control" required>
                           <option value="">--select center--</option>
                           @foreach($branch as $row)
                           <option value="{{ $row->id }}">{{ $row->name }} - {{ $row->company_name }}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group col-5 adm-field">
                        <input type="file" name="excel_file[]" class="form-control" accept=".xlsx,.xls" required>
                     </div>
                     <div class="form-group col-2 d-flex align-items-center">
                        <button type="button" class="btn btn-danger btn-sm remove-row" style="display:none;">Remove</button>
                     </div>
                  </div>
               </div>
               <div class="form-group mt-3">
                  <button type="button" id="add-row" class="btn-secondary">Add Row</button>
                  <button type="submit" class="btn btn-primary adm-btn-primary btn-sm">Submit</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   /* ==========================================================================
      Redesign notes: markup/classes only, same pattern as Parameter/Profile.
      #PackageTable's ajax URL/columns are initialised by public/admin.js
      exactly as before (now also with autoWidth:false). The name column's
      "view parameter" and "copy" icons were swapped from Font Awesome to
      inline SVG (still calling the same shared showPackageDetails() already
      proven on the Create Booking page). Status/Edit/Delete/FRQ buttons use
      the same .adm-act skin as every other module.
      ========================================================================== */
   function decorate($) {
      var $empty = $('#PackageTable td.dataTables_empty');
      if ($empty.length && !$empty.data('adm')) {
         $empty.data('adm', 1).html(
            '<div class="adm-empty">' +
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>' +
            '<b>No packages yet</b><span>Click "Add Package" to create the first one.</span></div>'
         );
      }
   }

   function init($) {
      var table = $('#PackageTable').DataTable();
      var $skeleton = $('.adm-orders-skeleton');

      table.on('draw.dt', function () {
         $skeleton.remove();
         decorate($);
      });
      table.on('xhr.dt', function (e, settings, json) {
         if (json && typeof json.recordsFiltered !== 'undefined') {
            $('#admPackageCount').text(json.recordsFiltered + ' result' + (json.recordsFiltered === 1 ? '' : 's'));
         }
      });
      if ($('#PackageTable tbody tr').length) {
         $skeleton.remove();
         decorate($);
      }

      var deb;
      $('#admPackageSearch').on('input', function () {
         var v = this.value;
         clearTimeout(deb);
         deb = setTimeout(function () { table.search(v).draw(); }, 300);
      });

      setTimeout(function () { $('.adm-toast').fadeOut(400); }, 4500);

      $('#checkAll').on('change', function () {
         $('.center-checkbox').prop('checked', $(this).prop('checked'));
      });
      $(document).on('change', '.center-checkbox', function () {
         $('#checkAll').prop('checked', $('.center-checkbox:checked').length === $('.center-checkbox').length);
      });

      $('#centerpricesimp').on('shown.bs.modal', function () {
         $('select[name="center[]"]').select2({ dropdownParent: $('#centerpricesimp') });
      });
      $('#add-row').on('click', function () {
         var newRow = $('.center-price-row:first').clone();
         newRow.find('input').val('');
         newRow.find('select').val('').trigger('change');
         newRow.find('.remove-row').show();
         newRow.find('select').next('.select2').remove();
         $('#center-price-rows').append(newRow);
         newRow.find('select').select2({ dropdownParent: $('#centerpricesimp'), width: '100%' });
      });
      $(document).on('click', '.remove-row', function () {
         $(this).closest('.center-price-row').remove();
      });
   }

   window.addEventListener('load', function () {
      var tries = 0;
      (function hook() {
         var jq = window.jQuery;
         if (jq && jq.fn && jq.fn.dataTable && jq.fn.dataTable.isDataTable('#PackageTable')) { init(jq); return; }
         if (++tries > 100) { return; }
         setTimeout(hook, 50);
      })();
   });
</script>
@endsection
