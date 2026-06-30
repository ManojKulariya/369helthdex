<style>
.custom_blog_card {
    position: relative;
    width: 100%;
    height: 200px;
    border-radius: 10px;
    overflow: hidden;
    transition: 0.3s ease-in-out;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.custom_blog_img {
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.custom_blog_img img {
    width: 100%;
    height: 395px;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
}

.custom_blog_card:hover .custom_blog_img img {
    transform: scale(1.05);
}

.custom_blog_content {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background: rgba(255, 255, 255, 0.8); /* White background with slight transparency */
    padding: 10px;
    box-sizing: border-box;
    text-align: center;
    border-radius: 0 0 10px 10px;
}

.blog_title {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

.custom_blog_bottom {
    font-size: 12px;
    color: #777;
}

.custom_blog_link {
    margin-top: 5px;
}

.custom_blog_link a {
    font-size: 14px;
    font-weight: bold;
    color: white;
    text-decoration: none;
}
</style>
<section class="blog_section bg-color-3 sec-pad">
  <div class="auto-container">
    <div class="sec-title text-center">
      <h4 class="newstyle">Our Blogs</h4>
      <div class="custom-swiper-nav">
        <button class="blogSwiper-button-prev btn-pre d-none d-md-block"><i class="fa fa-chevron-left"></i></button>
        <button class="blogSwiper-button-next btn-next d-none d-md-block"><i class="fa fa-chevron-right"></i></button>
      </div>
    </div>

    <div class="swiper blogSwiper">
      <div class="swiper-wrapper">
        @foreach($blogdata as $c)
         <div class="swiper-slide">
            <div class="testimonial-block-two">
                
                <!-- Image -->
                <div class="custom_blog_img">
                    <img src="{{ asset('storage/app/public/Blog') . '/' . $c->image }}" alt="{{ $c->name }}" />
                </div>
            
                <!-- Overlay Content -->
                <div class="custom_blog_content">
                    <span class="blog_title">{{ Str::limit($c->name, 38, '...') }}</span>
                    <div class="custom_blog_bottom">
                        <span class="author"><strong>HealthDex 369</strong> {{ \Carbon\Carbon::parse($c->created_at)->format('d M Y') }}</span>
                    </div>
                    <div class="custom_blog_link">
                        <a class="read_more" href="{{ route('blog_detail', ['slug' => $c->slug]) }}">Continue Reading</a>
                    </div>
                </div>
            </div>
          </div>
        @endforeach
      </div>
      
      <div class="swiper-pagination d-md-none " style="position: relative !important;  margin-top: 15px; text-align: center;"></div>
    </div>
  </div>
</section>
<script>
  var blogSwiper = new Swiper(".blogSwiper", {
    slidesPerView: "auto",
    spaceBetween: 8,
    autoplay: {
        delay: 3000, // Change slide every 3 seconds
        disableOnInteraction: false, // Continue autoplay even after user interaction
      },
    loop: false,
    navigation: {
      nextEl: ".blogSwiper-button-next",
      prevEl: ".blogSwiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      0: {
        slidesPerView: 1, // Show 1 slide on mobile
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
            dynamicMainBullets: 5,
          },
      },
      768: {
        slidesPerView: 2.2, // Show 3 full + 10% of 4th
        spaceBetween: 20,
        pagination: false, // Hide dots on larger screens
      },
      1000: {
        slidesPerView: 3.2, // Show 4 full + 10% of 5th
        spaceBetween: 25,
      },
    },
  });
</script>
