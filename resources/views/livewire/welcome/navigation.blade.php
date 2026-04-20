<div class="flex flex-row justify-between w-full sm:fixed sm:top-0 sm:left-0 p-6 z-10 text-xs sm:text-base">
     
    @auth
    <div>
        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm ">Dashboard</a>
    </div>
        
    @else
    <div class="flex justify-start gap-4">
        <a href="{{ route('welcome') }}" class="text-xs sm:text-base font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm " >Home</a>
        <a href="{{ route('aboutus') }}" class="text-xs sm:text-base font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm " >About us</a>
        <a href="{{ route('repository') }}" class="text-xs sm:text-base font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm ">Repository</a>
    </div>    
    <div class="flex flex-row gap-4">
        <a href="{{ route('login') }}" class="text-xs sm:text-base font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm " >Log in</a>
    @if (Route::has('register'))
 
        <a href="{{ route('register') }}" class="text-xs sm:text-base ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm  ">Register</a>
    </div>
           
    @endif
    @endauth
</div>
