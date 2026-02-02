@extends('layouts.master')

@section('title', 'EDIT DATA STOK')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-pencil me-2"></i>Edit Data Stok
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('stok.update', $stok->id) }}" method="POST" id="stokForm">
                            @csrf
                            @method('PUT')

                            <!-- Informasi Sistem (Readonly) -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-info-circle me-2"></i>Informasi Sistem
                                    </h5>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Kode Barang</label>
                                            <input type="text" 
                                                   class="form-control bg-light" 
                                                   value="{{ $stok->kode_barang }}" 
                                                   readonly
                                                   style="font-weight: bold; color: #0d6efd;">
                                            <input type="hidden" name="kode_barang" value="{{ $stok->kode_barang }}">
                                            <small class="text-muted">Kode tidak dapat diubah</small>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Tanggal Submit</label>
                                            <input type="datetime-local" 
                                                   class="form-control bg-light" 
                                                   value="{{ \Carbon\Carbon::parse($stok->tanggal_submit)->format('Y-m-d\TH:i') }}" 
                                                   readonly>
                                            <small class="text-muted">Tanggal submit awal</small>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Periode</label>
                                            <div class="input-group">
                                                @php
                                                    $bulanList = [
                                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 
                                                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                                                        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                                    ];
                                                @endphp
                                                <input type="text" 
                                                       class="form-control bg-light text-center" 
                                                       value="{{ $bulanList[$stok->bulan] ?? $stok->bulan }}" 
                                                       readonly>
                                                <input type="text" 
                                                       class="form-control bg-light text-center" 
                                                       value="{{ $stok->tahun }}" 
                                                       readonly>
                                            </div>
                                            <small class="text-muted">Periode tidak dapat diubah</small>
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
                                            value="{{ old('nama_barang', $namaBarang) }}" 
                                            placeholder="Contoh: Marie Regal, Tepung Terigu, Gula Pasir"
                                            required
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
                                            <input type="text" 
                                                   name="ukuran_barang"
                                                   class="form-control @error('ukuran_barang') is-invalid @enderror"
                                                   value="{{ old('ukuran_barang', $ukuranBarang) }}"
                                                   placeholder="Contoh: 1 KG, 500 GR, 250 ML"
                                                   required
                                                   id="ukuranBarangInput"
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
                                                value="{{ old('satuan', $stok->satuan) }}"
                                                required>
                                            <input type="hidden" name="satuan" id="satuanValue"
                                                value="{{ old('satuan', $stok->satuan) }}">
                                            <button class="btn btn-outline-primary" type="button" id="openSatuanModal">
                                                <i class="bi bi-search me-1"></i>Pilih Satuan
                                            </button>
                                        </div>

                                        <!-- Selected Satuan -->
                                        <div class="mt-2" id="selectedSatuanContainer"
                                            style="display: {{ old('satuan', $stok->satuan) ? 'block' : 'none' }};">
                                            <div
                                                class="alert alert-info py-2 mb-0 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi bi-check-circle me-2"></i>
                                                    Satuan dipilih: <strong
                                                        id="selectedSatuanText">{{ old('satuan', $stok->satuan) }}</strong>
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
                                        <label class="form-label">Departemen</label>
                                        <input type="text" name="departemen"
                                            class="form-control @error('departemen') is-invalid @enderror"
                                            value="{{ old('departemen', $masterStok->departemen ?? $stok->departemen) }}"
                                            placeholder="Contoh: Gudang Utama, Produksi, Retail">
                                        @error('departemen')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Departemen tempat barang disimpan (opsional)</small>
                                    </div>

                                    <!-- Supplier -->
                                    <div class="mb-3">
                                        <label class="form-label">Supplier</label>
                                        <input type="text" name="supplier"
                                            class="form-control @error('supplier') is-invalid @enderror"
                                            value="{{ old('supplier', $masterStok->supplier ?? $stok->supplier) }}"
                                            placeholder="Contoh: PT. Supplier ABC, CV. Jaya Makmur">
                                        @error('supplier')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Pemasok barang (opsional)</small>
                                    </div>

                                    <!-- Stok Awal -->
                                    <div class="mb-3">
                                        <label class="form-label required">Stok Awal Bulan</label>
                                        <input type="number" name="stok_awal" step="0.01" min="0"
                                            class="form-control @error('stok_awal') is-invalid @enderror"
                                            value="{{ old('stok_awal', $stok->stok_awal) }}" required id="stokAwalInput">
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
                                            placeholder="Tambahkan catatan jika diperlukan">{{ old('keterangan', $stok->keterangan) }}</textarea>
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
                                                    <span id="namaBarangPreview">{{ $stok->nama_barang }}</span>
                                                    <br>
                                                    <small class="text-muted">Ini yang akan disimpan di database</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Info Update -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <strong>Data akan diupdate di:</strong><br>
                                            <span class="badge bg-primary">Master Stok</span> dan 
                                            <span class="badge bg-success">Stok Detail (Bulan {{ $bulanList[$stok->bulan] ?? $stok->bulan }} {{ $stok->tahun }})</span>
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
                                    <i class="bi bi-save me-2"></i>Update Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="alert alert-info mt-3">
                    <h6><i class="bi bi-info-circle me-2"></i>Informasi Edit</h6>
                    <ul class="mb-0">
                        <li><strong>Kode Barang:</strong> Tidak dapat diubah karena merupakan identifier unik</li>
                        <li><strong>Nama Barang & Ukuran:</strong> Pisahkan antara nama produk dan ukuran</li>
                        <li><strong>Ukuran:</strong> Akan otomatis diubah menjadi UPPERCASE (contoh: 1 KG, 500 GR)</li>
                        <li><strong>Departemen & Supplier:</strong> Data tambahan untuk master stok (bisa dikosongkan)</li>
                        <li><strong>Stok Awal:</strong> Hanya stok awal yang dapat diubah. Stok masuk dan keluar diupdate melalui transaksi</li>
                        <li><strong>Perubahan akan diterapkan ke:</strong> Master Stok dan semua data detail yang terkait</li>
                        <li>Data akan diupdate di <strong>Master Stok</strong> dan <strong>Stok Detail Bulanan</strong></li>
                        <li>Untuk transaksi harian (stok masuk/keluar), gunakan menu <strong>"Transaksi Harian"</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Memilih Satuan (sama seperti di create) -->
    <div class="modal fade" id="satuanModal" tabindex="-1" aria-labelledby="satuanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="satuanModalLabel">
                        <i class="bi bi-list-ul me-2"></i>Pilih Satuan
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
                                <input type="text" class="form-control" id="modalSearchSatuan"
                                    placeholder="Cari satuan...">
                                <button class="btn btn-outline-secondary" type="button" id="clearSearchBtn">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-primary w-100" id="refreshSatuanList">
                                <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Loading Spinner -->
                    <div class="text-center py-4" id="loadingSpinner">
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
                    <div class="text-center py-5" id="noDataMessage" style="display: none;">
                        <i class="bi bi-inbox display-6 d-block mb-3 text-muted"></i>
                        <h5 class="text-muted mb-2">Tidak ada data satuan</h5>
                        <p class="text-muted mb-3">Silakan tambahkan satuan terlebih dahulu melalui menu <a
                                href="{{ route('satuan.index') }}">Master Satuan</a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="selectSatuanBtn" disabled>Pilih Satuan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const satuanDisplay = document.getElementById('satuanDisplay');
            const satuanValue = document.getElementById('satuanValue');
            const openSatuanModalBtn = document.getElementById('openSatuanModal');
            const selectedSatuanContainer = document.getElementById('selectedSatuanContainer');
            const selectedSatuanText = document.getElementById('selectedSatuanText');
            const clearSatuanBtn = document.getElementById('clearSatuanBtn');
            const namaBarangInput = document.getElementById('namaBarangInput');
            const ukuranBarangInput = document.getElementById('ukuranBarangInput');
            const namaBarangPreview = document.getElementById('namaBarangPreview');
            const stokAwalInput = document.getElementById('stokAwalInput');
            const departemenInput = document.querySelector('input[name="departemen"]');
            const supplierInput = document.querySelector('input[name="supplier"]');

            // Modal elements
            const satuanModal = new bootstrap.Modal(document.getElementById('satuanModal'));
            const modalSearchSatuan = document.getElementById('modalSearchSatuan');
            const clearSearchBtn = document.getElementById('clearSearchBtn');
            const refreshSatuanListBtn = document.getElementById('refreshSatuanList');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const satuanTableContainer = document.getElementById('satuanTableContainer');
            const satuanTableBody = document.getElementById('satuanTableBody');
            const noDataMessage = document.getElementById('noDataMessage');
            const selectSatuanBtn = document.getElementById('selectSatuanBtn');

            // Variables
            let selectedSatuanNama = '{{ old('satuan', $stok->satuan) }}';
            let satuanData = [];

            // Initialize
            function initialize() {
                updateNamaBarangPreview();
                
                // Load selected satuan
                if (selectedSatuanNama) {
                    satuanDisplay.value = selectedSatuanNama;
                    selectedSatuanContainer.style.display = 'block';
                    selectedSatuanText.textContent = selectedSatuanNama;
                }

                // Focus on nama barang input
                namaBarangInput.focus();
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

                let previewText = '{{ $stok->nama_barang }}';
                
                if (namaBarang && ukuranBarang) {
                    // Format: "Nama Barang UKURAN"
                    previewText = `${namaBarang} ${ukuranBarang}`;
                } else if (namaBarang) {
                    previewText = `${namaBarang} [Belum ada ukuran]`;
                } else if (ukuranBarang) {
                    previewText = `[Belum ada nama barang] ${ukuranBarang}`;
                }

                namaBarangPreview.textContent = previewText;
            }

            // Load satuan data
            function loadSatuanData() {
                showLoading(true);

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
                        showLoading(false);
                    })
                    .catch(error => {
                        console.error('Error loading satuan:', error);
                        showLoading(false);
                        showNoDataMessage();
                    });
            }

            // Render satuan table
            function renderSatuanTable(data) {
                satuanTableBody.innerHTML = '';

                if (data.length === 0) {
                    showNoDataMessage();
                    return;
                }

                const filteredData = filterSatuanData(data);

                if (filteredData.length === 0) {
                    showNoResults();
                    return;
                }

                filteredData.forEach(satuan => {
                    const row = document.createElement('tr');
                    row.className = 'satuan-row';
                    row.setAttribute('data-nama', satuan.nama_satuan);

                    const isSelected = selectedSatuanNama === satuan.nama_satuan;

                    row.innerHTML = `
                    <td class="text-center align-middle">
                        <div class="form-check">
                            <input class="form-check-input satuan-radio" 
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

                satuanTableContainer.style.display = 'block';
                noDataMessage.style.display = 'none';

                setupRowClickHandlers();
            }

            // Filter satuan data
            function filterSatuanData(data) {
                const searchTerm = modalSearchSatuan.value.toLowerCase();
                if (!searchTerm) return data;

                return data.filter(satuan =>
                    satuan.nama_satuan.toLowerCase().includes(searchTerm)
                );
            }

            // Show loading state
            function showLoading(show) {
                loadingSpinner.style.display = show ? 'block' : 'none';
                satuanTableContainer.style.display = show ? 'none' : 'block';
                noDataMessage.style.display = show ? 'none' : 'none';
            }

            // Show no data message
            function showNoDataMessage() {
                satuanTableContainer.style.display = 'none';
                noDataMessage.style.display = 'block';
            }

            // Show no results
            function showNoResults() {
                satuanTableBody.innerHTML = `
                <tr>
                    <td colspan="2" class="text-center py-4">
                        <i class="bi bi-search display-6 d-block mb-2 text-muted"></i>
                        <p class="text-muted mb-0">Tidak ditemukan satuan dengan kata kunci tersebut</p>
                    </td>
                </tr>
            `;
                satuanTableContainer.style.display = 'block';
                noDataMessage.style.display = 'none';
            }

            // Setup row click handlers
            function setupRowClickHandlers() {
                const rows = document.querySelectorAll('.satuan-row');
                const radios = document.querySelectorAll('.satuan-radio');

                rows.forEach(row => {
                    row.addEventListener('click', function(e) {
                        if (e.target.type !== 'radio') {
                            const radio = this.querySelector('.satuan-radio');
                            if (radio) {
                                radio.checked = true;
                                handleSatuanSelection(radio.value);
                            }
                        }
                    });

                    row.addEventListener('mouseenter', function() {
                        if (!this.querySelector('.satuan-radio:checked')) {
                            this.style.backgroundColor = '#f8f9fa';
                        }
                    });

                    row.addEventListener('mouseleave', function() {
                        if (!this.querySelector('.satuan-radio:checked')) {
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

            // Handle satuan selection
            function handleSatuanSelection(nama) {
                selectedSatuanNama = nama;
                selectSatuanBtn.disabled = false;

                document.querySelectorAll('.satuan-row').forEach(row => {
                    const radio = row.querySelector('.satuan-radio');
                    if (radio && radio.checked) {
                        row.style.backgroundColor = '#e7f1ff';
                        row.classList.add('selected');
                    } else {
                        row.style.backgroundColor = '';
                        row.classList.remove('selected');
                    }
                });
            }

            // Clear satuan selection
            function clearSatuanSelection() {
                satuanDisplay.value = '';
                satuanValue.value = '';
                selectedSatuanNama = '';
                selectedSatuanContainer.style.display = 'none';

                document.querySelectorAll('.satuan-radio').forEach(radio => {
                    radio.checked = false;
                });

                document.querySelectorAll('.satuan-row').forEach(row => {
                    row.style.backgroundColor = '';
                    row.classList.remove('selected');
                });
            }

            // Event Listeners
            openSatuanModalBtn.addEventListener('click', function() {
                loadSatuanData();
                satuanModal.show();
            });

            clearSatuanBtn.addEventListener('click', function() {
                clearSatuanSelection();
            });

            namaBarangInput.addEventListener('input', updateNamaBarangPreview);
            ukuranBarangInput.addEventListener('input', function() {
                updateNamaBarangPreview();
            });

            // Modal search
            modalSearchSatuan.addEventListener('input', function() {
                renderSatuanTable(satuanData);
            });

            clearSearchBtn.addEventListener('click', function() {
                modalSearchSatuan.value = '';
                renderSatuanTable(satuanData);
            });

            refreshSatuanListBtn.addEventListener('click', function() {
                const originalText = refreshSatuanListBtn.innerHTML;
                refreshSatuanListBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                refreshSatuanListBtn.disabled = true;

                loadSatuanData();

                setTimeout(() => {
                    refreshSatuanListBtn.innerHTML = originalText;
                    refreshSatuanListBtn.disabled = false;
                }, 1000);
            });

            selectSatuanBtn.addEventListener('click', function() {
                if (selectedSatuanNama) {
                    satuanDisplay.value = selectedSatuanNama;
                    satuanValue.value = selectedSatuanNama;

                    selectedSatuanContainer.style.display = 'block';
                    selectedSatuanText.textContent = selectedSatuanNama;

                    satuanModal.hide();
                }
            });

            // Form validation
            document.getElementById('stokForm').addEventListener('submit', function(e) {
                // Validate inputs
                if (!satuanValue.value.trim()) {
                    e.preventDefault();
                    alert('Silakan pilih satuan!');
                    openSatuanModalBtn.focus();
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

                // Auto uppercase ukuran before submit
                ukuranBarangInput.value = ukuranBarangInput.value.toUpperCase();

                // Show confirmation
                const namaBarang = namaBarangInput.value.trim();
                const ukuranBarang = ukuranBarangInput.value.trim();
                const stokAwal = stokAwalInput.value;
                const departemen = departemenInput.value || '-';
                const supplier = supplierInput.value || '-';
                
                if (!confirm(`Apakah Anda yakin ingin mengupdate data ini?\n\n` +
                           `Kode: {{ $stok->kode_barang }}\n` +
                           `Nama Barang: ${namaBarang} ${ukuranBarang}\n` +
                           `Stok Awal: ${stokAwal}\n` +
                           `Departemen: ${departemen}\n` +
                           `Supplier: ${supplier}\n\n` +
                           `Perubahan akan diterapkan ke:\n` +
                           `1. Master Stok (data utama)\n` +
                           `2. Semua data detail stok yang terkait\n\n` +
                           `Catatan: Perubahan pada nama barang akan mempengaruhi semua data historis`)) {
                    e.preventDefault();
                    return false;
                }

                return true;
            });

            // Modal hidden event
            document.getElementById('satuanModal').addEventListener('hidden.bs.modal', function() {
                modalSearchSatuan.value = '';
                selectSatuanBtn.disabled = true;
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

        .satuan-row {
            cursor: pointer;
            transition: background-color 0.15s ease;
        }

        .satuan-row:hover {
            background-color: #f8f9fa !important;
        }

        .satuan-row.selected {
            background-color: #e7f1ff !important;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .form-check-label {
            cursor: pointer;
            user-select: none;
        }

        #satuanDisplay {
            background-color: #fff;
            cursor: pointer;
        }

        #satuanDisplay:focus {
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