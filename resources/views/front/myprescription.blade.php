@extends('front.layout')
@section('title')
My Prescription
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
                <span>My Prescription</span>
            </nav>
            <h1 class="hd-dash-title">My Prescription</h1>
        </div>

        <div class="hd-dash-layout">
            @include('front.hd_account_sidebar', ['hdSidebarActive' => 'prescription'])

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
                        <h2>My Prescription</h2>
                        <p>Prescriptions you have shared with our team.</p>
                    </div>
                    <a href="{{route('Upload_Prescription')}}" class="premium-btn premium-btn-primary">
                        <i data-lucide="file-plus-2"></i>
                        Prescription
                    </a>
                </div>

                @if(count($myaddresses)>0)
                <div class="hd-fam-grid hd-addr-grid">
                    @foreach($myaddresses as $ma)
                    <div class="hd-fam-card">
                        <div class="hd-fam-top">
                            <span class="hd-fam-avatar"><i data-lucide="file-text"></i></span>
                            <div class="hd-fam-id">
                                <h3>{{$ma->name}}</h3>
                            </div>
                        </div>

                        <ul class="hd-fam-meta">
                            <li><i data-lucide="phone"></i>{{$ma->number}}</li>
                            <li><i data-lucide="mail"></i>{{$ma->email}}</li>
                            <li><i data-lucide="map-pin"></i>Location : {{$ma->location->name}}</li>
                        </ul>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="hd-dash-card hd-fam-empty">
                    <div class="hd-fam-empty-icon"><i data-lucide="file-text"></i></div>
                    <h3>No prescriptions uploaded yet.</h3>
                    <p>Upload a prescription and our team will help you book exactly what your doctor advised.</p>
                    <a href="{{route('Upload_Prescription')}}" class="premium-btn premium-btn-primary">
                        <i data-lucide="file-plus-2"></i>
                        Prescription
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
