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

                                <!-- Informasi Stok -->
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2 mb-3">
                                        <i class="bi bi-calculator me-2"></i>Informasi Stok
                                    </h5>

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
            </div>
        </div>
    </div>

    <!-- Modal untuk Memilih Satuan (sama seperti di create) -->
    <div class="modal fade" id="satuanModal" tabindex="-1" aria-labelledby="satuanModalLabel" aria-hidden="true">
        <!-- Konten modal sama dengan di create.blade.php -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const namaBarangInput = document.getElementById('namaBarangInput');
            const ukuranBarangInput = document.getElementById('ukuranBarangInput');
            const namaBarangPreview = document.getElementById('namaBarangPreview');
            
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
            
            // Event listeners
            namaBarangInput.addEventListener('input', updateNamaBarangPreview);
            ukuranBarangInput.addEventListener('input', function() {
                updateNamaBarangPreview();
            });
            
            // Initialize preview
            updateNamaBarangPreview();
        });
    </script>

    <style>
        .required::after {
            content: " *";
            color: #dc3545;
        }

        #ukuranBarangInput {
            text-transform: uppercase;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }
    </style>
@endsection