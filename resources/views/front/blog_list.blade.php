@extends('front.layout')
@section('title')
 Blog
@stop

@section('content')
@php
    /* Featured article = latest post; the grid shows the rest. */
    $hdFeatured = $blogdata->first();
    $hdRestBlogs = $blogdata->count() > 1 ? $blogdata->slice(1)->values() : collect();

    /* Resolve category names from the existing tag reference (same pattern
       already used by blog_detail.blade.php), purely for display. */
    $hdAllTagIds = collect();
    foreach ($blogdata as $hdB) {
        foreach (explode(',', (string) $hdB->tag) as $hdTid) {
            $hdTid = trim($hdTid);
            if ($hdTid !== '' && is_numeric($hdTid)) { $hdAllTagIds->push((int) $hdTid); }
        }
    }
    $hdTagNames = $hdAllTagIds->isNotEmpty() ? \App\Models\Tag::whereIn('id', $hdAllTagIds->unique())->pluck('name', 'id') : collect();

    $hdCategoryFor = function ($blog) use ($hdTagNames) {
        foreach (explode(',', (string) $blog->tag) as $hdTid) {
            $hdTid = trim($hdTid);
            if ($hdTid !== '' && isset($hdTagNames[$hdTid])) { return $hdTagNames[$hdTid]; }
        }
        return 'Health';
    };
    $hdFirstTagId = function ($blog) {
        $hdTid = trim(explode(',', (string) $blog->tag)[0] ?? '');
        return is_numeric($hdTid) ? (int) $hdTid : 0;
    };
    $hdReadingTime = function ($blog) {
        $hdWords = str_word_count(strip_tags((string) $blog->description));
        return max(1, (int) ceil($hdWords / 200));
    };

    /* Category post counts, for the sidebar. */
    $hdCategoryCounts = [];
    foreach ($blogdata as $hdB) {
        $hdCategoryCounts[$hdFirstTagId($hdB)] = ($hdCategoryCounts[$hdFirstTagId($hdB)] ?? 0) + 1;
    }

    /* Recent = same collection, already ordered newest-first by the controller. */
    $hdRecentPosts = $blogdata->take(5);

    /* Popular = existing likes() relationship, aggregated for display only. */
    $hdPopularPosts = \App\Models\Blog::withCount('likes')->orderByDesc('likes_count')->orderByDesc('id')->take(5)->get();
@endphp

