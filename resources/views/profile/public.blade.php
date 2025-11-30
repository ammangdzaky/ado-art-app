<x-app-layout>
    
    {{-- PESAN SUKSES --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
         class="bg-green-600 text-white text-center py-2.5 font-bold text-sm fixed top-16 inset-x-0 z-50 shadow-lg flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- 1. HERO COVER (Abstract Background) --}}
    <div class="h-48 md:h-64 w-full relative overflow-hidden bg-[#121212] group">
        
        @if($user->avatar)
            {{-- Gambar asli diblur kuat dan discale agar tidak ada border putih --}}
            <img src="{{ asset('storage/' . $user->avatar) }}" 
                 class="absolute inset-0 w-full h-full object-cover blur-[50px] scale-125 opacity-60 group-hover:scale-150 transition duration-[3000ms]">
        @else
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-900 via-purple-900 to-[#0b0b0b]"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
        @endif

        {{-- Overlay Gelap (Agar teks di depannya tetap terbaca/kontras) --}}
        <div class="absolute inset-0 bg-black/20"></div>
        
        {{-- Gradient Bawah (Agar menyatu dengan body hitam) --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#0b0b0b] via-transparent to-transparent"></div>
    </div>

    <div class="bg-[#0b0b0b] min-h-screen text-gray-300 pb-20">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col lg:flex-row gap-8 relative -mt-20">
                
                {{-- === KOLOM KIRI: PROFILE SIDEBAR === --}}
                <div class="lg:w-[360px] flex-shrink-0">
                    <div class="lg:sticky lg:top-24 space-y-6">
                        
                        {{-- Profile Card --}}
                        <div class="bg-[#121212] rounded-2xl p-6 border border-gray-800 shadow-2xl text-center relative group">
                            
                            {{-- Avatar --}}
                            <div class="relative mx-auto w-32 h-32 md:w-40 md:h-40 -mt-20 mb-4 rounded-full p-1.5 bg-[#121212]">
                                <div class="w-full h-full rounded-full overflow-hidden border-4 border-[#121212] shadow-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-5xl">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($user->name, 0, 1) }}
                                    @endif
                                </div>
                                @if($user->id === Auth::id())
                                    <a href="{{ route('dashboard', ['tab' => 'settings']) }}" class="absolute bottom-2 right-2 bg-white text-black p-2 rounded-full shadow-lg hover:bg-gray-200 transition" title="Edit Avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </a>
                                @endif
                            </div>

                            {{-- Nama & Info --}}
                            <h1 class="text-3xl font-black text-white mb-1 tracking-tight">{{ $user->name }}</h1>
                            <div class="text-indigo-400 text-sm font-bold uppercase tracking-widest mb-4">{{ $user->role }}</div>
                            
                            {{-- Bio --}}
                            <p class="text-gray-400 text-sm leading-relaxed mb-6">
                                {{ $user->bio ?? 'No bio yet.' }}
                            </p>

                            {{-- Stats Row --}}
                            <div class="grid grid-cols-3 gap-2 border-t border-b border-gray-800 py-4 mb-6">
                                <div>
                                    <div class="text-xl font-bold text-white">{{ $user->artworks->count() }}</div>
                                    <div class="text-[10px] text-gray-500 uppercase tracking-wider">Artworks</div>
                                </div>
                                <div>
                                    <div class="text-xl font-bold text-white">{{ $user->followers->count() }}</div>
                                    <div class="text-[10px] text-gray-500 uppercase tracking-wider">Followers</div>
                                </div>
                                <div>
                                    <div class="text-xl font-bold text-white">{{ $user->following->count() }}</div>
                                    <div class="text-[10px] text-gray-500 uppercase tracking-wider">Following</div>
                                </div>
                            </div>

                            {{-- Social Links --}}
                            @if(is_array($user->social_links) && (json_encode($user->social_links) !== '[]'))
                                <div class="flex justify-center gap-4 mb-6">
                                    @if(!empty($user->social_links['website']))
                                        <a href="{{ $user->social_links['website'] }}" target="_blank" class="p-2 bg-gray-800 hover:bg-indigo-600 text-gray-400 hover:text-white rounded-full transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                        </a>
                                    @endif
                                    @if(!empty($user->social_links['instagram']))
                                        <a href="{{ $user->social_links['instagram'] }}" target="_blank" class="p-2 bg-gray-800 hover:bg-pink-600 text-gray-400 hover:text-white rounded-full transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                        </a>
                                    @endif
                                    @if(!empty($user->social_links['twitter']))
                                        <a href="{{ $user->social_links['twitter'] }}" target="_blank" class="p-2 bg-gray-800 hover:bg-blue-400 text-gray-400 hover:text-white rounded-full transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            @endif

                            {{-- Tombol Aksi Utama --}}
                            @if($user->id === Auth::id())
                                <a href="{{ route('dashboard', ['tab' => 'settings']) }}" class="block w-full py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-bold text-sm transition">
                                    Edit Profile
                                </a>
                            @else
                                @auth
                                    <form action="{{ route('user.follow', $user) }}" method="POST">
                                        @csrf
                                        <button class="w-full py-2.5 rounded-lg font-bold text-sm transition {{ $isFollowing ? 'bg-gray-800 text-gray-300 border border-gray-700 hover:text-white' : 'bg-indigo-600 text-white hover:bg-indigo-500' }}">
                                            {{ $isFollowing ? 'Following' : 'Follow' }}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="block w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-bold text-sm transition">
                                        Follow
                                    </a>
                                @endauth
                            @endif

                        </div>
                        
                        {{-- Info Gabung (Kecil) --}}
                        <div class="text-center text-xs text-gray-600 uppercase tracking-widest font-bold">
                            Joined {{ $user->created_at->format('F Y') }}
                        </div>
                    </div>
                </div>

                {{-- === KOLOM KANAN: GALLERY === --}}
                <div class="flex-1 min-w-0 pt-8 lg:pt-0">
                    
                    <div class="flex items-center justify-between mb-6 ">
                        <h2 class="text-2xl font-bold text-white">Portfolio</h2>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($user->artworks as $artwork)
                        <div class="group relative bg-[#1e1e1e] rounded-xl overflow-hidden shadow-lg border border-gray-800 hover:border-indigo-500 transition duration-300">
                            <a href="{{ route('artworks.show', $artwork) }}" class="block aspect-square overflow-hidden">
                                <img src="{{ asset('storage/' . $artwork->image_path) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110 opacity-80 group-hover:opacity-100">
                            </a>
                            
                            {{-- Overlay Info --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-4 pointer-events-none">
                                <h3 class="text-white font-bold truncate text-sm">{{ $artwork->title }}</h3>
                                <div class="flex items-center gap-2 text-xs text-gray-300 mt-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/></svg>
                                    {{ $artwork->likes->count() }}
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full py-20 text-center border-2 border-dashed border-gray-800 rounded-xl">
                            <div class="bg-[#1e1e1e] w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <p class="text-gray-500 text-lg">No artworks shared yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>