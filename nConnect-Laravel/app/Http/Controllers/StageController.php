<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StageController extends Controller
{
    //
    public function index(){
        $stages = Stage::all();
        return response()->json($stages);
    }
    public function get_current_conference_stages(){
        $conference = Conference::query()->where("is_current",true)->first();
        $stages = $conference->stages;
        return response()->json($stages);
    }

    public function get_available_stages(){
        $conference = Conference::query()->where("is_current", true)->first();
        $allStages = Stage::all();
        $currentConferenceStages = $conference->stages;
        $availableStages = $allStages->diff($currentConferenceStages);
        return response()->json($availableStages);
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|unique:stages',
            'date' => 'required|unique:stages',
        ]);
        $stage = new Stage($data);
        $stage->save();

        return response()->json("Stage Created");
    }

    public function addStageToConference(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
        ]);
        $stage = Stage::find($data['id']);
        $conference = Conference::query()->where("is_current",true)->first();
        $conference->stages()->attach($stage);
        return response()->json("Stage Added");
    }

    public function deleteStageFromConference($id){
        $stage = Stage::find($id);
        $conference = Conference::query()->where("is_current",true)->first();
        $conference->stages()->detach($stage);
        return response()->json("Stage Deleted");
    }

    public function update(Request $request, $id)
    {
        $stage = Stage::find($id);

        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('stages')->ignore($stage),
            ],
            'date' => [
                'required',
                Rule::unique('stages')->ignore($stage),
            ],
        ]);

        $stage->update($data);

        return response()->json("Stage Updated");
    }


    public function destroy($id){
        $stage = Stage::find($id);
        $stage->delete();
        return response()->json("Stage Deleted");
    }

}
