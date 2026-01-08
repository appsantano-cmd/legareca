<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScreeningPet extends Model
{
    use HasFactory;

    protected $fillable = [
        'screening_id',
        'name',
        'breed',
        'sex',
        'age',
        'vaksin',
        'kutu',
        'jamur',
        'birahi',
        'kulit',
        'telinga',
        'riwayat'
    ];

    /**
     * Relasi ke screening
     */
    public function screening(): BelongsTo
    {
        return $this->belongsTo(Screening::class);
    }

    /**
     * Format nama lengkap dengan breed
     */
    public function getFullNameAttribute(): string
    {
        return $this->name . ' (' . $this->breed . ')';
    }

    /**
     * Cek apakah anabul sehat berdasarkan semua kriteria
     */
    public function isHealthy(): bool
    {
        $negativeCategories = ['kutu', 'jamur', 'birahi', 'kulit', 'telinga'];
        
        foreach ($negativeCategories as $category) {
            if ($this->$category !== 'Negatif') {
                return false;
            }
        }

        return $this->vaksin === 'Sudah lengkap' && $this->riwayat === 'Sehat';
    }

    /**
     * Dapatkan ringkasan kesehatan
     */
    public function getHealthSummaryAttribute(): array
    {
        return [
            'vaksin' => $this->vaksin,
            'kutu' => $this->kutu,
            'jamur' => $this->jamur,
            'birahi' => $this->birahi,
            'kulit' => $this->kulit,
            'telinga' => $this->telinga,
            'riwayat' => $this->riwayat,
            'is_healthy' => $this->isHealthy()
        ];
    }
}