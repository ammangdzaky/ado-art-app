<x-app-layout>
    {{-- LOGIKA DATA --}}
    @php
        $user = Auth::user();
        
        // Tentukan siapa yang boleh interaksi (Hanya Member)
        $canInteract = $user && $user->role === 'member';
        
        // Admin/Curator hanya 'Viewer' (bisa lihat tapi gak bisa like)
        $isViewer = $user && ($user->role === 'admin' || $user->role === 'curator');

        $isLiked = false;
        $isFavorited = false;
        $isFollowing = false;
        
        // Logika cek status (Hanya dijalankan jika user adalah Member)
        if ($canInteract) {
            $isLiked = $artwork->likes()->where('user_id', $user->id)->exists();
            $isFavorited = $artwork->collections()->where('user_id', $user->id)->exists();
            if ($user->id !== $artwork->user_id) {
                $isFollowing = $user->following()->where('followed_id', $artwork->user_id)->exists();
            }
        }

        $moreArtworks = $artwork->user->artworks()
                        ->where('id', '!=', $artwork->id)
                        ->latest()
                        ->take(6)
                        ->get();
    @endphp

    <div class="bg-[#0b0b0b] min-h-screen text-gray-300 pb-20 pt-6">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Pesan Khusus Admin (Opsional, biar sadar lagi mode Admin) --}}
            @if($user && $user->role === 'admin')
                <div class="mb-6 bg-red-900/20 border border-red-900/50 text-red-400 px-4 py-3 rounded-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <span class="font-bold text-sm">ADMIN MODE: You have moderation access to delete this content.</span>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                
                {{-- === KOLOM KIRI (75%) === --}}
                <div class="flex-1 min-w-0">
                    
                    {{-- 1. IMAGE VIEWER --}}
                    <div class="relative w-full rounded-2xl overflow-hidden mb-8 border border-gray-800/50 shadow-2xl bg-[#121212] group min-h-auto lg:min-h-[600px] flex justify-center items-center">
                        <div class="absolute inset-0 z-0 overflow-hidden">
                            <img src="{{ asset('storage/' . $artwork->image_path) }}" class="w-full h-full object-cover blur-[20px] scale-125 ">
                            <div class="absolute inset-0 bg-black/20"></div>
                        </div>
                        <div class="relative z-10 w-full flex justify-center p-0 lg:p-8">
                            <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-auto h-auto max-w-full max-h-[85vh] object-contain shadow-2xl rounded-lg lg:rounded-none">
                        </div>
                    </div>

                    {{-- === MOBILE ONLY INFO === --}}
                    <div class="block lg:hidden mb-8 space-y-6 bg-[#121212] p-5 rounded-xl border border-gray-800">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('artist.show', $artwork->user) }}" class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full overflow-hidden border border-gray-600">
                                    @if($artwork->user->avatar)
                                        <img src="{{ asset('storage/' . $artwork->user->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-white font-bold">{{ substr($artwork->user->name, 0, 1) }}</div>
                                    @endif
                                </div>
                                <div>
                                    <h2 class="text-white font-bold text-base leading-tight">{{ $artwork->user->name }}</h2>
                                    <div class="text-xs text-gray-500 font-medium truncate max-w-[200px]">{{ $artwork->user->bio ?? 'Member' }}</div>
                                </div>
                            </a>
                            {{-- Follow Button (Hanya Member) --}}
                            @if($canInteract && $user->id !== $artwork->user_id)
                                <form action="{{ route('user.follow', $artwork->user) }}" method="POST">
                                    @csrf
                                    <button class="px-4 py-1.5 rounded-full text-xs font-bold transition {{ $isFollowing ? 'bg-gray-800 text-gray-400 border border-gray-700' : 'bg-indigo-600 text-white' }}">
                                        {{ $isFollowing ? 'Following' : 'Follow' }}
                                    </button>
                                </form>
                            @endif
                        </div>

                        {{-- Action Buttons Mobile --}}
                        <div class="grid grid-cols-2 gap-3">
                            @if($canInteract)
                                {{-- MODE MEMBER: Bisa Like/Save --}}
                                <form action="{{ route('artwork.like', $artwork) }}" method="POST">
                                    @csrf
                                    <button class="w-full py-3 rounded-lg font-bold flex items-center justify-center gap-2 {{ $isLiked ? 'bg-indigo-600 text-white' : 'dark:bg-[#121212] text-white border border-gray-700' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $isLiked ? 'fill-white' : 'fill-none stroke-current' }}" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                                        {{ $artwork->likes->count() }}
                                    </button>
                                </form>
                                <button onclick="document.getElementById('collectionModal').classList.remove('hidden')" class="w-full py-3 rounded-lg dark:bg-[#121212] text-white font-bold flex items-center justify-center gap-2 border border-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $isFavorited ? 'fill-white' : 'fill-none stroke-current' }}" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>
                                    Save
                                </button>
                            @elseif($isViewer)
                                {{-- MODE ADMIN/CURATOR: Read Only Stats --}}
                                <div class="col-span-2 flex justify-around py-3 bg-gray-800/50 rounded-lg border border-gray-700">
                                    <span class="text-gray-400 text-xs font-bold uppercase flex items-center gap-2"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/></svg> {{ $artwork->likes->count() }} Likes</span>
                                    <span class="text-gray-400 text-xs font-bold uppercase flex items-center gap-2"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg> {{ $artwork->collections->count() }} Saves</span>
                                </div>
                            @else
                                {{-- MODE GUEST: Login Prompt --}}
                                <a href="{{ route('login') }}" class="col-span-2 w-full py-3 rounded-lg bg-indigo-600 text-white font-bold text-center">Sign In to Like</a>
                            @endif
                        </div>

                        {{-- Download & Admin Tools Mobile --}}
                        <a href="{{ asset('storage/' . $artwork->image_path) }}" download class="flex items-center justify-center w-full py-3 rounded-lg border border-gray-600 hover:border-white text-gray-300 hover:text-white font-bold text-sm transition hover:bg-white/5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            Download Image
                        </a>

                        {{-- Admin/Owner Tools --}}
                        <div class="flex justify-center pt-2 border-t border-gray-800 mt-4">
                            @if($canInteract && $user->id !== $artwork->user_id)
                                <button onclick="document.getElementById('reportModal').classList.remove('hidden')" class="text-red-600 hover:text-red-500 text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                                    Report Artwork
                                </button>
                            @endif
                            
                            {{-- Admin Delete Button --}}
                            @if($user && ($user->id === $artwork->user_id || $user->role === 'admin'))
                                <div class="w-full">
                                    @if($user->id === $artwork->user_id)
                                    <a href="{{ route('artworks.edit', $artwork) }}" class="block w-full text-center py-2 text-xs font-bold text-gray-300 bg-[#252525] rounded mb-2 border border-gray-700">Edit</a>
                                    @endif
                                    
                                    <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" onsubmit="return confirm('Delete?')" class="w-full">
                                        @csrf @method('DELETE')
                                        <button class="w-full py-2 rounded bg-[#252525] text-red-500 text-xs font-bold border border-gray-700 hover:text-red-400 hover:border-red-900">Delete Artwork</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- 2. JUDUL & DESKRIPSI --}}
                    <div class="max-w-5xl mx-auto">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <h1 class="text-3xl md:text-4xl font-black text-white mb-2 tracking-tight">{{ $artwork->title }}</h1>
                                <div class="text-sm text-gray-500 flex items-center gap-2">
                                    <span>Posted {{ $artwork->created_at->diffForHumans() }}</span>
                                    <span>•</span>
                                    <span class="text-indigo-400 font-bold">{{ $artwork->category->name }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="prose prose-invert prose-lg max-w-none text-gray-300 leading-relaxed mb-10">
                            <p class="whitespace-pre-line">{{ $artwork->description }}</p>
                        </div>

                        {{-- 3. KOMENTAR --}}
                        <div class="border-t border-gray-800 pt-10">
                            <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                                Comments <span class="dark:bg-[#121212] text-gray-400 px-2 py-0.5 rounded text-sm">{{ $artwork->comments->count() }}</span>
                            </h3>
                            
                            @if($canInteract)
                                <form action="{{ route('artwork.comment', $artwork) }}" method="POST" class="mb-10 flex gap-4">
                                    @csrf
                                    <div class="w-10 h-10 rounded-full bg-indigo-600 flex-shrink-0 flex items-center justify-center font-bold text-white border border-gray-700">
                                        @if($user->avatar) <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover rounded-full"> @else {{ substr($user->name, 0, 1) }} @endif
                                    </div>
                                    <div class="flex-1">
                                        <textarea name="body" rows="2" class="w-full rounded-lg bg-[#1a1a1a] border-gray-700 text-white focus:ring-indigo-500 placeholder-gray-600 transition p-4" placeholder="Add a comment..." required></textarea>
                                        <div class="mt-3 flex justify-end">
                                            <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-bold text-sm transition shadow-lg">Post Comment</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                {{-- Pesan untuk Guest / Admin --}}
                                <div class="bg-[#1a1a1a] p-6 rounded-lg text-center border border-gray-800 mb-10">
                                    @if($isViewer)
                                        <p class="text-gray-400 text-sm">Admins & Curators are in <strong>View-Only Mode</strong>.</p>
                                    @else
                                        <p class="text-gray-400">Please <a href="{{ route('login') }}" class="text-indigo-400 hover:underline font-bold">Sign In</a> to join the conversation.</p>
                                    @endif
                                </div>
                            @endif

                            <div class="space-y-8">
                                @foreach($artwork->comments as $comment)
                                    <div class="flex gap-4 group">
                                        <a href="{{ route('artist.show', $comment->user) }}" class="w-10 h-10 rounded-full bg-gray-800 flex-shrink-0 flex items-center justify-center overflow-hidden border border-gray-700 hover:border-indigo-500 transition">
                                            @if($comment->user->avatar) <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="w-full h-full object-cover"> @else <span class="text-gray-400 font-bold">{{ substr($comment->user->name, 0, 1) }}</span> @endif
                                        </a>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <a href="{{ route('artist.show', $comment->user) }}" class="font-bold text-gray-200 hover:text-white hover:underline">{{ $comment->user->name }}</a>
                                                    <span class="text-xs text-gray-600 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                {{-- Admin BISA Hapus Komentar --}}
                                                @if($user && ($user->id === $comment->user_id || $user->role === 'admin'))
                                                <form action="{{ route('comment.destroy', $comment) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="text-xs text-gray-600 hover:text-red-500 font-bold uppercase tracking-wider opacity-0 group-hover:opacity-100 transition">Delete</button>
                                                </form>
                                                @endif
                                            </div>
                                            <p class="text-gray-400 mt-1 leading-relaxed">{{ $comment->body }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- === KOLOM KANAN: SIDEBAR (DESKTOP ONLY) === --}}
                <div class="hidden lg:block w-[360px] flex-shrink-0">
                    <div class="sticky top-24 space-y-6">
                        
                        {{-- 1. ARTIST CARD --}}
                        <div class="dark:bg-[#121212] rounded-xl p-5 border border-gray-800 shadow-xl">
                            <div class="flex items-center gap-3 mb-5">
                                <a href="{{ route('artist.show', $artwork->user) }}" class="w-14 h-14 rounded-full overflow-hidden border-2 border-gray-700 hover:border-indigo-500 transition shrink-0">
                                    @if($artwork->user->avatar) <img src="{{ asset('storage/' . $artwork->user->avatar) }}" class="w-full h-full object-cover"> @else <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xl">{{ substr($artwork->user->name, 0, 1) }}</div> @endif
                                </a>
                                <div class="overflow-hidden">
                                    <a href="{{ route('artist.show', $artwork->user) }}" class="block text-white font-bold text-lg hover:text-indigo-400 transition truncate">{{ $artwork->user->name }}</a>
                                    <div class="text-xs text-gray-500 truncate">{{ $artwork->user->bio ?? 'Member of AdoArt' }}</div>
                                </div>
                            </div>

                            @if($canInteract && $user->id !== $artwork->user_id)
                                <form action="{{ route('user.follow', $artwork->user) }}" method="POST">
                                    @csrf
                                    <button class="w-full py-2 rounded-lg font-bold text-sm transition flex items-center justify-center gap-2 {{ $isFollowing ? 'bg-gray-700 text-gray-300 hover:bg-red-900/50 hover:text-red-400' : 'bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-500/30' }}">
                                        {{ $isFollowing ? 'Following' : 'Follow' }}
                                    </button>
                                </form>
                            @elseif(!$user)
                                <a href="{{ route('login') }}" class="block w-full py-2 rounded-lg font-bold text-sm bg-indigo-600 hover:bg-indigo-500 text-white text-center transition">Follow</a>
                            @endif
                        </div>

                        {{-- 2. ACTIONS CARD --}}
                        <div class="dark:bg-[#121212] rounded-xl p-5 border border-gray-800 shadow-xl">
                            <div class="flex gap-3 mb-6">
                                @if($canInteract)
                                    {{-- MODE MEMBER: Interact --}}
                                    <form action="{{ route('artwork.like', $artwork) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button class="w-full py-3 rounded-lg font-bold flex flex-col items-center justify-center transition group shadow-lg {{ $isLiked ? 'bg-indigo-600 text-white shadow-indigo-500/30' : 'bg-gradient-to-br from-indigo-600 to-blue-600 text-white hover:opacity-90' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 {{ $isLiked ? 'fill-white' : 'fill-none stroke-current' }}" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                                            <span class="text-xs">{{ $isLiked ? 'Liked' : 'Like' }}</span>
                                        </button>
                                    </form>
                                    <button onclick="document.getElementById('collectionModal').classList.remove('hidden')" class="flex-1 py-3 rounded-lg bg-[#2a2a2a] hover:bg-[#333] text-gray-300 hover:text-white font-bold flex flex-col items-center justify-center border border-gray-700 transition" title="Save">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 {{ $isFavorited ? 'fill-white' : 'fill-none stroke-current' }}" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>
                                        <span class="text-xs">{{ $isFavorited ? 'Saved' : 'Save' }}</span>
                                    </button>
                                @elseif($isViewer)
                                    {{-- MODE ADMIN: Read Only --}}
                                    <div class="w-full py-3 bg-gray-800 text-gray-500 text-xs font-bold text-center rounded-lg border border-gray-700">
                                        VIEW ONLY MODE
                                    </div>
                                @else
                                    {{-- MODE GUEST --}}
                                    <a href="{{ route('login') }}" class="flex-1 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-bold flex flex-col items-center justify-center transition shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                                        <span class="text-xs">Like</span>
                                    </a>
                                @endif
                            </div>
                            
                            {{-- Stats --}}
                            <div class="flex justify-center gap-8 text-sm text-gray-500 font-medium mb-6">
                                <span class="flex items-center gap-2"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/></svg> {{ $artwork->likes->count() }} Likes</span>
                                <span class="flex items-center gap-2"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"/></svg> {{ $artwork->collections->count() }} Saves</span>
                            </div>

                            <a href="{{ asset('storage/' . $artwork->image_path) }}" download class="block w-full py-2.5 text-center border border-gray-600 hover:border-white text-gray-300 hover:text-white rounded-lg font-bold text-sm transition mb-4 hover:bg-white/5">
                                <i class="fas fa-download mr-2"></i> Download Image
                            </a>

                            {{-- Tools --}}
                            @if($canInteract && $user->id !== $artwork->user_id)
                                <button onclick="document.getElementById('reportModal').classList.remove('hidden')" class="block w-full text-center text-xs text-red-600 hover:text-red-500 mt-2 font-medium uppercase tracking-wider">Report Artwork</button>
                            @endif
                            
                            {{-- Admin Delete Access --}}
                            @if($user && ($user->id === $artwork->user_id || $user->role === 'admin'))
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                    @if($user->id === $artwork->user_id)
                                    <a href="{{ route('artworks.edit', $artwork) }}" class="block w-full text-center py-2 text-xs font-bold text-gray-300 bg-[#252525] rounded hover:text-white border border-gray-700">Edit</a>
                                    @endif
                                    <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" onsubmit="return confirm('Delete?')" class="w-full {{ $user->role === 'admin' ? 'col-span-2' : '' }}">
                                        @csrf @method('DELETE')
                                        <button class="block w-full text-center py-2 text-xs font-bold text-red-400 bg-[#252525] rounded hover:text-red-300 border border-gray-700">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        {{-- 3. TAGS CARD --}}
                        @if($artwork->tags)
                        <div class="dark:bg-[#121212] rounded-xl p-5 border border-gray-800 shadow-xl">
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Tags</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $artwork->tags) as $tag)
                                    <a href="{{ route('artworks.index', ['search' => trim($tag)]) }}#gallery-section" class="px-3 py-1.5 bg-[#252525] hover:bg-gray-700 text-gray-300 hover:text-white text-xs rounded-md border border-gray-700 transition">
                                        {{ trim($tag) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- 4. MORE BY ARTIST --}}
                        @if($moreArtworks->count() > 0)
                        <div class="dark:bg-[#121212] rounded-xl p-5 border border-gray-800 shadow-xl">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">More by {{ $artwork->user->name }}</h4>
                                <a href="{{ route('artist.show', $artwork->user) }}" class="text-xs text-indigo-400 hover:text-white font-bold">View all</a>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($moreArtworks as $more)
                                    <a href="{{ route('artworks.show', $more) }}" class="block aspect-square rounded-lg overflow-hidden relative group border border-gray-800 hover:border-gray-600 transition">
                                        <img src="{{ asset('storage/' . $more->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition"></div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODALS (Sama) --}}
    @if($canInteract)
        {{-- Modal Collection --}}
        <div id="collectionModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
            <div class="dark:bg-[#121212] w-full max-w-md rounded-xl p-6 relative border border-gray-700 shadow-2xl">
                <button onclick="document.getElementById('collectionModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-white">✕</button>
                <h3 class="font-bold text-lg mb-4 text-white">Save to Moodboard</h3>
                @if($user->collections && $user->collections->count() > 0)
                    <form action="{{ route('collections.add', $artwork) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="flex gap-2">
                            <select name="collection_id" class="flex-1 rounded-lg bg-[#121212] border-gray-700 text-white focus:ring-indigo-500">
                                @foreach($user->collections as $col)
                                    <option value="{{ $col->id }}">{{ $col->name }}</option>
                                @endforeach
                            </select>
                            <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-bold">Save</button>
                        </div>
                    </form>
                    <div class="text-center text-xs text-gray-500 mb-4 font-bold uppercase tracking-widest">Or Create New</div>
                @endif
                <form action="{{ route('collections.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="artwork_id" value="{{ $artwork->id }}">
                    <input type="text" name="name" placeholder="New Collection Name" class="w-full mb-3 rounded-lg bg-[#121212] border-gray-700 text-white focus:ring-indigo-500" required>
                    <button class="w-full py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-bold border border-gray-600">Create & Save</button>
                </form>
            </div>
        </div>

        {{-- Report Modal --}}
        <div id="reportModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
            <div class="dark:bg-[#121212] w-full max-w-md rounded-xl p-6 relative border border-gray-700 shadow-2xl">
                <button onclick="document.getElementById('reportModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-white">✕</button>
                <h3 class="font-bold text-lg mb-4 text-white">Report Artwork</h3>
                <form action="{{ route('artwork.report', $artwork) }}" method="POST">
                    @csrf
                    <div class="space-y-3 mb-6">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-700 hover:bg-gray-800 cursor-pointer transition group">
                            <input type="radio" name="reason" value="Inappropriate Content" class="text-red-600 focus:ring-red-600 bg-gray-900 border-gray-600" required>
                            <span class="text-gray-300 group-hover:text-white text-sm">Inappropriate Content (NSFW)</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-700 hover:bg-gray-800 cursor-pointer transition group">
                            <input type="radio" name="reason" value="Plagiarism" class="text-red-600 focus:ring-red-600 bg-gray-900 border-gray-600">
                            <span class="text-gray-300 group-hover:text-white text-sm">Plagiarism / Stolen Art</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-700 hover:bg-gray-800 cursor-pointer transition group">
                            <input type="radio" name="reason" value="Spam" class="text-red-600 focus:ring-red-600 bg-gray-900 border-gray-600">
                            <span class="text-gray-300 group-hover:text-white text-sm">Spam or Misleading</span>
                        </label>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('reportModal').classList.add('hidden')" class="px-4 py-2 text-gray-400 hover:text-white text-sm font-bold">Cancel</button>
                        <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg font-bold text-sm shadow-lg shadow-red-600/20 transition">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</x-app-layout>