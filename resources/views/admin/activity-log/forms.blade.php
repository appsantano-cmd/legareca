<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submissions - Activity Log</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .card-shadow { box-shadow: 0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.06); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-edit text-purple-600 mr-2"></i>Form Submissions
                        </h1>
                        <p class="text-sm text-gray-600">Developer Only - Monitor semua form submission</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-pink-600 flex items-center justify-center text-white font-bold text-sm mr-3">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }} (Developer)</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @php
                $totalForms = $formActivities->total();
                $todayForms = $formActivities->where('created_at', '>=', today())->count();
                $uniqueUsers = $formActivities->unique('user_id')->count();
                $formTypes = $formStats->count();
            @endphp
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalForms }}</p>
                        <p class="text-sm text-gray-600">Total Form Submissions</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-file-alt text-purple-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $todayForms }}</p>
                        <p class="text-sm text-gray-600">Hari Ini</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                        <i class="fas fa-calendar-day text-green-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $uniqueUsers }}</p>
                        <p class="text-sm text-gray-600">User Unik</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $formTypes }}</p>
                        <p class="text-sm text-gray-600">Jenis Form</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-tags text-yellow-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Type Distribution -->
        @if($formStats->count() > 0)
        <div class="bg-white rounded-xl card-shadow p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Jenis Form</h3>
            <div class="space-y-4">
                @foreach($formStats as $stat)
                @php
                    $percentage = $totalForms > 0 ? round(($stat->count / $totalForms) * 100, 1) : 0;
                    $colors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-yellow-500', 'bg-red-500', 'bg-pink-500'];
                    $color = $colors[$loop->index % count($colors)] ?? 'bg-gray-500';
                @endphp
                <div class="space-y-1">
                    <div class="flex justify-between text-sm">
                        <span class="font-medium text-gray-700">{{ $stat->form_type }}</span>
                        <span class="text-gray-600">{{ $stat->count }} ({{ $percentage }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="{{ $color }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Form Submissions Table -->
        <div class="bg-white rounded-xl card-shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Form Submissions</h3>
                        <p class="text-sm text-gray-600">Menampilkan {{ $formActivities->count() }} form submission</p>
                    </div>
                    <a href="{{ route('admin.activity-log.export') }}?form_only=1" 
                       class="px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium hover:bg-green-200 transition">
                        <i class="fas fa-download mr-2"></i>Export Form Data
                    </a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Waktu</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">User</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Form Type</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Fields</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">URL</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($formActivities as $activity)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $activity->created_at->format('H:i:s') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $activity->created_at->format('d M Y') }}
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                @if($activity->user)
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xs mr-2">
                                        {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $activity->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $activity->user->role }}</div>
                                    </div>
                                </div>
                                @else
                                <span class="text-gray-500 text-sm">System</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $activity->form_name }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($activity->hasFormData())
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                    {{ count($activity->getCleanedFormData()) }} fields
                                </span>
                                @else
                                <span class="text-gray-500 text-xs">No data</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-xs text-gray-600 truncate max-w-xs">
                                    {{ parse_url($activity->url, PHP_URL_PATH) }}
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <button onclick="showFormData({{ $activity->id }})" 
                                        class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition">
                                    <i class="fas fa-database"></i> View Data
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500">
                                <i class="fas fa-file-alt text-4xl mb-4"></i>
                                <p>Belum ada form submission</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($formActivities->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $formActivities->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div id="formDataModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Form Data</h3>
                <button onclick="document.getElementById('formDataModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="formDataContent" class="max-h-96 overflow-y-auto">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        function showFormData(activityId) {
            // Show loading
            document.getElementById('formDataContent').innerHTML = `
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <p class="mt-2 text-gray-600">Loading form data...</p>
                </div>
            `;
            
            document.getElementById('formDataModal').classList.remove('hidden');
            
            // Fetch data
            fetch(`/admin/activity-log/${activityId}/form-data`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let html = `
                            <div class="mb-4 p-3 bg-gray-50 rounded">
                                <div class="grid grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <span class="text-gray-600">User:</span>
                                        <span class="font-medium ml-2">${data.data.user}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Time:</span>
                                        <span class="font-medium ml-2">${data.data.time}</span>
                                    </div>
                                    <div class="col-span-2">
                                        <span class="text-gray-600">URL:</span>
                                        <div class="font-medium truncate">${data.data.url}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="border rounded overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Field</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-700 uppercase">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                        `;
                        
                        if (data.data.form_data && Object.keys(data.data.form_data).length > 0) {
                            Object.entries(data.data.form_data).forEach(([key, value]) => {
                                if (value === null || value === '') return;
                                
                                let displayValue = value;
                                if (typeof value === 'object') {
                                    displayValue = JSON.stringify(value, null, 2);
                                }
                                
                                html += `
                                    <tr>
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900 border">${key}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700 border">
                                            <div class="max-h-32 overflow-y-auto">${displayValue}</div>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            html += `
                                <tr>
                                    <td colspan="2" class="px-4 py-8 text-center text-gray-500">
                                        No form data available
                                    </td>
                                </tr>
                            `;
                        }
                        
                        html += `
                                    </tbody>
                                </table>
                            </div>
                        `;
                        
                        document.getElementById('formDataContent').innerHTML = html;
                    } else {
                        document.getElementById('formDataContent').innerHTML = `
                            <div class="text-center py-8 text-red-600">
                                <i class="fas fa-exclamation-triangle text-3xl mb-4"></i>
                                <p>${data.error || 'Error loading form data'}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    document.getElementById('formDataContent').innerHTML = `
                        <div class="text-center py-8 text-red-600">
                            <i class="fas fa-exclamation-circle text-3xl mb-4"></i>
                            <p>Network error. Please try again.</p>
                        </div>
                    `;
                });
        }
        
        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.getElementById('formDataModal').classList.add('hidden');
            }
        });
    </script>
</body>
</html>