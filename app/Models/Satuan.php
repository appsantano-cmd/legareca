<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class Satuan extends Model
{
    use HasFactory, Loggable;

    protected $table = 'satuan';
    protected $fillable = ['nama_satuan'];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}