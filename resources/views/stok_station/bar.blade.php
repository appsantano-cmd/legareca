@extends('layouts.stok_station')

@section('title', 'Stok Bar')

@push('styles')
    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        .sticky-header {
            position: sticky;
            top: 0;
            background: white;
            z-index: 100;
        }

        .form-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .nav-link.active {
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><i class="fas fa-cocktail me-2"></i> Stok Bar</h4>
                        <div>
                            @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'developer']))
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">
                                    <i class="fas fa-file-export me-1"></i> Export
                                </button>
                            @endif
                            <button type="button" class="btn btn-success" onclick="toggleForm()">
                                <i class="fas fa-plus me-1"></i> Tambah Stok
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Bagian 1: Tabel Data Stok -->
                        <div class="table-container">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary sticky-header">
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Shift</th>
                                        <th>Kode Bahan</th>
                                        <th>Nama Bahan</th>
                                        <th>Satuan</th>
                                        <th>Stok Awal</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>Waste</th>
                                        <th>Stok Akhir</th>
                                        <th>Status Stok</th>
                                        <th>PIC</th>
                                        @if (in_array(auth()->user()->role, ['admin', 'developer']))
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stokBar as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                            <td><span class="badge bg-info">{{ $item->shift }}</span></td>
                                            <td><span class="badge bg-secondary">{{ $item->kode_bahan }}</span></td>
                                            <td>{{ $item->nama_bahan }}</td>
                                            <td>{{ $item->nama_satuan }}</td>
                                            <td class="text-end">{{ number_format($item->stok_awal, 2) }}</td>
                                            <td class="text-end text-success">{{ number_format($item->stok_masuk, 2) }}</td>
                                            <td class="text-end text-warning">{{ number_format($item->stok_keluar, 2) }}
                                            </td>
                                            <td class="text-end text-danger">{{ number_format($item->waste, 2) }}</td>
                                            <td class="text-end fw-bold">{{ number_format($item->stok_akhir, 2) }}</td>
                                            <td>
                                                @if ($item->status_stok == 'SAFE')
                                                    <span class="badge bg-success">SAFE</span>
                                                @else
                                                    <span class="badge bg-danger">REORDER</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->pic }}</td>
                                            @if (in_array(auth()->user()->role, ['admin', 'developer']))
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                            data-bs-target="#viewModal{{ $item->id }}" title="Lihat">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $item->id }}"
                                                            title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>

                                        <!-- View Modal -->
                                        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-eye me-2"></i>Detail Stok Bar
                                                        </h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <th width="40%">Tanggal</th>
                                                                        <td>: {{ $item->tanggal->format('d/m/Y') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Shift</th>
                                                                        <td>: <span
                                                                                class="badge bg-info">{{ $item->shift }}</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Kode Bahan</th>
                                                                        <td>: <span
                                                                                class="badge bg-secondary">{{ $item->kode_bahan }}</span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Nama Bahan</th>
                                                                        <td>: {{ $item->nama_bahan }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Satuan</th>
                                                                        <td>: {{ $item->nama_satuan }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <table class="table table-borderless">
                                                                    <tr>
                                                                        <th width="40%">Stok Awal</th>
                                                                        <td>: {{ number_format($item->stok_awal, 2) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Stok Masuk</th>
                                                                        <td class="text-success">:
                                                                            {{ number_format($item->stok_masuk, 2) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Stok Keluar</th>
                                                                        <td class="text-warning">:
                                                                            {{ number_format($item->stok_keluar, 2) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Waste</th>
                                                                        <td class="text-danger">:
                                                                            {{ number_format($item->waste, 2) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Stok Akhir</th>
                                                                        <td>:
                                                                            <strong>{{ number_format($item->stok_akhir, 2) }}</strong>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Status Stok</th>
                                                                        <td>:
                                                                            @if ($item->status_stok == 'SAFE')
                                                                                <span class="badge bg-success">SAFE</span>
                                                                            @else
                                                                                <span class="badge bg-danger">REORDER</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>PIC</th>
                                                                        <td>: {{ $item->pic }}</td>
                                                                    </tr>
                                                                    @if ($item->alasan_waste)
                                                                        <tr>
                                                                            <th>Alasan Waste</th>
                                                                            <td>: {{ $item->alasan_waste }}</td>
                                                                        </tr>
                                                                    @endif
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="fas fa-times me-1"></i> Tutup
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('stok-bar.update', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-edit me-2"></i>Edit Stok Bar
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Tanggal <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="date" class="form-control"
                                                                        name="tanggal"
                                                                        value="{{ $item->tanggal->format('Y-m-d') }}"
                                                                        required>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Shift <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="form-select" name="shift" required>
                                                                        <option value="">Pilih Shift</option>
                                                                        <option value="1"
                                                                            {{ $item->shift == '1' ? 'selected' : '' }}>1
                                                                        </option>
                                                                        <option value="2"
                                                                            {{ $item->shift == '2' ? 'selected' : '' }}>2
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Bahan <span
                                                                            class="text-danger">*</span></label>
                                                                    <select class="form-select master-bahan-select"
                                                                        name="kode_bahan" required
                                                                        onchange="loadMasterBahan(this.value, 'edit', {{ $item->id }})">
                                                                        <option value="">Pilih Bahan</option>
                                                                        @foreach ($masterBar as $master)
                                                                            <option value="{{ $master->kode_bahan }}"
                                                                                {{ $item->kode_bahan == $master->kode_bahan ? 'selected' : '' }}>
                                                                                {{ $master->kode_bahan }} -
                                                                                {{ $master->nama_bahan }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden" name="nama_bahan"
                                                                        id="edit_nama_bahan{{ $item->id }}"
                                                                        value="{{ $item->nama_bahan }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Satuan <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control satuan-input"
                                                                        name="nama_satuan"
                                                                        id="edit_nama_satuan{{ $item->id }}"
                                                                        value="{{ $item->nama_satuan }}" required
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Stok Awal <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="number" step="0.01"
                                                                        class="form-control" name="stok_awal"
                                                                        value="{{ $item->stok_awal }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label">Stok Masuk</label>
                                                                    <input type="number" step="0.01"
                                                                        class="form-control" name="stok_masuk"
                                                                        value="{{ $item->stok_masuk }}">
                                                                </div>
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label">Stok Keluar</label>
                                                                    <input type="number" step="0.01"
                                                                        class="form-control" name="stok_keluar"
                                                                        value="{{ $item->stok_keluar }}">
                                                                </div>
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label">Waste</label>
                                                                    <input type="number" step="0.01"
                                                                        class="form-control" name="waste"
                                                                        value="{{ $item->waste }}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">Alasan Waste</label>
                                                                    <textarea class="form-control" name="alasan_waste" rows="2">{{ $item->alasan_waste }}</textarea>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label">PIC <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control"
                                                                        name="pic" value="{{ $item->pic }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i> Batal
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fas fa-save me-1"></i> Update
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('stok-bar.destroy', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-danger">
                                                                <i class="fas fa-trash me-2"></i>Hapus Stok Bar
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda yakin ingin menghapus stok bar:</p>
                                                            <p><strong>{{ $item->nama_bahan }}</strong>
                                                                ({{ $item->kode_bahan }})?</p>
                                                            <p>Tanggal: {{ $item->tanggal->format('d/m/Y') }}, Shift:
                                                                {{ $item->shift }}</p>
                                                            <p class="text-danger">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                                Data yang sudah dihapus tidak dapat dikembalikan.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i> Batal
                                                            </button>
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fas fa-trash me-1"></i> Hapus
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Bagian 2: Form Input Stok (Awalnya tersembunyi) -->
                        <div id="formSection" class="form-section" style="display: none;">
                            <h5 class="mb-4"><i class="fas fa-plus-circle me-2"></i> Form Tambah Stok Bar</h5>
                            <form action="{{ route('stok-bar.store') }}" method="POST" id="stokForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                            name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                                            required onchange="getPreviousStok()">
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Shift <span class="text-danger">*</span></label>
                                        <select class="form-select @error('shift') is-invalid @enderror" name="shift"
                                            id="shift" required onchange="getPreviousStok()">
                                            <option value="">Pilih Shift</option>
                                            <option value="1" {{ old('shift') == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('shift') == '2' ? 'selected' : '' }}>2</option>
                                        </select>
                                        @error('shift')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Bahan <span class="text-danger">*</span></label>
                                        <select class="form-select @error('kode_bahan') is-invalid @enderror"
                                            name="kode_bahan" id="kode_bahan" required
                                            onchange="loadMasterBahan(this.value, 'create')">
                                            <option value="">Pilih Bahan</option>
                                            @foreach ($masterBar as $master)
                                                <option value="{{ $master->kode_bahan }}"
                                                    {{ old('kode_bahan') == $master->kode_bahan ? 'selected' : '' }}>
                                                    {{ $master->kode_bahan }} - {{ $master->nama_bahan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="nama_bahan" id="nama_bahan">
                                        @error('kode_bahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Satuan <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control satuan-input @error('nama_satuan') is-invalid @enderror"
                                            name="nama_satuan" id="nama_satuan" value="{{ old('nama_satuan') }}"
                                            required readonly>
                                        @error('nama_satuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('stok_awal') is-invalid @enderror" name="stok_awal"
                                            id="stok_awal" value="{{ old('stok_awal') }}" required>
                                        @error('stok_awal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted" id="stok_awal_info">Stok awal akan otomatis terisi dari
                                            stok akhir shift sebelumnya</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Stok Masuk</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('stok_masuk') is-invalid @enderror"
                                            name="stok_masuk" id="stok_masuk" value="{{ old('stok_masuk', 0) }}">
                                        @error('stok_masuk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Stok Keluar</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('stok_keluar') is-invalid @enderror"
                                            name="stok_keluar" id="stok_keluar" value="{{ old('stok_keluar', 0) }}">
                                        @error('stok_keluar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Waste</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('waste') is-invalid @enderror" name="waste"
                                            id="waste" value="{{ old('waste', 0) }}">
                                        @error('waste')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Alasan Waste</label>
                                        <textarea class="form-control @error('alasan_waste') is-invalid @enderror" name="alasan_waste" id="alasan_waste"
                                            rows="2">{{ old('alasan_waste') }}</textarea>
                                        @error('alasan_waste')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">PIC <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('pic') is-invalid @enderror"
                                            name="pic" id="pic" value="{{ old('pic') }}" required>
                                        @error('pic')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Catatan:</strong> Stok awal otomatis diisi dari stok akhir transaksi
                                            sebelumnya.
                                            Untuk shift 1, stok awal diambil dari shift 2 hari sebelumnya.
                                            Untuk shift 2, stok awal diambil dari shift 1 hari yang sama.
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" onclick="toggleForm()">
                                        <i class="fas fa-times me-1"></i> Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Fungsi untuk menampilkan/sembunyikan form
        function toggleForm() {
            const formSection = document.getElementById('formSection');
            if (formSection.style.display === 'none') {
                formSection.style.display = 'block';
                window.scrollTo({
                    top: formSection.offsetTop - 100,
                    behavior: 'smooth'
                });
            } else {
                formSection.style.display = 'none';
            }
        }

        // Fungsi untuk mengambil data master bahan
        function loadMasterBahan(kodeBahan, type, itemId = null) {
            if (!kodeBahan) return;

            fetch(`/api/master-bar/${kodeBahan}`)
                .then(response => response.json())
                .then(data => {
                    if (type === 'create') {
                        document.getElementById('nama_bahan').value = data.nama_bahan;
                        document.getElementById('nama_satuan').value = data.nama_satuan;
                        // Setelah dapat master, cari stok sebelumnya
                        getPreviousStok();
                    } else if (type === 'edit' && itemId) {
                        document.getElementById(`edit_nama_bahan${itemId}`).value = data.nama_bahan;
                        document.getElementById(`edit_nama_satuan${itemId}`).value = data.nama_satuan;
                    }
                })
                .catch(error => {
                    console.error('Error loading master bahan:', error);
                    alert('Gagal memuat data master bahan');
                });
        }

        // Fungsi untuk mendapatkan stok sebelumnya
        function getPreviousStok() {
            const tanggal = document.getElementById('tanggal').value;
            const shift = document.getElementById('shift').value;
            const kodeBahan = document.getElementById('kode_bahan').value;

            if (!tanggal || !shift || !kodeBahan) return;

            fetch(`/api/previous-stok-bar?tanggal=${tanggal}&kode_bahan=${kodeBahan}&shift=${shift}`)
                .then(response => response.json())
                .then(data => {
                    const stokAwalInput = document.getElementById('stok_awal');
                    const stokAwalInfo = document.getElementById('stok_awal_info');

                    if (data.stok_awal > 0) {
                        stokAwalInput.value = data.stok_awal;
                        stokAwalInfo.innerHTML =
                            `<i class="fas fa-check-circle me-1"></i> Stok awal diambil dari stok akhir sebelumnya: ${data.stok_akhir}`;
                        stokAwalInfo.className = 'text-success';
                    } else {
                        stokAwalInfo.innerHTML =
                            `<i class="fas fa-exclamation-triangle me-1"></i> Tidak ada data stok sebelumnya. Silakan isi stok awal secara manual.`;
                        stokAwalInfo.className = 'text-warning';
                        stokAwalInput.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error loading previous stok:', error);
                });
        }

        // Auto close alert setelah 5 detik
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Validasi form sebelum submit
        document.addEventListener('DOMContentLoaded', function() {
            const stokForm = document.getElementById('stokForm');
            if (stokForm) {
                stokForm.addEventListener('submit', function(e) {
                    const stokAwal = parseFloat(document.getElementById('stok_awal').value);
                    const stokMasuk = parseFloat(document.getElementById('stok_masuk').value) || 0;
                    const stokKeluar = parseFloat(document.getElementById('stok_keluar').value) || 0;
                    const waste = parseFloat(document.getElementById('waste').value) || 0;

                    const stokAkhir = stokAwal + stokMasuk - stokKeluar - waste;

                    if (stokAkhir < 0) {
                        e.preventDefault();
                        alert(
                            'Stok akhir tidak boleh negatif. Periksa kembali input stok keluar dan waste.'
                            );
                        return false;
                    }
                });
            }
        });
    </script>
@endpush
