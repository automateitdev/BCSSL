<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email'=>User::$seederMail[0]]
            ,[
            'name' => 'John Doe',
            'email' => User::$seederMail[0],
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'status' => User::STATUS_ACTIVE,
            'user_type' => User::USER_TYPE_SUPERADMIN,
            'remember_token' => Str::random(10),
        ]);

        User::updateOrCreate(
            ['email'=>User::$seederMail[1]],
            [
            'name' => 'demo',
            'email' => User::$seederMail[1],
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'status' => User::STATUS_ACTIVE,
            'user_type' => User::USER_TYPE_SUPERADMIN,
            'remember_token' => Str::random(10),
        ]);
    }
}
