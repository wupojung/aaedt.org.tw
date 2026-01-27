// Main JavaScript file for AAEDT website

// Navigation dropdown data
const navDropdownData = {
    '最新消息': [
        { text: '最新活動', link: '#' },
        { text: '新聞公告', link: '#' },
        { text: '活動花絮', link: '#' }
    ],
    '認識協會': [
        { text: '關於協會', link: '#' },
        { text: '組織架構', link: '#' },
        { text: '組織成員', link: 'member.html' },
        { text: '理事長的話', link: '#' },
        { text: '協會章程', link: '#' }
    ],
    '專業服務': [
        { text: '居家環境改造', link: '#' },
        { text: '無障礙環境檢測', link: '#' },
        { text: '可及性設計諮詢', link: '#' },
        { text: '環境改善施工', link: '#' }
    ],
    '推廣行動': [
        { text: '長照2.0居家環境改造', link: '#' },
        { text: '公共空間無障礙環境改善', link: '#' },
        { text: '可及性設計理念教育推廣', link: '#' },
        { text: '社區推廣活動', link: '#' }
    ],
    '相關資源': [
        { text: '法規資訊', link: '#' },
        { text: '設計指南', link: '#' },
        { text: '參考資料', link: '#' },
        { text: '常見問題', link: '#' }
    ],
    '加入我們': [
        { text: '會員申請', link: '#' },
        { text: '志工招募', link: '#' },
        { text: '捐款支持', link: '#' },
        { text: '合作提案', link: '#' }
    ]
};

document.addEventListener('DOMContentLoaded', function() {
    initDropdownNavigation();
    initButtonEffects();
    initFooterLinks();
});

// Initialize dropdown navigation
function initDropdownNavigation() {
    const navItems = document.querySelectorAll('.nav-menu-list .nav');

    navItems.forEach(navItem => {
        const navText = navItem.querySelector('.nav-link').textContent;
        const dropdownItems = navDropdownData[navText];

        if (dropdownItems && dropdownItems.length > 0) {
            // Create dropdown container
            const dropdown = document.createElement('div');
            dropdown.className = 'nav-dropdown';

            // Add dropdown items
            dropdownItems.forEach(item => {
                const dropdownItem = document.createElement('a');
                dropdownItem.className = 'nav-dropdown-item';
                dropdownItem.href = item.link;
                dropdownItem.textContent = item.text;

                dropdownItem.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Navigating to:', item.text);
                    // Add your navigation logic here
                    window.open(item.link, '_self');

                });

                dropdown.appendChild(dropdownItem);
            });

            navItem.appendChild(dropdown);

            // Toggle dropdown on click
            navItem.addEventListener('click', function(e) {
                e.stopPropagation();

                // Close other dropdowns
                document.querySelectorAll('.nav.active').forEach(item => {
                    if (item !== navItem) {
                        item.classList.remove('active');
                    }
                });

                // Toggle current dropdown
                this.classList.toggle('active');
            });
        }
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav')) {
            document.querySelectorAll('.nav.active').forEach(item => {
                item.classList.remove('active');
            });
        }
    });

    // Close dropdowns on scroll
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

// Handle external link (學生競圖)
const externalLink = document.querySelector('.nav-2');
if (externalLink) {
    externalLink.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('External link clicked: 學生競圖');
        window.open('https://www.aaedt.org.tw/blog/asdc/', '_blank');
    });
}
