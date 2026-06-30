<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Reliable Admin Panel" name="description">
		<meta content="Reliable Diagnostics Centre" name="author">
		<meta name="keywords" content="Reliable Diagnostics Centre Admin">

		<!-- Title -->
		<title>@yield('title')</title>

		<!--Favicon -->
		<link rel="icon" href="{{Session::get('favicon')}}" type="image/x-icon"/>

		<!--Bootstrap css -->
		@if(Session::get("is_rtl")==1)
		<link href="{{ asset('public/assets/css/rtl/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('public/assets/css/rtl/style.css?v=0') }}" rel="stylesheet" />
		<link href="{{ asset('public/assets/css/rtl/dark.css') }}" rel="stylesheet" />
		<link href="{{ asset('public/assets/css/rtl/skin-modes.css') }}" rel="stylesheet" />
		<link href="{{ asset('public/assets/css/rtl/animated.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/assets/css/rtl/sidemenu.css') }}" rel="stylesheet">
        <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet" />
        
        <link href="{{ asset('public/assets/css/rtl/dataTables.bootstrap5-rtl.css') }}" rel="stylesheet" />
		@else
		<link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('public/assets/css/style.css?v=0') }}" rel="stylesheet" />
		<link href="{{ asset('public/assets/css/dark.css') }}" rel="stylesheet" />
		<link href="{{ asset('public/assets/css/skin-modes.css') }}" rel="stylesheet" />
		<link href="{{ asset('public/assets/css/animated.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/assets/css/sidemenu.css') }}" rel="stylesheet">
        <link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet" />
        <link href="{{ asset('public/assets/plugins/datatables/DataTables/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
		@endif
		

		<!-- Style css -->
		

		<!-- Animate css -->
	

		<!-- P-scroll bar css-->
		

		<!---Icons css-->
		

		<!-- Simplebar css -->
		<link rel="stylesheet" href="{{ asset('public/assets/plugins/simplebar/css/simplebar.css') }}">

		<!-- INTERNAL Morris Charts css -->
		<link href="{{ asset('public/assets/plugins/morris/morris.css') }}" rel="stylesheet" />

		<!-- INTERNAL Select2 css -->
		<link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

		<!-- Data table css -->
		
		<link rel="stylesheet" href="{{ asset('public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
		<link href="{{ asset('public/assets/plugins/datatables/Responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />

	    <!-- Color Skin css -->
		<link id="theme" href="{{ asset('public/assets/colors/color1.css') }}" rel="stylesheet" type="text/css"/>

	    <!-- INTERNAL Switcher css -->
		<link href="{{ asset('public/assets/switcher/css/switcher.css') }}" rel="stylesheet"/>
		<link href="{{ asset('public/assets/switcher/demo.css') }}" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
		<style type="text/css">
			.reqfield{
				color: red;
			}
			.dark-menu .app-sidebar__logo{
			        background: #233646 !important;
			}
		</style>
		<script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{Config::get("mapdetail.key")}}&sensor=false&libraries=places'></script>
		<link href="//use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	</head>
	<body class="app sidebar-mini light-mode dark-header layout-fullwidth dark-menu">
		
		@include('admin.layout.header')
		<input type="hidden" name="url_path" id="url_path" value="{{url('/')}}">
        <input type="hidden" name="record" id="record" value="{{__('message.are you sure want to delete?')}}">
        <input type="hidden" name="more_lable" id="more_lable" value="{{__('message.More')}}">
        <input type="hidden" name="print_lable" id="print_lable" value="{{__('message.Print')}}">
        <input type="hidden" name="view_frq_lable" id="view_frq_lable" value="{{__('message.View FRQ')}}">
        <input type="hidden" name="name_for_lable" id="name_for_lable" value="{{__('message.Name')}}">
        <input type="hidden" name="phone_for_lable" id="phone_for_lable" value="{{__('message.Phone')}}">
        <input type="hidden" name="age_for_lable" id="age_for_lable" value="{{__('message.Age')}}">
        <input type="hidden" name="dob_for_lable" id="dob_for_lable" value="{{__('message.DOB')}}">
        <input type="hidden" name="relation_for_lable" id="relation_for_lable" value="{{__('message.Relation')}}">
        <input type="hidden" name="gender_for_lable" id="gender_for_lable" value="{{__('message.Gender')}}">
        <input type="hidden" name="add_for_lable" id="add_for_lable" value="{{__('message.Address')}}">
        <input type="hidden" name="house_no_lable" id="house_no_lable" value="{{__('message.House no')}}">
        <input type="hidden" name="landmark_lable" id="landmark_lable" value="{{__('message.Landmark')}}">
        <input type="hidden" name="pincode_lable" id="pincode_lable" value="{{__('message.Pincode')}}">
        <input type="hidden" name="admin_demo_msg" id="admin_demo_msg" value="{{__('message.admin_demo_msg')}}">
        <input type="hidden" name="pass_match_msg" id="pass_match_msg" value="{{__('message.Password and Confirm Password Must Be Same')}}">

        <input type="hidden" name="select_type_labal" id="select_type_labal" value="{{__('message.Select Type')}}">
        <input type="hidden" name="parameter_labal" id="parameter_labal" value="{{__('message.Parameter')}}">
        <input type="hidden" name="profile_labal" id="profile_labal" value="{{__('message.Profile')}}">
        <input type="hidden" name="select_test_labal" id="select_test_labal" value="{{__('message.Select Test')}}">
        <input type="hidden" name="delete_labal" id="delete_labal" value="{{__('message.Delete')}}">
        <input type="hidden" name="is_demo_flag" id="is_demo_flag" value="{{Session::get('is_demo')}}">
        <input type="hidden" id="view_report" value="{{__('message.View Report')}}">
         
        
		@include('admin.layout.sidebar')
		@yield('content')		
					</div>
				</div>
			</div>
		</div>
		<!--Footer-->
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center flex-row-reverse">
						<div class="col-md-12 col-sm-12 text-center">
							{{__("message.Copyright ©")}} {{date('Y')}} <a href="javascript:void0;">{{__("message.Freaktemplate")}}</a>. {{__("message.Designed with")}} <span class="fa fa-heart text-danger"></span> {{__("message.by")}} <a href="javascript:void0;"> {{__("message.Freaktemplate")}} </a> {{__("message.All rights reserved")}}
						</div>
					</div>
				</div>
			</footer>
		<!-- End Footer-->
			<!-- Back to top -->
			

		<a href="#top" id="back-to-top"><i class="fe fe-chevron-up"></i></a>

		<!-- Jquery js-->
		<script src="{{ asset('public/assets/js/jquery.min.js')}}"></script>

		<!-- Bootstrap5 js-->
		<script src="{{ asset('public/assets/plugins/bootstrap/popper.min.js') }}"></script>
		<script src="{{ asset('public/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

		<!--Othercharts js-->
		<script src="{{ asset('public/assets/plugins/othercharts/jquery.sparkline.min.js') }}"></script>

		<!-- Circle-progress js-->
		<script src="{{ asset('public/assets/js/circle-progress.min.js') }}"></script>

		<!-- Jquery-rating js-->
		<script src="{{ asset('public/assets/plugins/rating/jquery.rating-stars.js') }}"></script>

		<!--Sidemenu js-->
		<script src="{{ asset('public/assets/plugins/sidemenu/sidemenu.js') }}"></script>

		<!-- P-scroll js-->
		

		<!--INTERNAL Flot Charts js-->
		<script src="{{ asset('public/assets/plugins/flot/jquery.flot.js') }}"></script>
		<script src="{{ asset('public/assets/plugins/flot/jquery.flot.fillbetween.js') }}"></script>
		<script src="{{ asset('public/assets/plugins/flot/jquery.flot.pie.js') }}"></script>
		<script src="{{ asset('public/assets/js/dashboard.sampledata.js') }}"></script>
		<script src="{{ asset('public/assets/js/chart.flot.sampledata.js') }}"></script>

		<!-- INTERNAL Chart js -->
		<script src="{{ asset('public/assets/plugins/chart/chart.bundle.js') }}"></script>
		<script src="{{ asset('public/assets/plugins/chart/utils.js') }}"></script>

		<!-- INTERNAL Apexchart js -->
		<script src="{{ asset('public/assets/js/apexcharts.js') }}"></script>

		<!--INTERNAL Moment js-->
		<script src="{{ asset('public/assets/plugins/moment/moment.js') }}"></script>

		<!--INTERNAL Index js-->
		

		<!-- INTERNAL Data tables -->
		<script src="{{ asset('public/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
		<script src="{{ asset('public/assets/plugins/datatables/DataTables/js/jquery.dataTables.js') }}"></script>
		<script src="{{ asset('public/assets/plugins/datatables/DataTables/js/dataTables.bootstrap5.js') }}"></script>
		<script src="{{ asset('public/assets/plugins/datatables/Responsive/js/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('public/assets/plugins/datatables/Responsive/js/responsive.bootstrap5.min.js') }}"></script>

		<!-- INTERNAL Select2 js -->
		<script src="{{ asset('public/assets/plugins/select2/select2.full.min.js') }}"></script>
		<script src="{{ asset('public/assets/js/select2.js') }}"></script>

		<!-- Simplebar JS -->
		<script src="{{ asset('public/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>

		<!-- Rounded bar chart js-->
		<script src="{{ asset('public/assets/js/rounded-barchart.js') }}"></script>

		<!-- Custom js-->
		<script src="{{ asset('public/assets/js/custom.js') }}"></script>

		<!-- Switcher js -->
		<script src="{{ asset('public/assets/switcher/js/switcher.js')}}"></script>
		<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
		<script type="text/javascript" src="{{asset('public/admin.js?v=sadyutyfdg')}}"></script>

	</body>
</html>