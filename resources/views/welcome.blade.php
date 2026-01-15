<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Legareca Space</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Styles -->
    <style>
        /* Tailwind CSS v4.0.7 - Disederhanakan untuk kebutuhan proyek */
        :root {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            --color-black: #000;
            --color-white: #fff;
            --color-red-500: #f53003;
            --color-gray-800: #374151;
            --color-gray-900: #1f2937;
            --spacing: 0.25rem;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: var(--font-sans);
            line-height: 1.5;
            color: #1b1b18;
            background-color: #fdfdfc;
        }
        
        /* Utility Classes */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .flex-row { flex-direction: row; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .justify-end { justify-content: flex-end; }
        
        .hidden { display: none; }
        .block { display: block; }
        .inline-block { display: inline-block; }
        
        .w-full { width: 100%; }
        .h-full { height: 100%; }
        .h-screen { height: 100vh; }
        .h-16 { height: 4rem; }
        .h-64 { height: 16rem; }
        .h-80 { height: 20rem; }
        .h-96 { height: 24rem; }
        
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .p-8 { padding: 2rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        .pt-16 { padding-top: 4rem; }
        .pb-8 { padding-bottom: 2rem; }
        .pb-12 { padding-bottom: 3rem; }
        
        .m-auto { margin: auto; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .my-4 { margin-top: 1rem; margin-bottom: 1rem; }
        .my-8 { margin-top: 2rem; margin-bottom: 2rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-8 { margin-top: 2rem; }
        
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        
        .text-sm { font-size: 0.875rem; }
        .text-base { font-size: 1rem; }
        .text-lg { font-size: 1.125rem; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .text-3xl { font-size: 1.875rem; }
        .text-4xl { font-size: 2.25rem; }
        .text-5xl { font-size: 3rem; }
        
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        
        .rounded { border-radius: 0.25rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-full { border-radius: 9999px; }
        
        .bg-white { background-color: var(--color-white); }
        .bg-black { background-color: var(--color-black); }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-gray-800 { background-color: var(--color-gray-800); }
        .bg-gray-900 { background-color: var(--color-gray-900); }
        .bg-red-500 { background-color: var(--color-red-500); }
        
        .text-white { color: var(--color-white); }
        .text-black { color: var(--color-black); }
        .text-gray-600 { color: #4b5563; }
        .text-gray-700 { color: #374151; }
        .text-gray-800 { color: var(--color-gray-800); }
        .text-red-500 { color: var(--color-red-500); }
        
        .border { border-width: 1px; border-style: solid; }
        .border-gray-200 { border-color: #e5e7eb; }
        .border-gray-300 { border-color: #d1d5db; }
        
        .shadow { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); }
        .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        
        .overflow-hidden { overflow: hidden; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .fixed { position: fixed; }
        .top-0 { top: 0; }
        .left-0 { left: 0; }
        .right-0 { right: 0; }
        .bottom-0 { bottom: 0; }
        .z-10 { z-index: 10; }
        .z-20 { z-index: 20; }
        
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .gap-8 { gap: 2rem; }
        
        .transition { transition-property: all; transition-duration: 150ms; }
        .transition-all { transition-property: all; transition-duration: 300ms; }
        
        .cursor-pointer { cursor: pointer; }
        
        /* Custom Styles */
        .hero-section {
            height: 80vh;
            min-height: 600px;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1190&q=80');
            background-size: cover;
            background-position: center;
            color: white;
        }
        
        .nav-overlay {
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
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
        
        .card {
            transition: transform 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .card:hover .card-image {
            transform: scale(1.05);
        }
        
        .slider-btn {
            width: 50px;
            height: 50px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }
        
        .slider-btn:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
        
        .slider-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }
        
        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
        }
        
        .indicator.active {
            background-color: white;
        }
        
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
            .grid-cols-3 {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
            
            .hero-section {
                height: 70vh;
                min-height: 500px;
            }
            
            .nav-menu {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: rgba(0, 0, 0, 0.9);
                flex-direction: column;
                padding: 1rem;
                display: none;
            }
            
            .nav-menu.active {
                display: flex;
            }
            
            .mobile-menu-btn {
                display: block;
            }
        }
        
        @media (min-width: 769px) {
            .nav-menu {
                display: flex !important;
            }
            
            .mobile-menu-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full z-20 nav-overlay">
        <div class="container flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="text-xl font-bold text-white">Legareca Space</div>
            
            <!-- Desktop Menu -->
            <div class="nav-menu flex items-center gap-6">
                <a href="#beranda" class="text-white hover:text-red-500 transition">Beranda</a>
                <a href="#venue" class="text-white hover:text-red-500 transition">Venue</a>
                <a href="#inn" class="text-white hover:text-red-500 transition">Legareca Inn</a>
                <a href="#gallery" class="text-white hover:text-red-500 transition">Legareca Art Gallery</a>
                <a href="#pet" class="text-white hover:text-red-500 transition">Legareca Pet</a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Hero Section dengan Slider -->
    <section id="beranda" class="hero-section relative flex items-center justify-center pt-16">
        <!-- Slider Container -->
        <div class="relative w-full h-full">
            <!-- Slide 1 -->
            <div class="absolute inset-0 slide flex items-center justify-center transition-all duration-500 opacity-100">
                <div class="container text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Legareca Space</h1>
                    <p class="text-xl mb-8 max-w-2xl mx-auto">Tempat terbaik untuk acara, penginapan, seni, dan perawatan hewan peliharaan</p>
                    <a href="#venue" class="inline-block px-8 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">Jelajahi Layanan Kami</a>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="absolute inset-0 slide flex items-center justify-center transition-all duration-500 opacity-0">
                <div class="container text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Venue Legareca</h1>
                    <p class="text-xl mb-8 max-w-2xl mx-auto">Tempat acara yang elegan dan modern untuk berbagai kebutuhan</p>
                    <a href="#venue" class="inline-block px-8 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">Lihat Venue</a>
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="absolute inset-0 slide flex items-center justify-center transition-all duration-500 opacity-0">
                <div class="container text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Legareca Inn</h1>
                    <p class="text-xl mb-8 max-w-2xl mx-auto">Penginapan nyaman dengan fasilitas lengkap</p>
                    <a href="#inn" class="inline-block px-8 py-3 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition">Cek Kamar</a>
                </div>
            </div>
            
            <!-- Navigation Buttons -->
            <button class="slider-btn absolute left-4 top-1/2 transform -translate-y-1/2 z-10" id="prevBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            
            <button class="slider-btn absolute right-4 top-1/2 transform -translate-y-1/2 z-10" id="nextBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

    <!-- Layanan Kami -->
    <section class="py-12 bg-white">
        <div class="container">
            <h2 class="text-3xl font-bold text-center mb-2 section-title">Layanan Kami</h2>
            <p class="text-gray-600 text-center mb-8 max-w-2xl mx-auto">Legareca Space menawarkan berbagai layanan terbaik untuk memenuhi kebutuhan Anda</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Venue -->
                <div class="card bg-gray-100 rounded-xl overflow-hidden shadow-lg">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1190&q=80" alt="Venue" class="card-image w-full h-full">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Venue</h3>
                        <p class="text-gray-700 mb-4">Tempat acara yang elegan untuk pernikahan, seminar, pesta, dan acara lainnya.</p>
                        <a href="#venue" class="inline-block text-red-500 font-semibold hover:text-red-600">Selengkapnya →</a>
                    </div>
                </div>
                
                <!-- Legareca Inn -->
                <div class="card bg-gray-100 rounded-xl overflow-hidden shadow-lg">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Legareca Inn" class="card-image w-full h-full">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Legareca Inn</h3>
                        <p class="text-gray-700 mb-4">Penginapan nyaman dengan fasilitas lengkap untuk liburan atau perjalanan bisnis.</p>
                        <a href="#inn" class="inline-block text-red-500 font-semibold hover:text-red-600">Selengkapnya →</a>
                    </div>
                </div>
                
                <!-- Legareca Art Gallery -->
                <div class="card bg-gray-100 rounded-xl overflow-hidden shadow-lg">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80" alt="Legareca Art Gallery" class="card-image w-full h-full">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Legareca Art Gallery</h3>
                        <p class="text-gray-700 mb-4">Galeri seni yang menampilkan karya-karya terbaik dari seniman lokal dan internasional.</p>
                        <a href="#gallery" class="inline-block text-red-500 font-semibold hover:text-red-600">Selengkapnya →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Event -->
    <section class="py-12 bg-gray-100">
        <div class="container">
            <h2 class="text-3xl font-bold text-center mb-2 section-title">Event</h2>
            <p class="text-gray-600 text-center mb-8 max-w-2xl mx-auto">Temukan berbagai acara menarik yang diadakan di Legareca Space</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Event 1 -->
                <div class="card bg-white rounded-xl overflow-hidden shadow-lg">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Pameran Seni" class="card-image w-full h-full">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Pameran Seni Kontemporer</h3>
                        <p class="text-gray-700 mb-2">Tanggal: 15-30 Maret 2024</p>
                        <p class="text-gray-700 mb-4">Pameran karya seni kontemporer dari seniman ternama Indonesia.</p>
                        <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Detail Event →</a>
                    </div>
                </div>
                
                <!-- Event 2 -->
                <div class="card bg-white rounded-xl overflow-hidden shadow-lg">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-4.0.3&auto=format&fit=crop&w=1169&q=80" alt="Konser Musik" class="card-image w-full h-full">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Konser Jazz Malam</h3>
                        <p class="text-gray-700 mb-2">Tanggal: 22 Maret 2024</p>
                        <p class="text-gray-700 mb-4">Nikmati malam indah dengan alunan musik jazz dari band lokal.</p>
                        <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Detail Event →</a>
                    </div>
                </div>
                
                <!-- Event 3 -->
                <div class="card bg-white rounded-xl overflow-hidden shadow-lg">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1551135049-8a33b2fb2f5d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Workshop" class="card-image w-full h-full">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Workshop Fotografi</h3>
                        <p class="text-gray-700 mb-2">Tanggal: 28 Maret 2024</p>
                        <p class="text-gray-700 mb-4">Pelajari teknik fotografi dari fotografer profesional dengan harga terjangkau.</p>
                        <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Detail Event →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FNB (Food & Beverage) -->
    <section class="py-12 bg-white">
        <div class="container">
            <h2 class="text-3xl font-bold text-center mb-2 section-title">Food & Beverage</h2>
            <p class="text-gray-600 text-center mb-8 max-w-2xl mx-auto">Nikmati berbagai pilihan makanan dan minuman terbaik di Legareca Space</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Restaurant -->
                <div class="card bg-gray-100 rounded-xl overflow-hidden shadow-lg">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Restaurant" class="card-image w-full h-full">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Legareca Restaurant</h3>
                        <p class="text-gray-700 mb-4">Restoran dengan menu lokal dan internasional, cocok untuk acara keluarga atau bisnis.</p>
                        <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Lihat Menu →</a>
                    </div>
                </div>
                
                <!-- Cafe -->
                <div class="card bg-gray-100 rounded-xl overflow-hidden shadow-lg">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80" alt="Cafe" class="card-image w-full h-full">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Legareca Cafe</h3>
                        <p class="text-gray-700 mb-4">Tempat nongkrong yang nyaman dengan kopi spesial dan camilan lezat.</p>
                        <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Lihat Menu →</a>
                    </div>
                </div>
                
                <!-- Catering -->
                <div class="card bg-gray-100 rounded-xl overflow-hidden shadow-lg">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80" alt="Catering" class="card-image w-full h-full">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">Legareca Catering</h3>
                        <p class="text-gray-700 mb-4">Layanan katering untuk berbagai acara dengan menu yang dapat disesuaikan.</p>
                        <a href="#" class="inline-block text-red-500 font-semibold hover:text-red-600">Lihat Paket →</a>
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
                            <span>Jl. Legareca No. 123, Jakarta Selatan</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">📞</span>
                            <span>(021) 1234-5678</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">✉️</span>
                            <span>info@legarecaspace.com</span>
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
            C 2026 Santano • Legareca Space • Jl. Legareca No. 123, Jakarta Selatan • (021) 1234-5678 • info@legarecaspace.com • C 2026 Santano • Legareca Space • Jl. Legareca No. 123, Jakarta Selatan • (021) 1234-5678 • info@legarecaspace.com
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile Menu Toggle
        document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
            const navMenu = document.querySelector('.nav-menu');
            navMenu.classList.toggle('active');
        });
        
        // Slider Functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.indicator');
        
        // Initialize slider
        function initSlider() {
            slides.forEach((slide, index) => {
                if (index === 0) {
                    slide.style.opacity = '1';
                } else {
                    slide.style.opacity = '0';
                }
            });
            
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
            
            // Update slide visibility
            slides.forEach((slide, index) => {
                if (index === currentSlide) {
                    slide.style.opacity = '1';
                } else {
                    slide.style.opacity = '0';
                }
            });
            
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
        document.getElementById('nextBtn').addEventListener('click', nextSlide);
        document.getElementById('prevBtn').addEventListener('click', prevSlide);
        
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
</body>
</html>