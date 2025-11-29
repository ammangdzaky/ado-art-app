<x-app-layout>
    <div class="bg-[#0b0b0b] min-h-screen text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- HEADER: Back & Title --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 border-b border-gray-800 pb-8">
                <div>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-white uppercase tracking-wider mb-4 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Back to Dashboard
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tight">{{ $collection->name }}</h1>
                    @if($collection->description)
                        <p class="text-gray-400 mt-2 max-w-2xl text-sm leading-relaxed">{{ $collection->description }}</p>
                    @endif
                </div>

                {{-- Meta Info --}}
                <div class="flex items-center gap-4">
                    <span class="px-4 py-1.5 dark:bg-[#1e1e1e] text-indigo-400 border border-indigo-500/30 rounded-full text-xs font-bold uppercase tracking-wide">
                        {{ $artworks->total() }} Items
                    </span>
                </div>
            </div>

            {{-- GALLERY GRID --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($artworks as $artwork)
                    <div class="group relative bg-[#121212] rounded-xl overflow-hidden border border-gray-800 hover:border-gray-600 transition shadow-lg">
                        
                        {{-- Image Link --}}
                        <a href="{{ route('artworks.show', $artwork) }}" class="block aspect-square overflow-hidden relative">
                            <img src="{{ asset('storage/' . $artwork->image_path) }}" 
                                 alt="{{ $artwork->title }}" 
                                 class="w-full h-full object-cover transition duration-700 group-hover:scale-110 opacity-80 group-hover:opacity-100">
                            
                            {{-- Overlay Hover --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                        </a>

                        {{-- Info --}}
                        <div class="p-4 bg-[#121212]">
                            <h4 class="text-white font-bold text-sm truncate">{{ $artwork->title }}</h4>
                            <div class="flex items-center gap-2 mt-2">
                                <div class="w-5 h-5 rounded-full bg-indigo-600 flex items-center justify-center text-[8px] text-white font-bold overflow-hidden">
                                    @if($artwork->user->avatar)
                                        <img src="{{ asset('storage/' . $artwork->user->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($artwork->user->name, 0, 1) }}
                                    @endif
                                </div>
                                <span class="text-xs text-gray-500 truncate">{{ $artwork->user->name }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="col-span-full py-24 text-center border-2 border-dashed border-gray-800 rounded-2xl">
                        <div class="dark:bg-[#1e1e1e] w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-1">This moodboard is empty</h3>
                        <p class="text-gray-500 text-sm mb-6">Start saving artworks to build your collection.</p>
                        <a href="{{ route('artworks.index') }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-bold text-sm transition shadow-lg shadow-indigo-500/20">
                            Browse Artworks
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $artworks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>