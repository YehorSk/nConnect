<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
{
    public function index(){
        $gallery = Gallery::paginate(5);
        return response()->json($gallery);
    }

    public function indexAll(){
        $gallery = Gallery::all();
        return response()->json($gallery);
    }

    public function store(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'year' => 'required',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $path = $request->file('image')->storeAs('public/images/gallery', $imageName);
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

    public function update(Request $request, $id){
        $gallery = Gallery::find($id);
        if ($request->has('image') && !empty($request->image)) {
            $filePath = storage_path('app/public/' . $gallery->image);
            File::delete($filePath);
        }
        $data = $request->validate([
            'image'=> ['nullable', Rule::unique('galleries')->ignore($gallery->id),
                ],
            'year'=> ['required',
            ],
        ]);
        $gallery->update($data);
        return response()->json($data);
    }
    public function uploadGalleryImage(Request $request){
        $request->validate([
            'image'=> 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = time().'.'.$request->image->extension();
        $request->image->storeAs('public/images/gallery', $imageName);

        return response()->json(['image_path'=> 'images/gallery/'. $imageName]);
    }

}
