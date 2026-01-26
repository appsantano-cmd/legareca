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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Tanggal Transaksi</label>
                                        <input type="date" name="tanggal" class="form-control"
                                            value="{{ old('tanggal', $transaction->tanggal->format('Y-m-d')) }}"
                                            required>
                                        @error('tanggal')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Kode Barang</label>
                                        <select name="kode_barang" class="form-select" required>
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach ($barangList as $barang)
                                                <option value="{{ $barang->kode_barang }}"
                                                    {{ old('kode_barang', $transaction->kode_barang) == $barang->kode_barang ? 'selected' : '' }}>
                                                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                                                    (Stok: {{ number_format($barang->stok_akhir, 2) }}
                                                    {{ $barang->satuan }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kode_barang')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Jumlah</label>
                                        <input type="number" name="jumlah" class="form-control" step="0.01"
                                            min="0.01" required value="{{ old('jumlah', $transaction->jumlah) }}">
                                        @error('jumlah')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                        @if ($transaction->tipe == 'keluar')
                                            <small class="text-muted">
                                                Stok tersedia:
                                                @php
                                                    $stokTersedia =
                                                        $barangList->firstWhere(
                                                            'kode_barang',
                                                            $transaction->kode_barang,
                                                        )->stok_akhir ?? 0;
                                                    $stokSetelahKembali = $stokTersedia + $transaction->jumlah;
                                                @endphp
                                                <span
                                                    class="{{ $stokSetelahKembali < old('jumlah', $transaction->jumlah) ? 'text-danger' : 'text-success' }}">
                                                    {{ number_format($stokSetelahKembali, 2) }}
                                                </span>
                                            </small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    @if ($transaction->tipe == 'masuk')
                                        <div class="mb-3">
                                            <label class="form-label required">Supplier</label>
                                            <input type="text" name="supplier" class="form-control"
                                                value="{{ old('supplier', $transaction->supplier) }}" required
                                                placeholder="Masukkan nama supplier">
                                            @error('supplier')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">
                                                Supplier yang sering digunakan:
                                                @foreach ($supplierList as $supplier)
                                                    @if ($loop->index < 5)
                                                        <span class="badge bg-light text-dark me-1 cursor-pointer"
                                                            onclick="document.querySelector('input[name=\"supplier\"]').value='{{ $supplier }}'">
                                                            {{ $supplier }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </small>
                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <label class="form-label required">Departemen</label>
                                            <div class="d-flex gap-2">
                                                <input type="text" name="departemen" class="form-control"
                                                    value="{{ old('departemen', $transaction->departemen) }}"
                                                    placeholder="Pilih departemen" readonly required>
                                                <button type="button" class="btn btn-outline-primary"
                                                    id="btnPilihDepartemen">
                                                    <i class="bi bi-search"></i> Pilih
                                                </button>
                                            </div>
                                            @error('departemen')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label required">Keperluan</label>
                                            <input type="text" name="keperluan" class="form-control"
                                                value="{{ old('keperluan', $transaction->keperluan) }}" required
                                                placeholder="Masukkan keperluan">
                                            @error('keperluan')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label required">Nama Penerima Barang</label>
                                        <input type="text" name="nama_penerima" class="form-control"
                                            value="{{ old('nama_penerima', $transaction->nama_penerima) }}" required
                                            placeholder="Masukkan nama penerima barang">
                                        @error('nama_penerima')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

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
                                <strong>Perhatian:</strong> Mengubah transaksi akan mempengaruhi stok barang. Pastikan
                                data yang diinput sudah benar.
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
                        <input type="text" id="searchDepartemen" class="form-control modal-departemen-search-input"
                            placeholder="Cari departemen...">
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
        const departemenModal = new bootstrap.Modal(document.getElementById('departemenModal'));
        const departemenTableBody = document.getElementById('departemenTableBody');
        const departemenCountSpan = document.getElementById('departemenCount');
        const searchDepartemenInput = document.getElementById('searchDepartemen');
        const btnPilihDepartemen = document.getElementById('btnPilihDepartemen');
        const departemenInput = document.querySelector('input[name="departemen"]');
        const departemenRowTemplate = document.getElementById('departemenRowTemplate');
        
        let departemenList = @json($departemenList ?? []);

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
            departemenInput.value = departemen;
            departemenModal.hide();
        }

        // Event listener untuk tombol pilih departemen
        btnPilihDepartemen.addEventListener('click', function() {
            loadDepartemenList();
            departemenModal.show();
        });

        // Event listener untuk pencarian departemen
        searchDepartemenInput.addEventListener('input', searchDepartemen);

        // Update stok info when barang is changed
        document.querySelector('select[name="kode_barang"]').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const stokInfo = selectedOption.text.match(/Stok: ([\d.,]+)/);
            if (stokInfo && {{ $transaction->tipe == 'keluar' ? 'true' : 'false' }}) {
                const stokTersedia = parseFloat(stokInfo[1].replace(',', ''));
                const jumlahInput = document.querySelector('input[name="jumlah"]');
                const jumlah = parseFloat(jumlahInput.value) || 0;

                // Update validation message
                if (jumlah > stokTersedia) {
                    jumlahInput.classList.add('is-invalid');
                    // You can add a custom validation message here
                } else {
                    jumlahInput.classList.remove('is-invalid');
                }
            }
        });

        // Validate jumlah on input
        document.querySelector('input[name="jumlah"]').addEventListener('input', function() {
            if ({{ $transaction->tipe == 'keluar' ? 'true' : 'false' }}) {
                const selectedBarang = document.querySelector('select[name="kode_barang"]').value;
                if (selectedBarang) {
                    const selectedOption = document.querySelector('select[name="kode_barang"] option:checked');
                    const stokInfo = selectedOption.text.match(/Stok: ([\d.,]+)/);
                    if (stokInfo) {
                        const stokTersedia = parseFloat(stokInfo[1].replace(',', ''));
                        const jumlah = parseFloat(this.value) || 0;

                        if (jumlah > stokTersedia) {
                            this.classList.add('is-invalid');
                        } else {
                            this.classList.remove('is-invalid');
                        }
                    }
                }
            }
        });

        // Initialize departemen list
        document.addEventListener('DOMContentLoaded', function() {
            // Pre-populate departemen list if needed
            if (departemenList.length === 0) {
                // Fallback to default list if no data from controller
                departemenList = [
                    'Produksi',
                    'Gudang',
                    'Logistik',
                    'IT',
                    'HRD',
                    'Keuangan',
                    'Marketing',
                    'Maintenance',
                    'Lainnya'
                ];
            }
        });
    </script>
</body>

</html>