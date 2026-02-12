document.addEventListener('DOMContentLoaded', function() {
    initDropdownNavigation();
    initButtonEffects();
    initFooterLinks();
    initExternalLinks();
});

// 處理導覽列下拉動作
function initDropdownNavigation() {
    const navItems = document.querySelectorAll('.nav-menu-list .nav');

    navItems.forEach(navItem => {
        // 檢查該項目是否有下拉內容
        const dropdown = navItem.querySelector('.nav-dropdown');
        if (!dropdown) return;

        navItem.addEventListener('click', function(e) {
            // 防止點擊事件往上傳到 document 導致選單立刻被關閉
            e.stopPropagation();

            // 關閉「其他」已經開啟的選單 (確保一次只開一個)
            document.querySelectorAll('.nav.active').forEach(activeItem => {
                if (activeItem !== navItem) {
                    activeItem.classList.remove('active');
                }
            });

            // 切換當前選單的 active class
            this.classList.toggle('active');
        });
    });

    // 點擊頁面其他空白處時，關閉所有選單
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav')) {
            document.querySelectorAll('.nav.active').forEach(item => {
                item.classList.remove('active');
            });
        }
    });

    // 捲動頁面時關閉選單 (避免選單懸浮在奇怪位置)
    window.addEventListener('scroll', function() {
        document.querySelectorAll('.nav.active').forEach(item => {
            item.classList.remove('active');
        });
    });
}

// Initialize button hover effects
function initButtonEffects() {
    const buttons = document.querySelectorAll('.button');

    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.3s ease';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });

        button.addEventListener('click', function(e) {
            e.preventDefault();
            const buttonText = this.querySelector('.text-wrapper-10').textContent;
            console.log('Button clicked:', buttonText);
            // Add your button click logic here
        });
    });
}

// Initialize footer links
function initFooterLinks() {
    const footerLinks = document.querySelectorAll('.footer-page-link');

    footerLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const linkText = this.querySelector('.text-wrapper-16').textContent;
            console.log('Footer link clicked:', linkText);
            // Add your navigation logic here
        });

        link.style.cursor = 'pointer';
        link.style.transition = 'background-color 0.3s ease';

        link.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(254, 219, 0, 0.1)';
        });

        link.addEventListener('mouseleave', function() {
            this.style.backgroundColor = 'transparent';
        });
    });
}

// 處理外部連結 (學生競圖)
function initExternalLinks() {
    const externalLink = document.querySelector('.nav-2');
    if (externalLink) {
        externalLink.addEventListener('click', function() {
            window.open('https://www.aaedt.org.tw/blog/asdc/', '_blank');
        });
    }
}

