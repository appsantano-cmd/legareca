@extends('layouts.layout_main')

@section('title', $art->title)

@section('content')
@php
    use Carbon\Carbon;

    $today = Carbon::today();

    if ($art->start_date <= $today && $art->end_date >= $today) {
        $statusClass = 'ongoing';
        $statusText = 'Sedang Berlangsung';
    } elseif ($art->start_date > $today) {
        $statusClass = 'upcoming';
        $statusText = 'Akan Berlangsung';
    } else {
        $statusClass = 'past';
        $statusText = 'Sudah Berlangsung';
    }
@endphp

<div class="art-show-wrap">

    <a href="{{ route('gallery.index') }}" class="art-show-back">
        ← Kembali ke Gallery
    </a>

    {{-- HERO IMAGE --}}
    <div class="art-show-hero">
        <img src="{{ asset('storage/' . $art->image_path) }}" alt="{{ $art->title }}">
    </div>

    {{-- CONTENT --}}
    <div class="art-show-content">

        <div class="art-show-meta">
            <span class="art-show-status {{ $statusClass }}">
                {{ $statusText }}
            </span>

            <span class="art-show-date">
                {{ Carbon::parse($art->start_date)->format('d M Y') }}
                —
                {{ Carbon::parse($art->end_date)->format('d M Y') }}
            </span>
        </div>

        <h1 class="art-show-title">{{ $art->title }}</h1>

        @if($art->artist)
            <p class="art-show-artist">🎨 {{ $art->artist }}</p>
        @endif

        @if($art->location)
            <p class="art-show-location">📍 {{ $art->location }}</p>
        @endif

        @if($art->description)
            <div class="art-show-description">
                {{ $art->description }}
            </div>
        @endif

        <div class="art-show-actions">
            <a href="https://wa.me/62xxxxxxxxxx"
               target="_blank"
               class="btn-primary">
                💬 Tanya Kurator
            </a>

        </div>

    </div>
</div>
@endsection
