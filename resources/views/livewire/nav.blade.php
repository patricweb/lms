<nav class="bg-[#182023] border-b border-gray-700 backdrop-blur-sm bg-opacity-90">
    <div class="container mx-auto px-4">
        <div class="flex justify-center space-x-18 py-4">
            <a wire:navigation href="{{ route('features') }}" class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium py-2 hover:border-emerald-400">
                Features
            </a>
            @auth
                <a wire:navigation href="{{ route('courses') }}" class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium py-2 hover:border-emerald-400">
                    Courses
                </a>
            @endauth
            <a wire:navigation href="{{ route('pricing') }}" class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium py-2 hover:border-emerald-400">
                Pricing
            </a>
            <a wire:navigation href="{{ route('about') }}" class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium py-2 hover:border-emerald-400">
                About
            </a>
            <a wire:navigation href="{{ route('contacts') }}" class="text-gray-300 hover:text-emerald-400 transition-colors duration-200 font-medium py-2 hover:border-emerald-400">
                Contact
            </a>
        </div>
    </div>
</nav>