<x-app-layout>
    {{-- LOGIKA: Cek User --}}
    @php
        $user = Auth::user();
        $isLiked = false;
        $isFavorited = false;
        
        if ($user) {
            $isLiked = $artwork->likes()->where('user_id', $user->id)->exists();
            $isFavorited = $artwork->favorites()->where('user_id', $user->id)->exists();
        }
    @endphp

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                {{-- GAMBAR --}}
                <div class="w-full bg-gray-100 dark:bg-gray-900 flex justify-center items-center p-2 min-h-[400px]">
                    <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="max-h-[85vh] w-auto object-contain rounded shadow-lg">
                </div>

                <div class="p-6 md:p-10">
                    {{-- HEADER --}}
                    <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-8">
                        {{-- Judul & Info --}}
                        <div>
                            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ $artwork->title }}</h1>
                            <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                <a href="{{ route('artist.show', $artwork->user) }}" class="flex items-center gap-2 group hover:text-indigo-600">
                                    <span class="font-bold">{{ $artwork->user->name }}</span>
                                </a>
                                <span>•</span>
                                <span>{{ $artwork->created_at->format('d M Y') }}</span>
                                <span>•</span>
                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-xs font-semibold">{{ $artwork->category->name }}</span>
                            </div>
                        </div>

                        {{-- TOMBOL AKSI (Bagian Rawan Error) --}}
                        <div class="flex flex-wrap items-center gap-3">
                            @if($user)
                                {{-- 1. Like --}}
                                <form action="{{ route('artwork.like', $artwork) }}" method="POST">
                                    @csrf
                                    <button class="flex items-center gap-2 px-5 py-2.5 rounded-full font-bold transition {{ $isLiked ? 'bg-pink-100 text-pink-600 border border-pink-200' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                                        <span>❤️</span> <span>{{ $artwork->likes->count() }}</span>
                                    </button>
                                </form>

                                {{-- 2. Favorite --}}
                                <form action="{{ route('artwork.favorite', $artwork) }}" method="POST">
                                    @csrf
                                    <button class="p-2.5 rounded-full border transition {{ $isFavorited ? 'bg-yellow-50 border-yellow-400 text-yellow-500' : 'border-gray-300 text-gray-400 hover:text-yellow-500' }}">
                                        <span>⭐</span>
                                    </button>
                                </form>

                                {{-- 3. Save to Collection --}}
                                <button onclick="document.getElementById('collectionModal').classList.remove('hidden')" class="p-2.5 rounded-full border border-gray-300 text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 transition">
                                    <span>💾</span>
                                </button>

                                {{-- 4. Edit/Delete (Owner Only) --}}
                                @if($user->id === $artwork->user_id)
                                    <div class="h-6 w-px bg-gray-300 mx-2"></div>
                                    <a href="{{ route('artworks.edit', $artwork) }}" class="text-sm font-bold text-gray-500 hover:text-indigo-600">Edit</a>
                                    <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <button class="text-sm font-bold text-red-500 hover:text-red-700 ml-2">Delete</button>
                                    </form>
                                @endif

                                {{-- 5. Report (Visitor Only) --}}
                                @if($user->id !== $artwork->user_id)
                                    <button onclick="document.getElementById('reportModal').classList.remove('hidden')" class="ml-2 text-sm text-gray-400 hover:text-red-500 underline">Report</button>
                                @endif
                            @else
                                {{-- GUEST VIEW --}}
                                <div class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-full text-gray-500 text-sm">❤️ {{ $artwork->likes->count() }} Likes</div>
                                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline text-sm font-semibold">Login to Interact</a>
                            @endif
                        </div> 
                        {{-- END TOMBOL AKSI --}}
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="prose dark:prose-invert max-w-none mb-10 text-gray-700 dark:text-gray-300 leading-relaxed">
                        <p class="whitespace-pre-line">{{ $artwork->description }}</p>
                    </div>

                    {{-- TAGS --}}
                    @if($artwork->tags)
                        <div class="flex flex-wrap gap-2 mb-10">
                            @foreach(explode(',', $artwork->tags) as $tag)
                                <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 text-xs rounded-lg">#{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    @endif

                    <hr class="border-gray-200 dark:border-gray-700 mb-10">

                    {{-- COMMENTS --}}
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Comments ({{ $artwork->comments->count() }})</h3>
                        
                        @if($user)
                            <form action="{{ route('artwork.comment', $artwork) }}" method="POST" class="mb-8 flex gap-4">
                                @csrf
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center font-bold text-indigo-600">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <textarea name="body" rows="2" class="w-full rounded-xl border-gray-300 dark:bg-gray-800 dark:border-gray-600 focus:ring-indigo-500" placeholder="Write a comment..." required></textarea>
                                    <div class="mt-2 flex justify-end">
                                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-full text-sm font-bold">Post</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <p class="text-gray-500 mb-8">Please <a href="{{ route('login') }}" class="text-indigo-600 underline">login</a> to comment.</p>
                        @endif

                        <div class="space-y-6">
                            @foreach($artwork->comments as $comment)
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0 flex items-center justify-center font-bold text-gray-500">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <span class="font-bold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm mt-1">{{ $comment->body }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div> {{-- End Padding Content --}}
            </div> {{-- End Card BG --}}
        </div> {{-- End Max Width --}}
    </div> {{-- End Py-12 --}}

    {{-- MODALS (Hanya Dirender Jika User Ada) --}}
    @if($user)
        {{-- Modal Collection --}}
        <div id="collectionModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-xl p-6 relative">
                <button onclick="document.getElementById('collectionModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500">✕</button>
                <h3 class="font-bold text-lg mb-4 text-gray-900 dark:text-white">Save to Moodboard</h3>
                
                @if($user->collections && $user->collections->count() > 0)
                    <form action="{{ route('collections.add', $artwork) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="flex gap-2">
                            <select name="collection_id" class="flex-1 rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @foreach($user->collections as $col)
                                    <option value="{{ $col->id }}">{{ $col->name }}</option>
                                @endforeach
                            </select>
                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-bold">Save</button>
                        </div>
                    </form>
                    <div class="text-center text-xs text-gray-400 mb-4">OR CREATE NEW</div>
                @endif

                <form action="{{ route('collections.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="artwork_id" value="{{ $artwork->id }}">
                    <input type="text" name="name" placeholder="New Collection Name" class="w-full mb-2 rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    <button class="w-full py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white rounded-lg font-bold">Create & Save</button>
                </form>
            </div>
        </div>

        {{-- Modal Report --}}
        <div id="reportModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-xl p-6 relative">
                <button onclick="document.getElementById('reportModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500">✕</button>
                <h3 class="font-bold text-lg mb-4 text-gray-900 dark:text-white">Report Content</h3>
                <form action="{{ route('artwork.report', $artwork) }}" method="POST">
                    @csrf
                    <select name="reason" class="w-full mb-4 rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="Inappropriate">Inappropriate</option>
                        <option value="Plagiarism">Plagiarism</option>
                        <option value="Spam">Spam</option>
                    </select>
                    <button class="w-full py-2 bg-red-600 text-white rounded-lg font-bold">Submit Report</button>
                </form>
            </div>
        </div>
    @endif

</x-app-layout>