<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyCleaningReport extends Model
{
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