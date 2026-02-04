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
            padding-bottom: 20px;
        }

        /* Header */
        .header-container {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 1.5rem;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .header-subtitle {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Card */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            margin-bottom: 15px;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Status Badge */
        .status-badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
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

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        /* Table */
        .table th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 10px;
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .table td {
            padding: 12px 10px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }

        /* Action Buttons */
        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
        }

        .btn-view {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-view:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        /* Header Buttons */
        .btn-header {
            background-color: var(--success-color);
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            margin: 3px;
        }

        .btn-header:hover {
            background-color: #219653;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.2);
        }

        .btn-export {
            background-color: #28a745;
        }

        .btn-export:hover {
            background-color: #218838;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        /* Badges */
        .date-badge {
            background-color: #e9ecef;
            color: #495057;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
            margin: 2px 0;
        }

        .time-badge {
            background-color: #e3f2fd;
            color: #1565c0;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
            margin: 2px 0;
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-decoration: none;
            color: #333;
            transition: background 0.3s;
        }

        .mobile-menu-item:last-child {
            border-bottom: none;
        }

        .mobile-menu-item:hover {
            background-color: #f8f9fa;
        }

        .mobile-menu-icon {
            width: 30px;
            color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                padding: 1.2rem 0;
                border-radius: 0 0 10px 10px;
            }
            
            .header-title {
                font-size: 1.5rem;
            }
            
            .header-subtitle {
                font-size: 0.9rem;
            }
            
            .desktop-buttons {
                display: none;
            }
            
            .mobile-menu {
                display: block;
            }
            
            .table-container {
                padding: 15px;
                border-radius: 10px;
            }
            
            .table-responsive {
                border-radius: 8px;
                border: 1px solid #dee2e6;
            }
            
            .table th,
            .table td {
                padding: 8px 6px;
                font-size: 0.85rem;
            }
            
            .status-badge {
                padding: 4px 8px;
                font-size: 0.75rem;
            }
            
            .card {
                margin-bottom: 10px;
            }
            
            .card-body {
                padding: 15px;
            }
            
            .table-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .table-title {
                text-align: center;
                margin-bottom: 10px;
            }
            
            .empty-state {
                padding: 30px 15px;
            }
            
            .empty-state i {
                font-size: 2.5rem;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-menu {
                display: none;
            }
            
            .desktop-buttons {
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-end;
                gap: 8px;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease;
        }
        
        /* Modal Responsive */
        @media (max-width: 576px) {
            .modal-dialog {
                margin: 10px;
            }
            
            .modal-content {
                border-radius: 10px;
            }
            
            .modal-body {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header-container">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-7 col-12 mb-3 mb-md-0">
                    <h1 class="header-title fw-bold">
                        <i class="fas fa-exchange-alt me-2"></i>Pengajuan Tukar Shift
                    </h1>
                    <p class="header-subtitle mb-0">Daftar seluruh pengajuan pertukaran shift karyawan</p>
                </div>
                <div class="col-lg-4 col-md-5 col-12">
                    <div class="desktop-buttons">
                        <a href="{{ route('dashboard') }}" class="btn-header">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                        <a href="{{ route('shifting.create') }}" class="btn-header">
                            <i class="fas fa-plus-circle me-1"></i>Ajukan Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (Visible only on mobile) -->
    <div class="container mobile-menu fade-in">
        <a href="{{ route('dashboard') }}" class="mobile-menu-item">
            <div class="mobile-menu-icon">
                <i class="fas fa-tachometer-alt"></i>
            </div>
            <span class="ms-3">Dashboard</span>
        </a>
        <a href="{{ route('shifting.export') }}" class="mobile-menu-item">
            <div class="mobile-menu-icon">
                <i class="fas fa-file-excel text-success"></i>
            </div>
            <span class="ms-3">Export Excel</span>
        </a>
        <a href="{{ route('shifting.create') }}" class="mobile-menu-item">
            <div class="mobile-menu-icon">
                <i class="fas fa-plus-circle text-primary"></i>
            </div>
            <span class="ms-3">Ajukan Shift Baru</span>
        </a>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show fade-in" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show fade-in" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-6 col-md-3 mb-3">
                <div class="card fade-in">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total</h6>
                                <h3 class="mb-0">{{ $shiftings->count() }}</h3>
                            </div>
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card fade-in">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Pending</h6>
                                <h3 class="mb-0">{{ $shiftings->where('status', 'pending')->count() }}</h3>
                            </div>
                            <div class="card-icon bg-warning text-white">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card fade-in">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Disetujui</h6>
                                <h3 class="mb-0">{{ $shiftings->where('status', 'approved')->count() }}</h3>
                            </div>
                            <div class="card-icon bg-success text-white">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card fade-in">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Ditolak</h6>
                                <h3 class="mb-0">{{ $shiftings->where('status', 'rejected')->count() }}</h3>
                            </div>
                            <div class="card-icon bg-danger text-white">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="table-container fade-in">
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
                <!-- Table Header with Actions -->
                <div class="table-header">
                    <h5 class="table-title">
                        <i class="fas fa-list me-2"></i>Daftar Pengajuan
                    </h5>
                    <div>
                        <a href="{{ route('shifting.export') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel me-2"></i>Export Excel
                        </a>
                        <a href="{{ route('shifting.create') }}" class="btn btn-primary btn-sm ms-2">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Baru
                        </a>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th class="d-none d-md-table-cell">Divisi/Jabatan</th>
                                <th>Shift Asli</th>
                                <th>Shift Tujuan</th>
                                <th class="d-none d-sm-table-cell">Pengganti</th>
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
                                        <small class="d-block text-muted d-md-none">
                                            {{ $shift->divisi_jabatan }}
                                        </small>
                                    </td>
                                    <td class="d-none d-md-table-cell">{{ $shift->divisi_jabatan }}</td>
                                    <td>
                                        <div class="date-badge">
                                            {{ \Carbon\Carbon::parse($shift->tanggal_shift_asli)->format('d/m/Y') }}
                                        </div>
                                        <div class="time-badge">
                                            {{ \Carbon\Carbon::parse($shift->jam_shift_asli)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-badge">
                                            {{ \Carbon\Carbon::parse($shift->tanggal_shift_tujuan)->format('d/m/Y') }}
                                        </div>
                                        <div class="time-badge">
                                            {{ \Carbon\Carbon::parse($shift->jam_shift_tujuan)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        @if ($shift->sudah_pengganti == 'ya')
                                            <span class="badge bg-success">Ya</span>
                                            @if ($shift->nama_karyawan_pengganti)
                                                <small class="d-block mt-1">{{ $shift->nama_karyawan_pengganti }}</small>
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
                                        <small>{{ \Carbon\Carbon::parse($shift->created_at)->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <button type="button" class="action-btn btn-view" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $shift->id }}">
                                            <i class="fas fa-eye"></i>
                                            <span class="d-none d-md-inline">Detail</span>
                                        </button>

                                        <!-- Modal Detail -->
                                        <div class="modal fade" id="detailModal{{ $shift->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            Detail Pengajuan
                                                        </h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <!-- Info Karyawan -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Nama Karyawan</label>
                                                                <p class="fw-bold">{{ $shift->nama_karyawan }}</p>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Divisi/Jabatan</label>
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
                                                                        <span class="text-primary">{{ \Carbon\Carbon::parse($shift->jam_shift_asli)->format('H:i') }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <!-- Shift Tujuan -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Shift Tujuan</label>
                                                                <div class="border rounded p-3 bg-light">
                                                                    <p class="mb-1">
                                                                        <strong>Tanggal:</strong>
                                                                        {{ \Carbon\Carbon::parse($shift->tanggal_shift_tujuan)->format('d F Y') }}
                                                                    </p>
                                                                    <p class="mb-0">
                                                                        <strong>Jam:</strong>
                                                                        <span class="text-primary">{{ \Carbon\Carbon::parse($shift->jam_shift_tujuan)->format('H:i') }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <!-- Alasan -->
                                                            <div class="col-12 mb-3">
                                                                <label class="form-label text-muted">Alasan Pengajuan</label>
                                                                <div class="border rounded p-3 bg-light">
                                                                    <p class="mb-0">{{ $shift->alasan }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Info Pengganti -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Sudah Ada Pengganti?</label>
                                                                <p class="fw-bold text-uppercase">{{ $shift->sudah_pengganti }}</p>
                                                            </div>

                                                            @if ($shift->sudah_pengganti == 'ya')
                                                                <!-- Nama Pengganti -->
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label text-muted">Nama Pengganti</label>
                                                                    <p class="fw-bold">{{ $shift->nama_karyawan_pengganti ?? '-' }}</p>
                                                                </div>

                                                                <!-- Shift Pengganti -->
                                                                @if ($shift->tanggal_shift_pengganti && $shift->jam_shift_pengganti)
                                                                    <div class="col-12 mb-3">
                                                                        <label class="form-label text-muted">Shift Pengganti</label>
                                                                        <div class="border rounded p-3 bg-light">
                                                                            <p class="mb-1">
                                                                                <strong>Tanggal:</strong>
                                                                                {{ \Carbon\Carbon::parse($shift->tanggal_shift_pengganti)->format('d F Y') }}
                                                                            </p>
                                                                            <p class="mb-0">
                                                                                <strong>Jam:</strong>
                                                                                <span class="text-primary">{{ \Carbon\Carbon::parse($shift->jam_shift_pengganti)->format('H:i') }}</span>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif

                                                            <!-- Status & Tanggal -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Status</label>
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
                                                                        <span class="badge bg-secondary">{{ $shift->status }}</span>
                                                                    @endif
                                                                </p>
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label text-muted">Tanggal Pengajuan</label>
                                                                <p class="fw-bold">
                                                                    {{ \Carbon\Carbon::parse($shift->created_at)->format('d F Y H:i:s') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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

                <!-- Mobile View for Pengganti Column -->
                <div class="d-block d-sm-none mt-3">
                    @foreach ($shiftings as $shift)
                        @if ($loop->first)
                            <h6 class="text-muted mb-2"><i class="fas fa-user-friends me-2"></i>Info Pengganti</h6>
                        @endif
                        <div class="card mb-2">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $shift->nama_karyawan }}</strong>
                                        @if ($shift->sudah_pengganti == 'ya')
                                            <span class="badge bg-success ms-2">Ya</span>
                                            @if ($shift->nama_karyawan_pengganti)
                                                <small class="d-block text-muted">{{ $shift->nama_karyawan_pengganti }}</small>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary ms-2">Belum</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($shiftings instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            {{ $shiftings->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                        </nav>
                    </div>
                @endif
            @endif
        </div>

        <!-- Footer Info -->
        <div class="text-center mt-4 text-muted">
            <p class="mb-2">
                <i class="fas fa-sync-alt me-2"></i>
                Data diperbarui secara real-time dari database
            </p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-dismiss alerts
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Smooth scroll for mobile menu
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation
            document.body.classList.add('fade-in');
            
            // Handle export button click
            document.querySelectorAll('a[href*="export"]').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (!confirm('Export data ke Excel?')) {
                        e.preventDefault();
                    }
                });
            });
            
            // Mobile menu toggle
            const mobileMenu = document.querySelector('.mobile-menu');
            if (mobileMenu) {
                mobileMenu.style.display = window.innerWidth <= 768 ? 'block' : 'none';
            }
            
            // Responsive table adjustments
            function adjustTable() {
                const tableCells = document.querySelectorAll('.table td, .table th');
                if (window.innerWidth <= 576) {
                    tableCells.forEach(cell => {
                        cell.style.padding = '6px 4px';
                        cell.style.fontSize = '0.8rem';
                    });
                }
            }
            
            // Initial adjustment
            adjustTable();
            
            // Adjust on resize
            window.addEventListener('resize', adjustTable);
        });
    </script>
</body>
</html>