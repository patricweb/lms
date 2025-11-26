<nav class="bg-[#182023] border-b border-gray-700 backdrop-blur-sm bg-opacity-90">
    <div class="container mx-auto px-4">
        <div class="flex justify-center space-x-18 py-4">
            <a wire:navigate href="{{ route('features') }}" class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium py-2 hover:border-emerald-400">
                Features
            </a>
            @if($user->role === 'admin')
                <a wire:navigate href="{{ route('admin') }}" class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium py-2 hover:border-emerald-400">
                    Admin
                </a>
            @endif
            @auth
                <a wire:navigate href="{{ route('courses') }}" class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium py-2 hover:border-emerald-400">
                    Courses
                </a>
            @endauth
            <a wire:navigate href="{{ route('contacts') }}" class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium py-2 hover:border-emerald-400">
                Contact
            </a>
        </div>
    </div>
</nav>