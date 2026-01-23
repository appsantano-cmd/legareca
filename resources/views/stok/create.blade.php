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

                            <div class="row">
                                <!-- Informasi Barang -->
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-box me-2"></i>Informasi Barang
                                    </h5>

                                    <div class="mb-3">
                                        <label class="form-label required">Kode Barang</label>
                                        <input type="text" name="kode_barang"
                                            class="form-control @error('kode_barang') is-invalid @enderror"
                                            value="{{ old('kode_barang') }}" placeholder="Contoh: BRG-001" required>
                                        @error('kode_barang')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Kode unik untuk identifikasi barang</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Nama Barang</label>
                                        <input type="text" name="nama_barang"
                                            class="form-control @error('nama_barang') is-invalid @enderror"
                                            value="{{ old('nama_barang') }}" placeholder="Nama lengkap barang" required>
                                        @error('nama_barang')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required">Bulan</label>
                                            <select name="bulan" class="form-select @error('bulan') is-invalid @enderror"
                                                required>
                                                <option value="">Pilih Bulan</option>
                                                @foreach ($bulanList as $key => $bulan)
                                                    <option value="{{ $key }}"
                                                        {{ old('bulan', date('m')) == $key ? 'selected' : '' }}>
                                                        {{ $bulan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('bulan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label required">Tahun</label>
                                            <select name="tahun" class="form-select @error('tahun') is-invalid @enderror"
                                                required>
                                                <option value="">Pilih Tahun</option>
                                                @foreach ($tahunList as $tahun)
                                                    <option value="{{ $tahun }}"
                                                        {{ old('tahun', date('Y')) == $tahun ? 'selected' : '' }}>
                                                        {{ $tahun }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tahun')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

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

                                <!-- Stok Preview -->
                                <div class="col-12">
                                    <div class="stok-preview">
                                        <h6>Info:</h6>
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>
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

                // Load selected satuan from old input
                const oldSatuan = satuanValue.value;
                if (oldSatuan) {
                    selectedSatuanNama = oldSatuan;
                    satuanDisplay.value = oldSatuan;
                    selectedSatuanContainer.style.display = 'block';
                    selectedSatuanText.textContent = oldSatuan;
                }
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
                if (!satuanValue.value.trim()) {
                    e.preventDefault();
                    alert('Silakan pilih satuan!');
                    openSatuanModalBtn.focus();
                    return false;
                }
                return true;
            });

            // Modal hidden event
            document.getElementById('satuanModal').addEventListener('hidden.bs.modal', function() {
                // Clear search when modal closes
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
    </style>
@endsection
