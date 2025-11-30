<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <linkpreconnect href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0b0b0b] relative overflow-hidden">
            
            {{-- ========================================== --}}
            {{-- TOMBOL KEMBALI KE BERANDA (BACK TO HOME) --}}
            {{-- ========================================== --}}
            <a href="{{ route('home') }}" class="absolute top-6 left-6 z-50 flex items-center gap-3 group text-gray-400 hover:text-white transition duration-300">
                <div class="p-2 rounded-full bg-white/5 border border-white/10 group-hover:bg-indigo-600 group-hover:border-indigo-500 transition shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:-translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </div>
                <span class="text-sm font-bold tracking-wide hidden sm:block opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition duration-300">
                    Back to Home
                </span>
            </a>
            {{-- ========================================== --}}

            {{-- Dekorasi Background --}}
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-900/20 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-900/20 rounded-full blur-[100px] pointer-events-none"></div>

            {{-- Logo Section --}}
            <div class="mb-8 relative z-10">
                <a href="/">
                    <x-application-logo class="w-20 h-auto drop-shadow-2xl" />
                </a>
            </div>

            {{-- Kartu Form --}}
            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-[#1e1e1e] border border-gray-800 shadow-2xl overflow-hidden sm:rounded-2xl relative z-10">
                {{ $slot }}
            </div>
            
            {{-- Footer Copyright --}}
            <div class="mt-8 text-gray-600 text-xs relative z-10">
                &copy; {{ date('Y') }} AdoArt. All rights reserved.
            </div>
        </div>
    </body>
</html>