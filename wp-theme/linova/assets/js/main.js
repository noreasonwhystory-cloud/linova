(function () {
  if (window.lucide && typeof lucide.createIcons === 'function') {
    lucide.createIcons();
  }

  // mobile nav overlay
  var menu = document.getElementById('navmenu');
  var openNav = document.getElementById('openNav');
  var closeNav = document.getElementById('closeNav');
  if (menu && openNav) openNav.onclick = function () { menu.classList.add('open'); };
  if (menu && closeNav) closeNav.onclick = function () { menu.classList.remove('open'); };
  document.querySelectorAll('[data-nav]').forEach(function (a) {
    a.addEventListener('click', function () { if (menu) menu.classList.remove('open'); });
  });

  // header solid state + mobile CTA bar after scroll
  var hdr = document.querySelector('.hdr');
  var mcta = document.getElementById('mCta');
  var hero = document.getElementById('top');
  function onScroll() {
    if (hdr) hdr.classList.toggle('scrolled', window.scrollY > 40);
    if (mcta && hero) {
      var trigger = hero.offsetTop + hero.offsetHeight - 260;
      mcta.classList.toggle('show', window.scrollY > trigger);
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);
  onScroll();

  // scroll-linked fade-in (PC + mobile)
  (function () {
    var groups = [
      ['.hero-top'],
      ['.about-tx', '.about-media'],
      ['.flow-head'], ['.flow-step'],
      ['.svc'],
      ['.works-head'], ['.case'],
      ['.str'],
      ['.cta-in'],
      ['.map', '.area-side'],
      ['.contact-intro', '.form-card']
    ];
    var targets = [];
    groups.forEach(function (sel) {
      document.querySelectorAll(sel.join(',')).forEach(function (el, i) {
        el.classList.add('reveal');
        el.style.transitionDelay = (Math.min(i, 5) * 80) + 'ms';
        targets.push(el);
      });
    });
    function reveal() {
      var vh = window.innerHeight || document.documentElement.clientHeight;
      for (var i = targets.length - 1; i >= 0; i--) {
        var el = targets[i];
        var r = el.getBoundingClientRect();
        if (r.top < vh * 0.9 && r.bottom > 0) { el.classList.add('reveal-in'); targets.splice(i, 1); }
      }
    }
    requestAnimationFrame(function () { requestAnimationFrame(reveal); });
    window.addEventListener('scroll', reveal, { passive: true });
    window.addEventListener('resize', reveal);
    setTimeout(function () {
      document.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('reveal-in'); });
    }, 4500);
  })();
})();
