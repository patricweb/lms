{{-- contact.blade.php --}}
@extends("layout")

@section("main")
    <!-- Hero Section -->
    <section class="relative bg-[#182023] py-20 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] bg-[size:60px_60px]"></div>
        <div class="container mx-auto px-4 relative">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-[#7cdebe] bg-clip-text text-transparent leading-tight">
                    Get In Touch
                </h1>
                <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-20 bg-[#182023]">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Contact Info -->
                <div>
                    <h2 class="text-3xl font-bold mb-8 text-[#7cdebe]">Contact Information</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-[#7cdebe] rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-1">Address</h3>
                                <p class="text-gray-300">123 Education Street<br>Learning City, LC 12345</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-[#7cdebe] rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-1">Phone</h3>
                                <p class="text-gray-300">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-[#7cdebe] rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-1">Email</h3>
                                <p class="text-gray-300">support@edulms.com<br>info@edulms.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 p-6 bg-[#18181b] rounded-2xl border border-gray-700">
                        <h3 class="text-lg font-semibold text-white mb-3">Support Hours</h3>
                        <p class="text-gray-300">Monday - Friday: 9:00 AM - 6:00 PM EST<br>
                        Saturday: 10:00 AM - 4:00 PM EST<br>
                        Sunday: Closed</p>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-[#18181b] p-8 rounded-2xl border border-gray-700">
                    <h2 class="text-3xl font-bold mb-6 text-[#7cdebe]">Send us a Message</h2>
                    <form class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-white mb-2">First Name</label>
                                <input type="text" class="w-full bg-[#182023] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#7cdebe] focus:outline-none transition-colors duration-200">
                            </div>
                            <div>
                                <label class="block text-white mb-2">Last Name</label>
                                <input type="text" class="w-full bg-[#182023] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#7cdebe] focus:outline-none transition-colors duration-200">
                            </div>
                        </div>
                        <div>
                            <label class="block text-white mb-2">Email</label>
                            <input type="email" class="w-full bg-[#182023] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#7cdebe] focus:outline-none transition-colors duration-200">
                        </div>
                        <div>
                            <label class="block text-white mb-2">Subject</label>
                            <input type="text" class="w-full bg-[#182023] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#7cdebe] focus:outline-none transition-colors duration-200">
                        </div>
                        <div>
                            <label class="block text-white mb-2">Message</label>
                            <textarea rows="5" class="w-full bg-[#182023] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-[#7cdebe] focus:outline-none transition-colors duration-200"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-[#7cdebe] text-[#182023] py-4 rounded-xl font-bold text-lg hover:bg-[#6cccad] transition-all duration-200 transform hover:scale-105">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection