<x-app-layout>
    <div class="min-h-screen bg-[#0b0b0b] text-gray-300 py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">Moderation Queue</h1>
                    <p class="text-gray-500 mt-1">Review reported content and take action.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-white flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Back to Dashboard
                </a>
            </div>

            <div class="space-y-6">
                @forelse($reports as $report)
                <div class="bg-[#1e1e1e] rounded-2xl border border-red-900/30 overflow-hidden shadow-2xl relative group hover:border-red-600/50 transition duration-300">
                    {{-- Alert Stripe --}}
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-600"></div>
                    
                    <div class="p-6 flex flex-col md:flex-row gap-6">
                        {{-- Image Preview --}}
                        <div class="w-full md:w-48 h-48 shrink-0 bg-black rounded-xl overflow-hidden border border-gray-800">
                            <a href="{{ route('artworks.show', $report->artwork) }}" target="_blank" class="block h-full w-full group/img relative">
                                <img src="{{ asset('storage/' . $report->artwork->image_path) }}" class="w-full h-full object-cover opacity-80 group-hover/img:opacity-100 transition">
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition bg-black/50 font-bold text-white text-xs uppercase tracking-widest">View Art</div>
                            </a>
                        </div>
                        
                        {{-- Report Details --}}
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <div class="text-red-500 text-xs font-bold uppercase tracking-widest mb-1">Report Reason</div>
                                    <h3 class="text-xl font-bold text-white">{{ $report->reason }}</h3>
                                </div>
                                <span class="px-3 py-1 bg-gray-800 text-gray-400 text-xs font-bold rounded-lg border border-gray-700">{{ $report->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <div class="bg-[#121212] p-4 rounded-xl border border-gray-800 mb-6">
                                <p class="text-sm text-gray-400 mb-1">Reported By: <span class="text-white font-bold">{{ $report->reporter->name }}</span></p>
                                <p class="text-sm text-gray-400">Target Artwork: <span class="text-white font-bold">{{ $report->artwork->title }}</span> (by {{ $report->artwork->user->name }})</p>
                            </div>
                            
                            {{-- Actions --}}
                            <div class="flex gap-4">
                                <form action="{{ route('admin.reports.handle', $report) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="action" value="dismiss">
                                    <button class="px-6 py-2.5 bg-[#2a2a2a] hover:bg-gray-700 text-gray-300 hover:text-white rounded-xl text-sm font-bold border border-gray-700 transition">
                                        Dismiss (Ignore)
                                    </button>
                                </form>

                                <form action="{{ route('admin.reports.handle', $report) }}" method="POST" onsubmit="return confirm('Are you sure you want to DELETE this artwork? This cannot be undone.')">
                                    @csrf
                                    <input type="hidden" name="action" value="takedown">
                                    <button class="px-6 py-2.5 bg-red-600 hover:bg-red-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-red-600/20 transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        Take Down Content
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-24 border-2 border-dashed border-gray-800 rounded-3xl bg-[#121212]">
                    <div class="bg-green-900/20 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">All Clear!</h3>
                    <p class="text-gray-500">No pending reports to review at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>