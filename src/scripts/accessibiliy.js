// 以下是 card component 的無障礙點擊支持代碼
const cards = document.querySelectorAll('.card');
Array.prototype.forEach.call(cards, (card) => {
  let down, up;
  const link = card.querySelector('h3 a');
  card.style.cursor = 'pointer';
  card.onmousedown = () => (down = +new Date());
  card.onmouseup = () => {
    up = +new Date();
    if (up - down < 200) link.click();
  };
});

/**
 * Accessible Navigation Bar
 * 鍵盤導覽增強（Arrow keys、Home/End、Tab、Escape）
 * 不再自行管理 dropdown 的 display / opacity；
 * 統一交由 aaedt.js 的 .active class + CSS 控制。
 * WCAG 2.1 Level AA Compliant
 */
document.addEventListener('DOMContentLoaded', function () {
  initKeyboardNavigation();
  initExternalLinks();
});

function initKeyboardNavigation() {
  const dropdownButtons = document.querySelectorAll('.nav-dropdown-button');

  dropdownButtons.forEach((button) => {
    const dropdownId = button.getAttribute('aria-controls');
    const dropdown = document.getElementById(dropdownId);
    if (!dropdown) return;

    const dropdownItems = Array.from(dropdown.querySelectorAll('.nav-dropdown-item'));

    // ── Button 鍵盤事件 ─────────────────────────────────
    button.addEventListener('keydown', (e) => {
      const isOpen = button.getAttribute('aria-expanded') === 'true';

      switch (e.key) {
        case 'ArrowDown':
          e.preventDefault();
          if (!isOpen) openNav(button);
          focusItem(dropdownItems, 0);
          break;

        case 'ArrowUp':
          e.preventDefault();
          if (!isOpen) openNav(button);
          focusItem(dropdownItems, dropdownItems.length - 1);
          break;

        case 'Escape':
          e.preventDefault();
          closeNav(button);
          button.focus();
          break;

        // Enter / Space：交給 aaedt.js 的 click handler 處理（button 本身會觸發 click）
      }
    });

    // ── Dropdown item 鍵盤事件 ──────────────────────────
    dropdownItems.forEach((item, index) => {
      item.addEventListener('keydown', (e) => {
        switch (e.key) {
          case 'ArrowDown':
            e.preventDefault();
            focusItem(dropdownItems, (index + 1) % dropdownItems.length);
            break;

          case 'ArrowUp':
            e.preventDefault();
            focusItem(dropdownItems, (index - 1 + dropdownItems.length) % dropdownItems.length);
            break;

          case 'Home':
            e.preventDefault();
            focusItem(dropdownItems, 0);
            break;

          case 'End':
            e.preventDefault();
            focusItem(dropdownItems, dropdownItems.length - 1);
            break;

          case 'Escape':
            e.preventDefault();
            closeNav(button);
            button.focus();
            break;

          case 'Tab':
            // Shift+Tab 在第一項：收回按鈕
            if (e.shiftKey && index === 0) {
              e.preventDefault();
              closeNav(button);
              button.focus();
            }
            // Tab 在最後一項：關閉（讓 Tab 自然移到下一個按鈕）
            if (!e.shiftKey && index === dropdownItems.length - 1) {
              closeNav(button);
            }
            break;
        }
      });
    });
  });
}

/* ============================================================
   Helper：透過 .active class 開關，與 aaedt.js 保持一致
   ============================================================ */
function openNav(button) {
  // 先關其他（重用 aaedt.js 暴露的 closeAllDropdowns，若載入順序不同則 fallback）
  if (typeof closeAllDropdowns === 'function') {
    closeAllDropdowns();
  }
  const parentNav = button.closest('.nav');
  if (parentNav) parentNav.classList.add('active');
  button.setAttribute('aria-expanded', 'true');
}

function closeNav(button) {
  const parentNav = button.closest('.nav');
  if (parentNav) parentNav.classList.remove('active');
  button.setAttribute('aria-expanded', 'false');
}

function focusItem(items, index) {
  if (items[index]) items[index].focus();
}

/* ============================================================
   External Links
   ============================================================ */
function initExternalLinks() {
  const externalLink = document.querySelector('.nav-2');
  if (externalLink) {
    externalLink.addEventListener('click', () => {
      window.open('https://www.aaedt.org.tw/blog/asdc/', '_blank');
    });
  }
}
