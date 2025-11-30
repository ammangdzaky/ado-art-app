<x-app-layout>
    <div class="min-h-screen bg-[#0b0b0b] text-gray-300 py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">Host a Challenge</h1>
                    <p class="text-gray-500 mt-1">Engage the community with a new creative contest.</p>
                </div>
                <a href="{{ route('curator.dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-white transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Back to Dashboard
                </a>
            </div>

            <div class="bg-[#1e1e1e] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
                <form action="{{ route('curator.challenges.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                        
                        {{-- KOLOM KIRI: BANNER UPLOAD (AlpineJS Preview) --}}
                        <div class="lg:col-span-1" x-data="{ photoName: null, photoPreview: null }">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Challenge Banner</label>
                            
                            {{-- Input File Tersembunyi --}}
                            <input type="file" name="banner" class="hidden" x-ref="photo"
                                x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                " required />

                            {{-- Area Upload --}}
                            <div class="w-full aspect-[16/9] lg:aspect-[3/4] rounded-xl border-2 border-dashed border-gray-700 hover:border-indigo-500 bg-[#121212] flex flex-col items-center justify-center cursor-pointer transition group relative overflow-hidden"
                                 x-on:click.prevent="$refs.photo.click()">
                                
                                {{-- Placeholder --}}
                                <div class="text-center p-6" x-show="!photoPreview">
                                    <div class="w-16 h-16 mx-auto bg-gray-800 rounded-full flex items-center justify-center mb-4 group-hover:bg-indigo-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-400 font-bold">Upload Banner</p>
                                    <p class="text-[10px] text-gray-600 mt-1">1920x1080 Recommended</p>
                                </div>

                                {{-- Preview Image --}}
                                <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" x-show="photoPreview" 
                                     x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                </div>

                                {{-- Overlay Change --}}
                                <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition" x-show="photoPreview">
                                    <span class="text-white font-bold text-xs border border-white px-4 py-2 rounded-full">Change Banner</span>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('banner')" class="mt-2" />
                        </div>

                        {{-- KOLOM KANAN: FORM DETAILS --}}
                        <div class="lg:col-span-2 space-y-6">
                            
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Challenge Title</label>
                                <input type="text" id="title" name="title" 
                                       class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600 text-lg font-bold"
                                       placeholder="e.g. Cyberpunk Character Design" required>
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            {{-- Date Grid --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="start_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Start Date</label>
                                    <input type="datetime-local" id="start_date" name="start_date" 
                                           class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                                </div>
                                <div>
                                    <label for="end_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Deadline</label>
                                    <input type="datetime-local" id="end_date" name="end_date" 
                                           class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                                </div>
                            </div>

                            {{-- Prize (Input with Dollar Sign) --}}
                            <div>
                                <label for="prize" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Prize Pool (USD)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-400 font-bold text-lg">$</span>
                                    </div>
                                    <input type="text" id="prize" name="prize" 
                                           class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl pl-10 pr-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600 font-mono"
                                           placeholder="1,000" required>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Total value of all prizes.</p>
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Brief Description</label>
                                <textarea id="description" name="description" rows="4" 
                                          class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600 leading-relaxed"
                                          placeholder="Describe the theme and what participants need to create..." required></textarea>
                            </div>

                            {{-- Rules --}}
                            <div>
                                <label for="rules" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Rules & Guidelines</label>
                                <textarea id="rules" name="rules" rows="4" 
                                          class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600 leading-relaxed"
                                          placeholder="1. No AI Art&#10;2. Must be original work&#10;3. Resolution requirements..." required></textarea>
                            </div>

                            {{-- Submit Button --}}
                            <div class="pt-6 border-t border-gray-800 flex justify-end">
                                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition transform hover:-translate-y-0.5">
                                    Launch Challenge
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>