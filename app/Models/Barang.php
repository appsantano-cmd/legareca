<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'satuan_utama',
        'faktor_konversi',
        'stok_awal',
        'stok_sekarang',
        'status'
    ];

    protected $casts = [
        'faktor_konversi' => 'decimal:4',
        'stok_awal' => 'decimal:2',
        'stok_sekarang' => 'decimal:2',
        'status' => 'boolean'
    ];

    /**
     * Generate kode barang otomatis
     */
    public static function generateKodeBarang($count = 1)
    {
        $lastBarang = self::withTrashed()
            ->where('kode_barang', 'LIKE', 'AA%')
            ->orderBy('kode_barang', 'desc')
            ->first();

        $lastNumber = 0;

        if ($lastBarang) {
            $lastCode = $lastBarang->kode_barang;
            $lastNumber = (int) substr($lastCode, 2);
        }

        $kodeBarang = [];

        for ($i = 1; $i <= $count; $i++) {
            $newNumber = $lastNumber + $i;
            $kodeBarang[] = 'AA' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }

        return $count === 1 ? $kodeBarang[0] : $kodeBarang;
    }

    /**
     * Scope untuk barang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get total stok untuk barang dengan nama yang sama
     */
    public function getTotalStokAttribute()
    {
        return self::where('nama_barang', $this->nama_barang)
            ->where('status', true)
            ->sum('stok_sekarang');
    }

    /**
     * Update stok saat ada transaksi
     */
    public function updateStok($jumlah, $type = 'masuk')
    {
        if ($type === 'masuk') {
            $this->stok_sekarang += $jumlah;
        } else {
            $this->stok_sekarang -= $jumlah;
        }

        $this->save();
    }

    /**
     * Boot method untuk menghitung total stok setelah create
     */
    protected static function boot()
    {
        parent::boot();

        // Set stok_sekarang = stok_awal saat create
        static::creating(function ($model) {
            $model->stok_sekarang = $model->stok_awal;
        });

        // Update total stok di semua barang dengan nama sama (opsional)
        static::saved(function ($model) {
            // Anda bisa menambahkan logika untuk sinkronisasi stok total di sini
        });
    }
}
