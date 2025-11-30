<x-app-layout>
    <div class="min-h-screen bg-[#0b0b0b] text-gray-300">
        
        {{-- 1. HEADER SECTION --}}
        <div class="bg-[#121212] border-b border-gray-800 pt-10 pb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-3xl font-black text-white tracking-tight">Admin Dashboard</h1>
                        <span class="px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-[10px] font-bold uppercase tracking-widest">
                            Superuser
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm">Overview of system performance and moderation tasks.</p>
                </div>
                
                {{-- Quick Date/Info (Opsional) --}}
                <div class="text-right hidden md:block">
                    <div class="text-white font-bold">{{ now()->format('l, d F Y') }}</div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            {{-- 2. STATS OVERVIEW (KOTAK KECIL DI ATAS) --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                {{-- Total Users --}}
                <div class="bg-[#1e1e1e] p-5 rounded-2xl border border-gray-800 flex flex-col justify-between shadow-lg">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Total Users</div>
                    <div class="flex items-end justify-between">
                        <span class="text-3xl font-black text-white">{{ $totalUsers }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                </div>

                {{-- Total Artworks --}}
                <div class="bg-[#1e1e1e] p-5 rounded-2xl border border-gray-800 flex flex-col justify-between shadow-lg">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Artworks</div>
                    <div class="flex items-end justify-between">
                        <span class="text-3xl font-black text-white">{{ $totalArtworks }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                </div>

                {{-- Pending Curators (Alert) --}}
                <div class="bg-[#1e1e1e] p-5 rounded-2xl border {{ $pendingCurators > 0 ? 'border-yellow-500/50' : 'border-gray-800' }} flex flex-col justify-between shadow-lg relative overflow-hidden">
                    @if($pendingCurators > 0) <div class="absolute top-0 right-0 w-3 h-3 bg-yellow-500 rounded-bl-lg"></div> @endif
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Pending Curators</div>
                    <div class="flex items-end justify-between">
                        <span class="text-3xl font-black {{ $pendingCurators > 0 ? 'text-yellow-400' : 'text-white' }}">{{ $pendingCurators }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ $pendingCurators > 0 ? 'text-yellow-400' : 'text-gray-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                </div>

                {{-- Pending Reports (Alert) --}}
                <div class="bg-[#1e1e1e] p-5 rounded-2xl border {{ $pendingReports > 0 ? 'border-red-500/50' : 'border-gray-800' }} flex flex-col justify-between shadow-lg relative overflow-hidden">
                    @if($pendingReports > 0) <div class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-bl-lg"></div> @endif
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">Reports</div>
                    <div class="flex items-end justify-between">
                        <span class="text-3xl font-black {{ $pendingReports > 0 ? 'text-red-500' : 'text-white' }}">{{ $pendingReports }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ $pendingReports > 0 ? 'text-red-500' : 'text-gray-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                </div>
            </div>

            {{-- 3. MAIN MODULES GRID --}}
            <h3 class="text-xl font-bold text-white mb-6">Management Modules</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- MODULE 1: USER MANAGEMENT --}}
                <a href="{{ route('admin.users') }}" class="group block bg-[#1e1e1e] rounded-2xl border border-gray-800 hover:border-blue-500 transition duration-300 overflow-hidden shadow-xl hover:shadow-blue-500/10">
                    <div class="h-2 w-full bg-blue-600"></div>
                    <div class="p-8">
                        <div class="w-14 h-14 rounded-xl bg-blue-900/30 flex items-center justify-center mb-6 text-blue-400 group-hover:scale-110 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <h4 class="text-2xl font-bold text-white mb-2 group-hover:text-blue-400 transition">User Management</h4>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">Manage Members & Curators. Approve pending curator requests and oversee user accounts.</p>
                        <div class="flex items-center text-blue-400 text-xs font-bold uppercase tracking-widest group-hover:gap-2 transition-all">
                            Access Module <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </div>
                    </div>
                </a>

                {{-- MODULE 2: CATEGORY MANAGEMENT --}}
                <a href="{{ route('categories.index') }}" class="group block bg-[#1e1e1e] rounded-2xl border border-gray-800 hover:border-green-500 transition duration-300 overflow-hidden shadow-xl hover:shadow-green-500/10">
                    <div class="h-2 w-full bg-green-600"></div>
                    <div class="p-8">
                        <div class="w-14 h-14 rounded-xl bg-green-900/30 flex items-center justify-center mb-6 text-green-400 group-hover:scale-110 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                        </div>
                        <h4 class="text-2xl font-bold text-white mb-2 group-hover:text-green-400 transition">Categories</h4>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">Create, edit, and delete artwork categories (e.g., 3D Art, Illustration) for the platform.</p>
                        <div class="flex items-center text-green-400 text-xs font-bold uppercase tracking-widest group-hover:gap-2 transition-all">
                            Access Module <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </div>
                    </div>
                </a>

                {{-- MODULE 3: CONTENT MODERATION --}}
                <a href="{{ route('admin.reports') }}" class="group block bg-[#1e1e1e] rounded-2xl border border-gray-800 hover:border-red-500 transition duration-300 overflow-hidden shadow-xl hover:shadow-red-500/10">
                    <div class="h-2 w-full bg-red-600"></div>
                    <div class="p-8">
                        <div class="w-14 h-14 rounded-xl bg-red-900/30 flex items-center justify-center mb-6 text-red-400 group-hover:scale-110 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        </div>
                        <div class="flex justify-between items-start">
                            <h4 class="text-2xl font-bold text-white mb-2 group-hover:text-red-400 transition">Moderation</h4>
                            @if($pendingReports > 0)
                                <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse">{{ $pendingReports }} New</span>
                            @endif
                        </div>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">Review reports submitted by members. Take down inappropriate content or dismiss false reports.</p>
                        <div class="flex items-center text-red-400 text-xs font-bold uppercase tracking-widest group-hover:gap-2 transition-all">
                            Access Queue <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>