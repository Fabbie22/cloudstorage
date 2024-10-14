<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function read() 
    {
        $files = File::where('user_id', auth()->id())->get();
        return view('files.files', compact('files'));
    }

    public function create()
    {
        return view('files.files');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:2048'],
        ]);

        $userId = auth()->id();

        $destinationPath = "{$userId}";

        $file = $request->file('file');

        $extension = $file->getClientOriginalExtension();
        $baseFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $finalFilename = "{$baseFilename}.{$extension}";

        $counter = 1;
        while (Storage::disk('public')->exists("{$destinationPath}/{$finalFilename}")) {
            $finalFilename = "{$baseFilename}({$counter}).{$extension}";
            $counter++;
        }

        $filePath = $file->storeAs($destinationPath, $finalFilename, 'public');

        // Save the file info to the database
        $fileRecord = new File();
        $fileRecord->path = $filePath;  // Store the path
        $fileRecord->user_id = $userId; // Store the user ID
        $fileRecord->save();

        return redirect(route('files'))->with('status', 'files-uploaded');
    }

    public function delete(Request $request, $id)
    {    
        $path = $request->input('path');

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $file = File::findOrFail($id);
        $file->delete();

        return redirect()->route('files');
    }

    public function download(Request $request)
    {
        $path = $request->input('path');
        $file_name = basename($path);

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path, $file_name);
        }
    }
}
