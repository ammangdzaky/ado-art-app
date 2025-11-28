<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Explore Artworks') }}
            </h2>
            
            @auth
            <a href="{{ route('artworks.create') }}" class="px-4 py-2 bg-indigo-600 rounded-md text-white text-sm font-bold hover:bg-indigo-700">
                + Upload Art
            </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex flex-col md:flex-row gap-4">
                <form action="{{ route('artworks.index') }}" method="GET" class="flex-1 flex gap-2">
                    <input type="text" name="search" placeholder="Search title..." value="{{ request('search') }}" 
                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500">
                    <button type="submit" class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700">
                        Search
                    </button>
                </form>
            </div>

            @if(request()->routeIs('home'))
            <div class="relative bg-gray-900 overflow-hidden mb-12">
                <div class="absolute inset-0">
                    <img src="https://images.unsplash.com/photo-1547891654-e66ed7ebb968?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover opacity-30">
                </div>
                <div class="relative max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8 text-center">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Discover the Extraordinary.
                    </h1>
                    <p class="mt-6 text-xl text-gray-300 max-w-3xl mx-auto">
                        AdoArt is the premier showcase for digital artists. Join challenges, build your portfolio, and find inspiration.
                    </p>
                    @guest
                    <div class="mt-10 flex justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                            Get Started
                        </a>
                        <a href="{{ route('challenges.browse') }}" class="px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                            View Challenges
                        </a>
                    </div>
                    @endguest
                </div>
            </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($artworks as $artwork)
                <div class="group relative bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-1 hover:shadow-2xl">
                    <a href="{{ route('artworks.show', $artwork) }}" class="block w-full h-64 overflow-hidden">
                        <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </a>
                    
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black via-black/70 to-transparent p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <h3 class="text-white font-bold truncate">{{ $artwork->title }}</h3>
                        <p class="text-gray-300 text-xs">{{ $artwork->user->name }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                    No artworks found. Be the first to upload!
                </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $artworks->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>