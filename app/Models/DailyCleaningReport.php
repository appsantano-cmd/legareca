<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class DailyCleaningReport extends Model
{
    use Loggable;

    protected $table = 'daily_cleaning_reports';

    protected $fillable = [
        'nama',
        'tanggal',
        'departemen',
        'foto_path',
        'membership_datetime',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'membership_datetime' => 'datetime'
    ];
}