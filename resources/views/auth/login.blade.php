<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Le Gareca Space</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .card-shadow {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }
        
        .logo-container {
            transition: transform 0.5s ease;
        }
        
        .logo-container:hover {
            transform: scale(1.05);
        }
        
        .forgot-link {
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }
        
        .forgot-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }
    </style>
</head>
<body class="p-4">
    <div class="w-full max-w-md mx-auto">
        <!-- Login Card -->
        <div class="bg-white rounded-2xl card-shadow overflow-hidden">
            <!-- Header Section with Logo -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-center">
                <div class="flex justify-center mb-6 logo-container">
                    <!-- Logo Container with Larger Size -->
                    <div class="w-24 h-24 rounded-full bg-white/10 backdrop-blur-sm border-4 border-white/30 flex items-center justify-center shadow-2xl">
                        <!-- Logo Image with Better Visibility -->
                        <div class="relative w-20 h-20 bg-white rounded-full flex items-center justify-center overflow-hidden p-2">
                            <!-- If logo.png exists, it will be displayed here -->
                            <img id="logo-img" src="/logo.png" alt="Le Gareca Space Logo" 
                                 class="w-full h-full object-contain"
                                 onerror="this.style.display='none'; document.getElementById('logo-fallback').style.display='flex';">
                            <!-- Fallback logo if logo.png doesn't exist -->
                            <div id="logo-fallback" class="hidden w-full h-full items-center justify-center">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">LG</div>
                                    <div class="text-xs font-semibold text-blue-500 mt-1">SPACE</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Le Gareca Space</h1>
                <p class="text-blue-100">Sign in to your account</p>
            </div>
            
            <!-- Login Form -->
            <form method="POST" action="/login" class="p-8">
                @csrf
                
                <!-- Email Input -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                        <i class="fas fa-envelope mr-2 text-blue-500"></i>Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            placeholder="you@example.com" 
                            required 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none focus:border-blue-500 transition duration-200"
                        >
                    </div>
                </div>
                
                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-medium mb-2">
                        <i class="fas fa-lock mr-2 text-blue-500"></i>Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key text-gray-400"></i>
                        </div>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            placeholder="Enter your password" 
                            required 
                            class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none focus:border-blue-500 transition duration-200"
                        >
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-gray-400 hover:text-blue-500"></i>
                        </button>
                    </div>
                    
                    <!-- Forgot Password Link - Pojok Kanan Bawah Password -->
                    <div class="flex justify-end mt-2">
                        <a href="/forgot-password" class="forgot-link text-blue-600 font-medium hover:text-blue-800 transition duration-200">
                            <i class="fas fa-key mr-1 text-xs"></i>Forgot Password?
                        </a>
                    </div>
                </div>
                
                <!-- Error Message -->
                @error('email')
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                        <div>
                            <p class="text-red-700 text-sm font-medium">{{ $message }}</p>
                            <p class="text-red-600 text-xs mt-1">Please check your email and try again</p>
                        </div>
                    </div>
                @enderror
            
                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="w-full btn-primary text-white font-medium py-4 px-4 rounded-lg text-lg shadow-lg hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-sign-in-alt mr-3"></i>Sign In to Your Account
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Le Gareca Space. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Form validation and interaction
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        
        emailInput.addEventListener('focus', function() {
            this.parentElement.classList.add('border-blue-500', 'shadow-md');
        });
        
        emailInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('border-blue-500', 'shadow-md');
        });
        
        passwordInput.addEventListener('focus', function() {
            this.parentElement.classList.add('border-blue-500', 'shadow-md');
        });
        
        passwordInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('border-blue-500', 'shadow-md');
        });
        
        // Handle logo loading
        document.addEventListener('DOMContentLoaded', function() {
            const logoImg = document.getElementById('logo-img');
            const logoFallback = document.getElementById('logo-fallback');
            
            // Check if logo exists
            fetch('/logo.png')
                .then(response => {
                    if (!response.ok) {
                        // Logo doesn't exist, show fallback
                        logoImg.style.display = 'none';
                        logoFallback.style.display = 'flex';
                    }
                })
                .catch(error => {
                    // Error loading logo, show fallback
                    logoImg.style.display = 'none';
                    logoFallback.style.display = 'flex';
                });
            
            // Auto-focus on email input
            setTimeout(() => {
                document.getElementById('email').focus();
            }, 300);
        });
        
        // Add some animation to the form
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Signing In...';
            submitBtn.disabled = true;
            submitBtn.classList.remove('hover:shadow-xl', 'transform', 'translateY(-2px)');
        });
    </script>
</body>
</html>