@extends('layouts.layout_main')

@section('title', 'Venue - Legareca Space')

@section('content')
<!-- Hero Section -->
<section class="venue-hero-section">
    <div class="container">
        <div class="venue-hero-content text-center">
            <h1 class="display-4 fw-bold mb-4">Legareca Space Venue</h1>
            <p class="venue-lead-text">
                Ruang Acara Premium dengan Fasilitas Lengkap untuk Setiap Momen Spesial
            </p>
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center mt-4">
                <a href="{{ route('venue.index') }}" class="venue-booking-btn">
                    <i class="fas fa-calendar-check me-2"></i> Booking Venue Sekarang
                </a>
                <a href="#facilities" class="venue-contact-btn">
                    <i class="fas fa-building me-2"></i> Lihat Fasilitas
                </a>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h2 class="venue-section-title">Tentang Venue Kami</h2>
                <p class="venue-description">
                    Legareca Space adalah venue premium yang didesain khusus untuk berbagai jenis acara. 
                    Dengan kombinasi antara elegan dan fungsionalitas, kami menyediakan ruang yang sempurna 
                    untuk kesuksesan acara Anda.
                </p>
                <p class="venue-description">
                    Terletak di lokasi strategis dengan akses mudah, venue kami dilengkapi dengan 
                    teknologi terkini dan didukung oleh tim profesional yang siap membantu.
                </p>
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="venue-info-card">
                            <div class="venue-feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Kapasitas</h5>
                            <p class="text-muted mb-0">50 - 500 orang</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="venue-info-card">
                            <div class="venue-feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Durasi</h5>
                            <p class="text-muted mb-0">Flexible hours</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="venue-card">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                             alt="Legareca Space Interior" class="venue-image">
                        <span class="venue-badge" style="background: linear-gradient(135deg, #2a9d8f, #1d7873); color: white;">
                            Premium Venue
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section id="facilities" class="py-5 bg-light">
    <div class="container">
        <h2 class="venue-section-title text-center">Fasilitas Lengkap</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="venue-info-card h-100">
                    <div class="venue-feature-icon">
                        <i class="fas fa-volume-up"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Audio Visual</h4>
                    <ul class="venue-facility-list">
                        <li><i class="fas fa-check text-success me-2"></i> Sound System Professional</li>
                        <li><i class="fas fa-check text-success me-2"></i> Projector & Screen 300"</li>
                        <li><i class="fas fa-check text-success me-2"></i> Wireless Microphone</li>
                        <li><i class="fas fa-check text-success me-2"></i> Complete AV Setup</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="venue-info-card h-100">
                    <div class="venue-feature-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Ruang & Interior</h4>
                    <ul class="venue-facility-list">
                        <li><i class="fas fa-check text-success me-2"></i> Full AC Central</li>
                        <li><i class="fas fa-check text-success me-2"></i> Stage Customizable</li>
                        <li><i class="fas fa-check text-success me-2"></i> Lighting System</li>
                        <li><i class="fas fa-check text-success me-2"></i> Elegant Interior Design</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="venue-info-card h-100">
                    <div class="venue-feature-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Layanan Tambahan</h4>
                    <ul class="venue-facility-list">
                        <li><i class="fas fa-check text-success me-2"></i> Free High-Speed WiFi</li>
                        <li><i class="fas fa-check text-success me-2"></i> Catering Service</li>
                        <li><i class="fas fa-check text-success me-2"></i> Parkir Luas</li>
                        <li><i class="fas fa-check text-success me-2"></i> Event Coordinator</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Venue Types -->
