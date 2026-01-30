<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterStokGudang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_stok_gudang';
    
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'satuan',
        'departemen',
        'supplier',
        'stok_awal',
        'tanggal_submit'
    ];

    protected $casts = [
        'stok_awal' => 'decimal:2',
        'tanggal_submit' => 'date'
    ];

    // Relationship dengan stok gudang (detail)
    public function detailStok()
    {
        return $this->hasMany(StokGudang::class, 'kode_barang', 'kode_barang');
    }
}