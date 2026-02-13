@extends('layouts.layout_main')

@section('title', 'Legareca Cafe & Resto - Reservasi')

@section('content')

<!-- NAVBAR - Menggunakan Partial -->
@include('partials.navbar', [
'active_page' => 'cafe-resto'
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
            @foreach([
                ['type' => 'Indoor Regular', 'price' => 0, 'img' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0', 'desc' => 'Meja standar dengan suasana cozy di dalam ruangan ber-AC.', 'badge' => 'bg-success', 'badge_text' => 'Tersedia', 'max_guests' => 4],
                ['type' => 'Indoor Premium', 'price' => 50000, 'img' => 'https://images.unsplash.com/photo-1514933651103-005eec06c04b', 'desc' => 'Meja lebih luas dengan privasi tinggi dan view ke dapur terbuka.', 'badge' => 'bg-success', 'badge_text' => 'Tersedia', 'max_guests' => 6],
                ['type' => 'Outdoor Garden', 'price' => 30000, 'img' => 'https://images.unsplash.com/photo-1590846406792-0adc7f938f1d', 'desc' => 'Meja di taman dengan suasana alam dan udara segar.', 'badge' => 'bg-warning', 'badge_text' => 'Terbatas', 'max_guests' => 8],
                ['type' => 'Private Room', 'price' => 150000, 'img' => 'https://images.unsplash.com/photo-1559925393-8be0ec4767c8', 'desc' => 'Ruang privat untuk meeting, keluarga besar, atau acara khusus.', 'badge' => 'bg-info', 'badge_text' => 'Minimal 10 orang', 'max_guests' => 20]
            ] as $table)
            <div class="col-lg-3 col-md-6">
                <div class="table-card">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $table['img'] }}?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80"
                            alt="{{ $table['type'] }}" class="table-image">
                        <span class="table-badge {{ $table['badge'] }} text-white">{{ $table['badge_text'] }}</span>
                    </div>
                    <div class="p-4">
                        <h3 class="h5 mb-3 fw-bold">{{ $table['type'] }}</h3>
                        <div class="table-price">Rp {{ number_format($table['price'], 0, ',', '.') }}</div>
                        <p class="text-muted small mb-3">{{ $table['desc'] }}</p>

                        <ul class="table-features mb-4">
                            <li><i class="fas fa-check"></i> Maksimal {{ $table['max_guests'] }} orang</li>
                            @if($table['type'] == 'Indoor Regular')
                            <li><i class="fas fa-check"></i> Area ber-AC</li>
                            <li><i class="fas fa-check"></i> Dekat dengan live music</li>
                            <li><i class="fas fa-check"></i> Free WiFi</li>
                            @elseif($table['type'] == 'Indoor Premium')
                            <li><i class="fas fa-check"></i> View ke dapur terbuka</li>
                            <li><i class="fas fa-check"></i> Privacy screen</li>
                            <li><i class="fas fa-check"></i> Dedicated waiter</li>
                            @elseif($table['type'] == 'Outdoor Garden')
                            <li><i class="fas fa-check"></i> View taman</li>
                            <li><i class="fas fa-check"></i> Smoking area terpisah</li>
                            <li><i class="fas fa-check"></i> Evening live acoustic</li>
                            @else
                            <li><i class="fas fa-check"></i> Private sound system</li>
                            <li><i class="fas fa-check"></i> Projector screen</li>
                            <li><i class="fas fa-check"></i> Dedicated chef service</li>
                            @endif
                        </ul>

                        <button type="button"
                            class="reserve-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#reservationModal"
                            data-table-type="{{ $table['type'] }}"
                            data-table-price="{{ $table['price'] }}"
                            data-max-guests="{{ $table['max_guests'] }}">
                            <i class="fas fa-chair me-2"></i>Pilih Meja Ini
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
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
            ['img' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187', 'name' => 'Legareca Signature Steak', 'desc' => 'Daging sapi premium dengan saus spesial', 'price' => '125.000'],
            ['img' => 'https://images.unsplash.com/photo-1563379091339-03246963d9d6', 'name' => 'Seafood Platter', 'desc' => 'Berbagai seafood segar dengan bumbu rempah', 'price' => '185.000'],
            ['img' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1', 'name' => 'Grilled Chicken', 'desc' => 'Ayam panggang dengan sayuran organik', 'price' => '85.000'],
            ['img' => 'https://images.unsplash.com/photo-1572802419224-296b0aeee0d9', 'name' => 'Vegetarian Delight', 'desc' => 'Salad organik dengan dressing spesial', 'price' => '65.000']
            ] as $item)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="menu-card">
                    <img src="{{ $item['img'] }}?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="{{ $item['name'] }}" class="menu-image">
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
                <form id="reservationForm">
                    @csrf

                    <!-- Hidden inputs -->
                    <input type="hidden" id="selectedTableType" name="table_type">
                    <input type="hidden" id="selectedTablePrice" name="table_price">
                    <input type="hidden" id="selectedMaxGuests" name="max_guests">

                    <!-- Table Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tipe Meja</label>
                        <div class="form-control form-control-lg" id="tableTypeDisplay"
                            style="background: #f8f9fa; font-weight: 600; min-height: 48px; display: flex; align-items: center;">
                            <span class="text-muted">Pilih meja terlebih dahulu</span>
                        </div>
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
                                    <option value="{{ $i }}">{{ $i }} orang</option>
                                @endfor
                            </select>
                            <div class="invalid-feedback">Silakan pilih jumlah tamu.</div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-info mb-0 h-100 d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                Harga meja: <span id="displayPrice">Rp 0</span>
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
                                Format: +62 diisi otomatis, masukkan nomor setelah +62
                            </small>
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

                    <!-- Alert Info -->
                    <div class="alert alert-info border-info">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x text-info me-3"></i>
                            <div>
                                <h6 class="alert-heading mb-2">Informasi Penting</h6>
                                <p class="mb-0">Setelah mengirim reservasi, Anda akan diarahkan ke WhatsApp untuk konfirmasi. Pastikan nomor WhatsApp yang Anda masukkan aktif.</p>
                            </div>
                        </div>
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
                    <p class="mt-3 text-muted">Memproses reservasi...</p>
                </div>

                <!-- Success Message -->
                <div id="successMessage" class="d-none mt-4">
                    <div class="alert alert-success border-0 shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle fa-3x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="alert-heading mb-2">Reservasi Berhasil!</h4>
                                <p class="mb-2" id="successMessageText"></p>
                                <hr>
                                <p class="mb-0 small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Anda akan diarahkan ke WhatsApp dalam 3 detik...
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-sm btn-success" onclick="window.location.reload()">
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

<!-- Custom CSS -->
<style>
    /* Hero Section */
    .cafe-hero {
        background: linear-gradient(135deg, #FF6B6B 0%, #C92A2A 100%);
        padding: 120px 0;
        margin-top: 76px;
        position: relative;
        overflow: hidden;
    }

    .cafe-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2"/></svg>') repeat;
        opacity: 0.1;
    }

    .cafe-hero-content {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
        color: white;
    }

    .cafe-hero h1 {
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    /* Table Cards */
    .table-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #f0f0f0;
        margin-bottom: 25px;
    }

    .table-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(255, 107, 107, 0.15);
        border-color: #FF6B6B;
    }

    .table-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .table-card:hover .table-image {
        transform: scale(1.1);
    }

    .table-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        z-index: 2;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .table-price {
        font-size: 20px;
        font-weight: 700;
        color: #C92A2A;
        margin-bottom: 10px;
    }

    .table-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .table-features li {
        padding: 5px 0;
        font-size: 13px;
        color: #666;
        display: flex;
        align-items: center;
    }

    .table-features li i {
        color: #FF6B6B;
        margin-right: 8px;
        font-size: 12px;
    }

    .reserve-btn {
        background: linear-gradient(135deg, #FF6B6B, #C92A2A);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .reserve-btn:hover {
        background: linear-gradient(135deg, #C92A2A, #FF6B6B);
        transform: scale(0.98);
        color: white;
    }

    /* Menu Cards */
    .menu-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .menu-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .menu-price {
        font-weight: 700;
        color: #C92A2A;
        font-size: 16px;
    }

    /* Info Box */
    .info-box {
        background: white;
        padding: 35px;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        height: 100%;
    }

    .info-box-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #FF6B6B, #C92A2A);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .info-box-icon i {
        font-size: 24px;
        color: white;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #FF6B6B, #C92A2A);
        border-radius: 2px;
    }

    /* Modal */
    .cafe-modal .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }

    .cafe-modal .modal-header {
        background: linear-gradient(135deg, #FF6B6B, #C92A2A);
        color: white;
        border: none;
        padding: 20px 25px;
    }

    .cafe-modal .modal-title {
        font-weight: 700;
    }

    .cafe-modal .btn-close {
        background: white;
        opacity: 1;
        border-radius: 50%;
        padding: 8px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cafe-hero {
            padding: 80px 0;
        }
        
        .cafe-hero h1 {
            font-size: 2rem;
        }
        
        .table-card {
            margin-bottom: 20px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============= KONFIGURASI =============
        const ADMIN_PHONE = '6281328897679'; // Nomor WhatsApp admin
        const ADMIN_MESSAGE = 'Halo Admin Legareca Cafe & Resto, ada reservasi baru:';

        // ============= ELEMEN FORM =============
        const reservationForm = document.getElementById('reservationForm');
        const submitBtn = document.getElementById('submitReservationBtn');

        // Display elements
        const tableTypeDisplay = document.getElementById('tableTypeDisplay');
        const displayPrice = document.getElementById('displayPrice');

        // Hidden inputs
        const selectedTableType = document.getElementById('selectedTableType');
        const selectedTablePrice = document.getElementById('selectedTablePrice');
        const selectedMaxGuests = document.getElementById('selectedMaxGuests');

        // Form inputs
        const dateInput = document.getElementById('date');
        const timeInput = document.getElementById('time');
        const guestsSelect = document.getElementById('guests');
        const nameInput = document.getElementById('name');
        const phoneInput = document.getElementById('phone');
        const emailInput = document.getElementById('email');
        const specialRequest = document.getElementById('special_request');

        // ============= FUNGSI FORMAT =============
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function formatWhatsAppNumber(phoneNumber) {
            let cleaned = phoneNumber.replace(/\D/g, '');
            if (cleaned.startsWith('0')) {
                cleaned = '62' + cleaned.substring(1);
            } else if (!cleaned.startsWith('62')) {
                cleaned = '62' + cleaned;
            }
            return cleaned;
        }

        function formatDateToDisplay(dateString) {
            if (!dateString) return '-';
            let date = new Date(dateString + 'T00:00:00');
            let day = date.getDate().toString().padStart(2, '0');
            let month = (date.getMonth() + 1).toString().padStart(2, '0');
            let year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        // ============= FUNGSI UPDATE DISPLAY =============
        function updateTableDisplay(tableType, tablePrice, maxGuests) {
            if (tableTypeDisplay) {
                tableTypeDisplay.innerHTML = tableType ?
                    `<span style="color: #C92A2A; font-weight: 700;">${tableType}</span>` :
                    '<span class="text-muted">Pilih meja terlebih dahulu</span>';
            }

            if (displayPrice) {
                displayPrice.innerHTML = tablePrice ? 
                    `<strong style="color: #C92A2A;">${formatRupiah(parseInt(tablePrice))}</strong>` : 
                    '<strong style="color: #C92A2A;">Rp 0</strong>';
            }

            if (selectedTableType) selectedTableType.value = tableType || '';
            if (selectedTablePrice) selectedTablePrice.value = tablePrice || '';
            if (selectedMaxGuests) selectedMaxGuests.value = maxGuests || '';
        }

        // ============= FUNGSI SELECT TABLE =============
        function selectTable(tableType, tablePrice, maxGuests) {
            updateTableDisplay(tableType, tablePrice, maxGuests);
            
            // Update guests select max
            if (guestsSelect && maxGuests) {
                // Clear current options
                guestsSelect.innerHTML = '<option value="">-- Pilih Jumlah Tamu --</option>';
                
                // Add options based on max guests
                for (let i = 1; i <= maxGuests; i++) {
                    let option = document.createElement('option');
                    option.value = i;
                    option.textContent = i + ' orang';
                    guestsSelect.appendChild(option);
                }
            }
        }

        // ============= FUNGSI GENERATE PESAN WHATSAPP =============
        function generateWhatsAppMessage(formData) {
            let message = ADMIN_MESSAGE + '\n\n';
            message += '━━━━━━━━━━━━━━━━━━━━━\n';
            message += '*📋 DETAIL RESERVASI*\n';
            message += '━━━━━━━━━━━━━━━━━━━━━\n\n';
            
            message += '*🪑 Tipe Meja:*\n';
            message += `  ${formData.table_type || '-'}\n\n`;
            
            message += '*📅 Tanggal & Waktu:*\n';
            message += `  ${formatDateToDisplay(formData.date)} | ${formData.time || '-'} WIB\n\n`;
            
            message += '*👥 Jumlah Tamu:*\n';
            message += `  ${formData.guests || '-'} orang\n\n`;
            
            message += '*💰 Harga Meja:*\n';
            message += `  ${formatRupiah(parseInt(formData.table_price || 0))}\n\n`;
            
            message += '━━━━━━━━━━━━━━━━━━━━━\n';
            message += '*👤 DATA PEMESAN*\n';
            message += '━━━━━━━━━━━━━━━━━━━━━\n\n';
            
            message += '*📛 Nama:*\n';
            message += `  ${formData.name || '-'}\n\n`;
            
            message += '*📱 WhatsApp:*\n';
            message += `  +62${formData.phone || '-'}\n\n`;
            
            message += '*📧 Email:*\n';
            message += `  ${formData.email || '-'}\n\n`;
            
            if (formData.special_request) {
                message += '━━━━━━━━━━━━━━━━━━━━━\n';
                message += '*📝 PERMINTAAN KHUSUS*\n';
                message += '━━━━━━━━━━━━━━━━━━━━━\n\n';
                message += `  ${formData.special_request}\n\n`;
            }
            
            message += '━━━━━━━━━━━━━━━━━━━━━\n';
            message += 'Terima kasih telah melakukan reservasi di Legareca Cafe & Resto!\n';
            message += '━━━━━━━━━━━━━━━━━━━━━';
            
            return encodeURIComponent(message);
        }

        // ============= FUNGSI SUBMIT FORM =============
        function submitReservation(formData) {
            // Show loading
            document.getElementById('loading').classList.remove('d-none');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

            // Send to server via AJAX
            fetch('{{ route("cafe-resto.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading
                document.getElementById('loading').classList.add('d-none');
                
                if (data.success) {
                    // Hide form
                    document.getElementById('reservationForm').style.display = 'none';
                    
                    // Show success message
                    const successMsg = document.getElementById('successMessage');
                    const successText = document.getElementById('successMessageText');
                    successText.textContent = `Reservasi dengan kode ${data.reservation_code} berhasil dikirim.`;
                    successMsg.classList.remove('d-none');
                    
                    // Generate WhatsApp message
                    const waMessage = generateWhatsAppMessage(formData);
                    
                    // Redirect to WhatsApp after 3 seconds
                    setTimeout(() => {
                        window.open(`https://wa.me/${ADMIN_PHONE}?text=${waMessage}`, '_blank');
                    }, 3000);
                    
                    // Reset form
                    reservationForm.reset();
                    updateTableDisplay('', '', '');
                    
                } else {
                    // Show error
                    document.getElementById('errorMessage').classList.remove('d-none');
                    document.getElementById('errorText').textContent = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Hide loading
                document.getElementById('loading').classList.add('d-none');
                
                // Show error
                document.getElementById('errorMessage').classList.remove('d-none');
                document.getElementById('errorText').textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
            })
            .finally(() => {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Reservasi Sekarang';
            });
        }

        // ============= EVENT LISTENERS =============

        // 1. Event untuk tombol pilih meja
        document.querySelectorAll('[data-table-type]').forEach(button => {
            button.addEventListener('click', function() {
                const tableType = this.dataset.tableType;
                const tablePrice = this.dataset.tablePrice;
                const maxGuests = this.dataset.maxGuests;
                selectTable(tableType, tablePrice, maxGuests);
            });
        });

        // 2. Event untuk nomor WhatsApp
        if (phoneInput) {
            phoneInput.addEventListener('keydown', function(e) {
                if (this.value.length === 0 && e.key === '0') {
                    e.preventDefault();
                    this.value = '';
                }
                if (!/^[0-9]$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete' && 
                    e.key !== 'Tab' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
                    e.preventDefault();
                }
            });

            phoneInput.addEventListener('input', function(e) {
                let value = this.value.replace(/\D/g, '');
                if (value.length > 15) value = value.slice(0, 15);
                this.value = value;
            });

            phoneInput.addEventListener('blur', function(e) {
                let value = this.value.trim();
                if (value && value.length < 9) {
                    alert('Nomor WhatsApp minimal 9 digit setelah kode negara 62');
                    this.focus();
                }
            });
        }

        // 3. Validasi jumlah tamu
        if (guestsSelect) {
            guestsSelect.addEventListener('change', function() {
                const maxGuests = parseInt(selectedMaxGuests?.value || 0);
                const guestCount = parseInt(this.value);
                
                if (maxGuests > 0 && guestCount > maxGuests) {
                    alert(`Jumlah tamu melebihi kapasitas maksimal meja (maksimal ${maxGuests} orang)`);
                    this.value = '';
                }
            });
        }

        // 4. Set minimum date untuk tanggal
        if (dateInput) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
        }

        // 5. Event submit form
        if (reservationForm) {
            reservationForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validasi meja
                if (!selectedTableType?.value) {
                    alert('Silakan pilih tipe meja terlebih dahulu!');
                    return;
                }

                // Validasi tanggal
                if (!dateInput?.value) {
                    alert('Silakan pilih tanggal reservasi!');
                    dateInput.focus();
                    return;
                }

                // Validasi waktu
                if (!timeInput?.value) {
                    alert('Silakan pilih waktu reservasi!');
                    timeInput.focus();
                    return;
                }

                // Validasi jumlah tamu
                if (!guestsSelect?.value) {
                    alert('Silakan pilih jumlah tamu!');
                    guestsSelect.focus();
                    return;
                }

                // Validasi nama
                if (!nameInput?.value.trim()) {
                    alert('Silakan isi nama lengkap!');
                    nameInput.focus();
                    return;
                }

                // Validasi nomor WhatsApp
                if (!phoneInput?.value.trim()) {
                    alert('Silakan isi nomor WhatsApp!');
                    phoneInput.focus();
                    return;
                }

                let phoneValue = phoneInput.value.trim().replace(/\D/g, '');
                if (phoneValue.length < 9) {
                    alert('Nomor WhatsApp minimal 9 digit setelah kode negara 62!');
                    phoneInput.focus();
                    return;
                }

                // Validasi email
                if (!emailInput?.value.trim()) {
                    alert('Silakan isi alamat email!');
                    emailInput.focus();
                    return;
                }

                const emailValue = emailInput.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailValue)) {
                    alert('Format email tidak valid!');
                    emailInput.focus();
                    return;
                }

                // Format nomor WhatsApp
                let formattedPhone = formatWhatsAppNumber(phoneValue);

                // Siapkan data form
                const formData = {
                    table_type: selectedTableType.value,
                    table_price: selectedTablePrice.value,
                    date: dateInput.value,
                    time: timeInput.value,
                    guests: guestsSelect.value,
                    name: nameInput.value.trim(),
                    phone: formattedPhone,
                    email: emailInput.value.trim(),
                    special_request: specialRequest?.value.trim() || ''
                };

                // Submit ke server dan WhatsApp
                submitReservation(formData);
            });
        }

        // 6. Reset modal saat ditutup
        const modal = document.getElementById('reservationModal');
        if (modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                // Reset form
                reservationForm.reset();
                reservationForm.style.display = 'block';
                
                // Reset display
                updateTableDisplay('', '', '');
                
                // Hide messages
                document.getElementById('successMessage').classList.add('d-none');
                document.getElementById('errorMessage').classList.add('d-none');
                document.getElementById('loading').classList.add('d-none');
                
                // Reset submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Reservasi Sekarang';
            });
        }
    });
</script>

@endsection