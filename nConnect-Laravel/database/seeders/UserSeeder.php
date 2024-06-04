<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => \Str::random(10),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => \Str::random(10),
            ],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->name=$userData['name'];
            $user->email=$userData['email'];
            $user->email_verified_at =$userData['email_verified_at'];
            $user->password=$userData['password'];
            $user->remember_token=$userData['remember_token'];
            $user->save();

        }
    }
}
