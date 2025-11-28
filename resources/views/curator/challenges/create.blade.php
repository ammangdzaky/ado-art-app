<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Challenge') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('curator.challenges.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <x-input-label for="banner" :value="__('Challenge Banner')" />
                            <input type="file" name="banner" class="block w-full mt-1 text-sm bg-gray-50 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600" required>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Challenge Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required />
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="start_date" :value="__('Start Date')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="datetime-local" name="start_date" required />
                            </div>
                            <div>
                                <x-input-label for="end_date" :value="__('End Date (Deadline)')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="datetime-local" name="end_date" required />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="prize" :value="__('Prize Pool')" />
                            <x-text-input id="prize" class="block mt-1 w-full" type="text" name="prize" placeholder="e.g. $500 + Graphics Tablet" required />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea name="description" rows="4" class="block w-full mt-1 rounded-md bg-gray-50 border-gray-300 dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500" required></textarea>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="rules" :value="__('Rules')" />
                            <textarea name="rules" rows="4" class="block w-full mt-1 rounded-md bg-gray-50 border-gray-300 dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500" placeholder="1. No AI Art..." required></textarea>
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>{{ __('Publish Challenge') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>