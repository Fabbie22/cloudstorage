<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Carbon\Carbon;

class DataController extends Controller
{
    public function dashboard_statistics()
    {
        $files = File::all();

        //Users registrated in 30 days time
        $userRegistrationData = User::selectRaw('DATE(created_at) as date, COUNT(*) as aggregate')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        $files = File::withTrashed()->get();

        $fileTypesData = $files->map(function ($file) {
            return [
                'file_type' => pathinfo($file->path, PATHINFO_EXTENSION),
            ];
        })->groupBy('file_type')
            ->map(function ($group) {
                return count($group);
            });

        $fileTypesData = $fileTypesData->map(function ($count, $type) {
            return [
                'file_type' => $type,
                'total' => $count,
            ];
        })->values();

        // Calculate average time from creation to deletion (for trashed files only) by month
        $deletedRecords = File::onlyTrashed()->get();


        $userId = auth()->user()->id;

        $recent_files = File::where('created_at', '>=', Carbon::now()->subDays(2))
            ->where('user_id', $userId)
            ->limit(25)
            ->orderby('created_at', 'asc')
            ->paginate(5);

        //Count deleted and saved files
        $savedFilesCount = File::withoutTrashed()->count();
        $removedFilesCount = File::onlyTrashed()->count();

        // Calculate total file size used in MB
        $totalFileSizeBytes = 0;
        $files = File::withoutTrashed()->get(); // Get all saved files

        foreach ($files as $file) {
            $filePath = storage_path('app/public' . $file->path); // Assuming your files are stored in the storage/app directory
            if (file_exists($filePath)) {
                $totalFileSizeBytes += filesize($filePath); // Add the file size to the total
            }
        }

        // Convert total file size from bytes to megabytes
        $totalFileSizeMB = $totalFileSizeBytes / 1024;

        $fileAges = [];
        $ageLabels = []; // To hold labels for the chart
        $ageValues = []; // To hold values for the chart

        // Group files by age in months
        $monthlyFileCounts = [];

        // Get the current date
        $currentDate = Carbon::now();

        foreach ($files as $file) {
            // Get the creation date
            $createdAt = Carbon::parse($file->created_at);

            // Calculate the difference in months
            $diffInMonths = $createdAt->diffInMonths($currentDate);

            // Determine the age label for the current file
            if ($diffInMonths < 1) {
                $ageLabel = 'Less than 1 month';
            } else {
                // Create age groups (0-1 months, 1-2 months, etc.)
                $ageLabel = floor($diffInMonths) . '-' . ceil($diffInMonths) . ' months';
            }

            // Increment the count for that age category
            if (!isset($monthlyFileCounts[$ageLabel])) {
                $monthlyFileCounts[$ageLabel] = 0;
            }
            $monthlyFileCounts[$ageLabel]++;
        }

        // Prepare labels and values for the chart
        foreach ($monthlyFileCounts as $age => $count) {
            $ageLabels[] = $age; // The age range as the label
            $ageValues[] = $count;  // Number of files for that age range
        }

        // Retrieve users with file counts, ordered by the count of files, limiting to the top N users
        $topN = 5; // Change this to the number of top users you want
        $usersWithFileCount = User::withCount('files')
            ->orderBy('files_count', 'desc') // Order by file count in descending order
            ->take($topN) // Limit to top N users
            ->get();

        $userLabels = [];
        $fileCounts = [];

        // Prepare labels and values for the chart
        foreach ($usersWithFileCount as $user) {
            $userLabels[] = $user->name; // Assuming 'name' is the field for user identification
            $fileCounts[] = $user->files_count; // This gives the count of files per user
        }

        return view('dashboard', compact('files', 'recent_files', 'userRegistrationData', 'fileTypesData',  'savedFilesCount', 'removedFilesCount', 'totalFileSizeMB', 'fileAges', 'ageLabels', 'ageValues', 'usersWithFileCount', 'userLabels', 'fileCounts'));
    }

    public function allUsers()
    {
        $users = User::paginate(20);

        $usercount = User::count();

        $filecount = File::count();

        return view('userlist', compact('users', 'usercount', 'filecount'));
    }
}
