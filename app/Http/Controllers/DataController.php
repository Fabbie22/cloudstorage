<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Carbon\Carbon;

class DataController extends Controller
{
    public function dashboard_statistics()
    {
        // Fetch core data for dashboard
        $files = File::withTrashed()->get();
        $userRegistrationData = $this->getUserRegistrationData();
        $fileTypesData = $this->getFileTypesData($files);
        $recentFiles = $this->getRecentFiles();
        $savedFilesCount = File::withoutTrashed()->count();
        $removedFilesCount = File::onlyTrashed()->count();
        $totalFileSizeMB = $this->calculateTotalFileSize($files);

        // Age-based file statistics
        list($ageLabels, $ageValues) = $this->getFileAgeData($files);

        // Top users with file counts
        list($userLabels, $fileCounts) = $this->getTopUsersWithFileCounts();

        // Return view with all gathered data
        return view('dashboard', compact(
            'files',
            'recentFiles',
            'userRegistrationData',
            'fileTypesData',
            'savedFilesCount',
            'removedFilesCount',
            'totalFileSizeMB',
            'ageLabels',
            'ageValues',
            'userLabels',
            'fileCounts'
        ));
    }

    public function allUsers()
    {
        // Fetch paginated users and summary counts
        $users = User::paginate(20);
        $userCount = User::count();
        $fileCount = File::count();

        return view('userlist', compact('users', 'userCount', 'fileCount'));
    }

    /**
     * Fetches the number of users registered in the past 30 days.
     */
    private function getUserRegistrationData()
    {
        return User::selectRaw('DATE(created_at) as date, COUNT(*) as aggregate')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Processes file type data.
     */
    private function getFileTypesData($files)
    {
        return $files->map(function ($file) {
            return ['file_type' => pathinfo($file->path, PATHINFO_EXTENSION)];
        })
        ->groupBy('file_type')
        ->map(function ($group) {
            return count($group);
        })
        ->map(function ($count, $type) {
            return ['file_type' => $type, 'total' => $count];
        })
        ->values();
    }

    /**
     * Retrieves recent files for the logged-in user from the past 2 days.
     */
    private function getRecentFiles()
    {
        $userId = auth()->user()->id;
        return File::where('created_at', '>=', Carbon::now()->subDays(2))
            ->where('user_id', $userId)
            ->limit(25)
            ->orderBy('created_at', 'asc')
            ->paginate(5);
    }

    /**
     * Calculates total file size in MB for all non-trashed files.
     */
    private function calculateTotalFileSize($files)
    {
        $totalFileSizeBytes = 0;

        $savedFiles = File::withoutTrashed()->get();
        foreach ($savedFiles as $file) {
            $filePath = storage_path('app/public' . $file->path);
            if (file_exists($filePath)) {
                $totalFileSizeBytes += filesize($filePath);
            }
        }

        return $totalFileSizeBytes / 1024; // Convert bytes to MB
    }

    /**
     * Groups files by age and calculates how many fall into each age bracket.
     */
    private function getFileAgeData($files)
    {
        $monthlyFileCounts = [];
        $currentDate = Carbon::now();

        foreach ($files as $file) {
            $createdAt = Carbon::parse($file->created_at);
            $diffInMonths = $createdAt->diffInMonths($currentDate);

            $ageLabel = $diffInMonths < 1 ? 'Less than 1 month' : floor($diffInMonths) . '-' . ceil($diffInMonths) . ' months';

            if (!isset($monthlyFileCounts[$ageLabel])) {
                $monthlyFileCounts[$ageLabel] = 0;
            }
            $monthlyFileCounts[$ageLabel]++;
        }

        $ageLabels = array_keys($monthlyFileCounts);
        $ageValues = array_values($monthlyFileCounts);

        return [$ageLabels, $ageValues];
    }

    /**
     * Fetches top users based on the number of files they have uploaded.
     */
    private function getTopUsersWithFileCounts()
    {
        $topN = 5;
        $usersWithFileCount = User::withCount('files')
            ->orderBy('files_count', 'desc')
            ->take($topN)
            ->get();

        $userLabels = [];
        $fileCounts = [];

        foreach ($usersWithFileCount as $user) {
            $userLabels[] = $user->name;
            $fileCounts[] = $user->files_count;
        }

        return [$userLabels, $fileCounts];
    }
}
