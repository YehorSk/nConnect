<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Lecture;
use App\Traits\HttpResponses;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    use HttpResponses;
    public function fetchUser(){
        $user =  auth('sanctum')->user();
        if($user){
            return $user;
        }
        return $this->error('','No user',401);

    }
    public function fetchLectures()
    {
        $user = auth('sanctum')->user();
        if ($user instanceof User) {
            $activeConference = Conference::query()->where("is_current",true)->first();

            if (!$activeConference) {
                return $this->error('', 'No active conference found', 404);
            }

            $lectures = $user->lectures()->where('conference_id', $activeConference->id)->get();
            return response()->json($lectures);
        }

        return $this->error('', 'No user', 401);
    }

    public function addLecture(Request $request)
    {
        $user = auth('sanctum')->user();
        if($user instanceof User){
            $lecture = Lecture::find($request->input('id'));

            if ($lecture->taken_spots >= $lecture->capacity) {
                return $this->error('', 'Full capacity', 422);
            }

            $activeConference = Conference::query()->where("is_current", true)->first();
            if (!$activeConference) {
                return $this->error('', 'No active conference found', 404);
            }

            $newStartTime = $lecture->start_time;
            $newEndTime = $lecture->end_time;
            $overlappingLectures = $user->lectures()
                ->where('conference_id', $activeConference->id)
                ->where(function($query) use ($newStartTime, $newEndTime) {
                    $query->where(function($query) use ($newStartTime, $newEndTime) {
                        $query->where('start_time', '<', $newEndTime)
                            ->where('end_time', '>', $newStartTime);
                    })->orWhere(function($query) use ($newStartTime, $newEndTime) {
                        $query->where('start_time', '>', $newStartTime)
                            ->where('start_time', '<', $newEndTime);
                    });
                })->exists();

            if (!$overlappingLectures) {
                $user->lectures()->attach($lecture);
                $lecture->taken_spots += 1;
                $lecture->save();

                return $this->success('', 'Lecture added successfully');
            } else {
                return $this->error('', 'The new lecture overlaps with existing lectures', 422);
            }
        }

        return $this->error('', 'No user', 401);
    }

    public function removeLecture(Request $request){
        $user =  auth('sanctum')->user();
        if($user instanceof User){
            $lecture = Lecture::find($request->input('id'));
            $user->lectures()->detach($lecture);
            $lecture->taken_spots -= 1;
            $lecture->save();
        }
    }
    public function getRegularUsers(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
            ->where('is_admin', 0)
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->paginate(10);
        return response()->json($users);
    }


    public function getAdminUsers()
    {
        $users = User::where('is_admin', 1)->get();
        return response()->json($users);
    }

    public function addAdminUser(Request $request)
    {
        $userId = $request->input('id');
        $user = User::find($userId);
        if ($user) {
            $user->is_admin = 1;
            $user->save();

            return $this->success('','User has been successfully added to admin.');
        } else {
            return $this->error('','Error occurred.', 422);
        }
    }
    public function removeAdminUser(Request $request)
    {
        $userId = $request->input('id');
        $currentUser = auth('sanctum')->user();

        if ($currentUser->id == $userId) {
            return $this->error('','You cannot remove admin role from yourself.', 422);
        }

        $user = User::find($userId);
        if ($user) {
            $user->is_admin = 0;
            $user->save();

            return $this->success('','User removed from admin.');
        } else {
            return $this->error('','Error occurred.', 422);
        }
    }

}
