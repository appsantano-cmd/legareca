@extends('layouts.master')

@section('title', 'Transaksi Harian')

@section('content')

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Transaksi Harian</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <style>
            .card-header {
                background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
                color: white;
            }

            .summary-card {
                border-radius: 10px;
                transition: transform 0.2s;
            }

            .summary-card:hover {
                transform: translateY(-5px);
            }

            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(23, 162, 184, 0.05);
            }

            .badge-masuk {
                background-color: #28a745;
            }

            .badge-keluar {
                background-color: #dc3545;
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
                                <i class="bi bi-calendar-check me-2"></i>Laporan Transaksi Harian
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
                                <div class="col-md-4">
                                    <form method="GET" action="{{ route('transactions.laporan') }}" class="d-flex">
                                        <input type="date" name="tanggal" class="form-control me-2"
                                            value="{{ $date }}" required>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i> Tampilkan
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-8 text-end">
                                    <h5 class="text-muted">
                                        <i class="bi bi-calendar-event me-2"></i>
                                        {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
                                    </h5>
                                </div>
                            </div>

                            <!-- Summary Cards -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card bg-success text-white summary-card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="bi bi-box-arrow-in-down me-2"></i>Total Stok Masuk
                                            </h6>
                                            <h3>{{ number_format($summary['masuk'], 2) }}</h3>
                                            <small>Unit barang masuk</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-danger text-white summary-card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="bi bi-box-arrow-up me-2"></i>Total Stok Keluar
                                            </h6>
                                            <h3>{{ number_format($summary['keluar'], 2) }}</h3>
                                            <small>Unit barang keluar</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-info text-white summary-card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="bi bi-clipboard-data me-2"></i>Total Transaksi
                                            </h6>
                                            <h3>{{ $summary['total_transaksi'] }}</h3>
                                            <small>Transaksi disetujui</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Transactions Table -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Waktu</th>
                                            <th>Barang</th>
                                            <th>Tipe</th>
                                            <th>Jumlah</th>
                                            <th>Kategori</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $transaction)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $transaction->created_at->format('H:i') }}</td>
                                                <td>
                                                    <div>
                                                        <small
                                                            class="text-muted">{{ $transaction->kode_barang }}</small><br>
                                                        {{ $transaction->nama_barang }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $transaction->tipe }}">
                                                        {{ $transaction->tipe == 'masuk' ? 'MASUK' : 'KELUAR' }}
                                                    </span>
                                                </td>
                                                <td
                                                    class="{{ $transaction->tipe == 'masuk' ? 'text-success' : 'text-danger' }}">
                                                    <strong>{{ number_format($transaction->jumlah, 2) }}</strong>
                                                    {{ $transaction->satuan }}
                                                </td>
                                                <td>{{ $transaction->kategori }}</td>
                                                <td>{{ $transaction->keterangan ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <i class="bi bi-inbox display-4 d-block text-muted mb-2"></i>
                                                    Tidak ada transaksi pada tanggal ini
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Print Header (hidden in screen) -->
                            <div class="d-none d-print-block">
                                <h1 class="text-center">Laporan Transaksi Harian</h1>
                                <h3 class="text-center">
                                    Tanggal: {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
                                </h3>
                                <hr>
                                <p class="text-center">
                                    Dicetak pada: {{ now()->translatedFormat('l, d F Y H:i:s') }}
                                </p>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>

@endsection
