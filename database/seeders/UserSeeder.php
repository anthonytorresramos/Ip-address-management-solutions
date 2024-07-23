<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            'admin1@test.com',
            'test7@test.com',
            'test1@test.com',
            'test2@test.com',
            'test3@test.com',
            'test4@test.com',
            'test5@test.com',
            'test6@test.com',
        ];

        foreach ($users as $index => $email) {
            User::create([
                'name' => 'User' . ($index + 1),
                'email' => $email,
                'password' => Hash::make('1234'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
