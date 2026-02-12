{{-- resources/views/admin/venue-booking-simple.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Booking Venue</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            padding: 0;
            margin: 0;
        }

        .header {
            background: linear-gradient(135deg, #4ECDC4 0%, #2C7A7B 100%);
            padding: 15px 20px;
            color: white;
            margin-bottom: 20px;
        }

        .header-title {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
        }

        .container-custom {
            padding: 0 20px 20px 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            border: 1px solid #e9ecef;
            padding: 20px;
            margin-bottom: 20px;
        }

        .badge-pending {
            background-color: #fff3e0;
            color: #e67e22;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-confirmed {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-cancelled {
            background-color: #ffebee;
            color: #c62828;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .table th {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            color: #495057;
            font-size: 13px;
            padding: 12px 8px;
        }

        .table td {
            padding: 12px 8px;
            vertical-align: middle;
            font-size: 14px;
        }

        .booking-code {
            font-family: monospace;
            font-weight: 600;
            color: #2C7A7B;
        }

        .filter-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }

        .btn-primary {
            background: #4ECDC4;
            border: none;
        }

        .btn-primary:hover {
            background: #2C7A7B;
        }

        .btn-outline-light {
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: white;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
        }

        .pagination .page-link {
            color: #4ECDC4;
        }

        .pagination .active .page-link {
            background: #4ECDC4;
            border-color: #4ECDC4;
            color: white;
        }

        .venue-badge {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .event-badge {
            background-color: #fff8e1;
            color: #b76e00;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .duration-badge {
            background-color: #e0f2fe;
            color: #0369a1;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <!-- Header dengan Button Kembali -->
    <div class="header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <!-- BUTTON KEMBALI KE DASHBOARD UTAMA -->
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
                <h1 class="header-title mb-0">
                    <i class="fas fa-building me-2"></i> Venue - Data Booking
                </h1>
            </div>
            <span class="badge bg-white text-dark px-3 py-2">
                <i class="fas fa-calendar me-1"></i> {{ now()->format('d/m/Y') }}
            </span>
        </div>
    </div>

    <div class="container-custom">
        <!-- 3 Statistik Utama -->
        <div class="row mb-4" id="statsContainer">
            <div class="col-md-4">
                <div class="card text-center py-3">
                    <h5 class="text-muted mb-2">Total Booking</h5>
                    <h2 class="fw-bold" id="totalBooking">0</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center py-3">
                    <h5 class="text-muted mb-2">Pending</h5>
                    <h2 class="fw-bold text-warning" id="totalPending">0</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center py-3">
                    <h5 class="text-muted mb-2">Confirmed</h5>
                    <h2 class="fw-bold text-success" id="totalConfirmed">0</h2>
                </div>
            </div>
        </div>

        <!-- Filter Sederhana -->
        <div class="filter-box">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pencarian</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Nama / Venue / Email...">
                        <button class="btn btn-primary" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select class="form-select" id="filterStatus">
                        <option value="all">Semua</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Venue</label>
                    <select class="form-select" id="filterVenue">
                        <option value="all">Semua Venue</option>
                        <option value="Gedung A">Gedung A</option>
                        <option value="Gedung B">Gedung B</option>
                        <option value="Auditorium">Auditorium</option>
                        <option value="Ruang Meeting">Ruang Meeting</option>
                        <option value="Outdoor">Outdoor</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Dari Tanggal</label>
                    <input type="date" class="form-control" id="filterStartDate">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Sampai</label>
                    <input type="date" class="form-control" id="filterEndDate">
                </div>
                <div class="col-12 mt-2">
                    <button class="btn btn-primary me-2" id="applyFilterBtn">
                        <i class="fas fa-filter me-1"></i> Terapkan
                    </button>
                    <button class="btn btn-outline-secondary" id="resetFilterBtn">
                        <i class="fas fa-redo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabel Data Booking Venue -->
        <div class="card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-3">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2 text-primary"></i> Daftar Booking Venue
                    </h5>
                    <!-- Breadcrumb Navigation -->
                    <nav aria-label="breadcrumb" class="d-none d-md-block">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none">
                                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <i class="fas fa-building me-1"></i>Venue Booking
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <!-- Tombol Kembali Mobile -->
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary d-md-none">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-primary" onclick="exportData()">
                        <i class="fas fa-file-export me-1"></i> Export
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemesan</th>
                            <th>Kontak</th>
                            <th>Venue</th>
                            <th>Acara</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Durasi</th>
                            <th>Peserta</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="bookingsTableBody">
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="fas fa-circle-notch fa-spin fa-2x text-muted mb-2"></i>
                                <p class="text-muted">Memuat data...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small" id="paginationInfo"></div>
                <nav>
                    <ul class="pagination pagination-sm" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let currentPage = 1;

        $(document).ready(function() {
            loadStats();
            loadBookingsData();

            // Event listeners
            $('#searchBtn, #applyFilterBtn').click(function() {
                loadBookingsData(1);
            });

            $('#resetFilterBtn').click(function() {
                $('#searchInput').val('');
                $('#filterStatus').val('all');
                $('#filterVenue').val('all');
                $('#filterStartDate').val('');
                $('#filterEndDate').val('');
                loadBookingsData(1);
            });

            $('#searchInput').keypress(function(e) {
                if (e.which === 13) loadBookingsData(1);
            });
        });

        // Load statistik
        function loadStats() {
            $.ajax({
                url: '{{ route("venue.stats") }}',
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#totalBooking').text(response.data.total || 0);
                        $('#totalPending').text(response.data.pending || 0);
                        $('#totalConfirmed').text(response.data.confirmed || 0);
                    }
                }
            });
        }

        // Load data bookings
        function loadBookingsData(page = 1) {
            currentPage = page;

            const search = $('#searchInput').val();
            const status = $('#filterStatus').val();
            const venue = $('#filterVenue').val();
            const startDate = $('#filterStartDate').val();
            const endDate = $('#filterEndDate').val();

            $('#bookingsTableBody').html(`
                <tr>
                    <td colspan="10" class="text-center py-4">
                        <i class="fas fa-circle-notch fa-spin fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Memuat data...</p>
                    </td>
                </tr>
            `);

            $.ajax({
                url: '{{ route("venue.bookings") }}',
                type: 'GET',
                data: {
                    page: page,
                    search: search,
                    status: status === 'all' ? null : status,
                    venue: venue === 'all' ? null : venue,
                    start_date: startDate,
                    end_date: endDate,
                    per_page: 10
                },
                success: function(response) {
                    if (response.success) {
                        renderTable(response.data);
                        renderPagination(response);
                    }
                },
                error: function() {
                    $('#bookingsTableBody').html(`
                        <tr>
                            <td colspan="10" class="text-center py-4 text-danger">
                                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                <p>Gagal memuat data</p>
                            </td>
                        </tr>
                    `);
                }
            });
        }

        // Render tabel
        function renderTable(data) {
            const tbody = $('#bookingsTableBody');
            tbody.empty();

            if (!data || data.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data booking</p>
                        </td>
                    </tr>
                `);
                return;
            }

            data.forEach((item, index) => {
                let statusClass = {
                    'pending': 'badge-pending',
                    'confirmed': 'badge-confirmed',
                    'cancelled': 'badge-cancelled'
                } [item.status] || 'badge-pending';

                let statusText = {
                    'pending': 'Pending',
                    'confirmed': 'Confirmed',
                    'cancelled': 'Cancelled'
                } [item.status] || item.status;

                // Format durasi
                let durasiText = '';
                if (item.durasi_type === 'jam' && item.durasi_jam) {
                    durasiText = `${item.durasi_jam} jam`;
                    if (item.jam_mulai && item.jam_selesai) {
                        durasiText = `${formatTime(item.jam_mulai)} - ${formatTime(item.jam_selesai)}`;
                    }
                } else if (item.durasi_type === 'hari' && item.durasi_hari) {
                    durasiText = `${item.durasi_hari} hari`;
                    if (item.tanggal_mulai && item.tanggal_selesai) {
                        durasiText = `${formatShortDate(item.tanggal_mulai)} - ${formatShortDate(item.tanggal_selesai)}`;
                    }
                } else if (item.durasi_type === 'minggu' && item.durasi_minggu) {
                    durasiText = `${item.durasi_minggu} minggu`;
                } else if (item.durasi_type === 'bulan' && item.durasi_bulan) {
                    durasiText = `${item.durasi_bulan} bulan`;
                }

                const row = `
                    <tr>
                        <td>${((currentPage - 1) * 10) + index + 1}</td>
                        <td>
                            <span class="fw-semibold">${escapeHtml(item.nama_pemesan)}</span>
                            <br><small class="text-muted">${escapeHtml(item.email)}</small>
                        </td>
                        <td><small>${escapeHtml(item.nomer_wa)}</small></td>
                        <td><span class="venue-badge">${escapeHtml(item.venue)}</span></td>
                        <td><span class="event-badge">${escapeHtml(item.jenis_acara)}</span></td>
                        <td>${formatDate(item.tanggal_acara)}</td>
                        <td>${formatTime(item.jam_acara)}</td>
                        <td><span class="duration-badge">${durasiText}</span></td>
                        <td><span class="badge bg-light text-dark">${item.perkiraan_peserta} org</span></td>
                        <td><span class="${statusClass}">${statusText}</span></td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        // Pagination
        function renderPagination(response) {
            const pagination = $('#pagination');
            const info = $('#paginationInfo');

            pagination.empty();

            if (response.total === 0) {
                info.text('0 data');
                return;
            }

            const start = ((response.current_page - 1) * response.per_page) + 1;
            const end = Math.min(response.current_page * response.per_page, response.total);
            info.text(`${start}-${end} dari ${response.total} data`);

            // Previous
            if (response.current_page > 1) {
                pagination.append(`<li class="page-item"><a class="page-link" href="#" onclick="loadBookingsData(${response.current_page - 1})">&laquo;</a></li>`);
            }

            // Page numbers
            for (let i = 1; i <= response.last_page; i++) {
                if (i === response.current_page) {
                    pagination.append(`<li class="page-item active"><span class="page-link">${i}</span></li>`);
                } else if (i <= 3 || i > response.last_page - 2 || Math.abs(i - response.current_page) <= 1) {
                    pagination.append(`<li class="page-item"><a class="page-link" href="#" onclick="loadBookingsData(${i})">${i}</a></li>`);
                } else if (i === 4 && response.current_page > 3) {
                    pagination.append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
                }
            }

            // Next
            if (response.current_page < response.last_page) {
                pagination.append(`<li class="page-item"><a class="page-link" href="#" onclick="loadBookingsData(${response.current_page + 1})">&raquo;</a></li>`);
            }
        }

        // Helper functions
        function escapeHtml(text) {
            if (!text) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            } catch {
                return dateString;
            }
        }

        function formatShortDate(dateString) {
            if (!dateString) return '-';
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short'
                });
            } catch {
                return dateString;
            }
        }

        function formatTime(timeString) {
            if (!timeString) return '-';
            return timeString.substring(0, 5);
        }

        function exportData() {
            const search = $('#searchInput').val();
            const status = $('#filterStatus').val();
            const venue = $('#filterVenue').val();
            const startDate = $('#filterStartDate').val();
            const endDate = $('#filterEndDate').val();

            let params = new URLSearchParams();
            if (search) params.append('search', search);
            if (status && status !== 'all') params.append('status', status);
            if (venue && venue !== 'all') params.append('venue', venue);
            if (startDate) params.append('start_date', startDate);
            if (endDate) params.append('end_date', endDate);

            window.open('{{ route("venue.export") }}?' + params.toString(), '_blank');
        }

        // Auto refresh setiap 30 detik
        setInterval(function() {
            if (!document.hidden) {
                loadStats();
                loadBookingsData(currentPage);
            }
        }, 30000);
    </script>
</body>

</html>