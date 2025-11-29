{{-- resources/views/artworks/partials/sidebar.blade.php --}}
<div class="space-y-6">
                        
    {{-- 1. ARTIST PROFILE --}}
    <div class="flex items-center justify-between p-2">
        <a href="{{ route('artist.show', $artwork->user) }}" class="flex items-center gap-3 group">
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-transparent group-hover:border-indigo-500 transition relative">
                @if($artwork->user->avatar)
                    <img src="{{ asset('storage/' . $artwork->user->avatar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-lg">{{ substr($artwork->user->name, 0, 1) }}</div>
                @endif
            </div>
            <div>
                <h2 class="text-white font-bold text-lg leading-tight group-hover:text-indigo-400 transition">{{ $artwork->user->name }}</h2>
                <div class="text-xs text-gray-500 font-medium">Concept Artist</div>
            </div>
        </a>

        @if($user && $user->id !== $artwork->user_id)
            <form action="{{ route('user.follow', $artwork->user) }}" method="POST">
                @csrf
                <button class="px-5 py-2 rounded-full text-xs font-bold transition shadow-lg {{ $isFollowing ? 'bg-gray-800 text-gray-400 hover:text-white border border-gray-700' : 'bg-indigo-600/10 text-indigo-400 border border-indigo-500/50 hover:bg-indigo-600 hover:text-white' }}">
                    {{ $isFollowing ? 'Following' : 'Follow' }}
                </button>
            </form>
        @endif
    </div>

    {{-- 2. MAIN ACTIONS CARD --}}
    <div class="bg-[#1a1a1a] rounded-2xl p-6 border border-gray-800 shadow-2xl relative overflow-hidden group">
        
        {{-- Ambient Glow --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 blur-[60px] rounded-full pointer-events-none"></div>

        <div class="relative z-10">
            <div class="grid grid-cols-2 gap-3 mb-6">
                
                {{-- TOMBOL LIKE --}}
                @if($user)
                    <form action="{{ route('artwork.like', $artwork) }}" method="POST">
                        @csrf
                        <button class="w-full py-4 rounded-xl font-bold flex flex-col items-center justify-center transition-all duration-300 group/btn {{ $isLiked ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40 scale-[1.02]' : 'bg-gradient-to-br from-indigo-600 to-blue-600 text-white shadow-md hover:shadow-indigo-500/20 hover:-translate-y-0.5' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 {{ $isLiked ? 'fill-white' : 'fill-transparent stroke-current' }} transition-transform group-hover/btn:scale-110" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                            </svg>
                            <span class="text-xs tracking-wide">Like</span>
                        </button>
                    </form>
                    
                    {{-- TOMBOL SAVE --}}
                    <button onclick="document.getElementById('collectionModal').classList.remove('hidden')" class="w-full py-4 rounded-xl font-bold flex flex-col items-center justify-center transition-all duration-300 bg-[#252525] hover:bg-[#303030] text-gray-400 hover:text-white border border-gray-700 hover:border-gray-600 group/btn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 transition-transform group-hover/btn:scale-110 {{ $isFavorited ? 'fill-white text-white' : 'fill-none stroke-current' }}" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>
                        <span class="text-xs tracking-wide">Save</span>
                    </button>
                @else
                    <a href="{{ route('login') }}" class="col-span-2 w-full py-3 rounded-xl bg-indigo-600 text-white font-bold text-center">Sign In to Like</a>
                @endif
            </div>
            
            {{-- Stats Row --}}
            <div class="flex justify-center gap-8 text-sm text-gray-500 font-medium mb-6">
                <div class="flex items-center gap-2">
                    <span class="text-white font-bold text-lg">{{ $artwork->likes->count() }}</span> Likes
                </div>
                <div class="w-px h-6 bg-gray-700"></div>
                <div class="flex items-center gap-2">
                    <span class="text-white font-bold text-lg">{{ $artwork->favorites->count() }}</span> Saves
                </div>
            </div>

            <div class="w-full h-px bg-gray-800 mb-6"></div>

            {{-- Download Button --}}
            <a href="{{ asset('storage/' . $artwork->image_path) }}" download class="flex items-center justify-center w-full py-3 rounded-xl border border-gray-600 hover:border-white text-gray-300 hover:text-white font-bold text-sm transition hover:bg-white/5 mb-6 group/down">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover/down:animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                Download Image
            </a>

            {{-- Tools (Edit/Delete & Report) --}}
            <div class="flex flex-col items-center gap-4">
                @if($user && $user->id !== $artwork->user_id)
                    {{-- PERBAIKAN: Warna Report menjadi Merah --}}
                    <button onclick="document.getElementById('reportModal').classList.remove('hidden')" class="text-[10px] uppercase tracking-widest font-bold text-red-600 hover:text-red-400 transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        Report Artwork
                    </button>
                @endif

                @if($user && $user->id === $artwork->user_id)
                    {{-- PERBAIKAN: Tombol Edit & Delete yang Rapi --}}
                    <div class="grid grid-cols-2 gap-3 w-full">
                        <a href="{{ route('artworks.edit', $artwork) }}" class="flex items-center justify-center gap-2 py-2.5 rounded-xl bg-[#252525] hover:bg-indigo-600/20 text-gray-300 hover:text-indigo-400 font-bold text-sm transition border border-gray-700 hover:border-indigo-500/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                            Edit
                        </a>
                        <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this artwork? This action cannot be undone.');" class="w-full">
                            @csrf @method('DELETE')
                            <button class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl bg-[#252525] hover:bg-red-600/20 text-gray-300 hover:text-red-400 font-bold text-sm transition border border-gray-700 hover:border-red-500/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- 3. TAGS CARD --}}
    @if($artwork->tags)
    <div class="bg-[#1a1a1a] rounded-2xl p-6 border border-gray-800 shadow-xl">
        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 ml-1">Tags</h4>
        <div class="flex flex-wrap gap-2">
            @foreach(explode(',', $artwork->tags) as $tag)
                <a href="{{ route('artworks.index', ['search' => trim($tag)]) }}#gallery-section" 
                    class="px-4 py-1.5 bg-[#252525] hover:bg-gray-700 text-gray-300 hover:text-white text-xs font-medium rounded-full border border-gray-700/50 hover:border-gray-500 transition">
                    {{ trim($tag) }}
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- 4. MORE BY ARTIST --}}
    @if($moreArtworks->count() > 0)
    <div class="bg-[#1a1a1a] rounded-2xl p-6 border border-gray-800 shadow-xl">
        <div class="flex justify-between items-end mb-4 px-1">
            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">More by {{ $artwork->user->name }}</h4>
            <a href="{{ route('artist.show', $artwork->user) }}" class="text-xs text-indigo-400 hover:text-white font-bold transition">View all</a>
        </div>
        <div class="grid grid-cols-2 gap-3">
            @foreach($moreArtworks as $more)
                <a href="{{ route('artworks.show', $more) }}" class="block aspect-square rounded-xl overflow-hidden relative group border border-gray-800 hover:border-gray-600 transition">
                    <img src="{{ asset('storage/' . $more->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition"></div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

</div>