<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @stack('styles')
</head>
<body class="@yield('body-class', 'bg-gray-100') min-h-screen">

    <main class="container mx-auto py-6">
        @yield('content')
    </main>

    {{-- Footer --}}
    @if (! View::hasSection('hide-footer'))
        @include('partials.footer')
    @endif

    @stack('scripts')
</body>
</html>
