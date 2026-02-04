<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanIzin extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_izin';

    protected $fillable = [
        'user_id',
        'user_email',
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
        'status',
        'catatan_admin',
        'disetujui_oleh',
        'tanggal_persetujuan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Get the user that owns the pengajuan izin.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}