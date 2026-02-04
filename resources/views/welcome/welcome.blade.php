@extends('layouts.layout_main')

@section('title', 'Legareca Space')

@section('content')

{{-- HERO --}}
<section id="beranda" class="hero-section relative flex items-center justify-center pt-16 overflow-hidden">
    <!-- Slider Container -->
    <div class="relative w-full h-full">

        <!-- Navigation Buttons - PERBAIKAN POSISI -->
        <button class="slider-btn slider-btn-prev" id="prevBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>

        <button class="slider-btn slider-btn-next" id="nextBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>

        <!-- Indicators -->
        <div class="slider-indicators">
            <div class="indicator active" data-slide="0"></div>
            <div class="indicator" data-slide="1"></div>
            <div class="indicator" data-slide="2"></div>
        </div>
    </div>
</section>

<!-- Layanan Kami - Card Horizontal -->
<section class="py-12 bg-white">
    <div class="container">
        <h2 class="text-3xl font-bold text-center mb-2 section-title">Layanan Kami</h2>
        <p class="text-gray-600 text-center mb-8 max-w-2xl mx-auto">Legareca Space menawarkan berbagai layanan terbaik untuk memenuhi kebutuhan Anda</p>

        <div class="horizontal-card-container">
            <!-- Venue -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1190&q=80" alt="Venue" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Venue</h3>
                    <p class="text-gray-700 mb-4">Tempat acara yang elegan untuk pernikahan, seminar, pesta, dan acara lainnya.</p>
                    <a href="#venue" class="inline-block text-red-500 font-semibold hover:text-red-600">Selengkapnya →</a>
                </div>
            </div>

            <!-- Legareca Inn -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Legareca Inn" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Legareca Inn</h3>
                    <p class="text-gray-700 mb-4">Penginapan nyaman dengan fasilitas lengkap untuk liburan atau perjalanan bisnis.</p>
                    <a href="{{ route('reservasi.inn.index') }}" class="inline-block text-red-500 font-semibold hover:text-red-600">Selengkapnya →</a>
                </div>
            </div>

            <!-- Legareca Art Gallery -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80" alt="Legareca Art Gallery" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Legareca Art Gallery</h3>
                    <p class="text-gray-700 mb-4">Galeri seni yang menampilkan karya-karya terbaik dari seniman lokal dan internasional.</p>
                    <a href="#gallery" class="inline-block text-red-500 font-semibold hover:text-red-600">Selengkapnya →</a>
                </div>
            </div>

            <!-- Legareca Pet -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Legareca Pet" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Legareca Pet</h3>
                    <p class="text-gray-700 mb-4">Fasilitas perawatan hewan peliharaan dengan layanan grooming dan penitipan.</p>
                    <a href="{{ route('lega-pet-care.index') }}" class="inline-block text-red-500 font-semibold hover:text-red-600">Selengkapnya →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Event - Card Horizontal -->
<section class="py-12 bg-gray-100">
    <div class="container">
        <h2 class="text-3xl font-bold text-center mb-2 section-title">Event</h2>
        <p class="text-gray-600 text-center mb-8 max-w-2xl mx-auto">Temukan berbagai acara menarik yang diadakan di Legareca Space</p>

        <div class="horizontal-card-container">
            <!-- Event 1 -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Pameran Seni" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Pameran Seni Kontemporer</h3>
                    <p class="text-gray-700 mb-2">Tanggal: 15-30 Maret 2024</p>
                    <p class="text-gray-700 mb-4">Pameran karya seni kontemporer dari seniman ternama Indonesia.</p>
                    <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Detail Event →</a>
                </div>
            </div>

            <!-- Event 2 -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-4.0.3&auto=format&fit=crop&w=1169&q=80" alt="Konser Musik" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Konser Jazz Malam</h3>
                    <p class="text-gray-700 mb-2">Tanggal: 22 Maret 2024</p>
                    <p class="text-gray-700 mb-4">Nikmati malam indah dengan alunan musik jazz dari band lokal.</p>
                    <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Detail Event →</a>
                </div>
            </div>

            <!-- Event 3 -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1551135049-8a33b2fb2f5d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Workshop" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Workshop Fotografi</h3>
                    <p class="text-gray-700 mb-2">Tanggal: 28 Maret 2024</p>
                    <p class="text-gray-700 mb-4">Pelajari teknik fotografi dari fotografer profesional dengan harga terjangkau.</p>
                    <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Detail Event →</a>
                </div>
            </div>

            <!-- Event 4 -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1492684223066-e9e4aab4d25e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Festival Kuliner" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Festival Kuliner Lokal</h3>
                    <p class="text-gray-700 mb-2">Tanggal: 5-7 April 2024</p>
                    <p class="text-gray-700 mb-4">Nikmati berbagai hidangan khas dari seluruh Indonesia dalam satu lokasi.</p>
                    <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Detail Event →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FNB (Food & Beverage) - Card Horizontal -->
