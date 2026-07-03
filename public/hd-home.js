/* ==========================================================================
   HealthDex 369 — Premium homepage interactions
   Reveal-on-scroll (IntersectionObserver), animated counters, button ripple,
   magnetic buttons, hero mouse parallax, FAQ accordion, category slider.
   No dependencies (Swiper is optional and feature-detected).
   ========================================================================== */
(function () {
  'use strict';

  var reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var finePointer = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  function ready(fn) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn);
    } else {
      fn();
    }
  }

  /* ------------------------------------------------------------------
     1. Scroll reveal via IntersectionObserver (falls back to the scroll
        handler already present in the layout when IO is unavailable).
     ------------------------------------------------------------------ */
  function initReveal() {
    if (!('IntersectionObserver' in window)) return;
    var targets = document.querySelectorAll('.reveal:not(.active)');
    if (!targets.length) return;

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
          io.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.05 });

    targets.forEach(function (el) { io.observe(el); });
  }

  /* ------------------------------------------------------------------
     2. Animated counters — [data-hd-counter]
        Parses the server-rendered text ("75+", "25M+", "4.9★") and counts
        up to it when visible. Always ends on the exact original text.
     ------------------------------------------------------------------ */
  function initCounters() {
    var els = document.querySelectorAll('[data-hd-counter]');
    if (!els.length) return;

    function animate(el) {
      var original = el.textContent.trim();
      var match = original.match(/^([^0-9]*)([0-9]+(?:[.,][0-9]+)?)(.*)$/);
      if (!match) return;

      var prefix = match[1];
      var numText = match[2];
      var suffix = match[3];
      var decimalChar = numText.indexOf(',') > -1 ? ',' : '.';
      var target = parseFloat(numText.replace(',', '.'));
      var decimals = (numText.split(/[.,]/)[1] || '').length;
      if (isNaN(target)) return;

      var duration = 1400;
      var start = null;

      function frame(ts) {
        if (start === null) start = ts;
        var progress = Math.min((ts - start) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3); /* easeOutCubic */
        var value = (target * eased).toFixed(decimals);
        if (decimals > 0 && decimalChar === ',') value = value.replace('.', ',');
        el.textContent = prefix + value + suffix;
        if (progress < 1) {
          requestAnimationFrame(frame);
        } else {
          el.textContent = original;
        }
      }
      requestAnimationFrame(frame);
    }

    if (reducedMotion || !('IntersectionObserver' in window)) return;

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animate(entry.target);
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.4 });

    els.forEach(function (el) { io.observe(el); });
  }

  /* ------------------------------------------------------------------
     3. Button ripple (event delegation, pointer-accurate)
     ------------------------------------------------------------------ */
  var RIPPLE_SELECTOR = [
    '.premium-btn-primary',
    '.booking-cta-button',
    '.luxury-hero-search-btn',
    '.luxury-header-cta',
    '.footer-btn-primary',
    '.read-more-btn',
    '.faq-header-cta',
    '.hd-callback-fab'
  ].join(',');

  function initRipple() {
    if (reducedMotion) return;
    document.addEventListener('click', function (e) {
      var host = e.target.closest ? e.target.closest(RIPPLE_SELECTOR) : null;
      if (!host) return;

      host.classList.add('hd-ripple-host');
      var rect = host.getBoundingClientRect();
      var size = Math.max(rect.width, rect.height);
      var x = (e.clientX || rect.left + rect.width / 2) - rect.left - size / 2;
      var y = (e.clientY || rect.top + rect.height / 2) - rect.top - size / 2;

      var ripple = document.createElement('span');
      ripple.className = 'hd-ripple';
      ripple.style.width = size + 'px';
      ripple.style.height = size + 'px';
      ripple.style.left = x + 'px';
      ripple.style.top = y + 'px';
      host.appendChild(ripple);
      ripple.addEventListener('animationend', function () {
        if (ripple.parentNode) ripple.parentNode.removeChild(ripple);
      });
    }, { passive: true });
  }

  /* ------------------------------------------------------------------
     4. Magnetic buttons (desktop, fine pointers only)
        Uses the standalone `translate` property so CSS hover transforms
        and keyframe animations keep working alongside it.
     ------------------------------------------------------------------ */
  var MAGNETIC_SELECTOR = [
    '.packages-swiper-btn',
    '.tests-swiper-btn',
    '.categories-swiper-btn',
    '.custom-swiper-nav button',
    '.luxury-header-cta'
  ].join(',');

  function initMagnetic() {
    if (reducedMotion || !finePointer) return;
    if (!(window.CSS && CSS.supports && CSS.supports('translate', '1px 1px'))) return;

    document.querySelectorAll(MAGNETIC_SELECTOR).forEach(function (el) {
      var strength = 0.28;
      var max = 6;

      el.addEventListener('mousemove', function (e) {
        var rect = el.getBoundingClientRect();
        var dx = (e.clientX - rect.left - rect.width / 2) * strength;
        var dy = (e.clientY - rect.top - rect.height / 2) * strength;
        dx = Math.max(-max, Math.min(max, dx));
        dy = Math.max(-max, Math.min(max, dy));
        el.style.translate = dx.toFixed(1) + 'px ' + dy.toFixed(1) + 'px';
      });
      el.addEventListener('mouseleave', function () {
        el.style.translate = '';
      });
    });
  }

  /* ------------------------------------------------------------------
     5. Hero mouse parallax — [data-hd-parallax="strength"]
        Also drifts the ambient blobs. rAF-throttled, transform-composed
        via the `translate` property (GPU only, no layout shifts).
     ------------------------------------------------------------------ */
  function initParallax() {
    if (reducedMotion || !finePointer) return;
    if (!(window.CSS && CSS.supports && CSS.supports('translate', '1px 1px'))) return;

    var hero = document.querySelector('.luxury-hero');
    if (!hero) return;

    var items = [];
    hero.querySelectorAll('[data-hd-parallax]').forEach(function (el) {
      items.push({ el: el, depth: parseFloat(el.getAttribute('data-hd-parallax')) || 12 });
    });
    hero.querySelectorAll('.luxury-hero-blob').forEach(function (el) {
      items.push({ el: el, depth: 22 });
    });
    if (!items.length) return;

    var targetX = 0, targetY = 0, curX = 0, curY = 0, rafId = null;

    function tick() {
      curX += (targetX - curX) * 0.08;
      curY += (targetY - curY) * 0.08;
      items.forEach(function (item) {
        var x = (curX * item.depth).toFixed(2);
        var y = (curY * item.depth).toFixed(2);
        item.el.style.translate = x + 'px ' + y + 'px';
      });
      if (Math.abs(targetX - curX) > 0.001 || Math.abs(targetY - curY) > 0.001) {
        rafId = requestAnimationFrame(tick);
      } else {
        rafId = null;
      }
    }

    function schedule() {
      if (rafId === null) rafId = requestAnimationFrame(tick);
    }

    hero.addEventListener('mousemove', function (e) {
      var rect = hero.getBoundingClientRect();
      targetX = ((e.clientX - rect.left) / rect.width - 0.5);
      targetY = ((e.clientY - rect.top) / rect.height - 0.5);
      schedule();
    }, { passive: true });

    hero.addEventListener('mouseleave', function () {
      targetX = 0;
      targetY = 0;
      schedule();
    }, { passive: true });
  }

  /* ------------------------------------------------------------------
     6. FAQ accordion (single open, accessible)
     ------------------------------------------------------------------ */
  function initFaq() {
    var accordion = document.getElementById('hdFaqAccordion');
    if (!accordion) return;

    accordion.addEventListener('click', function (e) {
      var button = e.target.closest ? e.target.closest('.hd-faq-question') : null;
      if (!button) return;

      var item = button.parentElement;
      var isOpen = item.classList.contains('open');

      accordion.querySelectorAll('.hd-faq-item.open').forEach(function (other) {
        other.classList.remove('open');
        var q = other.querySelector('.hd-faq-question');
        if (q) q.setAttribute('aria-expanded', 'false');
      });

      if (!isOpen) {
        item.classList.add('open');
        button.setAttribute('aria-expanded', 'true');
      }
    });
  }

  /* ------------------------------------------------------------------
     7. Categories slider (only when Swiper + markup are present)
     ------------------------------------------------------------------ */
  function initCategorySwiper() {
    if (typeof window.Swiper === 'undefined') return;
    if (!document.querySelector('.categorySwiper .swiper-slide')) return;

    /* With fewer cards than the widest view (6), loop/autoplay stay off and
       the cards render as plain LEFT-aligned items. */
    var count = document.querySelectorAll('.categorySwiper .swiper-slide').length;

    new window.Swiper('.categorySwiper', {
      slidesPerView: 2,
      spaceBetween: 12,
      loop: count > 6,
      loopAddBlankSlides: false,
      watchOverflow: true,
      centerInsufficientSlides: false,
      grabCursor: true,
      speed: 600,
      autoplay: count > 6 ? {
        delay: 3000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true
      } : false,
      navigation: {
        nextEl: '.categorySwiper-button-next',
        prevEl: '.categorySwiper-button-prev'
      },
      pagination: {
        el: '.categorySwiper-pagination',
        clickable: true
      },
      breakpoints: {
        0: { slidesPerView: 2, spaceBetween: 10 },
        600: { slidesPerView: 3, spaceBetween: 14 },
        900: { slidesPerView: 4, spaceBetween: 16 },
        1200: { slidesPerView: 6, spaceBetween: 16 }
      }
    });
  }

  ready(function () {
    initReveal();
    initCounters();
    initRipple();
    initMagnetic();
    initParallax();
    initFaq();
    initCategorySwiper();
  });
})();
