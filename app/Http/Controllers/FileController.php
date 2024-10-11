<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth; // If using Auth facade for authenticated user
use Illuminate\Support\Facades\Storage; // If handling file storage
use Illuminate\Http\Response; // If you need to manage file downloads/responses
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class FileController extends Controller
{

    public function create()
    {
        return view('files.files');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $path = $request->file('file')->store(auth()->id(), 'public');

        Log::info('File uploaded to: ' . $path);


        $files = File::create([
            'path' => $path,
            'user_id'=> auth()->id()
        ]);

        Log::info('File saved in DB: ', $files->toArray());


        return redirect(route('files'))->with('status', 'files-uploaded');
    }

    public function read() 
    {
        $files = File::where('user_id', auth()->id())->get();
        return view('files.files', compact('files'));
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
}
