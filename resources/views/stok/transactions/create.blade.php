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
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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

                    <div class="card-body">
                        <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-clipboard-data me-2"></i>Informasi Transaksi
                                    </h5>
                                    <div class="mb-3">
                                        <label class="form-label required">Tanggal Transaksi</label>
                                        <input type="date" name="tanggal" class="form-control"
                                            value="{{ date('Y-m-d') }}" required>
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
                                            <div class="supplier-options">
                                                <div class="mb-3">
                                                    <label class="form-label">Pilih Opsi Supplier:</label>
                                                    <div class="d-flex flex-column gap-2">
                                                        <div class="supplier-option" id="supplierOptionGlobal">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" 
                                                                       name="supplier_mode" 
                                                                       id="supplier_mode_global" 
                                                                       value="global" checked>
                                                                <label class="form-check-label" for="supplier_mode_global">
                                                                    <strong>Supplier Global</strong> - Sama untuk semua barang
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="supplier-option" id="supplierOptionPerBarang">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" 
                                                                       name="supplier_mode" 
                                                                       id="supplier_mode_perbarang" 
                                                                       value="perbarang">
                                                                <label class="form-check-label" for="supplier_mode_perbarang">
                                                                    <strong>Supplier Per Barang</strong> - Berbeda untuk setiap barang
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Input Supplier Global -->
                                            <div id="supplierGlobalContainer" class="global-field-container">
                                                <label for="supplier_global" class="form-label">
                                                    <span id="supplierGlobalLabel">Supplier Global</span>
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="supplier-input-group">
                                                    <input type="text" name="supplier_global" id="supplier_global" 
                                                           class="form-control" 
                                                           placeholder="Masukkan nama supplier"
                                                           required>
                                                    <div id="supplierGlobalSuggestions" class="supplier-suggestion-list"></div>
                                                </div>
                                                <div class="supplier-info mt-2">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    <small class="text-muted">
                                                        <span id="supplierModeDescription">
                                                            Supplier global akan digunakan untuk semua barang dalam transaksi ini.
                                                        </span>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Field khusus Stok Keluar -->
                                    <div id="keluarFields" class="conditional-field">
                                        <div class="mb-3">
                                            <label class="form-label required">Departemen</label>
                                            <div class="field-group">
                                                <div class="field-mode-options">
                                                    <div class="field-mode-option active" data-field="departemen" data-mode="global">
                                                        <i class="bi bi-globe me-1"></i>Global
                                                    </div>
                                                    <div class="field-mode-option" data-field="departemen" data-mode="perbarang">
                                                        <i class="bi bi-box me-1"></i>Per Barang
                                                    </div>
                                                </div>
                                                <div id="departemenGlobalContainer" class="global-field-container">
                                                    <select name="departemen_global" id="departemen_global" class="form-select" required>
                                                        <option value="">-- Pilih Departemen --</option>
                                                        @foreach($departemenList as $departemen)
                                                            <option value="{{ $departemen }}">{{ $departemen }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-muted">Departemen akan digunakan untuk semua barang</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required">Keperluan</label>
                                            <div class="field-group">
                                                <div class="field-mode-options">
                                                    <div class="field-mode-option active" data-field="keperluan" data-mode="global">
                                                        <i class="bi bi-globe me-1"></i>Global
                                                    </div>
                                                    <div class="field-mode-option" data-field="keperluan" data-mode="perbarang">
                                                        <i class="bi bi-box me-1"></i>Per Barang
                                                    </div>
                                                </div>
                                                <div id="keperluanGlobalContainer" class="global-field-container">
                                                    <input type="text" name="keperluan_global" id="keperluan_global"
                                                           class="form-control"
                                                           required
                                                           placeholder="Masukkan keperluan global">
                                                    <small class="text-muted">Keperluan akan digunakan untuk semua barang</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nama Penerima Barang -->
                                    <div class="mb-3">
                                        <label class="form-label required">Nama Penerima Barang</label>
                                        <div class="field-group">
                                            <div class="field-mode-options">
                                                <div class="field-mode-option active" data-field="nama_penerima" data-mode="global">
                                                    <i class="bi bi-globe me-1"></i>Global
                                                </div>
                                                <div class="field-mode-option" data-field="nama_penerima" data-mode="perbarang">
                                                    <i class="bi bi-box me-1"></i>Per Barang
                                                </div>
                                            </div>
                                            <div id="namaPenerimaGlobalContainer" class="global-field-container">
                                                <input type="text" name="nama_penerima_global" id="nama_penerima_global" class="form-control"
                                                    value="{{ old('nama_penerima_global') }}" 
                                                    required
                                                    placeholder="Masukkan nama penerima barang global">
                                                <small class="text-muted">Nama penerima akan digunakan untuk semua barang</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Keterangan -->
                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <div class="field-group">
                                            <div class="field-mode-options">
                                                <div class="field-mode-option active" data-field="keterangan" data-mode="global">
                                                    <i class="bi bi-globe me-1"></i>Global
                                                </div>
                                                <div class="field-mode-option" data-field="keterangan" data-mode="perbarang">
                                                    <i class="bi bi-box me-1"></i>Per Barang
                                                </div>
                                            </div>
                                            <div id="keteranganGlobalContainer" class="global-field-container">
                                                <textarea name="keterangan_global" id="keterangan_global" rows="4" class="form-control" 
                                                    placeholder="Tambahkan keterangan transaksi global (opsional)">{{ old('keterangan_global') }}</textarea>
                                                <small class="text-muted">Keterangan akan digunakan untuk semua barang</small>
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
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#barangModal">
                                                <i class="bi bi-plus-circle me-1"></i>Tambah Barang
                                            </button>
                                        </div>
                                        
                                        <div class="barang-list-container" id="barangListContainer">
                                            <div class="no-barang-message" id="noBarangMessage">
                                                <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                                <p class="mb-0">Belum ada barang dipilih</p>
                                                <small class="text-muted">Klik tombol "Tambah Barang" untuk memulai</small>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3 text-end">
                                            <small>Total Barang: <span class="total-barang" id="totalBarang">0</span></small>
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
                                            <li><strong>Pilih Tipe:</strong> Pilih Stok Masuk atau Stok Keluar terlebih dahulu</li>
                                            <li><strong>Supplier Options:</strong>
                                                <ul class="mt-1">
                                                    <li><strong>Global:</strong> Satu supplier untuk semua barang (WAJIB diisi)</li>
                                                    <li><strong>Per Barang:</strong> Input supplier berbeda untuk setiap barang (WAJIB diisi)</li>
                                                </ul>
                                            </li>
                                            <li><strong>Nama Penerima & Keterangan:</strong> Bisa global atau per barang</li>
                                            <li><strong>Stok Keluar:</strong> Departemen dan Keperluan bisa global atau per barang</li>
                                            <li>Stok akan langsung diperbarui setelah transaksi disimpan</li>
                                            <li><strong>Multiple Items:</strong> Anda bisa menambahkan banyak barang dalam satu transaksi</li>
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
                        <li>Transaksi <strong>Stok Masuk</strong> akan menambah stok barang</li>
                        <li>Transaksi <strong>Stok Keluar</strong> akan mengurangi stok barang</li>
                        <li>Pastikan jumlah stok keluar tidak melebihi stok tersedia</li>
                        <li>Transaksi akan langsung mempengaruhi stok barang</li>
                        <li>Klik tombol "Tambah Barang" untuk menambah barang ke daftar transaksi</li>
                        <li>Anda bisa menambahkan <strong>banyak barang</strong> dalam satu transaksi</li>
                        <li><strong>Semua Field bisa Global atau Per Barang:</strong>
                            <ul class="mt-1">
                                <li><strong>Supplier</strong> (hanya untuk Stok Masuk)</li>
                                <li><strong>Nama Penerima</strong> (wajib)</li>
                                <li><strong>Keterangan</strong> (opsional)</li>
                                <li><strong>Departemen & Keperluan</strong> (hanya untuk Stok Keluar)</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="barangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="barangModalLabel">
                        <i class="bi bi-box-seam me-2"></i>Tambah Barang ke Transaksi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <tr class="barang-item" 
                                    data-kode="{{ $barang->kode_barang }}"
                                    data-nama="{{ $barang->nama_barang }}"
                                    data-satuan="{{ $barang->satuan }}"
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
                                        <span class="badge bg-{{ $barang->stok_akhir > 0 ? 'success' : 'danger' }}">
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
                        <input type="text" 
                               class="form-control supplier-per-barang" 
                               placeholder="Supplier untuk barang ini"
                               required>
                        <div class="supplier-suggestion-list"></div>
                    </div>
                </div>
                
                <!-- Departemen per Barang (hanya untuk Stok Keluar) -->
                <div class="barang-item-field departemen-field conditional-departemen-field" style="display: none;">
                    <label class="form-label">
                        <span>Departemen</span>
                        <span class="text-danger">*</span>
                    </label>
                    <select class="form-control departemen-per-barang" required>
                        <option value="">-- Pilih Departemen --</option>
                        @foreach($departemenList as $departemen)
                            <option value="{{ $departemen }}">{{ $departemen }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Keperluan per Barang (hanya untuk Stok Keluar) -->
                <div class="barang-item-field keperluan-field conditional-keperluan-field" style="display: none;">
                    <label class="form-label">
                        <span>Keperluan</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control keperluan-per-barang" 
                           placeholder="Keperluan untuk barang ini"
                           required>
                </div>
                
                <!-- Nama Penerima per Barang -->
                <div class="barang-item-field nama-penerima-field conditional-nama-penerima-field" style="display: none;">
                    <label class="form-label">
                        <span>Nama Penerima</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control nama-penerima-per-barang" 
                           placeholder="Nama penerima untuk barang ini"
                           required>
                </div>
                
                <!-- Keterangan per Barang -->
                <div class="barang-item-field keterangan-field conditional-keterangan-field" style="display: none;">
                    <label class="form-label">
                        <span>Keterangan</span>
                        <span class="text-muted">(Opsional)</span>
                    </label>
                    <textarea class="form-control keterangan-per-barang" 
                              rows="2" 
                              placeholder="Keterangan untuk barang ini (opsional)"></textarea>
                </div>
                
            </div>
            
            <div class="mt-3">
                <label class="form-label required">Jumlah</label>
                <input type="number" 
                       class="form-control jumlah-input" 
                       step="0.01" 
                       min="0.01" 
                       required
                       placeholder="Masukkan jumlah"
                       data-max="STOK_NUMBER">
                <div class="invalid-feedback jumlah-error" style="display: none;">
                    Jumlah harus lebih dari 0
                </div>
            </div>
        </div>
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
        
        // Supplier mode elements
        const supplierModeRadios = document.querySelectorAll('input[name="supplier_mode"]');
        const supplierGlobalInput = document.getElementById('supplier_global');
        const supplierGlobalSuggestions = document.getElementById('supplierGlobalSuggestions');
        const supplierOptionGlobal = document.getElementById('supplierOptionGlobal');
        const supplierOptionPerBarang = document.getElementById('supplierOptionPerBarang');
        
        // Field mode elements
        const fieldModeOptions = document.querySelectorAll('.field-mode-option');
        
        // Global field containers
        const departemenGlobalContainer = document.getElementById('departemenGlobalContainer');
        const keperluanGlobalContainer = document.getElementById('keperluanGlobalContainer');
        const namaPenerimaGlobalContainer = document.getElementById('namaPenerimaGlobalContainer');
        const keteranganGlobalContainer = document.getElementById('keteranganGlobalContainer');
        
        // Global field inputs
        const departemenGlobalInput = document.getElementById('departemen_global');
        const keperluanGlobalInput = document.getElementById('keperluan_global');
        const namaPenerimaGlobalInput = document.getElementById('nama_penerima_global');
        const keteranganGlobalInput = document.getElementById('keterangan_global');

        let selectedTipe = null;
        let selectedBarangList = [];
        let currentSupplierMode = 'global'; // Default mode: Global
        let fieldModes = {
            departemen: 'global',
            keperluan: 'global',
            nama_penerima: 'global',
            keterangan: 'global'
        };
        
        let supplierHistory = @json($supplierList ?? []);

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
            
            // Reset supplier mode to Global
            document.getElementById('supplier_mode_global').checked = true;
            currentSupplierMode = 'global';
            updateSupplierMode();
            
            // Reset semua field modes ke Global
            fieldModes = {
                departemen: 'global',
                keperluan: 'global',
                nama_penerima: 'global',
                keterangan: 'global'
            };
            
            // Update UI field modes
            updateFieldModesUI();
            
            selectedBarangList = [];
            updateBarangListDisplay();
            
            document.querySelectorAll('.barang-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
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
                // Enable and require supplier global input
                supplierGlobalInput.disabled = false;
                supplierGlobalInput.required = true;
                
                // Update supplier global label
                document.querySelector('#supplierGlobalLabel').innerHTML = 'Supplier Global';
                
            } else if (currentSupplierMode === 'perbarang') {
                supplierOptionPerBarang.classList.add('active');
                // Disable and unrequire supplier global input
                supplierGlobalInput.disabled = true;
                supplierGlobalInput.required = false;
                supplierGlobalInput.value = '';
                
                // Update supplier global label
                document.querySelector('#supplierGlobalLabel').innerHTML = 'Supplier Global <span class="text-muted">(Tidak digunakan)</span>';
            }
            
            // Update field visibility
            updateBarangListDisplay();
        }

        function updateFieldModesUI() {
            console.log('Updating field modes:', fieldModes);
            
            // Update active state for field mode options
            fieldModeOptions.forEach(option => {
                const field = option.getAttribute('data-field');
                const mode = option.getAttribute('data-mode');
                
                if (fieldModes[field] === mode) {
                    option.classList.add('active');
                } else {
                    option.classList.remove('active');
                }
            });
            
            // Show/hide global field containers and update required status
            const fields = ['departemen', 'keperluan', 'nama_penerima', 'keterangan'];
            fields.forEach(field => {
                const globalContainer = document.getElementById(`${field}GlobalContainer`);
                if (globalContainer) {
                    const input = globalContainer.querySelector('input, select, textarea');
                    const label = globalContainer.querySelector('label');
                    
                    if (fieldModes[field] === 'global') {
                        globalContainer.style.display = 'block';
                        if (input) {
                            // Enable input
                            input.disabled = false;
                            
                            // Set required based on field
                            if (field === 'keterangan') {
                                input.removeAttribute('required');
                                if (label) {
                                    const requiredSpan = label.querySelector('.text-danger');
                                    if (requiredSpan) requiredSpan.style.display = 'none';
                                }
                            } else {
                                input.setAttribute('required', 'required');
                                if (label) {
                                    const requiredSpan = label.querySelector('.text-danger');
                                    if (requiredSpan) requiredSpan.style.display = 'inline';
                                }
                            }
                        }
                    } else {
                        globalContainer.style.display = 'none';
                        if (input) {
                            // Disable input and clear value
                            input.disabled = true;
                            input.removeAttribute('required');
                            input.value = '';
                            
                            if (label) {
                                const requiredSpan = label.querySelector('.text-danger');
                                if (requiredSpan) requiredSpan.style.display = 'none';
                            }
                        }
                    }
                }
            });
            
            // Update field visibility in barang items
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
                return;
            }
            
            masukFields.style.display = 'none';
            keluarFields.style.display = 'none';
            
            if (selectedTipe === 'masuk') {
                masukFields.style.display = 'block';
            } else {
                keluarFields.style.display = 'block';
            }
            
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
                    const suggestionsContainer = supplierField.parentElement.querySelector('.supplier-suggestion-list');
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
                    departemenField.addEventListener('change', function() {
                        barang.departemen = this.value;
                    });
                    
                    const departemenContainer = itemCard.querySelector('.conditional-departemen-field');
                    if (selectedTipe === 'keluar' && fieldModes.departemen === 'perbarang') {
                        departemenContainer.style.display = 'block';
                        departemenField.setAttribute('required', 'required');
                    } else {
                        departemenContainer.style.display = 'none';
                        departemenField.removeAttribute('required');
                    }
                    
                    // Keperluan per barang (hanya untuk Stok Keluar)
                    const keperluanField = itemCard.querySelector('.keperluan-per-barang');
                    keperluanField.setAttribute('data-index', index);
                    keperluanField.value = barang.keperluan || '';
                    keperluanField.addEventListener('input', function() {
                        barang.keperluan = this.value;
                    });
                    
                    const keperluanContainer = itemCard.querySelector('.conditional-keperluan-field');
                    if (selectedTipe === 'keluar' && fieldModes.keperluan === 'perbarang') {
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
                    if (fieldModes.nama_penerima === 'perbarang') {
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
                    if (fieldModes.keterangan === 'perbarang') {
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
                    // Focus on the corresponding input
                    const jumlahInput = document.querySelector(`.barang-item-card[data-index="${i}"] .jumlah-input`);
                    if (jumlahInput) jumlahInput.focus();
                    return false;
                }
            }
            
            // Validasi berdasarkan tipe transaksi
            if (selectedTipe === 'masuk') {
                if (currentSupplierMode === 'global') {
                    if (!supplierGlobalInput.value.trim()) {
                        alert('Supplier global wajib diisi untuk mode Global!');
                        supplierGlobalInput.focus();
                        return false;
                    }
                } else if (currentSupplierMode === 'perbarang') {
                    for (let i = 0; i < selectedBarangList.length; i++) {
                        const barang = selectedBarangList[i];
                        if (!barang.supplier || !barang.supplier.trim()) {
                            alert(`Supplier wajib diisi untuk barang "${barang.nama}"!`);
                            const supplierInput = document.querySelector(`.barang-item-card[data-index="${i}"] .supplier-per-barang`);
                            if (supplierInput) supplierInput.focus();
                            return false;
                        }
                    }
                }
            }
            
            if (selectedTipe === 'keluar') {
                if (fieldModes.departemen === 'global') {
                    if (!departemenGlobalInput.value) {
                        alert('Departemen wajib dipilih untuk stok keluar!');
                        departemenGlobalInput.focus();
                        return false;
                    }
                } else if (fieldModes.departemen === 'perbarang') {
                    for (let i = 0; i < selectedBarangList.length; i++) {
                        const barang = selectedBarangList[i];
                        if (!barang.departemen) {
                            alert(`Departemen wajib dipilih untuk barang "${barang.nama}"!`);
                            const departemenSelect = document.querySelector(`.barang-item-card[data-index="${i}"] .departemen-per-barang`);
                            if (departemenSelect) departemenSelect.focus();
                            return false;
                        }
                    }
                }
                
                if (fieldModes.keperluan === 'global') {
                    if (!keperluanGlobalInput.value.trim()) {
                        alert('Keperluan wajib diisi untuk stok keluar!');
                        keperluanGlobalInput.focus();
                        return false;
                    }
                } else if (fieldModes.keperluan === 'perbarang') {
                    for (let i = 0; i < selectedBarangList.length; i++) {
                        const barang = selectedBarangList[i];
                        if (!barang.keperluan || !barang.keperluan.trim()) {
                            alert(`Keperluan wajib diisi untuk barang "${barang.nama}"!`);
                            const keperluanInput = document.querySelector(`.barang-item-card[data-index="${i}"] .keperluan-per-barang`);
                            if (keperluanInput) keperluanInput.focus();
                            return false;
                        }
                    }
                }
            }
            
            // Validasi Nama Penerima
            if (fieldModes.nama_penerima === 'global') {
                if (!namaPenerimaGlobalInput.value.trim()) {
                    alert('Nama penerima wajib diisi!');
                    namaPenerimaGlobalInput.focus();
                    return false;
                }
            } else if (fieldModes.nama_penerima === 'perbarang') {
                for (let i = 0; i < selectedBarangList.length; i++) {
                    const barang = selectedBarangList[i];
                    if (!barang.nama_penerima || !barang.nama_penerima.trim()) {
                        alert(`Nama penerima wajib diisi untuk barang "${barang.nama}"!`);
                        const namaPenerimaInput = document.querySelector(`.barang-item-card[data-index="${i}"] .nama-penerima-per-barang`);
                        if (namaPenerimaInput) namaPenerimaInput.focus();
                        return false;
                    }
                }
            }
            
            // Validasi stok untuk keluar
            if (!validateAllStock()) {
                alert('Ada masalah dengan jumlah stok keluar! Periksa kembali jumlah barang.');
                return false;
            }
            
            return true;
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

        supplierModeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                updateSupplierMode();
                toggleFields();
            });
        });

        // Click handlers for supplier options
        [supplierOptionGlobal, supplierOptionPerBarang].forEach(option => {
            option.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change'));
                }
            });
        });

        // Field mode options
        fieldModeOptions.forEach(option => {
            option.addEventListener('click', function() {
                const field = this.getAttribute('data-field');
                const mode = this.getAttribute('data-mode');
                
                // Update field mode
                fieldModes[field] = mode;
                
                // Update UI
                updateFieldModesUI();
            });
        });

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
            addHiddenInput('departemen_mode', fieldModes.departemen);
            addHiddenInput('keperluan_mode', fieldModes.keperluan);
            addHiddenInput('nama_penerima_mode', fieldModes.nama_penerima);
            addHiddenInput('keterangan_mode', fieldModes.keterangan);
            
            // Add global data if mode is global
            if (currentSupplierMode === 'global' && selectedTipe === 'masuk') {
                addHiddenInput('supplier_global', supplierGlobalInput.value);
            }
            
            if (fieldModes.departemen === 'global' && selectedTipe === 'keluar') {
                addHiddenInput('departemen_global', departemenGlobalInput.value);
            }
            
            if (fieldModes.keperluan === 'global' && selectedTipe === 'keluar') {
                addHiddenInput('keperluan_global', keperluanGlobalInput.value);
            }
            
            if (fieldModes.nama_penerima === 'global') {
                addHiddenInput('nama_penerima_global', namaPenerimaGlobalInput.value);
            }
            
            if (fieldModes.keterangan === 'global') {
                addHiddenInput('keterangan_global', keteranganGlobalInput.value);
            }
            
            // Add tanggal and tipe
            addHiddenInput('tanggal', document.querySelector('input[name="tanggal"]').value);
            addHiddenInput('tipe', selectedTipe);
            
            // Add barang data
            selectedBarangList.forEach((barang, index) => {
                addHiddenInput(`barang[${index}][kode_barang]`, barang.kode);
                addHiddenInput(`barang[${index}][nama_barang]`, barang.nama);
                addHiddenInput(`barang[${index}][satuan]`, barang.satuan);
                addHiddenInput(`barang[${index}][stok_tersedia]`, barang.stok);
                addHiddenInput(`barang[${index}][jumlah]`, barang.jumlah);
                
                // Add per-barang fields if applicable
                if (selectedTipe === 'masuk' && currentSupplierMode === 'perbarang') {
                    addHiddenInput(`barang[${index}][supplier]`, barang.supplier);
                }
                
                if (selectedTipe === 'keluar' && fieldModes.departemen === 'perbarang') {
                    addHiddenInput(`barang[${index}][departemen]`, barang.departemen);
                }
                
                if (selectedTipe === 'keluar' && fieldModes.keperluan === 'perbarang') {
                    addHiddenInput(`barang[${index}][keperluan]`, barang.keperluan);
                }
                
                if (fieldModes.nama_penerima === 'perbarang') {
                    addHiddenInput(`barang[${index}][nama_penerima]`, barang.nama_penerima);
                }
                
                if (fieldModes.keterangan === 'perbarang') {
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
            updateSupplierMode();
            updateFieldModesUI();
        });
    </script>
</body>

</html>