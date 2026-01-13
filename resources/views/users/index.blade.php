<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .card-shadow {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
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
        
        .role-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .role-badge-developer {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }
        
        .role-badge-admin {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        
        .role-badge-staff {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .role-badge-marcom {
            background-color: #fce7f3;
            color: #9d174d;
            border: 1px solid #f9a8d4;
        }

        .role-badge-guest {
            background-color: #f1f5f9;
            color: #334155;
            border: 1px solid #cbd5e1;
        }
        
        .role-badge-user {
            background-color: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
        }
        
        .status-badge {
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 500;
        }
        
        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-inactive {
            background-color: #fef2f2;
            color: #991b1b;
        }
        
        .table-row-hover:hover {
            background-color: #f9fafb;
        }
        
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
        }
        
        .dropdown-menu {
            transition: all 0.2s ease;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
        }
        
        .dropdown-menu-active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .filter-btn {
            transition: all 0.2s ease;
        }
        
        .filter-btn.active {
            background-color: #3b82f6;
            color: white;
        }
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
                        <h1 class="text-xl font-bold text-gray-800">Manajemen User</h1>
                        <p class="text-sm text-gray-600">Kelola data pengguna sistem</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm mr-3">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.style.display='none'">
                        <i class="fas fa-times text-green-700 hover:text-green-900"></i>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- Stats Cards -->
        @php
            $totalUsers = $users->count();
            $adminCount = $users->where('role', 'admin')->count();
            $developerCount = $users->where('role', 'developer')->count();
            $marcomCount = $users->where('role', 'marcom')->count();
            $staffCount = $users->where('role', 'staff')->count();
            $guestCount = $users->where('role', 'guest')->count();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mr-4">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                        <p class="text-sm text-gray-600">Total Users</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center mr-4">
                        <i class="fas fa-crown text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $adminCount }}</p>
                        <p class="text-sm text-gray-600">Admin</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center mr-4">
                        <i class="fas fa-code text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $developerCount }}</p>
                        <p class="text-sm text-gray-600">Developer</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-pink-100 flex items-center justify-center mr-4">
                        <i class="fas fa-bullhorn text-pink-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $marcomCount }}</p>
                        <p class="text-sm text-gray-600">MarCom</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-xl card-shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mr-4">
                        <i class="fas fa-user-tie text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $staffCount + $guestCount }}</p>
                        <p class="text-sm text-gray-600">Staff & Guest</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="bg-white rounded-xl card-shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="w-full md:w-auto">
                    <h2 class="text-lg font-bold text-gray-800">Daftar Pengguna</h2>
                    <p class="text-sm text-gray-600">Menampilkan {{ $totalUsers }} user</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                    <!-- Search Box -->
                    <div class="relative flex-1 sm:flex-none">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               id="searchInput"
                               placeholder="Cari user..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg search-input focus:outline-none focus:border-blue-500 transition duration-200">
                    </div>
                    
                    <!-- Add User Button -->
                    @if(in_array(auth()->user()->role, ['developer', 'admin']))
                    <a href="{{ route('users.create') }}" 
                       class="btn-primary text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center transition duration-200 whitespace-nowrap">
                        <i class="fas fa-user-plus mr-2"></i>
                        <span>Tambah User</span>
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Filters -->
            <div class="mt-6 flex flex-wrap gap-3">
                <button class="filter-btn px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 transition duration-200 active" data-filter="all">
                    Semua ({{ $totalUsers }})
                </button>
                <button class="filter-btn px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition duration-200" data-filter="admin">
                    Admin ({{ $adminCount }})
                </button>
                <button class="filter-btn px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition duration-200" data-filter="developer">
                    Developer ({{ $developerCount }})
                </button>
                <button class="filter-btn px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition duration-200" data-filter="marcom">
                    MarCom ({{ $marcomCount }})
                </button>
                <button class="filter-btn px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition duration-200" data-filter="staff">
                    Staff & Guest ({{ $staffCount + $guestCount }})
                </button>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-xl card-shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="py-4 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>No</span>
                                </div>
                            </th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>User</span>
                                </div>
                            </th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Email</span>
                                </div>
                            </th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Role</span>
                                </div>
                            </th>
                            <th class="py-4 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Status</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="userTableBody">
                        @forelse ($users as $user)
                        <tr class="table-row-hover user-row" data-role="{{ $user->role }}">
                            <td class="py-4 px-6 text-sm text-gray-900">
                                <span class="font-medium">{{ $loop->iteration }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm mr-3">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">
                                            Bergabung: {{ $user->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $roleClasses = [
                                        'developer' => 'role-badge-developer',
                                        'admin' => 'role-badge-admin',
                                        'marcom' => 'role-badge-marcom',
                                        'staff' => 'role-badge-staff',
                                        'guest' => 'role-badge-guest'
                                    ];
                                    $roleClass = $roleClasses[$user->role] ?? 'role-badge-guest';
                                @endphp
                                <span class="role-badge {{ $roleClass }} capitalize">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $isActive = $user->updated_at >= now()->subDays(7);
                                @endphp
                                <span class="status-badge {{ $isActive ? 'status-active' : 'status-inactive' }}">
                                    <i class="fas fa-circle mr-1" style="font-size: 0.5rem;"></i>
                                    {{ $isActive ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-users text-gray-400 text-xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-700 mb-2">Belum ada user</h3>
                                    <p class="text-gray-500 text-sm mb-4">Mulai dengan menambahkan user baru</p>
                                    @if(in_array(auth()->user()->role, ['developer', 'admin']))
                                    <a href="{{ route('users.create') }}" 
                                       class="btn-primary text-white font-medium py-2 px-4 rounded-lg flex items-center">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        <span>Tambah User Pertama</span>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="text-sm text-gray-600">
                    Total: <span class="font-medium">{{ $totalUsers }}</span> user
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl card-shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Role</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700">Admin</span>
                            <span class="font-medium">{{ $adminCount }} ({{ $totalUsers > 0 ? round(($adminCount/$totalUsers)*100) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $totalUsers > 0 ? ($adminCount/$totalUsers)*100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700">Developer</span>
                            <span class="font-medium">{{ $developerCount }} ({{ $totalUsers > 0 ? round(($developerCount/$totalUsers)*100) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $totalUsers > 0 ? ($developerCount/$totalUsers)*100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700">MarCom</span>
                            <span class="font-medium">{{ $marcomCount }} ({{ $totalUsers > 0 ? round(($marcomCount/$totalUsers)*100) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-pink-500 h-2 rounded-full" style="width: {{ $totalUsers > 0 ? ($marcomCount/$totalUsers)*100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700">Staff & Guest</span>
                            <span class="font-medium">{{ $staffCount + $guestCount }} ({{ $totalUsers > 0 ? round((($staffCount + $guestCount)/$totalUsers)*100) : 0 }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalUsers > 0 ? (($staffCount + $guestCount)/$totalUsers)*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl card-shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik User</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $users->where('created_at', '>=', now()->subMonth())->count() }}</div>
                        <div class="text-sm text-gray-600">User Baru (30 hari)</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $users->where('updated_at', '>=', now()->subDays(7))->count() }}</div>
                        <div class="text-sm text-gray-600">User Aktif (7 hari)</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
                        <div class="text-sm text-gray-600">Bulan Ini</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.user-row');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Filter by role
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                const rows = document.querySelectorAll('.user-row');
                
                // Update active filter button
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active', 'bg-blue-100', 'text-blue-700');
                    btn.classList.add('bg-gray-100', 'text-gray-700');
                });
                
                this.classList.remove('bg-gray-100', 'text-gray-700');
                this.classList.add('active', 'bg-blue-100', 'text-blue-700');
                
                // Filter rows
                rows.forEach(row => {
                    const role = row.getAttribute('data-role');
                    if (filter === 'all') {
                        row.style.display = '';
                    } else if (filter === 'staff' && (role === 'staff' || role === 'guest')) {
                        row.style.display = '';
                    } else if (role === filter) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
        
        // Confirm delete
        document.addEventListener('submit', function(e) {
            if (e.target.matches('form[onsubmit*="confirm"]')) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                    e.target.submit();
                }
            }
        });
    </script>
</body>
</html>