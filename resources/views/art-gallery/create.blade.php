<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Karya Seni - Art Gallery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Include Dropzone for image upload (optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
<div class="min-h-screen p-4 md:p-6">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-palette text-purple-600"></i> Tambah Karya Seni Baru
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Tambahkan karya seni baru ke dalam galeri
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold transition border border-gray-300 shadow-sm">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-purple-600"></i> Form Tambah Karya Seni
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Isi semua informasi tentang karya seni di bawah ini
                </p>
            </div>

            <form action="{{ route('gallery.store') }}" 
                method="POST" 
                enctype="multipart/form-data" 
                class="p-6 space-y-6">
                @csrf

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Judul
                    </label>
                    <input type="text"
                        name="title"
                        value="{{ old('title') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Artist --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Seniman
                    </label>
                    <input type="text"
                        name="artist"
                        value="{{ old('artist') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    @error('artist')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi Pameran
                    </label>
                    <input type="text"
                        name="location"
                        value="{{ old('location') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    @error('location')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Start Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai
                    </label>
                    <input type="date"
                        name="start_date"
                        value="{{ old('start_date') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    @error('start_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- End Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Selesai
                    </label>
                    <input type="date"
                        name="end_date"
                        value="{{ old('end_date') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                    @error('end_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Short Description --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Singkat (Max 500 karakter)
                    </label>
                    <textarea name="short_description"
                            rows="3"
                            maxlength="500"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none">{{ old('short_description') }}</textarea>
                    @error('short_description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Lengkap
                    </label>
                    <textarea name="description"
                            rows="6"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Karya
                    </label>
                    <input type="file"
                        name="image_path"
                        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml"
                        required
                        class="w-full border border-gray-300 rounded-lg p-2">
                    @error('image_path')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="flex gap-4 pt-4">
                    <button type="submit"
                            class="flex-1 bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-semibold">
                        Simpan
                    </button>

                    <a href="{{ route('gallery.index') }}"
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-lg text-center font-semibold">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- Tips --}}
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-lightbulb text-blue-600"></i>
                </div>
                <div>
                    <h4 class="font-medium text-blue-800 mb-1">Tips untuk deskripsi yang baik:</h4>
                    <ul class="text-sm text-blue-600 space-y-1 list-disc pl-4">
                        <li>Sertakan inspirasi atau makna di balik karya</li>
                        <li>Jelaskan teknik atau media yang digunakan</li>
                        <li>Sebutkan dimensi karya jika ada</li>
                        <li>Tambahkan informasi tentang gaya atau aliran seni</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Success Modal --}}
@if(session('success'))
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display: flex;">
    <div class="bg-white rounded-2xl w-full max-w-md">
        <div class="p-6 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-green-600 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Berhasil!</h3>
            <p class="text-gray-600 mb-6">{{ session('success') }}</p>
            <div class="flex gap-3">
                <a href="{{ route('gallery.create') }}"
                   class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-lg font-semibold transition">
                    Tambah Lagi
                </a>
                <a href="{{ route('gallery.index') }}"
                   class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-lg font-semibold transition">
                    Lihat Galeri
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<script>
// Character counter for short description
document.getElementById('short_description').addEventListener('input', function() {
    const counter = document.getElementById('short_desc_counter');
    counter.textContent = this.value.length;
    if (this.value.length > 500) {
        counter.classList.add('text-red-500');
    } else {
        counter.classList.remove('text-red-500');
    }
});

// Image preview function
function previewFile() {
    const preview = document.getElementById('previewImage');
    const fileInput = document.getElementById('image_path');
    const uploadArea = document.getElementById('uploadArea');
    const imagePreview = document.getElementById('imagePreview');
    const file = fileInput.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            uploadArea.classList.add('hidden');
            imagePreview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(file);
    }
}

// Remove image function
function removeImage() {
    document.getElementById('image_path').value = '';
    document.getElementById('uploadArea').classList.remove('hidden');
    document.getElementById('imagePreview').classList.add('hidden');
}

// Auto-hide success modal after 5 seconds
if (document.getElementById('successModal')) {
    setTimeout(() => {
        document.getElementById('successModal').style.display = 'none';
    }, 5000);
}

// Form submission handling
const form = document.querySelector('form');
if (form) {
    form.addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
        }
    });
}

// Make upload area clickable
document.getElementById('uploadArea').addEventListener('click', function() {
    document.getElementById('image_path').click();
});
</script>

<style>
/* Custom scrollbar */
* {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 #f1f1f1;
}

::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Smooth transitions */
* {
    transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
}

/* Focus styles */
input:focus, textarea:focus, select:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
    box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
}

/* Animation for success modal */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

#successModal > div {
    animation: fadeIn 0.3s ease-out;
}
</style>
</body>
</html>2. 