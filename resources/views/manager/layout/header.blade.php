<!-- App-Content -->
<div class="app-content main-content">
<div class="side-app">
<!--app header-->
<div class="app-header header main-header1">
   <div class="container-fluid" style="padding-right: 0px;">
      <div class="d-flex">
         <a class="header-brand" href="index.html">
         <img src="{{ asset('public/assets/images/brand/logo.png') }}" class="header-brand-img desktop-lgo" alt="Azea logo">
         <img src="{{ asset('public/assets/images/brand/logo1.png') }}" class="header-brand-img dark-logo" alt="Azea logo">
         <img src="{{ asset('public/assets/images/brand/favicon.png') }}" class="header-brand-img mobile-logo" alt="Azea logo">
         <img src="{{ asset('public/assets/images/brand/favicon1.png') }}" class="header-brand-img darkmobile-logo" alt="Azea logo">
         </a>
         <div class="app-sidebar__toggle d-flex" data-bs-toggle="sidebar">
            <a class="open-toggle" href="javascript:void0;">
               <svg xmlns="http://www.w3.org/2000/svg" class="feather feather-align-left header-icon" height="24" viewBox="0 0 24 24" width="24">
                  <path d="M0 0h24v24H0V0z" fill="none"/>
                  <path d="M3 19h18v2H3zM3 7h12v2H3zm0-4h18v2H3zm0 12h12v2H3zm0-4h18v2H3z"/>
               </svg>
            </a>
         </div>
         <div class="d-flex order-lg-2 ms-auto main-header-end">
            <button  class="navbar-toggler navresponsive-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="true" aria-label="Toggle navigation">
            <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
            </button>
            <div class="navbar navbar-expand-lg navbar-collapse responsive-navbar p-0">
               <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                  <div class="d-flex order-lg-2">
                     <div class="dropdown header-notify d-flex">
                        <a class="nav-link icon" data-bs-toggle="dropdown">
                           <svg xmlns="http://www.w3.org/2000/svg" class="header-icon" height="24" viewBox="0 0 24 24" width="24">
                              <path d="M0 0h24v24H0V0z" fill="none"/>
                              <path d="M12 6.5c-2.49 0-4 2.02-4 4.5v6h8v-6c0-2.48-1.51-4.5-4-4.5z" opacity=".3"/>
                              <path d="M18 16v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6zm-4 5c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2z"/>
                           </svg>
                           <span class="pulse "></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow  animated">
                           <div class="dropdown-header">
                              <h6 class="mb-0">{{__("message.notifications")}}</h6>
                              <span class="badge fs-10 bg-secondary br-7 ms-auto">{{__("message.new")}}</span>
                           </div>
                           <div class="notify-menu">
                              <a href="email-inbox.html" class="dropdown-item border-bottom d-flex ps-4">
                                 <div class="notifyimg  text-secondary bg-secondary-transparent border-secondary"> <i class="fa fa-shopping-cart"></i></div>
                                 <div>
                                    <span class="fs-13">{{__("message.order_placed")}}</span>
                                    <div class="small text-muted">{{__("message.5_hours")}}</div>
                                 </div>
                              </a>
                           </div>
                        </div>
                     </div>
                     <div class="dropdown profile-dropdown d-flex">
                        <a href="javascript:void0;" class="nav-link pe-0 leading-none" data-bs-toggle="dropdown">
                        <span class="header-avatar1">
                        <img src="{{ env('APP_URL').'storage/app/public/profile'.'/'.Auth::user()->profile_pic}}" alt="{{Auth::user()->name}}" class="avatar avatar-md brround">
                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
                           <div class="text-center">
                              <div class="text-center user pb-0 font-weight-bold">{{Auth::user()->name}}</div>
                              <!-- <span class="text-center user-semi-title">Web Designer</span> -->
                              <div class="dropdown-divider"></div>
                           </div>
                           <a class="dropdown-item d-flex" href="{{ route('manager-profile') }}">
                              <svg class="header-icon me-2" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                 <path d="M0 0h24v24H0V0z" fill="none"></path>
                                 <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.51.88 4.93 1.78C15.57 19.36 13.86 20 12 20s-3.57-.64-4.93-1.72zm11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6zm0 5c-.83 0-1.5-.67-1.5-1.5S11.17 8 12 8s1.5.67 1.5 1.5S12.83 11 12 11z"></path>
                              </svg>
                              <div class="fs-13">{{__("message.Profile")}}</div>
                           </a>
                           <a class="dropdown-item d-flex" href="{{ route('manager-changepassword') }}">
                              <svg class="header-icon me-2" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                 <path d="M0 0h24v24H0V0z" fill="none"/>
                                 <path d=""/>
                              </svg>
                              <div class="fs-13">{{__("message.Change Password")}}</div>
                           </a>
                           <a class="dropdown-item d-flex" href="{{route('manager-logout')}}">
                              <svg class="header-icon me-2" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24">
                                 <g>
                                    <rect fill="none" height="24" width="24"/>
                                 </g>
                                 <g>
                                    <path d="M11,7L9.6,8.4l2.6,2.6H2v2h10.2l-2.6,2.6L11,17l5-5L11,7z M20,19h-8v2h8c1.1,0,2-0.9,2-2V5c0-1.1-0.9-2-2-2h-8v2h8V19z"/>
                                 </g>
                              </svg>
                              <div class="fs-13">{{__("message.Sign Out")}}</div>
                           </a>
                        </div>
                     </div>
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--/app header-->