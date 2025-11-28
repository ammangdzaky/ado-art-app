<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Artwork</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('artworks.update', $artwork) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Current Image</label>
                            <img src="{{ asset('storage/' . $artwork->image_path) }}" class="h-40 rounded object-contain bg-gray-100 dark:bg-gray-700">
                        </div>

                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Change Image (Optional)')" />
                            <input type="file" name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                        </div>

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title', $artwork->title) }}" required />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select name="category_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $artwork->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md" required>{{ old('description', $artwork->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tags" :value="__('Tags')" />
                            <x-text-input id="tags" class="block mt-1 w-full" type="text" name="tags" value="{{ old('tags', $artwork->tags) }}" />
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('artworks.show', $artwork) }}" class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</a>
                            <x-primary-button>{{ __('Update Artwork') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>