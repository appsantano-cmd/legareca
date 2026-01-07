@extends('layouts.app')

@section('title', 'Ajukan Izin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Form Pengajuan Izin</h1>

<form method="POST" action="{{ route('izin.store') }}" enctype="multipart/form-data">
    @csrf

    {{-- Nama --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Nama</label>
        <input type="text" name="nama"
            class="w-full border px-3 py-2 rounded"
            value="{{ old('nama') }}">
        @error('nama')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    {{-- Divisi --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Jabatan / Divisi</label>
        <input type="text" name="divisi"
            class="w-full border px-3 py-2 rounded"
            value="{{ old('divisi') }}">
        @error('divisi')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    {{-- Jenis Izin --}}
    <div class="mb-4" x-data="{ selected: '' }">
        <label class="block font-semibold mb-2">Jenis Izin</label>

        {{-- RADIO --}}
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
                >
                <span>{{ $option }}</span>
            </label>
        @endforeach

        {{-- INPUT TAMBAHAN --}}
        <input
            x-show="selected === 'Lainnya'"
            x-transition
            type="text"
            name="jenis_izin_lainnya"
            placeholder="Tulis jenis izin lainnya..."
            class="w-full border px-3 py-2 rounded mt-2"
        >

        @error('jenis_izin')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    {{-- Tanggal Mulai --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Tanggal Mulai Izin</label>
        <input type="date" name="tanggal_mulai"
            class="w-full border px-3 py-2 rounded"
            value="{{ old('tanggal_mulai') }}">
        @error('tanggal_mulai')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    {{-- Tanggal Selesai --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Tanggal Selesai Izin</label>
        <input type="date" name="tanggal_selesai"
            class="w-full border px-3 py-2 rounded"
            value="{{ old('tanggal_selesai') }}">
        @error('tanggal_selesai')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    {{-- Jumlah Hari --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Jumlah Hari</label>
        <input type="number" name="jumlah_hari"
            class="w-full border px-3 py-2 rounded"
            value="{{ old('jumlah_hari') }}">
        @error('jumlah_hari')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    {{-- Keterangan --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Keterangan Tambahan</label>
        <input type="text" name="keterangan_tambahan"
            class="w-full border px-3 py-2 rounded"
            value="{{ old('keterangan_tambahan') }}">
        @error('keterangan_tambahan')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    {{-- File Pendukung --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">File Pendukung</label>
        <input type="file" name="documen_pendukung" class="w-full border px-3 py-2 rounded">
        @error('documen_pendukung')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    {{-- Telepon --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Nomor yang Bisa Dihubungi</label>
        <input type="text" name="nomor_telepon"
            class="w-full border px-3 py-2 rounded"
            value="{{ old('nomor_telepon') }}">
        @error('nomor_telepon')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    {{-- Alamat --}}
    <div class="mb-4">
        <label class="block font-semibold mb-1">Alamat Selama Izin</label>
        <input type="text" name="alamat"
            class="w-full border px-3 py-2 rounded"
            value="{{ old('alamat') }}">
        @error('alamat')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-4">
        <input type="checkbox" name="konfirmasi" value="1">
        <label>Saya menyatakan data benar</label>
    </div>

    <button class="bg-green-600 text-white px-6 py-2 rounded">
        Kirim
    </button>
</form>
@endsection
