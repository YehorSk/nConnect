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
        if ($stage) {
            $timeslots = $stage->time_slots()->orderBy("start_time")->get();
            return response()->json($timeslots);
        }
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        $this->validateNoOverlap($data['stage_id'], $data['start_time'], $data['end_time']);

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
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);
        $this->validateNoOverlap($timeSlot->stage_id, $data['start_time'], $data['end_time'], $id);

        $timeSlot->update($data);

        return response()->json("TimeSlot Updated");
    }

    private function validateNoOverlap($stageId, $startTime, $endTime, $exceptId = null)
    {
        $query = TimeSlot::where('stage_id', $stageId)
            ->where(function($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<', $startTime)
                            ->where('end_time', '>', $endTime);
                    });
            });

        if($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        if($query->exists()) {
            abort(422, 'The time slot overlaps with existing ones.');
        }
    }



}
