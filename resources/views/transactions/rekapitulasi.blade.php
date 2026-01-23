@extends('layouts.master')

@section('title', 'Rekapitulasi')

@section('content')

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rekapitulasi Transaksi</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <style>
            .card-header {
                background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
                color: white;
            }

            .rekapitulasi-card {
                border-left: 4px solid #6f42c1;
                margin-bottom: 15px;
            }

            .rekapitulasi-header {
                background-color: #f8f9fa;
                cursor: pointer;
                padding: 12px 15px;
                border-bottom: 1px solid #dee2e6;
            }

            .rekapitulasi-header:hover {
                background-color: #e9ecef;
            }

            .rekapitulasi-body {
                padding: 15px;
                background-color: white;
            }

            .badge-summary {
                font-size: 0.9em;
                padding: 5px 10px;
            }

            .table-sm th,
            .table-sm td {
                padding: 0.5rem;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="bi bi-bar-chart me-2"></i>Rekapitulasi Transaksi
                            </h4>
                            <div>
                                <button onclick="window.print()" class="btn btn-light me-2">
                                    <i class="bi bi-printer me-1"></i> Print
                                </button>
                                <a href="{{ route('transactions.index') }}" class="btn btn-light">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Filter Form -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <form method="GET" action="{{ route('transactions.rekapitulasi') }}" class="row g-2">
                                        <div class="col-md-5">
                                            <label class="form-label">Dari Tanggal</label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ $startDate }}" required>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Sampai Tanggal</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ $endDate }}" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-search"></i> Filter
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h5 class="text-muted">
                                        <i class="bi bi-calendar-range me-2"></i>
                                        {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}
                                    </h5>
                                </div>
                            </div>

                            <!-- Summary -->
                            @php
                                $totalMasuk = 0;
                                $totalKeluar = 0;
                                $totalBarang = count($rekapitulasi);
                            @endphp

                            <!-- Rekapitulasi per Barang -->
                            @foreach ($rekapitulasi as $kodeBarang => $data)
                                @php
                                    $totalMasuk += $data['masuk'];
                                    $totalKeluar += $data['keluar'];
                                @endphp

                                <div class="card rekapitulasi-card">
                                    <div class="rekapitulasi-header" onclick="toggleDetail('detail-{{ $kodeBarang }}')">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $data['nama_barang'] }}</strong>
                                                <small class="text-muted ms-2">{{ $kodeBarang }}</small>
                                                <span class="badge bg-secondary ms-2">{{ $data['satuan'] }}</span>
                                            </div>
                                            <div>
                                                <span class="badge bg-success badge-summary">
                                                    <i class="bi bi-box-arrow-in-down"></i>
                                                    {{ number_format($data['masuk'], 2) }} Masuk
                                                </span>
                                                <span class="badge bg-danger badge-summary ms-1">
                                                    <i class="bi bi-box-arrow-up"></i>
                                                    {{ number_format($data['keluar'], 2) }} Keluar
                                                </span>
                                                <i class="bi bi-chevron-down ms-2"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="detail-{{ $kodeBarang }}" class="rekapitulasi-body collapse">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover">
                                                <thead>
                                                    <tr class="table-light">
                                                        <th>Tanggal</th>
                                                        <th>Tipe</th>
                                                        <th>Jumlah</th>
                                                        <th>Kategori</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['transactions'] as $transaction)
                                                        <tr>
                                                            <td>{{ $transaction->tanggal->format('d/m/Y') }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-{{ $transaction->tipe == 'masuk' ? 'success' : 'danger' }}">
                                                                    {{ $transaction->tipe == 'masuk' ? 'MASUK' : 'KELUAR' }}
                                                                </span>
                                                            </td>
                                                            <td
                                                                class="{{ $transaction->tipe == 'masuk' ? 'text-success' : 'text-danger' }}">
                                                                {{ number_format($transaction->jumlah, 2) }}
                                                            </td>
                                                            <td>{{ $transaction->kategori }}</td>
                                                            <td>{{ $transaction->keterangan ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if (empty($rekapitulasi))
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox display-4 d-block text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak ada data transaksi</h5>
                                    <p class="text-muted">Tidak ada transaksi pada periode yang dipilih</p>
                                </div>
                            @endif

                            <!-- Total Summary -->
                            @if (!empty($rekapitulasi))
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body">
                                                <h6 class="card-title">Total Barang</h6>
                                                <h3>{{ $totalBarang }}</h3>
                                                <small>Jenis barang dengan transaksi</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-success text-white">
                                            <div class="card-body">
                                                <h6 class="card-title">Total Masuk</h6>
                                                <h3>{{ number_format($totalMasuk, 2) }}</h3>
                                                <small>Total unit masuk semua barang</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-danger text-white">
                                            <div class="card-body">
                                                <h6 class="card-title">Total Keluar</h6>
                                                <h3>{{ number_format($totalKeluar, 2) }}</h3>
                                                <small>Total unit keluar semua barang</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function toggleDetail(id) {
                const element = document.getElementById(id);
                const collapse = new bootstrap.Collapse(element, {
                    toggle: true
                });
            }
        </script>
    </body>

    </html>
@endsection
