<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log - Developer System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .card-shadow {
            box-shadow: 0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.06);
        }
        
        .badge-login { background-color: #dcfce7; color: #166534; }
        .badge-create { background-color: #dbeafe; color: #1e40af; }
        .badge-update { background-color: #fef3c7; color: #92400e; }
        .badge-delete { background-color: #fee2e2; color: #991b1b; }
        .badge-form { background-color: #f3e8ff; color: #7c3aed; }
        .badge-view { background-color: #f1f5f9; color: #475569; }
        
        .status-active { background-color: #10b981; }
        .status-inactive { background-color: #ef4444; }
        
        .table-row:hover { background-color: #f8fafc; }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 8px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 mr-4" title="Kembali ke Dashboard">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-history text-blue-600 mr-2"></i>Activity Log
                        </h1>
                        <p class="text-sm text-gray-600">Developer Only - Monitor semua aktivitas sistem</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-clock mr-1"></i>
                        <span id="currentTime">{{ now()->format('H:i:s') }}</span>
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
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $todayStats['total'] }}</p>
                        <p class="text-sm text-gray-600">Total Aktivitas Hari Ini</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-chart-bar text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $todayStats['logins'] }}</p>
                        <p class="text-sm text-gray-600">Login Hari Ini</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                        <i class="fas fa-sign-in-alt text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $todayStats['form_submissions'] }}</p>
                        <p class="text-sm text-gray-600">Form Submissions</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-edit text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $todayStats['unique_users'] }}</p>
                        <p class="text-sm text-gray-600">User Aktif</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-users text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Card -->
        <div class="bg-white rounded-xl card-shadow p-6 mb-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Filter Aktivitas</h2>
                    <p class="text-sm text-gray-600">Saring berdasarkan kriteria tertentu</p>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <button id="refreshBtn" class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 transition">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                    <a href="{{ route('admin.activity-log.forms') }}" class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg text-sm font-medium hover:bg-purple-200 transition">
                        <i class="fas fa-edit mr-2"></i>Form Submissions
                    </a>
                    <a href="{{ route('admin.activity-log.export') }}" class="px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium hover:bg-green-200 transition">
                        <i class="fas fa-download mr-2"></i>Export CSV
                    </a>
                </div>
            </div>
            
            <form method="GET" action="{{ route('admin.activity-log.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                        <select name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->role }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Aktivitas</label>
                        <select name="activity_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Tipe</option>
                            <option value="LOGIN" {{ request('activity_type') == 'LOGIN' ? 'selected' : '' }}>Login</option>
                            <option value="CREATE" {{ request('activity_type') == 'CREATE' ? 'selected' : '' }}>Create</option>
                            <option value="UPDATE" {{ request('activity_type') == 'UPDATE' ? 'selected' : '' }}>Update</option>
                            <option value="DELETE" {{ request('activity_type') == 'DELETE' ? 'selected' : '' }}>Delete</option>
                            <option value="FORM_SUBMIT" {{ request('activity_type') == 'FORM_SUBMIT' ? 'selected' : '' }}>Form Submit</option>
                            <option value="VIEW" {{ request('activity_type') == 'VIEW' ? 'selected' : '' }}>View</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari aktivitas..." 
                                   class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                            <i class="fas fa-filter mr-2"></i>Terapkan Filter
                        </button>
                        <a href="{{ route('admin.activity-log.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">
                            <i class="fas fa-redo mr-2"></i>Reset
                        </a>
                    </div>
                    
                    @if(request()->anyFilled(['date', 'user_id', 'activity_type', 'search']))
                    <div class="text-sm text-blue-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Filter aktif: 
                        @if(request('date')) Tanggal {{ request('date') }} @endif
                        @if(request('user_id')) • User {{ $users->where('id', request('user_id'))->first()->name ?? '' }} @endif
                        @if(request('activity_type')) • Tipe {{ request('activity_type') }} @endif
                        @if(request('search')) • Pencarian "{{ request('search') }}" @endif
                    </div>
                    @endif
                </div>
            </form>
        </div>

        <!-- Top Users Today -->
        @if($topUsers->count() > 0)
        <div class="bg-white rounded-xl card-shadow p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>Top 10 User Aktif Hari Ini
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Rank</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Nama User</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Role</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Jumlah Aktivitas</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($topUsers as $index => $topUser)
                        @php
                            $user = \App\Models\User::find($topUser->user_id);
                        @endphp
                        <tr class="table-row hover:bg-gray-50">
                            <td class="py-3 px-4">
                                @if($index == 0)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-800 font-bold">
                                    1
                                </span>
                                @elseif($index == 1)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-800 font-bold">
                                    2
                                </span>
                                @elseif($index == 2)
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-800 font-bold">
                                    3
                                </span>
                                @else
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-800 font-bold">
                                    {{ $index + 1 }}
                                </span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm mr-3">
                                        {{ strtoupper(substr($topUser->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $topUser->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $roleColors = [
                                        'developer' => 'bg-purple-100 text-purple-800',
                                        'admin' => 'bg-red-100 text-red-800',
                                        'marcom' => 'bg-pink-100 text-pink-800',
                                        'staff' => 'bg-green-100 text-green-800',
                                        'guest' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $roleClass = $roleColors[$user->role ?? 'guest'] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $roleClass }}">
                                    {{ $user->role ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mr-3">
                                        @php
                                            $maxCount = $topUsers->max('activity_count');
                                            $width = $maxCount > 0 ? ($topUser->activity_count / $maxCount) * 100 : 0;
                                        @endphp
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $width }}%"></div>
                                    </div>
                                    <span class="font-bold text-gray-800">{{ $topUser->activity_count }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.activity-log.user', $topUser->user_id) }}" 
                                   class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition inline-flex items-center">
                                    <i class="fas fa-eye mr-1"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Activity Log Table -->
        <div class="bg-white rounded-xl card-shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Aktivitas</h3>
                        <p class="text-sm text-gray-600">
                            Menampilkan {{ $activities->firstItem() ?? 0 }}-{{ $activities->lastItem() ?? 0 }} dari {{ $activities->total() }} aktivitas
                            @if(request('date'))
                            pada {{ \Carbon\Carbon::parse(request('date'))->isoFormat('D MMMM YYYY') }}
                            @else
                            hari ini
                            @endif
                        </p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Auto-refresh: <span id="refreshCountdown">30</span>s
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="py-4 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Waktu</th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">User</th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aktivitas</th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Detail</th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">IP Address</th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($activities as $activity)
                        <tr class="table-row hover:bg-gray-50" id="activity-{{ $activity->id }}">
                            <td class="py-4 px-6">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $activity->created_at->format('H:i:s') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $activity->created_at->format('d M Y') }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($activity->user)
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm mr-3">
                                        {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $activity->user->name }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $activity->user->role }}
                                            @if($activity->user->last_login_at)
                                            <br>Login terakhir: {{ $activity->user->last_login_at->diffForHumans() }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @else
                                <span class="text-gray-500 italic">System</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $badgeClass = 'badge-' . strtolower($activity->activity_type);
                                    $badgeColors = [
                                        'LOGIN' => 'badge-login',
                                        'CREATE' => 'badge-create',
                                        'UPDATE' => 'badge-update',
                                        'DELETE' => 'badge-delete',
                                        'FORM_SUBMIT' => 'badge-form',
                                        'VIEW' => 'badge-view'
                                    ];
                                    $badgeClass = $badgeColors[$activity->activity_type] ?? 'badge-view';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                    <i class="fas 
                                        @if($activity->activity_type == 'LOGIN') fa-sign-in-alt
                                        @elseif($activity->activity_type == 'CREATE') fa-plus-circle
                                        @elseif($activity->activity_type == 'UPDATE') fa-edit
                                        @elseif($activity->activity_type == 'DELETE') fa-trash-alt
                                        @elseif($activity->activity_type == 'FORM_SUBMIT') fa-edit
                                        @else fa-eye @endif
                                        mr-1"></i>
                                    {{ $activity->activity_type }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm text-gray-900">{{ $activity->description }}</div>
                                @if($activity->url)
                                <div class="text-xs text-gray-500 truncate max-w-xs">
                                    <a href="{{ $activity->url }}" target="_blank" class="text-blue-600 hover:underline">
                                        {{ $activity->url }}
                                    </a>
                                </div>
                                @endif
                                @if($activity->hasFormData())
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-purple-50 text-purple-700">
                                        <i class="fas fa-database mr-1"></i>
                                        {{ count($activity->getCleanedFormData()) }} data fields
                                    </span>
                                </div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $activity->ip_address }}</code>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex space-x-2">
                                    <button onclick="showActivityDetail({{ $activity->id }})" 
                                            class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if($activity->hasFormData())
                                    <button onclick="showFormData({{ $activity->id }})" 
                                            class="px-3 py-1 bg-purple-50 text-purple-700 rounded-lg text-sm font-medium hover:bg-purple-100 transition">
                                        <i class="fas fa-database"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-history text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-700 mb-2">Tidak ada aktivitas</h3>
                                    <p class="text-gray-500 text-sm">Belum ada aktivitas yang tercatat</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($activities->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-700">
                        Menampilkan {{ $activities->firstItem() }} - {{ $activities->lastItem() }} dari {{ $activities->total() }} aktivitas
                    </div>
                    <div class="flex space-x-2">
                        {{ $activities->withQueryString()->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Activity Type Distribution -->
        @if($activityTypes->count() > 0)
        <div class="bg-white rounded-xl card-shadow p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Tipe Aktivitas Hari Ini</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($activityTypes as $type)
                @php
                    $percentage = $todayStats['total'] > 0 ? round(($type->count / $todayStats['total']) * 100, 1) : 0;
                @endphp
                <div class="border rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-gray-800 mb-1">{{ $type->count }}</div>
                    <div class="text-sm text-gray-600 mb-2">{{ $type->activity_type }}</div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">{{ $percentage }}%</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Modal for Activity Detail -->
    <div id="activityDetailModal" class="modal">
        <div class="modal-content">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">Detail Aktivitas</h3>
            </div>
            <div class="p-6" id="activityDetailContent">
                <!-- Content loaded via AJAX -->
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                <button onclick="closeModal('activityDetailModal')" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal for Form Data -->
    <div id="formDataModal" class="modal">
        <div class="modal-content">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-800">Data Form</h3>
            </div>
            <div class="p-6" id="formDataContent">
                <!-- Content loaded via AJAX -->
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
                <button onclick="closeModal('formDataModal')" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { 
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('currentTime').textContent = timeString;
        }
        setInterval(updateTime, 1000);
        
        // Auto-refresh countdown
        let refreshCountdown = 30;
        function updateCountdown() {
            document.getElementById('refreshCountdown').textContent = refreshCountdown;
            refreshCountdown--;
            
            if (refreshCountdown < 0) {
                refreshCountdown = 30;
                window.location.reload();
            }
        }
        setInterval(updateCountdown, 1000);
        
        // Manual refresh
        document.getElementById('refreshBtn').addEventListener('click', function() {
            this.classList.add('animate-pulse');
            setTimeout(() => {
                this.classList.remove('animate-pulse');
                window.location.reload();
            }, 500);
        });
        
        // Modal functions
        function showModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        };
        
        // Show activity detail
        function showActivityDetail(activityId) {
            fetch(`/admin/activity-log/${activityId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('activityDetailContent').innerHTML = html;
                    showModal('activityDetailModal');
                })
                .catch(error => {
                    document.getElementById('activityDetailContent').innerHTML = 
                        '<p class="text-red-600">Error loading activity details</p>';
                    showModal('activityDetailModal');
                });
        }
        
        // Show form data
        function showFormData(activityId) {
            // Show loading
            document.getElementById('formDataContent').innerHTML = `
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <p class="mt-2 text-gray-600">Loading form data...</p>
                </div>
            `;
            showModal('formDataModal');
            
            // Fetch data
            fetch(`/admin/activity-log/${activityId}/form-data`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let html = `
                            <div class="mb-4">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">User</label>
                                        <div class="mt-1 text-sm text-gray-900">${data.data.user}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Waktu</label>
                                        <div class="mt-1 text-sm text-gray-900">${data.data.time}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">IP Address</label>
                                        <div class="mt-1 text-sm text-gray-900">${data.data.ip_address}</div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">URL</label>
                                        <div class="mt-1 text-sm text-gray-900 truncate">${data.data.url}</div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                                    <div class="px-3 py-2 bg-gray-50 rounded-lg text-sm">${data.data.description}</div>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-md font-bold text-gray-800 mb-3">Data Form:</h4>
                                <div class="overflow-x-auto">
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
                                // Skip empty values
                                if (value === null || value === '') return;
                                
                                let displayValue = value;
                                if (typeof value === 'object') {
                                    displayValue = JSON.stringify(value, null, 2);
                                }
                                
                                html += `
                                    <tr>
                                        <td class="px-4 py-2 text-sm font-medium text-gray-900 border">${key}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700 border">
                                            <div class="max-h-40 overflow-y-auto">${displayValue}</div>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            html += `
                                <tr>
                                    <td colspan="2" class="px-4 py-8 text-center text-gray-500">
                                        Tidak ada data form
                                    </td>
                                </tr>
                            `;
                        }
                        
                        html += `
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;
                        
                        document.getElementById('formDataContent').innerHTML = html;
                    } else {
                        document.getElementById('formDataContent').innerHTML = `
                            <div class="text-center py-8">
                                <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                                <p class="text-gray-600">${data.error || 'Error loading form data'}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    document.getElementById('formDataContent').innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-exclamation-circle text-red-500 text-4xl mb-4"></i>
                            <p class="text-gray-600">Network error. Please try again.</p>
                        </div>
                    `;
                });
        }
        
        // Highlight new activities
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to new rows (created in last 5 minutes)
            const rows = document.querySelectorAll('tbody tr[id^="activity-"]');
            rows.forEach(row => {
                const activityId = row.id.replace('activity-', '');
                // Check if activity is recent (within 5 minutes)
                fetch(`/admin/activity-log/${activityId}/timestamp`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.is_recent) {
                            row.classList.add('bg-yellow-50');
                            setTimeout(() => {
                                row.classList.remove('bg-yellow-50');
                            }, 10000); // Remove highlight after 10 seconds
                        }
                    });
            });
        });
    </script>
</body>
</html>