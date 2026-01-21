<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Keluar Gudang - Inventory System</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        'primary-dark': '#2563eb',
                        success: '#10b981',
                        danger: '#ef4444',
                        warning: '#f59e0b',
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-lg rounded-xl mx-4 lg:mx-8 mt-4 mb-6 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start gap-3 mb-2">
                        <div class="bg-gradient-to-r from-danger to-red-600 p-3 rounded-xl shadow-md">
                            <i class="fas fa-sign-out-alt text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Form Pengambilan Barang Gudang</h1>
                            <p class="text-gray-600 mt-1">Manajemen pengeluaran barang inventori</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-end">
                    <a href="{{ route('barang-keluar.create') }}" 
                       class="bg-gradient-to-r from-success to-green-600 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>Tambah Barang Keluar</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="mx-4 lg:mx-8 mb-8">
            <!-- Filter Section -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Data</h3>
                <form action="{{ route('barang-keluar.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                               placeholder="Nama Barang / Penerima / Keperluan">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                        <select name="department" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="">Semua Department</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                                {{ $dept }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    </div>
                    
                    <div class="md:col-span-4 flex justify-end space-x-3">
                        <button type="submit" 
                                class="bg-gradient-to-r from-primary to-primary-dark text-white font-semibold py-2 px-6 rounded-lg hover:shadow-md transition-all">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                        <a href="{{ route('barang-keluar.index') }}" 
                           class="bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg hover:bg-gray-300 transition-all">
                            <i class="fas fa-redo mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-danger to-red-600 p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-white p-3 rounded-xl shadow-md">
                                <i class="fas fa-list text-danger text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Daftar Barang Keluar</h2>
                                <p class="text-red-100 text-sm">Riwayat pengeluaran barang dari inventori</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 px-4 py-2 rounded-lg">
                                <span class="text-white text-sm">Total {{ $barangKeluars->total() }} data</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($barangKeluars->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Department</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Penerima</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($barangKeluars as $index => $item)
                                <tr class="hover:bg-red-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $loop->iteration + ($barangKeluars->currentPage() - 1) * $barangKeluars->perPage() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->tanggal_keluar->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                            {{ $item->department == 'Kitchen' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($item->department == 'Bar' ? 'bg-blue-100 text-blue-800' : 
                                               ($item->department == 'Pastry' ? 'bg-pink-100 text-pink-800' : 
                                               'bg-gray-100 text-gray-800')) }}">
                                            {{ $item->department }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->barang->nama_barang ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->barang->kode_barang ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ number_format($item->jumlah_keluar, 2) }} {{ $item->satuan->satuan_input ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $item->nama_penerima }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">{{ $item->keperluan }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('barang-keluar.show', $item->id) }}" 
                                               class="bg-blue-100 text-blue-600 p-2 rounded-lg hover:bg-blue-200 transition-colors"
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('barang-keluar.edit', $item->id) }}" 
                                               class="bg-green-100 text-green-600 p-2 rounded-lg hover:bg-green-200 transition-colors"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="deleteData({{ $item->id }})" 
                                                    class="bg-red-100 text-red-600 p-2 rounded-lg hover:bg-red-200 transition-colors"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $barangKeluars->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600">Belum ada data barang keluar</h3>
                        <p class="text-gray-500 mt-2">Mulai dengan menambahkan data barang keluar pertama</p>
                        <a href="{{ route('barang-keluar.create') }}" 
                           class="inline-block mt-4 bg-gradient-to-r from-success to-green-600 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all">
                            <i class="fas fa-plus-circle mr-2"></i>Tambah Data Barang Keluar
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';
        const baseUrl = '{{ url("/") }}';

        function deleteData(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini? Stok akan dikembalikan.')) {
                fetch(`${baseUrl}/barang-keluar/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus data');
                });
            }
        }

        // Alert untuk session messages
        @if(session('success'))
        alert('{{ session('success') }}');
        @endif

        @if(session('error'))
        alert('{{ session('error') }}');
        @endif
    </script>
</body>
</html>