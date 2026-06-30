@extends('admin.layout.index')
@section('title')
{{__("message.Dashboard")}}
@stop
@section('content')
<!--Page header-->
<div class="page-header">
   <div class="page-leftheader">
      <h4 class="page-title mb-0 text-primary">{{__("message.Dashboard")}}</h4>
   </div>
</div>
<?php
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return "#".random_color_part() . random_color_part() . random_color_part();
}

 ?>
<!--End Page header-->
<!-- Row-1 -->
<div class="row">
	<div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Sales")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$currency.number_format($totalsales,2,'.','')}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fa fa-usd fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Orders")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalorder}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fab fa-first-order fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Pending Orders")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$pendingorders}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-spinner fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Complete Orders")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$completeorder}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-tasks fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Category")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalcategory}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fab fa-accusoft fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total City")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalcity}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-city fa-2x"></i></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Users")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalusers}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-users fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Managers")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalmanager}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-user-tie fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Packages")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalpackage}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-cubes fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Parameters")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalprofile}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-stroopwafel fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Profiles")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalparameter}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-atom fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-6 col-xl-3">
      <div class="card" style="background-color: <?=random_color()?>;">
         <div class="card-body">
            <div class="d-flex no-block align-items-center">
               <div>
                  <h6 class="text-white">{{__("message.Total Popular Package")}}</h6>
                  <h2 class="text-white m-0 font-weight-bold">{{$totalpopular}}</h2>
               </div>
               <div class="ms-auto"> <span class="text-white display-6"><i class="fas fa-bowling-ball fa-2x"></i></span> </div>
            </div>
         </div>
      </div>
   </div>
   
   
</div>
<!-- End Row-1 -->
@endsection