@extends('front.layout')
@section('title')
  {{__("message.Family Members")}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('my-family-member')}}"/>
<meta property="og:title" content="{{__('message.site_name')}}"/>
<meta property="og:image" content="{{asset('public/img/').'/'.$setting->logo}}"/>
<meta property="og:image:width" content="250px"/>
<meta property="og:image:height" content="250px"/>
<meta property="og:site_name" content="{{__('message.site_name')}}"/>
<meta property="og:description" content="{{__('message.meta_description')}}"/>
<meta property="og:keyword" content="{{__('message.meta_keyword')}}"/>
<link rel="shortcut icon" href="{{asset('public/img/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')
@php
    /* Display-only summary derived from the existing $myfamily collection. */
    $hdFamTotal = count($myfamily);
    $hdFamAdults = 0;
    $hdFamChildren = 0;
    $hdFamSeniors = 0;
    foreach ($myfamily as $hdFamRow) {
        if (is_numeric($hdFamRow->age)) {
            $hdFamAge = (int) $hdFamRow->age;
            if ($hdFamAge < 18) {
                $hdFamChildren++;
            } elseif ($hdFamAge >= 60) {
                $hdFamSeniors++;
            } else {
                $hdFamAdults++;
            }
        }
    }
@endphp
<section class="hd-dash-section">
    <div class="auto-container">
        <!-- Page head -->
        <div class="hd-dash-head">
            <nav class="hd-dash-breadcrumb" aria-label="Breadcrumb">
                <a href="{{route('home')}}">{{__('message.Home')}}</a>
                <i data-lucide="chevron-right"></i>
                <a href="{{route('dashboard')}}">{{__('message.Dashboard')}}</a>
                <i data-lucide="chevron-right"></i>
                <span>{{__("message.My Family Members")}}</span>
            </nav>
            <h1 class="hd-dash-title">{{__("message.My Family Members")}}</h1>
        </div>

        <div class="hd-dash-layout">
            <!-- Sidebar -->
            <aside class="hd-dash-sidebar" id="hdDashSidebar">
                <div class="hd-dash-profile">
                    <?php
                          if(Auth::user()->profile_pic!=""){
                              $path=url('/')."/storage/profile"."/".Auth::user()->profile_pic;
                          }
                          else{
                              $path=asset('public/img/default_user.png');
                          }
                          ?>
                    <div class="hd-dash-avatar">
                        <img src="{{$path}}" alt="{{Auth::user()->name}}">
                    </div>
                    <h3>{{Auth::user()->name}}</h3>
                    <p><i data-lucide="mail"></i>{{Auth::user()->email}}</p>
                </div>

                <button type="button" class="hd-dash-nav-toggle" id="hdDashNavToggle" aria-expanded="false" aria-controls="hdDashNav">
                    <i data-lucide="menu"></i>
                    Account Menu
                </button>

                <nav class="hd-dash-nav" id="hdDashNav">
                    <ul>
                       <li><a href="{{route('dashboard')}}"><i data-lucide="layout-dashboard"></i>{{__("message.Dashboard")}}</a></li>
                       <li><a href="{{route('my-family-member')}}" class="current"><i data-lucide="users"></i>{{__("message.My Family Members")}}</a></li>
                       <li><a href="{{route('my-addresses')}}"><i data-lucide="map-pin"></i>{{__("message.My Addresses")}}</a></li>
                       <li><a href="{{route('my-home')}}"><i data-lucide="house"></i>Home Visit</a></li>
                       <li><a href="{{route('my_prescription')}}"><i data-lucide="file-text"></i>My Prescription</a></li>
                       <li><a href="{{route('user-profile')}}"><i data-lucide="user-round"></i>{{__("message.My Profile")}}</a></li>
                       <!-- <li><a href="{{route('user-change-password')}}"><i data-lucide="lock-keyhole"></i>{{__("message.Change Password")}}</a></li> -->
                       <li><a href="{{route('user-logout')}}" class="hd-dash-logout"><i data-lucide="log-out"></i>{{__("message.Logout")}}</a></li>
                    </ul>
                </nav>
            </aside>

            <!-- Main -->
            <main class="hd-dash-main">
                @if(Session::has('message'))
                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                    </div>
                    @endif

                <!-- Header row: title + add button -->
                <div class="hd-fam-header">
                    <div class="hd-fam-header-text">
                        <h2>{{__("message.My Family Members")}}</h2>
                        <p>Manage your family's healthcare profiles in one place.</p>
                    </div>
                    <button data-toggle="modal" data-target="#addmember" class="premium-btn premium-btn-primary">
                        <i data-lucide="user-round-plus"></i>
                        {{__("message.Add Family Members")}}
                    </button>
                </div>

                <!-- Summary (derived from existing data) -->
                <div class="hd-dash-stats">
                    <div class="hd-dash-stat">
                        <span class="hd-dash-stat-icon"><i data-lucide="users"></i></span>
                        <div class="hd-dash-stat-value" data-hd-counter>{{ $hdFamTotal }}</div>
                        <div class="hd-dash-stat-label">Total Family Members</div>
                    </div>
                    <div class="hd-dash-stat">
                        <span class="hd-dash-stat-icon"><i data-lucide="user-round"></i></span>
                        <div class="hd-dash-stat-value" data-hd-counter>{{ $hdFamAdults }}</div>
                        <div class="hd-dash-stat-label">Adults</div>
                    </div>
                    <div class="hd-dash-stat">
                        <span class="hd-dash-stat-icon"><i data-lucide="baby"></i></span>
                        <div class="hd-dash-stat-value" data-hd-counter>{{ $hdFamChildren }}</div>
                        <div class="hd-dash-stat-label">Children</div>
                    </div>
                    <div class="hd-dash-stat">
                        <span class="hd-dash-stat-icon"><i data-lucide="heart-handshake"></i></span>
                        <div class="hd-dash-stat-value" data-hd-counter>{{ $hdFamSeniors }}</div>
                        <div class="hd-dash-stat-label">Senior Citizens</div>
                    </div>
                </div>

                <!-- Members -->
                @if(count($myfamily)>0)
                <div class="hd-fam-grid">
                    @foreach($myfamily as $ma)
                    <div class="hd-fam-card">
                        <div class="hd-fam-top">
                            <span class="hd-fam-avatar">{{ strtoupper(substr(trim((string) $ma->name), 0, 1)) ?: '?' }}</span>
                            <div class="hd-fam-id">
                                <h3>{{$ma->name}}</h3>
                                <span class="hd-fam-relation">{{$ma->relation}}</span>
                            </div>
                        </div>

                        <ul class="hd-fam-meta">
                            <li><i data-lucide="user-round"></i>{{$ma->gender}}</li>
                            @if($ma->age != '')
                            <li><i data-lucide="hash"></i>{{$ma->age}} Years</li>
                            @endif
                            @if($ma->mobile_no != '')
                            <li><i data-lucide="phone"></i>{{$ma->mobile_no}}</li>
                            @endif
                            @if($ma->email != '')
                            <li><i data-lucide="mail"></i>{{$ma->email}}</li>
                            @endif
                            @if($ma->dob != '')
                            <li><i data-lucide="cake"></i>{{$ma->dob}}</li>
                            @endif
                        </ul>

                        <div class="hd-fam-actions">
                            <button type="button" class="hd-fam-btn hd-fam-btn-edit" data-toggle="modal" data-target="#editmember" onclick="editmember('{{$ma->id}}')">
                                <i data-lucide="pencil"></i>
                                {{__("message.Edit")}}
                            </button>
                            <button type="submit" class="hd-fam-btn hd-fam-btn-delete" onclick="deletemember('{{$ma->id}}')">
                                <i data-lucide="trash-2"></i>
                                {{__("message.Delete")}}
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="hd-dash-card hd-fam-empty">
                    <div class="hd-fam-empty-icon"><i data-lucide="users"></i></div>
                    <h3>No family members added yet.</h3>
                    <p>Add your family members to book tests and manage their health in one place.</p>
                    <button data-toggle="modal" data-target="#addmember" class="premium-btn premium-btn-primary">
                        <i data-lucide="user-round-plus"></i>
                        {{__("message.Add Family Members")}}
                    </button>
                </div>
                @endif
            </main>
        </div>
    </div>
