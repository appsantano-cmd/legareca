<?php
// app/Models/KamiDaur.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KamiDaur extends Model
{
    use HasFactory;

    protected $table = 'kami_daurs';

    protected $fillable = [
        'products',
        'materials',
        'is_active'
    ];

    protected $casts = [
        'products' => 'array',
        'materials' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Get active configurations
     */
    public static function getActiveConfigs()
    {
        return self::where('is_active', true)->orderBy('created_at', 'desc')->get();
    }
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
    }
}