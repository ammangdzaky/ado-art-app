<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="w-full bg-gray-100 dark:bg-gray-900 flex justify-center p-4">
                    <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="max-h-[80vh] w-auto object-contain rounded-md shadow-md">
                </div>

                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $artwork->title }}</h1>
                            <div class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400 gap-2">
                                <a href="{{ route('artist.show', $artwork->user) }}" class="flex items-center gap-2 hover:text-indigo-500 transition">
                                    <div class="w-6 h-6 rounded-full bg-gray-300 overflow-hidden">
                                        <svg class="w-full h-full text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                    </div>
                                    <span class="font-bold">{{ $artwork->user->name }}</span>
                                </a>
                                <span>•</span>
                                <span>{{ $artwork->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            @auth
                            <form action="{{ route('artwork.like', $artwork) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-full border {{ $artwork->likes->contains('user_id', Auth::id()) ? 'bg-pink-100 border-pink-500 text-pink-600' : 'border-gray-300 text-gray-500 hover:bg-gray-50' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $artwork->likes->contains('user_id', Auth::id()) ? 'fill-current' : 'fill-none stroke-current' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span>{{ $artwork->likes->count() }}</span>
                                </button>
                            </form>
                            @else
                                <div class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-300 text-gray-500">
                                    <span>❤️ {{ $artwork->likes->count() }}</span>
                                </div>
                            @endauth

                            @if(Auth::id() === $artwork->user_id)
                                <a href="{{ route('artworks.edit', $artwork) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md text-sm">Edit</a>
                                <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE')
                                    <button class="px-4 py-2 bg-red-600 text-white rounded-md text-sm">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="prose dark:prose-invert max-w-none mb-8">
                        <p class="whitespace-pre-line">{{ $artwork->description }}</p>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700 mb-8">

                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Comments ({{ $artwork->comments->count() }})</h3>
                        
                        @auth
                        <form action="{{ route('artwork.comment', $artwork) }}" method="POST" class="mb-8">
                            @csrf
                            <textarea name="body" rows="3" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500" placeholder="Write a comment..." required></textarea>
                            <div class="mt-2 flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-bold">Post Comment</button>
                            </div>
                        </form>
                        @endauth

                        <div class="space-y-6">
                            @foreach($artwork->comments as $comment)
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0"></div>
                                <div class="flex-1">
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold text-gray-900 dark:text-white text-sm">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $comment->body }}</p>
                                    </div>
                                    @if(Auth::id() === $comment->user_id || Auth::user()?->role === 'admin')
                                    <form action="{{ route('comment.destroy', $comment) }}" method="POST" class="mt-1">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-red-500 hover:underline">Delete</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>