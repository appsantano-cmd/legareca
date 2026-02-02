@extends('layouts.master')

@section('title', 'TRANSAKSI STOK HARIAN')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-arrow-left-right me-2"></i>Transaksi Stok Harian
                        </h4>
                        <div>
                            <a href="{{ route('transactions.export.form') }}" class="btn btn-success me-2">
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
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Filter Form -->
                        <div class="card filter-card mb-4">
                            <div class="card-body">
                                <form method="GET" action="{{ route('transactions.index') }}">
                                    <div class="row g-3">
                                        <div class="col-md-2">
                                            <label class="form-label">Tanggal</label>
                                            <input type="date" name="tanggal" class="form-control"
                                                value="{{ request('tanggal', date('Y-m-d')) }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Tipe</label>
                                            <select name="tipe" class="form-select">
                                                <option value="">Semua</option>
                                                <option value="masuk" {{ request('tipe') == 'masuk' ? 'selected' : '' }}>
                                                    Masuk</option>
                                                <option value="keluar" {{ request('tipe') == 'keluar' ? 'selected' : '' }}>
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
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="bi bi-search"></i>
                                            </button>
                                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </a>
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
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                                            </td>
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
                                            <td
                                                class="{{ $transaction->tipe == 'masuk' ? 'text-success' : 'text-danger' }}">
                                                <strong>{{ number_format($transaction->jumlah, 2) }}</strong>
                                            </td>
                                            <td>{{ $transaction->satuan }}</td>
                                            <td>
                                                @if ($transaction->tipe == 'masuk')
                                                    <small><strong>Supplier:</strong> {{ $transaction->supplier }}</small>
                                                @else
                                                    <div>
                                                        <small><strong>Departemen:</strong>
                                                            {{ $transaction->departemen }}</small><br>
                                                        <small><strong>Keperluan:</strong>
                                                            {{ $transaction->keperluan }}</small>
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
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center py-4">
                                                <i class="bi bi-inbox display-4 d-block text-muted mb-2"></i>
                                                Tidak ada transaksi ditemukan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Menampilkan {{ $transactions->firstItem() ?? 0 }} -
                                {{ $transactions->lastItem() ?? 0 }}
                                dari {{ $transactions->total() }} transaksi
                            </div>
                            <div>
                                {{ $transactions->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        .summary-card {
            transition: transform 0.2s;
        }

        .summary-card:hover {
            transform: translateY(-5px);
        }

        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
                // Buat form dinamis
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/transactions/' + id;
                form.style.display = 'none';

                // Tambahkan CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Tambahkan method spoofing
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
