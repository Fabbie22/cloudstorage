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

        $file_name = $request->file('file')->getClientOriginalName();

        $path = $request->file('file')->store(auth()->id(), 'public');

        $files = File::create([
            'path' => $path,
            'file_name' => $file_name,
            'user_id'=> auth()->id()
        ]);

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
        $file_name = $request->input('file_name');

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path, $file_name);
        }
    }
}
