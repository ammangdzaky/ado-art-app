<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CuratorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pending-approval', function () {
    return view('auth.pending');
})->middleware(['auth'])->name('pending.notice');

Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } 
    
    if ($user->role === 'curator') {
        return redirect()->route('curator.dashboard');
    }

    return view('dashboard'); 
})->middleware(['auth', 'verified', 'status'])->name('dashboard');

Route::middleware(['auth', 'status', 'role:curator'])->group(function () {
    Route::get('/curator/dashboard', [CuratorController::class, 'index'])->name('curator.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';