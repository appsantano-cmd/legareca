@extends('layouts.master')

@section('title', 'FORM TAMBAH STOK BARU')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Data Stok Baru
                        </h4>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('stok.store') }}" method="POST" id="stokForm">
                            @csrf

                            <!-- Informasi Sistem -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-info-circle me-2"></i>Informasi Sistem
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Kode Barang</label>
                                            <input type="text" class="form-control bg-light" value="{{ $kodeBarang }}"
                                                readonly style="font-weight: bold; color: #0d6efd;">
                                            <input type="hidden" name="kode_barang" value="{{ $kodeBarang }}">
                                            <small class="text-muted">Kode di-generate otomatis oleh sistem</small>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label required">Tanggal Submit</label>
                                            <div class="input-group">
                                                <input type="datetime-local" name="tanggal_submit" 
                                                    class="form-control @error('tanggal_submit') is-invalid @enderror"
                                                    id="tanggalSubmitInput"
                                                    value="{{ old('tanggal_submit', date('Y-m-d\TH:i')) }}"
                                                    required>
                                                <button type="button" class="btn btn-outline-secondary" id="setTanggalSekarang">
                                                    <i class="bi bi-clock"></i> Sekarang
                                                </button>
                                            </div>
                                            @error('tanggal_submit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Klik tombol "Sekarang" untuk tanggal saat ini</small>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Periode</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light text-center"
                                                    id="bulanDisplay" readonly>
                                                <input type="text" class="form-control bg-light text-center"
                                                    id="tahunDisplay" readonly>
                                                <input type="hidden" name="bulan" id="bulanHidden">
                                                <input type="hidden" name="tahun" id="tahunHidden">
                                            </div>
                                            <small class="text-muted">Otomatis berdasarkan tanggal submit</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Informasi Barang -->
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-box me-2"></i>Informasi Barang
                                    </h5>

                                    <!-- Input untuk Nama Barang (tanpa ukuran) -->
                                    <div class="mb-3">
                                        <label class="form-label required">Nama Barang</label>
                                        <input type="text" name="nama_barang"
                                            class="form-control @error('nama_barang') is-invalid @enderror"
                                            value="{{ old('nama_barang') }}"
                                            placeholder="Contoh: Marie Regal, Tepung Terigu, Gula Pasir" required
                                            id="namaBarangInput">
                                        @error('nama_barang')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Masukkan nama barang tanpa ukuran</small>
                                    </div>

                                    <!-- Input untuk Ukuran Barang (otomatis uppercase) -->
                                    <div class="mb-3">
                                        <label class="form-label required">Ukuran Barang</label>
                                        <div class="input-group">
                                            <input type="text" name="ukuran_barang"
                                                class="form-control @error('ukuran_barang') is-invalid @enderror"
                                                value="{{ old('ukuran_barang') }}"
                                                placeholder="Contoh: 1 KG, 500 GR, 250 ML" required id="ukuranBarangInput"
                                                oninput="autoUppercase(this)">
                                            <span class="input-group-text">
                                                <i class="bi bi-arrow-up" title="Otomatis UPPERCASE"></i>
                                            </span>
                                        </div>
                                        @error('ukuran_barang')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Ukuran akan otomatis diubah menjadi UPPERCASE</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Satuan</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="satuanDisplay"
                                                placeholder="Klik untuk memilih satuan" readonly
                                                value="{{ old('satuan') }}" required>
                                            <input type="hidden" name="satuan" id="satuanValue"
                                                value="{{ old('satuan') }}">
                                            <button class="btn btn-outline-primary" type="button" id="openSatuanModal">
                                                <i class="bi bi-search me-1"></i>Pilih Satuan
                                            </button>
                                        </div>

                                        <!-- Selected Satuan -->
                                        <div class="mt-2" id="selectedSatuanContainer"
                                            style="display: {{ old('satuan') ? 'block' : 'none' }};">
                                            <div
                                                class="alert alert-info py-2 mb-0 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-check-circle me-2"></i>
                                                    Satuan dipilih: <strong
                                                        id="selectedSatuanText">{{ old('satuan') }}</strong>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    id="clearSatuanBtn">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </div>
                                        </div>

                                        @error('satuan')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Klik tombol "Pilih Satuan" untuk memilih dari daftar yang
                                            tersedia</small>
                                    </div>
                                </div>

                                <!-- Informasi Tambahan -->
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-building me-2"></i>Informasi Tambahan
                                    </h5>

                                    <!-- Departemen -->
                                    <div class="mb-3">
                                        <label class="form-label required">Departemen</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="departemenDisplay"
                                                placeholder="Klik untuk memilih departemen" readonly
                                                value="{{ old('departemen') }}" required>
                                            <input type="hidden" name="departemen" id="departemenValue"
                                                value="{{ old('departemen') }}">
                                            <button class="btn btn-outline-primary" type="button" id="openDepartemenModal">
                                                <i class="bi bi-search me-1"></i>Pilih Departemen
                                            </button>
                                        </div>

                                        <!-- Selected Departemen -->
                                        <div class="mt-2" id="selectedDepartemenContainer"
                                            style="display: {{ old('departemen') ? 'block' : 'none' }};">
                                            <div
                                                class="alert alert-info py-2 mb-0 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-check-circle me-2"></i>
                                                    Departemen dipilih: <strong
                                                        id="selectedDepartemenText">{{ old('departemen') }}</strong>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    id="clearDepartemenBtn">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </div>
                                        </div>

                                        @error('departemen')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Klik tombol "Pilih Departemen" untuk memilih dari daftar yang
                                            tersedia</small>
                                    </div>

                                    <!-- Supplier -->
                                    <div class="mb-3">
                                        <label class="form-label required">Supplier</label>
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" id="supplierDisplay"
                                                placeholder="Klik untuk memilih supplier" readonly
                                                value="{{ old('supplier') }}" required>
                                            <input type="hidden" name="supplier" id="supplierValue"
                                                value="{{ old('supplier') }}">
                                            <button class="btn btn-outline-primary" type="button" id="openSupplierModal">
                                                <i class="bi bi-search me-1"></i>Pilih Supplier
                                            </button>
                                        </div>

                                        <!-- Selected Supplier -->
                                        <div class="mt-2" id="selectedSupplierContainer"
                                            style="display: {{ old('supplier') ? 'block' : 'none' }};">
                                            <div
                                                class="alert alert-info py-2 mb-0 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-check-circle me-2"></i>
                                                    Supplier dipilih: <strong
                                                        id="selectedSupplierText">{{ old('supplier') }}</strong>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    id="clearSupplierBtn">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </div>
                                        </div>

                                        @error('supplier')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Klik tombol "Pilih Supplier" untuk memilih dari daftar yang
                                            tersedia</small>
                                    </div>

                                    <!-- Stok Awal -->
                                    <div class="mb-3">
                                        <label class="form-label required">Stok Awal Bulan</label>
                                        <input type="number" name="stok_awal" step="0.01" min="0"
                                            class="form-control @error('stok_awal') is-invalid @enderror"
                                            value="{{ old('stok_awal', 0) }}" required id="stokAwalInput">
                                        @error('stok_awal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Stok di awal bulan ini</small>
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <textarea name="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror"
                                            placeholder="Tambahkan catatan jika diperlukan">{{ old('keterangan') }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Preview Nama Barang Lengkap -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Preview Nama Barang Lengkap</label>
                                        <div class="alert alert-warning py-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-eye me-2 fs-4"></i>
                                                <div>
                                                    <strong>Nama Barang: </strong>
                                                    <span id="namaBarangPreview">-</span>
                                                    <br>
                                                    <small class="text-muted">Ini yang akan disimpan di database</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stok Preview -->
                                <div class="col-12">
                                    <div class="stok-preview">
                                        <h6>Info:</h6>
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <strong>Kode Barang: {{ $kodeBarang }}</strong><br>
                                            <strong>Stok Awal: <span id="stokAwalPreview">0.00</span></strong><br>
                                            <strong>Tanggal Submit: <span id="tanggalSubmitPreview">{{ date('d/m/Y H:i') }}</span></strong><br>
                                            <strong>Periode: <span id="periodePreview">{{ date('F Y') }}</span></strong><br>
                                            <strong>Data akan disimpan ke:</strong> 
                                            <span class="badge bg-primary">Master Stok</span> dan 
                                            <span class="badge bg-success">Stok Detail</span><br>
                                            <small>Stok masuk dan keluar diinput melalui menu "Transaksi Harian"</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('stok.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="alert alert-info mt-3">
                    <h6><i class="bi bi-info-circle me-2"></i>Informasi Penting</h6>
                    <ul class="mb-0">
                        <li><strong>Kode Barang:</strong> AA001, AA002, dst. <em>(dibuat otomatis oleh sistem)</em></li>
                        <li><strong>Nama Barang:</strong> Pisahkan antara nama produk dan ukuran</li>
                        <li><strong>Ukuran:</strong> Akan otomatis diubah menjadi UPPERCASE (contoh: 1 KG, 500 GR)</li>
                        <li><strong>Contoh Format:</strong> "Marie Regal" + "1 KG" = "Marie Regal 1 KG"</li>
                        <li><strong>Tanggal Submit:</strong> Dapat diubah sesuai kebutuhan, default adalah waktu sekarang</li>
                        <li><strong>Periode:</strong> Otomatis ditentukan berdasarkan tanggal submit</li>
                        <li><strong>Departemen & Supplier:</strong> Harus dipilih dari daftar yang tersedia</li>
                        <li><strong>Data akan disimpan di 2 tempat:</strong> Master Stok (data utama) dan Stok Detail (data bulanan)</li>
                        <li>Form ini akan menyimpan data ke <strong>Master Stok</strong> dan <strong>Stok Detail Bulanan</strong></li>
                        <li><strong>Stok masuk dan keluar</strong> diinput melalui menu <strong>"Transaksi Harian"</strong></li>
                        <li>Stok akan otomatis terupdate setiap ada transaksi</li>
                        <li>Stok akhir bulan akan menjadi stok awal bulan berikutnya saat rollover</li>
                        <li>Untuk menambah satuan, departemen, atau supplier baru, silakan gunakan menu masing-masing</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Memilih Satuan -->
    <div class="modal fade" id="satuanModal" tabindex="-1" aria-labelledby="satuanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="satuanModalLabel">
                        <i class="bi bi-rulers me-2"></i>Pilih Satuan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Search Bar -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" id="satuanSearchInput"
                                    placeholder="Cari satuan...">
                                <button class="btn btn-outline-secondary" type="button" id="satuanClearSearchBtn">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-primary w-100" id="satuanRefreshBtn">
                                <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Loading Spinner -->
                    <div class="text-center py-4" id="satuanLoadingSpinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat data satuan...</p>
                    </div>

                    <!-- Satuan Table -->
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto; display: none;"
                        id="satuanTableContainer">
                        <table class="table table-hover table-sm mb-0" id="satuanTable">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th width="50">Pilih</th>
                                    <th>Nama Satuan</th>
                                </tr>
                            </thead>
                            <tbody id="satuanTableBody">
                                <!-- Data akan diisi via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- No Data Message -->
                    <div class="text-center py-5" id="satuanNoDataMessage" style="display: none;">
                        <i class="bi bi-inbox display-6 d-block mb-3 text-muted"></i>
                        <h5 class="text-muted mb-2">Tidak ada data satuan</h5>
                        <p class="text-muted mb-3">Silakan tambahkan satuan terlebih dahulu melalui menu <a
                                href="{{ route('satuan.index') }}">Master Satuan</a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="satuanSelectBtn" disabled>Pilih Satuan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Memilih Departemen -->
    <div class="modal fade" id="departemenModal" tabindex="-1" aria-labelledby="departemenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="departemenModalLabel">
                        <i class="bi bi-building me-2"></i>Pilih Departemen
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Search Bar -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" id="departemenSearchInput"
                                    placeholder="Cari departemen...">
                                <button class="btn btn-outline-secondary" type="button" id="departemenClearSearchBtn">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-success w-100" id="departemenRefreshBtn">
                                <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Loading Spinner -->
                    <div class="text-center py-4" id="departemenLoadingSpinner">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat data departemen...</p>
                    </div>

                    <!-- Departemen Table -->
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto; display: none;"
                        id="departemenTableContainer">
                        <table class="table table-hover table-sm mb-0" id="departemenTable">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th width="50">Pilih</th>
                                    <th>Nama Departemen</th>
                                </tr>
                            </thead>
                            <tbody id="departemenTableBody">
                                <!-- Data akan diisi via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- No Data Message -->
                    <div class="text-center py-5" id="departemenNoDataMessage" style="display: none;">
                        <i class="bi bi-inbox display-6 d-block mb-3 text-muted"></i>
                        <h5 class="text-muted mb-2">Tidak ada data departemen</h5>
                        <p class="text-muted mb-3">Silakan tambahkan departemen terlebih dahulu melalui menu <a
                                href="{{ route('departemen.index') }}">Master Departemen</a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" id="departemenSelectBtn" disabled>Pilih Departemen</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Memilih Supplier -->
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="supplierModalLabel">
                        <i class="bi bi-truck me-2"></i>Pilih Supplier
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Search Bar -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" id="supplierSearchInput"
                                    placeholder="Cari supplier...">
                                <button class="btn btn-outline-secondary" type="button" id="supplierClearSearchBtn">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-warning w-100" id="supplierRefreshBtn">
                                <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Loading Spinner -->
                    <div class="text-center py-4" id="supplierLoadingSpinner">
                        <div class="spinner-border text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat data supplier...</p>
                    </div>

                    <!-- Supplier Table -->
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto; display: none;"
                        id="supplierTableContainer">
                        <table class="table table-hover table-sm mb-0" id="supplierTable">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th width="50">Pilih</th>
                                    <th>Nama Supplier</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="supplierTableBody">
                                <!-- Data akan diisi via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- No Data Message -->
                    <div class="text-center py-5" id="supplierNoDataMessage" style="display: none;">
                        <i class="bi bi-inbox display-6 d-block mb-3 text-muted"></i>
                        <h5 class="text-muted mb-2">Tidak ada data supplier</h5>
                        <p class="text-muted mb-3">Silakan tambahkan supplier terlebih dahulu melalui menu <a
                                href="{{ route('supplier.index') }}">Master Supplier</a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-warning" id="supplierSelectBtn" disabled>Pilih Supplier</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements - Satuan
            const satuanDisplay = document.getElementById('satuanDisplay');
            const satuanValue = document.getElementById('satuanValue');
            const openSatuanModalBtn = document.getElementById('openSatuanModal');
            const selectedSatuanContainer = document.getElementById('selectedSatuanContainer');
            const selectedSatuanText = document.getElementById('selectedSatuanText');
            const clearSatuanBtn = document.getElementById('clearSatuanBtn');

            // Elements - Departemen
            const departemenDisplay = document.getElementById('departemenDisplay');
            const departemenValue = document.getElementById('departemenValue');
            const openDepartemenModalBtn = document.getElementById('openDepartemenModal');
            const selectedDepartemenContainer = document.getElementById('selectedDepartemenContainer');
            const selectedDepartemenText = document.getElementById('selectedDepartemenText');
            const clearDepartemenBtn = document.getElementById('clearDepartemenBtn');

            // Elements - Supplier
            const supplierDisplay = document.getElementById('supplierDisplay');
            const supplierValue = document.getElementById('supplierValue');
            const openSupplierModalBtn = document.getElementById('openSupplierModal');
            const selectedSupplierContainer = document.getElementById('selectedSupplierContainer');
            const selectedSupplierText = document.getElementById('selectedSupplierText');
            const clearSupplierBtn = document.getElementById('clearSupplierBtn');

            // Common Elements
            const tanggalSubmitInput = document.getElementById('tanggalSubmitInput');
            const setTanggalSekarangBtn = document.getElementById('setTanggalSekarang');
            const stokAwalInput = document.getElementById('stokAwalInput');
            const stokAwalPreview = document.getElementById('stokAwalPreview');
            const tanggalSubmitPreview = document.getElementById('tanggalSubmitPreview');
            const bulanDisplay = document.getElementById('bulanDisplay');
            const tahunDisplay = document.getElementById('tahunDisplay');
            const periodePreview = document.getElementById('periodePreview');
            const bulanHidden = document.getElementById('bulanHidden');
            const tahunHidden = document.getElementById('tahunHidden');
            const namaBarangInput = document.getElementById('namaBarangInput');
            const ukuranBarangInput = document.getElementById('ukuranBarangInput');
            const namaBarangPreview = document.getElementById('namaBarangPreview');

            // Variables
            let selectedSatuanNama = '';
            let selectedDepartemenNama = '';
            let selectedSupplierNama = '';
            let satuanData = [];
            let departemenData = [];
            let supplierData = [];

            // Initialize
            function initialize() {
                updateStokPreview();
                updateSystemInfo();
                updateNamaBarangPreview();

                // Load selected values from old input
                loadOldValues();

                // Focus on nama barang input
                namaBarangInput.focus();
            }

            function loadOldValues() {
                // Satuan
                const oldSatuan = satuanValue.value;
                if (oldSatuan) {
                    selectedSatuanNama = oldSatuan;
                    satuanDisplay.value = oldSatuan;
                    selectedSatuanContainer.style.display = 'block';
                    selectedSatuanText.textContent = oldSatuan;
                }

                // Departemen
                const oldDepartemen = departemenValue.value;
                if (oldDepartemen) {
                    selectedDepartemenNama = oldDepartemen;
                    departemenDisplay.value = oldDepartemen;
                    selectedDepartemenContainer.style.display = 'block';
                    selectedDepartemenText.textContent = oldDepartemen;
                }

                // Supplier
                const oldSupplier = supplierValue.value;
                if (oldSupplier) {
                    selectedSupplierNama = oldSupplier;
                    supplierDisplay.value = oldSupplier;
                    selectedSupplierContainer.style.display = 'block';
                    selectedSupplierText.textContent = oldSupplier;
                }

                // Set other old values
                @if (old('nama_barang'))
                    namaBarangInput.value = "{{ old('nama_barang') }}";
                @endif

                @if (old('ukuran_barang'))
                    ukuranBarangInput.value = "{{ old('ukuran_barang') }}";
                @endif

                @if (old('stok_awal'))
                    stokAwalInput.value = "{{ old('stok_awal') }}";
                @endif

                @if (old('tanggal_submit'))
                    tanggalSubmitInput.value = "{{ old('tanggal_submit') }}";
                @endif

                updateNamaBarangPreview();
                updateStokPreview();
                updateSystemInfo();
            }

            // Function to auto uppercase
            function autoUppercase(element) {
                element.value = element.value.toUpperCase();
                updateNamaBarangPreview();
            }

            // Function to update nama barang preview
            function updateNamaBarangPreview() {
                const namaBarang = namaBarangInput.value.trim();
                const ukuranBarang = ukuranBarangInput.value.trim();

                let previewText = '-';

                if (namaBarang && ukuranBarang) {
                    previewText = `${namaBarang} ${ukuranBarang}`;
                } else if (namaBarang) {
                    previewText = `${namaBarang} [Belum ada ukuran]`;
                } else if (ukuranBarang) {
                    previewText = `[Belum ada nama barang] ${ukuranBarang}`;
                }

                namaBarangPreview.textContent = previewText;
            }

            // Update system information based on tanggal submit
            function updateSystemInfo() {
                const tanggalSubmit = tanggalSubmitInput.value;
                let date;
                
                if (tanggalSubmit) {
                    date = new Date(tanggalSubmit);
                } else {
                    date = new Date();
                }

                // Format date for preview
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                
                tanggalSubmitPreview.textContent = `${day}/${month}/${year} ${hours}:${minutes}`;

                // Get month name for display
                const monthNames = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];

                const monthName = monthNames[date.getMonth()];
                const currentYear = date.getFullYear();

                // Update display
                bulanDisplay.value = monthName;
                tahunDisplay.value = currentYear;
                periodePreview.textContent = `${monthName} ${currentYear}`;

                // Update hidden fields
                bulanHidden.value = date.getMonth() + 1; // 1-12
                tahunHidden.value = currentYear;
            }

            // Set tanggal to current date and time
            function setTanggalSekarang() {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');

                const dateTimeString = `${year}-${month}-${day}T${hours}:${minutes}`;
                tanggalSubmitInput.value = dateTimeString;
                updateSystemInfo();
            }

            // Update stok preview
            function updateStokPreview() {
                const stokAwal = parseFloat(stokAwalInput.value) || 0;
                stokAwalPreview.textContent = stokAwal.toFixed(2);
            }

            // ========== SATUAN FUNCTIONS ==========
            // Load satuan data
            function loadSatuanData() {
                showSatuanLoading(true);

                fetch('{{ route('api.satuan.index') }}', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            throw new TypeError("Oops, we haven't got JSON!");
                        }
                        return response.json();
                    })
                    .then(data => {
                        satuanData = data;
                        renderSatuanTable(data);
                        showSatuanLoading(false);
                    })
                    .catch(error => {
                        console.error('Error loading satuan:', error);
                        showSatuanLoading(false);
                        showSatuanNoDataMessage();
                    });
            }

            // Render satuan table
            function renderSatuanTable(data) {
                const satuanTableBody = document.getElementById('satuanTableBody');
                satuanTableBody.innerHTML = '';

                if (data.length === 0) {
                    showSatuanNoDataMessage();
                    return;
                }

                const filteredData = filterSatuanData(data);

                if (filteredData.length === 0) {
                    showSatuanNoResults();
                    return;
                }

                filteredData.forEach(satuan => {
                    const row = document.createElement('tr');
                    row.className = 'satuan-modal-row';
                    row.setAttribute('data-nama', satuan.nama_satuan);

                    const isSelected = selectedSatuanNama === satuan.nama_satuan;

                    row.innerHTML = `
                    <td class="text-center align-middle">
                        <div class="form-check">
                            <input class="form-check-input satuan-modal-radio" 
                                   type="radio" 
                                   name="modal_satuan" 
                                   id="modal_satuan_${satuan.id}"
                                   value="${satuan.nama_satuan}"
                                   ${isSelected ? 'checked' : ''}>
                        </div>
                    </td>
                    <td class="align-middle">
                        <label class="form-check-label" for="modal_satuan_${satuan.id}">
                            ${satuan.nama_satuan}
                        </label>
                    </td>
                `;

                    satuanTableBody.appendChild(row);
                });

                document.getElementById('satuanTableContainer').style.display = 'block';
                document.getElementById('satuanNoDataMessage').style.display = 'none';

                setupSatuanRowClickHandlers();
            }

            function filterSatuanData(data) {
                const searchTerm = document.getElementById('satuanSearchInput').value.toLowerCase();
                if (!searchTerm) return data;
                return data.filter(satuan => satuan.nama_satuan.toLowerCase().includes(searchTerm));
            }

            function showSatuanLoading(show) {
                document.getElementById('satuanLoadingSpinner').style.display = show ? 'block' : 'none';
                document.getElementById('satuanTableContainer').style.display = show ? 'none' : 'block';
                document.getElementById('satuanNoDataMessage').style.display = show ? 'none' : 'none';
            }

            function showSatuanNoDataMessage() {
                document.getElementById('satuanTableContainer').style.display = 'none';
                document.getElementById('satuanNoDataMessage').style.display = 'block';
            }

            function showSatuanNoResults() {
                const satuanTableBody = document.getElementById('satuanTableBody');
                satuanTableBody.innerHTML = `
                <tr>
                    <td colspan="2" class="text-center py-4">
                        <i class="bi bi-search display-6 d-block mb-2 text-muted"></i>
                        <p class="text-muted mb-0">Tidak ditemukan satuan dengan kata kunci tersebut</p>
                    </td>
                </tr>
            `;
                document.getElementById('satuanTableContainer').style.display = 'block';
                document.getElementById('satuanNoDataMessage').style.display = 'none';
            }

            function setupSatuanRowClickHandlers() {
                const rows = document.querySelectorAll('.satuan-modal-row');
                const radios = document.querySelectorAll('.satuan-modal-radio');

                rows.forEach(row => {
                    row.addEventListener('click', function(e) {
                        if (e.target.type !== 'radio') {
                            const radio = this.querySelector('.satuan-modal-radio');
                            if (radio) {
                                radio.checked = true;
                                handleSatuanSelection(radio.value);
                            }
                        }
                    });

                    row.addEventListener('mouseenter', function() {
                        if (!this.querySelector('.satuan-modal-radio:checked')) {
                            this.style.backgroundColor = '#f8f9fa';
                        }
                    });

                    row.addEventListener('mouseleave', function() {
                        if (!this.querySelector('.satuan-modal-radio:checked')) {
                            this.style.backgroundColor = '';
                        }
                    });
                });

                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        handleSatuanSelection(this.value);
                    });
                });
            }

            function handleSatuanSelection(nama) {
                selectedSatuanNama = nama;
                document.getElementById('satuanSelectBtn').disabled = false;

                document.querySelectorAll('.satuan-modal-row').forEach(row => {
                    const radio = row.querySelector('.satuan-modal-radio');
                    if (radio && radio.checked) {
                        row.style.backgroundColor = '#e7f1ff';
                        row.classList.add('selected');
                    } else {
                        row.style.backgroundColor = '';
                        row.classList.remove('selected');
                    }
                });
            }

            function clearSatuanSelection() {
                satuanDisplay.value = '';
                satuanValue.value = '';
                selectedSatuanNama = '';
                selectedSatuanContainer.style.display = 'none';

                document.querySelectorAll('.satuan-modal-radio').forEach(radio => {
                    radio.checked = false;
                });

                document.querySelectorAll('.satuan-modal-row').forEach(row => {
                    row.style.backgroundColor = '';
                    row.classList.remove('selected');
                });
            }

            // ========== DEPARTEMEN FUNCTIONS ==========
            // Load departemen data
            function loadDepartemenData() {
                showDepartemenLoading(true);

                fetch('{{ route('api.departemen.index') }}', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        departemenData = data;
                        renderDepartemenTable(data);
                        showDepartemenLoading(false);
                    })
                    .catch(error => {
                        console.error('Error loading departemen:', error);
                        showDepartemenLoading(false);
                        showDepartemenNoDataMessage();
                    });
            }

            function renderDepartemenTable(data) {
                const departemenTableBody = document.getElementById('departemenTableBody');
                departemenTableBody.innerHTML = '';

                if (data.length === 0) {
                    showDepartemenNoDataMessage();
                    return;
                }

                const filteredData = filterDepartemenData(data);

                if (filteredData.length === 0) {
                    showDepartemenNoResults();
                    return;
                }

                filteredData.forEach(departemen => {
                    const row = document.createElement('tr');
                    row.className = 'departemen-modal-row';
                    row.setAttribute('data-nama', departemen.nama_departemen);

                    const isSelected = selectedDepartemenNama === departemen.nama_departemen;

                    row.innerHTML = `
                    <td class="text-center align-middle">
                        <div class="form-check">
                            <input class="form-check-input departemen-modal-radio" 
                                   type="radio" 
                                   name="modal_departemen" 
                                   id="modal_departemen_${departemen.id}"
                                   value="${departemen.nama_departemen}"
                                   ${isSelected ? 'checked' : ''}>
                        </div>
                    </td>
                    <td class="align-middle">
                        <label class="form-check-label" for="modal_departemen_${departemen.id}">
                            ${departemen.nama_departemen}
                        </label>
                    </td>
                `;

                    departemenTableBody.appendChild(row);
                });

                document.getElementById('departemenTableContainer').style.display = 'block';
                document.getElementById('departemenNoDataMessage').style.display = 'none';

                setupDepartemenRowClickHandlers();
            }

            function filterDepartemenData(data) {
                const searchTerm = document.getElementById('departemenSearchInput').value.toLowerCase();
                if (!searchTerm) return data;
                return data.filter(departemen => departemen.nama_departemen.toLowerCase().includes(searchTerm));
            }

            function showDepartemenLoading(show) {
                document.getElementById('departemenLoadingSpinner').style.display = show ? 'block' : 'none';
                document.getElementById('departemenTableContainer').style.display = show ? 'none' : 'block';
                document.getElementById('departemenNoDataMessage').style.display = show ? 'none' : 'none';
            }

            function showDepartemenNoDataMessage() {
                document.getElementById('departemenTableContainer').style.display = 'none';
                document.getElementById('departemenNoDataMessage').style.display = 'block';
            }

            function showDepartemenNoResults() {
                const departemenTableBody = document.getElementById('departemenTableBody');
                departemenTableBody.innerHTML = `
                <tr>
                    <td colspan="2" class="text-center py-4">
                        <i class="bi bi-search display-6 d-block mb-2 text-muted"></i>
                        <p class="text-muted mb-0">Tidak ditemukan departemen dengan kata kunci tersebut</p>
                    </td>
                </tr>
            `;
                document.getElementById('departemenTableContainer').style.display = 'block';
                document.getElementById('departemenNoDataMessage').style.display = 'none';
            }

            function setupDepartemenRowClickHandlers() {
                const rows = document.querySelectorAll('.departemen-modal-row');
                const radios = document.querySelectorAll('.departemen-modal-radio');

                rows.forEach(row => {
                    row.addEventListener('click', function(e) {
                        if (e.target.type !== 'radio') {
                            const radio = this.querySelector('.departemen-modal-radio');
                            if (radio) {
                                radio.checked = true;
                                handleDepartemenSelection(radio.value);
                            }
                        }
                    });

                    row.addEventListener('mouseenter', function() {
                        if (!this.querySelector('.departemen-modal-radio:checked')) {
                            this.style.backgroundColor = '#f8f9fa';
                        }
                    });

                    row.addEventListener('mouseleave', function() {
                        if (!this.querySelector('.departemen-modal-radio:checked')) {
                            this.style.backgroundColor = '';
                        }
                    });
                });

                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        handleDepartemenSelection(this.value);
                    });
                });
            }

            function handleDepartemenSelection(nama) {
                selectedDepartemenNama = nama;
                document.getElementById('departemenSelectBtn').disabled = false;

                document.querySelectorAll('.departemen-modal-row').forEach(row => {
                    const radio = row.querySelector('.departemen-modal-radio');
                    if (radio && radio.checked) {
                        row.style.backgroundColor = '#e7f1ff';
                        row.classList.add('selected');
                    } else {
                        row.style.backgroundColor = '';
                        row.classList.remove('selected');
                    }
                });
            }

            function clearDepartemenSelection() {
                departemenDisplay.value = '';
                departemenValue.value = '';
                selectedDepartemenNama = '';
                selectedDepartemenContainer.style.display = 'none';

                document.querySelectorAll('.departemen-modal-radio').forEach(radio => {
                    radio.checked = false;
                });

                document.querySelectorAll('.departemen-modal-row').forEach(row => {
                    row.style.backgroundColor = '';
                    row.classList.remove('selected');
                });
            }

            // ========== SUPPLIER FUNCTIONS ==========
            // Load supplier data
            function loadSupplierData() {
                showSupplierLoading(true);

                fetch('{{ route('supplier.api.supplier.index') }}', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        supplierData = data;
                        renderSupplierTable(data);
                        showSupplierLoading(false);
                    })
                    .catch(error => {
                        console.error('Error loading supplier:', error);
                        showSupplierLoading(false);
                        showSupplierNoDataMessage();
                    });
            }

            function renderSupplierTable(data) {
                const supplierTableBody = document.getElementById('supplierTableBody');
                supplierTableBody.innerHTML = '';

                if (data.length === 0) {
                    showSupplierNoDataMessage();
                    return;
                }

                const filteredData = filterSupplierData(data);

                if (filteredData.length === 0) {
                    showSupplierNoResults();
                    return;
                }

                filteredData.forEach(supplier => {
                    const row = document.createElement('tr');
                    row.className = 'supplier-modal-row';
                    row.setAttribute('data-nama', supplier.nama_supplier);

                    const isSelected = selectedSupplierNama === supplier.nama_supplier;
                    const isDeleted = supplier.deleted_at ? true : false;

                    row.innerHTML = `
                    <td class="text-center align-middle">
                        <div class="form-check">
                            <input class="form-check-input supplier-modal-radio" 
                                   type="radio" 
                                   name="modal_supplier" 
                                   id="modal_supplier_${supplier.id}"
                                   value="${supplier.nama_supplier}"
                                   ${isSelected ? 'checked' : ''}
                                   ${isDeleted ? 'disabled' : ''}>
                        </div>
                    </td>
                    <td class="align-middle">
                        <label class="form-check-label" for="modal_supplier_${supplier.id}">
                            ${supplier.nama_supplier}
                        </label>
                    </td>
                    <td class="align-middle">
                        ${isDeleted ? 
                            '<span class="badge bg-danger">Terhapus</span>' : 
                            '<span class="badge bg-success">Aktif</span>'
                        }
                    </td>
                `;

                    supplierTableBody.appendChild(row);
                });

                document.getElementById('supplierTableContainer').style.display = 'block';
                document.getElementById('supplierNoDataMessage').style.display = 'none';

                setupSupplierRowClickHandlers();
            }

            function filterSupplierData(data) {
                const searchTerm = document.getElementById('supplierSearchInput').value.toLowerCase();
                if (!searchTerm) return data;
                return data.filter(supplier => supplier.nama_supplier.toLowerCase().includes(searchTerm));
            }

            function showSupplierLoading(show) {
                document.getElementById('supplierLoadingSpinner').style.display = show ? 'block' : 'none';
                document.getElementById('supplierTableContainer').style.display = show ? 'none' : 'block';
                document.getElementById('supplierNoDataMessage').style.display = show ? 'none' : 'none';
            }

            function showSupplierNoDataMessage() {
                document.getElementById('supplierTableContainer').style.display = 'none';
                document.getElementById('supplierNoDataMessage').style.display = 'block';
            }

            function showSupplierNoResults() {
                const supplierTableBody = document.getElementById('supplierTableBody');
                supplierTableBody.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center py-4">
                        <i class="bi bi-search display-6 d-block mb-2 text-muted"></i>
                        <p class="text-muted mb-0">Tidak ditemukan supplier dengan kata kunci tersebut</p>
                    </td>
                </tr>
            `;
                document.getElementById('supplierTableContainer').style.display = 'block';
                document.getElementById('supplierNoDataMessage').style.display = 'none';
            }

            function setupSupplierRowClickHandlers() {
                const rows = document.querySelectorAll('.supplier-modal-row');
                const radios = document.querySelectorAll('.supplier-modal-radio');

                rows.forEach(row => {
                    row.addEventListener('click', function(e) {
                        const radio = this.querySelector('.supplier-modal-radio');
                        if (radio && !radio.disabled) {
                            if (e.target.type !== 'radio') {
                                radio.checked = true;
                                handleSupplierSelection(radio.value);
                            }
                        }
                    });

                    row.addEventListener('mouseenter', function() {
                        const radio = this.querySelector('.supplier-modal-radio');
                        if (radio && !radio.disabled && !radio.checked) {
                            this.style.backgroundColor = '#f8f9fa';
                        }
                    });

                    row.addEventListener('mouseleave', function() {
                        const radio = this.querySelector('.supplier-modal-radio');
                        if (radio && !radio.disabled && !radio.checked) {
                            this.style.backgroundColor = '';
                        }
                    });
                });

                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (!this.disabled) {
                            handleSupplierSelection(this.value);
                        }
                    });
                });
            }

            function handleSupplierSelection(nama) {
                selectedSupplierNama = nama;
                document.getElementById('supplierSelectBtn').disabled = false;

                document.querySelectorAll('.supplier-modal-row').forEach(row => {
                    const radio = row.querySelector('.supplier-modal-radio');
                    if (radio && radio.checked && !radio.disabled) {
                        row.style.backgroundColor = '#e7f1ff';
                        row.classList.add('selected');
                    } else {
                        row.style.backgroundColor = '';
                        row.classList.remove('selected');
                    }
                });
            }

            function clearSupplierSelection() {
                supplierDisplay.value = '';
                supplierValue.value = '';
                selectedSupplierNama = '';
                selectedSupplierContainer.style.display = 'none';

                document.querySelectorAll('.supplier-modal-radio').forEach(radio => {
                    radio.checked = false;
                });

                document.querySelectorAll('.supplier-modal-row').forEach(row => {
                    row.style.backgroundColor = '';
                    row.classList.remove('selected');
                });
            }

            // ========== EVENT LISTENERS ==========
            // Satuan
            openSatuanModalBtn.addEventListener('click', function() {
                loadSatuanData();
                const satuanModal = new bootstrap.Modal(document.getElementById('satuanModal'));
                satuanModal.show();
            });

            clearSatuanBtn.addEventListener('click', clearSatuanSelection);

            // Departemen
            openDepartemenModalBtn.addEventListener('click', function() {
                loadDepartemenData();
                const departemenModal = new bootstrap.Modal(document.getElementById('departemenModal'));
                departemenModal.show();
            });

            clearDepartemenBtn.addEventListener('click', clearDepartemenSelection);

            // Supplier
            openSupplierModalBtn.addEventListener('click', function() {
                loadSupplierData();
                const supplierModal = new bootstrap.Modal(document.getElementById('supplierModal'));
                supplierModal.show();
            });

            clearSupplierBtn.addEventListener('click', clearSupplierSelection);

            // Tanggal submit
            tanggalSubmitInput.addEventListener('change', updateSystemInfo);
            setTanggalSekarangBtn.addEventListener('click', setTanggalSekarang);

            // Common
            stokAwalInput.addEventListener('input', updateStokPreview);
            namaBarangInput.addEventListener('input', updateNamaBarangPreview);
            ukuranBarangInput.addEventListener('input', function() {
                updateNamaBarangPreview();
            });

            // Satuan Modal Events
            document.getElementById('satuanSearchInput')?.addEventListener('input', function() {
                renderSatuanTable(satuanData);
            });

            document.getElementById('satuanClearSearchBtn')?.addEventListener('click', function() {
                document.getElementById('satuanSearchInput').value = '';
                renderSatuanTable(satuanData);
            });

            document.getElementById('satuanRefreshBtn')?.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                this.disabled = true;

                loadSatuanData();

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1000);
            });

            document.getElementById('satuanSelectBtn')?.addEventListener('click', function() {
                if (selectedSatuanNama) {
                    satuanDisplay.value = selectedSatuanNama;
                    satuanValue.value = selectedSatuanNama;
                    selectedSatuanContainer.style.display = 'block';
                    selectedSatuanText.textContent = selectedSatuanNama;

                    const satuanModal = bootstrap.Modal.getInstance(document.getElementById('satuanModal'));
                    satuanModal.hide();
                }
            });

            // Departemen Modal Events
            document.getElementById('departemenSearchInput')?.addEventListener('input', function() {
                renderDepartemenTable(departemenData);
            });

            document.getElementById('departemenClearSearchBtn')?.addEventListener('click', function() {
                document.getElementById('departemenSearchInput').value = '';
                renderDepartemenTable(departemenData);
            });

            document.getElementById('departemenRefreshBtn')?.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                this.disabled = true;

                loadDepartemenData();

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1000);
            });

            document.getElementById('departemenSelectBtn')?.addEventListener('click', function() {
                if (selectedDepartemenNama) {
                    departemenDisplay.value = selectedDepartemenNama;
                    departemenValue.value = selectedDepartemenNama;
                    selectedDepartemenContainer.style.display = 'block';
                    selectedDepartemenText.textContent = selectedDepartemenNama;

                    const departemenModal = bootstrap.Modal.getInstance(document.getElementById('departemenModal'));
                    departemenModal.hide();
                }
            });

            // Supplier Modal Events
            document.getElementById('supplierSearchInput')?.addEventListener('input', function() {
                renderSupplierTable(supplierData);
            });

            document.getElementById('supplierClearSearchBtn')?.addEventListener('click', function() {
                document.getElementById('supplierSearchInput').value = '';
                renderSupplierTable(supplierData);
            });

            document.getElementById('supplierRefreshBtn')?.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                this.disabled = true;

                loadSupplierData();

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1000);
            });

            document.getElementById('supplierSelectBtn')?.addEventListener('click', function() {
                if (selectedSupplierNama) {
                    supplierDisplay.value = selectedSupplierNama;
                    supplierValue.value = selectedSupplierNama;
                    selectedSupplierContainer.style.display = 'block';
                    selectedSupplierText.textContent = selectedSupplierNama;

                    const supplierModal = bootstrap.Modal.getInstance(document.getElementById('supplierModal'));
                    supplierModal.hide();
                }
            });

            // Form validation
            document.getElementById('stokForm').addEventListener('submit', function(e) {
                // Validate inputs
                if (!tanggalSubmitInput.value.trim()) {
                    e.preventDefault();
                    alert('Silakan isi tanggal submit!');
                    tanggalSubmitInput.focus();
                    return false;
                }

                if (!satuanValue.value.trim()) {
                    e.preventDefault();
                    alert('Silakan pilih satuan!');
                    openSatuanModalBtn.focus();
                    return false;
                }

                if (!departemenValue.value.trim()) {
                    e.preventDefault();
                    alert('Silakan pilih departemen!');
                    openDepartemenModalBtn.focus();
                    return false;
                }

                if (!supplierValue.value.trim()) {
                    e.preventDefault();
                    alert('Silakan pilih supplier!');
                    openSupplierModalBtn.focus();
                    return false;
                }

                if (!namaBarangInput.value.trim()) {
                    e.preventDefault();
                    alert('Silakan isi nama barang!');
                    namaBarangInput.focus();
                    return false;
                }

                if (!ukuranBarangInput.value.trim()) {
                    e.preventDefault();
                    alert('Silakan isi ukuran barang!');
                    ukuranBarangInput.focus();
                    return false;
                }

                ukuranBarangInput.value = ukuranBarangInput.value.toUpperCase();

                // Show confirmation
                const namaBarang = namaBarangInput.value.trim();
                const ukuranBarang = ukuranBarangInput.value.trim();
                const stokAwal = stokAwalInput.value;
                const departemen = departemenDisplay.value;
                const supplier = supplierDisplay.value;
                const tanggal = tanggalSubmitPreview.textContent;
                const periode = periodePreview.textContent;
                
                if (!confirm(`Apakah Anda yakin ingin menyimpan data ini?\n\n` +
                           `Nama Barang: ${namaBarang} ${ukuranBarang}\n` +
                           `Satuan: ${satuanDisplay.value}\n` +
                           `Departemen: ${departemen}\n` +
                           `Supplier: ${supplier}\n` +
                           `Stok Awal: ${stokAwal}\n` +
                           `Tanggal Submit: ${tanggal}\n` +
                           `Periode: ${periode}\n\n` +
                           `Data akan disimpan ke:\n` +
                           `1. Master Stok (data utama)\n` +
                           `2. Stok Detail untuk bulan ${periode}`)) {
                    e.preventDefault();
                    return false;
                }

                return true;
            });

            // Modal hidden events
            document.getElementById('satuanModal')?.addEventListener('hidden.bs.modal', function() {
                document.getElementById('satuanSearchInput').value = '';
                document.getElementById('satuanSelectBtn').disabled = true;
            });

            document.getElementById('departemenModal')?.addEventListener('hidden.bs.modal', function() {
                document.getElementById('departemenSearchInput').value = '';
                document.getElementById('departemenSelectBtn').disabled = true;
            });

            document.getElementById('supplierModal')?.addEventListener('hidden.bs.modal', function() {
                document.getElementById('supplierSearchInput').value = '';
                document.getElementById('supplierSelectBtn').disabled = true;
            });

            // Initialize
            initialize();
        });
    </script>

    <style>
        .required::after {
            content: " *";
            color: #dc3545;
        }

        .satuan-modal-row,
        .departemen-modal-row,
        .supplier-modal-row {
            cursor: pointer;
            transition: background-color 0.15s ease;
        }

        .satuan-modal-row:hover,
        .departemen-modal-row:hover,
        .supplier-modal-row:hover {
            background-color: #f8f9fa !important;
        }

        .satuan-modal-row.selected,
        .departemen-modal-row.selected,
        .supplier-modal-row.selected {
            background-color: #e7f1ff !important;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .form-check-input:disabled {
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .form-check-label {
            cursor: pointer;
            user-select: none;
        }

        #satuanDisplay,
        #departemenDisplay,
        #supplierDisplay {
            background-color: #fff;
            cursor: pointer;
        }

        #satuanDisplay:focus,
        #departemenDisplay:focus,
        #supplierDisplay:focus {
            box-shadow: none;
        }

        .modal-body {
            min-height: 300px;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .input-group>.form-control:first-child {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group>.form-control:last-child {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-left: 0;
        }

        #ukuranBarangInput {
            text-transform: uppercase;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }

        .input-group-text i {
            color: #6c757d;
        }

        .badge {
            font-size: 0.75em;
            padding: 0.3em 0.6em;
        }
    </style>
@endsection