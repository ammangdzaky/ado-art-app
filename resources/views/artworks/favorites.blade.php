<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My Favorites</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse($favorites as $fav)
                <div class="group relative bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg">
                    <a href="{{ route('artworks.show', $fav->artwork) }}" class="block aspect-square">
                        <img src="{{ asset('storage/' . $fav->artwork->image_path) }}" class="w-full h-full object-cover">
                    </a>
                    <div class="p-3 bg-white dark:bg-gray-800">
                        <h3 class="font-bold text-gray-900 dark:text-white truncate">{{ $fav->artwork->title }}</h3>
                        <p class="text-xs text-gray-500">{{ $fav->artwork->user->name }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center text-gray-500">You haven't added any favorites yet.</div>
                @endforelse
            </div>
            <div class="mt-4">{{ $favorites->links() }}</div>
        </div>
    </div>
</x-app-layout>