<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    // Menampilkan daftar Moodboard
    public function index()
    {
        $collections = Auth::user()->collections()->withCount('artworks')->latest()->get();
        return view('collections.index', compact('collections'));
    }

    // 1. BUAT KOLEKSI BARU (Dan otomatis simpan gambar jika ada)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'artwork_id' => 'nullable|exists:artworks,id' // Validasi ID artwork jika ada
        ]);
        
        // Buat Koleksi Baru
        $collection = Auth::user()->collections()->create([
            'name' => $request->name,
            'description' => $request->input('description', '') // Default kosong jika tidak diisi
        ]);

        // Jika tombol ditekan dari halaman Artwork (Ada ID gambar yang dikirim)
        if ($request->has('artwork_id') && $request->artwork_id) {
            $collection->artworks()->attach($request->artwork_id);
            return back()->with('success', 'Moodboard created and artwork saved!');
        }

        return back()->with('success', 'Moodboard created successfully.');
    }

    // 2. SIMPAN KE KOLEKSI LAMA (Add to existing)
    public function addToCollection(Request $request, Artwork $artwork)
    {
        $request->validate([
            'collection_id' => 'required|exists:collections,id'
        ]);
        
        // Pastikan koleksi itu milik user yang sedang login (Keamanan)
        $collection = Auth::user()->collections()->where('id', $request->collection_id)->firstOrFail();

        // Cek apakah gambar sudah ada di koleksi itu (Mencegah duplikat)
        if (!$collection->artworks()->where('artwork_id', $artwork->id)->exists()) {
            $collection->artworks()->attach($artwork->id);
            return back()->with('success', 'Saved to ' . $collection->name);
        }

        return back()->with('info', 'Artwork is already in this moodboard.');
    }

    public function show(Collection $collection)
    {
        if ($collection->user_id !== Auth::id()) {
            abort(403);
        }
        
        $artworks = $collection->artworks()->paginate(12);
        return view('collections.show', compact('collection', 'artworks'));
    }
}