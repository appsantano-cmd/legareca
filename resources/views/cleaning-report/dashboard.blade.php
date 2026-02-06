<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cleaning Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        .editable {
            cursor: pointer;
            border-bottom: 1px dashed #667eea;
        }

        .editable:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }

        .photo-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            border: 2px solid #dee2e6;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .photo-thumbnail:hover {
            transform: scale(1.1);
            border-color: #667eea;
        }

        .modal-photo {
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        /* Modal Export Styles */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 20px 25px;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-body {
            padding: 25px;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 15px 25px;
        }

        /* Success Notification Styles */
        .success-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
            z-index: 10000;
            display: none;
            animation: slideInRight 0.4s ease-out;
            min-width: 300px;
        }

        .success-notification.show {
            display: block;
        }

        .success-notification .notification-icon {
            font-size: 2rem;
            margin-right: 15px;
            animation: checkmark 0.5s ease-in-out;
        }

        .success-notification .notification-content {
            flex: 1;
        }

        .success-notification .notification-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .success-notification .notification-message {
            font-size: 0.9rem;
            opacity: 0.95;
        }

        .success-notification .btn-close-notification {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0;
            margin-left: 10px;
            opacity: 0.8;
        }

        .success-notification .btn-close-notification:hover {
            opacity: 1;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes checkmark {
            0% {
                transform: scale(0) rotate(0deg);
            }
            50% {
                transform: scale(1.2) rotate(180deg);
            }
            100% {
                transform: scale(1) rotate(360deg);
            }
        }

        /* Form styles in modal */
        .date-range-group {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .date-range-group .form-group {
            flex: 1;
        }

        .date-range-separator {
            margin-top: 25px;
            color: #6c757d;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Success Notification -->
    <div class="success-notification" id="successNotification">
        <div class="d-flex align-items-center">
            <div class="notification-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">Download Berhasil!</div>
                <div class="notification-message">File Excel telah berhasil didownload</div>
            </div>
            <button class="btn-close-notification" onclick="hideSuccessNotification()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Export Excel Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">
                        <i class="fas fa-file-export me-2"></i>Export Data ke Excel
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Pilih rentang tanggal untuk export data cleaning report
                    </p>
                    
                    <form id="exportForm">
                        <div class="date-range-group">
                            <div class="form-group">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1"></i>Tanggal Awal
                                </label>
                                <input type="date" class="form-control" id="export_start_date" name="start_date">
                            </div>
                            
                            <div class="date-range-separator">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-1"></i>Tanggal Akhir
                                </label>
                                <input type="date" class="form-control" id="export_end_date" name="end_date">
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 d-flex align-items-center" role="alert">
                            <i class="fas fa-lightbulb me-2"></i>
                            <small>Kosongkan tanggal untuk export semua data</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-export" onclick="processExport()">
                        <i class="fas fa-download me-1"></i>Download Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Foto Cleaning Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalPhoto" src="" alt="Foto" class="modal-photo">
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-broom me-2"></i>Dashboard Cleaning Report
            </a>
            <div class="navbar-nav ms-auto">
                <span class="nav-item nav-link">
                    <i class="fas fa-user me-1"></i> {{ Auth::user()->name ?? 'Admin' }}
                </span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0" style="color: #495057;">
                    <i class="fas fa-database me-2" style="color: #667eea;"></i>Data Cleaning Report
                </h2>
                <p class="text-muted mb-0">Kelola dan pantau semua data laporan cleaning</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                <button type="button" class="btn btn-export" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="fas fa-file-export me-2"></i>Export Excel
                </button>
                <a href="{{ route('cleaning-report.index') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Data
                </a>
            </div>
        </div>

        <div class="row mb-4" id="statsContainer">
            <!-- Stats akan diisi oleh JavaScript -->
        </div>

        <div class="filter-section">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari nama, departemen...">
                        <button class="btn btn-primary" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="filterStartDate">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="filterEndDate">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Filter</label>
                    <select class="form-select" id="filterStatus">
                        <option value="all">Semua Data</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" id="applyFilterBtn">
                            <i class="fas fa-filter me-1"></i> Terapkan Filter
                        </button>
                        <button class="btn btn-outline-secondary" id="resetFilterBtn">
                            <i class="fas fa-redo me-1"></i> Reset
                        </button>
                        <button class="btn btn-outline-success" id="refreshBtn">
                            <i class="fas fa-sync-alt me-1"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50">ID</th>
                                <th>Nama</th>
                                <th width="120">Tanggal</th>
                                <th>Departemen</th>
                                <th width="100">Foto</th>
                                <th width="180">Dibuat</th>
                                <th width="80" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted" id="paginationInfo">
                        Menampilkan 0 dari 0 data
                    </div>
                    <div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination" id="pagination">
                                <!-- Pagination akan diisi oleh JavaScript -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            showLoading();
            loadStats();
            loadData();
            hideLoading();

            // Event Listeners
            $('#searchBtn').click(function() {
                loadData();
            });

            $('#refreshBtn').click(function() {
                showLoading();
                loadStats();
                loadData();
                hideLoading();
            });

            $('#applyFilterBtn').click(function() {
                loadData();
            });

            $('#resetFilterBtn').click(function() {
                $('#searchInput').val('');
                $('#filterStartDate').val('');
                $('#filterEndDate').val('');
                $('#filterStatus').val('all');
                loadData();
            });

            $('#searchInput').keypress(function(e) {
                if (e.which === 13) {
                    loadData();
                }
            });

            // Inisialisasi modal
            const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
            window.photoModal = photoModal;

            const exportModal = new bootstrap.Modal(document.getElementById('exportModal'));
            window.exportModal = exportModal;
        });

        // Export Excel Function
        function processExport() {
            const startDate = $('#export_start_date').val();
            const endDate = $('#export_end_date').val();

            // Build URL with parameters
            let exportUrl = '{{ route('cleaning-report.data.export') }}';
            const params = new URLSearchParams();

            if (startDate) {
                params.append('start_date', startDate);
            }
            if (endDate) {
                params.append('end_date', endDate);
            }

            if (params.toString()) {
                exportUrl += '?' + params.toString();
            }

            // Close modal
            window.exportModal.hide();

            // Show loading
            showLoading();

            // Create hidden iframe for download
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = exportUrl;
            document.body.appendChild(iframe);

            // Show success notification after short delay
            setTimeout(function() {
                hideLoading();
                showSuccessNotification();
                
                // Remove iframe after download
                setTimeout(function() {
                    document.body.removeChild(iframe);
                }, 2000);
            }, 1500);

            // Reset form
            $('#exportForm')[0].reset();
        }

        // Success Notification Functions
        function showSuccessNotification() {
            const notification = $('#successNotification');
            notification.addClass('show');
            
            // Auto hide after 5 seconds
            setTimeout(function() {
                hideSuccessNotification();
            }, 5000);
        }

        function hideSuccessNotification() {
            $('#successNotification').removeClass('show');
        }

        // Loading functions
        function showLoading() {
            $('#loadingOverlay').fadeIn();
        }

        function hideLoading() {
            $('#loadingOverlay').fadeOut();
        }

        // Stats functions - Diubah hanya menampilkan total data saja
        function loadStats() {
            $.ajax({
                url: '{{ route('cleaning-report.data.stats') }}',
                type: 'GET',
                beforeSend: showLoading,
                complete: hideLoading,
                success: function(response) {
                    if (response.success) {
                        renderStats(response.stats);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading stats:', xhr.responseText);
                    alert('Gagal memuat statistik');
                }
            });
        }

        function renderStats(stats) {
            // Hanya menampilkan total data saja
            const statsHtml = `
                <div class="col-md-12 mb-3">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Total Data Cleaning Report</h6>
                                    <h2 class="fw-bold">${stats.total}</h2>
                                    <small class="opacity-75">${stats.completed} data selesai</small>
                                </div>
                                <i class="fas fa-database stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $('#statsContainer').html(statsHtml);
        }

        // Data functions
        function loadData(page = 1) {
            const search = $('#searchInput').val();
            const status = $('#filterStatus').val();
            const startDate = $('#filterStartDate').val();
            const endDate = $('#filterEndDate').val();

            showLoading();
            
            $.ajax({
                url: '{{ route('cleaning-report.data.get') }}',
                type: 'GET',
                data: {
                    page: page,
                    search: search,
                    status: status,
                    start_date: startDate,
                    end_date: endDate,
                    per_page: 10
                },
                success: function(response) {
                    if (response.success) {
                        renderTable(response.data);
                        renderPagination(response);
                    } else {
                        alert('Gagal memuat data: ' + response.message);
                    }
                    hideLoading();
                },
                error: function(xhr) {
                    console.error('Error loading data:', xhr.responseText);
                    alert('Gagal memuat data');
                    hideLoading();
                }
            });
        }

        // Date formatting functions
        function formatDateOnly(dateString) {
            if (!dateString) return '-';
            
            try {
                // Cek jika formatnya YYYY-MM-DD
                if (dateString.match(/^\d{4}-\d{2}-\d{2}$/)) {
                    const [year, month, day] = dateString.split('-');
                    return `${day}/${month}/${year}`;
                }
                
                // Parse date dari string
                const date = new Date(dateString);
                if (isNaN(date.getTime())) return dateString;
                
                const day = date.getDate().toString().padStart(2, '0');
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const year = date.getFullYear();
                
                return `${day}/${month}/${year}`;
            } catch (e) {
                console.error('Error formatting date:', e);
                return dateString;
            }
        }

        function formatDateTime(dateTimeString) {
            if (!dateTimeString) return '-';
            
            try {
                const date = new Date(dateTimeString);
                if (isNaN(date.getTime())) return dateTimeString;
                
                const day = date.getDate().toString().padStart(2, '0');
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const year = date.getFullYear();
                const hours = date.getHours().toString().padStart(2, '0');
                const minutes = date.getMinutes().toString().padStart(2, '0');
                const seconds = date.getSeconds().toString().padStart(2, '0');
                
                return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
            } catch (e) {
                console.error('Error formatting datetime:', e);
                return dateTimeString;
            }
        }

        function renderTable(data) {
            const tbody = $('#tableBody');
            tbody.empty();

            if (data.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data ditemukan</p>
                        </td>
                    </tr>
                `);
                return;
            }

            data.forEach(function(item) {
                // Hanya tampilkan data dengan status completed atau semua data jika filter all
                const status = $('#filterStatus').val();
                if (status !== 'all' && item.status !== 'completed') {
                    return; // Skip data yang tidak completed
                }

                // Format dates
                const tanggal = formatDateOnly(item.tanggal);
                const createdAt = formatDateTime(item.created_at);

                // Photo handling
                let photoHtml = '<span class="text-muted">Tidak ada</span>';
                if (item.foto_path) {
                    const photoUrl = item.foto_path.startsWith('http') ? item.foto_path : `/${item.foto_path}`;
                    photoHtml = `
                        <img src="${photoUrl}" 
                             alt="Foto" 
                             class="photo-thumbnail" 
                             onclick="showPhoto('${photoUrl}')"
                             title="Klik untuk melihat">
                    `;
                }

                const row = `
                    <tr data-id="${item.id}">
                        <td class="fw-bold">#${item.id}</td>
                        <td>${item.nama}</td>
                        <td>${tanggal}</td>
                        <td>${item.departemen}</td>
                        <td>${photoHtml}</td>
                        <td>${createdAt}</td>
                        <td class="text-center">
                            <div class="action-buttons justify-content-center">
                                <button class="btn btn-action btn-danger" onclick="deleteData(${item.id})" title="Hapus">
                                    <i class="fas fa-trash fa-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;

                tbody.append(row);
            });
        }

        // Photo functions
        function showPhoto(photoUrl) {
            $('#modalPhoto').attr('src', photoUrl);
            window.photoModal.show();
        }

        function deleteData(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                showLoading();
                $.ajax({
                    url: '{{ route('cleaning-report.data.delete') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Data berhasil dihapus');
                            loadData();
                            loadStats();
                        } else {
                            alert('Gagal menghapus data: ' + response.message);
                        }
                        hideLoading();
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                        hideLoading();
                    }
                });
            }
        }

        // Pagination functions
        function renderPagination(response) {
            const pagination = $('#pagination');
            const info = $('#paginationInfo');

            pagination.empty();

            if (response.total === 0) {
                info.text('Menampilkan 0 dari 0 data');
                return;
            }

            const start = ((response.current_page - 1) * response.per_page) + 1;
            const end = Math.min(response.current_page * response.per_page, response.total);

            info.text(`Menampilkan ${start} - ${end} dari ${response.total} data`);

            // Previous button
            if (response.current_page > 1) {
                pagination.append(`
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="loadData(${response.current_page - 1})">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                `);
            }

            // Page numbers
            const maxPages = 5;
            let startPage = Math.max(1, response.current_page - Math.floor(maxPages / 2));
            let endPage = Math.min(response.last_page, startPage + maxPages - 1);

            if (endPage - startPage + 1 < maxPages) {
                startPage = Math.max(1, endPage - maxPages + 1);
            }

            for (let i = startPage; i <= endPage; i++) {
                const active = i === response.current_page ? 'active' : '';
                pagination.append(`
                    <li class="page-item ${active}">
                        <a class="page-link" href="#" onclick="loadData(${i})">${i}</a>
                    </li>
                `);
            }

            // Next button
            if (response.current_page < response.last_page) {
                pagination.append(`
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="loadData(${response.current_page + 1})">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                `);
            }
        }

        // Auto refresh every 30 seconds
        setInterval(function() {
            if (!document.hidden) {
                loadStats();
            }
        }, 30000);

        // Listen for visibility change
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                loadStats();
                loadData();
            }
        });
    </script>
</body>
</html>