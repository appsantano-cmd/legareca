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

        .supplier-suggestion-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 0 0 5px 5px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .supplier-suggestion-item {
            padding: 8px 12px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .supplier-suggestion-item:hover {
            background-color: #f8f9fa;
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

        .departemen-select-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            color: #4CAF50;
            font-weight: 500;
        }

        .departemen-select-btn:hover {
            text-decoration: underline;
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
                        <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                            @csrf

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
                                    
                                    <div class="mb-3">
                                        <label class="form-label required">Tipe Transaksi</label>
                                        <div class="radio-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tipe"
                                                    id="tipe_masuk" value="masuk">
                                                <label class="form-check-label text-success" for="tipe_masuk">
                                                    <i class="bi bi-box-arrow-in-down me-1"></i>Stok Masuk
                                                </label>
                                            </div>
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="radio" name="tipe"
                                                    id="tipe_keluar" value="keluar">
                                                <label class="form-check-label text-danger" for="tipe_keluar">
                                                    <i class="bi bi-box-arrow-up me-1"></i>Stok Keluar
                                                </label>
                                            </div>
                                        </div>
                                        <div class="text-danger small mt-1 d-none" id="tipeError">
                                            Silakan pilih tipe transaksi
                                        </div>
                                    </div>

                                    <!-- Supplier untuk Stok Masuk -->
                                    <div id="masukFields" class="conditional-field">
                                        <div class="mb-3">
                                            <label class="form-label">Supplier</label>
                                            <div class="field-options-container">
                                                <div class="field-option-item" id="supplierOptionGlobal">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="supplier_mode" id="supplier_mode_global"
                                                            value="global" checked>
                                                        <label class="form-check-label" for="supplier_mode_global">
                                                            <strong>Supplier Global</strong> - Sama untuk semua barang
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="field-option-item" id="supplierOptionPerBarang">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="supplier_mode" id="supplier_mode_perbarang"
                                                            value="perbarang">
                                                        <label class="form-check-label" for="supplier_mode_perbarang">
                                                            <strong>Supplier Per Barang</strong> - Berbeda untuk setiap
                                                            barang
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Input Supplier Global -->
                                            <div id="supplierGlobalContainer" class="global-field-container mt-2">
                                                <label for="supplier_global" class="form-label">
                                                    <span id="supplierGlobalLabel">Supplier Global</span>
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="supplier-input-group">
                                                    <input type="text" name="supplier_global" id="supplier_global"
                                                        class="form-control" placeholder="Masukkan nama supplier"
                                                        required>
                                                    <div id="supplierGlobalSuggestions"
                                                        class="supplier-suggestion-list"></div>
                                                </div>
                                                <div class="supplier-info mt-2">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    <small class="text-muted">
                                                        <span id="supplierModeDescription">
                                                            Supplier global akan digunakan untuk semua barang dalam
                                                            transaksi ini.
                                                        </span>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Field khusus Stok Keluar -->
                                    <div id="keluarFields" class="conditional-field">
                                        <!-- Departemen dengan radio button -->
                                        <div class="mb-3">
                                            <label class="form-label required">Departemen</label>
                                            <div class="field-options-container">
                                                <div class="field-option-item" id="departemenOptionGlobal">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="departemen_mode" id="departemen_mode_global"
                                                            value="global" checked>
                                                        <label class="form-check-label" for="departemen_mode_global">
                                                            <strong>Departemen Global</strong> - Sama untuk semua barang
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="field-option-item" id="departemenOptionPerBarang">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="departemen_mode" id="departemen_mode_perbarang"
                                                            value="perbarang">
                                                        <label class="form-check-label"
                                                            for="departemen_mode_perbarang">
                                                            <strong>Departemen Per Barang</strong> - Berbeda untuk
                                                            setiap barang
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Input Departemen Global -->
                                            <div id="departemenGlobalContainer" class="global-field-container mt-2">
                                                <div class="d-flex gap-2">
                                                    <input type="text" name="departemen_global"
                                                        id="departemen_global" class="form-control"
                                                        placeholder="Pilih departemen" readonly required>
                                                    <button type="button" class="btn btn-outline-primary"
                                                        id="btnPilihDepartemenGlobal"
                                                        data-target="#departemen_global">
                                                        <i class="bi bi-search"></i> Pilih
                                                    </button>
                                                </div>
                                                <div class="supplier-info mt-2">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    <small class="text-muted">
                                                        Departemen global akan digunakan untuk semua barang dalam
                                                        transaksi ini.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Keperluan dengan radio button -->
                                        <div class="mb-3">
                                            <label class="form-label required">Keperluan</label>
                                            <div class="field-options-container">
                                                <div class="field-option-item" id="keperluanOptionGlobal">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="keperluan_mode" id="keperluan_mode_global"
                                                            value="global" checked>
                                                        <label class="form-check-label" for="keperluan_mode_global">
                                                            <strong>Keperluan Global</strong> - Sama untuk semua barang
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="field-option-item" id="keperluanOptionPerBarang">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="keperluan_mode" id="keperluan_mode_perbarang"
                                                            value="perbarang">
                                                        <label class="form-check-label"
                                                            for="keperluan_mode_perbarang">
                                                            <strong>Keperluan Per Barang</strong> - Berbeda untuk setiap
                                                            barang
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Input Keperluan Global -->
                                            <div id="keperluanGlobalContainer" class="global-field-container mt-2">
                                                <input type="text" name="keperluan_global" id="keperluan_global"
                                                    class="form-control" required
                                                    placeholder="Masukkan keperluan global">
                                                <div class="supplier-info mt-2">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    <small class="text-muted">
                                                        Keperluan global akan digunakan untuk semua barang dalam
                                                        transaksi ini.
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
                                                        value="global" checked>
                                                    <label class="form-check-label" for="nama_penerima_mode_global">
                                                        <strong>Nama Penerima Global</strong> - Sama untuk semua barang
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="field-option-item" id="namaPenerimaOptionPerBarang">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="nama_penerima_mode" id="nama_penerima_mode_perbarang"
                                                        value="perbarang">
                                                    <label class="form-check-label"
                                                        for="nama_penerima_mode_perbarang">
                                                        <strong>Nama Penerima Per Barang</strong> - Berbeda untuk setiap
                                                        barang
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Input Nama Penerima Global -->
                                        <div id="namaPenerimaGlobalContainer" class="global-field-container mt-2">
                                            <input type="text" name="nama_penerima_global"
                                                id="nama_penerima_global" class="form-control"
                                                value="{{ old('nama_penerima_global') }}" required
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
                                                        value="global" checked>
                                                    <label class="form-check-label" for="keterangan_mode_global">
                                                        <strong>Keterangan Global</strong> - Sama untuk semua barang
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="field-option-item" id="keteranganOptionPerBarang">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="keterangan_mode" id="keterangan_mode_perbarang"
                                                        value="perbarang">
                                                    <label class="form-check-label" for="keterangan_mode_perbarang">
                                                        <strong>Keterangan Per Barang</strong> - Berbeda untuk setiap
                                                        barang
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Input Keterangan Global -->
                                        <div id="keteranganGlobalContainer" class="global-field-container mt-2">
                                            <textarea name="keterangan_global" id="keterangan_global" rows="4" class="form-control"
                                                placeholder="Tambahkan keterangan transaksi global (opsional)">{{ old('keterangan_global') }}</textarea>
                                            <div class="supplier-info mt-2">
                                                <i class="bi bi-info-circle me-1"></i>
                                                <small class="text-muted">
                                                    Keterangan global akan digunakan untuk semua barang dalam transaksi
                                                    ini.
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
                                                data-bs-toggle="modal" data-bs-target="#barangModal">
                                                <i class="bi bi-plus-circle me-1"></i>Tambah Barang
                                            </button>
                                        </div>

                                        <div class="barang-list-container" id="barangListContainer">
                                            <div class="no-barang-message" id="noBarangMessage">
                                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                                <p class="mb-0">Belum ada barang dipilih</p>
                                                <small class="text-muted">Klik tombol "Tambah Barang" untuk
                                                    memulai</small>
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
                                            <li><strong>Tanggal:</strong> Otomatis ditetapkan sebagai hari ini dan tidak dapat diubah</li>
                                            <li><strong>Pilih Tipe:</strong> Pilih Stok Masuk atau Stok Keluar terlebih
                                                dahulu</li>
                                            <li><strong>Supplier Options:</strong>
                                                <ul class="mt-1">
                                                    <li><strong>Global:</strong> Satu supplier untuk semua barang (WAJIB
                                                        diisi untuk Stok Masuk)</li>
                                                    <li><strong>Per Barang:</strong> Input supplier berbeda untuk setiap
                                                        barang (WAJIB diisi untuk Stok Masuk)</li>
                                                </ul>
                                            </li>
                                            <li><strong>Departemen & Keperluan:</strong>
                                                <ul class="mt-1">
                                                    <li><strong>Global:</strong> Sama untuk semua barang (WAJIB diisi
                                                        untuk Stok Keluar)</li>
                                                    <li><strong>Per Barang:</strong> Berbeda untuk setiap barang (WAJIB
                                                        diisi untuk Stok Keluar)</li>
                                                </ul>
                                            </li>
                                            <li><strong>Nama Penerima & Keterangan:</strong> Bisa global atau per barang
                                            </li>
                                            <li>Stok akan langsung diperbarui setelah transaksi disimpan</li>
                                            <li><strong>Multiple Items:</strong> Anda bisa menambahkan banyak barang
                                                dalam satu transaksi</li>
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
                                    <button type="submit" name="action" value="save" class="btn btn-primary">
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
                        <li><strong>Tanggal Transaksi:</strong> Otomatis menggunakan tanggal hari ini dan tidak dapat diubah</li>
                        <li>Transaksi <strong>Stok Masuk</strong> akan menambah stok barang</li>
                        <li>Transaksi <strong>Stok Keluar</strong> akan mengurangi stok barang</li>
                        <li>Pastikan jumlah stok keluar tidak melebihi stok tersedia</li>
                        <li>Transaksi akan langsung mempengaruhi stok barang</li>
                        <li>Klik tombol "Tambah Barang" untuk menambah barang ke daftar transaksi</li>
                        <li>Anda bisa menambahkan <strong>banyak barang</strong> dalam satu transaksi</li>
                        <li><strong>Semua Field bisa Global atau Per Barang:</strong>
                            <ul class="mt-1">
                                <li><strong>Stok Masuk:</strong> Supplier (WAJIB), Nama Penerima (WAJIB), Keterangan
                                    (Opsional)</li>
                                <li><strong>Stok Keluar:</strong> Departemen (WAJIB), Keperluan (WAJIB), Nama Penerima
                                    (WAJIB), Keterangan (Opsional)</li>
                            </ul>
                        </li>
                    </ul>
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
                                </tr>
                            </thead>
                            <tbody id="barangTableBody">
                                @foreach ($barangList as $index => $barang)
                                    <tr class="barang-item" data-kode="{{ $barang->kode_barang }}"
                                        data-nama="{{ $barang->nama_barang }}" data-satuan="{{ $barang->satuan }}"
                                        data-stok="{{ $barang->stok_akhir }}">
                                        <td class="text-center">
                                            <div class="form-check">
                                                <input class="form-check-input barang-checkbox" type="checkbox"
                                                    id="barang_{{ $barang->kode_barang }}"
                                                    value="{{ $barang->kode_barang }}">
                                            </div>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="barang_{{ $barang->kode_barang }}">
                                                <strong>{{ $barang->kode_barang }}</strong>
                                            </label>
                                        </td>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>{{ $barang->satuan }}</td>
                                        <td class="text-end">
                                            <span
                                                class="badge bg-{{ $barang->stok_akhir > 0 ? 'success' : 'danger' }}">
                                                {{ number_format($barang->stok_akhir, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 text-muted">
                        <small>
                            <i class="bi bi-info-circle me-1"></i>
                            Menampilkan <span id="itemCount">{{ count($barangList) }}</span> barang
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

    <!-- Modal Departemen -->
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

    <template id="barangItemTemplate">
        <div class="barang-item-card" data-kode="KODE_BARANG">
            <div class="barang-header">
                <div>
                    <h6 class="mb-0 fw-bold">NAMA_BARANG</h6>
                    <small class="text-muted">Kode: KODE_BARANG</small>
                </div>
                <button type="button" class="remove-barang-btn" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="product-info-item">
                        <div class="product-info-label">Satuan</div>
                        <div class="product-info-value">SATUAN</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-info-item">
                        <div class="product-info-label">Stok Tersedia</div>
                        <div class="product-info-value">
                            <span class="badge bg-STOK_COLOR">STOK_TOTAL SATUAN</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Field per Barang (ditampilkan jika mode Per Barang dipilih) -->
            <div class="field-group">

                <!-- Supplier per Barang (hanya untuk Stok Masuk - Mode Per Barang) -->
                <div class="barang-item-field supplier-field conditional-supplier-field" style="display: none;">
                    <label class="form-label">
                        <span>Supplier</span>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="supplier-input-group">
                        <input type="text" class="form-control supplier-per-barang"
                            placeholder="Supplier untuk barang ini" required>
                        <div class="supplier-suggestion-list"></div>
                    </div>
                </div>

                <!-- Departemen per Barang (hanya untuk Stok Keluar - Mode Per Barang) -->
                <div class="barang-item-field departemen-field conditional-departemen-field" style="display: none;">
                    <label class="form-label">
                        <span>Departemen</span>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control departemen-per-barang"
                            placeholder="Pilih departemen untuk barang ini" readonly required>
                        <button type="button" class="btn btn-outline-primary btn-sm btn-pilih-departemen-perbarang">
                            <i class="bi bi-search"></i> Pilih
                        </button>
                    </div>
                </div>

                <!-- Keperluan per Barang (hanya untuk Stok Keluar - Mode Per Barang) -->
                <div class="barang-item-field keperluan-field conditional-keperluan-field" style="display: none;">
                    <label class="form-label">
                        <span>Keperluan</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control keperluan-per-barang"
                        placeholder="Keperluan untuk barang ini" required>
                </div>

                <!-- Nama Penerima per Barang -->
                <div class="barang-item-field nama-penerima-field conditional-nama-penerima-field"
                    style="display: none;">
                    <label class="form-label">
                        <span>Nama Penerima</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control nama-penerima-per-barang"
                        placeholder="Nama penerima untuk barang ini" required>
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
        const tipeRadios = document.querySelectorAll('input[name="tipe"]');
        const stockWarning = document.getElementById('stockWarning');
        const stockWarningMessage = document.getElementById('stockWarningMessage');
        const searchBarangInput = document.getElementById('searchBarang');
        const barangTableBody = document.getElementById('barangTableBody');
        const itemCountSpan = document.getElementById('itemCount');
        const addBarangBtn = document.getElementById('addBarangBtn');
        const masukFields = document.getElementById('masukFields');
        const keluarFields = document.getElementById('keluarFields');
        const tipeError = document.getElementById('tipeError');
        const barangListContainer = document.getElementById('barangListContainer');
        const noBarangMessage = document.getElementById('noBarangMessage');
        const totalBarangSpan = document.getElementById('totalBarang');
        const barangDataContainer = document.getElementById('barangDataContainer');
        const barangItemTemplate = document.getElementById('barangItemTemplate');
        const departemenRowTemplate = document.getElementById('departemenRowTemplate');

        // Supplier mode elements
        const supplierModeRadios = document.querySelectorAll('input[name="supplier_mode"]');
        const supplierGlobalInput = document.getElementById('supplier_global');
        const supplierGlobalSuggestions = document.getElementById('supplierGlobalSuggestions');
        const supplierOptionGlobal = document.getElementById('supplierOptionGlobal');
        const supplierOptionPerBarang = document.getElementById('supplierOptionPerBarang');

        // Departemen mode elements
        const departemenModeRadios = document.querySelectorAll('input[name="departemen_mode"]');
        const departemenGlobalInput = document.getElementById('departemen_global');
        const departemenOptionGlobal = document.getElementById('departemenOptionGlobal');
        const departemenOptionPerBarang = document.getElementById('departemenOptionPerBarang');

        // Keperluan mode elements
        const keperluanModeRadios = document.querySelectorAll('input[name="keperluan_mode"]');
        const keperluanGlobalInput = document.getElementById('keperluan_global');
        const keperluanOptionGlobal = document.getElementById('keperluanOptionGlobal');
        const keperluanOptionPerBarang = document.getElementById('keperluanOptionPerBarang');

        // Nama Penerima mode elements
        const namaPenerimaModeRadios = document.querySelectorAll('input[name="nama_penerima_mode"]');
        const namaPenerimaGlobalInput = document.getElementById('nama_penerima_global');
        const namaPenerimaOptionGlobal = document.getElementById('namaPenerimaOptionGlobal');
        const namaPenerimaOptionPerBarang = document.getElementById('namaPenerimaOptionPerBarang');

        // Keterangan mode elements
        const keteranganModeRadios = document.querySelectorAll('input[name="keterangan_mode"]');
        const keteranganGlobalInput = document.getElementById('keterangan_global');
        const keteranganOptionGlobal = document.getElementById('keteranganOptionGlobal');
        const keteranganOptionPerBarang = document.getElementById('keteranganOptionPerBarang');

        // Modal elements
        const departemenModal = new bootstrap.Modal(document.getElementById('departemenModal'));
        const departemenTableBody = document.getElementById('departemenTableBody');
        const departemenCountSpan = document.getElementById('departemenCount');
        const searchDepartemenInput = document.getElementById('searchDepartemen');
        const btnPilihDepartemenGlobal = document.getElementById('btnPilihDepartemenGlobal');

        let selectedTipe = null;
        let selectedBarangList = [];
        let currentSupplierMode = 'global';
        let currentDepartemenMode = 'global';
        let currentKeperluanMode = 'global';
        let currentNamaPenerimaMode = 'global';
        let currentKeteranganMode = 'global';
        let targetDepartemenInput = null;
        let currentBarangIndex = null;

        let supplierHistory = @json($supplierList ?? []);
        let departemenList = @json($departemenList ?? []);

        function resetFormState() {
            tipeRadios.forEach(radio => radio.checked = false);
            selectedTipe = null;
            tipeError.classList.add('d-none');

            masukFields.style.display = 'none';
            keluarFields.style.display = 'none';

            // Reset semua input global
            supplierGlobalInput.value = '';
            departemenGlobalInput.value = '';
            keperluanGlobalInput.value = '';
            namaPenerimaGlobalInput.value = '';
            keteranganGlobalInput.value = '';

            // Reset semua modes ke Global
            currentSupplierMode = 'global';
            currentDepartemenMode = 'global';
            currentKeperluanMode = 'global';
            currentNamaPenerimaMode = 'global';
            currentKeteranganMode = 'global';

            // Update UI untuk semua modes
            updateAllModes();

            selectedBarangList = [];
            updateBarangListDisplay();

            document.querySelectorAll('.barang-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        function updateAllModes() {
            updateSupplierMode();
            updateDepartemenMode();
            updateKeperluanMode();
            updateNamaPenerimaMode();
            updateKeteranganMode();
        }

        function updateSupplierMode() {
            // Update UI based on supplier mode
            const modeRadios = document.querySelectorAll('input[name="supplier_mode"]:checked');
            if (modeRadios.length > 0) {
                currentSupplierMode = modeRadios[0].value;
            }

            // Update active class for options
            [supplierOptionGlobal, supplierOptionPerBarang].forEach(option => {
                option.classList.remove('active');
            });

            if (currentSupplierMode === 'global') {
                supplierOptionGlobal.classList.add('active');
            } else if (currentSupplierMode === 'perbarang') {
                supplierOptionPerBarang.classList.add('active');
            }

            // Update input status based on tipe transaksi
            if (selectedTipe === 'masuk') {
                if (currentSupplierMode === 'global') {
                    supplierGlobalInput.disabled = false;
                    supplierGlobalInput.required = true;
                } else {
                    supplierGlobalInput.disabled = true;
                    supplierGlobalInput.required = false;
                    supplierGlobalInput.value = '';
                }
            } else {
                // Untuk stok keluar, supplier tidak diperlukan
                supplierGlobalInput.disabled = true;
                supplierGlobalInput.required = false;
                supplierGlobalInput.value = '';
            }

            // Update field visibility
            updateBarangListDisplay();
        }

        function updateDepartemenMode() {
            // Update UI based on departemen mode
            const modeRadios = document.querySelectorAll('input[name="departemen_mode"]:checked');
            if (modeRadios.length > 0) {
                currentDepartemenMode = modeRadios[0].value;
            }

            // Update active class for options
            [departemenOptionGlobal, departemenOptionPerBarang].forEach(option => {
                option.classList.remove('active');
            });

            if (currentDepartemenMode === 'global') {
                departemenOptionGlobal.classList.add('active');

                // Nonaktifkan tombol pilih departemen di bagian informasi transaksi
                if (btnPilihDepartemenGlobal) {
                    btnPilihDepartemenGlobal.disabled = false;
                    btnPilihDepartemenGlobal.classList.remove('disabled');
                }
            } else if (currentDepartemenMode === 'perbarang') {
                departemenOptionPerBarang.classList.add('active');

                // Nonaktifkan tombol pilih departemen di bagian informasi transaksi
                if (btnPilihDepartemenGlobal) {
                    btnPilihDepartemenGlobal.disabled = true;
                    btnPilihDepartemenGlobal.classList.add('disabled');
                    btnPilihDepartemenGlobal.setAttribute('title',
                        'Tombol dinonaktifkan karena menggunakan mode Per Barang');
                }
            }

            // Update input status based on tipe transaksi
            if (selectedTipe === 'keluar') {
                if (currentDepartemenMode === 'global') {
                    departemenGlobalInput.disabled = false;
                    departemenGlobalInput.required = true;
                    // Juga nonaktifkan input jika tombol dinonaktifkan
                    if (btnPilihDepartemenGlobal) {
                        departemenGlobalInput.readOnly = true; // Read only karena pilih via modal
                    }
                } else {
                    departemenGlobalInput.disabled = true;
                    departemenGlobalInput.required = false;
                    departemenGlobalInput.value = '';
                    departemenGlobalInput.readOnly = false; // Bukan read only
                }
            } else {
                // Untuk stok masuk, departemen tidak diperlukan
                departemenGlobalInput.disabled = true;
                departemenGlobalInput.required = false;
                departemenGlobalInput.value = '';
                departemenGlobalInput.readOnly = false;

                // Pastikan tombol dinonaktifkan untuk stok masuk
                if (btnPilihDepartemenGlobal) {
                    btnPilihDepartemenGlobal.disabled = true;
                    btnPilihDepartemenGlobal.classList.add('disabled');
                }
            }

            // Update field visibility
            updateBarangListDisplay();
        }

        function updateKeperluanMode() {
            // Update UI based on keperluan mode
            const modeRadios = document.querySelectorAll('input[name="keperluan_mode"]:checked');
            if (modeRadios.length > 0) {
                currentKeperluanMode = modeRadios[0].value;
            }

            // Update active class for options
            [keperluanOptionGlobal, keperluanOptionPerBarang].forEach(option => {
                option.classList.remove('active');
            });

            if (currentKeperluanMode === 'global') {
                keperluanOptionGlobal.classList.add('active');
            } else if (currentKeperluanMode === 'perbarang') {
                keperluanOptionPerBarang.classList.add('active');
            }

            // Update input status based on tipe transaksi
            if (selectedTipe === 'keluar') {
                if (currentKeperluanMode === 'global') {
                    keperluanGlobalInput.disabled = false;
                    keperluanGlobalInput.required = true;
                } else {
                    keperluanGlobalInput.disabled = true;
                    keperluanGlobalInput.required = false;
                    keperluanGlobalInput.value = '';
                }
            } else {
                // Untuk stok masuk, keperluan tidak diperlukan
                keperluanGlobalInput.disabled = true;
                keperluanGlobalInput.required = false;
                keperluanGlobalInput.value = '';
            }

            // Update field visibility
            updateBarangListDisplay();
        }

        function updateNamaPenerimaMode() {
            // Update UI based on nama penerima mode
            const modeRadios = document.querySelectorAll('input[name="nama_penerima_mode"]:checked');
            if (modeRadios.length > 0) {
                currentNamaPenerimaMode = modeRadios[0].value;
            }

            // Update active class for options
            [namaPenerimaOptionGlobal, namaPenerimaOptionPerBarang].forEach(option => {
                option.classList.remove('active');
            });

            if (currentNamaPenerimaMode === 'global') {
                namaPenerimaOptionGlobal.classList.add('active');
            } else if (currentNamaPenerimaMode === 'perbarang') {
                namaPenerimaOptionPerBarang.classList.add('active');
            }

            // Update input status
            if (currentNamaPenerimaMode === 'global') {
                namaPenerimaGlobalInput.disabled = false;
                namaPenerimaGlobalInput.required = true;
            } else {
                namaPenerimaGlobalInput.disabled = true;
                namaPenerimaGlobalInput.required = false;
                namaPenerimaGlobalInput.value = '';
            }

            // Update field visibility
            updateBarangListDisplay();
        }

        function updateKeteranganMode() {
            // Update UI based on keterangan mode
            const modeRadios = document.querySelectorAll('input[name="keterangan_mode"]:checked');
            if (modeRadios.length > 0) {
                currentKeteranganMode = modeRadios[0].value;
            }

            // Update active class for options
            [keteranganOptionGlobal, keteranganOptionPerBarang].forEach(option => {
                option.classList.remove('active');
            });

            if (currentKeteranganMode === 'global') {
                keteranganOptionGlobal.classList.add('active');
            } else if (currentKeteranganMode === 'perbarang') {
                keteranganOptionPerBarang.classList.add('active');
            }

            // Update input status
            if (currentKeteranganMode === 'global') {
                keteranganGlobalInput.disabled = false;
                keteranganGlobalInput.required = false; // Keterangan opsional
            } else {
                keteranganGlobalInput.disabled = true;
                keteranganGlobalInput.required = false;
                keteranganGlobalInput.value = '';
            }

            // Update field visibility
            updateBarangListDisplay();
        }

        function showSupplierSuggestions(inputElement, suggestionsContainer) {
            const searchTerm = inputElement.value.toLowerCase();

            if (searchTerm.length < 2) {
                suggestionsContainer.style.display = 'none';
                return;
            }

            const filteredSuppliers = supplierHistory.filter(supplier =>
                supplier.toLowerCase().includes(searchTerm)
            );

            if (filteredSuppliers.length === 0) {
                suggestionsContainer.style.display = 'none';
                return;
            }

            suggestionsContainer.innerHTML = '';
            filteredSuppliers.forEach(supplier => {
                const item = document.createElement('div');
                item.className = 'supplier-suggestion-item';
                item.textContent = supplier;
                item.addEventListener('click', function() {
                    inputElement.value = supplier;
                    suggestionsContainer.style.display = 'none';

                    // Update corresponding barang object if applicable
                    if (inputElement.classList.contains('supplier-per-barang')) {
                        const kode = inputElement.closest('.barang-item-card').getAttribute('data-kode');
                        const barang = selectedBarangList.find(b => b.kode === kode);
                        if (barang) {
                            barang.supplier = supplier;
                        }
                    }
                });
                suggestionsContainer.appendChild(item);
            });

            suggestionsContainer.style.display = 'block';
        }

        function toggleFields() {
            if (!selectedTipe) {
                masukFields.style.display = 'none';
                keluarFields.style.display = 'none';

                // Nonaktifkan semua tombol pilih departemen
                if (btnPilihDepartemenGlobal) {
                    btnPilihDepartemenGlobal.disabled = true;
                    btnPilihDepartemenGlobal.classList.add('disabled');
                }
                return;
            }

            masukFields.style.display = 'none';
            keluarFields.style.display = 'none';

            if (selectedTipe === 'masuk') {
                masukFields.style.display = 'block';
                keluarFields.style.display = 'none';

                // Nonaktifkan tombol pilih departemen untuk stok masuk
                if (btnPilihDepartemenGlobal) {
                    btnPilihDepartemenGlobal.disabled = true;
                    btnPilihDepartemenGlobal.classList.add('disabled');
                    btnPilihDepartemenGlobal.setAttribute('title', 'Hanya untuk stok keluar');
                }
            } else {
                masukFields.style.display = 'none';
                keluarFields.style.display = 'block';

                // Aktifkan/nonaktifkan tombol berdasarkan mode
                updateDepartemenMode(); // Ini akan mengatur status tombol
            }

            // Update all modes untuk mengatur required yang benar
            updateAllModes();

            // Update field visibility
            updateBarangListDisplay();
        }

        function searchBarang() {
            const searchTerm = searchBarangInput.value.toLowerCase();
            const rows = barangTableBody.getElementsByClassName('barang-item');
            let visibleCount = 0;

            Array.from(rows).forEach(row => {
                const kode = row.getAttribute('data-kode').toLowerCase();
                const nama = row.getAttribute('data-nama').toLowerCase();
                const satuan = row.getAttribute('data-satuan').toLowerCase();

                const isVisible = kode.includes(searchTerm) ||
                    nama.includes(searchTerm) ||
                    satuan.includes(searchTerm);

                row.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });

            itemCountSpan.textContent = visibleCount;
        }

        function addBarangToList() {
            const selectedCheckboxes = document.querySelectorAll('.barang-checkbox:checked');

            if (selectedCheckboxes.length === 0) {
                alert('Silakan pilih barang terlebih dahulu!');
                return;
            }

            selectedCheckboxes.forEach(checkbox => {
                const row = checkbox.closest('.barang-item');
                const kode = row.getAttribute('data-kode');
                const nama = row.getAttribute('data-nama');
                const satuan = row.getAttribute('data-satuan');
                const stok = parseFloat(row.getAttribute('data-stok'));

                const existingIndex = selectedBarangList.findIndex(item => item.kode === kode);
                if (existingIndex === -1) {
                    selectedBarangList.push({
                        kode: kode,
                        nama: nama,
                        satuan: satuan,
                        stok: stok,
                        jumlah: '',
                        supplier: '',
                        departemen: '',
                        keperluan: '',
                        nama_penerima: '',
                        keterangan: ''
                    });
                }

                checkbox.checked = false;
            });

            updateBarangListDisplay();

            const modal = bootstrap.Modal.getInstance(document.getElementById('barangModal'));
            modal.hide();

            searchBarangInput.value = '';
            searchBarang();
        }

        function updateBarangListDisplay() {
            barangListContainer.innerHTML = '';

            if (selectedBarangList.length === 0) {
                barangListContainer.appendChild(noBarangMessage);
                noBarangMessage.classList.remove('d-none');
            } else {
                noBarangMessage.classList.add('d-none');

                selectedBarangList.forEach((barang, index) => {
                    const template = barangItemTemplate.content.cloneNode(true);
                    const itemCard = template.querySelector('.barang-item-card');

                    itemCard.setAttribute('data-kode', barang.kode);
                    itemCard.setAttribute('data-index', index);

                    itemCard.querySelector('h6').textContent = barang.nama;
                    itemCard.querySelector('small').textContent = `Kode: ${barang.kode}`;

                    itemCard.querySelectorAll('.product-info-value')[0].textContent = barang.satuan;

                    const stokColor = barang.stok > 0 ? 'success' : 'danger';
                    const stokBadge = itemCard.querySelector('.badge');
                    stokBadge.className = `badge bg-${stokColor}`;
                    stokBadge.textContent = `${barang.stok.toFixed(2)} ${barang.satuan}`;

                    // Update template placeholders
                    itemCard.innerHTML = itemCard.innerHTML
                        .replace(/KODE_BARANG/g, barang.kode)
                        .replace(/NAMA_BARANG/g, barang.nama)
                        .replace(/SATUAN/g, barang.satuan)
                        .replace(/STOK_COLOR/g, stokColor)
                        .replace(/STOK_TOTAL/g, barang.stok.toFixed(2))
                        .replace(/STOK_NUMBER/g, barang.stok);

                    // Supplier per barang (hanya untuk Stok Masuk - Mode Per Barang)
                    const supplierField = itemCard.querySelector('.supplier-per-barang');
                    supplierField.id = `supplier_${barang.kode}`;
                    supplierField.setAttribute('data-index', index);
                    supplierField.value = barang.supplier || '';

                    // Setup autocomplete for supplier per barang
                    const suggestionsContainer = supplierField.parentElement.querySelector(
                        '.supplier-suggestion-list');
                    supplierField.addEventListener('input', function() {
                        barang.supplier = this.value;
                        showSupplierSuggestions(this, suggestionsContainer);
                    });

                    supplierField.addEventListener('focus', function() {
                        showSupplierSuggestions(this, suggestionsContainer);
                    });

                    supplierField.addEventListener('blur', function() {
                        setTimeout(() => {
                            suggestionsContainer.style.display = 'none';
                        }, 200);
                    });

                    // Supplier visibility
                    const supplierContainer = itemCard.querySelector('.conditional-supplier-field');
                    if (selectedTipe === 'masuk' && currentSupplierMode === 'perbarang') {
                        supplierContainer.style.display = 'block';
                        supplierField.setAttribute('required', 'required');
                    } else {
                        supplierContainer.style.display = 'none';
                        supplierField.removeAttribute('required');
                    }

                    // Departemen per barang (hanya untuk Stok Keluar)
                    const departemenField = itemCard.querySelector('.departemen-per-barang');
                    departemenField.setAttribute('data-index', index);
                    departemenField.value = barang.departemen || '';

                    // KEPERLUAN PER BARANG - MODIFIKASI DI SINI
                    const departemenContainer = itemCard.querySelector('.conditional-departemen-field');
                    if (selectedTipe === 'keluar' && currentDepartemenMode === 'perbarang') {
                        departemenContainer.style.display = 'block';
                        departemenField.setAttribute('required', 'required');

                        // Aktifkan tombol pilih departemen per barang
                        const btnPilihDepartemenPerbarang = itemCard.querySelector(
                            '.btn-pilih-departemen-perbarang');
                        if (btnPilihDepartemenPerbarang) {
                            btnPilihDepartemenPerbarang.disabled = false;
                            btnPilihDepartemenPerbarang.classList.remove('disabled');
                            btnPilihDepartemenPerbarang.removeAttribute('title');
                        }
                    } else {
                        departemenContainer.style.display = 'none';
                        departemenField.removeAttribute('required');

                        // Nonaktifkan tombol pilih departemen per barang
                        const btnPilihDepartemenPerbarang = itemCard.querySelector(
                            '.btn-pilih-departemen-perbarang');
                        if (btnPilihDepartemenPerbarang) {
                            btnPilihDepartemenPerbarang.disabled = true;
                            btnPilihDepartemenPerbarang.classList.add('disabled');
                            btnPilihDepartemenPerbarang.setAttribute('title', 'Mode Global dipilih');
                        }
                    }

                    // Keperluan per barang (hanya untuk Stok Keluar)
                    const keperluanField = itemCard.querySelector('.keperluan-per-barang');
                    keperluanField.setAttribute('data-index', index);
                    keperluanField.value = barang.keperluan || '';
                    keperluanField.addEventListener('input', function() {
                        barang.keperluan = this.value;
                    });

                    const keperluanContainer = itemCard.querySelector('.conditional-keperluan-field');
                    if (selectedTipe === 'keluar' && currentKeperluanMode === 'perbarang') {
                        keperluanContainer.style.display = 'block';
                        keperluanField.setAttribute('required', 'required');
                    } else {
                        keperluanContainer.style.display = 'none';
                        keperluanField.removeAttribute('required');
                    }

                    // Nama Penerima per barang
                    const namaPenerimaField = itemCard.querySelector('.nama-penerima-per-barang');
                    namaPenerimaField.setAttribute('data-index', index);
                    namaPenerimaField.value = barang.nama_penerima || '';
                    namaPenerimaField.addEventListener('input', function() {
                        barang.nama_penerima = this.value;
                    });

                    const namaPenerimaContainer = itemCard.querySelector('.conditional-nama-penerima-field');
                    if (currentNamaPenerimaMode === 'perbarang') {
                        namaPenerimaContainer.style.display = 'block';
                        namaPenerimaField.setAttribute('required', 'required');
                    } else {
                        namaPenerimaContainer.style.display = 'none';
                        namaPenerimaField.removeAttribute('required');
                    }

                    // Keterangan per barang
                    const keteranganField = itemCard.querySelector('.keterangan-per-barang');
                    keteranganField.setAttribute('data-index', index);
                    keteranganField.value = barang.keterangan || '';
                    keteranganField.addEventListener('input', function() {
                        barang.keterangan = this.value;
                    });

                    const keteranganContainer = itemCard.querySelector('.conditional-keterangan-field');
                    if (currentKeteranganMode === 'perbarang') {
                        keteranganContainer.style.display = 'block';
                    } else {
                        keteranganContainer.style.display = 'none';
                    }

                    // Input jumlah
                    const jumlahInput = itemCard.querySelector('.jumlah-input');
                    jumlahInput.setAttribute('data-max', barang.stok);
                    jumlahInput.setAttribute('data-index', index);
                    jumlahInput.value = barang.jumlah || '';

                    const jumlahError = itemCard.querySelector('.jumlah-error');

                    jumlahInput.addEventListener('input', function() {
                        validateBarangJumlah(this);
                        validateBarangStock(this);
                        barang.jumlah = this.value;
                    });

                    // Setup event listener for departemen per barang button
                    const btnPilihDepartemenPerbarang = itemCard.querySelector('.btn-pilih-departemen-perbarang');
                    if (btnPilihDepartemenPerbarang) {
                        // Hanya tambahkan event listener jika tombol tidak disabled
                        if (!btnPilihDepartemenPerbarang.disabled) {
                            btnPilihDepartemenPerbarang.addEventListener('click', function() {
                                currentBarangIndex = index;
                                targetDepartemenInput = departemenField;
                                loadDepartemenList();
                                departemenModal.show();
                            });
                        }
                    }

                    const removeBtn = itemCard.querySelector('.remove-barang-btn');
                    removeBtn.addEventListener('click', function() {
                        removeBarangFromList(index);
                    });

                    barangListContainer.appendChild(itemCard);
                });
            }

            totalBarangSpan.textContent = selectedBarangList.length;
            validateAllStock();
        }

        function validateBarangJumlah(inputElement) {
            const jumlah = parseFloat(inputElement.value) || 0;
            const errorElement = inputElement.closest('.barang-item-card').querySelector('.jumlah-error');

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
            const index = inputElement.getAttribute('data-index');
            const jumlah = parseFloat(inputElement.value) || 0;
            const maxStok = parseFloat(inputElement.getAttribute('data-max'));
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

        function validateForm() {
            if (selectedTipe !== 'masuk' && selectedTipe !== 'keluar') {
                alert('Silakan pilih tipe transaksi!');
                return false;
            }

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

            // Validasi berdasarkan tipe transaksi
            if (selectedTipe === 'masuk') {
                if (currentSupplierMode === 'global') {
                    if (!supplierGlobalInput.value.trim()) {
                        alert('Supplier global wajib diisi untuk stok masuk!');
                        supplierGlobalInput.focus();
                        return false;
                    }
                } else if (currentSupplierMode === 'perbarang') {
                    for (let i = 0; i < selectedBarangList.length; i++) {
                        const barang = selectedBarangList[i];
                        if (!barang.supplier || !barang.supplier.trim()) {
                            alert(`Supplier wajib diisi untuk barang "${barang.nama}"!`);
                            const supplierInput = document.querySelector(
                                `.barang-item-card[data-index="${i}"] .supplier-per-barang`);
                            if (supplierInput) supplierInput.focus();
                            return false;
                        }
                    }
                }
                // Untuk stok masuk, tidak perlu validasi departemen dan keperluan

            } else if (selectedTipe === 'keluar') {
                // Validasi departemen untuk stok keluar
                if (currentDepartemenMode === 'global') {
                    if (!departemenGlobalInput.value) {
                        alert('Departemen wajib dipilih untuk stok keluar!');
                        departemenGlobalInput.focus();
                        return false;
                    }
                } else if (currentDepartemenMode === 'perbarang') {
                    for (let i = 0; i < selectedBarangList.length; i++) {
                        const barang = selectedBarangList[i];
                        if (!barang.departemen) {
                            alert(`Departemen wajib dipilih untuk barang "${barang.nama}"!`);
                            const departemenSelect = document.querySelector(
                                `.barang-item-card[data-index="${i}"] .departemen-per-barang`);
                            if (departemenSelect) departemenSelect.focus();
                            return false;
                        }
                    }
                }

                // Validasi keperluan untuk stok keluar
                if (currentKeperluanMode === 'global') {
                    if (!keperluanGlobalInput.value.trim()) {
                        alert('Keperluan wajib diisi untuk stok keluar!');
                        keperluanGlobalInput.focus();
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
            }

            // Validasi Nama Penerima (selalu wajib)
            if (currentNamaPenerimaMode === 'global') {
                if (!namaPenerimaGlobalInput.value.trim()) {
                    alert('Nama penerima wajib diisi!');
                    namaPenerimaGlobalInput.focus();
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

            // Validasi stok untuk keluar
            if (selectedTipe === 'keluar' && !validateAllStock()) {
                alert('Ada masalah dengan jumlah stok keluar! Periksa kembali jumlah barang.');
                return false;
            }

            return true;
        }

        function loadDepartemenList() {
            departemenTableBody.innerHTML = '';
            let count = 0;

            departemenList.forEach((departemen, index) => {
                const template = departemenRowTemplate.content.cloneNode(true);
                const row = template.querySelector('.departemen-item');

                row.querySelector('td:first-child').textContent = index + 1;
                row.querySelector('.departemen-nama').textContent = departemen;

                const selectBtn = row.querySelector('.btn-pilih-departemen');
                selectBtn.addEventListener('click', function() {
                    selectDepartemen(departemen);
                });

                departemenTableBody.appendChild(row);
                count++;
            });

            departemenCountSpan.textContent = count;
            searchDepartemen();
        }

        function searchDepartemen() {
            const searchTerm = searchDepartemenInput.value.toLowerCase();
            const rows = departemenTableBody.getElementsByClassName('departemen-item');
            let visibleCount = 0;

            Array.from(rows).forEach(row => {
                const departemenNama = row.querySelector('.departemen-nama').textContent.toLowerCase();
                const isVisible = departemenNama.includes(searchTerm);

                row.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });

            departemenCountSpan.textContent = visibleCount;
        }

        function selectDepartemen(departemen) {
            if (targetDepartemenInput) {
                targetDepartemenInput.value = departemen;

                // Update data barang jika mode per barang
                if (currentBarangIndex !== null && selectedBarangList[currentBarangIndex]) {
                    selectedBarangList[currentBarangIndex].departemen = departemen;
                }
            }

            departemenModal.hide();
            targetDepartemenInput = null;
            currentBarangIndex = null;
        }

        // Setup autocomplete for global supplier
        supplierGlobalInput.addEventListener('input', function() {
            showSupplierSuggestions(this, supplierGlobalSuggestions);
        });

        supplierGlobalInput.addEventListener('focus', function() {
            showSupplierSuggestions(this, supplierGlobalSuggestions);
        });

        supplierGlobalInput.addEventListener('blur', function() {
            setTimeout(() => {
                supplierGlobalSuggestions.style.display = 'none';
            }, 200);
        });

        // Event Listeners
        tipeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                selectedTipe = this.value;
                tipeError.classList.add('d-none');
                toggleFields();
                validateAllStock();
            });
        });

        // Event listeners untuk semua mode radio buttons
        supplierModeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateSupplierMode();
            });
        });

        departemenModeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateDepartemenMode();
            });
        });

        keperluanModeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateKeperluanMode();
            });
        });

        namaPenerimaModeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateNamaPenerimaMode();
            });
        });

        keteranganModeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateKeteranganMode();
            });
        });

        // Event listener untuk tombol pilih departemen global
        btnPilihDepartemenGlobal.addEventListener('click', function() {
            targetDepartemenInput = departemenGlobalInput;
            currentBarangIndex = null;
            loadDepartemenList();
            departemenModal.show();
        });

        // Event listener untuk pencarian departemen
        searchDepartemenInput.addEventListener('input', searchDepartemen);

        // Click handlers untuk semua option items
        function setupOptionClickHandler(optionElement) {
            optionElement.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change'));
                }
            });
        }

        // Setup click handlers untuk semua option containers
        [
            supplierOptionGlobal, supplierOptionPerBarang,
            departemenOptionGlobal, departemenOptionPerBarang,
            keperluanOptionGlobal, keperluanOptionPerBarang,
            namaPenerimaOptionGlobal, namaPenerimaOptionPerBarang,
            keteranganOptionGlobal, keteranganOptionPerBarang
        ].forEach(setupOptionClickHandler);

        addBarangBtn.addEventListener('click', addBarangToList);
        searchBarangInput.addEventListener('input', searchBarang);

        document.getElementById('transactionForm').addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }

            // Collect all data and prepare for submission
            prepareFormData();

            return true;
        });

        function prepareFormData() {
            // Clear existing hidden inputs
            barangDataContainer.innerHTML = '';

            // Add mode data
            addHiddenInput('supplier_mode', currentSupplierMode);
            addHiddenInput('departemen_mode', currentDepartemenMode);
            addHiddenInput('keperluan_mode', currentKeperluanMode);
            addHiddenInput('nama_penerima_mode', currentNamaPenerimaMode);
            addHiddenInput('keterangan_mode', currentKeteranganMode);

            // Add global data sesuai tipe transaksi
            if (selectedTipe === 'masuk') {
                if (currentSupplierMode === 'global') {
                    addHiddenInput('supplier_global', supplierGlobalInput.value);
                }
            } else if (selectedTipe === 'keluar') {
                if (currentDepartemenMode === 'global') {
                    addHiddenInput('departemen_global', departemenGlobalInput.value);
                }
                if (currentKeperluanMode === 'global') {
                    addHiddenInput('keperluan_global', keperluanGlobalInput.value);
                }
            }

            // Nama penerima dan keterangan selalu dikirim jika mode global
            if (currentNamaPenerimaMode === 'global') {
                addHiddenInput('nama_penerima_global', namaPenerimaGlobalInput.value);
            }

            if (currentKeteranganMode === 'global') {
                addHiddenInput('keterangan_global', keteranganGlobalInput.value);
            }

            // Add tanggal and tipe
            addHiddenInput('tanggal', document.querySelector('input[name="tanggal"]').value);
            addHiddenInput('tipe', selectedTipe);

            // Add barang data
            selectedBarangList.forEach((barang, index) => {
                addHiddenInput(`barang[${index}][kode_barang]`, barang.kode);
                addHiddenInput(`barang[${index}][jumlah]`, barang.jumlah);

                // Add per-barang fields sesuai tipe transaksi
                if (selectedTipe === 'masuk' && currentSupplierMode === 'perbarang') {
                    addHiddenInput(`barang[${index}][supplier]`, barang.supplier);
                }

                if (selectedTipe === 'keluar') {
                    if (currentDepartemenMode === 'perbarang') {
                        addHiddenInput(`barang[${index}][departemen]`, barang.departemen);
                    }

                    if (currentKeperluanMode === 'perbarang') {
                        addHiddenInput(`barang[${index}][keperluan]`, barang.keperluan);
                    }
                }

                if (currentNamaPenerimaMode === 'perbarang') {
                    addHiddenInput(`barang[${index}][nama_penerima]`, barang.nama_penerima);
                }

                if (currentKeteranganMode === 'perbarang') {
                    addHiddenInput(`barang[${index}][keterangan]`, barang.keterangan);
                }
            });
        }

        function addHiddenInput(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            barangDataContainer.appendChild(input);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            resetFormState();
            updateAllModes();

            // Nonaktifkan tombol pilih departemen global secara default
            if (btnPilihDepartemenGlobal) {
                btnPilihDepartemenGlobal.disabled = true;
                btnPilihDepartemenGlobal.classList.add('disabled');
                btnPilihDepartemenGlobal.setAttribute('title', 'Pilih tipe transaksi terlebih dahulu');
            }
        });
    </script>
</body>

</html>