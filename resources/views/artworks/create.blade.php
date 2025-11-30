<x-app-layout>
    <div class="min-h-screen bg-[#0b0b0b] text-gray-300 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-black text-white tracking-tight">Upload Artwork</h1>
                <p class="text-gray-500 mt-1">Share your latest creation with the community.</p>
            </div>

            <div class="bg-[#1e1e1e] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
                <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        {{-- KOLOM KIRI: UPLOAD AREA --}}
                        <div class="lg:col-span-1" x-data="{ photoName: null, photoPreview: null }">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Artwork File</label>
                            
                            <input type="file" name="image" class="hidden" x-ref="photo"
                                x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                " />

                            <div class="w-full aspect-[3/4] rounded-xl border-2 border-dashed border-gray-700 hover:border-indigo-500 bg-[#121212] flex flex-col items-center justify-center cursor-pointer transition group relative overflow-hidden"
                                 x-on:click.prevent="$refs.photo.click()">
                                
                                <div class="text-center p-6" x-show="!photoPreview">
                                    <div class="w-16 h-16 mx-auto bg-gray-800 rounded-full flex items-center justify-center mb-4 group-hover:bg-indigo-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-400 font-bold">Click to upload</p>
                                    <p class="text-xs text-gray-600 mt-1">JPG, PNG (Max 10MB)</p>
                                </div>

                                <div class="absolute inset-0 bg-contain bg-center bg-no-repeat" x-show="photoPreview" 
                                     x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        {{-- KOLOM KANAN: FORM DETAILS --}}
                        <div class="lg:col-span-2 space-y-6">
                            
                            {{-- Title --}}
                            <div>
                                <label for="title" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Title</label>
                                <input type="text" id="title" name="title" 
                                       class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600"
                                       placeholder="e.g. The Last Samurai" required>
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            {{-- CUSTOM CATEGORY DROPDOWN (Alpine JS) --}}
                            <div x-data="{ 
                                open: false, 
                                selected: '{{ old('category_id') }}', 
                                selectedName: 'Select Category' 
                            }" class="relative">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                                
                                {{-- Input Hidden untuk dikirim ke server --}}
                                <input type="hidden" name="category_id" :value="selected">
                                
                                {{-- Trigger Button --}}
                                <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="w-full bg-[#121212] border border-gray-700 text-left rounded-xl px-4 py-3 flex justify-between items-center focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                        :class="{'border-indigo-500 ring-1 ring-indigo-500': open}">
                                    <span x-text="selectedName" :class="{'text-gray-400': selectedName === 'Select Category', 'text-white font-bold': selectedName !== 'Select Category'}"></span>
                                    <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                {{-- Dropdown List --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute z-50 mt-2 w-full bg-[#1e1e1e] border border-gray-700 rounded-xl shadow-2xl max-h-60 overflow-y-auto custom-scrollbar">
                                    @foreach($categories as $category)
                                        <div @click="selected = '{{ $category->id }}'; selectedName = '{{ $category->name }}'; open = false"
                                             class="px-4 py-3 hover:bg-indigo-600 hover:text-white cursor-pointer transition flex items-center justify-between group border-b border-gray-800 last:border-0"
                                             :class="selected == '{{ $category->id }}' ? 'bg-indigo-900/30 text-indigo-400' : 'text-gray-300'">
                                            <span class="font-medium">{{ $category->name }}</span>
                                            {{-- Checkmark Icon --}}
                                            <svg x-show="selected == '{{ $category->id }}'" class="w-4 h-4 text-indigo-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        </div>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            {{-- Description --}}
                            <div>
                                <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Description</label>
                                <textarea id="description" name="description" rows="5" 
                                          class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600 leading-relaxed"
                                          placeholder="Tell the story behind your artwork..." required></textarea>
                            </div>

                            {{-- Tags --}}
                            <div>
                                <label for="tags" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tags</label>
                                <input type="text" id="tags" name="tags" 
                                       class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600"
                                       placeholder="cyberpunk, 3d, concept art (comma separated)">
                            </div>

                            {{-- Submit Button --}}
                            <div class="pt-4 border-t border-gray-800 flex justify-end">
                                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition transform hover:-translate-y-0.5">
                                    Publish Artwork
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>