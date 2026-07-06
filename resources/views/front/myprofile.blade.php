@extends('front.layout')
@section('title')
   {{__('message.My Profile')}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('user-profile')}}"/>
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
<section class="hd-dash-section">
    <div class="auto-container">
        <!-- Page head -->
        <div class="hd-dash-head">
            <nav class="hd-dash-breadcrumb" aria-label="Breadcrumb">
                <a href="{{route('home')}}">{{__('message.Home')}}</a>
                <i data-lucide="chevron-right"></i>
                <a href="{{route('dashboard')}}">{{__('message.Dashboard')}}</a>
                <i data-lucide="chevron-right"></i>
                <span>{{__('message.My Profile')}}</span>
            </nav>
            <h1 class="hd-dash-title">{{__('message.My Profile')}}</h1>
        </div>

        <div class="hd-dash-layout">
            @include('front.hd_account_sidebar', ['hdSidebarActive' => 'profile'])

            <main class="hd-dash-main">
                @if(Session::has('message'))
                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                    </div>
                    @endif

                <div class="hd-dash-card hd-dash-form">
                    <h3 class="hd-dash-card-title"><i data-lucide="user-round"></i>{{__('message.My Profile')}}</h3>

                    <form action="{{route('update-profile-info')}}" method="post" enctype="multipart/form-data" >
                        {{csrf_field()}}
                        <div class="hd-auth-grid">
                            <div class="hd-field-full form-group">
                                <label for="name">{{__('message.Profile Picture')}}<span class="reqfield">*</span></label>
                                <div id="uploaded_image" >
                                    <div class="upload-btn-wrapper">
                                        <button class="btn imgcatlog">
                                        <input type="hidden" name="real_basic_img" id="real_basic_img" value="<?= isset($data->image)?$data->image:""?>"/>
                                        <?php
                                        if(Auth::user()->profile_pic!=""){
                                            $path=url('/')."/storage/profile"."/".Auth::user()->profile_pic;
                                        }
                                        else{
                                            $path=asset('public/img/default_user.png');
                                        }
                                        ?>
                                        <img src="{{$path}}" alt="..." class="img-thumbnail imgsize"  id="basic_img" >
                                        </button>
                                        <input type="hidden" name="basic_img" id="basic_img1"/>
                                        @if(Auth::user()->profile_pic!="")
                                        <input type="file" name="upload_image" id="upload_image" class="form-control" />
                                        @else
                                         <input type="file" class="form-control" required="" name="upload_image" id="upload_image" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{__('message.Name')}}</label>
                                <input type="text" name="name" id="name" required="" value="{{Auth::user()->name}}">
                            </div>
                            <div class="form-group">
                                <label>{{__('message.email')}}</label>
                                <input type="email" name="email" id="email" value="{{Auth::user()->email}}" required="">
                            </div>
                        </div>

                        <div class="hd-dash-form-actions">
                            <button type="submit" class="theme-btn-one">{{__('message.Save Change')}}<i data-lucide="arrow-right"></i></button>
                            <a href="javascript::void(0)" onclick="resetpassword()" class="cancel-btn">{{__('message.Cancel')}}</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</section>
@stop
@section('footer')
@stop
