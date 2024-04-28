<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
{
    //
    public function index(){
        $gallery = Gallery::all();
        return response()->json($gallery);
    }
    public function store(Request $request){
        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'year' => 'required|unique:galleries',
        ]);
        Gallery::create($data);
        return response()->json("Image Added");
    }
    public function update(Request $request, $id)
    {
        $gallery= Gallery::find($id);

        $data = $request->validate([
            'image' => [
                'required',
            ],
            'year' => [
                'required',
            ],
        ]);

        $gallery->update($data);

        return response()->json("Image Updated");
    }
    public function destroy($id){
        $gallery = Gallery::find($id);
        $gallery->delete();
        return response()->json("Image Deleted");
    }

}
