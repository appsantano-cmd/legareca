<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konversi Satuan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #4cc9f0;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #333;
            line-height: 1.5;
        }
        
        .container {
            max-width: 1000px;
            padding-top: 1.5rem;
            padding-bottom: 2rem;
        }
        
        /* Header Styles */
        .main-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
        }
        
        .sync-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            padding: 8px 16px;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Form Container */
        .form-container {
            background-color: white;
            padding: 1.75rem;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .form-container:hover {
            box-shadow: var(--hover-shadow);
        }
        
        .form-header {
            border-bottom: 2px solid var(--light-bg);
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
        
        /* Card Styles */
        .main-card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        
        .main-card .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-bottom: none;
            padding: 1.25rem 1.5rem;
        }
        
        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            background-color: #f1f5fd;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: var(--secondary-color);
            padding: 1rem;
            white-space: nowrap;
        }
        
        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .table tbody tr {
            transition: background-color 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8faff;
        }
        
        /* Badge Styles */
        .badge-satuan {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .badge-input {
            background-color: #e3f2fd;
            color: #1565c0;
        }
        
        .badge-utama {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        /* Button Styles */
        .btn-action-group {
            display: flex;
            gap: 8px;
        }
        
        .btn-action {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(67, 97, 238, 0.3);
        }
        
        /* Footer Styles */
        .app-footer {
            background-color: white;
            padding: 1.25rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            margin-top: 1.5rem;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .main-header {
                padding: 1.25rem;
                text-align: center;
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .sync-indicator {
                align-self: center;
            }
            
            .form-container {
                padding: 1.25rem;
            }
            
            .table th, .table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.9rem;
            }
            
            .btn-action-group {
                flex-direction: column;
                gap: 4px;
            }
            
            .btn-action {
                width: 32px;
                height: 32px;
            }
        }
        
        @media (max-width: 576px) {
            .main-header h1 {
                font-size: 1.75rem;
            }
            
            .form-header h4 {
                font-size: 1.25rem;
            }
            
            .badge-satuan {
                font-size: 0.8rem;
                padding: 4px 8px;
            }
        }
        
        /* Animation for alerts */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Empty State */
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
            color: #6c757d;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #e9ecef;
        }
        
        /* Form labels */
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        /* Input focus effects */
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="main-header">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center header-content">
                <div>
                    <h1 class="mb-2 fw-bold">Manajemen Satuan</h1>
                    <p class="mb-0 opacity-90">Kelola data konversi satuan barang dengan mudah</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <span class="sync-indicator">
                        <i class="fas fa-sync-alt fa-spin"></i>
                        <span>Auto-sync Google Sheets Aktif</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Alert untuk pesan sukses/error -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-3 fa-lg"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                    <div>
                        <h6 class="mb-1">Terjadi Kesalahan</h6>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form Input/Edit -->
        <div class="form-container">
            <div class="form-header">
                <h4 class="mb-0 d-flex align-items-center">
                    <i class="fas {{ isset($satuan) ? 'fa-edit text-warning' : 'fa-plus-circle text-primary' }} me-3"></i>
                    {{ isset($satuan) ? 'Edit Satuan' : 'Tambah Satuan Baru' }}
                </h4>
                <p class="text-muted mb-0 mt-1">Isi formulir di bawah untuk {{ isset($satuan) ? 'mengubah' : 'menambahkan' }} data satuan</p>
            </div>
            
            <form method="POST" action="{{ isset($satuan) ? route('satuan.update', $satuan) : route('satuan.store') }}">
                @csrf
                @if(isset($satuan))
                    @method('PUT')
                @endif
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="satuan_input" class="form-label">
                            <i class="fas fa-ruler me-1 text-primary"></i>
                            Satuan Input <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-lg" id="satuan_input" name="satuan_input" 
                               value="{{ old('satuan_input', $satuan->satuan_input ?? '') }}" 
                               placeholder="Contoh: pcs, box, meter" required>
                        <div class="form-text mt-2">Satuan yang digunakan saat input data</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="satuan_utama" class="form-label">
                            <i class="fas fa-weight-hanging me-1 text-primary"></i>
                            Satuan Utama <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control form-control-lg" id="satuan_utama" name="satuan_utama" 
                               value="{{ old('satuan_utama', $satuan->satuan_utama ?? '') }}" 
                               placeholder="Contoh: kg, liter, pcs" required>
                        <div class="form-text mt-2">Satuan standar untuk perhitungan</div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="faktor" class="form-label">
                        <i class="fas fa-calculator me-1 text-primary"></i>
                        Faktor Konversi <span class="text-danger">*</span>
                    </label>
                    <input type="number" step="0.0001" class="form-control form-control-lg" id="faktor" name="faktor" 
                           value="{{ old('faktor', $satuan->faktor ?? '') }}" 
                           placeholder="Contoh: 0.001 untuk gram ke kilogram" required>
                    <div class="form-text mt-2">Faktor konversi dari satuan input ke satuan utama</div>
                </div>
                
                <div class="d-flex flex-column flex-md-row justify-content-end gap-3 mt-4">
                    @if(isset($satuan))
                        <a href="{{ route('satuan.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    @endif
                    <button type="submit" class="btn btn-primary-custom btn-lg px-5">
                        <i class="fas {{ isset($satuan) ? 'fa-sync-alt' : 'fa-save' }} me-2"></i>
                        {{ isset($satuan) ? 'Update & Sync' : 'Simpan & Sync' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Satuan -->
        <div class="main-card">
            <div class="card-header">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-list-check me-3"></i>
                    Daftar Satuan
                    <span class="badge bg-light text-primary ms-3">{{ $satuans->count() }} Data</span>
                </h5>
            </div>
            <div class="card-body p-0">
                @if($satuans->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-balance-scale empty-state-icon"></i>
                        <h4 class="mb-3">Belum ada data satuan</h4>
                        <p class="text-muted mb-4">Mulai dengan menambahkan satuan baru menggunakan formulir di atas.</p>
                        <a href="#form-container" class="btn btn-primary-custom">
                            <i class="fas fa-plus me-2"></i>Tambah Satuan Pertama
                        </a>
                    </div>
                @else
                    <div class="table-container">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="60">#</th>
                                    <th>
                                        <i class="fas fa-ruler me-2"></i>Satuan Input
                                    </th>
                                    <th>
                                        <i class="fas fa-weight-hanging me-2"></i>Satuan Utama
                                    </th>
                                    <th>
                                        <i class="fas fa-calculator me-2"></i>Faktor
                                    </th>
                                    <th>
                                        <i class="fas fa-calendar me-2"></i>Dibuat
                                    </th>
                                    <th width="120" class="text-center">
                                        <i class="fas fa-cog me-2"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($satuans as $index => $item)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge badge-satuan badge-input">{{ $item->satuan_input }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-satuan badge-utama">{{ $item->satuan_utama }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ number_format($item->faktor, 4) }}</span>
                                    </td>
                                    <td>
                                        <div class="text-muted">
                                            <small>{{ $item->created_at->format('d/m/Y') }}</small>
                                            <br>
                                            <small class="text-muted">{{ $item->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-action-group justify-content-center">
                                            <a href="{{ route('satuan.edit', $item) }}" 
                                               class="btn btn-warning btn-action" 
                                               title="Edit satuan">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('satuan.destroy', $item) }}" 
                                                  method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus satuan ini? Data akan dihapus dari sistem dan Google Sheets.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-action" 
                                                        title="Hapus satuan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-light py-3 px-4">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Total: {{ $satuans->count() }} satuan
                            </small>
                            <small class="text-muted mt-2 mt-md-0">
                                <i class="fas fa-sync-alt me-1"></i>
                                Data otomatis tersinkron ke Google Sheets
                            </small>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Info Footer -->
        <div class="app-footer">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <p class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        <strong>Informasi:</strong> Setiap perubahan data satuan akan otomatis tersinkron ke Google Sheets pada sheet "Konversi Satuan"
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alert setelah 5 detik
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Format input faktor dengan validasi
        const faktorInput = document.getElementById('faktor');
        if (faktorInput) {
            faktorInput.addEventListener('blur', function(e) {
                const value = parseFloat(e.target.value);
                if (!isNaN(value) && value >= 0.0001) {
                    e.target.value = value.toFixed(4);
                }
            });
        }

        // Validasi form sebelum submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const satuanInput = document.getElementById('satuan_input').value.trim();
                const satuanUtama = document.getElementById('satuan_utama').value.trim();
                const faktor = document.getElementById('faktor').value;

                if (!satuanInput || !satuanUtama || !faktor) {
                    e.preventDefault();
                    showAlert('warning', 'Peringatan', 'Semua field yang bertanda (*) wajib diisi!');
                    return false;
                }

                if (parseFloat(faktor) < 0.0001) {
                    e.preventDefault();
                    showAlert('warning', 'Peringatan', 'Faktor konversi harus lebih besar dari atau sama dengan 0.0001');
                    return false;
                }
                
                // Show loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                submitBtn.disabled = true;
            });
        }

        // Helper function untuk menampilkan alert custom
        function showAlert(type, title, message) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-${type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-3 fa-lg"></i>
                        <div>
                            <h6 class="mb-1">${title}</h6>
                            <p class="mb-0">${message}</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            // Tambahkan alert di atas form
            const formContainer = document.querySelector('.form-container');
            if (formContainer) {
                formContainer.insertAdjacentHTML('beforebegin', alertHtml);
                
                // Auto hide setelah 5 detik
                setTimeout(() => {
                    const newAlert = document.querySelector('.alert:last-child');
                    if (newAlert) {
                        const bsAlert = new bootstrap.Alert(newAlert);
                        bsAlert.close();
                    }
                }, 5000);
            }
        }

        // Smooth scroll ke form untuk empty state
        document.querySelectorAll('a[href="#form-container"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const formContainer = document.querySelector('.form-container');
                if (formContainer) {
                    formContainer.scrollIntoView({ behavior: 'smooth' });
                    // Highlight form dengan animasi
                    formContainer.style.transform = 'translateY(-5px)';
                    setTimeout(() => {
                        formContainer.style.transform = 'translateY(0)';
                    }, 300);
                }
            });
        });
    </script>
</body>
</html>