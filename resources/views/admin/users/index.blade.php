<x-app-layout>
    <div class="min-h-screen bg-[#0b0b0b] text-gray-300 py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">User Management</h1>
                    <p class="text-gray-500 mt-1 text-sm md:text-base">Manage all members and curators.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-white flex items-center gap-2 transition bg-[#1e1e1e] px-4 py-2 rounded-lg border border-gray-800 hover:border-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Back to Dashboard
                </a>
            </div>

            <div class="bg-[#1e1e1e] rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
                
                {{-- A. TAMPILAN DESKTOP (TABLE) --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-[#121212] text-gray-400 uppercase text-xs tracking-wider font-bold border-b border-gray-800">
                            <tr>
                                <th class="px-6 py-4">User</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($users as $user)
                            <tr class="hover:bg-[#252525] transition group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shrink-0 overflow-hidden">
                                            @if($user->avatar) <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover"> @else {{ substr($user->name, 0, 1) }} @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-white">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border {{ $user->role === 'admin' ? 'bg-red-500/10 text-red-400 border-red-500/20' : ($user->role === 'curator' ? 'bg-purple-500/10 text-purple-400 border-purple-500/20' : 'bg-blue-500/10 text-blue-400 border-blue-500/20') }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->status === 'active')
                                        <span class="flex items-center gap-2 text-green-400 text-xs font-bold uppercase"><span class="w-2 h-2 rounded-full bg-green-500"></span> Active</span>
                                    @elseif($user->status === 'pending')
                                        <span class="flex items-center gap-2 text-yellow-400 text-xs font-bold uppercase"><span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span> Pending</span>
                                    @else
                                        <span class="text-red-400 text-xs font-bold uppercase">Banned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    @if($user->role === 'curator' && $user->status === 'pending')
                                        <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="inline-block">
                                            @csrf @method('PATCH')
                                            <button class="px-3 py-1.5 bg-green-600 hover:bg-green-500 text-white rounded-lg text-xs font-bold transition">Approve</button>
                                        </form>
                                    @endif
                                    @if($user->role !== 'admin')
                                        <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete User?')">
                                            @csrf @method('DELETE')
                                            <button class="px-3 py-1.5 bg-[#2a2a2a] hover:bg-red-900/50 text-red-400 rounded-lg text-xs font-bold border border-gray-700 hover:border-red-800 transition">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- B. TAMPILAN MOBILE (CARD STACK) --}}
                <div class="md:hidden space-y-4 p-4">
                    @foreach($users as $user)
                    <div class="bg-[#121212] border border-gray-800 rounded-xl p-5 flex flex-col gap-4">
                        {{-- Row 1: User Info --}}
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shrink-0 overflow-hidden">
                                @if($user->avatar) <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover"> @else {{ substr($user->name, 0, 1) }} @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-white font-bold text-lg truncate">{{ $user->name }}</h4>
                                <p class="text-gray-500 text-xs truncate">{{ $user->email }}</p>
                            </div>
                        </div>

                        {{-- Row 2: Badges --}}
                        <div class="flex items-center justify-between border-t border-b border-gray-800 py-3">
                            <div class="flex flex-col">
                                <span class="text-[10px] uppercase text-gray-500 font-bold mb-1">Role</span>
                                <span class="text-xs font-bold uppercase {{ $user->role === 'admin' ? 'text-red-400' : ($user->role === 'curator' ? 'text-purple-400' : 'text-blue-400') }}">
                                    {{ $user->role }}
                                </span>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-[10px] uppercase text-gray-500 font-bold mb-1">Status</span>
                                @if($user->status === 'active')
                                    <span class="text-green-400 text-xs font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active</span>
                                @elseif($user->status === 'pending')
                                    <span class="text-yellow-400 text-xs font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Pending</span>
                                @else
                                    <span class="text-red-400 text-xs font-bold">Banned</span>
                                @endif
                            </div>
                        </div>

                        {{-- Row 3: Actions --}}
                        <div class="flex gap-3">
                            @if($user->role === 'curator' && $user->status === 'pending')
                                <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="flex-1">
                                    @csrf @method('PATCH')
                                    <button class="w-full py-2.5 bg-green-600 hover:bg-green-500 text-white rounded-lg text-sm font-bold">Approve</button>
                                </form>
                            @endif
                            @if($user->role !== 'admin')
                                <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete User?')">
                                    @csrf @method('DELETE')
                                    <button class="w-full py-2.5 bg-[#252525] text-red-400 border border-gray-700 rounded-lg text-sm font-bold hover:bg-red-900/20">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="p-6 border-t border-gray-800 bg-[#1e1e1e]">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>