<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Izin Baru - Le Gareca Space</title>
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
            font-size: 16px; /* Fixed size */
            color: #2d3748;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        /* Info Card - DIPERBAIKI */
        .info-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
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

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px; /* Fixed size */
            font-weight: 600;
            background: #fff3cd;
            color: #856404;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* File Card */
        .file-card {
            background: #e6f7ff;
            border-left: 4px solid #1890ff;
            border-radius: 8px;
            padding: 18px;
            margin: 24px 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .file-card.no-file {
            background: #f8f9fa;
            border-left-color: #adb5bd;
        }

        .file-icon {
            font-size: 32px;
            flex-shrink: 0;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-size: 15px; /* Fixed size */
            color: #1a202c;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .file-note {
            font-size: 13px; /* Fixed size */
            color: #718096;
        }

        /* Action Section - DIPERBAIKI */
        .action-section {
            text-align: center;
            padding: 30px 0;
            border-top: 1px solid #e2e8f0;
            margin-top: 30px;
        }

        .action-title {
            font-size: 15px; /* Fixed size */
            color: #4a5568;
            margin-bottom: 25px;
            font-weight: 500;
        }

        /* PERBAIKAN UTAMA: Tombol rata kiri dan kanan */
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: space-between; /* Tombol rata kiri dan kanan */
            width: 100%;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 15px; /* Fixed size */
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            flex: 1; /* Membuat kedua tombol sama lebar */
            min-width: 180px; /* Minimum width untuk tampilan desktop */
        }

        /* Desktop: Tombol rata kiri dan kanan dengan lebar sama */
        @media (min-width: 481px) {
            .btn {
                max-width: 48%; /* Agar ada ruang untuk gap */
            }
        }

        /* Mobile: Tombol full width dan bertumpuk */
        @media (max-width: 480px) {
            .action-buttons {
                flex-direction: column; /* Tombol bertumpuk */
                gap: 12px;
            }
            
            .btn {
                width: 100%; /* Full width di mobile */
                min-width: 100%; /* Hilangkan min-width di mobile */
            }
        }

        .btn-approve {
            background: linear-gradient(135deg, #52c41a 0%, #73d13d 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(82, 196, 26, 0.3);
        }

        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(82, 196, 26, 0.4);
        }

        .btn-reject {
            background: linear-gradient(135deg, #ff4d4f 0%, #ff7875 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 77, 79, 0.3);
        }

        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 77, 79, 0.4);
        }

        /* Note */
        .note-box {
            background: linear-gradient(135deg, #fff7e6 0%, #fff1b8 100%);
            border-radius: 10px;
            padding: 18px;
            margin-top: 30px;
            border: 1px solid #ffd666;
        }

        .note-box strong {
            color: #d48806;
            display: block;
            margin-bottom: 8px;
            font-size: 14px; /* Fixed size */
        }

        .note-box p {
            color: #d48806;
            font-size: 14px; /* Fixed size */
            line-height: 1.6;
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

        /* Utility */
        .highlight {
            color: #1890ff;
            font-weight: 600;
        }

        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 30px 0;
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

            .info-card {
                padding: 16px !important;
            }

            .file-card {
                padding: 16px !important;
            }

            .note-box {
                padding: 16px !important;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>📋 Pengajuan Izin Baru</h1>
            <p>Le Gareca Space</p>
        </div>

        <!-- Content -->
        <div class="email-content">
            <!-- Greeting -->
            <div class="greeting">
                Halo <span class="highlight">Admin</span>,<br>
                Terdapat pengajuan izin baru yang memerlukan persetujuan Anda.
            </div>

            <!-- Info Card -->
            <div class="info-card">
                <div class="info-row">
                    <div class="info-label">Nama Karyawan</div>
                    <div class="info-value">{{ $izin->nama }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $user->email }}</div>
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
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">{{ $izin->nomor_telepon }}</div>
                </div>

                <div class="info-row">
                    <div class="info-label">Alamat</div>
                    <div class="info-value">{{ $izin->alamat }}</div>
                </div>

                @if ($izin->keterangan_tambahan)
                    <div class="info-row">
                        <div class="info-label">Keterangan</div>
                        <div class="info-value">{{ $izin->keterangan_tambahan }}</div>
                    </div>
                @endif

                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="status-badge">{{ $izin->status }}</span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">Waktu Pengajuan</div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($izin->created_at)->format('d F Y, H:i') }} WIB
                    </div>
                </div>
            </div>

            <!-- File Attachment -->
            @if ($fileAttached && $fileName)
                <div class="file-card">
                    <span class="file-icon">
                        @if (str_contains(strtolower($fileName), '.pdf'))
                            📄
                        @elseif(str_contains(strtolower($fileName), '.jpg') ||
                                str_contains(strtolower($fileName), '.jpeg') ||
                                str_contains(strtolower($fileName), '.png'))
                            🖼️
                        @elseif(str_contains(strtolower($fileName), '.doc') || str_contains(strtolower($fileName), '.docx'))
                            📝
                        @elseif(str_contains(strtolower($fileName), '.xls') || str_contains(strtolower($fileName), '.xlsx'))
                            📊
                        @else
                            📎
                        @endif
                    </span>
                    <div class="file-info">
                        <div class="file-name">{{ $fileName }}</div>
                        <div class="file-note">File pendukung terlampir pada email ini</div>
                    </div>
                </div>
            @else
                <div class="file-card no-file">
                    <span class="file-icon">📎</span>
                    <div class="file-info">
                        <div class="file-name">Tidak ada file pendukung</div>
                        <div class="file-note">Karyawan tidak melampirkan file pendukung</div>
                    </div>
                </div>
            @endif

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Action Section -->
            <div class="action-section">
                <div class="action-title">Silakan pilih tindakan untuk pengajuan ini</div>
                <div class="action-buttons">
                    <a href="{{ $approveUrl }}" class="btn btn-approve">✓ Setujui</a>
                    <a href="{{ $rejectUrl }}" class="btn btn-reject">✗ Tolak</a>
                </div>
            </div>

            <!-- Note -->
            <div class="note-box">
                <strong>📌 Catatan Penting</strong>
                <p>Tindakan di atas akan langsung memperbarui status pengajuan dan mengirimkan notifikasi ke karyawan
                    terkait.</p>
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