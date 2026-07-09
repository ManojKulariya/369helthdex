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
      <img src="{{asset('public/img').'/'.$setting->logo}}" class="header-brand-img desktop-lgo" alt="logo">
      <img src="{{asset('public/img').'/'.$setting->logo}}" class="header-brand-img dark-logo" alt="logo">
      <img src="{{asset('public/img').'/'.$setting->favicon}}" class="header-brand-img mobile-logo" alt="logo">
      <img src="{{asset('public/img').'/'.$setting->favicon}}" class="header-brand-img darkmobile-logo" alt="logo">
      </a>
   </div>
   <div class="adm-sidebar-search">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
      <input type="text" id="admSidebarSearch" placeholder="Quick find menu…" autocomplete="off">
   </div>
   <ul class="side-menu app-sidebar3">

      <li class="side-item side-item-category">{{__("message.Main")}}</li>
      <li class="slide">
         <a class="side-menu__item"  href="{{ route('admin-dashboard') }}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
            <span class="side-menu__label">{{__("message.Dashboard")}}</span>
         </a>
      </li>
      <li class="side-item side-item-category">{{__("message.Sales")}}</li>
      <li class="slide">
         <a class="side-menu__item"  href="{{ route('admin-orders') }}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            <span class="side-menu__label"> {{__("message.Orders")}} </span>
         </a>
      </li>
      <li class="side-item side-item-category">{{__("message.Management")}}</li>
      <li class="slide">
         <a class="side-menu__item"  href="{{ route('complaints') }}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <span class="side-menu__label">{{__("message.Feedback_Complaints")}} </span>
         </a>
      </li>
      <li class="slide">
         <a class="side-menu__item"  href="{{ route('callback') }}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <span class="side-menu__label">{{__("message.Call_Back_Requests")}} </span>
         </a>
      </li>
      <li class="slide">
         <a class="side-menu__item"  href="{{ route('user_prescription') }}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M9 15h6"/><path d="M12 12v6"/></svg>
            <span class="side-menu__label">{{__("message.User Prescription")}} </span>
         </a>
      </li>
            <li class="slide">
         <a class="side-menu__item"  href="{{ route('application') }}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            <span class="side-menu__label">{{__("message.Application")}} </span>
         </a>
      </li>
       <li class="slide">
         <a class="side-menu__item"  href="{{ route('admin-subcategory') }}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span class="side-menu__label"> {{__("message.Category")}} </span>
         </a>
      </li>
       <li class="slide">
         <a class="side-menu__item"  href="{{ route('admin-city') }}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span class="side-menu__label"> {{__("message.City")}} </span>
         </a>
      </li>
      <!--<li class="slide">-->
      <!--   <a class="side-menu__item"  href="{{ route('admin-discount') }}">-->
      <!--      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cpu-fill side-menu__icon" viewBox="0 0 16 16">-->
      <!--         <path d="M6.5 6a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>-->
      <!--         <path d="M5.5.5a.5.5 0 0 0-1 0V2A2.5 2.5 0 0 0 2 4.5H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2v1H.5a.5.5 0 0 0 0 1H2A2.5 2.5 0 0 0 4.5 14v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14h1v1.5a.5.5 0 0 0 1 0V14a2.5 2.5 0 0 0 2.5-2.5h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14v-1h1.5a.5.5 0 0 0 0-1H14A2.5 2.5 0 0 0 11.5 2V.5a.5.5 0 0 0-1 0V2h-1V.5a.5.5 0 0 0-1 0V2h-1V.5a.5.5 0 0 0-1 0V2h-1V.5zm1 4.5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5v-3A1.5 1.5 0 0 1 6.5 5z"/>-->
      <!--      </svg>-->
      <!--      <span class="side-menu__label"> {{__("message.Discounts")}} </span>-->
      <!--   </a>-->
      <!--</li>-->
      
      <li class="slide">
         <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
            <span class="side-menu__label">{{__("message.Lab Components")}}</span><svg class="angle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
         </a>
         <ul class="slide-menu">
            <li><a href="{{ route('parameter_get') }}" class="slide-item"> {{__("message.Parameters")}}</a></li>
            <li><a href="{{ route('profiles') }}" class="slide-item"> {{__("message.Profiles")}}</a></li>
            <li><a href="{{ route('show-package') }}" class="slide-item"> {{__("message.Packages")}}</a></li>
            <li><a href="{{ route('show-sample') }}" class="slide-item"> Sample Type</a></li>
            <!--<li><a href="{{ route('popular-package') }}" class="slide-item"> {{__("message.Popular Package")}}</a></li>-->
         </ul>
      </li>
      <li class="slide">
         <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span class="side-menu__label">{{__("message.Users")}}</span><svg class="angle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
         </a>
         <ul class="slide-menu">
            <li><a href="{{ route('manager') }}" class="slide-item"> Branch User</a></li>
            <li><a href="{{ route('sampleuser') }}" class="slide-item"> SampleBoy User</a></li>
            <li><a href="{{ route('user') }}" class="slide-item"> {{__("message.Site Users")}}</a></li>
         </ul>
      </li>
      <li class="slide is-expanded">
         <a class="side-menu__item" href="{{route('show-contact')}}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22 6 12 13 2 6"/></svg>
            <span class="side-menu__label">{{__("message.Contact Us")}}</span>
         </a>
      </li>
      <li class="side-item side-item-category">{{__("message.Marketing")}}</li>
      <li class="slide">
         <a class="side-menu__item"  href="{{ route('admin-coupon') }}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M9 9h.01"/><path d="m15 9-6 6"/><path d="M15 15h.01"/></svg>
            <span class="side-menu__label">{{__("message.Coupon")}} </span>
         </a>
      </li>
      <li class="slide">
         <a class="side-menu__item"  href="{{ route('admin-offer') }}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m15 9-6 6"/><path d="M9 9h.01"/><path d="M15 15h.01"/></svg>
            <span class="side-menu__label">{{__("message.Offers")}} </span>
         </a>
      </li>
      <li class="side-item side-item-category">{{__("message.Content")}}</li>
      <li class="slide is-expanded">
         <a class="side-menu__item" href="{{route('vacancies')}}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
            <span class="side-menu__label">{{__("message.Vacancies")}}</span>
         </a>
      </li>
      <li class="slide is-expanded">
         <a class="side-menu__item" href="{{route('send-news')}}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11a9 9 0 0 1 9 9"/><path d="M4 4a16 16 0 0 1 16 16"/><circle cx="5" cy="19" r="1"/></svg>
            <span class="side-menu__label">{{__("message.News")}}</span>
         </a>
      </li>
      
      <!--<li class="slide is-expanded">
         <a class="side-menu__item" href="{{route('admin-blog')}}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><line x1="10" y1="9" x2="8" y2="9"/></svg>
            <span class="side-menu__label">{{__("message.Blog")}}</span>
         </a>
      </li>-->
      
      
      
    <li class="slide">
         <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
            <span class="side-menu__label">{{__("message.Blog")}}</span><svg class="angle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
         </a>
         <ul class="slide-menu">
            <li><a href="{{ route('admin-blog') }}" class="slide-item"> {{__("message.Post")}}</a></li>
            <li><a href="{{ route('admin-tag') }}" class="slide-item"> {{__("message.Tag")}}</a></li>
         </ul>
    </li>
      
    
    <li class="slide">
         <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
            <span class="side-menu__label">{{__("message.Content")}}</span><svg class="angle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
         </a>
         <ul class="slide-menu">
            <li><a href="{{ route('admin-content') }}" class="slide-item"> {{__("message.Content")}}</a></li>
         </ul>
    </li>
      
      
     
      <li class="side-item side-item-category">{{__("message.Settings")}}</li>
      <li class="slide">
         <a class="side-menu__item"  href="{{url('setting/1')}}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            <span class="side-menu__label"> {{__("message.Setting")}} </span>
         </a>
      </li>
      <li class="slide">
         <a class="side-menu__item"  href="{{route('payment-setting')}}">
            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            <span class="side-menu__label"> {{__("message.Payment Setting")}} </span>
         </a>
      </li>
   </ul>
   </div>
