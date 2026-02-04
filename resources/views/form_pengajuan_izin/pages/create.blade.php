<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Pengajuan Izin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gradient-to-br from-blue-500 to-purple-600">

    <div class="min-h-screen flex items-center px-4 py-8 md:py-12">
        <div class="max-w-6xl w-full mx-auto">
            @if (!Auth::check())
                <div class="text-center mb-8">
                    <div class="bg-red-100 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                            <div>
                                <h3 class="font-bold text-red-800">Perhatian!</h3>
                                <p class="text-red-700">Anda harus login terlebih dahulu untuk mengajukan izin.</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg font-semibold transition shadow-md">
                        <i class="fas fa-sign-in-alt"></i>
                        Login Sekarang
                    </a>
                </div>
            @else
                <div class="text-center mb-8 animation-slide-up">
                    <div class="logo-container mb-6">
                        <div
                            class="w-40 h-40 mx-auto bg-gradient-to-br from-blue-100 to-purple-100 rounded-full p-4 shadow-lg">
                            <div class="w-full h-full bg-white rounded-full p-4">
                                <img src="{{ asset('logo.png') }}" alt="Company Logo"
                                    class="w-full h-full object-contain rounded-full"
                                    onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMjAiIGhlaWdodD0iMTIwIiByeD0iNjAiIGZpbGw9InVybCgjY2xvZ28tZ3JhZGllbnQpIi8+CjxwYXRoIGQ9Ik0zNSA0NUg4NU02NSA0NVY5ME00NSA2NUg4NSIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSI1IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPGRlZnM+CjxsaW5lYXJHcmFkaWVudCBpZD0iY2xvZ28tZ3JhZGllbnQiIHgxPSIwIiB5MT0iMCIgeDI9IjEyMCIgeTI9IjEyMCIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPgo8c3RvcCBzdG9wLWNvbG9yPSIjNjY3RUVBIi8+CjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzc2NEJBMiIvPgo8L2xpbmVhckdyYWRpZW50Pgo8L2RlZnM+Cjwvc3ZnPgo=';">
                            </div>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">
                        <i class="fas fa-file-contract mr-2"></i>Form Pengajuan Izin
                    </h1>
                    <p class="text-blue-100 text-sm">Notifikasi akan dikirim ke email Anda: {{ Auth::user()->email }}
                    </p>
                </div>

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="mb-8 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-600"></i>
                            <div>
                                <h3 class="font-semibold">Pengajuan Berhasil!</h3>
                                <p>{{ session('success') }}</p>
                                <p class="text-sm mt-1">
                                    <i class="fas fa-envelope mr-1"></i>Notifikasi telah dikirim ke admin dan status
                                    akan dikirim ke email Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Card Container --}}
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    {{-- Header Card --}}
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                    <i class="fas fa-user-circle text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white">
                                        {{ Auth::user()->name }}
                                    </h2>
                                    <p class="text-blue-100 text-sm mt-1">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white">
                                    <i class="fas fa-clock mr-1"></i>
                                    Waktu pengisian: ~5 menit
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Form Content --}}
                    <div class="p-8">
                        @if ($errors->any())
                            <div
                                class="mb-8 p-4 rounded-xl bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500">
                                <div class="flex">
                                    <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-0.5"></i>
                                    <div>
                                        <h3 class="font-semibold text-red-800">Periksa kembali data Anda</h3>
                                        <ul class="mt-2 text-sm text-red-700 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li class="flex items-center">
                                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span>
                                                    {{ $error }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('izin.store') }}" enctype="multipart/form-data"
                            id="izinForm" class="space-y-10">
                            @csrf

                            <!-- Informasi User (auto-fill dari auth) -->
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 mb-6">
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama
                                            Karyawan</label>
                                        <!-- Tambahkan hidden input untuk mengirim data nama -->
                                        <input type="hidden" name="nama" value="{{ Auth::user()->name }}">
                                        <input type="text"
                                            class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg"
                                            value="{{ Auth::user()->name }}" readonly>
                                        <small class="text-gray-500 text-xs">Diambil dari data login Anda</small>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email"
                                            class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg"
                                            value="{{ Auth::user()->email }}" readonly>
                                        <small class="text-gray-500 text-xs">Notifikasi status akan dikirim ke email
                                            ini</small>
                                    </div>
                                </div>
                            </div>

                            <div class="grid lg:grid-cols-2 gap-10">
                                {{-- Left Column --}}
                                <div class="space-y-8">
                                    {{-- Section 1: Data Karyawan --}}
                                    <div
                                        class="bg-gradient-to-br from-slate-50 to-white rounded-xl p-6 border border-slate-200">
                                        <div class="flex items-center mb-6">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <h2 class="text-lg font-semibold text-slate-800">Data Karyawan</h2>
                                        </div>

                                        <div class="space-y-5">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                                    Divisi / Jabatan <span class="text-red-500">*</span>
                                                </label>
                                                <div class="relative">
                                                    <input type="text" name="divisi" value="{{ old('divisi') }}"
                                                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-300 rounded-xl 
                                                              text-slate-700 placeholder-slate-400 focus:border-blue-500 
                                                              focus:ring-3 focus:ring-blue-200 transition duration-200"
                                                        placeholder="Contoh: IT Support" required>
                                                    <div class="absolute left-4 top-3.5 text-slate-400">
                                                        <i class="fas fa-briefcase"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Kontak & Alamat --}}
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                                    Nomor Telepon/WhatsApp <span class="text-red-500">*</span>
                                                </label>
                                                <div class="relative">
                                                    <div class="absolute left-4 top-3.5 text-slate-400">
                                                        <i class="fas fa-phone"></i>
                                                    </div>
                                                    <input type="tel" name="nomor_telepon"
                                                        value="{{ old('nomor_telepon') }}"
                                                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-300 rounded-xl 
                                                              text-slate-700 placeholder-slate-400 focus:border-blue-500 
                                                              focus:ring-3 focus:ring-blue-200 transition duration-200"
                                                        placeholder="Contoh: 0812-3456-7890" required>
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                                    Alamat Selama Izin <span class="text-red-500">*</span>
                                                </label>
                                                <div class="relative">
                                                    <div class="absolute left-4 top-3.5 text-slate-400">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                    </div>
                                                    <textarea name="alamat" rows="3"
                                                        class="w-full pl-11 pr-4 py-3 bg-white border border-slate-300 rounded-xl 
                                                               text-slate-700 placeholder-slate-400 focus:border-blue-500 
                                                               focus:ring-3 focus:ring-blue-200 transition duration-200 resize-none"
                                                        placeholder="Alamat lengkap tempat Anda selama izin" required>{{ old('alamat') }}</textarea>
                                                </div>
                                                <p class="text-xs text-slate-500 mt-2">
                                                    Diperlukan untuk keperluan komunikasi darurat
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Right Column --}}
                                <div class="space-y-8">
                                    {{-- Section 2: Jenis Izin --}}
                                    <div x-data="{ selected: '{{ old('jenis_izin_pilihan') }}', custom: '{{ old('jenis_izin_lainnya') }}' }"
                                        class="bg-gradient-to-br from-slate-50 to-white rounded-xl p-6 border border-slate-200">
                                        <div class="flex items-center mb-6">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-file-contract text-blue-600"></i>
                                            </div>
                                            <h2 class="text-lg font-semibold text-slate-800">Jenis Izin</h2>
                                        </div>

                                        <div>
                                            <div class="grid sm:grid-cols-2 gap-3 mb-6">
                                                @foreach ([
        'Izin Sakit' => 'sakit',
        'Izin Datang Terlambat' => 'terlambat',
        'Izin Pulang Lebih Awal' => 'pulang',
        'Izin Kematian Keluarga' => 'kematian',
        'Lainnya' => 'lainnya',
    ] as $label => $value)
                                                    <label class="cursor-pointer">
                                                        <input type="radio" name="jenis_izin_pilihan"
                                                            value="{{ $label }}" x-model="selected"
                                                            class="hidden peer">
                                                        <div
                                                            class="p-4 border-2 border-slate-200 rounded-xl transition-all duration-200
                                                               hover:border-blue-400 hover:bg-blue-50 peer-checked:border-blue-500 
                                                               peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200">
                                                            <div class="flex items-center">
                                                                <div
                                                                    class="w-5 h-5 rounded-full border-2 border-slate-300 
                                                                    mr-3 flex-shrink-0 peer-checked:border-blue-500 
                                                                    peer-checked:bg-blue-500 peer-checked:border-4 
                                                                    peer-checked:border-white peer-checked:ring-2 
                                                                    peer-checked:ring-blue-200">
                                                                </div>
                                                                <span
                                                                    class="text-sm font-medium text-slate-700">{{ $label }}</span>
                                                            </div>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>

                                            <div x-show="selected === 'Lainnya'" x-transition>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                                    Tuliskan jenis izin lainnya
                                                </label>
                                                <input type="text" name="jenis_izin_lainnya" x-model="custom"
                                                    class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl 
                                                          text-slate-700 placeholder-slate-400 focus:border-blue-500 
                                                          focus:ring-3 focus:ring-blue-200 transition duration-200"
                                                    placeholder="Jelaskan jenis izin yang diajukan">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Section 3: Durasi Izin --}}
                                    <div
                                        class="bg-gradient-to-br from-slate-50 to-white rounded-xl p-6 border border-slate-200">
                                        <div class="flex items-center mb-6">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                                <i class="fas fa-calendar-alt text-blue-600"></i>
                                            </div>
                                            <h2 class="text-lg font-semibold text-slate-800">Durasi Izin</h2>
                                        </div>

                                        <div class="space-y-5">
                                            <div class="grid md:grid-cols-2 gap-5">
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                                        Tanggal Mulai <span class="text-red-500">*</span>
                                                    </label>
                                                    <div class="relative">
                                                        <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                                                            value="{{ old('tanggal_mulai') }}"
                                                            class="w-full pl-11 pr-4 py-3 bg-white border border-slate-300 rounded-xl 
                                                                  text-slate-700 focus:border-blue-500 focus:ring-3 
                                                                  focus:ring-blue-200 transition duration-200"
                                                            required>
                                                        <div class="absolute left-4 top-3.5 text-slate-400">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                                        Tanggal Selesai <span class="text-red-500">*</span>
                                                    </label>
                                                    <div class="relative">
                                                        <input type="date" id="tanggal_selesai"
                                                            name="tanggal_selesai"
                                                            value="{{ old('tanggal_selesai') }}"
                                                            class="w-full pl-11 pr-4 py-3 bg-white border border-slate-300 rounded-xl 
                                                                  text-slate-700 focus:border-blue-500 focus:ring-3 
                                                                  focus:ring-blue-200 transition duration-200"
                                                            required>
                                                        <div class="absolute left-4 top-3.5 text-slate-400">
                                                            <i class="fas fa-calendar-check"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                                    Total Hari Izin
                                                </label>
                                                <div class="relative">
                                                    <input type="number" id="jumlah_hari" name="jumlah_hari"
                                                        value="{{ old('jumlah_hari') }}"
                                                        class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl 
                                                              text-slate-700 font-medium"
                                                        readonly placeholder="Akan terhitung otomatis">
                                                    <div class="absolute left-4 top-3.5 text-slate-500">
                                                        <i class="fas fa-clock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Section 4: Dokumen Pendukung --}}
                            <div
                                class="bg-gradient-to-br from-slate-50 to-white rounded-xl p-6 border border-slate-200">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-file-upload text-blue-600"></i>
                                    </div>
                                    <h2 class="text-lg font-semibold text-slate-800">Dokumen Pendukung</h2>
                                </div>

                                {{-- Hidden input untuk file --}}
                                <input type="file" name="documen_pendukung" id="fileInput" accept="image/*,.pdf"
                                    class="hidden">
                                <input type="hidden" id="cameraImageData" name="camera_image_data">

                                {{-- Pilihan Upload Method --}}
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-slate-700 mb-3">
                                        Pilih cara upload dokumen:
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <button type="button" id="btnCamera"
                                            class="p-4 border-2 border-slate-200 rounded-xl transition-all duration-200
                                                   hover:border-blue-400 hover:bg-blue-50 focus:border-blue-500 
                                                   focus:ring-2 focus:ring-blue-200 flex flex-col items-center">
                                            <div
                                                class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-2">
                                                <i class="fas fa-camera text-blue-600 text-xl"></i>
                                            </div>
                                            <span class="text-sm font-medium text-slate-700">Ambil Foto</span>
                                            <span class="text-xs text-slate-500 mt-1">Gunakan kamera</span>
                                        </button>

                                        <button type="button" id="btnFile"
                                            class="p-4 border-2 border-slate-200 rounded-xl transition-all duration-200
                                                   hover:border-blue-400 hover:bg-blue-50 focus:border-blue-500 
                                                   focus:ring-2 focus:ring-blue-200 flex flex-col items-center">
                                            <div
                                                class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-2">
                                                <i class="fas fa-file-upload text-blue-600 text-xl"></i>
                                            </div>
                                            <span class="text-sm font-medium text-slate-700">Pilih File</span>
                                            <span class="text-xs text-slate-500 mt-1">Dari perangkat</span>
                                        </button>
                                    </div>
                                </div>

                                {{-- Preview Area --}}
                                <div id="uploadArea"
                                    class="hidden border-3 border-dashed border-slate-300 rounded-xl p-8 
                                        bg-gradient-to-br from-slate-50 to-white text-center">
                                    <div id="uploadContent">
                                        {{-- Konten akan diisi oleh JavaScript --}}
                                    </div>
                                </div>

                                {{-- Preview Dokumen --}}
                                <div id="previewBox"
                                    class="hidden mt-6 p-4 bg-slate-50 rounded-xl border border-slate-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                            <span class="text-sm font-medium text-slate-700">Dokumen terupload</span>
                                        </div>
                                        <span id="fileSize" class="text-xs text-slate-500"></span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 rounded-lg bg-blue-100 flex items-center 
                                                    justify-center mr-3">
                                                <i class="fas fa-file text-blue-600"></i>
                                            </div>
                                            <div>
                                                <p id="fileName" class="text-sm font-medium text-slate-700"></p>
                                                <p id="fileType" class="text-xs text-slate-500"></p>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" onclick="retakeFile()"
                                                class="px-3 py-1.5 text-sm border border-slate-300 rounded-lg 
                                                       hover:bg-slate-100 transition duration-200">
                                                Ganti
                                            </button>
                                            <button type="button" onclick="removeFile()"
                                                class="px-3 py-1.5 text-sm border border-red-300 text-red-600 
                                                       rounded-lg hover:bg-red-50 transition duration-200">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Keterangan Tambahan --}}
                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-slate-700 mb-3">
                                        <span class="flex items-center">
                                            <i class="fas fa-sticky-note mr-2 text-slate-400"></i>
                                            Keterangan Tambahan (Opsional)
                                        </span>
                                    </label>
                                    <textarea name="keterangan_tambahan" rows="4"
                                        class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl 
                                                 text-slate-700 placeholder-slate-400 focus:border-blue-500 
                                                 focus:ring-3 focus:ring-blue-200 transition duration-200"
                                        placeholder="Tambahkan catatan atau penjelasan jika diperlukan...">{{ old('keterangan_tambahan') }}</textarea>
                                    <p class="text-xs text-slate-500 mt-2">
                                        Contoh: Lampiran surat dokter, alasan detail, atau informasi tambahan lainnya
                                    </p>
                                </div>
                            </div>

                            {{-- Confirmation & Submit --}}
                            <div class="pt-8 border-t border-slate-200">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                    <label class="flex items-start space-x-3">
                                        <div class="relative">
                                            <input type="hidden" name="konfirmasi" value="0">
                                            <input type="checkbox" name="konfirmasi" id="konfirmasi" value="1"
                                                class="w-5 h-5 rounded border-2 border-slate-300 
                                                      checked:border-blue-500 checked:bg-blue-500
                                                      focus:ring-3 focus:ring-blue-200 transition duration-200"
                                                {{ old('konfirmasi') ? 'checked' : '' }} required>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-slate-700">
                                                Saya menyatakan data yang diisi adalah benar dan lengkap
                                            </span>
                                            <p class="text-xs text-slate-500 mt-1">
                                                Data akan dikirim ke admin dan status akan dikirim ke email Anda
                                            </p>
                                        </div>
                                    </label>

                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <a href="{{ route('dashboard') }}"
                                            class="px-6 py-3 border border-slate-300 rounded-xl text-sm font-medium 
                                              text-slate-700 hover:bg-slate-50 transition duration-200
                                              flex items-center justify-center">
                                            <i class="fas fa-arrow-left mr-2"></i>
                                            Kembali ke Dashboard
                                        </a>
                                        <button type="submit"
                                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 
                                                   rounded-xl text-sm font-semibold text-white 
                                                   hover:from-blue-700 hover:to-blue-800 
                                                   focus:ring-4 focus:ring-blue-200 
                                                   transition-all duration-200 shadow-lg hover:shadow-xl
                                                   flex items-center justify-center">
                                            <i class="fas fa-paper-plane mr-2"></i>
                                            Kirim Pengajuan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Footer Note --}}
                <div class="mt-8 text-center text-sm text-slate-500">
                    <p>
                        <i class="fas fa-info-circle mr-1"></i>Notifikasi email akan dikirim ke admin dan status update
                        akan dikirim ke email Anda
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- Camera Modal --}}
    <div id="cameraModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-800">Ambil Foto</h3>
                    <button type="button" onclick="closeCamera()" class="text-slate-400 hover:text-slate-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="p-6">
                <div class="relative bg-black rounded-lg overflow-hidden mb-6" style="height: 400px;">
                    <video id="cameraVideo" autoplay class="w-full h-full object-cover"></video>
                    <canvas id="cameraCanvas" class="hidden"></canvas>

                    {{-- Camera Controls --}}
                    <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-4">
                        <button type="button" onclick="takePhoto()"
                            class="w-16 h-16 rounded-full bg-white border-4 border-slate-200 
                                   hover:bg-slate-50 transition duration-200 flex items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-slate-800"></div>
                        </button>

                        <button type="button" onclick="switchCamera()"
                            class="w-12 h-12 rounded-full bg-white/80 backdrop-blur-sm 
                                   hover:bg-white transition duration-200 flex items-center justify-center">
                            <i class="fas fa-sync-alt text-slate-700"></i>
                        </button>
                    </div>
                </div>

                <div id="photoPreview" class="hidden mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-medium text-slate-700">Preview Foto</h4>
                        <button type="button" onclick="retakePhoto()"
                            class="text-sm text-blue-600 hover:text-blue-700">
                            Ambil Ulang
                        </button>
                    </div>
                    <img id="capturedPhoto" class="w-full h-64 object-cover rounded-lg border border-slate-200">
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeCamera()"
                        class="px-6 py-2.5 border border-slate-300 rounded-xl text-sm font-medium 
                               text-slate-700 hover:bg-slate-50 transition duration-200">
                        Batal
                    </button>
                    <button type="button" id="usePhotoBtn" onclick="usePhoto()"
                        class="px-6 py-2.5 bg-blue-600 rounded-xl text-sm font-medium text-white
                               hover:bg-blue-700 transition duration-200 hidden">
                        Gunakan Foto Ini
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Only run if user is logged in
            @if (Auth::check())
                const fileInput = document.getElementById('fileInput');
                const cameraImageData = document.getElementById('cameraImageData');
                const uploadArea = document.getElementById('uploadArea');
                const uploadContent = document.getElementById('uploadContent');
                const previewBox = document.getElementById('previewBox');
                const fileName = document.getElementById('fileName');
                const fileType = document.getElementById('fileType');
                const fileSize = document.getElementById('fileSize');

                const btnCamera = document.getElementById('btnCamera');
                const btnFile = document.getElementById('btnFile');

                const startInput = document.getElementById('tanggal_mulai');
                const endInput = document.getElementById('tanggal_selesai');
                const totalInput = document.getElementById('jumlah_hari');

                const phoneInput = document.querySelector('input[name="nomor_telepon"]');

                let currentStream = null;
                let facingMode = 'environment'; // 'user' untuk depan, 'environment' untuk belakang
                let capturedBlob = null;

                // Phone number formatting
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        value = value.match(new RegExp('.{1,4}', 'g')).join('-');
                    }
                    e.target.value = value;
                });

                // Set minimum date to today
                const today = new Date().toISOString().split('T')[0];
                startInput.min = today;
                endInput.min = today;

                // Calculate days function
                function calculateDays() {
                    if (!startInput.value || !endInput.value) return;

                    const start = new Date(startInput.value);
                    const end = new Date(endInput.value);

                    if (end < start) {
                        showNotification('⚠️ Tanggal selesai tidak boleh sebelum tanggal mulai.', 'warning');
                        endInput.value = '';
                        totalInput.value = '';
                        endInput.focus();
                        return;
                    }

                    const diff = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
                    totalInput.value = diff;

                    if (diff > 14) {
                        totalInput.classList.add('text-orange-600', 'font-bold');
                        showNotification(
                            `Pengajuan izin untuk ${diff} hari. Pastikan sesuai dengan kebijakan perusahaan.`,
                            'info');
                    } else {
                        totalInput.classList.remove('text-orange-600', 'font-bold');
                    }
                }

                startInput.addEventListener('change', function() {
                    endInput.min = this.value;
                    calculateDays();
                });

                endInput.addEventListener('change', calculateDays);

                // Camera Functions
                btnCamera.addEventListener('click', async function() {
                    const modal = document.getElementById('cameraModal');
                    modal.classList.remove('hidden');

                    try {
                        const constraints = {
                            video: {
                                facingMode: facingMode,
                                width: {
                                    ideal: 1280
                                },
                                height: {
                                    ideal: 720
                                }
                            },
                            audio: false
                        };

                        currentStream = await navigator.mediaDevices.getUserMedia(constraints);
                        const video = document.getElementById('cameraVideo');
                        video.srcObject = currentStream;

                        // Reset preview
                        document.getElementById('photoPreview').classList.add('hidden');
                        document.getElementById('usePhotoBtn').classList.add('hidden');

                    } catch (err) {
                        console.error('Error accessing camera:', err);
                        showNotification(
                            'Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.',
                            'error');
                        closeCamera();

                        // Fallback ke file upload
                        showNotification('Mengalihkan ke pilihan file...', 'info');
                        setTimeout(() => btnFile.click(), 1000);
                    }
                });

                btnFile.addEventListener('click', function() {
                    fileInput.click();
                });

                // File upload handling
                fileInput.addEventListener('change', function() {
                    handleFileUpload(this.files[0]);
                });

                function handleFileUpload(file) {
                    if (!file) return;

                    // Validate file size (5MB max)
                    const maxSize = 5 * 1024 * 1024;
                    if (file.size > maxSize) {
                        showNotification('File terlalu besar. Maksimal ukuran file adalah 5MB.', 'error');
                        return;
                    }

                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
                    if (!validTypes.includes(file.type)) {
                        showNotification('Format file tidak didukung. Gunakan JPG, PNG, atau PDF.', 'error');
                        return;
                    }

                    updatePreview(file);
                }

                function updatePreview(file) {
                    // Hide upload area
                    uploadArea.classList.add('hidden');

                    // Update preview info
                    fileName.textContent = file.name.length > 30 ? file.name.substring(0, 27) + '...' : file.name;

                    const type = file.type.split('/')[1]?.toUpperCase() || file.name.split('.').pop().toUpperCase();
                    fileType.textContent = type === 'PDF' ? 'Dokumen PDF' : `Gambar ${type}`;

                    const size = (file.size / 1024 / 1024).toFixed(2);
                    fileSize.textContent = `${size} MB`;

                    // Show preview
                    previewBox.classList.remove('hidden');

                    showNotification('File berhasil diupload!', 'info');
                }

                // Camera modal functions
                window.takePhoto = function() {
                    const video = document.getElementById('cameraVideo');
                    const canvas = document.getElementById('cameraCanvas');
                    const photoPreview = document.getElementById('photoPreview');
                    const capturedPhoto = document.getElementById('capturedPhoto');
                    const usePhotoBtn = document.getElementById('usePhotoBtn');

                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;

                    const context = canvas.getContext('2d');
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    // Convert to blob
                    canvas.toBlob(function(blob) {
                        capturedBlob = blob;

                        // Show preview
                        capturedPhoto.src = URL.createObjectURL(blob);
                        photoPreview.classList.remove('hidden');
                        usePhotoBtn.classList.remove('hidden');

                        // Stop camera
                        if (currentStream) {
                            currentStream.getTracks().forEach(track => track.stop());
                        }

                    }, 'image/jpeg', 0.8);
                };

                window.switchCamera = function() {
                    facingMode = facingMode === 'environment' ? 'user' : 'environment';

                    if (currentStream) {
                        currentStream.getTracks().forEach(track => track.stop());
                    }

                    const constraints = {
                        video: {
                            facingMode: facingMode
                        },
                        audio: false
                    };

                    navigator.mediaDevices.getUserMedia(constraints)
                        .then(stream => {
                            currentStream = stream;
                            const video = document.getElementById('cameraVideo');
                            video.srcObject = stream;
                        })
                        .catch(err => {
                            console.error('Error switching camera:', err);
                            showNotification('Tidak dapat mengganti kamera.', 'error');
                        });
                };

                window.retakePhoto = function() {
                    const photoPreview = document.getElementById('photoPreview');
                    const usePhotoBtn = document.getElementById('usePhotoBtn');

                    photoPreview.classList.add('hidden');
                    usePhotoBtn.classList.add('hidden');

                    // Start camera again
                    const constraints = {
                        video: {
                            facingMode: facingMode
                        },
                        audio: false
                    };

                    navigator.mediaDevices.getUserMedia(constraints)
                        .then(stream => {
                            currentStream = stream;
                            const video = document.getElementById('cameraVideo');
                            video.srcObject = stream;
                        })
                        .catch(console.error);
                };

                window.usePhoto = function() {
                    if (!capturedBlob) return;

                    // Create a file from blob
                    const file = new File([capturedBlob], `foto-izin-${Date.now()}.jpg`, {
                        type: 'image/jpeg',
                        lastModified: Date.now()
                    });

                    // Create a DataTransfer object to set the file
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;

                    // Update preview
                    updatePreview(file);

                    // Close camera
                    closeCamera();

                    showNotification('Foto berhasil digunakan!', 'success');
                };

                window.closeCamera = function() {
                    const modal = document.getElementById('cameraModal');
                    modal.classList.add('hidden');

                    if (currentStream) {
                        currentStream.getTracks().forEach(track => track.stop());
                        currentStream = null;
                    }
                };

                window.retakeFile = function() {
                    // Show upload options again
                    uploadArea.classList.remove('hidden');
                    previewBox.classList.add('hidden');

                    // Reset file input
                    fileInput.value = '';
                    cameraImageData.value = '';
                    capturedBlob = null;
                };

                window.removeFile = function() {
                    fileInput.value = '';
                    cameraImageData.value = '';
                    capturedBlob = null;

                    uploadArea.classList.add('hidden');
                    previewBox.classList.add('hidden');

                    showNotification('File berhasil dihapus', 'info');
                };

                // Notification function
                function showNotification(message, type = 'info') {
                    const existing = document.getElementById('temp-notification');
                    if (existing) existing.remove();

                    const colors = {
                        warning: 'bg-yellow-100 border-yellow-400 text-yellow-700',
                        info: 'bg-blue-100 border-blue-400 text-blue-700',
                        error: 'bg-red-100 border-red-400 text-red-700',
                        success: 'bg-green-100 border-green-400 text-green-700'
                    };

                    const notification = document.createElement('div');
                    notification.id = 'temp-notification';
                    notification.className =
                        `fixed top-4 right-4 p-4 rounded-lg border ${colors[type]} text-sm z-50 shadow-lg animate-fade-in`;
                    notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'warning' ? 'exclamation-triangle' : type === 'error' ? 'exclamation-circle' : type === 'success' ? 'check-circle' : 'info-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;

                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.style.opacity = '0';
                        notification.style.transition = 'opacity 0.3s';
                        setTimeout(() => notification.remove(), 300);
                    }, 4000);
                }

                // Form validation before submit
                document.getElementById('izinForm').addEventListener('submit', function(e) {
                    // Validate phone number
                    const phoneValue = phoneInput.value.replace(/\D/g, '');
                    if (phoneValue.length < 10) {
                        e.preventDefault();
                        showNotification('Nomor telepon harus minimal 10 digit angka', 'error');
                        phoneInput.focus();
                        phoneInput.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                        return;
                    }

                    // Validate address
                    const address = document.querySelector('textarea[name="alamat"]').value.trim();
                    if (address.length < 10) {
                        e.preventDefault();
                        showNotification('Alamat harus diisi dengan lengkap (minimal 10 karakter)',
                        'error');
                        return;
                    }

                    // Validate file upload
                    if (!fileInput.files[0] && !capturedBlob) {
                        if (!confirm('Anda belum mengupload dokumen pendukung. Lanjutkan tanpa dokumen?')) {
                            e.preventDefault();
                            showNotification('Harap upload dokumen pendukung terlebih dahulu', 'warning');
                            return;
                        }
                    }

                    // Add loading state
                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.innerHTML = `
            <i class="fas fa-spinner fa-spin mr-2"></i>
            Memproses...
        `;
                    submitBtn.disabled = true;
                });
            @endif
        });

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    #btnCamera.active, #btnFile.active {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    
    input:checked + div {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    
    input:checked + div > div > div {
        border-color: #3b82f6;
        background-color: #3b82f6;
        border-width: 4px;
        border-color: white;
    }
    
    input:checked + div > div > span {
        color: #1e40af;
        font-weight: 600;
    }
    
    /* Custom scrollbar */
    textarea::-webkit-scrollbar {
        width: 6px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    textarea::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Camera modal animations */
    #cameraModal {
        animation: modalFadeIn 0.3s ease-out;
    }
    
    @keyframes modalFadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
`;
        document.head.appendChild(style);
    </script>

</body>

</html>
