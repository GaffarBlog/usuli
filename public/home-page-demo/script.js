/* ================================================================
   উসুলি — homepage interactions
   Kept intentionally small: reveal-on-scroll, image fade-in,
   mobile menu. All motion respects prefers-reduced-motion.
   ================================================================ */
(function () {
  "use strict";

  var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* ---- Mobile menu toggle ---- */
  var toggle = document.getElementById("menuToggle");
  var panel = document.getElementById("mobileNav");

  if (toggle && panel) {
    toggle.addEventListener("click", function () {
      var open = toggle.getAttribute("aria-expanded") === "true";
      toggle.setAttribute("aria-expanded", String(!open));
      panel.hidden = open;
    });

    // Close the panel when a link is chosen or on resize to desktop
    panel.addEventListener("click", function (e) {
      if (e.target.closest("a")) {
        toggle.setAttribute("aria-expanded", "false");
        panel.hidden = true;
      }
    });
    window.addEventListener("resize", function () {
      if (window.innerWidth > 1000 && !panel.hidden) {
        toggle.setAttribute("aria-expanded", "false");
        panel.hidden = true;
      }
    });
  }

  /* ---- Fade photos in once they load (over the duotone placeholder) ---- */
  function markLoaded(img) { img.classList.add("is-loaded"); }
  var photos = document.querySelectorAll(".ph img");
  photos.forEach(function (img) {
    if (img.complete && img.naturalWidth > 0) {
      markLoaded(img);
    } else {
      img.addEventListener("load", function () { markLoaded(img); });
      img.addEventListener("error", function () {
        // leave the elegant duotone placeholder in place
        img.remove();
      });
    }
  });

  /* ---- Reveal on scroll ---- */
  var revealables = document.querySelectorAll(".reveal");
  if (reduceMotion || !("IntersectionObserver" in window)) {
    revealables.forEach(function (el) { el.classList.add("is-visible"); });
  } else {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: "0px 0px -8% 0px" });

    // Stagger siblings within a shared parent for a gentle cascade
    revealables.forEach(function (el, i) {
      var delay = Math.min((i % 6) * 70, 350);
      el.style.transitionDelay = delay + "ms";
      io.observe(el);
    });
  }
})();
