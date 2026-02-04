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
                'title'         => 'Aji Exhibition',
                'short_description'   => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'description'   => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'artist'        => 'Leonardo da Vinci',
                'location'      => 'Museum Louvre, Paris',
                'start_date'    => '2024-01-01',
                'end_date'      => '2024-12-31',
                'image_path'    => 'art_gallery/exhibition1.jpeg',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'title'         => 'Tama Seni Modern',
                'short_description'   => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'description'   => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'artist'        => 'Maurizio Cattelan',
                'location'      => 'Museum Modern, New York',
                'start_date'    => '2019-01-01',
                'end_date'      => '2019-12-31',
                'image_path'    => 'art_gallery/exhibition2.jpeg',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'title'         => 'Pameran Seni Rupa Kontemporer',
                'short_description'   => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'description'   => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'artist'        => 'Yayoi Kusama',
                'location'      => 'Tate Modern, London',
                'start_date'    => '2026-02-01',
                'end_date'      => '2026-02-28',
                'image_path'    => 'art_gallery/exhibition3.jpeg',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'title'         => 'Pameran Seni Robotik',
                'short_description'   => 'lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'description'   => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'artist'        => 'Jackson Pollock',
                'location'      => 'Guggenheim Museum, New York',
                'start_date'    => '2026-03-01',
                'end_date'      => '2026-04-30',
                'image_path'    => 'art_gallery/exhibition4.jpg',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]
        ]);
    }
}