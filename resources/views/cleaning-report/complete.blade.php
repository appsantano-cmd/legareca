<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Berhasil Disimpan - Le Gareca</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .card-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .card-header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .card-body {
            padding: 40px;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #10b981;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: pulse 2s infinite;
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                box-shadow: 0 0 0 20px rgba(16, 185, 129, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        .success-message {
            text-align: center;
            margin-bottom: 30px;
        }

        .success-message h2 {
            color: #1e293b;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .success-message p {
            color: #64748b;
            font-size: 16px;
            line-height: 1.5;
        }

        .report-info {
            background: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border: 2px solid #e2e8f0;
        }

        .report-info h3 {
            color: #1e293b;
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-item {
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #475569;
            font-size: 14px;
        }

        .info-value {
            color: #1e293b;
            font-size: 15px;
            font-weight: 500;
            text-align: right;
        }

        .photo-section {
            margin-top: 20px;
            text-align: center;
        }

        .photo-section img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 16px 24px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
        }

        .btn-secondary {
            background: transparent;
            color: #4f46e5;
            border: 2px solid #4f46e5;
        }

        @media (max-width: 640px) {
            .card-body {
                padding: 25px;
            }
            
            .btn {
                padding: 14px 20px;
            }
            
            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .info-value {
                text-align: left;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Data Berhasil Disimpan
                </h1>
                <p>Laporan cleaning harian telah berhasil diproses</p>
            </div>
            
            <div class="card-body">
                <!-- Success Icon -->
                <div class="success-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>

                <!-- Success Message -->
                <div class="success-message">
                    <h2>Terima Kasih!</h2>
                    <p>Data laporan cleaning Anda telah berhasil disimpan dengan sempurna.</p>
                </div>

                <!-- Report Information -->
                <div class="report-info">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0 1 1 0 002 0zm2-3a1 1 0 00-2 0v3a1 1 0 102 0V9zm4-1a1 1 0 10-2 0v4a1 1 0 102 0V8z" clip-rule="evenodd" />
                        </svg>
                        Detail Laporan
                    </h3>
                    
                    <div class="info-item">
                        <span class="info-label">ID Laporan</span>
                        <div class="info-value">{{ $report->id }}</div>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Nama</span>
                        <div class="info-value">{{ $report->nama }}</div>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Departemen</span>
                        <div class="info-value">{{ $report->departemen }}</div>
                    </div>
                    
                    <!--<div class="info-item">
                        <span class="info-label">Tanggal</span>
                        <div class="info-value">{{ $report->tanggal }}</div>
                    </div>-->
                    
                    <div class="info-item">
                        <span class="info-label">Waktu Submit</span>
                        <div class="info-value">{{ $report->membership_datetime }}</div>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <div class="info-value" style="color: #10b981; font-weight: 600;">
                            {{ ucfirst($report->status) }}
                        </div>
                    </div>
                    
                    <!-- Photo Preview -->
                    @if($report->foto_path)
                    <div class="photo-section">
                        <img src="{{ asset($report->foto_path) }}" alt="Foto Cleaning">
                        <div style="margin-top: 10px;">
                            <a href="{{ asset($report->foto_path) }}" target="_blank" 
                               style="color: #4f46e5; text-decoration: none; font-size: 14px; font-weight: 500;">
                                📷 Lihat foto
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('cleaning-report.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Buat Laporan Baru
                    </a>
                </div>

                <!-- Simple Note -->
                <div style="margin-top: 25px; text-align: center;">
                    <p style="color: #64748b; font-size: 14px;">
                        Data Anda telah tersimpan dengan aman. Terima kasih telah melapor.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple animation for success icon
        document.addEventListener('DOMContentLoaded', function() {
            const icon = document.querySelector('.success-icon');
            if (icon) {
                setTimeout(() => {
                    icon.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        icon.style.transform = 'scale(1)';
                    }, 300);
                }, 500);
            }
        });
    </script>
</body>
</html>