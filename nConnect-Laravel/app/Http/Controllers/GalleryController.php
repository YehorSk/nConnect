<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    //
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
        $request->image->move('C:\xampp\htdocs\nConnect\nConnect_Vue\public\images\gallery', $imageName);
        $gallery = new Gallery();
        $gallery->image = 'images/gallery/'.$imageName;
        $gallery->year = $request->input('year');
        $gallery->save();
        return response()->json("Image Added");
    }

    public function destroy($id){
        $gallery = Gallery::find($id);
        $fileName = 'C:/xampp/htdocs/nConnect/nConnect_Vue/public/'.$gallery->image;
        File::delete($fileName);
        $gallery->delete();
        return response()->json("Image Deleted");
    }

}
