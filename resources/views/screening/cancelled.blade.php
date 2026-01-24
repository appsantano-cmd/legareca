<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemeriksaan Dibatalkan - Le Gareca Space</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fef2f2 0%, #fff7ed 50%, #fef2f2 100%);
        }
        
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.08), 0 2px 6px rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(254, 202, 202, 0.2);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="min-h-screen px-4 py-8">
    <div class="w-full max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r from-red-100 to-orange-100 mb-4">
                <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">Pemeriksaan Dibatalkan</h1>
            <div class="flex items-center justify-center space-x-2">
                <div class="h-1 w-12 bg-red-400 rounded-full"></div>
                <h2 class="text-2xl md:text-3xl font-bold text-red-500">Le Gareca Space</h2>
                <div class="h-1 w-12 bg-orange-400 rounded-full"></div>
            </div>
        </div>

        <!-- Content Card -->
        <div class="card p-6 animate-fadeIn">
            <div class="text-center mb-8">
                <i class="fas fa-sad-tear text-6xl text-red-400 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Mohon Maaf, Pemeriksaan Tidak Dapat Dilanjutkan</h3>
                <p class="text-gray-600">
                    Berdasarkan hasil screening, terdapat kondisi yang mengharuskan pemeriksaan dibatalkan.
                </p>
            </div>

            <!-- Alasan Pembatalan -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-red-800 mb-3 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i> Alasan Pembatalan:
                </h4>
                <ul class="space-y-2">
                    @foreach($reasons as $reason)
                    <li class="flex items-start">
                        <i class="fas fa-paw text-red-500 mt-1 mr-2"></i>
                        <div>
                            <span class="font-medium">{{ $reason['pet_name'] }}</span>: 
                            <span class="text-gray-700">{{ $reason['reason'] }}</span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Informasi Pemilik -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-gray-800 mb-2">Informasi Pemilik:</h4>
                <p class="text-gray-700">Nama: <span class="font-medium">{{ $owner }}</span></p>
                <p class="text-gray-700">Total Anabul: <span class="font-medium">{{ count($pets) }}</span></p>
            </div>

            <!-- Saran dan Kontak -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
                    <i class="fas fa-stethoscope mr-2"></i> Saran:
                </h4>
                <p class="text-gray-700 mb-3">
                    Untuk kesehatan anabul Anda, disarankan untuk:
                </p>
                <ul class="list-disc pl-5 text-gray-700 space-y-1">
                    @if(in_array('kutu', array_column($reasons, 'reason')))
                    <li>Melakukan perawatan kutu terlebih dahulu</li>
                    <li>Konsultasi dengan dokter hewan untuk penanganan kutu</li>
                    @endif
                    @if(in_array('birahi', array_column($reasons, 'reason')))
                    <li>Menunggu masa birahi selesai</li>
                    <li>Pertimbangkan sterilisasi untuk kesehatan jangka panjang</li>
                    @endif
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('screening.welcome') }}" 
                   class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-3 px-8 rounded-full text-center hover:from-red-600 hover:to-orange-600 transition duration-300 shadow-md">
                    <i class="fas fa-home mr-2"></i> Kembali ke Halaman Awal
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            <p>Le Gareca Space — Peduli kesehatan anabul kesayangan Anda</p>
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
        // Auto export ke Google Sheets saat halaman dibuka
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route("screening.export-sheets") }}')
                .then(response => response.json())
                .then(data => {
                    console.log('Data exported to Google Sheets');
                })
                .catch(error => {
                    console.error('Export error:', error);
                });
        });
    </script>
</body>
</html>