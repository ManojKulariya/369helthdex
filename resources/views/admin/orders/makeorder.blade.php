@extends('admin.layout.index')
@section('title')
Make Order By Admin
@stop
@section('content')

<style>
    @media (min-width: 768px) {
        .modal-lg {
            max-width: 80%;
        }
    }
    .map #us2 {
        width: 100%;
        height: 200px;
    }

</style>
<div class="page-header">
	<h3 class="page-title">Make Order </h3>
	<div class="col-sm-6">
      @if(__("message.Is_rtl")=='1')
             <ol class="breadcrumb float-sm-left">
         @else
            <ol class="breadcrumb float-sm-right">
         @endif
         <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
         <li class="breadcrumb-item active">Order</li>
      </ol>
   </div>	      	
</div>
<div class="row" style="display: flex;justify-content: center;">
	<div class="col-12 grid-margin stretch-card">
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
                  
                  <div class="hidediv row" style="display:none;">
                      <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs" id="testTabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#packageTab"><small>Package</small></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#profileTab"><small>Profile</small></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#parameterTab"><small>Parameter</small></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- Package Table -->
                            <div id="packageTab" class="tab-pane fade show active">
                                <div class="card">
                                    <div class="card-body">
                                        <label for="name">Package</label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>{{__("message.Name")}}</th>
                                                        <th>{{__("message.MRP")}}</th>
                                                        <th>{{__("message.Action")}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @foreach($package as $packages)
                                                     <?php 
                                                        $p_data= json_encode($packages->paramater_data);
                                                        $reco = $packages->test_recommended_for.' '.$packages->test_recommended_for_age
                                                        ?>
                                                    <tr>
                                                        <td>{{$packages->name}} - ({{$packages->no_of_parameter}})  
                                                        <i class="fa fa-eye text-primary" style="cursor: pointer;"
                                                        onclick="showPackageDetails('Package',{{ $p_data }}, '{{$packages->name}}','{{$packages->sample_type}}','{{$packages->fasting_time}}','{{$reco}}','{{$packages->report_time}}')"></i>
                                                       
                                                        </td>
                                                        <td>{{$packages->price}}</td>
                                                        <td>
                                                            <a href="#" onclick="togglebook(this,{{$packages->id}},1,1,'{{$packages->name}}','Packages',{{$packages->price}})" class="btn btn-success">ADD TEST</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Profile Table -->
                            <div id="profileTab" class="tab-pane fade">
                                <div class="card">
                                    <div class="card-body">
                                        <label for="name">Profile</label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>{{__("message.Name")}}</th>
                                                        <th>{{__("message.MRP")}}</th>
                                                        <th>{{__("message.Action")}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($profiles as $profile)
                                                    <?php 
                                                        $p_data= json_encode($profile->paramater_data);
                                                        $reco = $profile->test_recommended_for.' '.$profile->test_recommended_for_age
                                                        ?>
                                                    <tr>
                                                        <td>{{$profile->profile_name}} - ({{$profile->no_of_parameter}})
                                                        
                                                        <i class="fa fa-eye text-primary" style="cursor: pointer;"
                                                        onclick="showPackageDetails('Profile',{{ $p_data }}, '{{$profile->profile_name}}','{{$profile->sample_type}}','{{$profile->fasting_time}}','{{$reco}}','{{$profile->report_time}}')"></i>
                                                       </td>
                                                        <td>{{$profile->price}}</td>
                                                        <td>
                                                            <a href="#" onclick="togglebook(this,{{$profile->id}},3,1,'{{$profile->profile_name}}','Profile',{{$profile->price}})" class="btn btn-success">ADD TEST</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Parameter Table -->
                            <div id="parameterTab" class="tab-pane fade">
                                <div class="card">
                                    <div class="card-body">
                                        <label for="name">Parameter</label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>{{__("message.Name")}}</th>
                                                        <th>{{__("message.MRP")}}</th>
                                                        <th>{{__("message.Action")}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($parameter as $parameters)
                                                    <tr>
                                                        <td>{{$parameters->name}}<br>
                                                            <small style="font-size: 12px; display: block; margin-top: 5px;">
                                                                <strong>Sample Type:</strong> {{$parameters->sample_type}}|| 
                                                                <strong>Fasting Time:</strong> {{$parameters->fast_time}} || 
                                                                <strong>Recommended For:</strong> {{$parameters->test_recommended_for}} {{$parameters->test_recommended_for_age}} ||
                                                                <strong>Report Time:</strong> {{$parameters->report_time}}
                                                            </small>
                                                        </td>
                                                        <td>{{$parameters->price}}</td>
                                                        <td>
                                                            <a href="#" onclick="togglebook(this,{{$parameters->id}},2,1,'{{$parameters->name}}','Parameters',{{$parameters->price}})" class="btn btn-success">ADD TEST</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12">
                          <div class="card">
                             <div class="card-body">
                                 <label for="name">Selected Test</label>
                                <div class="table-responsive">
                                   <table  id="selectedTestsTable" class="table table-bordered text-nowrap dataTable no-footer">
                                      <thead>
                                         <tr>
                                            <th>{{__("message.Name")}}</th>
                                            <th>{{__("message.Type")}}</th>
                                            <th>Test</th>
                                            <th>{{__("message.Member")}}</th>
                                            <th>{{__("message.Action")}}</th>
                                         </tr>
                                      </thead>
                                      <tbody> 
                                      </tbody>
                                   </table>
                                </div>
                             </div>
                          </div>
                      </div>
                      <div class="col-12" style="background-color:#f5f6f0;">
                            <form id="user_address_data">
                                    <div class="row ">
                                        <div class="col-12 form-group"  id="addressorder">
                                             <label>{{__('message.Address')}}<span class="reqfield">*</span></label>
                                             <input  type="text" id="autocomplete"  class="form-control"  name="address" placeholder='Search Location' />
                                          </div>
                                          <!-- Map Container -->
                                        <div class="col-12 form-group">
                                            <div id="map" style="width: 100%; height: 300px;"></div>
                                        </div>
                                        <?php
                                            $inputLatitude = env('MAP_LAT');
                                            $inputLongitude = env('MAP_LONG');
                                        ?>
                                        <input type="hidden" name="lat" id="us2-lat" value="{{$inputLatitude}}" />
                                        <input type="hidden" name="long" id="us2-lon" value="{{$inputLongitude}}" />
                                        <input type="hidden" name="state"  value="0" />
                                        <input type="hidden" name="city" value="0" />
                
                                        <div class="col-4 form-group">
                                            <label>Save As</label>
                                            <select name="name" class="form-control">
                                                <option>Home</option>
                                                <option>Work</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                        <div class="col-4 form-group">
                                            <label>{{__('message.Pincode')}}</label>
                                            <input type="text" name="pincode" id="pincode" class="form-control"
                                                placeholder="{{__('message.Enter Pincode')}}" required>
                                        </div>
                                        <div class="col-4 form-group">
                                            <label>House No./ Flat No.</label>
                                            <input type="text" name="house_no" id="house_no" class="form-control"
                                                placeholder="Enter House No./ Flat No." required>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label>Apartment/Building Name/Colony</label>
                                            <input type="text" name="apartment" id="apartment" class="form-control"
                                                placeholder="Enter Apartment/Building Name/Colony" required>
                                        </div>
                                        
                                        <div class="col-6 form-group">
                                            <label>Landmark</label>
                                            <input type="text" name="landmark" id="landmark" class="form-control"
                                                placeholder="Enter Landmark" required>
                                        </div>
                                        
                                        <div class="col-6 form-group">
                                            <button type="submit" class="btn btn-success">      {{__('message.Add Address')}}      </button>
                                        </div>
                                        
                                    </div>
                            </form>
                      </div>
                      <div class="form-group col-6">
                          
                         <label for="name">Select Address<span class="reqfield">*</span></label>
                         <select class="form-control select2" id="addressId" name="address_id" onchange="$('#address').val(this.value)" required>
                             <option value="">--select address--</option>
                         </select>
                      </div>
                     
                      <div class="form-group  col-md-6">
                            <label>{{__('message.Select sample collection date')}}</label>
                            <input type="date" name="collection_date" id="collection_date" value="{{ date('Y-m-d') }}"  class=" form-control" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{__('message.Select sample collection time')}}</label>
                            <select name="collection_time" id="collection_time"  class="form-control select-input underline-select">
                                <option value="">Select Time slot</option>
                                <?php
                                     $currentTime = date("H:i");
                                     $selected='';
                                     $timeAfterTwoHours = date("H:i", strtotime('+2 hours'));
                                ?>
                                @foreach ($timeslot as $slot)
                                    <?php 
                                        $time_in_am_pm = date("g:i A", strtotime($slot->timeslot));
                                        $isNextSlot = strtotime($slot->timeslot) > strtotime($timeAfterTwoHours);
                                    ?>
                                    <option value="{{ $slot->timeslot }}" {{ $isNextSlot && !$selected ? 'selected' : '' }}>
                                        {{ $time_in_am_pm }}
                                    </option>
                                    @php
                                        if ($isNextSlot && !$selected) $selected = true; // Mark the first next slot as selected
                                    @endphp
                                @endforeach
                            </select>
                      </div>
                      <div class="form-group col-6">
                         <label for="name">Select Lab<span class="reqfield">*</span></label>
                         <select class="form-control select2" name="lab_id" onchange="$('#labid').val(this.value)" required>
                             <option value="">--select Lab--</option>
                             @foreach($labs as $lab)
                             <option value="{{$lab->id}}">{{$lab->name}}</option>
                             @endforeach
                         </select>
                      </div>
                      <div class="form-group col-6">
                          <lable>Apply Coupon</lable>
                           <div class="row">
                              <div class="col-8">
                                    <input type="hidden" id="cp_id">
                                    <input type="text" id="cp_code"  class="form-control" >
                              </div>
                              <div class="col-4">
                                <button type="button" class="btn btn-primary" onclick="applycoupon()">
                                    Add
                                </button>
                                </div>
                            </div>
                          
                      </div>
                      <div class="form-group col-8"></div>
                      <div class="form-group col-4 row">
                          <div class="col-6">
                              SubTotal:<br>
                              Discount:<br>
                              Total:
                          </div>
                          <div class="col-6">
                              <span id="subtotal">0</span><br>
                              <span id="discount">0</span><br>
                              <span id="total">0</span>
                          </div>
                      </div>
                  </div>
                 </div>
            <form  method="post" class="hidecheckout" id="checkoutForm" style="display:none;">
               {{csrf_field()}}
                  <div class="row">
                     <div class="col-12">
                        <input type="hidden" name="userid" id="user_id"  />
                        <input type="hidden" name="test_json" id="orderdata"  />
                        <input type="hidden" name="sample_collection_address_id" id="address"  />
                        <input type="hidden" name="labid" id="labid"  />
                        <input type="hidden" name="cp_id" id="cp_id"  />
                        <input type="hidden" name="memberid" id="memberid"  />
                        <input type="submit" value='Checkout' class="btn btn-success" id="checkoutBtn">
                     </div>
                  </div>
           	</form>
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

<div class="modal fade" id="regmodal" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document"> <!-- Added modal-lg for larger modal -->
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">Select User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> 
               <span aria-hidden="true">×</span> 
            </button> 
         </div>
         
         <form  id="userForm">
            <div class="modal-body">
               {{csrf_field()}}

               <div class="row">
                   <div class="form-group col-8">
                     <select class="form-control select2" id="userId" name="user_id" >
                         <option value="">search user</option>
                     </select>
                    </div>
                    <div class="form-group col-3">
                        <button type="button" class="btn btn-primary" id="resetButton">Reset Selected User</button>
                    </div>
                   <!-- Name -->
                   <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                       <label>{{__("message.Name")}}</label>
                       <input type="text" class="form-control" name="name" placeholder="{{__('message.Enter Name')}}" required>
                   </div>
                   <!-- Mobile -->
                   <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                       <label>Mobile</label>
                       <input type="text" class="form-control" name="phone" placeholder="Enter Mobile" required>
                   </div>

                   <!-- Email -->
                   <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                       <label>{{__("message.email")}}</label>
                       <input type="email" class="form-control" name="email" placeholder="{{__('message.Enter Email')}}" required>
                   </div>

                   <!-- Date of Birth -->
                   <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                       <label>Date of Birth</label>
                       <input type="date" class="form-control" name="d_o_b" onchange="agecalculate(this.value,'age2')" required>
                   </div>

                   <!-- Age -->
                   <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                       <label>Age</label>
                       <input type="number" class="form-control" name="age" id="age2" placeholder="Enter Age" required>
                   </div>

                   <!-- Gender -->
                   <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                       <label>Gender</label>
                       <select name="sex" class="form-control">
                           <option value='Male'>Male</option>
                           <option value='Female'>Female</option> <!-- Fixed typo -->
                       </select>
                   </div>
                    <div class="col-12 form-group text-center">
                       <button type="button" class="btn btn-primary" id="selectUserBtn" style="display: none;" onclick="changeUser()" >Select User</button>
                       <button type="submit" class="btn btn-primary" id="registerBtn">{{__("message.Register")}}</button>
                   </div>
                   
               </div> <!-- End Row -->
            </div> <!-- End Modal Body -->
         </form>

      </div> <!-- End Modal Content -->
   </div> <!-- End Modal Dialog -->
</div> <!-- End Modal -->

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
                        <select class="form-control" id="familyMember" onchange="$('#memberid').val(this.value)" name="familyMember">
                            
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{__("message.Add New Family Member")}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form with input fields -->
                  <form id="familyMemberForm" method="post" class="registration-form">
                    @csrf
                    <div class="row">
                        <div class="form-group col-6">
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
                        <div class="form-group col-6">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control"  name="name" required>
                        </div>
                        <div class="form-group col-6">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" >
                        </div>
                        <div class="form-group col-6">
                            <label for="phone">Phone:</label>
                            <input type="tel" class="form-control" name="mobile_no" >
                        </div>
                        <div class="form-group col-6">
                            <label for="age">Age:</label>
                            <input type="number" class="form-control" id="age1" name="age" >
                        </div>
                        <div class="form-group col-6">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" class="form-control" onchange="agecalculate(this.value,'age1')" name="dob" >
                        </div>
                        <div class="form-group col-6">
                            <label for="gender">Gender:</label>
                            <select class="form-control" name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$("#userForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission
        
        $.ajax({
            url: "{{ route('save_user_') }}",
            type: "POST",
            data: $(this).serialize(), // Serialize form data
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    console.log(response.data);
                    let userlist = $('select[name="user_id"]');
                    userlist.append(`<option value="${response.data.id}" data-name="${response.data.name}" selected>${response.data.name} ${response.data.relation}</option>`);
                    
                    $("#userForm")[0].reset(); // Reset the form
                    changeUser();
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                alert("Something went wrong!");
            }
        });
    });

