<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicProfileController extends Controller
{
    public function show(User $user)
    {
        $user->load(['artworks', 'followers', 'following']);
        
        $isFollowing = false;
        if (Auth::check()) {
            $isFollowing = Auth::user()->following()->where('followed_id', $user->id)->exists();
        }

        return view('profile.public', compact('user', 'isFollowing'));
    }
}