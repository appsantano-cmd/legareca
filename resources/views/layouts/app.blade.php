<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Le Gareca Space')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS (TAMBAHKAN INI) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    
    @stack('styles')
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #1a5f7a;
            --secondary-color: #2a9d8f;
            --accent-color: #e76f51;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            padding-top: 0 !important; /* Hapus padding untuk navbar fixed */
        }
        
        .main-header {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-top {
            background-color: var(--primary-color);
        }
        
        .logo-img {
            height: 40px;
            width: auto;
        }
        
        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 10px 15px;
        }
        
        .navbar-nav .nav-link.active {
            color: var(--accent-color) !important;
        }
        
        .main-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        
        /* Override Bootstrap Navbar default styles */
        nav.navbar {
            display: none !important;
        }
        
        /* Pastikan navbar baru muncul di atas */
        .fixed {
            z-index: 9999 !important;
        }
    </style>
</head>
<body class="@yield('body-class', 'bg-gray-100') min-h-screen">

    {{-- Navbar hanya muncul jika halaman minta --}}
    @if (! View::hasSection('hide-navbar'))
         @include('partials.navbar')
    @endif

    <main class="container mx-auto py-6 pt-20">
        @yield('content')
    </main>

    {{-- Footer --}}
    @if (! View::hasSection('hide-footer'))
        @include('partials.footer')
    @endif

    @stack('scripts')
</body>
</html>