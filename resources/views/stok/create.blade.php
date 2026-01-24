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

                    <div class="card-body">
                        <form action="{{ route('stok.store') }}" method="POST" id="stokForm">
                            @csrf

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
                                                   value="{{ $kodeBarang }}" 
                                                   readonly
                                                   style="font-weight: bold; color: #0d6efd;">
                                            <input type="hidden" name="kode_barang" value="{{ $kodeBarang }}">
                                            <small class="text-muted">Kode di-generate otomatis oleh sistem</small>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Tanggal Submit</label>
                                            <input type="datetime-local" 
                                                   class="form-control bg-light" 
                                                   id="tanggalSubmitInput"
                                                   readonly
                                                   value="{{ date('Y-m-d\TH:i') }}">
                                            <input type="hidden" name="tanggal_submit" id="tanggalSubmitHidden">
                                            <small class="text-muted">Tanggal otomatis dari sistem</small>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Periode</label>
                                            <div class="input-group">
                                                <input type="text" 
                                                       class="form-control bg-light text-center" 
                                                       id="bulanDisplay"
                                                       readonly>
                                                <input type="text" 
                                                       class="form-control bg-light text-center" 
                                                       id="tahunDisplay"
                                                       readonly>
                                                <input type="hidden" name="bulan" id="bulanHidden">
                                                <input type="hidden" name="tahun" id="tahunHidden">
                                            </div>
                                            <small class="text-muted">Bulan dan tahun otomatis dari sistem</small>
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
                                                   value="{{ old('ukuran_barang') }}"
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
                                                placeholder="Klik untuk memilih satuan" readonly value="{{ old('satuan') }}"
                                                required>
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

                                <!-- Informasi Stok -->
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-calculator me-2"></i>Informasi Stok
                                    </h5>

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

                                    <!-- Hidden fields untuk stok_masuk dan stok_keluar (selalu 0) -->
                                    <input type="hidden" name="stok_masuk" value="0">
                                    <input type="hidden" name="stok_keluar" value="0">
                                    
                                    <!-- Hidden field untuk gabungan nama_barang + ukuran (tidak perlu lagi karena diolah di controller) -->
                                    <input type="hidden" name="nama_barang_gabungan" id="namaBarangGabungan">
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
                        <li><strong>Tanggal Submit:</strong> Menggunakan tanggal dan waktu dari sistem browser Anda</li>
                        <li><strong>Bulan & Tahun:</strong> Mengambil periode saat ini dari sistem</li>
                        <li>Form ini hanya untuk menambahkan barang baru ke sistem</li>
                        <li><strong>Stok masuk dan keluar</strong> diinput melalui menu <strong>"Transaksi Harian"</strong>
                        </li>
                        <li>Stok akan otomatis terupdate setiap ada transaksi</li>
                        <li>Stok akhir bulan akan menjadi stok awal bulan berikutnya saat rollover</li>
                        <li>Untuk menambah satuan baru, silakan gunakan menu <a href="{{ route('satuan.index') }}"
                                class="alert-link">Master Satuan</a></li>
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
            const stokAwalInput = document.getElementById('stokAwalInput');
            const stokAwalPreview = document.getElementById('stokAwalPreview');
            const tanggalSubmitInput = document.getElementById('tanggalSubmitInput');
            const tanggalSubmitHidden = document.getElementById('tanggalSubmitHidden');
            const bulanDisplay = document.getElementById('bulanDisplay');
            const tahunDisplay = document.getElementById('tahunDisplay');
            const bulanHidden = document.getElementById('bulanHidden');
            const tahunHidden = document.getElementById('tahunHidden');
            const namaBarangInput = document.getElementById('namaBarangInput');
            const ukuranBarangInput = document.getElementById('ukuranBarangInput');
            const namaBarangPreview = document.getElementById('namaBarangPreview');

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
            let selectedSatuanNama = '';
            let satuanData = [];

            // Initialize
            function initialize() {
                updateStokPreview();
                updateSystemInfo();
                updateNamaBarangPreview();

                // Load selected satuan from old input
                const oldSatuan = satuanValue.value;
                if (oldSatuan) {
                    selectedSatuanNama = oldSatuan;
                    satuanDisplay.value = oldSatuan;
                    selectedSatuanContainer.style.display = 'block';
                    selectedSatuanText.textContent = oldSatuan;
                }
                
                // Set old values for nama_barang and ukuran_barang if any
                @if(old('nama_barang'))
                    namaBarangInput.value = "{{ old('nama_barang') }}";
                @endif
                
                @if(old('ukuran_barang'))
                    ukuranBarangInput.value = "{{ old('ukuran_barang') }}";
                @endif
                
                updateNamaBarangPreview();
                
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
                
                let previewText = '-';
                
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

            // Update system information
            function updateSystemInfo() {
                // Get current date and time from browser
                const now = new Date();
                
                // Format date for datetime-local input (YYYY-MM-DDTHH:mm)
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                
                const dateTimeString = `${year}-${month}-${day}T${hours}:${minutes}`;
                tanggalSubmitInput.value = dateTimeString;
                tanggalSubmitHidden.value = dateTimeString;
                
                // Get month name
                const monthNames = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                
                const monthName = monthNames[now.getMonth()];
                const currentYear = now.getFullYear();
                
                // Update display
                bulanDisplay.value = monthName;
                tahunDisplay.value = currentYear;
                
                // Update hidden fields
                bulanHidden.value = now.getMonth() + 1; // 1-12
                tahunHidden.value = currentYear;
            }

            // Update stok preview
            function updateStokPreview() {
                const stokAwal = parseFloat(stokAwalInput.value) || 0;
                stokAwalPreview.textContent = stokAwal.toFixed(2);
            }

            // Load satuan data
            function loadSatuanData() {
                showLoading(true);

                // Gunakan route name yang benar
                fetch('{{ route('api.satuan.index') }}', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        // Cek jika response bukan JSON
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

                        // Tampilkan pesan error yang lebih jelas
                        if (error instanceof TypeError) {
                            alert(
                                'Error: Server mengembalikan respons dalam format yang tidak diharapkan. Silakan coba lagi.');
                        }
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

                    // Check if this is the selected satuan
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

                // Setup row click handlers
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

                    // Add hover effect
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

                // Update selected rows style
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

                // Clear any checked radio
                document.querySelectorAll('.satuan-radio').forEach(radio => {
                    radio.checked = false;
                });

                // Clear row selection
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

            stokAwalInput.addEventListener('input', updateStokPreview);
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
                    // Update form fields
                    satuanDisplay.value = selectedSatuanNama;
                    satuanValue.value = selectedSatuanNama;

                    // Update selected satuan display
                    selectedSatuanContainer.style.display = 'block';
                    selectedSatuanText.textContent = selectedSatuanNama;

                    // Close modal
                    satuanModal.hide();
                }
            });

            // Form validation
            document.getElementById('stokForm').addEventListener('submit', function(e) {
                // Update tanggal submit dengan waktu terkini sebelum submit
                updateSystemInfo();
                
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
                
                // Auto uppercase ukuran before submit (for safety)
                ukuranBarangInput.value = ukuranBarangInput.value.toUpperCase();
                
                return true;
            });

            // Modal hidden event
            document.getElementById('satuanModal').addEventListener('hidden.bs.modal', function() {
                // Clear search when modal closes
                modalSearchSatuan.value = '';
                selectSatuanBtn.disabled = true;
            });

            // Auto-update system info every minute
            setInterval(updateSystemInfo, 60000);

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

        .input-group > .form-control:first-child {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group > .form-control:last-child {
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
    </style>
@endsection