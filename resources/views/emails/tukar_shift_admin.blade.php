<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Tukar Shift Baru</title>
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

        .action-buttons {
            margin-top: 30px;
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-approve {
            background: #28a745;
            color: white;
        }

        .btn-reject {
            background: #dc3545;
            color: white;
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
            <h2>🔄 Pengajuan Tukar Shift Baru</h2>
            <p>Sistem Pengajuan Tukar Shift - Le Gareca Space</p>
        </div>

        <div class="content">
            <p>Halo Admin,</p>
            <p>Terdapat pengajuan tukar shift baru dengan detail sebagai berikut:</p>

            <div class="info-item">
                <span class="info-label">Nama Karyawan:</span>
                <span class="info-value">{{ $shifting->nama_karyawan }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Email Karyawan:</span>
                <span class="info-value">{{ $user->email }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Divisi/Jabatan:</span>
                <span class="info-value">{{ $shifting->divisi_jabatan }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Shift Asli:</span>
                <span class="info-value">
                    {{ \Carbon\Carbon::parse($shifting->tanggal_shift_asli)->format('d F Y') }}
                    ({{ $shifting->jam_shift_asli }})
                </span>
            </div>

            <div class="info-item">
                <span class="info-label">Shift Tujuan:</span>
                <span class="info-value">
                    {{ \Carbon\Carbon::parse($shifting->tanggal_shift_tujuan)->format('d F Y') }}
                    ({{ $shifting->jam_shift_tujuan }})
                </span>
            </div>

            <div class="info-item">
                <span class="info-label">Sudah Ada Pengganti:</span>
                <span class="info-value">{{ ucfirst($shifting->sudah_pengganti) }}</span>
            </div>

            @if ($shifting->sudah_pengganti == 'ya')
                <div class="info-item">
                    <span class="info-label">Nama Pengganti:</span>
                    <span class="info-value">{{ $shifting->nama_karyawan_pengganti }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Shift Pengganti:</span>
                    <span class="info-value">
                        {{ \Carbon\Carbon::parse($shifting->tanggal_shift_pengganti)->format('d F Y') }}
                        ({{ $shifting->jam_shift_pengganti }})
                    </span>
                </div>
            @endif

            <div class="info-item">
                <span class="info-label">Alasan:</span>
                <span class="info-value">{{ $shifting->alasan }}</span>
            </div>

            <div class="info-item">
                <span class="info-label">Status:</span>
                <span class="info-value" style="color: #ffc107; font-weight: bold;">
                    {{ ucfirst($shifting->status) }}
                </span>
            </div>

            <div class="info-item">
                <span class="info-label">Waktu Pengajuan:</span>
                <span class="info-value">
                    {{ \Carbon\Carbon::parse($shifting->created_at)->format('d F Y H:i:s') }}
                </span>
            </div>

            <div class="action-buttons">
                <p>Silakan pilih tindakan:</p>
                <a href="{{ $approveUrl }}"
                    style="
                            display:inline-block;
                            padding:12px 24px;
                            margin:0 10px;
                            background:#0d6efd;
                            color:#ffffff;
                            text-decoration:none;
                            border-radius:5px;
                            font-weight:bold;
                            ">
                        ✓ Setujui
                </a>

                <a href="{{ $rejectUrl }}"
                    style="
                            display:inline-block;
                            padding:12px 24px;
                            margin:0 10px;
                            background:#6c757d;
                            color:#ffffff;
                            text-decoration:none;
                            border-radius:5px;
                            font-weight:bold;
                            ">
                        ✗ Tolak
                </a>
            </div>

            <p style="margin-top: 30px; font-size: 12px; color: #6c757d;">
                <strong>Catatan:</strong> Tindakan di atas akan langsung memperbarui status pengajuan dan mengirimkan
                notifikasi ke karyawan yang bersangkutan.
            </p>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis dari Sistem Pengajuan Tukar Shift Le Gareca Space.</p>
            <p>© {{ date('Y') }} Le Gareca Space. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
