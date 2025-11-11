@extends("layout")

@section("main")
    <!-- Hero Section -->
    <section class="relative bg-[#182023] py-20 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-size-[60px_60px]"></div>
        <div class="container mx-auto px-4 relative">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Hero title: primary color used for the text (sparing) -->
                <h1 class="text-5xl md:text-6xl font-bold mb-6 text-[#7cdebe] leading-tight">
                    Transform Your Learning Journey
                </h1>

                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Discover the future of education with our modern LMS platform. Engage, learn, and grow with interactive courses powered by cutting-edge technology.
                </p>

                <!-- Stats (primary applied to numbers only) -->
                <div class="grid grid-cols-3 gap-8 mt-16 max-w-2xl mx-auto">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#7cdebe]">10K+</div>
                        <div class="text-gray-400">Students</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#7cdebe]">500+</div>
                        <div class="text-gray-400">Courses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#7cdebe]">98%</div>
                        <div class="text-gray-400">Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-[#182023]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">
                    Why Choose EduLMS?
                </h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                    Everything you need for effective and engaging online learning
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-[#18181b] p-8 rounded-2xl border border-gray-700 hover:border-purple-500 transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3 text-white">Interactive Learning</h3>
                    <p class="text-gray-300 leading-relaxed">Engage with interactive content, real-time quizzes, and instant feedback to maximize your learning potential.</p>
                    <!-- small accent -->
                </div>

                <!-- Feature 2 -->
                <div class="bg-[#18181b] p-8 rounded-2xl border border-gray-700 hover:border-purple-500 transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3 text-white">Expert Instructors</h3>
                    <p class="text-gray-300 leading-relaxed">Learn from industry professionals and experienced educators who are passionate about your success.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-[#18181b] p-8 rounded-2xl border border-gray-700 hover:border-purple-500 transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-semibold mb-3 text-white">Flexible Schedule</h3>
                    <p class="text-gray-300 leading-relaxed">Learn at your own pace with 24/7 access to all courses and materials from any device, anywhere.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="py-20 bg-[#182023]">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">
                    Popular Courses
                </h2>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                    Explore our most sought-after learning paths and boost your career
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    ['title' => 'Web Development', 'price' => '$99', 'color' => 'emerald'],
                    ['title' => 'Data Science', 'price' => '$129', 'color' => 'purple'],
                    ['title' => 'UI/UX Design', 'price' => '$89', 'color' => 'blue'],
                    ['title' => 'Mobile Development', 'price' => '$119', 'color' => 'orange'],
                    ['title' => 'Digital Marketing', 'price' => '$79', 'color' => 'green'],
                    ['title' => 'Cloud Computing', 'price' => '$149', 'color' => 'indigo']
                ] as $course)
                <div class="bg-[#18181b] rounded-2xl overflow-hidden border border-gray-700 hover:border-purple-500 transition-all duration-300 transform hover:-translate-y-2 group">
                    <!-- Верхний блок с большим названием курса -->
                    <div class="h-48 flex items-center justify-center bg-[#1f2937]">
                        <h3 class="text-3xl font-bold text-[#7cdebe] group-hover:text-purple-400 transition-colors duration-300 text-center px-4">
                            {{ $course['title'] }}
                        </h3>
                    </div>

                    <div class="p-6">
                        <p class="text-gray-300 mb-4 leading-relaxed">
                            Master modern technologies and build amazing projects with hands-on experience.
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-[#7cdebe] text-lg font-semibold">{{ $course['price'] }}</span>
                            <a href="#" class="inline-flex items-center gap-2 bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200">
                                Enroll Now
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-[#182023] relative overflow-hidden">
        <div class="absolute inset-0"></div>
        <div class="container mx-auto px-4 text-center relative">
            <h2 class="text-3xl md:text-5xl font-bold mb-6 text-white">
                Ready to Transform Your Future?
            </h2>
            <p class="text-lg text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                Join thousands of students who have already accelerated their careers with EduLMS
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a wire:navigation href="{{ route('register') }}" class="bg-emerald-500 hover:bg-purple-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 transform hover:scale-105 shadow-lg inline-block">
                    Start Learning Today
                </a>
            </div>
        </div>
    </section>
@endsection
