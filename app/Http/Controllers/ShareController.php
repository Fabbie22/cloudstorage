<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Share;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function sharedByMe()
    {
        $shared = Share::where('owner_email', auth()->user()->email)->get();
        return view('shared.share', compact('shared'));
    }
    public function sharedWithMe()
    {
        $shared_with_me = Share::where('recipient_email', auth()->user()->email)->get();
        return view('shared.shared-with-me', compact('shared_with_me'));
    }

    public function create()
    {
        return view('shared.share');
    }

    public function store(Request $request, $id)
    {
        $owner_email = $request->input('owner_email');
        $recipient_email = $request->input('recipient_email');
        $file_id = $id;

        $request->validate([
            'owner_email' => ['required', 'email'],
            'recipient_email' => ['required', 'email']
        ]);

        $fileAlreadyShared = Share::where('file_id', $id)
            ->where('recipient_email', $request->recipient_email)
            ->exists();

        if ($fileAlreadyShared) {
            return redirect()->route('files')->with('status', 'already-shared');
        }

        Share::create([
            'file_id' => $file_id,
            'owner_email' => $owner_email,
            'recipient_email' => $recipient_email
        ]);


        return redirect(route('files'))->with('status', 'file-shared');
    }

    public function download(Request $request)
    {
        $path = $request->input('path');
        $file_name = basename($path);

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path, $file_name);
        }
    }

    public function delete($id)
    {
        $share = Share::findOrFail($id);
        $share->delete();

        return redirect()->route('share')->with('status', 'share-deleted');
    }
}
