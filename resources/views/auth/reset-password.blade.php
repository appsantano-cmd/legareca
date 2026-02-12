<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Le Gareca Space</title>
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
    </style>
</head>
<body class="p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white rounded-2xl card-shadow overflow-hidden">
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
                <h1 class="text-3xl font-bold text-white mb-2">Set New Password</h1>
                <p class="text-blue-100">Create a strong password</p>
            </div>

            <div class="p-8">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3"></i>
                            <div>
                                <p class="text-red-700 text-sm font-medium">Please fix the following errors:</p>
                                <ul class="list-disc list-inside text-red-600 text-xs mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
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

                <div class="mb-6 p-4 bg-blue-50 rounded-lg flex items-start">
                    <i class="fas fa-envelope text-blue-500 mt-0.5 mr-3"></i>
                    <div>
                        <p class="text-blue-800 text-sm font-medium">Resetting password for:</p>
                        <p class="text-blue-600 text-sm font-semibold mt-1">{{ $email }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">
                            <i class="fas fa-lock mr-2 text-blue-500"></i>New Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" 
                                placeholder="Min. 8 characters" required
                                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none focus:border-blue-500 transition duration-200">
                            <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center" data-target="password">
                                <i class="fas fa-eye text-gray-400 hover:text-blue-500"></i>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>Minimum 8 characters
                        </p>
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">
                            <i class="fas fa-check-circle mr-2 text-blue-500"></i>Confirm Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                placeholder="Re-enter new password" required
                                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none focus:border-blue-500 transition duration-200">
                            <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center" data-target="password_confirmation">
                                <i class="fas fa-eye text-gray-400 hover:text-blue-500"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" 
                            class="w-full btn-primary text-white font-medium py-4 px-4 rounded-lg text-lg shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-save mr-3"></i>Reset Password
                        </button>
                    </div>
                </form>
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

            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.dataset.target;
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            setTimeout(() => {
                document.getElementById('password').focus();
            }, 300);
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Resetting Password...';
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75');
        });
    </script>
</body>
</html>