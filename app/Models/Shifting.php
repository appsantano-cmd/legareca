<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class shifting extends Model
{
    use HasFactory, Loggable;

    protected $table = 'shift_requests';

    protected $fillable = [
        'nama_karyawan',
        'divisi_jabatan',
        'tanggal_shift_asli',
        'jam_shift_asli',
        'tanggal_shift_tujuan',
        'jam_shift_tujuan',
        'alasan',
        'sudah_pengganti',
        'nama_karyawan_pengganti',
        'tanggal_shift_pengganti',
        'jam_shift_pengganti',
        'status',
        'user_id',
        'user_email',
        'catatan_admin',
        'disetujui_oleh',
        'tanggal_persetujuan',
    ];

    protected $casts = [
        'tanggal_shift_asli' => 'date',
        'tanggal_shift_tujuan' => 'date',
        'tanggal_shift_pengganti' => 'date',
        'tanggal_persetujuan' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Get the user that owns the shift request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
