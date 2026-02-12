<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Le Gareca Space</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-shadow { box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08); }
        .input-focus:focus { box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15); }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }
        .logo-container { transition: transform 0.5s ease; }
        .logo-container:hover { transform: scale(1.05); }
        .back-link { transition: all 0.2s ease; }
        .back-link:hover {
            color: #1d4ed8;
            transform: translateX(-3px);
        }
    </style>
</head>
<body class="p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white rounded-2xl card-shadow overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-center">
                <div class="flex justify-center mb-6 logo-container">
                    <div class="w-24 h-24 rounded-full bg-white/10 backdrop-blur-sm border-4 border-white/30 flex items-center justify-center shadow-2xl">
                        <div class="relative w-20 h-20 bg-white rounded-full flex items-center justify-center overflow-hidden p-2">
                            <img id="logo-img" src="/logo.png" alt="Le Gareca Space Logo" 
                                 class="w-full h-full object-contain"
                                 onerror="this.style.display='none'; document.getElementById('logo-fallback').style.display='flex';">
                            <div id="logo-fallback" class="hidden w-full h-full items-center justify-center">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">LG</div>
                                    <div class="text-xs font-semibold text-blue-500 mt-1">SPACE</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Forgot Password</h1>
                <p class="text-blue-100">Reset your password instantly</p>
            </div>

            <div class="p-8">
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                        <div>
                            <p class="text-green-700 text-sm font-medium">Success!</p>
                            <p class="text-green-600 text-xs mt-1">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                        <div>
                            <p class="text-green-700 text-sm font-medium">Success!</p>
                            <p class="text-green-600 text-xs mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                        <div>
                            <p class="text-red-700 text-sm font-medium">Error!</p>
                            <p class="text-red-600 text-xs mt-1">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- INFO PENTING: GANTI TEKS INI -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
                    <div>
                        <p class="text-blue-800 text-sm font-medium">Instant Password Reset</p>
                        <p class="text-blue-600 text-xs mt-1">Enter your email below. If it exists in our database, you will be able to set a new password immediately. No email confirmation needed.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-500"></i>Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your registered email" required autofocus
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none focus:border-blue-500 transition duration-200 @error('email') border-red-500 @enderror">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mt-8">
                        <button type="submit"
                            class="w-full btn-primary text-white font-medium py-4 px-4 rounded-lg text-lg shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-check-circle mr-3"></i>Verify & Continue
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}"
                        class="back-link inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Sign In
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-8 text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Le Gareca Space. All rights reserved.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoImg = document.getElementById('logo-img');
            const logoFallback = document.getElementById('logo-fallback');

            fetch('/logo.png')
                .then(response => {
                    if (!response.ok) {
                        logoImg.style.display = 'none';
                        logoFallback.style.display = 'flex';
                    }
                })
                .catch(error => {
                    logoImg.style.display = 'none';
                    logoFallback.style.display = 'flex';
                });

            setTimeout(() => {
                document.getElementById('email').focus();
            }, 300);
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Verifying...';
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75');
        });
    </script>
</body>
</html>