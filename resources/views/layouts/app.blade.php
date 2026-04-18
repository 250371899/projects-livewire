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
        @fluxAppearance
    </head>
    <body class="min-h-screen bg-white antialiased ">

    <header class="sticky top-0 z-50 w-full bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
        <livewire:layout.navigation />

    </header>
    {{-- Sidebar --}}
    <flux:sidebar.collapse class="lg:hidden" />
 
    <div class="flex w-full min-h-screen ">
        
    <flux:sidebar sticky collapsible="mobile" class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.header class="mt-8">
  
        </flux:sidebar.header>

        

        <flux:sidebar.nav>
            
            <flux:sidebar.item  icon="pencil-square" href="/new-project" :current="request()->is('new-project')" wire:navigat>Create a new project</flux:sidebar.item>
            <flux:sidebar.item icon="book-open" href="/view-projects" :current="request()->is('view-projects')">View your projects</flux:sidebar.item>
            <flux:sidebar.item icon="globe-alt" href="/search-project" :current="request()->is('search-project')">Search for a project</flux:sidebar.item>

        </flux:sidebar.nav>

        <flux:sidebar.spacer />

        <flux:sidebar.nav>
            <flux:sidebar.item icon="cog-6-tooth" :href="route('profile')">Settings</flux:sidebar.item>
      
        </flux:sidebar.nav>

    
    </flux:sidebar>


        <div class="flex-1 flex-col w-full overflow-hidden">
            <flux:main>
                <div class="mx-auto w-full max-width"> 
                         {{-- Messages for the users --}}
                        <div
                            x-cloak 
                            x-data="{ show: false, message: '' }" 
                            x-on:user-message.window="show = true; message = $event.detail.message"
                            x-show="show">
                                    <flux:callout icon="bell" color="green">    
                                    
                                        <flux:callout.text x-text="message"></flux:callout.text>
                                        <x-slot name="controls">        
                                            <flux:button icon="x-mark" variant="ghost" x-on:click="show = false" />    
                                        </x-slot>  
                                    </flux:callout>
                        </div>

                        <div x-data="{ show: false, error: '' }" 
                            x-on:user-error.window="show = true; error = $event.detail.message"
                            x-show="show" 
                           x-cloak>
                                    <flux:callout icon="bell" color="red">    
                                        <flux:callout.heading>Error</flux:callout.heading>
                                        <flux:callout.text x-text="error"></flux:callout.text>
                                        <x-slot name="controls">        
                                            <flux:button icon="x-mark" variant="ghost" x-on:click="show = false" />    
                                        </x-slot>  
                                    </flux:callout>
                        </div>
                        <br>
                        {{-- where pages components gets loaded into --}}
                        <div class=" bg-white dark:bg-gray-800">
                            {{ $slot }}
                        </div>
                  
                </div>
            </flux:main>
        </div>
     </div>
        @livewireScripts 
        @fluxScripts
        @livewireChartsScripts
     </body>
</html>
