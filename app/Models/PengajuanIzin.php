<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanIzin extends Model
{
    protected $table = 'pengajuan_izin';

    protected $fillable = [
        'nama',
        'divisi',
        'jenis_izin',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'keterangan_tambahan',
        'nomor_telepon',
        'alamat',
        'documen_pendukung',
        'konfirmasi',
        'status',
    ];
}
