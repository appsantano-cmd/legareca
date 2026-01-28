<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Screening - Le Gareca Space</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .stat-card {
            border-radius: 12px;
            overflow: hidden;
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .badge-completed {
            background-color: #28a745;
            color: white;
        }

        .badge-cancelled {
            background-color: #dc3545;
            color: white;
        }

        .table th {
            background-color: #f1f3f9;
            border-top: none;
            font-weight: 600;
            color: #495057;
        }

        .table tbody tr {
            transition: background-color 0.2s;
        }

        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }

        .filter-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 3px;
            border: none;
            color: #667eea;
        }

        .pagination .page-item.active .page-link {
            background-color: #667eea;
            border-color: #667eea;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
        }

        .btn-export {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            border-radius: 8px;
        }

        .btn-danger {
            border-radius: 8px;
        }

        .action-buttons .btn {
            padding: 5px 10px;
            margin: 2px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
        </div>
    </nav>
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0" style="color: #495057;">
                    <i class="fas fa-database me-2" style="color: #667eea;"></i>Data Screening
                </h2>
                <p class="text-muted mb-0">Kelola dan pantau semua data screening pasien</p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-export">
                    <i class="fas fa-file-export me-2"></i>Dashboard
                </a>
                <a href="{{ route('screening.export') }}" class="btn btn-export">
                    <i class="fas fa-file-export me-2"></i>Export CSV
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2">Total Screening</h6>
                                <h2 class="fw-bold">{{ $stats['total'] }}</h2>
                            </div>
                            <i class="fas fa-clipboard-list stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2">Selesai</h6>
                                <h2 class="fw-bold">{{ $stats['completed'] }}</h2>
                            </div>
                            <i class="fas fa-check-circle stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2">Dibatalkan</h6>
                                <h2 class="fw-bold">{{ $stats['cancelled'] }}</h2>
                            </div>
                            <i class="fas fa-times-circle stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2">Hari Ini</h6>
                                <h2 class="fw-bold">{{ $stats['today'] }}</h2>
                            </div>
                            <i class="fas fa-calendar-day stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="{{ route('screening.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Cari</label>
                        <input type="text" class="form-control" name="search"
                            placeholder="Owner, Phone, atau Nama Pet..." value="{{ $search }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Dibatalkan
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                @if ($search || $status || $startDate || $endDate)
                    <div class="mt-3">
                        <a href="{{ route('screening.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Reset Filter
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Data Table -->
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Tanggal</th>
                                <th>Owner</th>
                                <th>Phone</th>
                                <th width="8%">Jumlah Pet</th>
                                <th width="10%">Status</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($screenings as $screening)
                                <tr>
                                    <td class="fw-bold">#{{ $screening->id }}</td>
                                    <td>
                                        {{ $screening->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y') }}<br>
                                        <small
                                            class="text-muted">{{ $screening->created_at->setTimezone('Asia/Jakarta')->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $screening->owner_name }}</strong>
                                    </td>
                                    <td>
                                        <i class="fas fa-phone me-1 text-muted"></i>
                                        {{ $screening->phone_number }}
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $screening->pet_count }} Pet</span>
                                    </td>
                                    <td>
                                        @if ($screening->status == 'completed')
                                            <span class="badge badge-completed">
                                                <i class="fas fa-check me-1"></i>Selesai
                                            </span>
                                        @else
                                            <span class="badge badge-cancelled">
                                                <i class="fas fa-times me-1"></i>Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="action-buttons">
                                        <a href="{{ route('screening.show', $screening->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                        <form action="{{ route('screening.destroy', $screening->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Hapus data screening ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                            Tidak ada data screening ditemukan
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($screenings->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Menampilkan {{ $screenings->firstItem() }} - {{ $screenings->lastItem() }} dari
                            {{ $screenings->total() }} data
                        </div>
                        <div>
                            {{ $screenings->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-muted mt-4 mb-4">
            <small>
                <i class="fas fa-shield-alt me-1"></i>
                Le Gareca Space &copy; {{ date('Y') }} |
                <span id="datetime">{{ now()->setTimezone('Asia/Jakarta')->format('d F Y H:i:s') }}</span>
            </small>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // Initialize DataTable (optional - uncomment if you want to use DataTables instead of Laravel pagination)
        /*
        $(document).ready(function() {
            $('.table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                },
                pageLength: 25,
                order: [[0, 'desc']]
            });
        });
        */

        // Update datetime every second
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false,
                timeZone: 'Asia/Jakarta'
            };

            const formatter = new Intl.DateTimeFormat('id-ID', options);
            document.getElementById('datetime').textContent = formatter.format(now);
        }

        // Update time every second
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Initial call

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);

        // Confirm before delete
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
</body>

</html>
