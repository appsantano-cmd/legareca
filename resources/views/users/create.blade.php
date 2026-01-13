<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Baru - Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563 0%, #6b7280 100%);
            transform: translateY(-1px);
        }

        .role-badge {
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .role-badge-developer {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .role-badge-admin {
            background-color: #fef3c7;
            color: #92400e;
        }

        .role-badge-staff {
            background-color: #dcfce7;
            color: #166534;
        }

        .password-strength-meter {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .password-strength-weak {
            background-color: #ef4444;
            width: 25%;
        }

        .password-strength-fair {
            background-color: #f59e0b;
            width: 50%;
        }

        .password-strength-good {
            background-color: #3b82f6;
            width: 75%;
        }

        .password-strength-strong {
            background-color: #10b981;
            width: 100%;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Tambah User Baru</h1>
                        <p class="text-sm text-gray-600">Tambahkan user karyawan baru ke sistem</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm mr-3">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Card Form -->
            <div class="bg-white rounded-xl card-shadow overflow-hidden">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white mr-4">
                            <i class="fas fa-user-plus text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Form Tambah User Karyawan</h2>
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mx-8 mt-6">
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Terdapat {{ $errors->count() }} kesalahan yang perlu diperbaiki
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('users.store') }}" class="p-8">
                    @csrf

                    <!-- Nama Field -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-user text-blue-500 mr-2"></i>
                                Nama Lengkap
                            </span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none transition duration-200"
                                placeholder="Masukkan nama lengkap">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Nama lengkap sesuai identitas</p>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-envelope text-blue-500 mr-2"></i>
                                Alamat Email
                            </span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-at text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none transition duration-200"
                                placeholder="contoh@email.com">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Email yang valid dan aktif</p>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-lock text-blue-500 mr-2"></i>
                                Password
                            </span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none transition duration-200"
                                placeholder="Minimal 8 karakter">
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-blue-500"></i>
                            </button>
                        </div>
                        <div class="mt-2">
                            <div id="password-strength" class="password-strength-meter password-strength-weak"></div>
                            <div id="password-strength-text" class="text-xs text-gray-500 mt-1">Kekuatan password: Lemah
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-gray-500">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Minimal 8 karakter</li>
                                <li>Mengandung huruf besar dan kecil</li>
                                <li>Mengandung angka</li>
                                <li>Mengandung karakter khusus</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-8">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-lock text-blue-500 mr-2"></i>
                                Konfirmasi Password
                            </span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-redo text-gray-400"></i>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none transition duration-200"
                                placeholder="Ulangi password">
                            <button type="button" id="toggleConfirmPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-blue-500"></i>
                            </button>
                        </div>
                        <div id="password-match" class="hidden mt-2">
                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                            <span class="text-xs text-green-600">Password cocok</span>
                        </div>
                        <div id="password-mismatch" class="hidden mt-2">
                            <i class="fas fa-times-circle text-red-500 mr-1"></i>
                            <span class="text-xs text-red-600">Password tidak cocok</span>
                        </div>
                    </div>

                    <!-- Role Field -->
                    <div class="mb-8">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="flex items-center">
                                <i class="fas fa-user-tag text-blue-500 mr-2"></i>
                                Role / Posisi
                            </span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-briefcase text-gray-400"></i>
                            </div>
                            <select id="role" name="role" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg input-focus focus:outline-none transition duration-200 appearance-none">
                                <option value="">-- Pilih Role --</option>

                                @if(auth()->user()->role === 'developer')
                                    <option value="developer" {{ old('role') == 'developer' ? 'selected' : '' }}>
                                        Developer
                                    </option>
                                @endif

                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>

                                <option value="marcom" {{ old('role') == 'marcom' ? 'selected' : '' }}>
                                    MarCom
                                </option>

                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>
                                    Staff
                                </option>

                                <option value="guest" {{ old('role') == 'guest' ? 'selected' : '' }}>
                                    Guest
                                </option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('users.index') }}"
                            class="btn-secondary text-white font-medium py-3 px-6 rounded-lg text-center transition duration-200 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>
                            <span>Batal</span>
                        </a>
                        <button type="submit"
                            class="btn-primary text-white font-medium py-3 px-6 rounded-lg flex items-center justify-center transition duration-200">
                            <i class="fas fa-save mr-2"></i>
                            <span>Simpan User Baru</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
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

        // Toggle confirm password visibility
        document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const icon = this.querySelector('i');

            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const strengthMeter = document.getElementById('password-strength');
        const strengthText = document.getElementById('password-strength-text');
        const matchIndicator = document.getElementById('password-match');
        const mismatchIndicator = document.getElementById('password-mismatch');

        function checkPasswordStrength(password) {
            let strength = 0;

            // Length check
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;

            // Character variety check
            if (/[a-z]/.test(password)) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;

            // Update UI
            if (strength <= 2) {
                strengthMeter.className = 'password-strength-meter password-strength-weak';
                strengthText.textContent = 'Kekuatan password: Lemah';
                strengthText.className = 'text-xs text-red-600 mt-1';
            } else if (strength <= 4) {
                strengthMeter.className = 'password-strength-meter password-strength-fair';
                strengthText.textContent = 'Kekuatan password: Cukup';
                strengthText.className = 'text-xs text-yellow-600 mt-1';
            } else if (strength <= 5) {
                strengthMeter.className = 'password-strength-meter password-strength-good';
                strengthText.textContent = 'Kekuatan password: Baik';
                strengthText.className = 'text-xs text-blue-600 mt-1';
            } else {
                strengthMeter.className = 'password-strength-meter password-strength-strong';
                strengthText.textContent = 'Kekuatan password: Sangat Kuat';
                strengthText.className = 'text-xs text-green-600 mt-1';
            }
        }

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (!password || !confirmPassword) {
                matchIndicator.classList.add('hidden');
                mismatchIndicator.classList.add('hidden');
                return;
            }

            if (password === confirmPassword) {
                matchIndicator.classList.remove('hidden');
                mismatchIndicator.classList.add('hidden');
            } else {
                matchIndicator.classList.add('hidden');
                mismatchIndicator.classList.remove('hidden');
            }
        }

        // Event listeners
        passwordInput.addEventListener('input', function () {
            checkPasswordStrength(this.value);
            checkPasswordMatch();
        });

        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        // Form validation
        document.querySelector('form').addEventListener('submit', function (e) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                confirmPasswordInput.focus();
            }

            if (password.length < 8) {
                e.preventDefault();
                alert('Password harus minimal 8 karakter!');
                passwordInput.focus();
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            // Set focus on name field
            document.getElementById('name').focus();

            // Check if there are errors, scroll to form
            if (document.querySelector('.bg-red-50')) {
                window.scrollTo(0, document.querySelector('.bg-red-50').offsetTop - 20);
            }
        });
    </script>
</body>

</html>