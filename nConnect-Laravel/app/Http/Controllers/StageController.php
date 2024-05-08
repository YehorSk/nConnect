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
        $conference = Conference::query()->where("is_current",true)->first();
        $stages = $conference->stages;
        return response()->json($stages);
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|unique:stages',
            'date' => 'required|unique:stages',
        ]);
        $stage = new Stage($data);
        $stage->save();
        $conference = Conference::query()->where("is_current",true)->first();
        $conference->stages()->attach($stage);
        return response()->json("Stage Created");
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
