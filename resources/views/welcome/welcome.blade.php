@extends('layouts.layout_main')

@section('title', 'Legareca Space')

@section('content')

{{-- HERO --}}
<section id="beranda" class="hero-section relative flex items-center justify-center pt-16 overflow-hidden">
    <!-- Slider Container -->
    <div class="relative w-full h-full">
        <!-- Slides -->
        <div class="slide active" data-slide="0">
            <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1190&q=80" 
                 alt="Legareca Venue" 
                 class="w-full h-full object-cover">
            
            <!-- Caption dengan Deskripsi -->
            <div class="slide-caption opacity-75 bg-white rounded d-flex flex-column text-center px-4 py-3 mt-auto mx-auto">
                <h2 class="caption-title">Le Gareca Venue</h2>
                <h3 class="caption-subtitle">Tempat Acara Eksklusif</h3>
                <p class="caption-description">
                    Venue premium dengan kapasitas hingga 500 orang, dilengkapi fasilitas lengkap untuk pernikahan, seminar, dan acara perusahaan.
                </p>
            </div>
        </div>
        
        <div class="slide" data-slide="1">
            <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" 
                 alt="Legareca Inn" 
                 class="w-full h-full object-cover">
            
            <div class="slide-caption opacity-75 bg-white rounded d-flex flex-column text-center px-4 py-3 mt-auto mx-auto">
                <h2 class="caption-title">Le Gareca Inn</h2>
                <h3 class="caption-subtitle">Penginapan Nyaman</h3>
                <p class="caption-description">
                    Hotel bintang 3 dengan 50 kamar lengkap, kolam renang, dan pusat kebugaran. Cocok untuk liburan keluarga atau perjalanan bisnis.
                </p>
            </div>
        </div>
        
        <div class="slide" data-slide="2">
            <img src="https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80" 
                 alt="Legareca Art Gallery" 
                 class="w-full h-full object-cover">
            
            <div class="slide-caption opacity-75 bg-white rounded d-flex flex-column text-center px-4 py-3 mt-auto mx-auto">
                <h2 class="caption-title">Le Gareca Art Gallery</h2>
                <h3 class="caption-subtitle">Galeri Seni Modern</h3>
                <p class="caption-description">
                    Menampilkan karya seni kontemporer dari 100+ seniman lokal dan internasional. Ruang pamer seluas 2000m² dengan pencahayaan profesional.
                </p>
            </div>
        </div>

        <!-- Navigation Buttons -->
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
                    <h3 class="text-xl font-bold mb-2">Le Gareca Art Gallery</h3>
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
        <p class="text-gray-600 text-center mb-8 max-w-2xl mx-auto">Temukan berbagai acara menarik yang diadakan di Le Gareca Space</p>

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
        <p class="text-gray-600 text-center mb-8 max-w-2xl mx-auto">Nikmati berbagai pilihan makanan dan minuman terbaik di Le Gareca Space</p>

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
                <h3 class="text-xl font-bold mb-4">Tentang Le Gareca Space</h3>
                <p class="text-gray-300 mb-4">Le Gareca Space adalah ruang kreatif dan ramah hewan peliharaan yang menyatukan berbagai pengalaman dalam satu kawasan. Mulai dari Cafe Resto yang hangat, Venue untuk berbagai acara, Kami Daur sebagai butik daur ulang yang berkelanjutan, Le Gareca Inn untuk pengalaman menginap yang nyaman, Art Gallery sebagai ruang apresiasi seni, hingga Lega Pet Care yang menghadirkan perhatian khusus bagi sahabat berbulu Anda. Sebuah ruang untuk bersantai, berkarya, dan berbagi momen—bersama manusia dan hewan kesayangan.</p>
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
                        <span>Buka setiap hari: 07.00 - 22.00 WIB</span>
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