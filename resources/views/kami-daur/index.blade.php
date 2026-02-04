@extends('layouts.layout_main')

@section('title', $title ?? 'Butik Daur Ulang')

@section('content')
    <!-- Hero Section -->
    <section class="kami-daur-hero">
        <div class="container kami-daur-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold">BUTIK BAJU DAUR ULANG</h1>
                    <p class="lead">Fashion Berkelanjutan untuk Bumi yang Lebih Hijau</p>
                    <p>Setiap pakaian yang kami buat adalah cerita tentang perubahan - dari limbah menjadi karya seni yang bermakna, dari sampah menjadi fashion yang stylish dan ramah lingkungan.</p>
                    <a href="#produk" class="btn order-btn mt-3" style="max-width: 200px;">
                        <i class="fas fa-shopping-bag me-2"></i> Lihat Koleksi
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-leaf environment-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk Unggulan Section -->
    <section id="produk" class="py-5">
        <div class="container">
            <h2 class="section-title">Koleksi Eksklusif Kami</h2>
            <p class="text-center mb-5">Setiap potong pakaian dibuat dengan cinta dan komitmen terhadap lingkungan</p>
            
            <div class="row g-4">
                @if(isset($products) && is_array($products))
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class="card product-card">
                            @if($product['is_new'] ?? false)
                            <span class="product-badge">NEW</span>
                            @endif
                            @if($product['is_bestseller'] ?? false)
                            <span class="product-badge" style="background: linear-gradient(135deg, #FF9800, #F57C00); top: 45px;">BESTSELLER</span>
                            @endif
                            <img src="{{ $product['image'] ?? 'https://images.unsplash.com/photo-1558769132-cb1cdeede' }}" 
                                 class="product-image" alt="{{ $product['name'] }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product['name'] ?? 'Produk Daur Ulang' }}</h5>
                                <div class="product-price">Rp {{ number_format($product['price'] ?? 0, 0, ',', '.') }}</div>
                                <p class="card-text">{{ $product['description'] ?? 'Deskripsi produk' }}</p>
                                
                                <ul class="product-features">
                                    @foreach($product['features'] ?? [] as $feature)
                                    <li><i class="fas fa-check"></i> {{ $feature }}</li>
                                    @endforeach
                                </ul>
                                
                                <a href="https://wa.me/{{ $contact['phone'] ?? '' }}?text=Halo%20Butik%20Daur%20Ulang,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product['name'] ?? '') }}%20dan%20ingin%20bertanya%20lebih%20lanjut." 
                                   class="btn order-btn" target="_blank">
                                    <i class="fab fa-whatsapp me-2"></i> Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Fallback produk jika tidak ada data -->
                    @php
                        $defaultProducts = [
                            [
                                'name' => 'Jaket Denim Daur Ulang',
                                'price' => 299000,
                                'image' => 'https://images.unsplash.com/photo-1558769132-cb1cdeede',
                                'description' => 'Jaket denim stylish dari bahan jeans bekas berkualitas tinggi',
                                'features' => ['100% bahan daur ulang', 'Limited edition', 'Eco-friendly dye'],
                                'is_new' => true
                            ],
                            [
                                'name' => 'Dress Botol Plastik',
                                'price' => 459000,
                                'image' => 'https://images.unsplash.com/photo-1567401893414',
                                'description' => 'Dress elegan terbuat dari botol plastik daur ulang',
                                'features' => ['22 botol plastik', 'Anti-bacterial', 'Water resistant'],
                                'is_bestseller' => true
                            ],
                            [
                                'name' => 'Tas Ransel Kain Perca',
                                'price' => 189000,
                                'image' => 'https://images.unsplash.com/photo-1553062407',
                                'description' => 'Tas unik dari sisa kain perca dengan desain modern',
                                'features' => ['Handmade', 'Setiap tas unik', 'Waterproof lining']
                            ]
                        ];
                    @endphp
                    
                    @foreach($defaultProducts as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class="card product-card">
                            @if($product['is_new'] ?? false)
                            <span class="product-badge">NEW</span>
                            @endif
                            @if($product['is_bestseller'] ?? false)
                            <span class="product-badge" style="background: linear-gradient(135deg, #FF9800, #F57C00); top: 45px;">BESTSELLER</span>
                            @endif
                            <img src="{{ $product['image'] }}?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                                 class="product-image" alt="{{ $product['name'] }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product['name'] }}</h5>
                                <div class="product-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</div>
                                <p class="card-text">{{ $product['description'] }}</p>
                                
                                <ul class="product-features">
                                    @foreach($product['features'] as $feature)
                                    <li><i class="fas fa-check"></i> {{ $feature }}</li>
                                    @endforeach
                                </ul>
                                
                                <a href="https://wa.me/{{ $contact['phone'] ?? '6281234567890' }}?text=Halo%20Butik%20Daur%20Ulang,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product['name']) }}%20dan%20ingin%20bertanya%20lebih%20lanjut." 
                                   class="btn order-btn" target="_blank">
                                    <i class="fab fa-whatsapp me-2"></i> Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Bahan & Proses Section -->
    <section id="proses" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Proses & Bahan Kami</h2>
            <p class="text-center mb-5">Dari limbah menjadi fashion bernilai tinggi</p>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="material-card">
                        <img src="https://images.unsplash.com/photo-1542601906990-b4dceb0d8e63?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             class="material-image" alt="Botol Plastik">
                        <div class="card-body">
                            <h5 class="material-name">Botol Plastik</h5>
                            <p class="card-text">Botol plastik PET didaur ulang menjadi benang polyester untuk bahan pakaian berkualitas.</p>
                            <div class="info-box mt-3 p-3">
                                <small><i class="fas fa-recycle me-2"></i> 10 botol = 1 kaos</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="material-card">
                        <img src="https://images.unsplash.com/photo-1562077981-1e3eab3c8c7a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             class="material-image" alt="Kain Perca">
                        <div class="card-body">
                            <h5 class="material-name">Kain Perca</h5>
                            <p class="card-text">Sisa kain dari industri garmen diolah menjadi produk baru dengan desain unik dan kreatif.</p>
                            <div class="info-box mt-3 p-3">
                                <small><i class="fas fa-heart me-2"></i> Zero waste production</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="material-card">
                        <img src="https://images.unsplash.com/photo-1578551124695-5c2c6c6c6c6c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             class="material-image" alt="Denim Bekas">
                        <div class="card-body">
                            <h5 class="material-name">Denim Bekas</h5>
                            <p class="card-text">Jeans bekas diproses menjadi serat baru untuk koleksi denim sustainable kami.</p>
                            <div class="info-box mt-3 p-3">
                                <small><i class="fas fa-tint me-2"></i> Natural indigo dye</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">Filosofi Kami</h2>
                    <p class="fs-5">{{ $description ?? 'Butik Daur Ulang hadir sebagai jawaban atas masalah limbah tekstil yang semakin meningkat. Kami percaya bahwa fashion bisa menjadi gaya hidup sekaligus kontribusi positif bagi lingkungan.' }}</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <h3 class="mb-4">Nilai Kami</h3>
                    @foreach($mission ?? [
                        'Setiap produk menyelamatkan 1kg limbah',
                        'Menggunakan pewarna alami ramah lingkungan',
                        'Mendukung pengrajin lokal',
                        'Transparansi proses produksi'
                    ] as $item)
                    <div class="mission-item">
                        <i class="fas fa-leaf me-2 text-success"></i>
                        {{ $item }}
                    </div>
                    @endforeach
                </div>
                
                <div class="col-lg-6 mb-4">
                    <h3 class="mb-4">Impact Kami</h3>
                    <div class="info-box">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="contact-icon" style="width: 50px; height: 50px; margin: 0 auto 10px;">
                                    <i class="fas fa-recycle"></i>
                                </div>
                                <h4>5,000+</h4>
                                <small>Botol Plastik</small>
                            </div>
                            <div class="col-4">
                                <div class="contact-icon" style="width: 50px; height: 50px; margin: 0 auto 10px;">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                                <h4>2,500+</h4>
                                <small>Pakaian Terjual</small>
                            </div>
                            <div class="col-4">
                                <div class="contact-icon" style="width: 50px; height: 50px; margin: 0 auto 10px;">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4>50+</h4>
                                <small>Pengrajin</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Transparansi:</strong> Setiap produk dilengkapi dengan informasi dampak lingkungan yang ditimbulkan dan diselamatkan.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hubungi Kami Section -->
    <section id="kontak" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Konsultasi & Pemesanan</h2>
            <p class="text-center mb-5">Siap membantu Anda menemukan fashion berkelanjutan yang tepat</p>
            
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="contact-card">
                        <h3 class="mb-4">Butik Kami</h3>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <h5>Telepon/WhatsApp</h5>
                                <p>{{ $contact['phone'] ?? '+62 812-3456-7890' }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h5>Email</h5>
                                <p>{{ $contact['email'] ?? 'butik@daurulang.com' }}</p>
                            </div>
                            
                            <div class="col-12 mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h5>Alamat Butik</h5>
                                <p>{{ $contact['address'] ?? 'Jl. Sustainable Fashion No. 123, Kota Hijau' }}</p>
                                <small class="text-muted"><i class="fas fa-clock me-1"></i> Buka: Senin-Sabtu 10:00-20:00</small>
                            </div>
                        </div>
                        
                        <!-- WhatsApp Button -->
                        <div class="text-center mt-4">
                            <a href="https://wa.me/{{ $contact['phone'] ?? '6281234567890' }}?text=Halo%20Butik%20Daur%20Ulang,%20saya%20ingin%20konsultasi%20tentang%20produk%20fashion%20berkelanjutan%20dan%20ingin%20melakukan%20pemesanan." 
                               class="btn btn-whatsapp" 
                               target="_blank">
                                <i class="fab fa-whatsapp whatsapp-icon"></i> Konsultasi via WhatsApp
                            </a>
                            <p class="mt-2 text-muted">Dapatkan rekomendasi produk terbaik dari tim fashion consultant kami</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="contact-card">
                        <h4 class="mb-3">Layanan Kami</h4>
                        
                        <div class="alert alert-info">
                            <h6><i class="fas fa-ruler me-2"></i> Custom Size</h6>
                            <p class="mb-2">Kami menerima pemesanan ukuran custom untuk kenyamanan maksimal.</p>
                        </div>
                        
                        <div class="alert alert-info">
                            <h6><i class="fas fa-palette me-2"></i> Custom Design</h6>
                            <p class="mb-2">Ingin desain khusus? Konsultasikan ide Anda dengan desainer kami.</p>
                        </div>
                        
                        <div class="alert alert-info">
                            <h6><i class="fas fa-truck me-2"></i> Free Delivery</h6>
                            <p class="mb-2">Gratis pengiriman untuk pembelian di atas Rp 500.000.</p>
                        </div>
                        
                        <div class="mt-4">
                            <h5>Metode Pembayaran</h5>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <span class="badge bg-success">Transfer Bank</span>
                                <span class="badge bg-primary">E-Wallet</span>
                                <span class="badge bg-warning">COD</span>
                                <span class="badge bg-info">Kredit</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection