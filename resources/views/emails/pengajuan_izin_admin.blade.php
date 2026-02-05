<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Izin Baru</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f8f9fa; padding: 20px; border-radius: 5px; }
        .content { background: white; padding: 20px; border: 1px solid #dee2e6; border-radius: 5px; margin-top: 20px; }
        .info-item { margin-bottom: 10px; }
        .info-label { font-weight: bold; color: #495057; }
        .info-value { color: #212529; }
        .action-buttons { margin-top: 30px; text-align: center; }
        .btn { display: inline-block; padding: 12px 24px; margin: 0 10px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .btn-approve { background: #28a745; color: white; }
        .btn-reject { background: #dc3545; color: white; }
        .file-attachment { 
            background: #e9ecef; 
            padding: 15px; 
            border-radius: 5px; 
            margin-top: 20px;
            border-left: 4px solid #007bff;
        }
        .file-icon { 
            display: inline-block; 
            margin-right: 10px; 
            font-size: 18px; 
            color: #007bff; 
        }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; color: #6c757d; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>📋 Pengajuan Izin Baru</h2>
            <p>Sistem Pengajuan Izin - Le Gareca Space</p>
        </div>
        
        <div class="content">
            <p>Halo Admin,</p>
            <p>Terdapat pengajuan izin baru dengan detail sebagai berikut:</p>
            
            <div class="info-item">
                <span class="info-label">Nama Karyawan:</span>
                <span class="info-value">{{ $izin->nama }}</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Email Karyawan:</span>
                <span class="info-value">{{ $user->email }}</span>
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
                <span class="info-label">Nomor Telepon:</span>
                <span class="info-value">{{ $izin->nomor_telepon }}</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Alamat:</span>
                <span class="info-value">{{ $izin->alamat }}</span>
            </div>
            
            @if($izin->keterangan_tambahan)
            <div class="info-item">
                <span class="info-label">Keterangan Tambahan:</span>
                <span class="info-value">{{ $izin->keterangan_tambahan }}</span>
            </div>
            @endif
            
            <div class="info-item">
                <span class="info-label">Status:</span>
                <span class="info-value" style="color: #ffc107; font-weight: bold;">{{ $izin->status }}</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Waktu Pengajuan:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($izin->created_at)->format('d F Y H:i:s') }}</span>
            </div>
            
            @if($fileAttached && $fileName)
            <div class="file-attachment">
                <div style="margin-bottom: 10px;">
                    <span class="file-icon">
                        @if(str_contains(strtolower($fileName), '.pdf'))
                            📄
                        @elseif(str_contains(strtolower($fileName), '.jpg') || str_contains(strtolower($fileName), '.jpeg') || str_contains(strtolower($fileName), '.png'))
                            🖼️
                        @elseif(str_contains(strtolower($fileName), '.doc') || str_contains(strtolower($fileName), '.docx'))
                            📝
                        @elseif(str_contains(strtolower($fileName), '.xls') || str_contains(strtolower($fileName), '.xlsx'))
                            📊
                        @else
                            📎
                        @endif
                    </span>
                    <strong>File Pendukung Terlampir:</strong>
                </div>
                <div style="font-size: 14px;">
                    <div style="margin-bottom: 5px;">
                        <strong>Nama File:</strong> {{ $fileName }}
                    </div>
                    <div style="color: #6c757d; font-size: 12px;">
                        File ini sudah dilampirkan pada email ini. Anda dapat membuka atau menyimpannya untuk review.
                    </div>
                </div>
            </div>
            @else
            <div class="file-attachment" style="border-left-color: #6c757d; background: #f8f9fa;">
                <div style="color: #6c757d;">
                    <span class="file-icon">📎</span>
                    <strong>Tidak ada file pendukung yang dilampirkan</strong>
                </div>
                <div style="font-size: 12px; color: #6c757d; margin-top: 5px;">
                    Karyawan tidak mengupload file pendukung untuk pengajuan ini.
                </div>
            </div>
            @endif
            
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
                <strong>Catatan:</strong> Tindakan di atas akan langsung memperbarui status pengajuan dan mengirimkan notifikasi ke karyawan yang bersangkutan.
            </p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis dari Sistem Pengajuan Izin Le Gareca Space.</p>
            <p>© {{ date('Y') }} Le Gareca Space. All rights reserved.</p>
        </div>
    </div>
</body>
</html>