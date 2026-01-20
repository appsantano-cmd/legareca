<!-- Navbar Baru -->
<nav class="fixed top-0 left-0 w-full z-30 nav-overlay">
    <div class="container flex items-center justify-between h-16">
        
        <!-- Logo -->
        <div class="text-xl font-bold text-white flex items-center gap-2">
            <span>Legareca Space</span>
        </div>
        
        <!-- Desktop Menu -->
        <div class="nav-menu hidden absolute top-full left-0 w-full bg-black text-white flex flex-col items-center gap-4 p-6 md:static md:w-auto md:bg-transparent md:flex md:flex-row md:items-center md:gap-8">
            <a href="{{ url('/') }}"
            class="nav-item text-white hover:text-red-500 transition {{ request()->is('/') ? 'active' : '' }}">
                Beranda
            </a>

            <a href="#venue"
            class="nav-item text-white hover:text-red-500 transition {{ request()->is('venue*') ? 'active' : '' }}">
                Venue
            </a>

            <a href="#inn"
            class="nav-item text-white hover:text-red-500 transition {{ request()->is('inn*') ? 'active' : '' }}">
                Legareca Inn
            </a>

            <a href="{{ url('/art-gallery') }}"
            class="nav-item text-white hover:text-red-500 transition {{ request()->is('art-gallery*') ? 'active' : '' }}">
                Legareca Art Gallery
            </a>

            <a href="#pet"
            class="nav-item text-white hover:text-red-500 transition {{ request()->is('pet*') ? 'active' : '' }}">
                Legareca Pet
            </a>
            <button class="nav-button text-white text-sm">
                Hubungi Kami
            </button>
        </div>
        
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
    </div>
</nav>
