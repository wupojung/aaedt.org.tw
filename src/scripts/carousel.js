export function initCarousel() {
  const carousel = document.getElementById('carouselExampleIndicators');
  if (!carousel) return;

  const inner = carousel.querySelector('.carousel-inner');
  const items = carousel.querySelectorAll('.carousel-item');
  const indicators = carousel.querySelectorAll('.carousel-indicators li');
  const prevBtn = carousel.querySelector('.carousel-control-prev');
  const nextBtn = carousel.querySelector('.carousel-control-next');

  const playBtn = document.getElementById('carouselPlayBtn');

  let current = 0;
  let autoTimer = null;
  let isPaused = true;
  const total = items.length;
  const INTERVAL = 3000;

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

  function setPlayState(paused) {
    isPaused = paused;
    playBtn?.classList.toggle('is-paused', paused);
    if (playBtn) playBtn.setAttribute('aria-label', paused ? '開始輪播' : '暫停輪播');
  }

  prevBtn?.addEventListener('click', (e) => {
    e.preventDefault();
    goTo(current - 1);
    if (!isPaused) startAuto();
  });

  nextBtn?.addEventListener('click', (e) => {
    e.preventDefault();
    goTo(current + 1);
    if (!isPaused) startAuto();
  });

  indicators.forEach((dot, i) => {
    dot.addEventListener('click', () => {
      goTo(i);
      if (!isPaused) startAuto();
    });
  });

  playBtn?.addEventListener('click', () => {
    if (isPaused) {
      setPlayState(false);
      startAuto();
    } else {
      setPlayState(true);
      stopAuto();
    }
  });

  // 滑鼠懸停時暫停，但不改變 isPaused 狀態（離開後按原狀態決定是否繼續）
  carousel.addEventListener('mouseenter', stopAuto);
  carousel.addEventListener('mouseleave', () => {
    if (!isPaused) startAuto();
  });

  goTo(0);
  setPlayState(true);
}
