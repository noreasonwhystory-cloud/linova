(function () {
  if (window.lucide && typeof lucide.createIcons === 'function') {
    lucide.createIcons();
  }

  // mobile nav overlay
  var menu = document.getElementById('navmenu');
  var openNav = document.getElementById('openNav');
  var closeNav = document.getElementById('closeNav');
  function setNav(open) {
    if (!menu) return;
    menu.classList.toggle('open', open);
    if (openNav) openNav.setAttribute('aria-expanded', open ? 'true' : 'false');
    menu.setAttribute('aria-hidden', open ? 'false' : 'true');
  }
  if (menu) setNav(false);
  if (menu && openNav) openNav.onclick = function () { setNav(true); };
  if (menu && closeNav) closeNav.onclick = function () { setNav(false); };
  document.querySelectorAll('[data-nav]').forEach(function (a) {
    a.addEventListener('click', function () { setNav(false); });
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

  // 施工事例 一覧ページ (.wl-page) — フィルタ + もっと見る
  (function () {
    var grid = document.getElementById('wlGrid');
    if (!grid) return;
    var cards = [].slice.call(grid.querySelectorAll('.wl-card'));
    var chips = [].slice.call(document.querySelectorAll('.wl-chip'));
    var moreWrap = document.getElementById('wlMore');
    var moreBtn = document.getElementById('wlMoreBtn');
    var empty = document.getElementById('wlEmpty');
    var cat = 'all', expanded = false;
    var INIT = 6;
    function matches(c) { return cat === 'all' || (c.dataset.cat || '').split(' ').indexOf(cat) !== -1; }
    function render() {
      var shown = cards.filter(matches);
      cards.forEach(function (c) { c.classList.add('is-hidden'); });
      var limit = (cat === 'all' && !expanded) ? INIT : shown.length;
      shown.slice(0, limit).forEach(function (c) { c.classList.remove('is-hidden'); c.classList.add('reveal-in'); });
      var hasMore = cat === 'all' && !expanded && shown.length > INIT;
      if (moreWrap) moreWrap.style.display = hasMore ? '' : 'none';
      if (empty) empty.classList.toggle('show', shown.length === 0);
    }
    chips.forEach(function (chip) {
      chip.addEventListener('click', function () {
        chips.forEach(function (c) { c.classList.remove('active'); });
        chip.classList.add('active');
        cat = chip.dataset.cat; expanded = false;
        render();
      });
    });
    if (moreBtn) moreBtn.addEventListener('click', function () { expanded = true; render(); });
    render();

    // reveal
    var targets = [].slice.call(document.querySelectorAll('.wl-head,.wl-card'));
    targets.forEach(function (el) { el.classList.add('reveal'); });
    function reveal() {
      var vh = window.innerHeight || document.documentElement.clientHeight;
      for (var i = targets.length - 1; i >= 0; i--) {
        var r = targets[i].getBoundingClientRect();
        if (r.top < vh * 0.94 && r.bottom > 0) { targets[i].classList.add('reveal-in'); targets.splice(i, 1); }
      }
    }
    requestAnimationFrame(function () { requestAnimationFrame(reveal); });
    window.addEventListener('scroll', reveal, { passive: true });
    window.addEventListener('resize', reveal);
    setTimeout(function () { document.querySelectorAll('.wl-card.reveal').forEach(function (el) { el.classList.add('reveal-in'); }); }, 4500);
  })();

  // 施工事例 詳細ページ (.case-page)
  (function () {
    var page = document.querySelector('.case-page');
    if (!page) return;

    // ギャラリー: サムネ slider + メイン差し替え
    var track = document.getElementById('galTrack');
    var main = document.getElementById('galMain');
    if (track) {
      var prev = document.getElementById('galPrev');
      var next = document.getElementById('galNext');
      var thumbs = [].slice.call(track.querySelectorAll('.gal-thumb'));
      function pageW() { return Math.max(track.clientWidth * 0.8, 120); }
      function update() {
        var max = track.scrollWidth - track.clientWidth - 2;
        if (prev) prev.disabled = track.scrollLeft <= 2;
        if (next) next.disabled = track.scrollLeft >= max;
      }
      if (prev) prev.onclick = function () { track.scrollLeft -= pageW(); };
      if (next) next.onclick = function () { track.scrollLeft += pageW(); };
      track.addEventListener('scroll', update, { passive: true });
      window.addEventListener('resize', update);
      update();
      thumbs.forEach(function (t) {
        t.addEventListener('click', function () {
          thumbs.forEach(function (x) { x.classList.remove('active'); });
          t.classList.add('active');
          var im = t.querySelector('img');
          if (im && main) { main.src = im.src; main.alt = im.alt; }
        });
      });
      if (thumbs[0]) thumbs[0].classList.add('active');
    }

    // ケース別 FAQ アコーディオン
    page.querySelectorAll('.cd-faq .cd-faq-q').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var faq = btn.closest('.cd-faq');
        var ans = faq.querySelector('.cd-faq-a');
        var open = faq.classList.toggle('open');
        ans.style.maxHeight = open ? (ans.scrollHeight + 'px') : '0px';
      });
    });

    // reveal
    var targets = [].slice.call(page.querySelectorAll('.cd-gallery,.cd-head,.cd-meta .m,.cstep,.cd-faq'));
    targets.forEach(function (el) { el.classList.add('reveal'); });
    function reveal() {
      var vh = window.innerHeight || document.documentElement.clientHeight;
      for (var i = targets.length - 1; i >= 0; i--) {
        var r = targets[i].getBoundingClientRect();
        if (r.top < vh * 0.92 && r.bottom > 0) { targets[i].classList.add('reveal-in'); targets.splice(i, 1); }
      }
    }
    requestAnimationFrame(function () { requestAnimationFrame(reveal); });
    window.addEventListener('scroll', reveal, { passive: true });
    window.addEventListener('resize', reveal);
    setTimeout(function () { page.querySelectorAll('.reveal').forEach(function (el) { el.classList.add('reveal-in'); }); }, 4500);
  })();

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
