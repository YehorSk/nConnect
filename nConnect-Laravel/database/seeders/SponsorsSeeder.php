<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsors = [
            [
                'link' => 'https://gymbeam.sk/',
                'name' => 'GymBeam',
                'image' => 'images\sponsors\GymBeam.png',
            ],
            [
                'link' => 'https://www.powerplay.studio/',
                'name' => 'PowerPlay',
                'image' => 'images\sponsors\PowerPlay.png',
            ],
            [
                'link' => 'https://www.fpvai.ukf.sk/en/',
                'name' => 'FPVai',
                'image' => 'images\sponsors\fpvai.png',
            ],
            [
                'link' => 'https://www.facebook.com/CSNitra',
                'name' => 'CSNitra',
                'image' => 'images\sponsors\CSNitra.png',
            ],
        ];

        foreach ($sponsors as $sponsorData) {
            $sponsor = new Sponsor();
            $sponsor->link = $sponsorData['link'];
            $sponsor->name = $sponsorData['name'];
            $sponsor->image = $sponsorData['image'];
            $sponsor->save();
        }
    }
}
