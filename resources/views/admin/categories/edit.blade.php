<x-app-layout>
    <div class="min-h-screen bg-[#0b0b0b] text-gray-300 py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">Edit Category</h1>
                    <p class="text-gray-500 mt-1">Update category name and slug.</p>
                </div>
                <a href="{{ route('categories.index') }}" class="text-sm font-bold text-gray-400 hover:text-white flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Back to List
                </a>
            </div>

            <div class="bg-[#1e1e1e] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
                <form action="{{ route('categories.update', $category) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        {{-- Name Input --}}
                        <div>
                            <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Category Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                                   class="w-full bg-[#121212] border border-gray-700 text-white rounded-xl px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500 transition placeholder-gray-600 font-medium"
                                   required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Slug Info (Read Only visual) --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Current Slug</label>
                            <div class="w-full bg-[#151515] border border-gray-800 text-gray-400 rounded-xl px-4 py-3 font-mono text-sm">
                                {{ $category->slug }}
                            </div>
                            <p class="text-xs text-gray-600 mt-2">Slug will be updated automatically if you change the name.</p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-6 mt-6 border-t border-gray-800 flex justify-end gap-4">
                        <a href="{{ route('categories.index') }}" class="px-6 py-3 text-gray-400 font-bold hover:text-white transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/20 transition transform hover:-translate-y-0.5">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>