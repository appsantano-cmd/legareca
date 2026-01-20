<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    @stack('styles')
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
