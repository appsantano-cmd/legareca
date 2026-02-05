<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Pengajuan Tukar Shift</title>
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
                        <i class="fas fa-exchange-alt text-blue-600"></i> Pengajuan Tukar Shift
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Pantau dan kelola semua pengajuan tukar shift
                    </p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold transition border border-gray-300 shadow-sm">
                        <i class="fas fa-arrow-left text-gray-600"></i>
                        Dashboard
                    </a>

                    <a href="{{ route('shifting.export') }}"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-md hover:shadow-lg">
                        <i class="fas fa-file-excel"></i>
                        Export Excel
                    </a>

                    <a href="{{ route('shifting.create') }}"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-md hover:shadow-lg">
                        <i class="fas fa-plus-circle"></i>
                        Ajukan Tukar Shift
                    </a>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Pengajuan</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $shiftings->count() ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-exchange-alt text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Pending</p>
                            <p class="text-2xl font-bold text-yellow-600 mt-1">
                                {{ $shiftings->where('status', 'pending')->count() ?? 0 }}
                            </p>
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
                            <p class="text-2xl font-bold text-green-600 mt-1">
                                {{ $shiftings->where('status', 'disetujui')->count() ?? 0 }}
                            </p>
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
                            <p class="text-2xl font-bold text-red-600 mt-1">
                                {{ $shiftings->where('status', 'ditolak')->count() ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Success/Error Messages --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-600"></i>
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-600"></i>
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="ml-auto text-red-700 hover:text-red-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                {{-- Toolbar --}}
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <h2 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-list mr-2 text-gray-600"></i> Daftar Pengajuan Tukar Shift
                        </h2>

                        <div class="flex gap-3">
                            <form method="GET" class="flex gap-3">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" name="search" placeholder="Cari nama karyawan..."
                                        value="{{ request('search') }}"
                                        class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                                </div>
                                
                                <select name="status"
                                    class="px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>

                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                    <i class="fas fa-filter"></i>
                                    Filter
                                </button>

                                <a href="{{ route('shifting.index') }}"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                                    <i class="fas fa-redo"></i>
                                    Reset
                                </a>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- DESKTOP TABLE --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full min-w-full">
                        <thead class="bg-gray-50 text-gray-700 text-sm">
                            <tr>
                                <th class="p-4 text-left font-semibold">ID</th>
                                <th class="p-4 text-left font-semibold">Nama Karyawan</th>
                                <th class="p-4 text-left font-semibold">Email</th>
                                <th class="p-4 text-left font-semibold">Shift Asli</th>
                                <th class="p-4 text-left font-semibold">Shift Tujuan</th>
                                <th class="p-4 text-left font-semibold">Status</th>
                                <th class="p-4 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($shiftings as $item)
                                @php
                                    $statusConfig = [
                                        'pending' => [
                                            'class' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                            'icon' => 'fas fa-clock',
                                        ],
                                        'disetujui' => [
                                            'class' => 'bg-green-100 text-green-800 border border-green-200',
                                            'icon' => 'fas fa-check-circle',
                                        ],
                                        'ditolak' => [
                                            'class' => 'bg-red-100 text-red-800 border border-red-200',
                                            'icon' => 'fas fa-times-circle',
                                        ],
                                    ];

                                    $config = $statusConfig[$item->status] ?? $statusConfig['pending'];
                                @endphp

                                <tr class="hover:bg-gray-50 transition" data-id="{{ $item->id }}">
                                    <td class="p-4">
                                        <span class="text-sm font-medium text-gray-700">#{{ $item->id }}</span>
                                    </td>
                                    
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $item->nama_karyawan }}</p>
                                                <p class="text-xs text-gray-500">{{ $item->divisi_jabatan }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        <span class="text-sm text-gray-600">
                                            {{ $item->user_email ?? 'Tidak ada email' }}
                                        </span>
                                    </td>

                                    <td class="p-4">
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">
                                                {{ \Carbon\Carbon::parse($item->tanggal_shift_asli)->translatedFormat('d M Y') }}
                                            </div>
                                            <div class="text-gray-500">
                                                {{ $item->jam_shift_asli }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">
                                                {{ \Carbon\Carbon::parse($item->tanggal_shift_tujuan)->translatedFormat('d M Y') }}
                                            </div>
                                            <div class="text-gray-500">
                                                {{ $item->jam_shift_tujuan }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold {{ $config['class'] }}">
                                            <i class="{{ $config['icon'] }}"></i> 
                                            {{ ucfirst($item->status) }}
                                        </span>
                                        @if($item->disetujui_oleh)
                                            <br>
                                            <small class="text-xs text-gray-500 mt-1 block">
                                                Oleh: {{ $item->disetujui_oleh }}
                                            </small>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        <div class="flex items-center gap-2">
                                            <button onclick="showDetailModal({{ $item->id }})"
                                                class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition"
                                                title="Detail">
                                                <i class="fas fa-info-circle"></i>
                                            </button>

                                            @if($item->status == 'pending')
                                                {{-- Tombol Setujui --}}
                                                <form action="{{ route('shifting.update-status', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="disetujui">
                                                    <button type="submit" 
                                                            onclick="return confirm('Setujui pengajuan tukar shift ini?')"
                                                            class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50 transition"
                                                            title="Setujui">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>

                                                {{-- Tombol Tolak --}}
                                                <button type="button" 
                                                        onclick="showRejectModal({{ $item->id }})"
                                                        class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition"
                                                        title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center">
                                        <div class="flex flex-col items-center justify-center py-8">
                                            <div class="w-24 h-24 text-gray-300 mb-4">
                                                <i class="fas fa-exchange-alt text-6xl"></i>
                                            </div>
                                            <p class="text-gray-500 text-lg font-medium mb-2">Belum ada pengajuan tukar shift</p>
                                            <p class="text-gray-400 text-sm mb-4">Mulai dengan membuat pengajuan tukar shift baru</p>
                                            <a href="{{ route('shifting.create') }}"
                                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition">
                                                <i class="fas fa-plus-circle"></i>
                                                Ajukan Tukar Shift Baru
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
                        @forelse ($shiftings as $item)
                            @php
                                $statusConfig = [
                                    'pending' => [
                                        'class' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                        'icon' => 'fas fa-clock',
                                    ],
                                    'disetujui' => [
                                        'class' => 'bg-green-100 text-green-800 border border-green-200',
                                        'icon' => 'fas fa-check-circle',
                                    ],
                                    'ditolak' => [
                                        'class' => 'bg-red-100 text-red-800 border border-red-200',
                                        'icon' => 'fas fa-times-circle',
                                    ],
                                ];

                                $config = $statusConfig[$item->status] ?? $statusConfig['pending'];
                            @endphp

                            <div class="mobile-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition"
                                data-id="{{ $item->id }}">
                                {{-- Header --}}
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $item->nama_karyawan }}</h3>
                                        <p class="text-sm text-gray-600">{{ $item->divisi_jabatan }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->user_email ?? '' }}</p>
                                    </div>

                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $config['class'] }}">
                                        <i class="{{ $config['icon'] }}"></i> {{ ucfirst($item->status) }}
                                    </span>
                                </div>

                                {{-- Details --}}
                                <div class="space-y-2 text-sm mb-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Shift Asli:</span>
                                        <span class="text-gray-800">
                                            {{ \Carbon\Carbon::parse($item->tanggal_shift_asli)->translatedFormat('d M') }}
                                            ({{ $item->jam_shift_asli }})
                                        </span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Shift Tujuan:</span>
                                        <span class="text-gray-800">
                                            {{ \Carbon\Carbon::parse($item->tanggal_shift_tujuan)->translatedFormat('d M Y') }}
                                            ({{ $item->jam_shift_tujuan }})
                                        </span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Alasan:</span>
                                        <span class="text-gray-800 truncate max-w-[150px]">
                                            {{ $item->alasan }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="pt-3 border-t flex justify-end gap-3">
                                    <button onclick="showDetailModal({{ $item->id }})"
                                        class="text-blue-600 hover:text-blue-800 p-1" title="Detail">
                                        <i class="fas fa-info-circle"></i>
                                    </button>

                                    @if($item->status == 'pending')
                                        {{-- Setujui Button Mobile --}}
                                        <form action="{{ route('shifting.update-status', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" 
                                                    onclick="return confirm('Setujui pengajuan tukar shift ini?')"
                                                    class="text-green-600 hover:text-green-800 p-1"
                                                    title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        {{-- Tolak Button Mobile --}}
                                        <button type="button" 
                                                onclick="showRejectModal({{ $item->id }})"
                                                class="text-red-600 hover:text-red-800 p-1"
                                                title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="w-16 h-16 mx-auto text-gray-300 mb-4">
                                    <i class="fas fa-exchange-alt text-5xl"></i>
                                </div>
                                <p class="text-gray-500 mb-2">Belum ada pengajuan tukar shift</p>
                                <a href="{{ route('shifting.create') }}"
                                    class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-plus-circle"></i>
                                    Ajukan Tukar Shift Baru
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Pagination --}}
                @if ($shiftings->hasPages())
                    <div class="p-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <p class="text-sm text-gray-700">
                                Menampilkan
                                <span class="font-medium">{{ $shiftings->firstItem() }}</span>
                                sampai
                                <span class="font-medium">{{ $shiftings->lastItem() }}</span>
                                dari
                                <span class="font-medium">{{ $shiftings->total() }}</span>
                                hasil
                            </p>

                            <div class="flex gap-2">
                                {{ $shiftings->links('pagination::tailwind') }}
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
                    <i class="fas fa-exchange-alt text-blue-600"></i> Detail Pengajuan Tukar Shift
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

    {{-- Reject Modal --}}
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden">
            <form id="rejectForm" method="POST">
                @csrf
                <input type="hidden" name="status" value="ditolak">
                
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-times-circle text-red-600"></i> Tolak Pengajuan Tukar Shift
                    </h3>
                </div>

                <div class="p-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Alasan Penolakan (Opsional)
                        </label>
                        <textarea name="catatan_admin" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                            placeholder="Berikan alasan penolakan (jika perlu)..."></textarea>
                    </div>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Status akan berubah menjadi "Ditolak" dan notifikasi email akan dikirim ke karyawan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Tolak Pengajuan
                    </button>
                </div>
            </form>
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

                // Fetch data dari server
                const response = await fetch(`/tukar-shift/${id}/detail`);
                const data = await response.json();

                document.getElementById('modalContent').innerHTML = `
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-user mr-2"></i>Nama Karyawan</p>
                        <p class="font-medium text-gray-800 mt-1">${data.nama_karyawan || '-'}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-envelope mr-2"></i>Email</p>
                        <p class="font-medium text-gray-800 mt-1">${data.user_email || '-'}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-briefcase mr-2"></i>Divisi/Jabatan</p>
                        <p class="font-medium text-gray-800 mt-1">${data.divisi_jabatan || '-'}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-info-circle mr-2"></i>Status</p>
                        <p class="font-medium text-gray-800 mt-1">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold ${getStatusClass(data.status)}">
                                ${getStatusIcon(data.status)} ${data.status ? data.status.charAt(0).toUpperCase() + data.status.slice(1) : 'Pending'}
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-calendar-day mr-2"></i>Shift Asli</p>
                        <p class="font-medium text-gray-800 mt-1">${formatDate(data.tanggal_shift_asli) || '-'}</p>
                        <p class="text-sm text-gray-600">${data.jam_shift_asli || ''}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-calendar-check mr-2"></i>Shift Tujuan</p>
                        <p class="font-medium text-gray-800 mt-1">${formatDate(data.tanggal_shift_tujuan) || '-'}</p>
                        <p class="text-sm text-gray-600">${data.jam_shift_tujuan || ''}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500"><i class="fas fa-comment mr-2"></i>Alasan Pengajuan</p>
                    <p class="font-medium text-gray-800 mt-1">${data.alasan || '-'}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-user-check mr-2"></i>Sudah Ada Pengganti</p>
                        <p class="font-medium text-gray-800 mt-1">${data.sudah_pengganti ? data.sudah_pengganti.charAt(0).toUpperCase() + data.sudah_pengganti.slice(1) : 'Tidak'}</p>
                    </div>
                    
                    ${data.sudah_pengganti === 'ya' ? `
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-user-friends mr-2"></i>Nama Pengganti</p>
                        <p class="font-medium text-gray-800 mt-1">${data.nama_karyawan_pengganti || '-'}</p>
                    </div>
                    ` : ''}
                </div>
                
                ${data.sudah_pengganti === 'ya' ? `
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-calendar mr-2"></i>Tanggal Shift Pengganti</p>
                        <p class="font-medium text-gray-800 mt-1">${formatDate(data.tanggal_shift_pengganti) || '-'}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-clock mr-2"></i>Jam Shift Pengganti</p>
                        <p class="font-medium text-gray-800 mt-1">${data.jam_shift_pengganti || '-'}</p>
                    </div>
                </div>
                ` : ''}
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-user-tie mr-2"></i>Disetujui Oleh</p>
                        <p class="font-medium text-gray-800 mt-1">${data.disetujui_oleh || '-'}</p>
                    </div>
                    
                    ${data.tanggal_persetujuan ? `
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500"><i class="fas fa-calendar-alt mr-2"></i>Tanggal Persetujuan</p>
                        <p class="font-medium text-gray-800 mt-1">${formatDateTime(data.tanggal_persetujuan)}</p>
                    </div>
                    ` : ''}
                </div>
                
                ${data.catatan_admin ? `
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500"><i class="fas fa-sticky-note mr-2"></i>Catatan Admin</p>
                    <p class="font-medium text-gray-800 mt-1">${data.catatan_admin}</p>
                </div>
                ` : ''}
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500"><i class="fas fa-clock mr-2"></i>Waktu Pengajuan</p>
                    <p class="font-medium text-gray-800 mt-1">${formatDateTime(data.created_at)}</p>
                </div>
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

        function showRejectModal(id) {
            const form = document.getElementById('rejectForm');
            form.action = `/tukar-shift/${id}/update-status`;
            document.getElementById('rejectModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Handle reject form submission
        document.getElementById('rejectForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                submitBtn.disabled = true;
            }
        });

        function formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function formatDateTime(dateTimeString) {
            if (!dateTimeString) return '';
            const date = new Date(dateTimeString);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function getStatusClass(status) {
            const classes = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'disetujui': 'bg-green-100 text-green-800',
                'ditolak': 'bg-red-100 text-red-800'
            };
            return classes[status] || 'bg-gray-100 text-gray-800';
        }

        function getStatusIcon(status) {
            const icons = {
                'pending': '<i class="fas fa-clock"></i>',
                'disetujui': '<i class="fas fa-check-circle"></i>',
                'ditolak': '<i class="fas fa-times-circle"></i>'
            };
            return icons[status] || '<i class="fas fa-question-circle"></i>';
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeRejectModal();
            }
        });

        // Close modal on background click
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) closeRejectModal();
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
        input:focus,
        select:focus,
        button:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</body>

</html>