<section class="py-12 bg-white">
    <div class="container">
        <h2 class="text-3xl font-bold text-center mb-2 section-title">Food & Beverage</h2>
        <p class="text-gray-600 text-center mb-8 max-w-2xl mx-auto">Nikmati berbagai pilihan makanan dan minuman terbaik di Legareca Space</p>

        <div class="horizontal-card-container">
            <!-- Restaurant -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Restaurant" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Legareca Restaurant</h3>
                    <p class="text-gray-700 mb-4">Restoran dengan menu lokal dan internasional, cocok untuk acara keluarga atau bisnis.</p>
                    <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Lihat Menu →</a>
                </div>
            </div>

            <!-- Cafe -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80" alt="Cafe" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Legareca Cafe</h3>
                    <p class="text-gray-700 mb-4">Tempat nongkrong yang nyaman dengan kopi spesial dan camilan lezat.</p>
                    <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Lihat Menu →</a>
                </div>
            </div>

            <!-- Catering -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Catering" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Legareca Catering</h3>
                    <p class="text-gray-700 mb-4">Layanan katering untuk berbagai acara dengan menu yang dapat disesuaikan.</p>
                    <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Lihat Paket →</a>
                </div>
            </div>

            <!-- Bakery -->
            <div class="horizontal-card">
                <div class="overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1172&q=80" alt="Bakery" class="horizontal-card-image">
                </div>
                <div class="horizontal-card-content">
                    <h3 class="text-xl font-bold mb-2">Legareca Bakery</h3>
                    <p class="text-gray-700 mb-4">Roti dan kue segar buatan sehari-hari dengan bahan-bahan pilihan terbaik.</p>
                    <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Lihat Produk →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Deskripsi & Kontak -->
<section class="py-12 bg-gray-800 text-white">
    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Tentang Kami -->
            <div>
                <h3 class="text-xl font-bold mb-4">Tentang Legareca Space</h3>
                <p class="text-gray-300 mb-4">Legareca Space adalah destinasi lengkap yang menggabungkan venue acara, penginapan, galeri seni, dan fasilitas perawatan hewan peliharaan dalam satu lokasi.</p>
                <p class="text-gray-300">Kami berkomitmen untuk memberikan pengalaman terbaik bagi setiap pengunjung dengan layanan berkualitas dan fasilitas terbaik.</p>
            </div>

            <!-- Kontak -->
            <div>
                <h3 class="text-xl font-bold mb-4">Kontak Kami</h3>
                <ul class="space-y-2">
                    <li class="flex items-start">
                        <span class="mr-2">📍</span>
                        <span>Jl. Padokan Baru No.B789, Jogonalan Lor, Tirtonirmolo, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55181</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">📞</span>
                        <span>0812-2950-8183</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">✉️</span>
                        <span>legareca.space@gmail.com</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">🕐</span>
                        <span>Buka setiap hari: 08.00 - 22.00 WIB</span>
                    </li>
                </ul>
            </div>

            <!-- Social Media -->
            <div>
                <h3 class="text-xl font-bold mb-4">Ikuti Kami</h3>
                <div class="flex gap-4 mb-4">
                    <a href="#" class="text-white hover:text-red-500 transition">Facebook</a>
                    <a href="#" class="text-white hover:text-red-500 transition">Instagram</a>
                    <a href="#" class="text-white hover:text-red-500 transition">Twitter</a>
                    <a href="#" class="text-white hover:text-red-500 transition">YouTube</a>
                </div>
                <p class="text-gray-300">Dapatkan informasi terbaru tentang event, promo, dan layanan kami melalui media sosial.</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer Bergerak -->
