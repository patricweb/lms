<nav class="bg-black/90 backdrop-blur-sm border-b border-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="hidden md:flex justify-center items-center space-x-1 py-4">
            <a wire:navigate href="{{ route('features') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all duration-200">
                Возможности
            </a>
            @auth
                <a wire:navigate href="{{ route('courses') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all duration-200">
                    Каталог курсов
                </a>
                @if($user->role === 'teacher' || $user->role === 'admin')
                    <a wire:navigate href="{{ route('createCourse') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all duration-200">
                        Создать курс
                    </a>
                @endif
                @if($user->role === 'admin')
                    <a wire:navigate href="{{ route('admin') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all duration-200">
                        Админ-панель
                    </a>
                @endif
            @endauth
            <a wire:navigate href="{{ route('contacts') }}" class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all duration-200">
                Контакты
            </a>
        </div>
        <div class="md:hidden flex flex-wrap justify-center items-center gap-2 py-4">
            <a wire:navigate href="{{ route('features') }}" class="px-3 py-1.5 text-xs font-medium text-gray-500 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all">
                Возможности
            </a>
            @auth
                <a wire:navigate href="{{ route('courses') }}" class="px-3 py-1.5 text-xs font-medium text-gray-500 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all">
                    Курсы
                </a>
                @if($user->role === 'teacher' || $user->role === 'admin')
                    <a wire:navigate href="{{ route('createCourse') }}" class="px-3 py-1.5 text-xs font-medium text-gray-500 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all">
                        Создать
                    </a>
                @endif
                @if($user->role === 'admin')
                    <a wire:navigate href="{{ route('admin') }}" class="px-3 py-1.5 text-xs font-medium text-gray-500 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all">
                        Админ
                    </a>
                @endif
            @endauth
            <a wire:navigate href="{{ route('contacts') }}" class="px-3 py-1.5 text-xs font-medium text-gray-500 hover:text-violet-400 hover:bg-gray-900 rounded-lg transition-all">
                Контакты
            </a>
        </div>
    </div>
</nav>