</section>
<div class="modal" id="addmember">
   <div class="modal-dialog modal-lg">
      <div class="modal-content ">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__("message.Add New Family Member")}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{route('update-user-family')}}" method="post" class="registration-form">
         <!-- Modal body -->
         <div class="modal-body">

               {{csrf_field()}}
               <div class="row clearfix">
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Relation")}}</label>
                     <select  name="relation" required="">
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
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Name")}}</label>
                     <input type="text" name="name"  placeholder="{{__('message.Enter Name')}}" required="">
                  </div>
                  <!--<div class="col-lg-4 col-md-12 col-sm-12 form-group">-->
                  <!--   <label>{{__("message.email")}}</label>-->
                  <!--   <input type="email" name="email"  placeholder="{{__('message.Enter Email')}}" required="">-->
                  <!--</div>-->
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Phone")}}</label>
                     <input type="text" name="phone"  placeholder="{{__('message.Enter Phone')}}" required="">
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Age")}}</label>
                     <input type="text" name="age"  placeholder="{{__('message.Enter Age')}}" required="">
                  </div>
                  <!--<div class="col-lg-4 col-md-6 col-sm-12 form-group">-->
                  <!--   <label>{{__("message.DOB")}}</label>-->
                  <!--   <input type="date" name="dob"   required="">-->
                  <!--</div>-->
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Gender")}}</label>
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="gender" id="gender_1" value="Male" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__("message.Male")}}</span>
                           </label>
                        </div>
                     </div>
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="gender" id="gender_2" value="Female" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__("message.Female")}}</span>
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
         <button type="submit" class="btn btn-success" >{{__("message.Add Member")}}</button>
         <button type="button" class="btn btn-danger" data-dismiss="modal" >{{__("message.Close")}}</button>
         </div>
         </form>
      </div>
   </div>
