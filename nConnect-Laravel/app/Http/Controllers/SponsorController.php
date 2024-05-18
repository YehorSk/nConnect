<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class SponsorController extends Controller
{
    public function index(){
        $sponsors = Sponsor::all();
        return response()->json($sponsors);
    }

    public function get_current_conference_sponsors(){
        $conference = Conference::query()->where("is_current",true)->first();
        $sponsors = $conference->sponsors;
        return response()->json($sponsors);
    }

    public function get_available_sponsors(){
        $conference = Conference::query()->where("is_current", true)->first();
        $allSponsors = Sponsor::all();
        $currentConferenceSponsors = $conference->sponsors;
        $availableSponsors = $allSponsors->diff($currentConferenceSponsors);
        return response()->json($availableSponsors);
    }

    public function addSponsorsToConference(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
        ]);
        $sponsor = Sponsor::find($data['id']);
        $conference = Conference::query()->where("is_current",true)->first();
        $conference->sponsors()->attach($sponsor);
        return response()->json("Sponsor Added");
    }

    public function deleteSponsorFromConference($id){
        $sponsor = Sponsor::find($id);
        $conference = Conference::query()->where("is_current", true)->first();
        $conference->sponsors()->detach($sponsor);
        return response()->json("Sponsor Deleted");
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'link' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = $request->name.'.'.$request->image->extension();

        $path = $request->file('image')->storeAs('public/images/sponsors/', $imageName);

        $relativePath = str_replace('public/', '', $path);

        $sponsor = new Sponsor();
        $sponsor->name = $request->input('name');
        $sponsor->link = $request->input('link');
        $sponsor->image = $relativePath;
        $sponsor->save();

        $conference = Conference::query()->where("is_current",true)->first();
        $conference->sponsors()->attach($sponsor);

        return response()->json("Sponsor Created");
    }

    public function destroy($id){
        $sponsor = Sponsor::find($id);
        $filePath = storage_path('app/public/' . $sponsor->image);
        File::delete($filePath);
        $sponsor->delete();
        return response()->json("Sponsor Deleted");
    }

    public function update(Request $request, $id)
    {
        $sponsor = Sponsor::find($id);
        if ($request->has('image')&& !empty($request->image)){
            $filePath = storage_path('app/public/'. $sponsor->image);
            File::delete($filePath);
        }
        $data = $request->validate([
            'name'=>[ 'required', Rule::unique('sponsors')->ignore($sponsor->id),],
            'link'=>[ 'required', Rule::unique('sponsors')->ignore($sponsor->id),],
            'image'=>[ 'nullable', Rule::unique('sponsors')->ignore($sponsor->id),]

        ]);
        $sponsor->update($data);
        return response()->json($data);

    }
    public function uploadSponsorImage(Request $request){
        $request->validate([
            'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imageName = time().'.'.$request->image->extension();
        $request->image->storeAs('public/images/sponsors', $imageName);

        return response()->json(['image_path' => 'images/sponsors/'.$imageName]);
    }
}
