// 以下是 card component 的无障碍点击支持代码
const cards = document.querySelectorAll('.card');  
Array.prototype.forEach.call(cards, card => {  
    let down, up, link = card.querySelector('h3 a');
    card.style.cursor = 'pointer';  
    card.onmousedown = () => down = +new Date();
    card.onmouseup = () => {
        up = +new Date();
        if ((up - down) < 200) {
            link.click();
        }
    }
});



/**
 * Accessible Navigation Bar
 * Handles dropdown menus with full keyboard navigation support
 * WCAG 2.1 Level AA Compliant
 */

document.addEventListener('DOMContentLoaded', function() {
    initAccessibleDropdownNavigation();
    initExternalLinks();
});

/**
 * Initialize Accessible Dropdown Navigation
 * Features:
 * - Click to toggle dropdowns
 * - Keyboard navigation (Arrow keys, Enter, Escape, Tab)
 * - ARIA attribute management
 * - Focus trap within open dropdowns
 * - Close on outside click and scroll
 */
function initAccessibleDropdownNavigation() {
    const dropdownButtons = document.querySelectorAll('.nav-dropdown-button');
    
    dropdownButtons.forEach(button => {
        const dropdownId = button.getAttribute('aria-controls');
        const dropdown = document.getElementById(dropdownId);
        
        if (!dropdown) {
            console.warn(`Dropdown with id "${dropdownId}" not found`);
            return;
        }

        // Get all items in the dropdown
        const dropdownItems = dropdown.querySelectorAll('.nav-dropdown-item');

        // ===== CLICK HANDLER =====
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleDropdown(button, dropdown);
        });

        // ===== KEYBOARD HANDLERS =====
        button.addEventListener('keydown', function(e) {
            switch(e.key) {
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    toggleDropdown(button, dropdown);
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    if (button.getAttribute('aria-expanded') === 'false') {
                        openDropdown(button, dropdown);
                    }
                    focusDropdownItem(dropdownItems, 0);
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    if (button.getAttribute('aria-expanded') === 'false') {
                        openDropdown(button, dropdown);
                    }
                    focusDropdownItem(dropdownItems, dropdownItems.length - 1);
                    break;
                case 'Escape':
                    e.preventDefault();
                    closeDropdown(button, dropdown);
                    button.focus();
                    break;
                case 'Tab':
                    // Allow Tab to navigate through dropdown items
                    if (button.getAttribute('aria-expanded') === 'true') {
                        const focusedItem = document.activeElement;
                        if (focusedItem === dropdownItems[dropdownItems.length - 1]) {
                            closeDropdown(button, dropdown);
                        }
                    }
                    break;
            }
        });

        // ===== DROPDOWN ITEM KEYBOARD NAVIGATION =====
        dropdownItems.forEach((item, index) => {
            item.addEventListener('keydown', function(e) {
                switch(e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        const nextIndex = index + 1 < dropdownItems.length ? index + 1 : 0;
                        focusDropdownItem(dropdownItems, nextIndex);
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        const prevIndex = index - 1 >= 0 ? index - 1 : dropdownItems.length - 1;
                        focusDropdownItem(dropdownItems, prevIndex);
                        break;
                    case 'Home':
                        e.preventDefault();
                        focusDropdownItem(dropdownItems, 0);
                        break;
                    case 'End':
                        e.preventDefault();
                        focusDropdownItem(dropdownItems, dropdownItems.length - 1);
                        break;
                    case 'Escape':
                        e.preventDefault();
                        closeDropdown(button, dropdown);
                        button.focus();
                        break;
                    case 'Tab':
                        if (e.shiftKey) {
                            // Shift+Tab on first item: go back to button
                            if (index === 0) {
                                e.preventDefault();
                                closeDropdown(button, dropdown);
                                button.focus();
                            }
                        } else {
                            // Tab on last item: close dropdown
                            if (index === dropdownItems.length - 1) {
                                closeDropdown(button, dropdown);
                            }
                        }
                        break;
                }
            });
        });
    });

    // ===== CLOSE ON OUTSIDE CLICK =====
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.nav')) {
            document.querySelectorAll('.nav-dropdown-button[aria-expanded="true"]').forEach(btn => {
                const dropId = btn.getAttribute('aria-controls');
                const drop = document.getElementById(dropId);
                if (drop) closeDropdown(btn, drop);
            });
        }
    });

    // ===== CLOSE ON SCROLL =====
    window.addEventListener('scroll', () => {
        document.querySelectorAll('.nav-dropdown-button[aria-expanded="true"]').forEach(btn => {
            const dropId = btn.getAttribute('aria-controls');
            const drop = document.getElementById(dropId);
            if (drop) closeDropdown(btn, drop);
        });
    });
}

/**
 * Helper Functions
 */

function toggleDropdown(button, dropdown) {
    if (button.getAttribute('aria-expanded') === 'false') {
        openDropdown(button, dropdown);
    } else {
        closeDropdown(button, dropdown);
    }
}

function openDropdown(button, dropdown) {
    // Close other open dropdowns
    document.querySelectorAll('.nav-dropdown-button[aria-expanded="true"]').forEach(btn => {
        if (btn !== button) {
            const dropId = btn.getAttribute('aria-controls');
            const drop = document.getElementById(dropId);
            if (drop) closeDropdown(btn, drop);
        }
    });

    // Toggle aria-expanded to TRUE
    button.setAttribute('aria-expanded', 'true');
    dropdown.style.display = 'block';
    
    // Add active class for CSS compatibility
    button.parentElement.classList.add('active');
}

function closeDropdown(button, dropdown) {
    // Toggle aria-expanded to FALSE
    button.setAttribute('aria-expanded', 'false');
    dropdown.style.display = 'none';
    button.parentElement.classList.remove('active');
}

function focusDropdownItem(items, index) {
    if (items[index]) {
        items[index].focus();
    }
}

/**
 * Handle External Links
 * Adds proper accessibility attributes for links opening in new windows
 */
function initExternalLinks() {
    const externalLink = document.querySelector('.nav-2');
    if (externalLink) {
        // Already has aria-label in HTML, further JS is optional
        externalLink.addEventListener('click', function(e) {
            // Let the native <a href> handle it with target="_blank"
            // This is comment-only; the link works natively
        });
    }
}