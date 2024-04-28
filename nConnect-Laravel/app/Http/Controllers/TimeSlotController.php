<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $data = $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'time' => 'required|date_format:H:i|unique:time_slots,time,null,id,stage_id,' . $request->input('stage_id'),
        ]);
        TimeSlot::create($data);

        return response()->json("Time Slot Created");
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
            'time' => [
                'required',
                'date_format:H:i',
                Rule::unique('time_slots')->where(function ($query) use ($timeSlot) {
                    return $query->where('stage_id', $timeSlot->stage_id);
                })->ignore($timeSlot->id),
            ],
        ]);

        $timeSlot->time = $data['time'];
        $timeSlot->save();

        return response()->json("TimeSlot Updated");
    }



}
