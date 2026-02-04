@extends('layouts.layout_main')

@section('title', $title ?? 'Lega Pet Care')

@section('content')
    <!-- Hero Section -->
    <section class="pet-care-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold text-white">Lega Pet Care</h1>
                    <p class="lead text-white mb-4">{{ $tagline ?? 'Perawatan Terbaik untuk Sahabat Berbulu Anda' }}</p>
                    <p class="text-white mb-4">Kami memberikan perawatan penuh kasih dan profesional untuk hewan peliharaan Anda dengan fasilitas lengkap dan staf berpengalaman.</p>
                    <a href="#layanan" class="btn btn-primary btn-lg">
                        <i class="fas fa-paw me-2"></i> Lihat Layanan Kami
                    </a>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-paw pet-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Layanan Unggulan Kami</h2>
            <p class="text-center mb-5">Berbagai layanan lengkap untuk kebutuhan hewan peliharaan Anda</p>
            
            <!-- Baris 1: Layanan Utama -->
            <div class="row justify-content-center mb-4">
                @foreach(array_slice($services, 0, 5) as $service)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="{{ $service['icon'] }}"></i>
                        </div>
                        <img src="{{ $service['image'] }}?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             class="service-image" alt="{{ $service['title'] }}">
                        <div class="service-body">
                            <h5 class="service-title">{{ $service['title'] }}</h5>
                            <p class="service-description">{{ $service['description'] }}</p>
                            
                            <div class="service-price mb-3">
                                <i class="fas fa-tag me-2"></i> {{ $service['price_range'] }}
                            </div>
                            
                            <a href="https://wa.me/{{ $contact['phone'] }}?text=Halo%20Lega%20Pet%20Care,%20saya%20ingin%20bertanya%20tentang%20layanan%20{{ urlencode($service['title']) }}%20untuk%20hewan%20peliharaan%20saya." 
                               class="btn btn-service" target="_blank">
                                <i class="fab fa-whatsapp me-2"></i> Konsultasi Sekarang
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Baris 2: Detail Fitur -->
            @if(count($services) > 5)
            <div class="row justify-content-center">
                @foreach(array_slice($services, 5) as $service)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="{{ $service['icon'] }}"></i>
                        </div>
                        <img src="{{ $service['image'] }}?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                             class="service-image" alt="{{ $service['title'] }}">
                        <div class="service-body">
                            <h5 class="service-title">{{ $service['title'] }}</h5>
                            <p class="service-description">{{ $service['description'] }}</p>
                            
                            <div class="service-price mb-3">
                                <i class="fas fa-tag me-2"></i> {{ $service['price_range'] }}
                            </div>
                            
                            <a href="https://wa.me/{{ $contact['phone'] }}?text=Halo%20Lega%20Pet%20Care,%20saya%20ingin%20bertanya%20tentang%20layanan%20{{ urlencode($service['title']) }}%20untuk%20hewan%20peliharaan%20saya." 
                               class="btn btn-service" target="_blank">
                                <i class="fab fa-whatsapp me-2"></i> Konsultasi Sekarang
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    <!-- Features Grid Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Fitur Lengkap Setiap Layanan</h2>
            <p class="text-center mb-5">Detail lengkap dari setiap layanan yang kami tawarkan</p>
            
            <div class="features-grid">
                @foreach($services as $service)
                <div class="feature-category">
                    <div class="feature-header">
                        <div class="feature-icon">
                            <i class="{{ $service['icon'] }}"></i>
                        </div>
                        <h4>{{ $service['title'] }}</h4>
                        <p class="feature-price">{{ $service['price_range'] }}</p>
                    </div>
                    
                    <div class="feature-list">
                        @foreach($service['features'] as $feature)
                        <div class="feature-item">
                            <i class="fas fa-check-circle text-success"></i>
                            <span>{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="feature-action">
                        <a href="https://wa.me/{{ $contact['phone'] }}?text=Halo%20Lega%20Pet%20Care,%20saya%20ingin%20bertanya%20tentang%20layanan%20{{ urlencode($service['title']) }}%20dan%20detail%20fitur-fiturnya." 
                           class="btn btn-outline-primary btn-sm" target="_blank">
                            <i class="fab fa-whatsapp me-1"></i> Detail Layanan
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimoni" class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Apa Kata Klien Kami</h2>
            <p class="text-center mb-5">Kepuasan peliharaan dan pemilik adalah prioritas kami</p>
            
            <div class="row g-4">
                @foreach($testimonials as $testimonial)
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial['rating'])
                                <i class="fas fa-star text-warning"></i>
                                @else
                                <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="testimonial-text">"{{ $testimonial['text'] }}"</p>
                        <div class="testimonial-author">
                            <strong>{{ $testimonial['name'] }}</strong>
                            <span class="text-muted"> - {{ $testimonial['pet'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-center mb-5">Temukan jawaban untuk pertanyaan umum tentang layanan kami</p>
            
            <div class="accordion" id="faqAccordion">
                @foreach($faqs as $index => $faq)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" 
                                type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapse{{ $index }}" 
                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                aria-controls="collapse{{ $index }}">
                            <i class="fas fa-question-circle me-3 text-primary"></i>
                            {{ $faq['question'] }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" 
                         class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                         aria-labelledby="heading{{ $index }}" 
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Hubungi Kami</h2>
            <p class="text-center mb-5">Siap melayani hewan peliharaan Anda dengan penuh kasih sayang</p>
            
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="contact-card">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <h5>Telepon/WhatsApp</h5>
                                <p>{{ $contact['phone'] ?? '+62 811-2233-4455' }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h5>Email</h5>
                                <p>{{ $contact['email'] ?? 'petcare@legareca.com' }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h5>Alamat</h5>
                                <p>{{ $contact['address'] ?? 'Jl. Animal Care No. 123, Kota Pet Friendly' }}</p>
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <div class="contact-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h5>Jam Operasional</h5>
                                <p>Senin - Jumat: {{ $contact['hours']['weekdays'] ?? '07:00 - 21:00' }}</p>
                                <p>Sabtu - Minggu: {{ $contact['hours']['weekends'] ?? '08:00 - 20:00' }}</p>
                            </div>
                        </div>
                        
                        <!-- WhatsApp Button -->
                        <div class="text-center mt-4">
                            <a href="https://wa.me/{{ $contact['phone'] ?? '6281122334455' }}?text=Halo%20Lega%20Pet%20Care,%20saya%20ingin%20bertanya%20tentang%20layanan%20perawatan%20hewan%20peliharaan%20dan%20ingin%20melakukan%20reservasi." 
                               class="btn btn-whatsapp" 
                               target="_blank">
                                <i class="fab fa-whatsapp whatsapp-icon"></i> Reservasi via WhatsApp
                            </a>
                            <p class="mt-2 text-muted">Reservasi cepat dan mudah melalui WhatsApp</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="contact-card">
                        <h4 class="mb-4">Persyaratan</h4>
                        
                        <div class="alert alert-info">
                            <h6><i class="fas fa-syringe me-2"></i> Vaksinasi Lengkap</h6>
                            <p class="mb-0">Hewan harus sudah divaksin sesuai usia dan jenis.</p>
                        </div>
                        
                        <div class="alert alert-info">
                            <h6><i class="fas fa-heartbeat me-2"></i> Sehat dan Aktif</h6>
                            <p class="mb-0">Tidak menunjukkan gejala sakit dalam 7 hari terakhir.</p>
                        </div>
                        
                        <div class="alert alert-info">
                            <h6><i class="fas fa-id-card me-2"></i> Data Lengkap</h6>
                            <p class="mb-0">Membawa kartu vaksin dan data pemilik lengkap.</p>
                        </div>
                        
                        <div class="mt-4">
                            <h5>Metode Pembayaran</h5>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <span class="badge bg-success">Transfer Bank</span>
                                <span class="badge bg-primary">E-Wallet</span>
                                <span class="badge bg-warning">Tunai</span>
                                <span class="badge bg-info">Kartu Kredit</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection