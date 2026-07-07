document.addEventListener('DOMContentLoaded', function () {
  initPageReveal();
  initMobileToggle();
  initDropdownNavigation();
  initCurrentNav();
  initBreadcrumbCollapse();
  initLoadMore();
});

/* ============================================================
   Page Reveal — 移除初始隱藏，觸發淡入（CSS: html.page-ready）
   ============================================================ */
function initPageReveal() {
  document.documentElement.classList.add('page-ready');
}

/* ============================================================
   Mobile Hamburger Toggle
   - Toggles .show on .nav-content-wrapper（CSS 控制顯示）
   - 同步 aria-expanded 在 .nav-toggle 上
   ============================================================ */
function initMobileToggle() {
  const toggle = document.querySelector('.nav-toggle');
  const wrapper = document.querySelector('.nav-content-wrapper');
  if (!toggle || !wrapper) return;

  function closeWrapper() {
    if (!wrapper.classList.contains('show')) return;
    wrapper.classList.add('closing');
    document.body.classList.remove('nav-open');
    wrapper.addEventListener(
      'animationend',
      () => {
        wrapper.classList.remove('show', 'closing');
      },
      { once: true }
    );
  }

  toggle.addEventListener('click', (e) => {
    e.stopPropagation();
    const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!isExpanded));
    if (isExpanded) {
      closeWrapper();
    } else {
      wrapper.classList.remove('closing');
      wrapper.classList.add('show');
      document.body.classList.add('nav-open');
    }
  });

  // 視窗放大超過 hamburger 斷點時，重置狀態避免殘留鎖定捲動
  window.addEventListener('resize', () => {
    if (window.innerWidth >= 1024 && wrapper.classList.contains('show')) {
      wrapper.classList.remove('show', 'closing');
      toggle.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('nav-open');
    }
  });

  // 點擊 nav-bar 外部：收合 wrapper
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.nav-bar')) {
      closeAllDropdowns();
      closeWrapper();
      toggle.setAttribute('aria-expanded', 'false');
    }
  });
}

/* ============================================================
   Dropdown Navigation
   - 監聽 .nav-dropdown-button 的 click（而非整個 .nav li）
   - 用 .active class 控制展開（CSS 處理 display / opacity）
   - 同步 aria-expanded
   - 一次只開一個：開新的前先關其他
   ============================================================ */
function initDropdownNavigation() {
  const buttons = document.querySelectorAll('.nav-dropdown-button');

  buttons.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();

      const parentNav = btn.closest('.nav');
      const isActive = parentNav.classList.contains('active');

      // 關閉其他已展開的選單
      closeAllDropdowns();

      // 若原本是關閉的，現在打開；若原本是開著的，closeAllDropdowns 已關掉
      if (!isActive) {
        parentNav.classList.add('active');
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });

  // 點擊 .nav 外部（但在 nav-bar 內）也關閉
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.nav')) {
      closeAllDropdowns();
    }
  });

  // 捲動時關閉（desktop 浮層用）
  window.addEventListener('scroll', closeAllDropdowns);

  // 鍵盤：Escape 關閉並回焦
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      const openBtn = document.querySelector('.nav-dropdown-button[aria-expanded="true"]');
      closeAllDropdowns();
      if (openBtn) openBtn.focus();
    }
  });
}

/* ============================================================
   Helper：關閉所有下拉選單
   ============================================================ */
function closeAllDropdowns() {
  document.querySelectorAll('.nav.active').forEach((nav) => {
    nav.classList.remove('active');
    const btn = nav.querySelector('.nav-dropdown-button');
    if (btn) btn.setAttribute('aria-expanded', 'false');
  });
}

/* ============================================================
   Current Nav — 依當前路徑標記 .is-current / .is-current-item
   ============================================================ */
function initCurrentNav() {
  const path = window.location.pathname;
  // 取最後一段檔名（e.g. "/about.html" → "about.html"；"/" → "index.html"）
  let page = path.split('/').pop() || 'index.html';

  // 子頁面對應表：detail 頁 → 其所屬的 nav dropdown 父頁
  const parentPageMap = {
    'meetings_detail.html': 'minutes.html',
    'news_detail.html': 'news.html',
    'campaign_article.html': 'campaign_overview.html',
    'knowledge_article.html': 'knowledge.html',
  };
  const effectivePage = parentPageMap[page] ?? page;

  // 直接連結（最新消息）
  document.querySelectorAll('.nav-link[href]').forEach((link) => {
    if (link.getAttribute('href') === effectivePage) {
      link.closest('.nav')?.classList.add('is-current');
    }
  });

  // Dropdown 子項目
  document.querySelectorAll('.nav-dropdown-item[href]').forEach((item) => {
    if (item.getAttribute('href') === effectivePage) {
      item.classList.add('is-current-item');
      item.closest('.nav')?.classList.add('is-current');
    }
  });
}

/* ============================================================
   Breadcrumb Collapse — 手機板超過 page-header 一半寬度才折疊
   ============================================================ */
function initBreadcrumbCollapse() {
  const breadcrumbs = document.querySelectorAll('.breadcrumb');
  if (!breadcrumbs.length) return;

  function updateCollapse() {
    if (window.innerWidth > 767) {
      breadcrumbs.forEach((bc) => bc.classList.remove('collapsed'));
      return;
    }
    breadcrumbs.forEach((bc) => {
      const header = bc.closest('.page-header');
      if (!header) return;
      const threshold = header.getBoundingClientRect().width * 0.5;
      // 暫時移除 collapsed 取得真實展開寬度
      bc.classList.remove('collapsed');
      const fullWidth = bc.scrollWidth;
      if (fullWidth > threshold) {
        bc.classList.add('collapsed');
      }
    });
  }

  updateCollapse();

  const ro = new ResizeObserver(updateCollapse);
  document.querySelectorAll('.page-header').forEach((h) => ro.observe(h));
}

/* ============================================================
   Load More — 點擊「查看更多」展開全部，點擊「收合」折疊回初始狀態
   HTML: <ul id="grid-xxx"> + <div class="more" data-target="grid-xxx">
   ============================================================ */
function initLoadMore() {
  document.querySelectorAll('.more[data-target]').forEach((btn) => {
    const grid = document.getElementById(btn.dataset.target);
    if (!grid) return;

    // 記錄初始隱藏的卡片（頁面載入時已有 is-hidden 的）
    const initiallyHidden = new Set(
      Array.from(grid.querySelectorAll('.card-meeting.is-hidden'))
    );

    btn.addEventListener('click', () => {
      const isExpanded = btn.dataset.expanded === 'true';

      if (!isExpanded) {
        // 展開全部
        initiallyHidden.forEach((card) => card.classList.remove('is-hidden'));
        btn.textContent = '收合';
        btn.dataset.expanded = 'true';
      } else {
        // 收合回初始狀態
        initiallyHidden.forEach((card) => card.classList.add('is-hidden'));
        btn.textContent = '查看更多';
        btn.dataset.expanded = 'false';
      }
    });
  });
}
