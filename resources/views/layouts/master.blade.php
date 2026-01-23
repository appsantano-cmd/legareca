<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Stok Gudang')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ url('/stok-gudang') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo" height="32">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Menu Stok Gudang -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('stok-gudang*') ? 'active' : '' }}"
                            href="{{ route('stok.index') }}">
                            <i class="bi bi-box-seam me-1"></i> Stok Gudang
                        </a>
                    </li>

                    <!-- Menu Transaksi Harian (BARU) -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}"
                            href="{{ route('transactions.index') }}">
                            <i class="bi bi-arrow-left-right me-1"></i> Transaksi Harian
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('departemen*') ? 'active' : '' }}"
                            href="{{ route('departemen.index') }}">
                            <i class="bi bi-diagram-3 me-1"></i> Departemen
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('satuan*') ? 'active' : '' }}"
                            href="{{ route('satuan.index') }}">
                            <i class="bi bi-box me-1"></i> Satuan
                        </a>
                    </li>

                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-file-earmark-excel me-2"></i>Export Data ke Excel
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('stok.export') }}" method="GET">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" name="start_date" class="form-control" required
                                value="{{ date('Y-m-01') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="form-control" required
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-download me-2"></i>Export Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // CSRF setup untuk AJAX (jika diperlukan)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
