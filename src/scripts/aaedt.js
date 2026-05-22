document.addEventListener('DOMContentLoaded', function () {
  initPageReveal();
  initNavOffset();
  initMobileToggle();
  initDropdownNavigation();
  initExternalLinks();
});

/* ============================================================
   Nav Offset — 動態偵測 nav-bar 高度，依斷點分別補償
   < 1024px：nav 為 fixed → 對 .final 補 padding-top，--navbar-height 設 0
   ≥ 1024px：nav 為 absolute → 對 .main 補 margin-top（CSS var），清除 padding
   ============================================================ */
function initNavOffset() {
  const nav = document.querySelector('.nav-bar');
  const final = document.querySelector('.final');
  if (!nav || !final) return;

  function applyOffset() {
    const navHeight = nav.getBoundingClientRect().height;
    if (window.innerWidth < 1024) {
      // fixed nav：用 .final padding-top 補償，.main 不額外加距
      final.style.paddingTop = navHeight + 'px';
      document.documentElement.style.setProperty('--navbar-height', '0px');
    } else {
      // absolute nav：清除 padding，讓 .main margin-top 補償
      final.style.paddingTop = '';
      document.documentElement.style.setProperty('--navbar-height', navHeight + 'px');
    }
  }

  // ResizeObserver：字體載入、視窗縮放等任何高度變化都即時反應
  const ro = new ResizeObserver(applyOffset);
  ro.observe(nav);

  applyOffset();
  window.addEventListener('resize', applyOffset);
}

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

  toggle.addEventListener('click', (e) => {
    e.stopPropagation();
    const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!isExpanded));
    wrapper.classList.toggle('show');
  });

  // 點擊 nav-bar 外部：收合 wrapper
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.nav-bar')) {
      closeAllDropdowns();
      wrapper.classList.remove('show');
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
   External Links（學生競圖）
   ============================================================ */
function initExternalLinks() {
  const externalLink = document.querySelector('.nav-2');
  if (externalLink) {
    externalLink.addEventListener('click', () => {
      window.open('https://www.aaedt.org.tw/blog/asdc/', '_blank');
    });
  }
}
