@extends('admin.layout.index')
@section('title')
{{__("message.Package")}}
@stop
@section('content')
<div class="page-header">
	<h3 class="page-title">{{__("message.Package")}} </h3>
	<nav aria-label="breadcrumb">	      		
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Package")}}</li>
       </ol>
     </nav>	      	
</div>
<div class="row">
	<div class="col-lg-12 grid-margin stretch-card">
       <div class="card">                	
         <div class="card-body">
         	 @if(Session::has('message'))
            <div class="col-sm-12">
               <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
            </div>
            @endif
           
            <div class="row">
                <div class="col-3">
                    <a href="{{ route('save-package', ['id' => '0','tab'=>'1']) }}" class="btn btn-primary" style="margin-bottom: 25px;">{{__("message.Add Package")}}</a>
               </div>
               <div class="col-3">
                    <a href="{{ route('export_master_data', ['type' => 'package']) }}" class="btn btn-warning">Export all Package to Excel</a>
                </div>
               <div class="col-3">
                   <a  class="btn btn-success" rel="tooltip"  data-bs-toggle="modal" data-bs-target="#centerprices">Export Center Prices to Excel</a></div>
                <div class="col-3">
                    <a  class="btn btn-info" rel="tooltip"  data-bs-toggle="modal" data-bs-target="#centerpricesimp">Import Center Prices to Excel</a>
                </div>
            </div>  
            <div class="table-responsive">
                 <table id="PackageTable" class="table table-bordered text-nowrap dataTable no-footer">
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
                   	<tfoot>
                        <tr>
                           <th>{{__("message.ID")}}</th>
                           <th>{{__("message.Name")}}</th>
                           <th>MRP-PRICE</th>
                            <th>Recommended For</th>
                            <th>Status</th>
                           <th>{{__("message.Action")}}</th>
                        </tr>
                     </tfoot>
                 </table>
              </div>
         </div>
       </div>
     </div>
</div>
<!-- Package Details Modal -->
<div class="modal fade" id="packageDetailsModal" tabindex="-1" aria-labelledby="packageDetailsModalLabel" aria-hidden="true">
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
<!-- export price center list-->
<div class="modal fade" id="centerprices" tabindex="-1" aria-labelledby="centerpricesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Center prices</h5>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form action="{{ url('export_multiple_center_prices') }}" method="POST"class="pt-5" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="form-group col-12 mb-2">
                            <input type="checkbox" id="checkAll"> <strong>Select All Centers</strong>
                        </div>
                        @foreach($branch as $row)
                        <div class="form-group col-4">
                        <input type="hidden" name="test_type" value="package" />
                         
                        <input type="checkbox" class="center-checkbox" name="center[]" value="{{ $row->id }}"> {{ $row->name }} - {{ $row->company_name }}
                        
                       </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary mt-4">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- export price center list-->
<!-- Modal -->
<div class="modal fade" id="centerpricesimp" tabindex="-1" aria-labelledby="centerpricesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Center Prices</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ url('import_multiple_center_prices') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="test_type" value="package" />
                    <div id="center-price-rows">
                        <div class="row center-price-row">
                            <div class="form-group col-5">
                                <select name="center[]" class="form-control" required>
                                    <option value="">--select center--</option>
                                    @foreach($branch as $row)
                                        <option value="{{ $row->id }}">{{ $row->name }} - {{ $row->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-5">
                                <input type="file" name="excel_file[]" class="form-control" accept=".xlsx,.xls" required>
                            </div>

                            <div class="form-group col-2 d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm remove-row" style="display:none;">Remove</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <button type="button" id="add-row" class="btn btn-secondary btn-sm">Add Row</button>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 when modal is opened
        $('#centerpricesimp').on('shown.bs.modal', function () {
            $('select[name="center[]"]').select2({
                dropdownParent: $('#centerpricesimp')
            });
        });

        // Add new row
        $('#add-row').click(function() {
            let newRow = $('.center-price-row:first').clone();
            newRow.find('input').val('');
            newRow.find('select').val('').trigger('change'); // Reset and trigger change
            newRow.find('.remove-row').show();

            // Remove old Select2 container before reinitializing
            newRow.find('select').next('.select2').remove();

            $('#center-price-rows').append(newRow);

            // Re-initialize Select2 on new select
            newRow.find('select').select2({
                dropdownParent: $('#centerpricesimp'),
                width: '100%'
            });
        });

        // Remove row
        $(document).on('click', '.remove-row', function() {
            $(this).closest('.center-price-row').remove();
        });

    
    });
    $(document).ready(function() {
        $('#checkAll').change(function() {
            $('.center-checkbox').prop('checked', $(this).prop('checked'));
        });

        // Optional: update "check all" if any checkbox is manually unchecked
        $('.center-checkbox').change(function() {
            if ($('.center-checkbox:checked').length === $('.center-checkbox').length) {
                $('#checkAll').prop('checked', true);
            } else {
                $('#checkAll').prop('checked', false);
            }
        });
    });
</script>

@endsection