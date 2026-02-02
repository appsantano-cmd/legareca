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
</head>

<body>
    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%); color: white;">
                        <h4 class="mb-0">
                            <i class="bi bi-truck me-2"></i>Daftar Supplier
                        </h4>
                        <a href="{{ route('supplier.create') }}" class="btn btn-light">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Supplier
                        </a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Search Bar (Simplified) -->
                        <div class="mb-3">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Supplier</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $startNumber = ($suppliers->currentPage() - 1) * $suppliers->perPage() + 1;
                                    @endphp
                                    @forelse($suppliers as $supplier)
                                        <tr>
                                            <td>{{ $startNumber++ }}</td>
                                            <td>{{ $supplier->nama_supplier }}</td>
                                            <td>{{ $supplier->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
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
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="bi bi-truck display-4 d-block mb-2"></i>
                                                @if(request('search'))
                                                    Tidak ada supplier ditemukan
                                                @else
                                                    Belum ada data supplier
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Simple Pagination -->
                        @if($suppliers->hasPages())
                        <div class="mt-3">
                            {{ $suppliers->withQueryString()->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@endsection