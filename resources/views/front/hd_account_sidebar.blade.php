@php
    /* Shared premium account sidebar. Pass the active item via
       @include('front.hd_account_sidebar', ['hdSidebarActive' => 'addresses']) */
    $hdSidebarActive = $hdSidebarActive ?? '';
@endphp
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
           <li><a href="{{route('dashboard')}}" class="{{ $hdSidebarActive == 'dashboard' ? 'current' : '' }}"><i data-lucide="layout-dashboard"></i>{{__("message.Dashboard")}}</a></li>
           <li><a href="{{route('my-family-member')}}" class="{{ $hdSidebarActive == 'family' ? 'current' : '' }}"><i data-lucide="users"></i>{{__("message.My Family Members")}}</a></li>
           <li><a href="{{route('my-addresses')}}" class="{{ $hdSidebarActive == 'addresses' ? 'current' : '' }}"><i data-lucide="map-pin"></i>{{__("message.My Addresses")}}</a></li>
           <li><a href="{{route('my-home')}}" class="{{ $hdSidebarActive == 'homevisit' ? 'current' : '' }}"><i data-lucide="house"></i>Home Visit</a></li>
           <li><a href="{{route('my_prescription')}}" class="{{ $hdSidebarActive == 'prescription' ? 'current' : '' }}"><i data-lucide="file-text"></i>My Prescription</a></li>
           <li><a href="{{route('user-profile')}}" class="{{ $hdSidebarActive == 'profile' ? 'current' : '' }}"><i data-lucide="user-round"></i>{{__("message.My Profile")}}</a></li>
           <!-- <li><a href="{{route('user-change-password')}}" class="{{ $hdSidebarActive == 'password' ? 'current' : '' }}"><i data-lucide="lock-keyhole"></i>{{__("message.Change Password")}}</a></li> -->
           <li><a href="{{route('user-logout')}}" class="hd-dash-logout"><i data-lucide="log-out"></i>{{__("message.Logout")}}</a></li>
        </ul>
    </nav>
</aside>
