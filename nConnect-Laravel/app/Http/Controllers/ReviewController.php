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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = $request->name . '.' . $request->image->extension();
        $path = $request->file('image')->storeAs('public/images/reviews/', $imageName);
        $relativePath = str_replace('public/', '', $path);
        $reviews = new Review();
        $reviews->name = $request->input('name');
        $reviews->text = $request->input('text');
        $reviews->image = $relativePath;
        $currentConferenceId = Conference::where('is_current', true)->value('id');
        $reviews->conference_id = $currentConferenceId;
        $reviews->save();
        return response()->json("Review Added");
    }

    public function destroy($id)
    {
        $reviews = Review::find($id);
        $filePath = storage_path('app/public/' . $reviews->image);
        File::delete($filePath);
        $reviews->delete();
        return response()->json("Review Deleted");
    }

    public function update(Request $request, $id)
    {
        $reviews = Review::find($id);
        if ($request->has('image') && !empty($request->image)) {
            $filePath = storage_path('app/public/' . $reviews->image);
            File::delete($filePath);
        }
        $data = $request->validate([
            'name' => ['required',],
            'text' => ['required', 'string', 'max:255',],
            'image' =>[ 'nullable']
        ]);

        $reviews->update($data);
        return response()->json($data);
    }

        public function uploadReviewImage(Request $request)
        {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images/reviews', $imageName);

            return response()->json(['image_path' => 'images/reviews/'. $imageName]);
        }
    }



