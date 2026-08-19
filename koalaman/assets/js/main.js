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

(function () {
  // Dark mode toggle — flood-fills from the button using the View
  // Transitions API where available; falls back to an instant,
  // flicker-free swap everywhere else.
  var toggle = document.getElementById('theme-toggle');
  if (!toggle) return;

  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    try {
      localStorage.setItem('koalaman-theme', theme);
    } catch (e) {}
  }

  toggle.addEventListener('click', function (event) {
    var current = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
    var next = current === 'dark' ? 'light' : 'dark';

    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion || typeof document.startViewTransition !== 'function') {
      applyTheme(next);
      return;
    }

    // Use the actual pointer position when available (accurate regardless
    // of mobile browser chrome resizing the viewport mid-interaction).
    // Keyboard-triggered clicks report (0,0), so fall back to the
    // button's own center in that case.
    var x = event.clientX;
    var y = event.clientY;
    if (!x && !y) {
      var rect = toggle.getBoundingClientRect();
      x = rect.left + rect.width / 2;
      y = rect.top + rect.height / 2;
    }

    var vw = window.visualViewport ? window.visualViewport.width : window.innerWidth;
    var vh = window.visualViewport ? window.visualViewport.height : window.innerHeight;
    var endRadius = Math.hypot(
      Math.max(x, vw - x),
      Math.max(y, vh - y)
    );

    var transition = document.startViewTransition(function () {
      applyTheme(next);
    });

    transition.ready.then(function () {
      document.documentElement.animate(
        {
          clipPath: [
            'circle(0px at ' + x + 'px ' + y + 'px)',
            'circle(' + endRadius + 'px at ' + x + 'px ' + y + 'px)'
          ]
        },
        {
          duration: 550,
          easing: 'ease-in-out',
          pseudoElement: '::view-transition-new(root)'
        }
      );
    }).catch(function () {
      // If the transition API rejects for any reason, the theme is
      // already applied above — nothing further to do.
    });
  });
})();
