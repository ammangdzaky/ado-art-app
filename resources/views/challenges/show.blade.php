<x-app-layout>
    
    <div class="relative h-96 w-full">
        <img src="{{ asset('storage/' . $challenge->banner_path) }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent flex items-end">
            <div class="max-w-7xl mx-auto w-full px-6 pb-10">
                <span class="px-3 py-1 bg-indigo-600 text-white text-xs font-bold rounded-full mb-4 inline-block">
                    {{ $challenge->status === 'open' ? 'ACTIVE CHALLENGE' : 'CHALLENGE ENDED' }}
                </span>
                <h1 class="text-4xl md:text-6xl font-black text-white mb-2">{{ $challenge->title }}</h1>
                <p class="text-gray-300 text-lg max-w-2xl">{{ Str::limit($challenge->description, 150) }}</p>
                <div class="mt-6 flex gap-4 text-white text-sm font-semibold">
                    <div>🏆 Prize: <span class="text-yellow-400">{{ $challenge->prize }}</span></div>
                    <div>⏳ Deadline: <span class="text-indigo-300">{{ $challenge->end_date->format('d M Y, H:i') }}</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($winners->count() > 0)
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-white mb-8">🏆 Hall of Fame</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-end">
                    @foreach($winners as $winner)
                        <div class="relative group {{ $winner->rank == '1' ? 'order-first md:order-2 scale-110 z-10' : 'order-last md:order-1' }}">
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border-4 {{ $winner->rank == '1' ? 'border-yellow-400' : ($winner->rank == '2' ? 'border-gray-300' : 'border-amber-600') }}">
                                <img src="{{ asset('storage/' . $winner->artwork->image_path) }}" class="w-full h-64 object-cover">
                                <div class="p-4 text-center">
                                    <div class="font-bold text-2xl mb-1">
                                        {{ $winner->rank == '1' ? '🥇 1st' : ($winner->rank == '2' ? '🥈 2nd' : '🥉 3rd') }}
                                    </div>
                                    <h3 class="font-bold text-gray-900 dark:text-white truncate">{{ $winner->artwork->title }}</h3>
                                    <p class="text-sm text-gray-500">by {{ $winner->artwork->user->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                        <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-4">Brief & Rules</h3>
                        <div class="prose dark:prose-invert text-sm text-gray-600 dark:text-gray-300">
                            <p class="whitespace-pre-line">{{ $challenge->description }}</p>
                            <hr class="my-4 border-gray-700">
                            <h4 class="font-bold">Rules:</h4>
                            <p class="whitespace-pre-line">{{ $challenge->rules }}</p>
                        </div>

                        @if(Auth::check() && Auth::user()->role === 'member' && $challenge->status === 'open')
                            <div class="mt-6">
                                <button onclick="document.getElementById('submitModal').classList.remove('hidden')" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition">
                                    Submit Your Work
                                </button>
                                <p class="text-xs text-center mt-2 text-gray-500">Select from your existing portfolio</p>
                            </div>
                        @elseif(Auth::check() && $challenge->status === 'closed')
                            <div class="mt-6 p-3 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-center rounded-lg font-bold">
                                Submission Closed
                            </div>
                        @elseif(!Auth::check())
                            <div class="mt-6">
                                <a href="{{ route('login') }}" class="block w-full py-3 bg-gray-700 text-white text-center font-bold rounded-lg">Login to Join</a>
                            </div>
                        @endif
                    </div>

                    @if(Auth::id() === $challenge->curator_id)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-indigo-500">
                        <h3 class="font-bold text-lg text-indigo-400 mb-4">Curator Tools</h3>
                        @if($challenge->status === 'open' && now() > $challenge->end_date)
                            <form action="{{ route('curator.challenges.winners', $challenge) }}" method="POST">
                                @csrf
                                <div class="space-y-3">
                                    <p class="text-sm text-gray-400">Select winners to close the challenge:</p>
                                    <select name="winner_1" class="w-full rounded bg-gray-900 text-white border-gray-700 text-sm">
                                        <option value="">Select 1st Place...</option>
                                        @foreach($submissions as $sub)
                                            <option value="{{ $sub->id }}">{{ $sub->artwork->title }} ({{ $sub->artwork->user->name }})</option>
                                        @endforeach
                                    </select>
                                    <select name="winner_2" class="w-full rounded bg-gray-900 text-white border-gray-700 text-sm">
                                        <option value="">Select 2nd Place...</option>
                                        @foreach($submissions as $sub)
                                            <option value="{{ $sub->id }}">{{ $sub->artwork->title }} ({{ $sub->artwork->user->name }})</option>
                                        @endforeach
                                    </select>
                                    <select name="winner_3" class="w-full rounded bg-gray-900 text-white border-gray-700 text-sm">
                                        <option value="">Select 3rd Place...</option>
                                        @foreach($submissions as $sub)
                                            <option value="{{ $sub->id }}">{{ $sub->artwork->title }} ({{ $sub->artwork->user->name }})</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-700 text-white rounded font-bold mt-2">Announce Winners</button>
                                </div>
                            </form>
                        @elseif($challenge->status === 'closed')
                            <p class="text-green-500 font-bold text-center">Winners Announced!</p>
                        @else
                            <p class="text-sm text-gray-500">You can select winners after the deadline ({{ $challenge->end_date->format('d M') }}).</p>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="lg:col-span-2">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-4">Submissions ({{ $submissions->count() + $winners->count() }})</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($submissions as $sub)
                        <a href="{{ route('artworks.show', $sub->artwork) }}" class="block aspect-square rounded-lg overflow-hidden relative group">
                            <img src="{{ asset('storage/' . $sub->artwork->image_path) }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <span class="text-white text-xs font-bold">{{ $sub->artwork->user->name }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::check() && Auth::user()->role === 'member')
    <div id="submitModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 w-full max-w-2xl rounded-xl p-6 shadow-2xl relative">
            <button onclick="document.getElementById('submitModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-white">✕</button>
            
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Select Artwork to Submit</h3>
            
            @if($myArtworks->isEmpty())
                <p class="text-gray-400 text-center py-8">You have no artworks. <a href="{{ route('artworks.create') }}" class="text-indigo-400 underline">Upload first</a>.</p>
            @else
                <form action="{{ route('challenges.submit', $challenge) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-3 gap-4 max-h-96 overflow-y-auto mb-6">
                        @foreach($myArtworks as $art)
                        <label class="cursor-pointer relative group">
                            <input type="radio" name="artwork_id" value="{{ $art->id }}" class="peer sr-only" required>
                            <img src="{{ asset('storage/' . $art->image_path) }}" class="w-full aspect-square object-cover rounded-lg border-2 border-transparent peer-checked:border-indigo-500 peer-checked:opacity-100 opacity-60 hover:opacity-100 transition">
                            <div class="absolute bottom-1 left-1 bg-black/70 px-2 py-1 text-[10px] text-white rounded truncate max-w-full">{{ $art->title }}</div>
                            <div class="absolute inset-0 ring-2 ring-indigo-500 rounded-lg hidden peer-checked:block"></div>
                        </label>
                        @endforeach
                    </div>
                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700">Confirm Submission</button>
                </form>
            @endif
        </div>
    </div>
    @endif
</x-app-layout>