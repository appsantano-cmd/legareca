<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait Loggable
{
    /**
     * Boot the trait
     */
    public static function bootLoggable()
    {
        static::created(function ($model) {
            self::logActivity($model, 'CREATE', 'Membuat data ' . class_basename($model));
        });
        
        static::updated(function ($model) {
            self::logActivity($model, 'UPDATE', 'Memperbarui data ' . class_basename($model));
        });
        
        static::deleted(function ($model) {
            self::logActivity($model, 'DELETE', 'Menghapus data ' . class_basename($model));
        });
    }
    
    /**
     * Log activity for model events
     */
    protected static function logActivity($model, $activityType, $description)
    {
        $user = Auth::user();
        
        ActivityLog::create([
            'user_id' => $user ? $user->id : null,
            'name' => $user ? $user->name : 'System',
            'email' => $user ? $user->email : 'system@example.com',
            'activity_type' => $activityType,
            'description' => $description,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'old_data' => $activityType === 'UPDATE' ? $model->getOriginal() : null,
            'new_data' => $model->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
        ]);
    }
    
    /**
     * Manual logging method
     */
    public static function logManual($activityType, $description, $data = null)
    {
        $user = Auth::user();
        
        return ActivityLog::create([
            'user_id' => $user ? $user->id : null,
            'name' => $user ? $user->name : 'System',
            'email' => $user ? $user->email : 'system@example.com',
            'activity_type' => $activityType,
            'description' => $description,
            'model_type' => static::class,
            'model_id' => null,
            'old_data' => null,
            'new_data' => $data,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
        ]);
    }
    
    /**
     * Log view activity
     */
    public static function logView($description = null)
    {
        $user = Auth::user();
        $description = $description ?: 'Melihat data ' . class_basename(static::class);
        
        return ActivityLog::create([
            'user_id' => $user ? $user->id : null,
            'name' => $user ? $user->name : 'System',
            'email' => $user ? $user->email : 'system@example.com',
            'activity_type' => 'VIEW',
            'description' => $description,
            'model_type' => static::class,
            'model_id' => null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
        ]);
    }
}