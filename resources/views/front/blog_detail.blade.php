@extends('front.layout')


@section('content')
<style>
    
    .like-btn:hover {
        background-color: #FD484A;
        color: white;
    }
    .like-btn i {
        transition: transform 0.3s ease;
    }
    .like-btn:hover i {
        transform: scale(1.2);
    }
    .social-links a {
        transition: color 0.3s ease;
    }
    .social-links a:hover {
        opacity: 0.8;
    }
</style>
<!--page-title-two-->
        <section class="page-title-two">
            <div class="title-box centred bg-color-2">
                <div class="pattern-layer">
                    <div class="pattern-1" style="background-image: url(assets/images/shape/shape-70.png);"></div>
                    <div class="pattern-2" style="background-image: url(assets/images/shape/shape-71.png);"></div>
                </div>
                <div class="auto-container">
                    <div class="title">
                        <h1>Blog Details</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="index-2.html">Home</a></li>
                        <li>Blog Details</li>
                    </ul>
                </div>
            </div>
        </section>
        <!--page-title-two end-->


        <!-- sidebar-page-container -->
        <section class="sidebar-page-container">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                        <div class="blog-details-content">
                            <div class="news-block-one">
                                <div class="inner-box">
                                    <figure class="image-box">
                                       <img src="{{asset('storage/app/public/Blog').'/'.$blog->image}}" alt="">
                                       <!-- <span class="category">Featured</span>-->
                                    </figure>
                                    <div class="lower-content">
                                        <h3>{{$blog->name}}</h3>
                                        <ul class="post-info">
                                            <li><img src="" alt=""><a href="">369 HealthDex</a></li>
                                            <li>{{ \Carbon\Carbon::parse($blog->created_at)->format('Y-m-d') }}</li>
                                            
                                    <li>
                                        @if(Auth::id())
                                            <button class="btn btn-outline-danger like-btn d-flex align-items-center" data-post-id="{{ $blog->id }}">
                                                <i class="fas fa-heart"></i> &nbsp;
                                                <span>Like</span> 
                                                (<span class="like-count">{{ $blog->likes->count() }}</span>)
                                            </button>
                                        @else
                                            <button class="btn btn-outline-danger d-flex align-items-center " onclick="notlogin()" id="link">
                                                <i class="fas fa-heart"></i> &nbsp;
                                                <span>Like</span> 
                                                (<span class="like-count">{{ $blog->likes->count() }}</span>)
                                            </button>
                                        @endif 
                        
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="trackShare('{{ $blog->id }}', 'facebook', '{{ urlencode(request()->fullUrl()) }}')">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="trackShare('{{ $blog->id }}', 'twitter', '{{ urlencode(request()->fullUrl()) }}')">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="trackShare('{{ $blog->id }}', 'whatsapp', '{{ urlencode(request()->fullUrl()) }}')">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </li>
                                        </ul>
                                        <p>{{$blog->short_desc}}</p>
                                    </div>
                                    <div class="text">
                                        <p>{!! $blog->description !!}</p>

                                    </div>
                                </div>
                            </div>
                          
                            <div class="post-share-option clearfix my-4">
                                <div class="text pull-left"><h4>Like & Share</h4></div>
                                
                                <ul class="social-links clearfix pull-right">
                                
                                    <li>
                                        @if(Auth::id())
                                            <button class="btn btn-outline-danger like-btn d-flex align-items-center" data-post-id="{{ $blog->id }}">
                                                <i class="fas fa-heart"></i> &nbsp;
                                                <span>Like</span> 
                                                (<span class="like-count">{{ $blog->likes->count() }}</span>)
                                            </button>
                                        @else
                                            <button class="btn btn-outline-danger d-flex align-items-center mt-2 " onclick="notlogin()" id="link">
                                                <i class="fas fa-heart"></i> &nbsp;
                                                <span>Like</span> 
                                                (<span class="like-count">{{ $blog->likes->count() }}</span>)
                                            </button>
                                        @endif 
                                        
                        
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="trackShare('{{ $blog->id }}', 'facebook', '{{ urlencode(request()->fullUrl()) }}')">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="trackShare('{{ $blog->id }}', 'twitter', '{{ urlencode(request()->fullUrl()) }}')">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="trackShare('{{ $blog->id }}', 'whatsapp', '{{ urlencode(request()->fullUrl()) }}')">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="comment-box mb-4">
                                <div class="group-title">
                                    <h3>Comments ({{$blog->comments->count() }})</h3>
                                </div>
                                @foreach($blog->comments as $comment)
                                <div class="comment">
                                    <?php
                                    
                                    if(isset($comment->user->profile_pic) && $comment->user->profile_pic!=""){
                                          $path=env('APP_URL')."storage/app/public/profile"."/".$comment->user->profile_pic;
                                      }
                                      else{
                                          $path=asset('public/img/default_user.png');
                                      }
                                      ?>
                                    <figure class="thumb-box">
                                        <img src="{{$path}}" alt="" style="height: 100%;">
                                    </figure>
                                    <div class="comment-inner">
                                        <div class="comment-info my-1">
                                            <h5>{{ $comment->user->name ?? 'Unknown' }}</h5>
                                            <span class="comment-time">{{ $blog->created_at->format('F d, Y') }}</span>
                                        </div>
                                        <p>{{$comment->comment}} </p>
                                        <!--<a href="blog-details.html" class="reply-btn">Reply</a>-->
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="comments-form-area">
                                <div class="group-title">
                                    <h3>Leave a Comment</h3>
                                </div>
                                <form method="POST" action="{{ route('comments.store', $blog->id) }}" class="comment-form">
                                    @csrf
                                    <div class="col-12 form-group">
                                       <textarea name="comment" class="form-control" size="2" required style="height: 100px;"></textarea>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group btn-box">
                                            <button type="submit" class="book_now">Send Comment</button>
                                    </div>
                                </form>
                                <!--<form action="https://azim.commonsupport.com/Docpro/blog-details.html" method="post" class="comment-form">-->
                                <!--    <div class="row clearfix">-->
                                <!--        <div class="col-lg-6 col-md-6 col-sm-12 form-group">-->
                                <!--            <input type="text" name="fname" placeholder="First Name" required="">-->
                                <!--        </div>-->
                                <!--        <div class="col-lg-6 col-md-6 col-sm-12 form-group">-->
                                <!--            <input type="text" name="lname" placeholder="Last Name" required="">-->
                                <!--        </div>-->
                                <!--        <div class="col-lg-6 col-md-6 col-sm-12 form-group">-->
                                <!--            <input type="email" name="email" placeholder="Email Address" required="">-->
                                <!--        </div>-->
                                <!--        <div class="col-lg-6 col-md-6 col-sm-12 form-group">-->
                                <!--            <input type="text" name="phone" placeholder="Phone" required="">-->
                                <!--        </div>-->
                                <!--        <div class="col-lg-12 col-md-12 col-sm-12 form-group">-->
                                <!--            <textarea name="message" placeholder="Leave A Comment"></textarea>-->
                                <!--        </div>-->
                                <!--        <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">-->
                                <!--            <button type="submit" class="theme-btn-one">Send Message<i class="icon-Arrow-Right"></i></button>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</form>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                        <div class="blog-sidebar">
                            <div class="sidebar-widget sidebar-tags">
                                <div class="widget-title">
                                    <h3>Tags</h3>
                                </div>
                                <div class="widget-content">
                                    <ul class="tags-list clearfix">
                                        @foreach($tag as $t)
                                        <li><a href="">{{$t->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- sidebar-page-container end -->
@stop
@section('footer')
<script>
document.querySelectorAll('.like-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const postId = this.getAttribute('data-post-id');
        console.log(postId);
        fetch(`/like/${postId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            this.querySelector('.like-count').textContent = data.likes_count;
        });
    });
});
</script>
<script>
    function trackShare(postId, platform, url) {
        fetch(`/share/${postId}/${platform}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        });

        // After logging, open the share link
        let shareUrl = '';
        if (platform === 'facebook') {
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
        } else if (platform === 'twitter') {
            shareUrl = `https://twitter.com/intent/tweet?url=${url}`;
        } else if (platform === 'whatsapp') {
            shareUrl = `https://api.whatsapp.com/send?text=${url}`;
        }

        window.open(shareUrl, '_blank');
    }
</script>

@stop