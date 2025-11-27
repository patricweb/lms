<nav class="bg-[#182023] border-b border-gray-700">
    <div class="container mx-auto px-4">
        <div class="hidden md:flex justify-center items-center space-x-10 lg:space-x-16 py-5">
            <a wire:navigate href="{{ route('features') }}" class="text-gray-300 hover:text-emerald-400 text-lg font-medium transition">
                Features
            </a>
            @if (auth()->check() && auth()->user()->role === 'admin')
            <a wire:navigate href="{{ route('admin') }}" class="text-gray-300 hover:text-emerald-400 text-lg font-medium transition">
                Admin
            </a>
            @endif
            @auth
            <a wire:navigate href="{{ route('courses') }}" class="text-gray-300 hover:text-emerald-400 text-lg font-medium transition">
                Courses
            </a>
            @endauth
            <a wire:navigate href="{{ route('contacts') }}" class="text-gray-300 hover:text-emerald-400 text-lg font-medium transition">
                Contact
            </a>
        </div>
        <div class="md:hidden flex flex-col items-center space-y-5 py-6">
            <a wire:navigate href="{{ route('features') }}" class="text-gray-300 hover:text-emerald-400 text-base font-medium transition">
                Features
            </a>
            @if (auth()->check() && auth()->user()->role === 'admin')
            <a wire:navigate href="{{ route('admin') }}" class="text-gray-300 hover:text-emerald-400 text-base font-medium transition">
                Admin
            </a>
            @endif
            @auth
            <a wire:navigate href="{{ route('courses') }}" class="text-gray-300 hover:text-emerald-400 text-base font-medium transition">
                Courses
            </a>
            @endauth
            <a wire:navigate href="{{ route('contacts') }}" class="text-gray-300 hover:text-emerald-400 text-base font-medium transition">
                Contact
            </a>
        </div>
    </div>
</nav>