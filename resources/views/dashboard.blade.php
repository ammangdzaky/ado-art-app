<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Member Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-indigo-600 rounded-lg shadow-xl p-6 mb-8 text-white flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold">Hello, {{ Auth::user()->name }}! 👋</h3>
                    <p class="mt-1 text-indigo-100">Ready to showcase your creativity today?</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('artworks.create') }}" class="px-6 py-3 bg-white text-indigo-600 font-bold rounded-lg shadow hover:bg-gray-100 transition">
                        + Upload New Art
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <a href="{{ route('artworks.index', ['search' => Auth::user()->name]) }}" class="group block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition border border-transparent hover:border-indigo-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full text-blue-600 dark:text-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->artworks->count() }}</span>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-indigo-500 transition">My Artworks</h4>
                        <p class="text-sm text-gray-500 mt-1">Manage your portfolio</p>
                    </div>
                </a>

                <a href="{{ route('collections.index') }}" class="group block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition border border-transparent hover:border-pink-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-pink-100 dark:bg-pink-900 rounded-full text-pink-600 dark:text-pink-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->collections->count() }}</span>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-pink-500 transition">Moodboards</h4>
                        <p class="text-sm text-gray-500 mt-1">Your saved inspirations</p>
                    </div>
                </a>

                <a href="{{ route('challenges.mine') }}" class="group block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition border border-transparent hover:border-yellow-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full text-yellow-600 dark:text-yellow-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-yellow-500 transition">My Submissions</h4>
                        <p class="text-sm text-gray-500 mt-1">Track your contest entries</p>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="group block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition border border-transparent hover:border-green-500">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full text-green-600 dark:text-green-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-green-500 transition">Edit Profile</h4>
                        <p class="text-sm text-gray-500 mt-1">Update bio & avatar</p>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>