   var swiper = new Swiper(".mySwiper", {
        slidesPerView: "auto",
        spaceBetween: 8,
        loop: false,
         rtl: true,
        navigation: {
            nextEl: ".swiper-button-next", // Unique class
            prevEl: ".swiper-button-prev", // Unique class
        },
        breakpoints: {
            0: { slidesPerView: 2.2, spaceBetween: 6 },
            600: { slidesPerView: 2.5, spaceBetween: 10 },
            1000: { slidesPerView: 5.4, spaceBetween: 18 },
        },
    });

    var offerSwiper = new Swiper(".offerSwiper", {
        slidesPerView: "auto",
        spaceBetween: 8,
        loop: false,
        navigation: {
            nextEl: ".offerSwiper-button-next", // Unique class
            prevEl: ".offerSwiper-button-prev", // Unique class
        },
        pagination: {
            el: ".offerSwiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: { slidesPerView: 1, pagination: { el: ".offerSwiper-pagination", clickable: true } },
            768: { slidesPerView: 3.5, spaceBetween: 20, pagination: false },
        },
    });
 // Shared premium carousel config (Top Health Packages + Popular Tests)
  var hdCarouselBase = {
    slidesPerView: 1,
    spaceBetween: 24,
    loop: true,                 // infinite loop
    loopAddBlankSlides: false,  // never pad with blank slides when data is short
    watchOverflow: true,        // auto-disable (lock) when there aren't enough slides
    centerInsufficientSlides: false, // 1-3 cards align LEFT, never centered
    grabCursor: true,
    speed: 650,                 // smooth transition
    autoplay: {
      delay: 3500,              // auto slide every 3.5s
      disableOnInteraction: false,
      pauseOnMouseEnter: true,  // pause on hover
    },
    breakpoints: {
      0:    { slidesPerView: 1, spaceBetween: 16 }, // mobile: 1
      768:  { slidesPerView: 2, spaceBetween: 20 }, // tablet: 2
      1200: { slidesPerView: 4, spaceBetween: 24 }, // desktop: 4
    },
  };

  // Count real slides first: with fewer cards than the desktop view (4),
  // loop/autoplay stay off and the cards render as plain LEFT-aligned items.
  var hdPkgCount = document.querySelectorAll(".packageSwiper .swiper-slide").length;
  var packageSwiper = new Swiper(".packageSwiper", Object.assign({}, hdCarouselBase, {
    loop: hdPkgCount > 4,
    autoplay: hdPkgCount > 4 ? hdCarouselBase.autoplay : false,
    navigation: {
      nextEl: ".packageswiper-button-next",
      prevEl: ".packageswiper-button-prev",
    },
    pagination: {
      el: ".packageSwiper-pagination",
      clickable: true,
    },
  }));

  var hdTestCount = document.querySelectorAll(".testSwiper .swiper-slide").length;
  var testSwiper = new Swiper(".testSwiper", Object.assign({}, hdCarouselBase, {
    loop: hdTestCount > 4,
    autoplay: hdTestCount > 4 ? hdCarouselBase.autoplay : false,
    navigation: {
      nextEl: ".testswiper-button-next",
      prevEl: ".testswiper-button-prev",
    },
    pagination: {
      el: ".testSwiper-pagination",
      clickable: true,
    },
  }));
    var labSwiper = new Swiper(".labSwiper", {
    slidesPerView: "auto",
    spaceBetween: 8,
    centerInsufficientSlides: true,
     autoplay: {
        delay: 3000, // Change slide every 3 seconds
        disableOnInteraction: false, // Continue autoplay even after user interaction
      },
    loop: false,
    navigation: {
      nextEl: ".labSwiper-button-next",
      prevEl: ".labSwiper-button-prev",
    },
    pagination: {
      el: ".labSwiper-pagination",
      clickable: true,
    },
    breakpoints: {
      0: {
        slidesPerView: 1, // Show 1 slide on mobile
        pagination: {
        el: ".labSwiper-pagination",
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
  document.addEventListener("DOMContentLoaded", function() {
        let description = document.querySelector(".descriptiontxt");
        let btn = document.querySelector(".read-more-btn");

        if (btn && description) {
            btn.addEventListener("click", function() {
                if (description.classList.contains("expanded")) {
                    description.classList.remove("expanded");
                    btn.textContent = "Read More";
                } else {
                    description.classList.add("expanded");
                    btn.textContent = "Read Less";
                }
            });
        }
    });
