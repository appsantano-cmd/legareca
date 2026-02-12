<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class CafeRestoReservation extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'date',
        'time',
        'guests',
        'table_type',
        'special_request',
        'status', 
        'reservation_code'
    ];

    protected $casts = [
        'date' => 'date',
        'guests' => 'integer'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->reservation_code)) {
                $count = CafeRestoReservation::whereDate('created_at', today())->count();
                $model->reservation_code = 'CR' . date('Ymd') . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
