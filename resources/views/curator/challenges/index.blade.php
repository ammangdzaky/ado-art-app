<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manage Challenges') }}
            </h2>
            <a href="{{ route('curator.challenges.create') }}" class="px-4 py-2 bg-indigo-600 rounded-md text-white text-sm font-bold hover:bg-indigo-700">
                Create New Challenge
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                        <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Participants</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deadline</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($challenges as $challenge)
                            <tr>
                                <td class="px-6 py-4">{{ $challenge->title }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $challenge->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($challenge->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $challenge->submissions->count() }} Submissions</td>
                                <td class="px-6 py-4">{{ $challenge->end_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('challenges.show', $challenge) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    <a href="{{ route('curator.challenges.edit', $challenge) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('curator.challenges.destroy', $challenge) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Delete this challenge?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>