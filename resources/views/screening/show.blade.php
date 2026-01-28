<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Screening #{{ $screening->id }} - Le Gareca Space</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .badge-completed {
            background-color: #28a745;
            color: white;
        }
        
        .badge-cancelled {
            background-color: #dc3545;
            color: white;
        }
        
        .pet-card {
            border-left: 5px solid #667eea;
            margin-bottom: 20px;
        }
        
        .detail-label {
            font-weight: 600;
            color: #495057;
            width: 150px;
        }
        
        .detail-value {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('screening.index') }}">
                <i class="fas fa-arrow-left me-2"></i>
                Detail Screening
            </a>
            <span class="navbar-text">
                ID: #{{ $screening->id }}
            </span>
        </div>
    </nav>

    <div class="container">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('screening.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
            </a>
        </div>

        <!-- Owner Info Card -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>
                    Informasi Owner
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex mb-3">
                            <div class="detail-label">Nama Owner:</div>
                            <div class="detail-value">{{ $screening->owner_name }}</div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="detail-label">Nomor Telepon:</div>
                            <div class="detail-value">
                                <i class="fas fa-phone me-1 text-muted"></i>
                                {{ $screening->phone_number }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex mb-3">
                            <div class="detail-label">Tanggal Input:</div>
                            <div class="detail-value">
                                {{ $screening->created_at->setTimezone('Asia/Jakarta')->translatedFormat('l, j F Y H:i:s') }}
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="detail-label">Status:</div>
                            <div class="detail-value">
                                @if($screening->status == 'completed')
                                    <span class="badge badge-completed">
                                        <i class="fas fa-check me-1"></i>Selesai
                                    </span>
                                @else
                                    <span class="badge badge-cancelled">
                                        <i class="fas fa-times me-1"></i>Dibatalkan
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pets Info -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-paw me-2 text-primary"></i>
                    Data Pet ({{ $screening->pet_count }})
                </h5>
            </div>
            <div class="card-body">
                @foreach($screening->pets as $index => $pet)
                <div class="card pet-card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="mb-0">
                                <i class="fas fa-dog me-2" style="color: #667eea;"></i>
                                {{ $pet->name }}
                                <small class="text-muted">(Pet #{{ $index + 1 }})</small>
                            </h5>
                            <span class="badge bg-info">{{ $pet->status_text }}</span>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex mb-2">
                                    <div class="detail-label">Breed:</div>
                                    <div class="detail-value">{{ $pet->breed }}</div>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="detail-label">Jenis Kelamin:</div>
                                    <div class="detail-value">{{ $pet->sex }}</div>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="detail-label">Usia:</div>
                                    <div class="detail-value">{{ $pet->age }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex mb-2">
                                    <div class="detail-label">Status Vaksin:</div>
                                    <div class="detail-value">{{ $pet->vaksin }}</div>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="detail-label">Kutu:</div>
                                    <div class="detail-value">
                                        {{ $pet->kutu }}
                                        @if($pet->kutu_action)
                                            <span class="badge bg-warning ms-2">
                                                @if($pet->kutu_action == 'tidak_periksa')
                                                    Tidak Periksa
                                                @else
                                                    Lanjut Obat
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="detail-label">Jamur:</div>
                                    <div class="detail-value">{{ $pet->jamur }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="d-flex mb-2">
                                    <div class="detail-label">Birahi:</div>
                                    <div class="detail-value">
                                        {{ $pet->birahi }}
                                        @if($pet->birahi_action)
                                            <span class="badge bg-warning ms-2">
                                                @if($pet->birahi_action == 'tidak_periksa')
                                                    Tidak Periksa
                                                @else
                                                    Lanjut Obat
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="detail-label">Kulit:</div>
                                    <div class="detail-value">{{ $pet->kulit }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex mb-2">
                                    <div class="detail-label">Telinga:</div>
                                    <div class="detail-value">{{ $pet->telinga }}</div>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="detail-label">Riwayat Kesehatan:</div>
                                    <div class="detail-value">{{ $pet->riwayat }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mt-4 mb-4">
            <form action="{{ route('screening.destroy', $screening->id) }}" method="POST" onsubmit="return confirm('Hapus data screening ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Hapus Data
                </button>
            </form>
            
            <div>
                <a href="{{ route('screening.index') }}" class="btn btn-primary">
                    <i class="fas fa-list me-2"></i>Lihat Semua Data
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-muted mt-4 mb-4">
            <small>
                <i class="fas fa-shield-alt me-1"></i>
                Le Gareca Space &copy; {{ date('Y') }} | 
                Data ini bersifat rahasia dan hanya untuk keperluan internal
            </small>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Print functionality
        function printPage() {
            window.print();
        }
        
        // Auto-close alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>