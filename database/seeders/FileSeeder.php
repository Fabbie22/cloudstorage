<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Share; // Import the Share model
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
            $files = File::factory()->count(5)->create(['user_id' => $user->id]); // Create 5 files for each user

            // Share files with random users, ensuring no duplicate shares
            foreach ($files as $file) {
                // Choose a random user to share the file with, ensuring it's not the original user
                $recipient = $users->where('id', '!=', $user->id)->random();

                // Generate a unique share
                Share::create([
                    'file_id' => $file->id,
                    'owner_email' => $user->email, // Email of the owner
                    'recipient_email' => $recipient->email, // Email of the recipient
                ]);
            }
        }
    }
}


