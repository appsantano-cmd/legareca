<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Cleaning Report - Step 1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-broom mr-2"></i>Daily Cleaning Report
                </h1>
                <p class="text-gray-600">Step 1: Personal Information</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('cleaning-report.storeStep1') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label for="nama" class="block font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user mr-2"></i>Nama *
                    </label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none"
                        placeholder="Your full name"
                        value="{{ old('nama') }}"
                    >
                </div>

                <div class="mb-8">
                    <label class="block font-semibold text-gray-700 mb-3">
                        <i class="fas fa-building mr-2"></i>Departemen *
                    </label>
                    
                    <div class="space-y-2">
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="departemen" value="Kitchen" class="mr-3" required 
                                   {{ old('departemen') == 'Kitchen' ? 'checked' : '' }}>
                            <i class="fas fa-utensils text-gray-600 mr-2"></i>
                            Kitchen
                        </label>
                        
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="departemen" value="Bar" class="mr-3"
                                   {{ old('departemen') == 'Bar' ? 'checked' : '' }}>
                            <i class="fas fa-glass-whiskey text-gray-600 mr-2"></i>
                            Bar
                        </label>
                        
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="departemen" value="Marcom" class="mr-3"
                                   {{ old('departemen') == 'Marcom' ? 'checked' : '' }}>
                            <i class="fas fa-bullhorn text-gray-600 mr-2"></i>
                            Marcom
                        </label>
                        
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="departemen" value="Server" class="mr-3"
                                   {{ old('departemen') == 'Server' ? 'checked' : '' }}>
                            <i class="fas fa-server text-gray-600 mr-2"></i>
                            Server
                        </label>
                        
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="departemen" value="Cleaning Staff" class="mr-3"
                                   {{ old('departemen') == 'Cleaning Staff' ? 'checked' : '' }}>
                            <i class="fas fa-hands-wash text-gray-600 mr-2"></i>
                            Cleaning Staff
                        </label>
                    </div>
                </div>

                <div class="mt-8">
                    <button 
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg flex items-center justify-center transition duration-200"
                    >
                        Next: Add Date & Photo
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>