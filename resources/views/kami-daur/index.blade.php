{{-- resources/views/kami-daur/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk & Material - Kami Daur</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
            background: white;
            border-radius: 8px;
        }

        .empty-state i {
            color: #dee2e6;
            font-size: 48px;
            margin-bottom: 20px;
        }

        .btn-group .btn {
            padding: 0.4rem 0.7rem;
        }

        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 500;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 25px;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0 !important;
        }

        .table {
            margin-bottom: 0;
        }

        .table td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            color: #495057;
            font-weight: 600;
            padding: 1rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            transition: all 0.2s;
        }

        .table tbody tr:hover {
            background-color: rgba(40, 167, 69, 0.02);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #218838);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            border: none;
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #138496, #117a8b);
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff, #0069d9);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0069d9, #0056b3);
        }

        .pagination {
            margin-bottom: 0;
        }

        .product-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
        }

        .product-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .product-preview-more {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .feature-tag {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            display: inline-block;
            margin-right: 4px;
            margin-bottom: 4px;
            border: 1px solid #c8e6c9;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 10px;
        }

        .nav-tabs {
            border-bottom: none;
            gap: 10px;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
            border: none;
            transition: all 0.2s;
        }

        .nav-tabs .nav-link:hover {
            background-color: #e9ecef;
            color: #28a745;
        }

        .nav-tabs .nav-link.active {
            color: white;
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
        }

        .badge-active {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 500;
        }

        .badge-inactive {
            background: #6c757d;
            color: white;
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 500;
        }

        .id-badge {
            background: #e9ecef;
            color: #495057;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .material-badge {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-right: 5px;
            margin-bottom: 5px;
            transition: all 0.2s;
        }

        .material-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(23, 162, 184, 0.3);
        }

        .btn-action {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .product-stats {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .stat-badge {
            background: white;
            border: 1px solid #dee2e6;
            color: #495057;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .stat-badge i {
            color: #28a745;
        }

        .date-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .date-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #6c757d;
            font-size: 0.8rem;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 4px solid #28a745;
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4 align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success bg-gradient rounded-circle p-3"
                        style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-box fa-2x text-white"></i>
                    </div>
                    <div>
                        <h1 class="h2 fw-bold mb-1" style="color: #2c3e50;">
                            Manajemen Produk & Material
                        </h1>
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Kelola produk unggulan dan bahan/material daur ulang untuk halaman Kami Daur
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="d-flex justify-content-lg-end gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                    </a>
                    <a href="{{ route('kami-daur.create') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus-circle me-2"></i> Tambah Konfigurasi Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-2x me-3"></i>
                    <div>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Card -->
        <div class="card">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <div class="d-flex justify-content-lg-end gap-2">
                            <span class="text-muted">
                                <i class="fas fa-sync-alt me-1"></i> Diperbarui: {{ now()->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="tab-content" id="configTabsContent">
                    <!-- Tab Semua Konfigurasi -->
                    <div class="tab-pane fade show active" id="all" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th width="80">ID</th>
                                        <th>Produk Unggulan</th>
                                        <th>Bahan & Material</th>
                                        <th width="140">Dibuat</th>
                                        <th width="140">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kamiDaurs as $config)
                                        <tr>
                                            <td>
                                                <span class="id-badge">
                                                    <i class="fas fa-hashtag me-1"></i>{{ $config->id }}
                                                </span>
                                            </td>
                                            <td>
                                                @if (isset($config->products) && count($config->products) > 0)
                                                    <div class="d-flex align-items-start gap-2 mb-2">
                                                        @foreach (array_slice($config->products, 0, 3) as $product)
                                                            <div class="position-relative">
                                                                <img src="{{ $product['image'] ?? 'https://via.placeholder.com/60x60?text=No+Image' }}"
                                                                    class="product-preview"
                                                                    alt="{{ $product['name'] ?? 'Produk' }}"
                                                                    title="{{ $product['name'] ?? 'Produk' }}">
                                                                @if (($product['is_new'] ?? false) || ($product['is_bestseller'] ?? false))
                                                                    <span
                                                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                                                        style="font-size: 0.6rem;">
                                                                        @if ($product['is_new'] ?? false)
                                                                            NEW
                                                                        @endif
                                                                        @if (($product['is_new'] ?? false) && ($product['is_bestseller'] ?? false))
                                                                            &
                                                                        @endif
                                                                        @if ($product['is_bestseller'] ?? false)
                                                                            HOT
                                                                        @endif
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                        @if (count($config->products) > 3)
                                                            <div class="product-preview-more">
                                                                +{{ count($config->products) - 3 }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="product-stats">
                                                        <span class="stat-badge">
                                                            <i class="fas fa-cube"></i>
                                                            {{ count($config->products) }} Produk
                                                        </span>
                                                        @php
                                                            $newCount = collect($config->products)
                                                                ->where('is_new', true)
                                                                ->count();
                                                            $bestsellerCount = collect($config->products)
                                                                ->where('is_bestseller', true)
                                                                ->count();
                                                        @endphp
                                                        @if ($newCount > 0)
                                                            <span class="stat-badge"
                                                                style="background: #fff5f5; border-color: #feb2b2;">
                                                                <i class="fas fa-star text-danger"></i>
                                                                {{ $newCount }} New
                                                            </span>
                                                        @endif
                                                        @if ($bestsellerCount > 0)
                                                            <span class="stat-badge"
                                                                style="background: #fff3e0; border-color: #ffb74d;">
                                                                <i class="fas fa-crown text-warning"></i>
                                                                {{ $bestsellerCount }} Bestseller
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-2">
                                                        @foreach (array_slice($config->products, 0, 2) as $product)
                                                            @if (!empty($product['features']))
                                                                @foreach (array_slice($product['features'], 0, 2) as $feature)
                                                                    <span class="feature-tag">
                                                                        <i class="fas fa-check-circle me-1"
                                                                            style="font-size: 0.7rem;"></i>
                                                                        {{ Str::limit($feature, 20) }}
                                                                    </span>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="fas fa-box-open me-1"></i> Tidak ada produk
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($config->materials) && count($config->materials) > 0)
                                                    <div class="d-flex flex-wrap gap-1" style="max-width: 250px;">
                                                        @foreach ($config->materials as $material)
                                                            <span class="material-badge">
                                                                <i class="fas fa-cube me-1"></i>
                                                                {{ Str::limit($material['name'] ?? '', 15) }}
                                                                @if (!empty($material['info']))
                                                                    <span class="ms-1"
                                                                        title="{{ $material['info'] }}">
                                                                        <i class="fas fa-info-circle"></i>
                                                                    </span>
                                                                @endif
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                    <small class="text-muted mt-2 d-block">
                                                        <i class="fas fa-recycle me-1"></i>
                                                        Total {{ count($config->materials) }} material
                                                    </small>
                                                @else
                                                    <span class="text-muted">
                                                        <i class="fas fa-cubes me-1"></i> Tidak ada material
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="date-info">
                                                    <span class="date-item">
                                                        <i class="fas fa-calendar-alt text-primary"></i>
                                                        {{ $config->created_at->format('d/m/Y') }}
                                                    </span>
                                                    <span class="date-item">
                                                        <i class="fas fa-clock text-info"></i>
                                                        {{ $config->created_at->format('H:i') }} WIB
                                                    </span>
                                                    @if ($config->created_at != $config->updated_at)
                                                        <span class="date-item text-muted" style="font-size: 0.7rem;">
                                                            <i class="fas fa-edit"></i>
                                                            Diupdate {{ $config->updated_at->diffForHumans() }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('kami-daur.show', $config) }}"
                                                        class="btn btn-sm btn-info text-white btn-action"
                                                        title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('kami-daur.edit', $config) }}"
                                                        class="btn btn-sm btn-primary btn-action" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger btn-action"
                                                        title="Hapus"
                                                        onclick="confirmDelete({{ $config->id }}, '{{ $config->created_at->format('d/m/Y') }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                <div class="mt-2">
                                                    <a href="{{ route('kami-daur.home') }}?preview={{ $config->id }}"
                                                        class="text-decoration-none small" target="_blank"
                                                        title="Preview Halaman">
                                                        <i class="fas fa-external-link-alt me-1"></i> Preview
                                                    </a>
                                                </div>
                                                <form id="delete-form-{{ $config->id }}"
                                                    action="{{ route('kami-daur.destroy', $config) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="empty-state">
                                                    <div class="mb-4">
                                                        <i class="fas fa-box-open fa-5x mb-3"
                                                            style="color: #dee2e6;"></i>
                                                        <h3 class="fw-normal text-muted">Belum Ada Konfigurasi</h3>
                                                        <p class="text-muted mb-4">Mulai dengan menambahkan produk dan
                                                            material pertama Anda</p>
                                                    </div>
                                                    <a href="{{ route('kami-daur.create') }}"
                                                        class="btn btn-success btn-lg px-5 py-3">
                                                        <i class="fas fa-plus-circle me-2"></i> Tambah Konfigurasi Baru
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Aktif -->
                    <div class="tab-pane fade" id="active" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th width="80">ID</th>
                                        <th>Produk Unggulan</th>
                                        <th>Bahan & Material</th>
                                        <th width="160">Kontak</th>
                                        <th width="140">Dibuat</th>
                                        <th width="140">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kamiDaurs->where('is_active', true) as $config)
                                        <tr>
                                            <td>
                                                <span class="id-badge">
                                                    <i class="fas fa-hashtag me-1"></i>{{ $config->id }}
                                                </span>
                                            </td>
                                            <td>
                                                @if (isset($config->products) && count($config->products) > 0)
                                                    <div class="d-flex align-items-start gap-2 mb-2">
                                                        @foreach (array_slice($config->products, 0, 2) as $product)
                                                            <img src="{{ $product['image'] ?? 'https://via.placeholder.com/50' }}"
                                                                class="product-preview"
                                                                alt="{{ $product['name'] ?? '' }}"
                                                                style="width: 50px; height: 50px;">
                                                        @endforeach
                                                    </div>
                                                    <span class="stat-badge">
                                                        <i class="fas fa-cube"></i> {{ count($config->products) }}
                                                        Produk
                                                    </span>
                                                @else
                                                    <span class="text-muted">Tidak ada produk</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($config->materials) && count($config->materials) > 0)
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach ($config->materials as $material)
                                                            <span class="material-badge" style="font-size: 0.75rem;">
                                                                {{ Str::limit($material['name'] ?? '', 12) }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="text-muted">Tidak ada material</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>
                                                    <i class="fas fa-phone"></i>
                                                    {{ $config->contact_phone ?? '-' }}<br>
                                                    <i class="fas fa-envelope"></i>
                                                    {{ Str::limit($config->contact_email ?? '-', 15) }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="date-info">
                                                    <span class="date-item">
                                                        <i class="fas fa-calendar-alt"></i>
                                                        {{ $config->created_at->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('kami-daur.show', $config) }}"
                                                        class="btn btn-sm btn-info text-white btn-action">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('kami-daur.edit', $config) }}"
                                                        class="btn btn-sm btn-primary btn-action">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger btn-action"
                                                        onclick="confirmDelete({{ $config->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-toggle-off fa-4x mb-3"
                                                        style="color: #dee2e6;"></i>
                                                    <h4 class="fw-normal">Tidak Ada Konfigurasi Aktif</h4>
                                                    <p class="text-muted">Tidak ada konfigurasi yang sedang aktif saat
                                                        ini</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Tidak Aktif -->
                    <div class="tab-pane fade" id="inactive" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th width="80">ID</th>
                                        <th>Produk Unggulan</th>
                                        <th>Bahan & Material</th>
                                        <th width="140">Dibuat</th>
                                        <th width="140">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kamiDaurs->where('is_active', false) as $config)
                                        <tr>
                                            <td>
                                                <span class="id-badge">
                                                    <i class="fas fa-hashtag me-1"></i>{{ $config->id }}
                                                </span>
                                            </td>
                                            <td>
                                                @if (isset($config->products) && count($config->products) > 0)
                                                    <span class="stat-badge">
                                                        <i class="fas fa-cube"></i> {{ count($config->products) }}
                                                        Produk
                                                    </span>
                                                @else
                                                    <span class="text-muted">Tidak ada produk</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($config->materials) && count($config->materials) > 0)
                                                    <span class="badge bg-info">
                                                        {{ count($config->materials) }} Material
                                                    </span>
                                                @else
                                                    <span class="text-muted">Tidak ada material</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>
                                                    {{ $config->created_at->format('d/m/Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('kami-daur.show', $config) }}"
                                                        class="btn btn-sm btn-info text-white btn-action">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('kami-daur.edit', $config) }}"
                                                        class="btn btn-sm btn-primary btn-action">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger btn-action"
                                                        onclick="confirmDelete({{ $config->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-check-circle fa-4x mb-3"
                                                        style="color: #dee2e6;"></i>
                                                    <h4 class="fw-normal">Semua Konfigurasi Aktif</h4>
                                                    <p class="text-muted">Tidak ada konfigurasi yang tidak aktif</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if ($kamiDaurs->hasPages())
                <div class="card-footer bg-white py-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="mb-2 mb-md-0">
                            <small class="text-muted">
                                <i class="fas fa-database me-1"></i>
                                Menampilkan {{ $kamiDaurs->firstItem() ?? 0 }} - {{ $kamiDaurs->lastItem() ?? 0 }}
                                dari {{ $kamiDaurs->total() }} konfigurasi
                            </small>
                        </div>
                        <div>
                            {{ $kamiDaurs->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id, date = '') {
            Swal.fire({
                title: 'Hapus Konfigurasi?',
                html: `
                    <div style="text-align: left;">
                        <p>Anda akan menghapus konfigurasi <strong>#${id}</strong>${date ? ' (' + date + ')' : ''}</p>
                        <p class="text-danger mb-0"><i class="fas fa-exclamation-triangle me-1"></i> Semua produk dan material dalam konfigurasi ini akan ikut terhapus!</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Auto hide alert after 5 seconds
        setTimeout(function() {
            let alert = document.querySelector('.alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
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
