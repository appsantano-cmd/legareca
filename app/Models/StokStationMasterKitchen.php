<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StokStationMasterKitchen extends Model
{
    use HasFactory;

    protected $table = 'stok_stations_master_kitchen';

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
            // Generate kode bahan otomatis untuk kitchen (MAxxx)
            $model->kode_bahan = self::generateKodeBahanKitchen();
            
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
     * Generate kode bahan untuk kitchen dengan format MAxxx
     * Contoh: MA001, MA002, MA010, MA100
     */
    public static function generateKodeBahanKitchen()
    {
        $lastKode = DB::table('stok_stations_master_kitchen')
            ->where('kode_bahan', 'LIKE', 'MA%')
            ->orderBy('kode_bahan', 'desc')
            ->first('kode_bahan');

        if ($lastKode) {
            // Ambil angka dari kode terakhir
            $lastNumber = intval(substr($lastKode->kode_bahan, 2));
            $nextNumber = $lastNumber + 1;
            // Format dengan leading zeros
            $nextKode = 'MA' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        } else {
            // Jika tidak ada data, mulai dari MA001
            $nextKode = 'MA001';
        }

        return $nextKode;
    }
}