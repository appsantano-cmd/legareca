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
        'mission_items' => 'array',
        'products' => 'array',
        'materials' => 'array',
        'impact_stats' => 'array',
        'services' => 'array',
        'payment_methods' => 'array',
        'is_active' => 'boolean',
        'free_shipping_minimum' => 'integer'
    ];

    /**
     * Get active configuration
     */
    public static function getActive()
    {
        return self::where('is_active', true)->latest()->first();
    }
}