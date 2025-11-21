@extends("layout")

@section("main")
<div class="min-h-screen bg-[#182023] py-8">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="bg-[#18181b] rounded-2xl p-8 mb-8 border border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <!-- Avatar -->
                    <div class="relative">
                        <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-emerald-400 rounded-2xl flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full border-4 border-[#18181b] flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 16l-5-5 1.41-1.41L10 13.17l7.59-7.59L19 7l-9 9z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- User Info -->
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">{{ auth()->user()->name }}</h1>
                        <div class="flex items-center gap-4 text-gray-300">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#7cdebe]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="capitalize">{{ auth()->user()->role }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#7cdebe]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Edit Profile Button -->
                <button class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Profile
                </button>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Enrolled Courses -->
            <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700 hover:border-purple-500 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Enrolled Courses</p>
                        <p class="text-2xl font-bold text-white">12</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Courses -->
            <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700 hover:border-purple-500 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Completed</p>
                        <p class="text-2xl font-bold text-white">8</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Hours Learned -->
            <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700 hover:border-purple-500 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Hours Learned</p>
                        <p class="text-2xl font-bold text-white">156</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Current Streak -->
            <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700 hover:border-purple-500 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Current Streak</p>
                        <p class="text-2xl font-bold text-white">14 days</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Active Courses -->
                <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-white">Active Courses</h2>
                        <a href="{{ route('courses') }}" class="text-[#7cdebe] hover:text-emerald-400 transition-colors duration-200 text-sm font-medium">
                            View All
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach([
                            ['title' => 'Advanced Web Development', 'progress' => 75, 'category' => 'Programming'],
                            ['title' => 'Data Science Fundamentals', 'progress' => 45, 'category' => 'Data Science'],
                            ['title' => 'UI/UX Design Masterclass', 'progress' => 90, 'category' => 'Design']
                        ] as $course)
                        <div class="bg-[#182023] rounded-xl p-4 border border-gray-700 hover:border-[#7cdebe] transition-all duration-300">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-semibold text-white">{{ $course['title'] }}</h3>
                                <span class="text-sm text-gray-400">{{ $course['category'] }}</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2 mb-2">
                                <div class="bg-[#7cdebe] h-2 rounded-full transition-all duration-300" style="width: {{ $course['progress'] }}%"></div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400">{{ $course['progress'] }}% completed</span>
                                <button class="text-[#7cdebe] hover:text-emerald-400 text-sm font-medium transition-colors duration-200">
                                    Continue
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700">
                    <h2 class="text-2xl font-bold text-white mb-6">Recent Activity</h2>
                    
                    <div class="space-y-4">
                        @foreach([
                            ['action' => 'completed', 'course' => 'Web Development', 'time' => '2 hours ago', 'icon' => 'check'],
                            ['action' => 'started', 'course' => 'Data Science', 'time' => '1 day ago', 'icon' => 'play'],
                            ['action' => 'earned', 'course' => 'Certificate', 'time' => '2 days ago', 'icon' => 'trophy'],
                            ['action' => 'commented', 'course' => 'UI/UX Discussion', 'time' => '3 days ago', 'icon' => 'message']
                        ] as $activity)
                        <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-[#182023] transition-all duration-200">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($activity['icon'] === 'check')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    @elseif($activity['icon'] === 'play')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    @elseif($activity['icon'] === 'trophy')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    @endif
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-medium">
                                    {{ ucfirst($activity['action']) }} <span class="text-[#7cdebe]">{{ $activity['course'] }}</span>
                                </p>
                                <p class="text-gray-400 text-sm">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700">
                    <h2 class="text-2xl font-bold text-white mb-6">Quick Actions</h2>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('courses') }}" class="bg-[#182023] hover:bg-purple-500 rounded-xl p-4 text-center transition-all duration-300 group border border-gray-700 hover:border-purple-500">
                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-white transition-colors duration-300">
                                <svg class="w-6 h-6 text-white group-hover:text-purple-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <span class="text-white font-medium text-sm">Browse Courses</span>
                        </a>

                        <a href="#" class="bg-[#182023] hover:bg-emerald-500 rounded-xl p-4 text-center transition-all duration-300 group border border-gray-700 hover:border-emerald-500">
                            <div class="w-12 h-12 bg-emerald-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-white transition-colors duration-300">
                                <svg class="w-6 h-6 text-white group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-white font-medium text-sm">Certificates</span>
                        </a>

                        <a href="#" class="bg-[#182023] hover:bg-blue-500 rounded-xl p-4 text-center transition-all duration-300 group border border-gray-700 hover:border-blue-500">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-white transition-colors duration-300">
                                <svg class="w-6 h-6 text-white group-hover:text-blue-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span class="text-white font-medium text-sm">Profile</span>
                        </a>

                        <a href="#" class="bg-[#182023] hover:bg-orange-500 rounded-xl p-4 text-center transition-all duration-300 group border border-gray-700 hover:border-orange-500">
                            <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mx-auto mb-2 group-hover:bg-white transition-colors duration-300">
                                <svg class="w-6 h-6 text-white group-hover:text-orange-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <span class="text-white font-medium text-sm">Settings</span>
                        </a>
                    </div>
                </div>

                <!-- Achievements -->
                <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700">
                    <h2 class="text-2xl font-bold text-white mb-6">Achievements</h2>
                    
                    <div class="grid grid-cols-3 gap-4">
                        @foreach([
                            ['name' => 'Fast Learner', 'icon' => '⚡', 'locked' => false],
                            ['name' => 'Perfect Score', 'icon' => '🎯', 'locked' => false],
                            ['name' => 'Marathon', 'icon' => '🏃', 'locked' => true],
                            ['name' => 'Scholar', 'icon' => '📚', 'locked' => false],
                            ['name' => 'Early Bird', 'icon' => '🌅', 'locked' => true],
                            ['name' => 'Master', 'icon' => '👑', 'locked' => true]
                        ] as $achievement)
                        <div class="text-center group">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-2 
                                {{ $achievement['locked'] ? 'bg-gray-700 text-gray-500' : 'bg-gradient-to-br from-purple-500 to-emerald-400 text-white' }}">
                                <span class="text-2xl">{{ $achievement['icon'] }}</span>
                            </div>
                            <p class="text-sm font-medium {{ $achievement['locked'] ? 'text-gray-500' : 'text-white' }}">
                                {{ $achievement['name'] }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection