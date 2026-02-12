<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'room_type',
        'room_price',
        'check_in',
        'check_out',
        'guests',
        'rooms',
        'full_name',
        'phone',
        'email',
        'special_request',
        'duration_days',
        'total_price',
        'status',
        'booking_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'duration_days' => 'integer',
        'total_price' => 'decimal:2',
    ];

    /**
     * Generate unique booking code
     */
    public static function generateBookingCode(): string
    {
        $prefix = 'LGN';
        $date = Carbon::now()->format('ymd');
        $random = strtoupper(substr(uniqid(), -4));
        
        $code = $prefix . $date . $random;
        
        // Ensure uniqueness
        while (self::where('booking_code', $code)->exists()) {
            $random = strtoupper(substr(uniqid(), -4));
            $code = $prefix . $date . $random;
        }
        
        return $code;
    }

    /**
     * Calculate duration in days
     */
    public static function calculateDuration($checkIn, $checkOut): int
    {
        return Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut));
    }

    /**
     * Calculate total price
     */
    public static function calculateTotalPrice($roomPrice, $duration, $rooms): float
    {
        // Remove non-numeric characters and convert to float
        $price = (float) preg_replace('/[^0-9.]/', '', $roomPrice);
        return $price * $duration * $rooms;
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('booking_code', 'like', "%{$search}%")
              ->orWhere('full_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    /**
     * Scope untuk filter status
     */
    public function scopeStatus($query, $status)
    {
        if ($status && $status != 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope untuk filter tanggal
     */
    public function scopeDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->whereDate('check_in', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('check_out', '<=', $endDate);
        }
        return $query;
    }

    /**
     * Get formatted price attribute
     */
    public function getFormattedRoomPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) preg_replace('/[^0-9.]/', '', $this->room_price), 0, ',', '.');
    }

    /**
     * Get formatted total price attribute
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'confirmed' => 'bg-success',
            'pending' => 'bg-warning text-dark',
            'cancelled' => 'bg-danger',
            'completed' => 'bg-secondary',
            default => 'bg-info'
        };
    }
}