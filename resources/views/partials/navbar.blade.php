<nav class="bg-white shadow px-6 py-4">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between">
        <!-- Logo Section -->
        <div class="flex items-center space-x-3 mb-4 md:mb-0">
            <img src="{{ asset('storage/logo/logo.png') }}" alt="logo" class="h-10">
            <span class="text-xl font-bold text-gray-800">Legareca Space</span>
        </div>

        <!-- Desktop Navigation Menu -->
        <div class="hidden md:flex space-x-8">
            <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Beranda</a>
            <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Venue</a>
            <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Legareca Inn</a>
            <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Legareca Art Gallery</a>
            <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Legareca Pet</a>
            <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">HUBUNGI KAMI</a>
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
            <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden md:hidden mt-4 space-y-3">
        <a href="#" class="block text-gray-700 hover:text-blue-600 font-medium py-2">Beranda</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600 font-medium py-2">Venue</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600 font-medium py-2">Legareca Inn</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600 font-medium py-2">Legareca Art Gallery</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600 font-medium py-2">Legareca Pet</a>
        <a href="#" class="block text-gray-700 hover:text-blue-600 font-medium py-2">HUBUNGI KAMI</a>
    </div>
</nav>

<!-- JavaScript for mobile menu toggle -->
<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>