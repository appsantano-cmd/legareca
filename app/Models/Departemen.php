<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class Departemen extends Model
{
    use HasFactory, Loggable;

    protected $table = 'departemen';
    protected $fillable = ['nama_departemen'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}