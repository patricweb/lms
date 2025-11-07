<header class="bg-[#182023] border-b border-gray-700 sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 no-underline">
                    <div class="w-10 h-10 bg-[#3acf9e] rounded-lg flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-[#e2e2e2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6l9-5m-9 5l-9-5m9 5v-6"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-[#7cdebe] bg-clip-text text-transparent">
                            EduLMS
                        </h1>
                        <p class="text-xs text-gray-400">by Matei Patric</p>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav>
                <ul class="flex items-center space-x-6">
                    @auth
                        <li>
                            <a class="flex items-center space-x-2 text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium group" href="{{ route('profile') }}">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Account</span>
                            </a>
                        </li>
                        <li>
                            <a class="flex items-center space-x-2 text-gray-300 hover:text-orange-400 transition-colors duration-200 font-medium group" href="{{ route('logout') }}">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Logout</span>
                            </a>
                        </li>
                    @endauth
                    @guest
                        <li>
                            <a class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium px-4 py-2" href="{{ route('login') }}">
                                Sign In
                            </a>
                        </li>
                        <li>
                            <a class="bg-emerald-500 hover:bg-emerald-600 text-white font-medium px-6 py-2 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25" href="{{ route('register') }}">
                                Get Started Free
                            </a>
                        </li>
                    @endguest
                </ul>
            </nav>
        </div>
    </div>
</header>