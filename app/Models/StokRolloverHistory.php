<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokRolloverHistory extends Model
{
    use HasFactory;

    protected $table = 'stok_rollover_history';
    
    protected $fillable = [
        'from_bulan',
        'from_tahun',
        'to_bulan',
        'to_tahun',
        'total_barang',
        'total_nilai',
        'catatan'
    ];
}