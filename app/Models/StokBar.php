<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class StokBar extends Model
{
    use HasFactory, Loggable;

    protected $table = 'stok_bar';

    protected $fillable = [
        'tanggal',
        'shift',
        'kode_bahan',
        'nama_bahan',
        'nama_satuan',
        'stok_awal',
        'stok_masuk',
        'stok_keluar',
        'waste',
        'alasan_waste',
        'status_stok', // Tambah status stok
        'pic'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'stok_awal' => 'decimal:2',
        'stok_masuk' => 'decimal:2',
        'stok_keluar' => 'decimal:2',
        'waste' => 'decimal:2',
    ];

    protected $appends = ['stok_akhir'];

    public function getStokAkhirAttribute()
    {
        return $this->stok_awal + $this->stok_masuk - $this->stok_keluar - $this->waste;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Status stok berdasarkan stok akhir
            // Untuk bar, kita butuh master bar untuk mendapatkan stok minimum
            $master = StokStationMasterBar::where('kode_bahan', $model->kode_bahan)->first();
            if ($master) {
                $model->status_stok = $model->getStokAkhirAttribute() <= $master->stok_minimum ? 'REORDER' : 'SAFE';
            } else {
                $model->status_stok = 'SAFE'; // Default jika tidak ada master
            }
        });
    }

    // Hapus relasi satuan karena sudah jadi string
    // Hapus relasi masterBahan karena sudah jadi string
}