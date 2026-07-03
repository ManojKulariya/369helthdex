<!-- Premium Blog Section -->
<section class="blog-premium-section reveal">
  <div class="auto-container">
    <!-- Section Header -->
    <div class="blog-section-header">
      <div class="blog-section-title-wrapper">
        <div class="blog-section-badge">
          <span class="blog-section-badge-icon">
            <i data-lucide="newspaper"></i>
          </span>
          <span class="blog-section-badge-text">Health Articles</span>
        </div>
        <h2 class="blog-section-title">Latest Health Blogs</h2>
        <p class="blog-section-description">Stay informed with expert health tips, wellness guides and diagnostic insights</p>
      </div>
      
      <a href="{{route('blog')}}" class="blog-view-all-btn">
        View All Articles
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
          <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
        </svg>
      </a>
    </div>
    
    <!-- Blog Grid -->
    <div class="blog-grid-wrapper">
      <!-- Featured Article Column -->
      <div class="blog-featured-column">
        @php $firstBlog = $blogdata->first(); @endphp
        @if($firstBlog)
        <div class="blog-featured-card">
          <div class="blog-featured-image-wrapper">
            <img src="{{asset('storage/app/public/Blog').'/'.$firstBlog->image}}" alt="{{$firstBlog->name}}" class="blog-featured-image" loading="lazy" decoding="async">
            <div class="blog-featured-overlay"></div>
            <div class="blog-featured-badges">
              <span class="blog-category-badge">
                <i data-lucide="heart-pulse"></i>
                Health
              </span>
              <span class="blog-date-badge">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                  <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                </svg>
                {{Carbon\Carbon::parse($firstBlog->created_at)->format('d M Y')}}
              </span>
            </div>
          </div>
          <div class="blog-featured-content">
            <div class="blog-featured-meta">
              <div class="blog-author">
                <div class="blog-author-avatar">H</div>
                <span class="blog-author-name">HealthDex 369</span>
              </div>
              <div class="blog-reading-time">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                  <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                </svg>
                5 min read
              </div>
            </div>
            <h3 class="blog-featured-title">{{Str::limit($firstBlog->name, 80)}}</h3>
            <p class="blog-featured-excerpt">Expert health insights and wellness tips from our medical team. Stay informed about the latest diagnostic advancements.</p>
            <a href="{{route('blog_detail', ['slug'=>$firstBlog->slug])}}" class="blog-read-more-btn">
              Read Article
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
              </svg>
            </a>
          </div>
        </div>
        @endif
      </div>
      
      <!-- Sidebar Column -->
      <div class="blog-sidebar-column">
        @foreach($blogdata->slice(1, 3) as $c)
        <div class="blog-card">
          <div class="blog-card-image-wrapper">
            <img src="{{asset('storage/app/public/Blog').'/'.$c->image}}" alt="{{$c->name}}" class="blog-card-image" loading="lazy" decoding="async">
            <div class="blog-card-badges">
              <span class="blog-card-category">Health</span>
            </div>
          </div>
          <div class="blog-card-content">
            <div class="blog-card-meta">
              <span class="blog-card-category">Health</span>
              <span class="blog-card-date">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                  <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 017.5 3v1.5h9V3A.75.75 0 0118 3v1.5h.75a3 3 0 013 3v11.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V7.5a3 3 0 013-3H6V3a.75.75 0 01.75-.75zm13.5 9a1.5 1.5 0 00-1.5-1.5H5.25a1.5 1.5 0 00-1.5 1.5v7.5a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5v-7.5z" clip-rule="evenodd" />
                </svg>
                {{Carbon\Carbon::parse($c->created_at)->format('d M Y')}}
              </span>
            </div>
            <h4 class="blog-card-title">{{Str::limit($c->name, 60)}}</h4>
            <p class="blog-card-excerpt">Expert health insights and wellness tips from our medical team.</p>
            <a href="{{route('blog_detail', ['slug'=>$c->slug])}}" class="blog-card-link">
              Read More
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
              </svg>
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
