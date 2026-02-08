@extends('layouts.master')

@section('title', 'TRANSAKSI STOK HARIAN')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Transaksi Stok Harian</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <style>
            .card-header {
                background: linear-gradient(135deg, #263238 0%, #37474F 100%);
                color: white;
            }

            .badge-masuk {
                background-color: #17a2b8;
                color: white;
            }

            .badge-keluar {
                background-color: #6f42c1;
                color: white;
            }

            .filter-card {
                background-color: #f8f9fa;
                border-left: 4px solid #4CAF50;
            }

            .btn-group-sm .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
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

            /* Styling untuk tabel */
            .table-responsive {
                margin-bottom: 1.5rem;
                border-radius: 0.5rem;
                overflow: hidden;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }

            .table-hover tbody tr:hover {
                background-color: rgba(0, 0, 0, 0.03);
            }

            .table-dark {
                background-color: #2c3e50;
            }

            /* Styling untuk filter card */
            .filter-card .card-body {
                padding: 1.25rem;
            }

            .filter-card .form-label {
                font-size: 0.875rem;
                font-weight: 500;
                margin-bottom: 0.25rem;
                color: #495057;
            }

            /* Responsive table pada mobile */
            @media (max-width: 768px) {
                .table-responsive {
                    font-size: 0.875rem;
                }

                .btn-group {
                    display: flex;
                    flex-direction: column;
                    gap: 0.25rem;
                }

                .btn-group-sm .btn {
                    width: 100%;
                }
            }
        </style>
    </head>

    <body>
        <div class="container-fluid py-4">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="bi bi-arrow-left-right me-2"></i>Transaksi Stok Harian
                            </h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('transactions.export.form') }}" class="btn btn-success">
                                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                                </a>
                                <a href="{{ route('transactions.create') }}" class="btn btn-light">
                                    <i class="bi bi-plus-circle me-1"></i> Transaksi Baru
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Flash Messages -->
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center"
                                    role="alert">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <div>{{ session('success') }}</div>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center"
                                    role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <div>{{ session('error') }}</div>
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Filter Form -->
                            <div class="card filter-card mb-4">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('transactions.index') }}" id="filterForm">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-2">
                                                <label class="form-label">Tanggal</label>
                                                <input type="date" name="tanggal" class="form-control"
                                                    value="{{ request('tanggal', date('Y-m-d')) }}">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Tipe</label>
                                                <select name="tipe" class="form-select">
                                                    <option value="">Semua</option>
                                                    <option value="masuk"
                                                        {{ request('tipe') == 'masuk' ? 'selected' : '' }}>
                                                        Masuk</option>
                                                    <option value="keluar"
                                                        {{ request('tipe') == 'keluar' ? 'selected' : '' }}>
                                                        Keluar</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Supplier</label>
                                                <input type="text" name="supplier" class="form-control"
                                                    value="{{ request('supplier') }}" placeholder="Nama supplier">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Departemen</label>
                                                <input type="text" name="departemen" class="form-control"
                                                    value="{{ request('departemen') }}" placeholder="Nama departemen">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Cari Barang</label>
                                                <input type="text" name="search" class="form-control"
                                                    value="{{ request('search') }}" placeholder="Kode/Nama barang">
                                            </div>
                                            <div class="col-md-1">
                                                <div class="d-flex gap-2" style="padding-top: 1.65rem;">
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="bi bi-search"></i>
                                                    </button>
                                                    <a href="{{ route('transactions.index') }}"
                                                        class="btn btn-secondary w-100">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Transactions Table -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Tipe</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Info</th>
                                            <th>Penerima</th>
                                            <th>Waktu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $startNumber = ($transactions->currentPage() - 1) * $transactions->perPage() + 1;
                                        @endphp
                                        @forelse($transactions as $transaction)
                                            <tr>
                                                <td>{{ $startNumber++ }}</td>
                                                <td>{{ $transaction->tanggal->format('d/m/Y') }}</td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $transaction->kode_barang }}</span>
                                                </td>
                                                <td>{{ $transaction->nama_barang }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $transaction->tipe == 'masuk' ? 'success' : 'danger' }}">
                                                        {{ $transaction->tipe == 'masuk' ? 'MASUK' : 'KELUAR' }}
                                                    </span>
                                                </td>
                                                <td class="{{ $transaction->tipe == 'masuk' ? 'text-success' : 'text-danger' }}">
                                                    <strong>{{ number_format($transaction->jumlah, 2) }}</strong>
                                                </td>
                                                <td>{{ $transaction->satuan }}</td>
                                                <td>
                                                    @if ($transaction->tipe == 'masuk')
                                                        <small><strong>Supplier:</strong>
                                                            {{ $transaction->supplier ?? '-' }}</small>
                                                    @else
                                                        <div>
                                                            <small><strong>Departemen:</strong>
                                                                {{ $transaction->departemen ?? '-' }}</small><br>
                                                            <small><strong>Keperluan:</strong>
                                                                {{ $transaction->keperluan ?? '-' }}</small>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->nama_penerima }}</td>
                                                <td>{{ $transaction->created_at->format('H:i') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('transactions.edit', $transaction->id) }}"
                                                            class="btn btn-warning" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')"
                                                                title="Hapus">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center py-4">
                                                    <i class="bi bi-inbox display-4 d-block text-muted mb-2"></i>
                                                    @if (request()->has('tanggal') || request()->has('tipe') || request()->has('search') || request()->has('supplier') || request()->has('departemen'))
                                                        Tidak ada transaksi ditemukan dengan filter yang diterapkan
                                                    @else
                                                        Belum ada transaksi stok harian
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- FIX: Pagination dengan struktur yang lebih rapih -->
                            <div class="pagination-wrapper">
                                <!-- Informasi data -->
                                <div class="pagination-info">
                                    Menampilkan <strong>{{ $transactions->firstItem() ?? 0 }} -
                                        {{ $transactions->lastItem() ?? 0 }}</strong>
                                    dari <strong>{{ $transactions->total() }}</strong> transaksi
                                </div>

                                <!-- Kontrol pagination -->
                                <div class="pagination-controls">
                                    <!-- Form Lompat ke Halaman -->
                                    @if ($transactions->lastPage() > 1)
                                        <form method="GET" class="goto-page-form" id="gotoPageForm">
                                            @foreach (request()->except(['page', 'per_page']) as $key => $value)
                                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                            @endforeach
                                            <input type="hidden" name="per_page"
                                                value="{{ request('per_page', 10) }}">

                                            <span class="goto-label">Ke halaman:</span>
                                            <input type="number" name="page"
                                                class="form-control form-control-sm goto-page-input" min="1"
                                                max="{{ $transactions->lastPage() }}"
                                                value="{{ $transactions->currentPage() }}"
                                                onchange="this.form.submit()">
                                        </form>
                                    @endif

                                    <!-- Selector Per Page -->
                                    <form method="GET" class="per-page-form" id="perPageForm">
                                        @foreach (request()->except(['per_page', 'page']) as $key => $value)
                                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                        @endforeach
                                        <input type="hidden" name="page" value="{{ $transactions->currentPage() }}">

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
                                    {{ $transactions->withQueryString()->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });

                // Auto-hide alerts after 5 seconds
                setTimeout(function() {
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    });
                }, 5000);

                // Reset form button functionality
                const resetBtn = document.querySelector('.btn-secondary[href="{{ route('transactions.index') }}"]');
                if (resetBtn) {
                    resetBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        // Clear all form inputs
                        document.getElementById('filterForm').reset();
                        // Set tanggal to today
                        document.querySelector('input[name="tanggal"]').value = '{{ date('Y-m-d') }}';
                        // Submit the form
                        document.getElementById('filterForm').submit();
                    });
                }

                // Per page form - preserve all filter parameters
                const perPageForm = document.getElementById('perPageForm');
                if (perPageForm) {
                    perPageForm.addEventListener('submit', function(e) {
                        // Preserve all other form inputs
                        const filterForm = document.getElementById('filterForm');
                        const filterInputs = filterForm.querySelectorAll('input[name], select[name]');
                        
                        filterInputs.forEach(input => {
                            if (input.name !== 'per_page' && input.name !== 'page') {
                                const hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = input.name;
                                hiddenInput.value = input.value;
                                perPageForm.appendChild(hiddenInput);
                            }
                        });
                    });
                }

                // Go to page form - preserve all filter parameters
                const gotoPageForm = document.getElementById('gotoPageForm');
                if (gotoPageForm) {
                    gotoPageForm.addEventListener('submit', function(e) {
                        // Preserve all other form inputs
                        const filterForm = document.getElementById('filterForm');
                        const filterInputs = filterForm.querySelectorAll('input[name], select[name]');
                        
                        filterInputs.forEach(input => {
                            if (input.name !== 'page' && input.name !== 'per_page') {
                                const hiddenInput = document.createElement('input');
                                hiddenInput.type = 'hidden';
                                hiddenInput.name = input.name;
                                hiddenInput.value = input.value;
                                gotoPageForm.appendChild(hiddenInput);
                            }
                        });
                    });
                }
            });
        </script>
    </body>

    </html>
@endsection