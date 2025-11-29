<x-app-layout>
    
    {{-- 1. CHALLENGES BILLBOARD (MARQUEE) --}}
    @if($activeChallenges->count() > 0)
    <div class="bg-black border-b border-gray-800 overflow-hidden marquee-container relative group">
        <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-gray-900 to-transparent z-10 pointer-events-none"></div>
        <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-gray-900 to-transparent z-10 pointer-events-none"></div>

        <div class="py-6 flex animate-marquee">
            @for ($i = 0; $i < 2; $i++) 
                @foreach($activeChallenges as $challenge)
                <a href="{{ route('challenges.show', $challenge) }}" class="relative block w-[400px] h-[220px] mx-3 rounded-xl overflow-hidden shadow-lg transform transition hover:scale-105 hover:shadow-indigo-500/50 flex-shrink-0 border border-gray-800">
                    <img src="{{ asset('storage/' . $challenge->banner_path) }}" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>
                    <div class="absolute bottom-0 left-0 p-5 w-full">
                        <span class="px-2 py-1 bg-indigo-600 text-white text-[10px] font-bold uppercase tracking-wider rounded-sm mb-2 inline-block">CHALLENGE</span>
                        <h3 class="text-xl font-black text-white leading-tight mb-1 drop-shadow-md">{{ $challenge->title }}</h3>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-yellow-400 text-xs font-bold"></span>
                            <span class="text-gray-400 text-xs">Ends {{ $challenge->end_date->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            @endfor
        </div>
    </div>
    @endif

    {{-- BAGIAN 2: CATEGORIES BAR (REVISI WARNA DARK MODE) --}}
    <div id="gallery-section" class="scroll-mt-24 sticky top-0 z-30 bg-white dark:bg-[#121212] backdrop-blur-md border-b border-gray-200 dark:border-gray-800 shadow-sm" x-data="{ categoryMenuOpen: false }">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16 gap-4">
                
                {{-- A. MOBILE ONLY: Tombol Titik Tiga (...) --}}
                <div class="md:hidden flex items-center">
                    <button @click="categoryMenuOpen = !categoryMenuOpen" 
                            class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#1a1a1a] hover:text-indigo-500 transition border border-gray-200 dark:border-gray-700 bg-transparent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>
                    </button>
                    
                    <span class="ml-3 font-bold text-gray-900 dark:text-white text-sm tracking-wide">
                        {{ request('category') ? ucwords(str_replace('-', ' ', request('category'))) : 'Explore' }}
                    </span>
                </div>

                {{-- B. DESKTOP ONLY: Horizontal Scroll (Pills) --}}
                <div class="hidden md:flex flex-1 overflow-x-auto hide-scroll items-center space-x-2 py-2">
                    {{-- Tombol "All Art" (+ #gallery-section) --}}
                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}#gallery-section" 
                       class="px-5 py-1.5 rounded-full text-sm font-bold transition whitespace-nowrap {{ !request('category') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-[#1a1a1a]' }}">
                       All Art
                    </a>

                    @foreach($categories as $cat)
                    {{-- Tombol Kategori (+ #gallery-section) --}}
                    <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}#gallery-section" 
                       class="px-5 py-1.5 rounded-full text-sm font-medium transition whitespace-nowrap {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-[#1a1a1a]' }}">
                       {{ $cat->name }}
                    </a>
                    @endforeach
                </div>

                {{-- C. KANAN: Filter & Sort --}}
                <div class="flex-shrink-0 flex items-center border-l border-gray-200 dark:border-gray-800 pl-4">
                    

                    {{-- MOBILE ONLY: Dropdown Sort --}}
                    <div class="md:hidden relative" x-data="{ sortOpen: false }">
                        <button @click="sortOpen = !sortOpen" class="flex items-center gap-1 text-gray-900 dark:text-white font-bold text-sm bg-gray-100 dark:bg-[#1a1a1a] px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-indigo-500 transition">
                            <span>{{ request('sort') == 'trending' ? 'Trending' : 'Latest' }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="sortOpen" @click.outside="sortOpen = false" class="absolute right-0 mt-2 w-40 bg-white dark:bg-[#1a1a1a] rounded-xl shadow-2xl border border-gray-100 dark:border-gray-800 py-1 z-50 origin-top-right" style="display: none;">
                            {{-- Link Mobile Sort (+ #gallery-section) --}}
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}#gallery-section" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-[#252525] {{ !request('sort') || request('sort') == 'latest' ? 'font-bold text-indigo-500' : 'text-gray-700 dark:text-gray-300' }}">Latest</a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'trending']) }}#gallery-section" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-[#252525] {{ request('sort') == 'trending' ? 'font-bold text-indigo-500' : 'text-gray-700 dark:text-gray-300' }}">Trending</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- D. MOBILE CATEGORY DRAWER --}}
        <div x-show="categoryMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             @click.outside="categoryMenuOpen = false"
             class="absolute top-16 left-0 w-full bg-white dark:bg-[#121212] border-b border-gray-200 dark:border-gray-800 shadow-2xl z-40 md:hidden max-h-[80vh] overflow-y-auto">
            
            <div class="p-4 grid grid-cols-1 gap-1">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 px-3">All Channels</p>
                
                {{-- Tombol All Art Mobile (+ #gallery-section) --}}
                <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}#gallery-section" 
                   class="flex items-center justify-between px-3 py-3 rounded-lg transition {{ !request('category') ? 'bg-indigo-600 text-white font-bold shadow-lg' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#1a1a1a]' }}">
                   <div class="flex items-center gap-3">
                       <div class="w-8 h-8 rounded bg-white/20 flex items-center justify-center text-current">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                       </div>
                       <span>Explore All</span>
                   </div>
                   @if(!request('category')) <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg> @endif
                </a>

                {{-- List Kategori Mobile (+ #gallery-section) --}}
                @foreach($categories as $cat)
                <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}#gallery-section" 
                   class="flex items-center justify-between px-3 py-3 rounded-lg group transition {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white font-bold shadow-lg' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-[#1a1a1a] dark:hover:text-white' }}">
                   
                   <div class="flex items-center gap-3">
                       <div class="w-8 h-8 rounded bg-gray-200 dark:bg-[#252525] overflow-hidden relative">
                           <div class="absolute inset-0 flex items-center justify-center text-xs font-bold text-gray-500 dark:text-gray-400 group-hover:text-white transition">
                               {{ substr($cat->name, 0, 1) }}
                           </div>
                       </div>
                       <span>{{ $cat->name }}</span>
                   </div>

                   @if(request('category') == $cat->slug) 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg> 
                   @endif
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- 3. MAIN GALLERY GRID --}}
    <div class="bg-gray-50 dark:bg-[#0b0b0b] min-h-screen py-8">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6">
            
            {{-- Ubah Grid menjadi 4 Kolom di layar besar (lg) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($artworks as $artwork)
                <div class="group relative aspect-square bg-gray-900 rounded-lg overflow-hidden cursor-pointer">
                    
                    {{-- Layer 1: Image (Clean) --}}
                    <a href="{{ route('artworks.show', $artwork) }}" class="block w-full h-full">
                        <img src="{{ asset('storage/' . $artwork->image_path) }}" 
                             alt="{{ $artwork->title }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </a>

                    {{-- Layer 2: Hover Overlay (Info Muncul Saat Hover) --}}
                    <a href="{{ route('artworks.show', $artwork) }}" class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                        
                        {{-- Top Right: Like Badge --}}
                        <div class="absolute top-3 right-3 bg-black/50 backdrop-blur-sm rounded-full px-3 py-1 text-xs font-bold text-white flex items-center gap-1 transform translate-y-[-10px] opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition duration-300 delay-75">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-pink-500 fill-current" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" /></svg>
                            {{ $artwork->likes_count ?? $artwork->likes->count() }}
                        </div>

                        {{-- Bottom: User & Title info --}}
                        <div class="transform translate-y-[10px] opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition duration-300">
                            <h3 class="text-white font-bold text-lg leading-tight truncate">{{ $artwork->title }}</h3>
                            
                            <div class="flex items-center gap-2 mt-2">
                                {{-- Avatar User --}}
                                <div class="w-6 h-6 rounded-full overflow-hidden border border-white/30">
                                    @if($artwork->user->avatar)
                                        <img src="{{ asset('storage/' . $artwork->user->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-indigo-500 flex items-center justify-center text-[8px] text-white font-bold">
                                            {{ substr($artwork->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <span class="text-gray-300 text-xs font-medium truncate">{{ $artwork->user->name }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-span-full py-24 text-center">
                    <div class="inline-block p-4 rounded-full bg-gray-800 text-gray-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <p class="text-gray-400 text-lg">No artworks found.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-12 pb-24">
                {{ $artworks->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- 4. FLOATING FILTER BAR (NEW FEATURE) --}}
    <div class="fixed bottom-8 left-1/2 transform -translate-x-1/2 z-40 bg-gray-900/90 backdrop-blur-xl border border-gray-700 rounded-full shadow-2xl p-1.5 hidden md:flex items-center gap-2 transition-all duration-300 hover:scale-105">
        
        {{-- Link Desktop (+ #gallery-section) --}}
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}#gallery-section" 
           class="px-6 py-2.5 rounded-full text-sm font-bold transition {{ !request('sort') || request('sort') == 'latest' ? 'bg-white text-black shadow-lg scale-105' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
           Latest
        </a>
        
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'trending']) }}#gallery-section" 
           class="px-6 py-2.5 rounded-full text-sm font-bold transition {{ request('sort') == 'trending' ? 'bg-white text-black shadow-lg scale-105' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
           Trending
        </a>

    </div>

</x-app-layout>