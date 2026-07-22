<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <!-- Meta data -->
      <meta charset="UTF-8">
      <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
      <meta content="369 HealthDex Admin Login" name="description">
      <title>{{__("message.login_page_title")}}</title>
      <link rel="icon" href="{{asset('public/img').'/'.$setting->favicon}}" type="image/x-icon"/>

      <!-- Base reset (alert/close button styling only — no dashboard skin loaded on this page) -->
      <link href="{{ asset('public/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

      <!-- Centralized brand tokens (same file the rest of the site reads) -->
      <link rel="stylesheet" href="{{ asset('public/theme.css') }}?v=4">
      <!-- This page's own bespoke, self-contained stylesheet -->
      <link rel="stylesheet" href="{{ asset('public/admin-login.css') }}?v=2">
   </head>
   <body>
      <div class="adm-auth-page">
         <!-- Left aside: welcome + illustration (hidden on tablet/mobile) -->
         <div class="adm-auth-aside">
            <div class="adm-auth-aside-glow-1"></div>
            <div class="adm-auth-aside-glow-2"></div>
            <div class="adm-auth-aside-pattern"></div>
            <div class="adm-auth-aside-content">
               <span class="adm-auth-aside-badge">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-4"/></svg>
                  Secure Admin Access
               </span>
               <h1 class="adm-auth-aside-title">Welcome back to <span>369 HealthDex</span></h1>
               <p class="adm-auth-aside-desc">Manage bookings, catalog, users and reports from one place — sign in with your admin credentials to continue.</p>

               <div class="adm-auth-aside-features">
                  <div class="adm-auth-aside-feature">
                     <span class="adm-auth-aside-feature-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></span>
                     Real-time order &amp; catalog management
                  </div>
                  <div class="adm-auth-aside-feature">
                     <span class="adm-auth-aside-feature-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></span>
                     Centralized user &amp; branch controls
                  </div>
                  <div class="adm-auth-aside-feature">
                     <span class="adm-auth-aside-feature-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg></span>
                     Encrypted, access-controlled sessions
                  </div>
               </div>

               <div class="adm-auth-aside-illustration" aria-hidden="true">
                  <div class="adm-auth-aside-illustration-bar is-accent"></div>
                  <div class="adm-auth-aside-illustration-bar"></div>
                  <div class="adm-auth-aside-illustration-bar is-short"></div>
                  <div class="adm-auth-aside-illustration-row">
                     <span class="adm-auth-aside-illustration-chip"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></span>
                     <span class="adm-auth-aside-illustration-chip"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg></span>
                     <span class="adm-auth-aside-illustration-chip"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-4"/></svg></span>
                  </div>
               </div>
            </div>
         </div>

         <!-- Right panel: login card -->
         <div class="adm-auth-panel">
            <div class="adm-auth-card">
               <div class="adm-auth-logo">
                  <img src="{{asset('public/img').'/'.$setting->logo}}" alt="369 HealthDex">
               </div>
               <div class="adm-auth-header">
                  <h1 class="adm-auth-title">{{__("message.log_in")}}</h1>
                  <p class="adm-auth-subtitle">{{__("message.welcome_back")}}</p>
               </div>

               @if(Session::has('message'))
               <div class="adm-auth-alert {{ Session::get('alert-class', 'alert-info') }}" role="alert">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18" style="flex:0 0 auto;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                  <span>{{ Session::get('message') }}</span>
                  <button type="button" class="adm-auth-alert-close" onclick="this.parentElement.remove()" aria-label="Close">&times;</button>
               </div>
               @endif

               <form action="{{route('admin-postlogin')}}" method="post" id="adm-auth-form">
                  {{csrf_field()}}
                  <div class="adm-auth-field">
                     <label class="adm-auth-label" for="email">{{__('message.email')}}</label>
                     <div class="adm-auth-input-wrap">
                        <span class="adm-auth-input-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </span>
                        <input type="email" placeholder="{{__('message.email')}}" name="email" id="email" required autofocus value="{{isset($_COOKIE['email'])?$_COOKIE['email']:'admin@gmail.com'}}">
                     </div>
                  </div>

                  <div class="adm-auth-field">
                     <label class="adm-auth-label" for="password">{{__('message.password')}}</label>
                     <div class="adm-auth-input-wrap has-toggle">
                        <span class="adm-auth-input-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" placeholder="{{__('message.password')}}" name="password" id="password" required value="{{isset($_COOKIE['password'])?$_COOKIE['password']:'1234'}}">
                        <button type="button" class="adm-auth-toggle-pass" id="adm-auth-toggle-pass" aria-label="Show password" aria-pressed="false">
                           <svg class="adm-auth-eye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                           <svg class="adm-auth-eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                        </button>
                     </div>
                  </div>

                  <div class="adm-auth-row">
                     <label class="adm-auth-checkbox">
                        <input type="checkbox" name="rem_me" value="1">
                        <span>{{__('message.remember_me')}}</span>
                     </label>
                     <a href="mailto:{{$setting->email}}?subject=Admin%20Password%20Reset%20Request" class="adm-auth-forgot">Forgot password?</a>
                  </div>

                  <button type="submit" class="adm-auth-submit" id="adm-auth-submit">
                     <span class="adm-auth-spinner"></span>
                     <span class="adm-auth-submit-label">{{__("message.log_in")}}</span>
                  </button>
               </form>
            </div>
         </div>
      </div>

      <script src="{{ asset('public/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
      <script>
         // Password show/hide toggle — vanilla JS, replaces the old
         // jQuery bootstrap-show-password plugin (which targeted the
         // theme's dead fe-* icon font). Toggling `type` between
         // "password"/"text" has no effect on the submitted value or
         // field name, so this is purely a display-layer change.
         (function () {
            var toggle = document.getElementById('adm-auth-toggle-pass');
            var input = document.getElementById('password');
            if (!toggle || !input) return;
            toggle.addEventListener('click', function () {
               var showing = input.type === 'text';
               input.type = showing ? 'password' : 'text';
               toggle.classList.toggle('is-visible', !showing);
               toggle.setAttribute('aria-pressed', String(!showing));
               toggle.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
            });
         })();

         // Loading state on submit — purely visual; the form still submits
         // normally (no preventDefault), so existing validation/auth flow
         // is completely unchanged.
         (function () {
            var form = document.getElementById('adm-auth-form');
            var submit = document.getElementById('adm-auth-submit');
            if (!form || !submit) return;
            form.addEventListener('submit', function () {
               if (typeof form.reportValidity === 'function' && !form.reportValidity()) return;
               submit.classList.add('is-loading');
               submit.disabled = true;
            });
         })();
      </script>
   </body>
</html>
