<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Complete</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center py-8">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg p-8 text-center">
        @if(session('success'))
            <div class="mb-6">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-500 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Report Submitted Successfully!</h2>
                <p class="text-gray-600">Your daily cleaning report has been saved.</p>
            </div>
        @endif

        <!-- Report Summary -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
            <h3 class="font-semibold text-gray-700 mb-3">Report Summary:</h3>
            <ul class="space-y-2">
                <li class="flex items-center">
                    <i class="fas fa-user text-blue-500 mr-2"></i>
                    <span><strong>Name:</strong> {{ $report->nama }}</span>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-calendar text-blue-500 mr-2"></i>
                    <span><strong>Date:</strong> {{ $report->membership_datetime->format('m/d/Y H:i') }}</span>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-building text-blue-500 mr-2"></i>
                    <span><strong>Departments:</strong> 
                        @foreach(json_decode($report->departments) as $dept)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">{{ $dept }}</span>
                        @endforeach
                    </span>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-camera text-blue-500 mr-2"></i>
                    <span><strong>Photo Uploaded:</strong> Yes</span>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-clock text-blue-500 mr-2"></i>
                    <span><strong>Submitted:</strong> {{ $report->created_at->format('H:i') }}</span>
                </li>
            </ul>
        </div>

        <!-- Photo Preview (if available) -->
        @if($report->toilet_photo_path)
            <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-3">Uploaded Photo:</h4>
                <div class="border-2 border-gray-300 rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $report->toilet_photo_path) }}" 
                         alt="Toilet Photo" 
                         class="w-full h-64 object-cover">
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ route('cleaning-report.create') }}" 
               class="block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                <i class="fas fa-plus-circle mr-2"></i>Create New Report
            </a>
            
            <a href="{{ route('cleaning-report.index') }}" 
               class="block bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                <i class="fas fa-list mr-2"></i>View All Reports
            </a>
            
            <button onclick="window.print()" 
                    class="w-full bg-white border-2 border-gray-300 hover:bg-gray-50 text-gray-800 font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                <i class="fas fa-print mr-2"></i>Print Report
            </button>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-500">
                <i class="fas fa-info-circle mr-1"></i>
                Report ID: #{{ str_pad($report->id, 6, '0', STR_PAD_LEFT) }}
            </p>
        </div>
    </div>
</body>
</html>