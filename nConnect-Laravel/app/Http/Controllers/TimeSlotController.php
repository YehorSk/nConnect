<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\TimeSlot;
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'time' => 'required|date_format:H:i',
        ]);

        $timeSlot = new TimeSlot();
        $timeSlot->stage_id = $validatedData['stage_id'];
        $timeSlot->time = $validatedData['time'];

        $timeSlot->save();

        return response()->json($timeSlot, 201);
    }
    public function destroy($id){
        $timeSlot = TimeSlot::find($id);
        if(!$timeSlot) {
            return response()->json(["error" => "TimeSlot not found"], 404);
        }
        $timeSlot->delete();
        return response()->json("TimeSlot Deleted");
    }
    public function update(Request $request, $id)
    {
        $timeSlot = TimeSlot::find($id);
        if (!$timeSlot) {
            return response()->json(["error" => "TimeSlot not found"], 404);
        }

        $data = $request->validate([
            'time' => 'required|date_format:H:i:s',
        ]);

        $timeSlot->time = $data['time'];
        $timeSlot->save();

        return response()->json("TimeSlot Updated");
    }



}
