@extends('layouts.app')

@section('hide-footer')
@endsection

@section('body-class', 'bg-cyan-950')

@section('title', 'Ajukan Izin')

@section('content')

<div class="min-h-screen py-10 px-4">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="text-center text-white mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/20 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-3-3v6m-7 3h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold">Form Pengajuan Izin</h1>
            <p class="text-sm opacity-90 mt-2">
                Silakan isi data dengan lengkap dan benar
            </p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">

            {{-- Error Global --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700">
                    <p class="font-semibold mb-2">⚠️ Terdapat kesalahan:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('izin.store') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                {{-- Section: Identitas --}}
                <div>
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">👤 Data Karyawan</h2>

                    <div class="grid md:grid-cols-2 gap-4">
                        {{-- Nama --}}
                        <div>
                            <label class="text-sm font-medium">Nama Lengkap *</label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                class="input"
                                placeholder="Nama lengkap">
                        </div>

                        {{-- Divisi --}}
                        <div>
                            <label class="text-sm font-medium">Divisi / Jabatan *</label>
                            <input type="text" name="divisi" value="{{ old('divisi') }}"
                                class="input"
                                placeholder="Contoh: IT Support">
                        </div>
                    </div>
                </div>

                {{-- Section: Jenis Izin --}}
                <div x-data="{ selected: '{{ old('jenis_izin_pilihan') }}' }">
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">📌 Jenis Izin</h2>

                    <div class="grid md:grid-cols-2 gap-3">
                        @foreach ([
                            'Izin Sakit',
                            'Izin Datang Terlambat',
                            'Izin Pulang Lebih Awal',
                            'Izin Kematian Keluarga',
                            'Lainnya'
                        ] as $option)
                            <label class="cursor-pointer">
                                <input
                                    type="radio"
                                    name="jenis_izin_pilihan"
                                    value="{{ $option }}"
                                    x-model="selected"
                                    class="peer hidden"
                                >

                                <div
                                    class="border rounded-xl px-4 py-3 text-sm font-medium transition
                                        hover:border-indigo-400
                                        peer-checked:border-indigo-600
                                        peer-checked:bg-indigo-50
                                        peer-checked:text-indigo-700"
                                >
                                    {{ $option }}
                                </div>
                            </label>
                        @endforeach
                    </div>

                    {{-- Input Lainnya --}}
                    <div x-show="selected === 'Lainnya'" x-transition class="mt-3">
                        <input
                            type="text"
                            name="jenis_izin_lainnya"
                            value="{{ old('jenis_izin_lainnya') }}"
                            placeholder="Tuliskan jenis izin lainnya..."
                            class="input"
                        >
                    </div>
                </div>

                {{-- Section: Tanggal --}}
                <div>
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">📅 Durasi Izin</h2>

                    <div class="grid md:grid-cols-3 gap-4">
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="input" value="{{ old('tanggal_mulai') }}">
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="input" value="{{ old('tanggal_selesai') }}">
                        <input type="number" id="jumlah_hari" name="jumlah_hari" class="input" readonly>
                    </div>
                </div>

                {{-- Section: Keterangan Tambahan --}}
                <div>
                    <h2 class="font-semibold text-lg text-gray-700 mb-3">📝 Keterangan Tambahan</h2>

                    <textarea
                        name="keterangan_tambahan"
                        rows="3"
                        class="input"
                        placeholder="Tuliskan keterangan tambahan (opsional)..."
                    >{{ old('keterangan_tambahan') }}</textarea>

                    <p class="text-xs text-gray-500 mt-1">
                        Contoh: keperluan keluarga, kontrol dokter, dll.
                    </p>
                </div>

                {{-- Section: File --}}
                <div>
                    <h2 class="font-semibold text-lg text-gray-700 mb-2">📎 Dokumen Pendukung</h2>
                    <input type="file" name="documen_pendukung"
                           class="input-file"
                           onchange="previewFile(event)">
                    <div id="preview" class="hidden mt-3">
                        <img id="preview-image" class="h-32 rounded-lg border">
                        <p id="preview-file" class="text-sm text-gray-600 mt-1"></p>
                    </div>
                </div>

                {{-- Section: Kontak --}}
                <div>
                    <h2 class="font-semibold text-lg text-gray-700 mb-4">📞 Kontak & Alamat</h2>

                    <div class="grid md:grid-cols-2 gap-4">
                        <input type="text" name="nomor_telepon" class="input" placeholder="Nomor HP">
                        <textarea name="alamat" rows="2" class="input" placeholder="Alamat selama izin"></textarea>
                    </div>
                </div>

                {{-- Konfirmasi --}}
                <label class="flex items-start gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="konfirmasi" value="1" class="mt-1">
                    Saya menyatakan data yang diisi benar.
                </label>

                {{-- Action --}}
                <div class="flex justify-between pt-6 border-t">
                    <a href="{{ route('dashboard') }}" class="btn-secondary">
                        ← Kembali
                    </a>

                    <button class="btn-primary">
                        Kirim Pengajuan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Reusable Styles --}}
<style>
    .input {
        @apply w-full rounded-xl border px-4 py-3 text-sm
        focus:ring-2 focus:ring-indigo-400 focus:outline-none transition;
    }

    .input-file {
        @apply w-full rounded-xl border px-4 py-2 text-sm cursor-pointer;
    }

    .btn-primary {
        @apply bg-gradient-to-r from-indigo-600 to-purple-600 text-white
        px-6 py-3 rounded-xl font-semibold shadow-lg hover:opacity-90 transition;
    }

    .btn-secondary {
        @apply px-6 py-3 rounded-xl border text-gray-600 hover:bg-gray-100 transition;
    }

    .radio-card {
        cursor: pointer;
    }

    .radio-ui {
        @apply border rounded-xl px-4 py-3 flex items-center justify-center
        hover:border-indigo-400 transition;
    }

    input:checked + .radio-ui {
        @apply border-indigo-600 bg-indigo-50 text-indigo-700 font-semibold;
    }
</style>

<script>
function previewFile(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    const img = document.getElementById('preview-image');
    const fileText = document.getElementById('preview-file');

    if (!file) return;

    preview.classList.remove('hidden');

    if (file.type.startsWith('image/')) {
        img.src = URL.createObjectURL(file);
        img.classList.remove('hidden');
        fileText.innerText = file.name;
    } else {
        img.classList.add('hidden');
        fileText.innerText = file.name;
    }
}
document.addEventListener('DOMContentLoaded', function () {
    const startInput = document.getElementById('tanggal_mulai');
    const endInput   = document.getElementById('tanggal_selesai');
    const totalInput = document.getElementById('jumlah_hari');

    function hitungHari() {
        if (!startInput.value || !endInput.value) return;

        const start = new Date(startInput.value);
        const end   = new Date(endInput.value);

        const diffTime = end - start;
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

        if (diffDays > 0) {
            totalInput.value = diffDays;
        } else {
            totalInput.value = '';
        }
    }

    startInput.addEventListener('change', hitungHari);
    endInput.addEventListener('change', hitungHari);
});
</script>

@endsection
