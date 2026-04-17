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
            @if (Route::has('login'))
                <livewire:welcome.navigation />
            @endif
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white-100 dark:bg-gray-900">
            <div>
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-white-500" />
                </a>
            </div>
            {{-- show the correct width of the box for about and repository and another for login and signup --}}
            @if (request()->is('login') || request()->is('register'))
                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            @else
                <div class="w-full mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            @endif

                {{ $slot }}
            </div>
        </div>
    <!--footer-->
    <footer class="bg-body-tertiary text-center fixed-bottom">
        <div class="text-center p-3" style="background-color: black; color: white;">
            © 2026 Version 1.0
        </div>
    </footer>
            @livewireScripts 
        @fluxScripts
    </body>

</html>
