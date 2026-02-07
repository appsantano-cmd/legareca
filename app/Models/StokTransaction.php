<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Loggable;

class StokTransaction extends Model
{
    use HasFactory, Loggable;

    protected $table = 'stok_transactions';

    protected $fillable = [
        'stok_gudang_id',
        'tipe',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'satuan',
        'tanggal',
        'supplier',
        'departemen',
        'keperluan',
        'nama_penerima',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2'
    ];

    public function stokGudang(): BelongsTo
    {
        return $this->belongsTo(StokGudang::class);
    }

    // Scope untuk filter
    public function scopeMasuk($query)
    {
        return $query->where('tipe', 'masuk');
    }

    public function scopeKeluar($query)
    {
        return $query->where('tipe', 'keluar');
    }

    public function scopeTanggal($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }

    public function scopeBySupplier($query, $supplier)
    {
        return $query->where('supplier', 'like', "%{$supplier}%");
    }

    public function scopeByDepartemen($query, $departemen)
    {
        return $query->where('departemen', 'like', "%{$departemen}%");
    }

    // Tipe badge
    public function getTipeBadgeAttribute()
    {
        return $this->tipe == 'masuk' ? 'success' : 'danger';
    }

    // Accessor untuk display berdasarkan tipe
    public function getInfoTipeAttribute()
    {
        if ($this->tipe == 'masuk') {
            return [
                'label' => 'Supplier',
                'value' => $this->supplier
            ];
        } else {
            return [
                'label' => 'Departemen',
                'value' => $this->departemen
            ];
        }
    }
}