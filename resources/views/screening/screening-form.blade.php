<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Screening - Le Gareca Space</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fef2f2 0%, #fff7ed 50%, #fef2f2 100%);
        }
        
        .category-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.08), 0 2px 6px rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(254, 202, 202, 0.2);
        }
        
        .pet-card {
            background: #fafafa;
            border-radius: 12px;
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
        
        .select-field {
            background: white;
            border: 2px solid #e5e7eb;
            transition: all 0.2s ease;
            border-radius: 10px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 3rem;
        }
        
        .select-field:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        
        .select-field.error {
            border-color: #ef4444;
            background-color: #fef2f2;
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
        
        .progress-bar {
            height: 6px;
            background: linear-gradient(to right, #ef4444, #f97316);
            border-radius: 3px;
            transition: width 0.5s ease;
        }
        
        .progress-bar-bg {
            background: #fed7d7 !important;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
            20%, 40%, 60%, 80% { transform: translateX(3px); }
        }
        
        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .error-container {
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen px-4 py-8">

<div class="w-full max-w-5xl mx-auto">
    <!-- Paw decoration (optional) -->
    <div class="absolute top-4 right-4 opacity-100 text-2xl">
        <img src="/paw.png" alt="logo" class="w-12 h-12 object-contain">
    </div>

    <!-- Header dengan Progress Bar LANGKAH -->
    <div class="mb-8">
        <!-- Header dengan ikon dan gradient -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r from-red-100 to-orange-100 mb-4">
                <i class="fas fa-paw text-3xl text-red-500"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">Screening Result</h1>
            <div class="flex items-center justify-center space-x-2">
                <div class="h-1 w-12 bg-red-400 rounded-full"></div>
                <h2 class="text-2xl md:text-3xl font-bold text-red-500">Le Gareca Space</h2>
                <div class="h-1 w-12 bg-orange-400 rounded-full"></div>
            </div>
            <p class="text-gray-500 max-w-2xl mx-auto text-sm">
                Diisi oleh <span class="text-red-500 font-semibold">pawrents</span> berdasarkan hasil screening dari staff
            </p>
        </div>
    </div>

    <!-- Global Error Message -->
    <div id="globalError" class="hidden mb-6">
        <div class="flex items-start space-x-3 text-red-600 bg-red-50 border border-red-200 rounded-lg p-4 error-container">
            <i class="fas fa-exclamation-circle text-lg mt-0.5 flex-shrink-0"></i>
            <div class="flex-1">
                <p class="font-semibold">Ada pertanyaan yang belum dijawab!</p>
                <p class="text-gray-700 text-sm mt-1">Silakan lengkapi semua pertanyaan untuk setiap anabul sebelum melanjutkan.</p>
            </div>
        </div>
    </div>

    @php
        $count = session('count', 1);
        $pets  = session('pets', []);
        $count = is_numeric($count) ? (int)$count : 1;
        
        $categories = [
            'vaksin'  => ['label' => 'Status Vaksin'],
            'kutu'    => ['label' => 'Kutu'],
            'jamur'   => ['label' => 'Jamur'],
            'birahi'  => ['label' => 'Birahi'],
            'kulit'   => ['label' => 'Kulit'],
            'telinga' => ['label' => 'Telinga'],
            'riwayat' => ['label' => 'Riwayat Kesehatan']
        ];
    @endphp

    <form id="screeningForm" action="{{ route('screening.submitResult') }}" method="POST" class="space-y-6">
        @csrf

        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-red-500">Step 4 of 5</span>
                <span class="text-sm font-medium text-gray-500">Screening Result</span>
            </div>
            <div class="w-full progress-bar-bg rounded-full h-2">
                <div class="bg-gradient-to-r from-red-500 to-orange-500 h-2 rounded-full w-4/5"></div>
            </div>
        </div>
        
        @foreach($categories as $key => $category)
            <div class="category-card p-5">
                <!-- Category Header -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">{{ $category['label'] }} <span class="text-red-500">*</span></h2>
                </div>

                <!-- Pet Questions -->
                <div class="space-y-3">
                    @for ($i = 0; $i < $count; $i++)
                        @php 
                            $petName = $pets[$i]['name'] ?? 'Anabul ' . ($i+1);
                            $petBreed = $pets[$i]['breed'] ?? '';
                        @endphp

                        <div class="pet-card p-3">
                            <!-- Pet Info -->
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <div class="flex items-center">
                                        <span class="font-semibold text-gray-800">{{ $petName }}</span>
                                        @if($petBreed)
                                            <span class="text-sm text-gray-600 ml-2">({{ $petBreed }})</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Select Input -->
                            <div class="relative">
                                @if($key === 'riwayat')
                                    <select name="pets[{{ $i }}][{{ $key }}]" required
                                        class="select-field w-full px-3 py-2.5 pet-select"
                                        data-pet="{{ $i }}"
                                        data-key="{{ $key }}">
                                        <option value="" disabled selected>Pilih riwayat kesehatan</option>
                                        <option value="Sehat">Sehat</option>
                                        <option value="Pasca terapi">Pasca terapi</option>
                                        <option value="Sedang terapi">Sedang terapi</option>
                                    </select>
                                @elseif($key === 'vaksin')
                                    <select name="pets[{{ $i }}][{{ $key }}]" required
                                        class="select-field w-full px-3 py-2.5 pet-select"
                                        data-pet="{{ $i }}"
                                        data-key="{{ $key }}">
                                        <option value="" disabled selected>Pilih status vaksin</option>
                                        <option value="Belum">Belum</option>
                                        <option value="Belum lengkap">Belum lengkap</option>
                                        <option value="Sudah lengkap">Sudah lengkap</option>
                                    </select>
                                @elseif(in_array($key, ['kutu', 'jamur', 'kulit', 'telinga']))
                                    <select name="pets[{{ $i }}][{{ $key }}]" required
                                        class="select-field w-full px-3 py-2.5 pet-select"
                                        data-pet="{{ $i }}"
                                        data-key="{{ $key }}">
                                        <option value="" disabled selected>Pilih hasil pemeriksaan</option>
                                        <option value="Negatif">(-) Negatif</option>
                                        <option value="Positif">(+) Positif</option>
                                        <option value="Positif 2">(++) Positif 2</option>
                                        <option value="Positif 3">(+++) Positif 3</option>
                                    </select>
                                @elseif($key === 'birahi')
                                    <select name="pets[{{ $i }}][{{ $key }}]" required
                                        class="select-field w-full px-3 py-2.5 pet-select"
                                        data-pet="{{ $i }}"
                                        data-key="{{ $key }}">
                                        <option value="" disabled selected>Pilih status birahi</option>
                                        <option value="Negatif">(-) Negatif</option>
                                        <option value="Positif">(+) Positif</option>
                                    </select>
                                @endif
                            </div>

                            <!-- Error Message -->
                            <div class="error-container hidden mt-2" id="error-{{ $key }}-{{ $i }}">
                                <div class="flex items-center space-x-2 text-red-600 text-sm">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>Field is required</span>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        @endforeach

        <!-- Action Buttons -->
        <div class="pt-6 border-t border-gray-200">
           <div class="flex justify-between items-center gap-3">
    <button
    type="button"
    id="backBtn"
    onclick="window.location.href='/screening/pets'"
    class="submit-btn text-white font-bold text-lg px-12 py-4 rounded-full shadow-md transition flex items-center w-full sm:w-auto disabled:opacity-50 disabled:cursor-not-allowed">
    <i class="fas fa-arrow-left mr-2"></i>
    Back
</button>

<button
    type="button"
    id="submitBtn"
    class="submit-btn text-white font-bold text-lg px-12 py-4 rounded-full shadow-md transition flex items-center w-full sm:w-auto disabled:opacity-50 disabled:cursor-not-allowed">
    Next
    <i class="fas fa-arrow-right ml-2"></i>
</button>

            </div>
        </div>
    </form>
    
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
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('screeningForm');
    const submitBtn = document.getElementById('submitBtn');
    const globalError = document.getElementById('globalError');
    const selects = document.querySelectorAll('.pet-select');

    function resetErrors() {
        globalError.classList.add('hidden');
        document.querySelectorAll('.error-container').forEach(el => el.classList.add('hidden'));
        selects.forEach(sel => {
            sel.classList.remove('error', 'border-green-500');
        });
    }

    function validateForm() {
        let firstInvalid = null;

        selects.forEach(select => {
            const pet = select.dataset.pet;
            const key = select.dataset.key;
            const errorEl = document.getElementById(`error-${key}-${pet}`);

            if (!select.value) {
                if (!firstInvalid) firstInvalid = select;
                select.classList.add('error');
                errorEl?.classList.remove('hidden');
            } else {
                select.classList.remove('error');
                select.classList.add('border-green-500');
                errorEl?.classList.add('hidden');
            }
        });

        if (firstInvalid) {
            globalError.classList.remove('hidden');
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalid.closest('.pet-card')?.classList.add('animate-shake');
            setTimeout(() => {
                firstInvalid.closest('.pet-card')?.classList.remove('animate-shake');
            }, 400);
            return false;
        }

        return true;
    }

    // realtime validation
    selects.forEach(select => {
        select.addEventListener('change', () => {
            validateForm();
        });
    });

    // tombol NEXT
    submitBtn.addEventListener('click', () => {
        resetErrors();

        if (!validateForm()) {
            submitBtn.classList.add('animate-shake');
            setTimeout(() => submitBtn.classList.remove('animate-shake'), 400);
            return;
        }

        // loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <span class="loading-spinner mr-2"></span>
            Memproses...
        `;

        form.submit();
    });
});
</script>

</body>
</html>