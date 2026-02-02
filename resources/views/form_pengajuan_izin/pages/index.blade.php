<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pengajuan Izin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
<div class="min-h-screen p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-clipboard-list text-blue-600"></i> Pengajuan Izin
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Pantau dan kelola semua pengajuan izin Anda
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold transition border border-gray-300 shadow-sm">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('izin.create') }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-md hover:shadow-lg">
                    <i class="fas fa-plus-circle"></i>
                    Ajukan Izin
                </a>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Pengajuan</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['pending'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Disetujui</p>
                        <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['approved'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Ditolak</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['rejected'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
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
                        <i class="fas fa-list mr-2 text-gray-600"></i> Daftar Pengajuan Izin
                    </h2>
                    
                    <form method="GET" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                        {{-- Search --}}
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   placeholder="Cari nama atau jenis izin..."
                                   value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        </div>
                        
                        {{-- Date Filter --}}
                        <div class="flex gap-2">
                            <input type="date" 
                                   name="start_date" 
                                   value="{{ request('start_date') }}"
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <span class="self-center text-gray-500">s/d</span>
                            <input type="date" 
                                   name="end_date" 
                                   value="{{ request('end_date') }}"
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        </div>
                        
                        {{-- Status Filter --}}
                        <select name="status"
                                class="px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="">Semua Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        
                        <div class="flex gap-2">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                <i class="fas fa-filter"></i>
                                Filter
                            </button>
                            
                            <a href="{{ route('izin.index') }}"
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                <i class="fas fa-redo"></i>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- DESKTOP TABLE --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full min-w-full">
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
                                        'class' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                        'icon' => 'fas fa-clock'
                                    ],
                                    'Disetujui' => [
                                        'class' => 'bg-green-100 text-green-800 border border-green-200',
                                        'icon' => 'fas fa-check-circle'
                                    ],
                                    'Ditolak' => [
                                        'class' => 'bg-red-100 text-red-800 border border-red-200',
                                        'icon' => 'fas fa-times-circle'
                                    ]
                                ];
                                
                                $config = $statusConfig[$item->status] ?? $statusConfig['Pending'];
                            @endphp
                            
                            <tr class="hover:bg-gray-50 transition" data-id="{{ $item->id }}">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800 nama">{{ $item->nama }}</p>
                                            <p class="text-xs text-gray-500 divisi">{{ $item->divisi }}</p>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="p-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-700 tanggal-mulai">
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}
                                        </div>
                                        <div class="text-gray-500">
                                            s/d <span class="tanggal-selesai">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="p-4">
                                    <span class="text-sm font-medium text-gray-700 jenis-izin">
                                        {{ $item->jenis_izin }}
                                    </span>
                                </td>
                                
                                <td class="p-4">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-medium">
                                        <i class="fas fa-clock"></i>
                                        <span class="jumlah-hari">{{ $item->jumlah_hari }}</span> hari
                                    </span>
                                </td>
                                
                                <td class="p-4">
                                    @if ($item->documen_pendukung)
                                        <a href="{{ Storage::url($item->documen_pendukung) }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <i class="fas fa-eye"></i>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                
                                <td class="p-4">
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold {{ $config['class'] }} status">
                                        <i class="{{ $config['icon'] }}"></i> {{ $item->status }}
                                    </span>
                                </td>
                                
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <button onclick="showDetailModal({{ $item->id }})"
                                                class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition"
                                                title="Detail">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        
                                        @if($item->status == 'Pending')
                                        <a href="#"
                                           class="text-yellow-600 hover:text-yellow-800 p-2 rounded-lg hover:bg-yellow-50 transition"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif
                                        
                                        <form action="#" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')"
                                              class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition"
                                                    title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
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
                                            <i class="fas fa-file-alt text-6xl"></i>
                                        </div>
                                        <p class="text-gray-500 text-lg font-medium mb-2">Belum ada pengajuan izin</p>
                                        <p class="text-gray-400 text-sm mb-4">Mulai dengan membuat pengajuan izin baru</p>
                                        <a href="{{ route('izin.create') }}"
                                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition">
                                            <i class="fas fa-plus-circle"></i>
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
                                    'class' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                    'icon' => 'fas fa-clock'
                                ],
                                'Disetujui' => [
                                    'class' => 'bg-green-100 text-green-800 border border-green-200',
                                    'icon' => 'fas fa-check-circle'
                                ],
                                'Ditolak' => [
                                    'class' => 'bg-red-100 text-red-800 border border-red-200',
                                    'icon' => 'fas fa-times-circle'
                                ]
                            ];
                            
                            $config = $statusConfig[$item->status] ?? $statusConfig['Pending'];
                        @endphp
                        
                        <div class="mobile-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition" data-id="{{ $item->id }}">
                            {{-- Header --}}
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-gray-800 nama">{{ $item->nama }}</h3>
                                    <p class="text-sm text-gray-600 divisi">{{ $item->divisi }}</p>
                                </div>
                                
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $config['class'] }} status">
                                    <i class="{{ $config['icon'] }}"></i> {{ $item->status }}
                                </span>
                            </div>

                            {{-- Details --}}
                            <div class="space-y-2 text-sm mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Jenis Izin:</span>
                                    <span class="font-medium text-gray-800 jenis-izin">{{ $item->jenis_izin }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tanggal:</span>
                                    <span class="text-gray-800">
                                        <span class="tanggal-mulai">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M') }}</span> 
                                        - <span class="tanggal-selesai">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}</span>
                                    </span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Durasi:</span>
                                    <span class="inline-flex items-center gap-1 text-blue-600 font-medium">
                                        <i class="fas fa-clock"></i>
                                        <span class="jumlah-hari">{{ $item->jumlah_hari }}</span> hari
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
                                            <i class="fas fa-eye"></i>
                                            Lihat Dokumen
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Tidak ada dokumen</span>
                                    @endif
                                </div>
                                
                                <div class="flex gap-3">
                                    <button onclick="showDetailModal({{ $item->id }})"
                                            class="text-blue-600 hover:text-blue-800 p-1" title="Detail">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    
                                    @if($item->status == 'Pending')
                                    <a href="#"
                                       class="text-yellow-600 hover:text-yellow-800 p-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    
                                    <form action="#" 
                                          method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')"
                                          class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 p-1" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-16 h-16 mx-auto text-gray-300 mb-4">
                                <i class="fas fa-file-alt text-5xl"></i>
                            </div>
                            <p class="text-gray-500 mb-2">Belum ada pengajuan izin</p>
                            <a href="{{ route('izin.create') }}"
                               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <i class="fas fa-plus-circle"></i>
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
                        {{ $izin->links('pagination::tailwind') }}
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
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-file-alt text-blue-600"></i> Detail Pengajuan Izin
            </h3>
            <button onclick="closeModal()" 
                    class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
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
async function showDetailModal(id) {
    try {
        // Tampilkan loading state
        document.getElementById('modalContent').innerHTML = `
            <div class="flex justify-center items-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            </div>
        `;
        
        // Fetch data dari server (gantilah URL sesuai dengan route Anda)
        const response = await fetch(`/izin/${id}/detail`);
        const data = await response.json();
        
        document.getElementById('modalContent').innerHTML = `
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-user mr-2"></i>Nama Lengkap</p>
                        <p class="font-medium text-gray-800 mt-1">${data.nama || '-'}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-briefcase mr-2"></i>Divisi/Jabatan</p>
                        <p class="font-medium text-gray-800 mt-1">${data.divisi || '-'}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-tag mr-2"></i>Jenis Izin</p>
                        <p class="font-medium text-gray-800 mt-1">${data.jenis_izin || '-'}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-clock mr-2"></i>Durasi</p>
                        <p class="font-medium text-gray-800 mt-1">${data.jumlah_hari || '0'} hari</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-calendar-start mr-2"></i>Tanggal Mulai</p>
                        <p class="font-medium text-gray-800 mt-1">${formatDate(data.tanggal_mulai) || '-'}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-calendar-check mr-2"></i>Tanggal Selesai</p>
                        <p class="font-medium text-gray-800 mt-1">${formatDate(data.tanggal_selesai) || '-'}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500"><i class="fas fa-phone mr-2"></i>Nomor Telepon</p>
                    <p class="font-medium text-gray-800 mt-1">${data.nomor_telepon || '-'}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500"><i class="fas fa-map-marker-alt mr-2"></i>Alamat Selama Izin</p>
                    <p class="font-medium text-gray-800 mt-1">${data.alamat || '-'}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500"><i class="fas fa-sticky-note mr-2"></i>Keterangan Tambahan</p>
                    <p class="font-medium text-gray-800 mt-1">${data.keterangan || 'Tidak ada keterangan'}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500"><i class="fas fa-info-circle mr-2"></i>Status</p>
                    <p class="font-medium text-gray-800 mt-1">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold ${getStatusClass(data.status)}">
                            ${getStatusIcon(data.status)} ${data.status || 'Pending'}
                        </span>
                    </p>
                </div>
                
                ${data.documen_pendukung ? `
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 mb-2"><i class="fas fa-file-pdf mr-2"></i>Dokumen Pendukung</p>
                    <a href="${data.documen_pendukung}" 
                       target="_blank"
                       class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">
                        <i class="fas fa-external-link-alt"></i> Buka Dokumen
                    </a>
                </div>
                ` : ''}
            </div>
        `;
        
        document.getElementById('detailModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    } catch (error) {
        console.error('Error fetching data:', error);
        document.getElementById('modalContent').innerHTML = `
            <div class="text-center py-8 text-red-600">
                <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                <p class="font-medium">Gagal memuat data</p>
                <p class="text-sm text-gray-600 mt-2">Silakan coba lagi nanti</p>
            </div>
        `;
    }
}

function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}

function getStatusClass(status) {
    const classes = {
        'Pending': 'bg-yellow-100 text-yellow-800',
        'Disetujui': 'bg-green-100 text-green-800',
        'Ditolak': 'bg-red-100 text-red-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
}

function getStatusIcon(status) {
    const icons = {
        'Pending': '<i class="fas fa-clock"></i>',
        'Disetujui': '<i class="fas fa-check-circle"></i>',
        'Ditolak': '<i class="fas fa-times-circle"></i>'
    };
    return icons[status] || '<i class="fas fa-question-circle"></i>';
}

function closeModal() {
    document.getElementById('detailModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});

// Close modal on background click
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

// Form submission handling
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            submitBtn.disabled = true;
        }
    });
});
</script>

<style>
/* Custom scrollbar for modal */
#detailModal .overflow-y-auto {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 #f1f1f1;
}

#detailModal .overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

#detailModal .overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#detailModal .overflow-y-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

#detailModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Smooth transitions */
* {
    transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
}

/* Focus styles */
input:focus, select:focus, button:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
</style>
</body>
</html>