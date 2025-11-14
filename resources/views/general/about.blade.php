{{-- about.blade.php --}}
@extends("layout")

@section("main")
    <!-- Hero Section -->
    <section class="relative bg-[#182023] py-20 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[size:60px_60px]"></div>
        <div class="container mx-auto px-4 relative">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-[#7cdebe] bg-clip-text text-transparent leading-tight">
                    About EduLMS
                </h1>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Revolutionizing education through technology, innovation, and a passion for learning excellence.
                </p>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-20 bg-[#182023]">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-6 text-[#7cdebe]">Our Mission</h2>
                    <p class="text-lg text-gray-300 mb-6 leading-relaxed">
                        At EduLMS, we believe that education should be accessible, engaging, and transformative. 
                        Our mission is to break down barriers to learning by providing a platform that empowers 
                        students and educators worldwide.
                    </p>
                    <p class="text-lg text-gray-300 leading-relaxed">
                        We combine cutting-edge technology with pedagogical expertise to create learning 
                        experiences that are not just effective, but truly inspiring.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-[#18181b] p-6 rounded-2xl border border-gray-700 text-center">
                        <div class="text-3xl font-bold text-[#7cdebe] mb-2">2018</div>
                        <div class="text-gray-400">Founded</div>
                    </div>
                    <div class="bg-[#18181b] p-6 rounded-2xl border border-gray-700 text-center">
                        <div class="text-3xl font-bold text-[#7cdebe] mb-2">50+</div>
                        <div class="text-gray-400">Countries</div>
                    </div>
                    <div class="bg-[#18181b] p-6 rounded-2xl border border-gray-700 text-center">
                        <div class="text-3xl font-bold text-[#7cdebe] mb-2">100+</div>
                        <div class="text-gray-400">Team Members</div>
                    </div>
                    <div class="bg-[#18181b] p-6 rounded-2xl border border-gray-700 text-center">
                        <div class="text-3xl font-bold text-[#7cdebe] mb-2">24/7</div>
                        <div class="text-gray-400">Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-[#182023]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 text-[#7cdebe]">Our Values</h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    The principles that guide everything we do
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-[#18181b] p-8 rounded-2xl border border-gray-700 hover:border-[#7cdebe] transition-all duration-300 group">
                    <div class="w-14 h-14 bg-[#7cdebe] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Accessibility</h3>
                    <p class="text-gray-300 leading-relaxed">Making quality education available to everyone, regardless of location or background.</p>
                </div>

                <div class="bg-[#18181b] p-8 rounded-2xl border border-gray-700 hover:border-[#7cdebe] transition-all duration-300 group">
                    <div class="w-14 h-14 bg-[#7cdebe] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Innovation</h3>
                    <p class="text-gray-300 leading-relaxed">Constantly pushing boundaries to create better learning experiences through technology.</p>
                </div>

                <div class="bg-[#18181b] p-8 rounded-2xl border border-gray-700 hover:border-[#7cdebe] transition-all duration-300 group">
                    <div class="w-14 h-14 bg-[#7cdebe] rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Community</h3>
                    <p class="text-gray-300 leading-relaxed">Building a global network of learners and educators who support each other's growth.</p>
                </div>
            </div>
        </div>
    </section>
@endsection