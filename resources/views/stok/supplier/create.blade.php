@extends('layouts.master')

@section('title', 'TAMBAH SUPPLIER BARU')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Supplier Baru
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('supplier.store') }}" method="POST" id="supplierForm">
                            @csrf

                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 mb-3">
                                    <i class="bi bi-building me-2"></i>Informasi Supplier
                                </h5>

                                <div class="mb-3">
                                    <label for="nama_supplier" class="form-label required">Nama Supplier</label>
                                    <input type="text" name="nama_supplier" 
                                           class="form-control @error('nama_supplier') is-invalid @enderror"
                                           value="{{ old('nama_supplier') }}"
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
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Simpan Supplier
                                </button>
                            </div>
                        </form>
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
                if (!confirm(`Apakah Anda yakin ingin menyimpan supplier?\n\nNama Supplier: ${namaSupplier}`)) {
                    e.preventDefault();
                    return false;
                }

                return true;
            });
        });
    </script>

    <style>
        .required::after {
            content: " *";
            color: #dc3545;
        }
    </style>
@endsection