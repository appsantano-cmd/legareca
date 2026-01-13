<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Cleaning Report - Step 1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .card {
            background: linear-gradient(145deg, #ffffff 0%, #f7f9fc 100%);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.15);
        }
        
        .logo-container {
            position: relative;
            display: inline-block;
        }
        
        .logo-container::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: white;
            border-radius: 2px;
        }
        
        .radio-option {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            background: white;
        }
        
        .radio-option:hover {
            border-color: #667eea;
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.1);
        }
        
        .radio-option input:checked + div {
            border-color: #667eea;
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            color: #667eea;
        }
        
        .radio-option input:checked + div i {
            color: #667eea;
        }
        
        .input-field {
            transition: all 0.3s ease;
            background: white;
            border: 2px solid #e2e8f0;
        }
        
        .input-field:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(-1px);
        }
        
        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-primary:hover::after {
            left: 100%;
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .step {
            display: flex;
            align-items: center;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 10px;
            position: relative;
            z-index: 2;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .step.active .step-number {
            background: white;
            color: #667eea;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
            border: 2px solid white;
        }
        
        .step-label {
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        
        .step-line {
            width: 80px;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
            margin: 0 10px;
            position: relative;
            top: -8px;
        }
        
        .animation-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        .animation-slide-up {
            animation: slideUp 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .error-card {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .departemen-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: rgba(102, 126, 234, 0.1);
            margin-right: 15px;
        }
    </style>
</head>
<body class="min-h-screen py-8 px-4 animation-fade-in">
    <div class="max-w-md mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8 animation-slide-up">
            <div class="logo-container mb-6">
                <div class="w-40 h-40 mx-auto bg-gradient-to-br from-blue-100 to-purple-100 rounded-full p-4 shadow-lg">
                    <div class="w-full h-full bg-white rounded-full p-4">
                        <img 
                            src="{{ asset('logo.png') }}" 
                            alt="Company Logo" 
                            class="w-full h-full object-contain rounded-full"
                            onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjEyMCIgdmlld0JveD0iMCAwIDEyMCAxMjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMjAiIGhlaWdodD0iMTIwIiByeD0iNjAiIGZpbGw9InVybCgjY2xvZ28tZ3JhZGllbnQpIi8+CjxwYXRoIGQ9Ik0zNSA0NUg4NU02NSA0NVY5ME00NSA2NUg4NSIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSI1IiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiLz4KPGRlZnM+CjxsaW5lYXJHcmFkaWVudCBpZD0iY2xvZ28tZ3JhZGllbnQiIHgxPSIwIiB5MT0iMCIgeDI9IjEyMCIgeTI9IjEyMCIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPgo8c3RvcCBzdG9wLWNvbG9yPSIjNjY3RUVBIi8+CjxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzc2NEJBMiIvPgo8L2xpbmVhckdyYWRpZW50Pgo8L2RlZnM+Cjwvc3ZnPgo=';"
                        >
                    </div>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">
                <i class="fas fa-broom mr-2"></i>Daily Cleaning Report
            </h1>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator animation-slide-up">
            <div class="step active">
                <div class="step-number">
                    <i class="fas fa-user"></i>
                </div>
                <span class="step-label">Personal Info</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-number">2</div>
                <span class="step-label">Date & Photo</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-number">3</div>
                <span class="step-label">Complete</span>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card p-6 mb-6 animation-slide-up" style="animation-delay: 0.1s">
            @if ($errors->any())
                <div class="error-card bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700 px-4 py-4 rounded-xl mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="font-semibold">Please fix the following errors:</p>
                            <ul class="mt-1 text-sm list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="error-card bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700 px-4 py-4 rounded-xl mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="font-semibold">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('cleaning-report.storeStep1') }}" method="POST" id="cleaningForm">
                @csrf
                
                <!-- Name Input -->
                <div class="mb-8 animation-slide-up" style="animation-delay: 0.2s">
                    <label for="nama" class="block font-semibold text-gray-700 mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-100 to-purple-100 flex items-center justify-center mr-3">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <span class="text-lg">Full Name *</span>
                                <p class="text-sm text-gray-500 font-normal mt-1">Enter your complete name as per records</p>
                            </div>
                        </div>
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            required
                            class="w-full px-5 py-4 input-field rounded-xl focus:outline-none"
                            placeholder="Enter your full name here"
                            value="{{ old('nama') }}"
                        >
                        <div class="absolute right-4 top-1/2 transform -translateY(1/2)">
                            <i class="fas fa-edit text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Department Selection -->
                <div class="mb-10 animation-slide-up" style="animation-delay: 0.3s">
                    <label class="block font-semibold text-gray-700 mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-100 to-purple-100 flex items-center justify-center mr-3">
                                <i class="fas fa-building text-blue-600"></i>
                            </div>
                            <div>
                                <span class="text-lg">Department *</span>
                                <p class="text-sm text-gray-500 font-normal mt-1">Select your working department</p>
                            </div>
                        </div>
                    </label>
                    
                    <div class="grid grid-cols-1 gap-3">
                        <label class="radio-option">
                            <input type="radio" name="departemen" value="Kitchen" class="hidden" required 
                                   {{ old('departemen') == 'Kitchen' ? 'checked' : '' }}>
                            <div class="flex items-center p-4 rounded-xl border-2 cursor-pointer">
                                <div class="departemen-icon">
                                    <i class="fas fa-utensils text-blue-600 text-lg"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">Kitchen</span>
                                    <p class="text-xs text-gray-500 mt-1">Food preparation & cooking area</p>
                                </div>
                                <div class="ml-auto">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                        <div class="w-3 h-3 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="radio-option">
                            <input type="radio" name="departemen" value="Bar" class="hidden"
                                   {{ old('departemen') == 'Bar' ? 'checked' : '' }}>
                            <div class="flex items-center p-4 rounded-xl border-2 cursor-pointer">
                                <div class="departemen-icon">
                                    <i class="fas fa-glass-whiskey text-purple-600 text-lg"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">Bar</span>
                                    <p class="text-xs text-gray-500 mt-1">Beverage service & drink preparation</p>
                                </div>
                                <div class="ml-auto">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                        <div class="w-3 h-3 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="radio-option">
                            <input type="radio" name="departemen" value="Marcom" class="hidden"
                                   {{ old('departemen') == 'Marcom' ? 'checked' : '' }}>
                            <div class="flex items-center p-4 rounded-xl border-2 cursor-pointer">
                                <div class="departemen-icon">
                                    <i class="fas fa-bullhorn text-green-600 text-lg"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">Marcom</span>
                                    <p class="text-xs text-gray-500 mt-1">Marketing & communications</p>
                                </div>
                                <div class="ml-auto">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                        <div class="w-3 h-3 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="radio-option">
                            <input type="radio" name="departemen" value="Server" class="hidden"
                                   {{ old('departemen') == 'Server' ? 'checked' : '' }}>
                            <div class="flex items-center p-4 rounded-xl border-2 cursor-pointer">
                                <div class="departemen-icon">
                                    <i class="fas fa-server text-orange-600 text-lg"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">Server</span>
                                    <p class="text-xs text-gray-500 mt-1">Customer service & table service</p>
                                </div>
                                <div class="ml-auto">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                        <div class="w-3 h-3 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="radio-option">
                            <input type="radio" name="departemen" value="Cleaning Staff" class="hidden"
                                   {{ old('departemen') == 'Cleaning Staff' ? 'checked' : '' }}>
                            <div class="flex items-center p-4 rounded-xl border-2 cursor-pointer">
                                <div class="departemen-icon">
                                    <i class="fas fa-hands-wash text-teal-600 text-lg"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">Cleaning Staff</span>
                                    <p class="text-xs text-gray-500 mt-1">Sanitation & maintenance team</p>
                                </div>
                                <div class="ml-auto">
                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                        <div class="w-3 h-3 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 hidden"></div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-10 animation-slide-up" style="animation-delay: 0.4s">
                    <button 
                        type="submit"
                        class="btn-primary w-full text-white font-semibold py-4 px-8 rounded-xl flex items-center justify-center transition duration-200 text-lg"
                        id="submitBtn"
                    >
                        <span class="flex items-center">
                            <i class="fas fa-arrow-right mr-3"></i>
                            Continue to Step 2
                        </span>
                        <div class="ml-2 text-sm opacity-90">Date & Photo Selection</div>
                    </button>
                    
                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Your information is secure and confidential
                        </p>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center text-white text-sm animation-slide-up" style="animation-delay: 0.5s">
            <p>© {{ date('Y') }} Legareca. All rights reserved.</p>
            <p class="mt-1 opacity-90">Step 1 of 3 - Personal Information</p>
        </div>
    </div>

    <script>
        // Animation for radio buttons
        document.querySelectorAll('.radio-option input').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove all checked states
                document.querySelectorAll('.radio-option input + div').forEach(div => {
                    div.classList.remove('border-blue-500', 'bg-blue-50');
                    div.querySelector('.w-3.h-3').classList.add('hidden');
                });
                
                // Add checked state to selected
                if (this.checked) {
                    const selectedDiv = this.nextElementSibling;
                    selectedDiv.classList.add('border-blue-500', 'bg-blue-50');
                    selectedDiv.querySelector('.w-3.h-3').classList.remove('hidden');
                }
            });
            
            // Trigger change on page load for pre-selected items
            if (radio.checked) {
                radio.dispatchEvent(new Event('change'));
            }
        });

        // Form submission animation
        document.getElementById('cleaningForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            btn.innerHTML = `
                <div class="flex items-center">
                    <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mr-3"></div>
                    Processing...
                </div>
            `;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            btn.disabled = true;
        });

        // Add hover effect for form inputs
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('mouseenter', function() {
                this.classList.add('shadow-md');
            });
            
            input.addEventListener('mouseleave', function() {
                this.classList.remove('shadow-md');
            });
        });

        // Add ripple effect to button
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            let ripple = document.createElement('span');
            ripple.classList.add('ripple');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.7);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>