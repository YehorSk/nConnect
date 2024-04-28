<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    public function index($id){
        $stage = Stage::find($id);
        if($stage){
            $timeslots = $stage->time_slots()->orderBy("time")->get();
            return response()->json($timeslots);
        }
    }
}
