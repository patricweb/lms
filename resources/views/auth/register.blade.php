@extends("layout")

@section("main")
    <div class="min-h-screen flex items-center justify-center py-10 px-4">
        <div class="w-full max-w-md border border-gray-600 rounded-2xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-white text-center mb-6">Register</h1>
            <form method="POST" action="{{ route('registerPost') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-gray-300 mb-1" for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Name" value="{{ old('name') }}" class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-300 mb-1" for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-300 mb-1" for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password" class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-300 mb-1" for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full py-3 bg-emerald-500 text-black font-semibold rounded-xl hover:bg-emerald-600 transition mt-3">
                    Register
                </button>
            </form>
            <p class="text-gray-400 text-sm text-center mt-4">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-emerald-500 hover:underline">Login</a>
            </p>
        </div>
    </div>
@endsection
