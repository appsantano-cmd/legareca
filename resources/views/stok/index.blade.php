@extends('layouts.master')

@section('title', 'STOK GUDANG')

@section('content')
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Stok Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .data-type-tabs {
            margin-bottom: 20px;
        }

        .data-type-tabs .nav-link {
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            margin-right: 0.5rem;
        }

        .data-type-tabs .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .master-info-card {
            border-left: 4px solid #28a745;
        }

        /* FIX: Perbaikan styling untuk pagination */
        .pagination-wrapper {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        @media (min-width: 992px) {
            .pagination-wrapper {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        .pagination-info {
            font-size: 0.875rem;
            color: #6c757d;
            text-align: center;
        }

        @media (min-width: 992px) {
            .pagination-info {
                text-align: left;
            }
        }

        .pagination-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            align-items: center;
            margin: 0.5rem 0;
        }

        @media (min-width: 768px) {
            .pagination-controls {
                flex-wrap: nowrap;
            }
        }

        .per-page-form,
        .goto-page-form {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .per-page-form,
            .goto-page-form {
                flex-wrap: nowrap;
            }
        }

        .per-page-label,
        .goto-label {
            font-size: 0.875rem;
            color: #6c757d;
            white-space: nowrap;
        }

        .goto-page-input {
            width: 70px;
            text-align: center;
        }

        /* FIX: Perbaikan styling untuk pagination links Bootstrap */
        .pagination {
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.25rem;
        }

        .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
            border: 1px solid #dee2e6;
            color: #0d6efd;
            background-color: white;
            text-decoration: none;
            transition: all 0.2s;
        }

        .page-link:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
            color: #0a58ca;
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
            opacity: 0.6;
        }

        .page-link i {
            font-size: 0.875rem;
        }

        /* FIX: Container untuk pagination agar tetap rapih */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 0.5rem;
        }

        /* Tambahan untuk date filter */
        .date-filter {
            position: relative;
        }

        .date-filter .form-control {
            cursor: pointer;
            background-color: #fff;
            padding: 0.375rem 0.75rem 0.375rem 2.5rem;
        }

        .date-filter .bi-calendar {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
        }

        .filter-form-wrapper {
            margin-bottom: 0;
        }

        .filter-label {
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        .filter-summary {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }

        /* FIX: Styling untuk empty state */
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }

        .empty-state-icon {
            font-size: 3.5rem;
            color: #6c757d;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Table responsive */
        .table-responsive {
            margin-bottom: 1.5rem;
        }

        /* FIX: Styling untuk badge stok */
        .badge-stok {
            font-size: 0.8em;
            padding: 0.35em 0.65em;
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-box-seam me-2"></i>Manajemen Stok Gudang
                        </h4>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#exportModal">
                                <i class="bi bi-file-earmark-excel"></i> Export Excel
                            </button>

                            <a href="{{ route('stok.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Stok
                            </a>

                            @if ($dataType === 'stok')
                            <form action="{{ route('stok.rollover') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning"
                                    onclick="return confirm('Apakah Anda yakin ingin melakukan rollover stok ke bulan berikutnya?')">
                                    <i class="bi bi-arrow-clockwise"></i> Rollover Stok
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <!-- Tab untuk pilih tipe data -->
                        <div class="data-type-tabs">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link {{ $dataType === 'stok' ? 'active' : '' }}"
                                        href="{{ route('stok.index', ['type' => 'stok'] + request()->except('type')) }}">
                                        <i class="bi bi-table me-1"></i> Stok Detail (Bulanan)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $dataType === 'master' ? 'active' : '' }}"
                                        href="{{ route('stok.index', ['type' => 'master'] + request()->except('type')) }}">
                                        <i class="bi bi-database me-1"></i> Master Data Stok
                                    </a>
                                </li>
                            </ul>
                        </div>

                        @if ($dataType === 'stok')
                        <!-- TAMPILAN STOK DETAIL (BULANAN) -->
                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('stok.index') }}" class="mb-4" id="filterForm">
                            <input type="hidden" name="type" value="stok">
                            <div class="row g-3 align-items-end">
                                <!-- Tanggal -->
                                <div class="col-md-4">
                                    <label class="form-label filter-label">Filter Tanggal</label>
                                    <div class="date-filter">
                                        <i class="bi bi-calendar"></i>
                                        <input type="text" class="form-control form-control-sm" id="selectedDate"
                                            placeholder="Klik untuk memilih tanggal"
                                            value="{{ request('selected_date') ? date('d/m/Y', strtotime(request('selected_date'))) : '' }}"
                                            readonly>
                                        <input type="hidden" name="selected_date" id="selectedDateHidden"
                                            value="{{ request('selected_date') }}">
                                    </div>
                                </div>

                                <!-- Cari Barang -->
                                <div class="col-md-4">
                                    <label class="form-label filter-label">Cari Barang</label>
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Masukkan kode, nama barang, departemen, atau supplier..."
                                        value="{{ request('search') }}">
                                </div>

                                <!-- Tombol -->
                                <div class="col-md-2">
                                    <div style="padding-top: 1.65rem;">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                <i class="bi bi-search me-1"></i> Filter
                                            </button>
                                            <a href="{{ route('stok.index', ['type' => 'stok']) }}"
                                                class="btn btn-secondary btn-sm w-100">
                                                <i class="bi bi-arrow-clockwise"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Filter Summary -->
                        @if (request()->has('selected_date') || request()->has('search'))
                        <div class="filter-summary">
                            <div class="d-flex justify-content-between align-items-center">
                                <small>
                                    Total Data: {{ $stok->total() }} item
                                    @if (request('per_page', 10) != 'all')
                                    | Tampil: {{ $stok->count() }} per halaman
                                    @endif
                                </small>
                            </div>
                        </div>
                        @endif

                        <!-- Stok Table -->
                        <div class="table-responsive mt-3">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Satuan</th>
                                        <th>Stok Awal</th>
                                        <th>Stok Masuk</th>
                                        <th>Stok Keluar</th>
                                        <th>Stok Akhir</th>
                                        <th>Periode</th>
                                        <th>Departemen</th>
                                        <th>Supplier</th>
                                        <th>Tanggal Input</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $startNumber = ($stok->currentPage() - 1) * $stok->perPage() + 1;
                                    @endphp
                                    @forelse($stok as $item)
                                    <tr>
                                        <td>{{ $startNumber++ }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $item->kode_barang }}</span>
                                        </td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->satuan }}</td>
                                        <td class="text-end">{{ number_format($item->stok_awal, 2) }}</td>
                                        <td class="text-end text-success">
                                            {{ number_format($item->stok_masuk, 2) }}</td>
                                        <td class="text-end text-danger">
                                            {{ number_format($item->stok_keluar, 2) }}</td>
                                        <td class="text-end">
                                            <span
                                                class="badge bg-{{ $item->stok_akhir > 0 ? 'success' : 'danger' }} badge-stok">
                                                {{ number_format($item->stok_akhir, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $bulanList[$item->bulan] ?? $item->bulan }} {{ $item->tahun }}
                                            @if ($item->is_rollover)
                                            <br><small class="text-muted">Hasil Rollover</small>
                                            @endif
                                        </td>
                                        <td>{{ $item->departemen ?? '-' }}</td>
                                        <td>{{ $item->supplier ?? '-' }}</td>
                                        <td>
                                            {{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('stok.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="13" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                            @if (request()->has('search') || request()->has('selected_date'))
                                            Tidak ada data stok ditemukan dengan filter yang diterapkan
                                            @else
                                            Tidak ada data stok ditemukan
                                            @endif
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @else
                        <!-- TAMPILAN MASTER DATA STOK -->
                        <!-- Filter Form untuk Master -->
                        <form method="GET" action="{{ route('stok.index') }}" class="mb-4" id="filterForm">
                            <input type="hidden" name="type" value="master">
                            <div class="row g-3 align-items-end">
                                <!-- Cari Barang -->
                                <div class="col-md-6">
                                    <label class="form-label filter-label">Cari Barang</label>
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Masukkan kode, nama barang, departemen, atau supplier..."
                                        value="{{ request('search') }}">
                                </div>

                                <!-- Tombol -->
                                <div class="col-md-2">
                                    <div style="padding-top: 1.65rem;">
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                <i class="bi bi-search me-1"></i> Filter
                                            </button>
                                            <a href="{{ route('stok.index', ['type' => 'master']) }}"
                                                class="btn btn-secondary btn-sm w-100">
                                                <i class="bi bi-arrow-clockwise"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Info Master Data -->
                        <div class="alert alert-info master-info-card mb-4">
                            <div class="d-flex">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                <div>
                                    <strong>Master Data Stok</strong> - Data ini adalah referensi utama untuk semua
                                    barang.
                                    Setiap perubahan di master akan mempengaruhi data detail bulanan.
                                </div>
                            </div>
                        </div>

                        <!-- Filter Summary -->
                        @if (request()->has('search'))
                        <div class="filter-summary">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Filter Aktif:</strong>
                                    <span class="badge bg-info ms-2">
                                        <i class="bi bi-search me-1"></i>
                                        "{{ request('search') }}"
                                    </span>
                                </div>
                                <small>
                                    Total Data: {{ $masterStok->total() }} item
                                    @if (request('per_page', 10) != 'all')
                                    | Tampil: {{ $masterStok->count() }} per halaman
                                    @endif
                                </small>
                            </div>
                        </div>
                        @endif

                        <!-- Master Stok Table -->
                        <div class="table-responsive mt-3">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Satuan</th>
                                        <th>Departemen</th>
                                        <th>Supplier</th>
                                        <th>Stok Awal</th>
                                        <th>Tanggal Submit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $startNumber =
                                    ($masterStok->currentPage() - 1) * $masterStok->perPage() + 1;
                                    @endphp
                                    @forelse($masterStok as $item)
                                    @php
                                    $detailCount = $item->detailStok()->count();
                                    @endphp
                                    <tr>
                                        <td>{{ $startNumber++ }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $item->kode_barang }}</span>
                                        </td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>{{ $item->satuan }}</td>
                                        <td>{{ $item->departemen ?? '-' }}</td>
                                        <td>{{ $item->supplier ?? '-' }}</td>
                                        <td class="text-end">{{ number_format($item->stok_awal, 2) }}</td>
                                        <td>
                                            {{ $item->tanggal_submit ? date('d/m/Y', strtotime($item->tanggal_submit)) : '-' }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">
                                            <i class="bi bi-database-slash display-4 d-block mb-2"></i>
                                            @if (request()->has('search'))
                                            Tidak ada data master ditemukan dengan filter yang diterapkan
                                            @else
                                            Belum ada data master stok
                                            @endif
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @endif

                        <!-- FIX: Pagination dengan struktur yang lebih rapih -->
                        <div class="pagination-wrapper">
                            <!-- Informasi data -->
                            <div class="pagination-info">
                                @if ($dataType === 'stok')
                                Menampilkan <strong>{{ $stok->firstItem() ?? 0 }} - {{ $stok->lastItem() ?? 0 }}</strong>
                                dari <strong>{{ $stok->total() }}</strong> data
                                @else
                                Menampilkan <strong>{{ $masterStok->firstItem() ?? 0 }} - {{ $masterStok->lastItem() ?? 0 }}</strong>
                                dari <strong>{{ $masterStok->total() }}</strong> data
                                @endif
                            </div>

                            <!-- Kontrol pagination -->
                            <div class="pagination-controls">
                                <!-- Form Lompat ke Halaman -->
                                @if (($dataType === 'stok' && $stok->lastPage() > 1) || ($dataType === 'master' && $masterStok->lastPage() > 1))
                                <form method="GET" class="goto-page-form" id="gotoPageForm">
                                    <input type="hidden" name="type" value="{{ $dataType }}">
                                    <input type="hidden" name="selected_date"
                                        value="{{ request('selected_date') }}">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                                    <span class="goto-label">Ke halaman:</span>
                                    <input type="number" name="page"
                                        class="form-control form-control-sm goto-page-input" min="1"
                                        max="{{ $dataType === 'stok' ? $stok->lastPage() : $masterStok->lastPage() }}"
                                        value="{{ $dataType === 'stok' ? $stok->currentPage() : $masterStok->currentPage() }}"
                                        onchange="this.form.submit()">
                                </form>
                                @endif

                                <!-- Selector Per Page -->
                                <form method="GET" class="per-page-form" id="perPageForm">
                                    <input type="hidden" name="type" value="{{ $dataType }}">
                                    <input type="hidden" name="selected_date"
                                        value="{{ request('selected_date') }}">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="page"
                                        value="{{ $dataType === 'stok' ? $stok->currentPage() : $masterStok->currentPage() }}">

                                    <span class="per-page-label">Per halaman:</span>
                                    <select name="per_page" class="form-select form-select-sm"
                                        onchange="this.form.submit()" style="width: auto;">
                                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>
                                            10</option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25
                                        </option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50
                                        </option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100
                                        </option>
                                        <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>
                                            Semua</option>
                                    </select>
                                </form>
                            </div>

                            <!-- Pagination Links -->
                            <div class="pagination-container">
                                @if ($dataType === 'stok')
                                {{ $stok->withQueryString()->links('pagination::bootstrap-5') }}
                                @else
                                {{ $masterStok->withQueryString()->links('pagination::bootstrap-5') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Modal (kode modal tetap sama) -->
    <div class="modal fade" id="exportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-file-earmark-excel me-2"></i>Export Data ke Excel
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('stok.export') }}" method="GET">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tipe Data</label>
                            <select name="export_type" class="form-select">
                                <option value="detail">Stok Detail (Bulanan)</option>
                                <option value="master">Master Data Stok</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dari Tanggal (untuk detail)</label>
                            <input type="date" name="start_date" class="form-control" required
                                value="{{ date('Y-m-01') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sampai Tanggal (untuk detail)</label>
                            <input type="date" name="end_date" class="form-control" required
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Untuk master data, tanggal akan diabaikan
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-success shadow-sm">
                            <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== STOK GUDANG SCRIPT LOADED ===');

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Calendar functionality (kode calendar tetap sama)
            // ... (kode calendar tetap sama seperti sebelumnya)
        });
    </script>
</body>

</html>
@endsection