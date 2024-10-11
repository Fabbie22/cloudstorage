<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth; // If using Auth facade for authenticated user
use Illuminate\Support\Facades\Storage; // If handling file storage
use Illuminate\Http\Response; // If you need to manage file downloads/responses


class FileController extends Controller
{

    public function create()
    {

    }

    public function read() 
    {
        $files = File::where('user_id', auth()->id())->get();
        return view('files.files', compact('files'));
    }

    public function delete($id)
    {
        $file = File::findOrFail($id);
        $file->delete();

        return redirect()->route('files');
    }
}
