<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Active Challenges') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($challenges as $challenge)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col h-full border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition duration-300">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $challenge->banner_path) }}" class="w-full h-full object-cover transition duration-500 hover:scale-105">
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $challenge->status === 'open' ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                                {{ strtoupper($challenge->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-1">
                                <a href="{{ route('challenges.show', $challenge) }}" class="hover:text-indigo-500">
                                    {{ $challenge->title }}
                                </a>
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ $challenge->description }}
                            </p>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-500">Prize:</span>
                                <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $challenge->prize }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Deadline:</span>
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $challenge->end_date->format('d M Y') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('challenges.show', $challenge) }}" class="mt-6 block w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-center font-bold rounded transition">
                            View Challenge
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No challenges available right now.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $challenges->links() }}
            </div>
        </div>
    </div>
</x-app-layout>