<x-guest-layout>
    <div class="flex flex-col items-center justify-center text-center">
        
        {{-- 1. ANIMATED ICON --}}
        <div class="relative mb-8">
            {{-- Pulse Effect --}}
            <div class="absolute inset-0 bg-indigo-500/30 rounded-full animate-ping opacity-75"></div>
            
            <div class="relative w-24 h-24 bg-[#1a1a1a] rounded-full border-2 border-indigo-500/50 flex items-center justify-center shadow-xl shadow-indigo-500/20">
                {{-- Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                
                {{-- Badge --}}
                <div class="absolute -bottom-1 -right-1 bg-yellow-500 text-black text-[10px] font-black px-2 py-0.5 rounded-full border-4 border-[#0b0b0b]">
                    WAITING
                </div>
            </div>
        </div>

        {{-- 2. HEADING & MESSAGE --}}
        <h2 class="text-3xl font-black text-white tracking-tight mb-3">
            Account Under Review
        </h2>
        
        <div class="space-y-4 text-gray-400 text-sm leading-relaxed max-w-sm mx-auto mb-8">
            <p>
                Hello! Thank you for signing up as a <span class="text-indigo-400 font-bold">Curator</span> on AdoArt.
            </p>
            <p>
                Your account is currently queued for verification by our Admins to ensure community quality.
            </p>
            <div class="bg-[#1a1a1a] border border-gray-800 p-3 rounded-lg text-xs text-gray-500 flex items-start gap-2 text-left">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                <span>
                    This process usually takes up to 24 hours. Please check back later.
                </span>
            </div>
        </div>

        {{-- 3. LOGOUT BUTTON --}}
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full py-3 rounded-xl border border-gray-700 text-gray-300 font-bold text-sm hover:bg-gray-800 hover:text-white hover:border-gray-600 transition flex items-center justify-center gap-2 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Sign Out & Check Later
            </button>
        </form>

    </div>
</x-guest-layout>