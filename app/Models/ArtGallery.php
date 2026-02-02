<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtGallery extends Model
{
    protected $table = 'art_galleries';

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'artist',
        'creation_date',
        'image_path',
    ];
}
