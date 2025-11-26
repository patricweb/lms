@extends("layout")

@section("main")
    <div class="min-h-screen bg-[#182023] flex items-center justify-center">
        <div class='flex flex-col items-center justify-center'>
                <h1 class="text-[200px] font-bold text-red-400 mb-2">404</h1>
                <h2 class="text-[50px] font-bold text-white mb-4">Page Not Found</h2>
                <p class="text-gray-300 mb-8">
                    This page doesn't exists
                </p>
                <a href="{{ route('landing') }}" class="bg-emerald-500 hover:bg-emerald-600 text-center text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 inline-block w-full">
                    Return to Main Page
                </a>
        </div>
    </div>
@endsection