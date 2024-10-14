<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FileFactory extends Factory
{
    protected $model = File::class;

    public function definition()
    {
        // Select a random user from the existing users
        $user = User::inRandomOrder()->first(); // Fetch a random user from the database

        // Generate a random filename
        $filename = Str::random(10) . '.txt'; // Unique random filename with 10 characters

        // Define the path for the file based on the user's ID
        $path = storage_path('app/public/files/' . $user->id . '/' . $filename); // User-specific directory

        // Ensure the directory exists
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true); // Create the directory if it does not exist
        }

        // Decide whether to create an empty file or one with content
        if ($this->faker->boolean(50)) { // 50% chance to create an empty file
            // Create an empty file
            file_put_contents($path, ''); // Create an empty file
        } else {
            // Create a file with some random content
            file_put_contents($path, $this->faker->text(200)); // Create a file with 200 characters of text
        }

        return [
            'path' => '/files/' . $user->id . '/' . $filename, // Store the relative path in the database
            'user_id' => $user->id, // Use the selected user's ID
        ];
    }
}

