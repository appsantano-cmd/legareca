@extends('layouts.layout_main')

@section('title', 'Art Gallery')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold mb-12">🎨 Art Gallery</h1>

    {{-- =========================
       🟢 SEDANG BERLANGSUNG
    ========================== --}}
    @if($ongoing->count())
    <section class="gallery-section">
        <h2 class="gallery-section-title">🟢 Sedang Berlangsung</h2>

        <div class="gallery-list">
            @foreach($ongoing as $gallery)
                @include('art-gallery.partials.row', ['gallery' => $gallery])
            @endforeach
        </div>
    </section>
    @endif

    {{-- =========================
       🔵 AKAN BERLANGSUNG
    ========================== --}}
    @if($upcoming->count())
    <section class="gallery-section">
        <h2 class="gallery-section-title">🔵 Akan Berlangsung</h2>

        <div class="gallery-list">
            @foreach($upcoming as $gallery)
                @include('art-gallery.partials.row', ['gallery' => $gallery])
            @endforeach
        </div>
    </section>
    @endif

    {{-- =========================
       ⚪ SUDAH BERLANGSUNG
    ========================== --}}
    @if($past->count())
    <section class="gallery-section">
        <h2 class="gallery-section-title">⚪ Sudah Berlangsung</h2>

        <div class="gallery-list">
            @foreach($past as $gallery)
                @include('art-gallery.partials.row', ['gallery' => $gallery])
            @endforeach
        </div>
    </section>
    @endif

    {{-- fallback --}}
    @if(
        !$ongoing->count() &&
        !$upcoming->count() &&
        !$past->count()
    )
        <p class="text-gray-500">Belum ada data gallery.</p>
    @endif

</div>
@endsection
