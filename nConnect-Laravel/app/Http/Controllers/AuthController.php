<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Conference;
use App\Models\Lecture;
use App\Traits\HttpResponses;
use App\models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use HttpResponses;
    public function login(LoginUserRequest $request){
        $request -> validated($request->all());
        if(!Auth::attempt($request->only('email', 'password'))){
            return $this->error('','Credentials do not match',401);
        }
        $user =User::where('email', $request->email)->first();


        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ]);
    }

    public function register(StoreUserRequest $request){
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->sendEmailVerificationNotification();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ]);
    }
    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return $this->success([
            'message' => 'Logged out successfully',
        ]);
    }

    public function reset_password($token,$email) {
        return redirect()->to('http://localhost:5173/reset-password/' . $token . '?email=' . urlencode($email));
    }

    public function update_password(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        return response()->json("Password Updated");
    }

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
    public function getRegularUsers()
    {
        $users = User::where('is_admin', 0)->get();
        return response()->json($users);
    }

    public function getAdminUsers()
    {
        $users = User::where('is_admin', 1)->get();
        return response()->json($users);
    }
}
