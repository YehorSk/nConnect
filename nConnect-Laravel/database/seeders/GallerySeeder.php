<?php

namespace Database\Seeders;

use App\Models\Conference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gallery = [
            [
                'image' => 'images\gallery\g1.jpg',
                'year'=> 2024,
            ],
            [
                'image' => 'images\gallery\g2.jpg',
                'year'=> 2024,
            ],
            [
                'image' => 'images\gallery\g3.jpg',
                'year'=> 2024,
            ],
            [
                'image' => 'images\gallery\g4.jpg',
                'year'=> 2024,
            ],
            [
                'image' => 'images\gallery\g5.jpg',
                'year'=> 2024,
            ],
            [
                'image' => 'images\gallery\g6.jpg',
                'conference_id'=>1,
                'year'=> 2024,
            ],
            [
                'image' => 'images\gallery\g7.jpg',
                'year'=> 2024,
            ],
            [
                'image' => 'images\gallery\g8.jpg',
                'year'=> 2024,
            ],
            [
                'image' => 'images\gallery\g9.jpg',
                'year'=> 2024,
            ],
        ];
        foreach ($gallery as $galleryData) {
            $gallery = new Gallery();
            $gallery->image = $galleryData['image'];
            $gallery->year = $galleryData['year'];
            $gallery->save();
        }

    }
}
