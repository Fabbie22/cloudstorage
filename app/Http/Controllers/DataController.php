<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;

class DataController extends Controller
{
    public function dashboard()
    {
        // Retrieve all files and users
        $files = File::all(); // Fetch all files
        $userRegistrationData = User::selectRaw('DATE(created_at) as date, COUNT(*) as aggregate')
        ->where('created_at', '>=', now()->subDays(30)) // Filter for last 30 days
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Step 2: Map the files to get their types and count them
        $fileTypesData = $files->map(function ($file) {
            return [
                'file_type' => pathinfo($file->path, PATHINFO_EXTENSION), // Extract file type from the path
            ];
        })->groupBy('file_type') // Group the results by file type
          ->map(function ($group) {
              return count($group); // Count the occurrences of each file type
          });

        // Step 3: Convert the data to a format suitable for the chart
        $fileTypesData = $fileTypesData->map(function ($count, $type) {
            return [
                'file_type' => $type, // The file type (extension)
                'total' => $count, // The count of files of this type
            ];
        })->values(); // Reset the keys to make it a numerically indexed array

        // Return the data to the dashboard view
        return view('dashboard', compact('files', 'userRegistrationData', 'fileTypesData'));
    }
}
