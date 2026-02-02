document.addEventListener('DOMContentLoaded', () => {

  let currentSlide = 0;
  const slides = document.querySelectorAll('.slide');
  const indicators = document.querySelectorAll('.indicator');

  if (!slides.length) return;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.style.opacity = i === index ? '1' : '0';
    });

    indicators.forEach((dot, i) => {
      dot.classList.toggle('active', i === index);
    });

    currentSlide = index;
  }

  function nextSlide() {
    showSlide((currentSlide + 1) % slides.length);
  }

  function prevSlide() {
    showSlide((currentSlide - 1 + slides.length) % slides.length);
  }

  document.getElementById('nextBtn')?.addEventListener('click', nextSlide);
  document.getElementById('prevBtn')?.addEventListener('click', prevSlide);

  indicators.forEach((dot, index) => {
    dot.addEventListener('click', () => showSlide(index));
  });

  showSlide(0);

  setInterval(nextSlide, 5000);
});
