<?php

namespace Database\Seeders;

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
        $stage->date = "14.MAREC";
        $stage->save();
        $stage = new Stage();
        $stage->name = "AI&DATA STAGE";
        $stage->date = "14.MAREC";
        $stage->save();
    }
}
