<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Reservasi - Legareca Inn</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --primary-color: #264653;
            --secondary-color: #2a9d8f;
            --accent-color: #e76f51;
            --light-bg: #f8f9fa;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 20px;
        }
        
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .header-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: none;
        }
        
        .header-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        
        .header-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        .stats-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(42,157,143,0.3);
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
        }
        
        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .filter-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid #e9ecef;
        }
        
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .badge-status {
            padding: 8px 12px;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 8px;
            margin: 0 3px;
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .btn-view {
            background: #17a2b8;
            color: white;
        }
        
        .btn-edit {
            background: #ffc107;
            color: #000;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-wa {
            background: #25d366;
            color: white;
        }
        
        .pagination {
            margin-top: 20px;
            justify-content: center;
        }
        
        .page-link {
            color: var(--primary-color);
            border-radius: 8px;
            margin: 0 3px;
        }
        
        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #6c757d;
        }
        
        .search-box input {
            padding-left: 45px;
            border-radius: 30px;
            border: 2px solid #e9ecef;
        }
        
        .btn-filter {
            background: white;
            border: 2px solid var(--secondary-color);
            color: var(--secondary-color);
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 600;
        }
        
        .btn-filter:hover {
            background: var(--secondary-color);
            color: white;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 30px;
            padding: 10px 25px;
            color: white;
            font-weight: 600;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(42,157,143,0.4);
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
        }
        
        .empty-state i {
            font-size: 5rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        
        .empty-state h3 {
            color: #6c757d;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header Section -->
        <div class="header-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="header-title">
                        <i class="fas fa-hotel me-3" style="color: var(--secondary-color);"></i>
                        Manajemen Reservasi
                    </h1>
                    <p class="header-subtitle">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Kelola semua reservasi Legareca Inn dalam satu tempat
                    </p>
                </div>
                <div>
                    <a href="{{ route('reservasi.inn.home') }}" class="btn btn-primary-custom me-2">
                        <i class="fas fa-plus-circle me-2"></i>Reservasi Baru
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number">{{ $reservations->total() }}</div>
                            <div class="stats-label">Total Reservasi</div>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #2a9d8f, #219ebc);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number">{{ App\Models\Reservation::where('status', 'confirmed')->count() }}</div>
                            <div class="stats-label">Confirmed</div>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #e9c46a, #f4a261);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number">{{ App\Models\Reservation::where('status', 'pending')->count() }}</div>
                            <div class="stats-label">Pending</div>
                        </div>
                        <i class="fas fa-clock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card" style="background: linear-gradient(135deg, #e76f51, #e63946);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number">{{ App\Models\Reservation::whereDate('check_in', '=', now()->format('Y-m-d'))->count() }}</div>
                            <div class="stats-label">Check-in Hari Ini</div>
                        </div>
                        <i class="fas fa-sign-in-alt fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-card">
            <form action="{{ route('reservasi.inn.reservations.index') }}" method="GET" id="filterForm">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-search me-2"></i>Pencarian
                        </label>
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   placeholder="Cari kode booking, nama, email, no. WA..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-tag me-2"></i>Status
                        </label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar me-2"></i>Check-in
                        </label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-calendar me-2"></i>Check-out
                        </label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-filter">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                            <a href="{{ route('reservasi.inn.reservations.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-redo-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Hidden fields for sorting -->
                <input type="hidden" name="sort" id="sortField" value="{{ request('sort', 'created_at') }}">
                <input type="hidden" name="direction" id="sortDirection" value="{{ request('direction', 'desc') }}">
            </form>
        </div>
        
        <!-- Table Section -->
        <div class="table-container">
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
            
            @if($reservations->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h3>Belum Ada Reservasi</h3>
                    <p class="text-muted mb-4">Belum ada data reservasi yang tersedia.</p>
                    <a href="{{ route('reservasi.inn.home') }}" class="btn btn-primary-custom">
                        <i class="fas fa-plus-circle me-2"></i>Buat Reservasi Baru
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="12%">
                                    <a href="javascript:void(0)" onclick="sortTable('booking_code')" class="text-decoration-none text-dark">
                                        Kode Booking
                                        @if(request('sort') == 'booking_code')
                                            <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                        @else
                                            <i class="fas fa-sort text-muted"></i>
                                        @endif
                                    </a>
                                </th>
                                <th width="15%">Nama Tamu</th>
                                <th width="12%">Tipe Kamar</th>
                                <th width="10%">Check-in</th>
                                <th width="10%">Check-out</th>
                                <th width="10%">Total</th>
                                <th width="8%">Status</th>
                                <th width="18%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $index => $reservation)
                                <tr>
                                    <td>{{ $reservations->firstItem() + $index }}</td>
                                    <td>
                                        <span class="fw-bold" style="color: var(--primary-color);">
                                            {{ $reservation->booking_code }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $reservation->full_name }}</div>
                                        <small class="text-muted">{{ $reservation->phone }}</small>
                                    </td>
                                    <td>{{ $reservation->room_type }}</td>
                                    <td>{{ $reservation->check_in->format('d/m/Y') }}</td>
                                    <td>{{ $reservation->check_out->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="fw-bold text-success">
                                            {{ $reservation->formatted_total_price }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $reservation->status_badge_class }} badge-status">
                                            @switch($reservation->status)
                                                @case('pending')
                                                    <i class="fas fa-clock me-1"></i>Pending
                                                    @break
                                                @case('confirmed')
                                                    <i class="fas fa-check-circle me-1"></i>Confirmed
                                                    @break
                                                @case('cancelled')
                                                    <i class="fas fa-times-circle me-1"></i>Cancelled
                                                    @break
                                                @case('completed')
                                                    <i class="fas fa-flag-checkered me-1"></i>Completed
                                                    @break
                                            @endswitch
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="{{ route('reservasi.inn.reservations.show', $reservation->id) }}" 
                                               class="btn btn-sm action-btn btn-view" 
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <a href="{{ route('reservasi.inn.reservations.edit', $reservation->id) }}" 
                                               class="btn btn-sm action-btn btn-edit"
                                               title="Edit Reservasi">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reservation->phone) }}?text={{ urlencode('Halo ' . $reservation->full_name . ', Kami dari Legareca Inn ingin mengkonfirmasi reservasi Anda dengan kode booking: ' . $reservation->booking_code) }}" 
                                               target="_blank"
                                               class="btn btn-sm action-btn btn-wa"
                                               title="Hubungi via WhatsApp">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                            
                                            <button type="button" 
                                                    class="btn btn-sm action-btn btn-danger"
                                                    onclick="confirmDelete({{ $reservation->id }}, '{{ $reservation->booking_code }}')"
                                                    title="Hapus Reservasi">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            
                                            <div class="dropdown d-inline">
                                                <button class="btn btn-sm action-btn btn-secondary dropdown-toggle" 
                                                        type="button" 
                                                        data-bs-toggle="dropdown"
                                                        title="Ubah Status">
                                                    <i class="fas fa-tag"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus({{ $reservation->id }}, 'pending')">
                                                            <i class="fas fa-clock me-2 text-warning"></i>Pending
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus({{ $reservation->id }}, 'confirmed')">
                                                            <i class="fas fa-check-circle me-2 text-success"></i>Confirmed
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus({{ $reservation->id }}, 'cancelled')">
                                                            <i class="fas fa-times-circle me-2 text-danger"></i>Cancelled
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="updateStatus({{ $reservation->id }}, 'completed')">
                                                            <i class="fas fa-flag-checkered me-2 text-secondary"></i>Completed
                                                        </a>
                                                    </li>
                                                </ul>
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $reservations->firstItem() }} - {{ $reservations->lastItem() }} 
                        dari {{ $reservations->total() }} reservasi
                    </div>
                    <div>
                        {{ $reservations->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Function untuk sorting
        function sortTable(field) {
            let direction = 'asc';
            if ('{{ request('sort') }}' === field && '{{ request('direction') }}' === 'asc') {
                direction = 'desc';
            }
            document.getElementById('sortField').value = field;
            document.getElementById('sortDirection').value = direction;
            document.getElementById('filterForm').submit();
        }
        
        // Function untuk konfirmasi delete
        function confirmDelete(id, bookingCode) {
            Swal.fire({
                title: 'Hapus Reservasi?',
                html: `Anda akan menghapus reservasi dengan kode <strong>${bookingCode}</strong>.<br>Tindakan ini tidak dapat dibatalkan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
        
        // Function untuk update status via AJAX
        function updateStatus(id, status) {
            let statusText = status.charAt(0).toUpperCase() + status.slice(1);
            
            Swal.fire({
                title: 'Ubah Status',
                html: `Anda akan mengubah status reservasi menjadi <strong>${statusText}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2a9d8f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check me-2"></i>Ya, Ubah!',
                cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('reservasi/inn/reservations') }}/${id}/status`,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Gagal memperbarui status reservasi.',
                                icon: 'error',
                                confirmButtonColor: '#2a9d8f'
                            });
                        }
                    });
                }
            });
        }
        
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
        
        // Submit filter form when select changes
        $('select[name="status"]').change(function() {
            $('#filterForm').submit();
        });
        
        // Date range validation
        $('input[name="end_date"]').change(function() {
            let startDate = $('input[name="start_date"]').val();
            let endDate = $(this).val();
            
            if (startDate && endDate && endDate < startDate) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Tanggal check-out tidak boleh sebelum tanggal check-in',
                    icon: 'error',
                    confirmButtonColor: '#2a9d8f'
                });
                $(this).val('');
            }
        });
        
        // Prevent empty filter submission
        $('#filterForm').submit(function(e) {
            let search = $('input[name="search"]').val();
            let status = $('select[name="status"]').val();
            let startDate = $('input[name="start_date"]').val();
            let endDate = $('input[name="end_date"]').val();
            
            if (!search && !status && !startDate && !endDate) {
                window.location.href = '{{ route("reservasi.inn.reservations.index") }}';
                e.preventDefault();
            }
        });
    </script>
</body>
</html>