</aside>
<!-- Dim/tap-to-close backdrop for the mobile offcanvas drawer. The theme's
     CSS already positions and toggles .app-sidebar__overlay via the existing
     .sidenav-toggled body class and sidemenu.js's [data-bs-toggle="sidebar"]
     click binding — the element itself was just never rendered. -->
<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<!--aside closed-->
<script>
    /* Sidebar quick-filter: pure client-side text match over the menu items
       already rendered above. Does not touch routes/data — just show/hide. */
    (function () {
        var input = document.getElementById('admSidebarSearch');
        if (!input) { return; }
        var menu = document.querySelector('.side-menu.app-sidebar3');
        if (!menu) { return; }
        var topLevel = Array.prototype.slice.call(menu.children);

        input.addEventListener('input', function () {
            var term = input.value.trim().toLowerCase();
            var lastCategory = null;
            var categoryHasVisible = false;

            function flushCategory() {
                if (lastCategory) {
                    lastCategory.classList.toggle('adm-hidden-by-search', term !== '' && !categoryHasVisible);
                }
            }

            topLevel.forEach(function (li) {
                if (li.classList.contains('side-item-category')) {
                    flushCategory();
                    lastCategory = li;
                    categoryHasVisible = false;
                    return;
                }
                if (!li.classList.contains('slide')) { return; }
                var text = li.textContent.toLowerCase();
                var matches = term === '' || text.indexOf(term) !== -1;
                li.classList.toggle('adm-hidden-by-search', !matches);
                if (matches) { categoryHasVisible = true; }
            });
            flushCategory();
        });
    })();
</script>