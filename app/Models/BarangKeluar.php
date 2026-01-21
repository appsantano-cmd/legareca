<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangKeluar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang_keluar';
    
    protected $fillable = [
        'tanggal_keluar',
        'department',
        'barang_id',
        'jumlah_keluar',
        'satuan_id',
        'keperluan',
        'nama_penerima',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
        'jumlah_keluar' => 'decimal:5',
    ];

    /**
     * Relasi ke barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    /**
     * Relasi ke satuan
     */
    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    /**
     * Scope untuk filtering
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('nama_penerima', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%")
                    ->orWhereHas('barang', function ($query) use ($search) {
                        $query->where('nama_barang', 'like', "%{$search}%")
                              ->orWhere('kode_barang', 'like', "%{$search}%");
                    });
            });
        });

        $query->when($filters['department'] ?? false, function ($query, $department) {
            return $query->where('department', $department);
        });

        $query->when($filters['start_date'] ?? false, function ($query, $startDate) {
            return $query->whereDate('tanggal_keluar', '>=', $startDate);
        });

        $query->when($filters['end_date'] ?? false, function ($query, $endDate) {
            return $query->whereDate('tanggal_keluar', '<=', $endDate);
        });
    }
}