@extends('layouts.layout_main')

@section('title', $art->title)

@section('content')
<div class="art-show-container">

    <a href="{{ route('gallery.index') }}" class="art-show-back">
        ← Kembali ke Gallery
    </a>

    <div class="art-show-grid">

        <!-- Image -->
        <div class="art-show-image-wrapper">
            <img
                src="{{ asset('storage/' . $art->image_path) }}"
                alt="{{ $art->title }}"
                class="art-show-image">
        </div>

        <!-- Info -->
        <div>
            <h1 class="art-show-title">{{ $art->title }}</h1>

            @if($art->artist)
            <p class="art-show-artist">🎨 {{ $art->artist }}</p>
            @endif

            @if($art->creation_date)
            <p class="art-show-year">
                Tahun {{ \Carbon\Carbon::parse($art->creation_date)->format('Y') }}
            </p>
            @endif

            @if($art->price)
            <div class="art-show-price">
                Rp {{ number_format($art->price) }}
            </div>
            @endif

            @if($art->description)
            <p class="art-show-description">
                {{ $art->description }}
            </p>
            @endif

            <div class="art-show-actions">
                <a href="https://wa.me/6281328897679?text=Halo,%20saya%20ingin%20bertanya%20tentang%20Karya%20Ini%20di%20Art%20Gallery"
                    target="_blank"
                    class="art-show-btn-primary">
                    💬 Tanya
                </a>

                <button class="art-show-btn-outline">
                    ❤️ Favorit
                </button>
            </div>
        </div>

    </div>
</div>

@endsection