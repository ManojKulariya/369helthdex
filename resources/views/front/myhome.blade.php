@extends('front.layout')
@section('title')
My Home Visit
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{route('my-addresses')}}"/>
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
                <span>My Home Visit</span>
            </nav>
            <h1 class="hd-dash-title">My Home Visit</h1>
        </div>

        <div class="hd-dash-layout">
            @include('front.hd_account_sidebar', ['hdSidebarActive' => 'homevisit'])

            <main class="hd-dash-main">
                @if(Session::has('message'))
                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                    </div>
                    @endif

                <!-- Header row -->
                <div class="hd-fam-header">
                    <div class="hd-fam-header-text">
                        <h2>My Home Visit</h2>
                        <p>Your home sample collection requests and their status.</p>
                    </div>
                    <a href="{{route('home_visit')}}" class="premium-btn premium-btn-primary">
                        <i data-lucide="house-plus"></i>
                        Home Visit
                    </a>
                </div>

                @if(count($myaddresses)>0)
                <div class="hd-fam-grid hd-addr-grid">
                    @foreach($myaddresses as $ma)
                    <div class="hd-fam-card">
                        <div class="hd-fam-top">
                            <span class="hd-fam-avatar"><i data-lucide="house"></i></span>
                            <div class="hd-fam-id">
                                <h3>{{$ma->user_name}}</h3>
                            </div>
                        </div>

                        <div class="hd-fam-status">
                            @if( $ma->status == 0 )
                            <button type="button" class="btn btn-sm btn-warning ">Pending</button>
                            @elseif( $ma->status == 1 )
                            <button type="button" class="btn btn-sm btn-success ">Accepted</button>
                            @elseif( $ma->status == 2 )
                            <button type="button" class="btn btn-sm btn-danger ">Reject</button>
                            @else
                            <button type="button" class="btn btn-sm btn-primary ">Complete</button>
                            @endif
                        </div>

                        <ul class="hd-fam-meta">
                            <li><i data-lucide="phone"></i>{{$ma->user_number}}</li>
                            <li><i data-lucide="mail"></i>{{$ma->user_email}}</li>
                            <li><i data-lucide="map-pin"></i>Location : {{$ma->citydata->name}}</li>
                        </ul>

                        @if( $ma->status == 0 )
                        <div class="hd-fam-actions">
                            <button type="submit" class="hd-fam-btn hd-fam-btn-delete" onclick="deletevisit('{{$ma->id}}')">
                                <i data-lucide="trash-2"></i>
                                Delete
                            </button>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="hd-dash-card hd-fam-empty">
                    <div class="hd-fam-empty-icon"><i data-lucide="house"></i></div>
                    <h3>No home visit requests yet.</h3>
                    <p>Book a home visit and our expert phlebotomist will collect your sample at your doorstep.</p>
                    <a href="{{route('home_visit')}}" class="premium-btn premium-btn-primary">
                        <i data-lucide="house-plus"></i>
                        Home Visit
                    </a>
                </div>
                @endif
            </main>
        </div>
    </div>
</section>
@stop
@section('footer')
@stop
