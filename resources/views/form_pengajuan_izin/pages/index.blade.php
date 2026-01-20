@extends('layouts.app')

@section('hide-footer')
@endsection

@section('title', 'Pengajuan Izin')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengajuan Izin</h1>
            <p class="text-sm text-gray-500">
                Daftar dan pantau pengajuan izin Anda
            </p>
        </div>

        <a href="{{ route('izin.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>
            Ajukan Izin
        </a>
    </div>

    {{-- Alert --}}
    <x-alert />

    {{-- Filter Status --}}
    <form method="GET" class="mb-4">
        <div class="flex flex-col sm:flex-row gap-3 sm:items-center">
            <select name="status"
                class="w-full sm:w-48 border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Status</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>

            <button
                class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm">
                Filter
            </button>
        </div>
    </form>

    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Jenis Izin</th>
                    <th class="p-3 text-left">Bukti</th>
                    <th class="p-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($izin as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 font-medium">
                            {{ $item->nama }}
                        </td>

                        <td class="p-3">
                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                        </td>

                        <td class="p-3">
                            {{ $item->jenis_izin }}
                        </td>

                        <td class="p-3">
                            @if ($item->documen_pendukung)
                                <a href="{{ Storage::url($item->documen_pendukung) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline">
                                    Lihat
                                </a>
                            @else
                                <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>

                        <td class="p-3">
                            @php
                                $statusClass = match($item->status) {
                                    'Disetujui' => 'bg-green-100 text-green-700',
                                    'Ditolak' => 'bg-red-100 text-red-700',
                                    default => 'bg-yellow-100 text-yellow-700',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-6 text-gray-500">
                            Belum ada data pengajuan izin
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-4">
        @forelse ($izin as $item)
            <div class="border rounded-xl p-4 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-semibold text-gray-800">
                        {{ $item->nama }}
                    </h3>

                    <span class="text-xs px-3 py-1 rounded-full
                        {{ $item->status == 'Disetujui' ? 'bg-green-100 text-green-700' :
                           ($item->status == 'Ditolak' ? 'bg-red-100 text-red-700' :
                           'bg-yellow-100 text-yellow-700') }}">
                        {{ $item->status }}
                    </span>
                </div>

                <p class="text-sm text-gray-600">
                    {{ $item->jenis_izin }}
                </p>

                <p class="text-sm text-gray-500 mt-1">
                    {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                    -
                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                </p>

                <div class="mt-3">
                    @if ($item->documen_pendukung)
                        <a href="{{ Storage::url($item->documen_pendukung) }}"
                           class="text-blue-600 text-sm">
                            Lihat Dokumen
                        </a>
                    @else
                        <span class="text-sm text-gray-400">
                            Tidak ada dokumen
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">
                Belum ada data pengajuan izin
            </p>
        @endforelse
    </div>

</div>

<div>
    <a href="{{ route('dashboard') }}"
        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition">
        Kembali
    </a>
</div>
@endsection