function showPackageDetails(name,parameterData, packageName ,sampleType, fastingTime, recommendedFor,report_time) {
  
    document.getElementById("packageTitle").innerHTML = `
        <strong>${name}:</strong> ${packageName}
        <br>
        <small style="font-size: 12px; display: block; margin-top: 5px;">
            <strong>Sample Type:</strong> ${sampleType} || 
            <strong>Fasting Time:</strong> ${fastingTime} || 
            <strong>Recommended For:</strong> ${recommendedFor} ||
            <strong>Report Time:</strong> ${report_time}
        </small>
    `;

    // Clear previous data
    let paramList = document.getElementById("parameterList");
    paramList.innerHTML = "";

    // Check if parameterData exists and is an array
    if (Array.isArray(parameterData) && parameterData.length > 0) {
        let tableHTML = `<table class='table table-bordered' style='font-size:10px; margin:0; padding:0; border-collapse: collapse; width:100%;'>
            <thead>
                <tr style='background:#f8f9fa;'>
                    <th style='padding:2px;'>Sr. No.</th><th style='padding:2px;'>Parameter</th>
                    <th style='padding:2px;'>Sr. No.</th><th style='padding:2px;'>Parameter</th>
                    <th style='padding:2px;'>Sr. No.</th><th style='padding:2px;'>Parameter</th>
                </tr>
            </thead>
            <tbody>`;

        for (let i = 0; i < parameterData.length; i += 3) {
            tableHTML += "<tr>";
            
            // First Column
            tableHTML += `<td style='padding:2px;'><small>${i + 1}</small></td>
                          <td style='padding:2px;'><small>${parameterData[i]}</small></td>`;

            // Second Column (Check if exists)
            if (parameterData[i + 1] !== undefined) {
                tableHTML += `<td style='padding:2px;'><small>${i + 2}</small></td>
                              <td style='padding:2px;'><small>${parameterData[i + 1]}</small></td>`;
            } else {
                tableHTML += "<td style='padding:2px;'></td><td style='padding:2px;'></td>"; // Empty cells
            }

            // Third Column (Check if exists)
            if (parameterData[i + 2] !== undefined) {
                tableHTML += `<td style='padding:2px;'><small>${i + 3}</small></td>
                              <td style='padding:2px;'><small>${parameterData[i + 2]}</small></td>`;
            } else {
                tableHTML += "<td style='padding:2px;'></td><td style='padding:2px;'></td>"; // Empty cells
            }

            tableHTML += "</tr>";
        }

        tableHTML += "</tbody></table>";
        paramList.innerHTML = tableHTML;
    } else {
        paramList.innerHTML = "<p style='font-size:10px;'>No parameters available.</p>";
    }

    // Show modal
    $("#packageDetailsModal").modal("show");
}

    var bookedItems=[];
    var subtotal = 0;
    var total=0;
    var discount=0;
    function changeUser(){
        var id = document.getElementById('userId').value; // or $('#userId').val()
        console.log('==>'+id); // Debugging: Check the value
        if(id == ''){
            $('.hidediv').hide();
        }
        $('#user_id').val(id)
         bookedItems=[];
         subtotal = 0;
         total=0;
         discount=0; 
         
        getMember(id);
        getaddress(id);
        updateTable();
        $('#subtotal').html(subtotal);
        $('#total').html(total);
        $('#discount').html(discount);
        $("#regmodal").modal("hide");
        setTimeout(function() {
                $('.select2').select2();
            }, 100);
    }
    $(document).ready(function() {
        $('#regmodal').modal('show');
        getUser(3);
        $('#regmodal').on('shown.bs.modal', function () {
            getUser(3);
            $('#userId').select2('destroy');
            $('#userId').select2({
                dropdownParent: $('#regmodal')
            });
            
        });
        $('#userId').on('change', function () {
            let userId = $(this).val();
            if (userId) {
                $.ajax({
                    url: '/get_user_details', // Laravel route to fetch user details
                    type: 'GET',
                    data: { user_id: userId },
                    dataType: 'json',
                    success: function (user) {
                        $('input[name="name"]').val(user.name);
                        $('input[name="phone"]').val(user.phone);
                        $('input[name="email"]').val(user.email);
                        $('input[name="d_o_b"]').val(user.d_o_b);
                        $('input[name="age"]').val(user.age);
                        $('select[name="sex"]').val(user.sex).change();
    
                        // Toggle buttons: Show 'Select User' and hide 'Register'
                        $('#selectUserBtn').show();
                        $('#registerBtn').hide();
                    }
                });
            }
        });
        
    });
    
    function getUser(role){ 
        $.ajax({
            url: '/get_user_list',  // Define this route in Laravel
            type: 'GET',
            data: { role: role },  // Pass the order ID if necessary
            dataType: 'json',
            success: function(response) {
                    let userlist = $('select[name="user_id"]');
                    userlist.empty(); // Clear existing options
                    userlist.append(`<option value="">search user</option>`);
                    response.data.forEach(function(user) {
                    
                        userlist.append(`<option value="${user.id}">${user.name} ${user.phone}</option>`);
                    });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching sample boys:', error);
            }
        });
    }
    function applycoupon(){ 
        $.ajax({
            url: 'api/applycoupon_sample',  // Define this route in Laravel
            type: 'GET',
            data: { coupon_code: $('#cp_code').val(),subTotal:subtotal,book_test:bookedItems},  // Pass the order ID if necessary
            dataType: 'json',
            success: function(response) {
                
                discount=response.discount;
                total = subtotal - discount ;
                $('#total').html(total);
                $('#discount').html(response.discount);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching sample boys:', xhr);
            }
        });
    }
    function getMember(id){ 
    
        $('.hidediv').show();
        $.ajax({
            url: '/api/get_member_list',  // Define this route in Laravel
            type: 'GET',
            data: { id: id },  // Pass the order ID if necessary
            dataType: 'json',
            success: function(response) {
                
                let userlist = $('select[name="familyMember"]');
                userlist.empty();
                // userlist.append(`<option value="">select member</option>`);
                if(response.status == 1){
                    
                    response.data.forEach(function(user) {
                        userlist.append(`<option value="${user.id}" data-name="${user.name}">${user.name} ${user.relation}</option>`);
                    });
                    
                }
                
            },
            error: function(xhr, status, error) {
                console.error('Error fetching sample boys:', error);
            }
        });
    }
    function getaddress(id){ 
        
        if(id == ''){
            return;
        }
        $.ajax({
            url: '/api/getaddress',  // Define this route in Laravel
            type: 'GET',
            data: { id: id },  // Pass the order ID if necessary
            dataType: 'json',
            success: function(response) {
                if(response.status == "1"){
                let userlist = $('select[name="address_id"]');
                userlist.empty(); // Clear existing options
                userlist.append(`<option value="">select address</option>`);
                response.data.forEach(function(user) {
                      userlist.append(`<option value="${user.id}" >${user.name} ${user.address}</option>`);
                });
                }
                
            },
            error: function(xhr, status, error) {
                console.error('Error fetching sample boys:', error);
            }
        });
    }
    function togglebook(element, item_id, type, parameter,test_name,type_name,mrp) {
        
        var tempBooking = { type_id: item_id, type: type, parameter: parameter,test_name:test_name,type_name:type_name,mrp:mrp};

        $('#familyModal').modal('show');

        // Set a click event for the modal confirm button
        window.confirmBooking = function () {
            
            // Get the selected family member
            var selectedFamilyMember = $('#familyMember').val();
            let selectedOption = $('#familyMember').find(':selected');
            let memberName = selectedOption.data('name');
            // Update the tempBooking with the family member
            tempBooking.memberName=memberName;
            tempBooking.family_member_id = selectedFamilyMember;
            // Add the updated tempBooking to bookedItems array
            bookedItems.push(tempBooking);
            // Hide the modal
            $('#familyModal').modal('hide');
            // Update the hidden input field with bookedItems
            subtotal +=mrp;
            total +=mrp;
            $('#total').html(total);
            $('#subtotal').html(subtotal);
            $('#orderdata').val(JSON.stringify(bookedItems));
            // Refresh the table
            
            updateTable();
            applycoupon();
        };
    }
    // Function to update the table dynamically
    function updateTable() {
        let tableBody =  $('#selectedTestsTable tbody');
        tableBody.empty(); // Clear existing rows
      
        if(bookedItems.length == 0){
            $('.hidecheckout').hide();
        }else{
            $('.hidecheckout').show();
        }
        bookedItems.forEach((item, index) => {
            let newRow = `
                <tr>
                    <td>${item.test_name}</td>
                    <td>${item.type_name}</td>
                    <td>${item.mrp}</td>
                    <td>${item.memberName}</td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${index},${item.mrp})">Remove</button></td>
                </tr>
            `;
            tableBody.append(newRow);
        });
    }
    // Function to remove a selected test from the table
    function removeItem(index,mrp) {
        subtotal -=mrp;
        total -=mrp;
        
        $('#subtotal').html(subtotal);
        $('#total').html(total);
        applycoupon();
        bookedItems.splice(index, 1); // Remove item from the array
        updateTable(); // Refresh the table
    }

    $(document).ready(function () {
         
        $('.dataTable').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable search
            "ordering": true,       // Enable sorting
            "info": true,           // Show info
            "lengthMenu": [5,10, 25, 50, 100],  // Custom page length options
            "language": {
                "search": "Search Test:", // Custom search label
                "paginate": {
                    "previous": "Prev",
                    "next": "Next"
                }
            }
        });
    });
    function openModal() {
        $('#myModal').modal('show');
    }
    $(document).ready(function () {
    $("#checkoutForm").submit(function (e) {
        e.preventDefault(); // Prevent the default form submission
        let formData = $(this).serialize(); // Serialize form data
        user_id = $('#userId').val();
        formData += "&user_id=" + user_id;
        formData += "&subtotal=" + subtotal;
        formData += "&date=" + $('#collection_date').val();
        formData += "&time=" + $('#collection_time').val();
        formData +="&final_total="+total;
        formData +="&coupon_id="+$('#cp_code').val();
        $.ajax({
            url: '/api/admin_check_out',
            type: "GET",
            data: formData,
            dataType: "json",
            success: function (response) {
                
                alert(response.message);
                window.location.href = "/orders"; 
            },
            error: function (xhr) {
                alert("Something went wrong. Please try again.");
            }
        });
    });
    $("#familyMemberForm").submit(function (e) {
        e.preventDefault(); // Prevent the default form submission
        let formData = $(this).serialize(); // Serialize form data
        user_id = $('#userId').val();
        formData += "&user_id=" + user_id;
        formData += "&id=" + 0;
        $.ajax({
            url: '/api/save_member',
            type: "GET",
            data: formData,
            dataType: "json",
            success: function (response) {
                
                    let userlist = $('select[name="familyMember"]');
                    userlist.append(`<option value="${response.data.id}" data-name="${response.data.name}" selected>${response.data.name} ${response.data.relation}</option>`);
                    $('#myModal').modal('hide');
                    
                
            },
            error: function (xhr) {
                alert("Something went wrong. Please try again.");
            }
        });
    });
    $("#user_address_data").submit(function (e) {
        e.preventDefault(); // Prevent the default form submission
        let formData = $(this).serialize(); // Serialize form data
        user_id = $('#userId').val();
        formData += "&user_id=" + user_id;
        formData += "&id=" + 0;
        $.ajax({
            url: '/api/saveaddress',
            type: "GET",
            data: formData,
            dataType: "json",
            success: function (response) {
                    let userlist = $('select[name="address_id"]');
                    userlist.append(`<option value="${response.data.id}" selected>${response.data.name} ${response.data.address}</option>`);
                    $('#address').val(response.data.id);
                    $('#user_address_data')[0].reset();
                    alert("address saved. please select from dorpdown");
                   
            },
            error: function (xhr) {
               
                alert("Something went wrong. Please try again.");
            }
        });
    });
});
    document.getElementById("checkoutBtn").addEventListener("click", function(event) {
        // Get all hidden input fields
        let address = document.getElementById("address").value.trim();
        let labId = document.getElementById("labid").value.trim();
        
        // Check if any required field is empty
        if (address === "" || labId === "" ) {
            event.preventDefault(); // Prevent form submission
            // Show toast notification
            alert("Please fill all required fields Address & Lab before checkout!");
        }
    });
    $(document).ready(function(){
        
          $(".nav-tabs a").click(function(){
            $(".nav-tabs a").removeClass("active"); // Remove active class from all tabs
            $(this).addClass("active"); // Add active class to clicked tab
            
            $(".tab-pane").removeClass("show active");
            $($(this).attr("href")).addClass("show active"); 
        });
    });
    document.getElementById("collection_date").onchange = function() {
        updateTimeSlots();
    };
    
    document.getElementById("collection_time").onchange = function() {
        validateDateTime();
    };
    function updateTimeSlots() {
    var selectedDate = document.getElementById("collection_date").value;
    var timeSelect = document.getElementById("collection_time");
    var now = new Date();
    var currentTime = now.getHours() + ":" + now.getMinutes(); // Current time in "HH:mm" format

    timeSelect.innerHTML = '<option value="">Select Time slot</option>'; // Reset time slots

    let firstSlotAdded = false; // To track if the first slot has been added

    @foreach ($timeslot as $slot)
        var slotTime = "{{ $slot->timeslot }}";
        var slotTimeFormatted = new Date(now.toDateString() + ' ' + slotTime);

        // If the selected date is today, disable time slots before the current time + 2 hours
        if (selectedDate === now.toISOString().split('T')[0]) {
            var timeAfterTwoHours = new Date(now.getTime() + 2 * 60 * 60 * 1000); // Current time + 2 hours

            if (slotTimeFormatted > timeAfterTwoHours) {
                var option = new Option('{{ date("g:i A", strtotime($slot->timeslot)) }}', '{{ $slot->timeslot }}');
                timeSelect.add(option);

                // Automatically select the first available future time slot
                if (!firstSlotAdded) {
                    option.selected = true; // Select the first valid slot
                    firstSlotAdded = true; // Mark that the first slot has been added
                }
            }
        } else {
            // For future dates, allow all time slots
            var option = new Option('{{ date("g:i A", strtotime($slot->timeslot)) }}', '{{ $slot->timeslot }}');
            timeSelect.add(option);

            // Automatically select the first time slot for future dates
            if (!firstSlotAdded) {
                option.selected = true; // Select the first slot
                firstSlotAdded = true; // Mark that the first slot has been added
            }
        }
    @endforeach

    // Check if it's past 7 PM and the selected date is today
    if (selectedDate === now.toISOString().split('T')[0] && now.getHours() >= 19) {
        // Automatically move to the next day's first slot
        document.getElementById("collection_date").value = new Date(now.setDate(now.getDate() + 1)).toISOString().split('T')[0];
        alert('It\'s past 7 PM. Please select a slot for the next day.');
        updateTimeSlots();
    }
    }
    function validateDateTime(event) {
        var selectedDate = document.getElementById("collection_date").value;
        var selectedTime = document.getElementById("collection_time").value;
    
        if (!selectedDate || !selectedTime) {
            alert('Please select both date and time.');
            event.preventDefault();
            return false;
        }
    
        var selectedDateTime = new Date(selectedDate + ' ' + selectedTime);
        var currentDateTime = new Date();
    
        if (selectedDateTime <= currentDateTime) {
            alert('Please select a future date and time.');
            document.getElementById("collection_time").selectedIndex = 0;
            event.preventDefault();
            return false;
        }
        return true;
    }
    function initMap() {
        var defaultLat = parseFloat(document.getElementById('us2-lat').value) || 28.7041; // Default: Delhi
        var defaultLng = parseFloat(document.getElementById('us2-lon').value) || 77.1025;

        var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: defaultLat, lng: defaultLng },
            zoom: 15
        });

        var marker = new google.maps.Marker({
            position: { lat: defaultLat, lng: defaultLng },
            map: map,
            draggable: true
        });

        // Enable Places API for address autocomplete
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'), {
            types: ['geocode'] // Restrict results to addresses
        });

        autocomplete.setFields(['address_components', 'geometry', 'formatted_address']);

        // When user selects an address
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                alert("No details available for input: '" + place.name + "'");
                return;
            }

            // Move marker to selected location
            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);

            // Update hidden form fields
            document.getElementById('us2-lat').value = place.geometry.location.lat();
            document.getElementById('us2-lon').value = place.geometry.location.lng();
            document.getElementById('address').value = place.formatted_address;
            document.getElementById('autocomplete').value = place.formatted_address; // Update input field
        });

        // When marker is dragged, update fields
        google.maps.event.addListener(marker, 'dragend', function () {
            var position = marker.getPosition();
            document.getElementById('us2-lat').value = position.lat();
            document.getElementById('us2-lon').value = position.lng();

            // Get address from lat-long
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'location': position }, function (results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('address').value = results[0].formatted_address;
                        document.getElementById('autocomplete').value = results[0].formatted_address; // Update input field
                    }
                }
            });
        });
    }
    // Initialize map on window load
    window.onload = initMap;
    $('#addaddressmodel').on('shown.bs.modal', function () {
        initMap();  // Initialize the map when the modal is shown
    });
    function agecalculate(val,id){
        
        let dob = new Date(val);
        let today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        let monthDiff = today.getMonth() - dob.getMonth();
        let dayDiff = today.getDate() - dob.getDate();

        // Adjust age if birthday hasn't occurred this year yet
        if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
            age--;
        }
        // Set age input value
        
        $(`#${id}`).val(age);
    }
$('#resetButton').on('click', function() {
        location.reload(); // Refresh the page
    });
</script>


@endsection