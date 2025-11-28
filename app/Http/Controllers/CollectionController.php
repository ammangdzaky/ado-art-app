<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Auth::user()->collections()->withCount('artworks')->latest()->get();
        return view('collections.index', compact('collections'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        $collection = Auth::user()->collections()->create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        if ($request->has('artwork_id')) {
            $collection->artworks()->attach($request->artwork_id);
            return back()->with('success', 'Collection created and artwork saved!');
        }

        return back()->with('success', 'Moodboard created.');
    }

    public function show(Collection $collection)
    {
        if ($collection->user_id !== Auth::id()) abort(403);
        
        $artworks = $collection->artworks()->paginate(12);
        return view('collections.show', compact('collection', 'artworks'));
    }

    public function addToCollection(Request $request, Artwork $artwork)
    {
        $request->validate(['collection_id' => 'required|exists:collections,id']);
        
        $collection = Collection::where('id', $request->collection_id)
            ->where('user_id', Auth::id()) // Pastikan punya user sendiri
            ->firstOrFail();

        if (!$collection->artworks()->where('artwork_id', $artwork->id)->exists()) {
            $collection->artworks()->attach($artwork->id);
            return back()->with('success', 'Saved to ' . $collection->name);
        }

        return back()->with('info', 'Artwork already in this collection.');
    }
}