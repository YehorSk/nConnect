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
    public function get_current_conference_gallery(){
        $conference = Conference::query()->where("is_current",true)->first();
        $gallery = $conference->gallery;
        return response()->json($gallery);
    }
    public function get_available_gallery(){
        $conference = Conference::query()->where("is_current", true)->first();
        $allGallery = Gallery::all();
        $currentConferenceGallery = $conference->gallery;
        $availableGallery = $allGallery->diff($currentConferenceGallery);
        return response()->json($availableGallery);
    }
    public function addGalleryToConference(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
        ]);
        $gallery = Gallery::find($data['id']);
        $currentConferenceId = Conference::where('is_current', true)->value('id');

        $newGallery = new Gallery([
            'conference_id' => $currentConferenceId,
            'image' => $gallery->image,
            'year' => $gallery->year
        ]);
        $newGallery->save();

        return response()->json("Gallery Added");
    }

    public function deleteGalleryFromConference($id){
        $gallery = Gallery::find($id);
        $gallery->delete();
        return response()->json("Gallery Deleted");
    }




    public function destroy($id){
        $gallery = Gallery::find($id);
        $filePath = storage_path('app/public/' . $gallery->image);
        File::delete($filePath);
        $gallery->delete();
        return response()->json("Image Deleted");
    }

}
