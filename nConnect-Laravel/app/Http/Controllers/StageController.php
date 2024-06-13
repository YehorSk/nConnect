<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StageController extends Controller
{
    //
    public function index(Request $request){
        $search = $request->search;
        $stages = Stage::query()
            ->when(
                $search,
                function(Builder $builder) use ($search){
                    $builder->where('name', 'like', "%{$search}%");
                }
            )->paginate(5);
        return response()->json($stages);
    }
    public function get_current_conference_stages(Request $request){
        $search = $request->search;
        $conference = Conference::query()->where("is_current",true)->first();
        if ($conference) {
            $stages = $conference->stages()
                ->when(
                $search,
                function (Builder $builder) use ($search) {
                    $builder->where('name', 'like', "%{$search}%")
                        ->orWhere('date', 'like', "%{$search}%");
                }
            )->paginate(5);
            return response()->json($stages);
        }
        return response()->json(['message' => 'No current conference found'], 404);
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
            'name' => 'required|unique:stages'
        ]);
        $stage = new Stage($data);
        $stage->save();

        return response()->json("Stage Created");
    }

    public function addStageToConference(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'date' => 'required'
        ]);
        $stage = Stage::find($data['id']);
        $conference = Conference::query()->where("is_current",true)->first();
        $conference->stages()->attach($stage,['date' => $data['date']]);
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
            ]
        ]);

        $stage->update($data);

        return response()->json("Stage Updated");
    }

    public function updateInConference(Request $request, $id)
    {
        $stage = Stage::find($id);
        $data = $request->validate([
            'date' => [
                'required'
            ]
        ]);
        $conference = Conference::query()->where("is_current",true)->first();
        $conference->stages()->updateExistingPivot($stage->id, ['date' => $data['date']]);

        return response()->json("Stage Updated");
    }


    public function destroy($id){
        $stage = Stage::find($id);
        $stage->delete();
        return response()->json("Stage Deleted");
    }

}
