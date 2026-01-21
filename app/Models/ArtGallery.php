<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtGallery extends Model
{
    protected $table = 'art_galleries';

    protected $fillable = [
        'title',
        'description',
        'artist',
        'creation_date',
        'price',
        'image_path',
    ];
}
