@extends("layout")
@section("main")
<div class="min-h-screen bg-[#182023] py-8">
    <div class="container mx-auto px-4">
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-xl mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif
        <!-- User Header -->
        <div class="bg-[#18181b] rounded-2xl p-8 mb-8 border border-gray-700">
            @if($editMode)
                <form action="{{ route('profileUpdate') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <!-- Avatar Edit -->
                            <div class="relative">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-2xl object-cover">
                                @else
                                    <div class="w-24 h-24 bg-gray-800 rounded-2xl flex items-center justify-center text-white text-2xl font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <label for="avatar" class="absolute -bottom-2 -right-2 bg-purple-500 p-2 rounded-full cursor-pointer hover:bg-purple-600 transition-colors">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </label>
                                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                                @error('avatar')
                                    <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- User Info Edit -->
                            <div class="flex-1">
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       class="bg-transparent border-b border-gray-600 text-white text-3xl font-bold w-full focus:outline-none focus:border-purple-500 transition-colors" 
                                       required 
                                       placeholder="Имя">
                                @error('name')
                                    <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
                                @enderror
                                <div class="flex items-center gap-4 text-gray-300 mt-4">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-[#7cdebe]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="capitalize">{{ $user->role }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-[#7cdebe]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Buttons in Edit Mode -->
                        <div class="flex gap-4">
                            <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Save Changes
                            </button>
                            <a href="{{ route('profile') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200">Cancel</a>
                        </div>
                    </div>
                </form>
            @else
                <!-- Original Display Mode -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <!-- Avatar Display -->
                        <div class="relative">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-2xl object-cover">
                            @else
                                <div class="w-24 h-24 bg-gray-800 rounded-2xl flex items-center justify-center text-white text-2xl font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <!-- User Info Display -->
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h1>
                            <div class="flex items-center gap-4 text-gray-300">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#7cdebe]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="capitalize">{{ $user->role }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#7cdebe]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $user->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Profile Button -->
                    <a href="{{ route('profile', ['edit' => 1]) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </a>
                </div>
            @endif
        </div>

        <!-- Stats Section (остаётся без изменений) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 {{ in_array($user->role, ['teacher','admin']) ? 'md:grid-cols-3' : 'md:grid-cols-2' }} gap-6 mb-8">
            <!-- Active Courses -->
            <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700 hover:border-purple-500 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Active Courses</p>
                        <p class="text-2xl font-bold text-white">{{ $startedCourses->count() }}</p>
                    </div>
                </div>
            </div>
            <!-- Completed Courses -->
            <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700 hover:border-purple-500 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Completed Courses</p>
                        <p class="text-2xl font-bold text-white">{{ $completedCourses->count() }}</p>
                    </div>
                </div>
            </div>
            <!-- Created Courses (только для учителей и админов) -->
            @if(in_array($user->role, ['teacher','admin']))
            <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700 hover:border-purple-500 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-1">Created Courses</p>
                        <p class="text-2xl font-bold text-white">{{ $createdCourses->count() }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Started + Completed Courses -->
            <div class="{{ in_array($user->role, ['teacher','admin']) ? 'lg:col-span-2' : 'lg:col-span-3' }} space-y-6">
                <!-- Active Courses -->
                <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-white">Active Courses</h2>
                        <a href="{{ route('courses') }}" class="text-[#7cdebe] hover:text-emerald-400 transition-colors duration-200 text-sm font-medium">View All</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($startedCourses as $course)
                            @php $progress = $course->getProgressForUser($user); @endphp
                            <div class="bg-[#182023] rounded-xl p-4 border border-gray-700 hover:border-[#7cdebe] transition-all duration-300">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-lg font-semibold text-white">{{ $course->title }}</h3>
                                    <span class="text-sm text-gray-400">{{ $course->category->name ?? '—' }}</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-2 mb-2">
                                    <div class="bg-[#7cdebe] h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-400">{{ $progress }}% completed</span>
                                    <a href="{{ route('showCourse', $course->id) }}" class="text-[#7cdebe] hover:text-emerald-400 text-sm font-medium transition-colors duration-200">Continue</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-400">No active courses yet.</p>
                        @endforelse
                    </div>
                </div>
                <!-- Completed Courses -->
                <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700">
                    <h2 class="text-2xl font-bold text-white mb-6">Completed Courses</h2>
                    <div class="space-y-4">
                        @forelse($completedCourses as $course)
                            @php
                                $progress = $course->getProgressForUser($user);
                                $completedAt = $course->completionDateForUser($user);
                            @endphp
                            <div class="bg-[#182023] rounded-xl p-4 border border-gray-700 hover:border-emerald-400 transition-all duration-300 flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold text-white">{{ $course->title }}</h3>
                                    <span class="text-sm text-gray-400">{{ $course->category->name ?? '—' }}</span>
                                    <p class="text-sm text-gray-400">Completed on: {{ $completedAt ? $completedAt->format('M d, Y') : '-' }}</p>
                                </div>
                                <a href="{{ route('showCourse', $course->id) }}" class="text-[#7cdebe] hover:text-emerald-400 text-sm font-medium transition-colors duration-200">View</a>
                            </div>
                        @empty
                            <p class="text-gray-400">No completed courses yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- Right Column: Created Courses (для учителей и админов) -->
            @if($user->role === 'teacher' || $user->role === 'admin')
            <div class="space-y-6">
                <div class="bg-[#18181b] rounded-2xl p-6 border border-gray-700">
                    <h2 class="text-2xl font-bold text-white mb-6">Created Courses</h2>
                    <div class="space-y-4">
                        @forelse($createdCourses as $course)
                            <div class="bg-[#182023] rounded-xl p-4 border border-gray-700 hover:border-purple-500 transition-all duration-300 flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold text-white">{{ $course->title }}</h3>
                                    <span class="text-sm text-gray-400">{{ $course->category->name ?? '—' }}</span>
                                    <p class="text-sm text-gray-400">Students: {{ $course->students_count }}</p>
                                </div>
                                <a href="{{ route('editCourse', $course->id) }}" class="text-[#7cdebe] hover:text-purple-500 text-sm font-medium transition-colors duration-200">Edit</a>
                            </div>
                        @empty
                            <p class="text-gray-400">You haven't created any courses yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection