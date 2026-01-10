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
    <div class="max-w-2xl mx-auto">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-center mb-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="w-24 h-1 bg-blue-600"></div>
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        2
                    </div>
                </div>
            </div>
            <div class="flex justify-center text-sm text-gray-600">
                <div class="mr-16">Basic Information</div>
                <div class="font-semibold text-blue-600">Upload Details</div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-info-circle mr-2"></i>About today
                </h1>
                <p class="text-gray-600">Complete your daily cleaning report</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cleaning-report.storeStep2', $report->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Tanggal dan Jam Membership -->
                <div class="mb-8">
                    <label for="membership_datetime" class="block text-lg font-semibold text-gray-700 mb-3">
                        <i class="fas fa-calendar-alt mr-2"></i>Tanggal dan Jam membershipkan *
                    </label>
                    <div class="relative">
                        <input 
                            type="datetime-local" 
                            id="membership_datetime" 
                            name="membership_datetime" 
                            required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none transition duration-200"
                            value="{{ old('membership_datetime', now()->format('Y-m-d\TH:i')) }}"
                        >
                        <div class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>Format: MM/DD/YYYY HH:MM
                        </div>
                    </div>
                </div>

                <!-- Upload Foto -->
                <div class="mb-8">
                    <label class="block text-lg font-semibold text-gray-700 mb-3">
                        <i class="fas fa-camera mr-2"></i>Upload Bukti Foto Tampilan Toilet yang sudah bersih *
                    </label>
                    
                    <!-- File Upload Area -->
                    <div class="mt-2">
                        <div id="drop-area" 
                             class="border-4 border-dashed border-gray-300 rounded-2xl p-12 text-center hover:border-blue-400 hover:bg-blue-50 transition duration-200 cursor-pointer">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-cloud-upload-alt text-5xl text-gray-400 mb-4"></i>
                                <p class="text-xl font-semibold text-gray-700 mb-2">Drag & drop a file or browse</p>
                                <p class="text-gray-500 mb-4">Supports JPG, PNG, GIF up to 2MB</p>
                                
                                <!-- Browse Button -->
                                <label for="toilet_photo" class="cursor-pointer">
                                    <div class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg inline-flex items-center transition duration-200">
                                        <i class="fas fa-search mr-2"></i>Browse Files
                                    </div>
                                    <input type="file" 
                                           id="toilet_photo" 
                                           name="toilet_photo" 
                                           accept="image/*" 
                                           class="hidden" 
                                           required>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Preview Image -->
                        <div id="preview-container" class="mt-6 hidden">
                            <p class="text-gray-700 font-medium mb-2">Selected Image:</p>
                            <div class="relative inline-block">
                                <img id="preview-image" 
                                     src="#" 
                                     alt="Preview" 
                                     class="max-w-full h-64 rounded-lg border-2 border-gray-300">
                                <button type="button" 
                                        id="remove-image" 
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-sm text-gray-500 mt-4">
                        <i class="fas fa-shield-alt mr-1"></i>Your files are securely uploaded and protected
                    </div>
                </div>

                <!-- Warning Message -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <span class="font-bold">Security Notice:</span> Never share passwords in Fillout forms. Report malicious forms.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between">
                    <a href="{{ route('cleaning-report.create') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-8 rounded-lg flex items-center transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </a>
                    
                    <button 
                        type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg flex items-center transition duration-200 transform hover:scale-105"
                    >
                        <i class="fas fa-paper-plane mr-2"></i>Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('toilet_photo');
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const removeButton = document.getElementById('remove-image');

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Highlight drop area when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropArea.classList.add('border-blue-500', 'bg-blue-100');
            }

            function unhighlight() {
                dropArea.classList.remove('border-blue-500', 'bg-blue-100');
            }

            // Handle dropped files
            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                handleFiles(files);
            }

            // Handle file selection via browse button
            fileInput.addEventListener('change', function() {
                handleFiles(this.files);
            });

            function handleFiles(files) {
                if (files.length > 0) {
                    const file = files[0];
                    
                    // Validate file type
                    if (!file.type.match('image.*')) {
                        alert('Please select an image file.');
                        return;
                    }
                    
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size must be less than 2MB.');
                        return;
                    }
                    
                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Remove image
            removeButton.addEventListener('click', function() {
                fileInput.value = '';
                previewContainer.classList.add('hidden');
                previewImage.src = '#';
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                if (!fileInput.files.length) {
                    e.preventDefault();
                    alert('Please upload a toilet photo.');
                    return false;
                }
            });

            // Initialize datetime picker with current time
            const now = new Date();
            const timezoneOffset = now.getTimezoneOffset() * 60000;
            const localISOTime = new Date(now - timezoneOffset).toISOString().slice(0, 16);
            document.getElementById('membership_datetime').value = localISOTime;
        });
    </script>
</body>
</html>