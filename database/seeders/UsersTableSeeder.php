<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(5)->create()->each(function ($user) {
            $user->profile()->save(Profile::factory()->make());
        });

        User::find(1)->update([
            'email' => 'userTest@gmail.com',
            'password' => 'secret',
            'status' => User::ACTIVE,
        ]);
    }
}