<footer class="footer-moving">
    <div class="moving-text">
        C 2026 Santano • Legareca Space • Jl. Padokan Baru No.B789, Jogonalan Lor, Tirtonirmolo, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55181 • Phone: 0812-2950-8183 • legareca.space@gmail.com • C 2026 Santano • Legareca Space • Jl. Padokan Baru No.B789, Jogonalan Lor, Tirtonirmolo, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55181 • Phone: 0812-2950-8183 • legareca.space@gmail.com
    </div>
</footer>

@endsection

@push('styles')
<style>
    /* Custom Styles untuk halaman utama */
    .hero-section {
        height: 80vh;
        min-height: 600px;
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
            url('https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1190&q=80');
        background-size: cover;
        background-position: center;
        color: white;
    }

    /* PERBAIKAN: Slider Button */
    .slider-btn {
        width: 50px;
        height: 50px;
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.3);
        z-index: 40;
        position: absolute;
    }

    .slider-btn:hover {
        background-color: rgba(0, 0, 0, 0.9);
        border-color: rgba(255, 255, 255, 0.8);
        transform: scale(1.1);
    }

    .slider-btn:active {
        transform: scale(0.95);
    }

    .slider-btn-prev {
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
    }

    .slider-btn-next {
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
    }

    .slider-indicators {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 40;
    }

    .indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .indicator.active {
        background-color: white;
        transform: scale(1.2);
    }

    .section-title {
        position: relative;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background-color: #f53003;
    }

    /* STYLE BARU UNTUK CARD BERSAMPINGAN */
    .horizontal-card-container {
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        padding: 1rem 0;
        gap: 1.5rem;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
        -webkit-overflow-scrolling: touch;
    }

    .horizontal-card-container::-webkit-scrollbar {
        height: 8px;
    }

    .horizontal-card-container::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .horizontal-card-container::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 10px;
    }

    .horizontal-card {
        flex: 0 0 auto;
        width: 320px;
        background-color: #fff;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .horizontal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .horizontal-card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .horizontal-card-content {
        padding: 1.5rem;
    }

    /* Footer Bergerak */
    .footer-moving {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #1f2937;
        color: white;
        padding: 1rem 0;
        overflow: hidden;
        z-index: 100;
    }

    .moving-text {
        display: inline-block;
        white-space: nowrap;
        padding-left: 100%;
        animation: moveText 20s linear infinite;
    }

    @keyframes moveText {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section {
            height: 70vh;
            min-height: 500px;
        }

        /* Responsive horizontal cards */
        .horizontal-card {
            width: 280px;
        }

        /* Slider button di mobile */
        .slider-btn {
            width: 40px;
            height: 40px;
        }

        .slider-btn-prev {
            left: 10px;
        }

        .slider-btn-next {
            right: 10px;
        }
    }

    @media (min-width: 769px) {

        /* Lebar card lebih besar di desktop */
        .horizontal-card {
            width: 350px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Slider Functionality
    let currentSlide = 0;
    const slides = [
        "https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1190&q=80",
        "https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80",
        "https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80"
    ];

    const indicators = document.querySelectorAll('.indicator');
    const heroSection = document.querySelector('.hero-section');

    // Initialize slider
    function initSlider() {
        // Set background image
        heroSection.style.background = `linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('${slides[0]}')`;
        heroSection.style.backgroundSize = 'cover';
        heroSection.style.backgroundPosition = 'center';

        // Update indicators
        indicators.forEach((indicator, index) => {
            if (index === 0) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    }

    // Change slide
    function changeSlide(slideIndex) {
        // Update current slide
        currentSlide = slideIndex;

        // Update background image
        heroSection.style.background = `linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('${slides[currentSlide]}')`;
        heroSection.style.backgroundSize = 'cover';
        heroSection.style.backgroundPosition = 'center';

        // Add fade effect
        heroSection.style.opacity = '0.9';
        setTimeout(() => {
            heroSection.style.opacity = '1';
        }, 300);

        // Update indicators
        indicators.forEach((indicator, index) => {
            if (index === currentSlide) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
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
    document.getElementById('prevBtn').addEventListener('click', prevSlide);
    document.getElementById('nextBtn').addEventListener('click', nextSlide);

    // Event listeners for indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            changeSlide(index);
        });
    });

    // Auto slide change
    setInterval(nextSlide, 5000);

    // Initialize on load
    document.addEventListener('DOMContentLoaded', initSlider);
</script>
@endpush