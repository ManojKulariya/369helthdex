@extends('admin.layout.index')
@section('title')
Create Booking
@stop
@section('content')

<style>
    @media (min-width: 768px) {
        .modal-lg { max-width: 80%; }
    }
    .map #us2 { width: 100%; height: 200px; }
</style>

<div class="adm-bk">

    {{-- ============ Page header ============ --}}
    <div class="page-header adm-orders-header">
        <div>
            <h3 class="page-title mb-0">Create Booking</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb adm-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">{{__("message.Home")}}</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin-orders')}}">Orders</a></li>
                    <li class="breadcrumb-item active">Create Booking</li>
                </ol>
            </nav>
        </div>
        <a href="{{route('admin-orders')}}" class="btn btn-success adm-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            View Orders
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

    {{-- ============ Selected-customer banner: who this booking is for ============ --}}
    <div class="adm-bk-customerbar" id="bkCustomerBar" style="display:none;">
        <span class="adm-bk-customerbar-avatar" id="bkCustomerAvatar"></span>
        <div class="adm-bk-customerbar-info">
            <b id="bkCustomerName"></b>
            <span id="bkCustomerPhone"></span>
        </div>
        <button type="button" class="adm-ot-btn" data-bs-toggle="modal" data-bs-target="#regmodal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 11v6"/><path d="M19 14h6"/></svg>
            Change Customer
        </button>
    </div>

    <div class="adm-bk-grid">
        <div class="adm-bk-main">

            {{-- ============ Test catalog + Selected tests (hidden until a customer is picked — .hidediv is the exact hook changeUser()/getMember() already toggle) ============ --}}
            <div class="hidediv" style="display:none;">

                <div class="adm-form-card">
                    <div class="adm-form-card-head">
                        <div class="adm-form-card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/></svg>
                            Add Tests
                        </div>
                        <ul class="nav nav-tabs adm-cat-tabs" id="testTabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#packageTab">Packages</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profileTab">Profiles</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#parameterTab">Parameters</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="packageTab" class="tab-pane fade show active">
                            <div class="adm-orders-toolbar adm-cat-toolbar">
                                <div class="adm-ot-search">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                    <input type="text" id="pkgSearchInput" placeholder="Search packages…" autocomplete="off">
                                </div>
                                <select id="pkgLenSelect" class="adm-ot-select adm-ot-len" aria-label="Rows per page">
                                    <option value="5">5 rows</option>
                                    <option value="10">10 rows</option>
                                    <option value="25">25 rows</option>
                                    <option value="50">50 rows</option>
                                </select>
                            </div>
                            <div class="adm-table-wrap">
                                <table class="table adm-cat-table dataTable">
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
                                            <td class="adm-cat-name">{{$packages->name}}
                                                <span class="adm-cat-count">{{$packages->no_of_parameter}} parameters</span>
                                                <button type="button" class="adm-cat-eye" title="View details"
                                                    onclick="showPackageDetails('Package',{{ $p_data }}, '{{$packages->name}}','{{$packages->sample_type}}','{{$packages->fasting_time}}','{{$reco}}','{{$packages->report_time}}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                                </button>
                                            </td>
                                            <td class="adm-cat-price">₹{{$packages->price}}</td>
                                            <td>
                                                <a href="#" onclick="togglebook(this,{{$packages->id}},1,1,'{{$packages->name}}','Packages',{{$packages->price}})" class="btn btn-success adm-cat-add">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                                    Add
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="profileTab" class="tab-pane fade">
                            <div class="adm-orders-toolbar adm-cat-toolbar">
                                <div class="adm-ot-search">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                    <input type="text" id="profSearchInput" placeholder="Search profiles…" autocomplete="off">
                                </div>
                                <select id="profLenSelect" class="adm-ot-select adm-ot-len" aria-label="Rows per page">
                                    <option value="5">5 rows</option>
                                    <option value="10">10 rows</option>
                                    <option value="25">25 rows</option>
                                    <option value="50">50 rows</option>
                                </select>
                            </div>
                            <div class="adm-table-wrap">
                                <table class="table adm-cat-table dataTable">
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
                                            <td class="adm-cat-name">{{$profile->profile_name}}
                                                <span class="adm-cat-count">{{$profile->no_of_parameter}} parameters</span>
                                                <button type="button" class="adm-cat-eye" title="View details"
                                                    onclick="showPackageDetails('Profile',{{ $p_data }}, '{{$profile->profile_name}}','{{$profile->sample_type}}','{{$profile->fasting_time}}','{{$reco}}','{{$profile->report_time}}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                                </button>
                                            </td>
                                            <td class="adm-cat-price">₹{{$profile->price}}</td>
                                            <td>
                                                <a href="#" onclick="togglebook(this,{{$profile->id}},3,1,'{{$profile->profile_name}}','Profile',{{$profile->price}})" class="btn btn-success adm-cat-add">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                                    Add
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="parameterTab" class="tab-pane fade">
                            <div class="adm-orders-toolbar adm-cat-toolbar">
                                <div class="adm-ot-search">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                    <input type="text" id="paramSearchInput" placeholder="Search parameters…" autocomplete="off">
                                </div>
                                <select id="paramLenSelect" class="adm-ot-select adm-ot-len" aria-label="Rows per page">
                                    <option value="5">5 rows</option>
                                    <option value="10">10 rows</option>
                                    <option value="25">25 rows</option>
                                    <option value="50">50 rows</option>
                                </select>
                            </div>
                            <div class="adm-table-wrap">
                                <table class="table adm-cat-table dataTable">
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
                                            <td class="adm-cat-name">{{$parameters->name}}
                                                <span class="adm-cat-count">{{$parameters->sample_type}} · Fasting: {{$parameters->fast_time}}</span>
                                            </td>
                                            <td class="adm-cat-price">₹{{$parameters->price}}</td>
                                            <td>
                                                <a href="#" onclick="togglebook(this,{{$parameters->id}},2,1,'{{$parameters->name}}','Parameters',{{$parameters->price}})" class="btn btn-success adm-cat-add">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                                    Add
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="adm-form-card">
                    <div class="adm-form-card-head">
                        <div class="adm-form-card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11H5a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h4"/><rect width="10" height="14" x="9" y="5" rx="2"/></svg>
                            Selected Tests
                        </div>
                        <span class="adm-bk-count-badge" id="selectedCountBadge">0</span>
                    </div>
                    <div class="adm-table-wrap">
                        <table id="selectedTestsTable" class="table adm-cat-table adm-cart-table no-footer">
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

            {{-- ============ Collection address ============ --}}
            <div class="adm-form-card">
                <div class="adm-form-card-head">
                    <div class="adm-form-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        Collection Address
                    </div>
                </div>
                <form id="user_address_data" class="adm-bk-form">
                    <div class="row">
                        <div class="col-12 adm-field" id="addressorder">
                            <label>{{__('message.Address')}}<span class="reqfield">*</span></label>
                            <input type="text" id="autocomplete" class="form-control" name="address" placeholder="Search Location" />
                        </div>
                        <div class="col-12 adm-field">
                            <div id="map" class="adm-bk-map"></div>
                        </div>
                        <?php
                            $inputLatitude = env('MAP_LAT');
                            $inputLongitude = env('MAP_LONG');
                        ?>
                        <input type="hidden" name="lat" id="us2-lat" value="{{$inputLatitude}}" />
                        <input type="hidden" name="long" id="us2-lon" value="{{$inputLongitude}}" />
                        <input type="hidden" name="state" value="0" />
                        <input type="hidden" name="city" value="0" />

                        <div class="col-md-4 adm-field">
                            <label>Save As</label>
                            <select name="name" class="form-control">
                                <option>Home</option>
                                <option>Work</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 adm-field">
                            <label>{{__('message.Pincode')}}</label>
                            <input type="text" name="pincode" id="pincode" class="form-control" placeholder="{{__('message.Enter Pincode')}}" required>
                        </div>
                        <div class="col-md-4 adm-field">
                            <label>House No./ Flat No.</label>
                            <input type="text" name="house_no" id="house_no" class="form-control" placeholder="Enter House No./ Flat No." required>
                        </div>
                        <div class="col-md-6 adm-field">
                            <label>Apartment/Building Name/Colony</label>
                            <input type="text" name="apartment" id="apartment" class="form-control" placeholder="Enter Apartment/Building Name/Colony" required>
                        </div>
                        <div class="col-md-6 adm-field">
                            <label>Landmark</label>
                            <input type="text" name="landmark" id="landmark" class="form-control" placeholder="Enter Landmark" required>
                        </div>
                        <div class="col-12 adm-field">
                            <button type="submit" class="btn btn-success adm-btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                {{__('message.Add Address')}}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="adm-field adm-bk-savedaddress">
                    <label>Select Saved Address<span class="reqfield">*</span></label>
                    <select class="form-control select2" id="addressId" name="address_id" onchange="$('#address').val(this.value)" required>
                        <option value="">--select address--</option>
                    </select>
                </div>
            </div>

            {{-- ============ Schedule + Lab ============ --}}
            <div class="adm-form-card">
                <div class="adm-form-card-head">
                    <div class="adm-form-card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                        Collection Schedule &amp; Lab
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 adm-field">
                        <label>{{__('message.Select sample collection date')}}</label>
                        <input type="date" name="collection_date" id="collection_date" value="{{ date('Y-m-d') }}" class="form-control" min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4 adm-field">
                        <label>{{__('message.Select sample collection time')}}</label>
                        <select name="collection_time" id="collection_time" class="form-control select-input underline-select">
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
                                    if ($isNextSlot && !$selected) $selected = true;
                                @endphp
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 adm-field">
                        <label>Select Lab<span class="reqfield">*</span></label>
                        <select class="form-control select2" name="lab_id" onchange="$('#labid').val(this.value)" required>
                            <option value="">--select Lab--</option>
                            @foreach($labs as $lab)
                            <option value="{{$lab->id}}">{{$lab->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>

        {{-- ============ Sticky booking summary ============ --}}
        <div class="adm-bk-summary">
            <div class="adm-summary-card">
                <div class="adm-summary-title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    Booking Summary
                </div>

                <div class="adm-field adm-bk-coupon">
                    <label>Apply Coupon</label>
                    <div class="adm-bk-coupon-row">
                        <input type="text" id="cp_code" class="form-control" placeholder="Enter coupon code">
                        <button type="button" class="adm-ot-btn adm-ot-btn--green" onclick="applycoupon()">Apply</button>
                    </div>
                    <span class="adm-bk-coupon-msg" id="couponMsg"></span>
                </div>

                <div class="adm-summary-rows">
                    <div class="adm-summary-row"><span>Subtotal</span><b id="subtotal">0</b></div>
                    <div class="adm-summary-row adm-summary-row--discount"><span>Discount</span><b id="discount">0</b></div>
                    <div class="adm-summary-row adm-summary-row--total"><span>Total</span><b id="total">0</b></div>
                </div>

                <form method="post" class="hidecheckout" id="checkoutForm" style="display:none;">
                    {{csrf_field()}}
                    <input type="hidden" name="userid" id="user_id" />
                    <input type="hidden" name="test_json" id="orderdata" />
                    <input type="hidden" name="sample_collection_address_id" id="address" />
                    <input type="hidden" name="labid" id="labid" />
                    <input type="hidden" name="cp_id" id="cp_id" />
                    <input type="hidden" name="memberid" id="memberid" />
                    <input type="submit" value="Checkout" class="btn btn-success adm-btn-primary adm-bk-checkout-btn" id="checkoutBtn">
                </form>
                <p class="adm-bk-summary-hint" id="checkoutHint">Select a customer and add at least one test to continue.</p>
            </div>
        </div>
    </div>
</div>

{{-- ============ Package Details modal ============ --}}
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

{{-- ============ Select User modal — card-based ============ --}}
<div class="modal fade adm-modal" id="regmodal" tabindex="-1" aria-labelledby="normalmodal" style="display: none;" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="normalmodal1">
                <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
                Select Customer
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
         </div>

         <div class="modal-body">
            <div class="adm-ot-search adm-bk-usersearch">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" id="userCardSearch" placeholder="Search by name, mobile or email…" autocomplete="off">
            </div>

            {{-- the real, functional control — kept as a plain (hidden) select so
                 the existing change handler (fills the create/select form,
                 toggles Select/Register) and get_user_details AJAX call keep
                 working exactly as before; the cards below just drive it --}}
            <select class="adm-bk-hidden-select" id="userId" name="user_id" style="display:none;">
                <option value="">search user</option>
            </select>

            <div class="adm-user-grid" id="userCardGrid"></div>
            <div class="adm-empty" id="userCardEmpty" style="display:none;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <b>No customers found</b><span>Try a different search, or create a new customer below.</span>
            </div>

            <button type="button" class="adm-ot-btn adm-bk-newcustomer-toggle" id="newCustomerToggle">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                <span>Create New Customer</span>
            </button>

            <form id="userForm" class="adm-bk-newcustomer-form" style="display:none;">
               {{csrf_field()}}
               <div class="row">
                   <div class="col-lg-6 col-md-6 col-sm-12 adm-field">
                       <label>{{__("message.Name")}}</label>
                       <input type="text" class="form-control" name="name" placeholder="{{__('message.Enter Name')}}" required>
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 adm-field">
                       <label>Mobile</label>
                       <input type="text" class="form-control" name="phone" placeholder="Enter Mobile" required>
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 adm-field">
                       <label>{{__("message.email")}}</label>
                       <input type="email" class="form-control" name="email" placeholder="{{__('message.Enter Email')}}" required>
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 adm-field">
                       <label>Date of Birth</label>
                       <input type="date" class="form-control" name="d_o_b" onchange="agecalculate(this.value,'age2')" required>
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 adm-field">
                       <label>Age</label>
                       <input type="number" class="form-control" name="age" id="age2" placeholder="Enter Age" required>
                   </div>
                   <div class="col-lg-6 col-md-6 col-sm-12 adm-field">
                       <label>Gender</label>
                       <select name="sex" class="form-control">
                           <option value='Male'>Male</option>
                           <option value='Female'>Female</option>
                       </select>
                   </div>
                   <div class="col-12 adm-field text-center">
                       <button type="button" class="btn btn-primary adm-btn-primary" id="selectUserBtn" style="display: none;" onclick="changeUser()">Select User</button>
                       <button type="submit" class="btn btn-primary adm-btn-primary" id="registerBtn">{{__("message.Register")}}</button>
                   </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="resetButton">Reset Selected User</button>
         </div>
      </div>
   </div>
</div>

{{-- ============ Select Family Member modal ============ --}}
<div class="modal fade adm-modal" id="familyModal" tabindex="-1" role="dialog" aria-labelledby="familyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="familyModalLabel">
                    <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/></svg></span>
                    Select Family Member
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="familyForm">
                    <div class="adm-field">
                        <label for="familyMember">Choose who this test is for:</label>
                        <select class="form-control" id="familyMember" onchange="$('#memberid').val(this.value)" name="familyMember">
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary adm-btn-primary" onclick="confirmBooking()">Confirm</button>
                <button type="button" class="btn btn-secondary" onclick="openModal()">{{__("message.Add New Family Member")}}</button>
            </div>
        </div>
    </div>
</div>

{{-- ============ Add Family Member modal ============ --}}
<div class="modal adm-modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span class="adm-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg></span>
                    {{__("message.Add New Family Member")}}
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                  <form id="familyMemberForm" method="post" class="registration-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 adm-field">
                            <label>{{__("message.Relation")}}</label>
                            <select name="relation" class="form-control" required="">
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
                        <div class="col-md-6 adm-field">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6 adm-field">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="col-md-6 adm-field">
                            <label for="phone">Phone:</label>
                            <input type="tel" class="form-control" name="mobile_no">
                        </div>
                        <div class="col-md-6 adm-field">
                            <label for="age">Age:</label>
                            <input type="number" class="form-control" id="age1" name="age">
                        </div>
                        <div class="col-md-6 adm-field">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" class="form-control" onchange="agecalculate(this.value,'age1')" name="dob">
                        </div>
                        <div class="col-md-6 adm-field">
                            <label for="gender">Gender:</label>
                            <select class="form-control" name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success adm-btn-primary">Save</button>
                </div>
             </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
/* ==========================================================================
   Create Booking — all original functions kept with the same names/ids/
   routes/signatures (togglebook, showPackageDetails, changeUser, getMember,
   getaddress, confirmBooking, updateTable, removeItem, applycoupon,
   agecalculate, openModal, and every AJAX submit handler). Additions are
   scoped to: (1) rendering user results as cards instead of <option>s,
   (2) two bug fixes called out inline below, (3) restyled selected-tests
   rows. No endpoint, field name, or workflow step changed.
   ========================================================================== */

var ORIGIN = "{{ url('/') }}";
var latestUserResults = [];

function avatarHtml(user) {
    if (user.profile_pic) {
        return '<img src="' + ORIGIN + '/storage/profile/' + user.profile_pic + '" alt="">';
    }
    var initial = (user.name || '?').trim().charAt(0).toUpperCase();
    return '<span>' + (initial || '?') + '</span>';
}

function renderUserCards(users) {
    latestUserResults = users || [];
    var $grid = $('#userCardGrid');
    var $empty = $('#userCardEmpty');
    $grid.empty();
    if (!users || !users.length) {
        $empty.show();
        return;
    }
    $empty.hide();
    users.forEach(function (user) {
        var meta = [];
        if (user.phone) {
            meta.push('<span class="adm-user-meta"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>' + user.phone + '</span>');
        }
        if (user.email) {
            meta.push('<span class="adm-user-meta"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>' + user.email + '</span>');
        }
        if (user.city) {
            meta.push('<span class="adm-user-meta"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>' + user.city + '</span>');
        }
        var orders = user.orders_count || 0;
        var card = $(
            '<div class="adm-user-card">' +
                '<span class="adm-user-avatar">' + avatarHtml(user) + '</span>' +
                '<span class="adm-user-body">' +
                    '<span class="adm-user-name">' + (user.name || 'Unnamed') + '</span>' +
                    '<span class="adm-user-meta-row">' + meta.join('') + '</span>' +
                    '<span class="adm-user-orders">' + orders + ' previous order' + (orders === 1 ? '' : 's') + '</span>' +
                '</span>' +
                '<button type="button" class="adm-ot-btn adm-ot-btn--green adm-user-select">Select</button>' +
            '</div>'
        );
        card.find('.adm-user-select').on('click', function () {
            $('#userId').val(user.id).trigger('change');
        });
        $grid.append(card);
    });
}

$("#userForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: "{{ route('save_user_') }}",
            type: "POST",
            data: $(this).serialize(), // Serialize form data
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    let userlist = $('select[name="user_id"]');
                    userlist.append(`<option value="${response.data.id}" data-name="${response.data.name}" selected>${response.data.name} ${response.data.relation}</option>`);

                    $("#userForm")[0].reset(); // Reset the form
                    changeUser();
                } else {
                    admNotify.error(response.message, 'Registration Failed');
                }
            },
            error: function (xhr, status, error) {
                admNotify.error('Something went wrong. Please try again.', 'Request Failed');
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

            tableHTML += `<td style='padding:2px;'><small>${i + 1}</small></td>
                          <td style='padding:2px;'><small>${parameterData[i]}</small></td>`;

            if (parameterData[i + 1] !== undefined) {
                tableHTML += `<td style='padding:2px;'><small>${i + 2}</small></td>
                              <td style='padding:2px;'><small>${parameterData[i + 1]}</small></td>`;
            } else {
                tableHTML += "<td style='padding:2px;'></td><td style='padding:2px;'></td>";
            }

            if (parameterData[i + 2] !== undefined) {
                tableHTML += `<td style='padding:2px;'><small>${i + 3}</small></td>
                              <td style='padding:2px;'><small>${parameterData[i + 2]}</small></td>`;
            } else {
                tableHTML += "<td style='padding:2px;'></td><td style='padding:2px;'></td>";
            }

            tableHTML += "</tr>";
        }

        tableHTML += "</tbody></table>";
        paramList.innerHTML = tableHTML;
    } else {
        paramList.innerHTML = "<p style='font-size:10px;'>No parameters available.</p>";
    }

    $("#packageDetailsModal").modal("show");
}

    var bookedItems=[];
    var subtotal = 0;
    var total=0;
    var discount=0;
    function updateCustomerBar() {
        var $opt = $('#userId').find(':selected');
        var id = $('#userId').val();
        if (!id) { $('#bkCustomerBar').hide(); return; }
        var match = latestUserResults.filter(function (u) { return String(u.id) === String(id); })[0];
        var name = match ? match.name : $opt.data('name');
        $('#bkCustomerName').text(name || ('Customer #' + id));
        $('#bkCustomerPhone').text(match && match.phone ? match.phone : '');
        $('#bkCustomerAvatar').html(match ? avatarHtml(match) : '<span>' + (name ? name.charAt(0).toUpperCase() : '?') + '</span>');
        $('#bkCustomerBar').show();
    }
    function changeUser(){
        var id = document.getElementById('userId').value; // or $('#userId').val()
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
        updateCustomerBar();
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
                        $('#userForm').show();
                    }
                });
            }
        });
        $('#newCustomerToggle').on('click', function () {
            $('#userForm').slideToggle(150);
        });
        $('#userCardSearch').on('input', function () {
            var term = $(this).val().trim().toLowerCase();
            if (!term) { renderUserCards(latestUserResults.__all || latestUserResults); return; }
            var all = latestUserResults.__all || latestUserResults;
            var filtered = all.filter(function (u) {
                return (u.name || '').toLowerCase().indexOf(term) !== -1 ||
                       (u.phone || '').toLowerCase().indexOf(term) !== -1 ||
                       (u.email || '').toLowerCase().indexOf(term) !== -1;
            });
            renderUserCards(filtered);
            latestUserResults.__all = all; // preserve full list across re-filters
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
                        userlist.append(`<option value="${user.id}" data-name="${user.name}">${user.name} ${user.phone}</option>`);
                    });
                    response.data.__all = response.data.slice();
                    renderUserCards(response.data);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching sample boys:', error);
            }
        });
    }
    function applycoupon(){
        var $msg = $('#couponMsg');
        var code = $('#cp_code').val();
        if (!code) { $msg.text(''); return; }
        $.ajax({
            url: 'api/applycoupon_sample',  // Define this route in Laravel
            type: 'GET',
            data: { coupon_code: code, subTotal:subtotal, book_test:bookedItems},  // Pass the order ID if necessary
            dataType: 'json',
            success: function(response) {
                /* Bug fix: an invalid/not-found coupon returns a response with
                   no "discount" key at all. The previous code assigned it
                   unconditionally (discount = response.discount === undefined),
                   which turned `total = subtotal - discount` into NaN and left
                   the summary showing "NaN" until the page was reloaded. Now we
                   only apply a discount when the server actually returned one. */
                if (!response || response.status !== true || typeof response.discount !== 'number') {
                    discount = 0;
                    total = subtotal;
                    $('#total').html(total);
                    $('#discount').html(discount);
                    $msg.text(code ? 'Coupon not applicable.' : '');
                    return;
                }
                discount=response.discount;
                total = subtotal - discount ;
                $('#total').html(total);
                $('#discount').html(response.discount);
                $msg.text('Coupon applied.');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching sample boys:', xhr);
                $msg.text('Could not apply coupon, please try again.');
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

        if (!$('#familyMember option').length) {
            admNotify.warning('Click "Add New Family Member" to add one before selecting a test.', 'No Family Members Yet');
        }
        $('#familyModal').modal('show');

        // Set a click event for the modal confirm button
        window.confirmBooking = function () {

            // Get the selected family member
            var selectedFamilyMember = $('#familyMember').val();
            /* Defensive guard: confirming with nothing selected used to
               silently push an item with an empty family_member_id, which
               later breaks the order-details view (memberdetails resolves to
               null there). Block it here instead. */
            if (!selectedFamilyMember) {
                admNotify.warning('Please choose a family member first.', 'Missing Family Member');
                return;
            }
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

        $('#selectedCountBadge').text(bookedItems.length);

        if(bookedItems.length == 0){
            $('.hidecheckout').hide();
            $('#checkoutHint').show();
            tableBody.append('<tr class="adm-cart-empty-row"><td colspan="5"><div class="adm-empty adm-empty--inline"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73Z"/></svg><b>No tests selected yet</b><span>Add a package, profile or parameter above.</span></div></td></tr>');
            return;
        }
        $('.hidecheckout').show();
        $('#checkoutHint').hide();
        bookedItems.forEach((item, index) => {
            let newRow = `
                <tr>
                    <td class="adm-cart-name">${item.test_name}</td>
                    <td><span class="adm-chip adm-chip--green">${item.type_name}</span></td>
                    <td class="adm-cart-price">₹${item.mrp}</td>
                    <td>${item.memberName || '—'}</td>
                    <td><button type="button" class="adm-act adm-act--red" onclick="removeItem(${index},${item.mrp})"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>Remove</button></td>
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

        var catalogDtOptions = {
            "paging": true,         // Enable pagination
            "searching": true,      // Enable search
            "ordering": true,       // Enable sorting
            "info": true,           // Show info
            "dom": "rtip",          // Native length/filter markup replaced by the toolbar below
            "lengthMenu": [5, 10, 25, 50, 100],  // Custom page length options
            "language": {
                "paginate": {
                    "previous": "Prev",
                    "next": "Next"
                }
            }
        };
        /* Each tab gets its own DataTable instance (instead of one shared
           selector) so the custom search/length toolbar below can drive its
           own table via the DataTables API without affecting the other two
           tabs. Behavior (paging/search/sort/lengths) is unchanged. */
        var pkgTable = $('#packageTab table.adm-cat-table.dataTable').DataTable(catalogDtOptions);
        var profTable = $('#profileTab table.adm-cat-table.dataTable').DataTable(catalogDtOptions);
        var paramTable = $('#parameterTab table.adm-cat-table.dataTable').DataTable(catalogDtOptions);

        function wireCatalogToolbar(table, searchId, lenId) {
            var deb;
            $('#' + searchId).on('input', function () {
                var v = this.value;
                clearTimeout(deb);
                deb = setTimeout(function () { table.search(v).draw(); }, 300);
            });
            $('#' + lenId).on('change', function () {
                table.page.len(parseInt(this.value, 10) || 5).draw();
            });
        }
        wireCatalogToolbar(pkgTable, 'pkgSearchInput', 'pkgLenSelect');
        wireCatalogToolbar(profTable, 'profSearchInput', 'profLenSelect');
        wireCatalogToolbar(paramTable, 'paramSearchInput', 'paramLenSelect');

        updateTable();
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

                admNotify.success(response.message, 'Booking Created');
                setTimeout(function () { window.location.href = "/orders"; }, 1400);
            },
            error: function (xhr) {
                admNotify.error('Something went wrong. Please try again.', 'Checkout Failed');
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
                admNotify.error('Something went wrong. Please try again.', 'Request Failed');
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
                    admNotify.success('Address saved. Please select it from the dropdown.', 'Address Saved');

            },
            error: function (xhr) {

                admNotify.error('Something went wrong. Please try again.', 'Request Failed');
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
            admNotify.warning('Please select both Address and Lab before proceeding to checkout.', 'Missing Required Information');
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
        admNotify.warning("It's past 7 PM, so we've moved you to the next day's first available slot.", 'Slot Unavailable');
        updateTimeSlots();
    }
    }
    function validateDateTime(event) {
        var selectedDate = document.getElementById("collection_date").value;
        var selectedTime = document.getElementById("collection_time").value;

        if (!selectedDate || !selectedTime) {
            admNotify.warning('Please select both date and time.', 'Missing Information');
            event.preventDefault();
            return false;
        }

        var selectedDateTime = new Date(selectedDate + ' ' + selectedTime);
        var currentDateTime = new Date();

        if (selectedDateTime <= currentDateTime) {
            admNotify.warning('Please select a future date and time.', 'Invalid Time Slot');
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
                admNotify.warning("No details available for input: '" + place.name + "'", 'Address Not Found');
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
