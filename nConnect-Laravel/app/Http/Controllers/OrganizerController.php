<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrganizerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $organizers = Organizer::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone_number', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->paginate(5);

        return response()->json($organizers);
    }

    public function get_current_conference_organizers_all()
    {
        $conference = Conference::query()->where("is_current", true)->first();
        $organizers = $conference->organizers;
        return response()->json($organizers);
    }
    public function get_current_conference_organizers(Request $request)
    {
        $search = $request->input('search');
        $conference = Conference::query()->where("is_current", true)->first();
        $organizers = $conference->organizers()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone_number', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->paginate(5);

        return response()->json($organizers);
    }

    public function get_available_organizers()
    {
        $conference = Conference::query()->where("is_current", true)->first();
        $allOrganizers = Organizer::all();
        $currentConferenceOrganizers = $conference->organizers;
        $availableOrganizers = $allOrganizers->diff($currentConferenceOrganizers);
        return response()->json($availableOrganizers);
    }

    public function addOrganizersToConference(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
        ]);
        $organizer = Organizer::find($data['id']);
        $conference = Conference::query()->where("is_current", true)->first();
        $conference->organizers()->attach($organizer);
        return response()->json("Organizer Added");
    }

    public function deleteOrganizerFromConference($id)
    {
        $organizer = Organizer::find($id);
        $conference = Conference::query()->where("is_current", true)->first();
        $conference->organizers()->detach($organizer);
        return response()->json("Organizer Deleted");
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number' => 'required',
            'email' => 'required',
        ]);

        $imageName = $request->name . '_' . $request->image->extension();

        $path = $request->file('image')->storeAs('public/images/organizers', $imageName);

        $relativePath = str_replace('public/', '', $path);

        $organizer = new Organizer();
        $organizer->name = $request->input('name');
        $organizer->phone_number = $request->input('phone_number');
        $organizer->email = $request->input('email');
        $organizer->image = $relativePath;
        $organizer->save();


        return response()->json("Organizer Created");
    }


    public function destroy($id)
    {
        $organizer = Organizer::find($id);
        $filePath = storage_path('app/public/' . $organizer->image);
        File::delete($filePath);
        $organizer->delete();
        return response()->json("Organizer Deleted");
    }

    public function update(Request $request, $id)
    {
        $organizer = Organizer::find($id);
        if ($request->has('image') && !empty($request->image)) {
            $filePath = storage_path('app/public/' . $organizer->image);
            File::delete($filePath);
        }
        $data = $request->validate([
            'name' => ['required'],
            'phone_number' => ['required'],
            'email' => ['required'],
            'image' => ['nullable'],
            ]);

        $organizer->update($data);
        return response()->json($data);
    }

    public function uploadOrganizerImage(Request $request){
        $request->validate([
            'image'=> 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time(). '.'.$request->image->extension();
        $request->image->storeAs('public/images/organizers', $imageName);

        return response()->json(['image_path'=> 'images/organizers/'. $imageName]);
    }


}
