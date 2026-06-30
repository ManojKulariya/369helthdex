<!-- Page -->
<div class="page">
<div class="page-main">
    <style>
        .sidebar-container {
   height: 100%; /* Set a fixed height for the container */
   overflow-y: auto; /* Enable vertical scrolling if content overflows */
   padding-bottom: 20px; /* Add some padding to the bottom to ensure scroll bar visibility */
}
    </style>
<!--aside open-->
<aside class="app-sidebar">
    
   <div class="sidebar-container"> 
   <div class="app-sidebar__logo">
      <a class="header-brand" href="{{ route('admin-dashboard') }}">
      <img src="{{Session::get('logo')}}" class="header-brand-img desktop-lgo" alt="logo">
      <img src="{{Session::get('logo')}}" class="header-brand-img dark-logo" alt="logo">
      <img src="{{Session::get('favicon')}}" class="header-brand-img mobile-logo" alt="logo">
      <img src="{{Session::get('favicon')}}" class="header-brand-img darkmobile-logo" alt="logo">
      </a>
   </div>
   <ul class="side-menu app-sidebar3">
       
      <li class="side-item side-item-category">{{__("message.Main")}}</li>
      <li class="slide">
         <a class="side-menu__item"  href="{{ route('transport-admin-dashboard') }}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
               <g>
                  <path d="M0,0h24v24H0V0z" fill="none"/>
               </g>
               <g>
                  <g>
                     <path d="M3,11h8V3H3V11z M5,5h4v4H5V5z"/>
                     <path d="M13,3v8h8V3H13z M19,9h-4V5h4V9z"/>
                     <path d="M3,21h8v-8H3V21z M5,15h4v4H5V15z"/>
                     <polygon points="18,13 16,13 16,16 13,16 13,18 16,18 16,21 18,21 18,18 21,18 21,16 18,16"/>
                  </g>
               </g>
            </svg>
            <span class="side-menu__label">{{__("message.Dashboard")}}</span>
         </a>
      </li>
      <li class="side-item side-item-category">{{__("message.Parcel")}}</li>
      <li class="slide">
         <a class="side-menu__item"  href="{{ route('upcomming-parcel') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cpu-fill side-menu__icon" viewBox="0 0 16 16">
               <path d="M6.5 6a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
               <path d="M5.5.5a.5.5 0 0 0-1 0V2A2.5 2.5 0 0 0 2 4.5H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2A2.5 2.5 0 0 0 4.5 14v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14a2.5 2.5 0 0 0 2.5-2.5h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14A2.5 2.5 0 0 0 11.5 2V.5a.5.5 0 0 0-1 0V2h-1V.5a.5.5 0 0 0-1 0V2h-1V.5a.5.5 0 0 0-1 0V2h-1V.5zm1 4.5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5v-3A1.5 1.5 0 0 1 6.5 5z"/>
            </svg>
            <span class="side-menu__label"> {{__("message.Upcomming Parcel")}} </span>
         </a>
      </li>
      <li class="slide">
         <a class="side-menu__item"  href="{{ route('all-parcel') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cpu-fill side-menu__icon" viewBox="0 0 16 16">
               <path d="M6.5 6a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
               <path d="M5.5.5a.5.5 0 0 0-1 0V2A2.5 2.5 0 0 0 2 4.5H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2A2.5 2.5 0 0 0 4.5 14v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14a2.5 2.5 0 0 0 2.5-2.5h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14A2.5 2.5 0 0 0 11.5 2V.5a.5.5 0 0 0-1 0V2h-1V.5a.5.5 0 0 0-1 0V2h-1V.5a.5.5 0 0 0-1 0V2h-1V.5zm1 4.5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5v-3A1.5 1.5 0 0 1 6.5 5z"/>
            </svg>
            <span class="side-menu__label"> {{__("message.All Parcel")}} </span>
         </a>
      </li>
      <li class="side-item side-item-category">{{__("message.Main")}}</li>
      
      <li class="slide">
         <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill side-menu__icon" viewBox="0 0 16 16">
               <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
            </svg>
            <span class="side-menu__label">{{__("message.Users")}}</span><i class="angle fe fe-chevron-right"></i>
         </a>
         <ul class="slide-menu">
            <li><a href="{{ route('transport-manager') }}" class="slide-item"> Branch User</a></li>
            <li><a href="{{ route('transport-lab-user') }}" class="slide-item"> {{__("message.Lab Users")}}</a></li>
         </ul>
      </li>
     
     
    
   </ul>
   </div>
</aside>
<!--aside closed-->