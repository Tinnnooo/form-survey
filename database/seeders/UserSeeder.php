<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            "name" => "User 1",
            "email" => "user1@webtech.id",
            "password" => bcrypt('password1'),
        ]);

        User::factory()->create([
            "name" => "User 2",
            "email" => "user2@webtech.id",
            "password" => bcrypt('password2'),
        ]);

        User::factory()->create([
            "name" => "User 3",
            "email" => "user3@worldskills.org",
            "password" => bcrypt('password3'),
        ]);
    }
}
