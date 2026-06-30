@extends('manager.layout.index')
@section('title')
{{__("message.Orders List")}}
@stop
@section('content')
<div class="page-header">
   <h3 class="page-title">{{__("message.Orders List")}}</h3>
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{route('manager-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">{{__("message.Orders List")}}</li>
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
               <table  class="table table-bordered text-nowrap dataTable no-footer">
                     @php
                     $trashedItems = []; // Initialize an empty array to store trashed IDs
                     $bookedItems = [];
                     @endphp
                     <tr>
                        <th>Order Id</th> 
                        <th>Test Name</th>
                        <th>Member</th>
                        <th>{{__("message.Test Type")}}</th>
                        <th>{{__("message.Parameter")}}</th>
                        <th>{{__("message.MRP")}}</th>
                        <th>{{__("message.Price")}}</th>
                        <th>{{__("message.Action")}}</th>
                     </tr>

                     @foreach($data as $row)
                     <tr>
                        <td>{{ $row['id'] }}</td>
                        <td>{{ $row['test_name'] }}</td>
                        <td>{{ $row['member_name'] }} <br>{{ $row['relation'] }} </td>
                        <td>
                           @if($row['type'] ==1 )
                              Package
                           @elseif($row['type'] ==2)
                              Parameter
                           @else
                              Profile
                           @endif
                        </td>
                        <td>{{ $row['parameter'] }}</td>
                        <td>{{ $row['mrp'] }}</td>
                        <td>{{ $row['price'] }} </td>
                        <td>
                        <span>
                           <a style="color: red;"  onclick="toggleIcon(this, {{ $row['id'] }}, {{ $row['type'] }}, {{ $row['item_id'] }})">
                                 <i class="fa fa-trash"></i>
                           </a>
                        </span>
                        </td>
                     </tr>
                     @endforeach
                  
                  
               </table>
            </div>
            
         </div>
      </div>
   </div>
   <form action="{{ route('sampleboy_check_out')}}" method="post">
      @csrf
 <input name="trsh" type="hidden" id="trs">
 <input name="book" type="hidden" id="book">
 <input name="order_id" type="hidden" value="{{ $order_id}}">
 <input type="submit" class="btn btn-success"  value="Check Out" data-original-title="banner">

</form>

</div>

<div class="page-header">
   <h3 class="page-title">Other Test List</h3>
</div>
<div class="row">
   <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
         <div class="card-body">
           
            <div class="table-responsive">
               <table id="OrderschangeTable" class="table table-bordered text-nowrap dataTable no-footer">
                  <thead>
                     <tr>
                        <th>{{__("message.Id")}}</th>
                        <th>{{__("message.Name")}}</th>
                        <th>{{__("message.Type")}}</th>
                        <th>{{__("message.MRP")}}</th>
                        <th>{{__("message.Price")}}</th>
                        <th>{{__("message.Parameters")}}</th>
                        <th>{{__("message.Action")}}</th>
                     </tr>
                  </thead>
                  <tbody>                        
                  </tbody>
                  <tfoot>
                     
                        <th>{{__("message.Id")}}</th>
                        <th>{{__("message.Name")}}</th>
                        <th>{{__("message.Type")}}</th>
                        <th>{{__("message.MRP")}}</th>
                        <th>{{__("message.Price")}}</th>
                        <th>{{__("message.Parameters")}}</th>
                        <th>{{__("message.Action")}}</th>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Add this modal HTML structure to your page -->
<div class="modal fade" id="familyModal" tabindex="-1" role="dialog" aria-labelledby="familyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="familyModalLabel">Select Family Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="familyForm">
                    <div class="form-group">
                        <label for="familyMember">Choose a Family Member:</label>
                        <select class="form-control" id="familyMember" name="familyMember">
                            @foreach ($faimly as $member)
                                <option value="{{ $member->id }}">{{ $member->name }} - {{ $member->relation }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="confirmBooking()">Confirm</button>
                    <button type="button" class="btn btn-primary" onclick="openModal()">{{__("message.Add New Family Member")}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{__("message.Add New Family Member")}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form with input fields -->
                  <form action="{{route('update-user-family-boy')}}" method="post" class="registration-form">
                    @csrf
                    
                        <input type="hidden" class="form-control"  name="user_id" value="{{$user_id}}">
                    <div class="form-group">
                        <label>{{__("message.Relation")}}</label>
                     <select  name="relation" class="form-control" required="">
                        <option value="">{{__("message.Select Relation")}}</option>
                        <option value="Self">{{__("message.Self")}}</option>
                        <option value="Spouse">{{__("message.Spouse")}}</option>
                        <option value="Child">{{__("message.Child")}}</option>
                        <option value="Parent">{{__("message.Parent")}}</option>
                        <option value="Grand Parent">{{__("message.Grand Parent")}}</option>
                        <option value="Sibling">{{__("message.Sibling")}}</option>
                        <option value="Friend">{{__("message.Friend")}}</option>
                        <option value="Relative">{{__("message.Relative")}}</option>
                        <option value="Neighbour">{{__("message.Neighbour")}}</option>
                        <option value="Colleague">{{__("message.Colleague")}}</option>
                        <option value="Others">{{__("message.Others")}}</option>
                     </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control"  name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="tel" class="form-control" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age:</label>
                        <input type="number" class="form-control" name="age" required>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" class="form-control" name="dob" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select class="form-control" name="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
               
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" >Save</button>
            </div>
 </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Popper.js and jQuery are required) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Function to open the modal
    function openModal() {
        $('#myModal').modal('show');
    }

    // Function to save data (you can customize this)
    function saveData() {
        // Add your logic to save data here
        // For example, you can collect values from input fields
        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var age = $('#age').val();
        var dob = $('#dob').val();
        var gender = $('#gender').val();

        // Add your logic to save or process the data as needed
        console.log("Data saved:", name, email, phone, age, dob, gender);

        // Close the modal after saving data
        $('#myModal').modal('hide');
    }
</script>

<script>
    var bookedItems = @json($bookedItems);

    function togglebook(element, item_id, type, parameter) {
        // Store the details of the clicked button temporarily
        var tempBooking = { item_id: item_id, type: type, parameter: parameter };

        // Open the family member selection modal
        $('#familyModal').modal('show');

        // Set a click event for the modal confirm button
        window.confirmBooking = function () {
            // Get the selected family member
            var selectedFamilyMember = $('#familyMember').val();

            // Update the tempBooking with the family member
            tempBooking.familyMember = selectedFamilyMember;

            // Add the updated tempBooking to bookedItems array
            bookedItems.push(tempBooking);

            // Update the button appearance
            updateButton(element);

            // Hide the modal
            $('#familyModal').modal('hide');

            // Update the hidden input field with bookedItems
            console.log('Booked Items:', bookedItems);
            $('#book').val(JSON.stringify(bookedItems));
        };
    }

    function updateButton(button) {
        if (button.classList.contains('booked')) {
            button.classList.remove('booked');
            button.classList.remove('btn-primary');
            button.innerText = 'BOOK NOW';
        } else {
            button.classList.add('booked');
            button.classList.add('btn-primary');
            button.innerText = 'BOOKED';
        }
    }
</script>

<script>
    var trashedItems = @json($trashedItems); // Convert the PHP array to a JavaScript array

    function toggleIcon(element, id, type, item_id) {
        var icon = element.querySelector('i');
        if (icon.classList.contains('fa-trash')) {
            icon.classList.remove('fa-trash');
            icon.classList.add('fa-minus');
            // Add the ID, type, and item_id to the array as an object
            trashedItems.push({ id: id, type: type, item_id: item_id });
        } else {
            icon.classList.remove('fa-minus');
            icon.classList.add('fa-trash');
            // Remove the item from the array based on id, type, and item_id
            trashedItems = trashedItems.filter(item => item.id != id || item.type != type || item.item_id != item_id);
        }
        console.log('Trashed Items:', trashedItems); // Log the array of trashed items
        $('#trs').val(JSON.stringify(trashedItems));

        // You can send the trashedItems array to the server via an AJAX request here.
        // For example, you can use the fetch API or jQuery AJAX to send the data to the server.
    }
</script>

@endsection