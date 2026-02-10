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
            max-height: 400px;
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
            background: rgba(138, 35, 135, 0.1);
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

        /* Styles untuk Multiple Bahan */
        .bahan-card {
            background: white;
            border: 2px solid #eef2f7;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .bahan-card:hover {
            border-color: #8a2387;
            box-shadow: 0 5px 15px rgba(138, 35, 135, 0.1);
        }

        .bahan-card.selected {
            border-color: #0ba360;
            background-color: rgba(11, 163, 96, 0.05);
        }

        .bahan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eef2f7;
        }

        .bahan-title {
            font-weight: 600;
            color: #8a2387;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .remove-bahan {
            background: #dc3545;
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .remove-bahan:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        .selected-bahan-list {
            max-height: 300px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #eef2f7;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .selected-bahan-item {
            background: #f8f9fa;
            border: 1px solid #eef2f7;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .selected-bahan-info {
            flex: 1;
        }

        .selected-bahan-actions {
            display: flex;
            gap: 5px;
        }

        .empty-bahan {
            text-align: center;
            padding: 30px;
            color: #6c757d;
        }

        .empty-bahan i {
            font-size: 3em;
            margin-bottom: 10px;
        }

        /* Checkbox styling untuk modal */
        .bahan-checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .bahan-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .bahan-info {
            flex: 1;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .btn {
                padding: 8px 15px;
                font-size: 0.9rem;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .form-section {
                padding: 20px 15px;
            }

            .table-responsive {
                font-size: 0.9rem;
            }

            .bahan-card {
                padding: 15px;
            }
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
                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <label class="form-label">Status Stok</label>
                            <select class="form-select" name="status_stok">
                                <option value="">Semua Status</option>
                                <option value="SAFE" {{ request('status_stok') == 'SAFE' ? 'selected' : '' }}>SAFE
                                </option>
                                <option value="REORDER" {{ request('status_stok') == 'REORDER' ? 'selected' : '' }}>REORDER
                                </option>
                            </select>
                        </div>
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

                            @if (request()->anyFilled(['start_date', 'end_date', 'nama_bahan', 'shift', 'status_stok']))
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
                                        <th style="width: 120px">Tanggal & Jam</th>
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
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $item->created_at->format('H:i') }}
                                                </small>
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
                                    <i class="fas fa-plus-circle me-2 text-primary"></i> Form Input Stok Bar (Multiple
                                    Bahan)
                                </h5>
                                <button type="button" class="btn btn-outline-secondary" onclick="toggleForm()">
                                    <i class="fas fa-times me-1"></i> Tutup Form
                                </button>
                            </div>

                            <!-- Header Form (Tanggal, Shift, PIC) -->
                            <form action="{{ route('stok-bar.store') }}" method="POST" id="stokForm">
                                @csrf
                                <input type="hidden" name="bahan" id="bahanDataInput">

                                <div class="row mb-4">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-semibold">
                                            Tanggal <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                            name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" readonly required>
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-semibold">Shift <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('shift') is-invalid @enderror" name="shift"
                                            id="shift" required>
                                            <option value="">Pilih Shift</option>
                                            <option value="1">Shift 1</option>
                                            <option value="2">Shift 2</option>
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
                                    <div class="col-md-3 mb-3 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary w-100" onclick="showBahanModal()">
                                            <i class="fas fa-plus me-1"></i> Tambah Bahan
                                        </button>
                                    </div>
                                </div>

                                <!-- Daftar Bahan yang Dipilih -->
                                <div class="mb-4">
                                    <h6 class="fw-semibold mb-3">
                                        <i class="fas fa-list me-2"></i> Daftar Bahan yang Akan Disimpan
                                        <span class="badge bg-primary ms-2" id="bahanCount">0</span>
                                    </h6>

                                    <div id="selectedBahanList" class="selected-bahan-list">
                                        <div class="empty-bahan">
                                            <i class="fas fa-wine-bottle"></i>
                                            <p class="mb-0">Belum ada bahan dipilih</p>
                                            <small class="text-muted">Klik "Tambah Bahan" untuk menambahkan</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                    <button type="button" class="btn btn-lg btn-outline-secondary"
                                        onclick="toggleForm()">
                                        <i class="fas fa-times me-2"></i> Batal
                                    </button>
                                    <button type="submit" class="btn btn-lg btn-primary" id="submitButton" disabled>
                                        <i class="fas fa-save me-2"></i> Simpan Semua (<span id="bahanCountBtn">0</span>
                                        bahan)
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pilih Bahan (Multiple Selection) -->
    <div class="modal fade" id="bahanModal" tabindex="-1" aria-labelledby="bahanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bahanModalLabel">
                        <i class="fas fa-wine-bottle me-2"></i>Pilih Bahan Bar (Multiple Selection)
                        <span class="badge bg-primary ms-2" id="totalBahanCount">0 bahan tersedia</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Search Box -->
                    <div class="search-box mb-4">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" id="searchBahanInput"
                            placeholder="Cari bahan berdasarkan kode atau nama..." oninput="searchBahan()">
                    </div>

                    <!-- Selected Count and Actions -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="badge bg-success" id="selectedCountModal">0 bahan dipilih</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="selectAllBahan()">
                                <i class="fas fa-check-square me-1"></i> Pilih Semua
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllBahan()">
                                <i class="fas fa-square me-1"></i> Batal Semua
                            </button>
                            <button type="button" class="btn btn-sm btn-success" onclick="addSelectedBahan()">
                                <i class="fas fa-check me-1"></i> Tambahkan yang Dipilih
                            </button>
                        </div>
                    </div>

                    <!-- Bahan List -->
                    <div class="bahan-list" id="bahanList">
                        <div class="text-center py-5">
                            <i class="fas fa-spinner fa-spin fa-3x text-primary mb-3"></i>
                            <p class="text-muted">Memuat data bahan...</p>
                        </div>
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

    <!-- Modal untuk Input Detail Bahan -->
    <div class="modal fade" id="detailBahanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Input Detail Stok
                        <span class="badge bg-primary ms-2" id="detailBahanCounter"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailBahanModalBody">
                    <!-- Content akan diisi oleh JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Lewati
                    </button>
                    <button type="button" class="btn btn-primary" onclick="saveBahanDetail()">
                        <i class="fas fa-save me-1"></i> Simpan & Lanjut
                    </button>
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
                            <label for="export_start_date" class="form-label">Tanggal Mulai <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="export_start_date" name="export_start_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="export_end_date" class="form-label">Tanggal Akhir <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="export_end_date" name="export_end_date"
                                required>
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

    <!-- Modals lainnya (Detail, Edit, Delete untuk data yang sudah ada) -->
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
        // Global variables
        let allMasterBahan = []; // Semua bahan dari master
        let selectedBahan = []; // Bahan yang dipilih di modal (sementara)
        let bahanDetailList = []; // Bahan yang sudah diinput detailnya
        let currentBahanIndex = 0; // Index bahan yang sedang diproses

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
            loadAllMasterBahan();
        }

        // Load All Master Bahan
        function loadAllMasterBahan() {
            fetch(`/api/search-master-bar?search=`)
                .then(response => response.json())
                .then(data => {
                    allMasterBahan = data;
                    renderBahanList();
                })
                .catch(error => {
                    console.error('Error loading bahan:', error);
                    alert('Gagal memuat data bahan');
                });
        }

        // Render Bahan List in Modal
        function renderBahanList(searchTerm = '') {
            const bahanListElement = document.getElementById('bahanList');
            const totalBahanCount = document.getElementById('totalBahanCount');

            // Filter bahan berdasarkan search term
            const filteredBahan = allMasterBahan.filter(bahan => {
                if (!searchTerm) return true;
                const searchLower = searchTerm.toLowerCase();
                return bahan.nama_bahan.toLowerCase().includes(searchLower) ||
                    bahan.kode_bahan.toLowerCase().includes(searchLower);
            });

            if (filteredBahan.length === 0) {
                bahanListElement.innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-wine-bottle fa-3x text-muted mb-3"></i>
                <p class="text-muted">Tidak ada bahan ditemukan</p>
                <small>Ubah kata kunci pencarian</small>
            </div>
        `;
                totalBahanCount.textContent = '0 bahan tersedia';
                return;
            }

            let html = '';
            filteredBahan.forEach(bahan => {
                const isSelected = selectedBahan.some(b => b.kode_bahan === bahan.kode_bahan);

                html += `
            <div class="bahan-item ${isSelected ? 'selected' : ''}" onclick="toggleBahanSelection('${bahan.kode_bahan}')">
                <div class="bahan-checkbox-container">
                    <input type="checkbox" class="form-check-input bahan-checkbox" 
                           id="checkbox-${bahan.kode_bahan}" 
                           ${isSelected ? 'checked' : ''}
                           onclick="event.stopPropagation(); toggleBahanSelection('${bahan.kode_bahan}')">
                    <div class="bahan-info">
                        <h6 class="mb-1">${bahan.nama_bahan}</h6>
                        <small class="text-muted">
                            <span class="badge bg-secondary">${bahan.kode_bahan}</span>
                            <span class="ms-2">Satuan: ${bahan.nama_satuan}</span>
                            <span class="ms-2">Stok Min: ${bahan.stok_minimum}</span>
                        </small>
                    </div>
                </div>
            </div>
        `;
            });

            bahanListElement.innerHTML = html;
            totalBahanCount.textContent = `${filteredBahan.length} bahan tersedia`;
            updateSelectedCountModal();
        }

        // Toggle Bahan Selection
        function toggleBahanSelection(kodeBahan) {
            const bahan = allMasterBahan.find(b => b.kode_bahan === kodeBahan);
            if (!bahan) return;

            const index = selectedBahan.findIndex(b => b.kode_bahan === kodeBahan);
            const checkbox = document.getElementById(`checkbox-${kodeBahan}`);

            if (index === -1) {
                // Tambahkan ke selected
                selectedBahan.push({
                    ...bahan,
                    stok_awal: 0,
                    stok_masuk: 0,
                    stok_keluar: 0,
                    waste: 0,
                    alasan_waste: ''
                });
                checkbox.checked = true;
            } else {
                // Hapus dari selected
                selectedBahan.splice(index, 1);
                checkbox.checked = false;
            }

            // Update UI
            const item = checkbox.closest('.bahan-item');
            if (checkbox.checked) {
                item.classList.add('selected');
            } else {
                item.classList.remove('selected');
            }

            updateSelectedCountModal();
        }

        // Select All Bahan
        function selectAllBahan() {
            const searchTerm = document.getElementById('searchBahanInput').value;
            const filteredBahan = allMasterBahan.filter(bahan => {
                if (!searchTerm) return true;
                const searchLower = searchTerm.toLowerCase();
                return bahan.nama_bahan.toLowerCase().includes(searchLower) ||
                    bahan.kode_bahan.toLowerCase().includes(searchLower);
            });

            filteredBahan.forEach(bahan => {
                const index = selectedBahan.findIndex(b => b.kode_bahan === bahan.kode_bahan);
                if (index === -1) {
                    selectedBahan.push({
                        ...bahan,
                        stok_awal: 0,
                        stok_masuk: 0,
                        stok_keluar: 0,
                        waste: 0,
                        alasan_waste: ''
                    });
                }
            });

            renderBahanList(searchTerm);
        }

        // Deselect All Bahan
        function deselectAllBahan() {
            const searchTerm = document.getElementById('searchBahanInput').value;
            const filteredBahan = allMasterBahan.filter(bahan => {
                if (!searchTerm) return true;
                const searchLower = searchTerm.toLowerCase();
                return bahan.nama_bahan.toLowerCase().includes(searchLower) ||
                    bahan.kode_bahan.toLowerCase().includes(searchLower);
            });

            filteredBahan.forEach(bahan => {
                const index = selectedBahan.findIndex(b => b.kode_bahan === bahan.kode_bahan);
                if (index !== -1) {
                    selectedBahan.splice(index, 1);
                }
            });

            renderBahanList(searchTerm);
        }

        // Update Selected Count in Modal
        function updateSelectedCountModal() {
            const countElement = document.getElementById('selectedCountModal');
            countElement.textContent = `${selectedBahan.length} bahan dipilih`;
        }

        // Search Bahan
        function searchBahan() {
            const searchTerm = document.getElementById('searchBahanInput').value;
            renderBahanList(searchTerm);
        }

        // Add Selected Bahan to Form
        function addSelectedBahan() {
            if (selectedBahan.length === 0) {
                alert('Silakan pilih minimal satu bahan');
                return;
            }

            // Reset bahan detail list
            bahanDetailList = [];

            // Tutup modal bahan
            const modal = bootstrap.Modal.getInstance(document.getElementById('bahanModal'));
            modal.hide();

            // Mulai proses input detail
            currentBahanIndex = 0;
            showDetailBahanModal();
        }

        // Show Detail Bahan Modal
        function showDetailBahanModal() {
            if (currentBahanIndex >= selectedBahan.length) {
                // Semua bahan sudah diinput, update UI
                updateSelectedBahanList();
                return;
            }

            const bahan = selectedBahan[currentBahanIndex];

            // Update counter
            document.getElementById('detailBahanCounter').textContent =
                `(${currentBahanIndex + 1} dari ${selectedBahan.length})`;

            // Fetch previous stok data
            const tanggal = document.getElementById('tanggal').value;
            const shift = document.getElementById('shift').value;

            // Build modal content
            let modalContent = `
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="alert alert-info">
                    <h6 class="mb-2"><i class="fas fa-wine-bottle me-2"></i>${bahan.nama_bahan}</h6>
                    <small class="d-block">
                        <span class="badge bg-secondary me-2">${bahan.kode_bahan}</span>
                        <span class="me-2">Satuan: ${bahan.nama_satuan}</span>
                        <span>Stok Min: ${bahan.stok_minimum}</span>
                    </small>
                </div>
            </div>
        </div>
        
        <form id="detailBahanForm">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                    Stok Awal <span class="text-danger">*</span>
                    </label>
                        <div class="input-group">
                            <input type="number"
                             step="0.01"
                             class="form-control"
                             id="detail_stok_awal"
                             value="${bahan.stok_awal}"
                             readonly
                             required>
                            <span class="input-group-text">${bahan.nama_satuan}</span>
                        </div>
                    <small class="text-muted" id="stokAwalSource"></small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok Masuk</label>
                    <div class="input-group">
                        <input type="number" step="0.01" class="form-control" 
                               id="detail_stok_masuk" value="${bahan.stok_masuk}">
                        <span class="input-group-text">${bahan.nama_satuan}</span>
                    </div>
                    <small class="text-muted">Isi jika ada penambahan stok</small>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok Keluar</label>
                    <div class="input-group">
                        <input type="number" step="0.01" class="form-control" 
                               id="detail_stok_keluar" value="${bahan.stok_keluar}">
                        <span class="input-group-text">${bahan.nama_satuan}</span>
                    </div>
                    <small class="text-muted">Isi jika ada pengurangan stok</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Waste</label>
                    <div class="input-group">
                        <input type="number" step="0.01" class="form-control" 
                               id="detail_waste" value="${bahan.waste}">
                        <span class="input-group-text">${bahan.nama_satuan}</span>
                    </div>
                    <small class="text-muted">Isi jika ada waste/rusak</small>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Alasan Waste (Opsional)</label>
                    <textarea class="form-control" id="detail_alasan_waste" rows="2">${bahan.alasan_waste || ''}</textarea>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-light border">
                        <small>
                            <i class="fas fa-calculator me-2"></i>
                            <strong>Perhitungan Stok Akhir:</strong>
                            <span id="perhitunganText"></span>
                        </small>
                    </div>
                </div>
            </div>
            
            <input type="hidden" id="detail_kode_bahan" value="${bahan.kode_bahan}">
            <input type="hidden" id="detail_nama_bahan" value="${bahan.nama_bahan}">
            <input type="hidden" id="detail_nama_satuan" value="${bahan.nama_satuan}">
        </form>
    `;

            document.getElementById('detailBahanModalBody').innerHTML = modalContent;

            // Fetch previous stok data
            fetchPreviousStok(bahan.kode_bahan, tanggal, shift);

            // Add event listeners for real-time calculation
            const inputs = ['detail_stok_awal', 'detail_stok_masuk', 'detail_stok_keluar', 'detail_waste'];
            inputs.forEach(id => {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', updatePerhitungan);
                }
            });

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('detailBahanModal'));
            modal.show();
            updatePerhitungan();
        }

        // Fetch Previous Stok Data
        function fetchPreviousStok(kodeBahan, tanggal, shift) {
            if (!tanggal || !shift) {
                document.getElementById('stokAwalSource').innerHTML =
                    '<span class="text-danger">Harap isi tanggal dan shift terlebih dahulu</span>';
                return;
            }

            fetch(`/api/previous-stok-bar?kode_bahan=${kodeBahan}&tanggal=${tanggal}&shift=${shift}`)
                .then(response => response.json())
                .then(data => {
                    const stokAwalInput = document.getElementById('detail_stok_awal');
                    const stokAwalSource = document.getElementById('stokAwalSource');

                    if (data.stok_awal !== undefined) {
                        stokAwalInput.value = data.stok_awal;

                        let sourceText = '';
                        switch (data.source) {
                            case 'same_shift_transaction':
                                sourceText =
                                    `Diambil dari transaksi sebelumnya dalam shift yang sama (${data.tanggal_transaksi} Shift ${data.shift_transaksi} ${data.waktu_transaksi})`;
                                break;
                            case 'previous_shift_same_day':
                                sourceText =
                                    `Diambil dari shift sebelumnya (${data.tanggal_transaksi} Shift ${data.shift_transaksi} ${data.waktu_transaksi})`;
                                break;
                            case 'previous_day_shift_2':
                                sourceText =
                                    `Diambil dari Shift 2 hari sebelumnya (${data.tanggal_transaksi} Shift ${data.shift_transaksi} ${data.waktu_transaksi})`;
                                break;
                            case 'any_previous_transaction':
                                sourceText =
                                    `Diambil dari transaksi terakhir (${data.tanggal_transaksi} Shift ${data.shift_transaksi} ${data.waktu_transaksi})`;
                                break;
                            case 'master':
                                sourceText = `Diambil dari data master (tidak ada transaksi sebelumnya)`;
                                break;
                            default:
                                sourceText = `Diambil dari sistem`;
                        }

                        stokAwalSource.innerHTML = `<span class="text-success">${sourceText}</span>`;
                    }

                    updatePerhitungan();
                })
                .catch(error => {
                    console.error('Error fetching previous stok:', error);
                    document.getElementById('stokAwalSource').innerHTML =
                        '<span class="text-danger">Gagal mengambil data stok sebelumnya</span>';
                });
        }

        // Update Perhitungan Display
        function updatePerhitungan() {
            const stokAwalInput = document.getElementById('detail_stok_awal');
            const stokMasukInput = document.getElementById('detail_stok_masuk');
            const stokKeluarInput = document.getElementById('detail_stok_keluar');
            const wasteInput = document.getElementById('detail_waste');

            if (!stokAwalInput || !stokMasukInput || !stokKeluarInput || !wasteInput) return;

            const stokAwal = parseFloat(stokAwalInput.value) || 0;
            const stokMasuk = parseFloat(stokMasukInput.value) || 0;
            const stokKeluar = parseFloat(stokKeluarInput.value) || 0;
            const waste = parseFloat(wasteInput.value) || 0;

            const stokAkhir = stokAwal + stokMasuk - stokKeluar - waste;

            const perhitunganText = document.getElementById('perhitunganText');
            if (perhitunganText) {
                perhitunganText.innerHTML = `
            ${stokAwal.toFixed(2)} + ${stokMasuk.toFixed(2)} - ${stokKeluar.toFixed(2)} - ${waste.toFixed(2)} = 
            <strong>${stokAkhir.toFixed(2)}</strong>
        `;
            }
        }

        // Save Bahan Detail
        function saveBahanDetail() {
            // Validate form
            const form = document.getElementById('detailBahanForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Get form values
            const kode_bahan = document.getElementById('detail_kode_bahan').value;
            const nama_bahan = document.getElementById('detail_nama_bahan').value;
            const nama_satuan = document.getElementById('detail_nama_satuan').value;
            const stok_awal = parseFloat(document.getElementById('detail_stok_awal').value) || 0;
            const stok_masuk = parseFloat(document.getElementById('detail_stok_masuk').value) || 0;
            const stok_keluar = parseFloat(document.getElementById('detail_stok_keluar').value) || 0;
            const waste = parseFloat(document.getElementById('detail_waste').value) || 0;
            const alasan_waste = document.getElementById('detail_alasan_waste').value;

            // Calculate stok akhir
            const stok_akhir = stok_awal + stok_masuk - stok_keluar - waste;

            // Find and update in selectedBahan
            const index = selectedBahan.findIndex(b => b.kode_bahan === kode_bahan);
            if (index !== -1) {
                selectedBahan[index] = {
                    ...selectedBahan[index],
                    stok_awal,
                    stok_masuk,
                    stok_keluar,
                    waste,
                    alasan_waste,
                    stok_akhir
                };

                // Add to bahanDetailList if not already exists
                const existsIndex = bahanDetailList.findIndex(b => b.kode_bahan === kode_bahan);
                if (existsIndex === -1) {
                    bahanDetailList.push(selectedBahan[index]);
                } else {
                    bahanDetailList[existsIndex] = selectedBahan[index];
                }
            }

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('detailBahanModal'));
            modal.hide();

            // Move to next bahan
            currentBahanIndex++;
            setTimeout(() => {
                if (currentBahanIndex < selectedBahan.length) {
                    showDetailBahanModal();
                } else {
                    updateSelectedBahanList();
                }
            }, 300);
        }

        // Update Selected Bahan List in Form
        function updateSelectedBahanList() {
            const selectedBahanListElement = document.getElementById('selectedBahanList');
            const bahanCountElement = document.getElementById('bahanCount');
            const bahanCountBtnElement = document.getElementById('bahanCountBtn');
            const submitButton = document.getElementById('submitButton');

            if (bahanDetailList.length === 0) {
                selectedBahanListElement.innerHTML = `
            <div class="empty-bahan">
                <i class="fas fa-wine-bottle"></i>
                <p class="mb-0">Belum ada bahan dipilih</p>
                <small class="text-muted">Klik "Tambah Bahan" untuk menambahkan</small>
            </div>
        `;
                bahanCountElement.textContent = '0';
                bahanCountBtnElement.textContent = '0';
                submitButton.disabled = true;
                return;
            }

            // Build selected bahan list
            let html = '';
            bahanDetailList.forEach((bahan, index) => {
                const stokAkhir = bahan.stok_akhir || 0;

                html += `
            <div class="selected-bahan-item" id="bahan-item-${index}">
                <div class="selected-bahan-info">
                    <h6 class="mb-1">${bahan.nama_bahan}</h6>
                    <small class="text-muted d-block">
                        <span class="badge bg-secondary me-2">${bahan.kode_bahan}</span>
                        <span class="me-2">Satuan: ${bahan.nama_satuan}</span>
                        <span class="me-2">Awal: ${bahan.stok_awal.toFixed(2)}</span>
                        <span class="me-2">Masuk: ${bahan.stok_masuk.toFixed(2)}</span>
                        <span class="me-2">Keluar: ${bahan.stok_keluar.toFixed(2)}</span>
                        <span class="me-2">Waste: ${bahan.waste.toFixed(2)}</span>
                        <span class="badge bg-success">Akhir: ${stokAkhir.toFixed(2)}</span>
                    </small>
                    ${bahan.alasan_waste ? `<small class="text-muted d-block mt-1">Alasan Waste: ${bahan.alasan_waste}</small>` : ''}
                </div>
                <div class="selected-bahan-actions">
                    <button type="button" class="btn btn-sm btn-warning" onclick="editBahanDetail(${index})" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeBahanDetail(${index})" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
            });

            selectedBahanListElement.innerHTML = html;
            const count = bahanDetailList.length;
            bahanCountElement.textContent = count;
            bahanCountBtnElement.textContent = count;
            submitButton.disabled = false;
        }

        // Edit Bahan Detail
        function editBahanDetail(index) {
            const bahan = bahanDetailList[index];

            // Find index in selectedBahan
            const selectedIndex = selectedBahan.findIndex(b => b.kode_bahan === bahan.kode_bahan);
            if (selectedIndex !== -1) {
                currentBahanIndex = selectedIndex;
                showDetailBahanModal();
            }
        }

        // Remove Bahan Detail
        function removeBahanDetail(index) {
            if (confirm('Apakah Anda yakin ingin menghapus bahan ini dari list?')) {
                const bahan = bahanDetailList[index];

                // Remove from all lists
                bahanDetailList.splice(index, 1);

                // Find and remove from selectedBahan
                const selectedIndex = selectedBahan.findIndex(b => b.kode_bahan === bahan.kode_bahan);
                if (selectedIndex !== -1) {
                    selectedBahan.splice(selectedIndex, 1);
                }

                // Update UI
                updateSelectedBahanList();
            }
        }

        // Clear Form
        function clearForm() {
            selectedBahan = [];
            bahanDetailList = [];
            currentBahanIndex = 0;

            // Set default tanggal ke hari ini
            const tanggalInput = document.getElementById('tanggal');
            if (tanggalInput) {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');

                tanggalInput.value = `${year}-${month}-${day}`;
            }

            // Reset shift dan PIC
            const shiftSelect = document.getElementById('shift');
            if (shiftSelect) {
                shiftSelect.value = '';
            }

            const picInput = document.getElementById('pic');
            if (picInput) {
                picInput.value = '{{ auth()->user()->name }}';
            }

            // Clear bahan list
            updateSelectedBahanList();

            // Clear modal state
            if (document.getElementById('searchBahanInput')) {
                document.getElementById('searchBahanInput').value = '';
            }
        }

        // Form Submission
        document.addEventListener('DOMContentLoaded', function() {
            const stokForm = document.getElementById('stokForm');
            if (stokForm) {
                stokForm.addEventListener('submit', function(e) {
                    // Validasi client-side
                    if (bahanDetailList.length === 0) {
                        e.preventDefault();
                        alert('Silakan tambahkan minimal satu bahan');
                        return false;
                    }

                    // Validate required fields
                    const tanggal = document.getElementById('tanggal').value;
                    const shift = document.getElementById('shift').value;
                    const pic = document.getElementById('pic').value;

                    if (!tanggal || !shift || !pic) {
                        e.preventDefault();
                        alert('Harap isi semua field yang wajib diisi (Tanggal, Shift, PIC)');
                        return false;
                    }

                    // Prepare bahan data for submission
                    const bahanData = bahanDetailList.map(bahan => ({
                        kode_bahan: bahan.kode_bahan,
                        nama_bahan: bahan.nama_bahan,
                        nama_satuan: bahan.nama_satuan,
                        stok_awal: parseFloat(bahan.stok_awal) || 0,
                        stok_masuk: parseFloat(bahan.stok_masuk) || 0,
                        stok_keluar: parseFloat(bahan.stok_keluar) || 0,
                        waste: parseFloat(bahan.waste) || 0,
                        alasan_waste: bahan.alasan_waste || ''
                    }));

                    // Set hidden input value
                    document.getElementById('bahanDataInput').value = JSON.stringify(bahanData);

                    // Show loading state
                    const submitButton = document.getElementById('submitButton');
                    const originalText = submitButton.innerHTML;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
                    submitButton.disabled = true;

                    // Biarkan form submit secara normal
                    // Browser akan redirect ke halaman index dengan data baru

                    // Reset form state setelah submit
                    setTimeout(() => {
                        clearForm();
                        toggleForm();
                    }, 100);

                    return true;
                });
            }
        });

        // Helper: Show Alert
        function showAlert(type, message) {
            const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-3" style="font-size: 1.5em;"></i>
            <div class="flex-grow-1">${message}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

            // Insert at the beginning of card body
            const cardBody = document.querySelector('.card-body');
            if (cardBody) {
                cardBody.insertAdjacentHTML('afterbegin', alertHtml);

                // Auto dismiss after 5 seconds
                setTimeout(() => {
                    const alert = document.querySelector('.alert');
                    if (alert) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            }
        }

        // Load Master Bahan for Edit Form
        function loadMasterBahanEdit(kodeBahan, itemId) {
            fetch(`/api/master-bahan-bar/${kodeBahan}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        document.getElementById(`edit_nama_bahan${itemId}`).value = data.nama_bahan;
                        document.getElementById(`edit_nama_satuan${itemId}`).value = data.nama_satuan;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Export Form Validation
        document.addEventListener('DOMContentLoaded', function() {
            const exportForm = document.getElementById('exportForm');
            if (exportForm) {
                exportForm.addEventListener('submit', function(e) {
                    const startDate = document.getElementById('export_start_date').value;
                    const endDate = document.getElementById('export_end_date').value;

                    if (!startDate || !endDate) {
                        e.preventDefault();
                        alert('Harap isi tanggal mulai dan tanggal akhir');
                        return;
                    }

                    if (new Date(startDate) > new Date(endDate)) {
                        e.preventDefault();
                        alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                        return;
                    }
                });
            }

            // Set default dates for export modal
            const exportStartDate = document.getElementById('export_start_date');
            const exportEndDate = document.getElementById('export_end_date');

            if (exportStartDate) {
                exportStartDate.value = new Date().toISOString().split('T')[0];
            }
            if (exportEndDate) {
                exportEndDate.value = new Date().toISOString().split('T')[0];
            }

            // Set default tanggal untuk form input
            const tanggalInput = document.getElementById('tanggal');
            if (tanggalInput) {
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');

                tanggalInput.value = `${year}-${month}-${day}`;
            }

            // Auto-select shift based on current time
            const currentHour = new Date().getHours();
            const shiftSelect = document.getElementById('shift');
            if (shiftSelect) {
                if (currentHour >= 6 && currentHour < 18) {
                    shiftSelect.value = '1';
                } else {
                    shiftSelect.value = '2';
                }
            }

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Real-time filtering for edit modal bahan select
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.master-bahan-select').forEach(select => {
                select.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const options = this.options;

                    for (let option of options) {
                        const text = option.text.toLowerCase();
                        option.style.display = text.includes(searchTerm) ? '' : 'none';
                    }
                });
            });
        });

        // Additional helper functions
        function formatNumber(num) {
            return parseFloat(num).toLocaleString('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function calculateStokAkhir(row) {
            const stokAwal = parseFloat(row.stok_awal) || 0;
            const stokMasuk = parseFloat(row.stok_masuk) || 0;
            const stokKeluar = parseFloat(row.stok_keluar) || 0;
            const waste = parseFloat(row.waste) || 0;
            return stokAwal + stokMasuk - stokKeluar - waste;
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + F to focus on search
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                const searchInput = document.querySelector('input[name="nama_bahan"]');
                if (searchInput) {
                    searchInput.focus();
                }
            }

            // Ctrl + N to toggle form
            if (e.ctrlKey && e.key === 'n') {
                e.preventDefault();
                toggleForm();
            }
        });

        // Print functionality (optional)
        function printTable() {
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
        <html>
            <head>
                <title>Cetak Stok Bar - ${new Date().toLocaleDateString('id-ID')}</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                    @media print {
                        @page { size: landscape; }
                    }
                </style>
            </head>
            <body>
                <h2>Laporan Stok Bar</h2>
                <p>Tanggal Cetak: ${new Date().toLocaleString('id-ID')}</p>
                ${document.querySelector('.table-container').innerHTML}
            </body>
        </html>
    `);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endpush
