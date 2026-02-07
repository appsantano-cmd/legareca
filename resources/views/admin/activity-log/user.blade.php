<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivitas User - Activity Log</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .card-shadow { box-shadow: 0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.06); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- User Profile -->
        <div class="bg-white rounded-xl card-shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-2xl mr-4">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium 
                                @if($user->role == 'developer') bg-purple-100 text-purple-800
                                @elseif($user->role == 'admin') bg-red-100 text-red-800
                                @elseif($user->role == 'marcom') bg-pink-100 text-pink-800
                                @elseif($user->role == 'staff') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $user->role }}
                            </span>
                            <span class="text-sm text-gray-600">{{ $user->email }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-center md:text-right">
                    <a href="{{ route('admin.activity-log.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-2">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Activity Log
                    </a>
                    <div class="text-sm text-gray-600">
                        Bergabung: {{ $user->created_at->format('d M Y') }}
                        @if($user->last_login_at)
                        <br>Login terakhir: {{ $user->last_login_at->diffForHumans() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- User Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            @php
                $userStats = [
                    'total' => $user->activities()->count(),
                    'today' => $user->todayActivities()->count(),
                    'logins' => $user->activities()->where('activity_type', 'LOGIN')->count(),
                    'forms' => $user->activities()->where('activity_type', 'FORM_SUBMIT')->count(),
                ];
            @endphp
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $userStats['total'] }}</p>
                        <p class="text-sm text-gray-600">Total Aktivitas</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-history text-blue-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $userStats['today'] }}</p>
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
                        <p class="text-2xl font-bold text-gray-800">{{ $userStats['logins'] }}</p>
                        <p class="text-sm text-gray-600">Total Login</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                        <i class="fas fa-sign-in-alt text-yellow-600"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $userStats['forms'] }}</p>
                        <p class="text-sm text-gray-600">Form Submissions</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-edit text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Activities -->
        <div class="bg-white rounded-xl card-shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">Riwayat Aktivitas {{ $user->name }}</h3>
                <p class="text-sm text-gray-600">Menampilkan {{ $activities->count() }} dari {{ $userStats['total'] }} aktivitas</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Waktu</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Aktivitas</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Deskripsi</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">IP Address</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($activities as $activity)
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
                                @php
                                    $badgeColors = [
                                        'LOGIN' => 'bg-green-100 text-green-800',
                                        'CREATE' => 'bg-blue-100 text-blue-800',
                                        'UPDATE' => 'bg-yellow-100 text-yellow-800',
                                        'DELETE' => 'bg-red-100 text-red-800',
                                        'FORM_SUBMIT' => 'bg-purple-100 text-purple-800'
                                    ];
                                    $badgeClass = $badgeColors[$activity->activity_type] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $badgeClass }}">
                                    {{ $activity->activity_type }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-sm text-gray-900">{{ $activity->description }}</div>
                                @if($activity->url)
                                <div class="text-xs text-gray-500 truncate max-w-xs">
                                    {{ $activity->url }}
                                </div>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $activity->ip_address }}</code>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.activity-log.show', $activity->id) }}" 
                                   class="px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-100 transition inline-flex items-center">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                <p>Belum ada aktivitas yang tercatat</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($activities->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $activities->links() }}
            </div>
            @endif
        </div>
    </div>

    <script>
        // Auto-refresh every 60 seconds
        setTimeout(() => {
            window.location.reload();
        }, 60000);
    </script>
</body>
</html>