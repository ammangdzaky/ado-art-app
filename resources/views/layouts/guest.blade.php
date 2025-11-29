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
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            
            {{-- Logo Section --}}
            <div class="mb-6">
                <a href="/">
                    {{-- Logo kita panggil di sini, ukurannya kita perbesar sedikit --}}
                    <x-application-logo class="w-24 h-auto drop-shadow-xl" />
                </a>
            </div>

            {{-- Card Form Login --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-xl border border-gray-200 dark:border-gray-700">
                {{ $slot }}
            </div>

            {{-- Footer Kecil --}}
            <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} AdoArt. All rights reserved.
            </div>
        </div>
    </body>
</html>