@extends('layouts.master')

@section('title', 'DAFTAR SUPPLIER')

@section('content')
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .card-header {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            color: white;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(33, 150, 243, 0.05);
        }
        
        .btn-light {
            background-color: white;
            color: #1976D2;
            border: 1px solid #ddd;
        }
        
        .btn-light:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 50rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-deleted {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }
        
        .empty-state-icon {
            font-size: 3.5rem;
            color: #6c757d;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-truck me-2"></i>Daftar Supplier
                        </h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('supplier.create') }}" class="btn btn-light">
                                <i class="bi bi-plus-circle me-1"></i>Tambah Supplier
                            </a>
                            @if(request()->has('show_deleted') && request('show_deleted') == 'true')
                                <a href="{{ route('supplier.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-eye me-1"></i>Tampilkan Aktif
                                </a>
                            @else
                                <a href="{{ route('supplier.index') }}?show_deleted=true" class="btn btn-secondary">
                                    <i class="bi bi-eye-slash me-1"></i>Tampilkan Terhapus
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                <div>{{ session('success') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <div>{{ session('error') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($suppliers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Nama Supplier</th>
                                            <th>Status</th>
                                            <th>Tanggal Dibuat</th>
                                            <th width="150">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($suppliers as $index => $supplier)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="fw-medium">{{ $supplier->nama_supplier }}</td>
                                                <td>
                                                    @if($supplier->deleted_at)
                                                        <span class="status-badge status-deleted">
                                                            <i class="bi bi-trash me-1"></i>Terhapus
                                                        </span>
                                                    @else
                                                        <span class="status-badge status-active">
                                                            <i class="bi bi-check-circle me-1"></i>Aktif
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $supplier->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        @if($supplier->deleted_at)
                                                            <form action="{{ route('supplier.restore', $supplier->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-sm btn-success" 
                                                                        title="Restore"
                                                                        onclick="return confirm('Restore supplier ini?')">
                                                                    <i class="bi bi-arrow-clockwise"></i>
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('supplier.forceDelete', $supplier->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                                        title="Hapus Permanen"
                                                                        onclick="return confirm('Hapus permanen supplier ini? Tindakan ini tidak dapat dibatalkan.')">
                                                                    <i class="bi bi-trash-fill"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="{{ route('supplier.edit', $supplier->id) }}" 
                                                               class="btn btn-sm btn-warning" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            
                                                            <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                                        title="Hapus"
                                                                        onclick="return confirm('Hapus supplier ini?')">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <h5 class="text-muted mb-3">
                                    @if(request()->has('show_deleted') && request('show_deleted') == 'true')
                                        Tidak ada supplier yang dihapus
                                    @else
                                        Belum ada data supplier
                                    @endif
                                </h5>
                                @if(request()->has('show_deleted') && request('show_deleted') == 'true')
                                    <a href="{{ route('supplier.index') }}" class="btn btn-primary">
                                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Supplier Aktif
                                    </a>
                                @else
                                    <a href="{{ route('supplier.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i>Tambah Supplier Pertama
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>

</html>
@endsection