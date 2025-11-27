@extends("layout")

@section("main")
    <section class="relative bg-[#182023] py-16 sm:py-20 lg:py-28 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-size[length:60px_60px]"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6 text-white leading-tight">
                    Transform Your Learning Journey
                </h1>
                <p class="text-lg sm:text-xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Discover the future of education with our modern LMS platform. Engage, learn, and grow with interactive courses powered by cutting-edge technology.
                </p>
            </div>
        </div>
    </section>
    <section id="features" class="py-16 sm:py-20 lg:py-24 bg-[#182023]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-16">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-white">
                    Why Choose EduLMS?
                </h2>
                <p class="text-lg sm:text-xl text-gray-300 max-w-2xl mx-auto">
                    Everything you need for effective and engaging online learning
                </p>
            </div>
            <div class="max-w-6xl mx-auto">
                <div class="prose prose-lg prose-invert text-center mb-12 lg:mb-16 px-4">
                    <p class="text-lg sm:text-xl text-gray-300 leading-relaxed">
                        EduLMS offers a comprehensive learning management solution designed to meet the needs of modern education.
                        Our platform combines cutting-edge technology with user-friendly features to create an exceptional learning experience.
                    </p>
                </div>
                <div class="grid md:grid-cols-2 gap-10 lg:gap-16 max-w-5xl mx-auto">
                    <div class="text-center md:text-left space-y-6">
                        <h3 class="text-2xl sm:text-3xl font-semibold text-white">Key Benefits</h3>
                        <ul class="text-gray-300 space-y-5 text-lg">
                            <li class="flex items-start justify-center md:justify-start gap-3">
                                <span class="text-purple-500 mt-1.5 text-xl">•</span>
                                <span>Interactive learning with real-time engagement</span>
                            </li>
                            <li class="flex items-start justify-center md:justify-start gap-3">
                                <span class="text-purple-500 mt-1.5 text-xl">•</span>
                                <span>Expert instructors and comprehensive courses</span>
                            </li>
                            <li class="flex items-start justify-center md:justify-start gap-3">
                                <span class="text-purple-500 mt-1.5 text-xl">•</span>
                                <span>Flexible scheduling and self-paced learning</span>
                            </li>
                        </ul>
                    </div>
                    <div class="text-center md:text-left space-y-6 mt-8 md:mt-0">
                        <h3 class="text-2xl sm:text-3xl font-semibold text-white">What You Get</h3>
                        <ul class="text-gray-300 space-y-5 text-lg">
                            <li class="flex items-start justify-center md:justify-start gap-3">
                                <span class="text-purple-500 mt-1.5 text-xl">•</span>
                                <span>24/7 access from any device</span>
                            </li>
                            <li class="flex items-start justify-center md:justify-start gap-3">
                                <span class="text-purple-500 mt-1.5 text-xl">•</span>
                                <span>Progress tracking and analytics</span>
                            </li>
                            <li class="flex items-start justify-center md:justify-start gap-3">
                                <span class="text-purple-500 mt-1.5 text-xl">•</span>
                                <span>Collaborative learning tools</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="prose prose-lg prose-invert text-center mt-12 lg:mt-16 px-4">
                    <p class="text-lg sm:text-xl text-gray-300 leading-relaxed">
                        Join thousands of satisfied learners who have transformed their educational journey with EduLMS.
                        Start your learning experience today and discover the difference.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 sm:py-20 lg:py-28 bg-[#182023] relative overflow-hidden">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 text-white">
                Ready to Transform Your Future?
            </h2>
            <p class="text-lg sm:text-xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                Join thousands of students who have already accelerated their careers with EduLMS
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a wire:navigate href="{{ route('register') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-10 py-4 rounded-xl font-bold text-lg sm:text-xl transition-all duration-200 transform hover:scale-105 shadow-lg inline-block">
                    Start Learning Today
                </a>
            </div>
        </div>
    </section>
@endsection