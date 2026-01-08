<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pawrents</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fef2f2 0%, #fff7ed 50%, #fef2f2 100%);
        }

        .submit-btn {
            background: linear-gradient(to right, #ef4444, #f97316);
            color: white;
            font-weight: 700;
            padding: 14px 32px;
            border-radius: 999px;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .submit-btn:hover {
            background: linear-gradient(to right, #dc2626, #ea580c);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .submit-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .submit-btn:disabled:hover {
            transform: none;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4 py-8">

    <div class="w-full max-w-md text-center">
        <!-- Paw decoration (optional) -->
        <div class="absolute top-4 right-4 opacity-100 text-2xl">
            <img src="/paw.png" alt="logo" class="w-12 h-12 object-contain">
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8">
            <!-- Text -->
            <h2 class="text-xl font-bold text-gray-800 mb-6">
                Yakin sudah membaca<br>
                <span class="text-gray-900">Kesepakatan Pawrents di Le Gareca Space?</span>
            </h2>

            <!-- Radio Options -->
            <div class="flex flex-col gap-4 items-center mb-8">
                <label class="flex items-center w-full max-w-xs cursor-pointer">
                    <input type="radio" name="yakin" value="1" class="mr-4 scale-125 text-red-400 radio-option">
                    <div
                        class="w-full py-4 px-6 rounded-full bg-red-50 border-2 border-red-300 shadow-sm text-red-600 font-semibold hover:bg-red-100 transition">
                        Yakin
                    </div>
                </label>

                <label class="flex items-center w-full max-w-xs cursor-pointer">
                    <input type="radio" name="yakin" value="0" class="mr-4 scale-125 text-red-400 radio-option">
                    <div
                        class="w-full py-4 px-6 rounded-full bg-red-50 border-2 border-red-300 shadow-sm text-red-600 font-semibold hover:bg-red-100 transition">
                        Tidak Yakin
                    </div>
                </label>
            </div>

            <!-- Image -->
            <div class="flex justify-center mb-8">
                <img src="{{ asset('yakin.png') }}" alt="Yakin?" class="w-48 h-48 object-contain">
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="hidden mb-6">
                <div
                    class="flex items-center justify-center space-x-2 text-red-600 bg-red-50 border border-red-200 rounded-lg p-3">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Silakan pilih opsi terlebih dahulu</span>
                </div>
            </div>

            <!-- Next Button -->
            <button id="nextButton" onclick="window.location.href='/screening/owner'" disabled
                class="submit-btn text-white font-bold text-lg px-12 py-4 rounded-full shadow-md transition flex items-center justify-center w-full">
                <span>Next</span>
                <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </div>

        <!-- Footer note -->
        <div class="text-center text-gray-500 text-sm">
            <p>Le Gareca Space — Tempat berkumpulnya para pecinta hewan peliharaan</p>
            <div class="flex justify-center space-x-6 mt-4 text-gray-400">
                <i class="fas fa-dog"></i>
                <i class="fas fa-cat"></i>
                <i class="fas fa-heart"></i>
                <i class="fas fa-coffee"></i>
                <i class="fas fa-utensils"></i>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const radioOptions = document.querySelectorAll('.radio-option');
            const nextButton = document.getElementById('nextButton');
            const errorMessage = document.getElementById('errorMessage');

            // Tambahkan event listener untuk setiap radio button
            radioOptions.forEach(radio => {
                radio.addEventListener('change', function () {
                    // Sembunyikan pesan error
                    errorMessage.classList.add('hidden');

                    // Aktifkan tombol jika ada yang dipilih
                    if (this.checked) {
                        nextButton.disabled = false;
                    }
                });
            });

            // Validasi saat tombol diklik
            nextButton.addEventListener('click', function (e) {
                // Cek apakah ada radio button yang terpilih
                const selectedRadio = document.querySelector('input[name="yakin"]:checked');

                if (!selectedRadio) {
                    e.preventDefault(); // Mencegah navigasi
                    errorMessage.classList.remove('hidden');

                    // Animasi shake pada tombol
                    nextButton.classList.add('animate-shake');
                    setTimeout(() => {
                        nextButton.classList.remove('animate-shake');
                    }, 400);
                    return false;
                }

                // Jika memilih "Tidak Yakin", tampilkan konfirmasi
                if (selectedRadio.value === '0') {
                    e.preventDefault(); // Mencegah navigasi langsung
                    if (confirm('Apakah Anda yakin tidak ingin melanjutkan? Anda perlu membaca kesepakatan terlebih dahulu.')) {
                        // Jika user konfirmasi, redirect ke halaman sebelumnya atau home
                        window.location.href = '/screening/agreement';
                    }
                    return false;
                }

                // Jika memilih "Yakin", lanjutkan ke /screening/owner
                return true;
            });
        });
    </script>

</body>

</html>