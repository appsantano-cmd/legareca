<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Cleaning Report - Step 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .card {
            background: linear-gradient(145deg, #ffffff 0%, #f7f9fc 100%);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.15);
        }
        
        .logo-container {
            position: relative;
            display: inline-block;
        }
        
        .logo-container::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: white;
            border-radius: 2px;
        }
        
        .input-field {
            transition: all 0.3s ease;
            background: white;
            border: 2px solid #e2e8f0;
        }
        
        .input-field:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(-1px);
        }
        
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-primary:hover::after {
            left: 100%;
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .step {
            display: flex;
            align-items: center;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
            position: relative;
            z-index: 2;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .step.completed .step-number {
            background: white;
            color: #10b981;
            border: 2px solid white;
        }
        
        .step.active .step-number {
            background: white;
            color: #667eea;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
            border: 2px solid white;
        }
        
        .step-label {
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        
        .step-line {
            width: 80px;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
            margin: 0 10px;
            position: relative;
            top: -8px;
        }
        
        .animation-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        .animation-slide-up {
            animation: slideUp 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .error-card {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .upload-area {
            border: 2px dashed #667eea;
            background: linear-gradient(135deg, #667eea10 0%, #764ba210 100%);
            transition: all 0.3s ease;
        }
        
        .upload-area:hover {
            border-color: #764ba2;
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            transform: translateY(-2px);
        }
        
        .btn-camera {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-camera:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        
        .btn-gallery {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #374151;
            transition: all 0.3s ease;
        }
        
        .btn-gallery:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .btn-back {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #374151;
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.4);
        }
        
        .user-info-card {
            background: linear-gradient(135deg, #667eea10 0%, #764ba210 100%);
            border-left: 4px solid #667eea;
        }
        
        .preview-image-container {
            border: 3px solid #667eea;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
        }
        
        .preview-image-container:hover {
            transform: scale(1.01);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }
        
        .btn-retake {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-retake:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
        }
        
        .btn-remove {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-remove:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        }
        
        .info-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
            margin-right: 15px;
        }
    </style>
</head>
<body class="min-h-screen py-8 px-4 animation-fade-in">
    <div class="max-w-md mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8 animation-slide-up">
            <div class="logo-container mb-6">
                <div class="w-40 h-40 mx-auto bg-gradient-to-br from-blue-100 to-purple-100 rounded-full p-4 shadow-lg">
                    <div class="w-full h-full bg-white rounded-full p-4">
                        <img 
                            src="{{ asset('logo.png') }}" 
                            alt="Company Logo" 
                            class="w-full h-full object-contain rounded-full"
                            onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMjAiIGhlaWdodD0iMTIwIiByeD0iNjAiIGZpbGw9InVybCgjY2xvZ28tZ3JhZGllbnQpIi8+CjxwYXRoIGQ9Ik0zNSA0NUg4NU02NSA0NVY5ME00NSA2NUg4NSIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSI1IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPGRlZnM+CjxsaW5lYXJHcmFkaWVudCBpZD0iY2xvZ28tZ3JhZGllbnQiIHgxPSIwIiB5MT0iMCIgeDI9IjEyMCIgeTI9IjEyMCIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPgo8c3RvcCBzdG9wLWNvbG9yPSIjNjY3RUVBIi8+CjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzc2NEJBMiIvPgo8L2xpbmVhckdyYWRpZW50Pgo8L2RlZnM+Cjwvc3ZnPgo=';"
                        >
                    </div>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">
                <i class="fas fa-broom mr-2"></i>Daily Cleaning Report
            </h1>
            <p class="text-white opacity-90">Complete your daily cleaning documentation</p>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator animation-slide-up">
            <div class="step completed">
                <div class="step-number">
                    <i class="fas fa-user"></i>
                </div>
                <span class="step-label">Personal Info</span>
            </div>
            <div class="step-line"></div>
            <div class="step active">
                <div class="step-number">2</div>
                <span class="step-label">Date & Photo</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-number">3</div>
                <span class="step-label">Complete</span>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card p-6 mb-6 animation-slide-up" style="animation-delay: 0.1s">
            @if ($errors->any())
                <div class="error-card bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700 px-4 py-4 rounded-xl mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="font-semibold">Please fix the following errors:</p>
                            <ul class="mt-1 text-sm list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- User Information -->
            @if(isset($step1Data))
            <div class="user-info-card rounded-xl p-4 mb-6 animation-slide-up" style="animation-delay: 0.2s">
                <div class="flex items-center">
                    <div class="info-icon">
                        <i class="fas fa-user-check text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Personal Information</h3>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            <div>
                                <p class="text-xs text-gray-600">Name</p>
                                <p class="font-medium text-gray-800">{{ $step1Data['nama'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Department</p>
                                <p class="font-medium text-gray-800">{{ $step1Data['departemen'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('cleaning-report.storeStep2') }}" method="POST" enctype="multipart/form-data" id="reportForm">
                @csrf
                
                <!-- Hidden input untuk menyimpan file yang sudah dipilih -->
                <input type="hidden" name="foto_data" id="foto_data">
                
                <!-- Date Input -->
                <div class="mb-8 animation-slide-up" style="animation-delay: 0.3s">
                    <label for="tanggal" class="block font-semibold text-gray-700 mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-100 to-purple-100 flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-day text-blue-600"></i>
                            </div>
                            <div>
                                <span class="text-lg">Date *</span>
                                <p class="text-sm text-gray-500 font-normal mt-1">Select the cleaning date</p>
                            </div>
                        </div>
                    </label>
                    <div class="relative">
                        <input 
                            type="date" 
                            id="tanggal" 
                            name="tanggal" 
                            required
                            class="w-full px-5 py-4 input-field rounded-xl focus:outline-none"
                            value="{{ old('tanggal', date('Y-m-d')) }}"
                        >
                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-calendar text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Photo Upload -->
                <div class="mb-10 animation-slide-up" style="animation-delay: 0.4s">
                    <label class="block font-semibold text-gray-700 mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-100 to-purple-100 flex items-center justify-center mr-3">
                                <i class="fas fa-camera text-blue-600"></i>
                            </div>
                            <div>
                                <span class="text-lg">Photo Upload *</span>
                                <p class="text-sm text-gray-500 font-normal mt-1">Take or upload toilet photo</p>
                            </div>
                        </div>
                    </label>
                    
                    <!-- Upload Area -->
                    <div class="upload-area rounded-xl p-6 text-center">
                        <!-- Single file input untuk semua sumber -->
                        <input 
                            type="file" 
                            id="foto-input" 
                            name="foto" 
                            accept="image/*"
                            class="hidden"
                        >
                        
                        <div id="upload-area" class="cursor-pointer">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 flex items-center justify-center mb-4">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-blue-600"></i>
                                </div>
                                <p class="text-gray-700 font-medium mb-2">Upload Toilet Photo</p>
                                <p class="text-gray-500 text-sm mb-6">Supported: JPG, PNG, HEIC</p>
                                <div class="flex flex-col sm:flex-row gap-3 w-full">
                                    <button type="button" onclick="openCamera()" 
                                            class="btn-camera flex-1 py-3 px-4 rounded-xl font-medium">
                                        <i class="fas fa-camera mr-2"></i>Take Photo
                                    </button>
                                    <button type="button" onclick="openGallery()" 
                                            class="btn-gallery flex-1 py-3 px-4 rounded-xl font-medium">
                                        <i class="fas fa-images mr-2"></i>Choose from Gallery
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Preview Container -->
                        <div id="preview-container" class="hidden mt-6">
                            <p class="text-gray-700 font-medium mb-3 text-center">Selected Photo:</p>
                            <div class="preview-image-container rounded-xl overflow-hidden">
                                <img id="preview-image" class="w-full h-64 object-cover">
                                <div class="bg-gray-50 p-4">
                                    <p id="file-info" class="text-sm text-gray-600 text-center mb-4"></p>
                                    <div class="flex justify-center space-x-3">
                                        <button type="button" onclick="retakePhoto()" 
                                                class="btn-retake px-4 py-2 rounded-lg font-medium">
                                            <i class="fas fa-redo mr-2"></i>Retake
                                        </button>
                                        <button type="button" onclick="removeImage()" 
                                                class="btn-remove px-4 py-2 rounded-lg font-medium">
                                            <i class="fas fa-trash mr-2"></i>Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Loading Indicator -->
                        <div id="loading" class="hidden mt-6">
                            <div class="flex flex-col items-center">
                                <div class="relative w-16 h-16 mb-4">
                                    <div class="absolute inset-0 rounded-full border-4 border-blue-200"></div>
                                    <div class="absolute inset-0 rounded-full border-4 border-blue-600 border-t-transparent animate-spin"></div>
                                </div>
                                <p class="text-gray-600 font-medium">Processing image...</p>
                                <p class="text-gray-500 text-sm mt-1">Please wait a moment</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Error message container -->
                    <div id="error-message" class="hidden mt-4 p-4 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700 rounded-xl text-sm"></div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-10 animation-slide-up" style="animation-delay: 0.5s">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="{{ route('cleaning-report.create') }}" 
                           class="btn-back py-4 px-6 rounded-xl font-semibold text-center flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-3"></i>
                            Back
                        </a>
                        
                        <button type="submit" id="submit-btn"
                                class="btn-submit py-4 px-6 rounded-xl font-semibold flex items-center justify-center">
                            <i class="fas fa-save mr-3"></i>
                            Save Report
                        </button>
                    </div>
                    
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Make sure the photo clearly shows the toilet condition
                        </p>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center text-white text-sm animation-slide-up" style="animation-delay: 0.6s">
            <p>© {{ date('Y') }} Legareca Cleaning System. All rights reserved.</p>
            <p class="mt-1 opacity-90">Step 2 of 3 - Date & Photo Upload</p>
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
                            file.name.replace(/\.heic$|\.heif$/i, '.jpg'), 
                            { type: 'image/jpeg', lastModified: new Date().getTime() }
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
                
                // Tampilkan preview dengan animasi
                setTimeout(() => {
                    showPreview();
                    showLoading(false);
                }, 500);
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
                const date = new Date(file.lastModified).toLocaleDateString();
                fileInfo.textContent = `${file.name} • ${formatFileSize(file.size)} • ${date}`;
            }
        }
        
        // Tampilkan preview dengan animasi
        function showPreview() {
            const container = document.getElementById('preview-container');
            const uploadArea = document.getElementById('upload-area');
            
            uploadArea.style.opacity = '0';
            uploadArea.style.height = '0';
            uploadArea.style.overflow = 'hidden';
            
            setTimeout(() => {
                uploadArea.classList.add('hidden');
                container.classList.remove('hidden');
                container.style.opacity = '0';
                container.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    container.style.opacity = '1';
                    container.style.transform = 'translateY(0)';
                    container.style.transition = 'all 0.5s ease';
                }, 10);
            }, 300);
        }
        
        // Ulang ambil foto
        function retakePhoto() {
            removeImage();
            setTimeout(() => {
                openCamera();
            }, 300);
        }
        
        // Hapus gambar dengan animasi
        function removeImage() {
            const container = document.getElementById('preview-container');
            const uploadArea = document.getElementById('upload-area');
            const input = document.getElementById('foto-input');
            const fotoData = document.getElementById('foto_data');
            
            // Animasi hide preview
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                // Reset semua
                input.value = '';
                fotoData.value = '';
                
                // Reset preview
                container.classList.add('hidden');
                container.style.opacity = '';
                container.style.transform = '';
                
                // Tampilkan kembali upload area
                uploadArea.classList.remove('hidden');
                uploadArea.style.opacity = '';
                uploadArea.style.height = '';
                uploadArea.style.overflow = '';
                
                // Reset state
                currentFile = null;
                currentFileName = '';
                hideError();
                
                // Reset info file
                const fileInfo = document.getElementById('file-info');
                if (fileInfo) {
                    fileInfo.textContent = '';
                }
            }, 500);
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
        
        // Tampilkan error dengan animasi
        function showError(message) {
            const errorDiv = document.getElementById('error-message');
            errorDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                    <div>${message}</div>
                </div>
            `;
            errorDiv.style.opacity = '0';
            errorDiv.classList.remove('hidden');
            
            setTimeout(() => {
                errorDiv.style.opacity = '1';
                errorDiv.style.transition = 'opacity 0.3s ease';
            }, 10);
        }
        
        // Sembunyikan error
        function hideError() {
            const errorDiv = document.getElementById('error-message');
            errorDiv.style.opacity = '0';
            setTimeout(() => {
                errorDiv.classList.add('hidden');
                errorDiv.style.opacity = '';
            }, 300);
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
            submitBtn.innerHTML = `
                <div class="flex items-center">
                    <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mr-3"></div>
                    Saving Report...
                </div>
            `;
            
            // Show uploading message untuk file besar
            if (input.files.length > 0) {
                const file = input.files[0];
                if (file && file.size > 10 * 1024 * 1024) {
                    submitBtn.innerHTML = `
                        <div class="flex items-center">
                            <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mr-3"></div>
                            Uploading large file, please wait...
                        </div>
                    `;
                }
            }
        });
        
        // Add ripple effect to buttons
        function addRippleEffect(button) {
            button.addEventListener('click', function(e) {
                let ripple = document.createElement('span');
                ripple.classList.add('ripple');
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.7);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                `;
                
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        }
        
        // Add ripple to all buttons
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                if (!button.id.includes('foto-input')) {
                    addRippleEffect(button);
                }
            });
            
            // Add CSS for ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
                button {
                    position: relative;
                    overflow: hidden;
                }
            `;
            document.head.appendChild(style);
            
            // Setup camera fallback
            setupCameraFallback();
        });
        
        // Optional: Handle browser yang tidak support camera dengan baik
        function setupCameraFallback() {
            if (isIOS()) {
                const isIOS14orHigher = /OS 1[4-9]|OS [2-9][0-9]/.test(navigator.userAgent);
                if (isIOS14orHigher) {
                    console.log('iOS 14+ detected, camera may have permissions issues');
                }
            }
        }
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