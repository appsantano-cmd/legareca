<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'activity_type',
        'description',
        'model_type',
        'model_id',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
        'url',
        'method'
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
        'created_at' => 'datetime:d M Y H:i:s'
    ];

    /**
     * Get the user that performed the activity
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for today's activities
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for activities by specific user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for specific activity type
     */
    public function scopeByActivityType($query, $activityType)
    {
        return $query->where('activity_type', $activityType);
    }

    /**
     * Scope for login activities
     */
    public function scopeLoginActivities($query)
    {
        return $query->where('activity_type', 'LOGIN');
    }

    /**
     * Scope for form submissions
     */
    public function scopeFormSubmissions($query)
    {
        return $query->where('activity_type', 'FORM_SUBMIT')
            ->orWhere('description', 'like', '%form%')
            ->orWhere('description', 'like', '%submit%');
    }

    /**
     * Scope for date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get form name from URL
     */
    public function getFormNameAttribute()
    {
        if (!$this->url)
            return 'Unknown';

        $url = strtolower($this->url);

        if (str_contains($url, 'pendaftaran'))
            return 'Form Pendaftaran';
        if (str_contains($url, 'pengaduan'))
            return 'Form Pengaduan';
        if (str_contains($url, 'permohonan'))
            return 'Form Permohonan';
        if (str_contains($url, 'survey'))
            return 'Form Survey';
        if (str_contains($url, 'keluhan'))
            return 'Form Keluhan';
        if (str_contains($url, 'complaint'))
            return 'Form Complaint';
        if (str_contains($url, 'request'))
            return 'Form Request';
        if (str_contains($url, 'application'))
            return 'Form Application';
        if (str_contains($url, 'registration'))
            return 'Form Registration';

        // Extract from description
        if (str_contains(strtolower($this->description), 'form')) {
            return 'Form Submission';
        }

        return 'Other Form';
    }

    /**
     * Check if activity has form data
     */
    public function hasFormData()
    {
        return !empty($this->new_data) && is_array($this->new_data);
    }

    /**
     * Get cleaned form data (without tokens)
     */
    public function getCleanedFormData()
    {
        if (!$this->hasFormData())
            return [];

        $data = $this->new_data;

        // Remove sensitive/token fields
        unset($data['_token'], $data['_method'], $data['password'], $data['password_confirmation']);

        // Format date fields
        $dateFields = ['created_at', 'updated_at', 'deleted_at', 'date', 'tanggal', 'tgl', 'tanggal_shift_asli', 'tanggal_shift_tujuan'];
        $timeFields = ['jam', 'jam_shift_asli', 'jam_shift_tujuan', 'waktu'];

        foreach ($data as $key => $value) {
            if (in_array($key, $dateFields) && $value) {
                try {
                    // Try to parse as Carbon date
                    $data[$key] = \Carbon\Carbon::parse($value)->format('d-m-Y');
                } catch (\Exception $e) {
                    // If parsing fails, keep original value
                    $data[$key] = $value;
                }
            }

            if (in_array($key, $timeFields) && $value) {
                try {
                    // Format time fields
                    if (str_contains($value, 'T')) {
                        // ISO 8601 format
                        $data[$key] = \Carbon\Carbon::parse($value)->format('H:i');
                    } elseif (preg_match('/^\d{2}:\d{2}$/', $value)) {
                        // Already in HH:mm format
                        $data[$key] = $value;
                    } else {
                        // Try to parse other time formats
                        $data[$key] = \Carbon\Carbon::parse($value)->format('H:i');
                    }
                } catch (\Exception $e) {
                    $data[$key] = $value;
                }
            }

            // Format datetime fields (e.g., 2026-02-07T19:52:45.000000Z)
            if (is_string($value) && preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/', $value)) {
                try {
                    $data[$key] = \Carbon\Carbon::parse($value)->format('d-m-Y H:i');
                } catch (\Exception $e) {
                    // Keep original if parsing fails
                }
            }
        }

        return $data;
    }
}