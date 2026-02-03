<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT TRANSAKSI STOK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .card-header {
            background: linear-gradient(135deg, #ffd900 0%, #ffd900 100%);
            color: white;
        }

        .required:after {
            content: " *";
            color: #dc3545;
        }

        .info-box {
            background-color: #ffffff;
            border-left: 4px solid #ffe100;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .transaction-info {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-label {
            font-weight: 600;
            color: #000000;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1.1rem;
            color: #000000;
        }

        .badge-masuk {
            background-color: #04ff00;
        }

        .badge-keluar {
            background-color: #ff0019;
        }

        .readonly-field {
            background-color: #f8f9fa !important;
            cursor: not-allowed;
        }

        .form-control:read-only,
        .form-control:disabled {
            background-color: #f8f9fa !important;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-pencil-square me-2"></i>Edit Transaksi Stok
                        </h4>
                    </div>

                    <div class="card-body">
                        <!-- Info Transaksi -->
                        <div class="info-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="transaction-info">
                                        <div class="info-label">Tipe Transaksi</div>
                                        <div class="info-value">
                                            <span
                                                class="badge bg-{{ $transaction->tipe == 'masuk' ? 'success' : 'danger' }} text-white">
                                                {{ $transaction->tipe == 'masuk' ? 'STOK MASUK' : 'STOK KELUAR' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="transaction-info">
                                        <div class="info-label">Barang</div>
                                        <div class="info-value">
                                            <strong>{{ $transaction->nama_barang }}</strong><br>
                                            <small class="text-muted">Kode: {{ $transaction->kode_barang }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Hidden fields untuk data yang tidak boleh diubah -->
                            <input type="hidden" name="kode_barang" value="{{ $transaction->kode_barang }}">
                            <input type="hidden" name="tipe" value="{{ $transaction->tipe }}">
                            <!-- Kirim departemen untuk semua tipe -->
                            <input type="hidden" name="departemen" value="{{ $transaction->departemen ?? '' }}">
                            
                            @if($transaction->tipe == 'keluar')
                                <!-- Untuk stok keluar, kirim keperluan sebagai hidden -->
                                <input type="hidden" name="keperluan" value="{{ $transaction->keperluan }}">
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Tanggal (readonly) -->
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Transaksi</label>
                                        <input type="date" class="form-control readonly-field" 
                                            value="{{ $transaction->tanggal->format('Y-m-d') }}" readonly>
                                        <small class="text-muted">Tanggal transaksi tidak dapat diubah</small>
                                    </div>

                                    <!-- Kode Barang (readonly) -->
                                    <div class="mb-3">
                                        <label class="form-label">Kode Barang</label>
                                        <input type="text" class="form-control readonly-field" 
                                            value="{{ $transaction->kode_barang }} - {{ $transaction->nama_barang }}" readonly>
                                    </div>

                                    <!-- Tipe Transaksi (readonly) -->
                                    <div class="mb-3">
                                        <label class="form-label">Tipe Transaksi</label>
                                        <input type="text" class="form-control readonly-field" 
                                            value="{{ $transaction->tipe == 'masuk' ? 'Stok Masuk' : 'Stok Keluar' }}" readonly>
                                    </div>

                                    <!-- Departemen (readonly untuk semua tipe) -->
                                    <div class="mb-3">
                                        <label class="form-label">Departemen</label>
                                        <input type="text" class="form-control readonly-field" 
                                            value="{{ $transaction->departemen ?? 'Tidak ada departemen' }}" readonly>
                                        <small class="text-muted">Departemen tidak dapat diubah</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Jumlah (bisa diubah) -->
                                    <div class="mb-3">
                                        <label class="form-label required">Jumlah</label>
                                        <input type="number" name="jumlah" class="form-control" step="0.01"
                                            min="0.01" required value="{{ old('jumlah', $transaction->jumlah) }}">
                                        @error('jumlah')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                        @if ($transaction->tipe == 'keluar')
                                            @php
                                                $stokTersedia = $barangList->firstWhere('kode_barang', $transaction->kode_barang)->stok_akhir ?? 0;
                                                $stokSetelahKembali = $stokTersedia + $transaction->jumlah;
                                            @endphp
                                        @endif
                                    </div>

                                    <!-- Supplier (ditampilkan untuk semua tipe, readonly) -->
                                    <div class="mb-3">
                                        <label class="form-label">Supplier</label>
                                        @if ($transaction->tipe == 'masuk')
                                            <!-- Untuk stok masuk: tampilkan input supplier readonly -->
                                            <input type="text" name="supplier" class="form-control readonly-field"
                                                value="{{ old('supplier', $transaction->supplier) }}" readonly
                                                placeholder="Supplier">
                                            <small class="text-muted">Supplier tidak dapat diubah untuk transaksi stok masuk</small>
                                        @else
                                            <!-- Untuk stok keluar: tampilkan supplier jika ada -->
                                            <input type="text" class="form-control readonly-field" 
                                                value="{{ $transaction->supplier ?? 'Tidak ada supplier' }}" readonly>
                                            <small class="text-muted">Supplier diambil dari data barang</small>
                                        @endif
                                        @error('supplier')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if ($transaction->tipe == 'keluar')
                                        <!-- Keperluan (hanya untuk stok keluar, readonly) -->
                                        <div class="mb-3">
                                            <label class="form-label">Keperluan</label>
                                            <input type="text" class="form-control readonly-field" 
                                                value="{{ $transaction->keperluan }}" readonly>
                                            <small class="text-muted">Keperluan tidak dapat diubah</small>
                                        </div>
                                    @endif

                                    <!-- Nama Penerima Barang (bisa diubah) -->
                                    <div class="mb-3">
                                        <label class="form-label required">Nama Penerima Barang</label>
                                        <input type="text" name="nama_penerima" class="form-control"
                                            value="{{ old('nama_penerima', $transaction->nama_penerima) }}" required
                                            placeholder="Masukkan nama penerima barang">
                                        @error('nama_penerima')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Keterangan (bisa diubah) -->
                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Tambahkan keterangan (opsional)">{{ old('keterangan', $transaction->keterangan) }}</textarea>
                                        @error('keterangan')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning mt-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Perhatian:</strong> 
                                <ul class="mb-0 mt-2">
                                    <li>Hanya <strong>jumlah, nama penerima, dan keterangan</strong> yang dapat diubah.</li>
                                    <li>Untuk transaksi <strong>stok masuk</strong>: Supplier tidak dapat diubah.</li>
                                    <li>Untuk transaksi <strong>stok keluar</strong>: Supplier dan keperluan tidak dapat diubah.</li>
                                    <li>Departemen tidak dapat diubah untuk semua tipe transaksi.</li>
                                    <li>Mengubah jumlah akan mempengaruhi stok barang. Pastikan data yang diinput sudah benar.</li>
                                </ul>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                                <div>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Update stok info when jumlah is changed
        document.querySelector('input[name="jumlah"]').addEventListener('input', function() {
            @if($transaction->tipe == 'keluar')
                const currentJumlah = {{ $transaction->jumlah }};
                const newJumlah = parseFloat(this.value) || 0;
                const stokSetelahKembali = {{ $stokSetelahKembali }};
                const stokTersedia = stokSetelahKembali - currentJumlah + newJumlah;
                
                const stokInfo = document.getElementById('stokTersediaInfo');
                stokInfo.textContent = stokTersedia.toFixed(2);
                
                if (newJumlah > stokTersedia) {
                    stokInfo.classList.remove('text-success');
                    stokInfo.classList.add('text-danger');
                    this.classList.add('is-invalid');
                } else {
                    stokInfo.classList.remove('text-danger');
                    stokInfo.classList.add('text-success');
                    this.classList.remove('is-invalid');
                }
            @endif
        });

        // Validate form on submit
        document.querySelector('form').addEventListener('submit', function(e) {
            @if($transaction->tipe == 'keluar')
                const jumlah = parseFloat(document.querySelector('input[name="jumlah"]').value) || 0;
                const stokSetelahKembali = {{ $stokSetelahKembali }};
                const currentJumlah = {{ $transaction->jumlah }};
                const stokTersedia = stokSetelahKembali - currentJumlah + jumlah;
                
                if (jumlah > stokTersedia) {
                    e.preventDefault();
                    alert('Jumlah melebihi stok tersedia! Stok tersedia: ' + stokTersedia.toFixed(2));
                    return false;
                }
            @endif
            
            return true;
        });
    </script>
</body>

</html>