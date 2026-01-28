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
        'kutu_action',
        'jamur',
        'birahi',
        'birahi_action',
        'kulit',
        'telinga',
        'riwayat',
        'status'
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
            'kutu' => $this->kutu . ($this->kutu_action ? " [" . $this->getActionText($this->kutu_action) . "]" : ""),
            'jamur' => $this->jamur,
            'birahi' => $this->birahi . ($this->birahi_action ? " [" . $this->getActionText($this->birahi_action) . "]" : ""),
            'kulit' => $this->kulit,
            'telinga' => $this->telinga,
            'riwayat' => $this->riwayat,
            'is_healthy' => $this->isHealthy()
        ];
    }

    /**
     * Format teks untuk action
     */
    private function getActionText($action): string
    {
        return match ($action) {
            'tidak_periksa' => 'Tidak Periksa',
            'lanjut_obat' => 'Lanjut Obat',
            default => $action
        };
    }

    /**
     * Cek apakah pet dibatalkan
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled' ||
            $this->kutu_action === 'tidak_periksa' ||
            $this->birahi_action === 'tidak_periksa';
    }

    /**
     * Format status untuk tampilan
     */
    public function getStatusTextAttribute()
    {
        if ($this->kutu_action == 'tidak_periksa' || $this->birahi_action == 'tidak_periksa') {
            return 'Dibatalkan';
        }
        return 'Selesai';
    }

    /**
     * Dapatkan alasan pembatalan
     */
    public function getCancellationReasonAttribute(): ?string
    {
        $reasons = [];

        if ($this->kutu_action === 'tidak_periksa') {
            $reasons[] = "Kutu positif ({$this->kutu})";
        }

        if ($this->birahi_action === 'tidak_periksa') {
            $reasons[] = "Birahi positif";
        }

        if (!empty($reasons)) {
            return implode(', ', $reasons);
        }

        return null;
    }
}