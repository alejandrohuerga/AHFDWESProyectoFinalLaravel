<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @livewireStyles
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0a0a0a] text-white">
        <div class="min-h-screen bg-[#0a0a0a] relative">
        
            <div class="relative z-10">
                @include('layouts.navigation')
                @isset($header)
                    <header class="bg-transparent">
                        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                            <div class="text-white">
                                {{ $header }}
                            </div>
                        </div>
                    </header>
                @endisset

                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
        @livewireScripts
        @stack('scripts')
    </body>
</html>