<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Stok Station')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <!-- Font Awesome (tambahkan ini) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo" height="32">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Menu Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>

                    <!-- Menu Master Bahan Kitchen -->
                    @if (in_array(auth()->user()->role, ['admin', 'developer', 'staff']))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('master-kitchen*') ? 'active' : '' }}"
                                href="{{ route('master-kitchen.index') }}">
                                <i class="bi bi-egg-fried me-1"></i> Master Bahan Kitchen
                            </a>
                        </li>
                    @endif

                    <!-- Menu Master Bahan Bar -->
                    @if (in_array(auth()->user()->role, ['admin', 'developer', 'staff']))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('master-bar*') ? 'active' : '' }}"
                                href="{{ route('master-bar.index') }}">
                                <i class="bi bi-cup-straw me-1"></i> Master Bahan Bar
                            </a>
                        </li>
                    @endif

                    <!-- Menu Stok Harian Kitchen -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('stok-kitchen*') ? 'active' : '' }}"
                            href="{{ route('stok-kitchen.index') }}">
                            <i class="bi bi-egg me-1"></i> Stok Harian Kitchen
                        </a>
                    </li>

                    <!-- Menu Stok Harian Bar -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('stok-bar*') ? 'active' : '' }}"
                            href="{{ route('stok-bar.index') }}">
                            <i class="bi bi-cup me-1"></i> Stok Harian Bar
                        </a>
                    </li>

                    <!-- Menu Satuan -->
                    @if (in_array(auth()->user()->role, ['admin', 'developer']))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('satuan-station*') ? 'active' : '' }}"
                                href="{{ route('satuan-station.index') }}">
                                <i class="bi bi-box me-1"></i> Satuan
                            </a>
                        </li>
                    @endif
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // CSRF setup untuk AJAX
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        });
    </script>
    @stack('scripts')
</body>

</html>
