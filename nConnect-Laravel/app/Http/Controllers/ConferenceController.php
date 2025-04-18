<?php

namespace App\Http\Controllers;

use App\Models\Conference;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConferenceController extends Controller
{
    use HttpResponses;
    public function index(){
        $conferences = Conference::all();
        return response()->json($conferences);
    }

    public function get_active_conference(){
        $conference = Conference::query()->where("is_current",1)->first();
        return response()->json($conference);
    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required|unique:conferences',
            'year' => 'required',
        ]);
        $conference = new Conference($data);
        $conference->save();
        return response()->json("Conference Created");
    }

    public function update(Request $request, $id)
    {
        $conference = Conference::find($id);

        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('conferences')->ignore($conference),
            ],
            'year' => [
                'required',
            ],
            'is_current'=>[
                'required'
            ]
        ]);
        $cur = Conference::find($id);
        if($data['is_current'] == 0){

            if($cur->is_current === 1){
                return response()->json([
                    'message' => "At least one conference must be marked as current. Can't remove the last current conference."
                ], 422);
            }
        } else if($data['is_current'] === 1){
            if($cur->is_current !== 1){
                $conferences = Conference::all();
                foreach ($conferences as $conf) {
                    $conf->is_current = 0;
                    $conf->save();
                }
            }
        }

        $conference->update($data);

        return response()->json("Stage Updated");
    }

    public function destroy($id){
        if(Conference::count()==1){
            return response()->json([
                'message' => "At least one conference must be marked as current. Can't remove the last current conference."
            ], 422);
        }
        $conference = Conference::find($id);
        if($conference->is_current === 1){
            return response()->json([
                'message' => "Unable to delete active conference. Ensure there is always one conference marked as active."
            ], 422);
        }
        $conference->delete();


        return response()->json("Conference Deleted");

    }

    public function addUser(){
        $conference = Conference::query()->where("is_current",1)->first();
        $user = auth('sanctum')->user();
        $conference->users()->attach($user);
    }

    public function removeUser(){
        $conference = Conference::query()->where("is_current",1)->first();
        $user = auth('sanctum')->user();
        $conference->users()->detach($user);
        foreach ($user->lectures as $lecture) {
            $lecture->taken_spots = $lecture->taken_spots - 1;
            $lecture->save();
        }
        $user->lectures()->detach();
    }

    public function userHasCurrentConference(){
        $conference = Conference::query()->where("is_current", 1)->first();
        $user = auth('sanctum')->user();

        if($user instanceof User){
            if ($conference && $conference->users()->where('user_id', $user->id)->exists()) {
                return response()->json(['has_current_conference' => true]);
            } else {
                return response()->json(['has_current_conference' => false]);
            }
        }
        return $this->error('', 'No user', 401);
    }
    public function getConferenceUsers($id){
        $conference = Conference::find($id);
        $users = $conference->users;
        $totalUsers = $users->count();
        return response()->json([
            'total_users' => $totalUsers,
            'users' => $users
        ]);
    }



}
