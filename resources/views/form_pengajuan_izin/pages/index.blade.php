@extends('layouts.app')

@section('title', 'Pengajuan Izin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Pengajuan Izin</h1>

<x-alert />

<a href="{{ route('izin.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded">
    + Ajukan Izin
</a>

<table class="w-full mt-4 border">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-2">Nama</th>
            <th class="p-2">Tanggal Mulai</th>
            <th class="p-2">Tanggal Selesai</th>
            <th class="p-2">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($izin as $item)
            <tr>
                <td class="p-2">{{ $item->nama }}</td>
                <td class="p-2">{{ $item->tanggal_mulai }}</td>
                <td class="p-2">{{ $item->tanggal_selesai }}</td>
                <td class="p-2">{{ $item->status }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center p-4 text-gray-500">
                    Belum ada data
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
