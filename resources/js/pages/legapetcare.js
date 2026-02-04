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
document.querySelectorAll(".btn-whatsapp, .btn-service").forEach((button) => {
    button.addEventListener("click", function (e) {
        if (
            !confirm(
                "Anda akan diarahkan ke WhatsApp untuk konsultasi/reservasi. Lanjutkan?",
            )
        ) {
            e.preventDefault();
        }
    });
});

// Active tab untuk fitur grid
document.addEventListener("DOMContentLoaded", function () {
    const featureItems = document.querySelectorAll(".feature-category");

    featureItems.forEach((item) => {
        item.addEventListener("click", function () {
            const serviceTitle = this.querySelector("h4").textContent;
            const phoneNumber = "{{ $contact['phone'] ?? '6281122334455' }}";
            const message = `Halo Lega Pet Care, saya ingin bertanya tentang layanan ${serviceTitle} untuk hewan peliharaan saya.`;
            const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;

            if (confirm(`Konsultasi tentang ${serviceTitle}?`)) {
                window.open(whatsappUrl, "_blank");
            }
        });
    });
});
