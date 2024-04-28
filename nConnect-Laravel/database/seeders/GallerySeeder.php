<?php

namespace Database\Seeders;

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
        $gallery = new Gallery();
        $gallery->image= asset('public/images/galeria/g1.jpg');
        $gallery->year=2024;
        $gallery->save();
    }
}
