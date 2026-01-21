@extends('layouts.app')

@section('title', 'Art Gallery')

@section('body-class', 'bg-gray-100')

@push('styles')
    @include('partials.navbar-style')
@endpush

@push('scripts')
    @include('partials.navbar-script')
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold mb-6">🎨 Art Gallery</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

        @forelse ($galleries as $gallery)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                {{-- IMAGE --}}
                <img 
                    src="{{ asset('storage/' . $gallery->image_path) }}"
                    alt="{{ $gallery->title }}"
                    class="w-full h-56 object-cover"
                >

                {{-- CONTENT --}}
                <div class="p-4 space-y-2">
                    <h2 class="font-semibold text-lg">
                        {{ $gallery->title }}
                    </h2>

                    @if($gallery->artist)
                        <p class="text-sm text-gray-500">
                            🎨 {{ $gallery->artist }}
                        </p>
                    @endif

                    @if($gallery->description)
                        <p class="text-sm text-gray-700 line-clamp-2">
                            {{ $gallery->description }}
                        </p>
                    @endif

                    <div class="flex justify-between items-center pt-2">
                        @if($gallery->price)
                            <span class="font-bold text-orange-600">
                                Rp {{ number_format($gallery->price) }}
                            </span>
                        @endif

                        @if($gallery->creation_date)
                            <span class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($gallery->creation_date)->format('Y') }}
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        @empty
            <p class="text-gray-500">Belum ada data gallery.</p>
        @endforelse

    </div>

</div>
@endsection
