<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    public function run()
    {
        // Fetch the users created by UserSeeder
        $users = User::all();

        // Generate 500 fake files, distributed among the 100 users
        foreach ($users as $user) {
            File::factory()->count(5)->create(['user_id' => $user->id]); // Create 5 files for each user
        }
    }
}

