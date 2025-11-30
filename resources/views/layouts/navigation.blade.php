<nav x-data="{ open: false }" class="bg-white dark:bg-[#121212] border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50">
    <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center gap-2 md:gap-4">
            
            <div class="flex items-center shrink-0">
                <a href="{{ route('home') }}">
                    <x-application-logo class="block h-8 md:h-9 w-auto fill-current text-gray-800 dark:text-white" />
                </a>

                <div class="hidden xl:flex space-x-6 ml-6">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('artworks.index')" :active="request()->routeIs('artworks.*')">
                        {{ __('Gallery') }}
                    </x-nav-link>
                    <x-nav-link :href="route('challenges.browse')" :active="request()->routeIs('challenges.browse')">
                        {{ __('Challenges') }}
                    </x-nav-link>
                    
                </div>
            </div>

            <div class="flex-1 max-w-2xl hidden md:block px-4">
                <form action="{{ route('artworks.index') }}#gallery-section" method="GET" class="relative group" x-data="{ query: '{{ request('search') }}' }">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    
                    <input type="text" 
                           name="search" 
                           x-model="query"
                           x-ref="searchInput"
                           class="block w-full pl-10 pr-10 py-2 border border-gray-300 dark:border-gray-700 rounded-full leading-5 bg-gray-100 dark:bg-[#1a1a1a] text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200 ease-in-out" 
                           placeholder="Search art, artists, or tags...">
                    
                    <button type="button" x-show="query.length > 0" @click="query = ''; $refs.searchInput.focus()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white cursor-pointer transition" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                    </button>
                </form>
            </div>

            <div class="flex-1 md:hidden">
                <form action="{{ route('artworks.index') }}#gallery-section" method="GET" class="relative group" x-data="{ query: '{{ request('search') }}' }">
                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400 group-focus-within:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           x-model="query"
                           x-ref="mobileSearchInput"
                           class="block w-full pl-8 pr-8 h-9 border border-gray-200 dark:border-gray-700 rounded-full bg-gray-100 dark:bg-[#1a1a1a] text-gray-900 dark:text-white placeholder-gray-500 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition" 
                           placeholder="Search...">
                           
                    <button type="button" x-show="query.length > 0" @click="query = ''; $refs.mobileSearchInput.focus()" class="absolute inset-y-0 right-0 pr-2 flex items-center text-gray-400 hover:text-white cursor-pointer transition" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                    </button>
                </form>
            </div>

            <div class="flex items-center">
                
                <div class="hidden md:flex sm:items-center sm:ms-6">
                    @auth
                        @if(Auth::user()->role === 'member')
                        <a href="{{ route('artworks.create') }}" class="mr-4 text-gray-400 hover:text-white transition" title="Upload Art">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </a>
                        @endif

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white focus:outline-none transition duration-150 ease-in-out">
                                    <div class="w-8 h-8 rounded-full overflow-hidden bg-indigo-500 flex items-center justify-center text-white font-bold border border-gray-200 dark:border-gray-600">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div class="hidden lg:block font-bold">{{ Auth::user()->name }}</div>
                                    <div class="ms-1 hidden lg:block">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                {{-- Info Akun Kecil --}}
                                <div class="px-4 py-3 border-b border-gray-800 mb-1">
                                    <div class="text-sm text-white font-bold">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                                </div>

                                <x-dropdown-link :href="route('artist.show', Auth::user())">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    {{ __('My Profile') }}
                                </x-dropdown-link>

                                @if(Auth::user()->role === 'member')

                                    {{-- PERBAIKAN: SETTINGS HANYA MUNCUL UNTUK MEMBER --}}
                                    <x-dropdown-link :href="route('dashboard', ['tab' => 'settings'])">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        {{ __('Settings') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-800 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400 hover:text-red-500 hover:bg-red-900/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <div class="flex gap-3">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-bold text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition">Log In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition shadow-lg shadow-indigo-500/30">Sign Up</a>
                            @endif
                        </div>
                    @endauth
                </div>

                <div class="-mr-2 flex items-center md:hidden ml-2">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white dark:bg-[#121212] border-b border-gray-200 dark:border-gray-800">
        
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('artworks.index')" :active="request()->routeIs('artworks.*')">
                {{ __('Gallery') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('challenges.browse')" :active="request()->routeIs('challenges.browse')">
                {{ __('Challenges') }}
            </x-responsive-nav-link>
            
            @auth
                @if(Auth::user()->role === 'member')
                @endif
            @endauth
        </div>
        
        <div class="pt-4 pb-4 border-t border-gray-200 dark:border-gray-700">
            @auth
                <div class="px-4 flex items-center mb-3">
                    <div class="shrink-0">
                        <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold overflow-hidden">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="font-medium text-base text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('artist.show', Auth::user())">
                        {{ __('My Profile') }}
                    </x-responsive-nav-link>

                    {{-- PERBAIKAN: SETTINGS HANYA UNTUK MEMBER DI MOBILE JUGA --}}
                    @if(Auth::user()->role === 'member')
                        <x-responsive-nav-link :href="route('dashboard', ['tab' => 'settings'])">
                            {{ __('Settings') }}
                        </x-responsive-nav-link>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>