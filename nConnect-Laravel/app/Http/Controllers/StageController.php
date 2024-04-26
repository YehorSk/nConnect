<?php

namespace App\Http\Controllers;

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

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|unique:stages',
            'date' => 'required|unique:stages',
        ]);
        Stage::create($data);
        return response()->json("Stage Created");
    }

    public function update(Request $request,$id)
    {
        $data = $request->validate([
            'name' => 'required',
            'date' => 'required'
        ]);
        $stage = Stage::find($id);
        $stage->update($data);
        return response()->json("Stage Updated");
    }

    public function destroy($id){
        $stage = Stage::find($id);
        $stage->delete();
        return response()->json("Stage Deleted");
    }

}
