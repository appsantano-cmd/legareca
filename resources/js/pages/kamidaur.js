// Smooth scrolling untuk anchor links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();

        const targetId = this.getAttribute("href");
        if (targetId === "#") return;

        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: "smooth",
            });
        }
    });
});

// Navbar active state update
window.addEventListener("scroll", function () {
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

    let current = "";

    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;

        if (scrollY >= sectionTop - 100) {
            current = section.getAttribute("id");
        }
    });

    navLinks.forEach((link) => {
        link.classList.remove("active");
        if (link.getAttribute("href") === `#${current}`) {
            link.classList.add("active");
        }
    });
});

// Konfirmasi sebelum mengirim WhatsApp
document
    .querySelector(".btn-whatsapp")
    ?.addEventListener("click", function (e) {
        if (!confirm("Anda akan diarahkan ke WhatsApp. Lanjutkan?")) {
            e.preventDefault();
        }
    });

// Smooth scrolling untuk anchor links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();

        const targetId = this.getAttribute("href");
        if (targetId === "#") return;

        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: "smooth",
            });
        }
    });
});

// Konfirmasi sebelum mengirim WhatsApp
document.querySelectorAll(".btn-whatsapp, .order-btn").forEach((button) => {
    button.addEventListener("click", function (e) {
        if (!confirm("Anda akan diarahkan ke WhatsApp. Lanjutkan?")) {
            e.preventDefault();
        }
    });
});
