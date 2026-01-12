<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Anabul - Le Gareca Space</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fef2f2 0%, #fff7ed 50%, #fef2f2 100%);
        }

        .title-font {
            font-family: 'Nunito', sans-serif;
        }

        .form-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(239, 68, 68, 0.08), 0 4px 12px rgba(239, 68, 68, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(239, 68, 68, 0.12), 0 8px 20px rgba(239, 68, 68, 0.08);
        }

        .input-field {
            background: linear-gradient(to right, #fafafa, #f5f5f5);
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            background: white;
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .input-field:hover {
            border-color: #f97316;
        }

        .error-message {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .paw-decoration {
            background: linear-gradient(45deg, #fecaca, #fed7aa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .progress-bar {
            height: 6px;
            background: linear-gradient(to right, #ef4444, #f97316);
            border-radius: 3px;
            transition: width 0.5s ease;
        }

        .submit-btn {
            background: linear-gradient(to right, #ef4444, #f97316);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .submit-btn:hover {
            background: linear-gradient(to right, #dc2626, #ea580c);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .counter-control {
            background: #f3f4f6 !important;
            border: 2px solid #e5e7eb !important;
            transition: all 0.2s ease !important;
            cursor: pointer !important;
            color: #374151 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .counter-control:hover {
            background: #ef4444 !important;
            color: white !important;
            border-color: #ef4444 !important;
        }

        .counter-control:disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            background: #e5e7eb !important;
            border-color: #d1d5db !important;
            color: #9ca3af !important;
        }

        .counter-control:disabled:hover {
            background: #e5e7eb !important;
            border-color: #d1d5db !important;
            color: #9ca3af !important;
        }

        .paw-print {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(5deg);
            }
        }

        .paw-print:nth-child(2) {
            animation-delay: 0.5s;
        }

        .paw-print:nth-child(3) {
            animation-delay: 1s;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-5 py-10">

    <div class="w-full max-w-3xl">
        <!-- Paw decoration (optional) -->
        <div class="absolute top-4 right-4 opacity-100 text-2xl">
            <img src="/paw.png" alt="logo" class="w-12 h-12 object-contain">
        </div>

        <!-- Header dengan Progress Bar -->
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">Pawrents Data</h1>
            <div class="flex items-center justify-center space-x-2">
                <div class="h-1 w-12 bg-red-400 rounded-full"></div>
                <h2 class="text-2xl md:text-3xl font-bold text-red-500">Le Gareca Space</h2>
                <div class="h-1 w-12 bg-orange-400 rounded-full"></div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="form-card p-6 md:p-10">
            <div class="mb-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-red-500">Step 2 of 5</span>
                    <span class="text-sm font-medium text-gray-500">Pawrents Data</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-red-500 to-orange-500 h-2 rounded-full w-2/5"></div>
                </div>
            </div>

            <form action="{{ route('screening.submitOwner') }}" method="POST" id="ownerForm" class="space-y-10">
                @csrf

                <!-- Bagian Nama Pemilik -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
                            <i class="fas fa-user-tag text-red-500"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            Siapa nama kamu? <span class="text-red-500">*</span>
                        </h2>
                    </div>

                    <p class="text-gray-600 mb-6 ml-13">
                        Masukkan nama lengkap kamu sebagai pemilik anabul
                    </p>

                    <div class="relative max-w-md mx-auto">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-user"></i>
                        </div>
                        <input type="text" id="ownerName" name="owner" placeholder="e.g John Doe"
                            class="input-field w-full pl-12 pr-6 py-4 rounded-full shadow-sm text-gray-700 focus:outline-none">
                    </div>

                    <!-- Pesan Error untuk Nama Pemilik -->
                    <div id="ownerError" class="hidden mt-4 max-w-md mx-auto error-message">
                        <div class="flex items-center space-x-2 text-red-600 text-sm">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Field is required</span>
                        </div>
                    </div>
                </div>

                <!-- Bagian Jumlah Anabul -->
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center mr-3">
                            <i class="fas fa-paw text-orange-500"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            Ada berapa anabul? <span class="text-red-500">*</span>
                        </h2>
                    </div>

                    <p class="text-gray-600 mb-6 ml-13">
                        Jumlah hewan peliharaan yang dibawa ke Le Gareca Space
                    </p>

                    <div class="max-w-md mx-auto">
                        <!-- Counter Input dengan Controls -->
                        <div class="flex items-center justify-center space-x-4">
                            <button type="button" id="decreaseBtn"
                                class="counter-control w-12 h-12 rounded-full flex items-center justify-center text-2xl font-bold"
                                disabled>
                                <i class="fas fa-minus"></i>
                            </button>

                            <div class="relative">
                                <!-- Input Phone -->
                                <input type="text" id="petCount" name="count" value="1"
                                    class="input-field w-32 px-4 py-4 rounded-full shadow-sm text-gray-700 text-center text-2xl font-bold focus:outline-none"
                                    inputmode="numeric" pattern="[0-9]*">
                            </div>

                            <button type="button" id="increaseBtn"
                                class="counter-control w-12 h-12 rounded-full flex items-center justify-center text-2xl font-bold">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div class="flex justify-between mt-3 text-sm text-gray-500 max-w-xs mx-auto">
                            <span><i class="fas fa-info-circle mr-1"></i> Min 1</span>
                            <span>Max 10 <i class="fas fa-info-circle ml-1"></i></span>
                        </div>
                    </div>

                    <!-- Pesan Error untuk Jumlah Anabul -->
                    <div id="countError" class="hidden mt-4 max-w-md mx-auto error-message">
                        <div
                            class="flex items-start space-x-3 text-red-600 bg-red-50 border border-red-200 rounded-xl p-4">
                            <i class="fas fa-exclamation-circle text-xl mt-0.5"></i>
                            <div class="text-left">
                                <p class="font-semibold">Jumlah anabul tidak valid</p>
                                <p class="text-sm mt-1">Silakan masukkan jumlah antara 1 sampai 10</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="flex justify-between items-center gap-3">
                        <button type="button" onclick="window.location.href='/screening/yakin'" class="submit-btn text-white font-semibold
                                text-sm md:text-lg
                                px-5 py-2 md:px-12 md:py-4
                                rounded-full shadow-md transition
                                flex items-center justify-center w-full md:w-auto">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back
                        </button>

                        <div class="text-center sm:text-right">
                            <button type="submit" id="nextBtn" class="submit-btn text-white font-semibold
                                    text-sm md:text-lg
                                    px-5 py-2 md:px-12 md:py-4
                                    rounded-full shadow-md transition
                                    flex items-center justify-center w-full md:w-auto">
                                Next <i class="fas fa-arrow-right ml-2"></i>
                            </button>

                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer note -->
        <div class="text-center mt-8 text-gray-500 text-sm">
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
            const ownerInput = document.getElementById('ownerName');
            const countInput = document.getElementById('petCount');
            const decreaseBtn = document.getElementById('decreaseBtn');
            const increaseBtn = document.getElementById('increaseBtn');
            const ownerError = document.getElementById('ownerError');
            const countError = document.getElementById('countError');
            const form = document.getElementById('ownerForm');
            const submitBtn = document.getElementById('nextBtn');

            // Fungsi untuk update tombol counter
            function updateCounterButtons(value) {
                // Update tombol decrease
                if (value <= 1) {
                    decreaseBtn.disabled = true;
                } else {
                    decreaseBtn.disabled = false;
                }

                // Update tombol increase
                if (value >= 10) {
                    increaseBtn.disabled = true;
                } else {
                    increaseBtn.disabled = false;
                }
            }

            // Counter controls
            decreaseBtn.addEventListener('click', function () {
                let value = parseInt(countInput.value) || 0;
                if (value > 1) {
                    countInput.value = value - 1;
                    updateCounterButtons(value - 1);
                    countError.classList.add('hidden');
                }
            });

            increaseBtn.addEventListener('click', function () {
                let value = parseInt(countInput.value) || 0;
                if (value < 10) {
                    countInput.value = value + 1;
                    updateCounterButtons(value + 1);
                    countError.classList.add('hidden');
                }
            });

            // Real-time validation for pet count
            countInput.addEventListener('input', function () {
                // Hanya izinkan angka
                this.value = this.value.replace(/[^0-9]/g, '');

                let value = parseInt(this.value) || 0;
                if (value < 1) value = 1;
                if (value > 10) value = 10;
                this.value = value;
                updateCounterButtons(value);

                if (value >= 1 && value <= 10) {
                    countError.classList.add('hidden');
                }
            });

            // Pastikan hanya angka saat paste
            countInput.addEventListener('paste', function (e) {
                e.preventDefault();
                const pastedText = e.clipboardData.getData('text');
                const numbersOnly = pastedText.replace(/[^0-9]/g, '');

                // Gabungkan dengan nilai saat ini
                let currentValue = this.value.replace(/[^0-9]/g, '');
                let newValue = currentValue + numbersOnly;

                // Batasi maksimal 2 digit
                newValue = newValue.slice(0, 2);

                let value = parseInt(newValue) || 0;
                if (value < 1) value = 1;
                if (value > 10) value = 10;

                this.value = value;
                updateCounterButtons(value);
            });

            // Real-time validation for owner name
            ownerInput.addEventListener('input', function () {
                if (this.value.trim() !== '') {
                    ownerError.classList.add('hidden');
                }
            });

            // Focus effect for inputs
            [ownerInput, countInput].forEach(input => {
                input.addEventListener('focus', function () {
                    this.parentElement.classList.add('ring-2', 'ring-red-200', 'rounded-full');
                });

                input.addEventListener('blur', function () {
                    this.parentElement.classList.remove('ring-2', 'ring-red-200', 'rounded-full');

                    // Untuk count input, pastikan nilai valid saat blur
                    if (input === countInput) {
                        let value = parseInt(this.value) || 0;
                        if (value < 1) {
                            this.value = 1;
                            updateCounterButtons(1);
                        }
                        if (value > 10) {
                            this.value = 10;
                            updateCounterButtons(10);
                        }
                    }
                });
            });

            // Initialize counter buttons
            updateCounterButtons(parseInt(countInput.value) || 1);

            // Form submission
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                let valid = true;

                // Reset errors
                ownerError.classList.add('hidden');
                countError.classList.add('hidden');

                // Validate owner name
                if (ownerInput.value.trim() === '') {
                    ownerError.classList.remove('hidden');
                    ownerInput.focus();
                    valid = false;
                }

                // Validate pet count
                const count = parseInt(countInput.value) || 0;
                if (isNaN(count) || count < 1 || count > 10) {
                    countError.classList.remove('hidden');
                    if (valid) countInput.focus();
                    valid = false;
                }

                if (valid) {
                    // Add loading state to button
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
                    submitBtn.disabled = true;

                    // Simulate processing
                    setTimeout(() => {
                        e.target.submit();
                    }, 1000);
                }
            });

            // Add animation to form card on load
            const formCard = document.querySelector('.form-card');
            formCard.style.opacity = '0';
            formCard.style.transform = 'translateY(20px)';

            setTimeout(() => {
                formCard.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                formCard.style.opacity = '1';
                formCard.style.transform = 'translateY(0)';
            }, 300);
        });
    </script>

</body>

</html>