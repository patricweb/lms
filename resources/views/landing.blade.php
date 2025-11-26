@extends("layout")

@section("main")
    <section class="relative bg-[#182023] py-20 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-size-[60px_60px]"></div>
        <div class="container mx-auto px-4 relative">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 text-white leading-tight">
                    Transform Your Learning Journey
                </h1>

                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Discover the future of education with our modern LMS platform. Engage, learn, and grow with interactive courses powered by cutting-edge technology.
                </p>
            </div>
        </div>
    </section>

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
            
            <div class="max-w-4xl mx-auto">
                <div class="prose prose-lg prose-invert text-center">
                    <p class="text-xl text-gray-300 leading-relaxed mb-12">
                        EduLMS offers a comprehensive learning management solution designed to meet the needs of modern education. 
                        Our platform combines cutting-edge technology with user-friendly features to create an exceptional learning experience.
                    </p>
                    
                    <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
                        <div class="space-y-4 text-center md:text-left">
                            <h3 class="text-2xl font-semibold text-white mb-6">Key Benefits</h3>
                            <ul class="text-gray-300 space-y-4">
                                <li class="flex items-center md:justify-start justify-center">
                                    <span class="text-purple-500 mr-3 text-lg">-</span>
                                    <span>Interactive learning with real-time engagement</span>
                                </li>
                                <li class="flex items-center md:justify-start justify-center">
                                    <span class="text-purple-500 mr-3 text-lg">-</span>
                                    <span>Expert instructors and comprehensive courses</span>
                                </li>
                                <li class="flex items-center md:justify-start justify-center">
                                    <span class="text-purple-500 mr-3 text-lg">-</span>
                                    <span>Flexible scheduling and self-paced learning</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="space-y-4 text-center md:text-left">
                            <h3 class="text-2xl font-semibold text-white mb-6">What You Get</h3>
                            <ul class="text-gray-300 space-y-4">
                                <li class="flex items-center md:justify-start justify-center">
                                    <span class="text-purple-500 mr-3 text-lg">-</span>
                                    <span>24/7 access from any device</span>
                                </li>
                                <li class="flex items-center md:justify-start justify-center">
                                    <span class="text-purple-500 mr-3 text-lg">-</span>
                                    <span>Progress tracking and analytics</span>
                                </li>
                                <li class="flex items-center md:justify-start justify-center">
                                    <span class="text-purple-500 mr-3 text-lg">-</span>
                                    <span>Collaborative learning tools</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <p class="text-lg text-gray-300 mt-12 leading-relaxed">
                        Join thousands of satisfied learners who have transformed their educational journey with EduLMS. 
                        Start your learning experience today and discover the difference.
                    </p>
                </div>
            </div>
        </div>
    </section>

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
                <a wire:navigation href="{{ route('register') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-200 transform hover:scale-105 shadow-lg inline-block">
                    Start Learning Today
                </a>
            </div>
        </div>
    </section>
@endsection
