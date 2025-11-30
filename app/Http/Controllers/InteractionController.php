<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    public function toggleLike(Artwork $artwork)
    {
        $artwork->likes()->where('user_id', Auth::id())->exists()
            ? $artwork->likes()->where('user_id', Auth::id())->delete()
            : $artwork->likes()->create(['user_id' => Auth::id()]);

        return back();
    }

    public function storeComment(Request $request, Artwork $artwork)
    {
        $request->validate(['body' => 'required|string|max:500']);

        Comment::create([
            'user_id' => Auth::id(),
            'artwork_id' => $artwork->id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Comment posted.');
    }

    public function destroyComment(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }

    public function toggleFollow(User $user)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        Auth::user()->following()->toggle($user->id);

        return back();
    }
    public function report(Request $request, Artwork $artwork)
    {
        // Validasi: Pastikan alasan ada di dalam daftar yang diizinkan
        $request->validate([
            'reason' => 'required|string|in:Inappropriate Content,Plagiarism,Spam,Hate Speech,Scam or Fraud',
        ]);

        // 1. CEK DUPLIKASI (Satu user max 1 report per karya)
        $existingReport = \App\Models\Report::where('reporter_id', Auth::id())
            ->where('artwork_id', $artwork->id)
            ->exists();

        if ($existingReport) {
            return back()->with('error', 'You have already reported this artwork.');
        }

        // 2. SIMPAN LAPORAN
        \App\Models\Report::create([
            'reporter_id' => Auth::id(),
            'artwork_id' => $artwork->id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Report submitted to moderators.');
    }
}