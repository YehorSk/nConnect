<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ConferenceSeeder::class,
            StageSeeder::class,
            SpeakersSeeder::class,
            LectureSeeder::class,
            UserSeeder::class,
            SponsorsSeeder::class,
            GallerySeeder::class,
            OrganizersSeeder::class,
            PageSeeder::class,
            ReviewsSeeder::class,
        ]);
    }
}
