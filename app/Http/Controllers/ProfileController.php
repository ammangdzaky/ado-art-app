<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            if ($request->user()->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($request->user()->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $request->user()->avatar = $path;
        }

        if ($request->has('bio')) {
            $request->user()->bio = $request->input('bio');
        }

        $socialLinks = [
            'website' => $request->input('website'),
            'instagram' => $request->input('instagram'),
            'twitter' => $request->input('twitter'),
        ];
        
        $request->user()->social_links = $socialLinks;

        $request->user()->save();

        return redirect()->route('artist.show', $request->user())
                         ->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
