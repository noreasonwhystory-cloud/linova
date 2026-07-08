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

  // 最新の解決事例 carousel
  (function () {
    var track = document.getElementById('solTrack');
    var prev = document.getElementById('solPrev');
    var next = document.getElementById('solNext');
    var dotsWrap = document.getElementById('solDots');
    if (!track) return;
    var cards = [].slice.call(track.children);
    cards.forEach(function (c, i) {
      var b = document.createElement('button');
      b.setAttribute('aria-label', (i + 1) + '枚目');
      b.onclick = function () { track.scrollTo({ left: c.offsetLeft - track.offsetLeft, behavior: 'smooth' }); };
      dotsWrap.appendChild(b);
    });
    var dots = [].slice.call(dotsWrap.children);
    function step() { return track.clientWidth * 0.82; }
    if (prev) prev.onclick = function () { track.scrollBy({ left: -step(), behavior: 'smooth' }); };
    if (next) next.onclick = function () { track.scrollBy({ left: step(), behavior: 'smooth' }); };
    function update() {
      var max = track.scrollWidth - track.clientWidth - 2;
      if (prev) prev.disabled = track.scrollLeft <= 2;
      if (next) next.disabled = track.scrollLeft >= max;
      var idx = 0, best = 1e9;
      cards.forEach(function (c, i) {
        var d = Math.abs(c.offsetLeft - track.offsetLeft - track.scrollLeft);
        if (d < best) { best = d; idx = i; }
      });
      dots.forEach(function (d, i) { d.classList.toggle('active', i === idx); });
    }
    track.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
    update();
  })();

  // FAQ 工事種別フィルタ（/faq/）
  (function () {
    var filter = document.querySelector('.faq-filter');
    if (!filter) return;
    var items = [].slice.call(document.querySelectorAll('.faq-list .faq-item'));
    var empty = document.querySelector('.faq-empty');
    filter.addEventListener('click', function (e) {
      var btn = e.target.closest('[data-filter]');
      if (!btn) return;
      filter.querySelectorAll('.faq-pill').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      var f = btn.getAttribute('data-filter');
      var shown = 0;
      items.forEach(function (it) {
        var cats = (it.getAttribute('data-cats') || '').split(' ');
        var hit = (f === '*') || cats.indexOf(f) !== -1;
        it.classList.toggle('is-hidden', !hit);
        it.open = false;
        if (hit) shown++;
      });
      if (empty) empty.style.display = shown ? 'none' : 'block';
    });
  })();

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
