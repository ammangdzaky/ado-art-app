<x-app-layout>
    <div class="bg-black min-h-screen text-white py-8 md:py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 border-b border-gray-800 pb-6 gap-4">
                <h1 class="text-3xl md:text-4xl font-black tracking-tight text-white uppercase">
                    Challenges
                </h1>
                
                <a href="{{ route('artworks.index') }}" class="text-gray-400 hover:text-white text-sm font-bold flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Back to Gallery
                </a>
            </div>

            {{-- Challenge List --}}
            <div class="space-y-8">
                @forelse($challenges as $challenge)
                <div class="group relative bg-[#121212] rounded-xl overflow-hidden border border-gray-800 hover:border-gray-600 transition duration-300 shadow-2xl">
                    
                    {{-- 1. BAGIAN GAMBAR --}}
                    <a href="{{ route('challenges.show', $challenge) }}" class="block relative h-64 md:h-80 overflow-hidden">
                        <img src="{{ asset('storage/' . $challenge->banner_path) }}" alt="{{ $challenge->title }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90"></div>

                        {{-- Badge Status --}}
                        <div class="absolute top-4 left-4">
                            @if($challenge->status === 'open')
                                <span class="text-green-400 font-bold tracking-widest text-[10px] uppercase flex items-center gap-2 bg-black/60 backdrop-blur-md px-3 py-1 rounded-full border border-green-500/30 shadow-lg">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> OPEN
                                </span>
                            @else
                                <span class="text-red-400 font-bold tracking-widest text-[10px] uppercase flex items-center gap-2 bg-black/60 backdrop-blur-md px-3 py-1 rounded-full border border-red-500/30 shadow-lg">
                                    CLOSED
                                </span>
                            @endif
                        </div>

                        {{-- Judul & Info --}}
                        <div class="absolute bottom-4 left-4 right-4 md:bottom-6 md:left-6 md:right-6">
                            <h2 class="text-3xl md:text-5xl font-black text-white tracking-tighter mb-2 drop-shadow-lg group-hover:text-indigo-400 transition">
                                {{ $challenge->title }}
                            </h2>
                            
                            <div class="flex flex-wrap items-center gap-4 text-xs font-medium text-gray-300">
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Start: <span class="text-white">{{ $challenge->start_date->format('M d') }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    <span class="text-white">{{ $challenge->submissions->count() }}</span> Entries
                                </div>
                            </div>
                        </div>
                    </a>

                    {{-- 2. BAGIAN FOOTER (UPDATED: HOST CLICKABLE & BIGGER) --}}
                    <div class="px-4 py-3 bg-[#181818] flex flex-col md:flex-row justify-between items-center border-t border-gray-800 gap-3 md:gap-0">
                        
                        {{-- Host Info (LINK & BIGGER) --}}
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">HOSTED BY</span>
                            
                            {{-- Link ke Profil Curator --}}
                            <a href="{{ route('artist.show', $challenge->curator) }}" class="flex items-center gap-2 group">
                                {{-- Avatar Sedikit Lebih Besar (w-8 h-8) --}}
                                <div class="w-8 h-8 rounded-full bg-gray-700 overflow-hidden border border-gray-600  transition">
                                    @if($challenge->curator->avatar)
                                        <img src="{{ asset('storage/' . $challenge->curator->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs font-bold text-white">{{ substr($challenge->curator->name, 0, 1) }}</div>
                                    @endif
                                </div>
                                {{-- Nama Sedikit Lebih Besar (text-sm) --}}
                                <span class="text-sm font-bold text-white  transition">
                                    {{ $challenge->curator->name }}
                                </span>
                            </a>
                        </div>

                        {{-- Countdown Timer --}}
                        @if($challenge->status === 'open')
                        <div class="w-full md:w-auto flex justify-between md:justify-end items-center gap-3">
                            {{-- Menggunakan Timestamp --}}
                            <div class="countdown-timer font-mono text-sm md:text-base font-bold text-white tabular-nums flex items-center justify-end gap-2" 
                                 data-deadline="{{ $challenge->end_date->timestamp * 1000 }}">
                                {{-- Placeholder --}}
                                <span>Loading...</span>
                            </div>
                        </div>
                        @else
                        <div class="w-full md:w-auto text-right">
                            <span class="text-xs font-bold text-red-500 bg-red-500/10 px-2 py-1 rounded">CHALLENGE ENDED</span>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="py-20 text-center border border-dashed border-gray-700 rounded-xl">
                    <p class="text-gray-500 text-xl font-light">No active challenges.</p>
                </div>
                @endforelse

                <div class="mt-8">
                    {{ $challenges->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT UNTUK COUNTDOWN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timers = document.querySelectorAll('.countdown-timer');

            timers.forEach(timer => {
                const deadline = parseInt(timer.getAttribute('data-deadline'));

                const updateTimer = () => {
                    const now = new Date().getTime();
                    const distance = deadline - now;

                    if (distance < 0) {
                        timer.innerHTML = "<span class='text-red-500'>EXPIRED</span>";
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    const fHours = hours < 10 ? "0" + hours : hours;
                    const fMinutes = minutes < 10 ? "0" + minutes : minutes;
                    const fSeconds = seconds < 10 ? "0" + seconds : seconds;

                    // STYLING: Rapat & Compactends
                    timer.innerHTML = `
                        <span class="text-red-500 text-xs text-gray-400 mr-1 font-sans">ENDS IN</span>
                        <span class="text-white">${days} Days</span>
                        <span class="text-indigo-400 ml-1">${fHours}:${fMinutes}:${fSeconds}</span>
                    `;
                };

                updateTimer();
                setInterval(updateTimer, 1000);
            });
        });
    </script>
</x-app-layout>