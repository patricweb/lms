@extends("layout")

@section("main")
    <div class="min-h-screen bg-[#182023] flex items-center justify-center">
        <div class='flex flex-col items-center justify-center'>
            <!-- <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div> -->

                <!-- Text -->
                <h1 class="text-[200px] font-bold text-purple-400 mb-2">403</h1>
                <h2 class="text-[50px] font-bold text-white mb-4">Access Forbidden</h2>
                <p class="text-gray-300 mb-8">
                    You don't have permission to access this resource.
                </p>

                <!-- Action -->
                <a href="{{ route('landing') }}" 
                   class="bg-purple-500 hover:bg-purple-600 text-center text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 inline-block w-full">
                    Return to Safety
                </a>
            <div class="mt-8 text-gray-500 text-sm">
                Error code: 403_FORBIDDEN
            </div>
        </div>
    </div>
@endsection