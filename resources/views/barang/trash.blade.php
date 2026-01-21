<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Terhapus - Inventory System</title>
    
    <!-- Tailwind CSS dengan custom config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        'primary-dark': '#2563eb',
                        success: '#10b981',
                        'success-dark': '#059669',
                        danger: '#ef4444',
                        'danger-dark': '#dc2626',
                        warning: '#f59e0b',
                        'warning-dark': '#d97706',
                        info: '#06b6d4',
                        dark: '#1f2937',
                        light: '#f9fafb',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                        'medium': '0 10px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                        'hard': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
        }
        
        /* Animation untuk notifikasi */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .notification-slide-in {
            animation: slideInRight 0.3s ease forwards;
        }
        
        .notification-slide-out {
            animation: slideOutRight 0.3s ease forwards;
        }
        
        .table-row-hover:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }
        
        .btn-action {
            transition: all 0.2s ease;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        
        .spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 3px solid white;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-4 right-4 z-50 w-full max-w-sm space-y-3"></div>
    
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-lg rounded-xl mx-4 lg:mx-8 mt-4 mb-6 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start gap-3 mb-2">
                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-3 rounded-xl shadow-md">
                            <i class="fas fa-trash-restore text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-dark">Data Barang Terhapus</h1>
                            <p class="text-gray-600 mt-1">Manajemen data barang yang telah dihapus</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-end">
                    <a href="{{ route('barang.index') }}" 
                       class="bg-gradient-to-r from-primary to-primary-dark text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 btn-action">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Data Barang</span>
                    </a>
                    
                    @if($trashedItems->count() > 0)
                    <button onclick="restoreAll()" 
                           class="bg-gradient-to-r from-success to-success-dark text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 btn-action">
                        <i class="fas fa-undo"></i>
                        <span>Restore Semua</span>
                    </button>
                    
                    <button onclick="emptyTrash()" 
                           class="bg-gradient-to-r from-danger to-danger-dark text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 btn-action">
                        <i class="fas fa-trash"></i>
                        <span>Kosongkan Trash</span>
                    </button>
                    @endif
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <div class="mx-4 lg:mx-8 mb-8">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-3 rounded-lg">
                            <i class="fas fa-trash text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Total Data Terhapus</p>
                            <p class="text-2xl font-bold text-dark">{{ $trashedItems->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 p-3 rounded-lg">
                            <i class="fas fa-history text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Terhapus Terlama</p>
                            <p class="text-sm font-medium text-dark">
                                @if($trashedItems->count() > 0)
                                {{ $trashedItems->last()->deleted_at->diffForHumans() }}
                                @else
                                -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-3 rounded-lg">
                            <i class="fas fa-info-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Status Trash</p>
                            <p class="text-sm font-medium text-dark">
                                @if($trashedItems->count() > 0)
                                <span class="text-amber-600">Ada data terhapus</span>
                                @else
                                <span class="text-green-600">Kosong</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Data Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-white p-3 rounded-xl shadow-md">
                                <i class="fas fa-trash-alt text-amber-600 text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Daftar Barang Terhapus</h2>
                                <p class="text-amber-100 text-sm">Data barang yang telah dihapus sementara (soft delete)</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 px-4 py-2 rounded-lg">
                                <span class="text-white text-sm">Total {{ $trashedItems->count() }} data</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($trashedItems->count() > 0)
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Kode
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Nama Barang
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Satuan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Stok Terakhir
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Dihapus Pada
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($trashedItems as $item)
                                <tr class="table-row-hover hover:bg-amber-50 transition-all">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->kode_barang }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->nama_barang }}</div>
                                        @if($item->keterangan)
                                        <div class="text-xs text-gray-500 mt-1">{{ Str::limit($item->keterangan, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col gap-1">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $item->satuan_utama }}
                                            </span>
                                            @if($item->satuan_alternatif)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $item->satuan_alternatif }}
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ number_format($item->stok_sekarang, 2) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $item->deleted_at->format('d/m/Y H:i') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $item->deleted_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <button onclick="restoreData({{ $item->id }})" 
                                                    class="bg-gradient-to-r from-success to-success-dark text-white p-2 rounded-lg hover:shadow-md transition-all btn-action"
                                                    title="Restore">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                            <button onclick="forceDelete({{ $item->id }})" 
                                                    class="bg-gradient-to-r from-danger to-danger-dark text-white p-2 rounded-lg hover:shadow-md transition-all btn-action"
                                                    title="Hapus Permanen">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Info Footer -->
                    <div class="mt-6 p-4 bg-amber-50 rounded-lg border border-amber-200">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-info-circle text-amber-600"></i>
                            <div>
                                <p class="text-sm text-amber-800">
                                    <strong>Informasi:</strong> Data di halaman ini adalah data yang telah dihapus sementara (soft delete). 
                                    Data dapat dikembalikan (restore) atau dihapus permanen (force delete).
                                </p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="inline-block p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-full mb-6">
                            <i class="fas fa-trash-alt text-gray-400 text-5xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Trash Kosong</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Tidak ada data barang yang terhapus. Data yang dihapus akan muncul di halaman ini.
                        </p>
                        <a href="{{ route('barang.index') }}" 
                           class="bg-gradient-to-r from-primary to-primary-dark text-white font-semibold py-4 px-8 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 mx-auto max-w-sm btn-action">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Data Barang</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const csrfToken = '{{ csrf_token() }}';
        const baseUrl = '{{ url('/') }}';
        
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notificationContainer');
            const notificationId = 'notification-' + Date.now();
            
            const typeStyles = {
                success: 'bg-gradient-to-r from-success to-success-dark border-l-4 border-success-dark',
                error: 'bg-gradient-to-r from-danger to-danger-dark border-l-4 border-danger-dark',
                warning: 'bg-gradient-to-r from-warning to-warning-dark border-l-4 border-warning-dark',
                info: 'bg-gradient-to-r from-primary to-primary-dark border-l-4 border-primary-dark'
            };
            
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            
            const notification = document.createElement('div');
            notification.id = notificationId;
            notification.className = `${typeStyles[type]} text-white rounded-r-lg shadow-hard p-4 notification-slide-in`;
            notification.innerHTML = `
                <div class="flex items-start">
                    <i class="fas ${icons[type]} text-xl mr-3 mt-0.5"></i>
                    <div class="flex-1">
                        <p class="font-medium">${message}</p>
                    </div>
                    <button onclick="removeNotification('${notificationId}')" class="ml-3 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            container.appendChild(notification);
            
            setTimeout(() => {
                removeNotification(notificationId);
            }, 5000);
        }
        
        function removeNotification(id) {
            const notification = document.getElementById(id);
            if (notification) {
                notification.classList.remove('notification-slide-in');
                notification.classList.add('notification-slide-out');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }
        }
        
        async function restoreData(id) {
            if (!confirm('Apakah Anda yakin ingin mengembalikan data ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`${baseUrl}/barang/${id}/restore`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(result.message, 'success');
                    
                    // Refresh page after delay
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            }
        }
        
        async function forceDelete(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini secara permanen? Tindakan ini tidak dapat dibatalkan!')) {
                return;
            }
            
            try {
                const response = await fetch(`${baseUrl}/barang/${id}/force-delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(result.message, 'success');
                    
                    // Refresh page after delay
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            }
        }
        
        async function restoreAll() {
            if (!confirm('Apakah Anda yakin ingin mengembalikan semua data yang terhapus?')) {
                return;
            }
            
            try {
                const response = await fetch(`${baseUrl}/barang/restore-all`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(result.message, 'success');
                    
                    // Redirect to main page after delay
                    setTimeout(() => {
                        window.location.href = `${baseUrl}/barang`;
                    }, 1500);
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            }
        }
        
        async function emptyTrash() {
            if (!confirm('Apakah Anda yakin ingin mengosongkan trash? Semua data akan dihapus permanen dan tidak dapat dikembalikan!')) {
                return;
            }
            
            try {
                const response = await fetch(`${baseUrl}/barang/empty-trash`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(result.message, 'success');
                    
                    // Refresh page after delay
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            }
        }
    </script>
</body>
</html>