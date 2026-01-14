<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationPageController extends Controller
{
    // Halaman semua notifikasi
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = auth()->user()->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    // Mark as read
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $notification->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return back()->with('success', 'Notification marked as read.');
    }

    // Mark all as read
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return back()->with('success', 'All notifications marked as read.');
    }

    // Delete notification
    public function destroy($id)
    {
        $notification = Notification::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $notification->delete();

        return back()->with('success', 'Notification deleted.');
    }

    // Clear all notifications
    public function clearAll()
    {
        auth()->user()->notifications()->delete();

        return back()->with('success', 'All notifications cleared.');
    }
}