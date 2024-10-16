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
        $users = User::all(); // Fetch all users
        $userRegistrationData = User::selectRaw('DATE(created_at) as date, COUNT(*) as aggregate')
        ->where('created_at', '>=', now()->subDays(30)) // Filter for last 30 days
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Return the data to the dashboard view
        return view('dashboard', compact('files', 'users', 'userRegistrationData'));
    }
}
