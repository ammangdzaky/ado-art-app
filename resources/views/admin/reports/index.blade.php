<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Content Moderation Queue</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($reports as $report)
                    <div class="mb-6 p-4 border rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="w-32 h-32 flex-shrink-0">
                                <a href="{{ route('artworks.show', $report->artwork) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $report->artwork->image_path) }}" class="w-full h-full object-cover rounded">
                                </a>
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="font-bold text-lg text-red-600">Reason: {{ $report->reason }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                    Reported by: <strong>{{ $report->reporter->name }}</strong><br>
                                    Artwork: {{ $report->artwork->title }} (by {{ $report->artwork->user->name }})
                                </p>
                                
                                <div class="mt-4 flex gap-4">
                                    <form action="{{ route('admin.reports.handle', $report) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="dismiss">
                                        <button class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">Dismiss Report</button>
                                    </form>

                                    <form action="{{ route('admin.reports.handle', $report) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this artwork? This cannot be undone.')">
                                        @csrf
                                        <input type="hidden" name="action" value="takedown">
                                        <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-bold">Take Down Content</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-10">
                        No pending reports. Great job!
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>