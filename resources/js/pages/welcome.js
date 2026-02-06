document.addEventListener("DOMContentLoaded", () => {
    let currentSlide = 0;
    const slides = document.querySelectorAll(".slide");
    const indicators = document.querySelectorAll(".indicator");

    if (!slides.length) return;

    // Data deskripsi untuk setiap slide
    const slideDescriptions = [
        {
            title: "Legareca Venue",
            subtitle: "Tempat Acara Eksklusif",
            description:
                "Venue premium dengan kapasitas hingga 500 orang, dilengkapi fasilitas lengkap untuk pernikahan, seminar, dan acara perusahaan.",
        },
        {
            title: "Legareca Inn",
            subtitle: "Penginapan Nyaman",
            description:
                "Hotel bintang 3 dengan 50 kamar lengkap, kolam renang, dan pusat kebugaran. Cocok untuk liburan keluarga atau perjalanan bisnis.",
        },
        {
            title: "Legareca Art Gallery",
            subtitle: "Galeri Seni Modern",
            description:
                "Menampilkan karya seni kontemporer dari 100+ seniman lokal dan internasional. Ruang pamer seluas 2000m² dengan pencahayaan profesional.",
        },
    ];

    function showSlide(index) {
        // Update slides visibility
        slides.forEach((slide, i) => {
            slide.style.opacity = i === index ? "1" : "0";
            slide.style.zIndex = i === index ? "10" : "1";
        });

        // Update indicators
        indicators.forEach((dot, i) => {
            dot.classList.toggle("active", i === index);
        });

        // Update caption description
        updateCaption(index);

        currentSlide = index;
    }

    function updateCaption(slideIndex) {
        const caption = document.querySelector(".slide-caption");
        const captionTitle = caption.querySelector(".caption-title");
        const captionSubtitle = caption.querySelector(".caption-subtitle");
        const captionDescription = caption.querySelector(
            ".caption-description",
        );

        const desc = slideDescriptions[slideIndex];

        captionTitle.textContent = desc.title;
        captionSubtitle.textContent = desc.subtitle;
        captionDescription.textContent = desc.description;
    }

    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        showSlide(nextIndex);
    }

    function prevSlide() {
        const prevIndex = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prevIndex);
    }

    // Event listeners
    document.getElementById("nextBtn")?.addEventListener("click", nextSlide);
    document.getElementById("prevBtn")?.addEventListener("click", prevSlide);

    indicators.forEach((dot, index) => {
        dot.addEventListener("click", () => showSlide(index));
    });

    // Initialize
    showSlide(0);

    // Auto slide every 5 seconds
    setInterval(nextSlide, 5000);

    // Pause auto-slide on hover
    const sliderContainer = document.querySelector(".hero-section");
    let slideInterval = setInterval(nextSlide, 5000);

    sliderContainer.addEventListener("mouseenter", () => {
        clearInterval(slideInterval);
    });

    sliderContainer.addEventListener("mouseleave", () => {
        slideInterval = setInterval(nextSlide, 5000);
    });
});


// Slider Functionality
let currentSlide = 0;
const slides = [
    "https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1190&q=80",
    "https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80",
    "https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80",
];

const indicators = document.querySelectorAll(".indicator");
const heroSection = document.querySelector(".hero-section");

// Initialize slider
function initSlider() {
    // Set background image
    heroSection.style.background = `linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('${slides[0]}')`;
    heroSection.style.backgroundSize = "cover";
    heroSection.style.backgroundPosition = "center";

    // Update indicators
    indicators.forEach((indicator, index) => {
        if (index === 0) {
            indicator.classList.add("active");
        } else {
            indicator.classList.remove("active");
        }
    });
}

// Change slide
function changeSlide(slideIndex) {
    // Update current slide
    currentSlide = slideIndex;

    // Update background image
    heroSection.style.background = `linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('${slides[currentSlide]}')`;
    heroSection.style.backgroundSize = "cover";
    heroSection.style.backgroundPosition = "center";

    // Add fade effect
    heroSection.style.opacity = "0.9";
    setTimeout(() => {
        heroSection.style.opacity = "1";
    }, 300);

    // Update indicators
    indicators.forEach((indicator, index) => {
        if (index === currentSlide) {
            indicator.classList.add("active");
        } else {
            indicator.classList.remove("active");
        }
    });
}

// Next slide
function nextSlide() {
    let nextIndex = currentSlide + 1;
    if (nextIndex >= slides.length) {
        nextIndex = 0;
    }
    changeSlide(nextIndex);
}

// Previous slide
function prevSlide() {
    let prevIndex = currentSlide - 1;
    if (prevIndex < 0) {
        prevIndex = slides.length - 1;
    }
    changeSlide(prevIndex);
}

// Event listeners for slider buttons
document.getElementById("prevBtn").addEventListener("click", prevSlide);
document.getElementById("nextBtn").addEventListener("click", nextSlide);

// Event listeners for indicators
indicators.forEach((indicator, index) => {
    indicator.addEventListener("click", () => {
        changeSlide(index);
    });
});

// Auto slide change
setInterval(nextSlide, 5000);

// Initialize on load
document.addEventListener("DOMContentLoaded", initSlider);
