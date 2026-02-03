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

        .badge-pending {
            background-color: #ffc107;
            color: #212529;
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
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-broom me-2"></i>Dashboard Cleaning Report
            </a>
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
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
                <a href="{{ route('cleaning-report.data.export') }}" class="btn btn-export me-2">
                    <i class="fas fa-file-export me-2"></i>Export Excel
                </a>
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
                <div class="col-md-6">
                    <label class="form-label">Cari</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInput"
                            placeholder="Cari nama, departemen...">
                        <button class="btn btn-primary" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="filterStatus">
                        <option value="all">Semua Status</option>
                        <option value="completed">Selesai</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-outline-secondary w-100" id="refreshBtn">
                        <i class="fas fa-sync-alt me-1"></i> Refresh
                    </button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Departemen</th>
                                <th>Foto</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
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

    <script>
        $(document).ready(function() {
            loadStats();
            loadData();

            $('#searchBtn').click(function() {
                loadData();
            });

            $('#refreshBtn').click(function() {
                loadStats();
                loadData();
            });

            $('#filterStatus').change(function() {
                loadData();
            });

            $('#searchInput').keypress(function(e) {
                if (e.which === 13) {
                    loadData();
                }
            });
        });

        function loadStats() {
            $.ajax({
                url: '{{ route('cleaning-report.data.stats') }}',
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        renderStats(response.stats);
                    }
                }
            });
        }

        function renderStats(stats) {
            const statsHtml = `
                <div class="col-md-3">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Total Data</h6>
                                    <h2 class="fw-bold">${stats.total}</h2>
                                </div>
                                <i class="fas fa-database stat-icon"></i>
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
                                    <h2 class="fw-bold">${stats.completed}</h2>
                                </div>
                                <i class="fas fa-check-circle stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Pending</h6>
                                    <h2 class="fw-bold">${stats.pending}</h2>
                                </div>
                                <i class="fas fa-clock stat-icon"></i>
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
                                    <h2 class="fw-bold">${stats.cancelled}</h2>
                                </div>
                                <i class="fas fa-times-circle stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $('#statsContainer').html(statsHtml);
        }

        function loadData(page = 1) {
            const search = $('#searchInput').val();
            const status = $('#filterStatus').val();

            $.ajax({
                url: '{{ route('cleaning-report.data.get') }}',
                type: 'GET',
                data: {
                    page: page,
                    search: search,
                    status: status,
                    per_page: 10
                },
                success: function(response) {
                    if (response.success) {
                        renderTable(response.data);
                        renderPagination(response);
                    }
                }
            });
        }

        function renderTable(data) {
            const tbody = $('#tableBody');
            tbody.empty();

            if (data.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data ditemukan</p>
                        </td>
                    </tr>
                `);
                return;
            }

            data.forEach(function(item) {
                const statusClass = item.status === 'completed' ? 'badge-completed' :
                    item.status === 'pending' ? 'badge-pending' : 'badge-cancelled';
                const statusText = item.status === 'completed' ? 'Selesai' :
                    item.status === 'pending' ? 'Pending' : 'Dibatalkan';

                const row = `
                    <tr>
                        <td class="fw-bold">#${item.id}</td>
                        <td class="editable" onclick="editField(${item.id}, 'nama')">${item.nama}</td>
                        <td>${item.tanggal}</td>
                        <td class="editable" onclick="editField(${item.id}, 'departemen')">${item.departemen}</td>
                        <td>
                            ${item.foto_path ? 
                                `<a href="/${item.foto_path}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>` : 
                                '<span class="text-muted">Tidak ada</span>'}
                        </td>
                        <td>
                            <span class="badge ${statusClass} editable" onclick="editField(${item.id}, 'status')">
                                ${statusText}
                            </span>
                        </td>
                        <td>${new Date(item.created_at).toLocaleDateString('id-ID')}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="deleteData(${item.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                tbody.append(row);
            });
        }

        function editField(id, field) {
            const currentValue = $(`td:contains(${id})`).next().text().trim();
            const newValue = prompt(`Edit ${field}:`, currentValue);

            if (newValue !== null && newValue !== currentValue) {
                $.ajax({
                    url: '{{ route('cleaning-report.data.update') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        field: field,
                        value: newValue
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            loadData();
                        }
                    }
                });
            }
        }

        function deleteData(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: '{{ route('cleaning-report.data.delete') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            loadData();
                            loadStats();
                        }
                    }
                });
            }
        }

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
            for (let i = 1; i <= response.last_page; i++) {
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
    </script>
</body>

</html>
