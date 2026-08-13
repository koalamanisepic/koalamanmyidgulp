(function () {
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.querySelector('.nav-primary');

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var isOpen = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    // Close the mobile menu when a nav link is followed.
    nav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  }
})();

(function () {
  // Scroll-reveal: fade/slide sections up as they enter the viewport.
  var revealEls = document.querySelectorAll('.reveal');
  if (!revealEls.length) return;

  var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (prefersReducedMotion || !('IntersectionObserver' in window)) {
    revealEls.forEach(function (el) { el.classList.add('is-visible'); });
    return;
  }

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

  revealEls.forEach(function (el) { io.observe(el); });
})();

(function () {
  // Clown mascot: honk animation + sound on click.
  var mascot = document.getElementById('clown-mascot');
  var audio = document.getElementById('clown-audio');
  if (!mascot || !audio) return;

  mascot.addEventListener('click', function () {
    mascot.classList.remove('is-honking');
    void mascot.offsetWidth; // force reflow so the animation can restart
    mascot.classList.add('is-honking');

    try {
      audio.currentTime = 0;
      audio.play();
    } catch (e) {
      // Autoplay/interaction restrictions — safe to ignore, the visual still plays.
    }
  });

  mascot.addEventListener('animationend', function (e) {
    if (e.animationName === 'clown-honk') {
      mascot.classList.remove('is-honking');
    }
  });
})();
