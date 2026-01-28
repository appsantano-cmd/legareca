<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengajuan Tukar Shift</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-container {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-view {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-view:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .btn-new {
            background-color: var(--success-color);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-new:hover {
            background-color: #219653;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .date-badge {
            background-color: #e9ecef;
            color: #495057;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .time-badge {
            background-color: #e3f2fd;
            color: #1565c0;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
            }

            .table th,
            .table td {
                padding: 10px 8px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header-container">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold">
                        <i class="fas fa-exchange-alt me-3"></i>Pengajuan Tukar Shift
                    </h1>
                    <p class="lead mb-0">Daftar seluruh pengajuan pertukaran shift karyawan</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('dashboard') }}" class="btn-new">
                        <i class="fas fa-plus-circle"></i> Dashboard
                    </a>
                    <a href="{{ route('shifting.create') }}" class="btn-new">
                        <i class="fas fa-plus-circle"></i> Ajukan Shift Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Pengajuan</h6>
                                <h3 class="mb-0">{{ $shiftings->count() }}</h3>
                            </div>
                            <div class="bg-primary text-white rounded-circle p-3">
                                <i class="fas fa-file-alt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Pending</h6>
                                <h3 class="mb-0">{{ $shiftings->where('status', 'pending')->count() }}</h3>
                            </div>
                            <div class="bg-warning text-white rounded-circle p-3">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Disetujui</h6>
                                <h3 class="mb-0">{{ $shiftings->where('status', 'approved')->count() }}</h3>
                            </div>
                            <div class="bg-success text-white rounded-circle p-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Ditolak</h6>
                                <h3 class="mb-0">{{ $shiftings->where('status', 'rejected')->count() }}</h3>
                            </div>
                            <div class="bg-danger text-white rounded-circle p-3">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-container">
            @if ($shiftings->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-clipboard-list"></i>
                    <h4 class="mt-3">Belum ada pengajuan</h4>
                    <p class="text-muted">Silakan ajukan permintaan tukar shift baru</p>
                    <a href="{{ route('shifting.create') }}" class="btn btn-primary btn-lg mt-3">
                        <i class="fas fa-plus me-2"></i>Ajukan Shift
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Karyawan</th>
                                <th>Divisi/Jabatan</th>
                                <th>Shift Asli</th>
                                <th>Shift Tujuan</th>
                                <th>Pengganti</th>
                                <th>Status</th>
                                <th>Diajukan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shiftings as $shift)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $shift->nama_karyawan }}</strong>
                                    </td>
                                    <td>{{ $shift->divisi_jabatan }}</td>
                                    <td>
                                        <div class="date-badge">
                                            {{ \Carbon\Carbon::parse($shift->tanggal_shift_asli)->format('d/m/Y') }}
                                        </div>
                                        <div class="time-badge mt-1">
                                            {{ \Carbon\Carbon::parse($shift->jam_shift_asli)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-badge">
                                            {{ \Carbon\Carbon::parse($shift->tanggal_shift_tujuan)->format('d/m/Y') }}
                                        </div>
                                        <div class="time-badge mt-1">
                                            {{ \Carbon\Carbon::parse($shift->jam_shift_tujuan)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($shift->sudah_pengganti == 'ya')
                                            <span class="badge bg-success">Ya</span>
                                            @if ($shift->nama_karyawan_pengganti)
                                                <small
                                                    class="d-block mt-1">{{ $shift->nama_karyawan_pengganti }}</small>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Belum</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($shift->status == 'pending')
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-clock me-1"></i>Pending
                                            </span>
                                        @elseif($shift->status == 'approved')
                                            <span class="status-badge status-approved">
                                                <i class="fas fa-check me-1"></i>Disetujui
                                            </span>
                                        @elseif($shift->status == 'rejected')
                                            <span class="status-badge status-rejected">
                                                <i class="fas fa-times me-1"></i>Ditolak
                                            </span>
                                        @else
                                            <span class="status-badge">{{ $shift->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($shift->created_at)->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        <button type="button" class="action-btn btn-view" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $shift->id }}">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </button>

                                        <!-- Modal Detail -->
                                        <div class="modal fade" id="detailModal{{ $shift->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            Detail Pengajuan Tukar Shift
                                                        </h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <!-- Info Karyawan -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Nama
                                                                    Karyawan</label>
                                                                <p class="fw-bold">{{ $shift->nama_karyawan }}</p>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label
                                                                    class="form-label text-muted">Divisi/Jabatan</label>
                                                                <p class="fw-bold">{{ $shift->divisi_jabatan }}</p>
                                                            </div>

                                                            <!-- Shift Asli -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Shift Asli</label>
                                                                <div class="border rounded p-3 bg-light">
                                                                    <p class="mb-1">
                                                                        <strong>Tanggal:</strong>
                                                                        {{ \Carbon\Carbon::parse($shift->tanggal_shift_asli)->format('d F Y') }}
                                                                    </p>
                                                                    <p class="mb-0">
                                                                        <strong>Jam:</strong>
                                                                        <span
                                                                            class="text-primary">{{ \Carbon\Carbon::parse($shift->jam_shift_asli)->format('H:i') }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <!-- Shift Tujuan -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Shift
                                                                    Tujuan</label>
                                                                <div class="border rounded p-3 bg-light">
                                                                    <p class="mb-1">
                                                                        <strong>Tanggal:</strong>
                                                                        {{ \Carbon\Carbon::parse($shift->tanggal_shift_tujuan)->format('d F Y') }}
                                                                    </p>
                                                                    <p class="mb-0">
                                                                        <strong>Jam:</strong>
                                                                        <span
                                                                            class="text-primary">{{ \Carbon\Carbon::parse($shift->jam_shift_tujuan)->format('H:i') }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <!-- Alasan -->
                                                            <div class="col-12 mb-3">
                                                                <label class="form-label text-muted">Alasan
                                                                    Pengajuan</label>
                                                                <div class="border rounded p-3 bg-light">
                                                                    <p class="mb-0">{{ $shift->alasan }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Info Pengganti -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Sudah Ada
                                                                    Pengganti?</label>
                                                                <p class="fw-bold text-uppercase">
                                                                    {{ $shift->sudah_pengganti }}</p>
                                                            </div>

                                                            @if ($shift->sudah_pengganti == 'ya')
                                                                <!-- Nama Pengganti -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label text-muted">Nama Karyawan
                                                                        Pengganti</label>
                                                                    <p class="fw-bold">
                                                                        {{ $shift->nama_karyawan_pengganti ?? '-' }}
                                                                    </p>
                                                                </div>

                                                                <!-- Shift Pengganti -->
                                                                @if ($shift->tanggal_shift_pengganti && $shift->jam_shift_pengganti)
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="form-label text-muted">Shift
                                                                            Pengganti</label>
                                                                        <div class="border rounded p-3 bg-light">
                                                                            <p class="mb-1">
                                                                                <strong>Tanggal:</strong>
                                                                                {{ \Carbon\Carbon::parse($shift->tanggal_shift_pengganti)->format('d F Y') }}
                                                                            </p>
                                                                            <p class="mb-0">
                                                                                <strong>Jam:</strong>
                                                                                <span
                                                                                    class="text-primary">{{ \Carbon\Carbon::parse($shift->jam_shift_pengganti)->format('H:i') }}</span>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif

                                                            <!-- Status & Tanggal -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Status
                                                                    Pengajuan</label>
                                                                <p class="mb-0">
                                                                    @if ($shift->status == 'pending')
                                                                        <span class="status-badge status-pending">
                                                                            <i class="fas fa-clock me-1"></i>Pending
                                                                        </span>
                                                                    @elseif($shift->status == 'approved')
                                                                        <span class="status-badge status-approved">
                                                                            <i class="fas fa-check me-1"></i>Disetujui
                                                                        </span>
                                                                    @elseif($shift->status == 'rejected')
                                                                        <span class="status-badge status-rejected">
                                                                            <i class="fas fa-times me-1"></i>Ditolak
                                                                        </span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-secondary">{{ $shift->status }}</span>
                                                                    @endif
                                                                </p>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Tanggal
                                                                    Pengajuan</label>
                                                                <p class="fw-bold">
                                                                    {{ \Carbon\Carbon::parse($shift->created_at)->format('d F Y H:i:s') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination (jika diperlukan) -->
                @if ($shiftings instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-center mt-4">
                        {{ $shiftings->links() }}
                    </div>
                @endif
            @endif
        </div>

        <!-- Footer Info -->
        <div class="text-center mt-4 text-muted">
            <p>
                <i class="fas fa-sync-alt me-2"></i>
                Data diperbarui secara real-time dari database
            </p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Tooltip initialization
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>

</html>
