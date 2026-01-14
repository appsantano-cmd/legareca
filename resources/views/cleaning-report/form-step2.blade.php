<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Cleaning Report - Step 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-md mx-auto px-4">
        <div class="mb-4">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm">
                        ✓
                    </div>
                    <div class="w-16 h-1 bg-blue-600"></div>
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm">
                        2
                    </div>
                </div>
            </div>
            <div class="flex justify-center text-xs text-gray-600 mt-2">
                <div class="mr-12">Personal Info</div>
                <div class="font-semibold">Date & Photo</div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
            <div class="text-center mb-8">
                <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-calendar-alt mr-2"></i>Date & Photo Upload
                </h1>
                <p class="text-gray-600">Complete your report</p>

                @if (isset($step1Data))
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-700">
                            <span class="font-semibold">Name:</span> {{ $step1Data['nama'] }}<br>
                            <span class="font-semibold">Department:</span> {{ $step1Data['departemen'] }}
                        </p>
                    </div>
                @endif
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('cleaning-report.storeStep2') }}" method="POST" enctype="multipart/form-data"
                id="reportForm">
                @csrf

                <!-- Hidden input untuk menyimpan file yang sudah dipilih -->
                <input type="hidden" name="foto_data" id="foto_data">

                <div class="mb-6">
                    <label for="tanggal" class="block font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-day mr-2"></i>Tanggal *
                    </label>
                    <input type="date" id="tanggal" name="tanggal" required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                        value="{{ old('tanggal', date('Y-m-d')) }}">
                </div>

                <div class="mb-8">
                    <label class="block font-semibold text-gray-700 mb-2">
                        <i class="fas fa-camera mr-2"></i>Upload Foto Toilet *
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 md:p-6 text-center">
                        <!-- Single file input untuk semua sumber -->
                        <input type="file" id="foto-input" name="foto" accept="image/*" class="hidden">

                        <div id="upload-area" class="cursor-pointer">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-cloud-upload-alt text-3xl md:text-4xl text-gray-400 mb-3 md:mb-4"></i>
                                <p class="text-gray-700 font-medium mb-2 text-sm md:text-base">Upload photo of toilet
                                </p>
                                <p class="text-gray-500 text-xs md:text-sm">JPG, PNG (No size limit)</p>
                                <div class="flex flex-col sm:flex-row gap-2 mt-4">
                                    <button type="button" onclick="openCamera()"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                                        <i class="fas fa-camera mr-1"></i> Take Photo
                                    </button>
                                    <button type="button" onclick="openGallery()"
                                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm hover:bg-gray-300 transition">
                                        <i class="fas fa-images mr-1"></i> Choose from Gallery
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="preview-container" class="hidden mt-4">
                            <p class="text-gray-700 font-medium mb-2">Selected Photo:</p>
                            <div class="relative">
                                <img id="preview-image" class="w-full h-48 object-cover rounded-lg border">
                                <div class="mt-2">
                                    <p id="file-info" class="text-xs text-gray-500 mb-2"></p>
                                    <div class="flex justify-center space-x-2">
                                        <button type="button" onclick="retakePhoto()"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-yellow-600 transition">
                                            <i class="fas fa-redo mr-1"></i>Retake
                                        </button>
                                        <button type="button" onclick="removeImage()"
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600 transition">
                                            <i class="fas fa-trash mr-1"></i>Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="loading" class="hidden mt-4">
                            <div class="flex flex-col items-center">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mb-2"></div>
                                <p class="text-gray-600">Processing image...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Error message container -->
                    <div id="error-message" class="hidden mt-2 p-2 bg-red-100 text-red-700 rounded text-sm"></div>
                </div>

                <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
                    <a href="{{ route('cleaning-report.create') }}"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-4 rounded-lg text-center transition">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>

                    <button type="submit" id="submit-btn"
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i>Save Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Set default date to today
        document.getElementById('tanggal').valueAsDate = new Date();

        let currentFile = null;
        let currentFileName = '';

        // Deteksi perangkat mobile
        function isMobileDevice() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }

        // Deteksi iOS
        function isIOS() {
            return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        }

        // Deteksi Android
        function isAndroid() {
            return /Android/.test(navigator.userAgent);
        }

        // Format ukuran file
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Buka kamera
        function openCamera() {
            const input = document.getElementById('foto-input');

            // Reset input terlebih dahulu
            input.value = '';

            // Set atribut untuk kamera
            // iOS 14+ butuh approach khusus
            if (isIOS()) {
                // Untuk iOS, coba kedua metode
                input.removeAttribute('capture');
                input.setAttribute('capture', 'environment'); // Kamera belakang

                // Coba dengan user-facing camera juga
                setTimeout(() => {
                    input.click();
                }, 100);
            } else if (isAndroid()) {
                // Android biasanya support capture
                input.setAttribute('capture', 'camera');
                input.click();
            } else {
                // Desktop atau browser lain
                input.removeAttribute('capture');
                input.click();
            }

            // Set event handler
            input.onchange = function(e) {
                handleFileSelection(e);
            };

            if (!isIOS()) {
                input.click();
            }
        }

        // Buka gallery
        function openGallery() {
            const input = document.getElementById('foto-input');

            // Reset input
            input.value = '';

            // Hapus atribut capture untuk gallery
            input.removeAttribute('capture');

            // Set event handler
            input.onchange = function(e) {
                handleFileSelection(e);
            };

            input.click();
        }

        // Handle pemilihan file
        function handleFileSelection(event) {
            const file = event.target.files[0];

            if (!file) return;

            // Reset error message
            hideError();

            // Validasi tipe file
            if (!file.type.match('image.*')) {
                showError('Please select an image file (JPG, PNG, etc.)');
                resetFileInput();
                return;
            }

            // Simpan file dan nama
            currentFile = file;
            currentFileName = file.name;

            // Tampilkan loading
            showLoading(true);

            // Proses file
            processFile(file);
        }

        // Proses file (HEIC conversion untuk iOS)
        function processFile(file) {
            // Untuk iOS, konversi HEIC ke JPEG jika perlu
            if (isIOS() && (file.type === 'image/heic' || file.type === 'image/heif' ||
                    file.name.toLowerCase().endsWith('.heic') || file.name.toLowerCase().endsWith('.heif'))) {

                convertHEICtoJPEG(file).then(convertedFile => {
                    currentFile = convertedFile;
                    displayFile(convertedFile);
                }).catch(error => {
                    console.error('HEIC conversion error:', error);
                    // Fallback ke file asli
                    displayFile(file);
                });
            } else {
                displayFile(file);
            }
        }

        // Konversi HEIC ke JPEG (untuk iOS)
        function convertHEICtoJPEG(file) {
            return new Promise((resolve, reject) => {
                // Cek jika browser mendukung heic2any
                if (typeof heic2any !== 'undefined') {
                    heic2any({
                        blob: file,
                        toType: 'image/jpeg',
                        quality: 0.9
                    }).then(jpegBlob => {
                        const convertedFile = new File([jpegBlob],
                            file.name.replace(/\.heic$|\.heif$/i, '.jpg'), {
                                type: 'image/jpeg',
                                lastModified: new Date().getTime()
                            }
                        );
                        resolve(convertedFile);
                    }).catch(error => {
                        console.error('HEIC conversion failed:', error);
                        reject(error);
                    });
                } else {
                    // Jika library tidak tersedia, gunakan file asli
                    resolve(file);
                }
            });
        }

        // Tampilkan file di preview
        function displayFile(file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const preview = document.getElementById('preview-image');
                preview.src = e.target.result;

                // Simpan data base64 untuk backup
                document.getElementById('foto_data').value = e.target.result;

                // Tampilkan info file
                displayFileInfo(file);

                // Tampilkan preview
                showPreview();
                showLoading(false);
            };

            reader.onerror = function() {
                showError('Error reading file. Please try again.');
                showLoading(false);
            };

            reader.readAsDataURL(file);
        }

        // Tampilkan informasi file
        function displayFileInfo(file) {
            const fileInfo = document.getElementById('file-info');
            if (fileInfo) {
                fileInfo.textContent = `${file.name} (${formatFileSize(file.size)})`;
            }
        }

        // Tampilkan preview
        function showPreview() {
            const container = document.getElementById('preview-container');
            const uploadArea = document.getElementById('upload-area');

            container.classList.remove('hidden');
            uploadArea.classList.add('hidden');
        }

        // Ulang ambil foto
        function retakePhoto() {
            removeImage();
            setTimeout(() => {
                openCamera();
            }, 300);
        }

        // Hapus gambar
        function removeImage() {
            const container = document.getElementById('preview-container');
            const uploadArea = document.getElementById('upload-area');
            const input = document.getElementById('foto-input');
            const fotoData = document.getElementById('foto_data');

            // Reset semua
            input.value = '';
            fotoData.value = '';

            // Reset preview
            container.classList.add('hidden');
            uploadArea.classList.remove('hidden');

            // Reset state
            currentFile = null;
            currentFileName = '';
            hideError();

            // Reset info file
            const fileInfo = document.getElementById('file-info');
            if (fileInfo) {
                fileInfo.textContent = '';
            }
        }

        // Reset input file
        function resetFileInput() {
            const input = document.getElementById('foto-input');
            input.value = '';
            currentFile = null;
            currentFileName = '';
        }

        // Tampilkan loading
        function showLoading(show) {
            const loading = document.getElementById('loading');
            if (show) {
                loading.classList.remove('hidden');
            } else {
                loading.classList.add('hidden');
            }
        }

        // Tampilkan error
        function showError(message) {
            const errorDiv = document.getElementById('error-message');
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
        }

        // Sembunyikan error
        function hideError() {
            const errorDiv = document.getElementById('error-message');
            errorDiv.classList.add('hidden');
        }

        // Validasi form sebelum submit
        document.getElementById('reportForm').addEventListener('submit', function(e) {
            const input = document.getElementById('foto-input');
            const fotoData = document.getElementById('foto_data');

            // Cek apakah ada file yang dipilih
            if (!input.files || input.files.length === 0) {
                e.preventDefault();
                showError('Please select or take a photo before submitting.');
                return false;
            }

            // Validasi tanggal
            const tanggalInput = document.getElementById('tanggal');
            if (!tanggalInput.value) {
                e.preventDefault();
                showError('Please select a date.');
                return false;
            }

            // Tambahan: Backup dengan base64 jika file input kosong tapi ada preview
            const previewContainer = document.getElementById('preview-container');
            if (!previewContainer.classList.contains('hidden') && input.files.length === 0 && fotoData.value) {
                // File mungkin hilang karena issue browser
                // Kita akan submit dengan base64 data
                console.log('Using base64 backup data');
            }

            // Disable tombol submit untuk mencegah double submit
            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';

            // Show uploading message untuk file besar
            if (input.files.length > 0) {
                const file = input.files[0];
                if (file && file.size > 10 * 1024 * 1024) {
                    submitBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading large file, please wait...';
                }
            }

            // ===== TAMBAHKAN KODE REFRESH NOTIFIKASI DI SINI =====
            // Refresh notifikasi setelah 1.5 detik (beri waktu server memproses)
            setTimeout(() => {
                // Coba panggil fungsi refresh notifikasi
                if (typeof window.parent !== 'undefined' &&
                    typeof window.parent.refreshNotifications === 'function') {
                    window.parent.refreshNotifications();
                } else if (typeof window.refreshNotifications === 'function') {
                    window.refreshNotifications();
                } else if (typeof fetchNotifications === 'function') {
                    fetchNotifications();
                } else {
                    // Fallback: AJAX call langsung ke endpoint notifikasi
                    fetch('/api/notifications/unread-count', {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Notifications updated after form submit');
                        });
                }
            }, 1500);

        });

        // Optional: Handle browser yang tidak support camera dengan baik
        function setupCameraFallback() {
            // Jika iOS dan tidak bisa akses kamera, beri warning
            if (isIOS()) {
                const isIOS14orHigher = /OS 1[4-9]|OS [2-9][0-9]/.test(navigator.userAgent);
                if (isIOS14orHigher) {
                    console.log('iOS 14+ detected, camera may have permissions issues');
                }
            }
        }

        // Panggil setup saat halaman load
        document.addEventListener('DOMContentLoaded', function() {
            setupCameraFallback();
        });
    </script>

    <!-- Library untuk konversi HEIC (iOS) -->
    <script src="https://cdn.jsdelivr.net/npm/heic2any@0.0.3/dist/heic2any.min.js"></script>

    <!-- Optional: Tambahkan polyfill untuk browsers lama -->
    <script>
        // Polyfill untuk File API jika diperlukan
        if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
            alert('Your browser is too old to support file uploads. Please update your browser.');
        }
    </script>
</body>

</html>
