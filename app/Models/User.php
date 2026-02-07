<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Loggable;

    const ROLE_DEVELOPER = 'developer';
    const ROLE_ADMIN = 'admin';
    const ROLE_MARCOM = 'marcom';
    const ROLE_STAFF = 'staff';
    const ROLE_GUEST = 'guest';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function isDeveloper()
    {
        return $this->role === self::ROLE_DEVELOPER;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isMarcom()
    {
        return $this->role === self::ROLE_MARCOM;
    }

    public function isStaff()
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function isGuest()
    {
        return $this->role === self::ROLE_GUEST;
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }

    /**
     * Get all activities for this user
     */
    public function activities()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Get recent activities
     */
    public function recentActivities($limit = 10)
    {
        return $this->activities()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get today's activities
     */
    public function todayActivities()
    {
        return $this->activities()
            ->today()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Update last login time
     */
    public function updateLastLogin()
    {
        $this->last_login_at = now();
        $this->save();
    }
}