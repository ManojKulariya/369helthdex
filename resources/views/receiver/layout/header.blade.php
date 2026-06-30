<!-- App-Content -->
<div class="app-content main-content">
<div class="side-app">
<!--app header-->
<div class="app-header header main-header1">
   <div class="container-fluid" style="padding-right: 0px;">
      <div class="d-flex">
         <a class="header-brand" href="javascript:void()">
         <img src="{{Session::get('logo')}}" class="header-brand-img desktop-lgo" alt="logo">
         <img src="{{Session::get('logo')}}" class="header-brand-img dark-logo" alt="logo">
         <img src="{{Session::get('favicon')}}" class="header-brand-img mobile-logo" alt="logo">
         <img src="{{Session::get('favicon')}}" class="header-brand-img darkmobile-logo" alt="logo">
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
                                 <div class="notifyimg  text-primary bg-primary-transparent border-primary"> <i class="fa fa-envelope"></i> </div>
                                 <div>
                                    <span class="fs-13">{{__("message.message_sent")}}</span>
                                    <div class="small text-muted">{{__("message.3_hours")}}</div>
                                 </div>
                              </a>
                              <a href="email-inbox.html" class="dropdown-item border-bottom d-flex ps-4">
                                 <div class="notifyimg  text-secondary bg-secondary-transparent border-secondary"> <i class="fa fa-shopping-cart"></i></div>
                                 <div>
                                    <span class="fs-13">{{__("message.order_placed")}}</span>
                                    <div class="small text-muted">{{__("message.5_hours")}}</div>
                                 </div>
                              </a>
                              <a href="email-inbox.html" class="dropdown-item border-bottom d-flex ps-4">
                                 <div class="notifyimg  text-danger bg-danger-transparent border-danger"> <i class="fa fa-gift"></i> </div>
                                 <div>
                                    <span class="fs-13">{{__("message.event_started")}}</span>
                                    <div class="small text-muted">{{__("message.45 mintues ago")}}</div>
                                 </div>
                              </a>
                              <a href="email-inbox.html" class="dropdown-item border-bottom d-flex ps-4 mb-2">
                                 <div class="notifyimg  text-success  bg-success-transparent border-success"> <i class="fa fa-windows"></i> </div>
                                 <div>
                                    <span class="fs-13">{{__("message.Your Admin lanuched")}}</span>
                                    <div class="small text-muted">{{__("message.1 daya ago")}}</div>
                                 </div>
                              </a>
                           </div>
                           <div class=" text-center p-2">
                              <a href="email-inbox.html" class="btn btn-primary btn-md fs-13 btn-block">{{__("message.View All")}}</a>
                           </div>
                        </div>
                     </div>
                     <div class="dropdown profile-dropdown d-flex">
                        <a href="javascript:void0;" class="nav-link pe-0 leading-none" data-bs-toggle="dropdown">
                        <span class="header-avatar1">
                        <img src="{{ url('/').'/storage/app/public/profile'.'/'.Auth::user()->profile_pic}}" alt="{{Auth::user()->name}}" class="avatar avatar-md brround">
                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
                           <!--<a class="dropdown-item d-flex" href="{{ route('admin-profile') }}">-->
                           <!--   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle  me-2" viewBox="0 0 16 16">-->
                           <!--      <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>-->
                           <!--      <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>-->
                           <!--   </svg>-->
                           <!--   <div class="fs-13">{{__("message.Profile")}}</div>-->
                           <!--</a>-->
                           <!--<a class="dropdown-item d-flex" href="{{ route('admin-changepassword') }}">-->
                           <!--   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key me-2" viewBox="0 0 16 16">-->
                           <!--      <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>-->
                           <!--      <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>-->
                           <!--   </svg>-->
                           <!--  {{__("message.Change Password")}}-->
                           <!--</a>-->
                           <a class="dropdown-item d-flex" href="{{route('receiver-logout')}}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right me-2" viewBox="0 0 16 16">
                                 <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                 <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
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