<section class="py-5">
    <div class="container">
        <h2 class="venue-section-title text-center">Jenis Acara yang Cocok</h2>
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="venue-event-type-card">
                    <div class="venue-event-icon" style="background: linear-gradient(135deg, #2a9d8f, #1d7873);">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Seminar & Workshop</h5>
                    <p class="text-muted small mb-0">Kapasitas 50-300 orang</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="venue-event-type-card">
                    <div class="venue-event-icon" style="background: linear-gradient(135deg, #e76f51, #f4a261);">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Business Meeting</h5>
                    <p class="text-muted small mb-0">Boardroom setup</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="venue-event-type-card">
                    <div class="venue-event-icon" style="background: linear-gradient(135deg, #e9c46a, #f4a261);">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Pernikahan</h5>
                    <p class="text-muted small mb-0">Reception & Party</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="venue-event-type-card">
                    <div class="venue-event-icon" style="background: linear-gradient(135deg, #264653, #2a9d8f);">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Product Launch</h5>
                    <p class="text-muted small mb-0">Exhibition & Showcase</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="venue-section-title text-center">Paket Harga</h2>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="venue-package-card">
                    <h3 class="fw-bold text-center mb-3">Paket Basic</h3>
                    <div class="text-center mb-4">
                        <span class="venue-stats-number" style="color: #2a9d8f;">Rp 8.5</span>
                        <span class="text-muted">juta</span>
                        <p class="text-muted small mt-2">/ hari</p>
                    </div>
                    <ul class="venue-facility-list">
                        <li><i class="fas fa-check text-success me-2"></i> Kapasitas 50-100 orang</li>
                        <li><i class="fas fa-check text-success me-2"></i> Basic sound system</li>
                        <li><i class="fas fa-check text-success me-2"></i> Projector & screen</li>
                        <li><i class="fas fa-check text-success me-2"></i> Free WiFi</li>
                        <li><i class="fas fa-check text-success me-2"></i> Standard lighting</li>
                    </ul>
                    <div class="venue-actions mt-4">
                        <a href="{{ route('venue.index') }}" class="venue-booking-btn w-100 text-center">
                            <i class="fas fa-calendar-check me-2"></i> Pilih Paket
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="venue-package-card popular">
                    <h3 class="fw-bold text-center mb-3">Paket Premium</h3>
                    <div class="text-center mb-4">
                        <span class="venue-stats-number" style="color: #2a9d8f;">Rp 12.5</span>
                        <span class="text-muted">juta</span>
                        <p class="text-muted small mt-2">/ hari</p>
                    </div>
                    <ul class="venue-facility-list">
                        <li><i class="fas fa-check text-success me-2"></i> Kapasitas 100-250 orang</li>
                        <li><i class="fas fa-check text-success me-2"></i> Professional sound system</li>
                        <li><i class="fas fa-check text-success me-2"></i> Full lighting setup</li>
                        <li><i class="fas fa-check text-success me-2"></i> Catering untuk 50 orang</li>
                        <li><i class="fas fa-check text-success me-2"></i> Stage decoration</li>
                    </ul>
                    <div class="venue-actions mt-4">
                        <a href="{{ route('venue.index') }}" class="venue-booking-btn w-100 text-center">
                            <i class="fas fa-crown me-2"></i> Pilih Paket
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="venue-package-card">
                    <h3 class="fw-bold text-center mb-3">Paket Platinum</h3>
                    <div class="text-center mb-4">
                        <span class="venue-stats-number" style="color: #2a9d8f;">Rp 18</span>
                        <span class="text-muted">juta</span>
                        <p class="text-muted small mt-2">/ hari</p>
                    </div>
                    <ul class="venue-facility-list">
                        <li><i class="fas fa-check text-success me-2"></i> Kapasitas 250-500 orang</li>
                        <li><i class="fas fa-check text-success me-2"></i> Complete AV system</li>
                        <li><i class="fas fa-check text-success me-2"></i> Stage & decoration</li>
                        <li><i class="fas fa-check text-success me-2"></i> Full catering service</li>
                        <li><i class="fas fa-check text-success me-2"></i> Event coordinator</li>
                    </ul>
                    <div class="venue-actions mt-4">
                        <a href="{{ route('venue.index') }}" class="venue-booking-btn w-100 text-center">
                            <i class="fas fa-gem me-2"></i> Pilih Paket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-5">
    <div class="container">
        <h2 class="venue-section-title text-center">Gallery Venue</h2>
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="venue-gallery-item">
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Venue Interior">
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="venue-gallery-item">
                    <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Event Setup">
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="venue-gallery-item">
                    <img src="https://images.unsplash.com/photo-1492684223066-e9e4aab4d25e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Stage Setup">
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="venue-gallery-item">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Audience">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="venue-cta-section">
    <div class="container">
        <div class="venue-cta-content text-center">
            <h2 class="display-5 fw-bold mb-4">Siap Mengadakan Acara?</h2>
            <p class="lead mb-5 opacity-90">
                Hubungi kami sekarang untuk konsultasi gratis dan dapatkan penawaran spesial!
            </p>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('venue.index') }}" class="venue-booking-btn">
                                <i class="fas fa-calendar-check me-2"></i> Booking Venue Sekarang
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="tel:+622112345678" class="venue-contact-btn">
                                <i class="fas fa-phone-alt me-2"></i> Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="venue-stats-box mt-5">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="venue-stats-number">500+</div>
                        <div class="venue-stats-label">Acara Sukses</div>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="venue-stats-number">98%</div>
                        <div class="venue-stats-label">Kepuasan Klien</div>
                    </div>
                    <div class="col-md-4">
                        <div class="venue-stats-number">24/7</div>
                        <div class="venue-stats-label">Customer Support</div>
                    </div>
                </div>
            </div>
            <p class="mt-5 mb-0 opacity-75">
                <i class="fas fa-envelope me-2"></i>venue@legarecaspace.com 
                <span class="mx-3">|</span>
                <i class="fas fa-phone me-2"></i>(021) 1234-5678
                <span class="mx-3">|</span>
                <i class="fas fa-map-marker-alt me-2"></i>Jl. Legareca No. 123, Jakarta
            </p>
        </div>
    </div>
</section>
@endsection