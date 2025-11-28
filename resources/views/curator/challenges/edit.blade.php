<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Challenge</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('curator.challenges.update', $challenge) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Banner</label>
                            <img src="{{ asset('storage/' . $challenge->banner_path) }}" class="h-32 rounded mt-2 object-cover">
                        </div>

                        <div class="mb-4">
                            <x-input-label for="banner" :value="__('Change Banner (Optional)')" />
                            <input type="file" name="banner" class="block w-full mt-1 text-sm bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                        </div>

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title', $challenge->title) }}" required />
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="start_date" :value="__('Start Date')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="datetime-local" name="start_date" value="{{ $challenge->start_date->format('Y-m-d\TH:i') }}" required />
                            </div>
                            <div>
                                <x-input-label for="end_date" :value="__('Deadline')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="datetime-local" name="end_date" value="{{ $challenge->end_date->format('Y-m-d\TH:i') }}" required />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="prize" :value="__('Prize')" />
                            <x-text-input id="prize" class="block mt-1 w-full" type="text" name="prize" value="{{ old('prize', $challenge->prize) }}" required />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea name="description" rows="4" class="block w-full mt-1 rounded-md bg-gray-50 border-gray-300 dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500" required>{{ old('description', $challenge->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="rules" :value="__('Rules')" />
                            <textarea name="rules" rows="4" class="block w-full mt-1 rounded-md bg-gray-50 border-gray-300 dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500" required>{{ old('rules', $challenge->rules) }}</textarea>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('curator.challenges.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</a>
                            <x-primary-button>{{ __('Update Challenge') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>