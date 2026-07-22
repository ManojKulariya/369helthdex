<!-- App-Content -->
<div class="app-content main-content">
<div class="side-app">
<!--app header-->
<div class="app-header header main-header1">
   <div class="container-fluid" style="padding-right: 0px;">
      <div class="d-flex">
         <a class="header-brand" href="javascript:void()">
         <img src="{{asset('public/img').'/'.$setting->logo}}" class="header-brand-img desktop-lgo" alt="logo">
         <img src="{{asset('public/img').'/'.$setting->logo}}" class="header-brand-img dark-logo" alt="logo">
         <img src="{{asset('public/img').'/'.$setting->logo}}" class="header-brand-img mobile-logo" alt="logo">
         <img src="{{asset('public/img').'/'.$setting->logo}}" class="header-brand-img darkmobile-logo" alt="logo">
         </a>
         <div class="app-sidebar__toggle d-flex" data-bs-toggle="sidebar">
            <a class="open-toggle" href="javascript:void0;">
               <svg xmlns="http://www.w3.org/2000/svg" class="adm-toggle-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="3" y1="6" x2="21" y2="6"/>
                  <line x1="3" y1="12" x2="21" y2="12"/>
                  <line x1="3" y1="18" x2="21" y2="18"/>
               </svg>
            </a>
         </div>
         <div class="adm-header-search" id="admHeaderSearchWrap">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="admHeaderSearch" placeholder="Search menu…" autocomplete="off">
            <div class="adm-header-search-results" id="admHeaderSearchResults"></div>
         </div>
         <div class="d-flex order-lg-2 ms-auto main-header-end">
            <button  class="navbar-toggler navresponsive-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="true" aria-label="Toggle navigation">
            <svg class="adm-toggler-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
            </button>
            <div class="navbar navbar-expand-lg navbar-collapse responsive-navbar p-0">
               <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                  <div class="d-flex order-lg-2">
                     <div class="dropdown header-notify d-flex">
                        <a class="nav-link icon" data-bs-toggle="dropdown">
                           <svg xmlns="http://www.w3.org/2000/svg" class="header-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                              <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
                              <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
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
                                 <div class="notifyimg  text-primary bg-primary-transparent border-primary"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg> </div>
                                 <div>
                                    <span class="fs-13">{{__("message.message_sent")}}</span>
                                    <div class="small text-muted">{{__("message.3_hours")}}</div>
                                 </div>
                              </a>
                              <a href="email-inbox.html" class="dropdown-item border-bottom d-flex ps-4">
                                 <div class="notifyimg  text-secondary bg-secondary-transparent border-secondary"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg></div>
                                 <div>
                                    <span class="fs-13">{{__("message.order_placed")}}</span>
                                    <div class="small text-muted">{{__("message.5_hours")}}</div>
                                 </div>
                              </a>
                              <a href="email-inbox.html" class="dropdown-item border-bottom d-flex ps-4">
                                 <div class="notifyimg  text-danger bg-danger-transparent border-danger"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13"/><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/></svg> </div>
                                 <div>
                                    <span class="fs-13">{{__("message.event_started")}}</span>
                                    <div class="small text-muted">{{__("message.45 mintues ago")}}</div>
                                 </div>
                              </a>
                              <a href="email-inbox.html" class="dropdown-item border-bottom d-flex ps-4 mb-2">
                                 <div class="notifyimg  text-success  bg-success-transparent border-success"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg> </div>
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
                        <a href="javascript:void0;" class="nav-link pe-0 leading-none adm-profile-toggle" data-bs-toggle="dropdown">
                        <span class="header-avatar1">
                        <img src="{{ url('/').'/storage/profile'.'/'.Auth::user()->profile_pic}}" alt="{{Auth::user()->name}}" class="avatar avatar-md brround">
                        </span>
                        <span class="adm-profile-name">{{ Auth::user()->name }}</span>
                        <svg class="adm-profile-caret" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
                           <a class="dropdown-item d-flex" href="{{ route('admin-profile') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" class="adm-dd-icon me-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                 <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                 <circle cx="12" cy="7" r="4"/>
                              </svg>
                              <div class="fs-13">{{__("message.Profile")}}</div>
                           </a>
                           <a class="dropdown-item d-flex" href="{{ route('admin-changepassword') }}">
                              <svg xmlns="http://www.w3.org/2000/svg" class="adm-dd-icon me-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                 <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                 <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                              </svg>
                             {{__("message.Change Password")}}
                           </a>
                           <a class="dropdown-item d-flex" href="{{route('admin-logout')}}">
                              <svg xmlns="http://www.w3.org/2000/svg" class="adm-dd-icon me-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                 <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                 <polyline points="16 17 21 12 16 7"/>
                                 <line x1="21" x2="9" y1="12" y2="12"/>
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
<script>
   /* Header quick-search: client-side jump-to-menu only. It indexes the
      links the sidebar has already rendered in the DOM and navigates via
      their existing hrefs — no endpoint is called, no data is fetched.
      Deferred to DOMContentLoaded because the sidebar renders after this
      header include. */
   document.addEventListener('DOMContentLoaded', function () {
      var input = document.getElementById('admHeaderSearch');
      var panel = document.getElementById('admHeaderSearchResults');
      var wrap  = document.getElementById('admHeaderSearchWrap');
      if (!input || !panel || !wrap) { return; }

      var links = [];
      document.querySelectorAll('.side-menu a.side-menu__item[href], .side-menu a.slide-item[href]').forEach(function (a) {
         var href = a.getAttribute('href') || '';
         if (href.indexOf('javascript') === 0 || href === '#' || href === '') { return; }
         var label = (a.textContent || '').replace(/\s+/g, ' ').trim();
         if (label) { links.push({ label: label, href: href }); }
      });

      function render(term) {
         panel.innerHTML = '';
         if (!term) { wrap.classList.remove('is-open'); return; }
         var t = term.toLowerCase();
         var hits = links.filter(function (l) { return l.label.toLowerCase().indexOf(t) !== -1; }).slice(0, 8);
         if (!hits.length) {
            var empty = document.createElement('div');
            empty.className = 'adm-header-search-empty';
            empty.textContent = 'No menu match';
            panel.appendChild(empty);
         } else {
            hits.forEach(function (l) {
               var row = document.createElement('a');
               row.className = 'adm-header-search-row';
               row.href = l.href;
               row.textContent = l.label;
               panel.appendChild(row);
            });
         }
         wrap.classList.add('is-open');
      }

      input.addEventListener('input', function () { render(input.value.trim()); });
      input.addEventListener('keydown', function (e) {
         if (e.key === 'Enter') {
            e.preventDefault();
            var first = panel.querySelector('a.adm-header-search-row');
            if (first) { window.location.href = first.getAttribute('href'); }
         } else if (e.key === 'Escape') {
            input.value = '';
            render('');
         }
      });
      document.addEventListener('click', function (e) {
         if (!wrap.contains(e.target)) { wrap.classList.remove('is-open'); }
      });
   });
</script>