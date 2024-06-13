<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SpeakerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $speakers = Speaker::query()
            ->when($search, function ($query, $search) {
                return $query->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->paginate(5);

        return response()->json($speakers);
    }
    public function show($id) {
        $speaker = Speaker::findOrFail($id);
        return response()->json($speaker);
    }

    public function get_current_conference_speakers(){
        $conference = Conference::query()->where("is_current",true)->first();
        $speakers = $conference->speakers;
        return response()->json($speakers);
    }

    public function get_available_speakers(){
        $conference = Conference::query()->where("is_current", true)->first();
        $allSpeakers = Speaker::all();
        $currentConferenceSpeakers = $conference->speakers;
        $availableSpeakers = $allSpeakers->diff($currentConferenceSpeakers);
        return response()->json($availableSpeakers);
    }

    public function addSpeakersToConference(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
        ]);
        $speakers = Speaker::find($data['id']);
        $conference = Conference::query()->where("is_current",true)->first();
        $conference->speakers()->attach($speakers);
        return response()->json("Speaker Added");
    }

    public function deleteSpeakerFromConference($id){
        $speakers = Speaker::find($id);
        $conference = Conference::query()->where("is_current", true)->first();
        $conference->speakers()->detach($speakers);
        return response()->json("Speaker Deleted");
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'short_desc' => 'required',
            'long_desc' => 'required',
            'company' => 'required',
            'instagram' => 'nullable|url',
            'linkedIn' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = time().'.'.$request->first_name . '_' . $request->last_name . '.' . $request->image->extension();

        $path = $request->file('image')->storeAs('public/images/speakers', $imageName);

        $relativePath = str_replace('public/', '', $path);

        $speaker = new Speaker();
        $speaker->first_name = $request->input('first_name');
        $speaker->last_name = $request->input('last_name');
        $speaker->short_desc = $request->input('short_desc');
        $speaker->long_desc = $request->input('long_desc');
        $speaker->company = $request->input('company');
        $speaker->instagram = $request->input('instagram');
        $speaker->linkedIn = $request->input('linkedIn');
        $speaker->facebook = $request->input('facebook');
        $speaker->twitter = $request->input('twitter');
        $speaker->picture = $relativePath;
        $speaker->save();


        return response()->json("Speaker Created");
    }


    public function destroy($id){
        $speaker = Speaker::find($id);
        $filePath = storage_path('app/public/' . $speaker->picture);
        File::delete($filePath);
        $speaker->delete();
        return response()->json("Speaker Deleted");
    }
    public function update(Request $request, $id)
    {
        $speaker = Speaker::find($id);
        if ($request->has('picture') && !empty($request->picture)) {
            $filePath = storage_path('app/public/' . $speaker->picture);
            File::delete($filePath);
        }

        $data = $request->validate([
            'first_name' => [
                'required'
            ],
            'last_name' => [
                'required'
            ],
            'short_desc' => [
                'required'
            ],
            'long_desc' => [
                'required'
            ],
            'Company' => [
                'required'
            ],
            'Instagram' => [
                'nullable'
            ],
            'LinkedIn' => [
                'nullable'
            ],
            'Facebook' => [
                'nullable'
            ],
            'Twitter' => [
                'nullable'
            ],
            'picture' => [
                'nullable'
            ],
        ]);


        $speaker->update($data);

        return response()->json($data);
    }
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->storeAs('public/images/speakers', $imageName);

        return response()->json(['image_path' => 'images/speakers/'.$imageName]);
    }

}
