<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Stok Station</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dashboard-card {
            transition: transform 0.3s;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Sistem Stok Station</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('satuan-station*') ? 'active' : '' }}"
                            href="{{ route('satuan-station.index') }}">Satuan</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('master-*') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown">
                            Master Bahan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->is('master-kitchen*') ? 'active' : '' }}"
                                    href="{{ route('master-kitchen.index') }}">Kitchen</a></li>
                            <li><a class="dropdown-item {{ request()->is('master-bar*') ? 'active' : '' }}"
                                    href="{{ route('master-bar.index') }}">Bar</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('stok-*') ? 'active' : '' }}" href="#"
                            role="button" data-bs-toggle="dropdown">
                            Stok Harian
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->is('stok-kitchen*') ? 'active' : '' }}"
                                    href="{{ route('stok-kitchen.index') }}">Kitchen</a></li>
                            <li><a class="dropdown-item {{ request()->is('stok-bar*') ? 'active' : '' }}"
                                    href="{{ route('stok-bar.index') }}">Bar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">Dashboard Sistem Stok Station</h2>

        <div class="row g-4 mb-5">
            <div class="col-md-2">
                <div class="card dashboard-card bg-primary text-white">
                    <div class="card-body text-center">
                        <div class="card-icon mb-3">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h5 class="card-title">Satuan</h5>
                        <p class="stat-number">{{ \App\Models\SatuanStation::count() }}</p>
                        <a href="{{ route('satuan-station.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-right"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card dashboard-card bg-warning text-dark">
                    <div class="card-body text-center">
                        <div class="card-icon mb-3">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h5 class="card-title">Master Kitchen</h5>
                        <p class="stat-number">{{ \App\Models\StokStationMasterKitchen::count() }}</p>
                        <a href="{{ route('master-kitchen.index') }}" class="btn btn-dark btn-sm">
                            <i class="fas fa-arrow-right"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="card dashboard-card bg-info text-white">
                    <div class="card-body text-center">
                        <div class="card-icon mb-3">
                            <i class="fas fa-cocktail"></i>
                        </div>
                        <h5 class="card-title">Master Bar</h5>
                        <p class="stat-number">{{ \App\Models\StokStationMasterBar::count() }}</p>
                        <a href="{{ route('master-bar.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-right"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card dashboard-card bg-success text-white">
                    <div class="card-body text-center">
                        <div class="card-icon mb-3">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h5 class="card-title">Stok Kitchen</h5>
                        <p class="stat-number">{{ \App\Models\StokKitchen::count() }}</p>
                        <a href="{{ route('stok-kitchen.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-right"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card dashboard-card bg-danger text-white">
                    <div class="card-body text-center">
                        <div class="card-icon mb-3">
                            <i class="fas fa-cocktail"></i>
                        </div>
                        <h5 class="card-title">Stok Bar</h5>
                        <p class="stat-number">{{ \App\Models\StokBar::count() }}</p>
                        <a href="{{ route('stok-bar.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-right"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Stok REORDER</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @php
                                // Stok REORDER dari master kitchen
                                $stokOrderKitchen = \App\Models\StokStationMasterKitchen::where(
                                    'status_stok',
                                    'REORDER',
                                )
                                    ->with('satuan')
                                    ->take(5)
                                    ->get();

                                // Stok REORDER dari master bar
                                $stokOrderBar = \App\Models\StokStationMasterBar::where('status_stok', 'REORDER')
                                    ->with('satuan')
                                    ->take(5)
                                    ->get();
                            @endphp

                            @if ($stokOrderKitchen->count() > 0)
                                <h6 class="mb-2">Kitchen:</h6>
                                @foreach ($stokOrderKitchen as $item)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $item->nama_bahan }}</h6>
                                            <small class="text-danger">REORDER</small>
                                        </div>
                                        <p class="mb-1">
                                            <small>Kode: {{ $item->kode_bahan }} |
                                                Stok: {{ number_format($item->stok_awal, 2) }}
                                                {{ $item->satuan->nama_satuan }} |
                                                Minimum: {{ number_format($item->stok_minimum, 2) }}</small>
                                        </p>
                                    </div>
                                @endforeach
                            @endif

                            @if ($stokOrderBar->count() > 0)
                                <h6 class="mb-2 mt-3">Bar:</h6>
                                @foreach ($stokOrderBar as $item)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $item->nama_bahan }}</h6>
                                            <small class="text-danger">REORDER</small>
                                        </div>
                                        <p class="mb-1">
                                            <small>Kode: {{ $item->kode_bahan }} |
                                                Stok: {{ number_format($item->stok_awal, 2) }}
                                                {{ $item->satuan->nama_satuan }} |
                                                Minimum: {{ number_format($item->stok_minimum, 2) }}</small>
                                        </p>
                                    </div>
                                @endforeach
                            @endif

                            @if ($stokOrderKitchen->count() == 0 && $stokOrderBar->count() == 0)
                                <div class="text-center py-3">
                                    <p class="text-muted mb-0">Tidak ada stok yang harus diorder</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-history"></i> Aktivitas Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @php
                                $recentKitchen = \App\Models\StokKitchen::latest()
                                    ->with(['masterBahan', 'satuan'])
                                    ->take(3)
                                    ->get();

                                $recentBar = \App\Models\StokBar::latest()
                                    ->with(['masterBahan', 'satuan'])
                                    ->take(3)
                                    ->get();
                            @endphp

                            @if ($recentKitchen->count() > 0)
                                <h6 class="mb-2">Kitchen:</h6>
                                @foreach ($recentKitchen as $item)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $item->masterBahan->nama_bahan }}</h6>
                                            <small>{{ $item->tanggal->format('d/m') }}</small>
                                        </div>
                                        <p class="mb-1">
                                            <small>Shift: {{ $item->shift }} | PIC: {{ $item->pic }}</small>
                                        </p>
                                    </div>
                                @endforeach
                            @endif

                            @if ($recentBar->count() > 0)
                                <h6 class="mb-2 mt-3">Bar:</h6>
                                @foreach ($recentBar as $item)
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $item->masterBahan->nama_bahan }}</h6>
                                            <small>{{ $item->tanggal->format('d/m') }}</small>
                                        </div>
                                        <p class="mb-1">
                                            <small>Shift: {{ $item->shift }} | PIC: {{ $item->pic }}</small>
                                        </p>
                                    </div>
                                @endforeach
                            @endif

                            @if ($recentKitchen->count() == 0 && $recentBar->count() == 0)
                                <div class="text-center py-2">
                                    <p class="text-muted mb-0">Belum ada aktivitas stok</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 text-center">
            <div class="btn-group">
                <a href="{{ route('satuan-station.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-balance-scale"></i> Kelola Satuan
                </a>
                <a href="{{ route('master-kitchen.index') }}" class="btn btn-outline-warning">
                    <i class="fas fa-utensils"></i> Master Kitchen
                </a>
                <a href="{{ route('master-bar.index') }}" class="btn btn-outline-info">
                    <i class="fas fa-cocktail"></i> Master Bar
                </a>
                <a href="{{ route('stok-kitchen.index') }}" class="btn btn-outline-success">
                    <i class="fas fa-utensils"></i> Stok Kitchen
                </a>
                <a href="{{ route('stok-bar.index') }}" class="btn btn-outline-danger">
                    <i class="fas fa-cocktail"></i> Stok Bar
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
