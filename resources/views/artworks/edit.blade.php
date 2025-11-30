<x-app-layout>
    <div class="min-h-screen bg-[#0b0b0b] text-gray-300 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">Edit Artwork</h1>
                    <p class="text-gray-500 mt-1">Update details or change the image.</p>
                </div>
                <a href="{{ route('artworks.show', $artwork) }}" class="text-sm font-bold text-gray-400 hover:text-white transition">
                    &larr; Cancel
                </a>
            </div>

            <div class="bg-[#1e1e1e] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
                <form action="{{ route('artworks.update', $artwork) }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        {{-- IMAGE PREVIEW --}}
                        <div class="lg:col-span-1" x-data="{ photoName: null, photoPreview: '{{ asset('storage/' . $artwork->image_path) }}' }">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Artwork Image</label>
                            
                            <input type="file" name="image" class="hidden" x-ref="photo"
                                x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                " />

                            <div class="w-full aspect-[3/4] rounded-xl border-2 border-dashed border-gray-700 hover:border-indigo-500 bg-[#121212] flex flex-col items-center justify-center cursor-pointer transition group relative overflow-hidden"
                                 x-on:click.prevent="$refs.photo.click()">
                                
                                <div class="absolute inset-0 bg-contain bg-center bg-no-repeat" 
                                     x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                </div>

                                <div class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                    <span class="text-white font-bold text-sm border border-white px-4 py-2 rounded-full">Change Image</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 mt-3 text-center">Leave unchanged to keep current.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        {{-- FORM DETAILS --}}
                        <div class="lg:col-span-2 space-y-6">
                            
                            <div>
                                <label for="title" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Title</label>
                                <input type="text" id="title" name="title" value="{{ old('title', $artwork->title) }}"
                                       class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600"
                                       required>
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            {{-- CUSTOM CATEGORY DROPDOWN (EDIT MODE) --}}
                            {{-- Perhatikan inisialisasi selected dan selectedName dari data database --}}
                            <div x-data="{ 
                                open: false, 
                                selected: '{{ old('category_id', $artwork->category_id) }}', 
                                selectedName: '{{ $artwork->category->name ?? 'Select Category' }}' 
                            }" class="relative">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Category</label>
                                
                                <input type="hidden" name="category_id" :value="selected">
                                
                                <button type="button" @click="open = !open" @click.outside="open = false"
                                        class="w-full bg-[#121212] border border-gray-700 text-left rounded-xl px-4 py-3 flex justify-between items-center focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                        :class="{'border-indigo-500 ring-1 ring-indigo-500': open}">
                                    <span x-text="selectedName" class="text-white font-bold"></span>
                                    <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                <div x-show="open" x-transition 
                                     class="absolute z-50 mt-2 w-full bg-[#1e1e1e] border border-gray-700 rounded-xl shadow-2xl max-h-60 overflow-y-auto custom-scrollbar">
                                    @foreach($categories as $category)
                                        <div @click="selected = '{{ $category->id }}'; selectedName = '{{ $category->name }}'; open = false"
                                             class="px-4 py-3 hover:bg-indigo-600 hover:text-white cursor-pointer transition flex items-center justify-between group border-b border-gray-800 last:border-0"
                                             :class="selected == '{{ $category->id }}' ? 'bg-indigo-900/30 text-indigo-400' : 'text-gray-300'">
                                            <span class="font-medium">{{ $category->name }}</span>
                                            <svg x-show="selected == '{{ $category->id }}'" class="w-4 h-4 text-indigo-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        </div>
                                    @endforeach
                                </div>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Description</label>
                                <textarea id="description" name="description" rows="6" 
                                          class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600 leading-relaxed"
                                          required>{{ old('description', $artwork->description) }}</textarea>
                            </div>

                            <div>
                                <label for="tags" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tags</label>
                                <input type="text" id="tags" name="tags" value="{{ old('tags', $artwork->tags) }}"
                                       class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600">
                            </div>

                            <div class="pt-6 border-t border-gray-800 flex justify-end gap-4">
                                <a href="{{ route('artworks.show', $artwork) }}" class="px-6 py-3 text-gray-400 font-bold hover:text-white transition">Cancel</a>
                                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition transform hover:-translate-y-0.5">
                                    Update Artwork
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>