@extends('layouts.stok_station')

@section('title', 'Stok Bar')

@push('styles')
    <style>
        /* Professional Styling */
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .sticky-header {
            position: sticky;
            top: 0;
            background: linear-gradient(135deg, #8a2387 0%, #f27121 100%);
            color: white;
            z-index: 100;
        }

        .form-section {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            margin-top: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid #eef2f7;
        }

        .card-header {
            background: linear-gradient(135deg, #8a2387 0%, #f27121 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8a2387 0%, #f27121 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(138, 35, 135, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #0ba360 0%, #3cba92 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(11, 163, 96, 0.4);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(138, 35, 135, 0.05);
            transform: scale(1.002);
            transition: all 0.2s ease;
        }

        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 500;
        }

        .status-safe {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .status-reorder {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, #8a2387 0%, #f27121 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px;
        }

        .search-box {
            position: relative;
            margin-bottom: 20px;
        }

        .search-box input {
            padding-left: 45px;
            border-radius: 25px;
            border: 2px solid #eef2f7;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            border-color: #8a2387;
            box-shadow: 0 0 0 3px rgba(138, 35, 135, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8a2387;
        }

        .bahan-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #eef2f7;
            border-radius: 10px;
            padding: 10px;
        }

        .bahan-item {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .bahan-item:hover {
            background: linear-gradient(135deg, #8a2387 0%, #f27121 100%);
            color: white;
            transform: translateX(5px);
        }

        .bahan-item.selected {
            background: linear-gradient(135deg, #0ba360 0%, #3cba92 100%);
            color: white;
            border-color: #0ba360;
        }

        .bahan-item .badge {
            font-size: 0.8em;
        }

        .stok-input-group {
            position: relative;
        }

        .stok-input-group .form-control {
            padding-right: 40px;
        }

        .stok-input-group .unit {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8a2387;
            font-weight: 500;
        }

        .info-card {
            background: linear-gradient(135deg, #f6f9fc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .info-card i {
            color: #8a2387;
            font-size: 1.5em;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85em;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
        }

        .action-buttons .btn {
            padding: 5px 10px;
            margin: 2px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .action-buttons .btn:hover {
            transform: translateY(-2px);
        }

        /* Dashboard Stats */
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9em;
        }

        /* Filter Section */
        .filter-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .filter-header {
            font-weight: 600;
            color: #8a2387;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <i class="fas fa-filter"></i>
                <span>Filter Data</span>
            </div>

            <form method="GET" action="{{ route('stok-bar.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nama Bahan</label>
                        <input type="text" class="form-control" name="nama_bahan" value="{{ request('nama_bahan') }}"
                            placeholder="Cari nama bahan...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Shift</label>
                        <select class="form-select" name="shift">
                            <option value="">Semua Shift</option>
                            <option value="1" {{ request('shift') == '1' ? 'selected' : '' }}>Shift 1</option>
                            <option value="2" {{ request('shift') == '2' ? 'selected' : '' }}>Shift 2</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Terapkan Filter
                            </button>
                            <a href="{{ route('stok-bar.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Reset Filter
                            </a>

                            @if (request()->anyFilled(['start_date', 'end_date', 'nama_bahan', 'shift']))
                                <div class="ms-auto">
                                    <span class="badge bg-info">
                                        <i class="fas fa-filter me-1"></i>
                                        Data Difilter
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Main Card -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><i class="fas fa-cocktail me-2"></i> Stok Bar</h4>
                            <p class="mb-0 opacity-75">Manajemen stok bahan bar</p>
                        </div>
                        <div class="d-flex gap-2">
                            @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'developer']))
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">
                                    <i class="fas fa-file-export me-1"></i> Export
                                </button>
                            @endif

                            <button type="button" class="btn btn-warning text-dark" onclick="toggleForm()">
                                <i class="fas fa-plus me-1"></i> Tambah Stok
                            </button>
                        </div>

                    </div>
                    <div class="card-body p-4">
                        <!-- Success/Error Messages -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                                role="alert">
                                <i class="fas fa-check-circle me-3" style="font-size: 1.5em;"></i>
                                <div class="flex-grow-1">{{ session('success') }}</div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
                                role="alert">
                                <i class="fas fa-exclamation-circle me-3" style="font-size: 1.5em;"></i>
                                <div class="flex-grow-1">{{ session('error') }}</div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Data Table Section -->
                        <div class="table-responsive table-container">
                            <table class="table table-hover align-middle">
                                <thead class="sticky-header">
                                    <tr>
                                        <th class="text-center" style="width: 50px">#</th>
                                        <th style="width: 100px">Tanggal</th>
                                        <th class="text-center" style="width: 80px">Shift</th>
                                        <th style="width: 120px">Kode Bahan</th>
                                        <th>Nama Bahan</th>
                                        <th style="width: 100px">Satuan</th>
                                        <th class="text-end" style="width: 100px">Stok Awal</th>
                                        <th class="text-end" style="width: 100px">Masuk</th>
                                        <th class="text-end" style="width: 100px">Keluar</th>
                                        <th class="text-end" style="width: 100px">Waste</th>
                                        <th class="text-end" style="width: 120px">Stok Akhir</th>
                                        <th class="text-center" style="width: 100px">Status</th>
                                        <th style="width: 150px">PIC</th>
                                        @if (in_array(auth()->user()->role, ['admin', 'developer']))
                                            <th class="text-center" style="width: 150px">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach ($stokBar as $item)
                                        <tr>
                                            <td class="text-center fw-bold">{{ $counter++ }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ $item->tanggal->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">Shift {{ $item->shift }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-dark">{{ $item->kode_bahan }}</span>
                                            </td>
                                            <td class="fw-semibold">{{ $item->nama_bahan }}</td>
                                            <td>{{ $item->nama_satuan }}</td>
                                            <td class="text-end">
                                                <span class="fw-bold">{{ number_format($item->stok_awal, 2) }}</span>
                                            </td>
                                            <td class="text-end text-success">
                                                <i
                                                    class="fas fa-arrow-down me-1"></i>{{ number_format($item->stok_masuk, 2) }}
                                            </td>
                                            <td class="text-end text-warning">
                                                <i
                                                    class="fas fa-arrow-up me-1"></i>{{ number_format($item->stok_keluar, 2) }}
                                            </td>
                                            <td class="text-end text-danger">
                                                <i class="fas fa-trash me-1"></i>{{ number_format($item->waste, 2) }}
                                            </td>
                                            <td class="text-end">
                                                <span
                                                    class="fw-bold fs-6">{{ number_format($item->stok_akhir, 2) }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($item->status_stok == 'SAFE')
                                                    <span class="status-badge status-safe">SAFE</span>
                                                @else
                                                    <span class="status-badge status-reorder">REORDER</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-user me-1"></i>{{ $item->pic }}
                                                </span>
                                            </td>
                                            @if (in_array(auth()->user()->role, ['admin', 'developer']))
                                                <td class="text-center action-buttons">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#detailModal{{ $item->id }}"
                                                            title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}"
                                                            title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $item->id }}"
                                                            title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach

                                    @if ($stokBar->isEmpty())
                                        <tr>
                                            <td colspan="{{ in_array(auth()->user()->role, ['admin', 'developer']) ? 14 : 13 }}"
                                                class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                                    <p class="mb-0">Tidak ada data stok bar</p>
                                                    @if (request()->anyFilled(['start_date', 'end_date', 'nama_bahan', 'shift']))
                                                        <p class="small">Coba ubah filter pencarian</p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Form Input Section (Hidden by default) -->
                        <div id="formSection" class="form-section" style="display: none;">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">
                                    <i class="fas fa-plus-circle me-2 text-primary"></i> Form Input Stok Bar
                                </h5>
                                <button type="button" class="btn btn-outline-secondary" onclick="toggleForm()">
                                    <i class="fas fa-times me-1"></i> Tutup Form
                                </button>
                            </div>

                            <form action="{{ route('stok-bar.store') }}" method="POST" id="stokForm">
                                @csrf
                                <div class="row">
                                    <!-- Tanggal dan Shift -->
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-semibold">Tanggal <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                            name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                                            required onchange="getPreviousStok()">
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-semibold">Shift <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('shift') is-invalid @enderror" name="shift"
                                            id="shift" required onchange="getPreviousStok()">
                                            <option value="">Pilih Shift</option>
                                            <option value="1" {{ old('shift') == '1' ? 'selected' : '' }}>Shift 1
                                            </option>
                                            <option value="2" {{ old('shift') == '2' ? 'selected' : '' }}>Shift 2
                                            </option>
                                        </select>
                                        @error('shift')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-semibold">PIC <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('pic') is-invalid @enderror"
                                            name="pic" id="pic" value="{{ old('pic', auth()->user()->name) }}"
                                            required>
                                        @error('pic')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Pilih Bahan -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Bahan <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                                placeholder="Cari atau klik untuk memilih bahan..." id="searchBahan"
                                                readonly onclick="showBahanModal()">
                                            <button class="btn btn-outline-primary" type="button"
                                                onclick="showBahanModal()">
                                                <i class="fas fa-search"></i> Pilih Bahan
                                            </button>
                                            <input type="hidden" name="kode_bahan" id="kode_bahan">
                                            <input type="hidden" name="nama_bahan" id="nama_bahan">
                                            <input type="hidden" name="nama_satuan" id="nama_satuan">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Informasi Bahan</label>
                                        <div class="info-card">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-box me-3"></i>
                                                <div>
                                                    <small class="text-muted">Kode Bahan</small>
                                                    <div id="infoKodeBahan" class="fw-bold">-</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-weight me-3"></i>
                                                <div>
                                                    <small class="text-muted">Satuan</small>
                                                    <div id="infoSatuan" class="fw-bold">-</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-exclamation-triangle me-3"></i>
                                                <div>
                                                    <small class="text-muted">Stok Minimum</small>
                                                    <div id="infoStokMinimum" class="fw-bold">-</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Input Stok -->
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-semibold">Stok Awal</label>
                                        <div class="stok-input-group">
                                            <input type="number" step="0.01"
                                                class="form-control @error('stok_awal') is-invalid @enderror"
                                                name="stok_awal" id="stok_awal" value="{{ old('stok_awal') }}" readonly>
                                            <span class="unit" id="stokAwalUnit">-</span>
                                        </div>
                                        <small class="text-muted mt-1 d-block" id="stok_awal_info">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Stok awal akan otomatis terisi
                                        </small>
                                        @error('stok_awal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-semibold">Stok Masuk</label>
                                        <div class="stok-input-group">
                                            <input type="number" step="0.01"
                                                class="form-control @error('stok_masuk') is-invalid @enderror"
                                                name="stok_masuk" id="stok_masuk" value="{{ old('stok_masuk', 0) }}">
                                            <span class="unit" id="stokMasukUnit">-</span>
                                        </div>
                                        @error('stok_masuk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-semibold">Stok Keluar</label>
                                        <div class="stok-input-group">
                                            <input type="number" step="0.01"
                                                class="form-control @error('stok_keluar') is-invalid @enderror"
                                                name="stok_keluar" id="stok_keluar" value="{{ old('stok_keluar', 0) }}">
                                            <span class="unit" id="stokKeluarUnit">-</span>
                                        </div>
                                        @error('stok_keluar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-semibold">Waste</label>
                                        <div class="stok-input-group">
                                            <input type="number" step="0.01"
                                                class="form-control @error('waste') is-invalid @enderror" name="waste"
                                                id="waste" value="{{ old('waste', 0) }}">
                                            <span class="unit" id="wasteUnit">-</span>
                                        </div>
                                        @error('waste')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Alasan Waste dan Stok Akhir -->
                                <div class="row mb-4">
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label fw-semibold">Alasan Waste (Opsional)</label>
                                        <textarea class="form-control @error('alasan_waste') is-invalid @enderror" name="alasan_waste" id="alasan_waste"
                                            rows="2" placeholder="Masukkan alasan waste jika ada...">{{ old('alasan_waste') }}</textarea>
                                        @error('alasan_waste')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Stok Akhir</label>
                                        <div class="stok-input-group">
                                            <input type="text" class="form-control fw-bold fs-5 text-primary"
                                                id="stok_akhir_preview" value="0.00" readonly>
                                            <span class="unit" id="stokAkhirUnit">-</span>
                                        </div>
                                        <small class="text-muted mt-1 d-block">
                                            <i class="fas fa-calculator me-1"></i>
                                            Stok Awal + Masuk - Keluar - Waste
                                        </small>
                                    </div>
                                </div>

                                <!-- Informasi Sistem -->
                                <div class="info-card mb-4">
                                    <div class="d-flex">
                                        <i class="fas fa-lightbulb text-warning me-3 mt-1"></i>
                                        <div>
                                            <h6 class="fw-bold mb-2">Cara Kerja Sistem Stok:</h6>
                                            <ul class="mb-0" style="padding-left: 20px;">
                                                <li>Stok awal pertama kali diambil dari data master bar</li>
                                                <li>Untuk transaksi berikutnya, stok awal otomatis diambil dari stok akhir
                                                    transaksi sebelumnya</li>
                                                <li>Shift 1: Stok awal diambil dari stok akhir Shift 2 hari sebelumnya</li>
                                                <li>Shift 2: Stok awal diambil dari stok akhir Shift 1 hari yang sama</li>
                                                <li>Sistem akan otomatis menghitung stok akhir dan menentukan status
                                                    (SAFE/REORDER)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                    <button type="button" class="btn btn-lg btn-outline-secondary"
                                        onclick="toggleForm()">
                                        <i class="fas fa-times me-2"></i> Batal
                                    </button>
                                    <button type="submit" class="btn btn-lg btn-primary">
                                        <i class="fas fa-save me-2"></i> Simpan Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Export -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">
                        <i class="fas fa-file-export me-2"></i>Export Data Stok Bar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="exportForm" method="GET" action="{{ route('stok-bar.export') }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="export_start_date" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="export_start_date" name="export_start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="export_end_date" class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="export_end_date" name="export_end_date" required>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Data akan diexport dalam format Excel (.xlsx) dengan header kolom yang freeze.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success" id="exportButton">
                            <i class="fas fa-download me-1"></i> Download Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Pilih Bahan -->
    <div class="modal fade" id="bahanModal" tabindex="-1" aria-labelledby="bahanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bahanModalLabel">
                        <i class="fas fa-wine-bottle me-2"></i>Pilih Bahan Bar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Search Box -->
                    <div class="search-box mb-4">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" id="searchBahanInput"
                            placeholder="Cari bahan berdasarkan kode atau nama..." onkeyup="searchBahan()">
                    </div>

                    <!-- Bahan List -->
                    <div class="bahan-list" id="bahanList">
                        <!-- Bahan items will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- All Modals (Detail, Edit, Delete) -->
    @foreach ($stokBar as $item)
        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-info-circle me-2"></i>Detail Stok Bar
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Left Column - Basic Info -->
                            <div class="col-md-6">
                                <div class="info-card mb-3">
                                    <h6 class="fw-bold mb-3 text-primary">Informasi Dasar</h6>
                                    <div class="row mb-2">
                                        <div class="col-5"><small class="text-muted">Tanggal</small></div>
                                        <div class="col-7">
                                            <strong><i
                                                    class="fas fa-calendar-alt me-2"></i>{{ $item->tanggal->format('d F Y') }}</strong>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small class="text-muted">Shift</small></div>
                                        <div class="col-7">
                                            <span class="badge bg-info">Shift {{ $item->shift }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small class="text-muted">Kode Bahan</small></div>
                                        <div class="col-7">
                                            <span class="badge bg-dark">{{ $item->kode_bahan }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small class="text-muted">Nama Bahan</small></div>
                                        <div class="col-7"><strong>{{ $item->nama_bahan }}</strong></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small class="text-muted">Satuan</small></div>
                                        <div class="col-7"><strong>{{ $item->nama_satuan }}</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5"><small class="text-muted">PIC</small></div>
                                        <div class="col-7">
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-user me-1"></i>{{ $item->pic }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Stock Details -->
                            <div class="col-md-6">
                                <div class="info-card mb-3">
                                    <h6 class="fw-bold mb-3 text-primary">Detail Stok</h6>
                                    <div class="row mb-2">
                                        <div class="col-6"><small class="text-muted">Stok Awal</small></div>
                                        <div class="col-6 text-end">
                                            <strong>{{ number_format($item->stok_awal, 2) }}</strong>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6"><small class="text-muted">Stok Masuk</small></div>
                                        <div class="col-6 text-end text-success">
                                            <i
                                                class="fas fa-arrow-down me-1"></i><strong>{{ number_format($item->stok_masuk, 2) }}</strong>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6"><small class="text-muted">Stok Keluar</small></div>
                                        <div class="col-6 text-end text-warning">
                                            <i
                                                class="fas fa-arrow-up me-1"></i><strong>{{ number_format($item->stok_keluar, 2) }}</strong>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6"><small class="text-muted">Waste</small></div>
                                        <div class="col-6 text-end text-danger">
                                            <i
                                                class="fas fa-trash me-1"></i><strong>{{ number_format($item->waste, 2) }}</strong>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-2">
                                        <div class="col-6"><small class="text-muted">Stok Akhir</small></div>
                                        <div class="col-6 text-end">
                                            <strong class="fs-5">{{ number_format($item->stok_akhir, 2) }}</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6"><small class="text-muted">Status Stok</small></div>
                                        <div class="col-6 text-end">
                                            @if ($item->status_stok == 'SAFE')
                                                <span class="status-badge status-safe">SAFE</span>
                                            @else
                                                <span class="status-badge status-reorder">REORDER</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alasan Waste if exists -->
                        @if ($item->alasan_waste)
                            <div class="info-card">
                                <h6 class="fw-bold mb-2 text-primary">Alasan Waste</h6>
                                <p class="mb-0">{{ $item->alasan_waste }}</p>
                            </div>
                        @endif

                        <!-- Calculation Info -->
                        <div class="alert alert-light border mt-3">
                            <small>
                                <i class="fas fa-calculator me-2"></i>
                                <strong>Perhitungan:</strong> Stok Akhir = Stok Awal
                                ({{ number_format($item->stok_awal, 2) }})
                                + Masuk ({{ number_format($item->stok_masuk, 2) }})
                                - Keluar ({{ number_format($item->stok_keluar, 2) }})
                                - Waste ({{ number_format($item->waste, 2) }})
                                = <strong>{{ number_format($item->stok_akhir, 2) }}</strong>
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Tutup
                        </button>
                        @if (in_array(auth()->user()->role, ['admin', 'developer']))
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $item->id }}" data-bs-dismiss="modal">
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('stok-bar.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-edit me-2"></i>Edit Stok Bar
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanggal"
                                        value="{{ $item->tanggal->format('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Shift <span class="text-danger">*</span></label>
                                    <select class="form-select" name="shift" required>
                                        <option value="">Pilih Shift</option>
                                        <option value="1" {{ $item->shift == '1' ? 'selected' : '' }}>Shift 1
                                        </option>
                                        <option value="2" {{ $item->shift == '2' ? 'selected' : '' }}>Shift 2
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Bahan <span class="text-danger">*</span></label>
                                    <select class="form-select master-bahan-select" name="kode_bahan" required
                                        onchange="loadMasterBahanEdit(this.value, {{ $item->id }})">
                                        <option value="">Pilih Bahan</option>
                                        @foreach ($masterBar as $master)
                                            <option value="{{ $master->kode_bahan }}"
                                                {{ $item->kode_bahan == $master->kode_bahan ? 'selected' : '' }}>
                                                {{ $master->kode_bahan }} - {{ $master->nama_bahan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="nama_bahan" id="edit_nama_bahan{{ $item->id }}"
                                        value="{{ $item->nama_bahan }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Satuan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control satuan-input" name="nama_satuan"
                                        id="edit_nama_satuan{{ $item->id }}" value="{{ $item->nama_satuan }}"
                                        required readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="stok_awal"
                                        value="{{ $item->stok_awal }}" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Stok Masuk</label>
                                    <input type="number" step="0.01" class="form-control" name="stok_masuk"
                                        value="{{ $item->stok_masuk }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Stok Keluar</label>
                                    <input type="number" step="0.01" class="form-control" name="stok_keluar"
                                        value="{{ $item->stok_keluar }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Waste</label>
                                    <input type="number" step="0.01" class="form-control" name="waste"
                                        value="{{ $item->waste }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Alasan Waste</label>
                                    <textarea class="form-control" name="alasan_waste" rows="2">{{ $item->alasan_waste }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">PIC <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pic"
                                        value="{{ $item->pic }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Stok Akhir: <strong>{{ number_format($item->stok_akhir, 2) }}</strong> |
                                        Status:
                                        @if ($item->status_stok == 'SAFE')
                                            <span class="badge bg-success">SAFE</span>
                                        @else
                                            <span class="badge bg-danger">REORDER</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
                    <form action="{{ route('stok-bar.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title text-danger">
                                <i class="fas fa-trash me-2"></i>Hapus Stok Bar
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                                <h5 class="fw-bold">Konfirmasi Penghapusan</h5>
                            </div>
                            <p>Apakah Anda yakin ingin menghapus data stok bar berikut?</p>
                            <div class="alert alert-warning">
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Bahan</small>
                                        <div class="fw-bold">{{ $item->nama_bahan }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Kode</small>
                                        <div class="fw-bold">{{ $item->kode_bahan }}</div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <small class="text-muted">Tanggal</small>
                                        <div>{{ $item->tanggal->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Shift</small>
                                        <div>Shift {{ $item->shift }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>PERHATIAN:</strong> Data yang sudah dihapus tidak dapat dikembalikan!
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
@endsection

@push('scripts')
    <script>
        // Toggle Form Visibility
        function toggleForm() {
            const formSection = document.getElementById('formSection');
            if (formSection.style.display === 'none') {
                formSection.style.display = 'block';
                window.scrollTo({
                    top: formSection.offsetTop - 100,
                    behavior: 'smooth'
                });
                clearForm();
            } else {
                formSection.style.display = 'none';
            }
        }

        // Show Bahan Modal
        function showBahanModal() {
            const modal = new bootstrap.Modal(document.getElementById('bahanModal'));
            modal.show();
            loadBahanList();
        }

        // Load Bahan List
        function loadBahanList(search = '') {
            fetch(`/api/search-master-bar?search=${search}`)
                .then(response => response.json())
                .then(data => {
                    const bahanList = document.getElementById('bahanList');
                    bahanList.innerHTML = '';

                    if (data.length === 0) {
                        bahanList.innerHTML = `
                        <div class="text-center py-5">
                            <i class="fas fa-wine-bottle fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada bahan ditemukan</p>
                        </div>
                    `;
                        return;
                    }

                    data.forEach(bahan => {
                        const item = document.createElement('div');
                        item.className = 'bahan-item';
                        item.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">${bahan.nama_bahan}</h6>
                                <small class="text-muted">
                                    <span class="badge bg-secondary">${bahan.kode_bahan}</span>
                                    <span class="ms-2">Satuan: ${bahan.nama_satuan}</span>
                                    <span class="ms-2">Stok Min: ${bahan.stok_minimum}</span>
                                </small>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    `;
                        item.onclick = () => selectBahan(bahan);
                        bahanList.appendChild(item);
                    });
                })
                .catch(error => {
                    console.error('Error loading bahan:', error);
                    alert('Gagal memuat data bahan');
                });
        }

        // Search Bahan
        function searchBahan() {
            const searchTerm = document.getElementById('searchBahanInput').value;
            loadBahanList(searchTerm);
        }

        // Select Bahan
        function selectBahan(bahan) {
            // Update form fields
            document.getElementById('kode_bahan').value = bahan.kode_bahan;
            document.getElementById('nama_bahan').value = bahan.nama_bahan;
            document.getElementById('nama_satuan').value = bahan.nama_satuan;
            document.getElementById('searchBahan').value = `${bahan.kode_bahan} - ${bahan.nama_bahan}`;

            // Update info card
            document.getElementById('infoKodeBahan').textContent = bahan.kode_bahan;
            document.getElementById('infoSatuan').textContent = bahan.nama_satuan;
            document.getElementById('infoStokMinimum').textContent = bahan.stok_minimum;

            // Update unit labels
            const unit = bahan.nama_satuan;
            document.getElementById('stokAwalUnit').textContent = unit;
            document.getElementById('stokMasukUnit').textContent = unit;
            document.getElementById('stokKeluarUnit').textContent = unit;
            document.getElementById('wasteUnit').textContent = unit;
            document.getElementById('stokAkhirUnit').textContent = unit;

            // Get previous stock
            getPreviousStok();

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('bahanModal'));
            modal.hide();
        }

        // Get Previous Stock
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

                    if (data.source === 'previous_transaction') {
                        stokAwalInput.value = data.stok_awal;
                        stokAwalInfo.innerHTML = `
                        <i class="fas fa-check-circle me-1 text-success"></i>
                        Stok awal diambil dari transaksi sebelumnya: ${data.stok_akhir}
                    `;
                        stokAwalInfo.className = 'text-success mt-1 d-block';
                    } else if (data.source === 'master') {
                        stokAwalInput.value = data.stok_awal;
                        stokAwalInfo.innerHTML = `
                        <i class="fas fa-database me-1 text-primary"></i>
                        Stok awal diambil dari data master: ${data.stok_awal}
                    `;
                        stokAwalInfo.className = 'text-primary mt-1 d-block';
                    } else {
                        stokAwalInput.value = 0;
                        stokAwalInfo.innerHTML = `
                        <i class="fas fa-exclamation-triangle me-1 text-warning"></i>
                        Tidak ada data sebelumnya. Silakan isi stok awal manual.
                    `;
                        stokAwalInfo.className = 'text-warning mt-1 d-block';
                    }

                    calculateStokAkhir();
                })
                .catch(error => {
                    console.error('Error loading previous stok:', error);
                });
        }

        // Calculate Stock Akhir
        function calculateStokAkhir() {
            const stokAwal = parseFloat(document.getElementById('stok_awal').value) || 0;
            const stokMasuk = parseFloat(document.getElementById('stok_masuk').value) || 0;
            const stokKeluar = parseFloat(document.getElementById('stok_keluar').value) || 0;
            const waste = parseFloat(document.getElementById('waste').value) || 0;

            const stokAkhir = stokAwal + stokMasuk - stokKeluar - waste;
            document.getElementById('stok_akhir_preview').value = stokAkhir.toFixed(2);

            if (stokAkhir < 0) {
                document.getElementById('stok_akhir_preview').className = 'form-control fw-bold fs-5 text-danger';
            } else {
                document.getElementById('stok_akhir_preview').className = 'form-control fw-bold fs-5 text-primary';
            }
        }

        // Clear Form
        function clearForm() {
            document.getElementById('stokForm').reset();
            document.getElementById('kode_bahan').value = '';
            document.getElementById('nama_bahan').value = '';
            document.getElementById('nama_satuan').value = '';
            document.getElementById('searchBahan').value = '';
            document.getElementById('stok_awal').value = '';
            document.getElementById('stok_akhir_preview').value = '0.00';

            document.getElementById('infoKodeBahan').textContent = '-';
            document.getElementById('infoSatuan').textContent = '-';
            document.getElementById('infoStokMinimum').textContent = '-';

            document.getElementById('stokAwalUnit').textContent = '-';
            document.getElementById('stokMasukUnit').textContent = '-';
            document.getElementById('stokKeluarUnit').textContent = '-';
            document.getElementById('wasteUnit').textContent = '-';
            document.getElementById('stokAkhirUnit').textContent = '-';
        }

        // Load Master Bahan for Edit
        function loadMasterBahanEdit(kodeBahan, itemId) {
            if (!kodeBahan) return;

            fetch(`/api/master-bar/${kodeBahan}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById(`edit_nama_bahan${itemId}`).value = data.nama_bahan;
                    document.getElementById(`edit_nama_satuan${itemId}`).value = data.nama_satuan;
                })
                .catch(error => {
                    console.error('Error loading master bahan:', error);
                    alert('Gagal memuat data master bahan');
                });
        }

        // Handle Export Form Submission
        document.addEventListener('DOMContentLoaded', function() {
            const exportForm = document.getElementById('exportForm');
            if (exportForm) {
                exportForm.addEventListener('submit', function(e) {
                    const startDate = document.getElementById('export_start_date').value;
                    const endDate = document.getElementById('export_end_date').value;
                    
                    if (!startDate || !endDate) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Tanggal Harus Diisi!',
                            text: 'Silakan pilih tanggal mulai dan tanggal akhir',
                            confirmButtonColor: '#8a2387'
                        });
                        return false;
                    }
                    
                    if (new Date(startDate) > new Date(endDate)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Tanggal Tidak Valid!',
                            text: 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir',
                            confirmButtonColor: '#8a2387'
                        });
                        return false;
                    }
                    
                    // Tampilkan loading state
                    const exportButton = document.getElementById('exportButton');
                    exportButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Membuat Excel...';
                    exportButton.disabled = true;
                    
                    // Auto close modal setelah download
                    setTimeout(function() {
                        const exportModal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
                        if (exportModal) {
                            exportModal.hide();
                        }
                        // Reset button state
                        exportButton.innerHTML = '<i class="fas fa-download me-1"></i> Download Excel';
                        exportButton.disabled = false;
                    }, 2000);
                });
            }
            
            // Set default dates untuk export modal
            const exportModal = document.getElementById('exportModal');
            if (exportModal) {
                exportModal.addEventListener('show.bs.modal', function() {
                    const today = new Date();
                    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                    
                    document.getElementById('export_start_date').value = firstDay.toISOString().split('T')[0];
                    document.getElementById('export_end_date').value = today.toISOString().split('T')[0];
                });
            }

            // Event Listeners for real-time calculation
            const stockFields = ['stok_awal', 'stok_masuk', 'stok_keluar', 'waste'];
            stockFields.forEach(field => {
                const element = document.getElementById(field);
                if (element) {
                    element.addEventListener('input', calculateStokAkhir);
                }
            });

            const stokForm = document.getElementById('stokForm');
            if (stokForm) {
                stokForm.addEventListener('submit', function(e) {
                    const stokAwal = parseFloat(document.getElementById('stok_awal').value) || 0;
                    const stokMasuk = parseFloat(document.getElementById('stok_masuk').value) || 0;
                    const stokKeluar = parseFloat(document.getElementById('stok_keluar').value) || 0;
                    const waste = parseFloat(document.getElementById('waste').value) || 0;

                    const stokAkhir = stokAwal + stokMasuk - stokKeluar - waste;

                    if (stokAkhir < 0) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Stok Akhir Negatif!',
                            text: 'Stok akhir tidak boleh negatif. Periksa kembali input stok keluar dan waste.',
                            confirmButtonColor: '#8a2387'
                        });
                        return false;
                    }

                    if (!document.getElementById('kode_bahan').value) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pilih Bahan!',
                            text: 'Silakan pilih bahan terlebih dahulu.',
                            confirmButtonColor: '#8a2387'
                        });
                        return false;
                    }
                });
            }
        });

        // Auto-close alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush