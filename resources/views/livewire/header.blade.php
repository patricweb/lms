<header class="bg-black/95 backdrop-blur-xl border-b border-gray-900 sticky top-0 z-50 shadow-2xl" x-data="{ open: false }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Logo -->
            <a href="{{ route('landing') }}" class="flex items-center space-x-3 no-underline group">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-violet-600 to-purple-600 rounded-xl blur opacity-70 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative bg-gradient-to-r from-violet-600 to-purple-600 p-2.5 rounded-xl shadow-lg shadow-violet-500/30">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold bg-gradient-to-r from-violet-400 to-purple-400 bg-clip-text text-transparent">
                        EduLMS
                    </h1>
                    <p class="text-xs text-gray-500 hidden sm:block">Обучение нового поколения</p>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-1">
                @auth
                    <a href="{{ route('courses') }}" class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all duration-200">
                        Курсы
                    </a>
                    <a href="{{ route('certificates.index') }}" class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all duration-200">
                        Сертификаты
                    </a>
                    <div class="h-6 w-px bg-gray-800 mx-2"></div>
                    <a href="{{ route('profile') }}" class="flex items-center space-x-2 px-3 py-2 text-gray-400 hover:bg-gray-900 rounded-lg transition-all duration-200 group">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-lg object-cover ring-2 ring-gray-800 group-hover:ring-violet-500 transition-all">
                        @else
                            <div class="w-8 h-8 bg-gradient-to-br from-violet-600 to-purple-600 rounded-lg flex items-center justify-center text-white text-sm font-bold ring-2 ring-gray-800 group-hover:ring-violet-500 transition-all shadow-lg shadow-violet-500/30">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-sm font-medium hidden lg:block">{{ $user->name }}</span>
                    </a>
                    <a href="{{ route('logout') }}" class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-red-400 hover:bg-red-950/20 rounded-lg transition-all duration-200">
                        Выйти
                    </a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all duration-200">
                        Войти
                    </a>
                    <a href="{{ route('register') }}" class="ml-2 px-5 py-2 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg shadow-violet-500/50 hover:shadow-violet-500/70">
                        Начать бесплатно
                    </a>
                @endguest
            </nav>

            <!-- Mobile Menu Button -->
            <button @click="open = !open" class="md:hidden p-2 rounded-lg text-gray-400 hover:bg-gray-900 focus:outline-none transition-colors">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="md:hidden pb-4 border-t border-gray-900 mt-4 pt-4">
            <div class="flex flex-col space-y-2">
                @auth
                    <a href="{{ route('courses') }}" class="px-4 py-2 text-base font-medium text-gray-400 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all">
                        Курсы
                    </a>
                    <a href="{{ route('certificates.index') }}" class="px-4 py-2 text-base font-medium text-gray-400 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all">
                        Сертификаты
                    </a>
                    <a href="{{ route('profile') }}" class="flex items-center space-x-3 px-4 py-2 text-base font-medium text-gray-400 hover:bg-gray-900 rounded-lg transition-all">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-violet-600 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold shadow-lg shadow-violet-500/30">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <span>{{ $user->name }}</span>
                    </a>
                    <a href="{{ route('logout') }}" class="px-4 py-2 text-base font-medium text-red-400 hover:bg-red-950/20 rounded-lg transition-all">
                        Выйти
                    </a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="px-4 py-2 text-base font-medium text-gray-400 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all">
                        Войти
                    </a>
                    <a href="{{ route('register') }}" class="mx-4 px-4 py-2 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-medium rounded-lg transition-all text-center shadow-lg shadow-violet-500/50">
                        Начать бесплатно
                    </a>
                @endguest
            </div>
        </div>
    </div>
</header>
