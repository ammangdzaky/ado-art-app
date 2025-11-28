<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    public function index(Request $request)
    {
        $query = Artwork::with('user', 'category')->latest();

        // Filter Kategori
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search Logic: Judul OR Deskripsi OR Tags OR Nama User
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('tags', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $artworks = $query->paginate(12);
        
        return view('artworks.index', compact('artworks'));
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
        return view('artworks.show', compact('artwork'));
    }

    public function edit(Artwork $artwork)
    {
        if (Auth::id() !== $artwork->user_id) {
            abort(403);
        }
        
        $categories = Category::all();
        return view('artworks.edit', compact('artwork', 'categories'));
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