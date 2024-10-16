<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Carbon\Carbon;

class DataController extends Controller
{
    public function dashboard()
    {
        $files = File::all();
        
        //Users registrated in 30 days time
        $userRegistrationData = User::selectRaw('DATE(created_at) as date, COUNT(*) as aggregate')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        //Amount of file types
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

        //Deleted Average time
        $records = File::onlyTrashed()->get();

        $data = $records->map(function ($record) {
            $created = Carbon::parse($record->created_at->format('d-m-Y'));
            $deleted = Carbon::parse($record->deleted_at->format('d-m-Y'));

            return $created->diffInDays($deleted);
        });

        $averageTimeSaved = $data->isNotEmpty() ? $data->avg() : 0;

        return view('dashboard', compact('files', 'userRegistrationData', 'fileTypesData', 'averageTimeSaved'));
    }
}
