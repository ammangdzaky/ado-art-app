<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My Challenge History</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Challenge</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted Artwork</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Result</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($submissions as $sub)
                            <tr>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $sub->challenge->title }}</td>
                                <td class="px-6 py-4 flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $sub->artwork->image_path) }}" class="w-10 h-10 rounded object-cover">
                                    <span class="text-sm text-gray-600 dark:text-gray-300">{{ $sub->artwork->title }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($sub->rank)
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full">🏆 Winner #{{ $sub->rank }}</span>
                                    @elseif($sub->challenge->status === 'closed')
                                        <span class="text-gray-500 text-xs">Not Selected</span>
                                    @else
                                        <span class="text-blue-500 text-xs">Judging Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('challenges.show', $sub->challenge) }}" class="text-indigo-500 hover:underline text-sm">View Challenge</a>
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