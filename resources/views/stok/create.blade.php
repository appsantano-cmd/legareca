@extends('layouts.master')

@section('title', 'Tambah Stok Baru')

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
                                    <select name="satuan" class="form-select @error('satuan') is-invalid @enderror"
                                        required>
                                        <option value="">Pilih Satuan</option>
                                        <option value="Pcs" {{ old('satuan') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                        <option value="Unit" {{ old('satuan') == 'Unit' ? 'selected' : '' }}>Unit</option>
                                        <option value="Pack" {{ old('satuan') == 'Pack' ? 'selected' : '' }}>Pack</option>
                                        <option value="Box" {{ old('satuan') == 'Box' ? 'selected' : '' }}>Box</option>
                                        <option value="Dus" {{ old('satuan') == 'Dus' ? 'selected' : '' }}>Dus</option>
                                        <option value="Kg" {{ old('satuan') == 'Kg' ? 'selected' : '' }}>Kg</option>
                                        <option value="Liter" {{ old('satuan') == 'Liter' ? 'selected' : '' }}>Liter</option>
                                        <option value="Meter" {{ old('satuan') == 'Meter' ? 'selected' : '' }}>Meter</option>
                                    </select>
                                    @error('satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                        <select name="bulan"
                                            class="form-select @error('bulan') is-invalid @enderror" required>
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
                                        <select name="tahun"
                                            class="form-select @error('tahun') is-invalid @enderror" required>
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
                                        value="{{ old('stok_awal', 0) }}" required>
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
                    <li><strong>Stok masuk dan keluar</strong> diinput melalui menu <strong>"Transaksi Harian"</strong></li>
                    <li>Stok akan otomatis terupdate setiap ada transaksi</li>
                    <li>Stok akhir bulan akan menjadi stok awal bulan berikutnya saat rollover</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Update stok preview
    document.addEventListener('DOMContentLoaded', function() {
        const stokAwalInput = document.querySelector('input[name="stok_awal"]');
        const stokAwalPreview = document.getElementById('stokAwalPreview');
        
        function updateStokPreview() {
            const stokAwal = parseFloat(stokAwalInput.value) || 0;
            stokAwalPreview.textContent = stokAwal.toFixed(2);
        }
        
        stokAwalInput.addEventListener('input', updateStokPreview);
        updateStokPreview(); // Initial update
    });
</script>
@endsection