<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CafeRestoReservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'date',
        'time',
        'guests',
        'table_type',
        'special_request',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
    ];
}