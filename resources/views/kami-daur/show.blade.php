<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk & Material - Kami Daur #{{ $kamiDaur->id }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            padding: 30px 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container-fluid {
            max-width: 1000px;
            margin: 0 auto;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            border: none;
            margin-bottom: 25px;
        }
        .card-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }
        .card-header h5 {
            margin: 0;
            font-weight: 600;
        }
        .card-body {
            padding: 1.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
            background-color: #f9f9f9;
        }
        .form-control:disabled, .form-select:disabled {
            background-color: #f2f2f2;
            border-color: #dee2e6;
            color: #495057;
            opacity: 1;
        }
        .btn {
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
        }
        .btn-success {
            background: linear-gradient(135deg, #28a745, #218838);
            border: none;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
        }
        .btn-outline-danger {
            border-color: #dc3545;
            color: #dc3545;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
        .btn-outline-primary {
            border-color: #28a745;
            color: #28a745;
        }
        .btn-outline-primary:hover {
            background-color: #28a745;
            color: white;
        }
        .btn-outline-info {
            border-color: #17a2b8;
            color: #17a2b8;
        }
        .btn-outline-info:hover {
            background-color: #17a2b8;
            color: white;
        }
        .product-item, .material-item {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: white;
            transition: all 0.3s;
        }
        .product-item:hover, .material-item:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .product-header, .material-header {
            background-color: #f8f9fa;
            padding: 1rem 1.5rem;
            border-radius: 10px 10px 0 0;
            border-bottom: 1px solid #e9ecef;
        }
        .badge-new {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .badge-bestseller {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .feature-tag {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-block;
            margin-right: 8px;
            margin-bottom: 8px;
        }
        .feature-tag i {
            margin-left: 6px;
            cursor: pointer;
            color: #dc3545;
        }
        .feature-tag i:hover {
            color: #a71d2a;
        }
        .preview-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #dee2e6;
        }
        .image-upload-container {
            position: relative;
            margin-bottom: 10px;
        }
        .file-info {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
        }
        .supported-formats {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 3px;
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-3">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-2 fw-bold">
                    <i class="fas fa-eye text-success me-2"></i>Detail Produk & Material
                </h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-info-circle me-1"></i> 
                    Detail produk unggulan dan bahan/material daur ulang
                </p>
            </div>
            <div>
                <a href="{{ route('kami-daur.edit', $kamiDaur) }}" class="btn btn-warning text-white me-2">
                    <i class="fas fa-edit me-2"></i> Edit
                </a>
                <a href="{{ route('kami-daur.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        <!-- PRODUK UNGGULAN SECTION -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-box me-2"></i> Produk Unggulan
                </h5>
                <span class="badge bg-light text-dark" id="product-count">
                    <i class="fas fa-cube me-1"></i> <span id="product-counter">{{ count($kamiDaur->products ?? []) }}</span> Produk
                </span>
            </div>
            <div class="card-body">
                <div id="products-container">
                    @php
                        $products = $kamiDaur->products ?? [];
                    @endphp
                    
                    @forelse($products as $index => $product)
                    <div class="product-item card mb-3" data-product-index="{{ $index }}">
                        <div class="product-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 fw-bold">
                                        <i class="fas fa-tag text-success me-2"></i>
                                        Produk #<span class="product-number">{{ $index + 1 }}</span>
                                    </h6>
                                </div>
                                <div class="col-auto">
                                    @if(isset($product['is_new']) && $product['is_new'])
                                        <span class="badge-new me-2">NEW</span>
                                    @endif
                                    @if(isset($product['is_bestseller']) && $product['is_bestseller'])
                                        <span class="badge-bestseller">BESTSELLER</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Kolom Kiri - Preview Gambar -->
                                <div class="col-md-3">
                                    <div class="border rounded p-2 bg-light text-center h-100 d-flex flex-column">
                                        <div class="image-upload-container mb-2">
                                            <img src="{{ $product['image'] ?? 'https://via.placeholder.com/300' }}" 
                                                 class="img-fluid preview-image mb-2" 
                                                 alt="Preview" 
                                                 id="product-preview-{{ $index }}">
                                        </div>
                                        <small class="text-muted d-block">Gambar Produk</small>
                                        
                                        <div class="file-info mt-2" id="product-file-info-{{ $index }}">
                                            <i class="fas fa-image"></i> URL: 
                                            <a href="{{ $product['image'] ?? '#' }}" target="_blank" class="text-truncate d-block">
                                                {{ Str::limit($product['image'] ?? '', 30) }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Kolom Kanan - Detail -->
                                <div class="col-md-9">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Produk</label>
                                            <input type="text" class="form-control" 
                                                   value="{{ $product['name'] ?? '' }}" 
                                                   placeholder="Contoh: Jaket Denim Daur Ulang"
                                                   disabled readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Harga (Rp)</label>
                                            <input type="text" class="form-control" 
                                                   value="Rp {{ number_format($product['price'] ?? 0, 0, ',', '.') }}" 
                                                   placeholder="299000"
                                                   disabled readonly>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea class="form-control" 
                                                      rows="2" 
                                                      placeholder="Deskripsi produk"
                                                      disabled readonly>{{ $product['description'] ?? '' }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Fitur Produk</label>
                                            <div class="product-features-container mb-2">
                                                @if(isset($product['features']) && is_array($product['features']))
                                                    @foreach($product['features'] as $fIndex => $feature)
                                                    <span class="feature-tag">
                                                        {{ $feature }}
                                                        <i class="fas fa-check-circle text-success ms-1" style="cursor: default;"></i>
                                                    </span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Tidak ada fitur</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" 
                                                       {{ isset($product['is_new']) && $product['is_new'] ? 'checked' : '' }}
                                                       disabled>
                                                <label class="form-check-label">
                                                    <span class="badge-new px-3 py-2">NEW</span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" 
                                                       {{ isset($product['is_bestseller']) && $product['is_bestseller'] ? 'checked' : '' }}
                                                       disabled>
                                                <label class="form-check-label">
                                                    <span class="badge-bestseller px-3 py-2">BESTSELLER</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada produk.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- BAHAN & MATERIAL SECTION -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #17a2b8, #138496);">
                <h5 class="mb-0">
                    <i class="fas fa-recycle me-2"></i> Bahan & Material
                </h5>
                <span class="badge bg-light text-dark" id="material-count">
                    <i class="fas fa-cubes me-1"></i> <span id="material-counter">{{ count($kamiDaur->materials ?? []) }}</span> Material
                </span>
            </div>
            <div class="card-body">
                <div id="materials-container">
                    @php
                        $materials = $kamiDaur->materials ?? [];
                    @endphp
                    
                    @forelse($materials as $index => $material)
                    <div class="material-item card mb-3" data-material-index="{{ $index }}">
                        <div class="material-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 fw-bold">
                                        <i class="fas fa-cube text-info me-2"></i>
                                        Material #<span class="material-number">{{ $index + 1 }}</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Kolom Kiri - Preview Gambar -->
                                <div class="col-md-3">
                                    <div class="border rounded p-2 bg-light text-center h-100 d-flex flex-column">
                                        <div class="image-upload-container mb-2">
                                            <img src="{{ $material['image'] ?? 'https://via.placeholder.com/300' }}" 
                                                 class="img-fluid material-preview mb-2" 
                                                 alt="Preview" 
                                                 id="material-preview-{{ $index }}"
                                                 style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                                        </div>
                                        <small class="text-muted d-block">Gambar Material</small>
                                        
                                        <div class="file-info mt-2" id="material-file-info-{{ $index }}">
                                            <i class="fas fa-image"></i> URL: 
                                            <a href="{{ $material['image'] ?? '#' }}" target="_blank" class="text-truncate d-block">
                                                {{ Str::limit($material['image'] ?? '', 30) }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Kolom Kanan - Detail -->
                                <div class="col-md-9">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Material</label>
                                            <input type="text" class="form-control" 
                                                   value="{{ $material['name'] ?? '' }}" 
                                                   placeholder="Contoh: Botol Plastik"
                                                   disabled readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Info Tambahan</label>
                                            <input type="text" class="form-control" 
                                                   value="{{ $material['info'] ?? '' }}" 
                                                   placeholder="Contoh: 10 botol = 1 kaos"
                                                   disabled readonly>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea class="form-control" 
                                                      rows="3" 
                                                      placeholder="Deskripsi material"
                                                      disabled readonly>{{ $material['description'] ?? '' }}</textarea>
                                            <small class="text-muted">Informasi detail tentang material ini</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-cubes fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada material.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
            <a href="{{ route('kami-daur.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
            </a>
            <div>
                <button type="button" class="btn btn-danger me-2" onclick="confirmDelete()">
                    <i class="fas fa-trash me-2"></i> Hapus
                </button>
                <a href="{{ route('kami-daur.edit', $kamiDaur) }}" class="btn btn-success px-5 py-2">
                    <i class="fas fa-edit me-2"></i> Edit Konfigurasi
                </a>
            </div>
        </div>
    </div>

    <!-- Form Delete (Hidden) -->
    <form id="delete-form" action="{{ route('kami-daur.destroy', $kamiDaur) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Hapus Konfigurasi?',
                text: "Konfigurasi yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        }

        $(document).ready(function() {
            // Initialize nothing, this is readonly view
            console.log('Show view loaded - Readonly mode');
        });
    </script>
</body>
</html>