<x-app-layout>
    <div class="min-h-screen bg-[#0b0b0b] text-gray-300 py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">Edit Challenge</h1>
                    <p class="text-gray-500 mt-1">Update event details or change the banner.</p>
                </div>
                <a href="{{ route('curator.dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-white transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Back to Dashboard
                </a>
            </div>

            <div class="bg-[#1e1e1e] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
                {{-- Perhatikan route update dan method PUT --}}
                <form action="{{ route('curator.challenges.update', $challenge) }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                        
                        {{-- KOLOM KIRI: BANNER PREVIEW & UPLOAD --}}
                        <div class="lg:col-span-1" x-data="{ photoName: null, photoPreview: '{{ asset('storage/' . $challenge->banner_path) }}' }">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Challenge Banner</label>
                            
                            <input type="file" name="banner" class="hidden" x-ref="photo"
                                x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                " />

                            <div class="w-full aspect-[16/9] lg:aspect-[3/4] rounded-xl border-2 border-dashed border-gray-700 hover:border-indigo-500 bg-[#121212] flex flex-col items-center justify-center cursor-pointer transition group relative overflow-hidden"
                                 x-on:click.prevent="$refs.photo.click()">
                                
                                {{-- Preview (Menampilkan gambar lama atau baru) --}}
                                <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
                                     x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                </div>

                                {{-- Overlay Change --}}
                                <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                    <span class="text-white font-bold text-xs border border-white px-4 py-2 rounded-full">Change Banner</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mt-3 text-center">Leave unchanged to keep current banner.</p>
                            <x-input-error :messages="$errors->get('banner')" class="mt-2" />
                        </div>

                        {{-- KOLOM KANAN: FORM DETAILS --}}
                        <div class="lg:col-span-2 space-y-6">
                            
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Challenge Title</label>
                                <input type="text" id="title" name="title" value="{{ old('title', $challenge->title) }}"
                                       class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600 text-lg font-bold"
                                       required>
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            {{-- Date Grid --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="start_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Start Date</label>
                                    {{-- Format tanggal harus Y-m-d\TH:i agar terbaca input datetime-local --}}
                                    <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date', $challenge->start_date->format('Y-m-d\TH:i')) }}"
                                           class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                                </div>
                                <div>
                                    <label for="end_date" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Deadline</label>
                                    <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date', $challenge->end_date->format('Y-m-d\TH:i')) }}"
                                           class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                                </div>
                            </div>

                            {{-- Prize --}}
                            <div>
                                <label for="prize" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Prize Pool (USD)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-400 font-bold text-lg">$</span>
                                    </div>
                                    <input type="text" id="prize" name="prize" value="{{ old('prize', $challenge->prize) }}"
                                           class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl pl-10 pr-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600 font-mono"
                                           required>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Brief Description</label>
                                <textarea id="description" name="description" rows="4" 
                                          class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600 leading-relaxed"
                                          required>{{ old('description', $challenge->description) }}</textarea>
                            </div>

                            {{-- Rules --}}
                            <div>
                                <label for="rules" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Rules & Guidelines</label>
                                <textarea id="rules" name="rules" rows="4" 
                                          class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600 leading-relaxed"
                                          required>{{ old('rules', $challenge->rules) }}</textarea>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="pt-6 border-t border-gray-800 flex justify-end gap-4">
                                <a href="{{ route('curator.dashboard') }}" class="px-6 py-3 text-gray-400 font-bold hover:text-white transition">
                                    Cancel
                                </a>
                                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition transform hover:-translate-y-0.5">
                                    Update Challenge
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>