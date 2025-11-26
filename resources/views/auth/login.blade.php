@extends("layout")

@section("main")
<div class="min-h-screen flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-md border border-gray-600 rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-white text-center mb-6">Login</h1>

        @if(session('error'))
            <div class="bg-red-500 text-white px-4 py-2 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('loginPost') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-gray-300 mb-1" for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email"
                       value="{{ old('email') }}"
                       class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none
                              focus:ring-2 focus:ring-emerald-500 transition">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-300 mb-1" for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password"
                       class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none
                              focus:ring-2 focus:ring-emerald-500 transition">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="accent-emerald-500">
                <label for="remember" class="text-gray-300 text-sm">Remember me</label>
            </div>

            <button type="submit"
                    class="w-full py-3 bg-emerald-500 text-black font-semibold rounded-xl hover:bg-emerald-600
                           transition mt-3">
                Login
            </button>
        </form>

        <p class="text-gray-400 text-sm text-center mt-4">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-emerald-500 hover:underline">Register</a>
        </p>
    </div>
</div>
@endsection
