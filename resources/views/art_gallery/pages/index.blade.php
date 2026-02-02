@extends('layouts.layout_main')

@section('title', 'Art Gallery')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold mb-6">🎨 Art Gallery</h1>

    <div class="gallery-grid">

        @forelse ($galleries as $gallery)
        <a href="{{ route('gallery.show', $gallery->id) }}" class="block">
            <div class="gallery-card">

                <div class="gallery-image-wrapper">
                    <img 
                        src="{{ asset('storage/' . $gallery->image_path) }}"
                        class="gallery-image"
                        alt="{{ $gallery->title }}"
                    >
                </div>

                <div class="gallery-content">
                    <h2 class="gallery-title">{{ $gallery->title }}</h2>

                    @if($gallery->artist)
                        <p class="gallery-artist">🎨 {{ $gallery->artist }}</p>
                    @endif

                    @if($gallery->short_description)
                        <p class="gallery-description">
                            {{ Str::limit($gallery->short_description, 80) }}
                        </p>
                    @endif

                    <div class="gallery-meta">
                        @if($gallery->price)
                            <span class="gallery-price">
                                Rp {{ number_format($gallery->price) }}
                            </span>
                        @endif

                        @if($gallery->creation_date)
                            <span class="gallery-year">
                                {{ \Carbon\Carbon::parse($gallery->creation_date)->format('Y') }}
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </a>
        @empty
            <p class="text-gray-500">Belum ada data gallery.</p>
        @endforelse

    </div>

</div>
@endsection
