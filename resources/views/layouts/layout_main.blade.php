<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Legareca Space')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Vite --}}
    @vite([
        'resources/css/public.css',
        'resources/js/public.js'
    ])
    
    {{-- Stack untuk page-specific styles --}}
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
            background-color: #f8fafc;
            color: #333;
            padding-top: 0 !important;
        }
        
        /* Pastikan konten tidak tertutup navbar */
        main {
            min-height: calc(100vh - 200px); /* Sesuaikan dengan tinggi footer */
            padding-top: 4rem; /* Sesuaikan dengan tinggi navbar */
        }
        
        /* Override untuk navbar agar tidak double */
        nav.navbar {
            display: none !important;
        }
        
        /* Navbar baru styling */
        .legareca-navbar {
            z-index: 9999;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid #e53e3e;
        }
        
        /* Logo styling */
        .logo-img {
            height: 40px;
            width: auto;
            transition: transform 0.3s ease;
        }
        
        .logo-img:hover {
            transform: scale(1.05);
        }
        
        /* Nav link styling */
        .nav-link-custom {
            position: relative;
            color: white !important;
            font-weight: 500;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }
        
        .nav-link-custom:hover {
            color: #fbb6ce !important;
        }
        
        .nav-link-custom.active {
            color: #fbb6ce !important;
        }
        
        .nav-link-custom.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 16px;
            right: 16px;
            height: 2px;
            background-color: #fbb6ce;
        }
        
        /* Mobile menu button */
        .mobile-menu-btn {
            color: white;
            padding: 8px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        
        .mobile-menu-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        /* Footer styling */
        .main-footer {
            background-color: #1a202c;
            color: #cbd5e0;
            border-top: 1px solid #2d3748;
        }
        
        .footer-link {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-link:hover {
            color: white;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            main {
                padding-top: 3.5rem;
            }
            
            .logo-img {
                height: 35px;
            }
        }
        
        /* Animations */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="antialiased text-gray-800">
    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="animate-fade-in">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Stack untuk page-specific scripts -->
    @stack('scripts')
</body>
</html>