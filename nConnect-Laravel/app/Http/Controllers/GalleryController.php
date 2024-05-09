<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index(){
        $gallery = Gallery::all();
        return response()->json($gallery);
    }
    public function store(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'year' => 'required',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $path = $request->file('image')->storeAs('public/images/gallery/', $imageName);
        $relativePath = str_replace('public/', '', $path);
        $gallery = new Gallery();
        $gallery->image = $relativePath;
        $gallery->year = $request->input('year');

        $currentConferenceId = Conference::where('is_current', true)->value('id');
        $gallery->conference_id = $currentConferenceId;

        $gallery->save();

        return response()->json("Image Added");
    }
    

    public function destroy($id){
        $gallery = Gallery::find($id);
        $filePath = storage_path('app/public/' . $gallery->image);
        File::delete($filePath);
        $gallery->delete();
        return response()->json("Image Deleted");
    }

}
