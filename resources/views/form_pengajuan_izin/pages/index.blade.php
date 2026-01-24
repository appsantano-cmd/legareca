@extends('layouts.app')

@section('hide-navbar')
@endsection

@section('hide-footer')
@endsection

@section('title', 'Pengajuan Izin')

@section('content')
<div class="min-h-screen bg-gray-50 p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">📋 Pengajuan Izin</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Pantau dan kelola semua pengajuan izin Anda
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2.5 rounded-lg text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('izin.create') }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan Izin
                </a>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Pengajuan</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['pending'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Disetujui</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['approved'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Ditolak</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['rejected'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            {{-- Toolbar --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Daftar Pengajuan Izin
                    </h2>
                    
                    <form method="GET" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                        {{-- Search --}}
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   placeholder="Cari nama atau jenis izin..."
                                   value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        {{-- Date Filter --}}
                        <div class="flex gap-2">
                            <input type="date" 
                                   name="start_date" 
                                   value="{{ request('start_date') }}"
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="self-center text-gray-500">s/d</span>
                            <input type="date" 
                                   name="end_date" 
                                   value="{{ request('end_date') }}"
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        {{-- Status Filter --}}
                        <select name="status"
                                class="px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        
                        <div class="flex gap-2">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                            </button>
                            
                            <a href="{{ route('izin.index') }}"
                               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- DESKTOP TABLE --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-gray-700 text-sm">
                        <tr>
                            <th class="p-4 text-left font-semibold">Nama Karyawan</th>
                            <th class="p-4 text-left font-semibold">Tanggal</th>
                            <th class="p-4 text-left font-semibold">Jenis Izin</th>
                            <th class="p-4 text-left font-semibold">Durasi</th>
                            <th class="p-4 text-left font-semibold">Dokumen</th>
                            <th class="p-4 text-left font-semibold">Status</th>
                            <th class="p-4 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($izin as $item)
                            @php
                                $statusConfig = [
                                    'Pending' => [
                                        'class' => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
                                        'icon' => '⏳'
                                    ],
                                    'Disetujui' => [
                                        'class' => 'bg-green-50 text-green-700 border border-green-200',
                                        'icon' => '✅'
                                    ],
                                    'Ditolak' => [
                                        'class' => 'bg-red-50 text-red-700 border border-red-200',
                                        'icon' => '❌'
                                    ]
                                ];
                                
                                $config = $statusConfig[$item->status] ?? $statusConfig['Pending'];
                            @endphp
                            
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $item->nama }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->divisi }}</p>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="p-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-700">
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                        </div>
                                        <div class="text-gray-500">
                                            s/d {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="p-4">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ $item->jenis_izin }}
                                    </span>
                                </td>
                                
                                <td class="p-4">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $item->jumlah_hari }} hari
                                    </span>
                                </td>
                                
                                <td class="p-4">
                                    @if ($item->documen_pendukung)
                                        <a href="{{ Storage::url($item->documen_pendukung) }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                
                                <td class="p-4">
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold {{ $config['class'] }}">
                                        {{ $config['icon'] }} {{ $item->status }}
                                    </span>
                                </td>
                                
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <button onclick="showDetailModal({{ $item->id }})"
                                                class="text-gray-600 hover:text-gray-800 p-2 rounded-lg hover:bg-gray-100 transition"
                                                title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </button>
                                        
                                        @if($item->status == 'Pending')
                                        <a href="#"
                                           class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        @endif
                                        
                                        <form action="#" 
                                              method="POST" 
                                              onsubmit="return confirm('Hapus pengajuan ini?')"
                                              class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition"
                                                    title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <div class="w-24 h-24 text-gray-300 mb-4">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" 
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 text-lg font-medium mb-2">Belum ada pengajuan izin</p>
                                        <p class="text-gray-400 text-sm mb-4">Mulai dengan membuat pengajuan izin baru</p>
                                        <a href="{{ route('izin.create') }}"
                                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Ajukan Izin Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- MOBILE CARD VIEW --}}
            <div class="md:hidden p-4">
                <div class="space-y-4">
                    @forelse ($izin as $item)
                        @php
                            $statusConfig = [
                                'Pending' => [
                                    'class' => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
                                    'icon' => '⏳'
                                ],
                                'Disetujui' => [
                                    'class' => 'bg-green-50 text-green-700 border border-green-200',
                                    'icon' => '✅'
                                ],
                                'Ditolak' => [
                                    'class' => 'bg-red-50 text-red-700 border border-red-200',
                                    'icon' => '❌'
                                ]
                            ];
                            
                            $config = $statusConfig[$item->status] ?? $statusConfig['Pending'];
                        @endphp
                        
                        <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                            {{-- Header --}}
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $item->nama }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item->divisi }}</p>
                                </div>
                                
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $config['class'] }}">
                                    {{ $config['icon'] }} {{ $item->status }}
                                </span>
                            </div>

                            {{-- Details --}}
                            <div class="space-y-2 text-sm mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Jenis Izin:</span>
                                    <span class="font-medium text-gray-800">{{ $item->jenis_izin }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tanggal:</span>
                                    <span class="text-gray-800">
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} 
                                        - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                    </span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Durasi:</span>
                                    <span class="inline-flex items-center gap-1 text-blue-600 font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $item->jumlah_hari }} hari
                                    </span>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="pt-3 border-t flex justify-between items-center">
                                <div>
                                    @if ($item->documen_pendukung)
                                        <a href="{{ Storage::url($item->documen_pendukung) }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-1 text-blue-600 text-sm hover:underline">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat Dokumen
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Tidak ada dokumen</span>
                                    @endif
                                </div>
                                
                                <div class="flex gap-2">
                                    <button onclick="showDetailModal({{ $item->id }})"
                                            class="text-gray-600 hover:text-gray-800 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                    
                                    @if($item->status == 'Pending')
                                    <a href="#"
                                       class="text-blue-600 hover:text-blue-800 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @endif
                                    
                                    <form action="#" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus pengajuan ini?')"
                                          class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-16 h-16 mx-auto text-gray-300 mb-4">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" 
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 mb-2">Belum ada pengajuan izin</p>
                            <a href="{{ route('izin.create') }}"
                               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 4v16m8-8H4"/>
                                </svg>
                                Ajukan Izin Baru
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Pagination --}}
            @if ($izin->hasPages())
            <div class="p-6 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <p class="text-sm text-gray-700">
                        Menampilkan 
                        <span class="font-medium">{{ $izin->firstItem() }}</span>
                        sampai 
                        <span class="font-medium">{{ $izin->lastItem() }}</span>
                        dari 
                        <span class="font-medium">{{ $izin->total() }}</span>
                        hasil
                    </p>
                    
                    <div class="flex gap-2">
                        {{ $izin->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Detail Modal --}}
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Detail Pengajuan Izin</h3>
                <button onclick="closeModal()" 
                        class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="p-6 overflow-y-auto max-h-[60vh]">
            <div id="modalContent" class="space-y-4">
                {{-- Content akan diisi via JavaScript --}}
            </div>
        </div>
        
        <div class="p-6 border-t border-gray-200">
            <button onclick="closeModal()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function showDetailModal(id) {
    // Simulasi data (dalam real case, ini akan fetch dari API)
    // Ambil data dari row yang ada atau fetch dari server
    const row = document.querySelector(`tr[data-id="${id}"]`) || 
                document.querySelector(`.mobile-card[data-id="${id}"]`);
    
    if (row) {
        // Contoh data statis, sesuaikan dengan struktur data Anda
        const data = {
            nama: row.querySelector('.nama').innerText,
            divisi: row.querySelector('.divisi').innerText,
            jenis_izin: row.querySelector('.jenis-izin').innerText,
            tanggal_mulai: row.querySelector('.tanggal-mulai').innerText,
            tanggal_selesai: row.querySelector('.tanggal-selesai').innerText,
            jumlah_hari: row.querySelector('.jumlah-hari').innerText,
            alamat: 'Alamat akan diisi dari database',
            nomor_telepon: '0812-3456-7890',
            keterangan_tambahan: 'Tidak ada keterangan tambahan',
            status: row.querySelector('.status').innerText
        };
        
        document.getElementById('modalContent').innerHTML = `
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                        <p class="font-medium text-gray-800">${data.nama}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Divisi/Jabatan</p>
                        <p class="font-medium text-gray-800">${data.divisi}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Jenis Izin</p>
                        <p class="font-medium text-gray-800">${data.jenis_izin}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Durasi</p>
                        <p class="font-medium text-gray-800">${data.jumlah_hari}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Tanggal Mulai</p>
                        <p class="font-medium text-gray-800">${data.tanggal_mulai}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Tanggal Selesai</p>
                        <p class="font-medium text-gray-800">${data.tanggal_selesai}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Nomor Telepon</p>
                    <p class="font-medium text-gray-800">${data.nomor_telepon}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Alamat Selama Izin</p>
                    <p class="font-medium text-gray-800">${data.alamat}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Keterangan Tambahan</p>
                    <p class="font-medium text-gray-800">${data.keterangan_tambahan}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-medium text-gray-800">${data.status}</p>
                </div>
            </div>
        `;
        
        document.getElementById('detailModal').classList.remove('hidden');
    }
}

function closeModal() {
    document.getElementById('detailModal').classList.add('hidden');
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});

// Close modal on background click
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

<style>
/* Custom pagination styling */
.pagination {
    display: flex;
    gap: 0.5rem;
}

.pagination .page-item .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #4b5563;
    background: white;
    border: 1px solid #e5e7eb;
    transition: all 0.2s;
}

.pagination .page-item.active .page-link {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.pagination .page-item:not(.active) .page-link:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}

.pagination .page-item.disabled .page-link {
    color: #9ca3af;
    background: #f9fafb;
    cursor: not-allowed;
}
</style>
@endsection