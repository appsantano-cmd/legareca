<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Pengajuan Izin - Le Gareca Space</title>
    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            line-height: 1.6;
            -webkit-text-size-adjust: 100%;
            font-size: 15px; /* Base font size */
        }

        /* Container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 35px 30px;
            text-align: center;
            color: white;
            position: relative;
        }

        .email-header h1 {
            font-size: 24px; /* Fixed size */
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .email-header p {
            font-size: 15px; /* Fixed size */
            opacity: 0.95;
            font-weight: 300;
        }

        /* Content */
        .email-content {
            padding: 35px 30px;
        }

        .greeting {
            font-size: 17px; /* Fixed size */
            color: #2d3748;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .greeting .highlight {
            color: #1890ff;
            font-weight: 600;
        }

        /* Status Banner */
        .status-banner {
            text-align: center;
            padding: 30px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            border: 2px solid;
            position: relative;
            overflow: hidden;
        }

        .status-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
        }

        .status-approved {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-color: #28a745;
        }

        .status-rejected {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-color: #dc3545;
        }

        .status-icon {
            font-size: 48px; /* Fixed size */
            margin-bottom: 15px;
            display: inline-block;
            animation: bounce 1s ease;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .status-text {
            font-size: 22px; /* Fixed size */
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .status-approved .status-text {
            color: #155724;
            text-shadow: 0 2px 4px rgba(21, 87, 36, 0.1);
        }

        .status-rejected .status-text {
            color: #721c24;
            text-shadow: 0 2px 4px rgba(114, 28, 36, 0.1);
        }

        /* Section Title */
        .section-title {
            font-size: 16px; /* Fixed size */
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 3px solid #e2e8f0;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 60px;
            height: 3px;
            background: #1890ff;
        }

        /* Info Card - DIPERBAIKI */
        .info-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
        }

        .info-row {
            display: grid;
            grid-template-columns: 160px 1fr; /* Fixed width untuk label */
            gap: 20px; /* Spacing konsisten */
            padding: 14px 0;
            border-bottom: 1px solid #e2e8f0;
            align-items: start; /* Align ke atas */
        }

        .info-row:last-child {
            border-bottom: none;
        }

        /* Mobile responsive */
        @media (max-width: 480px) {
            .info-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }
        }

        .info-label {
            font-size: 14px; /* Fixed size */
            color: #4a5568;
            font-weight: 600; /* Lebih tebal untuk pembeda */
            line-height: 1.5;
        }

        .info-value {
            font-size: 15px; /* Fixed size, sedikit lebih besar dari label */
            color: #1a202c;
            word-break: break-word;
            line-height: 1.6;
        }

        .info-value strong {
            color: #1890ff;
        }

        /* Message Box */
        .message-box {
            background: linear-gradient(135deg, #e6f7ff 0%, #bae7ff 100%);
            border-left: 5px solid #1890ff;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
            font-size: 15px; /* Fixed size */
            color: #0050b3;
            line-height: 1.6;
            position: relative;
            overflow: hidden;
        }

        .message-box::before {
            content: '💬';
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            opacity: 0.1;
        }

        .message-box p {
            margin: 0;
            position: relative;
            z-index: 1;
        }

        /* Footer */
        .email-footer {
            background: #f8f9fa;
            padding: 22px;
            text-align: center;
            font-size: 12px; /* Fixed size */
            color: #718096;
            line-height: 1.6;
            border-top: 1px solid #e2e8f0;
        }

        .email-footer p {
            margin-bottom: 8px;
        }

        .email-footer p:last-child {
            margin-bottom: 0;
        }

        /* Thank You */
        .thank-you {
            text-align: center;
            padding: 25px 0;
            color: #4a5568;
            font-size: 15px; /* Fixed size */
            font-weight: 500;
        }

        .thank-you::before {
            content: '🙏';
            display: block;
            font-size: 32px;
            margin-bottom: 10px;
        }

        /* Gmail specific fixes */
        @media only screen and (max-width: 600px) {
            .email-header {
                padding: 30px 20px !important;
            }

            .email-content {
                padding: 30px 20px !important;
            }

            .email-header h1 {
                font-size: 22px !important;
            }

            .status-banner {
                padding: 25px 20px !important;
            }

            .status-icon {
                font-size: 40px !important;
            }

            .status-text {
                font-size: 18px !important;
            }

            .info-card {
                padding: 16px !important;
            }

            .message-box {
                padding: 16px !important;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>📋 Update Status Pengajuan</h1>
            <p>Le Gareca Space</p>
        </div>

        <!-- Content -->
        <div class="email-content">
            <!-- Greeting -->
            <div class="greeting">
                Halo <span class="highlight">{{ $izin->nama }}</span>,
            </div>

            <!-- Status Banner -->
            <div class="status-banner {{ $izin->status == 'Disetujui' ? 'status-approved' : 'status-rejected' }}">
                <div class="status-icon">
                    @if ($izin->status == 'Disetujui')
                        ✅
                    @else
                        ❌
                    @endif
                </div>
                <div class="status-text">
                    @if ($izin->status == 'Disetujui')
                        PENGAJUAN IZIN DISETUJUI
                    @else
                        PENGAJUAN IZIN DITOLAK
                    @endif
                </div>
            </div>

            <!-- Section Title -->
            <div class="section-title">Detail Pengajuan</div>

            <!-- Info Card -->
            <div class="info-card">
                <div class="info-row">
                    <div class="info-label">Nama</div>
                    <div class="info-value">{{ $izin->nama }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Divisi</div>
                    <div class="info-value">{{ $izin->divisi }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Jenis Izin</div>
                    <div class="info-value">{{ $izin->jenis_izin }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Periode</div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d F Y') }} -
                        {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d F Y') }}
                        <span style="color: #718096;">({{ $izin->jumlah_hari }} hari)</span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value"><strong>{{ $izin->status }}</strong></div>
                </div>

                @if ($izin->disetujui_oleh)
                    <div class="info-row">
                        <div class="info-label">Diproses oleh</div>
                        <div class="info-value">{{ $izin->disetujui_oleh }}</div>
                    </div>
                @endif

                @if ($izin->tanggal_persetujuan)
                    <div class="info-row">
                        <div class="info-label">Tanggal Proses</div>
                        <div class="info-value">
                            {{ \Carbon\Carbon::parse($izin->tanggal_persetujuan)->format('d F Y, H:i') }} WIB
                        </div>
                    </div>
                @endif

                @if ($izin->catatan_admin)
                    <div class="info-row">
                        <div class="info-label">Catatan Admin</div>
                        <div class="info-value">{{ $izin->catatan_admin }}</div>
                    </div>
                @endif
            </div>

            <!-- Message Box -->
            <div class="message-box">
                @if ($izin->status == 'Disetujui')
                    🎉 Selamat! Pengajuan izin Anda telah disetujui. Silakan atur jadwal Anda sesuai dengan periode izin
                    yang telah disetujui.
                @else
                    Mohon maaf, pengajuan izin Anda tidak dapat disetujui saat ini. Jika ada pertanyaan, silakan hubungi
                    tim HR.
                @endif
            </div>

            <!-- Thank You -->
            <div class="thank-you">
                Terima kasih atas pengertiannya.
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>Email otomatis dari Sistem Pengajuan Izin Le Gareca Space</p>
            <p>© {{ date('Y') }} Le Gareca Space. All rights reserved.</p>
        </div>
    </div>
</body>

</html>