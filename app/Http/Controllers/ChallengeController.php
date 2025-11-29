<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeSubmission;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::where('curator_id', Auth::id())->latest()->get();
        return view('curator.challenges.index', compact('challenges'));
    }

    public function create()
    {
        return view('curator.challenges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'required|string',
            'prize' => 'required|string',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $path = $request->file('banner')->store('banners', 'public');

        Challenge::create([
            'curator_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'rules' => $request->rules,
            'prize' => $request->prize,
            'banner_path' => $path,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'open',
        ]);

        return redirect()->route('curator.challenges.index')->with('success', 'Challenge created successfully.');
    }

    public function show(Challenge $challenge)
    {
        $challenge->load(['submissions.artwork.user', 'curator']);
        
        $winners = $challenge->submissions()->whereNotNull('rank')->orderBy('rank')->get();
        $submissions = $challenge->submissions()->whereNull('rank')->latest()->get();
        
        $myArtworks = collect();
        if (Auth::check() && Auth::user()->role === 'member') {
            $myArtworks = Artwork::where('user_id', Auth::id())->latest()->get();
        }

        return view('challenges.show', compact('challenge', 'winners', 'submissions', 'myArtworks'));
    }

    public function edit(Challenge $challenge)
    {
        if (Auth::id() !== $challenge->curator_id) {
            abort(403);
        }
        return view('curator.challenges.edit', compact('challenge'));
    }

    public function update(Request $request, Challenge $challenge)
    {
        if (Auth::id() !== $challenge->curator_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'required|string',
            'prize' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('banner')) {
            Storage::disk('public')->delete($challenge->banner_path);
            $challenge->banner_path = $request->file('banner')->store('banners', 'public');
        }

        $challenge->update($request->except('banner'));

        return redirect()->route('curator.challenges.index')->with('success', 'Challenge updated.');
    }

    public function destroy(Challenge $challenge)
    {
        if (Auth::id() !== $challenge->curator_id) {
            abort(403);
        }
        
        Storage::disk('public')->delete($challenge->banner_path);
        $challenge->delete();
        
        return redirect()->route('curator.challenges.index')->with('success', 'Challenge deleted.');
    }

    public function submit(Request $request, Challenge $challenge)
    {
        if (Auth::user()->role !== 'member') {
            abort(403, 'Only members can submit artworks.');
        }

        if (now()->greaterThan($challenge->end_date)) {
            return back()->with('error', 'Challenge has ended.');
        }

        $request->validate([
            'artwork_id' => 'required|exists:artworks,id',
        ]);

        $exists = ChallengeSubmission::where('challenge_id', $challenge->id)
            ->where('artwork_id', $request->artwork_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This artwork is already submitted.');
        }

        ChallengeSubmission::create([
            'challenge_id' => $challenge->id,
            'artwork_id' => $request->artwork_id,
        ]);

        return back()->with('success', 'Artwork submitted successfully!');
    }

    public function selectWinners(Request $request, Challenge $challenge)
    {
        if (Auth::id() !== $challenge->curator_id) {
            abort(403);
        }

        if (now()->lessThan($challenge->end_date)) {
            return back()->with('error', 'Cannot select winners before challenge ends.');
        }

        // VALIDASI BARU: Pastikan winner_1, winner_2, winner_3 berbeda satu sama lain
        $request->validate([
            'winner_1' => 'nullable|exists:challenge_submissions,id',
            'winner_2' => 'nullable|exists:challenge_submissions,id|different:winner_1',
            'winner_3' => 'nullable|exists:challenge_submissions,id|different:winner_1|different:winner_2',
        ], [
            'winner_2.different' => 'The 2nd place winner cannot be the same as 1st place.',
            'winner_3.different' => 'The 3rd place winner must be unique.',
        ]);

        // Reset semua ranking dulu
        ChallengeSubmission::where('challenge_id', $challenge->id)->update(['rank' => null]);

        // Update ranking baru
        if ($request->winner_1) ChallengeSubmission::where('id', $request->winner_1)->update(['rank' => '1']);
        if ($request->winner_2) ChallengeSubmission::where('id', $request->winner_2)->update(['rank' => '2']);
        if ($request->winner_3) ChallengeSubmission::where('id', $request->winner_3)->update(['rank' => '3']);

        $challenge->update(['status' => 'closed']);

        return back()->with('success', 'Winners announced successfully!');
      }

    public function mySubmissions()
    {
        $submissions = \App\Models\ChallengeSubmission::with('challenge', 'artwork')
            ->whereHas('artwork', function($q) {
                $q->where('user_id', Auth::id());
            })->latest()->get();

        return view('challenges.my-submissions', compact('submissions'));
    }
    public function browse()
    {
        // Tampilkan challenge yang Open paling atas, lalu urutkan berdasarkan deadline
        $challenges = Challenge::orderByRaw("FIELD(status, 'open', 'closed')")
            ->orderBy('end_date', 'desc')
            ->paginate(9);
            
        return view('challenges.index', compact('challenges'));
    }
}