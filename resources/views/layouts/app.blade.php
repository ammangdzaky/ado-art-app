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
        <style>
            @keyframes scroll {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); } /* Bergerak setengah karena kita menduplikasi konten */
            }

            .animate-marquee {
                display: flex;
                width: max-content;
                animation: scroll 30s linear infinite; /* Kecepatan animasi 30 detik */
            }

            .marquee-container:hover .animate-marquee {
                animation-play-state: paused;
            }

            .hide-scroll::-webkit-scrollbar {
                display: none;
            }
            .hide-scroll {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            
            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>