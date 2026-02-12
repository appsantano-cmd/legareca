<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk & Material - Kami Daur</title>
    
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
        }
        .form-control:focus, .form-select:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40,167,69,0.1);
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
        .camera-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            z-index: 10;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(40, 167, 69, 0.9);
            color: white;
            border: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .camera-btn:hover {
            background-color: #28a745;
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
    </style>
</head>
<body>
    <div class="container-fluid py-3">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-2 fw-bold">
                    <i class="fas fa-plus-circle text-success me-2"></i>Tambah Produk & Material
                </h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-info-circle me-1"></i> 
                    Kelola produk unggulan dan bahan/material daur ulang
                </p>
            </div>
            <a href="{{ route('kami-daur.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('kami-daur.store') }}" method="POST" id="configForm" enctype="multipart/form-data">
            @csrf

            <!-- PRODUK UNGGULAN SECTION -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-box me-2"></i> Produk Unggulan
                    </h5>
                    <span class="badge bg-light text-dark" id="product-count">
                        <i class="fas fa-cube me-1"></i> <span id="product-counter">3</span> Produk
                    </span>
                </div>
                <div class="card-body">
                    <div id="products-container">
                        @php
                            $oldProducts = old('products', [
                                [
                                    'name' => 'Jaket Denim Daur Ulang',
                                    'price' => 299000,
                                    'image' => 'https://images.unsplash.com/photo-1558769132-cb1cdeede?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                    'description' => 'Jaket denim stylish dari bahan jeans bekas berkualitas tinggi',
                                    'features' => ['100% bahan daur ulang', 'Limited edition', 'Eco-friendly dye'],
                                    'is_new' => true,
                                    'is_bestseller' => false
                                ],
                                [
                                    'name' => 'Dress Botol Plastik',
                                    'price' => 459000,
                                    'image' => 'https://images.unsplash.com/photo-1567401893414?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                    'description' => 'Dress elegan terbuat dari botol plastik daur ulang',
                                    'features' => ['22 botol plastik', 'Anti-bacterial', 'Water resistant'],
                                    'is_new' => false,
                                    'is_bestseller' => true
                                ],
                                [
                                    'name' => 'Tas Ransel Kain Perca',
                                    'price' => 189000,
                                    'image' => 'https://images.unsplash.com/photo-1553062407?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                    'description' => 'Tas unik dari sisa kain perca dengan desain modern',
                                    'features' => ['Handmade', 'Setiap tas unik', 'Waterproof lining'],
                                    'is_new' => false,
                                    'is_bestseller' => false
                                ]
                            ]);
                        @endphp
                        
                        @foreach($oldProducts as $index => $product)
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
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-product" {{ $loop->first ? 'disabled' : '' }}>
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Kolom Kiri - Upload Gambar -->
                                    <div class="col-md-3">
                                        <div class="border rounded p-2 bg-light text-center h-100 d-flex flex-column">
                                            <div class="image-upload-container mb-2">
                                                <img src="{{ $product['image'] ?? 'https://images.unsplash.com/photo-1558769132-cb1cdeede?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" 
                                                     class="img-fluid preview-image mb-2" 
                                                     alt="Preview" 
                                                     id="product-preview-{{ $index }}">
                                                <button type="button" class="btn camera-btn" onclick="document.getElementById('product-file-{{ $index }}').click();">
                                                    <i class="fas fa-camera"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted d-block">Klik kamera untuk upload/ambil foto</small>
                                            
                                            <!-- File Input -->
                                            <input type="file" 
                                                   class="form-control form-control-sm mt-2 product-image-file" 
                                                   id="product-file-{{ $index }}"
                                                   name="products[{{ $index }}][image_file]" 
                                                   accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,image/heic,image/heif"
                                                   style="display: none;"
                                                   onchange="previewImage(this, 'product-preview-{{ $index }}')">
                                            
                                            <!-- Hidden input untuk menyimpan URL gambar lama jika tidak upload baru -->
                                            <input type="hidden" name="products[{{ $index }}][image]" value="{{ $product['image'] ?? 'https://images.unsplash.com/photo-1558769132-cb1cdeede?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}">
                                            
                                            <div class="file-info mt-2" id="product-file-info-{{ $index }}">
                                                <i class="fas fa-info-circle"></i> Format: JPG, PNG, WEBP, HEIC (Max 20MB)
                                            </div>
                                            
                                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="document.getElementById('product-file-{{ $index }}').click();">
                                                <i class="fas fa-upload me-1"></i> Pilih File
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Kolom Kanan - Form -->
                                    <div class="col-md-9">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" 
                                                       name="products[{{ $index }}][name]" 
                                                       value="{{ $product['name'] ?? '' }}" 
                                                       placeholder="Contoh: Jaket Denim Daur Ulang">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Harga (Rp)</label>
                                                <input type="number" class="form-control" 
                                                       name="products[{{ $index }}][price]" 
                                                       value="{{ $product['price'] ?? '' }}" 
                                                       placeholder="299000">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea class="form-control" 
                                                          name="products[{{ $index }}][description]" 
                                                          rows="2" 
                                                          placeholder="Deskripsi produk">{{ $product['description'] ?? '' }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Fitur Produk</label>
                                                <div class="product-features-container mb-2">
                                                    @if(isset($product['features']) && is_array($product['features']))
                                                        @foreach($product['features'] as $fIndex => $feature)
                                                        <span class="feature-tag">
                                                            {{ $feature }}
                                                            <input type="hidden" name="products[{{ $index }}][features][]" value="{{ $feature }}">
                                                            <i class="fas fa-times-circle remove-feature"></i>
                                                        </span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm feature-input" placeholder="Tambah fitur...">
                                                    <button type="button" class="btn btn-outline-primary btn-sm add-feature">
                                                        <i class="fas fa-plus me-1"></i> Tambah
                                                    </button>
                                                </div>
                                                <small class="text-muted">Klik tombol tambah untuk menambah fitur produk</small>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="products[{{ $index }}][is_new]" 
                                                           value="1" {{ isset($product['is_new']) && $product['is_new'] ? 'checked' : '' }}>
                                                    <label class="form-check-label">
                                                        <span class="badge-new px-3 py-2">NEW</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="products[{{ $index }}][is_bestseller]" 
                                                           value="1" {{ isset($product['is_bestseller']) && $product['is_bestseller'] ? 'checked' : '' }}>
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
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="button" class="btn btn-success" id="add-product">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Produk Baru
                        </button>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Minimal 1 produk, maksimal 10 produk
                        </small>
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
                        <i class="fas fa-cubes me-1"></i> <span id="material-counter">3</span> Material
                    </span>
                </div>
                <div class="card-body">
                    <div id="materials-container">
                        @php
                            $oldMaterials = old('materials', [
                                [
                                    'name' => 'Botol Plastik',
                                    'description' => 'Botol plastik PET didaur ulang menjadi benang polyester untuk bahan pakaian berkualitas.',
                                    'image' => 'https://images.unsplash.com/photo-1542601906990-b4dceb0d8e63?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                    'info' => '10 botol = 1 kaos'
                                ],
                                [
                                    'name' => 'Kain Perca',
                                    'description' => 'Sisa kain dari industri garmen diolah menjadi produk baru dengan desain unik dan kreatif.',
                                    'image' => 'https://images.unsplash.com/photo-1562077981-1e3eab3c8c7a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                    'info' => 'Zero waste production'
                                ],
                                [
                                    'name' => 'Denim Bekas',
                                    'description' => 'Jeans bekas diproses menjadi serat baru untuk koleksi denim sustainable kami.',
                                    'image' => 'https://images.unsplash.com/photo-1578551124695-5c2c6c6c6c6c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80',
                                    'info' => 'Natural indigo dye'
                                ]
                            ]);
                        @endphp
                        
                        @foreach($oldMaterials as $index => $material)
                        <div class="material-item card mb-3" data-material-index="{{ $index }}">
                            <div class="material-header">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="mb-0 fw-bold">
                                            <i class="fas fa-cube text-info me-2"></i>
                                            Material #<span class="material-number">{{ $index + 1 }}</span>
                                        </h6>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-material" {{ $loop->first ? 'disabled' : '' }}>
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Kolom Kiri - Upload Gambar -->
                                    <div class="col-md-3">
                                        <div class="border rounded p-2 bg-light text-center h-100 d-flex flex-column">
                                            <div class="image-upload-container mb-2">
                                                <img src="{{ $material['image'] ?? 'https://images.unsplash.com/photo-1542601906990-b4dceb0d8e63?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" 
                                                     class="img-fluid material-preview mb-2" 
                                                     alt="Preview" 
                                                     id="material-preview-{{ $index }}"
                                                     style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                                                <button type="button" class="btn camera-btn" style="background: linear-gradient(135deg, #17a2b8, #138496);" onclick="document.getElementById('material-file-{{ $index }}').click();">
                                                    <i class="fas fa-camera"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted d-block">Klik kamera untuk upload/ambil foto</small>
                                            
                                            <!-- File Input -->
                                            <input type="file" 
                                                   class="form-control form-control-sm mt-2 material-image-file" 
                                                   id="material-file-{{ $index }}"
                                                   name="materials[{{ $index }}][image_file]" 
                                                   accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,image/heic,image/heif"
                                                   style="display: none;"
                                                   onchange="previewMaterialImage(this, 'material-preview-{{ $index }}')">
                                            
                                            <!-- Hidden input untuk menyimpan URL gambar lama jika tidak upload baru -->
                                            <input type="hidden" name="materials[{{ $index }}][image]" value="{{ $material['image'] ?? 'https://images.unsplash.com/photo-1542601906990-b4dceb0d8e63?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}">
                                            
                                            <div class="file-info mt-2" id="material-file-info-{{ $index }}">
                                                <i class="fas fa-info-circle"></i> Format: JPG, PNG, WEBP, HEIC (Max 20MB)
                                            </div>
                                            
                                            <button type="button" class="btn btn-outline-info btn-sm mt-2" onclick="document.getElementById('material-file-{{ $index }}').click();">
                                                <i class="fas fa-upload me-1"></i> Pilih File
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Kolom Kanan - Form -->
                                    <div class="col-md-9">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Nama Material</label>
                                                <input type="text" class="form-control" 
                                                       name="materials[{{ $index }}][name]" 
                                                       value="{{ $material['name'] ?? '' }}" 
                                                       placeholder="Contoh: Botol Plastik">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Info Tambahan</label>
                                                <input type="text" class="form-control" 
                                                       name="materials[{{ $index }}][info]" 
                                                       value="{{ $material['info'] ?? '' }}" 
                                                       placeholder="Contoh: 10 botol = 1 kaos">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea class="form-control" 
                                                          name="materials[{{ $index }}][description]" 
                                                          rows="3" 
                                                          placeholder="Deskripsi material">{{ $material['description'] ?? '' }}</textarea>
                                                <small class="text-muted">Informasi detail tentang material ini</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="button" class="btn btn-success" id="add-material" style="background: linear-gradient(135deg, #17a2b8, #138496); border: none;">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Material Baru
                        </button>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Minimal 1 material, maksimal 6 material
                        </small>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('kami-daur.index') }}'">
                    <i class="fas fa-times me-2"></i> Batal
                </button>
                <button type="submit" class="btn btn-success px-5 py-2">
                    <i class="fas fa-save me-2"></i> Simpan Produk & Material
                </button>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Fungsi preview gambar untuk produk
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result);
                    
                    // Update file info
                    var file = input.files[0];
                    var fileSize = (file.size / 1024 / 1024).toFixed(2);
                    var fileInfo = $(input).closest('.col-md-3').find('.file-info');
                    fileInfo.html('<i class="fas fa-check-circle text-success"></i> ' + file.name + ' (' + fileSize + 'MB)');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Fungsi preview gambar untuk material
        function previewMaterialImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result);
                    
                    // Update file info
                    var file = input.files[0];
                    var fileSize = (file.size / 1024 / 1024).toFixed(2);
                    var fileInfo = $(input).closest('.col-md-3').find('.file-info');
                    fileInfo.html('<i class="fas fa-check-circle text-success"></i> ' + file.name + ' (' + fileSize + 'MB)');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function() {
            // Counter untuk produk dan material
            let productCount = {{ count(old('products', [])) }};
            let materialCount = {{ count(old('materials', [])) }};
            
            // Update counter
            $('#product-counter').text(productCount);
            $('#material-counter').text(materialCount);

            // ============ PRODUK ============
            // Tambah produk baru
            $('#add-product').click(function() {
                if ($('.product-item').length >= 10) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Maksimal Produk',
                        text: 'Anda hanya dapat menambahkan maksimal 10 produk!',
                        confirmButtonColor: '#28a745'
                    });
                    return;
                }
                
                productCount = $('.product-item').length;
                let newIndex = productCount;
                
                const html = `
                    <div class="product-item card mb-3" data-product-index="${newIndex}">
                        <div class="product-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 fw-bold">
                                        <i class="fas fa-tag text-success me-2"></i>
                                        Produk #<span class="product-number">${newIndex + 1}</span>
                                    </h6>
                                </div>
                                <div class="col-auto">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-product">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Kolom Kiri - Upload Gambar -->
                                <div class="col-md-3">
                                    <div class="border rounded p-2 bg-light text-center h-100 d-flex flex-column">
                                        <div class="image-upload-container mb-2">
                                            <img src="https://images.unsplash.com/photo-1558769132-cb1cdeede?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                                                 class="img-fluid preview-image mb-2" 
                                                 alt="Preview" 
                                                 id="product-preview-${newIndex}">
                                            <button type="button" class="btn camera-btn" onclick="document.getElementById('product-file-${newIndex}').click();">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted d-block">Klik kamera untuk upload/ambil foto</small>
                                        
                                        <!-- File Input -->
                                        <input type="file" 
                                               class="form-control form-control-sm mt-2 product-image-file" 
                                               id="product-file-${newIndex}"
                                               name="products[${newIndex}][image_file]" 
                                               accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,image/heic,image/heif"
                                               style="display: none;"
                                               onchange="previewImage(this, 'product-preview-${newIndex}')">
                                        
                                        <!-- Hidden input untuk menyimpan URL gambar default -->
                                        <input type="hidden" name="products[${newIndex}][image]" value="https://images.unsplash.com/photo-1558769132-cb1cdeede?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80">
                                        
                                        <div class="file-info mt-2" id="product-file-info-${newIndex}">
                                            <i class="fas fa-info-circle"></i> Format: JPG, PNG, WEBP, HEIC (Max 20MB)
                                        </div>
                                        
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="document.getElementById('product-file-${newIndex}').click();">
                                            <i class="fas fa-upload me-1"></i> Pilih File
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-md-9">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Produk</label>
                                            <input type="text" class="form-control" 
                                                   name="products[${newIndex}][name]" 
                                                   placeholder="Contoh: Jaket Denim Daur Ulang">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Harga (Rp)</label>
                                            <input type="number" class="form-control" 
                                                   name="products[${newIndex}][price]" 
                                                   placeholder="299000">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea class="form-control" 
                                                      name="products[${newIndex}][description]" 
                                                      rows="2" 
                                                      placeholder="Deskripsi produk"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Fitur Produk</label>
                                            <div class="product-features-container mb-2"></div>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm feature-input" placeholder="Tambah fitur...">
                                                <button type="button" class="btn btn-outline-primary btn-sm add-feature">
                                                    <i class="fas fa-plus me-1"></i> Tambah
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="products[${newIndex}][is_new]" value="1">
                                                <label class="form-check-label">
                                                    <span class="badge-new px-3 py-2">NEW</span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="products[${newIndex}][is_bestseller]" value="1">
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
                `;
                
                $('#products-container').append(html);
                $('#product-counter').text($('.product-item').length);
            });

            // Hapus produk
            $(document).on('click', '.remove-product', function() {
                if ($('.product-item').length > 1) {
                    Swal.fire({
                        title: 'Hapus Produk?',
                        text: "Produk yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).closest('.product-item').remove();
                            // Update nomor urut dan index
                            $('.product-item').each(function(index) {
                                $(this).attr('data-product-index', index);
                                $(this).find('.product-number').text(index + 1);
                                $(this).find('input, textarea, select').each(function() {
                                    let name = $(this).attr('name');
                                    if (name) {
                                        $(this).attr('name', name.replace(/products\[\d+\]/, `products[${index}]`));
                                    }
                                });
                                
                                // Update ID preview dan file input
                                $(this).find('.preview-image').attr('id', `product-preview-${index}`);
                                $(this).find('.product-image-file').attr('id', `product-file-${index}`);
                                $(this).find('.camera-btn').attr('onclick', `document.getElementById('product-file-${index}').click();`);
                                $(this).find('.product-image-file').attr('onchange', `previewImage(this, 'product-preview-${index}')`);
                                $(this).find('.file-info').attr('id', `product-file-info-${index}`);
                            });
                            $('#product-counter').text($('.product-item').length);
                            
                            Swal.fire(
                                'Terhapus!',
                                'Produk berhasil dihapus.',
                                'success'
                            );
                        }
                    });
                }
            });

            // ============ MATERIAL ============
            // Tambah material baru
            $('#add-material').click(function() {
                if ($('.material-item').length >= 6) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Maksimal Material',
                        text: 'Anda hanya dapat menambahkan maksimal 6 material!',
                        confirmButtonColor: '#17a2b8'
                    });
                    return;
                }
                
                materialCount = $('.material-item').length;
                let newIndex = materialCount;
                
                const html = `
                    <div class="material-item card mb-3" data-material-index="${newIndex}">
                        <div class="material-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0 fw-bold">
                                        <i class="fas fa-cube text-info me-2"></i>
                                        Material #<span class="material-number">${newIndex + 1}</span>
                                    </h6>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-material">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Kolom Kiri - Upload Gambar -->
                                <div class="col-md-3">
                                    <div class="border rounded p-2 bg-light text-center h-100 d-flex flex-column">
                                        <div class="image-upload-container mb-2">
                                            <img src="https://images.unsplash.com/photo-1542601906990-b4dceb0d8e63?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                                                 class="img-fluid material-preview mb-2" 
                                                 alt="Preview" 
                                                 id="material-preview-${newIndex}"
                                                 style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                                            <button type="button" class="btn camera-btn" style="background: linear-gradient(135deg, #17a2b8, #138496);" onclick="document.getElementById('material-file-${newIndex}').click();">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted d-block">Klik kamera untuk upload/ambil foto</small>
                                        
                                        <!-- File Input -->
                                        <input type="file" 
                                               class="form-control form-control-sm mt-2 material-image-file" 
                                               id="material-file-${newIndex}"
                                               name="materials[${newIndex}][image_file]" 
                                               accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,image/heic,image/heif"
                                               style="display: none;"
                                               onchange="previewMaterialImage(this, 'material-preview-${newIndex}')">
                                        
                                        <!-- Hidden input untuk menyimpan URL gambar default -->
                                        <input type="hidden" name="materials[${newIndex}][image]" value="https://images.unsplash.com/photo-1542601906990-b4dceb0d8e63?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80">
                                        
                                        <div class="file-info mt-2" id="material-file-info-${newIndex}">
                                            <i class="fas fa-info-circle"></i> Format: JPG, PNG, WEBP, HEIC (Max 20MB)
                                        </div>
                                        
                                        <button type="button" class="btn btn-outline-info btn-sm mt-2" onclick="document.getElementById('material-file-${newIndex}').click();">
                                            <i class="fas fa-upload me-1"></i> Pilih File
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-md-9">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Material</label>
                                            <input type="text" class="form-control" 
                                                   name="materials[${newIndex}][name]" 
                                                   placeholder="Contoh: Botol Plastik">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Info Tambahan</label>
                                            <input type="text" class="form-control" 
                                                   name="materials[${newIndex}][info]" 
                                                   placeholder="Contoh: 10 botol = 1 kaos">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Deskripsi</label>
                                            <textarea class="form-control" 
                                                      name="materials[${newIndex}][description]" 
                                                      rows="3" 
                                                      placeholder="Deskripsi material"></textarea>
                                            <small class="text-muted">Informasi detail tentang material ini</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#materials-container').append(html);
                $('#material-counter').text($('.material-item').length);
            });

            // Hapus material
            $(document).on('click', '.remove-material', function() {
                if ($('.material-item').length > 1) {
                    Swal.fire({
                        title: 'Hapus Material?',
                        text: "Material yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).closest('.material-item').remove();
                            // Update nomor urut dan index
                            $('.material-item').each(function(index) {
                                $(this).attr('data-material-index', index);
                                $(this).find('.material-number').text(index + 1);
                                $(this).find('input, textarea').each(function() {
                                    let name = $(this).attr('name');
                                    if (name) {
                                        $(this).attr('name', name.replace(/materials\[\d+\]/, `materials[${index}]`));
                                    }
                                });
                                
                                // Update ID preview dan file input
                                $(this).find('.material-preview').attr('id', `material-preview-${index}`);
                                $(this).find('.material-image-file').attr('id', `material-file-${index}`);
                                $(this).find('.camera-btn').attr('onclick', `document.getElementById('material-file-${index}').click();`);
                                $(this).find('.material-image-file').attr('onchange', `previewMaterialImage(this, 'material-preview-${index}')`);
                                $(this).find('.file-info').attr('id', `material-file-info-${index}`);
                            });
                            $('#material-counter').text($('.material-item').length);
                            
                            Swal.fire(
                                'Terhapus!',
                                'Material berhasil dihapus.',
                                'success'
                            );
                        }
                    });
                }
            });

            // ============ FITUR PRODUK ============
            // Tambah fitur
            $(document).on('click', '.add-feature', function() {
                let input = $(this).closest('.input-group').find('.feature-input');
                let featureText = input.val().trim();
                
                if (featureText === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Fitur tidak boleh kosong!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    return;
                }
                
                let container = $(this).closest('.col-12').find('.product-features-container');
                let productDiv = $(this).closest('.product-item');
                let productIndex = productDiv.data('product-index');
                
                let featureHtml = `
                    <span class="feature-tag">
                        ${featureText}
                        <input type="hidden" name="products[${productIndex}][features][]" value="${featureText}">
                        <i class="fas fa-times-circle remove-feature"></i>
                    </span>
                `;
                
                container.append(featureHtml);
                input.val('');
            });

            // Hapus fitur
            $(document).on('click', '.remove-feature', function() {
                $(this).closest('.feature-tag').remove();
            });

            // ============ FORM SUBMIT ============
            $('#configForm').on('submit', function(e) {
                let isValid = true;
                let errorMessage = '';
                
                // Validasi minimal 1 produk
                if ($('.product-item').length === 0) {
                    errorMessage = 'Minimal harus ada 1 produk!';
                    isValid = false;
                }
                
                // Validasi minimal 1 material
                if ($('.material-item').length === 0) {
                    errorMessage = 'Minimal harus ada 1 material!';
                    isValid = false;
                }
                
                // Validasi nama produk tidak boleh kosong
                $('.product-item').each(function() {
                    let productName = $(this).find('input[name*="[name]"]').val();
                    if (!productName || productName.trim() === '') {
                        errorMessage = 'Nama produk tidak boleh kosong!';
                        isValid = false;
                        return false;
                    }
                });
                
                // Validasi harga produk
                $('.product-item').each(function() {
                    let price = $(this).find('input[name*="[price]"]').val();
                    if (price && price < 0) {
                        errorMessage = 'Harga produk tidak boleh negatif!';
                        isValid = false;
                        return false;
                    }
                });
                
                // Validasi file gambar (max 20MB)
                $('.product-image-file, .material-image-file').each(function() {
                    if (this.files.length > 0) {
                        let fileSize = this.files[0].size / 1024 / 1024; // dalam MB
                        if (fileSize > 20) {
                            errorMessage = 'Ukuran file gambar maksimal 20MB!';
                            isValid = false;
                            return false;
                        }
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: errorMessage,
                        confirmButtonColor: '#28a745'
                    });
                } else {
                    // Tampilkan loading
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>