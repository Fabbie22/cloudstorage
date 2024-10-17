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

        $averageTimePerMonth = $deletedRecords->groupBy(function ($record) {
            return Carbon::parse($record->deleted_at)->format('m-Y'); // Group by month
        })->map(function ($group) {
            $daysDiff = $group->map(function ($record) {
                return $record->created_at->diffInDays($record->deleted_at); // Calculate days between creation and deletion
            });
            return $daysDiff->isNotEmpty() ? $daysDiff->avg() : 0; // Calculate average per month
        });

        // Overall average deletion time
        $overallData = $deletedRecords->map(function ($record) {
            return $record->created_at->diffInDays($record->deleted_at); // Calculate days between creation and deletion
        });
        $averageTimeSaved = $overallData->isNotEmpty() ? $overallData->avg() : 0;

        $userId = auth()->user()->id;

        $recent_files = File::where('created_at', '>=', Carbon::now()->subDays(2))
            ->where('user_id', $userId)
            ->get();

        $savedFilesCount = File::withoutTrashed()->count();
        $removedFilesCount = File::onlyTrashed()->count();

        
        return view('dashboard', compact('files', 'recent_files', 'userRegistrationData', 'fileTypesData', 'averageTimeSaved', 'averageTimePerMonth', 'savedFilesCount', 'removedFilesCount'));
    }

    public function allUsers()
    {
        $users = User::paginate(20);

        $usercount = User::count();

        $filecount = File::count();

        return view('userlist', compact('users', 'usercount', 'filecount'));
    }
}