<!-- Hero -->
<section class="blog-hero-section reveal">
  <div class="blog-hero-bg" aria-hidden="true">
    <span class="blog-hero-blob blog-hero-blob-1"></span>
    <span class="blog-hero-blob blog-hero-blob-2"></span>
    <span class="blog-hero-pattern"></span>
  </div>
  <div class="auto-container">
    <nav class="blog-hero-breadcrumb" aria-label="Breadcrumb">
      <a href="{{route('home')}}">{{__('message.Home')}}</a>
      <i data-lucide="chevron-right"></i>
      <span>Blog</span>
    </nav>

    <div class="blog-hero-grid">
      <div class="blog-hero-content">
        <div class="blog-section-badge">
          <span class="blog-section-badge-icon"><i data-lucide="newspaper"></i></span>
          <span class="blog-section-badge-text">Health Blog</span>
        </div>
        <h1 class="blog-hero-title">Your Guide to <span class="blog-hero-title-accent">Better Health</span></h1>
        <p class="blog-hero-subtitle">Expert-backed articles on preventive care, diagnostics and everyday wellness — curated by the 369 HealthDex team.</p>

        <div class="blog-hero-search-wrap">
          <div class="luxury-hero-search" id="blogHeroSearch">
            <span class="luxury-hero-search-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
              </svg>
            </span>
            <input type="text" id="blogSearchInput" class="luxury-hero-search-input" placeholder="Search articles…">
            <button type="button" class="btn btn-primary btn-lg luxury-hero-search-btn" id="blogSearchBtn">
              <span>Search</span>
              <i data-lucide="arrow-right"></i>
            </button>
          </div>
        </div>

        @if($hdTagNames->isNotEmpty())
        <div class="blog-filter-pills" id="blogFilterPills">
          <button type="button" class="blog-filter-pill is-active" data-filter="all">All Articles</button>
          @foreach($hdTagNames as $hdTid => $hdTname)
          <button type="button" class="blog-filter-pill" data-filter="{{ $hdTid }}">{{ $hdTname }}</button>
          @endforeach
        </div>
        @endif
      </div>

      <div class="blog-hero-visual" aria-hidden="true">
        <span class="blog-hero-float blog-hero-float-1"><i data-lucide="stethoscope"></i></span>
        <span class="blog-hero-float blog-hero-float-2"><i data-lucide="heart-pulse"></i></span>
        <span class="blog-hero-float blog-hero-float-3"><i data-lucide="flask-conical"></i></span>
        <span class="blog-hero-float blog-hero-float-4"><i data-lucide="book-open-text"></i></span>
        <div class="blog-hero-visual-ring">
          <div class="blog-hero-visual-core">
            <i data-lucide="newspaper"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="blog-listing-section reveal">
  <div class="auto-container">
    @if($blogdata->isEmpty())
    <div class="hd-dash-card hd-fam-empty">
      <div class="hd-fam-empty-icon"><i data-lucide="newspaper"></i></div>
      <h3>No articles published yet.</h3>
      <p>Check back soon for expert health tips and wellness updates from our team.</p>
      <a href="{{route('home')}}" class="premium-btn premium-btn-primary">
        <i data-lucide="arrow-left"></i>
        Back to Home
      </a>
    </div>
    @else

    <!-- Featured Article -->
    @if($hdFeatured)
    <div class="blog-featured-wrap">
      <span class="blog-featured-label"><i data-lucide="sparkles"></i>Featured Article</span>
      <div class="blog-featured-card blog-featured-card-full">
        <div class="blog-featured-image-wrapper">
          <img src="{{asset('storage/Blog').'/'.$hdFeatured->image}}" alt="{{$hdFeatured->name}}" class="blog-featured-image" loading="lazy" decoding="async">
          <div class="blog-featured-overlay"></div>
          <div class="blog-featured-badges">
            <span class="blog-category-badge">
              <i data-lucide="heart-pulse"></i>
              {{ $hdCategoryFor($hdFeatured) }}
            </span>
            <span class="blog-date-badge">
              <i data-lucide="calendar"></i>
              {{ \Carbon\Carbon::parse($hdFeatured->created_at)->format('d M Y') }}
            </span>
          </div>
        </div>
        <div class="blog-featured-content">
          <div class="blog-featured-meta">
            <div class="blog-author">
              <div class="blog-author-avatar">H</div>
              <span class="blog-author-name">369 HealthDex</span>
            </div>
            <div class="blog-reading-time">
              <i data-lucide="clock"></i>
              {{ $hdReadingTime($hdFeatured) }} min read
            </div>
          </div>
          <h2 class="blog-featured-title">{{ \Illuminate\Support\Str::limit($hdFeatured->name, 90) }}</h2>
          <p class="blog-featured-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags((string) $hdFeatured->short_desc), 160) }}</p>
          <a href="{{ route('blog_detail', ['slug' => $hdFeatured->slug]) }}" class="blog-read-more-btn">
            Read Article
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
            </svg>
          </a>
        </div>
      </div>
    </div>
    @endif

    <div class="blog-main-grid">
      <!-- Grid + pagination -->
      <div class="blog-main-col">
        @if($hdRestBlogs->isNotEmpty())
        <div class="blog-cards-grid" id="blogCardsGrid">
          @foreach($hdRestBlogs as $c)
          <div class="blog-grid-item" data-filter="{{ $hdFirstTagId($c) }}" data-title="{{ strtolower($c->name) }}">
            <div class="blog-featured-card">
              <div class="blog-featured-image-wrapper">
                <img src="{{asset('storage/Blog').'/'.$c->image}}" alt="{{$c->name}}" class="blog-featured-image" loading="lazy" decoding="async">
                <div class="blog-featured-overlay"></div>
                <div class="blog-featured-badges">
                  <span class="blog-category-badge">
                    <i data-lucide="heart-pulse"></i>
                    {{ $hdCategoryFor($c) }}
                  </span>
                  <span class="blog-date-badge">
                    <i data-lucide="calendar"></i>
                    {{ \Carbon\Carbon::parse($c->created_at)->format('d M Y') }}
                  </span>
                </div>
              </div>
              <div class="blog-featured-content">
                <div class="blog-featured-meta">
                  <div class="blog-author">
                    <div class="blog-author-avatar">H</div>
                    <span class="blog-author-name">369 HealthDex</span>
                  </div>
                  <div class="blog-reading-time">
                    <i data-lucide="clock"></i>
                    {{ $hdReadingTime($c) }} min read
                  </div>
                </div>
                <h3 class="blog-featured-title">{{ \Illuminate\Support\Str::limit($c->name, 70) }}</h3>
                <p class="blog-featured-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags((string) $c->short_desc), 110) }}</p>
                <a href="{{ route('blog_detail', ['slug' => $c->slug]) }}" class="blog-read-more-btn">
                  Read More
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <p class="blog-no-results" id="blogNoResults" hidden>No articles match your search.</p>
        <nav class="blog-pagination" id="blogPagination" aria-label="Blog pagination"></nav>
        @endif
      </div>

      <!-- Sidebar -->
      <aside class="blog-sidebar-col">
        @if($hdTagNames->isNotEmpty())
        <div class="hd-dash-card blog-sidebar-widget">
          <h3 class="hd-dash-card-title"><i data-lucide="tags"></i>Categories</h3>
          <ul class="blog-sidebar-categories" id="blogSidebarCategories">
            @foreach($hdTagNames as $hdTid => $hdTname)
            <li>
              <button type="button" data-filter="{{ $hdTid }}">
                {{ $hdTname }}
                <span>{{ $hdCategoryCounts[$hdTid] ?? 0 }}</span>
              </button>
            </li>
            @endforeach
          </ul>
        </div>
        @endif

        @if($hdRecentPosts->isNotEmpty())
        <div class="hd-dash-card blog-sidebar-widget">
          <h3 class="hd-dash-card-title"><i data-lucide="history"></i>Recent Posts</h3>
          <div class="blog-sidebar-list">
            @foreach($hdRecentPosts as $r)
            <a href="{{ route('blog_detail', ['slug' => $r->slug]) }}" class="blog-card">
              <div class="blog-card-image-wrapper">
                <img src="{{asset('storage/Blog').'/'.$r->image}}" alt="{{$r->name}}" class="blog-card-image" loading="lazy" decoding="async">
              </div>
              <div class="blog-card-content">
                <div class="blog-card-meta">
                  <span class="blog-card-date">
                    <i data-lucide="calendar"></i>
                    {{ \Carbon\Carbon::parse($r->created_at)->format('d M Y') }}
                  </span>
                </div>
                <h4 class="blog-card-title">{{ \Illuminate\Support\Str::limit($r->name, 60) }}</h4>
              </div>
            </a>
            @endforeach
          </div>
        </div>
        @endif

        @if($hdPopularPosts->isNotEmpty())
        <div class="hd-dash-card blog-sidebar-widget">
          <h3 class="hd-dash-card-title"><i data-lucide="flame"></i>Popular Posts</h3>
          <div class="blog-sidebar-list">
            @foreach($hdPopularPosts as $p)
            <a href="{{ route('blog_detail', ['slug' => $p->slug]) }}" class="blog-card">
              <div class="blog-card-image-wrapper">
                <img src="{{asset('storage/Blog').'/'.$p->image}}" alt="{{$p->name}}" class="blog-card-image" loading="lazy" decoding="async">
              </div>
              <div class="blog-card-content">
                <div class="blog-card-meta">
                  <span class="blog-popular-badge">
                    <i data-lucide="heart"></i>
                    {{ $p->likes_count }} {{ Str::plural('like', $p->likes_count) }}
                  </span>
                </div>
                <h4 class="blog-card-title">{{ \Illuminate\Support\Str::limit($p->name, 60) }}</h4>
              </div>
            </a>
            @endforeach
          </div>
        </div>
        @endif
      </aside>
    </div>
    @endif
  </div>
