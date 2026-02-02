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
        
        .radio-group {
            display: flex;
            gap: 12px;
            margin-top: 12px;
        }
        
        .radio-option {
            flex: 1;
            position: relative;
        }
        
        .radio-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .radio-label {
            display: block;
            padding: 10px 16px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .radio-input:checked + .radio-label {
            background: #fef2f2;
            border-color: #ef4444;
            color: #ef4444;
            font-weight: 600;
        }
        
        .conditional-section {
            animation: slideDown 0.3s ease-out;
            overflow: hidden;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
                max-height: 0;
            }
            to {
                opacity: 1;
                transform: translateY(0);
                max-height: 200px;
            }
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
        
        .progress-bar {
            height: 6px;
            background: linear-gradient(to right, #ef4444, #f97316);
            border-radius: 3px;
            transition: width 0.5s ease;
        }
        
        .progress-bar-bg {
            background: #fed7d7 !important;
        }
        
        .hidden {
            display: none;
        }
        
        .cancelled-redirect-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .redirect-message {
            text-align: center;
            padding: 40px;
            max-width: 500px;
            width: 90%;
        }
        
        .redirect-spinner {
            width: 60px;
            height: 60px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #ef4444;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="min-h-screen px-4 py-8">

<div class="w-full max-w-5xl mx-auto">
    <!-- Paw decoration -->
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
                                        data-key="{{ $key }}"
                                        data-required="true">
                                        <option value="" disabled selected>Pilih riwayat kesehatan</option>
                                        <option value="Sehat">Sehat</option>
                                        <option value="Pasca terapi">Pasca terapi</option>
                                        <option value="Sedang terapi">Sedang terapi</option>
                                    </select>
                                @elseif($key === 'vaksin')
                                    <select name="pets[{{ $i }}][{{ $key }}]" required
                                        class="select-field w-full px-3 py-2.5 pet-select"
                                        data-pet="{{ $i }}"
                                        data-key="{{ $key }}"
                                        data-required="true">
                                        <option value="" disabled selected>Pilih status vaksin</option>
                                        <option value="Belum">Belum</option>
                                        <option value="Belum lengkap">Belum lengkap</option>
                                        <option value="Sudah lengkap">Sudah lengkap</option>
                                    </select>
                                @elseif(in_array($key, ['kutu', 'jamur', 'kulit', 'telinga']))
                                    <select name="pets[{{ $i }}][{{ $key }}]" required
                                        class="select-field w-full px-3 py-2.5 pet-select conditional-select"
                                        data-pet="{{ $i }}"
                                        data-key="{{ $key }}"
                                        data-category="{{ $key }}"
                                        data-required="true">
                                        <option value="" disabled selected>Pilih hasil pemeriksaan</option>
                                        <option value="Negatif">(-) Negatif</option>
                                        <option value="Positif">(+) Positif</option>
                                        <option value="Positif 2">(++) Positif 2</option>
                                        <option value="Positif 3">(+++) Positif 3</option>
                                    </select>
                                @elseif($key === 'birahi')
                                    <select name="pets[{{ $i }}][{{ $key }}]" required
                                        class="select-field w-full px-3 py-2.5 pet-select birahi-select"
                                        data-pet="{{ $i }}"
                                        data-key="{{ $key }}"
                                        data-category="{{ $key }}"
                                        data-required="true">
                                        <option value="" disabled selected>Pilih status birahi</option>
                                        <option value="Negatif">(-) Negatif</option>
                                        <option value="Positif">(+) Positif</option>
                                    </select>
                                @endif
                            </div>

                            <!-- Conditional Section for Kutu ONLY when Positif -->
                            @if($key === 'kutu')
                                <div id="conditional-section-kutu-{{ $i }}" class="conditional-section hidden mt-3">
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                        <p class="text-sm font-medium text-yellow-800 mb-2">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Hasil pemeriksaan menunjukkan positif. Apa yang ingin dilakukan?
                                        </p>
                                        
                                        <div class="radio-group">
                                            <div class="radio-option">
                                                <input type="radio" 
                                                       id="action-kutu-{{ $i }}-cancel" 
                                                       name="pets[{{ $i }}][kutu_action]"
                                                       value="tidak_periksa"
                                                       class="radio-input conditional-action"
                                                       data-pet="{{ $i }}"
                                                       data-key="kutu"
                                                       data-cancelled-url="{{ route('screening.cancelled') }}">
                                                <label for="action-kutu-{{ $i }}-cancel" class="radio-label">
                                                    Tidak Jadi Periksa
                                                </label>
                                            </div>
                                            <div class="radio-option">
                                                <input type="radio" 
                                                       id="action-kutu-{{ $i }}-continue" 
                                                       name="pets[{{ $i }}][kutu_action]"
                                                       value="lanjut_obat"
                                                       class="radio-input conditional-action"
                                                       data-pet="{{ $i }}"
                                                       data-key="kutu">
                                                <label for="action-kutu-{{ $i }}-continue" class="radio-label">
                                                    Lanjut Periksa (Pakai Obat)
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <!-- Hidden input to track if condition is active -->
                                        <input type="hidden" 
                                               id="conditional-active-kutu-{{ $i }}"
                                               name="pets[{{ $i }}][kutu_conditional]" 
                                               value="0">
                                    </div>
                                </div>
                            @endif

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

        <!-- Hidden input untuk tracking -->
        <input type="hidden" name="submission_type" id="submissionType" value="normal">

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

<!-- Redirect Overlay -->
<div id="redirectOverlay" class="cancelled-redirect-overlay hidden">
    <div class="redirect-message">
        <div class="redirect-spinner"></div>
        <h3 class="text-xl font-bold text-gray-800 mb-3">Mengarahkan ke halaman pembatalan...</h3>
        <p class="text-gray-600 mb-4">Ada hasil pemeriksaan yang mengharuskan pembatalan. Data sedang disimpan...</p>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
            <p class="text-sm text-yellow-800">
                <i class="fas fa-info-circle mr-2"></i>
                Anda akan dialihkan dalam <span id="countdown">3</span> detik
            </p>
        </div>
        <button 
            id="manualRedirectBtn" 
            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-full transition duration-300">
            <i class="fas fa-external-link-alt mr-2"></i> Klik di sini jika tidak otomatis redirect
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('screeningForm');
    const submitBtn = document.getElementById('submitBtn');
    const redirectOverlay = document.getElementById('redirectOverlay');
    const countdownElement = document.getElementById('countdown');
    const manualRedirectBtn = document.getElementById('manualRedirectBtn');
    const kutuSelects = document.querySelectorAll('select[data-key="kutu"]');
    const birahiSelects = document.querySelectorAll('.birahi-select');
    
    let countdownTimer = null;
    let cancelledUrl = '';
    let isCancelled = false;
    let forceRedirect = false;

    // Handle kutu select changes
    kutuSelects.forEach(select => {
        select.addEventListener('change', (e) => {
            const pet = e.target.dataset.pet;
            const value = e.target.value;
            const conditionalSection = document.getElementById(`conditional-section-kutu-${pet}`);
            const conditionalActive = document.getElementById(`conditional-active-kutu-${pet}`);
            
            // Reset semua kondisi
            if (conditionalSection) {
                conditionalSection.classList.add('hidden');
                conditionalActive.value = '0';
                
                const actionInputs = conditionalSection.querySelectorAll('.conditional-action');
                actionInputs.forEach(input => {
                    input.checked = false;
                });
            }
            
            // Jika Positif, tampilkan pilihan
            if (value === 'Positif') {
                if (conditionalSection) {
                    conditionalSection.classList.remove('hidden');
                    conditionalActive.value = '1';
                    forceRedirect = false;
                }
            }
            // Jika Positif 2 atau Positif 3, langsung force redirect
            else if (value === 'Positif 2' || value === 'Positif 3') {
                forceRedirect = true;
                isCancelled = true;
                cancelledUrl = '{{ route("screening.cancelled") }}';
                prepareFormForCancelledSubmission();
                showRedirectOverlay();
                startCountdown();
            }
            // Jika Negatif, sembunyikan dan reset
            else {
                if (conditionalSection) {
                    conditionalSection.classList.add('hidden');
                    conditionalActive.value = '0';
                }
                forceRedirect = false;
            }
        });
    });

    // Handle birahi select changes - langsung redirect jika Positif
    birahiSelects.forEach(select => {
        select.addEventListener('change', (e) => {
            const value = e.target.value;
            
            if (value === 'Positif') {
                forceRedirect = true;
                isCancelled = true;
                cancelledUrl = '{{ route("screening.cancelled") }}';
                prepareFormForCancelledSubmission();
                showRedirectOverlay();
                startCountdown();
            }
        });
    });

    // Handle conditional action untuk kutu positif
    const conditionalActions = document.querySelectorAll('.conditional-action');
    conditionalActions.forEach(action => {
        action.addEventListener('change', (e) => {
            const value = e.target.value;
            const url = e.target.dataset.cancelledUrl;
            
            if (value === 'tidak_periksa') {
                isCancelled = true;
                cancelledUrl = url;
                forceRedirect = false;
                
                prepareFormForCancelledSubmission();
                showRedirectOverlay();
                startCountdown();
            } else {
                isCancelled = false;
            }
        });
    });

    // Fungsi untuk mengisi field yang kosong dengan "-" saat cancelled
    function prepareFormForCancelledSubmission() {
        console.log('Preparing form for cancelled submission...');
        
        const categories = ['vaksin', 'kutu', 'jamur', 'birahi', 'kulit', 'telinga', 'riwayat'];
        const count = {{ $count }};
        
        for (let i = 0; i < count; i++) {
            categories.forEach(category => {
                const selectName = `pets[${i}][${category}]`;
                const selectElement = document.querySelector(`select[name="${selectName}"]`);
                
                if (selectElement) {
                    // Jika belum ada value, tambahkan opsi "-" dan set value
                    if (!selectElement.value) {
                        // Cek apakah opsi "-" sudah ada
                        let hasDashOption = false;
                        for (let opt of selectElement.options) {
                            if (opt.value === '-') {
                                hasDashOption = true;
                                break;
                            }
                        }
                        
                        // Jika belum ada, tambahkan
                        if (!hasDashOption) {
                            const option = document.createElement('option');
                            option.value = '-';
                            option.textContent = '-';
                            selectElement.appendChild(option);
                        }
                        
                        // Set value ke "-"
                        selectElement.value = '-';
                        console.log(`Set ${selectName} to "-"`);
                    }
                }
            });
        }
    }

    // Fungsi untuk menampilkan overlay redirect
    function showRedirectOverlay() {
        redirectOverlay.classList.remove('hidden');
    }

    // Fungsi untuk memulai countdown
    function startCountdown() {
        let seconds = 3;
        countdownElement.textContent = seconds;
        
        countdownTimer = setInterval(() => {
            seconds--;
            countdownElement.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(countdownTimer);
                submitFormForCancellation();
            }
        }, 1000);
    }

    // Fungsi untuk submit form untuk pembatalan
    function submitFormForCancellation() {
        console.log('Submitting form for cancellation...');
        
        // Pastikan semua field sudah diisi dengan "-"
        prepareFormForCancelledSubmission();
        
        // Debug: Lihat data form sebelum submit
        const formData = new FormData(form);
        console.log('Form data before submission:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }
        
        // Create and add force_cancelled hidden input
        let forceCancelledInput = document.querySelector('input[name="force_cancelled"]');
        if (!forceCancelledInput) {
            forceCancelledInput = document.createElement('input');
            forceCancelledInput.type = 'hidden';
            forceCancelledInput.name = 'force_cancelled';
            forceCancelledInput.value = 'true';
            form.appendChild(forceCancelledInput);
        } else {
            forceCancelledInput.value = 'true';
        }
        
        // Submit the form immediately
        console.log('Form submitted with cancelled flag');
        form.submit();
    }

    // Tombol redirect manual
    manualRedirectBtn.addEventListener('click', () => {
        clearInterval(countdownTimer);
        prepareFormForCancelledSubmission();
        submitFormForCancellation();
    });

    // Tombol NEXT untuk normal flow
    submitBtn.addEventListener('click', () => {
        console.log('Next button clicked, isCancelled:', isCancelled);
        
        // Cek apakah ada yang memilih "Tidak Jadi Periksa"
        const cancelledInputs = document.querySelectorAll('.conditional-action[value="tidak_periksa"]:checked');
        
        if (cancelledInputs.length > 0) {
            console.log('Cancelled inputs found:', cancelledInputs.length);
            // Jika ada yang dibatalkan, tampilkan overlay
            const url = cancelledInputs[0].dataset.cancelledUrl;
            cancelledUrl = url;
            isCancelled = true;
            forceRedirect = false;
            
            // Isi field kosong dengan "-"
            prepareFormForCancelledSubmission();
            
            showRedirectOverlay();
            startCountdown();
        } else {
            console.log('No cancelled inputs, validating normal form...');
            
            // Cek jika ada kutu positif 2/3 atau birahi positif yang belum terhandle
            let hasAutoCancel = false;
            
            // Cek kutu positif 2/3
            const kutuSelects = document.querySelectorAll('select[data-key="kutu"]');
            kutuSelects.forEach(select => {
                if (['Positif 2', 'Positif 3'].includes(select.value)) {
                    hasAutoCancel = true;
                    console.log('Found kutu positif 2/3 that needs auto cancel');
                }
            });
            
            // Cek birahi positif
            const birahiSelects = document.querySelectorAll('.birahi-select');
            birahiSelects.forEach(select => {
                if (select.value === 'Positif') {
                    hasAutoCancel = true;
                    console.log('Found birahi positif that needs auto cancel');
                }
            });
            
            if (hasAutoCancel) {
                // Force redirect ke cancelled
                forceRedirect = true;
                cancelledUrl = '{{ route("screening.cancelled") }}';
                prepareFormForCancelledSubmission();
                showRedirectOverlay();
                startCountdown();
                return;
            }
            
            // Validasi form normal
            if (validateForm()) {
                console.log('Form validated, submitting...');
                
                // Remove any cancelled flags
                const forceCancelledInput = document.querySelector('input[name="force_cancelled"]');
                if (forceCancelledInput) {
                    forceCancelledInput.remove();
                }
                
                form.submit();
            } else {
                console.log('Form validation failed');
            }
        }
    });

    // Fungsi untuk validasi form NORMAL
    function validateForm() {
        const selects = document.querySelectorAll('.pet-select[data-required="true"]');
        let allFieldsFilled = true;
        
        // Reset errors
        document.getElementById('globalError').classList.add('hidden');
        selects.forEach(select => {
            select.style.borderColor = '';
            select.style.boxShadow = '';
            const pet = select.dataset.pet;
            const key = select.dataset.key;
            const errorDiv = document.getElementById(`error-${key}-${pet}`);
            if (errorDiv) {
                errorDiv.classList.add('hidden');
            }
        });
        
        // Check if all required fields are filled
        selects.forEach(select => {
            if (!select.value || select.value === '-') {
                allFieldsFilled = false;
                select.style.borderColor = '#ef4444';
                select.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
                
                const pet = select.dataset.pet;
                const key = select.dataset.key;
                const errorDiv = document.getElementById(`error-${key}-${pet}`);
                if (errorDiv) {
                    errorDiv.classList.remove('hidden');
                }
            }
        });
        
        // Check for kutu positif yang belum memilih action
        const kutuPositifSelects = document.querySelectorAll('select[data-key="kutu"]');
        kutuPositifSelects.forEach(select => {
            if (select.value === 'Positif') {
                const pet = select.dataset.pet;
                const actionInputs = document.querySelectorAll(`input[name="pets[${pet}][kutu_action]"]:checked`);
                
                if (actionInputs.length === 0) {
                    allFieldsFilled = false;
                    select.style.borderColor = '#ef4444';
                    select.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
                    
                    // Tampilkan pesan error
                    const errorDiv = document.getElementById(`error-kutu-${pet}`);
                    if (errorDiv) {
                        errorDiv.innerHTML = `
                            <div class="flex items-center space-x-2 text-red-600 text-sm">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>Silakan pilih tindakan untuk kutu positif</span>
                            </div>
                        `;
                        errorDiv.classList.remove('hidden');
                    }
                }
            }
        });
        
        if (!allFieldsFilled) {
            document.getElementById('globalError').classList.remove('hidden');
            return false;
        }
        
        return true;
    }
});
</script>

</body>
</html>