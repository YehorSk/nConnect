<?php

namespace Database\Seeders;

use App\Models\Stage;
use App\Models\TimeSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSlotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeSlot = new TimeSlot();
        $timeSlot->stage_id = 1;
        $timeSlot->time = "10:00:00";
        $timeSlot->save();
    }
}
