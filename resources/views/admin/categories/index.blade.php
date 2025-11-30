<x-app-layout>
    <div class="min-h-screen bg-[#0b0b0b] text-gray-300 py-8 md:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">Categories</h1>
                    <p class="text-gray-500 mt-1 text-sm md:text-base">Manage artwork categories.</p>
                </div>
                <a href="{{ route('categories.create') }}" class="w-full md:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold text-sm transition shadow-lg flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Add New
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-[#1e1e1e] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
                
                {{-- A. DESKTOP TABLE --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-[#121212] text-gray-400 uppercase text-xs tracking-wider font-bold border-b border-gray-800">
                            <tr>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Slug</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach ($categories as $category)
                            <tr class="hover:bg-[#252525] transition">
                                <td class="px-6 py-4">
                                    <span class="text-white font-bold">{{ $category->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm font-mono text-indigo-400">
                                    {{ $category->slug }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('categories.edit', $category) }}" class="px-3 py-1.5 bg-[#2a2a2a] hover:bg-gray-700 text-gray-300 hover:text-white rounded-lg text-xs font-bold border border-gray-700 transition inline-block">Edit</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this category?')">
                                        @csrf @method('DELETE')
                                        <button class="px-3 py-1.5 bg-[#2a2a2a] hover:bg-red-900/50 text-red-400 rounded-lg text-xs font-bold border border-gray-700 hover:border-red-800 transition">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- B. MOBILE CARDS --}}
                <div class="md:hidden space-y-3 p-4">
                    @foreach ($categories as $category)
                    <div class="bg-[#121212] border border-gray-800 rounded-xl p-4 flex items-center justify-between">
                        <div>
                            <h4 class="text-white font-bold text-lg">{{ $category->name }}</h4>
                            <p class="text-xs text-indigo-400 font-mono mt-1">{{ $category->slug }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('categories.edit', $category) }}" class="p-2 bg-[#252525] text-gray-300 rounded-lg border border-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="p-2 bg-[#252525] text-red-400 rounded-lg border border-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>