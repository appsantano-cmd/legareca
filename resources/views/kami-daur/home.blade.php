@extends('layouts.layout_main')

@section('title', $title ?? 'Butik Daur Ulang')
@section('meta_description', $description ?? '')

@section('content')
    <!-- Hero Section -->
    <section class="kami-daur-hero">
        <div class="container kami-daur-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold">{{ $hero_title ?? $title ?? 'BUTIK BAJU DAUR ULANG' }}</h1>
                    <p class="lead">{{ $hero_subtitle ?? 'Fashion Berkelanjutan untuk Bumi yang Lebih Hijau' }}</p>
                    <p>{{ $hero_description ?? ($description ?? 'Setiap pakaian yang kami buat adalah cerita tentang perubahan - dari limbah menjadi karya seni yang bermakna, dari sampah menjadi fashion yang stylish dan ramah lingkungan.') }}</p>
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
                @if(isset($products) && is_array($products) && count($products) > 0)
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class="card product-card">
                            @if($product['is_new'] ?? false)
                            <span class="product-badge">NEW</span>
                            @endif
                            @if($product['is_bestseller'] ?? false)
                            <span class="product-badge" style="background: linear-gradient(135deg, #FF9800, #F57C00); top: 45px;">BESTSELLER</span>
                            @endif
                            <img src="{{ $product['image'] ?? 'https://images.unsplash.com/photo-1558769132-cb1cdeede?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" 
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
                                
                                <a href="https://wa.me/{{ $contact['phone'] ?? '6281234567890' }}?text=Halo%20Butik%20Daur%20Ulang,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product['name'] ?? '') }}%20dan%20ingin%20bertanya%20lebih%20lanjut." 
                                   class="btn order-btn" target="_blank">
                                    <i class="fab fa-whatsapp me-2"></i> Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Fallback jika tidak ada produk -->
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h4>Belum Ada Produk</h4>
                        <p class="text-muted">Produk akan segera hadir. Nantikan koleksi eksklusif dari kami!</p>
                    </div>
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
                @if(isset($materials) && is_array($materials) && count($materials) > 0)
                    @foreach($materials as $material)
                    <div class="col-lg-4 col-md-6">
                        <div class="material-card">
                            <img src="{{ $material['image'] ?? 'https://images.unsplash.com/photo-1542601906990-b4dceb0d8e63?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" 
                                 class="material-image" alt="{{ $material['name'] }}">
                            <div class="card-body">
                                <h5 class="material-name">{{ $material['name'] ?? 'Material Daur Ulang' }}</h5>
                                <p class="card-text">{{ $material['description'] ?? 'Deskripsi material' }}</p>
                                @if(!empty($material['info']))
                                <div class="info-box mt-3 p-3">
                                    <small><i class="fas fa-recycle me-2"></i> {{ $material['info'] }}</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Fallback jika tidak ada material -->
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-flask fa-3x text-muted mb-3"></i>
                        <h4>Informasi Material</h4>
                        <p class="text-muted">Kami akan segera menginformasikan bahan-bahan yang digunakan dalam proses daur ulang.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">{{ $about_title ?? 'Filosofi Kami' }}</h2>
                    <p class="fs-5">{{ $about_description ?? ($description ?? 'Butik Daur Ulang hadir sebagai jawaban atas masalah limbah tekstil yang semakin meningkat. Kami percaya bahwa fashion bisa menjadi gaya hidup sekaligus kontribusi positif bagi lingkungan.') }}</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <h3 class="mb-4">Nilai Kami</h3>
                    @if(isset($mission) && is_array($mission) && count($mission) > 0)
                        @foreach($mission as $item)
                        <div class="mission-item">
                            <i class="fas fa-leaf me-2 text-success"></i>
                            {{ $item }}
                        </div>
                        @endforeach
                    @else
                        <div class="mission-item">
                            <i class="fas fa-leaf me-2 text-success"></i>
                            Setiap produk menyelamatkan 1kg limbah
                        </div>
                        <div class="mission-item">
                            <i class="fas fa-leaf me-2 text-success"></i>
                            Menggunakan pewarna alami ramah lingkungan
                        </div>
                        <div class="mission-item">
                            <i class="fas fa-leaf me-2 text-success"></i>
                            Mendukung pengrajin lokal
                        </div>
                        <div class="mission-item">
                            <i class="fas fa-leaf me-2 text-success"></i>
                            Transparansi proses produksi
                        </div>
                    @endif
                </div>
                
                <div class="col-lg-6 mb-4">
                    <h3 class="mb-4">Impact Kami</h3>
                    <div class="info-box">
                        <div class="row text-center">
                            @if(isset($impact_stats) && is_array($impact_stats) && count($impact_stats) > 0)
                                @foreach($impact_stats as $stat)
                                <div class="col-4">
                                    <div class="contact-icon" style="width: 50px; height: 50px; margin: 0 auto 10px;">
                                        <i class="fas {{ $stat['icon'] ?? 'fa-recycle' }}"></i>
                                    </div>
                                    <h4>{{ $stat['value'] ?? '0' }}</h4>
                                    <small>{{ $stat['label'] ?? 'Statistik' }}</small>
                                </div>
                                @endforeach
                            @else
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
                            @endif
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
                                <small class="text-muted"><i class="fas fa-clock me-1"></i> Buka: {{ $opening_hours ?? 'Senin-Sabtu 10:00-20:00' }}</small>
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
                        
                        @if(isset($services) && is_array($services) && count($services) > 0)
                            @foreach($services as $service)
                            <div class="alert alert-info">
                                <h6><i class="fas {{ $service['icon'] ?? 'fa-circle' }} me-2"></i> {{ $service['title'] ?? 'Layanan' }}</h6>
                                <p class="mb-2">{{ $service['description'] ?? 'Deskripsi layanan' }}</p>
                            </div>
                            @endforeach
                        @else
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
                        @endif
                        
                        <div class="mt-4">
                            <h5>Metode Pembayaran</h5>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                @if(isset($payment_methods) && is_array($payment_methods) && count($payment_methods) > 0)
                                    @foreach($payment_methods as $method)
                                    <span class="badge bg-success">{{ $method }}</span>
                                    @endforeach
                                @else
                                    <span class="badge bg-success">Transfer Bank</span>
                                    <span class="badge bg-primary">E-Wallet</span>
                                    <span class="badge bg-warning">COD</span>
                                    <span class="badge bg-info">Kredit</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection