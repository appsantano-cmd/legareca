<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi Stok</title>
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
        }
        
        .barang-item-card {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
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

                                    <div class="mb-3">
                                        <label class="form-label required">Tanggal Transaksi</label>
                                        <input type="date" name="tanggal" class="form-control"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>

                                    <!-- Supplier Global untuk Stok Masuk -->
                                    <div id="masukFields" class="conditional-field">
                                        <div class="mb-3">
                                            <label class="form-label required">Supplier Global</label>
                                            <input type="text" name="supplier_global" id="supplier_global" 
                                                   class="form-control" 
                                                   required 
                                                   disabled
                                                   placeholder="Masukkan nama supplier global">
                                            <small class="text-muted">Supplier ini akan diterapkan ke semua barang. Kosongkan jika ingin menggunakan supplier berbeda untuk setiap barang.</small>
                                        </div>
                                    </div>

                                    <!-- Field khusus Stok Keluar -->
                                    <div id="keluarFields" class="conditional-field">
                                        <div class="mb-3">
                                            <label class="form-label required">Departemen</label>
                                            <select name="departemen" id="departemen" class="form-select" required disabled>
                                                <option value="">-- Pilih Departemen --</option>
                                                @foreach($departemenList as $departemen)
                                                    <option value="{{ $departemen }}">{{ $departemen }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required">Keperluan</label>
                                            <input type="text" name="keperluan" id="keperluan"
                                                   class="form-control"
                                                   required
                                                   disabled
                                                   placeholder="Masukkan keperluan">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Nama Penerima Barang</label>
                                        <input type="text" name="nama_penerima" class="form-control"
                                            value="{{ old('nama_penerima') }}" required
                                            placeholder="Masukkan nama penerima barang">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <textarea name="keterangan" rows="4" class="form-control" 
                                            placeholder="Tambahkan keterangan transaksi (opsional)">{{ old('keterangan') }}</textarea>
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

                                    <!-- Bagian Informasi (tidak dihapus) -->
                                    <div class="alert alert-info">
                                        <h6><i class="bi bi-info-circle me-2"></i>Informasi</h6>
                                        <ul class="mb-0 small">
                                            <li><strong>Pilih Tipe:</strong> Pilih Stok Masuk atau Stok Keluar terlebih dahulu</li>
                                            <li><strong>Tambah Barang:</strong> Klik tombol "Tambah Barang" untuk menambah barang ke daftar</li>
                                            <li><strong>Stok Masuk:</strong> Supplier bisa diisi global atau per barang</li>
                                            <li><strong>Stok Keluar:</strong> Departemen dan Keperluan wajib diisi</li>
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

                <!-- Info Box Penting (tidak dihapus) -->
                <div class="alert alert-info mt-3">
                    <h6><i class="bi bi-info-circle me-2"></i>Informasi Penting</h6>
                    <ul class="mb-0">
                        <li>Transaksi <strong>Stok Masuk</strong> akan menambah stok barang</li>
                        <li>Transaksi <strong>Stok Keluar</strong> akan mengurangi stok barang</li>
                        <li>Pastikan jumlah stok keluar tidak melebihi stok tersedia</li>
                        <li>Transaksi akan langsung mempengaruhi stok barang</li>
                        <li>Klik tombol "Tambah Barang" untuk menambah barang ke daftar transaksi</li>
                        <li>Anda bisa menambahkan <strong>banyak barang</strong> dalam satu transaksi</li>
                        <li><strong>Supplier per Barang:</strong> Untuk stok masuk, Anda bisa mengisi supplier yang berbeda untuk setiap barang</li>
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
            
            <!-- Supplier per Barang (hanya untuk Stok Masuk) -->
            <div class="supplier-field conditional-supplier-field" style="display: none;">
                <label class="form-label">Supplier (Opsional)</label>
                <input type="text" 
                       class="form-control supplier-per-barang" 
                       placeholder="Supplier untuk barang ini (kosongkan untuk menggunakan supplier global)">
                <small class="text-muted">Jika dikosongkan, akan menggunakan supplier global</small>
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
        const supplierGlobalInput = document.getElementById('supplier_global');
        const departemenSelect = document.getElementById('departemen');
        const keperluanInput = document.getElementById('keperluan');
        const tipeError = document.getElementById('tipeError');
        const barangListContainer = document.getElementById('barangListContainer');
        const noBarangMessage = document.getElementById('noBarangMessage');
        const totalBarangSpan = document.getElementById('totalBarang');
        const barangDataContainer = document.getElementById('barangDataContainer');
        const barangItemTemplate = document.getElementById('barangItemTemplate');

        let selectedTipe = null;
        let selectedBarangList = [];

        function resetFormState() {
            tipeRadios.forEach(radio => radio.checked = false);
            selectedTipe = null;
            tipeError.classList.add('d-none');
            
            masukFields.style.display = 'none';
            keluarFields.style.display = 'none';
            
            supplierGlobalInput.disabled = true;
            departemenSelect.disabled = true;
            keperluanInput.disabled = true;
            
            supplierGlobalInput.value = '';
            departemenSelect.value = '';
            keperluanInput.value = '';
            
            selectedBarangList = [];
            updateBarangListDisplay();
            
            document.querySelectorAll('.barang-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        function toggleFields() {
            if (!selectedTipe) {
                masukFields.style.display = 'none';
                keluarFields.style.display = 'none';
                supplierGlobalInput.disabled = true;
                departemenSelect.disabled = true;
                keperluanInput.disabled = true;
                return;
            }
            
            masukFields.style.display = 'none';
            keluarFields.style.display = 'none';
            
            supplierGlobalInput.required = false;
            departemenSelect.required = false;
            keperluanInput.required = false;
            
            if (selectedTipe === 'masuk') {
                masukFields.style.display = 'block';
                supplierGlobalInput.required = true;
                supplierGlobalInput.disabled = false;
                departemenSelect.value = '';
                keperluanInput.value = '';
                departemenSelect.disabled = true;
                keperluanInput.disabled = true;
                
                // Tampilkan field supplier per barang
                document.querySelectorAll('.conditional-supplier-field').forEach(field => {
                    field.style.display = 'block';
                });
            } else {
                keluarFields.style.display = 'block';
                departemenSelect.required = true;
                keperluanInput.required = true;
                departemenSelect.disabled = false;
                keperluanInput.disabled = false;
                supplierGlobalInput.value = '';
                supplierGlobalInput.disabled = true;
                
                // Sembunyikan field supplier per barang
                document.querySelectorAll('.conditional-supplier-field').forEach(field => {
                    field.style.display = 'none';
                });
            }
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
                        supplier: ''
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
            barangDataContainer.innerHTML = '';
            
            if (selectedBarangList.length === 0) {
                barangListContainer.appendChild(noBarangMessage);
                noBarangMessage.classList.remove('d-none');
            } else {
                noBarangMessage.classList.add('d-none');
                
                selectedBarangList.forEach((barang, index) => {
                    const template = barangItemTemplate.content.cloneNode(true);
                    const itemCard = template.querySelector('.barang-item-card');
                    
                    itemCard.setAttribute('data-kode', barang.kode);
                    
                    itemCard.querySelector('h6').textContent = barang.nama;
                    itemCard.querySelector('small').textContent = `Kode: ${barang.kode}`;
                    
                    itemCard.querySelectorAll('.product-info-value')[0].textContent = barang.satuan;
                    
                    const stokColor = barang.stok > 0 ? 'success' : 'danger';
                    const stokBadge = itemCard.querySelector('.badge');
                    stokBadge.className = `badge bg-${stokColor}`;
                    stokBadge.textContent = `${barang.stok.toFixed(2)} ${barang.satuan}`;
                    
                    // Supplier per barang
                    const supplierField = itemCard.querySelector('.supplier-per-barang');
                    supplierField.setAttribute('name', `barang[${index}][supplier]`);
                    supplierField.value = barang.supplier || '';
                    
                    // Tampilkan/sembunyikan field supplier berdasarkan tipe transaksi
                    const supplierContainer = itemCard.querySelector('.conditional-supplier-field');
                    if (selectedTipe === 'masuk') {
                        supplierContainer.style.display = 'block';
                    } else {
                        supplierContainer.style.display = 'none';
                    }
                    
                    supplierField.addEventListener('input', function() {
                        barang.supplier = this.value;
                    });
                    
                    // Input jumlah
                    const jumlahInput = itemCard.querySelector('.jumlah-input');
                    jumlahInput.setAttribute('data-max', barang.stok);
                    jumlahInput.setAttribute('name', `barang[${index}][jumlah]`);
                    jumlahInput.setAttribute('data-index', index);
                    jumlahInput.value = barang.jumlah || '';
                    
                    const jumlahSatuanLabel = itemCard.querySelector('.text-muted');
                    
                    jumlahInput.addEventListener('input', function() {
                        validateBarangStock(this);
                        barang.jumlah = this.value;
                    });
                    
                    const removeBtn = itemCard.querySelector('.remove-barang-btn');
                    removeBtn.addEventListener('click', function() {
                        removeBarangFromList(index);
                    });
                    
                    barangListContainer.appendChild(template);
                    
                    addHiddenInput('barang[' + index + '][kode_barang]', barang.kode);
                    addHiddenInput('barang[' + index + '][nama_barang]', barang.nama);
                    addHiddenInput('barang[' + index + '][satuan]', barang.satuan);
                    addHiddenInput('barang[' + index + '][stok_tersedia]', barang.stok);
                });
            }
            
            totalBarangSpan.textContent = selectedBarangList.length;
            validateAllStock();
        }

        function addHiddenInput(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            barangDataContainer.appendChild(input);
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

        tipeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                selectedTipe = this.value;
                tipeError.classList.add('d-none');
                toggleFields();
                validateAllStock();
                
                // Update tampilan supplier per barang
                if (selectedTipe === 'masuk') {
                    document.querySelectorAll('.conditional-supplier-field').forEach(field => {
                        field.style.display = 'block';
                    });
                } else {
                    document.querySelectorAll('.conditional-supplier-field').forEach(field => {
                        field.style.display = 'none';
                    });
                }
            });
        });

        addBarangBtn.addEventListener('click', addBarangToList);

        searchBarangInput.addEventListener('input', searchBarang);

        departemenSelect.addEventListener('change', function() {
            if (this.value && keperluanInput.disabled === false) {
                keperluanInput.focus();
            }
        });

        document.getElementById('transactionForm').addEventListener('submit', function(e) {
            const selectedTipeRadio = document.querySelector('input[name="tipe"]:checked');
            if (!selectedTipeRadio) {
                e.preventDefault();
                tipeError.classList.remove('d-none');
                alert('Silakan pilih tipe transaksi!');
                return false;
            }
            
            const tipeValue = selectedTipeRadio.value;
            
            if (selectedBarangList.length === 0) {
                e.preventDefault();
                alert('Silakan tambahkan minimal satu barang ke daftar!');
                return false;
            }
            
            if (tipeValue === 'masuk') {
                // Untuk stok masuk, validasi supplier global atau per barang
                const supplierGlobal = supplierGlobalInput.value.trim();
                let hasSupplier = false;
                
                // Cek apakah ada supplier global
                if (supplierGlobal) {
                    hasSupplier = true;
                } else {
                    // Cek apakah ada supplier per barang
                    selectedBarangList.forEach((barang, index) => {
                        if (barang.supplier && barang.supplier.trim()) {
                            hasSupplier = true;
                        }
                    });
                }
                
                if (!hasSupplier) {
                    e.preventDefault();
                    alert('Supplier wajib diisi! Isi supplier global atau supplier untuk setiap barang.');
                    supplierGlobalInput.focus();
                    return false;
                }
            }
            
            if (tipeValue === 'keluar') {
                if (!departemenSelect.value) {
                    e.preventDefault();
                    alert('Departemen wajib dipilih untuk stok keluar!');
                    departemenSelect.focus();
                    return false;
                }
                if (!keperluanInput.value.trim()) {
                    e.preventDefault();
                    alert('Keperluan wajib diisi untuk stok keluar!');
                    keperluanInput.focus();
                    return false;
                }
            }
            
            let jumlahError = false;
            selectedBarangList.forEach((barang, index) => {
                const jumlah = parseFloat(barang.jumlah) || 0;
                if (jumlah <= 0) {
                    jumlahError = true;
                    e.preventDefault();
                    alert(`Jumlah untuk barang "${barang.nama}" harus lebih dari 0!`);
                    return;
                }
            });
            
            if (jumlahError) return false;
            
            if (!validateAllStock()) {
                e.preventDefault();
                alert('Ada masalah dengan jumlah stok keluar! Periksa kembali jumlah barang.');
                return false;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            resetFormState();
        });
    </script>
</body>

</html>