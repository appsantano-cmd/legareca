<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesepakatan Pawrents — Le Gareca Space</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom gradient */
        .gradient-bg {
            background: linear-gradient(135deg, #fef2f2 0%, #fff7ed 50%, #fef2f2 100%);
            min-height: 100vh;
        }

        /* Card shadow and animation */
        .agreement-card {
            box-shadow: 0 10px 40px rgba(239, 68, 68, 0.08), 0 4px 12px rgba(239, 68, 68, 0.05);
        }

        /* Section styling */
        .section-header {
            position: relative;
            padding-left: 1.5rem;
        }

        .section-header::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 60%;
            width: 6px;
            background: linear-gradient(to bottom, #ef4444, #f97316);
            border-radius: 4px;
        }

        /* Custom checkbox */
        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 24px;
            height: 24px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .custom-checkbox:checked {
            background-color: #ef4444;
            border-color: #ef4444;
        }

        .custom-checkbox:checked::after {
            content: '✓';
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        /* List item styling dengan titik hitam */
        .custom-list {
            list-style-type: disc;
            padding-left: 1.5rem;
        }

        .custom-list li {
            position: relative;
            margin-bottom: 0.75rem;
            color: #374151;
            line-height: 1.6;
            padding-left: 0.25rem;
        }

        /* Warna titik hitam untuk bullet points */
        .custom-list li::marker {
            color: #1f2937;
            /* Warna hitam gelap */
            font-size: 1.1em;
        }

        /* Button styling */
        .btn-primary {
            background: linear-gradient(to right, #ef4444, #f97316);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #dc2626, #ea580c);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        /* Emphasized text */
        .emphasized {
            background: linear-gradient(to right, #fef3c7, #fee2e2);
            padding: 0.1rem 0.4rem;
            border-radius: 4px;
            font-weight: 600;
            font-style: italic;
        }

        /* Scrollbar styling */
        .scrollable-section {
            max-height: 500px;
            overflow-y: auto;
        }

        .scrollable-section::-webkit-scrollbar {
            width: 6px;
        }

        .scrollable-section::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollable-section::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #ef4444, #f97316);
            border-radius: 10px;
        }
    </style>
</head>

<body class="gradient-bg px-4 md:px-6 py-8 md:py-12">

    <div class="max-w-4xl mx-auto">
        <!-- Paw decoration (optional) -->
        <div class="absolute top-4 right-4 opacity-100 text-2xl">
            <img src="/paw.png" alt="logo" class="w-12 h-12 object-contain">
        </div>

        <!-- Header dengan ikon dan gradient -->
        <div class="text-center mb-10">
            <!-- <div
                class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r from-red-100 to-orange-100 mb-4">
                <i class="fas fa-paw text-3xl text-red-500"></i>
            </div> -->
            <div
                class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r from-red-100 to-orange-100 mb-4">
                <i class="fas fa-handshake text-3xl text-red-500"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">Kesepakatan Pawrents</h1>
            <div class="flex items-center justify-center space-x-2">
                <div class="h-1 w-12 bg-red-400 rounded-full"></div>
                <h2 class="text-2xl md:text-3xl font-bold text-red-500">Le Gareca Space</h2>
                <div class="h-1 w-12 bg-orange-400 rounded-full"></div>
            </div>
        </div>

        <!-- Main Agreement Card -->
        <div class="agreement-card bg-white rounded-2xl p-6 md:p-10">
            <!-- Progress indicator -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-red-500">Step 1 of 5</span>
                    <span class="text-sm font-medium text-gray-500">Agreement</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-red-500 to-orange-500 h-2 rounded-full w-1/5"></div>
                </div>
            </div>

            <!-- Agreement Sections -->
            <div class="scrollable-section pr-2 mb-6">
                <div class="space-y-8">
                    <!-- Section 1 -->
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 p-5 rounded-xl border-l-4 border-red-400">
                        <div class="section-header">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-door-open text-red-500 mr-3"></i>
                                Syarat Masuk Le Gareca Space
                            </h3>
                        </div>
                        <ul class="custom-list mt-4 text-gray-700">
                            <li>Anabul harus sehat.</li>
                            <li>Anabul wajib bersih dan tidak berbau.</li>
                            <li>Anabul wajib memakai tali/<span class="emphasized">harness</span>/kandang.</li>
                            <li>Anabul wajib menggunakan pampers/<span class="emphasized">manner belt</span>.</li>
                            <li>Anabul hanya boleh di area outdoor (<span class="emphasized">pet friendly zone</span>).
                            </li>
                        </ul>
                    </div>

                    <!-- Section 2 -->
                    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 p-5 rounded-xl border-l-4 border-amber-400">
                        <div class="section-header">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-map-marker-alt text-amber-500 mr-3"></i>
                                Area Khusus
                            </h3>
                        </div>
                        <ul class="custom-list mt-4 text-gray-700">
                            <li><span class="emphasized">Zona pet friendly</span> tersedia (outdoor).</li>
                            <li>Anabul tidak boleh masuk ke area indoor.</li>
                            <li>Tamu tanpa anabul mendapat area terpisah.</li>
                        </ul>
                    </div>

                    <!-- Section 3 -->
                    <div
                        class="bg-gradient-to-r from-emerald-50 to-teal-50 p-5 rounded-xl border-l-4 border-emerald-400">
                        <div class="section-header">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-broom text-emerald-500 mr-3"></i>
                                Kebersihan & Kenyamanan
                            </h3>
                        </div>
                        <ul class="custom-list mt-4 text-gray-700">
                            <li>Pawrents wajib membawa perlengkapan anabul.</li>
                            <li>Jika anabul buang kotoran, pemilik wajib membersihkan.</li>
                            <li>Anabul tidak boleh naik ke meja/kursi.</li>
                            <li>Dilarang memberi makan anabul dengan peralatan restoran.</li>
                        </ul>
                    </div>

                    <!-- Section 4 -->
                    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 p-5 rounded-xl border-l-4 border-blue-400">
                        <div class="section-header">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-shield-alt text-blue-500 mr-3"></i>
                                Keamanan
                            </h3>
                        </div>
                        <ul class="custom-list mt-4 text-gray-700">
                            <li>Anabul harus selalu dalam pengawasan pawrents.</li>
                            <li>Anabul Tidak boleh dibiarkan tanpa tali (harus <span
                                    class="emphasized">on-leash</span>).</li>
                            <li>Jika mengganggu, manajemen berhak meminta pawrents menenangkan anabul.</li>
                            <li>Anabul yang memasuki area dog park, disarankan tetap memakai leash. Khusus anabul yang
                                sudah lolos CGC (<span class="emphasized">Canine Good Citizen</span>), maka pawrents
                                boleh melepas anabul tersebut di dalam area dog park (<span
                                    class="emphasized">off-leash</span>).</li>
                        </ul>
                    </div>

                    <!-- Section 5 -->
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-5 rounded-xl border-l-4 border-purple-400">
                        <div class="section-header">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-concierge-bell text-purple-500 mr-3"></i>
                                Layanan Restoran
                            </h3>
                        </div>
                        <ul class="custom-list mt-4 text-gray-700">
                            <li>Le Gareca Space menyediakan mangkuk air gratis (bisa <span
                                    class="emphasized">request</span>).</li>
                            <li>Tersedia <span class="emphasized">day care</span> untuk anabul di Lega Pet Hotel.</li>
                            <li>Staff tidak diperbolehkan memegang anabul tanpa izin pawrents.</li>
                        </ul>
                    </div>

                    <!-- Section 6 -->
                    <div class="bg-gradient-to-r from-rose-50 to-red-50 p-5 rounded-xl border-l-4 border-rose-400">
                        <div class="section-header">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-balance-scale text-rose-500 mr-3"></i>
                                Hak & Tanggung Jawab
                            </h3>
                        </div>
                        <ul class="custom-list mt-4 text-gray-700">
                            <li>Manajemen berhak menolak tamu dengan anabul sakit/agresif.</li>
                            <li>Pawrents bertanggung jawab penuh atas anabul.</li>
                            <li>Pawrents bertanggung jawab penuh atas kerusakan properti yang disebabkan oleh anabul.
                            </li>
                            <li>Manajemen tidak bertanggung jawab atas kelalaian pawrents yang berakibat terhadap
                                kesehatan anabul. Seperti perkelahian antar anabul, anabul menggigit tamu lain, atau
                                anabul memakan sesuatu seperti rumput, serangga, atau hewan lainnnya.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Agreement Checkbox -->
            <div class="mt-10 pt-8 border-t border-gray-200">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl">
                    <label class="flex items-start space-x-4 cursor-pointer group">
                        <input type="checkbox" id="agreeCheck" class="custom-checkbox flex-shrink-0 mt-1">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-signature text-red-500 mr-2"></i>
                                <span class="text-lg font-bold text-gray-800">Persetujuan Pawrents</span>
                            </div>
                            <p class="text-gray-700 italic leading-relaxed">
                                "Sebagai pawrent, saya sudah membaca dan memahami semua kesepakatan di Le Gareca Space.
                                Saya menyetujui untuk mematuhi peraturan ini dan bertanggung jawab penuh atas anabul
                                saya. Siap enjoy dan have fun bareng!"
                            </p>
                            <div class="mt-4 flex items-center text-sm text-gray-500">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                <span>Dengan mencentang, Anda menyetujui kesepakatan</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center mt-8 pt-6 gap-3">
                <button onclick="window.location.href='/screening'" class="btn-primary text-white font-semibold
                        text-sm md:text-lg
                        px-5 py-2 md:px-10 md:py-3
                        rounded-full shadow-md transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Home
                </button>

                <div class="flex items-center space-x-4">
                    <button id="nextBtn" onclick="window.location.href='/screening/yakin'" class="btn-primary text-white font-semibold
                            text-sm md:text-lg
                            px-5 py-2 md:px-10 md:py-3
                            rounded-full shadow-md transition
                            disabled:opacity-50 disabled:cursor-not-allowed
                            flex items-center" disabled>
                        Next <i class="fas fa-arrow-right ml-2"></i>
                    </button>

                </div>
            </div>
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

    <!-- JavaScript untuk interaktivitas -->
    <script>
        const check = document.getElementById('agreeCheck');
        const btn = document.getElementById('nextBtn');

        check.addEventListener('change', function () {
            if (this.checked) {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                btn.classList.add('opacity-100', 'cursor-pointer');
            } else {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
                btn.classList.remove('opacity-100', 'cursor-pointer');
            }
        });
    </script>

</body>

</html>