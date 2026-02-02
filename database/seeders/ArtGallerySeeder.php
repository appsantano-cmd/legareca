<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArtGallerySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('art_galleries')->insert([
            [
                'title'         => 'Mona Lisa',
                'short_description'   => 'Lukisan karya Leonardo da Vinci yang sangat terkenal.',
                'description'   => 'Mona Lisa adalah sebuah lukisan potret yang dibuat oleh seniman Italia Leonardo da Vinci. Lukisan ini terkenal karena senyumnya yang misterius dan teknik sfumato yang digunakan oleh da Vinci.',
                'artist'        => 'Leonardo da Vinci',
                'creation_date' => '1503-01-01',
                'image_path'    => 'art_gallery/Monalisa.jpg',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'title'         => 'Banana Lakban Hitam',
                'short_description'   => 'Karya seni kontemporer oleh Maurizio Cattelan.',
                'description'   => 'Banana Lakban Hitam adalah sebuah karya seni kontemporer yang dibuat oleh seniman Italia Maurizio Cattelan. Karya ini menampilkan sebuah pisang yang direkatkan ke dinding menggunakan lakban hitam, yang menimbulkan berbagai interpretasi tentang seni dan nilai estetika.',
                'artist'        => 'Maurizio Cattelan',
                'creation_date' => '2019-01-01',
                'image_path'    => 'art_gallery/banana_lakban.jpg',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}