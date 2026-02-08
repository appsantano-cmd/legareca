@extends('layouts.stok_station')

@section('title', 'Master Bahan Bar')

@push('styles')
    <style>
        /* Modern Professional Styles */
        .master-bar-container {
            padding: 20px;
            background-color: #f8f9fa;
            margin-top: 0;
        }

        /* Stats Cards */
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            flex: 1;
            min-width: 200px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.purple {
            border-left: 4px solid #9b59b6;
        }

        .stat-card.green {
            border-left: 4px solid #2ecc71;
        }

        .stat-card.red {
            border-left: 4px solid #e74c3c;
        }

        .stat-card.indigo {
            border-left: 4px solid #34495e;
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-right: 15px;
        }

        .stat-card.purple .stat-icon {
            color: #9b59b6;
        }

        .stat-card.green .stat-icon {
            color: #2ecc71;
        }

        .stat-card.red .stat-icon {
            color: #e74c3c;
        }

        .stat-card.indigo .stat-icon {
            color: #34495e;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .stat-info p {
            margin: 5px 0 0;
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        /* Filter Card */
        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .filter-card h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 1.2rem;
        }

        .filter-card h3 i {
            margin-right: 10px;
            color: #9b59b6;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            color: #34495e;
            font-weight: 500;
        }

        .form-group label i {
            margin-right: 8px;
            color: #7f8c8d;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #9b59b6;
            box-shadow: 0 0 0 2px rgba(155, 89, 182, 0.2);
            outline: none;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background: #9b59b6;
            color: white;
        }

        .btn-primary:hover {
            background: #8e44ad;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(155, 89, 182, 0.3);
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(149, 165, 166, 0.3);
        }

        /* Main Card */
        .main-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
            padding: 20px 25px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .header-title {
            display: flex;
            align-items: center;
        }

        .header-title i {
            font-size: 1.5rem;
            margin-right: 12px;
        }

        .header-title h3 {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 600;
        }

        .header-title p {
            margin: 5px 0 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .btn-success {
            background: #2ecc71;
            color: white;
        }

        .btn-success:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(243, 156, 18, 0.3);
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
            padding: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .data-table thead {
            background: #f8f9fa;
        }

        .data-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #dee2e6;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            color: #34495e;
        }

        .data-table tbody tr {
            transition: background-color 0.2s;
        }

        .data-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }

        .badge i {
            margin-right: 5px;
        }

        .badge-purple {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .badge-secondary {
            background: #f5f5f5;
            color: #666;
        }

        .badge-success {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-danger {
            background: #ffebee;
            color: #c62828;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-action i {
            font-size: 14px;
        }

        .btn-edit {
            background: #ff9800;
            color: white;
        }

        .btn-edit:hover {
            background: #f57c00;
        }

        .btn-delete {
            background: #f44336;
            color: white;
        }

        .btn-delete:hover {
            background: #d32f2f;
        }

        /* Tooltip */
        .btn-action .tooltip-text {
            visibility: hidden;
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #2c3e50;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            margin-bottom: 8px;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        .btn-action .tooltip-text::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 5px;
            border-style: solid;
            border-color: #2c3e50 transparent transparent transparent;
        }

        .btn-action:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: #7f8c8d;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .empty-state p {
            color: #95a5a6;
            margin-bottom: 30px;
        }

        /* Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            border-left: 4px solid transparent;
        }

        .alert-success {
            background: #e8f5e9;
            border-color: #2ecc71;
            color: #2e7d32;
        }

        .alert-error {
            background: #ffebee;
            border-color: #e74c3c;
            color: #c62828;
        }

        .alert i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Modal Custom Styles */
        .modal-header {
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
            color: white;
            border-radius: 8px 8px 0 0;
            padding: 20px 25px;
        }

        .modal-header h5 {
            margin: 0;
            display: flex;
            align-items: center;
            font-size: 1.2rem;
        }

        .modal-header h5 i {
            margin-right: 10px;
        }

        .btn-close-white {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .btn-close-white:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 25px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-grid .form-group {
            margin-bottom: 20px;
        }

        .modal-footer {
            padding: 20px 25px;
            border-top: 1px solid #dee2e6;
            background: #f8f9fa;
            border-radius: 0 0 8px 8px;
        }

        /* Satuan Input */
        .satuan-input-group {
            position: relative;
        }

        .satuan-input-group input[readonly] {
            background: white;
            cursor: pointer;
        }

        .satuan-input-group .btn-select {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: #9b59b6;
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s;
        }

        .satuan-input-group .btn-select:hover {
            background: #8e44ad;
        }

        /* Satuan Modal */
        .modal-satuan {
            z-index: 1060 !important;
        }

        .modal-satuan .modal-content {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-satuan .modal-header {
            background: linear-gradient(135deg, #9b59b6 0%, #34495e 100%);
        }

        .satuan-list {
            max-height: 300px;
            overflow-y: auto;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .satuan-item {
            padding: 12px 20px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }

        .satuan-item:hover {
            background: #f5f7fa;
            padding-left: 25px;
        }

        .satuan-item.selected {
            background: #f3e5f5;
            color: #7b1fa2;
            font-weight: 500;
        }

        .satuan-item i {
            margin-right: 10px;
            color: #7f8c8d;
        }

        .satuan-item.selected i {
            color: #7b1fa2;
        }

        .search-satuan {
            margin-bottom: 20px;
            position: relative;
        }

        .search-satuan i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
        }

        .search-satuan input {
            padding-left: 40px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .header-actions {
                width: 100%;
                margin-top: 15px;
            }

            .header-actions .btn {
                flex: 1;
            }
        }

        /* Export Modal Specific Styles */
        #exportModal .modal-header {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        }

        #exportModal .alert-info {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 8px;
            padding: 15px;
            color: #1565c0;
        }

        #exportModal .alert-info i {
            color: #2196f3;
        }

        #exportModal .form-text {
            color: #666;
            font-size: 0.85rem;
            margin-top: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="master-bar-container">
        <!-- Filter Card -->
        <div class="filter-card">
            <h3><i class="fas fa-filter"></i> Filter Data</h3>
            <form method="GET" action="{{ route('master-bar.index') }}" class="filter-form">
                <div class="form-group">
                    <label for="tanggal"><i class="fas fa-calendar"></i> Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                        value="{{ request('tanggal') }}">
                </div>

                <div class="form-group">
                    <label for="search"><i class="fas fa-search"></i> Cari Bahan</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau kode bahan...">
                </div>

                <div class="form-group filter-buttons">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('master-bar.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Main Card -->
        <div class="main-card">
            <!-- Card Header -->
            <div class="card-header">
                <div class="header-title">
                    <i class="fas fa-cocktail"></i>
                    <div>
                        <h3>Master Bahan Bar</h3>
                        <p>Kelola semua bahan master bar dengan mudah</p>
                    </div>
                </div>
                <div class="header-actions">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="fas fa-file-export me-1"></i> Export Data
                    </button>

                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createModal">
                        <i class="fas fa-plus me-1"></i> Tambah Bahan
                    </button>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Alerts -->
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if ($masterBar->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-cocktail"></i>
                        <h4>Belum ada data master bahan bar</h4>
                        <p>Mulai dengan menambahkan bahan baru untuk mengelola stok bar Anda</p>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fas fa-plus"></i> Tambah Bahan Pertama
                        </button>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Kode Bahan</th>
                                    <th>Nama Bahan</th>
                                    <th>Satuan</th>
                                    <th>Stok Awal</th>
                                    <th>Stok Minimum</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($masterBar as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge badge-purple">
                                                <i class="fas fa-hashtag"></i> {{ $item->kode_bahan }}
                                            </span>
                                        </td>
                                        <td>{{ $item->nama_bahan }}</td>
                                        <td>
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-balance-scale"></i> {{ $item->nama_satuan }}
                                            </span>
                                        </td>
                                        <td style="text-align: right; font-weight: 600;">
                                            {{ number_format($item->stok_awal, 2) }}</td>
                                        <td style="text-align: right;">{{ number_format($item->stok_minimum, 2) }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button type="button" class="btn-action btn-edit" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $item->id }}">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="tooltip-text">Edit Data</span>
                                                </button>
                                                <button type="button" class="btn-action btn-delete" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $item->id }}">
                                                    <i class="fas fa-trash"></i>
                                                    <span class="tooltip-text">Hapus Data</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Tambah Master Bahan Bar</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('master-bar.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-grid">
                            <!-- Row 1 -->
                            <div class="form-group">
                                <label for="tanggal"><i class="fas fa-calendar"></i> Tanggal <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-hashtag"></i> Kode Bahan</label>
                                <div class="form-control" style="background: #e8f5e9; color: #2e7d32; font-weight: 500;">
                                    <i class="fas fa-spinner fa-spin"></i> Auto generate (MIxxx)
                                </div>
                                <small class="text-muted">Kode akan otomatis di-generate setelah data disimpan</small>
                            </div>

                            <!-- Row 2 -->
                            <div class="form-group">
                                <label for="nama_bahan"><i class="fas fa-tag"></i> Nama Bahan <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_bahan') is-invalid @enderror"
                                    name="nama_bahan" id="nama_bahan" value="{{ old('nama_bahan') }}"
                                    placeholder="Masukkan nama bahan lengkap" required>
                                @error('nama_bahan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nama_satuan"><i class="fas fa-balance-scale"></i> Satuan <span
                                        class="text-danger">*</span></label>
                                <div class="satuan-input-group">
                                    <input type="text" class="form-control @error('nama_satuan') is-invalid @enderror"
                                        id="satuanInputCreateBar" value="{{ old('nama_satuan') }}"
                                        placeholder="Klik untuk memilih satuan" readonly required
                                        onclick="showSatuanModalBar('create')">
                                    <button type="button" class="btn-select" onclick="showSatuanModalBar('create')">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <input type="hidden" name="nama_satuan" id="selectedSatuanCreateBar"
                                        value="{{ old('nama_satuan') }}">
                                </div>
                                @error('nama_satuan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Row 3 -->
                            <div class="form-group">
                                <label for="stok_awal"><i class="fas fa-boxes"></i> Stok Awal <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('stok_awal') is-invalid @enderror" name="stok_awal"
                                    id="stok_awal" value="{{ old('stok_awal') }}" placeholder="0.00" required
                                    min="0">
                                @error('stok_awal')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="stok_minimum"><i class="fas fa-exclamation-triangle"></i> Stok Minimum <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('stok_minimum') is-invalid @enderror" name="stok_minimum"
                                    id="stok_minimum" value="{{ old('stok_minimum') }}" placeholder="0.00" required
                                    min="0">
                                @error('stok_minimum')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Bahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modals -->
    @foreach ($masterBar as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Master Bahan Bar</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('master-bar.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanggal"
                                        value="{{ $item->tanggal->format('Y-m-d') }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Kode Bahan</label>
                                    <div class="form-control" style="background: #f5f5f5; color: #666;">
                                        {{ $item->kode_bahan }}
                                    </div>
                                    <input type="hidden" name="kode_bahan" value="{{ $item->kode_bahan }}">
                                </div>

                                <div class="form-group">
                                    <label>Nama Bahan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_bahan"
                                        value="{{ $item->nama_bahan }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Satuan <span class="text-danger">*</span></label>
                                    <div class="satuan-input-group">
                                        <input type="text" class="form-control"
                                            id="satuanInputEditBar{{ $item->id }}" value="{{ $item->nama_satuan }}"
                                            readonly required onclick="showSatuanModalBar('edit', {{ $item->id }})">
                                        <button type="button" class="btn-select"
                                            onclick="showSatuanModalBar('edit', {{ $item->id }})">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <input type="hidden" name="nama_satuan"
                                            id="selectedSatuanEditBar{{ $item->id }}"
                                            value="{{ $item->nama_satuan }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Stok Awal <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="stok_awal"
                                        value="{{ $item->stok_awal }}" required min="0">
                                </div>

                                <div class="form-group">
                                    <label>Stok Minimum <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control" name="stok_minimum"
                                        value="{{ $item->stok_minimum }}" required min="0">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Delete Modals -->
    @foreach ($masterBar as $item)
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
                        <h5 class="modal-title"><i class="fas fa-trash"></i> Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('master-bar.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body text-center">
                            <div class="mb-4">
                                <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                            </div>
                            <h5 class="mb-3">Hapus Data Bahan?</h5>
                            <p>Data yang dihapus tidak dapat dikembalikan.</p>

                            <div
                                style="background: #ffebee; border: 1px solid #ffcdd2; border-radius: 8px; padding: 15px; margin: 20px 0;">
                                <strong>{{ $item->nama_bahan }}</strong><br>
                                <small>Kode: {{ $item->kode_bahan }}</small>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Batalkan
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Ya, Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Satuan Modal -->
    <div class="modal fade modal-satuan" id="satuanModalBar" tabindex="-1" aria-labelledby="satuanModalLabelBar"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-balance-scale"></i> Pilih Satuan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="search-satuan">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" id="searchSatuanBar" placeholder="Cari satuan...">
                    </div>
                    <ul class="satuan-list" id="satuanListBar">
                        @foreach ($satuan as $s)
                            <li class="satuan-item" data-value="{{ $s->nama_satuan }}"
                                onclick="selectSatuanBar('{{ $s->nama_satuan }}')">
                                <i class="fas fa-balance-scale"></i> {{ $s->nama_satuan }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-file-export"></i> Export Data Excel</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('master-bar.export') }}" method="POST" id="exportForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <p class="text-muted mb-4">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Pilih rentang tanggal untuk export data
                            </p>
                        </div>

                        <div class="form-group mb-3">
                            <label for="start_date" class="form-label">
                                <i class="fas fa-calendar-day me-2"></i>Tanggal Mulai <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ date('Y-m-d') }}" required>
                            <div class="form-text">Pilih tanggal awal periode</div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="end_date" class="form-label">
                                <i class="fas fa-calendar-alt me-2"></i>Tanggal Akhir <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ date('Y-m-d') }}" required>
                            <div class="form-text">Pilih tanggal akhir periode</div>
                        </div>

                        <div class="alert alert-info" style="background: #e3f2fd; border-color: #2196f3;">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>Info:</strong> File akan diexport dengan format:
                            <br>
                            <small class="text-muted">Master Stok Bar - Tanggal - Bulan - Tahun.xlsx</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="button" class="btn btn-success" id="exportButton">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Modal variables for Bar
        let currentModalTypeBar = '';
        let currentItemIdBar = '';

        // Show satuan modal for Bar
        function showSatuanModalBar(type, id = '') {
            currentModalTypeBar = type;
            currentItemIdBar = id;

            // Show the satuan modal
            const satuanModal = new bootstrap.Modal(document.getElementById('satuanModalBar'));
            satuanModal.show();

            // Clear search
            document.getElementById('searchSatuanBar').value = '';

            // Show all items
            document.querySelectorAll('#satuanListBar .satuan-item').forEach(item => {
                item.style.display = 'flex';
            });

            // Highlight selected satuan
            setTimeout(() => {
                let selectedValue = '';
                if (type === 'create') {
                    selectedValue = document.getElementById('selectedSatuanCreateBar')?.value || '';
                } else if (type === 'edit' && id) {
                    selectedValue = document.getElementById('selectedSatuanEditBar' + id)?.value || '';
                }

                document.querySelectorAll('#satuanListBar .satuan-item').forEach(item => {
                    if (item.getAttribute('data-value') === selectedValue) {
                        item.classList.add('selected');
                    } else {
                        item.classList.remove('selected');
                    }
                });
            }, 100);
        }

        // Select satuan for Bar
        function selectSatuanBar(satuan) {
            if (currentModalTypeBar === 'create') {
                document.getElementById('satuanInputCreateBar').value = satuan;
                document.getElementById('selectedSatuanCreateBar').value = satuan;
            } else if (currentModalTypeBar === 'edit' && currentItemIdBar) {
                document.getElementById('satuanInputEditBar' + currentItemIdBar).value = satuan;
                document.getElementById('selectedSatuanEditBar' + currentItemIdBar).value = satuan;
            }

            // Hide the satuan modal
            const satuanModal = bootstrap.Modal.getInstance(document.getElementById('satuanModalBar'));
            if (satuanModal) {
                satuanModal.hide();
            }
        }

        // Search functionality for satuan modal
        document.getElementById('searchSatuanBar')?.addEventListener('input', function(e) {
            const searchValue = e.target.value.toLowerCase();
            const satuanItems = document.querySelectorAll('#satuanListBar .satuan-item');

            satuanItems.forEach(item => {
                const satuan = item.textContent.toLowerCase();
                if (satuan.includes(searchValue)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // When satuan modal is shown, adjust z-index to appear above other modals
        document.getElementById('satuanModalBar')?.addEventListener('show.bs.modal', function() {
            // Find all open modals and set their z-index lower
            document.querySelectorAll('.modal.show').forEach(modal => {
                if (modal.id !== 'satuanModalBar') {
                    modal.style.zIndex = '1040';
                }
            });
            this.style.zIndex = '1060';
        });

        // When satuan modal is hidden, restore z-index
        document.getElementById('satuanModalBar')?.addEventListener('hidden.bs.modal', function() {
            document.querySelectorAll('.modal.show').forEach(modal => {
                modal.style.zIndex = '';
            });
        });

        // Auto close alerts
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);

        // Date validation for export
        document.getElementById('start_date')?.addEventListener('change', function() {
            const endDate = document.getElementById('end_date');
            if (this.value > endDate.value) {
                endDate.value = this.value;
            }
            endDate.min = this.value;
        });

        document.getElementById('end_date')?.addEventListener('change', function() {
            const startDate = document.getElementById('start_date');
            if (this.value < startDate.value) {
                startDate.value = this.value;
            }
        });

        // Handle export form submission
        document.getElementById('exportButton')?.addEventListener('click', function() {
            const exportForm = document.getElementById('exportForm');
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (!startDate || !endDate) {
                alert('Mohon isi tanggal mulai dan tanggal akhir');
                return;
            }
            
            if (startDate > endDate) {
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                return;
            }
            
            // Disable button and show loading
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            this.disabled = true;
            
            // Close modal first
            const exportModal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
            if (exportModal) {
                exportModal.hide();
            }
            
            // Submit form after modal is hidden
            setTimeout(() => {
                exportForm.submit();
                
                // Reset button after 3 seconds
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-file-excel"></i> Export Excel';
                    this.disabled = false;
                }, 3000);
            }, 300);
        });

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            // Bootstrap tooltips are already initialized
            
            // Set default dates for export modal
            document.getElementById('start_date').value = new Date().toISOString().split('T')[0];
            document.getElementById('end_date').value = new Date().toISOString().split('T')[0];
        });
    </script>
@endpush