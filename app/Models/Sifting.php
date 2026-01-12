<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sifting extends Model
{
    use HasFactory;

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
    ];

    protected $casts = [
        'tanggal_shift_asli' => 'date',
        'tanggal_shift_tujuan' => 'date',
        'tanggal_shift_pengganti' => 'date',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];
}
