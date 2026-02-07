<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class ArtGallery extends Model
{
    use Loggable;
    protected $table = 'art_galleries';

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'artist',
        'location',
        'start_date',
        'end_date',
        'image_path',
    ];
}
