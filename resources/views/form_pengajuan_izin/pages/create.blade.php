@extends('layouts.app')

@section('title', 'Ajukan Izin')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm p-6">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Form Pengajuan Izin</h1>
        <p class="text-sm text-gray-500 mt-1">
            Silakan isi data berikut dengan benar dan lengkap
        </p>
    </div>

    <form method="POST" action="{{ route('izin.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Nama --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Nama Karyawan<span class="text-red-500">*</span>
            </label>
            <input type="text" name="nama"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                value="{{ old('nama') }}"
                placeholder="Masukkan nama lengkap">
            @error('nama')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        {{-- Divisi --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Jabatan / Divisi <span class="text-red-500">*</span>
            </label>
            <input type="text" name="divisi"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                value="{{ old('divisi') }}"
                placeholder="Contoh: IT Support">
            @error('divisi')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        {{-- Jenis Izin --}}
        <div class="mb-4" x-data="{ selected: '{{ old('jenis_izin_pilihan') }}' }">
            <label class="block text-sm font-semibold mb-2">
                Jenis Izin <span class="text-red-500">*</span>
            </label>

            <div class="space-y-2">
                @foreach ([
                    'Izin Sakit',
                    'Izin Datang Terlambat',
                    'Izin Pulang Lebih Awal',
                    'Izin Kematian Keluarga',
                    'Lainnya'
                ] as $option)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            type="radio"
                            name="jenis_izin_pilihan"
                            value="{{ $option }}"
                            x-model="selected"
                            class="text-blue-600 focus:ring-blue-500"
                        >
                        <span class="text-sm">{{ $option }}</span>
                    </label>
                @endforeach
            </div>

            {{-- Input Lainnya --}}
            <input
                x-show="selected === 'Lainnya'"
                x-transition
                type="text"
                name="jenis_izin_lainnya"
                value="{{ old('jenis_izin_lainnya') }}"
                placeholder="Tulis jenis izin lainnya..."
                class="w-full border rounded-lg px-3 py-2 mt-3 focus:ring-2 focus:ring-blue-200 focus:outline-none"
            >

            @error('jenis_izin_lainnya')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        {{-- Tanggal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold mb-1">
                    Tanggal Mulai Izin<span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_mulai"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    value="{{ old('tanggal_mulai') }}">
                @error('tanggal_mulai')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">
                    Tanggal Selesai Izin<span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_selesai"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    value="{{ old('tanggal_selesai') }}">
                @error('tanggal_selesai')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- Jumlah Hari --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Jumlah Hari <span class="text-red-500">*</span>
            </label>
            <input type="number" name="jumlah_hari"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                value="{{ old('jumlah_hari') }}"
                min="1">
            @error('jumlah_hari')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        {{-- Keterangan --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Keterangan Tambahan
            </label>
            <textarea name="keterangan_tambahan" rows="3"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                placeholder="Opsional">{{ old('keterangan_tambahan') }}</textarea>
            @error('keterangan_tambahan')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        {{-- File --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Jika Memilih Izin Sakit lebih dari 1 hari, lampirkan surat dokter
            </label>
            <input type="file" name="documen_pendukung"
                class="w-full border rounded-lg px-3 py-2 text-sm">
            <small class="text-gray-500">
                PDF / JPG / PNG (maks. 2MB)
            </small>
            @error('documen_pendukung')
                <small class="text-red-500 block">{{ $message }}</small>
            @enderror
        </div>

        {{-- Kontak --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Nomor yang bisa dihubungi <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nomor_telepon"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                value="{{ old('nomor_telepon') }}"
                placeholder="08xxxxxxxxxx">
            @error('nomor_telepon')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        {{-- Alamat --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-1">
                Alamat Selama Izin <span class="text-red-500">*</span>
            </label>
            <textarea name="alamat" rows="2"
                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
            @error('alamat')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        {{-- Konfirmasi --}}
        <div class="mb-6 flex items-start gap-2">
            <input type="checkbox" name="konfirmasi" value="1"
                class="mt-1 text-blue-600 focus:ring-blue-500">
            <label class="text-sm text-gray-700">
                Saya menyatakan bahwa data yang saya isi adalah benar dan dapat dipertanggungjawabkan.
            </label>
        </div>

        {{-- Action --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('izin.index') }}"
               class="px-5 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                Batal
            </a>

            <button
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Kirim Pengajuan
            </button>
        </div>

    </form>
</div>
@endsection
