<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Inventory System</title>

    <!-- Tailwind CSS dengan config lengkap -->
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
                        'amber-500': '#f59e0b',
                        'amber-600': '#d97706',
                        'cyan-600': '#0891b2',
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
                        'fade-in': 'fadeIn 0.3s ease',
                        'spin': 'spin 1s linear infinite',
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles dengan fallback -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
        }

        /* ===== FALLBACK STYLES ===== */
        :root {
            --color-primary: #3b82f6;
            --color-primary-dark: #2563eb;
            --color-success: #10b981;
            --color-success-dark: #059669;
            --color-danger: #ef4444;
            --color-danger-dark: #dc2626;
            --color-warning: #f59e0b;
            --color-warning-dark: #d97706;
            --color-info: #06b6d4;
            --color-dark: #1f2937;
            --color-light: #f9fafb;
            --color-amber-500: #f59e0b;
            --color-amber-600: #d97706;
            --color-cyan-600: #0891b2;
            --color-gray-50: #f9fafb;
            --color-gray-100: #f3f4f6;
            --color-gray-200: #e5e7eb;
            --color-gray-300: #d1d5db;
            --color-gray-400: #9ca3af;
            --color-gray-500: #6b7280;
            --color-gray-600: #4b5563;
            --color-gray-700: #374151;
            --color-gray-800: #1f2937;
            --color-gray-900: #111827;
            --color-blue-50: #eff6ff;
            --color-blue-100: #dbeafe;
            --color-blue-200: #bfdbfe;
            --color-blue-500: #3b82f6;
            --color-blue-600: #2563eb;
            --color-green-100: #d1fae5;
            --color-green-500: #10b981;
            --color-green-600: #059669;
            --color-red-100: #fee2e2;
            --color-red-500: #ef4444;
            --color-red-600: #dc2626;
            --color-white: #ffffff;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-container {
            background: white;
            border-radius: 1rem;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow: hidden;
            transform: translateY(-20px);
            transition: transform 0.3s;
        }

        .modal-overlay.active .modal-container {
            transform: translateY(0);
        }

        /* Table Styles untuk Modal */
        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-container th {
            position: sticky;
            top: 0;
            background: var(--color-primary);
            color: white;
            font-weight: 600;
            z-index: 10;
        }

        .table-container tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }

        .selectable-row {
            cursor: pointer;
            transition: all 0.2s;
        }

        .selectable-row:hover {
            background-color: var(--color-blue-50) !important;
        }

        .selected-row {
            background-color: var(--color-blue-100) !important;
            border-left: 4px solid var(--color-primary);
        }

        @media (max-width: 768px) {
            .modal-container {
                width: 95%;
                max-height: 80vh;
            }

            .table-container {
                max-height: 300px;
            }
            
            /* Responsive form layout */
            .form-grid {
                grid-template-columns: 1fr !important;
            }
        }

        /* Animasi spinner */
        .spinner {
            border: 3px solid rgba(59, 130, 246, 0.2);
            border-radius: 50%;
            border-top: 3px solid var(--color-primary);
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Style untuk hidden class */
        .hidden {
            display: none !important;
        }

        /* Enhanced input styles */
        .form-input {
            transition: all 0.3s ease;
            border-width: 2px;
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }

        /* Custom button styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--color-success), var(--color-success-dark));
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-gray {
            background: linear-gradient(135deg, var(--color-gray-500), var(--color-gray-600));
            transition: all 0.3s ease;
        }

        .btn-gray:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(107, 114, 128, 0.3);
        }

        /* Card styles */
        .card {
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Label styles */
        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .form-label i {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        /* Info text styles */
        .form-info {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 6px;
            font-size: 13px;
        }

        .form-info i {
            font-size: 14px;
            color: var(--color-primary);
        }

        /* Header enhancements */
        .page-header {
            border-radius: 20px;
            overflow: hidden;
        }

        /* Form grid layout */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }

        /* Fieldset styling */
        .field-group {
            background: var(--color-gray-50);
            border-radius: 12px;
            padding: 20px;
            border: 2px solid var(--color-gray-200);
            transition: border-color 0.3s ease;
        }

        .field-group:focus-within {
            border-color: var(--color-primary);
            background: var(--color-white);
        }

        /* Required field indicator */
        .required-field::after {
            content: " *";
            color: var(--color-danger);
            font-weight: bold;
        }

        /* Search button enhancement - FIXED */
        .search-btn {
            position: absolute;
            right: 2px;
            top: 2px;
            bottom: 2px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            min-height: 44px;
        }

        .search-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .search-btn i {
            font-size: 16px;
        }

        /* Input dengan tombol search */
        .input-with-search {
            position: relative;
        }

        .input-with-search input {
            padding-right: 100px !important;
        }

        /* Perbaikan untuk mobile */
        @media (max-width: 640px) {
            .search-btn {
                padding: 0 12px;
                font-size: 13px;
            }
            
            .search-btn span {
                display: none;
            }
            
            .search-btn i {
                font-size: 16px;
                margin: 0;
            }
            
            .input-with-search input {
                padding-right: 60px !important;
            }
        }

        /* Modal search input */
        .modal-search-input {
            padding-left: 48px !important;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-4 right-4 z-50 w-full max-w-sm space-y-3"></div>

    <!-- Modal untuk Pilih Satuan -->
    <div id="satuanModal" class="modal-overlay">
        <div class="modal-container shadow-hard">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-primary to-primary-dark p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-white">Pilih Satuan Utama</h3>
                        <p class="text-blue-100 mt-1">Pilih satuan dari daftar yang tersedia</p>
                    </div>
                    <button onclick="closeModal()" class="text-white hover:text-gray-200 text-2xl transition-transform hover:scale-110">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Search -->
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <div class="relative">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                        <i class="fas fa-search text-gray-400 text-lg"></i>
                    </div>
                    <input type="text" id="searchSatuan"
                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all modal-search-input"
                        placeholder="Cari satuan...">
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-6 table-container">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-white">No</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-white">Satuan Utama</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-white">Satuan Input</th>
                            <th class="px-4 py-4 text-left text-sm font-semibold text-white">Faktor</th>
                        </tr>
                    </thead>
                    <tbody id="satuanTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </table>

                <div id="loadingSpinner" class="text-center py-8">
                    <div class="spinner mx-auto"></div>
                    <p class="text-gray-500 mt-3 text-sm font-medium">Memuat data satuan...</p>
                </div>

                <div id="noResults" class="text-center py-8 hidden">
                    <div class="mb-3">
                        <i class="fas fa-search text-gray-400 text-5xl mb-2"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Tidak ada satuan yang ditemukan</p>
                    <p class="text-gray-400 text-sm mt-1">Coba dengan kata kunci yang berbeda</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-gray-200 p-4 bg-gray-50">
                <div class="flex justify-end space-x-3">
                    <button onclick="closeModal()"
                        class="px-5 py-3 border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-all hover:border-gray-400">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <button onclick="useSelectedSatuan()" id="selectButton"
                        class="px-5 py-3 bg-primary text-white rounded-xl hover:bg-primary-dark disabled:opacity-50 disabled:cursor-not-allowed font-medium transition-all hover:shadow-lg flex items-center gap-2"
                        disabled>
                        <i class="fas fa-check"></i>
                        Pilih Satuan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="min-h-screen">
        <!-- Header -->
        <header class="page-header bg-white shadow-hard mx-4 lg:mx-8 mt-4 mb-8 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start gap-4 mb-3">
                        <div class="bg-gradient-to-br from-success to-success-dark p-4 rounded-2xl shadow-lg">
                            <i class="fas fa-plus-circle text-white text-3xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-dark">Tambah Data Barang</h1>
                            <p class="text-gray-600 mt-2">Input data barang baru ke sistem inventory</p>
                            <div class="mt-3">
                                <span
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-50 to-green-100 text-green-800 border border-green-200">
                                    <i class="fas fa-sync-alt animate-pulse"></i>
                                    Auto-sync Google Sheets Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-end">
                    <a href="{{ route('barang.index') }}"
                        class="btn-gray text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left text-lg"></i>
                        <span class="font-medium">Kembali ke Data</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Form Section -->
        <div class="mx-4 lg:mx-8 mb-8">
            <div class="card bg-white shadow-lg">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-primary to-primary-dark p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="bg-white p-4 rounded-2xl shadow-lg">
                                <i class="fas fa-edit text-primary text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Form Input Barang</h2>
                                <p class="text-blue-100 mt-2">Isi form berikut untuk menambahkan data barang baru</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 bg-white/20 p-3 rounded-xl backdrop-blur-sm">
                            <div class="bg-white/30 p-2 rounded-lg">
                                <i class="fas fa-info-circle text-white text-lg"></i>
                            </div>
                            <span class="text-white text-sm font-medium">
                                Field bertanda <span class="text-red-300 font-bold">*</span> wajib diisi
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-6 lg:p-8">
                    <form id="barangForm" method="POST" action="{{ route('barang.store') }}" novalidate>
                        @csrf

                        <div class="form-grid mb-8">
                            <!-- Kode Barang -->
                            <div class="field-group lg:col-span-2">
                                <label class="form-label text-gray-700">
                                    <i class="fas fa-barcode text-primary"></i>
                                    Kode Barang
                                    <span class="required-field"></span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="kode_barang"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input bg-gray-100 font-medium"
                                        value="{{ $kodeBarang }}" readonly>
                                    <div class="absolute right-3 top-3">
                                        <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-lg text-sm font-medium">
                                            <i class="fas fa-lock mr-1"></i> Auto-generate
                                        </span>
                                    </div>
                                </div>
                                <p class="form-info text-gray-500">
                                    <i class="fas fa-info-circle"></i>
                                    Kode barang otomatis dibuat oleh sistem
                                </p>
                            </div>

                            <!-- Nama Barang -->
                            <div class="field-group lg:col-span-2">
                                <label class="form-label text-gray-700">
                                    <i class="fas fa-box text-primary"></i>
                                    Nama Barang
                                    <span class="required-field"></span>
                                </label>
                                <input type="text" name="nama_barang"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input"
                                    placeholder="Masukkan nama barang" required>
                                <p class="form-info text-gray-500">
                                    <i class="fas fa-lightbulb"></i>
                                    Nama lengkap barang untuk identifikasi
                                </p>
                            </div>

                            <!-- Satuan Utama - PERBAIKAN UTAMA -->
                            <div class="field-group">
                                <label class="form-label text-gray-700">
                                    <i class="fas fa-balance-scale text-primary"></i>
                                    Satuan Utama
                                    <span class="required-field"></span>
                                </label>
                                <div class="input-with-search">
                                    <input type="text" name="satuan_utama" id="satuan_utama_input"
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input bg-white cursor-pointer"
                                        placeholder="Klik untuk memilih satuan" required readonly>
                                    <button type="button" onclick="openSatuanModal()"
                                        class="search-btn">
                                        <i class="fas fa-search"></i>
                                        <span class="hidden sm:inline">Cari</span>
                                    </button>
                                </div>
                                <p class="form-info text-gray-500">
                                    <i class="fas fa-mouse-pointer"></i>
                                    Klik tombol <span class="font-medium text-primary">Cari</span> untuk memilih satuan
                                </p>

                                <!-- Input tersembunyi untuk menyimpan ID satuan -->
                                <input type="hidden" name="satuan_id" id="satuan_id">
                            </div>

                            <!-- Stok Awal -->
                            <div class="field-group">
                                <label class="form-label text-gray-700">
                                    <i class="fas fa-cubes text-primary"></i>
                                    Stok Awal
                                    <span class="required-field"></span>
                                </label>
                                <input type="number" name="stok_awal"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input"
                                    min="0" step="0.01" placeholder="0" required>
                                <p class="form-info text-gray-500">
                                    <i class="fas fa-database"></i>
                                    Jumlah stok awal barang dalam satuan utama
                                </p>
                            </div>

                            <!-- Faktor Konversi -->
                            <div class="field-group">
                                <label class="form-label text-gray-700">
                                    <i class="fas fa-calculator text-primary"></i>
                                    Faktor Konversi
                                    <span class="required-field"></span>
                                </label>
                                <input type="number" name="faktor_konversi"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all form-input"
                                    min="0.01" step="0.01" placeholder="1.00" value="1.00" required>
                                <p class="form-info text-gray-500">
                                    <i class="fas fa-exchange-alt"></i>
                                    Faktor konversi ke satuan input
                                </p>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="pt-8 border-t border-gray-200 mt-6">
                            <div class="flex flex-col lg:flex-row gap-4">
                                <a href="{{ route('barang.index') }}"
                                    class="btn-gray text-white font-semibold py-4 px-8 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 flex-1 text-lg">
                                    <i class="fas fa-times-circle text-xl"></i>
                                    <span class="font-semibold">Batal</span>
                                </a>

                                <button type="submit"
                                    class="btn-success text-white font-semibold py-4 px-8 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 flex-1 text-lg">
                                    <i class="fas fa-save text-xl"></i>
                                    <span class="font-semibold">Simpan & Sync ke Google Sheets</span>
                                </button>
                            </div>
                            
                            <!-- Additional Info -->
                            <div class="mt-6 text-center">
                                <p class="text-gray-500 text-sm">
                                    <i class="fas fa-shield-alt mr-2 text-primary"></i>
                                    Data akan tersimpan di database lokal dan tersinkronisasi dengan Google Sheets secara otomatis
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variabel global
        let satuanData = [];
        let selectedSatuan = null;
        let currentRowId = null;
        let searchTimeout;

        // Fungsi untuk membuka modal satuan
        function openSatuanModal() {
            const modal = document.getElementById('satuanModal');
            modal.classList.add('active');

            // Reset search input
            document.getElementById('searchSatuan').value = '';

            // Reset pilihan
            selectedSatuan = null;
            document.getElementById('selectButton').disabled = true;

            // Load data segar setiap kali modal dibuka
            loadSatuanData();

            // Reset currentRowId
            currentRowId = null;
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            const modal = document.getElementById('satuanModal');
            modal.classList.remove('active');
        }

        // Fungsi untuk memuat data satuan dari API
        async function loadSatuanData() {
            const loadingSpinner = document.getElementById('loadingSpinner');
            const noResults = document.getElementById('noResults');
            const tableBody = document.getElementById('satuanTableBody');

            loadingSpinner.classList.remove('hidden');
            noResults.classList.add('hidden');
            tableBody.innerHTML = '';

            try {
                // Ganti dengan endpoint yang sesuai untuk mengambil data satuan
                const response = await fetch('/api/satuan');
                satuanData = await response.json();

                loadingSpinner.classList.add('hidden');

                if (satuanData.length === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    renderSatuanTable(satuanData);
                }
            } catch (error) {
                console.error('Error loading satuan data:', error);
                loadingSpinner.classList.add('hidden');
                noResults.classList.remove('hidden');
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-red-500">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-exclamation-triangle text-2xl"></i>
                                <span>Gagal memuat data satuan</span>
                                <button onclick="loadSatuanData()" class="mt-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        // Fungsi untuk render tabel satuan dengan highlight
        function renderSatuanTable(data) {
            const tableBody = document.getElementById('satuanTableBody');
            const noResults = document.getElementById('noResults');

            tableBody.innerHTML = '';

            if (data.length === 0) {
                noResults.classList.remove('hidden');
                return;
            }

            noResults.classList.add('hidden');

            data.forEach((satuan, index) => {
                const row = document.createElement('tr');
                row.id = `row-${satuan.id || index}`;
                row.className = 'selectable-row hover:bg-blue-50 transition-colors';

                // Tambahkan event listener untuk klik baris
                row.addEventListener('click', () => selectSatuanRow(satuan, row.id));

                // Highlight satuan yang sudah dipilih sebelumnya
                const currentSatuanValue = document.getElementById('satuan_utama_input').value;
                if (currentSatuanValue === satuan.satuan_utama) {
                    row.classList.add('selected-row');
                    selectedSatuan = satuan;
                    currentRowId = row.id;
                    document.getElementById('selectButton').disabled = false;
                }

                row.innerHTML = `
                    <td class="px-4 py-3 text-center font-medium">${index + 1}</td>
                    <td class="px-4 py-3 font-semibold text-gray-800">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-weight text-primary"></i>
                            ${satuan.satuan_utama || satuan.nama}
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-600">${satuan.satuan_input || '-'}</td>
                    <td class="px-4 py-3 text-right font-semibold text-primary">
                        ${parseFloat(satuan.faktor || 0).toFixed(2)}
                    </td>
                `;

                tableBody.appendChild(row);
            });
        }

        // Fungsi untuk memilih baris satuan
        function selectSatuanRow(satuan, rowId) {
            // Remove selection from all rows
            document.querySelectorAll('.selectable-row').forEach(row => {
                row.classList.remove('selected-row');
            });

            // Add selection to clicked row
            const selectedRow = document.getElementById(rowId);
            if (selectedRow) {
                selectedRow.classList.add('selected-row');
            }

            // Store selected satuan
            selectedSatuan = satuan;
            currentRowId = rowId;

            // Enable select button
            const selectButton = document.getElementById('selectButton');
            selectButton.disabled = false;
            selectButton.innerHTML = `
                <i class="fas fa-check"></i>
                Pilih "${satuan.satuan_utama || satuan.nama}"
            `;
        }

        // Fungsi untuk menggunakan satuan yang dipilih
        function useSelectedSatuan() {
            if (selectedSatuan) {
                const satuanInput = document.getElementById('satuan_utama_input');
                const satuanIdInput = document.getElementById('satuan_id');

                // Set nilai input
                satuanInput.value = selectedSatuan.satuan_utama || selectedSatuan.nama;

                // Set ID jika ada
                if (selectedSatuan.id) {
                    satuanIdInput.value = selectedSatuan.id;
                }

                // Tutup modal
                closeModal();

                // Tampilkan notifikasi
                showNotification(
                    `Satuan <span class="font-semibold">"${selectedSatuan.satuan_utama || selectedSatuan.nama}"</span> berhasil dipilih`,
                    'success'
                );
            } else {
                showNotification('Silakan pilih satuan terlebih dahulu', 'error');
            }
        }

        // Fungsi untuk mencari satuan
        document.getElementById('searchSatuan').addEventListener('input', function(e) {
            clearTimeout(searchTimeout);

            const searchTerm = e.target.value.toLowerCase().trim();

            searchTimeout = setTimeout(() => {
                if (searchTerm === '') {
                    // Jika kosong, tampilkan semua data asli dari API
                    renderSatuanTable(satuanData);
                } else {
                    const filteredData = satuanData.filter(satuan => {
                        return (
                            (satuan.satuan_utama && satuan.satuan_utama.toLowerCase().includes(searchTerm)) ||
                            (satuan.satuan_input && satuan.satuan_input.toLowerCase().includes(searchTerm))
                        );
                    });

                    renderSatuanTable(filteredData);
                }
            }, 300); // Debounce 300ms
        });

        // Tutup modal saat klik di luar konten modal
        document.getElementById('satuanModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Tutup modal dengan tombol ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Show notification
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
            notification.className = `${typeStyles[type]} text-white rounded-r-lg shadow-hard p-4 animate-fade-in`;
            notification.innerHTML = `
                <div class="flex items-start">
                    <i class="fas ${icons[type]} text-xl mr-3 mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1">
                        <p class="font-medium">${message}</p>
                    </div>
                    <button onclick="removeNotification('${notificationId}')" 
                            class="ml-3 text-white hover:text-gray-200 transition-colors flex-shrink-0">
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

        function removeNotification(id) {
            const notification = document.getElementById(id);
            if (notification) {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }
        }

        // Handle form submission
        document.getElementById('barangForm').addEventListener('submit', function(e) {
            const satuanInput = document.getElementById('satuan_utama_input');
            
            // Validasi satuan utama
            if (!satuanInput.value.trim()) {
                e.preventDefault();
                showNotification('Silakan pilih satuan utama terlebih dahulu', 'error');
                satuanInput.focus();
                return false;
            }
            
            // Validasi lainnya bisa ditambahkan di sini
            
            // Show loading state
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = `
                <i class="fas fa-spinner fa-spin"></i>
                <span>Menyimpan data...</span>
            `;
            submitButton.disabled = true;
            
            // Jika semua validasi lolos, form akan disubmit
            return true;
        });

        // Form input validation
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('border-red-500');
                    this.classList.remove('border-gray-300');
                } else {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300');
                }
            });
        });

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            // Add enter key support for search
            document.getElementById('searchSatuan').addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && selectedSatuan) {
                    useSelectedSatuan();
                }
            });
        });
    </script>
</body>

</html>