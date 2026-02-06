@extends('layouts.stok_station')

@section('title', 'Master Bahan Bar')

@push('styles')
<style>
    .nav-link.active {
        font-weight: bold;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-cocktail me-2"></i> Master Bahan Bar</h4>
                    <div>
                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-file-export me-1"></i> Export
                        </button>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="fas fa-plus me-1"></i> Tambah Bahan
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Kode Bahan</th>
                                    <th>Nama Bahan</th>
                                    <th>Satuan</th>
                                    <th>Stok Minimum</th>
                                    <th>Status Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($masterBar as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                                    <td><span class="badge bg-secondary">{{ $item->kode_bahan }}</span></td>
                                    <td>{{ $item->nama_bahan }}</td>
                                    <td>{{ $item->nama_satuan }}</td>
                                    <td class="text-end">{{ number_format($item->stok_minimum, 2) }}</td>
                                    <td>
                                        @if($item->status_stok == 'SAFE')
                                            <span class="badge bg-success">SAFE</span>
                                        @else
                                            <span class="badge bg-danger">REORDER</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-warning" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal{{ $item->id }}"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $item->id }}"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ route('master-bar.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-edit me-2"></i>Edit Master Bahan Bar
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                                            <input type="date" class="form-control" 
                                                                   name="tanggal" 
                                                                   value="{{ $item->tanggal->format('Y-m-d') }}" 
                                                                   required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Kode Bahan <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" 
                                                                   name="kode_bahan" 
                                                                   value="{{ $item->kode_bahan }}" 
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Nama Bahan <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" 
                                                                   name="nama_bahan" 
                                                                   value="{{ $item->nama_bahan }}" 
                                                                   required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                                                            <select class="form-select" name="nama_satuan" required>
                                                                <option value="">Pilih Satuan</option>
                                                                @foreach($satuan as $s)
                                                                    <option value="{{ $s->nama_satuan }}" {{ $item->nama_satuan == $s->nama_satuan ? 'selected' : '' }}>
                                                                        {{ $s->nama_satuan }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Stok Minimum <span class="text-danger">*</span></label>
                                                            <input type="number" step="0.01" class="form-control" 
                                                                   name="stok_minimum" 
                                                                   value="{{ $item->stok_minimum }}" 
                                                                   required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i> Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save me-1"></i> Update
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('master-bar.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-danger">
                                                        <i class="fas fa-trash me-2"></i>Hapus Master Bahan
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus master bahan:</p>
                                                    <p><strong>{{ $item->nama_bahan }}</strong> ({{ $item->kode_bahan }})?</p>
                                                    <p class="text-danger">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Data yang sudah dihapus tidak dapat dikembalikan.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i> Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('master-bar.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Master Bahan Bar
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                   name="tanggal" 
                                   value="{{ old('tanggal', date('Y-m-d')) }}" 
                                   required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Bahan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_bahan') is-invalid @enderror" 
                                   name="kode_bahan" 
                                   value="{{ old('kode_bahan') }}" 
                                   required 
                                   placeholder="Contoh: B001, B002">
                            @error('kode_bahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Bahan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_bahan') is-invalid @enderror" 
                                   name="nama_bahan" 
                                   value="{{ old('nama_bahan') }}" 
                                   required 
                                   placeholder="Nama bahan lengkap">
                            @error('nama_bahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                            <select class="form-select @error('nama_satuan') is-invalid @enderror" name="nama_satuan" required>
                                <option value="">Pilih Satuan</option>
                                @foreach($satuan as $s)
                                    <option value="{{ $s->nama_satuan }}" {{ old('nama_satuan') == $s->nama_satuan ? 'selected' : '' }}>
                                        {{ $s->nama_satuan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nama_satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok Minimum <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('stok_minimum') is-invalid @enderror" 
                                   name="stok_minimum" 
                                   value="{{ old('stok_minimum') }}" 
                                   required 
                                   placeholder="0.00">
                            @error('stok_minimum')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto close alert setelah 5 detik
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endpush