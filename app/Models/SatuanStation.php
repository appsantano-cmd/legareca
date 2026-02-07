<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class SatuanStation extends Model
{
    use HasFactory, Loggable;

    protected $table = 'satuan_stations';

    protected $fillable = [
        'nama_satuan'
    ];

    public function stokStations()
    {
        return $this->hasMany(StokStation::class);
    }

    public function stokKitchen()
    {
        return $this->hasMany(StokKitchen::class);
    }

    public function stokBar()
    {
        return $this->hasMany(StokBar::class);
    }
}