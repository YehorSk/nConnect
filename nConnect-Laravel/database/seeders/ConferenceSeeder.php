<?php

namespace Database\Seeders;

use App\Models\Conference;
use Illuminate\Database\Seeder;

class ConferenceSeeder extends Seeder
{
    public function run()
    {
        $conference = new Conference();
        $conference->year = 2024;
        $conference->name = "nConnect24";
        $conference->is_current = true;
        $conference->save();
        $conference = new Conference();
        $conference->year = 2024;
        $conference->name = "nConnect24";
        $conference->is_current = false;
        $conference->save();


    }


}
