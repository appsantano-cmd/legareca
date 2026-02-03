<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXPORT TRANSAKSI STOK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .card-header {
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
        }

        .export-form-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .info-box {
            background-color: #e8f5e9;
            border-left: 4px solid #4CAF50;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .date-range-picker {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-file-earmark-excel me-2"></i>Export Data Transaksi Stok
                        </h4>
                    </div>

                    <div class="card-body">
                        <!-- Flash Messages -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Info Box -->
                        <div class="info-box">
                            <h6><i class="bi bi-info-circle me-2"></i>Informasi Export</h6>
                            <ul class="mb-0">
                                <li>Export akan menghasilkan file Excel (.xlsx) dengan format yang sudah disesuaikan
                                </li>
                                <li>Data yang diexport meliputi semua kolom transaksi</li>
                                <li>Filter berdasarkan tanggal dan tipe transaksi bersifat opsional</li>
                                <li>Jika tidak memilih tanggal, semua data akan diexport</li>
                            </ul>
                        </div>

                        <!-- Export Form -->
                        <div class="export-form-container">
                            <form action="{{ route('transactions.export') }}" method="POST" target="_blank">
                                @csrf

                                <div class="date-range-picker mb-4">
                                    <h6 class="mb-3"><i class="bi bi-calendar-range me-2"></i>Filter Tanggal</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Mulai</label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ old('start_date') }}"
                                                placeholder="Pilih tanggal mulai (opsional)">
                                            <small class="text-muted">Kosongkan untuk mengambil semua data dari
                                                awal</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Akhir</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ old('end_date') }}"
                                                placeholder="Pilih tanggal akhir (opsional)">
                                            <small class="text-muted">Kosongkan untuk mengambil semua data hingga
                                                sekarang</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Filter Tipe Transaksi -->
                                <div class="mb-4">
                                    <h6 class="mb-3"><i class="bi bi-funnel me-2"></i>Filter Tipe Transaksi</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="tipe"
                                                    id="tipe_all" value="" checked>
                                                <label class="form-check-label" for="tipe_all">
                                                    <i class="bi bi-arrow-left-right me-1"></i> Semua Tipe (Masuk &
                                                    Keluar)
                                                </label>
                                            </div>
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="radio" name="tipe"
                                                    id="tipe_masuk" value="masuk">
                                                <label class="form-check-label" for="tipe_masuk">
                                                    <i class="bi bi-box-arrow-in-down me-1"></i> Stok Masuk Saja
                                                </label>
                                            </div>
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="radio" name="tipe"
                                                    id="tipe_keluar" value="keluar">
                                                <label class="form-check-label" for="tipe_keluar">
                                                    <i class="bi bi-box-arrow-up me-1"></i> Stok Keluar Saja
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="alert alert-info">
                                                <i class="bi bi-lightbulb me-2"></i>
                                                <strong>Tips:</strong><br>
                                                • Pilih "Semua Tipe" untuk export data lengkap<br>
                                                • Pilih tipe tertentu untuk fokus analisis
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Button Group -->
                                <div class="d-flex justify-content-between mt-4">
                                    <div>
                                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left me-2"></i>Kembali
                                        </a>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-file-earmark-excel me-2"></i>Export ke Excel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="alert alert-warning mt-4">
                            <h6><i class="bi bi-exclamation-triangle me-2"></i>Perhatian</h6>
                            <ul class="mb-0">
                                <li>Proses export mungkin memerlukan waktu beberapa saat tergantung jumlah data</li>
                                <li>Pastikan koneksi internet stabil selama proses export</li>
                                <li>File Excel akan otomatis terdownload setelah proses selesai</li>
                                <li>Data yang diexport adalah data yang sudah tersimpan di database</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set tanggal default untuk kemudahan
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            const firstDayOfMonth = new Date(new Date().getFullYear(), new Date().getMonth(), 2)
                .toISOString().split('T')[0];

            // Set tanggal default jika belum ada nilai
            const startDateInput = document.querySelector('input[name="start_date"]');
            const endDateInput = document.querySelector('input[name="end_date"]');

            if (startDateInput && !startDateInput.value) {
                startDateInput.value = firstDayOfMonth;
            }

            if (endDateInput && !endDateInput.value) {
                endDateInput.value = today;
            }

            // Validasi form sebelum submit
            document.querySelector('form').addEventListener('submit', function(e) {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);

                    if (start > end) {
                        e.preventDefault();
                        alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir!');
                        startDateInput.focus();
                        return false;
                    }
                }

                // Konfirmasi sebelum export
                if (!confirm('Apakah Anda yakin ingin mengexport data dengan filter yang dipilih?')) {
                    e.preventDefault();
                    return false;
                }

                // Tampilkan loading
                const submitBtn = document.querySelector('button[type="submit"]');

                return true;
            });
        });
    </script>
</body>

</html>