</section>

<!-- CTA -->
<section class="blog-cta-section">
  <div class="auto-container">
    <div class="footer-cta-strip blog-cta-strip">
      <div class="footer-cta-content">
        <h3 class="footer-cta-title">Stay Updated With Health Tips</h3>
        <p class="footer-cta-description">Get expert healthcare insights, wellness tips, and preventive care updates.</p>
      </div>
      <div class="footer-cta-buttons">
        <a href="#blogCardsGrid" class="footer-btn footer-btn-primary">
          Read More Blogs
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 011.06 0l7.5 7.5a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 11-1.06-1.06l6.22-6.22H3a.75.75 0 010-1.5h16.19l-6.22-6.22a.75.75 0 010-1.06z" clip-rule="evenodd" />
          </svg>
        </a>
        <a href="{{route('popular-packages',['city'=>session()->get('cityName') ?: 'rajkot'])}}" class="footer-btn footer-btn-secondary">
          <i data-lucide="calendar-check"></i>
          Book Health Checkup
        </a>
      </div>
    </div>
  </div>
</section>

<script>
(function () {
    var grid = document.getElementById('blogCardsGrid');
    var items = grid ? Array.prototype.slice.call(grid.querySelectorAll('.blog-grid-item')) : [];
    var searchInput = document.getElementById('blogSearchInput');
    var searchBtn = document.getElementById('blogSearchBtn');
    var pillsWrap = document.getElementById('blogFilterPills');
    var sidebarCats = document.getElementById('blogSidebarCategories');
    var noResults = document.getElementById('blogNoResults');
    var pager = document.getElementById('blogPagination');
    var perPage = 6;
    var currentFilter = 'all';
    var currentPage = 1;

    function matches(item) {
        var text = searchInput ? searchInput.value.trim().toLowerCase() : '';
        var matchesText = !text || item.getAttribute('data-title').indexOf(text) !== -1;
        var matchesFilter = currentFilter === 'all' || item.getAttribute('data-filter') === currentFilter;
        return matchesText && matchesFilter;
    }

    function render() {
        if (!grid) { return; }
        var visible = items.filter(matches);

        items.forEach(function (item) { item.hidden = true; });

        var totalPages = Math.max(1, Math.ceil(visible.length / perPage));
        if (currentPage > totalPages) { currentPage = totalPages; }
        var start = (currentPage - 1) * perPage;
        visible.slice(start, start + perPage).forEach(function (item) { item.hidden = false; });

        if (noResults) { noResults.hidden = visible.length !== 0; }
        grid.style.display = visible.length ? '' : 'none';

        renderPager(totalPages, visible.length);
    }

    function renderPager(totalPages, total) {
        if (!pager) { return; }
        pager.innerHTML = '';
        if (total <= perPage) { return; }

        function makeBtn(label, page, opts) {
            opts = opts || {};
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.innerHTML = label;
            if (opts.active) { btn.classList.add('is-active'); }
            if (opts.disabled) { btn.disabled = true; }
            btn.addEventListener('click', function () {
                currentPage = page;
                render();
                grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
            return btn;
        }

        pager.appendChild(makeBtn('<i data-lucide="chevron-left"></i>', currentPage - 1, { disabled: currentPage <= 1 }));
        for (var p = 1; p <= totalPages; p++) {
            pager.appendChild(makeBtn(String(p), p, { active: p === currentPage }));
        }
        pager.appendChild(makeBtn('<i data-lucide="chevron-right"></i>', currentPage + 1, { disabled: currentPage >= totalPages }));

        if (window.lucide) { lucide.createIcons(); }
    }

    function setFilter(value) {
        currentFilter = value;
        currentPage = 1;
        [pillsWrap, sidebarCats].forEach(function (wrap) {
            if (!wrap) { return; }
            wrap.querySelectorAll('[data-filter]').forEach(function (btn) {
                btn.classList.toggle('is-active', btn.getAttribute('data-filter') === value);
            });
        });
        render();
    }

    if (pillsWrap) {
        pillsWrap.addEventListener('click', function (e) {
            var btn = e.target.closest ? e.target.closest('[data-filter]') : null;
            if (btn) { setFilter(btn.getAttribute('data-filter')); }
        });
    }
    if (sidebarCats) {
        sidebarCats.addEventListener('click', function (e) {
            var btn = e.target.closest ? e.target.closest('[data-filter]') : null;
            if (btn) { setFilter(btn.getAttribute('data-filter')); }
        });
    }
    if (searchInput) {
        searchInput.addEventListener('input', function () { currentPage = 1; render(); });
    }
    if (searchBtn) {
        searchBtn.addEventListener('click', function (e) { e.preventDefault(); currentPage = 1; render(); });
    }

    render();
})();
</script>

@stop
@section('footer')
@stop
