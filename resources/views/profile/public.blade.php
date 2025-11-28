<x-app-layout>
    <div class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="w-32 h-32 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-4xl font-bold text-indigo-600 dark:text-indigo-300">
                    {{ substr($user->name, 0, 1) }}
                </div>
                
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $user->bio ?? 'Artist at AdoArt' }}</p>
                    
                    <div class="flex justify-center md:justify-start gap-6 mt-4 text-sm font-medium text-gray-600 dark:text-gray-300">
                        <div><span class="font-bold text-gray-900 dark:text-white">{{ $user->artworks->count() }}</span> Artworks</div>
                        <div><span class="font-bold text-gray-900 dark:text-white">{{ $user->followers->count() }}</span> Followers</div>
                        <div><span class="font-bold text-gray-900 dark:text-white">{{ $user->following->count() }}</span> Following</div>
                    </div>
                </div>

                @auth
                    @if(Auth::id() !== $user->id)
                    <form action="{{ route('user.follow', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2 rounded-full font-bold transition {{ $isFollowing ? 'bg-gray-200 text-gray-800 hover:bg-red-100 hover:text-red-600' : 'bg-indigo-600 text-white hover:bg-indigo-700' }}">
                            {{ $isFollowing ? 'Following' : 'Follow' }}
                        </button>
                    </form>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Portfolio</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($user->artworks as $artwork)
                <div class="group relative bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:-translate-y-1 transition duration-300">
                    <a href="{{ route('artworks.show', $artwork) }}" class="block aspect-square">
                        <img src="{{ asset('storage/' . $artwork->image_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </a>
                    <div class="absolute bottom-0 inset-x-0 p-4 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition">
                        <p class="text-white font-bold truncate">{{ $artwork->title }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    This user hasn't uploaded any artworks yet.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>