@extends("layout")

@section("main")
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-20 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[size:60px_60px]"></div>
        <div class="container mx-auto px-4 relative">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-emerald-400 via-green-400 to-purple-500 bg-clip-text text-transparent leading-tight">
                    Transform Your Learning Journey
                </h1>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Discover the future of education with our modern LMS platform. Engage, learn, and grow with interactive courses powered by cutting-edge technology.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('register') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-8 py-4 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25 text-lg">
                        Start Learning Free
                    </a>
                    <a href="#features" class="border-2 border-emerald-400 text-emerald-400 hover:bg-emerald-400 hover:text-white font-bold px-8 py-4 rounded-xl transition-all duration-200 transform hover:scale-105 text-lg">
                        Explore Features
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-8 mt-16 max-w-2xl mx-auto">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-emerald-400">10K+</div>
                        <div class="text-gray-400">Students</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-400">500+</div>
                        <div class="text-gray-400">Courses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-400">98%</div>
                        <div class="text-gray-400">Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent">
                    Why Choose EduLMS?
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Everything you need for effective and engaging online learning
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-900 p-8 rounded-2xl border border-gray-700 hover:border-emerald-400 transition-all duration-300 hover:transform hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-emerald-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Interactive Learning</h3>
                    <p class="text-gray-300 leading-relaxed">Engage with interactive content, real-time quizzes, and instant feedback to maximize your learning potential.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-900 p-8 rounded-2xl border border-gray-700 hover:border-purple-400 transition-all duration-300 hover:transform hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Expert Instructors</h3>
                    <p class="text-gray-300 leading-relaxed">Learn from industry professionals and experienced educators who are passionate about your success.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-900 p-8 rounded-2xl border border-gray-700 hover:border-green-400 transition-all duration-300 hover:transform hover:-translate-y-2 group">
                    <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Flexible Schedule</h3>
                    <p class="text-gray-300 leading-relaxed">Learn at your own pace with 24/7 access to all courses and materials from any device, anywhere.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="py-20 bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-green-400 to-emerald-400 bg-clip-text text-transparent">
                    Popular Courses
                </h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Explore our most sought-after learning paths and boost your career
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach([
                    ['title' => 'Web Development', 'price' => '$99', 'color' => 'emerald', 'gradient' => 'from-emerald-500 to-green-600'],
                    ['title' => 'Data Science', 'price' => '$129', 'color' => 'purple', 'gradient' => 'from-purple-500 to-pink-600'],
                    ['title' => 'UI/UX Design', 'price' => '$89', 'color' => 'blue', 'gradient' => 'from-blue-500 to-cyan-600'],
                    ['title' => 'Mobile Development', 'price' => '$119', 'color' => 'orange', 'gradient' => 'from-orange-500 to-red-600'],
                    ['title' => 'Digital Marketing', 'price' => '$79', 'color' => 'green', 'gradient' => 'from-green-500 to-emerald-600'],
                    ['title' => 'Cloud Computing', 'price' => '$149', 'color' => 'indigo', 'gradient' => 'from-indigo-500 to-purple-600']
                ] as $course)
                <div class="bg-gray-800 rounded-2xl overflow-hidden border border-gray-700 hover:border-{{ $course['color'] }}-400 transition-all duration-300 hover:transform hover:-translate-y-2 group">
                    <div class="h-48 bg-gradient-to-r {{ $course['gradient'] }}"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-white group-hover:text-{{ $course['color'] }}-400 transition-colors duration-300">
                            {{ $course['title'] }}
                        </h3>
                        <p class="text-gray-300 mb-4 leading-relaxed">Master modern technologies and build amazing projects with hands-on experience.</p>
                        <div class="flex justify-between items-center">
                            <span class="text-{{ $course['color'] }}-400 font-bold text-lg">{{ $course['price'] }}</span>
                            <a href="#" class="text-{{ $course['color'] }}-400 hover:text-{{ $course['color'] }}-300 font-medium transition-colors duration-200">
                                Enroll Now →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-emerald-600 via-green-600 to-purple-600 relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="container mx-auto px-4 text-center relative">
            <h2 class="text-4xl md:text-6xl font-bold mb-6 text-white">
                Ready to Transform Your Future?
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto leading-relaxed">
                Join thousands of students who have already accelerated their careers with EduLMS
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-emerald-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-2xl inline-block">
                    Start Learning Today
                </a>
                <a href="#courses" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-emerald-600 transition-all duration-200 transform hover:scale-105 inline-block">
                    Browse Courses
                </a>
            </div>
        </div>
    </section>
@endsection