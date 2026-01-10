<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Cleaning Report - Step 1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .radio-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            min-height: 56px;
            flex: 1;
            text-align: center;
        }
        .radio-label:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        input[type="radio"]:checked + .radio-label {
            border-color: #3b82f6;
            background-color: #eff6ff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .required::after {
            content: ' *';
            color: #ef4444;
        }
        .radio-container {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .radio-item {
            flex: 1;
            min-width: 120px;
        }
        .logo-container {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-center mb-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        1
                    </div>
                    <div class="w-24 h-1 bg-blue-600"></div>
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold">
                        2
                    </div>
                </div>
            </div>
            <div class="flex justify-center text-sm text-gray-600">
                <div class="mr-16 font-semibold text-blue-600">Personal Information</div>
                <div>Upload Details</div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Logo di Tengah -->
            <div class="logo-container flex justify-center items-center mb-8">
                <img 
                    src="/logo.png" 
                    alt="Company Logo" 
                    class="h-32 w-auto max-w-xs"
                    onerror="this.style.display='none'; document.getElementById('logoFallback').style.display='flex';"
                >
                <div id="logoFallback" class="hidden items-center justify-center h-32 w-32 bg-blue-100 rounded-full">
                    <i class="fas fa-building text-blue-600 text-4xl"></i>
                </div>
            </div>

            <!-- Judul Form -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-broom mr-2"></i>Daily Cleaning Report
                </h1>
                <p class="text-gray-600">Please fill in your information to start the report</p>
                <p class="text-red-500 text-sm mt-2">All fields are required</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cleaning-report.storeStep1') }}" method="POST" id="cleaningForm">
                @csrf
                
                <!-- Nama Field -->
                <div class="mb-8">
                    <label for="nama" class="block text-lg font-semibold text-gray-700 mb-3 required">
                        <i class="fas fa-user mr-2"></i>Nama
                    </label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none transition duration-200"
                        placeholder="Enter your full name"
                        value="{{ old('nama') }}"
                    >
                    @error('nama')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Departments - HORIZONTAL RADIO BUTTONS (Single Selection) -->
                <div class="mb-8">
                    <label class="block text-lg font-semibold text-gray-700 mb-4 required">
                        <i class="fas fa-building mr-2"></i>Departemen
                    </label>
                    
                    <div class="radio-container">
                        <!-- Kitchen -->
                        <div class="radio-item">
                            <input type="radio" id="dept-kitchen" name="department" value="Kitchen" class="hidden" required {{ old('department') == 'Kitchen' ? 'checked' : '' }}>
                            <label for="dept-kitchen" class="radio-label">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-utensils text-gray-600 text-xl mb-2"></i>
                                    <span class="text-gray-700 text-sm font-medium">Kitchen</span>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Bar -->
                        <div class="radio-item">
                            <input type="radio" id="dept-bar" name="department" value="Bar" class="hidden" {{ old('department') == 'Bar' ? 'checked' : '' }}>
                            <label for="dept-bar" class="radio-label">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-glass-whiskey text-gray-600 text-xl mb-2"></i>
                                    <span class="text-gray-700 text-sm font-medium">Bar</span>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Marcom -->
                        <div class="radio-item">
                            <input type="radio" id="dept-marcom" name="department" value="Marcom" class="hidden" {{ old('department') == 'Marcom' ? 'checked' : '' }}>
                            <label for="dept-marcom" class="radio-label">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-bullhorn text-gray-600 text-xl mb-2"></i>
                                    <span class="text-gray-700 text-sm font-medium">Marcom</span>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Server -->
                        <div class="radio-item">
                            <input type="radio" id="dept-server" name="department" value="Server" class="hidden" {{ old('department') == 'Server' ? 'checked' : '' }}>
                            <label for="dept-server" class="radio-label">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-server text-gray-600 text-xl mb-2"></i>
                                    <span class="text-gray-700 text-sm font-medium">Server</span>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Cleaning Staff -->
                        <div class="radio-item">
                            <input type="radio" id="dept-cleaning" name="department" value="Cleaning Staff" class="hidden" {{ old('department') == 'Cleaning Staff' ? 'checked' : '' }}>
                            <label for="dept-cleaning" class="radio-label">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-hands-wash text-gray-600 text-xl mb-2"></i>
                                    <span class="text-gray-700 text-sm font-medium">Cleaning Staff</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    @error('department')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button 
                        type="submit"
                        id="submitBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg flex items-center transition duration-200 transform hover:scale-105 shadow-md"
                    >
                        Next
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('cleaningForm');
            const namaInput = document.getElementById('nama');
            const submitBtn = document.getElementById('submitBtn');
            
            // Radio button styling
            const radioLabels = document.querySelectorAll('.radio-label');
            radioLabels.forEach(label => {
                label.addEventListener('click', function() {
                    // Remove selected style from all
                    radioLabels.forEach(l => {
                        l.classList.remove('border-blue-500', 'bg-blue-50');
                    });
                    // Add selected style to clicked
                    this.classList.add('border-blue-500', 'bg-blue-50');
                });
            });
            
            // Set initial selected state
            const checkedRadio = document.querySelector('input[type="radio"]:checked');
            if (checkedRadio) {
                const label = checkedRadio.nextElementSibling;
                if (label && label.classList.contains('radio-label')) {
                    label.classList.add('border-blue-500', 'bg-blue-50');
                }
            }
            
            // Form validation
            form.addEventListener('submit', function(e) {
                // Simple validation
                const nama = namaInput.value.trim();
                const departmentSelected = document.querySelector('input[name="department"]:checked');
                
                let isValid = true;
                
                // Validate nama
                if (!nama) {
                    namaInput.classList.add('border-red-500');
                    isValid = false;
                } else {
                    namaInput.classList.remove('border-red-500');
                }
                
                // Validate department
                if (!departmentSelected) {
                    // Highlight all radio labels if none selected
                    radioLabels.forEach(label => {
                        label.classList.add('border-red-500');
                    });
                    isValid = false;
                } else {
                    radioLabels.forEach(label => {
                        label.classList.remove('border-red-500');
                    });
                }
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields');
                } else {
                    // Change button to loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
                }
            });
            
            // Remove error styling on input
            namaInput.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('border-red-500');
                }
            });
            
            // Remove error styling on radio selection
            const radioInputs = document.querySelectorAll('input[name="department"]');
            radioInputs.forEach(radio => {
                radio.addEventListener('change', function() {
                    radioLabels.forEach(label => {
                        label.classList.remove('border-red-500');
                    });
                });
            });
            
            // Handle logo error - show fallback if logo doesn't exist
            const logo = document.querySelector('img[src="/logo.png"]');
            if (logo) {
                logo.onerror = function() {
                    this.style.display = 'none';
                    document.getElementById('logoFallback').style.display = 'flex';
                };
            }
        });
    </script>
</body>
</html>