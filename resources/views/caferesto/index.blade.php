@extends('layouts.app')

@section('title', 'Legareca Cafe & Resto - Reservasi')

@section('styles')
<style>
    /* Reset untuk navbar */
    body {
        padding-top: 0 !important;
    }

    main {
        padding-top: 4rem !important;
    }

    /* Hero Section */
    .cafe-hero {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.8)),
            url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 100px 0;
        margin-bottom: 50px;
        position: relative;
        overflow: hidden;
    }

    .cafe-hero:before {
        content: '';
        position: absolute;
        bottom: -50px;
        left: 0;
        width: 100%;
        height: 100px;
        background: white;
        transform: skewY(-3deg);
        z-index: 1;
    }

    .cafe-hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
    }

    /* Table Type Cards */
    .table-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 30px;
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        height: 100%;
    }

    .table-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .table-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }

    .table-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .table-price {
        color: #d63031;
        font-size: 1.4rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .table-features {
        list-style: none;
        padding-left: 0;
        margin-bottom: 20px;
    }

    .table-features li {
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        color: #666;
    }

    .table-features li i {
        color: #00b894;
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    /* Section Styling */
    .section-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 30px;
        color: #2d3436;
        font-size: 2rem;
        font-weight: 700;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #e17055, #fdcb6e);
        border-radius: 2px;
    }

    /* Button Styles */
    .reserve-btn {
        background: linear-gradient(135deg, #e17055, #d63031);
        color: white;
        padding: 12px 25px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-weight: 600;
        border: none;
        width: 100%;
    }

    .reserve-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(225, 112, 85, 0.4);
        color: white;
    }

    /* Menu Highlights */
    .menu-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .menu-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .menu-image {
        height: 150px;
        object-fit: cover;
        width: 100%;
    }

    .menu-price {
        color: #e17055;
        font-weight: bold;
        font-size: 1.1rem;
    }

    /* Info Box */
    .info-box {
        background: linear-gradient(135deg, #ffeaa7, #fab1a0);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
    }

    .info-box-icon {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .info-box-icon i {
        color: #e17055;
        font-size: 1.5rem;
    }

    /* Modal Styling */
    .cafe-modal .modal-header {
        background: linear-gradient(135deg, #e17055, #d63031);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 20px 30px;
    }

    .cafe-modal .form-control,
    .cafe-modal .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 15px;
    }

    .cafe-modal .form-control:focus,
    .cafe-modal .form-select:focus {
        border-color: #e17055;
        box-shadow: 0 0 0 0.25rem rgba(225, 112, 85, 0.25);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cafe-hero {
            padding: 70px 0;
        }

        .section-title {
            font-size: 1.6rem;
        }

        .table-card {
            margin-bottom: 20px;
        }
    }

    /* Progress Steps Indicator */
    .progress-steps {
        padding: 20px 0;
    }

    .step-indicator {
        flex: 1;
        position: relative;
    }

    .step-circle {
        width: 40px;
        height: 40px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #6c757d;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .step-circle.active {
        background: #e17055;
        color: white;
        transform: scale(1.1);
    }

    .step-line {
        height: 2px;
        background: #e9ecef;
        margin-top: 20px;
    }

    .step-label {
        font-size: 0.8rem;
        color: #6c757d;
        font-weight: 500;
    }

    .step-circle.active+.step-label {
        color: #e17055;
        font-weight: 600;
    }

    /* Invalid feedback styling */
    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    .is-invalid~.invalid-feedback {
        display: block;
    }
</style>
@endsection

@section('content')

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 w-full bg-black/90 backdrop-blur-md border-b-2 border-red-500 shadow-lg z-50">
    <div class="container mx-auto px-4 h-16 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center gap-3">
            <div class="h-12 w-12 flex items-center justify-center bg-white rounded-xl shadow">
                <img
                    src="{{ asset('logo.png') }}"
                    alt="logo"
                    class="h-8 w-auto object-contain">
            </div>
            <span class="text-white text-xl font-semibold tracking-wide">
                Legareca Cafe & Resto
            </span>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-8">
            <a href="/" class="text-white hover:text-red-400 font-medium relative group transition-colors duration-300">
                Beranda
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-500 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="#venue" class="text-white hover:text-red-400 font-medium relative group transition-colors duration-300">
                Venue
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-500 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="/reservasi" class="text-white hover:text-red-400 font-medium relative group transition-colors duration-300">
                Legareca Inn
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-500 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="{{ route('cafe-resto') }}" class="text-red-400 font-medium relative group transition-colors duration-300">
                Cafe & Resto
                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-500"></span>
            </a>
            <a href="#gallery" class="text-white hover:text-red-400 font-medium relative group transition-colors duration-300">
                Legareca Art Gallery
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-500 group-hover:w-full transition-all duration-300"></span>
            </a>
            <a href="#pet" class="text-white hover:text-red-400 font-medium relative group transition-colors duration-300">
                Legareca Pet
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-500 group-hover:w-full transition-all duration-300"></span>
            </a>

            <a href="#contact" class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-semibold px-6 py-2 rounded-full hover:from-red-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                HUBUNGI KAMI
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-white p-2 hover:bg-white/10 rounded-lg transition-colors duration-300" id="mobileMenuBtn">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden absolute top-full left-0 w-full bg-black/95 backdrop-blur-lg border-t border-red-500/30 hidden" id="mobileMenu">
        <div class="container mx-auto px-4 py-6 space-y-4">
            <a href="/" class="block text-white hover:text-red-400 py-3 px-4 hover:bg-white/5 rounded-lg transition-colors duration-300">
                Beranda
            </a>
            <a href="#venue" class="block text-white hover:text-red-400 py-3 px-4 hover:bg-white/5 rounded-lg transition-colors duration-300">
                Venue
            </a>
            <a href="/reservasi" class="block text-white hover:text-red-400 py-3 px-4 hover:bg-white/5 rounded-lg transition-colors duration-300">
                Legareca Inn
            </a>
            <a href="{{ route('cafe-resto') }}" class="block text-red-400 py-3 px-4 bg-white/5 rounded-lg transition-colors duration-300">
                Cafe & Resto
            </a>
            <a href="#gallery" class="block text-white hover:text-red-400 py-3 px-4 hover:bg-white/5 rounded-lg transition-colors duration-300">
                Legareca Art Gallery
            </a>
            <a href="#pet" class="block text-white hover:text-red-400 py-3 px-4 hover:bg-white/5 rounded-lg transition-colors duration-300">
                Legareca Pet
            </a>

            <a href="#contact" class="block bg-gradient-to-r from-red-500 to-orange-500 text-white font-semibold py-3 px-6 rounded-full hover:from-red-600 hover:to-orange-600 transition-all duration-300 text-center mt-4">
                HUBUNGI KAMI
            </a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="cafe-hero text-center">
    <div class="container">
        <div class="cafe-hero-content">
            <h1 class="display-5 fw-bold mb-4 animate__animated animate__fadeInDown">
                Legareca Cafe & Resto
            </h1>
            <p class="lead mb-4 animate__animated animate__fadeInUp" style="color: rgba(255,255,255,0.9);">
                Pengalaman kuliner tak terlupakan di jantung Yogyakarta.
                Menyajikan berbagai hidangan lokal dan internasional dengan bahan-bahan terbaik.
            </p>
            <button type="button"
                class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold shadow animate__animated animate__fadeInUp reserve-btn"
                data-bs-toggle="modal"
                data-bs-target="#reservationModal">
                <i class="fas fa-calendar-alt me-2"></i>Reservasi Meja Sekarang
            </button>
        </div>
    </div>
</section>

<!-- Table Types Section -->
<section id="tables" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Pilihan Meja</h2>
            <p class="text-muted mb-5" style="max-width: 700px; margin: 0 auto;">
                Pilih meja yang sesuai dengan kebutuhan Anda. Setiap area didesain dengan suasana yang berbeda untuk pengalaman makan yang optimal.
            </p>
        </div>

        <div class="row">
            <!-- Table Type 1: Indoor Regular -->
            <div class="col-lg-3 col-md-6">
                <div class="table-card">
                    <div class="position-relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                            alt="Indoor Regular" class="table-image">
                        <span class="table-badge bg-success text-white">Tersedia</span>
                    </div>
                    <div class="p-4">
                        <h3 class="h5 mb-3 fw-bold">Meja Indoor Regular</h3>
                        <div class="table-price">Rp 0</div>
                        <p class="text-muted small mb-3">Meja standar dengan suasana cozy di dalam ruangan ber-AC.</p>

                        <ul class="table-features mb-4">
                            <li><i class="fas fa-check"></i> Maksimal 4 orang</li>
                            <li><i class="fas fa-check"></i> Area ber-AC</li>
                            <li><i class="fas fa-check"></i> Dekat dengan live music</li>
                            <li><i class="fas fa-check"></i> Free WiFi</li>
                        </ul>

                        <button type="button"
                            class="reserve-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#reservationModal"
                            data-table-type="Indoor Regular">
                            <i class="fas fa-chair me-2"></i>Pilih Meja Ini
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Type 2: Indoor Premium -->
            <div class="col-lg-3 col-md-6">
                <div class="table-card">
                    <div class="position-relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1514933651103-005eec06c04b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80"
                            alt="Indoor Premium" class="table-image">
                        <span class="table-badge bg-success text-white">Tersedia</span>
                    </div>
                    <div class="p-4">
                        <h3 class="h5 mb-3 fw-bold">Meja Indoor Premium</h3>
                        <div class="table-price">Rp 50.000</div>
                        <p class="text-muted small mb-3">Meja lebih luas dengan privasi tinggi dan view ke dapur terbuka.</p>

                        <ul class="table-features mb-4">
                            <li><i class="fas fa-check"></i> Maksimal 6 orang</li>
                            <li><i class="fas fa-check"></i> View ke dapur terbuka</li>
                            <li><i class="fas fa-check"></i> Privacy screen</li>
                            <li><i class="fas fa-check"></i> Dedicated waiter</li>
                            <li><i class="fas fa-check"></i> Complimentary appetizer</li>
                        </ul>

                        <button type="button"
                            class="reserve-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#reservationModal"
                            data-table-type="Indoor Premium">
                            <i class="fas fa-chair me-2"></i>Pilih Meja Ini
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Type 3: Outdoor Garden -->
            <div class="col-lg-3 col-md-6">
                <div class="table-card">
                    <div class="position-relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1590846406792-0adc7f938f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2080&q=80"
                            alt="Outdoor Garden" class="table-image">
                        <span class="table-badge bg-warning text-dark">Terbatas</span>
                    </div>
                    <div class="p-4">
                        <h3 class="h5 mb-3 fw-bold">Outdoor Garden</h3>
                        <div class="table-price">Rp 30.000</div>
                        <p class="text-muted small mb-3">Meja di taman dengan suasana alam dan udara segar.</p>

                        <ul class="table-features mb-4">
                            <li><i class="fas fa-check"></i> Maksimal 8 orang</li>
                            <li><i class="fas fa-check"></i> View taman</li>
                            <li><i class="fas fa-check"></i> Smoking area terpisah</li>
                            <li><i class="fas fa-check"></i> Natural lighting</li>
                            <li><i class="fas fa-check"></i> Evening live acoustic</li>
                        </ul>

                        <button type="button"
                            class="reserve-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#reservationModal"
                            data-table-type="Outdoor Garden">
                            <i class="fas fa-chair me-2"></i>Pilih Meja Ini
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Type 4: Private Room -->
            <div class="col-lg-3 col-md-6">
                <div class="table-card">
                    <div class="position-relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1559925393-8be0ec4767c8?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80"
                            alt="Private Room" class="table-image">
                        <span class="table-badge bg-info text-white">Minimal 10 orang</span>
                    </div>
                    <div class="p-4">
                        <h3 class="h5 mb-3 fw-bold">Private Room</h3>
                        <div class="table-price">Rp 150.000</div>
                        <p class="text-muted small mb-3">Ruang privat untuk meeting, keluarga besar, atau acara khusus.</p>

                        <ul class="table-features mb-4">
                            <li><i class="fas fa-check"></i> Maksimal 20 orang</li>
                            <li><i class="fas fa-check"></i> Private sound system</li>
                            <li><i class="fas fa-check"></i> Projector screen</li>
                            <li><i class="fas fa-check"></i> Dedicated chef service</li>
                            <li><i class="fas fa-check"></i> Minimum spending Rp 1.5jt</li>
                        </ul>

                        <button type="button"
                            class="reserve-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#reservationModal"
                            data-table-type="Private Room">
                            <i class="fas fa-chair me-2"></i>Pilih Meja Ini
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Menu Highlights Section -->
<section id="menu" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Menu Unggulan</h2>
            <p class="text-muted mb-5" style="max-width: 700px; margin: 0 auto;">
                Jelajahi pilihan terbaik dari chef kami yang berpengalaman.
            </p>
        </div>

        <div class="row">
            @foreach([
            ['img' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-4.0.3&auto=format&fit=crop&w=2065&q=80', 'name' => 'Legareca Signature Steak', 'desc' => 'Daging sapi premium dengan saus spesial', 'price' => '125.000'],
            ['img' => 'https://images.unsplash.com/photo-1563379091339-03246963d9d6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'name' => 'Seafood Platter', 'desc' => 'Berbagai seafood segar dengan bumbu rempah', 'price' => '185.000'],
            ['img' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2067&q=80', 'name' => 'Grilled Chicken', 'desc' => 'Ayam panggang dengan sayuran organik', 'price' => '85.000'],
            ['img' => 'https://images.unsplash.com/photo-1572802419224-296b0aeee0d9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80', 'name' => 'Vegetarian Delight', 'desc' => 'Salad organik dengan dressing spesial', 'price' => '65.000']
            ] as $item)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="menu-card">
                    <img src="{{ $item['img'] }}" alt="{{ $item['name'] }}" class="menu-image">
                    <div class="p-3">
                        <h5 class="fw-bold mb-2">{{ $item['name'] }}</h5>
                        <p class="text-muted small mb-2">{{ $item['desc'] }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="menu-price">Rp {{ $item['price'] }}</span>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Information Section -->
<section id="info" class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="info-box">
                    <h3 class="fw-bold mb-4">Jam Operasional</h3>
                    <div class="row">
                        @foreach([
                        ['days' => 'Senin - Kamis', 'hours' => '10:00 - 22:00'],
                        ['days' => 'Jumat - Sabtu', 'hours' => '10:00 - 23:00'],
                        ['days' => 'Minggu & Hari Libur', 'hours' => '10:00 - 21:00']
                        ] as $schedule)
                        <div class="col-md-4 mb-3">
                            <div class="bg-white p-3 rounded text-center">
                                <h6 class="fw-bold">{{ $schedule['days'] }}</h6>
                                <p class="mb-0">{{ $schedule['hours'] }} WIB</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <div class="info-box-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h5 class="fw-bold">Reservasi & Informasi</h5>
                        <p class="mb-2">
                            <i class="fas fa-phone me-2"></i>(0274) 567-8901
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-envelope me-2"></i>cafe@legareca.com
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="info-box" style="background: linear-gradient(135deg, #74b9ff, #0984e3);">
                    <div class="info-box-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h5 class="fw-bold text-white">Informasi Penting</h5>
                    <ul class="text-white" style="padding-left: 20px;">
                        <li>Reservasi minimal 2 jam sebelumnya</li>
                        <li>Meja hanya ditahan 15 menit</li>
                        <li>Special menu tersedia</li>
                        <li>Free parking untuk pelanggan</li>
                        <li>Live music setiap Jumat & Sabtu</li>
                    </ul>
                </div>

                <div class="text-center mt-4">
                    <a href="https://wa.me/6281234567890"
                        target="_blank"
                        class="btn btn-success btn-lg w-100 py-3 fw-bold">
                        <i class="fab fa-whatsapp me-2"></i>Chat via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reservation Modal -->
<div class="modal fade cafe-modal" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationModalLabel">
                    <i class="fas fa-utensils me-2"></i>Form Reservasi Meja
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Progress Steps Indicator -->
                <div class="progress-steps mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        @for($i = 1; $i <= 3; $i++)
                            <div class="step-indicator text-center">
                            <div class="step-circle {{ $i == 1 ? 'active' : '' }}">{{ $i }}</div>
                            <div class="step-label mt-1">
                                @if($i == 1) Pilih Meja
                                @elseif($i == 2) Waktu & Tamu
                                @else Data Diri
                                @endif
                            </div>
                    </div>
                    @if($i < 3)
                        <div class="step-line flex-grow-1 mx-2">
                </div>
                @endif
                @endfor
            </div>
        </div>

        <form id="reservationForm" method="POST">
            @csrf

            <!-- Step 1: Table Selection -->
            <div class="step step-1">
                <div class="mb-4">
                    <label for="tableType" class="form-label fw-bold">Pilih Tipe Meja</label>
                    <select class="form-select form-select-lg" id="tableType" name="table_type" required>
                        <option value="">-- Pilih Tipe Meja --</option>
                        <option value="Indoor Regular">Meja Indoor Regular</option>
                        <option value="Indoor Premium">Meja Indoor Premium (Rp 50.000)</option>
                        <option value="Outdoor Garden">Outdoor Garden (Rp 30.000)</option>
                        <option value="Private Room">Private Room (Rp 150.000)</option>
                    </select>
                    <div class="invalid-feedback">Silakan pilih tipe meja.</div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Harga meja akan ditambahkan ke total pembayaran Anda.
                </div>

                <button type="button" class="btn btn-primary w-100 py-3 next-step" data-step="1">
                    Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>

            <!-- Step 2: Date & Time -->
            <div class="step step-2 d-none">
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label fw-bold">Tanggal Reservasi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="invalid-feedback">Silakan pilih tanggal.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="time" class="form-label fw-bold">Waktu Reservasi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-clock"></i>
                            </span>
                            <select class="form-select" id="time" name="time" required>
                                <option value="">-- Pilih Waktu --</option>
                                @for($i = 10; $i <= 21; $i++)
                                    <option value="{{ sprintf('%02d:00', $i) }}">{{ sprintf('%02d:00', $i) }} WIB</option>
                                    @if($i < 21)
                                        <option value="{{ sprintf('%02d:30', $i) }}">{{ sprintf('%02d:30', $i) }} WIB</option>
                                        @endif
                                        @endfor
                            </select>
                        </div>
                        <div class="invalid-feedback">Silakan pilih waktu.</div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="guests" class="form-label fw-bold">Jumlah Tamu</label>
                        <select class="form-select" id="guests" name="guests" required>
                            <option value="">-- Pilih Jumlah Tamu --</option>
                            @for($i = 1; $i <= 20; $i++)
                                <option value="{{ $i }}" {{ $i == 2 ? 'selected' : '' }}>{{ $i }} orang</option>
                                @endfor
                        </select>
                        <div class="invalid-feedback">Silakan pilih jumlah tamu.</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary prev-step" data-step="2">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                    <button type="button" class="btn btn-primary next-step" data-step="2">
                        Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 3: Personal Information -->
            <div class="step step-3 d-none">
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" id="name" name="name" required
                                placeholder="Nama sesuai KTP">
                        </div>
                        <div class="invalid-feedback">Silakan isi nama lengkap.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label fw-bold">Nomor WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white">
                                <i class="fab fa-whatsapp"></i>
                            </span>
                            <input type="tel" class="form-control" id="phone" name="phone" required
                                placeholder="628xxxxxxxxxx" pattern="[0-9+\-\s]+">
                        </div>
                        <div class="invalid-feedback">Silakan isi nomor WhatsApp yang valid.</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control" id="email" name="email" required
                            placeholder="email@anda.com">
                    </div>
                    <div class="invalid-feedback">Silakan isi email yang valid.</div>
                </div>

                <div class="mb-4">
                    <label for="special_request" class="form-label fw-bold">Permintaan Khusus (Opsional)</label>
                    <textarea class="form-control" id="special_request" name="special_request"
                        rows="3"
                        placeholder="Contoh: Perayaan ulang tahun, alergi makanan tertentu, kursi bayi, dll."></textarea>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Pastikan data yang Anda masukkan benar. Reservasi akan dikonfirmasi via WhatsApp.
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary prev-step" data-step="3">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Reservasi
                    </button>
                </div>
            </div>
        </form>

        <!-- Loading Indicator -->
        <div id="loading" class="text-center d-none mt-4">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Mengirim reservasi...</p>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="alert alert-success d-none mt-4">
            <i class="fas fa-check-circle me-2"></i>
            <span id="successText"></span>
        </div>

        <!-- Error Message -->
        <div id="errorMessage" class="alert alert-danger d-none mt-4">
            <i class="fas fa-exclamation-circle me-2"></i>
            <span id="errorText"></span>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="reservationModalLabel">
                <i class="fas fa-utensils me-2"></i>Form Reservasi Meja
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
            <form id="reservationForm">
                @csrf

                <!-- Step 1: Table Selection -->
                <div class="step step-1">
                    <div class="mb-4">
                        <label for="tableType" class="form-label fw-bold">Pilih Tipe Meja</label>
                        <select class="form-select form-select-lg" id="tableType" name="table_type" required>
                            <option value="">-- Pilih Tipe Meja --</option>
                            <option value="Indoor Regular">Meja Indoor Regular</option>
                            <option value="Indoor Premium">Meja Indoor Premium (Rp 50.000)</option>
                            <option value="Outdoor Garden">Outdoor Garden (Rp 30.000)</option>
                            <option value="Private Room">Private Room (Rp 150.000)</option>
                        </select>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Harga meja akan ditambahkan ke total pembayaran Anda.
                    </div>

                    <button type="button" class="btn btn-primary w-100 py-3 next-step" data-step="1">
                        Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>

                <!-- Step 2: Date & Time -->
                <div class="step step-2 d-none">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="date" class="form-label fw-bold">Tanggal Reservasi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input type="date" class="form-control" id="date" name="date" required
                                    min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="time" class="form-label fw-bold">Waktu Reservasi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <select class="form-select" id="time" name="time" required>
                                    <option value="">-- Pilih Waktu --</option>
                                    @for($i = 10; $i <= 21; $i++)
                                        <option value="{{ sprintf('%02d:00', $i) }}">{{ sprintf('%02d:00', $i) }} WIB</option>
                                        @if($i < 21)
                                            <option value="{{ sprintf('%02d:30', $i) }}">{{ sprintf('%02d:30', $i) }} WIB</option>
                                            @endif
                                            @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="guests" class="form-label fw-bold">Jumlah Tamu</label>
                            <select class="form-select" id="guests" name="guests" required>
                                <option value="">-- Pilih Jumlah Tamu --</option>
                                @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}">{{ $i }} orang</option>
                                    @endfor
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary prev-step" data-step="2">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </button>
                        <button type="button" class="btn btn-primary next-step" data-step="2">
                            Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Personal Information -->
                <div class="step step-3 d-none">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="Nama sesuai KTP">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold">Nomor WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-success text-white">
                                    <i class="fab fa-whatsapp"></i>
                                </span>
                                <input type="tel" class="form-control" id="phone" name="phone" required
                                    placeholder="628xxxxxxxxxx">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="email@anda.com">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="special_request" class="form-label fw-bold">Permintaan Khusus</label>
                        <textarea class="form-control" id="special_request" name="special_request"
                            rows="3"
                            placeholder="Contoh: Perayaan ulang tahun, alergi makanan tertentu, kursi bayi, dll."></textarea>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Pastikan data yang Anda masukkan benar. Reservasi akan dikonfirmasi via WhatsApp.
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary prev-step" data-step="3">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Reservasi
                        </button>
                    </div>
                </div>
            </form>

            <!-- Loading Indicator -->
            <div id="loading" class="text-center d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">Mengirim reservasi...</p>
            </div>

            <!-- Success Message -->
            <div id="successMessage" class="alert alert-success d-none">
                <i class="fas fa-check-circle me-2"></i>
                <span id="successText"></span>
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="alert alert-danger d-none">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span id="errorText"></span>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - Cafe Resto page');

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                console.log('Mobile menu button clicked');
                mobileMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function(event) {
                if (!mobileMenu.contains(event.target) &&
                    !mobileMenuBtn.contains(event.target) &&
                    !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }

        // Table Selection from Cards
        const tableButtons = document.querySelectorAll('[data-table-type]');
        const tableTypeSelect = document.getElementById('tableType');

        if (tableButtons.length > 0 && tableTypeSelect) {
            tableButtons.forEach(button => {
                button.addEventListener('click', function() {
                    console.log('Table button clicked:', this.getAttribute('data-table-type'));
                    const tableType = this.getAttribute('data-table-type');
                    tableTypeSelect.value = tableType;

                    // Auto-focus pada select
                    setTimeout(() => {
                        tableTypeSelect.focus();
                    }, 300);
                });
            });
        }

        // Multi-step Form System
        let currentStep = 1;
        const totalSteps = 3;

        // Fungsi untuk berpindah step
        function goToStep(step) {
            console.log('Going to step:', step);

            // Sembunyikan semua step
            document.querySelectorAll('.step').forEach(el => {
                el.classList.add('d-none');
            });

            // Tampilkan step yang dituju
            const targetStep = document.querySelector(`.step-${step}`);
            if (targetStep) {
                targetStep.classList.remove('d-none');
                currentStep = step;

                // Set focus ke elemen pertama pada step
                setTimeout(() => {
                    const firstInput = targetStep.querySelector('input, select, textarea');
                    if (firstInput) {
                        firstInput.focus();
                    }
                }, 100);
            }

            console.log('Current step:', currentStep);
        }

        // Event listener untuk tombol "Selanjutnya"
        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Next button clicked for step:', currentStep);

                // Validasi step saat ini
                const currentStepElement = document.querySelector(`.step-${currentStep}`);
                if (!currentStepElement) {
                    console.error('Current step element not found');
                    return;
                }

                const inputs = currentStepElement.querySelectorAll('[required]');
                let isValid = true;
                let firstInvalidInput = null;

                inputs.forEach(input => {
                    input.classList.remove('is-invalid');

                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('is-invalid');

                        if (!firstInvalidInput) {
                            firstInvalidInput = input;
                        }
                    }

                    // Validasi khusus untuk email
                    if (input.type === 'email' && input.value.trim()) {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(input.value.trim())) {
                            isValid = false;
                            input.classList.add('is-invalid');
                        }
                    }

                    // Validasi khusus untuk telepon
                    if (input.name === 'phone' && input.value.trim()) {
                        const phoneRegex = /^[0-9+\-\s]+$/;
                        if (!phoneRegex.test(input.value.trim())) {
                            isValid = false;
                            input.classList.add('is-invalid');
                        }
                    }
                });

                if (isValid) {
                    goToStep(currentStep + 1);
                } else {
                    // Tampilkan pesan error
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Silakan lengkapi semua data yang diperlukan sebelum melanjutkan.',
                        confirmButtonColor: '#e17055'
                    });

                    // Focus ke input pertama yang invalid
                    if (firstInvalidInput) {
                        firstInvalidInput.focus();
                    }
                }
            });
        });

        // Event listener untuk tombol "Kembali"
        document.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Prev button clicked for step:', currentStep);

                if (currentStep > 1) {
                    goToStep(currentStep - 1);
                }
            });
        });

        // Inisialisasi form - tampilkan step 1
        goToStep(1);

        // Form Submission Handler
        const reservationForm = document.getElementById('reservationForm');

        if (reservationForm) {
            reservationForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                console.log('Form submission started');

                const submitButton = this.querySelector('button[type="submit"]');
                const loadingIndicator = document.getElementById('loading');
                const successMessage = document.getElementById('successMessage');
                const errorMessage = document.getElementById('errorMessage');

                if (!submitButton || !loadingIndicator) {
                    console.error('Required elements not found');
                    return;
                }

                // Validasi final sebelum submit
                const allInputs = this.querySelectorAll('[required]');
                let finalIsValid = true;

                allInputs.forEach(input => {
                    if (!input.value.trim()) {
                        finalIsValid = false;
                        input.classList.add('is-invalid');
                    }
                });

                if (!finalIsValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Data Tidak Lengkap',
                        text: 'Mohon lengkapi semua data yang diperlukan.',
                        confirmButtonColor: '#e17055'
                    });
                    return;
                }

                // Show loading, hide buttons
                submitButton.disabled = true;
                loadingIndicator.classList.remove('d-none');
                successMessage.classList.add('d-none');
                errorMessage.classList.add('d-none');

                // Collect form data
                const formData = new FormData(this);

                // Log form data for debugging
                console.log('Form data:');
                for (let [key, value] of formData.entries()) {
                    console.log(key + ': ' + value);
                }

                try {
                    const response = await fetch('{{ route("cafe-resto.reservation.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams(formData)
                    });

                    const data = await response.json();
                    console.log('Response received:', data);

                    loadingIndicator.classList.add('d-none');

                    if (data.success) {
                        // Show success message
                        document.getElementById('successText').textContent = data.message;
                        successMessage.classList.remove('d-none');

                        // Reset form dan kembali ke step 1
                        reservationForm.reset();
                        goToStep(1);

                        // Redirect to WhatsApp after 2 seconds
                        setTimeout(() => {
                            if (data.whatsapp_url) {
                                window.open(data.whatsapp_url, '_blank');
                            }

                            // Close modal after 1 more second
                            setTimeout(() => {
                                const modal = bootstrap.Modal.getInstance(document.getElementById('reservationModal'));
                                if (modal) {
                                    modal.hide();
                                }
                            }, 1000);
                        }, 2000);
                    } else {
                        // Show error message
                        let errorText = data.message || 'Terjadi kesalahan.';
                        if (data.errors) {
                            errorText = '';
                            for (const [key, messages] of Object.entries(data.errors)) {
                                errorText += messages.join(', ') + ' ';
                            }
                        }
                        document.getElementById('errorText').textContent = errorText;
                        errorMessage.classList.remove('d-none');
                        submitButton.disabled = false;
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    loadingIndicator.classList.add('d-none');
                    document.getElementById('errorText').textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                    errorMessage.classList.remove('d-none');
                    submitButton.disabled = false;
                }
            });
        }

        // Modal reset on close
        const reservationModal = document.getElementById('reservationModal');
        if (reservationModal) {
            reservationModal.addEventListener('hidden.bs.modal', function() {
                console.log('Modal closed, resetting form');
                if (reservationForm) {
                    reservationForm.reset();
                    goToStep(1);

                    // Reset semua status
                    document.getElementById('loading').classList.add('d-none');
                    document.getElementById('successMessage').classList.add('d-none');
                    document.getElementById('errorMessage').classList.add('d-none');

                    // Enable submit button
                    const submitButton = reservationForm.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = false;
                    }

                    // Remove invalid classes
                    reservationForm.querySelectorAll('.is-invalid').forEach(el => {
                        el.classList.remove('is-invalid');
                    });
                }
            });

            // Modal show event
            reservationModal.addEventListener('shown.bs.modal', function() {
                console.log('Modal shown');
                // Reset ke step 1 ketika modal dibuka
                goToStep(1);

                // Auto-focus pada select pertama
                setTimeout(() => {
                    const firstInput = document.querySelector('#tableType');
                    if (firstInput) {
                        firstInput.focus();
                    }
                }, 300);
            });
        }

        // Date validation - set min date to today
        const dateInput = document.getElementById('date');
        if (dateInput) {
            const today = new Date();
            const todayFormatted = today.toISOString().split('T')[0];
            dateInput.min = todayFormatted;
            console.log('Min date set to:', todayFormatted);

            // Set default date to tomorrow
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const tomorrowFormatted = tomorrow.toISOString().split('T')[0];
            dateInput.value = tomorrowFormatted;
        }

        // Time validation - set default time
        const timeSelect = document.getElementById('time');
        if (timeSelect) {
            // Set default time to 18:00
            timeSelect.value = '18:00';
        }

        // Guests validation - set default guests
        const guestsSelect = document.getElementById('guests');
        if (guestsSelect) {
            guestsSelect.value = '2';
        }

        // Add CSS for invalid inputs
        const style = document.createElement('style');
        style.textContent = `
            .is-invalid {
                border-color: #dc3545 !important;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right calc(0.375em + 0.1875rem) center;
                background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            }
            
            .is-invalid:focus {
                border-color: #dc3545 !important;
                box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection