<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenueBooking extends Model
{
    protected $fillable = [
        'nama_pemesan',
        'nomer_wa',
        'email',
        'venue',
        'jenis_acara',
        'tanggal_acara',
        'hari_acara',
        'tahun_acara',
        'jam_acara',
        'durasi_type',
        'durasi_jam',
        'durasi_hari',
        'durasi_minggu',
        'durasi_bulan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'perkiraan_peserta',
        'status',
        'booking_code',
    ];

    protected $casts = [
        'tanggal_acara' => 'date',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'perkiraan_peserta' => 'integer',
        'durasi_jam' => 'integer',
        'durasi_hari' => 'integer',
        'durasi_minggu' => 'integer',
        'durasi_bulan' => 'integer',
    ];
}