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
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: { slidesPerView: 1, pagination: { el: ".swiper-pagination", clickable: true } },
            768: { slidesPerView: 3.5, spaceBetween: 20, pagination: false },
        },
    });
 var packageSwiper = new Swiper(".packageSwiper", {
    slidesPerView: "auto",
    spaceBetween: 8,
    loop: false,
    navigation: {
      nextEl: ".packageswiper-button-next",
      prevEl: ".packageswiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      0: {
        slidesPerView: 1, // Show 1 slide on mobile
        pagination: { el: ".swiper-pagination", clickable: true },
      },
      768: {
        slidesPerView: 2.2, // Show 3 full + 10% of 4th
        spaceBetween: 20,
        pagination: false, // Hide dots on larger screens
      },
      1000: {
        slidesPerView: 3.3, // Show 4 full + 10% of 5th
        spaceBetween: 25,
      },
    },
  });
    var testSwiper = new Swiper(".testSwiper", {
    slidesPerView: "auto",
    spaceBetween: 8,
    loop: false,
    navigation: {
      nextEl: ".testswiper-button-next",
      prevEl: ".testswiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      0: {
        slidesPerView: 1, // Show 1 slide on mobile
        pagination: { el: ".swiper-pagination", clickable: true },
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
    var labSwiper = new Swiper(".labSwiper", {
    slidesPerView: "auto",
    spaceBetween: 8,
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
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      0: {
        slidesPerView: 1, // Show 1 slide on mobile
        // pagination: { el: ".swiper-pagination", clickable: true },
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
  document.addEventListener("DOMContentLoaded", function() {
        let description = document.querySelector(".descriptiontxt");
        let btn = document.querySelector(".read-more-btn");

        btn.addEventListener("click", function() {
            if (description.classList.contains("expanded")) {
                description.classList.remove("expanded");
                btn.textContent = "Read More";
            } else {
                description.classList.add("expanded");
                btn.textContent = "Read Less";
            }
        });
    });
  