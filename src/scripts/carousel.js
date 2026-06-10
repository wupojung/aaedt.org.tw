export function initCarousel() {
    const carousel = document.getElementById('carouselExampleIndicators');
    if (!carousel) return;

    const inner = carousel.querySelector('.carousel-inner');
    const items = carousel.querySelectorAll('.carousel-item');
    const indicators = carousel.querySelectorAll('.carousel-indicators li');
    const prevBtn = carousel.querySelector('.carousel-control-prev');
    const nextBtn = carousel.querySelector('.carousel-control-next');

    let current = 0;
    let autoTimer = null;
    const total = items.length;
    const INTERVAL = 1000;

    function goTo(index) {
        indicators[current]?.classList.remove('active');
        current = (index + total) % total;
        inner.style.transform = `translateX(-${current * 100}%)`;
        indicators[current]?.classList.add('active');
    }

    function startAuto() {
        stopAuto();
        autoTimer = setInterval(() => goTo(current + 1), INTERVAL);
    }

    function stopAuto() {
        clearInterval(autoTimer);
    }

    prevBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        goTo(current - 1);
        startAuto();
    });

    nextBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        goTo(current + 1);
        startAuto();
    });

    indicators.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            goTo(i);
            startAuto();
        });
    });

    // 暫停自動播放（滑鼠懸停時）
    carousel.addEventListener('mouseenter', stopAuto);
    carousel.addEventListener('mouseleave', startAuto);

    goTo(0);
    startAuto();
}
