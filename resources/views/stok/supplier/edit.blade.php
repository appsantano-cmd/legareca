@extends('layouts.master')

@section('title', 'EDIT SUPPLIER')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0">
                            <i class="bi bi-pencil me-2"></i>Edit Supplier
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" id="supplierForm">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="bi bi-building me-2"></i>Informasi Supplier
                                </h5>

                                <!-- Informasi Sistem (Readonly) -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Dibuat</label>
                                        <input type="text" class="form-control bg-light" 
                                               value="{{ $supplier->created_at->format('d/m/Y H:i') }}" 
                                               readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status</label>
                                        <div>
                                            @if($supplier->deleted_at)
                                                <span class="badge bg-danger">Terhapus</span>
                                            @else
                                                <span class="badge bg-success">Aktif</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Nama Supplier -->
                                <div class="mb-3">
                                    <label for="nama_supplier" class="form-label required">Nama Supplier</label>
                                    <input type="text" name="nama_supplier" 
                                           class="form-control @error('nama_supplier') is-invalid @enderror"
                                           value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                                           placeholder="Masukkan nama supplier" 
                                           required
                                           id="nama_supplier">
                                    @error('nama_supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('supplier.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-2"></i>Update Supplier
                                    </button>
                                    @if(!$supplier->deleted_at)
                                        <button type="button" class="btn btn-danger" id="deleteBtn">
                                            <i class="bi bi-trash me-2"></i>Hapus
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>

                        <!-- Delete Form -->
                        @if(!$supplier->deleted_at)
                            <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" id="deleteForm" class="mt-3">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Focus on input
            document.getElementById('nama_supplier').focus();

            // Form validation
            document.getElementById('supplierForm').addEventListener('submit', function(e) {
                const namaSupplier = document.getElementById('nama_supplier').value.trim();
                
                if (!namaSupplier) {
                    e.preventDefault();
                    alert('Silakan isi nama supplier!');
                    document.getElementById('nama_supplier').focus();
                    return false;
                }

                // Confirm before submit
                if (!confirm(`Apakah Anda yakin ingin mengupdate supplier?\n\nNama Supplier Baru: ${namaSupplier}`)) {
                    e.preventDefault();
                    return false;
                }

                return true;
            });

            // Delete button
            const deleteBtn = document.getElementById('deleteBtn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    if (confirm(`Apakah Anda yakin ingin menghapus supplier ini?\n\nSupplier: {{ $supplier->nama_supplier }}\n\nCatatan: Data akan dihapus (soft delete) dan dapat dikembalikan nanti.`)) {
                        document.getElementById('deleteForm').submit();
                    }
                });
            }
        });
    </script>

    <style>
        .required::after {
            content: " *";
            color: #dc3545;
        }
        
        .bg-light {
            background-color: #f8f9fa !important;
        }
    </style>
@endsection