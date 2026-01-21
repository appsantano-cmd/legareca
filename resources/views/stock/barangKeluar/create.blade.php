<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengambilan Barang Gudang - Inventory System</title>

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
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('barang-keluar.index') }}"
                        class="text-gray-600 hover:text-primary transition-colors">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Pengambilan Barang Gudang</h1>
                        <p class="text-gray-600 mt-1">Formulir pengeluaran barang dari inventori</p>

                        <!-- TAMBAHKAN INDIKATOR SYNC -->
                        <div class="mt-2">
                            <span
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-sync-alt"></i>
                                Auto-sync Google Sheets Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="mx-4 lg:mx-8 mb-8">
            <form action="{{ route('barang-keluar.store') }}" method="POST" id="barangKeluarForm">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Card: Informasi Transaksi -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-info-circle text-primary mr-2"></i>
                                Informasi Transaksi
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-calendar-alt text-primary mr-1"></i>
                                        Tanggal Keluar <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tanggal_keluar"
                                        value="{{ old('tanggal_keluar', date('Y-m-d')) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                        required>
                                    @error('tanggal_keluar')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-building text-primary mr-1"></i>
                                        Department <span class="text-red-500">*</span>
                                    </label>
                                    <select name="department"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                        required>
                                        <option value="">Pilih Department</option>
                                        <option value="Bar" {{ old('department') == 'Bar' ? 'selected' : '' }}>Bar
                                        </option>
                                        <option value="Kitchen" {{ old('department') == 'Kitchen' ? 'selected' : '' }}>
                                            Kitchen</option>
                                        <option value="Pastry" {{ old('department') == 'Pastry' ? 'selected' : '' }}>
                                            Pastry</option>
                                        <option value="Server" {{ old('department') == 'Server' ? 'selected' : '' }}>
                                            Server</option>
                                        <option value="Marcom" {{ old('department') == 'Marcom' ? 'selected' : '' }}>
                                            Marcom</option>
                                        <option value="Cleaning Staff"
                                            {{ old('department') == 'Cleaning Staff' ? 'selected' : '' }}>Cleaning Staff
                                        </option>
                                    </select>
                                    @error('department')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Card: Barang -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-box text-primary mr-2"></i>
                                Informasi Barang
                            </h3>

                            <div class="space-y-4">
                                <!-- Nama Barang dengan Modal -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-box-open text-primary mr-1"></i>
                                        Nama Barang <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex space-x-2">
                                        <input type="hidden" name="barang_id" id="barang_id"
                                            value="{{ old('barang_id') }}">
                                        <input type="text" id="barang_nama" value="{{ old('barang_nama') }}"
                                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg bg-gray-50"
                                            placeholder="Pilih barang dari daftar" readonly>
                                        <button type="button" onclick="openBarangModal()"
                                            class="bg-primary text-white px-4 py-3 rounded-lg hover:bg-primary-dark transition-colors">
                                            <i class="fas fa-search"></i> Pilih
                                        </button>
                                    </div>
                                    <div id="barang_info" class="mt-2 text-sm text-gray-600 hidden">
                                        <div>Kode: <span id="kode_barang" class="font-bold">-</span></div>
                                        <div>Stok tersedia: <span id="stok_tersedia" class="font-bold">0</span></div>
                                        <div>Satuan utama: <span id="satuan_utama" class="font-bold">-</span></div>
                                    </div>
                                    @error('barang_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jumlah Keluar -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-balance-scale text-primary mr-1"></i>
                                        Jumlah Keluar <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex space-x-2">
                                        <input type="number" name="jumlah_keluar" step="any" min="0.0001"
                                            value="{{ old('jumlah_keluar') }}"
                                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                            placeholder="0.00" required>
                                    </div>
                                    @error('jumlah_keluar')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Satuan dengan Modal -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-weight text-primary mr-1"></i>
                                        Satuan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex space-x-2">
                                        <input type="hidden" name="satuan_id" id="satuan_id"
                                            value="{{ old('satuan_id') }}">
                                        <input type="text" id="satuan_nama" value="{{ old('satuan_nama') }}"
                                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg bg-gray-50"
                                            placeholder="Pilih satuan dari daftar" readonly>
                                        <button type="button" onclick="openSatuanModal()"
                                            class="bg-primary text-white px-4 py-3 rounded-lg hover:bg-primary-dark transition-colors">
                                            <i class="fas fa-search"></i> Pilih
                                        </button>
                                    </div>
                                    <div id="satuan_info" class="mt-2 text-sm text-gray-600 hidden">
                                        <div>Satuan utama: <span id="satuan_utama_text" class="font-bold">-</span>
                                        </div>
                                        <div>Faktor konversi: 1 <span id="satuan_input_text"></span> =
                                            <span id="faktor_konversi" class="font-bold">0</span>
                                            <span id="satuan_utama_conversion"></span>
                                        </div>
                                    </div>
                                    @error('satuan_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Card: Penerima -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-user text-primary mr-2"></i>
                                Informasi Penerima
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-user-tag text-primary mr-1"></i>
                                        Nama Penerima <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nama_penerima" value="{{ old('nama_penerima') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                        placeholder="Nama lengkap penerima" required>
                                    @error('nama_penerima')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-clipboard-list text-primary mr-1"></i>
                                        Keperluan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="keperluan" rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                        placeholder="Deskripsi keperluan pengeluaran barang" required>{{ old('keperluan') }}</textarea>
                                    @error('keperluan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <!-- Card: Ringkasan -->
                        <div class="bg-white rounded-xl shadow-lg p-6">

                            <!-- Action Buttons -->
                            <div class="mt-6 flex space-x-3">
                                <a href="{{ route('barang-keluar.index') }}"
                                    class="flex-1 bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-300 transition-colors text-center">
                                    <i class="fas fa-times mr-2"></i>Batal
                                </a>
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-success to-green-600 text-white font-semibold py-3 px-6 rounded-lg hover:shadow-lg transition-all">
                                    <i class="fas fa-save mr-2"></i>Simpan & Sync ke Google Sheets
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Barang -->
    <div id="barangModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl">
                <div class="p-6 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800">Pilih Barang</h3>
                        <button onclick="closeBarangModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>

                    <!-- Search Bar -->
                    <div class="mt-4">
                        <div class="relative">
                            <input type="text" id="searchBarang"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Cari barang (nama atau kode)...">
                            <div class="absolute right-3 top-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-y-auto max-h-96">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Kode</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Nama Barang
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Satuan Utama
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Stok</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="barangTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Data akan diisi via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <div id="loadingBarang" class="text-center py-4">
                        <i class="fas fa-spinner fa-spin text-primary text-xl"></i>
                        <p class="mt-2 text-gray-600">Memuat data...</p>
                    </div>

                    <div id="noBarangData" class="text-center py-8 hidden">
                        <i class="fas fa-box-open text-gray-300 text-4xl"></i>
                        <p class="mt-2 text-gray-600">Tidak ada data barang ditemukan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Satuan -->
    <div id="satuanModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl">
                <div class="p-6 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800">Pilih Satuan</h3>
                        <button onclick="closeSatuanModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>

                    <!-- Search Bar -->
                    <div class="mt-4">
                        <div class="relative">
                            <input type="text" id="searchSatuan"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Cari satuan...">
                            <div class="absolute right-3 top-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-y-auto max-h-96">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Satuan Input
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Satuan Utama
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Faktor</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="satuanTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Data akan diisi via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <div id="loadingSatuan" class="text-center py-4">
                        <i class="fas fa-spinner fa-spin text-primary text-xl"></i>
                        <p class="mt-2 text-gray-600">Memuat data...</p>
                    </div>

                    <div id="noSatuanData" class="text-center py-8 hidden">
                        <i class="fas fa-weight text-gray-300 text-4xl"></i>
                        <p class="mt-2 text-gray-600">Tidak ada data satuan ditemukan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const baseUrl = '{{ url('/') }}';
        let selectedBarang = null;
        let selectedSatuan = null;

        // Modal Barang Functions
        function openBarangModal() {
            document.getElementById('barangModal').classList.remove('hidden');
            loadBarangData();
        }

        function closeBarangModal() {
            document.getElementById('barangModal').classList.add('hidden');
        }

        function loadBarangData(search = '') {
            document.getElementById('loadingBarang').classList.remove('hidden');
            document.getElementById('noBarangData').classList.add('hidden');

            fetch(`${baseUrl}/api/barang-keluar/barang-list?search=${encodeURIComponent(search)}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('barangTableBody');
                    tbody.innerHTML = '';

                    if (data.length === 0) {
                        document.getElementById('noBarangData').classList.remove('hidden');
                    } else {
                        data.forEach(barang => {
                            const row = document.createElement('tr');
                            row.className = 'hover:bg-gray-50';
                            row.innerHTML = `
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">${barang.kode_barang}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">${barang.nama_barang}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        ${barang.satuan_utama}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-bold ${barang.stok_sekarang > 0 ? 'text-green-600' : 'text-red-600'}">
                                        ${parseFloat(barang.stok_sekarang).toFixed(2)}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <button onclick="selectBarang(${barang.id})"
                                            class="bg-primary text-white px-3 py-1 rounded-lg hover:bg-primary-dark transition-colors text-sm">
                                        Pilih
                                    </button>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });
                    }
                    document.getElementById('loadingBarang').classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error loading barang:', error);
                    document.getElementById('loadingBarang').classList.add('hidden');
                });
        }

        function selectBarang(barangId) {
            fetch(`${baseUrl}/api/barang-keluar/barang/${barangId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        selectedBarang = data.data;
                        document.getElementById('barang_id').value = selectedBarang.id;
                        document.getElementById('barang_nama').value = selectedBarang.nama_barang;
                        document.getElementById('kode_barang').textContent = selectedBarang.kode_barang;
                        document.getElementById('stok_tersedia').textContent = parseFloat(selectedBarang.stok_sekarang)
                            .toFixed(2);
                        document.getElementById('satuan_utama').textContent = selectedBarang.satuan_utama;
                        document.getElementById('barang_info').classList.remove('hidden');
                        closeBarangModal();
                        calculateTotal();
                    }
                })
                .catch(error => console.error('Error selecting barang:', error));
        }

        // Modal Satuan Functions
        function openSatuanModal() {
            document.getElementById('satuanModal').classList.remove('hidden');
            loadSatuanData();
        }

        function closeSatuanModal() {
            document.getElementById('satuanModal').classList.add('hidden');
        }

        // Modal Satuan Functions
        function loadSatuanData(search = '') {
            document.getElementById('loadingSatuan').classList.remove('hidden');
            document.getElementById('noSatuanData').classList.add('hidden');

            fetch(`${baseUrl}/api/barang-keluar/satuan-list?search=${encodeURIComponent(search)}`)
                .then(response => {
                    // Cek jika response tidak OK
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Satuan data:', data); // Debug log

                    const tbody = document.getElementById('satuanTableBody');
                    tbody.innerHTML = '';

                    // Cek jika data adalah array
                    if (Array.isArray(data) && data.length === 0) {
                        document.getElementById('noSatuanData').classList.remove('hidden');
                    } else if (Array.isArray(data)) {
                        data.forEach(satuan => {
                            const row = document.createElement('tr');
                            row.className = 'hover:bg-gray-50';
                            row.innerHTML = `
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">${satuan.satuan_input}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                ${satuan.satuan_utama}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">${parseFloat(satuan.faktor).toFixed(4)}</div>
                        </td>
                        <td class="px-4 py-3">
                            <button onclick="selectSatuan(${satuan.id})"
                                    class="bg-primary text-white px-3 py-1 rounded-lg hover:bg-primary-dark transition-colors text-sm">
                                Pilih
                            </button>
                        </td>
                    `;
                            tbody.appendChild(row);
                        });
                    } else {
                        // Jika data bukan array, tampilkan error
                        console.error('Data is not an array:', data);
                        document.getElementById('noSatuanData').classList.remove('hidden');
                        document.getElementById('noSatuanData').innerHTML = `
                    <i class="fas fa-exclamation-triangle text-yellow-400 text-4xl"></i>
                    <p class="mt-2 text-gray-600">Error: ${data.message || 'Format data tidak valid'}</p>
                `;
                    }
                    document.getElementById('loadingSatuan').classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error loading satuan:', error);
                    document.getElementById('loadingSatuan').classList.add('hidden');
                    document.getElementById('noSatuanData').classList.remove('hidden');
                    document.getElementById('noSatuanData').innerHTML = `
                <i class="fas fa-exclamation-triangle text-red-400 text-4xl"></i>
                <p class="mt-2 text-gray-600">Terjadi kesalahan: ${error.message}</p>
            `;
                });
        }

        function selectSatuan(satuanId) {
            fetch(`${baseUrl}/api/barang-keluar/satuan/${satuanId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        selectedSatuan = data.data;
                        document.getElementById('satuan_id').value = selectedSatuan.id;
                        document.getElementById('satuan_nama').value = selectedSatuan.satuan_input;
                        document.getElementById('satuan_utama_text').textContent = selectedSatuan.satuan_utama;
                        document.getElementById('satuan_input_text').textContent = selectedSatuan.satuan_input;
                        document.getElementById('faktor_konversi').textContent = parseFloat(selectedSatuan.faktor)
                            .toFixed(4);
                        document.getElementById('satuan_utama_conversion').textContent = selectedSatuan.satuan_utama;
                        document.getElementById('satuan_info').classList.remove('hidden');
                        closeSatuanModal();
                        calculateTotal();
                    }
                })
                .catch(error => console.error('Error selecting satuan:', error));
        }

        // Calculate Total Function
        function calculateTotal() {
            const jumlahInput = document.querySelector('input[name="jumlah_keluar"]');
            const jumlah = parseFloat(jumlahInput?.value) || 0;

            let totalSatuanUtama = 0;
            let penguranganStok = 0;

            if (selectedSatuan && jumlah > 0) {
                totalSatuanUtama = jumlah * parseFloat(selectedSatuan.faktor);
                penguranganStok = totalSatuanUtama;

                // Format untuk display
                document.getElementById('total_satuan_utama').textContent = totalSatuanUtama.toFixed(2);
                document.getElementById('pengurangan_stok').textContent = `-${totalSatuanUtama.toFixed(2)}`;

                // Cek jika stok tidak mencukupi
                if (selectedBarang && totalSatuanUtama > parseFloat(selectedBarang.stok_sekarang)) {
                    document.getElementById('pengurangan_stok').classList.add('text-danger');
                    document.getElementById('pengurangan_stok').classList.remove('text-primary');

                    // Tampilkan warning
                    if (!document.getElementById('stokWarning')) {
                        const warningDiv = document.createElement('div');
                        warningDiv.id = 'stokWarning';
                        warningDiv.className = 'mt-2 p-3 bg-red-50 border border-red-200 rounded-lg';
                        warningDiv.innerHTML = `
                            <div class="flex items-center text-red-800">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span class="font-semibold">Stok Tidak Mencukupi!</span>
                            </div>
                            <p class="text-sm text-red-700 mt-1">
                                Stok tersedia: ${selectedBarang.stok_sekarang} ${selectedBarang.satuan_utama}
                            </p>
                        `;
                        document.getElementById('barang_info').appendChild(warningDiv);
                    }
                } else {
                    document.getElementById('pengurangan_stok').classList.remove('text-danger');
                    document.getElementById('pengurangan_stok').classList.add('text-primary');

                    // Hapus warning jika ada
                    const warningDiv = document.getElementById('stokWarning');
                    if (warningDiv) {
                        warningDiv.remove();
                    }
                }
            }
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality for modals
            document.getElementById('searchBarang').addEventListener('input', function(e) {
                loadBarangData(e.target.value);
            });

            document.getElementById('searchSatuan').addEventListener('input', function(e) {
                loadSatuanData(e.target.value);
            });

            // Calculate total when jumlah changes
            const jumlahInput = document.querySelector('input[name="jumlah_keluar"]');
            if (jumlahInput) {
                jumlahInput.addEventListener('input', calculateTotal);
            }

            // Form validation
            document.getElementById('barangKeluarForm').addEventListener('submit', function(e) {
                const jumlah = parseFloat(document.querySelector('input[name="jumlah_keluar"]').value);
                const barangId = document.getElementById('barang_id').value;
                const satuanId = document.getElementById('satuan_id').value;

                if (!barangId) {
                    e.preventDefault();
                    alert('Silakan pilih barang terlebih dahulu');
                    return false;
                }

                if (!satuanId) {
                    e.preventDefault();
                    alert('Silakan pilih satuan terlebih dahulu');
                    return false;
                }

                if (jumlah <= 0) {
                    e.preventDefault();
                    alert('Jumlah keluar harus lebih dari 0');
                    return false;
                }

                // Cek stok
                if (selectedBarang && selectedSatuan) {
                    const totalSatuanUtama = jumlah * parseFloat(selectedSatuan.faktor);
                    if (totalSatuanUtama > parseFloat(selectedBarang.stok_sekarang)) {
                        e.preventDefault();
                        alert(
                            `Stok tidak mencukupi! Stok tersedia: ${selectedBarang.stok_sekarang} ${selectedBarang.satuan_utama}`
                            );
                        return false;
                    }
                }

                // Show loading
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                return true;
            });
        });

        // Close modals when clicking outside
        window.onclick = function(event) {
            const barangModal = document.getElementById('barangModal');
            const satuanModal = document.getElementById('satuanModal');

            if (event.target === barangModal) {
                closeBarangModal();
            }
            if (event.target === satuanModal) {
                closeSatuanModal();
            }
        }
    </script>
</body>

</html>
