<footer class="bg-[#182023] border-t border-gray-800 py-12">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="md:col-span-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v6l9-5m-9 5l-9-5m9 5v-6"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-emerald-400">EduLMS</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Transforming education through innovative technology and engaging learning experiences. Built with passion by Matei Patric.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-bold mb-4 text-lg">Quick Links</h3>
                <ul class="space-y-3">
                    @foreach(['Features', 'Courses', 'Pricing', 'About', 'Contact'] as $link)
                    <li>
                        <a href="#{{ strtolower($link) }}" class="text-gray-400 hover:text-emerald-400 transition-colors duration-200 text-sm">
                            {{ $link }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="text-white font-bold mb-4 text-lg">Support</h3>
                <ul class="space-y-3">
                    @foreach(['Help Center', 'Contact Us', 'Privacy Policy', 'Terms of Service'] as $link)
                    <li>
                        <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors duration-200 text-sm">
                            {{ $link }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-white font-bold mb-4 text-lg">Contact Info</h3>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>matejtradir@gmail.com</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>+37361080709</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Chisinau, Moldova</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center">
            <p class="text-gray-400 text-sm">
                &copy; 2025 EduLMS. All rights reserved. Coded by Matei Patric
            </p>
        </div>
    </div>
</footer>