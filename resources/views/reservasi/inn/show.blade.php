<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Reservasi - {{ $reservation->booking_code }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #264653;
            --secondary-color: #2a9d8f;
            --accent-color: #e76f51;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 30px;
        }
        
        .detail-container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .detail-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            overflow: hidden;
            border: none;
        }
        
        .detail-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
        }
        
        .detail-body {
            padding: 40px;
        }
        
        .booking-code {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 3px;
            margin-bottom: 10px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .info-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--primary-color);
        }
        
        .info-box {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            height: 100%;
            border-left: 4px solid var(--secondary-color);
        }
        
        .price-total {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 15px 25px;
            border-radius: 15px;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid var(--secondary-color);
        }
        
        .btn-action {
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .guest-info {
            background: #e3f2fd;
            border-radius: 15px;
            padding: 20px;
        }
        
        .special-request {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            border-radius: 10px;
        }

        /* ============= CSS UNTUK CETAK - HEMAT HALAMAN ============= */
        @media print {
            /* Sembunyikan semua elemen yang tidak perlu */
            body {
                background: white;
                padding: 0;
                margin: 0;
                font-size: 11pt;
                line-height: 1.2;
            }
            
            /* Sembunyikan tombol-tombol */
            .btn-back,
            .btn-action,
            .btn-print,
            .btn-warning,
            .btn-success,
            .btn-outline-secondary,
            .btn-outline-danger,
            .dropdown,
            .dropdown-menu,
            button[onclick*="confirmDelete"],
            button[onclick*="print"],
            .alert,
            .btn-close {
                display: none !important;
            }
            
            /* Sembunyikan form delete hidden */
            form[style*="display: none"] {
                display: none !important;
            }
            
            /* Optimalisasi card untuk cetak */
            .detail-card {
                box-shadow: none;
                border: 1px solid #ddd;
                margin: 0;
                page-break-inside: avoid;
            }
            
            .detail-header {
                background: #264653 !important;
                color: white !important;
                padding: 15px !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .detail-body {
                padding: 20px !important;
            }
            
            /* Kurangi margin dan padding */
            .row {
                margin-bottom: 0 !important;
                page-break-inside: avoid;
            }
            
            .mb-5 {
                margin-bottom: 15px !important;
            }
            
            .mb-4 {
                margin-bottom: 10px !important;
            }
            
            .mb-3 {
                margin-bottom: 8px !important;
            }
            
            .info-box {
                padding: 12px !important;
                margin-bottom: 8px !important;
                border-left-width: 3px !important;
            }
            
            .guest-info {
                padding: 15px !important;
            }
            
            .special-request {
                padding: 12px !important;
            }
            
            /* Ukuran font lebih kecil untuk cetak */
            .booking-code {
                font-size: 1.5rem !important;
                margin-bottom: 5px !important;
            }
            
            .section-title {
                font-size: 1.2rem !important;
                margin-bottom: 10px !important;
                padding-bottom: 5px !important;
            }
            
            .info-value {
                font-size: 1rem !important;
            }
            
            .info-label {
                font-size: 0.8rem !important;
            }
            
            .price-total {
                padding: 10px 20px !important;
                font-size: 1.2rem !important;
            }
            
            .status-badge {
                padding: 5px 15px !important;
                font-size: 0.8rem !important;
            }
            
            /* Watermark di pojok */
            .print-watermark {
                position: fixed;
                bottom: 10px;
                right: 10px;
                font-size: 8pt;
                color: #999;
                border: none;
                margin: 0;
                padding: 0;
            }
            
            .print-watermark div {
                border: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            .print-watermark p {
                margin: 0;
                line-height: 1.2;
            }
            
            /* Hindari page break di tengah */
            .detail-card,
            .detail-header,
            .detail-body,
            .row,
            .info-box,
            .guest-info,
            .special-request {
                page-break-inside: avoid;
            }
            
            /* Kompres layout menjadi lebih rapat */
            .col-md-4, .col-md-3, .col-md-6 {
                width: 50%;
                float: left;
            }
            
            .container, .detail-container {
                max-width: 100%;
                padding: 0;
            }
            
            /* Hilangkan background gradient */
            .price-total {
                background: #28a745 !important;
            }
            
            /* Icon tidak perlu terlalu besar */
            .fa-2x {
                font-size: 1.5em !important;
            }
            
            .rounded-circle {
                padding: 8px !important;
            }
        }
        /* ============= END CSS CETAK ============= */
    </style>
</head>
<body>
    <div class="detail-container">
        <!-- Tombol Kembali - AKAN SEMBUNYI SAAT CETAK -->
        <div class="mb-4 btn-back">
            <a href="{{ route('reservasi.inn.reservations.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Reservasi
            </a>
        </div>
        
        <div class="detail-card">
            <!-- Header -->
            <div class="detail-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="booking-code">{{ $reservation->booking_code }}</div>
                        <p class="mb-0 opacity-75 small">
                            <i class="fas fa-calendar-alt me-2"></i>
                            {{ $reservation->created_at->translatedFormat('d M Y H:i') }}
                        </p>
                    </div>
                    <div>
                        <span class="badge {{ $reservation->status_badge_class }} status-badge">
                            @switch($reservation->status)
                                @case('pending')
                                    <i class="fas fa-clock me-1"></i>PENDING
                                    @break
                                @case('confirmed')
                                    <i class="fas fa-check-circle me-1"></i>CONFIRMED
                                    @break
                                @case('cancelled')
                                    <i class="fas fa-times-circle me-1"></i>CANCELLED
                                    @break
                                @case('completed')
                                    <i class="fas fa-flag-checkered me-1"></i>COMPLETED
                                    @break
                            @endswitch
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Body -->
            <div class="detail-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Informasi Kamar & Menginap digabung untuk hemat halaman -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h3 class="section-title">
                            <i class="fas fa-bed me-2"></i>
                            Detail Reservasi
                        </h3>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="info-label">Tipe Kamar</div>
                            <div class="info-value">{{ $reservation->room_type }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="info-label">Harga/Malam</div>
                            <div class="info-value">{{ $reservation->formatted_room_price }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="info-box">
                            <div class="info-label">Jumlah Kamar</div>
                            <div class="info-value">{{ $reservation->rooms }} Kamar</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="info-box">
                            <div class="info-label">Check-in</div>
                            <div class="info-value">{{ $reservation->check_in->format('d/m/Y') }}</div>
                            <small>14:00</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="info-box">
                            <div class="info-label">Check-out</div>
                            <div class="info-value">{{ $reservation->check_out->format('d/m/Y') }}</div>
                            <small>12:00</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="info-box">
                            <div class="info-label">Durasi</div>
                            <div class="info-value">{{ $reservation->duration_days }} Malam</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="info-box">
                            <div class="info-label">Jumlah Tamu</div>
                            <div class="info-value">{{ $reservation->guests }} Orang</div>
                        </div>
                    </div>
                </div>
                
                <!-- Informasi Tamu - lebih ringkas -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h3 class="section-title">
                            <i class="fas fa-user me-2"></i>
                            Data Tamu
                        </h3>
                    </div>
                    <div class="col-md-12">
                        <div class="guest-info p-3">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <small class="text-muted d-block">Nama Lengkap</small>
                                    <strong>{{ $reservation->full_name }}</strong>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <small class="text-muted d-block">WhatsApp</small>
                                    <strong>{{ $reservation->phone }}</strong>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <small class="text-muted d-block">Email</small>
                                    <strong>{{ $reservation->email }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Permintaan Khusus - hanya jika ada -->
                @if($reservation->special_request)
                <div class="row mb-4">
                    <div class="col-12">
                        <h3 class="section-title">
                            <i class="fas fa-comment-dots me-2"></i>
                            Catatan
                        </h3>
                    </div>
                    <div class="col-12">
                        <div class="special-request p-3">
                            <i class="fas fa-quote-left me-1"></i>
                            {{ $reservation->special_request }}
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Total Pembayaran - lebih kompak -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center p-3" style="background: #f8f9fa; border-radius: 10px;">
                            <div>
                                <strong>Total Pembayaran</strong><br>
                                <small class="text-muted">{{ $reservation->rooms }} kamar x {{ $reservation->duration_days }} malam</small>
                            </div>
                            <div class="price-total px-4 py-2">
                                {{ $reservation->formatted_total_price }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Aksi - AKAN SEMBUNYI SAAT CETAK -->
                <div class="row btn-action mt-4">
                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('reservasi.inn.reservations.edit', $reservation->id) }}" class="btn btn-sm btn-warning btn-action">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reservation->phone) }}?text={{ urlencode('Halo ' . $reservation->full_name . ', Konfirmasi booking: ' . $reservation->booking_code) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-success btn-action">
                                    <i class="fab fa-whatsapp me-1"></i>WA
                                </a>
                            </div>
                            <div>
                                <button onclick="window.print()" class="btn btn-sm btn-outline-secondary btn-action btn-print">
                                    <i class="fas fa-print me-1"></i>Cetak
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-action" onclick="confirmDelete({{ $reservation->id }}, '{{ $reservation->booking_code }}')">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Delete (Hidden) -->
                <form id="delete-form-{{ $reservation->id }}" 
                      action="{{ route('reservasi.inn.reservations.destroy', $reservation->id) }}" 
                      method="POST" 
                      style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                
                <!-- Watermark untuk cetak - lebih minimalis -->
                <div class="print-watermark" style="display: none;">
                    <div>
                        {{ now()->format('d/m/Y H:i') }} | Legareca Inn
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function confirmDelete(id, bookingCode) {
            Swal.fire({
                title: 'Hapus Reservasi?',
                html: `Kode: <strong>${bookingCode}</strong>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
        
        // Auto hide alerts
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.remove();
            });
        }, 3000);

        // Watermark saat cetak
        window.onbeforeprint = function() {
            const watermark = document.querySelector('.print-watermark');
            if (watermark) watermark.style.display = 'block';
        };

        window.onafterprint = function() {
            const watermark = document.querySelector('.print-watermark');
            if (watermark) watermark.style.display = 'none';
        };
    </script>
</body>
</html>