@extends('front.layout')
@section('title')
 Blog
@stop

@section('content')
<section class="blog-grid">
        <div class="auto-container">
            <div class="row clearfix">
                @foreach($blogdata as $c)
                <div class="col-lg-4 col-md-6 col-sm-12 news-block">
                    <div class="news-block-one wow fadeInUp animated animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                        <div class="inner-box">
                            <figure class="image-box">
                                <img src="{{asset('storage/app/public/Blog').'/'.$c->image}}" alt="" style="height: 200px; width: 100%;">
                                <a href="" class="link"><i class="fas fa-link"></i></a>
                                <!--<span class="category">Featured</span>-->
                            </figure>
                            <div class="lower-content">
                                <h3><a href="{{ route('blog_detail', ['slug' => $c->slug]) }}" style="font-size:16px;">{{substr_replace($c->name, "   ", 45)}}</a></h3>
                                <ul class="post-info">
                                    <li><img src="" alt=""><a href="">369 HealthDex</a></li>   
                                    <li>{{ \Carbon\Carbon::parse($c->created_at)->format('d M Y') }} </li>
                                </ul>   
                                <p>{!! substr_replace($c->description, "   ", 85) !!}</p>
                                <div class="link"><a href="{{ route('blog_detail', ['slug' => $c->slug]) }}"><i class="icon-Arrow-Right"></i></a></div>
                                <div class="btn-box"><a href="{{ route('blog_detail', ['slug' => $c->slug]) }}" class="theme-btn-one">Read more<i class="icon-Arrow-Right"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
</section>
@stop
@section('footer')
@stop