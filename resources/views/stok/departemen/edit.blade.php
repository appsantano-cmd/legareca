<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($departemen) ? 'Edit' : 'Tambah' }} Departemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header" style="background: linear-gradient(135deg, #2196F3 0%, #0D47A1 100%); color: white;">
                        <h4 class="mb-0">
                            <i class="bi bi-building me-2"></i>{{ isset($departemen) ? 'Edit' : 'Tambah' }} Departemen
                        </h4>
                    </div>
                    
                    <div class="card-body">
                        <form action="{{route('departemen.update', $departemen) }}" method="POST">
                            @csrf
                            @if(isset($departemen))
                                @method('PUT')
                            @endif
                            
                            <div class="mb-3">
                                <label for="nama_departemen" class="form-label">Nama Departemen *</label>
                                <input type="text" class="form-control @error('nama_departemen') is-invalid @enderror" 
                                       id="nama_departemen" name="nama_departemen" 
                                       value="{{ old('nama_departemen', $departemen->nama_departemen ?? '') }}" 
                                       required>
                                @error('nama_departemen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('departemen.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>