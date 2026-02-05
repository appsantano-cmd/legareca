<a href="{{ route('gallery.show', $gallery->id) }}" class="gallery-row">

    <div class="gallery-row-image">
        <img
            src="{{ asset('storage/' . $gallery->image_path) }}"
            alt="{{ $gallery->title }}"
        >
    </div>

    <div class="gallery-row-content">
        <h3 class="gallery-row-title">{{ $gallery->title }}</h3>

        @if($gallery->artist)
            <p class="gallery-row-artist">🎨 {{ $gallery->artist }}</p>
        @endif

        @if($gallery->short_description)
            <p class="gallery-row-description">
                {{ \Illuminate\Support\Str::limit($gallery->short_description, 120) }}
            </p>
        @endif

        <div class="gallery-row-dates">
            <span class="gallery-row-date-label">Tanggal Pameran</span>
            <span class="gallery-row-date">
                {{ \Carbon\Carbon::parse($gallery->start_date)->format('d M Y') }}
                —
                {{ \Carbon\Carbon::parse($gallery->end_date)->format('d M Y') }}
            </span>
        </div>
    </div>

</a>
