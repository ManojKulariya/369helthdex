<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Azea - Admin Panel HTML template" name="description">
		<meta content="Spruko Private Limited" name="author">
		<meta name="keywords" content="admin, admin template, dashboard, admin dashboard, responsive, bootstrap, bootstrap 5, admin theme, admin themes, bootstrap admin template, scss, ui, crm, modern, flat">

		<!-- Title -->
		<title>@yield('title')</title>

		<!--Favicon -->
		<link rel="icon" href="https://spruko.com/demo/azea/Azea/assets/images/brand/favicon.ico" type="image/x-icon"/>

		<!--Bootstrap css -->
		<link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

		<!-- Style css -->
		<link href="{{ asset('public/assets/css/style.css?v=0') }}" rel="stylesheet" />
		<link href="{{ asset('public/assets/css/dark.css') }}" rel="stylesheet" />
		<link href="{{ asset('public/assets/css/skin-modes.css') }}" rel="stylesheet" />

		<!-- Animate css -->
		<link href="{{ asset('public/assets/css/animated.css') }}" rel="stylesheet" />

		<!--Sidemenu css -->
       <link href="{{ asset('public/assets/css/sidemenu.css') }}" rel="stylesheet">

		<!-- P-scroll bar css-->
		

		<!---Icons css-->
		<link href="{{ asset('public/assets/css/icons.css') }}" rel="stylesheet" />

		<!-- Simplebar css -->
		<link rel="stylesheet" href="{{ asset('public/assets/plugins/simplebar/css/simplebar.css') }}">

		<!-- INTERNAL Morris Charts css -->
		<link href="{{ asset('public/assets/plugins/morris/morris.css') }}" rel="stylesheet" />

		<!-- INTERNAL Select2 css -->
		<link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

		<!-- Data table css -->
		<link href="{{ asset('public/assets/plugins/datatables/DataTables/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
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
		</style>
		<link href="//use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	</head>
	<body class="app sidebar-mini light-mode dark-header layout-fullwidth dark-menu">
		<div class="switcher-wrapper">
			<div class="demo_changer">
				<div class="form_holder sidebar-right1">
					<div class="row">
						<div class="predefined_styles">
							
							<div class="swichermainleft">
								<h4>Theme Layout</h4>
								<div class="switch_section d-flex my-4">
									<ul class="switch-buttons row">
										<li class="col-md-6 mb-0">
											<button type="button" id="background-left1" class="bg-left1 wscolorcode1 button-image"></button>
											<span class="d-block">Light Theme</span>
										</li>
										<li class="col-md-6 mb-0">
											<button type="button" id="background-left2" class="bg-left2 wscolorcode1 button-image"></button>
											<span class="d-block">Dark Theme</span>
										</li>
									</ul>
								</div>
							</div>
							<div class="swichermainleft">
								<h4>Header Styles Mode</h4>
								<div class="switch_section d-flex my-4">
									<ul class="switch-buttons row">
										<li class="col-md-6 light-bg">
											<button type="button" id="background1" class="bg1 wscolorcode1 button-image"></button>
											<span class="d-block">Light Header</span>
										</li>
										<li class="col-md-6">
											<button type="button" id="background2" class="bg2 wscolorcode1 button-image"></button>
											<span class="d-block">Color Header</span>
										</li>
										<li class="col-md-6 d-block mx-auto dark-bg">
											<button type="button" id="background3" class="bg3 wscolorcode1 button-image"></button>
											<span class="d-block">Dark Header</span>
										</li>
										<li class="col-md-6 d-block mx-auto">
											<button type="button" id="background11" class="bg8 wscolorcode1 button-image"></button>
											<span class="d-block">Gradient Header</span>
										</li>
									</ul>
								</div>
							</div>
							<div class="swichermainleft">
								<h4>Leftmenu Styles Mode</h4>
								<div class="switch_section d-flex my-4">
									<ul class="switch-buttons row">
										<li class="col-md-6 mb-4">
											<button type="button" id="background4" class="bg4 wscolorcode1 button-image"></button>
											<span class="d-block">Light Menu</span>
										</li>
										<li class="col-md-6 mb-4">
											<button type="button" id="background5" class="bg5 wscolorcode1 button-image"></button>
											<span class="d-block">Color Menu</span>
										</li>
										<li class="col-md-6 mb-0 d-block mx-auto dark-bgmenu">
											<button type="button" id="background6" class="bg6 wscolorcode1 button-image"></button>
											<span class="d-block">Dark Menu</span>
										</li>
										<li class="col-md-6 mb-0 d-block mx-auto">
											<button type="button" id="background10" class="bg7 wscolorcode1 button-image"></button>
											<span class="d-block">Gradient Menu</span>
										</li>
									</ul>
								</div>
							</div>
							<div class="swichermainleft">
								<h4>Layout-width Styles Mode</h4>
								<div class="switch_section d-flex my-4">
									<ul class="switch-buttons row">
										<li class="col-md-6 mb-4">
											<button type="button" id="background14" class="bg-layf wscolorcode1 button-image"></button>
											<span class="d-block">Full-Width</span>
										</li>
										<li class="col-md-6 mb-4">
											<button type="button" id="background15" class="bg-laybx wscolorcode1 button-image"></button>
											<span class="d-block">Boxed</span>
										</li>
									</ul>
								</div>
							</div>
							<div class="swichermainleft">
								<h4>Side-menu layout Styles Mode</h4>
								<div class="switch_section d-flex my-4">
									<ul class="switch-buttons row">
										<li class="col-md-6 mb-4">
											<button type="button" id="background18" class="bg-sided button-image wscolorcode1 default-menu" data-sidetheme="../../assets/css/sidemenu.css"></button>
											<span class="d-block">Default</span>
										</li>
										<li class="col-md-6 mb-4">
											<button type="button" id="background19" class="bg-sideictxt button-image wscolorcode1 icontext-menu" data-sidetheme="../../assets/css/sidemenu-icontext.css"></button>
											<span class="d-block">Icon-with Text</span>
										</li>
										<li class="col-md-6 d-block mx-auto">
											<button type="button" id="background20" class="bg-sideicon button-image wscolorcode1 sideicon-menu" data-sidetheme="../../assets/css/sidemenu-icon.css"></button>
											<span class="d-block">Icon</span>
										</li>
									</ul>
								</div>
							</div>
							<div class="swichermainleft">
								<h4>Layout Positions Mode</h4>
								<div class="switch_section d-flex my-4">
									<ul class="switch-buttons row">
										<li class="col-md-6 mb-4">
											<button type="button" id="background16" class="bg-left1 wscolorcode1 button-image"></button>
											<span class="d-block">Fixed</span>
										</li>
										<li class="col-md-6 mb-4">
											<button type="button" id="background17" class="bg-left1 wscolorcode1 button-image"></button>
											<span class="d-block">Scrollable</span>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@include('manager.layout.header')
		<input type="hidden" name="url_path" id="url_path" value="{{url('/')}}">
        <input type="hidden" name="record" id="record" value="{{__('message.are you sure want to delete?')}}">
		@include('manager.layout.sidebar')
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
		<script type="text/javascript" src="{{asset('public/manager.js?v=sadyutyfdg')}}"></script>
		<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Set up variables using Blade to render the values into the script
    const pusherKey = "{{ config('broadcasting.connections.pusher.key') }}";
    const pusherCluster = "{{ config('broadcasting.connections.pusher.options.cluster') }}";

    // Initialize Pusher
    Pusher.logToConsole = true;
    var pusher = new Pusher(pusherKey, {
        cluster: pusherCluster,
        useTLS: true // Use secure connection
    });

    // Subscribe to the channel
    var channel = pusher.subscribe('test-order-channel');

    // Listen for the event
    channel.bind('test-order-received', function(data) {
        alert('New test order received!');
        // Additional code can go here to handle the data
    });
</script>


	</body>
</html>