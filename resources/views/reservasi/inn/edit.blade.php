<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservasi - {{ $reservation->booking_code }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
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
        
        .edit-container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .edit-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            overflow: hidden;
            border: none;
        }
        
        .edit-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 25px 30px;
        }
        
        .edit-body {
            padding: 40px;
        }
        
        .booking-code {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        
        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid var(--secondary-color);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(42,157,143,0.25);
        }
        
        .input-group-text {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 10px 0 0 10px;
            padding: 12px 15px;
        }
        
        .btn-save {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(42,157,143,0.4);
            color: white;
        }
        
        .btn-cancel {
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 12px 35px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-cancel:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .room-option-card {
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 15px;
        }
        
        .room-option-card:hover {
            border-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(42,157,143,0.2);
        }
        
        .room-option-card.selected {
            border-color: var(--secondary-color);
            background: rgba(42,157,143,0.05);
            box-shadow: 0 0 0 3px rgba(42,157,143,0.2);
        }
        
        .summary-card {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .alert-custom {
            border-left: 4px solid var(--secondary-color);
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <!-- Tombol Kembali -->
        <div class="mb-4">
            <a href="{{ route('reservasi.inn.reservations.show', $reservation->id) }}" class="btn btn-light">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
            </a>
        </div>
        
        <div class="edit-card">
            <!-- Header -->
            <div class="edit-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="booking-code">
                            <i class="fas fa-edit me-2"></i>Edit Reservasi
                        </div>
                        <p class="mb-0 opacity-75">
                            Kode Booking: <strong>{{ $reservation->booking_code }}</strong>
                        </p>
                    </div>
                    <div>
                        <span class="badge {{ $reservation->status_badge_class }} status-badge">
                            @switch($reservation->status)
                                @case('pending')
                                    <i class="fas fa-clock me-2"></i>PENDING
                                    @break
                                @case('confirmed')
                                    <i class="fas fa-check-circle me-2"></i>CONFIRMED
                                    @break
                                @case('cancelled')
                                    <i class="fas fa-times-circle me-2"></i>CANCELLED
                                    @break
                                @case('completed')
                                    <i class="fas fa-flag-checkered me-2"></i>COMPLETED
                                    @break
                            @endswitch
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Body -->
            <div class="edit-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Terjadi Kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <form action="{{ route('reservasi.inn.reservations.update', $reservation->id) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Input Hidden -->
                    <input type="hidden" id="selectedRoomType" name="room_type" value="{{ $reservation->room_type }}">
                    <input type="hidden" id="selectedRoomPrice" name="room_price" value="{{ $reservation->room_price }}">
                    
                    <!-- Pilihan Kamar -->
                    <div class="mb-5">
                        <h3 class="section-title">
                            <i class="fas fa-bed me-2" style="color: var(--secondary-color);"></i>
                            Pilih Tipe Kamar
                        </h3>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="room-option-card {{ $reservation->room_type == 'Standard Room' ? 'selected' : '' }}" 
                                     data-room="Standard Room" 
                                     data-price="350000"
                                     onclick="selectRoom(this)">
                                    <div class="text-center">
                                        <i class="fas fa-bed fa-3x mb-3" style="color: var(--primary-color);"></i>
                                        <h6 class="fw-bold mb-2">Standard Room</h6>
                                        <p class="text-success fw-bold mb-2">Rp 350.000</p>
                                        <small class="text-muted">Kamar standar dengan fasilitas lengkap</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="room-option-card {{ $reservation->room_type == 'Deluxe Room' ? 'selected' : '' }}"
                                     data-room="Deluxe Room" 
                                     data-price="550000"
                                     onclick="selectRoom(this)">
                                    <div class="text-center">
                                        <i class="fas fa-star fa-3x mb-3" style="color: var(--primary-color);"></i>
                                        <h6 class="fw-bold mb-2">Deluxe Room</h6>
                                        <p class="text-success fw-bold mb-2">Rp 550.000</p>
                                        <small class="text-muted">Kamar premium dengan balkon</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="room-option-card {{ $reservation->room_type == 'Family Suite' ? 'selected' : '' }}"
                                     data-room="Family Suite" 
                                     data-price="850000"
                                     onclick="selectRoom(this)">
                                    <div class="text-center">
                                        <i class="fas fa-users fa-3x mb-3" style="color: var(--primary-color);"></i>
                                        <h6 class="fw-bold mb-2">Family Suite</h6>
                                        <p class="text-success fw-bold mb-2">Rp 850.000</p>
                                        <small class="text-muted">Suite keluarga dengan 2 kamar</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tanggal Menginap -->
                    <div class="mb-4">
                        <h3 class="section-title">
                            <i class="fas fa-calendar-alt me-2" style="color: var(--secondary-color);"></i>
                            Tanggal Menginap
                        </h3>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="checkIn" class="form-label">
                                    <i class="fas fa-sign-in-alt me-2"></i>Tanggal Check-in
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="date" 
                                           class="form-control" 
                                           id="checkIn" 
                                           name="check_in" 
                                           value="{{ $reservation->check_in->format('Y-m-d') }}"
                                           required 
                                           min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="checkOut" class="form-label">
                                    <i class="fas fa-sign-out-alt me-2"></i>Tanggal Check-out
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    <input type="date" 
                                           class="form-control" 
                                           id="checkOut" 
                                           name="check_out" 
                                           value="{{ $reservation->check_out->format('Y-m-d') }}"
                                           required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Jumlah Tamu & Kamar -->
                    <div class="mb-4">
                        <h3 class="section-title">
                            <i class="fas fa-user-friends me-2" style="color: var(--secondary-color);"></i>
                            Detail Reservasi
                        </h3>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="guests" class="form-label">
                                    <i class="fas fa-user me-2"></i>Jumlah Tamu
                                </label>
                                <select class="form-select" id="guests" name="guests" required>
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}" {{ $reservation->guests == $i ? 'selected' : '' }}>
                                            {{ $i }} Orang
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rooms" class="form-label">
                                    <i class="fas fa-door-closed me-2"></i>Jumlah Kamar
                                </label>
                                <select class="form-select" id="rooms" name="rooms" required>
                                    @for($i = 1; $i <= 3; $i++)
                                        <option value="{{ $i }}" {{ $reservation->rooms == $i ? 'selected' : '' }}>
                                            {{ $i }} Kamar
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Informasi Tamu -->
                    <div class="mb-4">
                        <h3 class="section-title">
                            <i class="fas fa-user me-2" style="color: var(--secondary-color);"></i>
                            Informasi Tamu
                        </h3>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullName" class="form-label">
                                    <i class="fas fa-user-circle me-2"></i>Nama Lengkap
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="fullName" 
                                           name="full_name" 
                                           value="{{ old('full_name', $reservation->full_name) }}"
                                           required 
                                           placeholder="Nama sesuai KTP">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fab fa-whatsapp me-2"></i>Nomor WhatsApp
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fab fa-whatsapp"></i>
                                    </span>
                                    <input type="tel" 
                                           class="form-control" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', $reservation->phone) }}"
                                           required 
                                           placeholder="628xxxxxxxxxx">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Alamat Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $reservation->email) }}"
                                       required 
                                       placeholder="email@anda.com">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Reservasi -->
                    <div class="mb-4">
                        <h3 class="section-title">
                            <i class="fas fa-tag me-2" style="color: var(--secondary-color);"></i>
                            Status Reservasi
                        </h3>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="status" class="form-label">
                                    <i class="fas fa-flag me-2"></i>Pilih Status
                                </label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>
                                        <i class="fas fa-clock"></i> Pending - Menunggu Konfirmasi
                                    </option>
                                    <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>
                                        <i class="fas fa-check-circle"></i> Confirmed - Terkonfirmasi
                                    </option>
                                    <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>
                                        <i class="fas fa-times-circle"></i> Cancelled - Dibatalkan
                                    </option>
                                    <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>
                                        <i class="fas fa-flag-checkered"></i> Completed - Selesai
                                    </option>
                                </select>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Ubah status untuk mengupdate kondisi reservasi
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Permintaan Khusus -->
                    <div class="mb-4">
                        <h3 class="section-title">
                            <i class="fas fa-comment-dots me-2" style="color: var(--secondary-color);"></i>
                            Permintaan Khusus
                        </h3>
                        
                        <div class="mb-3">
                            <textarea class="form-control" 
                                      id="specialRequest" 
                                      name="special_request" 
                                      rows="4" 
                                      placeholder="Contoh: Kamar lantai atas, peringatan anniversary, makanan khusus, dll.">{{ old('special_request', $reservation->special_request) }}</textarea>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Isi jika ada permintaan khusus untuk kenyamanan tamu
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ringkasan & Total -->
                    <div class="summary-card mb-4">
                        <h5 class="fw-bold mb-3" style="color: var(--primary-color);">
                            <i class="fas fa-receipt me-2"></i>Ringkasan Reservasi
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-muted">Tipe Kamar:</td>
                                        <td class="fw-bold" id="summaryRoom">{{ $reservation->room_type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Harga per Malam:</td>
                                        <td class="fw-bold text-success" id="summaryPrice">{{ $reservation->formatted_room_price }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Durasi:</td>
                                        <td class="fw-bold" id="summaryDuration">{{ $reservation->duration_days }} Malam</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-muted">Jumlah Kamar:</td>
                                        <td class="fw-bold" id="summaryRooms">{{ $reservation->rooms }} Kamar</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Check-in:</td>
                                        <td class="fw-bold" id="summaryCheckIn">{{ $reservation->check_in->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Check-out:</td>
                                        <td class="fw-bold" id="summaryCheckOut">{{ $reservation->check_out->format('d/m/Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0" style="color: var(--primary-color);">TOTAL PEMBAYARAN</span>
                            <span class="h3 mb-0 fw-bold" style="color: var(--secondary-color);" id="summaryTotal">
                                {{ $reservation->formatted_total_price }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Informasi Penting -->
                    <div class="alert alert-custom mb-4">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x" style="color: var(--secondary-color);"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-2" style="color: var(--primary-color);">Informasi Penting:</h6>
                                <ul class="mb-0 text-muted">
                                    <li>Perubahan data reservasi akan langsung tersimpan di sistem</li>
                                    <li>Pastikan semua data yang diinput sudah benar</li>
                                    <li>Untuk perubahan status, pilih status yang sesuai dengan kondisi terkini</li>
                                    <li>Total harga akan otomatis menyesuaikan dengan perubahan data</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tombol Submit -->
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('reservasi.inn.reservations.index') }}" class="btn btn-cancel">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-save" id="submitBtn">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Initialize date pickers
        flatpickr("#checkIn, #checkOut", {
            locale: "id",
            minDate: "today",
            dateFormat: "Y-m-d"
        });
        
        // Function untuk memilih kamar
        function selectRoom(element) {
            // Remove selected class from all room options
            document.querySelectorAll('.room-option-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked element
            element.classList.add('selected');
            
            // Get room data
            let roomType = element.dataset.room;
            let roomPrice = element.dataset.price;
            
            // Update hidden inputs
            document.getElementById('selectedRoomType').value = roomType;
            document.getElementById('selectedRoomPrice').value = roomPrice;
            
            // Update summary
            updateSummary();
        }
        
        // Function untuk update summary
        function updateSummary() {
            let roomType = document.getElementById('selectedRoomType').value;
            let roomPrice = document.getElementById('selectedRoomPrice').value;
            let checkIn = document.getElementById('checkIn').value;
            let checkOut = document.getElementById('checkOut').value;
            let rooms = document.getElementById('rooms').value;
            
            // Format price
            let price = parseInt(roomPrice.replace(/[^0-9]/g, ''));
            let formattedPrice = 'Rp ' + price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            
            // Update summary text
            document.getElementById('summaryRoom').textContent = roomType || '-';
            document.getElementById('summaryPrice').textContent = formattedPrice;
            
            // Calculate duration
            if (checkIn && checkOut) {
                let start = new Date(checkIn);
                let end = new Date(checkOut);
                let diffTime = Math.abs(end - start);
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                document.getElementById('summaryDuration').textContent = diffDays + ' Malam';
                document.getElementById('summaryCheckIn').textContent = formatDate(checkIn);
                document.getElementById('summaryCheckOut').textContent = formatDate(checkOut);
                
                // Calculate total
                let total = price * diffDays * parseInt(rooms);
                document.getElementById('summaryTotal').textContent = 'Rp ' + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            
            document.getElementById('summaryRooms').textContent = rooms + ' Kamar';
        }
        
        // Function untuk format tanggal
        function formatDate(dateString) {
            let date = new Date(dateString);
            let day = date.getDate().toString().padStart(2, '0');
            let month = (date.getMonth() + 1).toString().padStart(2, '0');
            let year = date.getFullYear();
            return day + '/' + month + '/' + year;
        }
        
        // Validate check-out date
        document.getElementById('checkOut').addEventListener('change', function() {
            let checkIn = document.getElementById('checkIn').value;
            let checkOut = this.value;
            
            if (checkIn && checkOut && checkOut <= checkIn) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Tanggal check-out harus setelah tanggal check-in',
                    icon: 'error',
                    confirmButtonColor: '#2a9d8f'
                });
                this.value = '';
            } else {
                updateSummary();
            }
        });
        
        // Event listeners for form changes
        document.getElementById('checkIn').addEventListener('change', updateSummary);
        document.getElementById('rooms').addEventListener('change', updateSummary);
        document.getElementById('guests').addEventListener('change', function() {
            let guests = parseInt(this.value);
            let roomOptions = document.querySelectorAll('.room-option-card');
            
            // Validate guest count against room type
            let selectedRoom = document.querySelector('.room-option-card.selected');
            if (selectedRoom) {
                let roomType = selectedRoom.dataset.room;
                let maxGuests = 2;
                
                if (roomType === 'Family Suite') {
                    maxGuests = 4;
                }
                
                if (guests > maxGuests) {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Jumlah tamu melebihi kapasitas maksimal kamar ini',
                        icon: 'warning',
                        confirmButtonColor: '#2a9d8f'
                    });
                }
            }
        });
        
        // Form submission confirmation
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: 'Anda akan menyimpan perubahan data reservasi ini',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2a9d8f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-save me-2"></i>Ya, Simpan!',
                cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
        
        // Initialize summary on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSummary();
        });
        
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>