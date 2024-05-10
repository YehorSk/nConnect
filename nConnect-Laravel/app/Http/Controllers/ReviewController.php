<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

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
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $data = $request->validate([
            'name' => 'required', Rule::unique('reviews')->ignore($review),
            'text' => 'required|string|min:5|max:255', Rule::unique('stages')->ignore($review),
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('photo')) {
            $imageName = $request->name . '.' . $request->photo->extension();
            $path = $request->file('photo')->storeAs('public/images/reviews/', $imageName);
            $relativePath = str_replace('public/', '', $path);
            $review->photo = $relativePath;
        }

        $review->update($data);

        return response()->json("Review Updated");
    }



}

