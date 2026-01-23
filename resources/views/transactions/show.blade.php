@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detail Transaksi - {{ $transaction->kode_barang }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <style>
            .detail-card {
                border-left: 4px solid #4CAF50;
            }

            .badge-pending {
                background-color: #ffc107;
                color: #000;
            }

            .badge-approved {
                background-color: #28a745;
                color: white;
            }

            .badge-rejected {
                background-color: #dc3545;
                color: white;
            }

            .info-label {
                font-weight: 600;
                color: #495057;
                width: 200px;
            }

            .info-value {
                color: #6c757d;
            }

            .bukti-img {
                max-width: 300px;
                max-height: 300px;
                border: 1px solid #dee2e6;
                border-radius: 5px;
            }
        </style>
    </head>

    <body>
        <div class="container py-4">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow detail-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="bi bi-file-text me-2"></i>Detail Transaksi
                            </h4>
                            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-light">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>

                        <div class="card-body">
                            <!-- Transaction Info -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2">Informasi Transaksi</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="info-label">ID Transaksi:</td>
                                            <td class="info-value">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Tanggal:</td>
                                            <td class="info-value">{{ $transaction->tanggal->format('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Waktu Input:</td>
                                            <td class="info-value">{{ $transaction->created_at->format('d/m/Y H:i:s') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Tipe:</td>
                                            <td class="info-value">
                                                <span
                                                    class="badge bg-{{ $transaction->tipe == 'masuk' ? 'success' : 'danger' }}">
                                                    {{ $transaction->tipe == 'masuk' ? 'STOK MASUK' : 'STOK KELUAR' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Status:</td>
                                            <td class="info-value">
                                                <span class="badge badge-{{ $transaction->status }}">
                                                    {{ strtoupper($transaction->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2">Informasi Barang</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="info-label">Kode Barang:</td>
                                            <td class="info-value">
                                                <span class="badge bg-secondary">{{ $transaction->kode_barang }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Nama Barang:</td>
                                            <td class="info-value">{{ $transaction->nama_barang }}</td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Jumlah:</td>
                                            <td class="info-value">
                                                <span
                                                    class="{{ $transaction->tipe == 'masuk' ? 'text-success' : 'text-danger' }}">
                                                    <strong>{{ number_format($transaction->jumlah, 2) }}</strong>
                                                    {{ $transaction->satuan }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="info-label">Kategori:</td>
                                            <td class="info-value">{{ $transaction->kategori }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- People Info -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5 class="border-bottom pb-2">Informasi Pencatatan</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="info-label">Keterangan:</td>
                                            <td class="info-value">{{ $transaction->keterangan ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>

                                @if ($transaction->status != 'pending')
                                    <div class="col-md-6">
                                        <h5 class="border-bottom pb-2">Informasi Approval</h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="info-label">Diupdate:</td>
                                                <td class="info-value">
                                                    {{ $transaction->updated_at->format('d/m/Y H:i:s') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="info-label">Catatan Admin:</td>
                                                <td class="info-value">{{ $transaction->catatan_admin ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <!-- Bukti Transaksi -->
                            @if ($transaction->bukti)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5 class="border-bottom pb-2">Bukti Transaksi</h5>
                                        <div class="mt-3">
                                            @if (in_array(pathinfo($transaction->bukti, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                <img src="{{ asset('storage/' . $transaction->bukti) }}"
                                                    alt="Bukti Transaksi" class="bukti-img img-fluid">
                                            @else
                                                <div class="alert alert-info">
                                                    <i class="bi bi-file-earmark-pdf me-2"></i>
                                                    <a href="{{ asset('storage/' . $transaction->bukti) }}" target="_blank"
                                                        class="text-decoration-none">
                                                        Download Dokumen Bukti (PDF/Doc)
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            @if ($transaction->status == 'pending')
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-2">
                                            <form action="{{ route('transactions.reject', $transaction->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="button" class="btn btn-danger reject-btn"
                                                    data-id="{{ $transaction->id }}">
                                                    <i class="bi bi-x-circle me-1"></i> Tolak
                                                </button>
                                            </form>
                                            <form action="{{ route('transactions.approve', $transaction->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="button" class="btn btn-success approve-btn"
                                                    data-id="{{ $transaction->id }}">
                                                    <i class="bi bi-check-circle me-1"></i> Approve
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals (same as index) -->
        <div class="modal fade" id="approveModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-check-circle text-success me-2"></i>Approve Transaksi
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="approveForm" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menyetujui transaksi ini?</p>
                            <div class="mb-3">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-x-circle text-danger me-2"></i>Tolak Transaksi
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="rejectForm" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menolak transaksi ini?</p>
                            <div class="mb-3">
                                <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                <textarea name="catatan_admin" class="form-control" rows="3" required placeholder="Berikan alasan penolakan"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Approve button handler
            document.querySelector('.approve-btn')?.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const form = document.getElementById('approveForm');
                form.action = `/transactions/${id}/approve`;

                const modal = new bootstrap.Modal(document.getElementById('approveModal'));
                modal.show();
            });

            // Reject button handler
            document.querySelector('.reject-btn')?.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const form = document.getElementById('rejectForm');
                form.action = `/transactions/${id}/reject`;

                const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
                modal.show();
            });
        </script>
    </body>

    </html>

@endsection
