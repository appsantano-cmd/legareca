<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAMBAH TRANSAKSI STOK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .card-header {
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
        }

        .required:after {
            content: " *";
            color: #dc3545;
        }

        .radio-group {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #f8f9fa;
        }

        .radio-group .form-check {
            margin-bottom: 5px;
        }

        .barang-list-container {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #f8f9fa;
            margin-top: 20px;
            min-height: 200px;
        }

        .barang-item-card {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            position: relative;
        }

        .barang-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }

        .remove-barang-btn {
            background: none;
            border: none;
            color: #dc3545;
            padding: 5px 8px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .remove-barang-btn:hover {
            color: #bd2130;
        }

        .no-barang-message {
            text-align: center;
            padding: 30px 20px;
            color: #6c757d;
        }

        .total-barang {
            font-weight: bold;
            color: #4CAF50;
        }

        .product-info-item {
            background-color: white;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            margin-bottom: 10px;
        }

        .product-info-label {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .product-info-value {
            font-size: 1rem;
            font-weight: 500;
        }

        .supplier-field {
            margin-top: 15px;
        }

        .conditional-field {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .search-container {
            position: relative;
            margin-bottom: 15px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .search-input {
            padding-left: 40px;
        }

        .barang-checkbox:checked {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        .barang-checkbox:focus {
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
        }

        .supplier-info {
            background-color: #e8f5e9;
            border-left: 4px solid #4CAF50;
            padding: 10px 15px;
            margin-top: 10px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .supplier-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .supplier-option:hover {
            background-color: #f8f9fa;
        }

        .supplier-option.active {
            background-color: #e8f5e9;
            border: 1px solid #4CAF50;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stok-masuk-badge {
            background-color: #28a745;
        }

        .stok-keluar-badge {
            background-color: #dc3545;
        }

        .supplier-input-group {
            position: relative;
        }

        .field-group {
            margin-top: 15px;
        }

        .field-mode-options {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .field-mode-option {
            padding: 6px 12px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .field-mode-option:hover {
            background-color: #f8f9fa;
        }

        .field-mode-option.active {
            background-color: #e8f5e9;
            border-color: #4CAF50;
            color: #2E7D32;
            font-weight: 500;
        }

        .global-field-container {
            display: block;
        }

        .perbarang-field-container {
            display: none;
        }

        .form-control:disabled {
            background-color: #e9ecef;
            opacity: 0.7;
            cursor: not-allowed;
        }

        .barang-item-field {
            margin-top: 10px;
        }

        .field-options-container {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #f8f9fa;
            margin-top: 10px;
        }

        .field-option-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-bottom: 5px;
        }

        .field-option-item:hover {
            background-color: #f8f9fa;
        }

        .field-option-item.active {
            background-color: #e8f5e9;
            border: 1px solid #4CAF50;
        }

        /* Modal departemen styles */
        .modal-departemen-search-container {
            position: relative;
            margin-bottom: 15px;
        }

        .modal-departemen-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .modal-departemen-search-input {
            padding-left: 40px;
        }

        .departemen-item {
            cursor: pointer;
            transition: all 0.2s;
        }

        .departemen-item:hover {
            background-color: #f8f9fa;
        }

        .departemen-item.selected {
            background-color: #e8f5e9;
            border-left: 4px solid #4CAF50;
        }

        .btn:disabled,
        .btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        .btn-outline-primary:disabled,
        .btn-outline-primary.disabled {
            color: #6c757d;
            border-color: #6c757d;
            background-color: transparent;
        }

        .btn-pilih-departemen-perbarang:disabled,
        .btn-pilih-departemen-perbarang.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
            border-color: #6c757d;
            color: #6c757d;
        }

        /* Style khusus untuk input tanggal yang readonly */
        .date-input-readonly {
            background-color: #f8f9fa !important;
            cursor: default !important;
            border-color: #dee2e6 !important;
            color: #495057 !important;
        }

        .date-input-readonly:hover {
            background-color: #f8f9fa !important;
        }

        .date-input-readonly:focus {
            box-shadow: none !important;
            border-color: #dee2e6 !important;
            background-color: #f8f9fa !important;
        }

        /* Styling untuk informasi departemen */
        .departemen-info-box {
            background-color: #e8f5e9;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        .departemen-info-title {
            font-weight: bold;
            color: #2E7D32;
            margin-bottom: 5px;
        }

        .departemen-info-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-change-departemen {
            margin-left: auto;
        }

        /* Warning ketika departemen belum dipilih */
        .departemen-warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 5px;
            padding: 10px 15px;
            margin-bottom: 15px;
        }

        /* Step indicator */
        .step-indicator {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .step {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
        }

        .step.active .step-number {
            background-color: #4CAF50;
            color: white;
        }

        .step.completed .step-number {
            background-color: #2E7D32;
            color: white;
        }

        .step-label {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .step.active .step-label {
            color: #4CAF50;
            font-weight: 500;
        }

        .step-line {
            flex-grow: 1;
            height: 2px;
            background-color: #e9ecef;
            margin: 0 10px;
        }

        .step.completed .step-line {
            background-color: #2E7D32;
        }

        /* Keperluan global container */
        .keperluan-global-container {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Transaksi Stok
                        </h4>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        <!-- Step Indicator -->
                        <div class="step-indicator">
                            <div class="step active" id="step1">
                                <div class="step-number">1</div>
                                <div class="step-label">Pilih Departemen</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step" id="step2">
                                <div class="step-number">2</div>
                                <div class="step-label">Pilih Tipe Transaksi</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step" id="step3">
                                <div class="step-number">3</div>
                                <div class="step-label">Tambah Barang</div>
                            </div>
                        </div>

                        <!-- Departemen Info Box -->
                        <div id="departemenInfoBox" class="departemen-info-box" style="display: none;">
                            <div class="departemen-info-title">
                                <i class="bi bi-building me-2"></i>Departemen Terpilih
                            </div>
                            <div class="departemen-info-content">
                                <span id="selectedDepartemenName">-</span>
                                <button type="button" class="btn btn-sm btn-outline-primary btn-change-departemen"
                                    id="btnChangeDepartemen">
                                    <i class="bi bi-pencil me-1"></i>Ubah
                                </button>
                            </div>
                        </div>

                        <!-- Warning jika departemen belum dipilih -->
                        <div id="departemenWarning" class="departemen-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Silakan pilih departemen terlebih dahulu untuk melanjutkan
                            <button type="button" class="btn btn-sm btn-warning ms-2" id="btnSelectDepartemen">
                                <i class="bi bi-building me-1"></i>Pilih Departemen
                            </button>
                        </div>

                        <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                            @csrf

                            <!-- Hidden input untuk menyimpan data departemen -->
                            <input type="hidden" name="departemen" id="departemenInput" value="">

                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-clipboard-data me-2"></i>Informasi Transaksi
                                    </h5>

                                    <!-- MODIFIKASI DI SINI: Input tanggal diubah menjadi readonly -->
                                    <div class="mb-3">
                                        <label class="form-label required">Tanggal Transaksi</label>
                                        <input type="date" name="tanggal" class="form-control date-input-readonly"
                                            value="{{ date('Y-m-d') }}" readonly required
                                            title="Tanggal transaksi tidak dapat diubah (otomatis tanggal hari ini)">
                                        <small class="text-muted mt-1 d-block">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Tanggal transaksi ditetapkan otomatis sebagai hari ini
                                        </small>
                                    </div>

                                    <!-- Tipe Transaksi (akan diaktifkan setelah departemen dipilih) -->
                                    <div class="mb-3">
                                        <label class="form-label required">Tipe Transaksi</label>
                                        <div class="radio-group" id="tipeRadioGroup">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tipe"
                                                    id="tipe_masuk" value="masuk" disabled>
                                                <label class="form-check-label text-success" for="tipe_masuk">
                                                    <i class="bi bi-box-arrow-in-down me-1"></i>Stok Masuk
                                                </label>
                                            </div>
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="radio" name="tipe"
                                                    id="tipe_keluar" value="keluar" disabled>
                                                <label class="form-check-label text-danger" for="tipe_keluar">
                                                    <i class="bi bi-box-arrow-up me-1"></i>Stok Keluar
                                                </label>
                                            </div>
                                        </div>
                                        <div class="text-danger small mt-1 d-none" id="tipeError">
                                            Silakan pilih tipe transaksi
                                        </div>
                                        <div id="tipeDisabledMessage" class="text-muted small mt-1">
                                            Pilih departemen terlebih dahulu untuk mengaktifkan opsi ini
                                        </div>
                                    </div>

                                    <!-- Supplier untuk Stok Masuk (DIHAPUS karena supplier diambil dari data barang) -->
                                    <div id="masukFields" class="conditional-field">
                                        <div class="mb-3">
                                            <div class="alert alert-info">
                                                <i class="bi bi-info-circle me-2"></i>
                                                <strong>Informasi Supplier:</strong> Supplier akan otomatis diambil dari
                                                data barang yang dipilih
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Field khusus Stok Keluar -->
                                    <div id="keluarFields" class="conditional-field">
                                        <!-- Keperluan dengan radio button -->
                                        <div class="mb-3">
                                            <label class="form-label required">Keperluan</label>
                                            <div class="field-options-container">
                                                <div class="field-option-item" id="keperluanOptionGlobal">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="keperluan_mode" id="keperluan_mode_global"
                                                            value="global" disabled>
                                                        <label class="form-check-label" for="keperluan_mode_global">
                                                            <strong>Keperluan Global</strong> - Sama untuk semua barang
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="field-option-item" id="keperluanOptionPerBarang">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="keperluan_mode" id="keperluan_mode_perbarang"
                                                            value="perbarang" disabled>
                                                        <label class="form-check-label"
                                                            for="keperluan_mode_perbarang">
                                                            <strong>Keperluan Per Barang</strong> - Berbeda untuk setiap
                                                            barang
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Input Keperluan Global -->
                                            <div id="keperluanGlobalContainer" class="global-field-container keperluan-global-container" style="display: none;">
                                                <input type="text" name="keperluan_global" id="keperluan_global"
                                                    class="form-control" disabled
                                                    placeholder="Masukkan keperluan global">
                                                <div class="supplier-info mt-2">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    <small class="text-muted">
                                                        Keperluan global akan digunakan untuk semua barang dalam transaksi ini.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nama Penerima Barang dengan radio button -->
                                    <div class="mb-3">
                                        <label class="form-label required">Nama Penerima Barang</label>
                                        <div class="field-options-container">
                                            <div class="field-option-item" id="namaPenerimaOptionGlobal">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="nama_penerima_mode" id="nama_penerima_mode_global"
                                                        value="global" disabled>
                                                    <label class="form-check-label" for="nama_penerima_mode_global">
                                                        <strong>Nama Penerima Global</strong> - Sama untuk semua barang
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="field-option-item" id="namaPenerimaOptionPerBarang">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="nama_penerima_mode" id="nama_penerima_mode_perbarang"
                                                        value="perbarang" disabled>
                                                    <label class="form-check-label"
                                                        for="nama_penerima_mode_perbarang">
                                                        <strong>Nama Penerima Per Barang</strong> - Berbeda untuk setiap
                                                        barang
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Input Nama Penerima Global -->
                                        <div id="namaPenerimaGlobalContainer" class="global-field-container mt-2" style="display: none;">
                                            <input type="text" name="nama_penerima_global"
                                                id="nama_penerima_global" class="form-control"
                                                value="{{ old('nama_penerima_global') }}" disabled
                                                placeholder="Masukkan nama penerima barang global">
                                            <div class="supplier-info mt-2">
                                                <i class="bi bi-info-circle me-1"></i>
                                                <small class="text-muted">
                                                    Nama penerima global akan digunakan untuk semua barang dalam
                                                    transaksi ini.
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Keterangan dengan radio button -->
                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <div class="field-options-container">
                                            <div class="field-option-item" id="keteranganOptionGlobal">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="keterangan_mode" id="keterangan_mode_global"
                                                        value="global" disabled>
                                                    <label class="form-check-label" for="keterangan_mode_global">
                                                        <strong>Keterangan Global</strong> - Sama untuk semua barang
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="field-option-item" id="keteranganOptionPerBarang">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="keterangan_mode" id="keterangan_mode_perbarang"
                                                        value="perbarang" disabled>
                                                    <label class="form-check-label" for="keterangan_mode_perbarang">
                                                        <strong>Keterangan Per Barang</strong> - Berbeda untuk setiap
                                                        barang
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Input Keterangan Global -->
                                        <div id="keteranganGlobalContainer" class="global-field-container mt-2" style="display: none;">
                                            <textarea name="keterangan_global" id="keterangan_global" rows="4" 
                                                class="form-control" disabled 
                                                placeholder="Tambahkan keterangan transaksi global (opsional)">{{ old('keterangan_global') }}</textarea>
                                            <div class="supplier-info mt-2">
                                                <i class="bi bi-info-circle me-1"></i>
                                                <small class="text-muted">
                                                    Keterangan global akan digunakan untuk semua barang dalam transaksi ini.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-box me-2"></i>Daftar Barang
                                    </h5>

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0">Barang yang Dipilih</h6>
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#barangModal"
                                                id="btnTambahBarang" disabled>
                                                <i class="bi bi-plus-circle me-1"></i>Tambah Barang
                                            </button>
                                        </div>

                                        <div class="barang-list-container" id="barangListContainer">
                                            <div class="no-barang-message" id="noBarangMessage">
                                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                                <p class="mb-0">Belum ada barang dipilih</p>
                                                <small class="text-muted">Pilih departemen dan tipe transaksi terlebih
                                                    dahulu</small>
                                            </div>
                                        </div>

                                        <div class="mt-3 text-end">
                                            <small>Total Barang: <span class="total-barang"
                                                    id="totalBarang">0</span></small>
                                        </div>
                                    </div>

                                    <div id="stockWarning" class="alert alert-warning mt-2 d-none">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        <span id="stockWarningMessage"></span>
                                    </div>

                                    <!-- Bagian Informasi -->
                                    <div class="alert alert-info">
                                        <h6><i class="bi bi-info-circle me-2"></i>Informasi</h6>
                                        <ul class="mb-0 small">
                                            <li><strong>Langkah 1:</strong> Pilih departemen terlebih dahulu</li>
                                            <li><strong>Langkah 2:</strong> Pilih tipe transaksi (Stok Masuk/Keluar)
                                            </li>
                                            <li><strong>Langkah 3:</strong> Tambahkan barang ke daftar</li>
                                            <li><strong>Supplier:</strong> Otomatis diambil dari data barang</li>
                                            <li><strong>Departemen:</strong> Sudah ditentukan di awal</li>
                                            <li><strong>Keperluan:</strong> Hanya untuk stok keluar</li>
                                            <li><strong>Tanggal:</strong> Otomatis hari ini</li>
                                            <li>Stok akan langsung diperbarui setelah transaksi disimpan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div id="barangDataContainer"></div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                                <div>
                                    <button type="submit" name="action" value="save" class="btn btn-primary"
                                        id="btnSimpan" disabled>
                                        <i class="bi bi-save me-2"></i>Simpan Transaksi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Box Penting -->
                <div class="alert alert-info mt-3">
                    <h6><i class="bi bi-info-circle me-2"></i>Informasi Penting</h6>
                    <ul class="mb-0">
                        <li><strong>Urutan Proses:</strong> Departemen → Tipe Transaksi → Barang</li>
                        <li><strong>Tanggal Transaksi:</strong> Otomatis menggunakan tanggal hari ini</li>
                        <li><strong>Supplier:</strong> Otomatis diambil dari data master barang</li>
                        <li><strong>Departemen:</strong> Ditentukan di awal dan berlaku untuk semua barang</li>
                        <li>Transaksi akan langsung mempengaruhi stok barang</li>
                        <li>Pastikan jumlah stok keluar tidak melebihi stok tersedia</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Departemen (TAMPIL PERTAMA) -->
    <div class="modal fade" id="departemenModal" tabindex="-1" aria-labelledby="departemenModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="departemenModalLabel">
                        <i class="bi bi-building me-2"></i>Pilih Departemen
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-departemen-search-container">
                        <i class="bi bi-search modal-departemen-search-icon"></i>
                        <input type="text" id="searchDepartemen"
                            class="form-control modal-departemen-search-input" placeholder="Cari departemen...">
                    </div>

                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover table-sm">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Departemen</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="departemenTableBody">
                                <!-- Data akan diisi via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 text-muted">
                        <small>
                            <i class="bi bi-info-circle me-1"></i>
                            Menampilkan <span id="departemenCount">0</span> departemen
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Barang -->
    <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="barangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="barangModalLabel">
                        <i class="bi bi-box-seam me-2"></i>Tambah Barang ke Transaksi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <i class="bi bi-info-circle me-2"></i>
                        Menampilkan barang untuk departemen: <strong id="modalDepartemenInfo">-</strong>
                    </div>

                    <div class="search-container">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" id="searchBarang" class="form-control search-input"
                            placeholder="Cari barang berdasarkan kode, nama, atau satuan...">
                    </div>

                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover table-sm">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th width="30"></th>
                                    <th width="120">Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th width="100">Satuan</th>
                                    <th width="120" class="text-end">Stok Tersedia</th>
                                    <th width="150">Supplier</th>
                                </tr>
                            </thead>
                            <tbody id="barangTableBody">
                                <!-- Data akan diisi via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 text-muted">
                        <small>
                            <i class="bi bi-info-circle me-1"></i>
                            Menampilkan <span id="itemCount">0</span> barang
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="addBarangBtn">
                        <i class="bi bi-plus-circle me-1"></i>Tambah ke Daftar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <template id="barangItemTemplate">
        <div class="barang-item-card" data-kode="KODE_BARANG">
            <div class="barang-header">
                <div>
                    <h6 class="mb-0 fw-bold">NAMA_BARANG</h6>
                    <small class="text-muted">Kode: KODE_BARANG</small>
                    <div class="mt-1">
                        <small class="text-primary">
                            <i class="bi bi-truck me-1"></i>Supplier: <span class="supplier-display">SUPPLIER_NAME</span>
                        </small>
                    </div>
                </div>
                <button type="button" class="remove-barang-btn" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="product-info-item">
                        <div class="product-info-label">Satuan</div>
                        <div class="product-info-value">SATUAN</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-info-item">
                        <div class="product-info-label">Stok Tersedia</div>
                        <div class="product-info-value">
                            <span class="badge bg-STOK_COLOR">STOK_TOTAL SATUAN</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-info-item">
                        <div class="product-info-label">Departemen</div>
                        <div class="product-info-value">DEPARTEMEN_NAME</div>
                    </div>
                </div>
            </div>

            <!-- Field per Barang (ditampilkan jika mode Per Barang dipilih) -->
            <div class="field-group">
                <!-- Keperluan per Barang (hanya untuk Stok Keluar - Mode Per Barang) -->
                <div class="barang-item-field keperluan-field conditional-keperluan-field" style="display: none;">
                    <label class="form-label">
                        <span>Keperluan</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control keperluan-per-barang"
                        placeholder="Keperluan untuk barang ini">
                </div>

                <!-- Nama Penerima per Barang -->
                <div class="barang-item-field nama-penerima-field conditional-nama-penerima-field"
                    style="display: none;">
                    <label class="form-label">
                        <span>Nama Penerima</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control nama-penerima-per-barang"
                        placeholder="Nama penerima untuk barang ini">
                </div>

                <!-- Keterangan per Barang -->
                <div class="barang-item-field keterangan-field conditional-keterangan-field" style="display: none;">
                    <label class="form-label">
                        <span>Keterangan</span>
                        <span class="text-muted">(Opsional)</span>
                    </label>
                    <textarea class="form-control keterangan-per-barang" rows="2"
                        placeholder="Keterangan untuk barang ini (opsional)"></textarea>
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label required">Jumlah</label>
                <input type="number" class="form-control jumlah-input" step="0.01" min="0.01" required
                    placeholder="Masukkan jumlah" data-max="STOK_NUMBER">
                <div class="invalid-feedback jumlah-error" style="display: none;">
                    Jumlah harus lebih dari 0
                </div>
            </div>
        </div>
    </template>

    <template id="departemenRowTemplate">
        <tr class="departemen-item">
            <td class="text-center">INDEX</td>
            <td class="departemen-nama">NAMA_DEPARTEMEN</td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-primary btn-pilih-departemen">
                    <i class="bi bi-check-circle me-1"></i>Pilih
                </button>
            </td>
        </tr>
    </template>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Inisialisasi variabel global
        let selectedDepartemen = null;
        let selectedTipe = null;
        let selectedBarangList = [];
        let currentKeperluanMode = 'global';
        let currentNamaPenerimaMode = 'global';
        let currentKeteranganMode = 'global';

        // Data dari backend
        let departemenList = @json($departemenList ?? []);

        // Elemen DOM
        const departemenWarning = document.getElementById('departemenWarning');
        const departemenInfoBox = document.getElementById('departemenInfoBox');
        const selectedDepartemenName = document.getElementById('selectedDepartemenName');
        const departemenInput = document.getElementById('departemenInput');
        const btnSelectDepartemen = document.getElementById('btnSelectDepartemen');
        const btnChangeDepartemen = document.getElementById('btnChangeDepartemen');
        const tipeRadios = document.querySelectorAll('input[name="tipe"]');
        const tipeDisabledMessage = document.getElementById('tipeDisabledMessage');
        const btnTambahBarang = document.getElementById('btnTambahBarang');
        const btnSimpan = document.getElementById('btnSimpan');
        const modalDepartemenInfo = document.getElementById('modalDepartemenInfo');
        const barangTableBody = document.getElementById('barangTableBody');
        const itemCountSpan = document.getElementById('itemCount');
        const searchBarangInput = document.getElementById('searchBarang');
        const addBarangBtn = document.getElementById('addBarangBtn');
        const barangListContainer = document.getElementById('barangListContainer');
        const noBarangMessage = document.getElementById('noBarangMessage');
        const totalBarangSpan = document.getElementById('totalBarang');
        const stockWarning = document.getElementById('stockWarning');
        const stockWarningMessage = document.getElementById('stockWarningMessage');
        const barangDataContainer = document.getElementById('barangDataContainer');

        // Step indicators
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');

        // Load departemen list saat modal dibuka
        document.getElementById('departemenModal').addEventListener('show.bs.modal', function() {
            loadDepartemenList();
        });

        // Load barang list saat modal barang dibuka
        document.getElementById('barangModal').addEventListener('show.bs.modal', function() {
            if (selectedDepartemen) {
                loadBarangListByDepartemen(selectedDepartemen);
                modalDepartemenInfo.textContent = selectedDepartemen;
            }
        });

        function loadDepartemenList() {
            const departemenTableBody = document.getElementById('departemenTableBody');
            const searchDepartemenInput = document.getElementById('searchDepartemen');
            const departemenCountSpan = document.getElementById('departemenCount');

            departemenTableBody.innerHTML = '';
            let count = 0;

            departemenList.forEach((departemen, index) => {
                const row = document.createElement('tr');
                row.className = 'departemen-item';
                row.innerHTML = `
            <td class="text-center">${index + 1}</td>
            <td class="departemen-nama">${departemen}</td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-primary btn-pilih-departemen" data-departemen="${departemen}">
                    <i class="bi bi-check-circle me-1"></i>Pilih
                </button>
            </td>
        `;

                departemenTableBody.appendChild(row);
                count++;
            });

            departemenCountSpan.textContent = count;

            // Event listener untuk tombol pilih departemen
            document.querySelectorAll('.btn-pilih-departemen').forEach(btn => {
                btn.addEventListener('click', function() {
                    const departemen = this.getAttribute('data-departemen');
                    selectDepartemen(departemen);
                });
            });

            // Event listener untuk pencarian departemen
            searchDepartemenInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = departemenTableBody.getElementsByClassName('departemen-item');
                let visibleCount = 0;

                Array.from(rows).forEach(row => {
                    const departemenNama = row.querySelector('.departemen-nama').textContent.toLowerCase();
                    const isVisible = departemenNama.includes(searchTerm);

                    row.style.display = isVisible ? '' : 'none';
                    if (isVisible) visibleCount++;
                });

                departemenCountSpan.textContent = visibleCount;
            });
        }

        function selectDepartemen(departemen) {
            selectedDepartemen = departemen;
            selectedDepartemenName.textContent = departemen;
            departemenInput.value = departemen;

            // Update UI
            departemenWarning.style.display = 'none';
            departemenInfoBox.style.display = 'block';

            // Aktifkan step 2
            step1.classList.add('completed');
            step2.classList.add('active');

            // Aktifkan tipe transaksi
            document.querySelectorAll('input[name="tipe"]').forEach(radio => {
                radio.disabled = false;
            });
            tipeDisabledMessage.style.display = 'none';

            // Nonaktifkan tombol simpan sampai tipe transaksi dipilih
            btnSimpan.disabled = true;

            // Tutup modal
            const departemenModalEl = document.getElementById('departemenModal');
            const departemenModal = bootstrap.Modal.getInstance(departemenModalEl);
            if (departemenModal) {
                departemenModal.hide();
            }

            // Reset tipe transaksi
            resetTipeTransaksi();
        }

        function resetTipeTransaksi() {
            // Reset pilihan tipe transaksi
            document.querySelectorAll('input[name="tipe"]').forEach(radio => {
                radio.checked = false;
            });
            selectedTipe = null;

            // Reset semua field conditional
            const masukFields = document.getElementById('masukFields');
            const keluarFields = document.getElementById('keluarFields');
            if (masukFields) masukFields.style.display = 'none';
            if (keluarFields) keluarFields.style.display = 'none';

            // Nonaktifkan semua radio button mode
            document.querySelectorAll('input[name="keperluan_mode"]').forEach(radio => {
                radio.disabled = true;
                radio.checked = false;
            });
            document.querySelectorAll('input[name="nama_penerima_mode"]').forEach(radio => {
                radio.disabled = true;
                radio.checked = false;
            });
            document.querySelectorAll('input[name="keterangan_mode"]').forEach(radio => {
                radio.disabled = true;
                radio.checked = false;
            });

            // Sembunyikan semua container input global
            const keperluanGlobalContainer = document.getElementById('keperluanGlobalContainer');
            const namaPenerimaGlobalContainer = document.getElementById('namaPenerimaGlobalContainer');
            const keteranganGlobalContainer = document.getElementById('keteranganGlobalContainer');
            
            if (keperluanGlobalContainer) keperluanGlobalContainer.style.display = 'none';
            if (namaPenerimaGlobalContainer) namaPenerimaGlobalContainer.style.display = 'none';
            if (keteranganGlobalContainer) keteranganGlobalContainer.style.display = 'none';

            // Nonaktifkan tombol tambah barang
            if (btnTambahBarang) btnTambahBarang.disabled = true;

            // Reset barang list
            selectedBarangList = [];
            updateBarangListDisplay();
        }

        function updateTipeTransaksi() {
            if (!selectedTipe) {
                const masukFields = document.getElementById('masukFields');
                const keluarFields = document.getElementById('keluarFields');
                if (masukFields) masukFields.style.display = 'none';
                if (keluarFields) keluarFields.style.display = 'none';
                if (btnTambahBarang) btnTambahBarang.disabled = true;
                if (btnSimpan) btnSimpan.disabled = true;
                if (step3) step3.classList.remove('active');
                return;
            }

            // Aktifkan step 3
            if (step2) step2.classList.add('completed');
            if (step3) step3.classList.add('active');

            // Tampilkan field sesuai tipe
            if (selectedTipe === 'masuk') {
                const masukFields = document.getElementById('masukFields');
                const keluarFields = document.getElementById('keluarFields');
                if (masukFields) masukFields.style.display = 'block';
                if (keluarFields) keluarFields.style.display = 'none';

            } else if (selectedTipe === 'keluar') {
                const masukFields = document.getElementById('masukFields');
                const keluarFields = document.getElementById('keluarFields');
                if (masukFields) masukFields.style.display = 'none';
                if (keluarFields) keluarFields.style.display = 'block';
            }

            // Aktifkan semua radio button mode
            document.querySelectorAll('input[name="keperluan_mode"]').forEach(radio => {
                radio.disabled = false;
            });
            document.querySelectorAll('input[name="nama_penerima_mode"]').forEach(radio => {
                radio.disabled = false;
            });
            document.querySelectorAll('input[name="keterangan_mode"]').forEach(radio => {
                radio.disabled = false;
            });

            // Set default ke global untuk semua mode
            document.getElementById('keperluan_mode_global').checked = true;
            document.getElementById('nama_penerima_mode_global').checked = true;
            document.getElementById('keterangan_mode_global').checked = true;

            // Update mode variables
            currentKeperluanMode = 'global';
            currentNamaPenerimaMode = 'global';
            currentKeteranganMode = 'global';

            // Tampilkan input global
            updateGlobalInputsVisibility();

            // Aktifkan tombol tambah barang
            if (btnTambahBarang) btnTambahBarang.disabled = false;

            // Aktifkan tombol simpan (meski belum ada barang)
            if (btnSimpan) btnSimpan.disabled = false;

            // Update field modes
            updateAllModes();
        }

        function updateGlobalInputsVisibility() {
            const keperluanGlobalContainer = document.getElementById('keperluanGlobalContainer');
            const namaPenerimaGlobalContainer = document.getElementById('namaPenerimaGlobalContainer');
            const keteranganGlobalContainer = document.getElementById('keteranganGlobalContainer');
            
            if (selectedTipe === 'keluar' && currentKeperluanMode === 'global') {
                if (keperluanGlobalContainer) {
                    keperluanGlobalContainer.style.display = 'block';
                    document.getElementById('keperluan_global').disabled = false;
                }
            } else {
                if (keperluanGlobalContainer) {
                    keperluanGlobalContainer.style.display = 'none';
                    document.getElementById('keperluan_global').disabled = true;
                }
            }
            
            if (currentNamaPenerimaMode === 'global') {
                if (namaPenerimaGlobalContainer) {
                    namaPenerimaGlobalContainer.style.display = 'block';
                    document.getElementById('nama_penerima_global').disabled = false;
                }
            } else {
                if (namaPenerimaGlobalContainer) {
                    namaPenerimaGlobalContainer.style.display = 'none';
                    document.getElementById('nama_penerima_global').disabled = true;
                }
            }
            
            if (currentKeteranganMode === 'global') {
                if (keteranganGlobalContainer) {
                    keteranganGlobalContainer.style.display = 'block';
                    document.getElementById('keterangan_global').disabled = false;
                }
            } else {
                if (keteranganGlobalContainer) {
                    keteranganGlobalContainer.style.display = 'none';
                    document.getElementById('keterangan_global').disabled = true;
                }
            }
        }

        function loadBarangListByDepartemen(departemen) {
            if (!barangTableBody) return;

            // Tampilkan loading
            barangTableBody.innerHTML = '<tr><td colspan="6" class="text-center">Memuat data...</td></tr>';

            // AJAX request untuk mendapatkan barang berdasarkan departemen
            fetch(`{{ route('transactions.getBarangByDepartemen') }}?departemen=${encodeURIComponent(departemen)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!barangTableBody) return;

                    barangTableBody.innerHTML = '';

                    if (!data || data.length === 0) {
                        barangTableBody.innerHTML =
                            '<tr><td colspan="6" class="text-center">Tidak ada barang untuk departemen ini</td></tr>';
                        if (itemCountSpan) itemCountSpan.textContent = '0';
                        return;
                    }

                    data.forEach((barang, index) => {
                        const row = document.createElement('tr');
                        row.className = 'barang-item';
                        row.setAttribute('data-kode', barang.kode_barang);
                        row.setAttribute('data-nama', barang.nama_barang);
                        row.setAttribute('data-satuan', barang.satuan);
                        row.setAttribute('data-stok', barang.stok_akhir);
                        row.setAttribute('data-supplier', barang.supplier || 'Tidak ada supplier');

                        const stokColor = barang.stok_akhir > 0 ? 'success' : 'danger';

                        row.innerHTML = `
                    <td class="text-center">
                        <div class="form-check">
                            <input class="form-check-input barang-checkbox" type="checkbox"
                                id="barang_${barang.kode_barang}" value="${barang.kode_barang}">
                        </div>
                    </td>
                    <td>
                        <label class="form-check-label" for="barang_${barang.kode_barang}">
                            <strong>${barang.kode_barang}</strong>
                        </label>
                    </td>
                    <td>${barang.nama_barang}</td>
                    <td>${barang.satuan}</td>
                    <td class="text-end">
                        <span class="badge bg-${stokColor}">
                            ${parseFloat(barang.stok_akhir).toFixed(2)}
                        </span>
                    </td>
                    <td>${barang.supplier || 'Tidak ada supplier'}</td>
                `;

                        barangTableBody.appendChild(row);
                    });

                    if (itemCountSpan) itemCountSpan.textContent = data.length;

                    // Setup search functionality
                    if (searchBarangInput) {
                        searchBarangInput.addEventListener('input', searchBarang);
                        searchBarang();
                    }
                })
                .catch(error => {
                    console.error('Error loading barang:', error);
                    if (barangTableBody) {
                        barangTableBody.innerHTML =
                            '<tr><td colspan="6" class="text-center text-danger">Gagal memuat data</td></tr>';
                    }
                    if (itemCountSpan) itemCountSpan.textContent = '0';
                });
        }

        function searchBarang() {
            if (!searchBarangInput || !barangTableBody || !itemCountSpan) return;

            const searchTerm = searchBarangInput.value.toLowerCase();
            const rows = barangTableBody.getElementsByClassName('barang-item');
            let visibleCount = 0;

            Array.from(rows).forEach(row => {
                const kode = row.getAttribute('data-kode')?.toLowerCase() || '';
                const nama = row.getAttribute('data-nama')?.toLowerCase() || '';
                const satuan = row.getAttribute('data-satuan')?.toLowerCase() || '';
                const supplier = row.getAttribute('data-supplier')?.toLowerCase() || '';

                const isVisible = kode.includes(searchTerm) ||
                    nama.includes(searchTerm) ||
                    satuan.includes(searchTerm) ||
                    supplier.includes(searchTerm);

                row.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });

            itemCountSpan.textContent = visibleCount;
        }

        function addBarangToList() {
            if (!barangTableBody) return;

            const selectedCheckboxes = document.querySelectorAll('.barang-checkbox:checked');

            if (selectedCheckboxes.length === 0) {
                alert('Silakan pilih barang terlebih dahulu!');
                return;
            }

            selectedCheckboxes.forEach(checkbox => {
                const row = checkbox.closest('.barang-item');
                if (!row) return;

                const kode = row.getAttribute('data-kode');
                const nama = row.getAttribute('data-nama');
                const satuan = row.getAttribute('data-satuan');
                const stok = parseFloat(row.getAttribute('data-stok')) || 0;
                const supplier = row.getAttribute('data-supplier') || 'Tidak ada supplier';

                const existingIndex = selectedBarangList.findIndex(item => item.kode === kode);
                if (existingIndex === -1) {
                    selectedBarangList.push({
                        kode: kode,
                        nama: nama,
                        satuan: satuan,
                        stok: stok,
                        supplier: supplier,
                        departemen: selectedDepartemen,
                        jumlah: '',
                        keperluan: '',
                        nama_penerima: '',
                        keterangan: ''
                    });
                }

                checkbox.checked = false;
            });

            updateBarangListDisplay();

            const barangModalEl = document.getElementById('barangModal');
            const barangModal = bootstrap.Modal.getInstance(barangModalEl);
            if (barangModal) {
                barangModal.hide();
            }

            if (searchBarangInput) {
                searchBarangInput.value = '';
                searchBarang();
            }
        }

        function updateBarangListDisplay() {
            if (!barangListContainer) return;

            barangListContainer.innerHTML = '';

            if (selectedBarangList.length === 0) {
                if (noBarangMessage) {
                    const noBarangClone = noBarangMessage.cloneNode(true);
                    barangListContainer.appendChild(noBarangClone);
                    noBarangClone.classList.remove('d-none');
                }
            } else {
                if (noBarangMessage) noBarangMessage.classList.add('d-none');

                const barangItemTemplate = document.getElementById('barangItemTemplate');
                if (!barangItemTemplate) return;

                selectedBarangList.forEach((barang, index) => {
                    const template = barangItemTemplate.content.cloneNode(true);
                    const itemCard = template.querySelector('.barang-item-card');

                    if (!itemCard) return;

                    // Update konten dengan replace string
                    let itemHTML = itemCard.outerHTML;
                    itemHTML = itemHTML
                        .replace(/KODE_BARANG/g, barang.kode)
                        .replace(/NAMA_BARANG/g, barang.nama)
                        .replace(/SATUAN/g, barang.satuan)
                        .replace(/SUPPLIER_NAME/g, barang.supplier || 'Tidak ada supplier')
                        .replace(/DEPARTEMEN_NAME/g, barang.departemen)
                        .replace(/STOK_COLOR/g, barang.stok > 0 ? 'success' : 'danger')
                        .replace(/STOK_TOTAL/g, barang.stok.toFixed(2))
                        .replace(/STOK_NUMBER/g, barang.stok);

                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = itemHTML;
                    const newItemCard = tempDiv.firstElementChild;

                    // Set atribut data
                    newItemCard.setAttribute('data-kode', barang.kode);
                    newItemCard.setAttribute('data-index', index);

                    // Field per barang
                    const keperluanField = newItemCard.querySelector('.keperluan-per-barang');
                    if (keperluanField) {
                        keperluanField.setAttribute('data-index', index);
                        keperluanField.value = barang.keperluan || '';
                        keperluanField.addEventListener('input', function() {
                            barang.keperluan = this.value;
                        });

                        const keperluanContainer = newItemCard.querySelector('.conditional-keperluan-field');
                        if (keperluanContainer) {
                            if (selectedTipe === 'keluar' && currentKeperluanMode === 'perbarang') {
                                keperluanContainer.style.display = 'block';
                                keperluanField.disabled = false;
                                keperluanField.required = true;
                            } else {
                                keperluanContainer.style.display = 'none';
                                keperluanField.disabled = true;
                                keperluanField.removeAttribute('required');
                            }
                        }
                    }

                    // Nama Penerima per barang
                    const namaPenerimaField = newItemCard.querySelector('.nama-penerima-per-barang');
                    if (namaPenerimaField) {
                        namaPenerimaField.setAttribute('data-index', index);
                        namaPenerimaField.value = barang.nama_penerima || '';
                        namaPenerimaField.addEventListener('input', function() {
                            barang.nama_penerima = this.value;
                        });

                        const namaPenerimaContainer = newItemCard.querySelector('.conditional-nama-penerima-field');
                        if (namaPenerimaContainer) {
                            if (currentNamaPenerimaMode === 'perbarang') {
                                namaPenerimaContainer.style.display = 'block';
                                namaPenerimaField.disabled = false;
                                namaPenerimaField.required = true;
                            } else {
                                namaPenerimaContainer.style.display = 'none';
                                namaPenerimaField.disabled = true;
                                namaPenerimaField.removeAttribute('required');
                            }
                        }
                    }

                    // Keterangan per barang
                    const keteranganField = newItemCard.querySelector('.keterangan-per-barang');
                    if (keteranganField) {
                        keteranganField.setAttribute('data-index', index);
                        keteranganField.value = barang.keterangan || '';
                        keteranganField.addEventListener('input', function() {
                            barang.keterangan = this.value;
                        });

                        const keteranganContainer = newItemCard.querySelector('.conditional-keterangan-field');
                        if (keteranganContainer) {
                            if (currentKeteranganMode === 'perbarang') {
                                keteranganContainer.style.display = 'block';
                                keteranganField.disabled = false;
                            } else {
                                keteranganContainer.style.display = 'none';
                                keteranganField.disabled = true;
                            }
                        }
                    }

                    // Input jumlah
                    const jumlahInput = newItemCard.querySelector('.jumlah-input');
                    if (jumlahInput) {
                        jumlahInput.setAttribute('data-max', barang.stok);
                        jumlahInput.setAttribute('data-index', index);
                        jumlahInput.value = barang.jumlah || '';

                        const jumlahError = newItemCard.querySelector('.jumlah-error');

                        jumlahInput.addEventListener('input', function() {
                            validateBarangJumlah(this);
                            validateBarangStock(this);
                            barang.jumlah = this.value;
                        });

                        // Tambahkan event listener untuk validasi saat halaman load
                        validateBarangJumlah(jumlahInput);
                        validateBarangStock(jumlahInput);
                    }

                    // Tombol hapus
                    const removeBtn = newItemCard.querySelector('.remove-barang-btn');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', function() {
                            removeBarangFromList(index);
                        });
                    }

                    barangListContainer.appendChild(newItemCard);
                });
            }

            if (totalBarangSpan) totalBarangSpan.textContent = selectedBarangList.length;
            validateAllStock();
        }

        function validateBarangJumlah(inputElement) {
            if (!inputElement) return false;

            const jumlah = parseFloat(inputElement.value) || 0;
            const errorElement = inputElement.closest('.barang-item-card')?.querySelector('.jumlah-error');

            if (jumlah <= 0) {
                inputElement.classList.add('is-invalid');
                if (errorElement) errorElement.style.display = 'block';
                return false;
            } else {
                inputElement.classList.remove('is-invalid');
                if (errorElement) errorElement.style.display = 'none';
                return true;
            }
        }

        function removeBarangFromList(index) {
            if (confirm('Apakah Anda yakin ingin menghapus barang ini dari daftar?')) {
                selectedBarangList.splice(index, 1);
                updateBarangListDisplay();
            }
        }

        function validateBarangStock(inputElement) {
            if (!inputElement) return true;

            const index = inputElement.getAttribute('data-index');
            const jumlah = parseFloat(inputElement.value) || 0;
            const maxStok = parseFloat(inputElement.getAttribute('data-max')) || 0;
            const barang = selectedBarangList[index];

            if (!barang) return true;

            if (selectedTipe === 'keluar' && jumlah > maxStok) {
                inputElement.classList.add('is-invalid');
                return false;
            } else {
                inputElement.classList.remove('is-invalid');
                return true;
            }
        }

        function validateAllStock() {
            if (!stockWarning || !stockWarningMessage) return true;

            if (selectedTipe !== 'keluar') {
                stockWarning.classList.add('d-none');
                return true;
            }

            let hasError = false;
            let errorMessages = [];

            selectedBarangList.forEach((barang, index) => {
                const jumlah = parseFloat(barang.jumlah) || 0;
                if (jumlah > barang.stok) {
                    hasError = true;
                    errorMessages.push(`${barang.nama}: ${jumlah} > ${barang.stok.toFixed(2)} ${barang.satuan}`);
                }
            });

            if (hasError) {
                stockWarning.classList.remove('d-none');
                stockWarningMessage.innerHTML = `
            <strong>Stok tidak mencukupi untuk beberapa barang!</strong><br>
            ${errorMessages.join('<br>')}
        `;
                return false;
            } else {
                stockWarning.classList.add('d-none');
                return true;
            }
        }

        function updateAllModes() {
            // Update mode dari radio buttons
            const keperluanModeRadios = document.querySelectorAll('input[name="keperluan_mode"]:checked');
            if (keperluanModeRadios.length > 0) {
                currentKeperluanMode = keperluanModeRadios[0].value;
            }

            const namaPenerimaModeRadios = document.querySelectorAll('input[name="nama_penerima_mode"]:checked');
            if (namaPenerimaModeRadios.length > 0) {
                currentNamaPenerimaMode = namaPenerimaModeRadios[0].value;
            }

            const keteranganModeRadios = document.querySelectorAll('input[name="keterangan_mode"]:checked');
            if (keteranganModeRadios.length > 0) {
                currentKeteranganMode = keteranganModeRadios[0].value;
            }

            // Update active class untuk semua options
            updateOptionActiveClass('keperluan', currentKeperluanMode);
            updateOptionActiveClass('nama_penerima', currentNamaPenerimaMode);
            updateOptionActiveClass('keterangan', currentKeteranganMode);

            // Update global inputs visibility
            updateGlobalInputsVisibility();

            // Update field visibility di barang list
            updateBarangListDisplay();
        }

        function updateOptionActiveClass(field, mode) {
            const globalOption = document.getElementById(`${field}OptionGlobal`);
            const perbarangOption = document.getElementById(`${field}OptionPerBarang`);

            if (globalOption) globalOption.classList.remove('active');
            if (perbarangOption) perbarangOption.classList.remove('active');

            if (mode === 'global' && globalOption) {
                globalOption.classList.add('active');
            } else if (mode === 'perbarang' && perbarangOption) {
                perbarangOption.classList.add('active');
            }
        }

        function validateForm() {
            // Validasi departemen
            if (!selectedDepartemen) {
                alert('Silakan pilih departemen terlebih dahulu!');
                if (btnSelectDepartemen) btnSelectDepartemen.focus();
                return false;
            }

            // Validasi tipe transaksi
            if (!selectedTipe) {
                alert('Silakan pilih tipe transaksi!');
                return false;
            }

            // Validasi barang
            if (selectedBarangList.length === 0) {
                alert('Silakan tambahkan minimal satu barang ke daftar!');
                return false;
            }

            // Validasi jumlah untuk setiap barang
            for (let i = 0; i < selectedBarangList.length; i++) {
                const barang = selectedBarangList[i];
                const jumlah = parseFloat(barang.jumlah) || 0;
                if (jumlah <= 0) {
                    alert(`Jumlah untuk barang "${barang.nama}" harus lebih dari 0!`);
                    const jumlahInput = document.querySelector(`.barang-item-card[data-index="${i}"] .jumlah-input`);
                    if (jumlahInput) jumlahInput.focus();
                    return false;
                }
            }

            // Validasi untuk stok keluar
            if (selectedTipe === 'keluar') {
                // Validasi keperluan
                if (currentKeperluanMode === 'global') {
                    const keperluanGlobal = document.getElementById('keperluan_global');
                    if (keperluanGlobal && !keperluanGlobal.value.trim()) {
                        alert('Keperluan wajib diisi untuk stok keluar!');
                        keperluanGlobal.focus();
                        return false;
                    }
                } else if (currentKeperluanMode === 'perbarang') {
                    for (let i = 0; i < selectedBarangList.length; i++) {
                        const barang = selectedBarangList[i];
                        if (!barang.keperluan || !barang.keperluan.trim()) {
                            alert(`Keperluan wajib diisi untuk barang "${barang.nama}"!`);
                            const keperluanInput = document.querySelector(
                                `.barang-item-card[data-index="${i}"] .keperluan-per-barang`);
                            if (keperluanInput) keperluanInput.focus();
                            return false;
                        }
                    }
                }

                // Validasi stok
                if (!validateAllStock()) {
                    alert('Ada masalah dengan jumlah stok keluar! Periksa kembali jumlah barang.');
                    return false;
                }
            }

            // Validasi Nama Penerima
            if (currentNamaPenerimaMode === 'global') {
                const namaPenerimaGlobal = document.getElementById('nama_penerima_global');
                if (namaPenerimaGlobal && !namaPenerimaGlobal.value.trim()) {
                    alert('Nama penerima wajib diisi!');
                    namaPenerimaGlobal.focus();
                    return false;
                }
            } else if (currentNamaPenerimaMode === 'perbarang') {
                for (let i = 0; i < selectedBarangList.length; i++) {
                    const barang = selectedBarangList[i];
                    if (!barang.nama_penerima || !barang.nama_penerima.trim()) {
                        alert(`Nama penerima wajib diisi untuk barang "${barang.nama}"!`);
                        const namaPenerimaInput = document.querySelector(
                            `.barang-item-card[data-index="${i}"] .nama-penerima-per-barang`);
                        if (namaPenerimaInput) namaPenerimaInput.focus();
                        return false;
                    }
                }
            }

            return true;
        }

        function prepareFormData() {
            if (!barangDataContainer) return;

            // Clear existing hidden inputs
            barangDataContainer.innerHTML = '';

            // Add mode data
            addHiddenInput('departemen', selectedDepartemen);
            addHiddenInput('keperluan_mode', currentKeperluanMode);
            addHiddenInput('nama_penerima_mode', currentNamaPenerimaMode);
            addHiddenInput('keterangan_mode', currentKeteranganMode);

            // Add global data jika mode global
            if (selectedTipe === 'keluar' && currentKeperluanMode === 'global') {
                const keperluanGlobal = document.getElementById('keperluan_global');
                if (keperluanGlobal && keperluanGlobal.value.trim()) {
                    addHiddenInput('keperluan_global', keperluanGlobal.value);
                }
            }

            if (currentNamaPenerimaMode === 'global') {
                const namaPenerimaGlobal = document.getElementById('nama_penerima_global');
                if (namaPenerimaGlobal && namaPenerimaGlobal.value.trim()) {
                    addHiddenInput('nama_penerima_global', namaPenerimaGlobal.value);
                }
            }

            if (currentKeteranganMode === 'global') {
                const keteranganGlobal = document.getElementById('keterangan_global');
                if (keteranganGlobal) {
                    addHiddenInput('keterangan_global', keteranganGlobal.value);
                }
            }

            // Add tanggal and tipe
            const tanggalInput = document.querySelector('input[name="tanggal"]');
            if (tanggalInput) {
                addHiddenInput('tanggal', tanggalInput.value);
            }
            addHiddenInput('tipe', selectedTipe);

            // Add barang data
            selectedBarangList.forEach((barang, index) => {
                addHiddenInput(`barang[${index}][kode_barang]`, barang.kode);
                addHiddenInput(`barang[${index}][jumlah]`, barang.jumlah);
                addHiddenInput(`barang[${index}][supplier]`, barang.supplier || '');
                addHiddenInput(`barang[${index}][departemen]`, barang.departemen);

                // Add per-barang fields jika mode perbarang
                if (selectedTipe === 'keluar' && currentKeperluanMode === 'perbarang') {
                    addHiddenInput(`barang[${index}][keperluan]`, barang.keperluan || '');
                }

                if (currentNamaPenerimaMode === 'perbarang') {
                    addHiddenInput(`barang[${index}][nama_penerima]`, barang.nama_penerima || '');
                }

                if (currentKeteranganMode === 'perbarang') {
                    addHiddenInput(`barang[${index}][keterangan]`, barang.keterangan || '');
                }
            });
        }

        function addHiddenInput(name, value) {
            if (!barangDataContainer) return;

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value || '';
            barangDataContainer.appendChild(input);
        }

        // Event Listeners
        if (btnSelectDepartemen) {
            btnSelectDepartemen.addEventListener('click', function() {
                const departemenModal = new bootstrap.Modal(document.getElementById('departemenModal'));
                departemenModal.show();
            });
        }

        if (btnChangeDepartemen) {
            btnChangeDepartemen.addEventListener('click', function() {
                const departemenModal = new bootstrap.Modal(document.getElementById('departemenModal'));
                departemenModal.show();
            });
        }

        // Event listener untuk tipe transaksi
        tipeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                selectedTipe = this.value;
                updateTipeTransaksi();
            });
        });

        // Event listener untuk mode radio buttons
        document.querySelectorAll('input[name="keperluan_mode"]').forEach(radio => {
            radio.addEventListener('change', updateAllModes);
        });

        document.querySelectorAll('input[name="nama_penerima_mode"]').forEach(radio => {
            radio.addEventListener('change', updateAllModes);
        });

        document.querySelectorAll('input[name="keterangan_mode"]').forEach(radio => {
            radio.addEventListener('change', updateAllModes);
        });

        // Event listener untuk tombol tambah barang
        if (addBarangBtn) {
            addBarangBtn.addEventListener('click', addBarangToList);
        }

        // Event listener untuk form submission
        const transactionForm = document.getElementById('transactionForm');
        if (transactionForm) {
            transactionForm.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }

                prepareFormData();
                return true;
            });
        }

        // Setup click handlers untuk semua option items
        function setupOptionClickHandler(optionElement) {
            if (!optionElement) return;

            optionElement.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                if (radio && !radio.disabled) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change'));
                }
            });
        }

        // Setup click handlers untuk semua option containers
        [
            'keperluanOptionGlobal', 'keperluanOptionPerBarang',
            'namaPenerimaOptionGlobal', 'namaPenerimaOptionPerBarang',
            'keteranganOptionGlobal', 'keteranganOptionPerBarang'
        ].forEach(id => {
            const element = document.getElementById(id);
            if (element) setupOptionClickHandler(element);
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Nonaktifkan semua input sampai departemen dipilih
            resetTipeTransaksi();

            // Jika ada departemen yang sudah dipilih (misal dari session), set otomatis
            const savedDepartemen = "{{ old('departemen') }}";
            if (savedDepartemen && departemenList.includes(savedDepartemen)) {
                selectDepartemen(savedDepartemen);
            }
        });
    </script>
</body>

</html>