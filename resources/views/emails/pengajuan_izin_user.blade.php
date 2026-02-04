<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Pengajuan Izin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }

        .content {
            background: white;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-top: 20px;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            color: #495057;
        }

        .info-value {
            color: #212529;
        }

        .status-box {
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>📋 Update Status Pengajuan Izin</h2>
            <p>Sistem Pengajuan Izin - Le Gareca Space</p>
        </div>

        <div class="content">
            <p>Halo {{ $izin->nama }},</p>

            <p>Pengajuan izin Anda telah diperbarui statusnya:</p>

            <div class="status-box {{ $izin->status == 'Disetujui' ? 'status-approved' : 'status-rejected' }}">
                @if ($izin->status == 'Disetujui')
                    ✅ PENGAJUAN IZIN DISETUJUI
                @else
                    ❌ PENGAJUAN IZIN DITOLAK
                @endif
            </div>

            <p><strong>Detail Pengajuan:</strong></p>

            <div class="info-item">
                <span class="info-label">Nama:</span>
                <span class="info-value">{{ $izin->nama }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Divisi:</span>
                <span class="info-value">{{ $izin->divisi }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Jenis Izin:</span>
                <span class="info-value">{{ $izin->jenis_izin }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Periode:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d F Y') }}
                    s/d {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d F Y') }}
                    ({{ $izin->jumlah_hari }} hari)</span>
            </div>

            <div class="info-item">
                <span class="info-label">Status Saat Ini:</span>
                <span class="info-value">
                    <strong>{{ $izin->status }}</strong>
                </span>
            </div>

            @if ($izin->disetujui_oleh)
                <div class="info-item">
                    <span class="info-label">Disetujui/Ditolak Oleh:</span>
                    <span class="info-value">{{ $izin->disetujui_oleh }}</span>
                </div>
            @endif

            @if ($izin->tanggal_persetujuan)
                <div class="info-item">
                    <span class="info-label">Tanggal Persetujuan:</span>
                    <span
                        class="info-value">{{ \Carbon\Carbon::parse($izin->tanggal_persetujuan)->format('d F Y H:i:s') }}</span>
                </div>
            @endif

            @if ($izin->catatan_admin)
                <div class="info-item">
                    <span class="info-label">Catatan dari Admin:</span>
                    <span class="info-value">{{ $izin->catatan_admin }}</span>
                </div>
            @endif

            <p style="margin-top: 30px;">
                @if ($izin->status == 'Disetujui')
                    Selamat, Pengajuan izin Anda telah disetujui.
                @else
                    Mohon maaf, pengajuan izin Anda tidak dapat disetujui saat ini.
                @endif
            </p>

            <p>Terima kasih.</p>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis dari Sistem Pengajuan Izin Le Gareca Space.</p>
            <p>© {{ date('Y') }} Le Gareca Space. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