</div>

<div class="modal" id="editmember">
   <div class="modal-dialog modal-lg">
      <div class="modal-content ">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{__("message.Edit Family Member")}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{route('update-user-family')}}" method="post" class="registration-form">
         <!-- Modal body -->
         <div class="modal-body">
              <input type="hidden" name="id" id="edit_id" >
               {{csrf_field()}}
               <div class="row clearfix">
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Relation")}}</label>
                     <select  name="relation" id="edit_relation" required="">
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
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Name")}}</label>
                     <input type="text" name="name"  id="name" placeholder="{{__('message.Enter Name')}}" required="">
                  </div>
                  <!--<div class="col-lg-4 col-md-12 col-sm-12 form-group">-->
                  <!--   <label>{{__("message.email")}}</label>-->
                  <!--   <input type="email" name="email" id="email" placeholder="{{__('message.Enter Email')}}" required="">-->
                  <!--</div>-->
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Phone")}}</label>
                     <input type="text" name="phone"  id="phone" placeholder="{{__('message.Enter Phone')}}" required="">
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Age")}}</label>
                     <input type="text" name="age"  id="age" placeholder="{{__('message.Enter Age')}}" required="">
                  </div>
                  <!--<div class="col-lg-4 col-md-6 col-sm-12 form-group">-->
                  <!--   <label>{{__("message.DOB")}}</label>-->
                  <!--   <input type="date" name="dob" id="dob"  required="">-->
                  <!--</div>-->
                  <div class="col-lg-4 col-md-6 col-sm-12 form-group">
                     <label>{{__("message.Gender")}}</label>
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="gender" id="edit_gender_1" value="Male" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__("message.Male")}}</span>
                           </label>
                        </div>
                     </div>
                     <div class="custom-check-box">
                        <div class="custom-controls-stacked">
                           <label class="custom-control material-checkbox">
                           <input type="radio" name="gender" id="edit_gender_2" value="Female" class="material-control-input">
                           <span class="material-control-indicator"></span>
                           <span class="description">{{__("message.Female")}}</span>
                           </label>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
         <button type="submit" class="btn btn-success" >{{__("message.Update Member")}}</button>
         <button type="button" class="btn btn-danger" data-dismiss="modal" >{{__("message.Close")}}</button>
         </div>
         </form>
      </div>
   </div>
</div>
@stop
@section('footer')
@stop
