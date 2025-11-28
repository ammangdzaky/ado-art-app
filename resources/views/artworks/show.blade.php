<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="w-full bg-gray-100 dark:bg-gray-900 flex justify-center p-4">
                    <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}" class="max-h-[80vh] w-auto object-contain rounded-md shadow-md">
                </div>

                <div class="p-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $artwork->title }}</h1>
                            <div class="flex items-center mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <span>by <span class="font-bold text-indigo-500">{{ $artwork->user->name }}</span></span>
                                <span class="mx-2">•</span>
                                <span>{{ $artwork->created_at->format('M d, Y') }}</span>
                                <span class="mx-2">•</span>
                                <span class="px-2 py-1 bg-gray-200 dark:bg-gray-700 rounded-full text-xs">
                                    {{ $artwork->category->name }}
                                </span>
                            </div>
                        </div>

                        @if(Auth::id() === $artwork->user_id)
                        <div class="flex space-x-2">
                            <a href="{{ route('artworks.edit', $artwork) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 text-sm">Edit</a>
                            <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" onsubmit="return confirm('Delete this artwork?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">Delete</button>
                            </form>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6 prose dark:prose-invert max-w-none">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Description</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300 whitespace-pre-line">
                            {{ $artwork->description }}
                        </p>
                    </div>

                    @if($artwork->tags)
                    <div class="mt-6">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $artwork->tags) as $tag)
                                <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 rounded-full text-xs">
                                    #{{ trim($tag) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>