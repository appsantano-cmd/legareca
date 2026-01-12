<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anabul — Le Gareca Space</title>

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
            box-shadow: 0 10px 40px rgba(239, 68, 68, 0.08),
                0 4px 12px rgba(239, 68, 68, 0.05);
        }

        .input-field {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px;
            font-size: 16px;
            width: 100%;
        }

        .input-field:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
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

        .loading-spinner {
            width: 18px;
            height: 18px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-6px);
            }

            50% {
                transform: translateX(6px);
            }

            75% {
                transform: translateX(-6px);
            }
        }

        .animate-shake {
            animation: shake 0.4s ease;
        }
    </style>
</head>

<body class="px-4 py-6">
    <div class="w-full max-w-3xl mx-auto">

        <!-- Paw Decoration -->
        <div class="absolute top-4 right-4 opacity-100 text-2xl">
            <img src="/paw.png" alt="logo" class="w-12 h-12 object-contain">
        </div>

        <!-- Header -->
        <div class="text-center mb-10">
            <div
                class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r from-red-100 to-orange-100 mb-4">
                <i class="fas fa-paw text-3xl text-red-500"></i>
            </div>

            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">
                Data Anabul
            </h1>

            <div class="flex items-center justify-center space-x-2">
                <div class="h-1 w-12 bg-red-400 rounded-full"></div>
                <h2 class="text-2xl md:text-3xl font-bold text-red-500">
                    Le Gareca Space
                </h2>
                <div class="h-1 w-12 bg-orange-400 rounded-full"></div>
            </div>
        </div>

        <!-- Progress -->
        <div class="mb-6">
            <div class="flex justify-between text-sm mb-2">
                <span class="text-red-500 font-medium">Step 3 of 5</span>
                <span class="text-gray-500">Data Anabul</span>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-red-500 to-orange-500 h-2 rounded-full w-3/5"></div>
            </div>
        </div>

        <!-- Form -->
        <form id="petForm" action="{{ route('screening.submitPets') }}" method="POST">
            @csrf

            <div class="space-y-6">
                @for ($i = 0; $i < $count; $i++)
                    <div class="form-card p-5 border border-gray-100">
                        <div class="flex items-center gap-2 mb-4">
                            <span
                                class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-red-500 text-white text-sm font-bold">
                                {{ $i + 1 }}
                            </span>
                            <span class="font-bold text-gray-800">Anabul</span>
                        </div>

                        <div class="space-y-4">
                            <!-- Nama -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1 text-sm">Nama Pet *</label>
                                <input type="text" name="pets[{{ $i }}][name]" class="input-field pet-name-input" required
                                    value="{{ old("pets.$i.name") }}">
                                <p class="text-red-500 text-xs hidden mt-1" id="name-error-{{ $i }}">Nama wajib diisi</p>
                            </div>

                            <!-- Breed -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1 text-sm">Breed *</label>
                                <input type="text" name="pets[{{ $i }}][breed]" class="input-field pet-breed-input" required
                                    value="{{ old("pets.$i.breed") }}">
                                <p class="text-red-500 text-xs hidden mt-1" id="breed-error-{{ $i }}">Breed wajib diisi</p>
                            </div>

                            <!-- Sex -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1 text-sm">Jenis Kelamin *</label>
                                <select name="pets[{{ $i }}][sex]" class="input-field pet-sex-select" required>
                                    <option value="" disabled selected>Pilih jenis kelamin</option>
                                    <option value="Jantan" {{ old("pets.$i.sex") == 'Jantan' ? 'selected' : '' }}>Jantan
                                    </option>
                                    <option value="Betina" {{ old("pets.$i.sex") == 'Betina' ? 'selected' : '' }}>Betina
                                    </option>
                                </select>
                                <p class="text-red-500 text-xs hidden mt-1" id="sex-error-{{ $i }}">Pilih jenis kelamin</p>
                            </div>

                            <!-- Usia -->
                            <div>
                                <label class="block font-bold text-gray-700 mb-1 text-sm">Usia *</label>

                                <div class="grid grid-cols-2 gap-3">
                                    <select name="pets[{{ $i }}][age_year]" class="input-field pet-age-year">
                                        @for ($y = 0; $y <= 30; $y++)
                                            <option value="{{ $y }}" {{ old("pets.$i.age_year", 0) == $y ? 'selected' : '' }}>
                                                {{ $y }} Tahun
                                            </option>
                                        @endfor
                                    </select>

                                    <select name="pets[{{ $i }}][age_month]" class="input-field pet-age-month">
                                        @for ($m = 0; $m <= 11; $m++)
                                            <option value="{{ $m }}" {{ old("pets.$i.age_month", 0) == $m ? 'selected' : '' }}>
                                                {{ $m }} Bulan
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <p class="text-red-500 text-xs hidden mt-1" id="age-error-{{ $i }}">
                                    Usia wajib diisi
                                </p>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Buttons -->
            <div class="pt-8 border-t border-gray-200 mt-10">
                <div class="flex justify-between items-center gap-3">
                    <button type="button" onclick="window.location.href='/screening/owner'" class="submit-btn
                            text-sm md:text-lg
                            px-5 py-2 md:px-8 md:py-4
                            w-full md:w-auto
                            flex items-center justify-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </button>

                    <button type="submit" id="nextBtn" class="submit-btn
                            text-sm md:text-lg
                            px-5 py-2 md:px-8 md:py-4
                            w-full md:w-auto
                            flex items-center justify-center">
                        Next <i class="fas fa-arrow-right ml-2"></i>
                    </button>

                </div>
            </div>
        </form>

        <!-- Footer -->
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
        document.getElementById('petForm').addEventListener('submit', function (e) {
            const rows = document.querySelectorAll('.form-card');
            let valid = true;
            const submitBtn = document.getElementById('nextBtn');

            rows.forEach((_, i) => {
                ['name', 'breed', 'sex', 'age'].forEach(type => {
                    document.getElementById(`${type}-error-${i}`).classList.add('hidden');
                });
            });

            rows.forEach((card, i) => {
                const name = card.querySelector('.pet-name-input');
                const breed = card.querySelector('.pet-breed-input');
                const sex = card.querySelector('.pet-sex-select');
                const year = card.querySelector('.pet-age-year');
                const month = card.querySelector('.pet-age-month');

                if (!name.value.trim()) {
                    document.getElementById(`name-error-${i}`).classList.remove('hidden');
                    valid = false;
                }
                if (!breed.value.trim()) {
                    document.getElementById(`breed-error-${i}`).classList.remove('hidden');
                    valid = false;
                }
                if (!sex.value) {
                    document.getElementById(`sex-error-${i}`).classList.remove('hidden');
                    valid = false;
                }
                if (+year.value === 0 && +month.value === 0) {
                    document.getElementById(`age-error-${i}`).classList.remove('hidden');
                    valid = false;
                }
            });

            if (!valid) {
                e.preventDefault();
                submitBtn.classList.add('animate-shake');
                setTimeout(() => submitBtn.classList.remove('animate-shake'), 400);
            }
        });
    </script>
</body>

</html>