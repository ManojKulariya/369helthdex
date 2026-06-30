@extends('admin.layout.index')
@section('title')
'Branch Tests' 
@stop
@section('content')


<div class="page-header">
	<h3 class="page-title" >{{ $data['user']->name }} -  {{ $data['user']->company_name}}</h3>
	<nav aria-label="breadcrumb">	      		
       <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.User")}}</li>
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

            <div class="table-responsive">
                <form>
                 <table  class="table table-bordered text-nowrap dataTable no-footer">
                   	<thead>
                     <tr>
                        <th>
                            <input type="checkbox" id="check-all" onclick="toggleCheckboxes(this)">
                            <label for="check-all">Check All</label>
                        </th>
                        <th>{{__("message.ID")}}</th>
                        <th>Test name</th>
                        <th>Parameters</th>
                        
                     </tr>
                     @foreach($data['test'] as $index =>$row)
                        <tr>
                            <td><input type="checkbox" name="checkbox[]" value="{{ $row->id }}"></td>
                            <td>{{++$index}}</td>
                            <td>{{$row->profile_name}}</td>
                            <td>{{$row->paramater_data}}</td>
                        </tr>
                     @endforeach
                   	</thead>
                   	<tbody>                        
                   	</tbody>
                  
                 </table>
                 </form>
              </div>
         </div>
       </div>
     </div>
</div>
  
  
  <div class="modal fade" id="normalmodal" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content" style="width:110%; overflow: scroll;">
                  <div class="modal-header">
                     <h5 class="modal-title" id="normalmodal1">{{__("message.Family Members Detail")}}</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div>
                        <div class="container"style="margin-top: 13px;margin-bottom: 5px; ">
                          <h5 class="orderh">{{__("message.Family Members")}}</h5>
                        </div>
                        <table class="table" id="itemdata">
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

  <div class="modal fade" id="addressmodal" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
               <div class="modal-content" style="overflow: scroll;">
                  <div class="modal-header">
                     <h5 class="modal-title" id="normalmodal1">{{__("message.Address")}}</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div>
                        <div class="container"style="margin-top: 13px;margin-bottom: 5px; ">
                          <h5 class="orderh">{{__("message.User Address")}}</h5>
                        </div>
                        <table class="table" id="addressdata">
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function toggleCheckboxes(source) {
        var checkboxes = document.getElementsByName('checkbox[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
<script>
    $(document).ready(function () {
        
        // Handle checkbox change event
        $('input[name="checkbox[]"]').change(function () {
            var isChecked = $(this).is(':checked');
            var itemId = $(this).val();
           var userID = <?php echo json_encode($data['user']->id); ?>;

            console.log(itemId);

            if (isChecked) {
                // AJAX call to add item to the database
                $.ajax({
                    url: '/add-item',
                    method: 'POST',
                    data: {
                        item_id: itemId,
                        userID:userID,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        // Handle success response
                        console.log(response);
                    },
                    error: function (xhr, status, error) {
                        // Handle error response
                        console.log(xhr.responseText);
                    }
                });
            } else {
                // AJAX call to remove item from the database
                $.ajax({
                    url: '/remove-item',
                    method: 'POST',
                    data: {
                        item_id: itemId,
                        userID:userID,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        // Handle success response
                        console.log(response);
                    },
                    error: function (xhr, status, error) {
                        // Handle error response
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
</script>


<script>
    $(document).ready(function () {
        // Handle "Check All" checkbox click event
        $('#check-all').change(function () {
            var isChecked = $(this).is(':checked');
            var userID = <?php echo json_encode($data['user']->id); ?>;
            
            if (isChecked) {
                var status = 1;
                var selectedItems = $('input[name="checkbox[]"]:checked').map(function () {
                    return $(this).val();
                }).get();
                
                
            } else {
                
                var status = 0;
                var selectedItems=[];
            }
            
            
            $.ajax({
                url: '/update-items',
                method: 'POST',
                data: {
                    selected_items: selectedItems,
                    userID:userID,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    // Handle success response
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.log(xhr.responseText);
                }
            });

           
           
        });

    });
</script>
@endsection

