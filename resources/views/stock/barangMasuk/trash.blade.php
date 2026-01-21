<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash - Stok Masuk Gudang</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
        }
        
        /* Animations */
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        
        .notification-slide-in {
            animation: slideInRight 0.3s ease forwards;
        }
        
        .notification-slide-out {
            animation: slideOutRight 0.3s ease forwards;
        }
        
        /* Table responsive */
        @media (max-width: 768px) {
            .mobile-stack {
                flex-direction: column !important;
            }
            
            .mobile-full {
                width: 100% !important;
            }
            
            .mobile-text-center {
                text-align: center !important;
            }
            
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
        
        /* Card hover effect */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Loading spinner */
        .spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 3px solid white;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
    <!-- Tailwind Config -->
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
</head>
<body class="bg-gray-50">
    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-4 right-4 z-50 w-full max-w-sm space-y-3"></div>
    
    <div class="min-h-screen">
        <!-- Header Section -->
        <div class="bg-white shadow-hard rounded-xl mx-4 lg:mx-8 mt-4 mb-6 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start gap-3 mb-2">
                        <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-3 rounded-xl shadow-md">
                            <i class="fas fa-trash-restore text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-dark">Trash - Data Terhapus</h1>
                            <p class="text-gray-600 mt-1">Data yang telah dihapus (soft delete) akan disimpan di sini</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-end">
                    <a href="{{ route('barang-masuk.index') }}" 
                       class="bg-gradient-to-r from-primary to-primary-dark text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Stok Masuk</span>
                    </a>
                </div>
            </div>
            
            <!-- Stats and Actions -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-r from-amber-50 to-amber-100 px-4 py-2 rounded-lg border border-amber-200">
                            <span class="text-amber-700 text-sm font-medium">Total Data: </span>
                            <span class="text-amber-800 font-bold text-lg">{{ $trashedItems->count() }}</span>
                        </div>
                        
                        @if($trashedItems->count() > 0)
                        <div class="hidden lg:flex items-center gap-2 text-sm text-gray-600">
                            <i class="fas fa-info-circle text-blue-500"></i>
                            <span>Data akan disimpan selama 30 hari sebelum dihapus otomatis</span>
                        </div>
                        @endif
                    </div>
                    
                    @if($trashedItems->count() > 0)
                    <div class="flex flex-wrap gap-3">
                        <button onclick="restoreAll()"
                                class="bg-gradient-to-r from-success to-success-dark text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-redo"></i>
                            <span>Pulihkan Semua</span>
                        </button>
                        
                        <button onclick="emptyTrash()"
                                class="bg-gradient-to-r from-danger to-danger-dark text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-trash-alt"></i>
                            <span>Kosongkan Trash</span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="mx-4 lg:mx-8 mb-8">
            @if($trashedItems->count() > 0)
            <!-- Data Table -->
            <div class="bg-white rounded-2xl shadow-hard overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-dark to-gray-800 p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-white p-3 rounded-xl shadow-md">
                                <i class="fas fa-history text-dark text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Data Terhapus</h2>
                                <p class="text-gray-300 text-sm">Riwayat data yang telah dihapus</p>
                            </div>
                        </div>
                        
                        <div class="bg-white/10 px-4 py-2 rounded-lg">
                            <span class="text-white text-sm">Menampilkan {{ $trashedItems->count() }} data</span>
                        </div>
                    </div>
                </div>
                
                <!-- Table Content - Responsive -->
                <div class="p-6">
                    <div class="table-responsive overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-calendar-times mr-1"></i> Dihapus
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-calendar-alt mr-1"></i> Masuk
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-truck mr-1"></i> Supplier
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-box mr-1"></i> Barang
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-hashtag mr-1"></i> Jumlah
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        <i class="fas fa-cog mr-1"></i> Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($trashedItems as $item)
                                <tr id="row-{{ $item->id }}" 
                                    class="hover:bg-gray-50 transition-all card-hover">
                                    <!-- Tanggal Dihapus -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($item->deleted_at)->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($item->deleted_at)->format('H:i') }}
                                        </div>
                                        <div class="text-xs text-danger mt-1">
                                            <i class="fas fa-trash mr-1"></i>Terhapus
                                        </div>
                                    </td>
                                    
                                    <!-- Tanggal Masuk -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    
                                    <!-- Supplier -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->supplier }}</div>
                                    </td>
                                    
                                    <!-- Nama Barang -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->nama_barang }}</div>
                                    </td>
                                    
                                    <!-- Jumlah dan Satuan -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-gray-900">
                                                {{ number_format($item->jumlah_masuk) }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $item->satuan }}
                                            </span>
                                        </div>
                                        @if($item->keterangan)
                                        <div class="text-xs text-gray-500 mt-1 truncate max-w-xs">
                                            {{ $item->keterangan }}
                                        </div>
                                        @endif
                                    </td>
                                    
                                    <!-- Aksi -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <button onclick="restoreItem({{ $item->id }})"
                                                    class="bg-gradient-to-r from-success to-success-dark text-white p-2 rounded-lg hover:shadow-md transition-all flex items-center gap-2"
                                                    title="Pulihkan">
                                                <i class="fas fa-redo text-sm"></i>
                                                <span class="hidden sm:inline">Pulihkan</span>
                                            </button>
                                            
                                            <button onclick="forceDelete({{ $item->id }})"
                                                    class="bg-gradient-to-r from-danger to-danger-dark text-white p-2 rounded-lg hover:shadow-md transition-all flex items-center gap-2"
                                                    title="Hapus Permanen">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                                <span class="hidden sm:inline">Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Mobile Cards View (Hidden on desktop) -->
                    <div class="lg:hidden mt-6 space-y-4">
                        @foreach($trashedItems as $item)
                        <div class="bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-4 card-hover">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $item->nama_barang }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded-full">
                                            <i class="fas fa-trash mr-1"></i>
                                            {{ \Carbon\Carbon::parse($item->deleted_at)->format('d/m H:i') }}
                                        </span>
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                            {{ $item->satuan }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900">
                                        {{ number_format($item->jumlah_masuk) }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-truck text-gray-400 w-5"></i>
                                    <span class="text-gray-700">{{ $item->supplier }}</span>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-gray-400 w-5"></i>
                                    <span class="text-gray-700">
                                        Masuk: {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}
                                    </span>
                                </div>
                                
                                @if($item->keterangan)
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-sticky-note text-gray-400 w-5 mt-1"></i>
                                    <span class="text-gray-700">{{ $item->keterangan }}</span>
                                </div>
                                @endif
                            </div>
                            
                            <div class="mt-4 pt-3 border-t border-gray-200">
                                <div class="flex justify-between gap-2">
                                    <button onclick="restoreItem({{ $item->id }})"
                                            class="bg-gradient-to-r from-success to-success-dark text-white font-semibold py-2 px-4 rounded-lg hover:shadow-md transition-all flex items-center justify-center gap-2 flex-1">
                                        <i class="fas fa-redo"></i>
                                        <span>Pulihkan</span>
                                    </button>
                                    
                                    <button onclick="forceDelete({{ $item->id }})"
                                            class="bg-gradient-to-r from-danger to-danger-dark text-white font-semibold py-2 px-4 rounded-lg hover:shadow-md transition-all flex items-center justify-center gap-2 flex-1">
                                        <i class="fas fa-trash-alt"></i>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Action Buttons for Mobile -->
                    @if($trashedItems->count() > 0)
                    <div class="lg:hidden mt-8 pt-6 border-t border-gray-200">
                        <div class="space-y-3">
                            <button onclick="restoreAll()"
                                    class="bg-gradient-to-r from-success to-success-dark text-white font-semibold py-4 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 w-full">
                                <i class="fas fa-redo"></i>
                                <span>Pulihkan Semua Data</span>
                            </button>
                            
                            <button onclick="emptyTrash()"
                                    class="bg-gradient-to-r from-danger to-danger-dark text-white font-semibold py-4 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 w-full">
                                <i class="fas fa-trash-alt"></i>
                                <span>Kosongkan Trash</span>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-hard overflow-hidden">
                <div class="bg-gradient-to-r from-dark to-gray-800 p-6">
                    <div class="flex items-center gap-3">
                        <div class="bg-white p-3 rounded-xl shadow-md">
                            <i class="fas fa-trash text-dark text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Trash Kosong</h2>
                            <p class="text-gray-300 text-sm">Tidak ada data yang dihapus</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-8 text-center">
                    <div class="inline-block p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-full mb-6">
                        <i class="fas fa-trash-restore text-blue-500 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Trash Kosong</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Tidak ada data yang telah dihapus. Data yang dihapus akan muncul di sini dan dapat dipulihkan dalam waktu 30 hari.
                    </p>
                    <a href="{{ route('barang-masuk.index') }}" 
                       class="bg-gradient-to-r from-primary to-primary-dark text-white font-semibold py-4 px-8 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 mx-auto max-w-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Stok Masuk</span>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';
        const baseUrl = '{{ url('/') }}';
        
        // Function to show notification
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
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                removeNotification(notificationId);
            }, 5000);
        }
        
        // Function to remove notification
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
        
        // Restore single item
        async function restoreItem(id) {
            if (!confirm('Pulihkan data ini?')) return;
            
            // Show loading on button
            const restoreBtn = document.querySelector(`#row-${id} .bg-gradient-to-r.from-success`);
            if (restoreBtn) {
                const originalHtml = restoreBtn.innerHTML;
                restoreBtn.innerHTML = '<div class="spinner"></div>';
                restoreBtn.disabled = true;
            }
            
            try {
                const response = await fetch(`${baseUrl}/barang-masuk/${id}/restore`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(result.message, 'success');
                    
                    // Remove row with animation
                    const row = document.getElementById(`row-${id}`);
                    if (row) {
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(-20px)';
                        
                        setTimeout(() => {
                            row.remove();
                            
                            // Check if table is empty
                            const tbody = document.querySelector('tbody');
                            const mobileCards = document.querySelector('.lg\\:hidden .space-y-4');
                            
                            if (tbody && tbody.children.length === 0) {
                                location.reload();
                            }
                        }, 300);
                    }
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            } finally {
                // Restore button state
                if (restoreBtn) {
                    restoreBtn.innerHTML = originalHtml;
                    restoreBtn.disabled = false;
                }
            }
        }
        
        // Restore all items
        async function restoreAll() {
            if (!confirm('Pulihkan semua data dari trash?')) return;
            
            // Show loading
            const restoreAllBtn = document.querySelector('button[onclick="restoreAll()"]');
            if (restoreAllBtn) {
                const originalHtml = restoreAllBtn.innerHTML;
                restoreAllBtn.innerHTML = '<div class="spinner"></div><span>Memproses...</span>';
                restoreAllBtn.disabled = true;
            }
            
            try {
                const response = await fetch(`${baseUrl}/barang-masuk/restore-all`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(`${result.message} (${result.count} data)`, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            } finally {
                // Restore button state
                if (restoreAllBtn) {
                    restoreAllBtn.innerHTML = originalHtml;
                    restoreAllBtn.disabled = false;
                }
            }
        }
        
        // Force delete (permanent delete)
        async function forceDelete(id) {
            if (!confirm('Hapus permanen data ini? Tindakan ini tidak dapat dibatalkan!')) return;
            
            // Show loading on button
            const deleteBtn = document.querySelector(`#row-${id} .bg-gradient-to-r.from-danger`);
            if (deleteBtn) {
                const originalHtml = deleteBtn.innerHTML;
                deleteBtn.innerHTML = '<div class="spinner"></div>';
                deleteBtn.disabled = true;
            }
            
            try {
                const response = await fetch(`${baseUrl}/barang-masuk/${id}/force-delete`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(result.message, 'success');
                    
                    // Remove row with animation
                    const row = document.getElementById(`row-${id}`);
                    if (row) {
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(20px)';
                        
                        setTimeout(() => {
                            row.remove();
                            
                            // Check if table is empty
                            const tbody = document.querySelector('tbody');
                            const mobileCards = document.querySelector('.lg\\:hidden .space-y-4');
                            
                            if (tbody && tbody.children.length === 0) {
                                location.reload();
                            }
                        }, 300);
                    }
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            } finally {
                // Restore button state
                if (deleteBtn) {
                    deleteBtn.innerHTML = originalHtml;
                    deleteBtn.disabled = false;
                }
            }
        }
        
        // Empty trash
        async function emptyTrash() {
            if (!confirm('Kosongkan trash? Semua data akan dihapus permanen dan tidak dapat dipulihkan!')) return;
            
            // Show loading
            const emptyBtn = document.querySelector('button[onclick="emptyTrash()"]');
            if (emptyBtn) {
                const originalHtml = emptyBtn.innerHTML;
                emptyBtn.innerHTML = '<div class="spinner"></div><span>Memproses...</span>';
                emptyBtn.disabled = true;
            }
            
            try {
                const response = await fetch(`${baseUrl}/barang-masuk/empty-trash`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(result.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan', 'error');
            } finally {
                // Restore button state
                if (emptyBtn) {
                    emptyBtn.innerHTML = originalHtml;
                    emptyBtn.disabled = false;
                }
            }
        }
        
        // Responsive adjustments
        window.addEventListener('resize', function() {
            // Adjust layout for mobile
            if (window.innerWidth < 768) {
                // Mobile-specific adjustments
            }
        });
    </script>
</body>
</html>