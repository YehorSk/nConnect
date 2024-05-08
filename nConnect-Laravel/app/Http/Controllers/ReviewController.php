<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\File;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'text' => 'required|string|min:5|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = $request->name . '.' . $request->photo->extension();
        $path = $request->file('photo')->storeAs('public/images/reviews/', $imageName);
        $relativePath = str_replace('public/', '', $path);
        $review = new Review();
        $review->name = $request->input('name');
        $review->text = $request->input('text');
        $review->photo = $relativePath;
        $currentConferenceId = Conference::where('is_current', true)->value('id');
        $review->conference_id = $currentConferenceId;
        $review->save();
        return response()->json("Review Added");
    }
    public function destroy($id){
        $review = Review::find($id);
        $filePath = storage_path('app/public/' . $review->photo);
        File::delete($filePath);
        $review->delete();
        return response()->json("Review Deleted");
    }

}
