<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokStationMasterKitchen extends Model
{
    use HasFactory;

    protected $table = 'stok_stations_master_kitchen';

    protected $fillable = [
        'tanggal',
        'kode_bahan',
        'nama_bahan',
        'nama_satuan', // Ubah dari satuan_id
        'stok_minimum', // Hapus stok_awal
        'status_stok',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'stok_minimum' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Status stok untuk master tidak perlu karena stok awal sudah dihapus
            // Status stok akan dihitung dari stok harian
        });
    }

    // Hapus relasi satuan karena sudah jadi string
    // Hapus relasi stokKitchens karena struktur berubah
}