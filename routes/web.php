<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShareController;
use App\Models\File;
use App\Models\Share;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('start');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function() {
    Route::get('/files', [FileController::class, 'read'])->name('files');
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
    Route::delete('/files/{id}', [FileController::class, 'delete'])->name('files.delete');
    Route::post('/files/download', [FileController::class, 'download'])->name('files.download');
    Route::post('/files/share/{id}', [ShareController::class, 'store'])->name('share.store');
});

Route::middleware('auth')->group(function() {
    Route::get('/shared', [ShareController::class, 'sharedByMe'])->name('share');
    Route::get('/shared-with-me', [ShareController::class, 'sharedWithMe'])->name('shared.shared-with-me');
});

require __DIR__.'/auth.php';
