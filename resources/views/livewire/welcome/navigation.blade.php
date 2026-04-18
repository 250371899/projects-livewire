<div class="flex flex-row justify-between w-full sm:fixed sm:top-0 sm:left-0 p-6 z-10 text-xs sm:text-base">
     
    @auth
    <div>
        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Dashboard</a>
    </div>
        
    @else
    <div class="flex justify-start gap-4">
        <a href="{{ route('home') }}" class="text-xs sm:text-base font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Home</a>
        <a href="{{ route('aboutus') }}" class="text-xs sm:text-base font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>About us</a>
        <a href="{{ route('repository') }}" class="text-xs sm:text-base font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Repository</a>
    </div>    
    <div class="flex flex-row gap-4">
        <a href="{{ route('login') }}" class="text-xs sm:text-base font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Log in</a>
    @if (Route::has('register'))
 
        <a href="{{ route('register') }}" class="text-xs sm:text-base ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Register</a>
    </div>
           
    @endif
    @endauth
</div>
