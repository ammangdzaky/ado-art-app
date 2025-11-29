<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Artwork::with('user', 'category');

        // 1. Filter Kategori
        if ($request->has('category') && $request->category != 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 2. Search Logic (PERBAIKAN: Grouping Query)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('tags', 'like', '%' . $search . '%')
                  // Cari berdasarkan Nama User (Relasi)
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // 3. Sorting
        if ($request->sort === 'trending') {
            $query->withCount('likes')->orderByDesc('likes_count');
        } else {
            $query->latest();
        }

        $artworks = $query->paginate(12);
        
        $activeChallenges = \App\Models\Challenge::where('status', 'open')
            ->where('end_date', '>', now())
            ->latest()
            ->take(5)
            ->get();

        $categories = \App\Models\Category::all();

        return view('artworks.index', compact('artworks', 'activeChallenges', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('artworks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // Max 10MB
            'tags' => 'nullable|string',
        ]);

        $path = $request->file('image')->store('artworks', 'public');

        Artwork::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $path,
            'tags' => $request->tags,
        ]);

        return redirect()->route('dashboard')->with('success', 'Artwork uploaded successfully!');
    }

    public function show(Artwork $artwork)
    {
        $previousArtwork = Artwork::where('id', '<', $artwork->id)->orderBy('id', 'desc')->first();
        
        $nextArtwork = Artwork::where('id', '>', $artwork->id)->orderBy('id', 'asc')->first();

        return view('artworks.show', compact('artwork', 'previousArtwork', 'nextArtwork'));
    }

    public function update(Request $request, Artwork $artwork)
    {
        if (Auth::id() !== $artwork->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($artwork->image_path);
            $path = $request->file('image')->store('artworks', 'public');
            $artwork->image_path = $path;
        }

        $artwork->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'tags' => $request->tags,
        ]);

        return redirect()->route('artworks.show', $artwork)->with('success', 'Artwork updated successfully.');
    }

    public function destroy(Artwork $artwork)
    {
        if (Auth::id() !== $artwork->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        Storage::disk('public')->delete($artwork->image_path);
        $artwork->delete();

        return redirect()->route('dashboard')->with('success', 'Artwork deleted.');
    }

    public function myFavorites()
    {
        $favorites = Auth::user()->favorites()->with('artwork.user')->latest()->paginate(12);
        return view('artworks.favorites', compact('favorites'));
    }
}