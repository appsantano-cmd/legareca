<?php
// app/Http/Controllers/ActivityLogController.php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    /**
     * Display activity log index page
     */
    public function index(Request $request)
    {
        // Check if user is developer
        if (!Auth::user()->isDeveloper()) {
            abort(403, 'Hanya developer yang dapat mengakses activity log.');
        }

        $query = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        } else {
            $query->whereDate('created_at', today());
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by activity type
        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        // Filter form submissions only
        if ($request->has('form_only')) {
            $query->formSubmissions();
        }

        // Search in description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $activities = $query->paginate(50);
        $users = User::orderBy('name')->get();

        // Statistics for today
        $todayStats = $this->getTodayStats();

        // Top active users today
        $topUsers = $this->getTopUsersToday();

        // Activity types count for today
        $activityTypes = ActivityLog::select('activity_type', DB::raw('count(*) as count'))
            ->today()
            ->groupBy('activity_type')
            ->orderBy('count', 'desc')
            ->get();

        return view('admin.activity-log.index', compact(
            'activities',
            'users',
            'todayStats',
            'topUsers',
            'activityTypes'
        ));
    }

    /**
     * Show detailed activity log
     */
    public function show($id)
    {
        if (!Auth::user()->isDeveloper()) {
            abort(403, 'Hanya developer yang dapat mengakses activity log.');
        }

        $activity = ActivityLog::with('user')->findOrFail($id);

        return view('admin.activity-log.show', compact('activity'));
    }

    /**
     * Show activities by specific user
     */
    public function userActivities($userId)
    {
        if (!Auth::user()->isDeveloper()) {
            abort(403, 'Hanya developer yang dapat mengakses activity log.');
        }

        $user = User::findOrFail($userId);
        $activities = ActivityLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('admin.activity-log.user', compact('activities', 'user'));
    }

    /**
     * Show form submissions only
     */
    public function formSubmissions(Request $request)
    {
        if (!Auth::user()->isDeveloper()) {
            abort(403, 'Hanya developer yang dapat mengakses activity log.');
        }

        $query = ActivityLog::with('user')
            ->where(function ($q) {
                $q->where('activity_type', 'FORM_SUBMIT')
                    ->orWhere('description', 'like', '%form%');
            })
            ->orderBy('created_at', 'desc');

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        } else {
            $query->whereDate('created_at', today());
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $formActivities = $query->paginate(50);

        // Form statistics
        $formStats = $this->getFormStatistics();

        return view('admin.activity-log.forms', compact('formActivities', 'formStats'));
    }

    /**
     * Get form data via AJAX
     */
    public function getFormData($id)
    {
        if (!Auth::user()->isDeveloper()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $activity = ActivityLog::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'form_data' => $activity->getCleanedFormData(),
                'user' => $activity->name,
                'time' => $activity->created_at->format('d M Y H:i:s'),
                'url' => $activity->url,
                'description' => $activity->description,
                'ip_address' => $activity->ip_address
            ]
        ]);
    }

    /**
     * Export activity log to CSV
     */
    public function export(Request $request)
    {
        if (!Auth::user()->isDeveloper()) {
            abort(403, 'Hanya developer yang dapat mengakses activity log.');
        }

        $query = ActivityLog::with('user');

        // Apply filters if present
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        } else {
            $query->whereDate('created_at', today());
        }

        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        $activities = $query->orderBy('created_at', 'desc')->get();

        // Generate CSV
        $filename = 'activity-log-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($activities) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fwrite($file, "\xEF\xBB\xBF");

            // Headers
            fputcsv($file, [
                'ID',
                'Tanggal',
                'Waktu',
                'User',
                'Email',
                'Role',
                'Tipe Aktivitas',
                'Deskripsi',
                'URL',
                'IP Address',
                'Method'
            ]);

            // Data
            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->id,
                    $activity->created_at->format('d/m/Y'),
                    $activity->created_at->format('H:i:s'),
                    $activity->name,
                    $activity->email,
                    $activity->user ? $activity->user->role : 'N/A',
                    $activity->activity_type,
                    $activity->description,
                    $activity->url,
                    $activity->ip_address,
                    $activity->method
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Clear old logs (older than 30 days)
     */
    public function clearOldLogs()
    {
        if (!Auth::user()->isDeveloper()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $deleted = ActivityLog::where('created_at', '<', now()->subDays(30))->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus ' . $deleted . ' log lama.',
            'deleted_count' => $deleted
        ]);
    }

    /**
     * Get today's statistics
     */
    private function getTodayStats(): array
    {
        return [
            'total' => ActivityLog::today()->count(),
            'logins' => ActivityLog::today()->where('activity_type', 'LOGIN')->count(),
            'form_submissions' => ActivityLog::today()
                ->where('activity_type', 'FORM_SUBMIT')
                ->count(),
            'creates' => ActivityLog::today()->where('activity_type', 'CREATE')->count(),
            'updates' => ActivityLog::today()->where('activity_type', 'UPDATE')->count(),
            'deletes' => ActivityLog::today()->where('activity_type', 'DELETE')->count(),
            'unique_users' => ActivityLog::today()
                ->whereNotNull('user_id')
                ->distinct('user_id')
                ->count('user_id'),
        ];
    }

    /**
     * Get top users today
     */
    private function getTopUsersToday()
    {
        return ActivityLog::select('user_id', 'name', DB::raw('count(*) as activity_count'))
            ->today()
            ->whereNotNull('user_id')
            ->groupBy('user_id', 'name')
            ->orderBy('activity_count', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get form statistics
     */
    private function getFormStatistics()
    {
        return ActivityLog::select(
            DB::raw("CASE 
                    WHEN url LIKE '%pendaftaran%' THEN 'Pendaftaran'
                    WHEN url LIKE '%pengaduan%' THEN 'Pengaduan'
                    WHEN url LIKE '%permohonan%' THEN 'Permohonan'
                    WHEN url LIKE '%survey%' THEN 'Survey'
                    WHEN url LIKE '%keluhan%' THEN 'Keluhan'
                    WHEN url LIKE '%complaint%' THEN 'Complaint'
                    WHEN url LIKE '%request%' THEN 'Request'
                    WHEN url LIKE '%application%' THEN 'Application'
                    WHEN description LIKE '%form%' THEN 'Other Forms'
                    ELSE 'Unknown'
                END as form_type"),
            DB::raw('count(*) as count')
        )
            ->today()
            ->where(function ($q) {
                $q->where('activity_type', 'FORM_SUBMIT')
                    ->orWhere('description', 'like', '%form%');
            })
            ->groupBy('form_type')
            ->orderBy('count', 'desc')
            ->get();
    }

    /**
     * Get quick stats for developer dashboard
     */
    public function quickStats()
    {
        if (!Auth::user()->isDeveloper()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $today = now()->startOfDay();

        $stats = [
            'today_activities' => ActivityLog::where('created_at', '>=', $today)->count(),
            'form_submissions' => ActivityLog::where('activity_type', 'FORM_SUBMIT')
                ->where('created_at', '>=', $today)
                ->count(),
            'user_logins' => ActivityLog::where('activity_type', 'LOGIN')
                ->where('created_at', '>=', $today)
                ->count(),
            'active_users' => ActivityLog::where('created_at', '>=', $today)
                ->distinct('user_id')
                ->count('user_id'),
            'recent_activities' => ActivityLog::where('created_at', '>=', now()->subMinutes(5))->count(),
            'success' => true
        ];

        return response()->json($stats);
    }

    /**
     * Get recent activities for dashboard
     */
    public function recentActivities()
    {
        if (!Auth::user()->isDeveloper()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $activities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'activity_type' => $activity->activity_type,
                    'description' => $activity->description,
                    'name' => $activity->name,
                    'time' => $activity->created_at->format('H:i'),
                    'user_role' => $activity->user ? $activity->user->role : 'System'
                ];
            });

        return response()->json([
            'success' => true,
            'activities' => $activities
        ]);
    }

    /**
     * Check for new activities (for live updates)
     */
    public function checkNewActivities(Request $request)
    {
        if (!Auth::user()->isDeveloper()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $lastCheck = $request->input('last_check', now()->subMinutes(5));

        $newCount = ActivityLog::where('created_at', '>', $lastCheck)->count();

        return response()->json([
            'success' => true,
            'has_new' => $newCount > 0,
            'count' => $newCount,
            'current_time' => now()
        ]);
    }

}