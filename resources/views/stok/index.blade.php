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

            .calendar-modal .modal-dialog {
                max-width: 320px;
            }

            /* Google Calendar Style */
            .calendar-container {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }

            .calendar-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid #e0e0e0;
                margin-bottom: 15px;
            }

            .calendar-title {
                font-size: 1.2rem;
                font-weight: 500;
                color: #3c4043;
            }

            .calendar-nav {
                display: flex;
                gap: 5px;
            }

            .calendar-nav-btn {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                border: none;
                background: transparent;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: #5f6368;
                transition: background-color 0.2s;
            }

            .calendar-nav-btn:hover {
                background-color: #f1f3f4;
            }

            .calendar-nav-btn i {
                font-size: 1.2rem;
            }

            .calendar-weekdays {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                text-align: center;
                font-weight: 500;
                color: #5f6368;
                font-size: 0.85rem;
                margin-bottom: 8px;
            }

            .calendar-weekday {
                padding: 8px 0;
            }

            .calendar-days {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 4px;
            }

            .calendar-day {
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                cursor: pointer;
                font-size: 0.9rem;
                color: #3c4043;
                transition: all 0.2s;
                position: relative;
            }

            .calendar-day:hover {
                background-color: #f1f3f4;
            }

            .calendar-day.today {
                background-color: #e8f0fe;
                color: #1a73e8;
                font-weight: 500;
            }

            .calendar-day.selected {
                background-color: #1a73e8;
                color: white;
            }

            .calendar-day.other-month {
                color: #dadce0;
            }

            .calendar-day.empty {
                visibility: hidden;
            }

            .calendar-footer {
                margin-top: 20px;
                padding-top: 15px;
                border-top: 1px solid #e0e0e0;
            }

            .quick-actions {
                display: flex;
                gap: 10px;
            }

            .btn-google {
                border-radius: 4px;
                font-weight: 500;
                padding: 8px 16px;
                font-size: 0.9rem;
            }

            .btn-google-primary {
                background-color: #1a73e8;
                color: white;
                border: none;
            }

            .btn-google-primary:hover {
                background-color: #0d62d9;
            }

            .btn-google-secondary {
                background-color: transparent;
                color: #5f6368;
                border: 1px solid #dadce0;
            }

            .btn-google-secondary:hover {
                background-color: #f1f3f4;
            }

            .btn-google-danger {
                background-color: transparent;
                color: #d93025;
                border: 1px solid #dadce0;
            }

            .btn-google-danger:hover {
                background-color: #fce8e6;
            }

            /* Month/Year Selector */
            .month-year-selector {
                display: flex;
                gap: 15px;
                margin-bottom: 20px;
            }

            .month-selector-container,
            .year-selector-container {
                flex: 1;
            }

            .month-selector,
            .year-selector {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 5px;
                max-height: 200px;
                overflow-y: auto;
                padding: 10px;
                border: 1px solid #dadce0;
                border-radius: 8px;
                background: white;
            }

            .month-item,
            .year-item {
                padding: 8px 4px;
                text-align: center;
                border-radius: 4px;
                cursor: pointer;
                font-size: 0.9rem;
                transition: all 0.2s;
            }

            .month-item:hover,
            .year-item:hover {
                background-color: #f1f3f4;
            }

            .month-item.selected,
            .year-item.selected {
                background-color: #1a73e8;
                color: white;
            }

            .selector-label {
                font-size: 0.9rem;
                color: #5f6368;
                margin-bottom: 5px;
                font-weight: 500;
            }

            .per-page-form {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .per-page-label {
                font-size: 0.875rem;
                color: #6c757d;
            }

            .goto-page-form {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .goto-page-input {
                width: 70px;
                text-align: center;
            }

            .pagination-controls {
                display: flex;
                gap: 1rem;
                align-items: center;
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

                            <!-- Pagination dengan Kontrol Custom -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    @if ($dataType === 'stok')
                                        Menampilkan {{ $stok->firstItem() ?? 0 }} - {{ $stok->lastItem() ?? 0 }} dari
                                        {{ $stok->total() }} data
                                    @else
                                        Menampilkan {{ $masterStok->firstItem() ?? 0 }} -
                                        {{ $masterStok->lastItem() ?? 0 }} dari
                                        {{ $masterStok->total() }} data
                                    @endif
                                </div>

                                <div class="pagination-controls">
                                    <!-- Form Lompat ke Halaman -->
                                    @if (($dataType === 'stok' && $stok->lastPage() > 1) || ($dataType === 'master' && $masterStok->lastPage() > 1))
                                        <form method="GET" class="goto-page-form" id="gotoPageForm">
                                            <input type="hidden" name="type" value="{{ $dataType }}">
                                            <input type="hidden" name="selected_date"
                                                value="{{ request('selected_date') }}">
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                                            <span class="per-page-label">Halaman:</span>
                                            <input type="number" name="page"
                                                class="form-control form-control-sm goto-page-input" min="1"
                                                max="{{ $dataType === 'stok' ? $stok->lastPage() : $masterStok->lastPage() }}"
                                                value="{{ $dataType === 'stok' ? $stok->currentPage() : $masterStok->currentPage() }}"
                                                onchange="document.getElementById('gotoPageForm').submit()">
                                            <span class="per-page-label">dari
                                                {{ $dataType === 'stok' ? $stok->lastPage() : $masterStok->lastPage() }}</span>
                                        </form>
                                    @endif

                                    <!-- Selector Per Page -->
                                    <form method="GET" class="per-page-form" id="perPageFormBottom">
                                        <input type="hidden" name="type" value="{{ $dataType }}">
                                        <input type="hidden" name="selected_date"
                                            value="{{ request('selected_date') }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="page"
                                            value="{{ $dataType === 'stok' ? $stok->currentPage() : $masterStok->currentPage() }}">

                                        <span class="per-page-label">Tampilkan:</span>
                                        <select name="per_page" class="form-select form-select-sm per-page-selector"
                                            onchange="this.form.submit()">
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
                                <nav>
                                    @if ($dataType === 'stok')
                                        {{ $stok->withQueryString()->links() }}
                                    @else
                                        {{ $masterStok->withQueryString()->links() }}
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Google Calendar Style Modal -->
        <div class="modal fade calendar-modal" id="calendarModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-calendar3 me-2"></i>Pilih Tanggal
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="calendar-container">
                            <!-- Calendar Navigation -->
                            <div class="calendar-header">
                                <div class="calendar-title" id="calendarTitle">Januari 2024</div>
                                <div class="calendar-nav">
                                    <button type="button" class="calendar-nav-btn" id="prevYear">
                                        <i class="bi bi-chevron-double-left"></i>
                                    </button>
                                    <button type="button" class="calendar-nav-btn" id="prevMonth">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <button type="button" class="calendar-nav-btn" id="monthYearPicker">
                                        <i class="bi bi-calendar-range"></i>
                                    </button>
                                    <button type="button" class="calendar-nav-btn" id="nextMonth">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                    <button type="button" class="calendar-nav-btn" id="nextYear">
                                        <i class="bi bi-chevron-double-right"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Month/Year Selector (Hidden by default) -->
                            <div id="monthYearSelector" style="display: none;">
                                <div class="month-year-selector">
                                    <div class="month-selector-container">
                                        <div class="selector-label">Bulan</div>
                                        <div class="month-selector" id="monthSelector">
                                            <!-- Months will be populated by JavaScript -->
                                        </div>
                                    </div>
                                    <div class="year-selector-container">
                                        <div class="selector-label">Tahun</div>
                                        <div class="year-selector" id="yearSelector">
                                            <!-- Years will be populated by JavaScript -->
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button type="button" class="btn btn-google btn-google-secondary"
                                        id="cancelMonthYear">
                                        Batal
                                    </button>
                                    <button type="button" class="btn btn-google btn-google-primary" id="applyMonthYear">
                                        Terapkan
                                    </button>
                                </div>
                            </div>

                            <!-- Calendar View -->
                            <div id="calendarView">
                                <!-- Weekdays -->
                                <div class="calendar-weekdays">
                                    <div class="calendar-weekday">Sen</div>
                                    <div class="calendar-weekday">Sel</div>
                                    <div class="calendar-weekday">Rab</div>
                                    <div class="calendar-weekday">Kam</div>
                                    <div class="calendar-weekday">Jum</div>
                                    <div class="calendar-weekday">Sab</div>
                                    <div class="calendar-weekday">Min</div>
                                </div>

                                <!-- Days Grid -->
                                <div class="calendar-days" id="calendarDays">
                                    <!-- Days will be populated by JavaScript -->
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div class="calendar-footer">
                                <div class="quick-actions">
                                    <button type="button" class="btn btn-google btn-google-primary" id="todayBtn">
                                        <i class="bi bi-calendar-check me-1"></i> Hari Ini
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="confirmDate">Pilih Tanggal</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Modal -->
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

                // Calendar variables
                let currentDate = new Date();
                let selectedDate = null;
                const calendarDays = document.getElementById('calendarDays');
                const calendarTitle = document.getElementById('calendarTitle');
                const calendarView = document.getElementById('calendarView');
                const monthYearSelector = document.getElementById('monthYearSelector');
                const monthSelector = document.getElementById('monthSelector');
                const yearSelector = document.getElementById('yearSelector');

                // Indonesian month names
                const monthNames = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];

                // Days of week (starting from Monday)
                const dayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

                // Initialize selected date from input if exists
                const selectedDateHidden = document.getElementById('selectedDateHidden');
                const selectedDateDisplay = document.getElementById('selectedDate');

                // Cek apakah ada tanggal yang sudah dipilih sebelumnya
                if (selectedDateHidden && selectedDateHidden.value && selectedDateHidden.value.trim() !== '') {
                    try {
                        // Parse date from YYYY-MM-DD format
                        const [year, month, day] = selectedDateHidden.value.split('-').map(Number);
                        if (!isNaN(year) && !isNaN(month) && !isNaN(day)) {
                            selectedDate = new Date(year, month - 1, day);
                            currentDate = new Date(year, month - 1, 1); // Set to first day of month
                            console.log('Loaded selected date:', selectedDate);
                        }
                    } catch (error) {
                        console.error('Error parsing selected date:', error);
                        selectedDate = null;
                    }
                } else {
                    selectedDate = null;
                }

                // Format date for display (dd/mm/yyyy)
                function formatDateForDisplay(date) {
                    if (!date || isNaN(date.getTime())) return '';
                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const year = date.getFullYear();
                    return `${day}/${month}/${year}`;
                }

                // Format date for hidden input (YYYY-MM-DD)
                function formatDateForHidden(date) {
                    if (!date || isNaN(date.getTime())) return '';
                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const year = date.getFullYear();
                    return `${year}-${month}-${day}`;
                }

                // Generate calendar
                function generateCalendar() {
                    if (!calendarDays || !calendarTitle) return;

                    const year = currentDate.getFullYear();
                    const month = currentDate.getMonth();

                    // Update calendar title
                    calendarTitle.textContent = `${monthNames[month]} ${year}`;

                    // Get first day of month
                    const firstDay = new Date(year, month, 1);
                    // Get day of week (0 = Sunday, 1 = Monday, etc.)
                    let startingDay = firstDay.getDay();

                    // Adjust for Monday start (0 = Monday)
                    if (startingDay === 0) {
                        startingDay = 6; // Sunday becomes last day of week
                    } else {
                        startingDay = startingDay - 1; // Monday becomes 0
                    }

                    // Get last day of month
                    const lastDay = new Date(year, month + 1, 0);
                    const daysInMonth = lastDay.getDate();

                    // Get today's date
                    const today = new Date();
                    const todayYear = today.getFullYear();
                    const todayMonth = today.getMonth();
                    const todayDay = today.getDate();

                    // Clear calendar
                    calendarDays.innerHTML = '';

                    // Add days from previous month
                    const prevMonth = new Date(year, month - 1, 1);
                    const daysInPrevMonth = new Date(year, month, 0).getDate();

                    for (let i = startingDay - 1; i >= 0; i--) {
                        const day = daysInPrevMonth - i;
                        const dayElement = document.createElement('div');
                        dayElement.className = 'calendar-day other-month';
                        dayElement.textContent = day;
                        dayElement.title = `${day} ${monthNames[prevMonth.getMonth()]} ${prevMonth.getFullYear()}`;
                        calendarDays.appendChild(dayElement);
                    }

                    // Add days of current month
                    for (let day = 1; day <= daysInMonth; day++) {
                        const dayElement = document.createElement('div');
                        dayElement.className = 'calendar-day';
                        dayElement.textContent = day;
                        dayElement.dataset.day = day;
                        dayElement.dataset.year = year;
                        dayElement.dataset.month = month;

                        // Check if today
                        if (day === todayDay && month === todayMonth && year === todayYear) {
                            dayElement.classList.add('today');
                        }

                        // Check if selected
                        if (selectedDate &&
                            day === selectedDate.getDate() &&
                            month === selectedDate.getMonth() &&
                            year === selectedDate.getFullYear()) {
                            dayElement.classList.add('selected');
                        }

                        // Add click event
                        dayElement.addEventListener('click', function() {
                            // Remove selected from all days
                            document.querySelectorAll('.calendar-day.selected').forEach(el => {
                                el.classList.remove('selected');
                            });

                            // Add selected to clicked day
                            this.classList.add('selected');

                            // Update selected date
                            const day = parseInt(this.dataset.day);
                            const month = parseInt(this.dataset.month);
                            const year = parseInt(this.dataset.year);
                            selectedDate = new Date(year, month, day);
                            console.log('Date selected:', selectedDate);
                        });

                        calendarDays.appendChild(dayElement);
                    }

                    // Add days from next month to fill grid (6 rows)
                    const totalCells = 42; // 6 rows * 7 days
                    const cellsUsed = startingDay + daysInMonth;
                    const nextMonthDays = totalCells - cellsUsed;

                    for (let day = 1; day <= nextMonthDays; day++) {
                        const nextMonth = new Date(year, month + 1, 1);
                        const dayElement = document.createElement('div');
                        dayElement.className = 'calendar-day other-month';
                        dayElement.textContent = day;
                        dayElement.title = `${day} ${monthNames[nextMonth.getMonth()]} ${nextMonth.getFullYear()}`;
                        calendarDays.appendChild(dayElement);
                    }
                }

                // Generate month selector
                function generateMonthSelector() {
                    if (!monthSelector) return;

                    monthSelector.innerHTML = '';
                    const currentMonth = currentDate.getMonth();

                    monthNames.forEach((monthName, index) => {
                        const monthElement = document.createElement('div');
                        monthElement.className = 'month-item';
                        if (index === currentMonth) {
                            monthElement.classList.add('selected');
                        }
                        monthElement.textContent = monthName;
                        monthElement.dataset.month = index;

                        monthElement.addEventListener('click', function() {
                            document.querySelectorAll('.month-item.selected').forEach(el => {
                                el.classList.remove('selected');
                            });
                            this.classList.add('selected');
                        });

                        monthSelector.appendChild(monthElement);
                    });
                }

                // Generate year selector
                function generateYearSelector() {
                    if (!yearSelector) return;

                    yearSelector.innerHTML = '';
                    const currentYear = currentDate.getFullYear();
                    const startYear = currentYear - 10;
                    const endYear = currentYear + 10;

                    for (let year = startYear; year <= endYear; year++) {
                        const yearElement = document.createElement('div');
                        yearElement.className = 'year-item';
                        if (year === currentYear) {
                            yearElement.classList.add('selected');
                        }
                        yearElement.textContent = year;
                        yearElement.dataset.year = year;

                        yearElement.addEventListener('click', function() {
                            document.querySelectorAll('.year-item.selected').forEach(el => {
                                el.classList.remove('selected');
                            });
                            this.classList.add('selected');
                        });

                        yearSelector.appendChild(yearElement);
                    }
                }

                // Navigation buttons for calendar
                function setupCalendarNavigation() {
                    document.getElementById('prevYear')?.addEventListener('click', function() {
                        currentDate.setFullYear(currentDate.getFullYear() - 1);
                        generateCalendar();
                    });

                    document.getElementById('prevMonth')?.addEventListener('click', function() {
                        currentDate.setMonth(currentDate.getMonth() - 1);
                        generateCalendar();
                    });

                    document.getElementById('nextMonth')?.addEventListener('click', function() {
                        currentDate.setMonth(currentDate.getMonth() + 1);
                        generateCalendar();
                    });

                    document.getElementById('nextYear')?.addEventListener('click', function() {
                        currentDate.setFullYear(currentDate.getFullYear() + 1);
                        generateCalendar();
                    });
                }

                // Month/Year picker functionality
                function setupMonthYearPicker() {
                    const monthYearPickerBtn = document.getElementById('monthYearPicker');
                    const cancelMonthYearBtn = document.getElementById('cancelMonthYear');
                    const applyMonthYearBtn = document.getElementById('applyMonthYear');

                    monthYearPickerBtn?.addEventListener('click', function() {
                        // Switch to month/year selector view
                        calendarView.style.display = 'none';
                        monthYearSelector.style.display = 'block';

                        // Generate selectors
                        generateMonthSelector();
                        generateYearSelector();
                    });

                    cancelMonthYearBtn?.addEventListener('click', function() {
                        // Switch back to calendar view
                        calendarView.style.display = 'block';
                        monthYearSelector.style.display = 'none';
                    });

                    applyMonthYearBtn?.addEventListener('click', function() {
                        const selectedMonth = monthSelector.querySelector('.month-item.selected');
                        const selectedYear = yearSelector.querySelector('.year-item.selected');

                        if (selectedMonth && selectedYear) {
                            const month = parseInt(selectedMonth.dataset.month);
                            const year = parseInt(selectedYear.dataset.year);

                            currentDate = new Date(year, month, 1);
                            generateCalendar();

                            // Switch back to calendar view
                            calendarView.style.display = 'block';
                            monthYearSelector.style.display = 'none';
                        }
                    });
                }

                // Calendar modal functionality
                function setupCalendarModal() {
                    // Open calendar when input is clicked
                    selectedDateDisplay?.addEventListener('click', function() {
                        // Reset to current date if no date selected
                        if (!this.value.trim()) {
                            selectedDate = null;
                            currentDate = new Date();
                        } else if (selectedDate && !isNaN(selectedDate.getTime())) {
                            // Set currentDate based on selected date
                            currentDate = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), 1);
                        }

                        const calendarModal = new bootstrap.Modal(document.getElementById('calendarModal'));
                        calendarModal.show();
                        generateCalendar();

                        // Ensure calendar view is shown (not selector)
                        calendarView.style.display = 'block';
                        monthYearSelector.style.display = 'none';
                    });

                    // Today button
                    document.getElementById('todayBtn')?.addEventListener('click', function() {
                        const today = new Date();
                        selectedDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
                        currentDate = new Date(today.getFullYear(), today.getMonth(), 1);

                        // Regenerate calendar
                        generateCalendar();

                        // Ensure calendar view is shown (not selector)
                        calendarView.style.display = 'block';
                        monthYearSelector.style.display = 'none';
                    });

                    // Clear date button in modal
                    document.getElementById('clearDateBtnModal')?.addEventListener('click', function() {
                        selectedDate = null;
                        document.querySelectorAll('.calendar-day.selected').forEach(el => {
                            el.classList.remove('selected');
                        });
                    });

                    // Confirm date selection from calendar modal
                    document.getElementById('confirmDate')?.addEventListener('click', function() {
                        if (!selectedDate || isNaN(selectedDate.getTime())) {
                            alert('Silakan pilih tanggal terlebih dahulu.');
                            return;
                        }

                        const formattedDateHidden = formatDateForHidden(selectedDate);
                        const formattedDateDisplay = formatDateForDisplay(selectedDate);

                        console.log('Confirming date:', {
                            hidden: formattedDateHidden,
                            display: formattedDateDisplay
                        });

                        // Update input fields
                        if (selectedDateHidden) selectedDateHidden.value = formattedDateHidden;
                        if (selectedDateDisplay) selectedDateDisplay.value = formattedDateDisplay;

                        // Close modal
                        const calendarModal = bootstrap.Modal.getInstance(document.getElementById(
                            'calendarModal'));
                        if (calendarModal) calendarModal.hide();

                        // Auto-submit form
                        setTimeout(() => {
                            const form = document.getElementById('filterForm');
                            if (form) {
                                console.log('Auto-submitting form after date selection');
                                form.submit();
                            }
                        }, 300);
                    });

                    // Modal hidden event
                    const calendarModal = document.getElementById('calendarModal');
                    if (calendarModal) {
                        calendarModal.addEventListener('hidden.bs.modal', function() {
                            // Reset to calendar view when modal is closed
                            calendarView.style.display = 'block';
                            monthYearSelector.style.display = 'none';
                        });
                    }
                }

                // Clear date button functionality
                function setupClearDateButton() {
                    const clearDateBtn = document.getElementById('clearDateBtn');
                    if (clearDateBtn) {
                        clearDateBtn.addEventListener('click', function() {
                            if (selectedDateDisplay) selectedDateDisplay.value = '';
                            if (selectedDateHidden) selectedDateHidden.value = '';
                            selectedDate = null;

                            // Submit form
                            const form = document.getElementById('filterForm');
                            if (form) form.submit();
                        });
                    }
                }

                // Initialize all functions
                function init() {
                    console.log('Initializing stok gudang script...');

                    // Setup all event listeners
                    setupCalendarNavigation();
                    setupMonthYearPicker();
                    setupCalendarModal();
                    setupClearDateButton();

                    console.log('Script initialization complete');
                }

                // Run initialization
                init();
            });
        </script>
    </body>

    </html>
@endsection
