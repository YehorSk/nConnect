<?php

namespace Database\Seeders;

use App\Models\Conference;
use App\Models\Stage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stage = new Stage();
        $stage->name = "SOFT DEV STAGE";
        $stage->save();
        $stage2 = new Stage();
        $stage2->name = "AI&DATA STAGE";
        $stage2->save();

        $conference = Conference::query()->where("is_current",1)->first();
        $conference->stages()->attach($stage,['date' => "14.MAREC"]);
        $conference->stages()->attach($stage2,['date' => "14.MAREC"]);
    }
}
