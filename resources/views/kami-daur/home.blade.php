{{-- resources/views/kami-daur/home.blade.php --}}
@extends('layouts.layout_main')

@section('title', 'Butik Daur Ulang')
@section('meta_description', 'Butik Daur Ulang - Fashion Berkelanjutan')

@section('content')
    <!-- Hero Section -->
    <section class="kami-daur-hero">
        <div class="container kami-daur-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold">BUTIK BAJU DAUR ULANG</h1>
                    <p class="lead">Fashion Berkelanjutan untuk Bumi yang Lebih Hijau</p>
                    <p>Setiap pakaian yang kami buat adalah cerita tentang perubahan - dari limbah menjadi karya seni yang bermakna, dari sampah menjadi fashion yang stylish dan ramah lingkungan.</p>
                    @if(isset($products) && is_array($products) && count($products) > 0)
                    <a href="#produk" class="btn order-btn mt-3" style="max-width: 200px;">
                        <i class="fas fa-shopping-bag me-2"></i> Lihat Koleksi
                    </a>
                    @endif
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-leaf environment-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk Unggulan Section - TANPA DUMMY DATA -->
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
                            <img src="{{ $product['image'] ?? '' }}" 
                                 class="product-image" alt="{{ $product['name'] }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product['name'] ?? '' }}</h5>
                                @if(isset($product['price']))
                                <div class="product-price">Rp {{ number_format($product['price'], 0, ',', '.') }}</div>
                                @endif
                                <p class="card-text">{{ $product['description'] ?? '' }}</p>
                                
                                @if(isset($product['features']) && is_array($product['features']) && count($product['features']) > 0)
                                <ul class="product-features">
                                    @foreach($product['features'] as $feature)
                                    <li><i class="fas fa-check"></i> {{ $feature }}</li>
                                    @endforeach
                                </ul>
                                @endif
                                
                                <a href="https://wa.me/6281234567890?text=Halo%20Butik%20Daur%20Ulang,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product['name'] ?? '') }}%20dan%20ingin%20bertanya%20lebih%20lanjut." 
                                   class="btn order-btn" target="_blank">
                                    <i class="fab fa-whatsapp me-2"></i> Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- KOSONG TOTAL - TIDAK ADA DUMMY DATA -->
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h4>Belum Ada Produk</h4>
                        <p class="text-muted">Produk akan segera hadir. Nantikan koleksi eksklusif dari kami!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Bahan & Proses Section - TANPA DUMMY DATA -->
    <section id="proses" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Proses & Bahan Kami</h2>
            <p class="text-center mb-5">Dari limbah menjadi fashion bernilai tinggi</p>
            
            <div class="row g-4">
                @if(isset($materials) && is_array($materials) && count($materials) > 0)
                    @foreach($materials as $material)
                    <div class="col-lg-4 col-md-6">
                        <div class="material-card">
                            <img src="{{ $material['image'] ?? '' }}" 
                                 class="material-image" alt="{{ $material['name'] }}">
                            <div class="card-body">
                                <h5 class="material-name">{{ $material['name'] ?? '' }}</h5>
                                <p class="card-text">{{ $material['description'] ?? '' }}</p>
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
                    <!-- KOSONG TOTAL - TIDAK ADA DUMMY DATA -->
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-flask fa-3x text-muted mb-3"></i>
                        <h4>Belum Ada Informasi Material</h4>
                        <p class="text-muted">Kami akan segera menginformasikan bahan-bahan yang digunakan dalam proses daur ulang.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section - DISEDERHANAKAN -->
    <section id="tentang" class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">Tentang Kami</h2>
                    <p class="fs-5">Butik Daur Ulang hadir sebagai jawaban atas masalah limbah tekstil yang semakin meningkat. Kami percaya bahwa fashion bisa menjadi gaya hidup sekaligus kontribusi positif bagi lingkungan.</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <h3 class="mb-4">Nilai Kami</h3>
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
                </div>
                
                <div class="col-lg-6 mb-4">
                    <h3 class="mb-4">Hubungi Kami</h3>
                    <div class="info-box p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="contact-icon me-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">WhatsApp</h5>
                                <p class="mb-0">+62 812-3456-7890</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="contact-icon me-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Email</h5>
                                <p class="mb-0">butik@daurulang.com</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="contact-icon me-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Alamat</h5>
                                <p class="mb-0">Jl. Sustainable Fashion No. 123, Kota Hijau</p>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="https://wa.me/6281234567890?text=Halo%20Butik%20Daur%20Ulang,%20saya%20ingin%20konsultasi%20tentang%20produk%20fashion%20berkelanjutan." 
                               class="btn btn-whatsapp" 
                               target="_blank">
                                <i class="fab fa-whatsapp whatsapp-icon"></i> Konsultasi via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Section - DISEDERHANAKAN -->
    <section id="layanan" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Layanan Kami</h2>
            <p class="text-center mb-5">Siap membantu Anda menemukan fashion berkelanjutan yang tepat</p>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="contact-card">
                        <div class="contact-icon mx-auto mb-3">
                            <i class="fas fa-ruler"></i>
                        </div>
                        <h4 class="text-center">Custom Size</h4>
                        <p class="text-center">Kami menerima pemesanan ukuran custom untuk kenyamanan maksimal.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="contact-card">
                        <div class="contact-icon mx-auto mb-3">
                            <i class="fas fa-palette"></i>
                        </div>
                        <h4 class="text-center">Custom Design</h4>
                        <p class="text-center">Konsultasikan ide Anda dengan desainer kami.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="contact-card">
                        <div class="contact-icon mx-auto mb-3">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h4 class="text-center">Free Delivery</h4>
                        <p class="text-center">Gratis pengiriman untuk pembelian di atas Rp 500.000.</p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <h5 class="mb-3">Metode Pembayaran</h5>
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <span class="badge bg-success">Transfer Bank</span>
                        <span class="badge bg-primary">E-Wallet</span>
                        <span class="badge bg-warning">COD</span>
                        <span class="badge bg-info">Kredit</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection