@extends('layouts.layout_main')

@section('title', 'Reservasi Legareca Inn')

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
                    <!-- Input tersembunyi untuk menyimpan data -->
                    <input type="hidden" id="selectedRoomType" name="room_type">
                    <input type="hidden" id="selectedRoomPrice" name="room_price">
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipe Kamar</label>
                            <div class="form-control form-control-lg" id="roomTypeDisplay" style="background: #f8f9fa; font-weight: 600; min-height: 48px; display: flex; align-items: center;">
                                <span class="text-muted">Pilih kamar terlebih dahulu</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Harga per Malam</label>
                            <div class="form-control form-control-lg" id="roomPriceDisplay" style="background: #f8f9fa; font-weight: 600; color: #2a9d8f; min-height: 48px; display: flex; align-items: center;">
                                <span class="text-muted">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tambahkan bagian untuk memilih kamar jika belum dipilih dari tombol -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label fw-bold">Pilih Kamar <span class="text-muted">(jika belum dipilih)</span></label>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="room-option" data-room="Standard Room" data-price="350000">
                                        <div class="card h-100 border">
                                            <div class="card-body text-center">
                                                <h6 class="card-title fw-bold mb-2">Standard Room</h6>
                                                <p class="text-success fw-bold mb-2">Rp 350.000</p>
                                                <small class="text-muted d-block">Kamar standar dengan fasilitas lengkap</small>
                                                <button type="button" class="btn btn-sm btn-outline-primary mt-2 p-1 px-3 select-room-btn">
                                                    Pilih
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="room-option" data-room="Deluxe Room" data-price="550000">
                                        <div class="card h-100 border">
                                            <div class="card-body text-center">
                                                <h6 class="card-title fw-bold mb-2">Deluxe Room</h6>
                                                <p class="text-success fw-bold mb-2">Rp 550.000</p>
                                                <small class="text-muted d-block">Kamar premium dengan balkon</small>
                                                <button type="button" class="btn btn-sm btn-outline-primary mt-2 p-1 px-3 select-room-btn">
                                                    Pilih
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="room-option" data-room="Family Suite" data-price="850000">
                                        <div class="card h-100 border">
                                            <div class="card-body text-center">
                                                <h6 class="card-title fw-bold mb-2">Family Suite</h6>
                                                <p class="text-success fw-bold mb-2">Rp 850.000</p>
                                                <small class="text-muted d-block">Suite keluarga dengan 2 kamar</small>
                                                <button type="button" class="btn btn-sm btn-outline-primary mt-2 p-1 px-3 select-room-btn">
                                                    Pilih
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

                    <!-- Ringkasan Reservasi -->
                    <div class="card border-primary mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-receipt me-2"></i>Ringkasan Reservasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Tipe Kamar:</strong> <span id="summaryRoomType">-</span></p>
                                    <p class="mb-2"><strong>Harga per Malam:</strong> <span id="summaryRoomPrice">Rp 0</span></p>
                                    <p class="mb-2"><strong>Jumlah Malam:</strong> <span id="summaryNights">0</span> malam</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Jumlah Kamar:</strong> <span id="summaryRooms">1</span></p>
                                    <p class="mb-2"><strong>Check-in:</strong> <span id="summaryCheckIn">-</span></p>
                                    <p class="mb-0"><strong>Check-out:</strong> <span id="summaryCheckOut">-</span></p>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Total Perkiraan</h6>
                                <h5 class="mb-0 text-success" id="summaryTotal">Rp 0</h5>
                            </div>
                        </div>
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
                <button type="submit" form="bookingForm" class="btn btn-primary px-4 py-2" id="submitBookingBtn" disabled>
                    <i class="fas fa-paper-plane me-2"></i>Kirim Reservasi
                </button>
            </div>
        </div>
    </div>
</div>
@endsection