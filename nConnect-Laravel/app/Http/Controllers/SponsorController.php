<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Sponsor;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SponsorController extends Controller
{
    public function index(){
        $conference = Conference::query()->where("is_current",true)->first();
        $sponsors = $conference->sponsors;
        return response()->json($sponsors);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'link' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = $request->name.'.'.$request->image->extension();

        $path = $request->file('image')->storeAs('public/images/sponsors/', $imageName);

        $relativePath = str_replace('public/', '', $path);

        $sponsor = new Sponsor();
        $sponsor->name = $request->input('name');
        $sponsor->link = $request->input('link');
        $sponsor->image = $relativePath;
        $sponsor->save();

        $conference = Conference::query()->where("is_current",true)->first();
        $conference->sponsors()->attach($sponsor);

        return response()->json("Sponsor Created");
    }

    public function destroy($id){
        $sponsor = Sponsor::find($id);
        $filePath = storage_path('app/public/' . $sponsor->image);
        File::delete($filePath);
        $sponsor->delete();
        return response()->json("Sponsor Deleted");
    }
}
