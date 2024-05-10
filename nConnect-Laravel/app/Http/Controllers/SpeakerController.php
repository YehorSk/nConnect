<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Speaker;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SpeakerController extends Controller
{
    public function index(){
        $speakers = Speaker::all();
        return response()->json($speakers);
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
            'instagram' => 'required',
            'linkedIn' => 'required',
            'facebook' => 'required',
            'twitter' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = $request->first_name . '_' . $request->last_name . '.' . $request->image->extension();

        $path = $request->file('image')->storeAs('public/images/speakers/', $imageName);

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
}
