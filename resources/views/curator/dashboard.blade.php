<x-app-layout>
    {{-- CONTAINER UTAMA (Alpine JS untuk Tab System) --}}
    <div class="min-h-screen bg-[#0b0b0b] text-gray-300" 
        x-data="{ activeTab: new URLSearchParams(window.location.search).get('tab') || 'challenges' }">
        
        {{-- 1. HEADER PROFILE & STATS --}}
        <div class="bg-[#121212] border-b border-gray-800 pt-8 md:pt-10 pb-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center md:items-end gap-6 md:gap-8 pb-8 text-center md:text-left">
                    
                    {{-- Avatar Besar --}}
                    <div class="relative group shrink-0">
                        <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-[#0b0b0b] shadow-2xl bg-indigo-600 flex items-center justify-center">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-3xl md:text-4xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            @endif
                        </div>
                        {{-- Tombol Edit Cepat --}}
                        <button @click="activeTab = 'settings'" class="absolute inset-0 bg-black/50 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition cursor-pointer text-white font-bold text-xs uppercase tracking-wide">
                            Edit
                        </button>
                    </div>

                    {{-- Info User --}}
                    <div class="flex-1 w-full">
                        <div class="flex flex-col md:flex-row items-center gap-3 mb-2 justify-center md:justify-start">
                            <h1 class="text-2xl md:text-4xl font-black text-white tracking-tight">{{ Auth::user()->name }}</h1>
                            <span class="px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-[10px] font-bold uppercase tracking-widest">
                                Curator
                            </span>
                        </div>
                        <p class="text-gray-400 max-w-2xl text-sm leading-relaxed mx-auto md:mx-0">{{ Auth::user()->bio ?? 'Manage your events and discover new talents.' }}</p>
                        
                        {{-- Stats --}}
                        <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 md:gap-8 mt-6 text-sm font-bold">
                            <div class="text-center md:text-left">
                                <span class="block text-white text-xl md:text-2xl">{{ $challenges->count() }}</span>
                                <span class="text-gray-500 uppercase text-[10px] tracking-wider">Events Created</span>
                            </div>
                            <div class="w-px h-8 bg-gray-800 hidden md:block"></div>
                            <div class="text-center md:text-left">
                                <span class="block text-green-400 text-xl md:text-2xl">{{ $activeCount }}</span>
                                <span class="text-gray-500 uppercase text-[10px] tracking-wider">Active Now</span>
                            </div>
                            <div class="w-px h-8 bg-gray-800 hidden md:block"></div>
                            <div class="text-center md:text-left">
                                <span class="block text-indigo-400 text-xl md:text-2xl">{{ $totalSubmissions }}</span>
                                <span class="text-gray-500 uppercase text-[10px] tracking-wider">Total Submissions</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Create Challenge Utama --}}
                    <div class="w-full md:w-auto mt-4 md:mt-0">
                        <a href="{{ route('curator.challenges.create') }}" class="flex items-center justify-center gap-2 bg-white hover:bg-gray-200 text-black px-6 py-3 rounded-full font-bold transition shadow-lg transform hover:-translate-y-1 w-full md:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            <span>Create Challenge</span>
                        </a>
                    </div>
                </div>

                {{-- 2. TAB NAVIGATION --}}
                <div class="flex space-x-8 border-t border-gray-800 justify-center md:justify-start">
                    <button @click="activeTab = 'challenges'" 
                            :class="activeTab === 'challenges' ? 'border-indigo-500 text-white' : 'border-transparent text-gray-500 hover:text-gray-300'"
                            class="py-4 px-4 border-t-2 font-bold text-sm tracking-wide transition">
                        MY CHALLENGES
                    </button>
                    <button @click="activeTab = 'settings'" 
                            :class="activeTab === 'settings' ? 'border-indigo-500 text-white' : 'border-transparent text-gray-500 hover:text-gray-300'"
                            class="py-4 px-4 border-t-2 font-bold text-sm tracking-wide transition">
                        SETTINGS
                    </button>
                </div>
            </div>
        </div>

        {{-- 3. KONTEN TABS --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            {{-- TAB 1: CHALLENGES MANAGEMENT --}}
            <div x-show="activeTab === 'challenges'" x-transition.opacity>
                
                @if($challenges->isEmpty())
                    <div class="text-center py-24 border-2 border-dashed border-gray-800 rounded-3xl bg-[#121212]">
                        <div class="bg-gray-800 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">No Challenges Yet</h3>
                        <p class="text-gray-500 mb-6 max-w-md mx-auto">Start hosting art competitions to engage with the community and discover amazing talents.</p>
                        <a href="{{ route('curator.challenges.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-full font-bold transition">
                            Create Your First Event
                        </a>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($challenges as $challenge)
                        <div class="group bg-[#1e1e1e] rounded-2xl overflow-hidden border border-gray-800 hover:border-indigo-500/50 transition shadow-xl hover:shadow-2xl flex flex-col md:flex-row h-auto md:h-64">
                            
                            {{-- Banner Image (Lebih Gelap & Badge Jelas) --}}
                            <div class="relative h-48 md:h-full w-full md:w-2/5 overflow-hidden shrink-0">
                                <img src="{{ asset('storage/' . $challenge->banner_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 opacity-80 group-hover:opacity-100">
                                
                                {{-- Gradient Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-[#1e1e1e] via-transparent to-transparent opacity-90 md:bg-gradient-to-r"></div>
                                
                                {{-- Badge Status (Menggunakan Backdrop Blur agar jelas di gambar terang) --}}
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
                            </div>

                            {{-- Info & Controls --}}
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-2xl font-black text-white leading-tight">{{ $challenge->title }}</h3>
                                        
                                        {{-- Dropdown Action (Mobile) atau Button (Desktop) --}}
                                    </div>
                                    
                                    {{-- Stats --}}
                                    <div class="flex flex-wrap items-center gap-4 text-xs text-gray-400 mb-6 font-medium uppercase tracking-wide">
                                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg> {{ $challenge->submissions_count }} Entries</span>
                                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> End: {{ $challenge->end_date->format('M d, Y') }}</span>
                                    </div>

                                    {{-- Countdown Timer --}}
                                    @if($challenge->status === 'open')
                                        <div class="bg-black/30 rounded-lg p-3 border border-gray-800 inline-block mb-4">
                                            <div class="text-[10px] text-gray-500 uppercase font-bold mb-1">Time Remaining</div>
                                            <div class="countdown-timer font-mono text-lg font-bold text-white flex gap-2" data-deadline="{{ $challenge->end_date->timestamp * 1000 }}">
                                                <span>Loading...</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex flex-wrap gap-3 mt-auto">
                                    {{-- Manage (Utama) --}}
                                    <a href="{{ route('challenges.show', $challenge) }}" class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-center text-sm font-bold transition shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2">
                                        Manage & Winners
                                    </a>
                                    
                                    {{-- Edit --}}
                                    <a href="{{ route('curator.challenges.edit', $challenge) }}" class="px-4 py-2.5 bg-[#252525] hover:bg-gray-700 text-gray-300 hover:text-white rounded-lg text-center text-sm font-bold border border-gray-700 transition">
                                        Edit
                                    </a>
                                    
                                    {{-- Delete --}}
                                    <form action="{{ route('curator.challenges.destroy', $challenge) }}" method="POST" onsubmit="return confirm('Delete this challenge? This cannot be undone.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-4 py-2.5 bg-[#252525] hover:bg-red-900/30 text-red-500 hover:text-red-400 rounded-lg text-center text-sm font-bold border border-gray-700 hover:border-red-900 transition h-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- TAB 2: SETTINGS --}}
            <div x-show="activeTab === 'settings'" x-transition.opacity style="display: none;">
                
                <div class="max-w-4xl mx-auto">
                    <h3 class="text-2xl font-black text-white mb-8">Profile Settings</h3>

                    <div class="bg-[#1e1e1e] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
                        
                        {{-- Form dengan x-data untuk preview gambar --}}
                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" 
                              class="p-8"
                              x-data="{ photoName: null, photoPreview: null }">
                            @csrf
                            @method('patch')

                            <div class="flex flex-col md:flex-row gap-10">
                                
                                {{-- KOLOM KIRI: AVATAR UPLOAD --}}
                                <div class="md:w-1/3 flex flex-col items-center">
                                    <div class="relative group">
                                        <input type="file" name="avatar" class="hidden" x-ref="photo"
                                            x-on:change="
                                                photoName = $refs.photo.files[0].name;
                                                const reader = new FileReader();
                                                reader.onload = (e) => { photoPreview = e.target.result; };
                                                reader.readAsDataURL($refs.photo.files[0]);
                                            " />

                                        <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-[#121212] shadow-lg bg-indigo-600 flex items-center justify-center" x-show="!photoPreview">
                                            @if(Auth::user()->avatar)
                                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-5xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                            @endif
                                        </div>

                                        <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-indigo-500 shadow-lg bg-black" x-show="photoPreview" style="display: none;">
                                            <span class="block w-full h-full bg-cover bg-no-repeat bg-center"
                                                  x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                            </span>
                                        </div>

                                        <div class="absolute bottom-2 right-2 bg-white text-gray-900 p-2 rounded-full shadow-lg cursor-pointer hover:bg-gray-200 transition transform hover:scale-110"
                                             x-on:click.prevent="$refs.photo.click()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                    </div>

                                    <p class="text-xs text-gray-500 mt-4 text-center">
                                        Click the camera icon to change.<br>JPG, PNG or GIF (Max 2MB).
                                    </p>

                                    {{-- Member Badge --}}
                                    <div class="mt-6 bg-[#121212] rounded-lg p-4 w-full border border-gray-800 text-center">
                                        <div class="text-xs text-gray-500 uppercase tracking-widest font-bold mb-1">Role</div>
                                        <div class="text-indigo-400 font-black text-lg uppercase tracking-wider">{{ Auth::user()->role }}</div>
                                    </div>
                                </div>

                                {{-- KOLOM KANAN: FORM DATA --}}
                                <div class="md:w-2/3 space-y-6">
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        {{-- Name --}}
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Display Name</label>
                                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                                                   class="w-full bg-[#121212] border border-gray-700 text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition hover:border-gray-600" required>
                                        </div>

                                        {{-- Email --}}
                                        <div class="space-y-2">
                                            <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Email Address</label>
                                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                                                   class="w-full bg-[#121212] border border-gray-700 text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition hover:border-gray-600" required>
                                        </div>
                                    </div>

                                    {{-- Bio --}}
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Bio / About Me</label>
                                        <textarea name="bio" rows="5" 
                                                  class="w-full bg-[#121212] border border-gray-700 text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition hover:border-gray-600 leading-relaxed"
                                                  placeholder="Tell us about your art style...">{{ old('bio', Auth::user()->bio) }}</textarea>
                                        <p class="text-xs text-gray-600 text-right">Brief description for your profile.</p>
                                    </div>

                                    {{-- Social Links Section --}}
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-800">
                                        <div class="md:col-span-3 text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">External Links</div>
                                        
                                        {{-- Website --}}
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 mb-1">Website URL</label>
                                            <input type="url" name="website" value="{{ Auth::user()->social_links['website'] ?? '' }}" placeholder="https://yourportfolio.com"
                                                  class="w-full bg-[#121212] border border-gray-700 text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
                                        </div>

                                        {{-- Instagram --}}
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 mb-1">Instagram URL</label>
                                            <input type="url" name="instagram" value="{{ Auth::user()->social_links['instagram'] ?? '' }}" placeholder="https://instagram.com/username"
                                                  class="w-full bg-[#121212] border border-gray-700 text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
                                        </div>

                                        {{-- Twitter --}}
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 mb-1">Twitter / X URL</label>
                                            <input type="url" name="twitter" value="{{ Auth::user()->social_links['twitter'] ?? '' }}" placeholder="https://twitter.com/username"
                                                  class="w-full bg-[#121212] border border-gray-700 text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2">
                                        </div>
                                    </div>

                                    {{-- Save Button & Status --}}
                                    <div class="pt-4 flex items-center justify-between border-t border-gray-800 mt-8">
                                        <div class="text-sm">
                                            @if (session('status') === 'profile-updated')
                                                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-green-400 font-bold flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                                    Saved Successfully
                                                </span>
                                            @endif
                                        </div>

                                        <button type="submit" class="px-8 py-3 bg-white hover:bg-gray-200 text-black font-bold rounded-xl transition shadow-lg shadow-white/10 transform hover:-translate-y-0.5">
                                            Save Changes
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- JS Countdown --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timers = document.querySelectorAll('.countdown-timer');
            timers.forEach(timer => {
                const deadline = parseInt(timer.getAttribute('data-deadline'));
                const updateTimer = () => {
                    const now = new Date().getTime();
                    const dist = deadline - now;
                    if(dist < 0) { timer.innerHTML = "<span class='text-red-500 text-sm'>EXPIRED</span>"; return; }
                    const d = Math.floor(dist / (1000 * 60 * 60 * 24));
                    const h = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const m = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((dist % (1000 * 60)) / 1000);
                    const fh = h < 10 ? "0" + h : h; const fm = m < 10 ? "0" + m : m; const fs = s < 10 ? "0" + s : s;
                    timer.innerHTML = `<span class="text-white mr-2">${d} Days</span><span class="text-indigo-400 font-mono">${fh}:${fm}:${fs}</span>`;
                };
                updateTimer(); setInterval(updateTimer, 1000);
            });
        });
    </script>
</x-app-layout>