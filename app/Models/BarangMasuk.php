<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangMasuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang_masuk';

    protected $fillable = [
        'tanggal_masuk',
        'supplier',
        'nama_barang',
        'jumlah_masuk',
        'satuan',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'jumlah_masuk' => 'integer'
    ];

    // Jika ingin custom scope untuk data yang aktif
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    // Scope untuk data yang dihapus (trash)
    public function scopeTrashed($query)
    {
        return $query->whereNotNull('deleted_at');
    }
}