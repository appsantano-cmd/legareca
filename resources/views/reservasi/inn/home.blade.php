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
                <p class="text-muted mb-5" style="max-width: 700px; margin: 0 auto;">Temukan kamar yang sesuai dengan
                    kebutuhan Anda. Setiap kamar didesain dengan sentuhan modern dan fasilitas lengkap untuk kenyamanan
                    maksimal.</p>
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
                            <p class="room-description">Kamar nyaman dengan tempat tidur queen size, dilengkapi AC, TV LED
                                32", dan kamar mandi pribadi yang bersih.</p>

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
                                <button type="button" class="booking-btn" data-bs-toggle="modal"
                                    data-bs-target="#bookingModal" data-room="Standard Room" data-price="350000">
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
                            <p class="room-description">Kamar lebih luas dengan balkon pribadi, tempat kerja ergonomis, dan
                                fasilitas premium untuk pengalaman menginap yang lebih eksklusif.</p>

                            <ul class="room-features mb-4">
                                <li><i class="fas fa-bed"></i> 1 Tempat Tidur King Size</li>
                                <li><i class="fas fa-user"></i> Maksimal 2 orang</li>
                                <li><i class="fas fa-wifi"></i> WiFi High-Speed Premium</li>
                                <li><i class="fas fa-utensils"></i> Sarapan Premium</li>
                                <li><i class="fas fa-bath"></i> Bathtub</li>
                                <li><i class="fas fa-desktop"></i> Meja Kerja</li>
                            </ul>

                            <div class="room-actions">
                                <a href="https://wa.me/6281328897679?text=Halo,%20saya%20ingin%20bertanya%20tentang%20Deluxe%20Room%20di%20Legareca%20Inn"
                                    target="_blank" class="whatsapp-btn">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                                <button type="button" class="booking-btn" data-bs-toggle="modal"
                                    data-bs-target="#bookingModal" data-room="Deluxe Room" data-price="550000">
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
                            <p class="room-description">Suite keluarga eksklusif dengan 2 kamar tidur terpisah, ruang tamu,
                                dan dapur kecil. Ideal untuk keluarga atau rombongan kecil.</p>

                            <ul class="room-features mb-4">
                                <li><i class="fas fa-bed"></i> 2 Kamar Tidur (King + Twin)</li>
                                <li><i class="fas fa-user"></i> Maksimal 4 orang</li>
                                <li><i class="fas fa-wifi"></i> WiFi High-Speed</li>
                                <li><i class="fas fa-utensils"></i> Dapur Kecil</li>
                                <li><i class="fas fa-couch"></i> Ruang Tamu Terpisah</li>
                                <li><i class="fas fa-tv"></i> 2 TV LED 40"</li>
                            </ul>

                            <div class="room-actions">
                                <a href="https://wa.me/6281328897679?text=Halo,%20saya%20ingin%20bertanya%20tentang%20Family%20Suite%20di%20Legareca%20Inn"
                                    target="_blank" class="whatsapp-btn">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                                <button type="button" class="booking-btn" data-bs-toggle="modal"
                                    data-bs-target="#bookingModal" data-room="Family Suite" data-price="850000">
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
                        <p class="mb-4" style="color: #666;">Hubungi kami untuk informasi lebih lanjut atau melakukan
                            reservasi. Tim kami siap membantu Anda 24/7.</p>

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
                                    <p class="mb-2 fw-bold" style="color: #2a9d8f; font-size: 1.1rem;">
                                        reservasi@legarecainn.com</p>
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
                                <p class="mb-2 fw-bold" style="color: #2a9d8f;">Jl. Padokan Baru No.B789, Jogonalan Lor,
                                    Tirtonirmolo, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55181</p>
                                <p class="text-muted mb-0">Berlokasi strategis di kawasan Legareca Space, mudah dijangkau
                                    dari berbagai fasilitas seni dan budaya Yogyakarta.</p>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3">
                            <a href="https://wa.me/6281328897679" target="_blank" class="whatsapp-btn px-5">
                                <i class="fab fa-whatsapp"></i> Chat via WhatsApp
                            </a>
                            <a href="tel:+6281328897679" class="booking-btn px-5"
                                style="background: linear-gradient(135deg, #264653, #2a9d8f);">
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
                    <h5 class="modal-title" id="bookingModalLabel"><i class="fas fa-calendar-check me-2"></i>Form
                        Reservasi Kamar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="bookingForm" action="{{ route('reservasi.inn.submit') }}" method="POST">
                        @csrf
                        <!-- Input tersembunyi untuk menyimpan data -->
                        <input type="hidden" id="selectedRoomType" name="room_type">
                        <input type="hidden" id="selectedRoomPrice" name="room_price">

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tipe Kamar</label>
                                <div class="form-control form-control-lg" id="roomTypeDisplay"
                                    style="background: #f8f9fa; font-weight: 600; min-height: 48px; display: flex; align-items: center;">
                                    <span class="text-muted">Pilih kamar terlebih dahulu</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Harga per Malam</label>
                                <div class="form-control form-control-lg" id="roomPriceDisplay"
                                    style="background: #f8f9fa; font-weight: 600; color: #2a9d8f; min-height: 48px; display: flex; align-items: center;">
                                    <span class="text-muted">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tambahkan bagian untuk memilih kamar jika belum dipilih dari tombol -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-bold">Pilih Kamar <span class="text-muted">(jika belum
                                        dipilih)</span></label>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="room-option" data-room="Standard Room" data-price="350000">
                                            <div class="card h-100 border">
                                                <div class="card-body text-center">
                                                    <h6 class="card-title fw-bold mb-2">Standard Room</h6>
                                                    <p class="text-success fw-bold mb-2">Rp 350.000</p>
                                                    <small class="text-muted d-block">Kamar standar dengan fasilitas
                                                        lengkap</small>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary mt-2 p-1 px-3 select-room-btn">
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
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary mt-2 p-1 px-3 select-room-btn">
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
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary mt-2 p-1 px-3 select-room-btn">
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
                                    <span class="input-group-text bg-primary text-white"><i
                                            class="fas fa-calendar-alt"></i></span>
                                    <input type="date" class="form-control" id="checkIn" name="check_in" required
                                        min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="checkOut" class="form-label fw-bold">Tanggal Check-out</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white"><i
                                            class="fas fa-calendar-alt"></i></span>
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
                                    <span class="input-group-text bg-primary text-white"><i
                                            class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="fullName" name="full_name" required
                                        placeholder="Nama sesuai KTP">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white">
                                        <i class="fab fa-whatsapp"></i>
                                    </span>
                                    <span class="input-group-text bg-light border"
                                        style="background: #e9ecef; font-weight: 600; color: #264653; border-right: none;">
                                        +62
                                    </span>
                                    <input type="tel" class="form-control" id="phone" name="phone" required
                                        placeholder="81234567890" pattern="[0-9]{9,15}"
                                        title="Masukkan nomor setelah kode negara +62 (contoh: 81234567890)"
                                        style="border-left: none;" autocomplete="off">
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Format: +62 diisi otomatis, masukkan nomor setelah +62 (contoh: 81234567890)
                                </small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i
                                        class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" required
                                    placeholder="johndoe@gmail.com">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="specialRequest" class="form-label fw-bold">Permintaan Khusus</label>
                            <textarea class="form-control" id="specialRequest" name="special_request" rows="3"
                                placeholder="Contoh: Kamar lantai atas, peringatan anniversary, makanan khusus, dll."></textarea>
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
                                        <p class="mb-2"><strong>Tipe Kamar:</strong> <span id="summaryRoomType">-</span>
                                        </p>
                                        <p class="mb-2"><strong>Harga per Malam:</strong> <span id="summaryRoomPrice">Rp
                                                0</span></p>
                                        <p class="mb-2"><strong>Jumlah Malam:</strong> <span id="summaryNights">0</span>
                                            malam</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Jumlah Kamar:</strong> <span id="summaryRooms">1</span>
                                        </p>
                                        <p class="mb-2"><strong>Check-in:</strong> <span id="summaryCheckIn">-</span>
                                        </p>
                                        <p class="mb-0"><strong>Check-out:</strong> <span id="summaryCheckOut">-</span>
                                        </p>
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
                                    <p class="mb-0">Setelah mengisi form ini, Anda akan diarahkan ke WhatsApp untuk
                                        konfirmasi dan pembayaran. Reservasi akan dikonfirmasi setelah pembayaran diterima.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="bookingForm" class="btn btn-primary px-4 py-2" id="submitBookingBtn">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Reservasi
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ============= SETUP AWAL =============
            const bookingForm = document.getElementById('bookingForm');
            const submitBtn = document.getElementById('submitBookingBtn');

            // Atribut untuk elemen display
            const roomTypeDisplay = document.getElementById('roomTypeDisplay');
            const roomPriceDisplay = document.getElementById('roomPriceDisplay');

            // Hidden inputs
            const selectedRoomType = document.getElementById('selectedRoomType');
            const selectedRoomPrice = document.getElementById('selectedRoomPrice');

            // Input fields
            const checkIn = document.getElementById('checkIn');
            const checkOut = document.getElementById('checkOut');
            const guests = document.getElementById('guests');
            const rooms = document.getElementById('rooms');
            const fullName = document.getElementById('fullName');
            const phone = document.getElementById('phone');
            const email = document.getElementById('email');
            const specialRequest = document.getElementById('specialRequest');

            // Summary elements
            const summaryRoomType = document.getElementById('summaryRoomType');
            const summaryRoomPrice = document.getElementById('summaryRoomPrice');
            const summaryNights = document.getElementById('summaryNights');
            const summaryRooms = document.getElementById('summaryRooms');
            const summaryCheckIn = document.getElementById('summaryCheckIn');
            const summaryCheckOut = document.getElementById('summaryCheckOut');
            const summaryTotal = document.getElementById('summaryTotal');

            // ============= FUNGSI FORMAT =============
            function formatRupiah(angka) {
                return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function parseRupiah(rupiah) {
                return parseInt(rupiah.replace(/[^0-9]/g, ''));
            }

            function formatDateToDisplay(dateString) {
                if (!dateString) return '-';
                let date = new Date(dateString + 'T00:00:00');
                let day = date.getDate().toString().padStart(2, '0');
                let month = (date.getMonth() + 1).toString().padStart(2, '0');
                let year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }

            // ============= FUNGSI FORMAT NOMOR WHATSAPP =============
            function formatWhatsAppNumber(phoneNumber) {
                // Hapus semua karakter non-digit
                let cleaned = phoneNumber.replace(/\D/g, '');

                // Jika nomor kosong, return empty string
                if (!cleaned) return '';

                // Jika dimulai dengan 0, ganti dengan 62
                if (cleaned.startsWith('0')) {
                    cleaned = '62' + cleaned.substring(1);
                }

                // Jika tidak dimulai dengan 62, tambahkan 62
                if (!cleaned.startsWith('62')) {
                    cleaned = '62' + cleaned;
                }

                // Hapus '62' di depan untuk disimpan di input (karena prefix sudah +62)
                // Tapi kita simpan nomor tanpa 62 di value input
                if (cleaned.startsWith('62')) {
                    cleaned = cleaned.substring(2);
                }

                return cleaned;
            }

            // ============= FUNGSI UPDATE DISPLAY =============
            function updateRoomDisplay(roomType, roomPrice) {
                // Update display
                if (roomTypeDisplay) {
                    roomTypeDisplay.innerHTML = roomType ?
                        `<span style="color: #264653; font-weight: 700;">${roomType}</span>` :
                        '<span class="text-muted">Pilih kamar terlebih dahulu</span>';
                }

                if (roomPriceDisplay) {
                    roomPriceDisplay.innerHTML = roomPrice ?
                        `<span style="color: #2a9d8f; font-weight: 700;">${formatRupiah(roomPrice)}</span>` :
                        '<span class="text-muted">Rp 0</span>';
                }

                // Update hidden inputs
                if (selectedRoomType) selectedRoomType.value = roomType || '';
                if (selectedRoomPrice) selectedRoomPrice.value = roomPrice || '';
            }

            // ============= FUNGSI UPDATE SUMMARY =============
            function updateSummary() {
                // Ambil data dari form
                const roomType = selectedRoomType?.value || '';
                const roomPrice = selectedRoomPrice?.value || '';
                const checkInVal = checkIn?.value || '';
                const checkOutVal = checkOut?.value || '';
                const roomsCount = parseInt(rooms?.value || 1);

                // Update summary teks
                if (summaryRoomType) summaryRoomType.textContent = roomType || '-';

                if (roomPrice) {
                    const price = parseInt(roomPrice);
                    summaryRoomPrice.textContent = formatRupiah(price);
                } else {
                    summaryRoomPrice.textContent = 'Rp 0';
                }

                if (summaryRooms) summaryRooms.textContent = roomsCount;

                // Hitung durasi jika tanggal sudah diisi
                if (checkInVal && checkOutVal) {
                    const start = new Date(checkInVal + 'T00:00:00');
                    const end = new Date(checkOutVal + 'T00:00:00');
                    const diffTime = end - start;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    if (diffDays > 0) {
                        summaryNights.textContent = diffDays;

                        // Hitung total harga
                        const price = parseInt(roomPrice || 0);
                        const total = price * diffDays * roomsCount;
                        summaryTotal.textContent = formatRupiah(total);
                    } else {
                        summaryNights.textContent = '0';
                        summaryTotal.textContent = 'Rp 0';
                    }

                    summaryCheckIn.textContent = formatDateToDisplay(checkInVal);
                    summaryCheckOut.textContent = formatDateToDisplay(checkOutVal);
                } else {
                    summaryNights.textContent = '0';
                    summaryCheckIn.textContent = '-';
                    summaryCheckOut.textContent = '-';
                    summaryTotal.textContent = 'Rp 0';
                }
            }

            // ============= FUNGSI SELECT ROOM =============
            function selectRoom(roomType, roomPrice) {
                updateRoomDisplay(roomType, roomPrice);
                updateSummary();

                // Hapus class active dari semua card
                document.querySelectorAll('.room-option .card').forEach(card => {
                    card.classList.remove('border-primary', 'bg-light');
                });

                // Add class active ke card yang dipilih
                const selectedCard = document.querySelector(`.room-option[data-room="${roomType}"] .card`);
                if (selectedCard) {
                    selectedCard.classList.add('border-primary', 'bg-light');
                }
            }

            // ============= EVENT LISTENERS =============

            // 1. Event untuk tombol booking di card kamar
            document.querySelectorAll('.booking-btn[data-bs-toggle="modal"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    const roomType = this.dataset.room;
                    const roomPrice = this.dataset.price;
                    selectRoom(roomType, roomPrice);

                    // Reset form fields
                    if (checkIn) checkIn.value = '';
                    if (checkOut) checkOut.value = '';
                    if (guests) guests.value = '2';
                    if (rooms) rooms.value = '1';
                    if (fullName) fullName.value = '';
                    if (phone) phone.value = ''; // Reset nomor WhatsApp
                    if (email) email.value = '';
                    if (specialRequest) specialRequest.value = '';

                    // Set minimum date for checkOut based on checkIn
                    if (checkIn) {
                        checkIn.min = new Date().toISOString().split('T')[0];
                    }

                    // Focus ke input phone setelah modal terbuka
                    setTimeout(() => {
                        if (phone) phone.focus();
                    }, 500);
                });
            });

            // 2. Event untuk tombol "Pilih" di dalam modal
            document.querySelectorAll('.select-room-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const roomOption = this.closest('.room-option');
                    if (roomOption) {
                        const roomType = roomOption.dataset.room;
                        const roomPrice = roomOption.dataset.price;
                        selectRoom(roomType, roomPrice);
                    }
                });
            });

            // 3. Event untuk card room di modal
            document.querySelectorAll('.room-option .card').forEach(card => {
                card.addEventListener('click', function(e) {
                    const roomOption = this.closest('.room-option');
                    if (roomOption) {
                        const roomType = roomOption.dataset.room;
                        const roomPrice = roomOption.dataset.price;
                        selectRoom(roomType, roomPrice);
                    }
                });
                card.style.cursor = 'pointer';
            });

            // 4. Event untuk input fields
            if (checkIn) {
                checkIn.addEventListener('change', function() {
                    if (checkOut) {
                        checkOut.min = this.value;
                        if (checkOut.value && checkOut.value <= this.value) {
                            checkOut.value = '';
                        }
                    }
                    updateSummary();
                });
            }

            if (checkOut) {
                checkOut.addEventListener('change', updateSummary);
            }

            if (rooms) {
                rooms.addEventListener('change', updateSummary);
            }

            // 5. Event khusus untuk nomor WhatsApp - AUTO FORMAT +62
            if (phone) {
                // Cegah user memasukkan prefix
                phone.addEventListener('keydown', function(e) {
                    // Cegah user mengetik angka 0 di awal
                    if (this.value.length === 0 && e.key === '0') {
                        e.preventDefault();
                        this.value = '';
                    }

                    // Cegah user mengetik karakter non-digit
                    if (!/^[0-9]$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete' && e.key !==
                        'Tab' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
                        e.preventDefault();
                    }
                });

                // Format saat mengetik
                phone.addEventListener('input', function(e) {
                    // Hanya izinkan angka
                    let value = this.value.replace(/\D/g, '');

                    // Batasi panjang maksimal 15 digit (nomor internasional)
                    if (value.length > 15) {
                        value = value.slice(0, 15);
                    }

                    // Update value
                    this.value = value;
                });

                // Validasi saat kehilangan fokus
                phone.addEventListener('blur', function(e) {
                    let value = this.value.trim();

                    if (value) {
                        // Minimal 9 digit setelah 62
                        if (value.length < 9) {
                            alert('Nomor WhatsApp minimal 9 digit setelah kode negara 62');
                            this.focus();
                        } else {
                            // Format ulang nomor (pastikan tanpa 62 di depan)
                            let formatted = formatWhatsAppNumber(value);
                            this.value = formatted;
                        }
                    }
                });

                // Focus otomatis ke input phone saat modal dibuka
                phone.addEventListener('focus', function() {
                    this.placeholder = '81234567890';
                });
            }

            // 6. Validasi kapasitas tamu
            if (guests) {
                guests.addEventListener('change', function() {
                    const selectedRoom = selectedRoomType?.value;
                    let maxGuests = 2;

                    if (selectedRoom === 'Family Suite') {
                        maxGuests = 4;
                    } else if (selectedRoom === 'Deluxe Room') {
                        maxGuests = 2;
                    } else if (selectedRoom === 'Standard Room') {
                        maxGuests = 2;
                    }

                    const guestCount = parseInt(this.value);
                    if (guestCount > maxGuests && selectedRoom) {
                        alert(
                            `Jumlah tamu melebihi kapasitas maksimal kamar ${selectedRoom} (maksimal ${maxGuests} orang)`
                            );
                        this.value = maxGuests;
                    }
                });
            }

            // 7. Validasi form sebelum submit
            if (bookingForm) {
                bookingForm.addEventListener('submit', function(e) {
                    // Cek apakah kamar sudah dipilih
                    if (!selectedRoomType?.value || !selectedRoomPrice?.value) {
                        e.preventDefault();
                        alert('Silakan pilih tipe kamar terlebih dahulu!');
                        return;
                    }

                    // Cek tanggal
                    if (!checkIn?.value || !checkOut?.value) {
                        e.preventDefault();
                        alert('Silakan isi tanggal check-in dan check-out!');
                        return;
                    }

                    // Cek nama
                    if (!fullName?.value.trim()) {
                        e.preventDefault();
                        alert('Silakan isi nama lengkap!');
                        fullName.focus();
                        return;
                    }

                    // Cek nomor WhatsApp
                    if (!phone?.value.trim()) {
                        e.preventDefault();
                        alert('Silakan isi nomor WhatsApp!');
                        phone.focus();
                        return;
                    }

                    // Validasi nomor WhatsApp
                    let phoneValue = phone.value.trim();

                    // Pastikan hanya angka
                    phoneValue = phoneValue.replace(/\D/g, '');

                    // Validasi panjang (minimal 9 digit setelah 62)
                    if (phoneValue.length < 9) {
                        e.preventDefault();
                        alert('Nomor WhatsApp minimal 9 digit setelah kode negara 62!');
                        phone.focus();
                        return;
                    }

                    // Format nomor untuk dikirim ke server: 62xxxxxxxxxx
                    let formattedPhone = '62' + phoneValue;

                    // Update input dengan format lengkap untuk dikirim ke server
                    // Kita tetap simpan di hidden input atau langsung ubah value
                    // Buat hidden input untuk nomor yang sudah diformat
                    let hiddenPhone = document.createElement('input');
                    hiddenPhone.type = 'hidden';
                    hiddenPhone.name = 'phone_formatted';
                    hiddenPhone.value = formattedPhone;

                    // Hapus hidden input lama jika ada
                    let oldHidden = document.querySelector('input[name="phone_formatted"]');
                    if (oldHidden) oldHidden.remove();

                    // Tambahkan hidden input baru
                    bookingForm.appendChild(hiddenPhone);

                    // Ubah value phone menjadi format +62 untuk display
                    phone.value = phoneValue;

                    // Cek email
                    if (!email?.value.trim()) {
                        e.preventDefault();
                        alert('Silakan isi alamat email!');
                        email.focus();
                        return;
                    }

                    // Validasi format email
                    const emailValue = email.value.trim();
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(emailValue)) {
                        e.preventDefault();
                        alert('Format email tidak valid!');
                        email.focus();
                        return;
                    }

                    // Jika semua validasi lolos, tampilkan loading
                    const submitBtn = document.getElementById('submitBookingBtn');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                        submitBtn.disabled = true;
                    }

                    return true;
                });
            }

            // 8. Reset form ketika modal ditutup
            const bookingModal = document.getElementById('bookingModal');
            if (bookingModal) {
                bookingModal.addEventListener('hidden.bs.modal', function() {
                    // Reset room selection
                    updateRoomDisplay('', '');

                    // Reset hidden inputs
                    if (selectedRoomType) selectedRoomType.value = '';
                    if (selectedRoomPrice) selectedRoomPrice.value = '';

                    // Reset form fields
                    if (checkIn) checkIn.value = '';
                    if (checkOut) checkOut.value = '';
                    if (guests) guests.value = '2';
                    if (rooms) rooms.value = '1';
                    if (fullName) fullName.value = '';
                    if (phone) phone.value = ''; // Reset nomor WhatsApp
                    if (email) email.value = '';
                    if (specialRequest) specialRequest.value = '';

                    // Remove hidden phone formatted
                    let hiddenPhone = document.querySelector('input[name="phone_formatted"]');
                    if (hiddenPhone) hiddenPhone.remove();

                    // Remove active class from cards
                    document.querySelectorAll('.room-option .card').forEach(card => {
                        card.classList.remove('border-primary', 'bg-light');
                    });

                    // Update summary
                    updateSummary();

                    // Reset submit button
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Reservasi';
                        submitBtn.disabled = false;
                    }
                });
            }

            // 9. Set default date untuk checkIn
            if (checkIn) {
                const today = new Date().toISOString().split('T')[0];
                checkIn.min = today;
            }

            // 10. Initial update summary
            updateSummary();
        });
    </script>
@endpush
