<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Data — Le Gareca Space</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fef2f2 0%, #fff7ed 50%, #fef2f2 100%);
        }
        
        .section-card {
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
        
        .info-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            margin-right: 8px;
            margin-bottom: 8px;
        }
        
        .info-badge.blue {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }
        
        .info-badge.green {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }
        
        .info-badge.yellow {
            background: #fef9c3;
            color: #854d0e;
            border: 1px solid #fde047;
        }
        
        .info-badge.red {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .info-badge.orange {
            background: #ffedd5;
            color: #9a3412;
            border: 1px solid #fdba74;
        }
        
        .info-badge.purple {
            background: #f3e8ff;
            color: #6b21a8;
            border: 1px solid #d8b4fe;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .status-badge.completed {
            background: linear-gradient(to right, #10b981, #34d399);
            color: white;
        }
        
        .status-badge.cancelled {
            background: linear-gradient(to right, #ef4444, #f97316);
            color: white;
        }
        
        .back-btn {
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
        
        .back-btn:hover {
            background: linear-gradient(to right, #dc2626, #ea580c);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        
        .data-row {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        .data-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .data-label {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }
        
        .data-value {
            font-size: 16px;
            color: #111827;
            font-weight: 600;
        }
        
        .separator {
            height: 1px;
            background: linear-gradient(to right, transparent, #e5e7eb, transparent);
            margin: 20px 0;
        }
    </style>
</head>
<body class="min-h-screen px-4 py-8">

<div class="w-full max-w-4xl mx-auto">
    <!-- Paw decoration -->
    <div class="absolute top-4 right-4 opacity-100 text-2xl">
        <img src="/paw.png" alt="logo" class="w-12 h-12 object-contain">
    </div>

    <!-- Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r from-red-100 to-orange-100 mb-4">
            <i class="fas fa-clipboard-check text-3xl text-red-500"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">Review Data Screening</h1>
        <div class="flex items-center justify-center space-x-2">
            <div class="h-1 w-12 bg-red-400 rounded-full"></div>
            <h2 class="text-2xl md:text-3xl font-bold text-red-500">Le Gareca Space</h2>
            <div class="h-1 w-12 bg-orange-400 rounded-full"></div>
        </div>
        <p class="text-gray-500 max-w-2xl mx-auto text-sm mt-2">
            Review data screening yang telah Anda input
        </p>
    </div>

    @if(isset($screening))
        <!-- Status Info -->
        <div class="section-card p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Status Screening</h3>
                    <p class="text-gray-600 text-sm">Data ini sudah tersimpan di sistem</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="status-badge {{ $screening->status }}">
                        {{ $screening->status == 'completed' ? '✅ Selesai' : '⚠️ Dibatalkan' }}
                    </span>
                    <span class="text-gray-500 text-sm">
                        {{ $screening->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Owner Information -->
        <div class="section-card p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-user-circle mr-2 text-red-500"></i>
                Informasi Owner
            </h3>
            
            <div class="data-row">
                <div class="data-item">
                    <span class="data-label">Nama Owner</span>
                    <span class="data-value">{{ $screening->owner_name }}</span>
                </div>
                
                <div class="separator"></div>
                
                <div class="data-item">
                    <span class="data-label">Nomor Telepon</span>
                    <span class="data-value">{{ $screening->phone_number }}</span>
                </div>
                
                <div class="separator"></div>
                
                <div class="data-item">
                    <span class="data-label">Jumlah Anabul</span>
                    <span class="data-value">{{ $screening->pet_count }} anabul</span>
                </div>
            </div>
        </div>

        <!-- Pets Information -->
        <div class="section-card p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-paw mr-2 text-orange-500"></i>
                Data Anabul
            </h3>
            
            <div class="space-y-6">
                @foreach($screening->pets as $index => $pet)
                    <div class="pet-card p-5">
                        <!-- Pet Header -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-bold text-gray-800">
                                    {{ $pet->name }}
                                    <span class="text-sm font-normal text-gray-600">({{ $pet->breed }})</span>
                                </h4>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="info-badge blue">
                                        <i class="fas fa-venus-mars mr-1"></i>
                                        {{ $pet->sex }}
                                    </span>
                                    <span class="info-badge green">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $pet->age }}
                                    </span>
                                    @if($pet->status_text !== 'Normal')
                                        <span class="info-badge red">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            {{ $pet->status_text }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-2 md:mt-0">
                                <span class="text-sm text-gray-500">Anabul #{{ $index + 1 }}</span>
                            </div>
                        </div>
                        
                        <!-- Pet Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <!-- Column 1 -->
                            <div class="space-y-4">
                                <!-- Vaksin -->
                                <div class="data-item">
                                    <span class="data-label">
                                        <i class="fas fa-syringe mr-1 text-blue-500"></i>
                                        Status Vaksin
                                    </span>
                                    <span class="data-value">{{ $pet->vaksin }}</span>
                                </div>
                                
                                <!-- Kutu -->
                                <div class="data-item">
                                    <span class="data-label">
                                        <i class="fas fa-bug mr-1 text-red-500"></i>
                                        Hasil Kutu
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <span class="data-value">{{ $pet->kutu }}</span>
                                        @if($pet->kutu_action)
                                            <span class="info-badge {{ $pet->kutu_action == 'tidak_periksa' ? 'red' : 'yellow' }}">
                                                {{ $pet->kutu_action == 'tidak_periksa' ? 'Tidak Periksa' : 'Lanjut Obat' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Jamur -->
                                <div class="data-item">
                                    <span class="data-label">
                                        <i class="fas fa-leaf mr-1 text-green-500"></i>
                                        Hasil Jamur
                                    </span>
                                    <span class="data-value">{{ $pet->jamur }}</span>
                                </div>
                            </div>
                            
                            <!-- Column 2 -->
                            <div class="space-y-4">
                                <!-- Birahi -->
                                <div class="data-item">
                                    <span class="data-label">
                                        <i class="fas fa-heart mr-1 text-pink-500"></i>
                                        Status Birahi
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <span class="data-value">{{ $pet->birahi }}</span>
                                        @if($pet->birahi_action)
                                            <span class="info-badge {{ $pet->birahi_action == 'tidak_periksa' ? 'red' : 'yellow' }}">
                                                {{ $pet->birahi_action == 'tidak_periksa' ? 'Tidak Periksa' : 'Lanjut Obat' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Kulit -->
                                <div class="data-item">
                                    <span class="data-label">
                                        <i class="fas fa-hand-sparkles mr-1 text-orange-500"></i>
                                        Hasil Kulit
                                    </span>
                                    <span class="data-value">{{ $pet->kulit }}</span>
                                </div>
                                
                                <!-- Telinga -->
                                <div class="data-item">
                                    <span class="data-label">
                                        <i class="fas fa-ear-listen mr-1 text-purple-500"></i>
                                        Hasil Telinga
                                    </span>
                                    <span class="data-value">{{ $pet->telinga }}</span>
                                </div>
                                
                                <!-- Riwayat -->
                                <div class="data-item">
                                    <span class="data-label">
                                        <i class="fas fa-history mr-1 text-indigo-500"></i>
                                        Riwayat Kesehatan
                                    </span>
                                    <span class="data-value">{{ $pet->riwayat }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Notes for cancelled pets -->
                        @if($screening->status == 'cancelled' && isset($sessionData['cancel_reasons'][$index]))
                            <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-triangle text-red-500 mt-1 mr-2"></i>
                                    <div>
                                        <p class="text-sm font-medium text-red-800">Alasan pembatalan:</p>
                                        <p class="text-sm text-red-600 mt-1">
                                            {{ $sessionData['cancel_reasons'][$index]['reason'] ?? 'Tidak jadi periksa' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Summary -->
        <div class="section-card p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-file-alt mr-2 text-green-500"></i>
                Ringkasan Screening
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Total Anabul:</span>
                        <span class="font-bold text-gray-800">{{ $screening->pet_count }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-bold {{ $screening->status == 'completed' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $screening->status == 'completed' ? 'Selesai' : 'Dibatalkan' }}
                        </span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Tanggal Input:</span>
                        <span class="font-bold text-gray-800">
                            {{ $screening->created_at->setTimezone('Asia/Jakarta')->translatedFormat('d/m/Y') }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Waktu Input:</span>
                        <span class="font-bold text-gray-800">
                            {{ $screening->created_at->setTimezone('Asia/Jakarta')->format('H:i') }}
                        </span>
                    </div>
                </div>
            </div>
            
            @if($screening->status == 'completed')
                <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        <div>
                            <p class="font-medium text-green-800">Screening berhasil diselesaikan!</p>
                            <p class="text-sm text-green-600 mt-1">
                                Data anabul Anda telah tercatat di sistem. Terima kasih telah menggunakan layanan screening Le Gareca Space.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-xl mr-3"></i>
                        <div>
                            <p class="font-medium text-yellow-800">Screening dibatalkan</p>
                            <p class="text-sm text-yellow-600 mt-1">
                                Screening dibatalkan karena kondisi anabul yang tidak memungkinkan untuk pemeriksaan.
                                Silakan hubungi staff untuk informasi lebih lanjut.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 mt-8">
            <button 
                type="button" 
                onclick="window.print()"
                class="back-btn bg-blue-500 hover:bg-blue-600">
                <i class="fas fa-print mr-2"></i>
                Cetak Data
            </button>
            
            <button 
                type="button" 
                onclick="window.location.href='{{ route('screening.thankyou') }}'"
                class="back-btn">
                <i class="fas fa-home mr-2"></i>
                Kembali ke Home
            </button>
        </div>

    @else
        <!-- No Data Found -->
        <div class="section-card p-8 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                <i class="fas fa-search text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Data Tidak Ditemukan</h3>
            <p class="text-gray-600 mb-6">Data screening tidak ditemukan. Silakan lakukan screening terlebih dahulu.</p>
            <button 
                type="button" 
                onclick="window.location.href='{{ route('screening.welcome') }}'"
                class="back-btn mx-auto">
                <i class="fas fa-plus-circle mr-2"></i>
                Mulai Screening Baru
            </button>
        </div>
    @endif

    <!-- Footer -->
    <div class="text-center mt-10 text-gray-500 text-sm">
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

<!-- Print Styles -->
<style media="print">
    @media print {
        body {
            background: white !important;
            padding: 20px !important;
        }
        
        .section-card, .pet-card {
            box-shadow: none !important;
            border: 1px solid #e5e7eb !important;
            break-inside: avoid;
        }
        
        .back-btn, .status-badge, .info-badge {
            display: none !important;
        }
        
        .separator {
            background: #e5e7eb !important;
        }
        
        /* Header for print */
        .text-center h1 {
            font-size: 24px !important;
            margin-bottom: 10px !important;
        }
        
        .text-center h2 {
            font-size: 20px !important;
        }
        
        /* Add print logo */
        .print-logo {
            display: block !important;
            text-align: center;
            margin-bottom: 20px;
        }
        
        /* Hide decorative elements */
        .absolute {
            display: none !important;
        }
        
        /* Footer for print */
        .text-center.mt-10 {
            margin-top: 30px !important;
            font-size: 10px !important;
        }
        
        /* Page break */
        .page-break {
            page-break-before: always;
        }
    }
    
    /* Show print logo only for print */
    .print-logo {
        display: none;
    }
</style>

<!-- Print Logo (only shown when printing) -->
<div class="print-logo">
    <h2 style="text-align: center; margin-bottom: 5px;">Review Data Screening</h2>
    <h3 style="text-align: center; color: #ef4444; margin-bottom: 20px;">Le Gareca Space</h3>
    <p style="text-align: center; font-size: 12px; color: #6b7280;">
        Dicetak pada: {{ now()->setTimezone('Asia/Jakarta')->translatedFormat('d F Y H:i:s') }}
    </p>
    <hr style="margin: 20px 0; border: none; border-top: 2px solid #e5e7eb;">
</div>

<script>
    // Add print functionality with better formatting
    document.addEventListener('DOMContentLoaded', function() {
        // Add page breaks for print
        const petsCards = document.querySelectorAll('.pet-card');
        petsCards.forEach((card, index) => {
            if (index > 0 && index % 2 === 0) {
                card.classList.add('page-break');
            }
        });
        
        // Print button functionality
        const printBtn = document.querySelector('button[onclick="window.print()"]');
        if (printBtn) {
            printBtn.addEventListener('click', function() {
                // Add print header
                const printLogo = document.querySelector('.print-logo');
                if (printLogo) {
                    printLogo.style.display = 'block';
                    setTimeout(() => {
                        window.print();
                        setTimeout(() => {
                            printLogo.style.display = 'none';
                        }, 100);
                    }, 100);
                } else {
                    window.print();
                }
            });
        }
    });
</script>

</body>
</html>