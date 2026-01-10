<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyCleaningReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'departments',
        'work_completed',
        'membership_datetime',
        'toilet_photo_path',
        'status',
        'report_date'
    ];

    protected $casts = [
        'departments' => 'array',
        'report_date' => 'date',
        'membership_datetime' => 'datetime'
    ];
}