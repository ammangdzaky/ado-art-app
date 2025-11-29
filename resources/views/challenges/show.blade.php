<x-app-layout>
    {{-- 1. HERO BANNER SECTION --}}
    <div class="relative h-[500px] w-full bg-[#0b0b0b] group">
        <div class="absolute inset-0 overflow-hidden">
            <img src="{{ asset('storage/' . $challenge->banner_path) }}" class="w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-[2000ms]">
            <div class="absolute inset-0 bg-gradient-to-t from-[#0b0b0b] via-[#0b0b0b]/80 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#0b0b0b]/90 via-transparent to-transparent"></div>
        </div>

        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pb-16">
                <div class="flex items-center gap-4 mb-6">
                    @if($challenge->status === 'open')
                        <span class="px-4 py-1.5 bg-green-500/20 text-green-400 border border-green-500/50 text-xs font-bold tracking-widest uppercase rounded-full flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Active Challenge
                        </span>
                    @else
                        <span class="px-4 py-1.5 bg-red-500/20 text-red-400 border border-red-500/50 text-xs font-bold tracking-widest uppercase rounded-full">
                            Challenge Closed
                        </span>
                    @endif
                    <span class="px-4 py-1.5 bg-yellow-500/20 text-yellow-400 border border-yellow-500/50 text-xs font-bold tracking-widest uppercase rounded-full flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                        Prize Pool: {{ $challenge->prize }}
                    </span>
                </div>

                <h1 class="text-5xl md:text-7xl font-black text-white mb-4 tracking-tight drop-shadow-2xl max-w-4xl leading-tight">
                    {{ $challenge->title }}
                </h1>

                <div class="flex flex-wrap items-end gap-8 text-gray-300">
                    <div>
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Time Remaining</div>
                        @if($challenge->status === 'open')
                            <div class="countdown-timer font-mono text-2xl text-white font-bold tracking-widest flex items-baseline gap-2" data-deadline="{{ $challenge->end_date->timestamp * 1000 }}">
                                <span>00</span><span class="text-sm text-gray-500">D</span>
                                <span>00</span><span class="text-sm text-gray-500">H</span>
                                <span>00</span><span class="text-sm text-gray-500">M</span>
                                <span class="text-indigo-500">00</span><span class="text-sm text-gray-500">S</span>
                            </div>
                        @else
                            <div class="text-2xl text-red-500 font-bold tracking-widest">ENDED</div>
                        @endif
                    </div>
                    
                    {{-- Info Host --}}
                    <div class="h-10 w-px bg-gray-700 hidden md:block"></div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('artist.show', $challenge->curator) }}" class="w-10 h-10 rounded-full overflow-hidden border border-gray-500 hover:border-white transition">
                            @if($challenge->curator->avatar)
                                <img src="{{ asset('storage/' . $challenge->curator->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-white font-bold">{{ substr($challenge->curator->name, 0, 1) }}</div>
                            @endif
                        </a>
                        <div>
                            <div class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Hosted By</div>
                            <a href="{{ route('artist.show', $challenge->curator) }}" class="text-white font-bold hover:text-indigo-400 transition">{{ $challenge->curator->name }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-[#0b0b0b] min-h-screen pb-20 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
            
            {{-- 2. WINNERS SECTION --}}
            @if($winners->count() > 0)
            <div class="mb-16">
                <div class="flex items-center gap-4 mb-8 justify-center">
                    <div class="h-px bg-gray-800 w-20"></div>
                    <h2 class="text-2xl font-black text-white uppercase tracking-widest">Challenge Winners</h2>
                    <div class="h-px bg-gray-800 w-20"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                    @foreach($winners as $winner)
                        <div class="relative group {{ $winner->rank == '1' ? 'order-first md:order-2 -translate-y-4' : ($winner->rank == '2' ? 'order-last md:order-1' : 'order-last md:order-3') }}">
                            <a href="{{ route('artworks.show', $winner->artwork) }}" class="block bg-[#1e1e1e] rounded-2xl overflow-hidden shadow-2xl border-2 transition transform hover:scale-105 {{ $winner->rank == '1' ? 'border-yellow-500 shadow-yellow-500/20' : ($winner->rank == '2' ? 'border-gray-400' : 'border-orange-700') }}">
                                <div class="relative h-64 {{ $winner->rank == '1' ? 'md:h-80' : 'md:h-64' }}">
                                    <img src="{{ asset('storage/' . $winner->artwork->image_path) }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-4 text-center">
                                        <div class="inline-block px-3 py-1 rounded-full text-xs font-bold mb-2 text-black {{ $winner->rank == '1' ? 'bg-yellow-500' : ($winner->rank == '2' ? 'bg-gray-300' : 'bg-orange-600 text-white') }}">
                                            {{ $winner->rank == '1' ? '1ST PLACE' : ($winner->rank == '2' ? '2ND PLACE' : '3RD PLACE') }}
                                        </div>
                                        <h3 class="font-bold text-white truncate">{{ $winner->artwork->title }}</h3>
                                        <p class="text-xs text-gray-400">by {{ $winner->artwork->user->name }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- 
                GRID UTAMA (LEFT: INFO/CONTROLS, RIGHT: GALLERY)
                PERBAIKAN: Menambahkan data 'titles' untuk lookup nama karya 
            --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" 
                 x-data="{ 
                    w1: null, 
                    w2: null, 
                    w3: null,
                    titles: {
                        @foreach($submissions as $s)
                            {{ $s->id }}: '{{ addslashes(Str::limit($s->artwork->title, 20)) }} by {{ addslashes(Str::limit($s->artwork->user->name, 15)) }}',
                        @endforeach
                    }
                 }">
                
                {{-- KOLOM KIRI --}}
                <div class="space-y-8">
                    <div class="bg-[#1e1e1e] p-6 rounded-xl shadow-lg border border-gray-800 sticky top-24">
                        
                        {{-- Brief & Rules --}}
                        <h3 class="font-bold text-xl text-white mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Brief & Rules
                        </h3>
                        <div class="prose prose-invert prose-sm text-gray-400 mb-6">
                            <p class="whitespace-pre-line">{{ $challenge->description }}</p>
                        </div>
                        <div class="bg-[#121212] p-4 rounded-lg border border-gray-700 mb-6">
                            <h4 class="font-bold text-gray-300 text-sm mb-2 uppercase tracking-wide">Rules</h4>
                            <p class="whitespace-pre-line text-xs text-gray-500">{{ $challenge->rules }}</p>
                        </div>

                        {{-- Submit Button (Member) --}}
                        @if(Auth::check() && Auth::user()->role === 'member' && $challenge->status === 'open')
                            <button onclick="document.getElementById('submitModal').classList.remove('hidden')" class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-lg transition shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                                Submit Your Work
                            </button>
                            <p class="text-xs text-center mt-3 text-gray-500">Select from your portfolio</p>
                        @elseif(Auth::check() && $challenge->status === 'closed')
                            <div class="w-full py-3 bg-gray-800 text-gray-500 font-bold rounded-lg text-center border border-gray-700 cursor-not-allowed">Submissions Closed</div>
                        @elseif(!Auth::check())
                            <a href="{{ route('login') }}" class="block w-full py-3 bg-gray-700 hover:bg-gray-600 text-white text-center font-bold rounded-lg transition">Login to Join</a>
                        @endif

                        {{-- Curator Controls (PERBAIKAN DISPLAY TEXT) --}}
                        @if(Auth::id() === $challenge->curator_id)
                        <div class="mt-8 pt-8 border-t border-gray-700">
                            <h3 class="font-bold text-sm text-indigo-400 uppercase tracking-wider mb-4">Curator Controls</h3>
                            
                            @if($challenge->status === 'open' && now() > $challenge->end_date)
                                <form action="{{ route('curator.challenges.winners', $challenge) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="winner_1" :value="w1">
                                    <input type="hidden" name="winner_2" :value="w2">
                                    <input type="hidden" name="winner_3" :value="w3">

                                    <div class="space-y-3 mb-6">
                                        {{-- Slot 1 --}}
                                        <div class="bg-[#121212] p-3 rounded border border-gray-700 flex items-center justify-between transition-colors duration-300" :class="{'border-yellow-500 bg-yellow-900/10': w1}">
                                            <div class="flex items-center gap-3 overflow-hidden">
                                                <div class="w-8 h-8 flex-shrink-0 rounded-full bg-yellow-500 flex items-center justify-center text-black font-bold text-xs">1</div>
                                                <span class="text-sm text-gray-400 truncate" x-text="w1 ? titles[w1] : 'Select 1st Place below'"></span>
                                            </div>
                                            <button type="button" x-show="w1" @click="w1 = null" class="text-red-500 hover:text-white text-xs ml-2">Clear</button>
                                        </div>
                                        {{-- Slot 2 --}}
                                        <div class="bg-[#121212] p-3 rounded border border-gray-700 flex items-center justify-between transition-colors duration-300" :class="{'border-gray-400 bg-gray-800/50': w2}">
                                            <div class="flex items-center gap-3 overflow-hidden">
                                                <div class="w-8 h-8 flex-shrink-0 rounded-full bg-gray-400 flex items-center justify-center text-black font-bold text-xs">2</div>
                                                <span class="text-sm text-gray-400 truncate" x-text="w2 ? titles[w2] : 'Select 2nd Place below'"></span>
                                            </div>
                                            <button type="button" x-show="w2" @click="w2 = null" class="text-red-500 hover:text-white text-xs ml-2">Clear</button>
                                        </div>
                                        {{-- Slot 3 --}}
                                        <div class="bg-[#121212] p-3 rounded border border-gray-700 flex items-center justify-between transition-colors duration-300" :class="{'border-orange-600 bg-orange-900/10': w3}">
                                            <div class="flex items-center gap-3 overflow-hidden">
                                                <div class="w-8 h-8 flex-shrink-0 rounded-full bg-orange-600 flex items-center justify-center text-white font-bold text-xs">3</div>
                                                <span class="text-sm text-gray-400 truncate" x-text="w3 ? titles[w3] : 'Select 3rd Place below'"></span>
                                            </div>
                                            <button type="button" x-show="w3" @click="w3 = null" class="text-red-500 hover:text-white text-xs ml-2">Clear</button>
                                        </div>
                                    </div>

                                    <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-500 text-white rounded font-bold shadow-lg shadow-green-500/20 disabled:opacity-50 disabled:cursor-not-allowed" :disabled="!w1">
                                        Confirm Winners
                                    </button>
                                </form>
                            @elseif($challenge->status === 'closed')
                                <p class="text-green-500 text-sm font-bold flex items-center gap-2"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Winners Announced</p>
                            @else
                                <p class="text-xs text-gray-500 bg-gray-800 p-3 rounded">Winner selection available after deadline.</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                {{-- KOLOM KANAN: Gallery Grid --}}
                <div class="lg:col-span-2">
                    <div class="flex justify-between items-end mb-6 border-b border-gray-800 pb-4">
                        <h3 class="font-bold text-2xl text-white">Submissions</h3>
                        <span class="bg-[#1e1e1e] px-3 py-1 rounded-full text-sm text-gray-400 font-bold">{{ $submissions->count() }} Entries</span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($submissions as $sub)
                        <div class="relative group bg-[#1e1e1e] rounded-xl overflow-hidden border border-gray-800">
                            <a href="{{ route('artworks.show', $sub->artwork) }}" class="block aspect-square">
                                <img src="{{ asset('storage/' . $sub->artwork->image_path) }}" class="w-full h-full object-cover">
                            </a>
                            
                            {{-- SELECTION OVERLAY (FIXED BUTTONS) --}}
                            @if(Auth::id() === $challenge->curator_id && $challenge->status === 'open' && now() > $challenge->end_date)
                                <div class="absolute inset-x-0 bottom-0 bg-black/80 p-2 flex justify-center gap-2 transition duration-200 z-20 opacity-100 lg:opacity-0 lg:group-hover:opacity-100">
                                    
                                    {{-- Tombol 1 --}}
                                    <button type="button" @click="w1 = (w1 == {{ $sub->id }} ? null : {{ $sub->id }}); if(w2 == {{ $sub->id }}) w2 = null; if(w3 == {{ $sub->id }}) w3 = null;" 
                                            :class="w1 == {{ $sub->id }} ? 'bg-yellow-500 text-black scale-110 ring-2 ring-white' : 'bg-gray-700 text-gray-300 hover:bg-yellow-500 hover:text-black'"
                                            class="w-8 h-8 rounded-full font-bold text-sm border border-gray-600 flex items-center justify-center shadow-lg transition-all">1</button>
                                    
                                    {{-- Tombol 2 --}}
                                    <button type="button" @click="w2 = (w2 == {{ $sub->id }} ? null : {{ $sub->id }}); if(w1 == {{ $sub->id }}) w1 = null; if(w3 == {{ $sub->id }}) w3 = null;" 
                                            :class="w2 == {{ $sub->id }} ? 'bg-gray-300 text-black scale-110 ring-2 ring-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-300 hover:text-black'"
                                            class="w-8 h-8 rounded-full font-bold text-sm border border-gray-600 flex items-center justify-center shadow-lg transition-all">2</button>
                                    
                                    {{-- Tombol 3 --}}
                                    <button type="button" @click="w3 = (w3 == {{ $sub->id }} ? null : {{ $sub->id }}); if(w1 == {{ $sub->id }}) w1 = null; if(w2 == {{ $sub->id }}) w2 = null;" 
                                            :class="w3 == {{ $sub->id }} ? 'bg-orange-600 text-white scale-110 ring-2 ring-white' : 'bg-gray-700 text-gray-300 hover:bg-orange-600 hover:text-white'"
                                            class="w-8 h-8 rounded-full font-bold text-sm border border-gray-600 flex items-center justify-center shadow-lg transition-all">3</button>
                                </div>
                                
                                {{-- Indikator (Badge) --}}
                                <div class="absolute top-2 right-2 z-10 pointer-events-none">
                                    <template x-if="w1 == {{ $sub->id }}"><span class="bg-yellow-500 text-black text-[10px] font-black px-2 py-1 rounded shadow-lg border border-yellow-300">1ST</span></template>
                                    <template x-if="w2 == {{ $sub->id }}"><span class="bg-gray-300 text-black text-[10px] font-black px-2 py-1 rounded shadow-lg border border-white">2ND</span></template>
                                    <template x-if="w3 == {{ $sub->id }}"><span class="bg-orange-600 text-white text-[10px] font-black px-2 py-1 rounded shadow-lg border border-orange-400">3RD</span></template>
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL SUBMIT (TETAP SAMA) --}}
    @if(Auth::check() && Auth::user()->role === 'member')
    <div id="submitModal" class="hidden fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-[#1e1e1e] w-full max-w-3xl rounded-2xl p-8 shadow-2xl border border-gray-700 relative flex flex-col max-h-[90vh]">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-black text-white">Select Artwork</h3>
                <button onclick="document.getElementById('submitModal').classList.add('hidden')" class="text-gray-400 hover:text-white transition text-2xl">&times;</button>
            </div>
            @if($myArtworks->isEmpty())
                <div class="text-center py-12 flex-1 flex flex-col justify-center items-center">
                    <p class="text-gray-400 mb-4">Your portfolio is empty.</p>
                    <a href="{{ route('artworks.create') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-500">Upload Artwork First</a>
                </div>
            @else
                <form action="{{ route('challenges.submit', $challenge) }}" method="POST" class="flex flex-col flex-1 min-h-0">
                    @csrf
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-4 overflow-y-auto pr-2 mb-6 custom-scrollbar flex-1">
                        @foreach($myArtworks as $art)
                        <label class="cursor-pointer relative group aspect-square">
                            <input type="radio" name="artwork_id" value="{{ $art->id }}" class="peer sr-only" required>
                            <div class="w-full h-full rounded-lg overflow-hidden border-2 border-transparent peer-checked:border-indigo-500 relative">
                                <img src="{{ asset('storage/' . $art->image_path) }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 peer-checked:opacity-100 transition">
                                <div class="absolute inset-0 bg-indigo-500/20 hidden peer-checked:block"></div>
                                <div class="absolute top-2 right-2 w-6 h-6 bg-indigo-500 rounded-full flex items-center justify-center text-white text-xs opacity-0 peer-checked:opacity-100 transition transform scale-0 peer-checked:scale-100">✓</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <div class="pt-4 border-t border-gray-700 flex justify-end">
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-500 transition shadow-lg shadow-indigo-500/20">Confirm Submission</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
    @endif

    {{-- JS Countdown (TETAP SAMA) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timer = document.querySelector('.countdown-timer');
            if(timer) {
                const deadline = parseInt(timer.getAttribute('data-deadline'));
                const updateTimer = () => {
                    const now = new Date().getTime();
                    const dist = deadline - now;
                    if(dist < 0) { timer.innerHTML = "EXPIRED"; return; }
                    const d = Math.floor(dist / (1000 * 60 * 60 * 24));
                    const h = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const m = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((dist % (1000 * 60)) / 1000);
                    const fh = h < 10 ? "0" + h : h; const fm = m < 10 ? "0" + m : m; const fs = s < 10 ? "0" + s : s;
                    timer.innerHTML = `<span class="text-white mr-3">${d} Days</span><span class="text-white tracking-widest">${fh}:${fm}:${fs}</span>`;
                };
                updateTimer(); setInterval(updateTimer, 1000);
            }
        });
    </script>
</x-app-layout>