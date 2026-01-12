<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nomor HP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fef2f2 0%, #fff7ed 50%, #fef2f2 100%);
        }

        .input-field {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px;
            font-size: 16px;
            width: 100%;
        }

        .input-field.error {
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

        .progress-bar-bg {
            background: #fed7d7 !important;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-3xl">
        <!-- Paw decoration (optional) -->
        <div class="absolute top-4 right-4 opacity-100 text-2xl">
            <img src="/paw.png" alt="logo" class="w-12 h-12 object-contain">
        </div>

        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r from-red-100 to-orange-100 mb-4">
                <i class="fas fa-phone-alt text-3xl text-red-500"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">Contact Pawrents</h1>
            <div class="flex items-center justify-center space-x-2 mb-2">
                <div class="h-1 w-12 bg-red-400 rounded-full"></div>
                <h2 class="text-2xl md:text-3xl font-bold text-red-500">Le Gareca Space</h2>
                <div class="h-1 w-12 bg-orange-400 rounded-full"></div>
            </div>
        </div>

        <div class="form-card bg-white p-6 md:p-8 mb-8 rounded-2xl shadow-lg">

            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-red-500">Step 5 of 5</span>
                    <span class="text-sm font-medium text-gray-500">Phone Number</span>
                </div>
                <div class="w-full progress-bar-bg rounded-full h-2">
                    <div class="bg-gradient-to-r from-red-500 to-orange-500 h-2 rounded-full w-5/5"></div>
                </div>
            </div>

            <form id="phoneForm" action="{{ route('screening.submitNoHp') }}" method="POST" class="space-y-8">
                @csrf
                <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Nomor HP <span
                        class="text-red-500">*</span></h3>

                <div class="relative flex items-center max-w-md mx-auto">
                    <!-- LOCKED FLAG WRAPPER -->
                    <div
                        class="absolute left-0 top-0 bottom-0 flex items-center bg-gray-100 px-4 rounded-l-full border-r border-gray-300 z-30">
                        <button type="button" id="flagSelector">
                            <img id="flagImg" src="https://flagsapi.com/ID/flat/32.png" class="w-6" alt="flag">
                        </button>
                    </div>

                    <!-- INPUT PHONE -->
                    <input type="tel" inputmode="numeric" pattern="[0-9]*" name="no_hp" id="phoneInput" maxlength="13"
                        placeholder="Masukkan nomor HP"
                        class="w-full pl-20 pr-6 py-4 rounded-full bg-gray-50 border border-gray-300 focus:ring-2 focus:ring-red-200 focus:outline-none focus:border-red-400 z-10">

                    <!-- HIDDEN COUNTRY CODE -->
                    <input type="hidden" name="country_code" id="countryCode" value="+62">

                    <!-- DROPDOWN FLAG -->
                    <div id="flagDropdown"
                        class="hidden absolute left-0 top-full mt-2 bg-white rounded-xl shadow-lg w-60 max-h-80 overflow-y-auto py-2 z-40 border border-gray-200">
                        <div class="px-3 pb-2">
                            <input type="text" id="flagSearch" placeholder="Cari negara..."
                                class="input-field text-sm py-2 px-3">
                        </div>
                        <div id="countryList">
                            <button type="button"
                                class="flex items-center gap-3 px-4 w-full py-2 flag-option hover:bg-gray-50"
                                data-code="+47" data-country="NO"><img src="https://flagsapi.com/NO/flat/32.png"
                                    class="w-6">Norwegia</button>
                            <button type="button"
                                class="flex items-center gap-3 px-4 w-full py-2 flag-option hover:bg-gray-50"
                                data-code="+62" data-country="ID"><img src="https://flagsapi.com/ID/flat/32.png"
                                    class="w-6">Indonesia</button>
                            <button type="button"
                                class="flex items-center gap-3 px-4 w-full py-2 flag-option hover:bg-gray-50"
                                data-code="+1" data-country="US"><img src="https://flagsapi.com/US/flat/32.png"
                                    class="w-6">United States</button>
                            <button type="button"
                                class="flex items-center gap-3 px-4 w-full py-2 flag-option hover:bg-gray-50"
                                data-code="+60" data-country="MY"><img src="https://flagsapi.com/MY/flat/32.png"
                                    class="w-6">Malaysia</button>
                            <button type="button"
                                class="flex items-center gap-3 px-4 w-full py-2 flag-option hover:bg-gray-50"
                                data-code="+65" data-country="SG"><img src="https://flagsapi.com/SG/flat/32.png"
                                    class="w-6">Singapore</button>
                        </div>
                    </div>

                    <!-- ERROR MESSAGE -->
                    <div id="phoneError"
                        class="hidden absolute -bottom-6 left-0 right-0 text-center text-red-600 text-sm font-semibold">
                        <i class="fas fa-exclamation-circle"></i>
                        <span id="phoneErrorText"></span>
                    </div>
                </div>
            </form>
        </div>

        <div class="pt-6 flex flex-row justify-between items-center gap-4">
            <button type="button" onclick="window.history.back()" class="submit-btn flex-1 sm:flex-none">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </button>

            <button type="button" id="submitBtn" class="submit-btn flex-1 sm:flex-none">
                <i class="fas fa-check"></i>
                Submit
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const flagButton = document.getElementById('flagSelector');
            const flagDropdown = document.getElementById('flagDropdown');
            const flagImg = document.getElementById('flagImg');
            const phoneInput = document.getElementById('phoneInput');
            const countryCode = document.getElementById('countryCode');
            const flagSearch = document.getElementById('flagSearch');
            const submitBtn = document.getElementById('submitBtn');
            const phoneError = document.getElementById('phoneError');
            const phoneErrorText = document.getElementById('phoneErrorText');
            const form = document.getElementById('phoneForm');

            flagButton.addEventListener('click', (e) => {
                e.stopPropagation();
                flagDropdown.classList.toggle('hidden');
                flagSearch.focus();
            });

            document.querySelectorAll('.flag-option').forEach(opt => {
                opt.addEventListener('click', () => {
                    flagImg.src = `https://flagsapi.com/${opt.dataset.country}/flat/32.png`;
                    countryCode.value = opt.dataset.code;
                    flagDropdown.classList.add('hidden');
                });
            });

            flagSearch.addEventListener('input', () => {
                const term = flagSearch.value.toLowerCase();
                document.querySelectorAll('.flag-option').forEach(opt => {
                    opt.style.display = opt.textContent.toLowerCase().includes(term) ? 'flex' : 'none';
                });
            });

            phoneInput.addEventListener('input', () => {
                phoneInput.value = phoneInput.value.replace(/\D/g, '').slice(0, 13);
                hideError();
            });

            phoneInput.addEventListener('paste', (e) => {
                if (/\D/.test(e.clipboardData.getData('text'))) e.preventDefault();
            });

            document.addEventListener('click', () => flagDropdown.classList.add('hidden'));
            flagDropdown.addEventListener('click', (e) => e.stopPropagation());

            function hideError() {
                phoneError.classList.add('hidden');
                phoneInput.classList.remove('error');
            }

            function showError(msg) {
                phoneErrorText.textContent = msg;
                phoneError.classList.remove('hidden');
                phoneInput.classList.add('error');
            }

            submitBtn.addEventListener('click', (e) => {
                e.preventDefault();
                hideError();
                if (!phoneInput.value.trim()) return showError("Field is required");
                if (phoneInput.value.length < 8) return showError("Nomor HP minimal 8 digit");
                form.submit();
            });
        });
    </script>

</body>

</html>