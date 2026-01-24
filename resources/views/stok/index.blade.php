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
            .card-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            .table-hover tbody tr:hover {
                background-color: rgba(102, 126, 234, 0.1);
            }

            .badge-stok {
                font-size: 0.8em;
                padding: 0.4em 0.8em;
            }

            .export-btn {
                background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
                color: white;
                border: none;
            }

            .export-btn:hover {
                background: linear-gradient(135deg, #45a049 0%, #1B5E20 100%);
                color: white;
            }

            .date-filter {
                position: relative;
            }

            .date-filter .form-control {
                background-color: white;
                cursor: pointer;
                padding-right: 40px;
            }

            .filter-icon {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                color: #6c757d;
                pointer-events: none;
            }

            .filter-summary {
                background-color: #f8f9fa;
                border-radius: 5px;
                padding: 10px 15px;
                margin-bottom: 20px;
                border-left: 4px solid #667eea;
            }

            .filter-summary small {
                color: #6c757d;
            }

            .calendar-modal .modal-dialog {
                max-width: 400px;
            }

            .calendar-container {
                padding: 15px;
            }

            .calendar-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
                padding-bottom: 10px;
                border-bottom: 1px solid #dee2e6;
            }

            .calendar-title {
                font-weight: bold;
                font-size: 1.1rem;
                cursor: pointer;
                padding: 5px 10px;
                border-radius: 4px;
                transition: background-color 0.2s;
            }

            .calendar-title:hover {
                background-color: #f8f9fa;
            }

            .calendar-nav {
                display: flex;
                gap: 10px;
            }

            .calendar-nav button {
                width: 30px;
                height: 30px;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            }

            .calendar-nav button:hover {
                background-color: #f8f9fa;
            }

            .calendar-weekdays {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 5px;
                margin-bottom: 10px;
                text-align: center;
                font-weight: bold;
                color: #6c757d;
            }

            .calendar-days {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 5px;
            }

            .calendar-day {
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 4px;
                cursor: pointer;
                transition: all 0.2s;
            }

            .calendar-day:hover {
                background-color: #e9ecef;
            }

            .calendar-day.selected {
                background-color: #667eea;
                color: white;
            }

            .calendar-day.today {
                border: 2px solid #667eea;
            }

            .calendar-day.other-month {
                color: #adb5bd;
            }

            .calendar-day.empty {
                cursor: default;
                background: none;
            }

            .calendar-day.empty:hover {
                background: none;
            }

            /* Month/Year Selector */
            .month-year-selector {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                padding: 15px;
                z-index: 1000;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                display: none;
            }

            .month-year-selector.active {
                display: block;
            }

            .selector-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                margin-bottom: 15px;
            }

            .selector-item {
                padding: 8px;
                text-align: center;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                cursor: pointer;
                transition: all 0.2s;
            }

            .selector-item:hover {
                background-color: #e9ecef;
            }

            .selector-item.selected {
                background-color: #667eea;
                color: white;
                border-color: #667eea;
            }

            .year-selector {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
                max-height: 200px;
                overflow-y: auto;
            }

            .year-item {
                padding: 8px;
                text-align: center;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                cursor: pointer;
                transition: all 0.2s;
            }

            .year-item:hover {
                background-color: #e9ecef;
            }

            .year-item.selected {
                background-color: #667eea;
                color: white;
                border-color: #667eea;
            }

            .selector-controls {
                display: flex;
                justify-content: space-between;
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid #dee2e6;
            }

            /* Quick Filter Styles */
            .quick-filter-container {
                margin-bottom: 15px;
            }

            .quick-filter-btn {
                font-size: 0.85rem;
                padding: 0.25rem 0.75rem;
                margin-right: 0.5rem;
                margin-bottom: 0.5rem;
            }

            /* Filter Form Alignment Fix */
            .filter-label {
                font-size: 0.875rem;
                font-weight: 500;
                margin-bottom: 0.25rem;
            }

            .form-control-sm {
                min-height: calc(1.5em + 0.5rem + 2px);
            }

            /* Form alignment fix */
            .filter-form-wrapper {
                margin-bottom: 0.5rem;
            }

            /* Per Page Selector */
            .per-page-selector {
                width: 100px;
            }

            .pagination-controls {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .per-page-form {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .per-page-label {
                white-space: nowrap;
                font-size: 0.9rem;
                color: #6c757d;
            }

            .goto-page-form {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .goto-page-input {
                width: 80px;
                text-align: center;
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
                                <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                    data-bs-target="#exportModal">
                                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                                </button>
                                <a href="{{ route('stok.create') }}" class="btn btn-light">
                                    <i class="bi bi-plus-circle"></i> Tambah Stok
                                </a>
                                <form action="{{ route('stok.rollover') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning"
                                        onclick="return confirm('Apakah Anda yakin ingin melakukan rollover stok ke bulan berikutnya?')">
                                        <i class="bi bi-arrow-clockwise"></i> Rollover Stok
                                    </button>
                                </form>
                                <a href="{{ route('stok.rollover.history') }}" class="btn btn-info text-white">
                                    <i class="bi bi-clock-history"></i> History Rollover
                                </a>
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

                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('stok.index') }}" class="mb-4" id="filterForm">
                                <div class="row g-3 align-items-end">
                                    <!-- Tanggal -->
                                    <div class="col-md-4">
                                        <div class="filter-form-wrapper">
                                            <label class="form-label filter-label">Filter Tanggal</label>
                                            <div class="date-filter">
                                                <input type="text" class="form-control form-control-sm" id="selectedDate"
                                                    placeholder="Klik untuk memilih tanggal"
                                                    value="{{ request('selected_date') ? date('d/m/Y', strtotime(request('selected_date'))) : '' }}"
                                                    readonly>
                                                <i class="bi bi-calendar filter-icon"></i>
                                            </div>
                                            <input type="hidden" name="selected_date" id="selectedDateHidden"
                                                value="{{ request('selected_date') }}">
                                        </div>
                                    </div>

                                    <!-- Cari Barang -->
                                    <div class="col-md-4">
                                        <div class="filter-form-wrapper">
                                            <label class="form-label filter-label">Cari Barang</label>
                                            <input type="text" name="search" class="form-control form-control-sm"
                                                placeholder="Masukkan kode atau nama barang..."
                                                value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <!-- Tombol -->
                                    <div class="col-md-2">
                                        <div class="filter-form-wrapper" style="padding-top: 1.65rem;">
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-primary btn-sm w-100" id="applyFilter">
                                                    <i class="bi bi-search me-1"></i> Filter
                                                </button>
                                                <a href="{{ route('stok.index') }}" class="btn btn-secondary btn-sm w-100">
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
                                        <div>
                                            <strong>Filter Aktif:</strong>
                                            @if (request()->has('search'))
                                                <span class="badge bg-info ms-2">
                                                    <i class="bi bi-search me-1"></i>
                                                    "{{ request('search') }}"
                                                </span>
                                            @endif
                                        </div>
                                        <small>
                                            Total Data: {{ $stok->total() }} item
                                            @if(request('per_page', 10) != 'all')
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
                                                <td colspan="12" class="text-center text-muted py-4">
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

                            <!-- Pagination dengan Kontrol Custom -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    Menampilkan {{ $stok->firstItem() ?? 0 }} - {{ $stok->lastItem() ?? 0 }} dari
                                    {{ $stok->total() }} data
                                </div>
                                
                                <div class="pagination-controls">
                                    <!-- Form Lompat ke Halaman -->
                                    @if($stok->lastPage() > 1)
                                    <form method="GET" class="goto-page-form" id="gotoPageForm">
                                        <input type="hidden" name="selected_date" value="{{ request('selected_date') }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                        
                                        <span class="per-page-label">Halaman:</span>
                                        <input type="number" 
                                               name="page" 
                                               class="form-control form-control-sm goto-page-input" 
                                               min="1" 
                                               max="{{ $stok->lastPage() }}" 
                                               value="{{ $stok->currentPage() }}"
                                               onchange="document.getElementById('gotoPageForm').submit()">
                                        <span class="per-page-label">dari {{ $stok->lastPage() }}</span>
                                    </form>
                                    @endif

                                    <!-- Selector Per Page (Duplicate untuk bawah) -->
                                    <form method="GET" class="per-page-form" id="perPageFormBottom">
                                        <input type="hidden" name="selected_date" value="{{ request('selected_date') }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="page" value="{{ $stok->currentPage() }}">
                                        
                                        <span class="per-page-label">Tampilkan:</span>
                                        <select name="per_page" class="form-select form-select-sm per-page-selector" onchange="this.form.submit()">
                                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Semua</option>
                                        </select>
                                    </form>
                                </div>
                                
                                <!-- Pagination Links -->
                                <nav>
                                    {{ $stok->withQueryString()->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Calendar Modal -->
        <div class="modal fade calendar-modal" id="calendarModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-calendar me-2"></i>Pilih Tanggal
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body calendar-container">
                        <!-- Month/Year Selector -->
                        <div class="month-year-selector" id="monthYearSelector">
                            <h6 class="mb-3">Pilih Bulan</h6>
                            <div class="selector-grid" id="monthSelector">
                                <!-- Months will be populated by JavaScript -->
                            </div>
                            
                            <h6 class="mb-3 mt-4">Pilih Tahun</h6>
                            <div class="year-selector" id="yearSelector">
                                <!-- Years will be populated by JavaScript -->
                            </div>
                            
                            <div class="selector-controls">
                                <button type="button" class="btn btn-sm btn-secondary" id="cancelSelector">
                                    Batal
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" id="applyMonthYear">
                                    Pilih
                                </button>
                            </div>
                        </div>

                        <!-- Calendar View -->
                        <div class="calendar-view" id="calendarView">
                            <div class="calendar-header">
                                <button type="button" class="btn btn-sm btn-outline-secondary prev-year">
                                    <i class="bi bi-chevron-double-left"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary prev-month">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <div class="calendar-title" id="calendarMonthYear"></div>
                                <button type="button" class="btn btn-sm btn-outline-secondary next-month">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary next-year">
                                    <i class="bi bi-chevron-double-right"></i>
                                </button>
                            </div>

                            <div class="calendar-weekdays">
                                <div>M</div>
                                <div>S</div>
                                <div>S</div>
                                <div>R</div>
                                <div>K</div>
                                <div>J</div>
                                <div>S</div>
                            </div>

                            <div class="calendar-days" id="calendarDays">
                                <!-- Days will be generated by JavaScript -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="confirmDate">
                            Pilih Tanggal
                        </button>
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
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" name="start_date" class="form-control" required
                                    value="{{ date('Y-m-01') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" name="end_date" class="form-control" required
                                    value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Data akan diexport berdasarkan tanggal input data
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn export-btn">
                                <i class="bi bi-download me-2"></i>Export Excel
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
                const calendarMonthYear = document.getElementById('calendarMonthYear');
                const monthYearSelector = document.getElementById('monthYearSelector');
                const calendarView = document.getElementById('calendarView');
                const monthSelector = document.getElementById('monthSelector');
                const yearSelector = document.getElementById('yearSelector');

                // Indonesian month names
                const monthNames = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];

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
                            currentDate = new Date(year, month - 1, day);
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

                // Clear all filters
                function clearAllFilters() {
                    if (selectedDateDisplay) selectedDateDisplay.value = '';
                    if (selectedDateHidden) selectedDateHidden.value = '';

                    // Reset search input if exists
                    const searchInput = document.querySelector('input[name="search"]');
                    if (searchInput) searchInput.value = '';

                    // Reset per page to default
                    const perPageSelectors = document.querySelectorAll('select[name="per_page"]');
                    perPageSelectors.forEach(select => {
                        select.value = 10;
                    });

                    // Submit form
                    const form = document.querySelector('form[method="GET"]');
                    if (form) {
                        form.submit();
                    }
                }

                // Apply filter dengan validasi
                function applyFilter() {
                    const form = document.querySelector('form[method="GET"]');
                    if (!form) return;

                    // Jika tanggal display kosong, pastikan hidden juga kosong
                    if (selectedDateDisplay && !selectedDateDisplay.value.trim()) {
                        if (selectedDateHidden) selectedDateHidden.value = '';
                    }

                    // Submit form
                    form.submit();
                }

                // Generate calendar
                function generateCalendar() {
                    if (!calendarDays || !calendarMonthYear) return;

                    const year = currentDate.getFullYear();
                    const month = currentDate.getMonth();

                    // Update month/year display
                    calendarMonthYear.textContent = `${monthNames[month]} ${year}`;

                    // Get first day of month
                    const firstDay = new Date(year, month, 1);
                    // Adjust for Monday start (0=Sunday, 1=Monday, etc.)
                    let startingDay = firstDay.getDay() - 1;
                    if (startingDay < 0) startingDay = 6; // Sunday becomes 6

                    // Get last day of month
                    const lastDay = new Date(year, month + 1, 0);
                    const daysInMonth = lastDay.getDate();

                    // Get today's date
                    const today = new Date();
                    const todayYear = today.getFullYear();
                    const todayMonth = today.getMonth();

                    // Clear calendar
                    calendarDays.innerHTML = '';

                    // Add empty cells for days before first day of month
                    for (let i = 0; i < startingDay; i++) {
                        const emptyDay = document.createElement('div');
                        emptyDay.className = 'calendar-day empty';
                        calendarDays.appendChild(emptyDay);
                    }

                    // Add days of month
                    for (let day = 1; day <= daysInMonth; day++) {
                        const dayElement = document.createElement('div');
                        dayElement.className = 'calendar-day';
                        dayElement.textContent = day;
                        dayElement.dataset.day = day;
                        dayElement.dataset.year = year;
                        dayElement.dataset.month = month;

                        // Check if today
                        if (day === today.getDate() && month === todayMonth && year === todayYear) {
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

                            console.log('Date selected in calendar:', selectedDate);
                        });

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
                        monthElement.className = 'selector-item';
                        if (index === currentMonth) {
                            monthElement.classList.add('selected');
                        }
                        monthElement.textContent = monthName;
                        monthElement.dataset.month = index;
                        
                        monthElement.addEventListener('click', function() {
                            document.querySelectorAll('.selector-item.selected').forEach(el => {
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

                // Show month/year selector
                function showMonthYearSelector() {
                    if (monthYearSelector && calendarView) {
                        monthYearSelector.classList.add('active');
                        calendarView.style.display = 'none';
                        generateMonthSelector();
                        generateYearSelector();
                    }
                }

                // Hide month/year selector
                function hideMonthYearSelector() {
                    if (monthYearSelector && calendarView) {
                        monthYearSelector.classList.remove('active');
                        calendarView.style.display = 'block';
                    }
                }

                // Apply month/year selection
                function applyMonthYearSelection() {
                    const selectedMonth = monthSelector.querySelector('.selector-item.selected');
                    const selectedYear = yearSelector.querySelector('.year-item.selected');
                    
                    if (selectedMonth && selectedYear) {
                        const month = parseInt(selectedMonth.dataset.month);
                        const year = parseInt(selectedYear.dataset.year);
                        
                        currentDate = new Date(year, month, 1);
                        generateCalendar();
                        hideMonthYearSelector();
                    }
                }

                // Navigation buttons for calendar
                function setupCalendarNavigation() {
                    document.querySelector('.prev-year')?.addEventListener('click', function() {
                        currentDate.setFullYear(currentDate.getFullYear() - 1);
                        generateCalendar();
                    });

                    document.querySelector('.prev-month')?.addEventListener('click', function() {
                        currentDate.setMonth(currentDate.getMonth() - 1);
                        generateCalendar();
                    });

                    document.querySelector('.next-month')?.addEventListener('click', function() {
                        currentDate.setMonth(currentDate.getMonth() + 1);
                        generateCalendar();
                    });

                    document.querySelector('.next-year')?.addEventListener('click', function() {
                        currentDate.setFullYear(currentDate.getFullYear() + 1);
                        generateCalendar();
                    });

                    // Click on month/year title to show selector
                    calendarMonthYear?.addEventListener('click', function() {
                        showMonthYearSelector();
                    });

                    // Cancel selector
                    document.getElementById('cancelSelector')?.addEventListener('click', function() {
                        hideMonthYearSelector();
                    });

                    // Apply month/year selection
                    document.getElementById('applyMonthYear')?.addEventListener('click', function() {
                        applyMonthYearSelection();
                    });
                }

                // Calendar modal functionality
                function setupCalendarModal() {
                    // Open calendar when input is clicked
                    selectedDateDisplay?.addEventListener('click', function() {
                        // Jika input kosong, reset ke tanggal hari ini
                        if (!this.value.trim()) {
                            selectedDate = new Date();
                            currentDate = new Date();
                        }

                        const calendarModal = new bootstrap.Modal(document.getElementById('calendarModal'));
                        calendarModal.show();
                        generateCalendar();
                        hideMonthYearSelector(); // Ensure calendar view is shown
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
                            const form = document.querySelector('form[method="GET"]');
                            if (form) {
                                console.log('Auto-submitting form after date selection');
                                form.submit();
                            }
                        }, 300);
                    });
                }

                // Quick date filter buttons
                function setupQuickFilters() {
                    document.querySelectorAll('.quick-date-btn').forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();

                            console.log('Quick filter:', this.textContent);

                            const days = this.getAttribute('data-days');
                            const monthFilter = this.getAttribute('data-month');
                            const clear = this.getAttribute('data-clear');

                            if (clear) {
                                clearAllFilters();
                                return;
                            }

                            let targetDate = new Date();

                            if (days) {
                                const daysInt = parseInt(days);
                                if (daysInt === 1) {
                                    // Hari ini
                                    targetDate = new Date();
                                } else {
                                    // X hari terakhir (tanggal awal periode)
                                    targetDate.setDate(targetDate.getDate() - daysInt + 1);
                                }
                            } else if (monthFilter === 'current') {
                                // Tanggal 1 bulan ini
                                targetDate = new Date(targetDate.getFullYear(), targetDate.getMonth(),
                                    1);
                            }

                            // Format dates
                            const formattedDateHidden = formatDateForHidden(targetDate);
                            const formattedDateDisplay = formatDateForDisplay(targetDate);

                            // Update input fields
                            if (selectedDateHidden) selectedDateHidden.value = formattedDateHidden;
                            if (selectedDateDisplay) selectedDateDisplay.value = formattedDateDisplay;

                            // Submit form
                            setTimeout(() => {
                                const form = document.querySelector('form[method="GET"]');
                                if (form) {
                                    console.log('Submitting with quick filter:',
                                        formattedDateHidden);
                                    form.submit();
                                }
                            }, 100);
                        });
                    });
                }

                // Form validation and submission
                function setupFormValidation() {
                    const form = document.getElementById('filterForm');
                    if (!form) return;

                    // Handler untuk tombol filter
                    const applyFilterBtn = document.getElementById('applyFilter');
                    if (applyFilterBtn) {
                        applyFilterBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            applyFilter();
                        });
                    }

                    // Handler untuk tombol reset
                    const resetBtn = document.querySelector('a.btn-secondary[href*="stok.index"]');
                    if (resetBtn) {
                        resetBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            clearAllFilters();
                        });
                    }

                    // Handler untuk form submission (jika ada submit programmatic)
                    form.addEventListener('submit', function(e) {
                        // Clear tanggal jika input display kosong
                        if (selectedDateDisplay && !selectedDateDisplay.value.trim()) {
                            if (selectedDateHidden) selectedDateHidden.value = '';
                        }

                        // Validasi tanggal jika ada
                        if (selectedDateHidden && selectedDateHidden.value.trim()) {
                            try {
                                const [year, month, day] = selectedDateHidden.value.split('-').map(Number);
                                const date = new Date(year, month - 1, day);

                                if (isNaN(date.getTime())) {
                                    alert('Tanggal tidak valid. Silakan pilih tanggal yang benar.');
                                    e.preventDefault();
                                    return;
                                }

                                // Pastikan format benar
                                const formattedDate = formatDateForHidden(date);
                                if (formattedDate !== selectedDateHidden.value) {
                                    selectedDateHidden.value = formattedDate;
                                }

                            } catch (error) {
                                console.error('Date validation error:', error);
                                alert('Format tanggal tidak valid. Silakan pilih tanggal dari kalender.');
                                e.preventDefault();
                                return;
                            }
                        }

                        console.log('Form submitting with date:', selectedDateHidden?.value);
                    });
                }

                // Initialize all functions
                function init() {
                    console.log('Initializing stok gudang script...');

                    // Initialize display input dengan tanggal yang valid
                    if (selectedDateDisplay && selectedDate && !isNaN(selectedDate.getTime())) {
                        selectedDateDisplay.value = formatDateForDisplay(selectedDate);
                    } else if (selectedDateDisplay) {
                        selectedDateDisplay.value = '';
                    }

                    // Setup all event listeners
                    setupCalendarNavigation();
                    setupCalendarModal();
                    setupQuickFilters();
                    setupFormValidation();

                    // Generate initial calendar
                    generateCalendar();

                    // Modal shown event
                    const calendarModalElement = document.getElementById('calendarModal');
                    if (calendarModalElement) {
                        calendarModalElement.addEventListener('shown.bs.modal', function() {
                            generateCalendar();
                            hideMonthYearSelector();
                        });
                    }

                    console.log('Script initialization complete');
                }

                // Run initialization
                init();
            });
        </script>
    </body>

    </html>
@endsection