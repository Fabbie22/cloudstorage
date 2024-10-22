<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function read() 
    {
        $files = File::where('user_id', auth()->id())
        ->paginate(21);
    return view('files.files', compact('files'));
    }

    public function create()
    {
        return view('files.files');
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => ['required', 'file', 'max:2048'],
        ]);

        $userId = auth()->id();

        $destinationPath = "files/{$userId}";

        $files = $request->file('files');


        foreach($files as $file)
        {
        $extension = $file->getClientOriginalExtension();
        $baseFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $finalFilename = "{$baseFilename}.{$extension}";

        $counter = 1;
        while (Storage::disk('public')->exists("{$destinationPath}/{$finalFilename}")) {
            $finalFilename = "{$baseFilename}({$counter}).{$extension}";
            $counter++;
        }

        $filePath = $file->storeAs($destinationPath, $finalFilename, 'public');

        $fileRecord = new File();
        $fileRecord->path = $filePath;
        $fileRecord->user_id = $userId;
        $fileRecord->save();
    }

        return redirect(route('files'))->with('status', 'files-uploaded');
    }

    public function delete($id)
    {    
        $file = File::findOrFail(Crypt::decryptString($id));

        $path = $file->path;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $newBasename = uniqid() . '.' . $extension;

        $newPath = time() . '_' . $newBasename;

        $file->path = $newPath;
        $file->save();

        $file->delete();

        return redirect()->route('files')->with('status', 'files-deleted');
    }

    public function download(Request $request)
    {
        $path = Crypt::decryptString($request->input('path'));
        $file_name = basename($path);

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path, $file_name);
        }
    }
}
