<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'satuan_input',
        'satuan_utama',
        'faktor'
    ];

    protected $casts = [
        'faktor' => 'decimal:5'
    ];

    /**
     * Scope untuk barang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}