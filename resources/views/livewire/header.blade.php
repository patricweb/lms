<header class="bg-[#182023] border-b border-gray-700 sticky top-0 z-50" x-data="{ open: false }">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ route('landing') }}" class="flex items-center space-x-3 no-underline">
            <h1 class="text-2xl text-emerald-400"><span class='font-bold'>EduLMS</span> <small class="text-gray-400 text-sm">made by Matei Patric</small></h1>
        </a>
        <nav class="hidden md:flex items-center space-x-6">
            @auth
                <a href="{{ route('profile') }}" class="flex items-center space-x-2 text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium">
                        <div class="w-9 h-9 bg-gray-800 rounded-2xl flex items-center justify-center text-white text-sm font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    <span>Account</span>
                </a>
                <a href="{{ route('logout') }}" class="text-gray-300 hover:text-purple-500 transition-colors duration-200 font-medium">
                    Logout
                </a>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium px-4 py-2">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-medium px-6 py-2 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                    Get Started Free
                </a>
            @endguest
        </nav>
        <button @click="open = !open" class="md:hidden flex items-center text-gray-300 focus:outline-none">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <div x-show="open" x-transition class="md:hidden bg-[#182023] border-t border-gray-700">
        <div class="px-4 py-4 space-y-3 flex flex-col">
            @auth
                <a href="{{ route('profile') }}" class="flex items-center space-x-2 text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-2xl object-cover">
                    @else
                        <div class="w-8 h-8 bg-gray-800 rounded-2xl flex items-center justify-center text-white text-sm font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                    <span>Account</span>
                </a>
                <a href="{{ route('logout') }}" class="text-gray-300 hover:text-purple-500 transition-colors duration-200 font-medium">
                    Logout
                </a>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium">
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-medium px-4 py-2 rounded-lg transition-all duration-200">
                    Get Started Free
                </a>
            @endguest
        </div>
    </div>
</header>
