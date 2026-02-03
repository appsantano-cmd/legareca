@extends('layouts.layout_main')

@section('title', 'Reservasi Legareca Inn')

@push('styles')
<style>
    /* Reset untuk memastikan navbar bekerja */
    body {
        padding-top: 0 !important;
    }

    /* Tambahkan padding untuk konten karena navbar fixed */
    main {
        padding-top: 4rem !important;
        /* 4rem = 64px (tinggi navbar) */
    }

    /* Custom Styles for Legareca Inn Page - Hanya yang perlu */
    .hero-section {
        background: linear-gradient(rgba(10, 37, 64, 0.85), rgba(10, 37, 64, 0.9)),
            url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 120px 0;
        margin-bottom: 70px;
        position: relative;
        overflow: hidden;
    }

    .hero-section:before {
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

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
    }

    .room-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 30px;
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
    }

    .room-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .room-image {
        height: 280px;
        object-fit: cover;
        width: 100%;
        transition: transform 0.5s ease;
    }

    .room-card:hover .room-image {
        transform: scale(1.05);
    }

    .room-price {
        background: linear-gradient(135deg, #2a9d8f, #1d7873);
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        padding: 8px 20px;
        border-radius: 10px;
        display: inline-block;
        margin-bottom: 15px;
    }

    .room-features {
        list-style: none;
        padding-left: 0;
        margin-bottom: 25px;
    }

    .room-features li {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .room-features li i {
        color: #2a9d8f;
        margin-right: 12px;
        width: 20px;
        text-align: center;
    }

    .contact-box {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border-radius: 16px;
        padding: 40px;
        margin-top: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(42, 157, 143, 0.1);
    }

    .whatsapp-btn {
        background: linear-gradient(135deg, #25D366, #128C7E);
        color: white;
        padding: 14px 28px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        flex: 1;
    }

    .whatsapp-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
        color: white;
    }

    .whatsapp-btn i {
        margin-right: 12px;
        font-size: 1.3rem;
    }

    .booking-btn {
        background: linear-gradient(135deg, #ff7a18, #ff3d00);
        color: #ffffff;
    }

    .booking-btn:hover {
        background: linear-gradient(135deg, #ff6a00, #e53935);
        color: #ffffff;
    }


    .section-title {
        position: relative;
        padding-bottom: 20px;
        margin-bottom: 40px;
        color: #264653;
        font-size: 2.2rem;
        font-weight: 700;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #2a9d8f, #e76f51);
        border-radius: 2px;
    }

    .badge-availability {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 2;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .room-actions {
        display: flex;
        gap: 15px;
        align-items: center;
        margin-top: 20px;
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #2a9d8f, #1d7873);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .feature-icon i {
        color: white;
        font-size: 1.3rem;
    }

    .info-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f0f0;
        transition: transform 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
    }

    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        background: linear-gradient(135deg, #264653, #2a9d8f);
        color: white;
        border-radius: 16px 16px 0 0;
        padding: 25px 30px;
        border: none;
    }

    .modal-header .btn-close {
        filter: invert(1) brightness(100%);
    }

    .form-control,
    .form-select {
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2a9d8f;
        box-shadow: 0 0 0 0.25rem rgba(42, 157, 143, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #2a9d8f, #1d7873);
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1d7873, #155e58);
        transform: translateY(-2px);
    }

    .lead-text {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.9);
        max-width: 600px;
        margin: 0 auto 30px;
        line-height: 1.6;
    }

    .room-description {
        color: #666;
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .facility-list li {
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
    }

    .facility-list li:last-child {
        border-bottom: none;
    }

    .stats-box {
        background: linear-gradient(135deg, #264653, #2a9d8f);
        color: white;
        padding: 30px;
        border-radius: 16px;
        text-align: center;
        margin-top: 40px;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 80px 0;
            margin-bottom: 50px;
        }

        .section-title {
            font-size: 1.8rem;
        }

        .room-actions {
            flex-direction: column;
        }

        .whatsapp-btn,
        .booking-btn {
            width: 100%;
            text-align: center;
        }

        .contact-box {
            padding: 25px;
        }
    }
</style>
@endpush

@section('content')

<!-- Include Navbar dari partials -->
@include('partials.navbar')

<!-- Hero Section -->
<section class="hero-section text-center pt-24 pb-3">
    <div class="container">
        <div class="hero-content">
            <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown">
                Legareca Inn
            </h1>

            <p class="lead-text mb-5 animate__animated animate__fadeInUp">
                Penginapan premium dengan kenyamanan maksimal di jantung Yogyakarta.
                Pengalaman menginap yang tak terlupakan dengan fasilitas lengkap dan pelayanan terbaik.
            </p>

            <a href="#rooms"
                class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold shadow animate__animated animate__fadeInUp"
                style="background: white; color: #264653;">
                <i class="fas fa-bed me-2"></i>Lihat Kamar Tersedia
            </a>
        </div>
    </div>
</section>


<!-- Room List Section -->
<section id="rooms" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title d-inline-block">Kamar Tersedia</h2>
            <p class="text-muted mb-5" style="max-width: 700px; margin: 0 auto;">Temukan kamar yang sesuai dengan kebutuhan Anda. Setiap kamar didesain dengan sentuhan modern dan fasilitas lengkap untuk kenyamanan maksimal.</p>
        </div>

        <div class="row">
            <!-- Room 1: Standard Room -->
            <div class="col-lg-4 col-md-6">
                <div class="room-card">
                    <div class="position-relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                            alt="Standard Room" class="room-image">
                        <span class="badge bg-success badge-availability">Tersedia</span>
                    </div>
                    <div class="p-4">
                        <h3 class="h4 mb-3 fw-bold" style="color: #264653;">Standard Room</h3>
                        <div class="room-price mb-3">Rp 350.000 / malam</div>
                        <p class="room-description">Kamar nyaman dengan tempat tidur queen size, dilengkapi AC, TV LED 32", dan kamar mandi pribadi yang bersih.</p>

                        <ul class="room-features mb-4">
                            <li><i class="fas fa-bed"></i> 1 Tempat Tidur Queen Size</li>
                            <li><i class="fas fa-user"></i> Maksimal 2 orang</li>
                            <li><i class="fas fa-wifi"></i> WiFi High-Speed</li>
                            <li><i class="fas fa-coffee"></i> Sarapan Inklusif</li>
                            <li><i class="fas fa-snowflake"></i> AC</li>
                        </ul>

                        <div class="room-actions">
                            <a href="https://wa.me/6281328897679?text=Halo,%20saya%20ingin%20bertanya%20tentang%20Standard%20Room%20di%20Legareca%20Inn"
                                target="_blank" class="whatsapp-btn">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <button type="button" class="booking-btn" data-bs-toggle="modal" data-bs-target="#bookingModal" data-room="Standard Room" data-price="350000">
                                Booking Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room 2: Deluxe Room -->
            <div class="col-lg-4 col-md-6">
                <div class="room-card">
                    <div class="position-relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2074&q=80"
                            alt="Deluxe Room" class="room-image">
                        <span class="badge bg-success badge-availability">Tersedia</span>
                    </div>
                    <div class="p-4">
                        <h3 class="h4 mb-3 fw-bold" style="color: #264653;">Deluxe Room</h3>
                        <div class="room-price mb-3">Rp 550.000 / malam</div>
                        <p class="room-description">Kamar lebih luas dengan balkon pribadi, tempat kerja ergonomis, dan fasilitas premium untuk pengalaman menginap yang lebih eksklusif.</p>

                        <ul class="room-features mb-4">
                            <li><i class="fas fa-bed"></i> 1 Tempat Tidur King Size</li>
                            <li><i class="fas fa-user"></i> Maksimal 2 orang</li>
                            <li><i class="fas fa-wifi"></i> WiFi High-Speed Premium</li>
                            <li><i class="fas fa-utensils"></i> Sarapan Premium</li>
                            <li><i class="fas fa-bath"></i> Bathtub</li>
                            <li><i class="fas fa-desktop"></i> Meja Kerja</li>
                        </ul>

                        <div class="room-actions">
                            <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20bertanya%20tentang%20Deluxe%20Room%20di%20Legareca%20Inn"
                                target="_blank" class="whatsapp-btn">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <button type="button" class="booking-btn" data-bs-toggle="modal" data-bs-target="#bookingModal" data-room="Deluxe Room" data-price="550000">
                                Booking Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room 3: Family Suite -->
            <div class="col-lg-4 col-md-6">
                <div class="room-card">
                    <div class="position-relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1615873968403-89e068629265?ixlib=rb-4.0.3&auto=format&fit=crop&w=2080&q=80"
                            alt="Family Suite" class="room-image">
                        <span class="badge bg-warning text-dark badge-availability">Terbatas</span>
                    </div>
                    <div class="p-4">
                        <h3 class="h4 mb-3 fw-bold" style="color: #264653;">Family Suite</h3>
                        <div class="room-price mb-3">Rp 850.000 / malam</div>
                        <p class="room-description">Suite keluarga eksklusif dengan 2 kamar tidur terpisah, ruang tamu, dan dapur kecil. Ideal untuk keluarga atau rombongan kecil.</p>

                        <ul class="room-features mb-4">
                            <li><i class="fas fa-bed"></i> 2 Kamar Tidur (King + Twin)</li>
                            <li><i class="fas fa-user"></i> Maksimal 4 orang</li>
                            <li><i class="fas fa-wifi"></i> WiFi High-Speed</li>
                            <li><i class="fas fa-utensils"></i> Dapur Kecil</li>
                            <li><i class="fas fa-couch"></i> Ruang Tamu Terpisah</li>
                            <li><i class="fas fa-tv"></i> 2 TV LED 40"</li>
                        </ul>

                        <div class="room-actions">
                            <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20bertanya%20tentang%20Family%20Suite%20di%20Legareca%20Inn"
                                target="_blank" class="whatsapp-btn">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <button type="button" class="booking-btn" data-bs-toggle="modal" data-bs-target="#bookingModal" data-room="Family Suite" data-price="850000">
                                Booking Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="row mt-5">
            <div class="col-md-3 col-6">
                <div class="stats-box">
                    <div class="stats-number">24/7</div>
                    <div class="stats-label">Resepsionis</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-box">
                    <div class="stats-number">50+</div>
                    <div class="stats-label">Kamar</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-box">
                    <div class="stats-number">4.8</div>
                    <div class="stats-label">Rating</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-box">
                    <div class="stats-number">100%</div>
                    <div class="stats-label">Kepuasan</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact & Information Section -->
<section id="contact" class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="contact-box">
                    <h2 class="section-title" style="font-size: 1.8rem;">Informasi & Reservasi</h2>
                    <p class="mb-4" style="color: #666;">Hubungi kami untuk informasi lebih lanjut atau melakukan reservasi. Tim kami siap membantu Anda 24/7.</p>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <div class="feature-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <h5 class="fw-bold mb-3" style="color: #264653;">Telepon</h5>
                                <p class="mb-2 fw-bold" style="color: #2a9d8f; font-size: 1.2rem;">(0274) 123-4567</p>
                                <p class="text-muted mb-0">Senin - Minggu: 08.00 - 20.00 WIB</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <div class="feature-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h5 class="fw-bold mb-3" style="color: #264653;">Email</h5>
                                <p class="mb-2 fw-bold" style="color: #2a9d8f; font-size: 1.1rem;">reservasi@legarecainn.com</p>
                                <p class="text-muted mb-0">Respon dalam 1x24 jam</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="info-card">
                            <div class="feature-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5 class="fw-bold mb-3" style="color: #264653;">Lokasi</h5>
                            <p class="mb-2 fw-bold" style="color: #2a9d8f;">Jl. Padokan Baru No.B789, Jogonalan Lor, Tirtonirmolo, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55181</p>
                            <p class="text-muted mb-0">Berlokasi strategis di kawasan Legareca Space, mudah dijangkau dari berbagai fasilitas seni dan budaya Yogyakarta.</p>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="https://wa.me/6281234567890" target="_blank" class="whatsapp-btn px-5">
                            <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                        </a>
                        <a href="tel:+622741234567" class="booking-btn px-5" style="background: linear-gradient(135deg, #264653, #2a9d8f);">
                            <i class="fas fa-phone-alt"></i> Telepon Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="info-card h-100">
                    <h3 class="h5 fw-bold mb-4" style="color: #264653;">Fasilitas & Layanan</h3>
                    <ul class="facility-list list-unstyled">
                        <li><i class="fas fa-check-circle text-success me-3"></i> Resepsionis 24 jam</li>
                        <li><i class="fas fa-check-circle text-success me-3"></i> Area parkir luas & aman</li>
                        <li><i class="fas fa-check-circle text-success me-3"></i> Restoran & kafe premium</li>
                        <li><i class="fas fa-check-circle text-success me-3"></i> Laundry & dry cleaning</li>
                        <li><i class="fas fa-check-circle text-success me-3"></i> Ruang meeting & co-working</li>
                        <li><i class="fas fa-check-circle text-success me-3"></i> Tour & travel assistance</li>
                        <li><i class="fas fa-check-circle text-success me-3"></i> Airport transfer service</li>
                        <li><i class="fas fa-check-circle text-success me-3"></i> Gym & wellness center</li>
                    </ul>

                    <h3 class="h5 fw-bold mt-5 mb-3" style="color: #264653;">Kebijakan</h3>
                    <ul class="facility-list list-unstyled">
                        <li><i class="fas fa-sign-in-alt text-primary me-3"></i> Check-in: 14.00 WIB</li>
                        <li><i class="fas fa-sign-out-alt text-primary me-3"></i> Check-out: 12.00 WIB</li>
                        <li><i class="fas fa-smoking-ban text-danger me-3"></i> Area bebas rokok</li>
                        <li><i class="fas fa-paw text-warning me-3"></i> Tidak menerima hewan peliharaan</li>
                        <li><i class="fas fa-child text-info me-3"></i> Anak di bawah 5 tahun gratis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel"><i class="fas fa-calendar-check me-2"></i>Form Reservasi Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="bookingForm">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="roomType" class="form-label fw-bold">Tipe Kamar</label>
                            <input type="text" class="form-control form-control-lg" id="roomType" name="room_type" readonly style="background: #f8f9fa; font-weight: 600;">
                        </div>
                        <div class="col-md-6">
                            <label for="roomPrice" class="form-label fw-bold">Harga per Malam</label>
                            <input type="text" class="form-control form-control-lg" id="roomPrice" name="room_price" readonly style="background: #f8f9fa; font-weight: 600; color: #2a9d8f;">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="checkIn" class="form-label fw-bold">Tanggal Check-in</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" class="form-control" id="checkIn" name="check_in" required min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="checkOut" class="form-label fw-bold">Tanggal Check-out</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-alt"></i></span>
                                <input type="date" class="form-control" id="checkOut" name="check_out" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="guests" class="form-label fw-bold">Jumlah Tamu</label>
                            <select class="form-select" id="guests" name="guests" required>
                                <option value="1">1 Orang</option>
                                <option value="2" selected>2 Orang</option>
                                <option value="3">3 Orang</option>
                                <option value="4">4 Orang</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="rooms" class="form-label fw-bold">Jumlah Kamar</label>
                            <select class="form-select" id="rooms" name="rooms" required>
                                <option value="1" selected>1 Kamar</option>
                                <option value="2">2 Kamar</option>
                                <option value="3">3 Kamar</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="fullName" class="form-label fw-bold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="fullName" name="full_name" required placeholder="Nama sesuai KTP">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold">Nomor WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text bg-success text-white"><i class="fab fa-whatsapp"></i></span>
                                <input type="tel" class="form-control" id="phone" name="phone" required placeholder="628xxxxxxxxxx">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="email@anda.com">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="specialRequest" class="form-label fw-bold">Permintaan Khusus</label>
                        <textarea class="form-control" id="specialRequest" name="special_request" rows="3" placeholder="Contoh: Kamar lantai atas, peringatan anniversary, makanan khusus, dll."></textarea>
                        <div class="form-text">Silakan isi jika ada permintaan khusus untuk kenyamanan Anda</div>
                    </div>

                    <div class="alert alert-info border-info">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x text-info me-3"></i>
                            <div>
                                <h6 class="alert-heading mb-2">Informasi Penting</h6>
                                <p class="mb-0">Setelah mengisi form ini, Anda akan diarahkan ke WhatsApp untuk konfirmasi dan pembayaran. Reservasi akan dikonfirmasi setelah pembayaran diterima.</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="bookingForm" class="btn btn-primary px-4 py-2">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Reservasi
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css"></script>
<script>
    // Mobile Menu Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileMenu.contains(event.target) &&
                    !mobileMenuBtn.contains(event.target) &&
                    !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }

        // Booking Modal Script
        const bookingModal = document.getElementById('bookingModal');

        if (bookingModal) {
            bookingModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const roomType = button.getAttribute('data-room');
                const roomPrice = button.getAttribute('data-price');

                const modalTitle = bookingModal.querySelector('.modal-title');
                const modalRoomType = bookingModal.querySelector('#roomType');
                const modalRoomPrice = bookingModal.querySelector('#roomPrice');

                modalTitle.innerHTML = `<i class="fas fa-bed me-2"></i>Booking ${roomType}`;
                modalRoomType.value = roomType;
                modalRoomPrice.value = formatRupiah(roomPrice);
            });
        }

        function formatRupiah(angka) {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        }

        const checkInInput = document.getElementById('checkIn');
        const checkOutInput = document.getElementById('checkOut');

        if (checkInInput && checkOutInput) {
            checkInInput.addEventListener('change', function() {
                const tomorrow = new Date(this.value);
                tomorrow.setDate(tomorrow.getDate() + 1);
                const nextDay = tomorrow.toISOString().split('T')[0];
                checkOutInput.min = nextDay;

                if (checkOutInput.value && new Date(checkOutInput.value) < tomorrow) {
                    checkOutInput.value = nextDay;
                }
            });
        }

        const bookingForm = document.getElementById('bookingForm');
        if (bookingForm) {
            bookingForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const roomType = document.getElementById('roomType').value;
                const checkIn = document.getElementById('checkIn').value;
                const checkOut = document.getElementById('checkOut').value;
                const guests = document.getElementById('guests').value;
                const rooms = document.getElementById('rooms').value;
                const fullName = document.getElementById('fullName').value;
                const phone = document.getElementById('phone').value;
                const email = document.getElementById('email').value;
                const specialRequest = document.getElementById('specialRequest').value;

                const message = `*RESERVASI LEGARECA INN*%0A%0A` +
                    `*Detail Reservasi:*%0A` +
                    `Tipe Kamar: ${roomType}%0A` +
                    `Check-in: ${formatDate(checkIn)}%0A` +
                    `Check-out: ${formatDate(checkOut)}%0A` +
                    `Jumlah Kamar: ${rooms} kamar%0A` +
                    `Jumlah Tamu: ${guests} orang%0A%0A` +
                    `*Data Pemesan:*%0A` +
                    `Nama: ${fullName}%0A` +
                    `WhatsApp: ${phone}%0A` +
                    `Email: ${email}%0A` +
                    `Permintaan Khusus: ${specialRequest || 'Tidak ada'}%0A%0A` +
                    `_Terima kasih atas reservasi Anda. Tim kami akan menghubungi Anda untuk konfirmasi lebih lanjut._`;

                window.open(`https://wa.me/6281234567890?text=${message}`, '_blank');

                const modal = bootstrap.Modal.getInstance(bookingModal);
                modal.hide();

                bookingForm.reset();
            });
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return date.toLocaleDateString('id-ID', options);
        }
    });
</script>
@endsection