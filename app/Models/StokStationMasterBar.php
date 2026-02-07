<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\Loggable;

class StokStationMasterBar extends Model
{
    use HasFactory, Loggable;

    protected $table = 'stok_stations_master_bar';

    protected $fillable = [
        'tanggal',
        'kode_bahan',
        'nama_bahan',
        'nama_satuan',
        'stok_awal',
        'stok_minimum',
        'status_stok',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'stok_awal' => 'decimal:2',
        'stok_minimum' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate kode bahan otomatis untuk bar (MIxxx)
            $model->kode_bahan = self::generateKodeBahanBar();

            // Set status stok
            if ($model->stok_awal <= $model->stok_minimum) {
                $model->status_stok = 'REORDER';
            } else {
                $model->status_stok = 'SAFE';
            }
        });

        static::updating(function ($model) {
            // Update status stok
            if ($model->stok_awal <= $model->stok_minimum) {
                $model->status_stok = 'REORDER';
            } else {
                $model->status_stok = 'SAFE';
            }
        });
    }

    /**
     * Generate kode bahan untuk bar dengan format MIxxx
     * Contoh: MI001, MI002, MI010, MI100
     */
    public static function generateKodeBahanBar()
    {
        $lastKode = DB::table('stok_stations_master_bar')
            ->where('kode_bahan', 'LIKE', 'MI%')
            ->orderBy('kode_bahan', 'desc')
            ->first('kode_bahan');

        if ($lastKode) {
            // Ambil angka dari kode terakhir
            $lastNumber = intval(substr($lastKode->kode_bahan, 2));
            $nextNumber = $lastNumber + 1;
            // Format dengan leading zeros
            $nextKode = 'MI' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        } else {
            // Jika tidak ada data, mulai dari MI001
            $nextKode = 'MI001';
        }

        return $nextKode;
    }
}