@extends('layouts.master')

@section('title', 'Stok Gudang')

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
                            <form method="GET" action="{{ route('stok.index') }}" class="mb-4">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari kode/nama barang..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select name="bulan" class="form-select">
                                            <option value="">Pilih Bulan</option>
                                            @foreach ($bulanList as $key => $bulan)
                                                <option value="{{ $key }}"
                                                    {{ request('bulan') == $key ? 'selected' : '' }}>
                                                    {{ $bulan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="tahun" class="form-select">
                                            <option value="">Pilih Tahun</option>
                                            @foreach ($tahunList as $tahun)
                                                <option value="{{ $tahun }}"
                                                    {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                                    {{ $tahun }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i> Cari
                                        </button>
                                        <a href="{{ route('stok.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-clockwise"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <!-- Stok Summary -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">Total Barang</h6>
                                            <h4>{{ $stok->total() }}</h4>
                                            <small>Jenis barang di gudang</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">Total Stok Akhir</h6>
                                            <h4>{{ number_format($stok->sum('stok_akhir'), 2) }}</h4>
                                            <small>Total keseluruhan stok</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">Stok Masuk Bulan Ini</h6>
                                            <h4>{{ number_format($stok->where('bulan', date('m'))->where('tahun', date('Y'))->sum('stok_masuk'), 2) }}
                                            </h4>
                                            <small>Bulan {{ date('F') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <h6 class="card-title">Stok Keluar Bulan Ini</h6>
                                            <h4>{{ number_format($stok->where('bulan', date('m'))->where('tahun', date('Y'))->sum('stok_keluar'), 2) }}
                                            </h4>
                                            <small>Bulan {{ date('F') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stok Table -->
                            <div class="table-responsive">
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
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($stok as $item)
                                            <tr>
                                                <td>{{ $loop->iteration + ($stok->currentPage() - 1) * $stok->perPage() }}
                                                </td>
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
                                                    @if ($item->stok_akhir <= 0)
                                                        <span class="badge bg-danger">Habis</span>
                                                    @elseif($item->stok_akhir < 10)
                                                        <span class="badge bg-warning">Menipis</span>
                                                    @else
                                                        <span class="badge bg-success">Tersedia</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                        title="Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                        title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center text-muted py-4">
                                                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                                    Tidak ada data stok ditemukan
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Menampilkan {{ $stok->firstItem() ?? 0 }} - {{ $stok->lastItem() ?? 0 }} dari
                                    {{ $stok->total() }} data
                                </div>
                                <nav>
                                    {{ $stok->withQueryString()->links() }}
                                </nav>
                            </div>
                        </div>
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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        </script>
    </body>

    </html>

@endsection
