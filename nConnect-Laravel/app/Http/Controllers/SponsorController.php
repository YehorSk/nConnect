<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SponsorController extends Controller
{
    public function index(){
        $sponsors = Sponsor::all();
        return response()->json($sponsors);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'link' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = $request->name.'.'.$request->image->extension();
        $request->image->move('C:\xampp\htdocs\nConnect\nConnect_Vue\public\images\sponsors', $imageName);
        $sponsor = new Sponsor();
        $sponsor->name = $request->input('name');
        $sponsor->link = $request->input('link');
        $sponsor->image = 'images/sponsors/'.$imageName;
        $sponsor->save();
        return response()->json("Sponsor Created");
    }
    public function destroy($id){
        $sponsor = Sponsor::find($id);
        $fileName = 'C:/xampp/htdocs/nConnect/nConnect_Vue/public/'.$sponsor->image;
        File::delete($fileName);
        $sponsor->delete();
        return response()->json("Sponsor Deleted");
    }
}
