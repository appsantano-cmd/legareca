@extends('layouts.layout_main')

@section('title', 'Legareca Cafe & Resto - Reservasi')

@section('content')

<!-- NAVBAR - Menggunakan Partial -->
@include('partials.navbar', [
'active_page' => 'cafe-resto' // Kirim parameter untuk halaman aktif
])

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
            </div>
        </div>
    </div>
</section>

<!-- Reservation Modal -->
<div class="modal fade cafe-modal" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationModalLabel">
                    <i class="fas fa-utensils me-2"></i>Form Reservasi Meja
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- FORM -->
                <form id="reservationForm"
                    action="{{ route('cafe-resto.store') }}"
                    method="POST">
                    @csrf

                    <!-- Table Selection -->
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

                    <!-- Date & Time -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label fw-bold">Tanggal Reservasi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input type="date" class="form-control" id="date" name="date" required
                                    min="{{ date('Y-m-d') }}">
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

                    <!-- Guests -->
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
                        <div class="col-md-6">
                            <div class="alert alert-info mb-0 h-100 d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                Harga meja akan ditambahkan ke total pembayaran.
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <h5 class="fw-bold mb-3 border-bottom pb-2">Data Diri</h5>

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
                            <label for="phone" class="form-label fw-bold">Nomor Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="tel" class="form-control" id="phone" name="phone" required
                                    placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="invalid-feedback">Silakan isi nomor telepon yang valid.</div>
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

                    <!-- Special Request -->
                    <div class="mb-4">
                        <label for="special_request" class="form-label fw-bold">Permintaan Khusus (Opsional)</label>
                        <textarea class="form-control" id="special_request" name="special_request"
                            rows="3"
                            placeholder="Contoh: Perayaan ulang tahun, alergi makanan tertentu, kursi bayi, dll."></textarea>
                    </div>

                    <!-- Terms & Info -->
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Informasi Penting:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Pastikan data yang Anda masukkan benar</li>
                            <li>Reservasi akan dikonfirmasi melalui email/telepon</li>
                            <li>Meja hanya ditahan selama 15 menit</li>
                            <li>Untuk pembatalan, harap hubungi kami minimal 2 jam sebelumnya</li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitReservationBtn"
                        class="btn btn-success btn-lg px-5 py-3 w-100">
                        <i class="fas fa-paper-plane me-2"></i>
                        Kirim Reservasi Sekarang
                    </button>
                </form>

                <!-- Loading Indicator -->
                <div id="loading" class="text-center d-none mt-4">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Mengirim reservasi...</p>
                </div>

                <!-- Success Message with Detailed Confirmation -->
                <div id="successMessage" class="d-none mt-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="success-animation mb-4">
                                <div class="checkmark-circle">
                                    <div class="checkmark"></div>
                                </div>
                            </div>
                            
                            <h3 class="fw-bold text-success mb-2">Reservasi Berhasil!</h3>
                            <p class="text-muted mb-4">Terima kasih telah melakukan reservasi di Legareca Cafe & Resto</p>
                            
                            <!-- Reservation Details Card -->
                            <div id="reservationDetails" class="bg-light rounded-4 p-4 mb-4 text-start">
                                <h5 class="fw-bold mb-3 border-bottom pb-2">
                                    <i class="fas fa-receipt me-2"></i>Detail Reservasi
                                </h5>
                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <span class="text-muted">Kode Reservasi</span>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span id="reservationCode" class="fw-bold text-primary"></span>
                                    </div>
                                    
                                    <div class="col-6 mb-2">
                                        <span class="text-muted">Nama Pemesan</span>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span id="detailName" class="fw-bold"></span>
                                    </div>
                                    
                                    <div class="col-6 mb-2">
                                        <span class="text-muted">Tipe Meja</span>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span id="detailTable" class="fw-bold"></span>
                                    </div>
                                    
                                    <div class="col-6 mb-2">
                                        <span class="text-muted">Tanggal & Waktu</span>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span id="detailDateTime" class="fw-bold"></span>
                                    </div>
                                    
                                    <div class="col-6 mb-2">
                                        <span class="text-muted">Jumlah Tamu</span>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span id="detailGuests" class="fw-bold"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-center">
                                <button type="button" 
                                    class="btn btn-primary px-5" 
                                    data-bs-dismiss="modal">
                                    <i class="fas fa-check me-2"></i>
                                    Tutup
                                </button>
                            </div>
                            <p class="text-muted small mt-3 mb-0">
                                <i class="fas fa-clock me-1"></i>
                                Meja akan ditahan selama 15 menit dari waktu reservasi
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Simple Success Message (Alternative for non-JSON response) -->
                <div id="simpleSuccessMessage" class="d-none mt-4">
                    <div class="alert alert-success border-0 shadow-sm">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle fa-3x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="alert-heading mb-2">Reservasi Terkirim!</h4>
                                <p class="mb-2">Terima kasih, data reservasi Anda telah kami terima.</p>
                                <p class="mb-1 fw-bold" id="simpleReservationCode"></p>
                                <hr>
                                <p class="mb-0 small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Konfirmasi akan dikirim melalui email/telepon.
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-sm btn-success" data-bs-dismiss="modal">
                                <i class="fas fa-check me-1"></i> Tutup
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div id="errorMessage" class="alert alert-danger d-none mt-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-2">Terjadi Kesalahan</h5>
                            <p class="mb-0" id="errorText"></p>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-sm btn-danger" onclick="location.reload()">
                            <i class="fas fa-redo me-1"></i> Coba Lagi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS untuk Animasi Success -->
