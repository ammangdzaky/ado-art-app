<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CuratorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [App\Http\Controllers\ArtworkController::class, 'index'])->name('home');
Route::get('/gallery', [App\Http\Controllers\ArtworkController::class, 'index'])->name('artworks.index');
Route::get('/artwork/{artwork}', [App\Http\Controllers\ArtworkController::class, 'show'])->name('artworks.show');
Route::get('/challenges/{challenge}', [App\Http\Controllers\ChallengeController::class, 'show'])->name('challenges.show');
Route::get('/artist/{user}', [App\Http\Controllers\PublicProfileController::class, 'show'])->name('artist.show');
Route::get('/my-submissions', [App\Http\Controllers\ChallengeController::class, 'mySubmissions'])->name('challenges.mine');
Route::get('/challenges', [App\Http\Controllers\ChallengeController::class, 'browse'])->name('challenges.browse');

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
    Route::resource('curator/challenges', App\Http\Controllers\ChallengeController::class)->names([
        'index' => 'curator.challenges.index',
        'create' => 'curator.challenges.create',
        'store' => 'curator.challenges.store',
        'edit' => 'curator.challenges.edit',
        'update' => 'curator.challenges.update',
        'destroy' => 'curator.challenges.destroy',
    ])->except(['show']);

    Route::post('/curator/challenges/{challenge}/winners', [App\Http\Controllers\ChallengeController::class, 'selectWinners'])->name('curator.challenges.winners');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/admin/users/{user}/approve', [AdminController::class, 'approveCurator'])->name('admin.users.approve');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::post('/admin/reports/{report}', [AdminController::class, 'handleReport'])->name('admin.reports.handle');

    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('artworks', App\Http\Controllers\ArtworkController::class)->except(['index', 'show']);
    Route::post('/challenges/{challenge}/submit', [App\Http\Controllers\ChallengeController::class, 'submit'])->name('challenges.submit');
    Route::post('/artwork/{artwork}/like', [App\Http\Controllers\InteractionController::class, 'toggleLike'])->name('artwork.like');
    Route::post('/artwork/{artwork}/comment', [App\Http\Controllers\InteractionController::class, 'storeComment'])->name('artwork.comment');
    Route::delete('/comment/{comment}', [App\Http\Controllers\InteractionController::class, 'destroyComment'])->name('comment.destroy');
    Route::post('/user/{user}/follow', [App\Http\Controllers\InteractionController::class, 'toggleFollow'])->name('user.follow');
    Route::post('/artwork/{artwork}/report', [App\Http\Controllers\InteractionController::class, 'report'])->name('artwork.report');
    Route::post('/artwork/{artwork}/favorite', [App\Http\Controllers\InteractionController::class, 'toggleFavorite'])->name('artwork.favorite');
    Route::get('/my-favorites', [App\Http\Controllers\ArtworkController::class, 'myFavorites'])->name('artworks.favorites');
    Route::resource('collections', App\Http\Controllers\CollectionController::class);
    Route::post('/artwork/{artwork}/save-to-collection', [App\Http\Controllers\CollectionController::class, 'addToCollection'])->name('collections.add');
});

require __DIR__.'/auth.php';