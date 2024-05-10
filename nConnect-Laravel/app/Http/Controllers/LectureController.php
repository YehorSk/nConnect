<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Lecture;
use App\Models\Speaker;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LectureController extends Controller
{
    public function index(){
        $lectures = Lecture::all();
        return response()->json($lectures);
    }
    public function get_current_conference_lectures(){
        $conference = Conference::query()->where("is_current",true)->first();
        $lectures = $conference->lectures;
        return response()->json($lectures);
    }
    public function addSpeakerToLecture(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'speaker_id' => 'required',
        ]);

        $lecture = Lecture::find($data['id']);
        $speaker = Speaker::find($data['speaker_id']);

        if ($lecture->speakers()->where('speaker_id', $speaker->id)->exists()) {
            return response()->json('Speaker is already attached to the lecture');
        }

        $lecture->speaker_id = $speaker->id;
        $lecture->save();

        return response()->json('Speaker added to the lecture');
    }
    public function addStageToLecture(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'stage_id' => 'required',
        ]);

        $lecture = Lecture::find($data['id']);
        $stage = Stage::find($data['stage_id']);

        $lecture->stage_id = $stage->id;
        $lecture->save();

        return response()->json('Stage added to the lecture');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer|min:1',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'short_desc' => 'required',
            'long_desc' => 'required',
        ]);

        $lecture = new Lecture($data);
        $lecture->save();

        return response()->json('Lecture created successfully', 201);
    }
    public function update(Request $request, $id)
    {
        $lecture = Lecture::find($id);
        $data = $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer|min:1',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'short_desc' => 'required',
            'long_desc' => 'required',
        ]);
        $lecture ->update($data);
        return response()->json("Lecture Updated");

    }


    public function destroy($id){
        $lecture = Lecture::find($id);
        $lecture->delete();
        return response()->json("Lecture Deleted");
    }



}
