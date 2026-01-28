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
    
    <!-- Animate.css untuk animasi -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS untuk Bootstrap agar bekerja dengan Tailwind -->
    <style>
        /* Reset Tailwind untuk Bootstrap Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 99999;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            overflow-y: auto;
            outline: 0;
        }
        
        .modal.show {
            display: block;
        }
        
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 99998;
            width: 100vw;
            height: 100vh;
            background-color: #000;
        }
        
        .modal-backdrop.show {
            opacity: 0.5;
        }
        
        .modal-dialog {
            position: relative;
            width: auto;
            margin: 0.5rem;
            pointer-events: none;
        }
        
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translate(0, -50px);
        }
        
        .modal.show .modal-dialog {
            transform: none;
        }
        
        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.3rem;
            outline: 0;
        }
        
        /* Pastikan body tidak scroll saat modal terbuka */
        body.modal-open {
            overflow: hidden;
            padding-right: 17px; /* Untuk kompensasi scrollbar hilang */
        }
        
        /* Fix untuk body padding karena navbar fixed */
        body {
            padding-top: 0 !important;
        }
        
        /* Navbar baru */
        .fixed {
            z-index: 9999 !important;
        }
        
        /* Atur main content */
        main {
            position: relative;
            z-index: 1;
        }
    </style>
    
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

    <!-- Bootstrap JS Bundle dengan Popper - HARUS ADA -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Manual Bootstrap Modal Fix Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Bootstrap modal fix loaded');
            
            // Fix untuk Bootstrap Modal dengan Tailwind
            const initModalFix = () => {
                const modals = document.querySelectorAll('.modal');
                
                modals.forEach(modal => {
                    // Handle show modal
                    modal.addEventListener('show.bs.modal', function() {
                        console.log('Modal showing...');
                        this.classList.add('show');
                        this.style.display = 'block';
                        
                        // Add backdrop
                        const backdrop = document.createElement('div');
                        backdrop.className = 'modal-backdrop fade show';
                        backdrop.style.zIndex = '99998';
                        document.body.appendChild(backdrop);
                        
                        // Prevent body scrolling
                        document.body.classList.add('modal-open');
                        document.body.style.overflow = 'hidden';
                        document.body.style.paddingRight = '17px';
                    });
                    
                    // Handle hide modal
                    modal.addEventListener('hide.bs.modal', function() {
                        console.log('Modal hiding...');
                        this.classList.remove('show');
                        this.style.display = 'none';
                        
                        // Remove backdrop
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                        
                        // Restore body scrolling
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    });
                });
                
                // Close modal dengan tombol close
                document.querySelectorAll('[data-bs-dismiss="modal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const modalId = this.closest('.modal').id;
                        const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
                        if (modal) modal.hide();
                    });
                });
            };
            
            // Initialize modal fix
            initModalFix();
            
            // Debug: Check semua tombol booking
            const bookingButtons = document.querySelectorAll('[data-bs-target="#bookingModal"]');
            console.log('Found booking buttons:', bookingButtons.length);
            
            bookingButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    console.log('Booking button clicked:', {
                        target: this.getAttribute('data-bs-target'),
                        room: this.getAttribute('data-room'),
                        price: this.getAttribute('data-price')
                    });
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>