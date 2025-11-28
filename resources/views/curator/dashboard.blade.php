<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Curator Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Welcome back, {{ Auth::user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg border dark:border-gray-600">
                            <h4 class="font-bold text-xl mb-2">Manage Challenges</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">Create new events, validate submissions, and select winners.</p>
                            <a href="{{ route('curator.challenges.index') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Go to Challenges</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>