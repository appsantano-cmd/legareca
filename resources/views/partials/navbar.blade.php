<nav class="fixed top-0 left-0 w-full z-30 nav-overlay">
    <div class="container mx-auto flex items-center justify-between h-16 px-6">
        
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3">
            <img 
                src="{{ asset('images/logo.png') }}" 
                alt="Legareca Space Logo"
                class="h-10 w-auto object-contain nav-logo"
            >
        </a>
        
        <!-- Desktop Menu -->
        <div class="nav-menu hidden md:flex items-center gap-8">
            <a href="/" class="nav-item">Beranda</a>
            <a href="/cafe-resto" class="nav-item">Le Gareca Cafe & Resto</a>
            <a href="/halamanvenue" class="nav-item">Venue</a>
            <a href="/kami-daur" class="nav-item">KAMI DAUR</a>
            <a href="/reservasi" class="nav-item">Le Gareca Inn</a>
            <a href="/art-gallery" class="nav-item">Art Gallery</a>
            <a href="/lega-pet-care" class="nav-item">Lega Pet Care</a>

            <button class="nav-button">
                Hubungi Kami
            </button>
        </div>

        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn md:hidden text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
    </div>
</nav>
