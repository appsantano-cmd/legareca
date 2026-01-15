<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Notifications - Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .notification-unread {
            background-color: #f0f9ff;
            border-left: 4px solid #3b82f6;
        }
        
        .notification-read {
            background-color: #f9fafb;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 mr-4">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">All Notifications</h1>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">{{ $notifications->total() }}</span> notifications
                            @if($unreadCount > 0)
                            • <span class="text-blue-600 font-medium">{{ $unreadCount }} unread</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    @if($unreadCount > 0)
                    <form method="POST" action="{{ route('notifications.read-all') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition duration-200 text-sm font-medium">
                            <i class="fas fa-check-double mr-2"></i>Mark All as Read
                        </button>
                    </form>
                    @endif
                    
                    @if($notifications->total() > 0)
                    <form method="POST" action="{{ route('notifications.clear-all') }}" class="inline" onsubmit="return confirm('Are you sure you want to clear all notifications?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition duration-200 text-sm font-medium">
                            <i class="fas fa-trash mr-2"></i>Clear All
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mr-4">
                        <i class="fas fa-bell text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $notifications->total() }}</h3>
                        <p class="text-gray-600 text-sm">Total Notifications</p>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Notifications List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <nav class="flex">
                    <a href="{{ route('notifications.all') }}" class="px-6 py-4 border-b-2 border-blue-500 text-blue-600 font-medium">
                        All Notifications
                    </a>
                </nav>
            </div>

            <!-- Notifications -->
            @if($notifications->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($notifications as $notification)
                    @php
                        // Determine icon and color
                        if (str_contains($notification->type, 'cleaning')) {
                            $icon = 'fa-broom';
                            $color = 'text-green-600 bg-green-100';
                            $badgeColor = 'bg-green-100 text-green-800';
                            $badgeText = 'Cleaning';
                        } elseif (str_contains($notification->type, 'sifting')) {
                            $icon = 'fa-exchange-alt';
                            $color = 'text-blue-600 bg-blue-100';
                            $badgeColor = 'bg-blue-100 text-blue-800';
                            $badgeText = 'Shift';
                        } elseif (str_contains($notification->type, 'izin')) {
                            $icon = 'fa-file-alt';
                            $color = 'text-yellow-600 bg-yellow-100';
                            $badgeColor = 'bg-yellow-100 text-yellow-800';
                            $badgeText = 'Leave';
                        } elseif (str_contains($notification->type, 'confirmation')) {
                            $icon = 'fa-check-circle';
                            $color = 'text-green-600 bg-green-100';
                            $badgeColor = 'bg-green-100 text-green-800';
                            $badgeText = 'Confirmation';
                        } elseif (str_contains($notification->type, 'user')) {
                            $icon = 'fa-user-plus';
                            $color = 'text-purple-600 bg-purple-100';
                            $badgeColor = 'bg-purple-100 text-purple-800';
                            $badgeText = 'User';
                        } else {
                            $icon = 'fa-bell';
                            $color = 'text-gray-600 bg-gray-100';
                            $badgeColor = 'bg-gray-100 text-gray-800';
                            $badgeText = 'System';
                        }
                        
                        $isUnread = !$notification->is_read;
                    @endphp
                    
                    <div class="p-6 hover:bg-gray-50 transition duration-200 {{ $isUnread ? 'notification-unread' : 'notification-read' }}">
                        <div class="flex items-start">
                            <!-- Icon -->
                            <div class="w-12 h-12 rounded-full {{ $color }} flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas {{ $icon }} text-lg"></i>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-3">
                                        <h3 class="font-semibold text-gray-800">{{ $notification->title }}</h3>
                                        <span class="px-2 py-1 {{ $badgeColor }} text-xs font-medium rounded-full">
                                            {{ $badgeText }}
                                        </span>
                                        @if($isUnread)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                            New
                                        </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $notification->created_at->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                                
                                <p class="text-gray-600 mb-3">{{ $notification->message }}</p>
                                
                                <!-- Actions -->
                                <div class="flex items-center space-x-4 mt-4">
                                    @if($isUnread)
                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                            <i class="fas fa-check mr-1"></i> Mark as Read
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}" class="inline" onsubmit="return confirm('Delete this notification?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $notifications->links() }}
                </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="py-16 text-center">
                    <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-bell-slash text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No notifications yet</h3>
                    <p class="text-gray-600 mb-6">You're all caught up! New notifications will appear here.</p>
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                    </a>
                </div>
            @endif
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Auto-mark as read when clicked
        document.addEventListener('DOMContentLoaded', function() {
            // Mark as read when notification is clicked
            document.querySelectorAll('.notification-unread').forEach(item => {
                item.addEventListener('click', function(e) {
                    if (!e.target.closest('button') && !e.target.closest('a')) {
                        const form = this.querySelector('form');
                        if (form) {
                            form.submit();
                        }
                    }
                });
            });
            
            // Refresh badge count
            function updateNotificationBadge() {
                fetch('/api/notifications/unread-count', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update page title if there are unread notifications
                    if (data.count > 0) {
                        document.title = `(${data.count}) All Notifications - Management System`;
                    }
                });
            }
            
            // Initial update
            updateNotificationBadge();
        });
    </script>
</body>
</html>