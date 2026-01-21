<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Inventory System</title>

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

        /* ===== FALLBACK STYLES untuk warna custom ===== */

        /* Definisikan warna CSS variables */
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
        }

        /* Fallback untuk gradient backgrounds */
        .bg-gradient-to-r.from-primary.to-primary-dark {
            background: linear-gradient(to right, var(--color-primary), var(--color-primary-dark)) !important;
        }

        .bg-gradient-to-r.from-success.to-success-dark {
            background: linear-gradient(to right, var(--color-success), var(--color-success-dark)) !important;
        }

        .bg-gradient-to-r.from-danger.to-danger-dark {
            background: linear-gradient(to right, var(--color-danger), var(--color-danger-dark)) !important;
        }

        .bg-gradient-to-r.from-warning.to-warning-dark {
            background: linear-gradient(to right, var(--color-warning), var(--color-warning-dark)) !important;
        }

        .bg-gradient-to-r.from-info.to-info {
            background: linear-gradient(to right, var(--color-info), var(--color-info)) !important;
        }

        .bg-gradient-to-r.from-dark.to-gray-800 {
            background: linear-gradient(to right, var(--color-dark), #1f2937) !important;
        }

        .bg-gradient-to-r.from-amber-500.to-amber-600 {
            background: linear-gradient(to right, #f59e0b, #d97706) !important;
        }

        /* Fallback untuk background colors */
        .bg-primary {
            background-color: var(--color-primary) !important;
        }

        .bg-primary-dark {
            background-color: var(--color-primary-dark) !important;
        }

        .bg-success {
            background-color: var(--color-success) !important;
        }

        .bg-success-dark {
            background-color: var(--color-success-dark) !important;
        }

        .bg-danger {
            background-color: var(--color-danger) !important;
        }

        .bg-danger-dark {
            background-color: var(--color-danger-dark) !important;
        }

        .bg-warning {
            background-color: var(--color-warning) !important;
        }

        .bg-warning-dark {
            background-color: var(--color-warning-dark) !important;
        }

        .bg-info {
            background-color: var(--color-info) !important;
        }

        .bg-dark {
            background-color: var(--color-dark) !important;
        }

        .bg-light {
            background-color: var(--color-light) !important;
        }

        /* Fallback untuk text colors */
        .text-primary {
            color: var(--color-primary) !important;
        }

        .text-primary-dark {
            color: var(--color-primary-dark) !important;
        }

        .text-success {
            color: var(--color-success) !important;
        }

        .text-success-dark {
            color: var(--color-success-dark) !important;
        }

        .text-danger {
            color: var(--color-danger) !important;
        }

        .text-danger-dark {
            color: var(--color-danger-dark) !important;
        }

        .text-warning {
            color: var(--color-warning) !important;
        }

        .text-warning-dark {
            color: var(--color-warning-dark) !important;
        }

        .text-info {
            color: var(--color-info) !important;
        }

        .text-dark {
            color: var(--color-dark) !important;
        }

        .text-light {
            color: var(--color-light) !important;
        }

        /* Fallback untuk border colors */
        .border-primary {
            border-color: var(--color-primary) !important;
        }

        .border-success {
            border-color: var(--color-success) !important;
        }

        .border-danger {
            border-color: var(--color-danger) !important;
        }

        /* Fallback untuk utility classes yang tidak dikenali */
        .bg-white\/10 {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }

        .bg-white\/20 {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }

        /* ===== ANIMATIONS ===== */

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: rgba(59, 130, 246, 0.2);
        }

        .table-row-hover:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }

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

        /* Responsive adjustments */
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
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Notification Container -->
    <div id="notificationContainer" class="fixed top-4 right-4 z-50 w-full max-w-sm space-y-3"></div>

    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-lg rounded-xl mx-4 lg:mx-8 mt-4 mb-6 p-6"
            style="background-color: white; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); border-radius: 0.75rem; margin: 1rem 2rem 1.5rem 2rem; padding: 1.5rem;">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start gap-3 mb-2">
                        <div class="bg-gradient-to-r from-primary to-primary-dark p-3 rounded-xl shadow-md"
                            style="background: linear-gradient(to right, #3b82f6, #2563eb); padding: 0.75rem; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                            <i class="fas fa-boxes text-white text-2xl" style="color: white; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-dark"
                                style="font-size: 1.5rem; line-height: 2rem; color: #1f2937; font-weight: 700;">Master
                                Data Barang</h1>
                            <p class="text-gray-600 mt-1" style="color: #4b5563; margin-top: 0.25rem;">Manajemen data
                                barang inventori</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-end">
                    <a href="{{ route('barang.create') }}"
                        class="bg-gradient-to-r from-success to-success-dark text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2"
                        style="background: linear-gradient(to right, #10b981, #059669); color: white; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; gap: 0.5rem; text-decoration: none;">
                        <i class="fas fa-plus-circle"></i>
                        <span>Tambah Barang Baru</span>
                    </a>

                    <a href="{{ route('barang.trash') }}"
                        class="bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2"
                        style="background: linear-gradient(to right, #f59e0b, #d97706); color: white; font-weight: 600; padding: 0.75rem 1.5rem; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; gap: 0.5rem; text-decoration: none;">
                        <i class="fas fa-trash-restore"></i>
                        <span>Data Terhapus</span>
                        @if ($trashCount > 0)
                            <span
                                class="bg-white text-amber-600 text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center"
                                style="background-color: white; color: #d97706; font-size: 0.75rem; font-weight: 700; border-radius: 9999px; width: 1.5rem; height: 1.5rem; display: flex; align-items: center; justify-content: center;">
                                {{ $trashCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="mx-4 lg:mx-8 mb-8" style="margin-left: 1rem; margin-right: 1rem; margin-bottom: 2rem;">

            <!-- Data Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden"
                style="background-color: white; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); overflow: hidden;">
                <div class="bg-gradient-to-r from-dark to-gray-800 p-6"
                    style="background: linear-gradient(to right, #1f2937, #1f2937); padding: 1.5rem;">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-white p-3 rounded-xl shadow-md"
                                style="background-color: white; padding: 0.75rem; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                                <i class="fas fa-list text-dark text-xl"
                                    style="color: #1f2937; font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white"
                                    style="font-size: 1.25rem; line-height: 1.75rem; color: white; font-weight: 700;">
                                    Daftar Barang</h2>
                                <p class="text-gray-300 text-sm" style="color: #d1d5db; font-size: 0.875rem;">Semua
                                    barang yang terdaftar dalam sistem</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="bg-white/10 px-4 py-2 rounded-lg"
                                style="background-color: rgba(255,255,255,0.1); padding-left: 1rem; padding-right: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-radius: 0.5rem;">
                                <span class="text-white text-sm" style="color: white; font-size: 0.875rem;">Menampilkan
                                    {{ $barang->count() }} data</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6" style="padding: 1.5rem;">
                    @if ($barang->count() > 0)
                        <div class="overflow-x-auto rounded-xl border border-gray-200"
                            style="overflow-x: auto; border-radius: 0.75rem; border: 1px solid #e5e7eb;">
                            <table class="min-w-full divide-y divide-gray-200" style="min-width: 100%;">
                                <thead class="bg-gray-50" style="background-color: #f9fafb;">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                                            style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 0.75rem; padding-bottom: 0.75rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #374151; text-transform: uppercase;">
                                            Kode
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                                            style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 0.75rem; padding-bottom: 0.75rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #374151; text-transform: uppercase;">
                                            Nama Barang
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                                            style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 0.75rem; padding-bottom: 0.75rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #374151; text-transform: uppercase;">
                                            Satuan
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                                            style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 0.75rem; padding-bottom: 0.75rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #374151; text-transform: uppercase;">
                                            Faktor Konversi
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                                            style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 0.75rem; padding-bottom: 0.75rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #374151; text-transform: uppercase;">
                                            Stok
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                                            style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 0.75rem; padding-bottom: 0.75rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #374151; text-transform: uppercase;">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
                                            style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 0.75rem; padding-bottom: 0.75rem; text-align: left; font-size: 0.75rem; font-weight: 600; color: #374151; text-transform: uppercase;">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" style="background-color: white;">
                                    @foreach ($barang as $item)
                                        <tr class="table-row-hover hover:bg-blue-50 transition-all"
                                            style="transition: all 0.3s ease;">
                                            <td class="px-6 py-4 whitespace-nowrap"
                                                style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 1rem; padding-bottom: 1rem; white-space: nowrap;">
                                                <div class="text-sm font-bold text-gray-900"
                                                    style="font-size: 0.875rem; font-weight: 700; color: #111827;">
                                                    {{ $item->kode_barang }}</div>
                                            </td>
                                            <td class="px-6 py-4"
                                                style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 1rem; padding-bottom: 1rem;">
                                                <div class="text-sm font-bold text-gray-900"
                                                    style="font-size: 0.875rem; font-weight: 700; color: #111827;">
                                                    {{ $item->nama_barang }}</div>
                                                @if ($item->keterangan)
                                                    <div class="text-xs text-gray-500 mt-1"
                                                        style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">
                                                        {{ Str::limit($item->keterangan, 50) }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"
                                                style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 1rem; padding-bottom: 1rem; white-space: nowrap;">
                                                <div class="flex flex-col gap-1"
                                                    style="display: flex; flex-direction: column; gap: 0.25rem;">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                                        style="display: inline-flex; align-items: center; padding-left: 0.75rem; padding-right: 0.75rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: #dbeafe; color: #1e40af;">
                                                        {{ $item->satuan_utama }}
                                                    </span>
                                                    @if ($item->satuan_alternatif)
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                                            style="display: inline-flex; align-items: center; padding-left: 0.75rem; padding-right: 0.75rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: #d1fae5; color: #065f46;">
                                                            {{ $item->satuan_alternatif }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"
                                                style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 1rem; padding-bottom: 1rem; white-space: nowrap;">
                                                <div class="text-sm text-gray-900"
                                                    style="font-size: 0.875rem; color: #111827;">
                                                    1 {{ $item->satuan_utama }} =
                                                    {{ $item->faktor_konversi }}
                                                    {{ $item->satuan_alternatif ?? $item->satuan_utama }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"
                                                style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 1rem; padding-bottom: 1rem; white-space: nowrap;">
                                                <div class="flex flex-col"
                                                    style="display: flex; flex-direction: column;">
                                                    <span class="text-sm font-bold text-gray-900"
                                                        style="font-size: 0.875rem; font-weight: 700; color: #111827;">
                                                        {{ number_format($item->stok_sekarang, 2) }}
                                                    </span>
                                                    <span class="text-xs text-gray-500"
                                                        style="font-size: 0.75rem; color: #6b7280;">
                                                        Awal: {{ number_format($item->stok_awal, 2) }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"
                                                style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 1rem; padding-bottom: 1rem; white-space: nowrap;">
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $item->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                                                    style="display: inline-flex; align-items: center; padding-left: 0.75rem; padding-right: 0.75rem; padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; {{ $item->status ? 'background-color: #d1fae5; color: #065f46;' : 'background-color: #fee2e2; color: #991b1b;' }}">
                                                    {{ $item->status ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                                style="padding-left: 1.5rem; padding-right: 1.5rem; padding-top: 1rem; padding-bottom: 1rem; white-space: nowrap; font-size: 0.875rem; font-weight: 500;">
                                                <div class="flex items-center gap-2"
                                                    style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <a href="{{ route('barang.show', $item->id) }}"
                                                        class="bg-gradient-to-r from-info to-cyan-600 text-white p-2 rounded-lg hover:shadow-md transition-all"
                                                        title="Detail"
                                                        style="background: linear-gradient(to right, #06b6d4, #06b6d4); color: white; padding: 0.5rem; border-radius: 0.5rem; text-decoration: none;">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('barang.edit', $item->id) }}"
                                                        class="bg-gradient-to-r from-primary to-primary-dark text-white p-2 rounded-lg hover:shadow-md transition-all"
                                                        title="Edit"
                                                        style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; padding: 0.5rem; border-radius: 0.5rem; text-decoration: none;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button onclick="deleteData({{ $item->id }})"
                                                        class="bg-gradient-to-r from-danger to-danger-dark text-white p-2 rounded-lg hover:shadow-md transition-all"
                                                        title="Hapus"
                                                        style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; padding: 0.5rem; border-radius: 0.5rem; border: none; cursor: pointer;">
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
                        <div class="text-center py-12"
                            style="text-align: center; padding-top: 3rem; padding-bottom: 3rem;">
                            <div class="inline-block p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-full mb-6"
                                style="display: inline-block; padding: 1.5rem; background: linear-gradient(to right, #eff6ff, #dbeafe); border-radius: 9999px; margin-bottom: 1.5rem;">
                                <i class="fas fa-box-open text-blue-500 text-5xl"
                                    style="color: #3b82f6; font-size: 3rem;"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3"
                                style="font-size: 1.5rem; line-height: 2rem; color: #1f2937; font-weight: 700; margin-bottom: 0.75rem;">
                                Belum Ada Data Barang</h3>
                            <p class="text-gray-600 mb-8 max-w-md mx-auto"
                                style="color: #4b5563; margin-bottom: 2rem; max-width: 28rem; margin-left: auto; margin-right: auto;">
                                Mulai dengan menambahkan data barang pertama Anda untuk mengelola inventori.
                            </p>
                            <a href="{{ route('barang.create') }}"
                                class="bg-gradient-to-r from-success to-success-dark text-white font-semibold py-4 px-8 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-3 mx-auto max-w-sm"
                                style="background: linear-gradient(to right, #10b981, #059669); color: white; font-weight: 600; padding: 1rem 2rem; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; gap: 0.75rem; margin-left: auto; margin-right: auto; max-width: 24rem; text-decoration: none;">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tambah Barang Pertama</span>
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

        async function deleteData(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini? Data akan dipindahkan ke Trash.')) {
                return;
            }

            try {
                const response = await fetch(`${baseUrl}/barang/${id}`, {
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
                    }, 1000);
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
