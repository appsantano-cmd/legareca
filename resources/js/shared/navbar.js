document.addEventListener('DOMContentLoaded', () => {

  console.log('Navbar JS loaded');


  // =====================
  // Mobile Menu Toggle
  // =====================
  const mobileBtn = document.querySelector('.mobile-menu-btn');
  const navMenu   = document.querySelector('.nav-menu');

  if (mobileBtn && navMenu) {
    mobileBtn.addEventListener('click', () => {
      navMenu.classList.toggle('active');
    });
  }

  // ============================
  // Active menu based on scroll
  // ============================
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-item');

  function activateMenuOnScroll() {
    let scrollY = window.pageYOffset;

    sections.forEach(section => {
      const sectionTop    = section.offsetTop - 140;
      const sectionHeight = section.offsetHeight;
      const sectionId     = section.getAttribute('id');

      if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
        navLinks.forEach(link => {
          link.classList.remove('active');

          if (link.getAttribute('href') === `#${sectionId}`) {
            link.classList.add('active');
          }
        });
      }
    });
  }

  window.addEventListener('scroll', activateMenuOnScroll);
  activateMenuOnScroll();

});
