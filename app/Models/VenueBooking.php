<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class VenueBooking extends Model
{
    use HasFactory, Loggable;

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
        'jam_mulai',
        'jam_selesai',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_jam',
        'durasi_hari',
        'durasi_minggu',
        'durasi_bulan',
        'perkiraan_peserta',
        'status',
    ];
}
