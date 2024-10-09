<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FileController extends Controller
{

    public function create()
    {

    }

    public function read() 
    {
        $files = File::all();
        return view('files.files', compact('files'));
    }

    public function delete($id)
    {
        $file = File::findOrFail($id);
        $file->delete();

        return redirect()->route('files');
    }
}
