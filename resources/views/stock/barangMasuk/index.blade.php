<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Masuk Gudang - Sistem Manajemen Inventory</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --success: #10b981;
            --success-dark: #059669;
            --danger: #ef4444;
            --danger-dark: #dc2626;
            --warning: #f59e0b;
            --warning-dark: #d97706;
            --info: #06b6d4;
            --dark: #1f2937;
            --light: #f9fafb;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }

        /* Card hover effect */
        .card-hover {
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: rgba(59, 130, 246, 0.2);
        }

        /* Form input focus styles */
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Animation for notifications */
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

        /* Table row hover */
        .table-row-hover:hover {
            background-color: rgba(59, 130, 246, 0.05);
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Gradient buttons */
        .btn-gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .btn-gradient-success {
            background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
        }

        .btn-gradient-danger {
            background: linear-gradient(135deg, var(--danger) 0%, var(--danger-dark) 100%);
        }

        .btn-gradient-warning {
            background: linear-gradient(135deg, var(--warning) 0%, var(--warning-dark) 100%);
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .mobile-stack {
                flex-direction: column;
            }

            .mobile-full {
                width: 100%;
            }

            .mobile-text-center {
                text-align: center;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }

        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }
        }

        /* Animation for item removal */
        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }

            to {
                opacity: 0;
                transform: translateX(-20px);
            }
        }

        .fade-out {
            animation: fadeOut 0.3s ease forwards;
        }

        /* Animation for item addition */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease forwards;
        }

        /* Modal Styles */
        .modal-open {
            overflow: hidden;
        }

        .modal-backdrop {
            backdrop-filter: blur(5px);
        }

        /* Table row hover for modal */
        .modal-row-hover:hover {
            background-color: rgba(59, 130, 246, 0.05) !important;
        }

        /* Selected row style */
        .row-selected {
            background-color: rgba(16, 185, 129, 0.1) !important;
            border-left: 4px solid #10b981;
        }

        /* Checkbox styling */
        .checkbox-custom {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid #d1d5db;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkbox-custom:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        /* Modal animation */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-content {
            animation: modalFadeIn 0.3s ease;
        }

        /* Browse button style */
        .browse-barang-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #3b82f6;
        }

        .browse-barang-btn:hover {
            color: #2563eb;
            transform: translateY(-50%) scale(1.1);
        }

        /* Adjust input padding to accommodate browse button */
        .relative-input-wrapper {
            position: relative;
        }

        .relative-input-wrapper input[type="text"] {
            padding-right: 45px !important;
        }

        /* Satuan table row hover */
        .satuan-row-hover:hover {
            background-color: rgba(59, 130, 246, 0.05) !important;
        }

        /* Button untuk modal satuan */
        .browse-satuan-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #3b82f6;
        }

        .browse-satuan-btn:hover {
            color: #2563eb;
            transform: translateY(-50%) scale(1.1);
        }

        /* Highlight untuk satuan yang dipilih */
        .satuan-selected {
            background-color: rgba(16, 185, 129, 0.1) !important;
            border-left: 4px solid #10b981;
        }

        /* Sync indicator */
        .sync-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            padding: 4px 10px;
            border-radius: 12px;
            background-color: rgba(16, 185, 129, 0.1);
            color: #059669;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        /* Single selection style */
        .single-selection-radio {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* Item card selected style */
        .item-card-selected {
            border-left: 4px solid #10b981;
            background-color: rgba(16, 185, 129, 0.05);
        }

        /* Modal single selection instructions */
        .single-selection-instruction {
            background: linear-gradient(135deg, #e0f7fa 0%, #bbdefb 100%);
            border: 1px solid #81d4fa;
            color: #0277bd;
        }

        /* Barang info in modal */
        .barang-info {
            background: rgba(59, 130, 246, 0.05);
            border-left: 4px solid #3b82f6;
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
                    },
                    animation: {
                        'bounce-slow': 'bounce 2s infinite',
                        'pulse-slow': 'pulse 3s infinite',
                        'fade-in': 'fadeIn 0.3s ease',
                        'fade-out': 'fadeOut 0.3s ease',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 text-gray-800">
    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-4 right-4 z-50 w-full max-w-sm space-y-3"></div>

    <!-- Loading Overlay for Sync -->
    <div id="syncLoading" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-40 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="bg-white p-8 rounded-xl shadow-xl flex flex-col items-center">
                <div class="spinner mb-4" style="border-top-color: #3b82f6;"></div>
                <p class="text-lg font-semibold text-gray-700">Menyinkronkan ke Google Sheets...</p>
                <p class="text-sm text-gray-500 mt-2">Data sedang diperbarui secara otomatis</p>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="min-h-screen">
        <!-- Header Section - Shown on Data Page -->
        <header id="mainHeader" class="glass shadow-medium rounded-xl mx-4 lg:mx-8 mt-4 mb-6 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start gap-3 mb-2">
                        <div class="bg-primary p-3 rounded-xl shadow-md">
                            <i class="fas fa-boxes text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-dark">Stok Masuk Gudang</h1>
                            <p class="text-gray-600 mt-1">Sistem Manajemen Inventory Barang Masuk</p>
                            <div class="mt-2">
                                <span class="sync-indicator">
                                    <i class="fas fa-sync-alt"></i>
                                    Auto-sync Google Sheets Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-end">
                    <!-- Input Barang -->
                    <button id="showFormBtn"
                        class="btn-gradient-success text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>Input Barang Baru</span>
                    </button>

                    <a href="{{ route('barang-masuk.trash') }}"
                        class="bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-trash-restore"></i>
                        <span>Data Terhapus</span>
                        @if ($trashCount > 0)
                            <span
                                class="bg-white text-amber-600 text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                                {{ $trashCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="mx-4 lg:mx-8 mb-8">
            <!-- Form Section - Initially Hidden -->
            <section id="formSection" class="bg-white rounded-2xl shadow-hard overflow-hidden" style="display: none;">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-primary to-primary-dark p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-white p-3 rounded-xl shadow-md">
                                <i class="fas fa-edit text-primary text-xl"></i>
                            </div>
                            <div>
                                <h2 id="formTitle" class="text-2xl font-bold text-white">Input Data Stok Masuk</h2>
                                <p class="text-blue-100 mt-1">Isi form berikut untuk menambahkan data stok masuk</p>
                                <div class="mt-2">
                                    <span class="text-blue-200 text-sm flex items-center gap-1">
                                        <i class="fas fa-info-circle"></i>
                                        Data akan otomatis tersinkron ke Google Sheets
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 bg-white/20 p-2 rounded-lg">
                            <i class="fas fa-info-circle text-white"></i>
                            <span class="text-white text-sm">Semua field bertanda <span
                                    class="text-red-300 font-bold">*</span> wajib diisi</span>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6">
                    <form id="stokMasukForm" novalidate>
                        @csrf
                        <input type="hidden" id="editId" name="editId">
                        <input type="hidden" id="mode" name="mode" value="create">

                        <!-- Single Item Form for Edit -->
                        <div id="singleItemForm" class="mb-6" style="display: none;">
                            <div
                                class="bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-warning p-6 rounded-lg">
                                <div class="flex items-center gap-2 mb-4">
                                    <i class="fas fa-edit text-warning"></i>
                                    <h3 class="font-bold text-dark">Edit Data Barang</h3>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <!-- Tanggal Masuk -->
                                    <div>
                                        <label for="edit_tanggal_masuk"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-calendar-alt mr-1 text-primary"></i>
                                            Tanggal Masuk <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" id="edit_tanggal_masuk" name="edit_tanggal_masuk"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input"
                                            value="{{ date('Y-m-d') }}" required>
                                        <p class="text-xs text-gray-500 mt-1">Tanggal barang masuk ke gudang</p>
                                    </div>

                                    <!-- Supplier -->
                                    <div>
                                        <label for="edit_supplier" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-truck mr-1 text-primary"></i>
                                            Supplier <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="edit_supplier" name="edit_supplier"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input"
                                            list="supplierList" placeholder="Pilih atau ketik nama supplier" required>
                                        <datalist id="supplierList">
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier }}">
                                            @endforeach
                                        </datalist>
                                        <p class="text-xs text-gray-500 mt-1">Nama pemasok barang</p>
                                    </div>

                                    <!-- Nama Barang -->
                                    <div class="lg:col-span-2">
                                        <label for="edit_nama_barang"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-box mr-1 text-primary"></i>
                                            Nama Barang <span class="text-danger">*</span>
                                        </label>
                                        <div class="relative-input-wrapper">
                                            <input type="text" id="edit_nama_barang" name="edit_nama_barang"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input"
                                                list="barangList" placeholder="Klik untuk memilih dari daftar barang"
                                                required>
                                            <button type="button" class="browse-barang-btn"
                                                onclick="openBarangModalForSingleSelection('edit')">
                                                <i class="fas fa-list"></i>
                                            </button>
                                        </div>
                                        <div id="edit_barang_info" class="mt-2 text-sm hidden barang-info p-3 rounded-lg">
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                                <div>Kode: <span id="edit_kode_barang" class="font-bold">-</span></div>
                                                <div>Stok: <span id="edit_stok_tersedia" class="font-bold">0</span></div>
                                                <div>Satuan: <span id="edit_satuan_utama" class="font-bold">-</span></div>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Pilih barang dari daftar (hanya 1 barang per item)</p>
                                    </div>

                                    <!-- Jumlah dan Satuan -->
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:col-span-2">
                                        <div>
                                            <label for="edit_jumlah_masuk"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-hashtag mr-1 text-primary"></i>
                                                Jumlah Masuk <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" id="edit_jumlah_masuk" name="edit_jumlah_masuk"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input"
                                                min="0.0001" step="any" placeholder="0.000" required>
                                            <p class="text-xs text-gray-500 mt-1">Jumlah barang yang masuk (bisa desimal)</p>
                                        </div>

                                        <div>
                                            <label for="edit_satuan"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-balance-scale mr-1 text-primary"></i>
                                                Satuan Input <span class="text-danger">*</span>
                                            </label>
                                            <div class="relative-input-wrapper">
                                                <input type="text" id="edit_satuan" name="edit_satuan"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input"
                                                    placeholder="Klik untuk memilih satuan" required
                                                    autocomplete="off">
                                                <button type="button" class="browse-satuan-btn"
                                                    onclick="openSatuanModal('edit_satuan')">
                                                    <i class="fas fa-list"></i>
                                                </button>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Satuan pengukuran barang</p>
                                        </div>
                                    </div>

                                    <!-- Keterangan -->
                                    <div class="lg:col-span-2">
                                        <label for="edit_keterangan"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class="fas fa-sticky-note mr-1 text-primary"></i>
                                            Keterangan (Opsional)
                                        </label>
                                        <textarea id="edit_keterangan" name="edit_keterangan"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input"
                                            rows="3" placeholder="Keterangan tambahan..."></textarea>
                                        <p class="text-xs text-gray-500 mt-1">Catatan atau informasi tambahan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Multiple Items Form for Create -->
                        <div id="multipleItemsForm">
                            <!-- Items Header -->
                            <div class="mb-6">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-primary p-3 rounded-lg">
                                            <i class="fas fa-list text-white"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-dark">Daftar Barang Masuk</h3>
                                            <p class="text-gray-600">Tambahkan item barang yang masuk (1 barang per item)</p>
                                        </div>
                                    </div>

                                    <!-- Desktop Add Item Button -->
                                    <button type="button" id="addItemBtn"
                                        class="bg-gradient-to-r from-primary to-primary-dark text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-2 hidden lg:flex">
                                        <i class="fas fa-plus"></i>
                                        <span>Tambah Item Baru</span>
                                    </button>
                                </div>

                                <!-- Info Panel -->
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-4 mb-6">
                                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                                            <div>
                                                <p class="text-blue-700 font-medium">Tips:</p>
                                                <p class="text-blue-600 text-sm">1 barang per item. Klik tombol "Tambah Item Baru" untuk baris baru.</p>
                                                <p class="text-blue-600 text-sm mt-1">Data akan otomatis tersinkron ke Google Sheets.</p>
                                            </div>
                                        </div>
                                        <div class="bg-white px-4 py-2 rounded-lg shadow-soft">
                                            <span class="text-blue-700 font-bold">
                                                Total Item: <span id="itemCount" class="text-primary text-xl">0</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Items List -->
                            <div id="itemsList" class="space-y-6 mb-8">
                                <!-- Item rows will be added here -->
                            </div>

                            <!-- Mobile Add Item Button -->
                            <div class="text-center mb-8 lg:hidden">
                                <button type="button" id="addItemBtnMobile"
                                    class="bg-gradient-to-r from-primary to-primary-dark text-white font-semibold py-4 px-8 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 w-full">
                                    <i class="fas fa-plus"></i>
                                    <span>Tambah Item Baru</span>
                                </button>
                            </div>

                            <!-- Desktop Add Item Button (Bottom) -->
                            <div class="text-center mb-8 hidden lg:block">
                                <button type="button" id="addItemBtnBottom"
                                    class="bg-gradient-to-r from-primary to-primary-dark text-white font-semibold py-4 px-8 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 w-full max-w-md mx-auto">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Tambah Item Baru Lainnya</span>
                                </button>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex flex-col lg:flex-row gap-4">
                                <button type="button" id="cancelBtn"
                                    class="bg-gradient-to-r from-gray-500 to-gray-600 text-white font-semibold py-4 px-8 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 flex-1 order-2 lg:order-1">
                                    <i class="fas fa-times"></i>
                                    <span>Batal</span>
                                </button>

                                <button type="submit" id="submitBtn"
                                    class="btn-gradient-success text-white font-semibold py-4 px-8 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 flex-1 order-1 lg:order-2">
                                    <i class="fas fa-save"></i>
                                    <span id="submitBtnText">Simpan Data & Sync ke Google Sheets</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Data Table Section - Initially Visible -->
            <section id="dataSection" class="bg-white rounded-2xl shadow-hard overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-dark to-gray-800 p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-white p-3 rounded-xl shadow-md">
                                <i class="fas fa-history text-dark text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Data Stok Masuk Terbaru</h2>
                                <p class="text-gray-300 mt-1">Riwayat barang masuk ke gudang - Auto-sync Google Sheets Aktif</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-white/10 px-4 py-2 rounded-lg">
                                <span class="text-white text-sm">Total Data: <span
                                        class="font-bold">{{ $barangMasuk->count() }}</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="p-6">
                    @if ($barangMasuk->count() > 0)
                        <div class="table-responsive overflow-x-auto rounded-xl border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            No</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-calendar mr-1"></i> Tanggal
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-truck mr-1"></i> Supplier
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-box mr-1"></i> Nama Barang
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-hashtag mr-1"></i> Jumlah Masuk
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-balance-scale mr-1"></i> Satuan Input
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-sticky-note mr-1"></i> Keterangan
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            <i class="fas fa-cog mr-1"></i> Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="stokTableBody" class="bg-white divide-y divide-gray-200">
                                    @foreach ($barangMasuk as $index => $item)
                                        <tr id="row-{{ $item->id }}" data-id="{{ $item->id }}"
                                            data-tanggal="{{ $item->tanggal_masuk }}"
                                            data-supplier="{{ $item->supplier }}"
                                            data-nama="{{ $item->nama_barang }}"
                                            data-jumlah="{{ $item->jumlah_masuk }}"
                                            data-satuan="{{ $item->satuan }}"
                                            data-keterangan="{{ $item->keterangan }}"
                                            class="table-row-hover hover:bg-blue-50 transition-all">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $index + 1 }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">
                                                    {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $item->supplier }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">{{ $item->nama_barang }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">
                                                    {{ number_format($item->jumlah_masuk, 3) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $item->satuan }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                                    {{ $item->keterangan ?: '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center gap-2">
                                                    <button onclick="editData({{ $item->id }})"
                                                        class="bg-gradient-to-r from-primary to-primary-dark text-white p-2 rounded-lg hover:shadow-md transition-all"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button onclick="deleteData({{ $item->id }})"
                                                        class="bg-gradient-to-r from-danger to-danger-dark text-white p-2 rounded-lg hover:shadow-md transition-all"
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
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="inline-block p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-full mb-6">
                                <i class="fas fa-box-open text-blue-500 text-5xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Data</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                                Belum ada data stok masuk yang tercatat. Mulai dengan menambahkan data barang masuk
                                pertama Anda.
                            </p>
                            <button id="showFormBtn2"
                                class="btn-gradient-success text-white font-semibold py-4 px-8 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 mx-auto">
                                <i class="fas fa-plus-circle"></i>
                                <span>Input Barang Baru Pertama</span>
                            </button>
                        </div>
                    @endif
                </div>
            </section>
        </div>
        <!-- Back Button - Shown on Form Page -->
        <div id="backButtonContainer" class="mx-4 lg:mx-8 mb-6" style="display: none;">
            <button id="backToDataBtn"
                class="bg-gradient-to-r from-primary to-primary-dark text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Data</span>
            </button>
        </div>
    </div>

    <!-- Modal untuk Tabel Barang (Single Selection) -->
    <div id="barangModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden modal-backdrop">
        <div
            class="relative top-20 mx-auto p-5 border w-11/12 lg:w-4/5 shadow-lg rounded-2xl bg-white max-h-[80vh] flex flex-col modal-content">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b mb-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Pilih Barang</h3>
                    <p class="text-gray-600" id="modalInstruction">Pilih 1 barang dari daftar di bawah ini</p>
                </div>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Single Selection Instruction -->
            <div id="singleSelectionInfo" class="mb-4 p-4 rounded-lg single-selection-instruction hidden">
                <div class="flex items-center gap-3">
                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                    <div>
                        <p class="font-medium text-blue-800">Mode Pemilihan Tunggal</p>
                        <p class="text-blue-700 text-sm mt-1">Hanya dapat memilih 1 barang per item. Klik pada baris untuk memilih.</p>
                    </div>
                </div>
            </div>

            <!-- Selected Barang Info -->
            <div id="selectedBarangInfo" class="mb-4 p-4 rounded-lg border border-green-200 bg-green-50 hidden">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium text-green-800">Barang Dipilih:</p>
                        <p class="text-green-700 text-sm mt-1" id="selectedBarangName">-</p>
                    </div>
                    <button id="clearSelectionBtn" class="text-red-500 hover:text-red-700 text-sm">
                        <i class="fas fa-times mr-1"></i>Hapus Pilihan
                    </button>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="mb-6">
                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" id="searchBarang"
                                class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Cari barang (nama atau kode)...">
                            <div class="absolute left-4 top-3.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button id="refreshBarangBtn"
                            class="bg-gradient-to-r from-primary to-primary-dark text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i>
                            <span>Refresh</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="flex-1 overflow-auto rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Pilih
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Kode Barang
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Nama Barang
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Satuan Utama
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Stok Sekarang
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody id="barangTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Data barang akan diisi via JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Modal Footer -->
            <div class="pt-4 mt-4 border-t flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <span id="selectedBarangCount">0</span> barang dipilih
                </div>
                <div class="flex gap-3">
                    <button id="cancelSelectBtn"
                        class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all">
                        Batal
                    </button>
                    <button id="confirmSelectBtn"
                        class="bg-gradient-to-r from-success to-success-dark text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all flex items-center gap-2">
                        <i class="fas fa-check"></i>
                        Pilih Barang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Tabel Satuan -->
    <div id="satuanModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden modal-backdrop">
        <div
            class="relative top-20 mx-auto p-5 border w-11/12 lg:w-4/5 shadow-lg rounded-2xl bg-white max-h-[80vh] flex flex-col modal-content">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-4 border-b mb-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Daftar Satuan</h3>
                    <p class="text-gray-600">Pilih satuan dari daftar di bawah ini</p>
                </div>
                <button id="closeSatuanModalBtn" class="text-gray-400 hover:text-gray-600 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Search and Filter -->
            <div class="mb-6">
                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" id="searchSatuan"
                                class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Cari satuan...">
                            <div class="absolute left-4 top-3.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button id="refreshSatuanBtn"
                            class="bg-gradient-to-r from-primary to-primary-dark text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i>
                            <span>Refresh</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="flex-1 overflow-auto rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                No
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Satuan Input
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Satuan Utama
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Faktor
                            </th>
                        </tr>
                    </thead>
                    <tbody id="satuanTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Data satuan akan diisi via JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Modal Footer -->
            <div class="pt-4 mt-4 border-t flex justify-between items-center">
                <div id="selectedSatuanCount" class="text-sm text-gray-600">
                    Klik satuan untuk memilih
                </div>
                <div class="flex gap-3">
                    <button id="cancelSatuanSelectBtn"
                        class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transition-all">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Inisialisasi variabel
        const csrfToken = '{{ csrf_token() }}';
        const baseUrl = '{{ url('/') }}';
        let isEditMode = false;
        let currentEditId = null;
        let itemCounter = 1;

        // Variabel untuk modal (SINGLE SELECTION)
        let selectedBarang = null; // Hanya menyimpan 1 barang
        let currentNamaInputId = null;
        let currentSatuanInputId = null;
        let currentSatuanModalTarget = null;
        let currentItemId = null; // Untuk menyimpan item card yang sedang dipilih

        // DOM Elements
        const mainHeader = document.getElementById('mainHeader');
        const backButtonContainer = document.getElementById('backButtonContainer');
        const backToDataBtn = document.getElementById('backToDataBtn');
        const formSection = document.getElementById('formSection');
        const dataSection = document.getElementById('dataSection');
        const showFormBtn = document.getElementById('showFormBtn');
        const showFormBtn2 = document.getElementById('showFormBtn2');
        const cancelBtn = document.getElementById('cancelBtn');
        const addItemBtn = document.getElementById('addItemBtn');
        const addItemBtnMobile = document.getElementById('addItemBtnMobile');
        const addItemBtnBottom = document.getElementById('addItemBtnBottom');
        const form = document.getElementById('stokMasukForm');
        const formTitle = document.getElementById('formTitle');
        const submitBtn = document.getElementById('submitBtn');
        const submitBtnText = document.getElementById('submitBtnText');
        const singleItemForm = document.getElementById('singleItemForm');
        const multipleItemsForm = document.getElementById('multipleItemsForm');
        const itemsList = document.getElementById('itemsList');
        const syncLoading = document.getElementById('syncLoading');

        // Modal elements
        const barangModal = document.getElementById('barangModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const searchBarang = document.getElementById('searchBarang');
        const refreshBarangBtn = document.getElementById('refreshBarangBtn');
        const cancelSelectBtn = document.getElementById('cancelSelectBtn');
        const confirmSelectBtn = document.getElementById('confirmSelectBtn');
        const satuanModal = document.getElementById('satuanModal');
        const closeSatuanModalBtn = document.getElementById('closeSatuanModalBtn');
        const searchSatuan = document.getElementById('searchSatuan');
        const refreshSatuanBtn = document.getElementById('refreshSatuanBtn');
        const cancelSatuanSelectBtn = document.getElementById('cancelSatuanSelectBtn');
        
        // Single selection elements
        const singleSelectionInfo = document.getElementById('singleSelectionInfo');
        const selectedBarangInfo = document.getElementById('selectedBarangInfo');
        const selectedBarangName = document.getElementById('selectedBarangName');
        const clearSelectionBtn = document.getElementById('clearSelectionBtn');

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Sistem Stok Masuk dengan Auto-Sync initialized');

            // Event listeners
            showFormBtn.addEventListener('click', () => showFormPage());
            if (showFormBtn2) showFormBtn2.addEventListener('click', () => showFormPage());
            backToDataBtn.addEventListener('click', showDataPage);
            cancelBtn.addEventListener('click', showDataPage);

            // Event listeners untuk tombol tambah item
            if (addItemBtn) addItemBtn.addEventListener('click', addNewItem);
            if (addItemBtnMobile) addItemBtnMobile.addEventListener('click', addNewItem);
            if (addItemBtnBottom) addItemBtnBottom.addEventListener('click', addNewItem);

            form.addEventListener('submit', handleSubmit);

            // Event listeners untuk modal barang (SINGLE SELECTION)
            closeModalBtn.addEventListener('click', closeBarangModal);
            cancelSelectBtn.addEventListener('click', closeBarangModal);
            confirmSelectBtn.addEventListener('click', confirmSingleBarangSelection);
            refreshBarangBtn.addEventListener('click', () => loadBarangData(searchBarang.value));
            clearSelectionBtn.addEventListener('click', clearBarangSelection);

            // Event listeners untuk modal satuan
            closeSatuanModalBtn.addEventListener('click', closeSatuanModal);
            cancelSatuanSelectBtn.addEventListener('click', closeSatuanModal);
            refreshSatuanBtn.addEventListener('click', () => loadSatuanData(searchSatuan.value));

            // Search functionality
            let searchBarangTimeout;
            searchBarang.addEventListener('input', function() {
                clearTimeout(searchBarangTimeout);
                searchBarangTimeout = setTimeout(() => {
                    loadBarangData(this.value);
                }, 500);
            });

            let searchSatuanTimeout;
            searchSatuan.addEventListener('input', function() {
                clearTimeout(searchSatuanTimeout);
                searchSatuanTimeout = setTimeout(() => {
                    loadSatuanData(this.value);
                }, 500);
            });

            // Close modals on escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    if (!barangModal.classList.contains('hidden')) {
                        closeBarangModal();
                    }
                    if (!satuanModal.classList.contains('hidden')) {
                        closeSatuanModal();
                    }
                }
            });

            // Close modals on backdrop click
            barangModal.addEventListener('click', function(event) {
                if (event.target === this) {
                    closeBarangModal();
                }
            });

            satuanModal.addEventListener('click', function(event) {
                if (event.target === this) {
                    closeSatuanModal();
                }
            });

            // Tampilkan halaman data sebagai default
            showDataPage();
        });

        // Fungsi untuk menampilkan halaman form input
        function showFormPage() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            mainHeader.style.display = 'none';
            backButtonContainer.style.display = 'block';
            formSection.style.display = 'block';
            dataSection.style.display = 'none';

            resetForm();

            console.log('Form page shown');
        }

        // Fungsi untuk menampilkan halaman data
        function showDataPage() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            mainHeader.style.display = 'block';
            backButtonContainer.style.display = 'none';
            formSection.style.display = 'none';
            dataSection.style.display = 'block';

            if (isEditMode) {
                cancelEditMode();
            }

            console.log('Data page shown');
        }

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

        // Clear validation styles function
        function clearValidationStyles() {
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.classList.remove('border-red-500', 'ring-2', 'ring-red-300');
                input.classList.add('border-gray-300');
            });
        }

        function addNewItem() {
            const itemId = 'item-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);

            const itemCard = `
                <div class="item-card card-hover fade-in bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-6" 
                     id="${itemId}" data-item-number="${itemCounter}" data-item-id="${itemId}">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-primary text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">
                                ${itemCounter}
                            </div>
                            <h4 class="font-bold text-dark">Item Barang ${itemCounter}</h4>
                            <span class="item-status bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full hidden">
                                <i class="fas fa-exclamation-circle mr-1"></i>Belum pilih barang
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            ${itemCounter > 1 ? `
                                <button type="button" class="remove-item-btn bg-gradient-to-r from-danger to-danger-dark text-white p-2 rounded-lg hover:shadow-md transition-all" 
                                        title="Hapus Item" data-item-id="${itemId}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            ` : `
                                <button type="button" class="remove-item-btn bg-gradient-to-r from-gray-300 to-gray-400 text-gray-500 p-2 rounded-lg cursor-not-allowed" 
                                        title="Item pertama tidak dapat dihapus" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            `}
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Tanggal Masuk -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt mr-1 text-primary"></i>
                                Tanggal Masuk <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="items[${itemId}][tanggal_masuk]" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input item-input item-tanggal" 
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <!-- Supplier -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-truck mr-1 text-primary"></i>
                                Supplier <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="items[${itemId}][supplier]" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input item-input item-supplier" 
                                   list="supplierList" placeholder="Pilih atau ketik nama supplier" required>
                        </div>
                        
                        <!-- Nama Barang (SINGLE SELECTION) -->
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-box mr-1 text-primary"></i>
                                Nama Barang <span class="text-danger">*</span>
                                <span class="text-xs text-gray-500">(Pilih 1 barang)</span>
                            </label>
                            <div class="relative-input-wrapper">
                                <input type="text" name="items[${itemId}][nama_barang]" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input item-input item-nama" 
                                       placeholder="Klik untuk memilih 1 barang dari daftar" 
                                       required
                                       readonly
                                       onclick="openBarangModalForSingleSelection('${itemId}')">
                                <button type="button" class="browse-barang-btn" onclick="openBarangModalForSingleSelection('${itemId}')">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                            <!-- Barang Info (akan ditampilkan setelah memilih) -->
                            <div id="barang-info-${itemId}" class="mt-2 text-sm hidden barang-info p-3 rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                    <div>Kode: <span id="kode-${itemId}" class="font-bold">-</span></div>
                                    <div>Stok: <span id="stok-${itemId}" class="font-bold">0</span></div>
                                    <div>Satuan: <span id="satuan-${itemId}" class="font-bold">-</span></div>
                                </div>
                            </div>
                            <input type="hidden" name="items[${itemId}][barang_id]" id="barang-id-${itemId}" value="">
                            <p class="text-xs text-gray-500 mt-1">Hanya dapat memilih 1 barang per item</p>
                        </div>
                        
                        <!-- Jumlah dan Satuan -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:col-span-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-hashtag mr-1 text-primary"></i>
                                    Jumlah Masuk <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="items[${itemId}][jumlah_masuk]" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input item-input item-jumlah" 
                                       min="0.0001" step="any" placeholder="0.000" required>
                                <p class="text-xs text-gray-500 mt-1">Masukkan jumlah (bisa desimal)</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-balance-scale mr-1 text-primary"></i>
                                    Satuan Input <span class="text-danger">*</span>
                                </label>
                                <div class="relative-input-wrapper">
                                    <input type="text" name="items[${itemId}][satuan]" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input item-input item-satuan" 
                                           placeholder="Klik untuk memilih satuan" required
                                           autocomplete="off"
                                           onclick="openSatuanModalForItem('${itemId}')"
                                           readonly>
                                    <button type="button" class="browse-satuan-btn" onclick="openSatuanModalForItem('${itemId}')">
                                        <i class="fas fa-list"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Keterangan -->
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sticky-note mr-1 text-primary"></i>
                                Keterangan (Opsional)
                            </label>
                            <textarea name="items[${itemId}][keterangan]" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input item-input item-keterangan" 
                                      rows="2" placeholder="Keterangan tambahan..."></textarea>
                        </div>
                    </div>
                </div>
            `;

            itemsList.insertAdjacentHTML('beforeend', itemCard);
            itemCounter++;
            updateItemCount();
            attachRemoveItemListeners();

            setTimeout(() => {
                const newItem = document.getElementById(itemId);
                if (newItem) {
                    newItem.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                    const tanggalInput = newItem.querySelector('.item-tanggal');
                    if (tanggalInput) tanggalInput.focus();
                }
            }, 100);
        }

        // Attach event listeners untuk tombol hapus item
        function attachRemoveItemListeners() {
            const removeButtons = document.querySelectorAll('.remove-item-btn');
            removeButtons.forEach(button => {
                button.replaceWith(button.cloneNode(true));
            });

            document.querySelectorAll('.remove-item-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const itemId = this.getAttribute('data-item-id');
                    if (itemId && !this.disabled) {
                        removeItem(itemId);
                    }
                });
            });
        }

        // Remove Item
        function removeItem(itemId) {
            const item = document.getElementById(itemId);
            if (!item) return;

            if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                return;
            }

            item.classList.add('fade-out');

            setTimeout(() => {
                item.remove();
                updateItemNumbers();
                updateItemCount();
                updateFirstItemRemoveButton();
                showNotification('Item dihapus', 'warning');
            }, 300);
        }

        // Update nomor urut semua item
        function updateItemNumbers() {
            const itemCards = document.querySelectorAll('.item-card');
            itemCounter = 1;

            itemCards.forEach((card, index) => {
                const itemNumber = index + 1;
                card.setAttribute('data-item-number', itemNumber);

                const numberBadge = card.querySelector('.bg-primary.text-white');
                if (numberBadge) {
                    numberBadge.textContent = itemNumber;
                }

                const titleElement = card.querySelector('.font-bold.text-dark');
                if (titleElement) {
                    titleElement.textContent = `Item Barang ${itemNumber}`;
                }

                itemCounter = itemNumber + 1;
            });
        }

        // Update item count display
        function updateItemCount() {
            const itemCount = document.querySelectorAll('.item-card').length;
            const itemCountElement = document.getElementById('itemCount');
            if (itemCountElement) {
                itemCountElement.textContent = itemCount;
            }
        }

        // Update tombol hapus untuk item pertama
        function updateFirstItemRemoveButton() {
            const firstItem = document.querySelector('.item-card');
            if (firstItem) {
                const removeBtn = firstItem.querySelector('.remove-item-btn');
                if (removeBtn) {
                    removeBtn.disabled = true;
                    removeBtn.classList.remove('bg-gradient-to-r', 'from-danger', 'to-danger-dark', 'hover:shadow-md');
                    removeBtn.classList.add('bg-gradient-to-r', 'from-gray-300', 'to-gray-400', 'text-gray-500',
                        'cursor-not-allowed');
                    removeBtn.title = 'Item pertama tidak dapat dihapus';
                }
            }
        }

        // Reset Form
        function resetForm() {
            console.log('Resetting form...');

            itemsList.innerHTML = '';
            itemCounter = 1;

            document.getElementById('editId').value = '';
            document.getElementById('mode').value = 'create';

            multipleItemsForm.style.display = 'block';
            singleItemForm.style.display = 'none';

            formTitle.textContent = 'Input Data Stok Masuk';
            submitBtnText.textContent = 'Simpan Data & Sync ke Google Sheets';

            const allRows = document.querySelectorAll('#stokTableBody tr');
            allRows.forEach(row => row.classList.remove('edit-mode'));

            addNewItem();

            form.reset();
            document.getElementById('edit_tanggal_masuk').value = '{{ date('Y-m-d') }}';

            clearValidationStyles();

            console.log('Form has been reset');
        }

        // Edit Data
        function editData(id) {
            const row = document.getElementById(`row-${id}`);
            if (!row) {
                showNotification('Data tidak ditemukan', 'error');
                return;
            }

            const data = {
                id: id,
                tanggal_masuk: row.dataset.tanggal,
                supplier: row.dataset.supplier,
                nama_barang: row.dataset.nama,
                jumlah_masuk: row.dataset.jumlah,
                satuan: row.dataset.satuan,
                keterangan: row.dataset.keterangan || ''
            };

            isEditMode = true;
            currentEditId = id;

            showFormPage();

            formTitle.textContent = 'Edit Data Stok';
            submitBtnText.textContent = 'Update Data & Sync ke Google Sheets';

            singleItemForm.style.display = 'block';
            multipleItemsForm.style.display = 'none';

            document.getElementById('editId').value = data.id;
            document.getElementById('mode').value = 'edit';

            let formattedDate;
            try {
                const tanggalString = data.tanggal_masuk.trim();

                if (/^\d{4}-\d{2}-\d{2}$/.test(tanggalString)) {
                    formattedDate = tanggalString;
                } else {
                    const tanggal = new Date(tanggalString);

                    if (!isNaN(tanggal.getTime())) {
                        const year = tanggal.getFullYear();
                        const month = String(tanggal.getMonth() + 1).padStart(2, '0');
                        const day = String(tanggal.getDate()).padStart(2, '0');
                        formattedDate = `${year}-${month}-${day}`;
                    } else {
                        const today = new Date();
                        const year = today.getFullYear();
                        const month = String(today.getMonth() + 1).padStart(2, '0');
                        const day = String(today.getDate()).padStart(2, '0');
                        formattedDate = `${year}-${month}-${day}`;
                    }
                }
            } catch (e) {
                console.error('Error parsing date:', e);
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                formattedDate = `${year}-${month}-${day}`;
            }

            document.getElementById('edit_tanggal_masuk').value = formattedDate;
            document.getElementById('edit_supplier').value = data.supplier;
            document.getElementById('edit_nama_barang').value = data.nama_barang;
            document.getElementById('edit_jumlah_masuk').value = data.jumlah_masuk;
            document.getElementById('edit_satuan').value = data.satuan;
            document.getElementById('edit_keterangan').value = data.keterangan;

            // Load barang info untuk edit mode
            if (data.nama_barang) {
                loadBarangInfoForEdit(data.nama_barang);
            }

            const allRows = document.querySelectorAll('#stokTableBody tr');
            allRows.forEach(row => row.classList.remove('edit-mode'));
            row.classList.add('edit-mode');

            setTimeout(() => {
                document.getElementById('edit_tanggal_masuk').focus();
            }, 300);

            showNotification('Data siap diedit', 'warning');
        }

        // Load barang info untuk edit mode
        async function loadBarangInfoForEdit(namaBarang) {
            try {
                const response = await fetch(
                    `${baseUrl}/barang-masuk/get-barang-info?nama=${encodeURIComponent(namaBarang)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success && data.barang) {
                        const barang = data.barang;
                        document.getElementById('edit_kode_barang').textContent = barang.kode_barang || '-';
                        document.getElementById('edit_stok_tersedia').textContent = parseFloat(barang.stok_sekarang).toLocaleString() || '0';
                        document.getElementById('edit_satuan_utama').textContent = barang.satuan_utama || '-';
                        document.getElementById('edit_barang_info').classList.remove('hidden');
                    }
                }
            } catch (error) {
                console.error('Error loading barang info for edit:', error);
            }
        }

        // Cancel Edit Mode
        function cancelEditMode() {
            isEditMode = false;
            currentEditId = null;
            resetForm();
            showNotification('Edit dibatalkan', 'warning');
        }

        // Show sync loading
        function showSyncLoading() {
            syncLoading.classList.remove('hidden');
        }

        // Hide sync loading
        function hideSyncLoading() {
            syncLoading.classList.add('hidden');
        }

        // Delete Data
        async function deleteData(id) {
            if (!confirm(
                    'Apakah Anda yakin ingin menghapus data ini? Data akan dipindahkan ke Trash dan dapat dipulihkan nanti.'
                )) {
                return;
            }

            try {
                const deleteBtn = document.querySelector(`#row-${id} .bg-gradient-to-r.from-danger`);
                const originalHtml = deleteBtn.innerHTML;
                deleteBtn.innerHTML = '<div class="spinner"></div>';
                deleteBtn.disabled = true;

                // Show sync loading
                showSyncLoading();

                const response = await fetch(`${baseUrl}/barang-masuk/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                hideSyncLoading();
                deleteBtn.innerHTML = originalHtml;
                deleteBtn.disabled = false;

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                console.log('Delete response:', result);

                if (result.success) {
                    const row = document.getElementById(`row-${id}`);
                    if (row) {
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(-20px)';

                        setTimeout(() => {
                            row.remove();

                            const tbody = document.getElementById('stokTableBody');
                            if (tbody && tbody.children.length === 0) {
                                location.reload();
                            }
                        }, 300);
                    }

                    showNotification(result.message + ' Data telah disinkronkan ke Google Sheets.', 'success');

                    if (result.trash_count !== undefined) {
                        updateTrashButton(result.trash_count);
                    }
                } else {
                    showNotification(result.message || 'Gagal menghapus data', 'error');
                }
            } catch (error) {
                console.error('Error in deleteData:', error);
                hideSyncLoading();

                const deleteBtn = document.querySelector(`#row-${id} .bg-gradient-to-r.from-danger`);
                if (deleteBtn) {
                    deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
                    deleteBtn.disabled = false;
                }

                showNotification('Terjadi kesalahan saat menghapus data: ' + error.message, 'error');
            }
        }

        // Helper function to update trash button
        function updateTrashButton(count) {
            const trashBtn = document.querySelector('a.bg-gradient-to-r.from-amber-500');
            if (trashBtn) {
                if (count > 0) {
                    const countBadge = trashBtn.querySelector('.bg-white');
                    if (countBadge) {
                        countBadge.textContent = count;
                    }
                }
            }
        }

        // ==================== FUNGSI MODAL BARANG (SINGLE SELECTION) ====================

        function openBarangModalForSingleSelection(target) {
            currentItemId = target;
            
            // Reset selection
            selectedBarang = null;
            
            // Tampilkan modal
            barangModal.classList.remove('hidden');
            document.body.classList.add('modal-open');
            
            // Tampilkan instruksi single selection
            singleSelectionInfo.classList.remove('hidden');
            selectedBarangInfo.classList.add('hidden');
            
            // Reset selected count
            document.getElementById('selectedBarangCount').textContent = '0';
            
            // Load data barang
            loadBarangData('');
            
            // Jika mode edit, cari barang yang sudah dipilih
            if (target === 'edit') {
                const namaBarang = document.getElementById('edit_nama_barang').value;
                if (namaBarang) {
                    document.getElementById('modalInstruction').textContent = `Mengedit: ${namaBarang}`;
                }
            }

            setTimeout(() => {
                searchBarang.focus();
            }, 300);
        }

        function closeBarangModal() {
            barangModal.classList.add('hidden');
            document.body.classList.remove('modal-open');

            selectedBarang = null;
            currentItemId = null;
            searchBarang.value = '';
            
            // Reset UI
            singleSelectionInfo.classList.add('hidden');
            selectedBarangInfo.classList.add('hidden');
            document.getElementById('selectedBarangCount').textContent = '0';
        }

        // Clear barang selection
        function clearBarangSelection() {
            selectedBarang = null;
            selectedBarangInfo.classList.add('hidden');
            updateSelectedCount();
            clearSelectedRows();
        }

        // Load data barang dari server
        async function loadBarangData(search = '') {
            try {
                const tbody = document.getElementById('barangTableBody');
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="inline-block">
                                <div class="spinner mx-auto"></div>
                                <p class="mt-3 text-gray-600">Memuat data barang...</p>
                            </div>
                        </td>
                    </tr>
                `;

                const response = await fetch(
                    `${baseUrl}/barang-masuk/get-barang-data?search=${encodeURIComponent(search)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                if (!response.ok) {
                    throw new Error('Gagal mengambil data barang');
                }

                const data = await response.json();
                renderBarangTableSingleSelection(data.barang);

            } catch (error) {
                console.error('Error loading barang data:', error);

                const tbody = document.getElementById('barangTableBody');
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-red-500">
                                <i class="fas fa-exclamation-circle text-4xl mb-3"></i>
                                <p class="font-bold">Terjadi Kesalahan</p>
                                <p class="text-sm text-gray-600 mt-1">${error.message}</p>
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        // Render tabel barang untuk single selection
        function renderBarangTableSingleSelection(barangList) {
            const tbody = document.getElementById('barangTableBody');

            if (!barangList || barangList.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-box-open text-4xl mb-3"></i>
                                <p class="font-bold">Tidak Ada Data</p>
                                <p class="text-sm text-gray-600 mt-1">Tidak ditemukan data barang</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';

            barangList.forEach((barang, index) => {
                const isSelected = selectedBarang && selectedBarang.id === barang.id;

                html += `
                    <tr data-barang-id="${barang.id}" 
                        data-nama="${barang.nama_barang}"
                        data-kode="${barang.kode_barang}"
                        data-stok="${barang.stok_sekarang}"
                        data-satuan="${barang.satuan_utama}"
                        class="${isSelected ? 'row-selected' : ''} modal-row-hover hover:bg-blue-50 cursor-pointer"
                        onclick="selectSingleBarang(${barang.id}, '${barang.nama_barang}', '${barang.kode_barang}', '${barang.stok_sekarang}', '${barang.satuan_utama}')">
                        <td class="px-6 py-4 whitespace-nowrap" onclick="event.stopPropagation()">
                            <input type="radio" 
                                   name="barang_selection"
                                   class="single-selection-radio"
                                   data-id="${barang.id}"
                                   data-nama="${barang.nama_barang}"
                                   data-kode="${barang.kode_barang}"
                                   data-stok="${barang.stok_sekarang}"
                                   data-satuan="${barang.satuan_utama}"
                                   ${isSelected ? 'checked' : ''}
                                   onchange="selectSingleBarang(${barang.id}, '${barang.nama_barang}', '${barang.kode_barang}', '${barang.stok_sekarang}', '${barang.satuan_utama}')">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">${barang.kode_barang}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">${barang.nama_barang}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                ${barang.satuan_utama}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold ${barang.stok_sekarang > 0 ? 'text-green-600' : 'text-red-600'}">
                                ${parseFloat(barang.stok_sekarang).toLocaleString()}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ${barang.status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                ${barang.status ? 'Aktif' : 'Nonaktif'}
                            </span>
                        </td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
            updateSelectedCount();
        }

        // Select single barang
        function selectSingleBarang(id, nama, kode, stok, satuan) {
            // Simpan hanya 1 barang yang dipilih
            selectedBarang = {
                id: id,
                nama: nama,
                kode: kode,
                stok: stok,
                satuan: satuan
            };

            // Update UI
            updateSelectedCount();
            updateSelectedBarangInfo();
            updateSelectedRows();
        }

        // Update selected rows highlighting
        function updateSelectedRows() {
            const allRows = document.querySelectorAll('#barangTableBody tr');
            allRows.forEach(row => {
                const barangId = parseInt(row.dataset.barangId);
                const radioBtn = row.querySelector('.single-selection-radio');
                
                if (selectedBarang && barangId === selectedBarang.id) {
                    row.classList.add('row-selected');
                    if (radioBtn) radioBtn.checked = true;
                } else {
                    row.classList.remove('row-selected');
                    if (radioBtn) radioBtn.checked = false;
                }
            });
        }

        // Clear selected rows
        function clearSelectedRows() {
            const allRows = document.querySelectorAll('#barangTableBody tr');
            allRows.forEach(row => {
                row.classList.remove('row-selected');
                const radioBtn = row.querySelector('.single-selection-radio');
                if (radioBtn) radioBtn.checked = false;
            });
        }

        // Update selected barang info
        function updateSelectedBarangInfo() {
            if (selectedBarang) {
                selectedBarangName.textContent = `${selectedBarang.nama} (${selectedBarang.kode})`;
                selectedBarangInfo.classList.remove('hidden');
            } else {
                selectedBarangInfo.classList.add('hidden');
            }
        }

        // Update selected count (selalu 0 atau 1)
        function updateSelectedCount() {
            const count = selectedBarang ? 1 : 0;
            document.getElementById('selectedBarangCount').textContent = count;
        }

        // Confirm single barang selection
        function confirmSingleBarangSelection() {
            if (!selectedBarang) {
                showNotification('Pilih 1 barang terlebih dahulu', 'warning');
                return;
            }

            if (currentItemId === 'edit') {
                // Mode edit
                document.getElementById('edit_nama_barang').value = selectedBarang.nama;
                document.getElementById('edit_kode_barang').textContent = selectedBarang.kode;
                document.getElementById('edit_stok_tersedia').textContent = parseFloat(selectedBarang.stok).toLocaleString();
                document.getElementById('edit_satuan_utama').textContent = selectedBarang.satuan;
                document.getElementById('edit_barang_info').classList.remove('hidden');
                
                // Set satuan default
                document.getElementById('edit_satuan').value = selectedBarang.satuan;
                
                showNotification(`Barang "${selectedBarang.nama}" dipilih`, 'success');
            } else {
                // Mode create (multiple items)
                const itemCard = document.getElementById(currentItemId);
                if (itemCard) {
                    const namaInput = itemCard.querySelector('.item-nama');
                    const barangIdInput = itemCard.querySelector(`#barang-id-${currentItemId}`);
                    const barangInfoDiv = itemCard.querySelector(`#barang-info-${currentItemId}`);
                    
                    if (namaInput) namaInput.value = selectedBarang.nama;
                    if (barangIdInput) barangIdInput.value = selectedBarang.id;
                    
                    // Update barang info
                    const kodeElement = itemCard.querySelector(`#kode-${currentItemId}`);
                    const stokElement = itemCard.querySelector(`#stok-${currentItemId}`);
                    const satuanElement = itemCard.querySelector(`#satuan-${currentItemId}`);
                    
                    if (kodeElement) kodeElement.textContent = selectedBarang.kode;
                    if (stokElement) stokElement.textContent = parseFloat(selectedBarang.stok).toLocaleString();
                    if (satuanElement) satuanElement.textContent = selectedBarang.satuan;
                    
                    // Show barang info
                    if (barangInfoDiv) barangInfoDiv.classList.remove('hidden');
                    
                    // Set satuan default
                    const satuanInput = itemCard.querySelector('.item-satuan');
                    if (satuanInput) satuanInput.value = selectedBarang.satuan;
                    
                    // Update status
                    const statusElement = itemCard.querySelector('.item-status');
                    if (statusElement) {
                        statusElement.classList.remove('bg-yellow-100', 'text-yellow-800');
                        statusElement.classList.add('bg-green-100', 'text-green-800');
                        statusElement.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Barang dipilih';
                    }
                    
                    // Highlight card
                    itemCard.classList.add('item-card-selected');
                    
                    showNotification(`Barang "${selectedBarang.nama}" ditambahkan ke item`, 'success');
                }
            }

            closeBarangModal();
        }

        // ==================== FUNGSI MODAL SATUAN ====================

        function openSatuanModal(satuanInputId) {
            currentSatuanModalTarget = satuanInputId;

            satuanModal.classList.remove('hidden');
            document.body.classList.add('modal-open');

            loadSatuanData('');

            setTimeout(() => {
                searchSatuan.focus();
            }, 300);
        }

        function openSatuanModalForItem(itemId) {
            const itemCard = document.getElementById(itemId);
            if (!itemCard) return;

            const satuanInput = itemCard.querySelector('.item-satuan');

            if (satuanInput) {
                currentSatuanModalTarget = satuanInput.name;

                satuanModal.classList.remove('hidden');
                document.body.classList.add('modal-open');

                loadSatuanData('');

                setTimeout(() => {
                    searchSatuan.focus();
                }, 300);
            }
        }

        function closeSatuanModal() {
            satuanModal.classList.add('hidden');
            document.body.classList.remove('modal-open');

            currentSatuanModalTarget = null;
            searchSatuan.value = '';
        }

        // Load data satuan dari server
        async function loadSatuanData(search = '') {
            try {
                const tbody = document.getElementById('satuanTableBody');
                tbody.innerHTML = `
            <tr>
                <td colspan="4" class="px-6 py-12 text-center">
                    <div class="inline-block">
                        <div class="spinner mx-auto"></div>
                        <p class="mt-3 text-gray-600">Memuat data satuan...</p>
                    </div>
                </td>
            </tr>
        `;

                const url = `${baseUrl}/barang-masuk/get-satuan-data?search=${encodeURIComponent(search)}`;
                console.log('Loading satuan data from:', url);

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                console.log('Response status:', response.status);

                if (!response.ok) {
                    throw new Error(`Gagal mengambil data satuan. Status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Satuan data received:', data);

                if (data.success) {
                    renderSatuanTable(data.satuan);
                } else {
                    throw new Error(data.message || 'Data tidak valid diterima dari server');
                }

            } catch (error) {
                console.error('Error loading satuan data:', error);

                const tbody = document.getElementById('satuanTableBody');
                tbody.innerHTML = `
            <tr>
                <td colspan="4" class="px-6 py-12 text-center">
                    <div class="text-red-500">
                        <i class="fas fa-exclamation-circle text-4xl mb-3"></i>
                        <p class="font-bold">Terjadi Kesalahan</p>
                        <p class="text-sm text-gray-600 mt-1">${error.message}</p>
                        <button onclick="loadSatuanData()" class="mt-3 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-all">
                            Coba Lagi
                        </button>
                    </div>
                </td>
            </tr>
        `;
            }
        }

        // Render tabel satuan
        function renderSatuanTable(satuansList) {
            const tbody = document.getElementById('satuanTableBody');

            if (!satuansList || satuansList.length === 0) {
                tbody.innerHTML = `
            <tr>
                <td colspan="4" class="px-6 py-12 text-center">
                    <div class="text-gray-500">
                        <i class="fas fa-balance-scale text-4xl mb-3"></i>
                        <p class="font-bold">Tidak Ada Data</p>
                        <p class="text-sm text-gray-600 mt-1">Tidak ditemukan data satuan</p>
                    </div>
                </td>
            </tr>
        `;
                return;
            }

            let html = '';

            satuansList.forEach((satuan, index) => {
                const satuanInput = escapeHtml(satuan.satuan_input || '');
                const satuanUtama = escapeHtml(satuan.satuan_utama || '');
                const faktor = satuan.faktor ? parseFloat(satuan.faktor).toFixed(5) : '0.00000';

                const escapedSatuanForClick = satuanInput
                    .replace(/'/g, "\\'")
                    .replace(/"/g, '\\"')
                    .replace(/\\/g, '\\\\');

                html += `
            <tr data-satuan="${satuanInput}"
                class="satuan-row-hover hover:bg-blue-50 cursor-pointer"
                onclick="selectSatuanSafe('${escapedSatuanForClick}')">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${index + 1}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-bold text-gray-900">${satuanInput}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${satuanUtama}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-mono text-gray-900">${faktor}</div>
                </td>
            </tr>
        `;
            });

            tbody.innerHTML = html;
        }

        // Helper function untuk escape HTML
        function escapeHtml(text) {
            if (!text) return '';
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.toString().replace(/[&<>"']/g, function(m) {
                return map[m];
            });
        }

        // Fungsi aman untuk select satuan
        function selectSatuanSafe(satuan) {
            if (currentSatuanModalTarget) {
                const decodedSatuan = satuan
                    .replace(/\\'/g, "'")
                    .replace(/\\"/g, '"')
                    .replace(/\\\\/g, '\\');

                if (currentSatuanModalTarget === 'edit_satuan') {
                    document.getElementById('edit_satuan').value = decodedSatuan;
                } else {
                    const satuanInput = document.querySelector(`[name="${currentSatuanModalTarget}"]`);
                    if (satuanInput) satuanInput.value = decodedSatuan;
                }

                showNotification(`Satuan "${decodedSatuan}" dipilih`, 'success');
                closeSatuanModal();
            }
        }

        // Form Submission Handler dengan Auto-Sync
        async function handleSubmit(e) {
            e.preventDefault();
            console.log('Form submission started...');

            const mode = document.getElementById('mode').value;
            const editId = document.getElementById('editId').value;

            console.log('Mode:', mode);
            console.log('Edit ID:', editId);

            clearValidationStyles();

            let isValid = true;
            let errorMessages = [];

            if (mode === 'edit') {
                console.log('Validating single edit form...');

                const requiredFields = [{
                        id: 'edit_tanggal_masuk',
                        name: 'Tanggal Masuk'
                    },
                    {
                        id: 'edit_supplier',
                        name: 'Supplier'
                    },
                    {
                        id: 'edit_nama_barang',
                        name: 'Nama Barang'
                    },
                    {
                        id: 'edit_jumlah_masuk',
                        name: 'Jumlah'
                    },
                    {
                        id: 'edit_satuan',
                        name: 'Satuan'
                    }
                ];

                requiredFields.forEach(field => {
                    const input = document.getElementById(field.id);
                    console.log(`Field ${field.name}:`, input.value);

                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('border-red-500', 'ring-2', 'ring-red-300');
                        errorMessages.push(`${field.name} harus diisi`);
                    }
                });

                const jumlahInput = document.getElementById('edit_jumlah_masuk');
                if (jumlahInput.value && (isNaN(jumlahInput.value) || parseFloat(jumlahInput.value) <= 0)) {
                    isValid = false;
                    jumlahInput.classList.add('border-red-500', 'ring-2', 'ring-red-300');
                    errorMessages.push('Jumlah harus angka positif');
                }
            } else {
                console.log('Validating multiple items form...');
                const itemCards = document.querySelectorAll('.item-card');

                if (itemCards.length === 0) {
                    isValid = false;
                    errorMessages.push('Minimal harus ada 1 item');
                    console.log('No items found');
                }

                itemCards.forEach((card, index) => {
                    const itemNumber = index + 1;
                    const itemId = card.id;
                    const tanggalInput = card.querySelector('.item-tanggal');
                    const supplierInput = card.querySelector('.item-supplier');
                    const namaInput = card.querySelector('.item-nama');
                    const jumlahInput = card.querySelector('.item-jumlah');
                    const satuanInput = card.querySelector('.item-satuan');
                    const barangIdInput = card.querySelector(`#barang-id-${itemId}`);

                    // Validasi barang dipilih
                    if (!namaInput.value.trim() || !barangIdInput.value.trim()) {
                        isValid = false;
                        namaInput.classList.add('border-red-500', 'ring-2', 'ring-red-300');
                        errorMessages.push(`Item ${itemNumber}: Silakan pilih barang dari daftar`);
                    }

                    const inputs = [{
                            input: tanggalInput,
                            name: 'Tanggal Masuk'
                        },
                        {
                            input: supplierInput,
                            name: 'Supplier'
                        },
                        {
                            input: namaInput,
                            name: 'Nama Barang'
                        },
                        {
                            input: jumlahInput,
                            name: 'Jumlah'
                        },
                        {
                            input: satuanInput,
                            name: 'Satuan'
                        }
                    ];

                    inputs.forEach(({
                        input,
                        name
                    }) => {
                        if (input && name !== 'Nama Barang') { // Nama barang sudah divalidasi di atas
                            if (!input.value.trim()) {
                                isValid = false;
                                input.classList.add('border-red-500', 'ring-2', 'ring-red-300');
                                errorMessages.push(`Item ${itemNumber}: ${name} harus diisi`);
                            }

                            if (input === jumlahInput && input.value) {
                                if (isNaN(input.value) || parseFloat(input.value) <= 0) {
                                    isValid = false;
                                    input.classList.add('border-red-500', 'ring-2', 'ring-red-300');
                                    errorMessages.push(
                                        `Item ${itemNumber}: Jumlah harus angka positif`);
                                }
                            }
                        }
                    });
                });
            }

            if (!isValid) {
                console.log('Validation failed:', errorMessages);
                showNotification(errorMessages.slice(0, 3).join(', ') + (errorMessages.length > 3 ? '...' : ''),
                    'error');
                return;
            }

            console.log('Form validation passed, preparing data...');

            const formData = new FormData();
            let url, method;

            if (mode === 'edit') {
                url = `${baseUrl}/barang-masuk/${editId}`;
                method = 'POST';

                formData.append('_method', 'PUT');
                formData.append('_token', csrfToken);
                formData.append('tanggal_masuk', document.getElementById('edit_tanggal_masuk').value);
                formData.append('supplier', document.getElementById('edit_supplier').value);
                formData.append('nama_barang', document.getElementById('edit_nama_barang').value);
                formData.append('jumlah_masuk', document.getElementById('edit_jumlah_masuk').value);
                formData.append('satuan', document.getElementById('edit_satuan').value);
                formData.append('keterangan', document.getElementById('edit_keterangan').value || '');

                console.log('Edit data prepared:', {
                    tanggal_masuk: document.getElementById('edit_tanggal_masuk').value,
                    supplier: document.getElementById('edit_supplier').value,
                    nama_barang: document.getElementById('edit_nama_barang').value,
                    jumlah_masuk: document.getElementById('edit_jumlah_masuk').value,
                    satuan: document.getElementById('edit_satuan').value,
                    keterangan: document.getElementById('edit_keterangan').value
                });
            } else {
                url = `${baseUrl}/barang-masuk/store-multiple`;
                method = 'POST';

                const itemCards = document.querySelectorAll('.item-card');

                console.log('Total item cards found:', itemCards.length);

                itemCards.forEach((card, index) => {
                    const itemId = card.id;
                    const tanggal_masuk = card.querySelector('.item-tanggal').value;
                    const supplier = card.querySelector('.item-supplier').value;
                    const nama_barang = card.querySelector('.item-nama').value;
                    const jumlah_masuk = card.querySelector('.item-jumlah').value;
                    const satuan = card.querySelector('.item-satuan').value;
                    const keterangan = card.querySelector('.item-keterangan').value || '';
                    const barang_id = card.querySelector(`#barang-id-${itemId}`).value;

                    console.log(`Item ${index}:`, {
                        itemId,
                        tanggal_masuk,
                        supplier,
                        nama_barang,
                        barang_id,
                        jumlah_masuk,
                        satuan,
                        keterangan
                    });

                    formData.append(`items[${index}][tanggal_masuk]`, tanggal_masuk);
                    formData.append(`items[${index}][supplier]`, supplier);
                    formData.append(`items[${index}][nama_barang]`, nama_barang);
                    formData.append(`items[${index}][barang_id]`, barang_id);
                    formData.append(`items[${index}][jumlah_masuk]`, jumlah_masuk);
                    formData.append(`items[${index}][satuan]`, satuan);
                    formData.append(`items[${index}][keterangan]`, keterangan);
                });

                formData.append('_token', csrfToken);

                console.log('FormData contents:');
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
            }

            // Show loading state with sync indicator
            submitBtn.disabled = true;
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = `
        <div class="spinner"></div>
        <span>Menyimpan & Menyinkronkan...</span>
    `;

            // Show sync loading overlay
            showSyncLoading();

            console.log('Sending request to:', url);
            console.log('Method:', method);

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                console.log('Response status:', response.status);

                let result;
                try {
                    result = await response.json();
                    console.log('Response data:', result);
                } catch (jsonError) {
                    console.error('Error parsing JSON:', jsonError);
                    throw new Error('Response bukan format JSON yang valid');
                }

                // Hide sync loading overlay
                setTimeout(() => {
                    hideSyncLoading();
                }, 1000);

                if (response.ok && result.success) {
                    showNotification(result.message + ' Data telah disinkronkan ke Google Sheets.', 'success');

                    // Kembali ke halaman data setelah delay
                    setTimeout(() => {
                        showDataPage();
                        location.reload();
                    }, 1500);
                } else {
                    if (result.errors) {
                        const errorMessages = Object.values(result.errors).flat();
                        showNotification(errorMessages.join(', '), 'error');
                    } else {
                        showNotification(result.message || 'Terjadi kesalahan', 'error');
                    }
                }
            } catch (error) {
                console.error('Error in handleSubmit:', error);
                hideSyncLoading();
                showNotification('Terjadi kesalahan saat menyimpan data: ' + error.message, 'error');
            } finally {
                // Reset button state
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }, 1000);
            }
        }

        // Responsive adjustments
        window.addEventListener('resize', function() {
            if (window.innerWidth < 768) {
                // Mobile-specific adjustments
            }
        });
    </script>
</body>

</html>