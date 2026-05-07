<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen w-full flex flex-col justify-center items-center py-6 relative overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="/images/logos/fondoLogin.jpg" class="w-full h-full object-cover" alt="Background">
                <div class="absolute inset-0 bg-black/20"></div>
            </div>
            <div class="relative z-10 w-full flex flex-col items-center">
                <div class="flex justify-center mb-6"> 
                    <a href="/">
                        <img src="/images/logos/LogoBlancoSinFondo.png" alt="Logo Parser.IO" class="w-64 h-auto drop-shadow-2xl"/>
                    </a>
                </div>
                <div class="w-full sm:max-w-md px-8 py-10 bg-white/10 backdrop-blur-xl border border-white/40 shadow-2xl rounded-3xl">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
