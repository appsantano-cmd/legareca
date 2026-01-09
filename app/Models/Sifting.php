<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sifting extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'shift_requests';

    /**
     * Kolom yang boleh diisi mass assignment
     */
    protected $fillable = [
        // STEP 1
        'nama_karyawan',

        // STEP 2
        'divisi_jabatan',

        // STEP 3 – SHIFT ASLI
        'tanggal_shift_asli',
        'jam_shift_asli',

        // STEP 3 – SHIFT TUJUAN
        'tanggal_shift_tujuan',
        'jam_shift_tujuan',

        // STEP 4
        'alasan',

        // STEP 5
        'sudah_pengganti',
        'tanggal_shift_pengganti',
        'jam_shift_pengganti',

        // ADMIN
        'status',
        'catatan_admin',
    ];

    /**
     * Default attribute values
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'tanggal_shift_asli' => 'date',
        'tanggal_shift_tujuan' => 'date',
        'tanggal_shift_pengganti' => 'date',
    ];
}
