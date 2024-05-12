<?php

namespace Database\Seeders;

use App\Models\Conference;
use App\Models\Organizer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizers = [
            [
                'email' => 'dhalvonik@ukf.sk',
                'phone_number'=> '+421 902 170 744',
                'name' => 'DOMINIK HALVONÍK',
                'image' => 'images\organizers\cp1.jpg',
            ],
            [
                'email' => 'jreichel@ukf.sk',
                'phone_number'=> '+421 904 687 757',
                'name' => 'JAROSLAV REICHEL',
                'image' => 'images\organizers\cp2.jpg',
            ],
        ];

        foreach ($organizers as $organizerData) {
            $organizer = new Organizer();
            $organizer->email = $organizerData['email'];
            $organizer->phone_number = $organizerData['phone_number'];
            $organizer->name = $organizerData['name'];
            $organizer->image = $organizerData['image'];
            $organizer->save();
            $conference = Conference::find(1);
            $conference->organizers()->attach($organizer);
        }
    }
}
