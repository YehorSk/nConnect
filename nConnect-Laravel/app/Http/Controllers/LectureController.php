<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Lecture;
use App\Models\Speaker;
use App\Models\Stage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LectureController extends Controller
{
    public function index(){
        $lectures = Lecture::all();
        return response()->json($lectures);
    }
    public function get_lecture_users($id){
        $lecture = Lecture::find($id);
        $users = $lecture->users;
        return response()->json($users);
    }
    public function get_current_conference_lectures(){
        $conference = Conference::query()->where("is_current", true)->first();
        $lectures = $conference->lectures()->with('speaker', 'stage')->get();

        $lectures = $lectures->map(function ($lecture) {
            $speakerId = $lecture->speaker ? $lecture->speaker->id : null;
            $speakerName = $lecture->speaker ? $lecture->speaker->first_name : null;
            $speakerImage = $lecture->speaker ? $lecture->speaker->picture : null;
            $speakerLastName= $lecture->speaker ? $lecture->speaker->last_name : null;
            $speakerCompany= $lecture->speaker ? $lecture->speaker->company : null;
            return [
                'id' => $lecture->id,
                'name' => $lecture->name,
                'capacity' => $lecture->capacity,
                'remaining_spots'=>$lecture->remaining_spots,
                'start_time' => $lecture->start_time,
                'end_time' => $lecture->end_time,
                'short_desc' => $lecture->short_desc,
                'long_desc' => $lecture->long_desc,
                'is_lecture' => $lecture->is_lecture,
                'stage_name' => $lecture->stage->name,
                'stage_id' => $lecture->stage->id,
                'speaker_id' => $speakerId,
                'speaker_name' => $speakerName,
                'speaker_lastname' => $speakerLastName,
                'speaker_image' => $speakerImage,
                'speaker_company' => $speakerCompany,
            ];
        });

        return response()->json($lectures);
    }



    public function store(Request $request)
    {
        if($request['is_lecture']===true){
            $data = $request->validate([
                'name' => 'required',
                'capacity' => 'required',
                'stage_id'=>'required',
                'speaker_id'=>'required',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'short_desc' => 'required',
                'long_desc' => 'required',
                'is_lecture' => 'required',
            ]);
        }else{
            $data = $request->validate([
                'name' => 'required',
                'stage_id'=>'required',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'short_desc' => 'required',
                'is_lecture' => 'required',
            ]);
        }

        $conference = Conference::query()->where("is_current",true)->first();
        $data['conference_id'] = $conference->id;
        $lecture = new Lecture($data);
        $lecture->save();

        return response()->json('Lecture created successfully', 201);
    }
    public function update(Request $request, $id)
    {
        $lecture = Lecture::find($id);
        if($lecture->is_lecture===1){
            $data = $request->validate([
                'name' => 'required',
                'capacity' => 'required',
                'stage_id'=>'required',
                'speaker_id'=>'required',
                'start_time' => 'required|date_format:H:i:s',
                'end_time' => 'required|date_format:H:i:s|after:start_time',
                'short_desc' => 'required',
                'long_desc' => 'required',
            ]);
        }else{
            $data = $request->validate([
                'name' => 'required',
                'stage_id'=>'required',
                'start_time' => 'required|date_format:H:i:s',
                'end_time' => 'required|date_format:H:i:s|after:start_time',
                'short_desc' => 'required',
            ]);
        }

        $lecture ->update($data);
        return response()->json("Lecture Updated");

    }


    public function destroy($id){
        $lecture = Lecture::find($id);
        $lecture->delete();
        return response()->json("Lecture Deleted");
    }



}
