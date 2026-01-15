<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            transition: all 0.3s ease;
        }

        .sidebar-collapsed {
            width: 70px;
        }

        .sidebar-expanded {
            width: 260px;
        }

        .main-content {
            transition: all 0.3s ease;
        }

        .main-content-expanded {
            margin-left: 260px;
        }

        .main-content-collapsed {
            margin-left: 70px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -260px;
                z-index: 50;
            }

            .sidebar-active {
                left: 0;
            }

            .main-content-expanded,
            .main-content-collapsed {
                margin-left: 0;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
            }

            .overlay-active {
                display: block;
            }
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-admin {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-developer {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-staff {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-user {
            background-color: #f3f4f6;
            color: #374151;
        }

        .active-menu {
            background-color: #e0f2fe;
            color: #0369a1;
            border-left: 4px solid #0ea5e9;
        }

        .dropdown-menu {
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
        }

        .dropdown-menu-active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .role-badge-admin {
            background-color: #fef3c7;
            color: #92400e;
        }

        .role-badge-developer {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .role-badge-staff {
            background-color: #dcfce7;
            color: #166534;
        }

        .role-badge-user {
            background-color: #f3f4f6;
            color: #374151;
        }

        .staff-card {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .staff-card-secondary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
        }

        .staff-card-tertiary {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
        }

        .staff-card-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        /* Add pagination styles */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 2px;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .pagination a {
            color: #4b5563;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .pagination a:hover {
            background-color: #e5e7eb;
            color: #374151;
        }

        .pagination .active span {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .pagination .disabled span {
            color: #9ca3af;
            background-color: #f9fafb;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Overlay for mobile sidebar -->
    <div id="overlay" class="overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar sidebar-expanded bg-white h-screen fixed left-0 top-0 shadow-lg z-40">
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <!-- Logo -->
                    <div
                        class="w-10 h-10 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-center mr-3">
                        <img id="sidebar-logo" src="/logo.png" alt="Logo" class="w-7 h-7 object-contain"
                            onerror="this.style.display='none'; document.getElementById('sidebar-logo-fallback').style.display='flex';">
                        <div id="sidebar-logo-fallback"
                            class="hidden w-full h-full items-center justify-center text-white font-bold">
                            S
                        </div>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Dashboard</h2>
                        <p class="text-xs text-gray-500">Management System</p>
                    </div>
                </div>
                <button id="sidebar-toggle" class="text-gray-500 hover:text-gray-700 lg:hidden"
                    onclick="toggleSidebar()">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="p-4 overflow-y-auto h-[calc(100vh-260px)]">
            <ul class="space-y-2">
                <!-- Home/Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('dashboard') ? 'active-menu' : '' }}">
                        <i class="fas fa-home text-lg w-6"></i>
                        <span class="ml-3 font-medium">Dashboard</span>
                    </a>
                </li>

                <!-- User Management (Admin/Developer only) -->
                @if (in_array(auth()->user()->role, ['admin', 'developer']))
                    <li>
                        <div class="mt-6 mb-2 px-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">User
                                Management</span>
                        </div>

                        <!-- Add User -->
                        <a href="{{ route('users.create') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('users.create') ? 'active-menu' : '' }}">
                            <i class="fas fa-user-plus text-lg w-6"></i>
                            <span class="ml-3 font-medium">Tambah User</span>
                            <span class="ml-auto bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">New</span>
                        </a>

                        <!-- User List -->
                        <a href="{{ route('users.index') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('users.index') ? 'active-menu' : '' }}">
                            <i class="fas fa-users text-lg w-6"></i>
                            <span class="ml-3 font-medium">Daftar User</span>
                        </a>
                    </li>
                @endif

                @if (in_array(auth()->user()->role, ['admin', 'developer']))
                    <li>
                        <div class="mt-6 mb-2 px-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">System
                                Management</span>
                        </div>

                        <!-- Screening -->
                        <a href="/screening"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->is('screening') ? 'active-menu' : '' }}">
                            <i class="fas fa-clipboard-check text-lg w-6"></i>
                            <span class="ml-3 font-medium">Screening</span>
                        </a>
                        <!-- Cleaning  -->
                        <a href="/cleaning-report"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->is('cleaning-report') ? 'active-menu' : '' }}">
                            <i class="fas fa-broom text-lg w-6"></i>
                            <span class="ml-3 font-medium">Cleaning Report</span>
                        </a>

                        <!-- Tukar Shift -->
                        <a href="/sifting"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->is('sifting') ? 'active-menu' : '' }}">
                            <i class="fas fa-exchange-alt text-lg w-6"></i>
                            <span class="ml-3 font-medium">Tukar Shift</span>
                        </a>

                        <!-- Pengajuan Izin -->
                        <a href="/izin"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->is('izin') ? 'active-menu' : '' }}">
                            <i class="fas fa-file-alt text-lg w-6"></i>
                            <span class="ml-3 font-medium">Pengajuan Izin</span>
                        </a>

                    </li>
                @endif

                <!-- Staff Menu (Staff only) -->
                @if (auth()->user()->role === 'staff')
                    <li>
                        <div class="mt-6 mb-2 px-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Staff Menu</span>
                        </div>

                        <!-- Cleaning  -->
                        <a href="/cleaning-report"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->is('cleaning-report') ? 'active-menu' : '' }}">
                            <i class="fas fa-broom text-lg w-6"></i>
                            <span class="ml-3 font-medium">Cleaning Report</span>
                        </a>

                        <!-- Tukar Shift -->
                        <a href="/sifting"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->is('sifting') ? 'active-menu' : '' }}">
                            <i class="fas fa-exchange-alt text-lg w-6"></i>
                            <span class="ml-3 font-medium">Tukar Shift</span>
                        </a>

                        <!-- Pengajuan Izin -->
                        <a href="/izin"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->is('izin') ? 'active-menu' : '' }}">
                            <i class="fas fa-file-alt text-lg w-6"></i>
                            <span class="ml-3 font-medium">Pengajuan Izin</span>
                        </a>

                    </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="main-content main-content-expanded min-h-screen">
        <!-- Top Navigation Bar -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
            <div class="flex items-center justify-between px-6 py-4">
                <!-- Left side: Menu button and breadcrumb -->
                <div class="flex items-center">
                    <button id="mobile-menu-button" class="text-gray-600 hover:text-gray-900 mr-4 lg:hidden"
                        onclick="toggleSidebar()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Desktop sidebar toggle -->
                    <button id="desktop-sidebar-toggle" class="hidden lg:block text-gray-600 hover:text-gray-900 mr-4"
                        onclick="toggleDesktopSidebar()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <!-- Breadcrumb -->
                    <div class="hidden md:flex items-center text-sm text-gray-600">
                        <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
                        <i class="fas fa-chevron-right mx-2 text-xs"></i>
                        <span class="text-gray-900 font-medium">Home</span>
                    </div>
                </div>

                <!-- Right side: Notifications, User dropdown -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->

                    @php
                        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->take(5)->get();

                        $unreadCount = auth()->user()->unreadNotifications()->count();
                    @endphp

                    <div class="relative">
                        <button id="notification-button" class="text-gray-600 hover:text-gray-900 relative"
                            onclick="toggleDropdown('notification-dropdown')">
                            <i class="fas fa-bell text-xl"></i>
                            @if ($unreadCount > 0)
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notification-dropdown"
                            class="dropdown-menu absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-40">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <h3 class="font-semibold text-gray-800">Notifications</h3>
                            </div>

                            <!-- Di dropdown notifikasi -->
                            <div class="max-h-60 overflow-y-auto">
                                @forelse($notifications as $notification)
                                    @php
                                        // Tentukan icon dan warna berdasarkan type
                                        $iconClass = '';
                                        $bgColor = '';
                                        $textColor = '';

                                        if (str_contains($notification->type, 'cleaning')) {
                                            $iconClass = 'fa-broom';
                                            $bgColor = 'bg-green-100';
                                            $textColor = 'text-green-600';
                                        } elseif (str_contains($notification->type, 'sifting')) {
                                            $iconClass = 'fa-exchange-alt';
                                            $bgColor = 'bg-blue-100';
                                            $textColor = 'text-blue-600';
                                        } elseif (str_contains($notification->type, 'izin')) {
                                            $iconClass = 'fa-file-alt';
                                            $bgColor = 'bg-yellow-100';
                                            $textColor = 'text-yellow-600';
                                        } elseif (str_contains($notification->type, 'confirmation')) {
                                            $iconClass = 'fa-check-circle';
                                            $bgColor = 'bg-green-100';
                                            $textColor = 'text-green-600';
                                        } else {
                                            $iconClass = 'fa-bell';
                                            $bgColor = 'bg-gray-100';
                                            $textColor = 'text-gray-600';
                                        }
                                    @endphp

                                    <a href="#"
                                        class="flex items-center px-4 py-3 hover:bg-gray-50 {{ !$loop->last ? 'border-b border-gray-100' : '' }} notification-item"
                                        data-id="{{ $notification->id }}">
                                        <div
                                            class="w-10 h-10 rounded-full {{ $bgColor }} {{ $textColor }} flex items-center justify-center mr-3">
                                            <i class="fas {{ $iconClass }}"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">{{ $notification->title }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $notification->message }}</p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                        @if (!$notification->is_read)
                                            <span class="ml-auto w-2 h-2 rounded-full bg-blue-500"></span>
                                        @endif
                                    </a>
                                @empty
                                    <div class="px-4 py-6 text-center text-gray-500">
                                        <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                        <p>No notifications</p>
                                    </div>
                                @endforelse
                            </div>

                            <div class="px-4 py-2 border-t border-gray-100">
                                <a href="{{ route('notifications.all') }}"
                                    class="block text-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    View all notifications
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="relative">
                        <button id="user-menu-button"
                            class="flex items-center space-x-3 text-gray-700 hover:text-gray-900"
                            onclick="toggleDropdown('user-dropdown')">
                            <div
                                class="w-9 h-9 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs hidden md:block"></i>
                        </button>

                        <!-- User Dropdown Menu -->
                        <div id="user-dropdown"
                            class="dropdown-menu absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-40">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full px-4 py-3 text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="p-6">
            <!-- Welcome Card -->
            <div class="mb-8">
                <div
                    class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="p-8 text-white">
                        <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                        <p class="text-blue-100 mb-6">You are logged in as <span
                                class="font-bold capitalize">{{ auth()->user()->role }}</span>. Here's what's
                            happening today.</p>
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                                <i class="fas fa-calendar-day mr-3"></i>
                                <span>{{ now()->format('l, F j, Y') }}</span>
                            </div>
                            <div class="flex items-center bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                                <i class="fas fa-clock mr-3"></i>
                                <span>{{ now()->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conditional card Content Based on Role -->
            @if (auth()->user()->role === 'staff')
                <!-- Staff Dashboard Content -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Cleaning Report Card -->
                    <div class="staff-card rounded-xl shadow-lg overflow-hidden card-hover">
                        <a href="/cleaning-report" class="block p-6 h-full">
                            <div class="flex items-center justify-between mb-4">
                                <div
                                    class="w-12 h-12 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <i class="fas fa-broom text-white text-xl"></i>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold mb-1">Cleaning Report</h3>
                        </a>
                    </div>

                    <!-- Shift Change Card -->
                    <div class="staff-card-secondary rounded-xl shadow-lg overflow-hidden card-hover">
                        <a href="/sifting" class="block p-6 h-full">
                            <div class="flex items-center justify-between mb-4">
                                <div
                                    class="w-12 h-12 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <i class="fas fa-exchange-alt text-white text-xl"></i>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold mb-1">Tukar Shift</h3>
                        </a>
                    </div>

                    <!-- Leave Request Card -->
                    <div class="staff-card-tertiary rounded-xl shadow-lg overflow-hidden card-hover">
                        <a href="/izin" class="block p-6 h-full">
                            <div class="flex items-center justify-between mb-4">
                                <div
                                    class="w-12 h-12 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <i class="fas fa-file-alt text-white text-xl"></i>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold mb-1">Pengajuan Izin</h3>
                        </a>
                    </div>
                </div>
            @else
                <!-- Admin/Developer Dashboard Content -->
                <!-- Stats Cards dengan Data Real dari Database -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Users Card -->
                    @php
                        $totalUsers = App\Models\User::count();

                        // Hitung pertumbuhan bulan ini vs bulan lalu
                        $currentMonthStart = now()->startOfMonth();
                        $currentMonthEnd = now()->endOfMonth();
                        $lastMonthStart = now()->subMonth()->startOfMonth();
                        $lastMonthEnd = now()->subMonth()->endOfMonth();

                        $usersThisMonth = App\Models\User::whereBetween('created_at', [
                            $currentMonthStart,
                            $currentMonthEnd,
                        ])->count();
                        $usersLastMonth = App\Models\User::whereBetween('created_at', [
                            $lastMonthStart,
                            $lastMonthEnd,
                        ])->count();

                        if ($usersLastMonth > 0) {
                            $growthPercentage = round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100);
                        } else {
                            $growthPercentage = $usersThisMonth > 0 ? 100 : 0;
                        }

                        $growthColor = $growthPercentage >= 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50';
                        $growthIcon = $growthPercentage >= 0 ? 'fas fa-arrow-up' : 'fas fa-arrow-down';

                        // Hitung user hari ini
                        $usersToday = App\Models\User::whereDate('created_at', today())->count();

                        // Hitung user aktif (updated_at dalam 7 hari terakhir)
                        $activeUsers = App\Models\User::where('updated_at', '>=', now()->subDays(7))->count();
                        $activePercentage = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0;

                        // Hitung user berdasarkan role
                        $adminCount = App\Models\User::where('role', 'admin')->count();
                        $developerCount = App\Models\User::where('role', 'developer')->count();
                        $staffCount = App\Models\User::where('role', 'staff')->count();
                        $marcomCount = App\Models\User::where('role', 'marcom')->count();

                        // User baru minggu ini
                        $newUsersThisWeek = App\Models\User::whereBetween('created_at', [
                            now()->startOfWeek(),
                            now()->endOfWeek(),
                        ])->count();
                        $newUsersLastWeek = App\Models\User::whereBetween('created_at', [
                            now()->subWeek()->startOfWeek(),
                            now()->subWeek()->endOfWeek(),
                        ])->count();

                        if ($newUsersLastWeek > 0) {
                            $weekGrowth = round((($newUsersThisWeek - $newUsersLastWeek) / $newUsersLastWeek) * 100);
                        } else {
                            $weekGrowth = $newUsersThisWeek > 0 ? 100 : 0;
                        }

                        $weekGrowthColor = $weekGrowth >= 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50';
                        $weekGrowthIcon = $weekGrowth >= 0 ? 'fas fa-arrow-up' : 'fas fa-arrow-down';
                    @endphp

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                            <span class="text-sm font-medium {{ $growthColor }} px-3 py-1 rounded-full">
                                <i class="{{ $growthIcon }} mr-1"></i>{{ abs($growthPercentage) }}%
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ number_format($totalUsers) }}</h3>
                        <p class="text-gray-600 text-sm">Total Users</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Today: {{ $usersToday }}</span>
                                <span>This Month: {{ $usersThisMonth }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Active Users Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                                <i class="fas fa-user-check text-green-600 text-xl"></i>
                            </div>
                            <span class="text-sm font-medium text-green-600 bg-green-50 px-3 py-1 rounded-full">
                                {{ $activePercentage }}% Active
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ number_format($activeUsers) }}</h3>
                        <p class="text-gray-600 text-sm">Active Users (7 days)</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="text-xs text-gray-500">
                                <div class="flex justify-between mb-1">
                                    <span>Active: {{ $activeUsers }}</span>
                                    <span>Total: {{ $totalUsers }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                    <div class="bg-green-500 h-1.5 rounded-full"
                                        style="width: {{ $activePercentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role Distribution Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-user-tag text-purple-600 text-xl"></i>
                            </div>
                            @php
                                // Cari role dengan jumlah terbanyak
                                $roleCounts = [
                                    'admin' => $adminCount,
                                    'developer' => $developerCount,
                                    'staff' => $staffCount,
                                    'marcom' => $marcomCount,
                                ];
                                arsort($roleCounts);
                                $topRole = key($roleCounts);
                                $topRolePercentage =
                                    $totalUsers > 0 ? round(($roleCounts[$topRole] / $totalUsers) * 100) : 0;
                            @endphp
                            <span
                                class="text-sm font-medium text-purple-600 bg-purple-50 px-3 py-1 rounded-full capitalize">
                                {{ $topRolePercentage }}% {{ $topRole }}
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ number_format($totalUsers) }}</h3>
                        <p class="text-gray-600 text-sm">Role Distribution</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs">
                                    <span class="flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>
                                        Admin
                                    </span>
                                    <span class="font-medium">{{ $adminCount }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                                        Developer
                                    </span>
                                    <span class="font-medium">{{ $developerCount }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                        Staff
                                    </span>
                                    <span class="font-medium">{{ $staffCount }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-gray-500 mr-2"></span>
                                        Mar. Com
                                    </span>
                                    <span class="font-medium">{{ $marcomCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Users This Week -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                                <i class="fas fa-user-plus text-orange-600 text-xl"></i>
                            </div>
                            <span class="text-sm font-medium {{ $weekGrowthColor }} px-3 py-1 rounded-full">
                                <i class="{{ $weekGrowthIcon }} mr-1"></i>{{ abs($weekGrowth) }}%
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ number_format($newUsersThisWeek) }}</h3>
                        <p class="text-gray-600 text-sm">New This Week</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="text-xs text-gray-500">
                                <div class="flex justify-between mb-1">
                                    <span>Last Week: {{ $newUsersLastWeek }}</span>
                                    <span>Today: {{ $usersToday }}</span>
                                </div>
                                <div class="flex items-center mt-2">
                                    <i class="fas fa-calendar-week text-gray-400 mr-2 text-xs"></i>
                                    <span>{{ now()->startOfWeek()->format('M d') }} -
                                        {{ now()->endOfWeek()->format('M d') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Users Table -->
                @php
                    $recentUsers = App\Models\User::orderBy('created_at', 'desc')->take(5)->get();
                @endphp

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Recent Users</h2>
                            <p class="text-gray-600 text-sm">Latest registered users</p>
                        </div>
                        @if (in_array(auth()->user()->role, ['admin', 'developer']))
                            <a href="{{ route('users.index') }}"
                                class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg font-medium hover:bg-blue-100 transition duration-200">
                                View All Users
                            </a>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Name</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Email</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Role</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Joined</th>
                                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="py-3 px-4">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm mr-3">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <span class="font-medium">{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-gray-600 text-sm">{{ $user->email }}</td>
                                        <td class="py-3 px-4">
                                            @php
                                                $roleColors = [
                                                    'admin' => 'role-badge-admin',
                                                    'developer' => 'role-badge-developer',
                                                    'staff' => 'role-badge-staff',
                                                    'user' => 'role-badge-user',
                                                ];
                                                $roleColor = $roleColors[$user->role] ?? 'role-badge-user';
                                            @endphp
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-medium {{ $roleColor }} capitalize">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-gray-600 text-sm">
                                            {{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="py-3 px-4">
                                            @php
                                                $isActive = $user->updated_at >= now()->subDays(7);
                                            @endphp
                                            <div class="flex items-center">
                                                <div
                                                    class="w-2 h-2 rounded-full {{ $isActive ? 'bg-green-500' : 'bg-gray-400' }} mr-2">
                                                </div>
                                                <span
                                                    class="text-sm {{ $isActive ? 'text-green-600' : 'text-gray-600' }}">
                                                    {{ $isActive ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-gray-500">
                                            No users found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-6 px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-600 text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} Management System. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Toggle mobile sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.toggle('sidebar-active');
            overlay.classList.toggle('overlay-active');

            // Prevent body scrolling when sidebar is open on mobile
            if (sidebar.classList.contains('sidebar-active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }

        // Toggle desktop sidebar
        function toggleDesktopSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            if (sidebar.classList.contains('sidebar-expanded')) {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
                mainContent.classList.remove('main-content-expanded');
                mainContent.classList.add('main-content-collapsed');
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
                mainContent.classList.remove('main-content-collapsed');
                mainContent.classList.add('main-content-expanded');
            }
        }

        // Toggle dropdown menus
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('dropdown-menu-active');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const notificationButton = document.getElementById('notification-button');
            const notificationDropdown = document.getElementById('notification-dropdown');
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');

            // Close notification dropdown if clicking outside
            if (notificationButton && !notificationButton.contains(event.target) &&
                notificationDropdown && !notificationDropdown.contains(event.target)) {
                notificationDropdown.classList.remove('dropdown-menu-active');
            }

            // Close user dropdown if clicking outside
            if (userMenuButton && !userMenuButton.contains(event.target) &&
                userDropdown && !userDropdown.contains(event.target)) {
                userDropdown.classList.remove('dropdown-menu-active');
            }
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Close sidebar on mobile when clicking a link
            const sidebarLinks = document.querySelectorAll('#sidebar a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        toggleSidebar();
                    }
                });
            });

            // Update time every minute
            function updateTime() {
                const timeElements = document.querySelectorAll('.time-display');
                const now = new Date();
                const timeString = now.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });

                timeElements.forEach(el => {
                    el.textContent = timeString;
                });
            }

            // Update time initially and every minute
            updateTime();
            setInterval(updateTime, 60000);
        });

        // Fungsi untuk mengambil notifikasi terbaru
        function fetchNotifications() {
            fetch('/api/notifications', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    // Update badge count
                    const badge = document.querySelector('.notification-badge');
                    if (badge && data.unread_count > 0) {
                        badge.textContent = data.unread_count > 9 ? '9+' : data.unread_count;
                        badge.classList.remove('hidden');

                        // Update page title jika ada notifikasi baru
                        if (!document.title.includes('(')) {
                            document.title = `(${data.unread_count}) Dashboard - Management System`;
                        }

                    } else if (badge && data.unread_count === 0) {
                        badge.classList.add('hidden');

                        // Reset page title
                        document.title = 'Dashboard - Management System';
                    }

                    // Jika dropdown terbuka, update isinya
                    const dropdown = document.getElementById('notification-dropdown');
                    if (dropdown && dropdown.classList.contains('dropdown-menu-active')) {
                        updateNotificationDropdown(data.notifications);
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }

        // Update dropdown notifikasi
        function updateNotificationDropdown(notifications) {
            const container = document.querySelector('#notification-dropdown .max-h-60');
            if (!container) return;

            if (notifications.length === 0) {
                container.innerHTML = `
            <div class="px-4 py-6 text-center text-gray-500">
                <i class="fas fa-bell-slash text-2xl mb-2"></i>
                <p>No notifications</p>
            </div>
        `;
                return;
            }

            let html = '';
            notifications.forEach((notification, index) => {
                const icons = {
                    'cleaning_submitted': 'fa-broom',
                    'sifting_requested': 'fa-exchange-alt',
                    'izin_submitted': 'fa-file-alt',
                    'user_registered': 'fa-user-plus'
                };

                const colors = {
                    'cleaning_submitted': 'green',
                    'sifting_requested': 'blue',
                    'izin_submitted': 'yellow',
                    'user_registered': 'blue'
                };

                const icon = icons[notification.type] || 'fa-bell';
                const color = colors[notification.type] || 'gray';

                html += `
            <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 ${index < notifications.length - 1 ? 'border-b border-gray-100' : ''} notification-item" 
               data-id="${notification.id}">
                <div class="w-10 h-10 rounded-full bg-${color}-100 text-${color}-600 flex items-center justify-center mr-3">
                    <i class="fas ${icon}"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">${notification.title}</p>
                    <p class="text-xs text-gray-500">${notification.message}</p>
                    <p class="text-xs text-gray-400 mt-1">${new Date(notification.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</p>
                </div>
                ${!notification.is_read ? '<span class="ml-auto w-2 h-2 rounded-full bg-blue-500"></span>' : ''}
            </a>
        `;
            });

            container.innerHTML = html;
        }

        // Polling setiap 30 detik
        setInterval(fetchNotifications, 30000);

        // Saat dropdown dibuka, ambil data terbaru
        document.getElementById('notification-button').addEventListener('click', function() {
            setTimeout(fetchNotifications, 100);
        });

        // Mark as read ketika diklik
        document.addEventListener('click', function(e) {
            if (e.target.closest('.notification-item')) {
                e.preventDefault();
                const notificationId = e.target.closest('.notification-item').dataset.id;

                fetch(`/api/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            fetchNotifications(); // Refresh notifikasi
                        }
                    });
            }
        });

        // Jalankan pertama kali
        document.addEventListener('DOMContentLoaded', fetchNotifications);
    </script>
</body>

</html>
>>>>>>> main
