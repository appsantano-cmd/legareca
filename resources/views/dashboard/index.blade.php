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
            width: calc(100% - 260px);
        }

        .main-content-collapsed {
            margin-left: 70px;
            width: calc(100% - 70px);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -260px;
                z-index: 50;
                height: 100vh;
            }

            .sidebar-active {
                left: 0;
            }

            .main-content-expanded,
            .main-content-collapsed {
                margin-left: 0;
                width: 100%;
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

        /* New styles for Activity Log badge */
        .activity-log-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            font-size: 0.6rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: bold;
        }

        /* Developer-specific menu item */
        .developer-menu {
            border-left: 3px solid #8b5cf6;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Overlay for mobile sidebar -->
    <div id="overlay" class="overlay" onclick="closeMobileSidebar()"></div>

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
                <button id="sidebar-close" class="text-gray-500 hover:text-gray-700 lg:hidden"
                    onclick="closeMobileSidebar()">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Navigation Menu -->
        <div class="p-4 overflow-y-auto" style="height: calc(100vh - 120px);">
            <ul class="space-y-2">
                <!-- Home/Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('dashboard') ? 'active-menu' : '' }}">
                        <i class="fas fa-home text-lg w-6"></i>
                        <span class="ml-3 font-medium">Dashboard</span>
                    </a>
                </li>

                <!-- Staff Menu -->
                @if (auth()->user()->role === 'staff')
                    <li>
                        <div class="mt-6 mb-2 px-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Staff Menu</span>
                        </div>

                        <!-- Form Cleaning Report -->
                        <a href="{{ route('cleaning-report.create') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('cleaning-report.create') ? 'active-menu' : '' }}">
                            <i class="fas fa-pen-to-square text-lg w-6"></i>
                            <span class="ml-3 font-medium">Form Cleaning Report</span>
                        </a>

                        <!-- Form Tukar Shift -->
                        <a href="{{ route('shifting.create') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('shifting.create') ? 'active-menu' : '' }}">
                            <i class="fas fa-right-left text-lg w-6"></i>
                            <span class="ml-3 font-medium">Form Tukar Shift</span>
                        </a>

                        <!-- Form Pengajuan Izin -->
                        <a href="{{ route('izin.create') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('izin.create') ? 'active-menu' : '' }}">
                            <i class="fas fa-file-circle-plus text-lg w-6"></i>
                            <span class="ml-3 font-medium">Form Pengajuan Izin</span>
                        </a>

                        <!-- Stok Gudang (Transaction Create) -->
                        <a href="{{ route('transactions.create') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('transactions.create') ? 'active-menu' : '' }}">
                            <i class="fas fa-boxes-stacked text-lg w-6"></i>
                            <span class="ml-3 font-medium">Stok Gudang</span>
                        </a>

                        <!-- Stok Station -->
                        <a href="{{ route('stok-kitchen.index') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('master-kitchen.index') ? 'active-menu' : '' }}">
                            <i class="fas fa-kitchen-set text-lg w-6"></i>
                            <span class="ml-3 font-medium">Stok Station</span>
                        </a>
                    </li>
                @endif

                <!-- Admin & Developer Menu -->
                @if (in_array(auth()->user()->role, ['admin', 'developer']))
                    <li>
                        <div class="mt-6 mb-2 px-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">User
                                Management</span>
                        </div>

                        <!-- Tambah User -->
                        <a href="{{ route('users.create') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('users.create') ? 'active-menu' : '' }}">
                            <i class="fas fa-user-plus text-lg w-6"></i>
                            <span class="ml-3 font-medium">Tambah User</span>
                        </a>

                        <!-- Daftar User -->
                        <a href="{{ route('users.index') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('users.index') ? 'active-menu' : '' }}">
                            <i class="fas fa-users text-lg w-6"></i>
                            <span class="ml-3 font-medium">Daftar User</span>
                        </a>

                        <div class="mt-6 mb-2 px-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Form
                                Management</span>
                        </div>

                        <!-- Form Screening -->
                        <a href="{{ route('screening.welcome') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('screening.welcome') ? 'active-menu' : '' }}">
                            <i class="fas fa-clipboard-list text-lg w-6"></i>
                            <span class="ml-3 font-medium">Form Screening</span>
                        </a>

                        <!-- Daftar Screening -->
                        <a href="{{ route('screening.index') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('screening.index') ? 'active-menu' : '' }}">
                            <i class="fas fa-list-check text-lg w-6"></i>
                            <span class="ml-3 font-medium">Daftar Screening</span>
                        </a>

                        <!-- Form Cleaning Report -->
                        <a href="{{ route('cleaning-report.create') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('cleaning-report.create') ? 'active-menu' : '' }}">
                            <i class="fas fa-pen-to-square text-lg w-6"></i>
                            <span class="ml-3 font-medium">Form Cleaning Report</span>
                        </a>

                        <!-- Daftar Cleaning Report -->
                        <a href="{{ route('cleaning-report.dashboard') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('cleaning-report.dashboard') ? 'active-menu' : '' }}">
                            <i class="fas fa-broom text-lg w-6"></i>
                            <span class="ml-3 font-medium">Daftar Cleaning Report</span>
                        </a>

                        <!-- Form Tukar Shift -->
                        <a href="{{ route('shifting.create') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('shifting.create') ? 'active-menu' : '' }}">
                            <i class="fas fa-right-left text-lg w-6"></i>
                            <span class="ml-3 font-medium">Form Tukar Shift</span>
                        </a>

                        <!-- Daftar Tukar Shift -->
                        <a href="{{ route('shifting.index') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('shifting.index') ? 'active-menu' : '' }}">
                            <i class="fas fa-calendar-days text-lg w-6"></i>
                            <span class="ml-3 font-medium">Daftar Tukar Shift</span>
                        </a>

                        <!-- Form Pengajuan Izin -->
                        <a href="{{ route('izin.create') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('izin.create') ? 'active-menu' : '' }}">
                            <i class="fas fa-file-circle-plus text-lg w-6"></i>
                            <span class="ml-3 font-medium">Form Pengajuan Izin</span>
                        </a>

                        <!-- Daftar Pengajuan Izin -->
                        <a href="{{ route('izin.index') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('izin.index') ? 'active-menu' : '' }}">
                            <i class="fas fa-folder-open text-lg w-6"></i>
                            <span class="ml-3 font-medium">Daftar Pengajuan Izin</span>
                        </a>

                        <div class="mt-6 mb-2 px-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Inventory
                                Management</span>
                        </div>

                        <!-- Stok Gudang -->
                        <a href="{{ route('stok.index') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('stok.index') ? 'active-menu' : '' }}">
                            <i class="fas fa-warehouse text-lg w-6"></i>
                            <span class="ml-3 font-medium">Stok Gudang</span>
                        </a>

                        <!-- Stok Station -->
                        <a href="{{ route('master-kitchen.index') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('master-kitchen.index') ? 'active-menu' : '' }}">
                            <i class="fas fa-kitchen-set text-lg w-6"></i>
                            <span class="ml-3 font-medium">Stok Station</span>
                        </a>

                        <div class="mt-6 mb-2 px-3">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Content
                                Management</span>
                        </div>

                        <!-- Art Gallery Create -->
                        <a href="{{ route('gallery.create') }}"
                            class="flex items-center p-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 {{ request()->routeIs('gallery.create') ? 'active-menu' : '' }}">
                            <i class="fas fa-paint-brush text-lg w-6"></i>
                            <span class="ml-3 font-medium">Art Gallery Create</span>
                        </a>

                        <!-- Developer Menu (Activity Log) -->
                        @if (auth()->user()->role === 'developer')
                            <div class="mt-6 mb-2 px-3">
                                <span class="text-xs font-semibold text-purple-600 uppercase tracking-wider">
                                    <i class="fas fa-code mr-1"></i> Developer Tools
                                </span>
                            </div>

                            <!-- Activity Log -->
                            <a href="{{ route('admin.activity-log.index') }}"
                                class="flex items-center p-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition duration-200 developer-menu {{ request()->is('admin/activity-log*') ? 'active-menu' : '' }} relative">
                                <i class="fas fa-history text-lg w-6"></i>
                                <span class="ml-3 font-medium">Activity Log</span>
                                <!-- Live activity badge -->
                                <div class="activity-log-badge" id="activityLogBadge" style="display: none;">
                                    <span id="recentActivitiesCount">0</span>
                                </div>
                            </a>

                            <!-- Form Submissions (View only) -->
                            <a href="{{ route('admin.activity-log.forms') }}"
                                class="flex items-center p-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition duration-200 developer-menu {{ request()->is('admin/activity-log/forms') ? 'active-menu' : '' }}">
                                <i class="fas fa-file-edit text-lg w-6"></i>
                                <span class="ml-3 font-medium">Form Submissions</span>
                            </a>
                        @endif
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
                        onclick="openMobileSidebar()">
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
                    <!-- Developer Activity Indicator -->
                    @if (auth()->user()->role === 'developer')
                        <div class="hidden md:flex items-center space-x-2">
                            <div class="relative" id="liveActivityIndicator">
                                <div class="w-3 h-3 rounded-full bg-green-500 animate-pulse" id="activityIndicator">
                                </div>
                                <div class="text-xs text-gray-600 ml-2">Live Activity</div>
                            </div>
                        </div>
                    @endif

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

                            <div class="max-h-60 overflow-y-auto">
                                @forelse($notifications as $notification)
                                    @php
                                        $iconClass = '';
                                        $bgColor = '';
                                        $textColor = '';

                                        if (str_contains($notification->type, 'cleaning')) {
                                            $iconClass = 'fa-broom';
                                            $bgColor = 'bg-green-100';
                                            $textColor = 'text-green-600';
                                        } elseif (str_contains($notification->type, 'shifting')) {
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
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
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
                                <p class="text-xs text-gray-500 capitalize">
                                    @if (auth()->user()->role === 'developer')
                                        <span class="text-purple-600 font-bold">
                                            <i class="fas fa-code mr-1"></i>Developer
                                        </span>
                                    @else
                                        {{ auth()->user()->role }}
                                    @endif
                                </p>
                            </div>
                            <i class="fas fa-chevron-down text-xs hidden md:block"></i>
                        </button>

                        <!-- User Dropdown Menu -->
                        <div id="user-dropdown"
                            class="dropdown-menu absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-40">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                <div class="mt-1">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium 
                                        @if (auth()->user()->role === 'developer') bg-purple-100 text-purple-800
                                        @elseif(auth()->user()->role === 'admin') bg-red-100 text-red-800
                                        @elseif(auth()->user()->role === 'staff') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ auth()->user()->role }}
                                    </span>
                                </div>
                            </div>

                            <!-- Developer Quick Links -->
                            @if (auth()->user()->role === 'developer')
                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <a href="{{ route('admin.activity-log.index') }}"
                                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-purple-50 text-sm">
                                        <i class="fas fa-history w-4 mr-3 text-purple-600"></i>
                                        <span>Activity Log</span>
                                    </a>
                                    <a href="{{ route('admin.activity-log.forms') }}"
                                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-purple-50 text-sm">
                                        <i class="fas fa-file-edit w-4 mr-3 text-purple-600"></i>
                                        <span>Form Submissions</span>
                                    </a>
                                </div>
                            @endif

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
                        <p class="text-blue-100 mb-6">You are logged in as
                            <span class="font-bold capitalize">
                                @if (auth()->user()->role === 'developer')
                                    <i class="fas fa-code mr-1"></i>Developer
                                @else
                                    {{ auth()->user()->role }}
                                @endif
                            </span>.
                            @if (auth()->user()->role === 'developer')
                                <br>You have access to <strong>Activity Log</strong> for monitoring all system
                                activities.
                            @endif
                        </p>
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                                <i class="fas fa-calendar-day mr-3"></i>
                                <span>{{ now()->format('l, F j, Y') }}</span>
                            </div>
                            <div class="flex items-center bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                                <i class="fas fa-clock mr-3"></i>
                                <span class="time-display">{{ now()->format('h:i A') }}</span>
                            </div>

                            <!-- Developer Stats (Only for developer) -->
                            @if (auth()->user()->role === 'developer')
                                <div
                                    class="flex items-center bg-purple-500/30 backdrop-blur-sm rounded-lg px-4 py-2 border border-purple-400/30">
                                    <i class="fas fa-history mr-3"></i>
                                    <span id="recentActivityStats">Loading activities...</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Cards (Existing content) -->
            @if (auth()->user()->role === 'developer')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- System Status -->
                    <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">System Status</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">Database</span>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Online</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">Email Service</span>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">File Storage</span>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Normal</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">API Services</span>
                                <span
                                    class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Operational</span>
                            </div>

                            <!-- Developer System Info -->
                            <div class="border-t border-gray-200 pt-4 mt-4">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Developer Info</h4>
                                <div class="text-xs text-gray-600 space-y-1">
                                    <div>PHP: {{ phpversion() }}</div>
                                    <div>Laravel: {{ app()->version() }}</div>
                                    <div>Environment: {{ app()->environment() }}</div>
                                    <div>Activity Log: <span id="activityLogStatus">Active</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>

    <script>
        // Mobile sidebar functions
        function openMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.add('sidebar-active');
            overlay.classList.add('overlay-active');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.remove('sidebar-active');
            overlay.classList.remove('overlay-active');
            document.body.style.overflow = 'auto';
        }

        // Desktop sidebar function
        function toggleDesktopSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            // Hanya toggle jika bukan di mobile
            if (window.innerWidth >= 768) {
                if (sidebar.classList.contains('sidebar-expanded')) {
                    // Collapse sidebar
                    sidebar.classList.remove('sidebar-expanded');
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.remove('main-content-expanded');
                    mainContent.classList.add('main-content-collapsed');
                } else {
                    // Expand sidebar
                    sidebar.classList.remove('sidebar-collapsed');
                    sidebar.classList.add('sidebar-expanded');
                    mainContent.classList.remove('main-content-collapsed');
                    mainContent.classList.add('main-content-expanded');
                }
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
            // Close mobile sidebar when clicking a link
            const sidebarLinks = document.querySelectorAll('#sidebar a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        closeMobileSidebar();
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('main-content');
                const overlay = document.getElementById('overlay');

                // Jika beralih dari mobile ke desktop, pastikan sidebar dalam keadaan normal
                if (window.innerWidth >= 768) {
                    closeMobileSidebar();

                    // Pastikan kelas yang tepat diterapkan untuk desktop
                    if (sidebar.classList.contains('sidebar-collapsed')) {
                        mainContent.classList.remove('main-content-expanded');
                        mainContent.classList.add('main-content-collapsed');
                    } else {
                        mainContent.classList.remove('main-content-collapsed');
                        mainContent.classList.add('main-content-expanded');
                    }
                }
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

            // Load developer stats if user is developer
            @if (auth()->user()->role === 'developer')
                loadDeveloperStats();
                loadRecentActivities();

                // Live activity indicator
                startLiveActivityMonitoring();
            @endif
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
                    'shifting_requested': 'fa-exchange-alt',
                    'izin_submitted': 'fa-file-alt',
                    'user_registered': 'fa-user-plus'
                };

                const colors = {
                    'cleaning_submitted': 'green',
                    'shifting_requested': 'blue',
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

        // ================== DEVELOPER FUNCTIONS ==================

        // Load developer stats
        async function loadDeveloperStats() {
            try {
                const response = await fetch('/admin/activity-log/quick-stats', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Update stats cards
                    document.getElementById('todayActivitiesCount').textContent = data.today_activities || 0;
                    document.getElementById('formSubmissionsCount').textContent = data.form_submissions || 0;
                    document.getElementById('userLoginsCount').textContent = data.user_logins || 0;
                    document.getElementById('activeUsersCount').textContent = data.active_users || 0;

                    // Update welcome message stats
                    const recentStats = document.getElementById('recentActivityStats');
                    if (recentStats) {
                        const recentCount = data.recent_activities || 0;
                        recentStats.textContent = `${recentCount} recent activities`;

                        // Update badge if there are recent activities
                        const badge = document.getElementById('activityLogBadge');
                        const badgeCount = document.getElementById('recentActivitiesCount');
                        if (recentCount > 0) {
                            badge.style.display = 'block';
                            badgeCount.textContent = recentCount > 9 ? '9+' : recentCount;
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                }
            } catch (error) {
                console.error('Error loading developer stats:', error);
            }
        }

        // Load recent activities for dashboard
        async function loadRecentActivities() {
            try {
                const response = await fetch('/admin/activity-log/recent', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                const container = document.getElementById('recentActivitiesList');

                if (data.success && data.activities.length > 0) {
                    let html = '';
                    data.activities.forEach((activity, index) => {
                        // Determine icon based on activity type
                        let icon = 'fa-circle';
                        let color = 'text-gray-400';

                        switch (activity.activity_type) {
                            case 'LOGIN':
                                icon = 'fa-sign-in-alt';
                                color = 'text-green-500';
                                break;
                            case 'FORM_SUBMIT':
                                icon = 'fa-file-edit';
                                color = 'text-blue-500';
                                break;
                            case 'CREATE':
                                icon = 'fa-plus-circle';
                                color = 'text-green-500';
                                break;
                            case 'UPDATE':
                                icon = 'fa-edit';
                                color = 'text-yellow-500';
                                break;
                            case 'DELETE':
                                icon = 'fa-trash-alt';
                                color = 'text-red-500';
                                break;
                        }

                        html += `
                            <div class="flex items-start ${index < data.activities.length - 1 ? 'pb-3 border-b border-gray-100' : ''}">
                                <div class="flex-shrink-0 mt-1">
                                    <i class="fas ${icon} ${color} text-sm"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm text-gray-800">${activity.description}</p>
                                    <div class="flex justify-between items-center mt-1">
                                        <span class="text-xs text-gray-500">${activity.name}</span>
                                        <span class="text-xs text-gray-400">${activity.time}</span>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<p class="text-gray-500">No recent activities</p>';
                }
            } catch (error) {
                console.error('Error loading recent activities:', error);
                document.getElementById('recentActivitiesList').innerHTML =
                    '<p class="text-gray-500">Error loading activities</p>';
            }
        }

        // Live activity monitoring
        function startLiveActivityMonitoring() {
            // Blink indicator every 2 seconds
            const indicator = document.getElementById('activityIndicator');
            if (indicator) {
                setInterval(() => {
                    indicator.classList.toggle('animate-pulse');
                    indicator.classList.toggle('bg-green-500');
                    indicator.classList.toggle('bg-purple-500');
                }, 2000);
            }

            // Refresh stats every 60 seconds
            setInterval(() => {
                loadDeveloperStats();
                loadRecentActivities();
            }, 60000);

            // Check for new activities every 30 seconds
            setInterval(checkNewActivities, 30000);
        }

        // Check for new activities
        async function checkNewActivities() {
            try {
                const response = await fetch('/admin/activity-log/check-new', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success && data.has_new) {
                    // Show notification
                    showNewActivityNotification(data.count);
                    // Update stats
                    loadDeveloperStats();
                    loadRecentActivities();
                }
            } catch (error) {
                console.error('Error checking new activities:', error);
            }
        }

        // Show notification for new activities
        function showNewActivityNotification(count) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className =
                'fixed bottom-4 right-4 bg-purple-600 text-white px-4 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-history mr-3"></i>
                    <div>
                        <p class="font-medium">New Activity Detected</p>
                        <p class="text-sm opacity-90">${count} new ${count === 1 ? 'activity' : 'activities'} recorded</p>
                    </div>
                    <button class="ml-4 text-white opacity-75 hover:opacity-100" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            // Add to body
            document.body.appendChild(notification);

            // Remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);

            // Add animation CSS if not exists
            if (!document.querySelector('style#activity-notification-style')) {
                const style = document.createElement('style');
                style.id = 'activity-notification-style';
                style.textContent = `
                    @keyframes fade-in {
                        from { opacity: 0; transform: translateY(10px); }
                        to { opacity: 1; transform: translateY(0); }
                    }
                    .animate-fade-in {
                        animation: fade-in 0.3s ease-out;
                    }
                `;
                document.head.appendChild(style);
            }
        }
    </script>
</body>

</html>
