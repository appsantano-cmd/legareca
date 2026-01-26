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
                'description'   => 'Lukisan karya Leonardo da Vinci yang sangat terkenal.',
                'artist'        => 'Leonardo da Vinci',
                'creation_date' => '1503-01-01',
                'price'         => 1000000000,
                'image_path'    => 'art_gallery/Monalisa.jpg',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'title'         => 'Banana Lakban Hitam',
                'description'   => 'Karya seni kontemporer oleh Maurizio Cattelan.',
                'artist'        => 'Maurizio Cattelan',
                'creation_date' => '2019-01-01',
                'price'         => 12000000,
                'image_path'    => 'art_gallery/banana_lakban.jpg',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}