<style>
    .success-animation {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .checkmark-circle {
        width: 80px;
        height: 80px;
        position: relative;
        display: inline-block;
        vertical-align: top;
        background-color: #28a745;
        border-radius: 50%;
        animation: pulse 1.5s ease-in-out infinite;
    }
    
    .checkmark {
        border-radius: 5px;
    }
    
    .checkmark-circle:after {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 20px;
        border-left: 5px solid white;
        border-bottom: 5px solid white;
        transform: translate(-50%, -60%) rotate(-45deg);
        animation: drawCheck 0.5s ease-out;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
        }
        70% {
            transform: scale(1);
            box-shadow: 0 0 0 15px rgba(40, 167, 69, 0);
        }
        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
        }
    }
    
    @keyframes drawCheck {
        0% {
            width: 0;
            height: 0;
            opacity: 0;
        }
        100% {
            width: 40px;
            height: 20px;
            opacity: 1;
        }
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }
    
    #reservationDetails {
        border-left: 4px solid #28a745;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle pre-fill table type from button data attribute
        const reserveButtons = document.querySelectorAll('[data-table-type]');
        reserveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tableType = this.dataset.tableType;
                const tableSelect = document.getElementById('tableType');
                if (tableSelect) {
                    tableSelect.value = tableType;
                }
            });
        });

        // Handle form submission with AJAX
        const form = document.getElementById('reservationForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Hide any previous messages
                document.getElementById('successMessage')?.classList.add('d-none');
                document.getElementById('simpleSuccessMessage')?.classList.add('d-none');
                document.getElementById('errorMessage')?.classList.add('d-none');
                
                // Show loading
                document.getElementById('loading')?.classList.remove('d-none');
                
                // Disable submit button
                const submitBtn = document.getElementById('submitReservationBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
                }
                
                // Get form data
                const formData = new FormData(this);
                
                // Send AJAX request
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Hide loading
                    document.getElementById('loading')?.classList.add('d-none');
                    
                    if (data.success) {
                        // Show success message with details
                        showSuccessMessage(data);
                        
                        // Reset form
                        this.reset();
                    } else {
                        // Show error message
                        showErrorMessage(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Hide loading
                    document.getElementById('loading')?.classList.add('d-none');
                    
                    // Show error message
                    showErrorMessage('Terjadi kesalahan jaringan. Silakan coba lagi.');
                })
                .finally(() => {
                    // Re-enable submit button
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Reservasi Sekarang';
                    }
                });
            });
        }
        
        // Function to show detailed success message
        function showSuccessMessage(data) {
            // Hide form
            const form = document.getElementById('reservationForm');
            if (form) form.style.display = 'none';
            
            // Hide simple success message
            document.getElementById('simpleSuccessMessage')?.classList.add('d-none');
            
            // Show detailed success message
            const successMsg = document.getElementById('successMessage');
            if (successMsg) {
                successMsg.classList.remove('d-none');
                
                // Fill in reservation details
                if (data.data) {
                    document.getElementById('reservationCode').textContent = data.data.reservation_code || '-';
                    document.getElementById('detailName').textContent = data.data.name || '-';
                    document.getElementById('detailTable').textContent = data.data.table_type || '-';
                    
                    const date = data.data.date ? new Date(data.data.date).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }) : '-';
                    const time = data.data.time || '-';
                    document.getElementById('detailDateTime').textContent = `${date}, ${time} WIB`;
                    
                    document.getElementById('detailGuests').textContent = `${data.data.guests || 0} orang`;
                }
            }
        }
        
        // Function to show simple success message (fallback)
        function showSimpleSuccess(message) {
            // Hide form
            const form = document.getElementById('reservationForm');
            if (form) form.style.display = 'none';
            
            // Hide detailed success message
            document.getElementById('successMessage')?.classList.add('d-none');
            
            // Show simple success message
            const simpleMsg = document.getElementById('simpleSuccessMessage');
            if (simpleMsg) {
                simpleMsg.classList.remove('d-none');
                const codeElement = document.getElementById('simpleReservationCode');
                if (codeElement) {
                    codeElement.innerHTML = `<i class="fas fa-ticket-alt me-2"></i>Kode Reservasi: ${message || '#'}`;
                }
            }
        }
        
        // Function to show error message
        function showErrorMessage(message) {
            const errorMsg = document.getElementById('errorMessage');
            if (errorMsg) {
                errorMsg.classList.remove('d-none');
                document.getElementById('errorText').textContent = message || 'Terjadi kesalahan. Silakan coba lagi.';
            }
        }
        
        // Reset modal when closed
        const modal = document.getElementById('reservationModal');
        if (modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                // Show form again
                const form = document.getElementById('reservationForm');
                if (form) {
                    form.style.display = 'block';
                    form.reset();
                }
                
                // Hide all messages
                document.getElementById('successMessage')?.classList.add('d-none');
                document.getElementById('simpleSuccessMessage')?.classList.add('d-none');
                document.getElementById('errorMessage')?.classList.add('d-none');
                document.getElementById('loading')?.classList.add('d-none');
                
                // Re-enable submit button
                const submitBtn = document.getElementById('submitReservationBtn');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Reservasi Sekarang';
                }
            });
        }
    });
</script>

@endsection
