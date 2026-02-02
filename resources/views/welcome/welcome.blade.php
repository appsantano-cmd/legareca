@extends('layouts.layout_main')

@section('title', 'Welcome')

@section('content')

{{-- HERO --}}
<section id="beranda" class="hero-section relative overflow-hidden">

    <div class="relative w-full h-full">

        {{-- Slides --}}
        <div class="slide">
            <img src="{{ asset('storage/art_gallery/art1.jpeg') }}" alt="Art 1">
        </div>

        <div class="slide">
            <img src="{{ asset('storage/art_gallery/art2.jpeg') }}" alt="Art 2">
        </div>

        <div class="slide">
            <img src="{{ asset('storage/art_gallery/art3.jpeg') }}" alt="Art 3">
        </div>

        {{-- Navigation --}}
        <button class="slider-btn slider-btn-prev" id="prevBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="white"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>

        <button class="slider-btn slider-btn-next" id="nextBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="white"
                 stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>

        {{-- Indicators --}}
        <div class="slider-indicators">
            <div class="indicator" data-slide="0"></div>
            <div class="indicator" data-slide="1"></div>
            <div class="indicator" data-slide="2"></div>
        </div>

    </div>
</section>

{{-- LAYANAN --}}
<section class="py-12 bg-white">
    <div class="container">
        <h2 class="section-title text-3xl font-bold text-center">Layanan Kami</h2>
        <p class="text-center text-gray-600 mb-8 max-w-2xl mx-auto">
            Legareca Space menawarkan berbagai layanan terbaik
        </p>

        <div class="horizontal-card-container">
            @foreach ([
                ['Venue','Tempat acara elegan'],
                ['Legareca Inn','Penginapan nyaman'],
                ['Art Gallery','Galeri seni terbaik'],
                ['Legareca Pet','Perawatan hewan']
            ] as $item)
            <div class="horizontal-card">
                <img src="https://source.unsplash.com/600x400/?event" class="horizontal-card-image">
                <div class="horizontal-card-content">
                    <h3 class="font-bold text-xl mb-2">{{ $item[0] }}</h3>
                    <p class="text-gray-700">{{ $item[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FOOTER INFO --}}
<section class="py-12 bg-gray-800 text-white">
    <div class="container grid md:grid-cols-3 gap-8">
        <div>
            <h3 class="font-bold text-xl mb-3">Tentang Kami</h3>
            <p class="text-gray-300">
                Legareca Space adalah destinasi lengkap venue, penginapan dan galeri seni.
            </p>
        </div>
        <div>
            <h3 class="font-bold text-xl mb-3">Kontak</h3>
            <ul class="space-y-2 text-gray-300">
                <li>📍 Jakarta Selatan</li>
                <li>📞 (021) 1234-5678</li>
                <li>✉️ info@legarecaspace.com</li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold text-xl mb-3">Social</h3>
            <div class="flex gap-4">
                <a href="#" class="hover:text-red-500">Instagram</a>
                <a href="#" class="hover:text-red-500">YouTube</a>
            </div>
        </div>
    </div>
</section>

@endsection
