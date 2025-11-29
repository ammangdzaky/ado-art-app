<x-app-layout>
    {{-- CONTAINER UTAMA (Alpine JS untuk Tab System) --}}
    <div class="min-h-screen bg-[#0b0b0b] text-gray-300" x-data="{ activeTab: 'portfolio' }">
        
        {{-- 1. HEADER PROFILE & STATS --}}
        <div class="bg-[#121212] border-b border-gray-800 pt-8 md:pt-10 pb-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Flex Column di HP (items-center), Flex Row di Desktop (items-end) --}}
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
                        <h1 class="text-2xl md:text-4xl font-black text-white tracking-tight mb-2">{{ Auth::user()->name }}</h1>
                        <p class="text-gray-400 max-w-2xl text-sm leading-relaxed mx-auto md:mx-0">{{ Auth::user()->bio ?? 'No bio yet. Tell the world who you are!' }}</p>
                        
                        {{-- Stats --}}
                        <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 md:gap-6 mt-4 md:mt-6 text-sm font-bold">
                            <div class="flex items-center gap-2">
                                <span class="text-white text-lg md:text-xl">{{ $artworks->count() }}</span>
                                <span class="text-gray-500 uppercase text-[10px] md:text-xs tracking-wider">Artworks</span>
                            </div>
                            <div class="w-px h-4 bg-gray-700"></div>
                            <div class="flex items-center gap-2">
                                <span class="text-white text-lg md:text-xl">{{ $collections->count() }}</span>
                                <span class="text-gray-500 uppercase text-[10px] md:text-xs tracking-wider">Moodboards</span>
                            </div>
                            <div class="w-px h-4 bg-gray-700"></div>
                            <div class="flex items-center gap-2">
                                <span class="text-white text-lg md:text-xl">{{ $submissions->count() }}</span>
                                <span class="text-gray-500 uppercase text-[10px] md:text-xs tracking-wider">Challenges</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Upload Utama --}}
                    <div class="w-full md:w-auto mt-2 md:mt-0">
                        <a href="{{ route('artworks.create') }}" class="flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-full font-bold transition shadow-lg shadow-indigo-500/20 transform hover:-translate-y-1 w-full md:w-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            <span>Upload Art</span>
                        </a>
                    </div>
                </div>

                {{-- 2. TAB NAVIGATION --}}
                <div class="flex overflow-x-auto space-x-8 border-t border-gray-800 -mx-4 px-4 md:mx-0 md:px-0 hide-scroll">
                    <button @click="activeTab = 'portfolio'" 
                            :class="activeTab === 'portfolio' ? 'border-indigo-500 text-white' : 'border-transparent text-gray-500 hover:text-gray-300'"
                            class="py-4 px-1 border-t-2 font-bold text-sm tracking-wide transition whitespace-nowrap flex-shrink-0">
                        PORTFOLIO
                    </button>
                    <button @click="activeTab = 'moodboards'" 
                            :class="activeTab === 'moodboards' ? 'border-indigo-500 text-white' : 'border-transparent text-gray-500 hover:text-gray-300'"
                            class="py-4 px-1 border-t-2 font-bold text-sm tracking-wide transition whitespace-nowrap flex-shrink-0">
                        MOODBOARDS
                    </button>
                    <button @click="activeTab = 'submissions'" 
                            :class="activeTab === 'submissions' ? 'border-indigo-500 text-white' : 'border-transparent text-gray-500 hover:text-gray-300'"
                            class="py-4 px-1 border-t-2 font-bold text-sm tracking-wide transition whitespace-nowrap flex-shrink-0">
                        SUBMISSIONS
                    </button>
                    <button @click="activeTab = 'settings'" 
                            :class="activeTab === 'settings' ? 'border-indigo-500 text-white' : 'border-transparent text-gray-500 hover:text-gray-300'"
                            class="py-4 px-1 border-t-2 font-bold text-sm tracking-wide transition whitespace-nowrap flex-shrink-0">
                        SETTINGS
                    </button>
                </div>
            </div>
        </div>

        {{-- 3. KONTEN TABS --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            
            {{-- TAB 1: PORTFOLIO --}}
            <div x-show="activeTab === 'portfolio'" x-transition.opacity>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">My Portfolio</h3>
                </div>

                @if($artworks->isEmpty())
                    <div class="text-center py-20 border-2 border-dashed border-gray-800 rounded-2xl">
                        <div class="bg-gray-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <p class="text-gray-500">You haven't uploaded any artwork yet.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                        @foreach($artworks as $art)
                        <div class="group relative bg-[#121212] rounded-xl overflow-hidden border border-gray-800 hover:border-gray-600 transition shadow-lg">
                            <a href="{{ route('artworks.show', $art) }}" class="block aspect-square overflow-hidden">
                                <img src="{{ asset('storage/' . $art->image_path) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110 opacity-80 group-hover:opacity-100">
                            </a>
                            <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ route('artworks.edit', $art) }}" class="p-2 bg-black/70 text-white rounded-lg hover:bg-indigo-600 backdrop-blur-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                                </a>
                            </div>
                            <div class="p-3">
                                <h4 class="text-white font-bold text-sm truncate">{{ $art->title }}</h4>
                                <div class="flex justify-between items-center mt-1">
                                    <span class="text-xs text-gray-500">{{ $art->created_at->diffForHumans() }}</span>
                                    <span class="text-xs text-indigo-400 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/></svg> 
                                        {{ $art->likes_count }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- TAB 2: MOODBOARDS --}}
            <div x-show="activeTab === 'moodboards'" x-transition.opacity style="display: none;">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">My Moodboards</h3>
                </div>

                @if($collections->isEmpty())
                    <div class="text-center py-20 border-2 border-dashed border-gray-800 rounded-2xl">
                        <p class="text-gray-500">No moodboards created yet.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($collections as $col)
                        <a href="{{ route('collections.show', $col) }}" class="block bg-[#121212] rounded-xl overflow-hidden border border-gray-800 hover:border-indigo-500 transition group">
                            <div class="h-40 bg-gray-800 flex items-center justify-center relative overflow-hidden">
                                <div class="flex w-full h-full">
                                    @foreach($col->artworks->take(3) as $art)
                                        <div class="flex-1 h-full border-r border-black/20">
                                            <img src="{{ asset('storage/' . $art->image_path) }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition">
                                        </div>
                                    @endforeach
                                    @if($col->artworks->count() == 0)
                                        <span class="text-gray-600 text-xs font-bold uppercase w-full flex items-center justify-center">Empty</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-5">
                                <h4 class="text-lg font-bold text-white group-hover:text-indigo-400 transition">{{ $col->name }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $col->artworks_count }} items</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- TAB 3: SUBMISSIONS (UPDATED: CLICKABLE CARDS) --}}
            <div x-show="activeTab === 'submissions'" x-transition.opacity style="display: none;">
                <h3 class="text-xl font-bold text-white mb-6">Challenge History</h3>

                @if($submissions->isEmpty())
                    <div class="text-center py-20 border-2 border-dashed border-gray-800 rounded-2xl">
                        <p class="text-gray-500">You haven't joined any challenges yet.</p>
                        <a href="{{ route('challenges.browse') }}" class="text-indigo-500 hover:underline mt-2 inline-block">Browse Challenges</a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($submissions as $sub)
                        {{-- PERBAIKAN DI SINI: Menambahkan tag <a> --}}
                        <a href="{{ route('challenges.show', $sub->challenge) }}" class="block flex flex-col md:flex-row items-start md:items-center gap-4 bg-[#121212] p-4 rounded-xl border border-gray-800 hover:border-indigo-500 transition group">
                            <div class="flex items-center gap-4 w-full md:w-auto">
                                <div class="w-16 h-16 md:w-20 md:h-20 rounded-lg overflow-hidden bg-black shrink-0">
                                    <img src="{{ asset('storage/' . $sub->artwork->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                </div>
                                <div class="flex-1 md:hidden">
                                    <h4 class="text-white font-bold text-base truncate group-hover:text-indigo-400">{{ $sub->artwork->title }}</h4>
                                    <span class="text-xs text-gray-400">in {{ $sub->challenge->title }}</span>
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0 hidden md:block">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Challenge</span>
                                    <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                                    <span class="text-xs text-gray-400 group-hover:text-white transition">{{ $sub->challenge->title }}</span>
                                </div>
                                <h4 class="text-white font-bold text-lg truncate group-hover:text-indigo-400 transition">{{ $sub->artwork->title }}</h4>
                                <div class="text-xs text-gray-500 mt-1">Submitted {{ $sub->created_at->format('d M Y') }}</div>
                            </div>

                            <div class="w-full md:w-auto text-right mt-2 md:mt-0">
                                @if($sub->rank == '1')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-500 text-xs font-bold border border-yellow-500/30">🥇 1st Place</span>
                                @elseif($sub->rank == '2')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-300/20 text-gray-300 text-xs font-bold border border-gray-300/30">🥈 2nd Place</span>
                                @elseif($sub->rank == '3')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-orange-500/20 text-orange-500 text-xs font-bold border border-orange-500/30">🥉 3rd Place</span>
                                @elseif($sub->challenge->status == 'closed')
                                    <span class="text-gray-500 text-xs font-bold">Not Selected</span>
                                @else
                                    <span class="text-blue-400 text-xs font-bold bg-blue-400/10 px-3 py-1 rounded-full">Judging Pending</span>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- TAB 4: SETTINGS (MODERN UI WITH LIVE PREVIEW) --}}
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
</x-app-layout>