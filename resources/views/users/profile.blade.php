@extends("layout")

@section("main")
    <div class="min-h-screen py-8 sm:py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Profile Header Card -->
            <div class="bg-gray-800 rounded-3xl border border-gray-700 shadow-xl p-8 mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                    <div class="flex items-center gap-6">
                        <!-- Avatar -->
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-violet-500 to-purple-500 rounded-2xl blur opacity-75"></div>
                            <div class="relative w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 rounded-2xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center text-3xl sm:text-4xl font-bold text-white shadow-xl ring-4 ring-slate-800">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                        
                        <!-- User Info -->
                        <div class="flex-1">
                            @if($editMode)
                                <form action="{{ route('profileUpdate') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <input type="text" name="name" value="{{ $user->name }}" class="bg-gray-800 border-2 border-gray-600 text-white text-xl lg:text-2xl font-bold outline-none w-full max-w-xs px-4 py-2 rounded-xl focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition" required autofocus>
                                    <div class="text-sm lg:text-base text-gray-400">{{ $user->email }}</div>
                                    <div class="flex flex-wrap gap-3 pt-2">
                                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-violet-500/25">
                                            Сохранить
                                        </button>
                                        <a href="{{ route('profile') }}" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-gray-300 font-semibold rounded-xl transition-all">
                                            Отмена
                                        </a>
                                    </div>
                                </form>
                            @else
                                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold bg-gradient-to-r from-violet-400 to-purple-400 bg-clip-text text-transparent mb-2">
                                    {{ $user->name }}
                                </h1>
                                <div class="text-base lg:text-lg text-gray-400 mb-1">{{ $user->email }}</div>
                                <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold bg-violet-900/30 text-violet-300 rounded-full capitalize">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $user->role }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    @if(!$editMode)
                        <a href="{{ route('profile', ['edit' => 1]) }}" class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg shadow-violet-500/25 hover:shadow-violet-500/40 whitespace-nowrap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Редактировать профиль
                        </a>
                    @endif
                </div>

                <!-- Stats -->
                <div class="mt-8 pt-8 border-t border-gray-700">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold bg-gradient-to-r from-violet-400 to-fuchsia-400 bg-clip-text text-transparent mb-1">
                                {{ $startedCourses->count() }}
                            </div>
                            <div class="text-sm text-gray-400 font-medium">В процессе</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold bg-gradient-to-r from-violet-400 to-purple-400 bg-clip-text text-transparent mb-1">
                                {{ $completedCourses->count() }}
                            </div>
                            <div class="text-sm text-gray-400 font-medium">Завершено</div>
                        </div>
                        @if(in_array($user->role, ['teacher','admin']))
                        <div class="text-center">
                            <div class="text-3xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-1">
                                {{ $createdCourses->count() }}
                            </div>
                            <div class="text-sm text-gray-400 font-medium">Создано</div>
                        </div>
                        @endif
                        <div class="text-center">
                            <div class="text-3xl font-bold bg-gradient-to-r from-amber-400 to-orange-400 bg-clip-text text-transparent mb-1">
                                @php
                                    $userCertificates = $user->certificates()->count();
                                @endphp
                                {{ $userCertificates }}
                            </div>
                            <div class="text-sm text-gray-400 font-medium">Сертификатов</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Continue Learning -->
                    <div class="bg-gray-800 rounded-2xl border border-gray-700 shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                            <span class="w-1 h-8 bg-gradient-to-b from-violet-500 to-purple-500 rounded-full"></span>
                            Продолжить обучение
                        </h2>
                        <div class="space-y-4">
                            @forelse($startedCourses as $course)
                                @php $progress = $course->getProgressForUser($user); @endphp
                                <a href="{{ route('showCourse', $course->id) }}" class="group flex flex-col sm:flex-row items-start sm:items-center gap-4 p-5 rounded-xl border border-gray-700 hover:border-violet-500 hover:shadow-lg hover:shadow-violet-500/10 transition-all">
                                    @if($course->thumbnail)
                                        <img src="{{ Storage::url($course->thumbnail) }}" class="w-full sm:w-24 lg:w-32 h-32 sm:h-20 lg:h-24 rounded-xl object-cover ring-2 ring-slate-700 group-hover:ring-violet-500 transition-all">
                                    @else
                                        <div class="w-full sm:w-24 lg:w-32 h-32 sm:h-20 lg:h-24 rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 w-full min-w-0">
                                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-3">
                                            <h3 class="text-lg font-bold text-white group-hover:text-violet-400 transition-colors line-clamp-2">
                                                {{ $course->title }}
                                            </h3>
                                            <span class="inline-flex items-center gap-1 px-3 py-1 text-sm font-semibold bg-violet-900/30 text-violet-400 rounded-full whitespace-nowrap">
                                                Продолжить
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="w-full h-2.5 bg-gray-700 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-violet-500 to-purple-500 transition-all duration-700 rounded-full" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <p class="text-sm text-gray-400">{{ $progress }}% завершено</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400">Нет активных курсов</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- My Courses (Enrolled) -->
                    @if($user->role === 'student' && isset($enrolledCourses))
                        <div class="bg-gray-800 rounded-2xl border border-gray-700 shadow-lg p-6">
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                                <span class="w-1 h-8 bg-gradient-to-b from-violet-500 to-fuchsia-500 rounded-full"></span>
                                Мои курсы
                            </h2>
                            <div class="space-y-4">
                                @forelse($enrolledCourses as $course)
                                    @php $progress = $course->getProgressForUser($user); @endphp
                                    <a href="{{ route('showCourse', $course) }}" class="group flex flex-col sm:flex-row items-start sm:items-center gap-4 p-5 rounded-xl border border-gray-700 hover:border-blue-500 hover:shadow-lg transition-all">
                                        @if($course->thumbnail)
                                            <img src="{{ Storage::url($course->thumbnail) }}" class="w-full sm:w-24 lg:w-32 h-32 sm:h-20 lg:h-24 rounded-xl object-cover">
                                        @else
                                            <div class="w-full sm:w-24 lg:w-32 h-32 sm:h-20 lg:h-24 rounded-xl bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 w-full min-w-0">
                                            <h3 class="text-lg font-bold text-white group-hover:text-blue-400 transition-colors mb-3 line-clamp-2">
                                                {{ $course->title }}
                                            </h3>
                                            <div class="space-y-2">
                                                <div class="w-full h-2.5 bg-gray-700 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-violet-500 to-fuchsia-500 transition-all duration-700 rounded-full" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <p class="text-sm text-gray-400">{{ $progress }}% завершено</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center py-12">
                                        <p class="text-gray-400">Вы еще не записались ни на один курс</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif

                    <!-- Favorite Courses -->
                    @if(isset($favoriteCourses))
                        <div class="bg-gray-800 rounded-2xl border border-gray-700 shadow-lg p-6">
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                                <span class="w-1 h-8 bg-gradient-to-b from-violet-500 to-purple-500 rounded-full"></span>
                                Избранные курсы
                            </h2>
                            <div class="space-y-4">
                                @forelse($favoriteCourses as $course)
                                    @php $progress = $course->getProgressForUser($user); @endphp
                                    <a href="{{ route('showCourse', $course) }}" class="group flex flex-col sm:flex-row items-start sm:items-center gap-4 p-5 rounded-xl border border-gray-700 hover:border-pink-500 dark:hover:border-pink-500 hover:shadow-lg transition-all">
                                        @if($course->thumbnail)
                                            <img src="{{ Storage::url($course->thumbnail) }}" class="w-full sm:w-24 lg:w-32 h-32 sm:h-20 lg:h-24 rounded-xl object-cover">
                                        @else
                                            <div class="w-full sm:w-24 lg:w-32 h-32 sm:h-20 lg:h-24 rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 w-full min-w-0">
                                            <h3 class="text-lg font-bold text-white group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors mb-3 line-clamp-2">
                                                {{ $course->title }}
                                            </h3>
                                            <div class="space-y-2">
                                                <div class="w-full h-2.5 bg-gray-700 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-violet-500 to-purple-500 transition-all duration-700 rounded-full" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <p class="text-sm text-gray-400">{{ $progress }}% завершено</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center py-12">
                                        <p class="text-gray-500 dark:text-gray-400">Пока нет избранных курсов</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif

                    <!-- Completed Courses -->
                    <div class="bg-gray-800 rounded-2xl border border-gray-700 shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                            <span class="w-1 h-8 bg-gradient-to-b from-amber-500 to-orange-500 rounded-full"></span>
                            Завершенные курсы
                        </h2>
                        <div class="space-y-4">
                            @forelse($completedCourses as $course)
                                @php $date = $course->completionDateForUser($user); @endphp
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-5 rounded-xl border border-gray-700 hover:border-amber-500 dark:hover:border-amber-500 hover:shadow-lg transition-all bg-gradient-to-r from-violet-50/50 to-purple-50/50 dark:from-violet-900/10 dark:to-purple-900/10">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <h3 class="text-lg font-bold text-white">{{ $course->title }}</h3>
                                        </div>
                                        <p class="text-sm text-gray-400 mb-2">
                                            Завершено: {{ $date?->format('d.m.Y') ?? '-' }}
                                        </p>
                                        @if($course->hasCertificateForUser($user))
                                            <a href="{{ route('certificates.index') }}" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold bg-violet-100 dark:bg-violet-900/30 text-violet-300 rounded-full hover:bg-violet-200 dark:hover:bg-violet-900/50 transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Сертификат доступен
                                            </a>
                                        @endif
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('showCourse', $course->id) }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-300 font-semibold rounded-xl transition-all text-sm">
                                            Просмотр
                                        </a>
                                        @if($course->hasCertificateForUser($user))
                                            <a href="{{ route('certificates.index') }}" class="px-4 py-2 bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white font-semibold rounded-xl transition-all text-sm shadow-lg shadow-violet-500/25">
                                                Сертификат
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <p class="text-gray-500 dark:text-gray-400">Нет завершенных курсов</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Created Courses (Teacher/Admin) -->
                    @if(in_array($user->role, ['teacher','admin']))
                        <div class="bg-gray-800 rounded-2xl border border-gray-700 shadow-lg p-6">
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                                <span class="w-1 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></span>
                                Мои созданные курсы
                            </h2>
                            <div class="space-y-4">
                                @forelse($createdCourses as $course)
                                    <a href="{{ route('editCourse', $course->id) }}" class="group flex justify-between items-center p-5 rounded-xl border border-gray-700 hover:border-purple-500 dark:hover:border-purple-500 hover:shadow-lg transition-all">
                                        <h3 class="text-lg font-bold text-white group-hover:text-purple-400 transition-colors">
                                            {{ $course->title }}
                                        </h3>
                                        <span class="inline-flex items-center gap-1 px-4 py-2 text-sm font-semibold bg-purple-900/30 text-purple-400 rounded-xl group-hover:bg-purple-900/50 transition-colors">
                                            Редактировать
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </span>
                                    </a>
                                @empty
                                    <div class="text-center py-12">
                                        <p class="text-gray-500 dark:text-gray-400">Вы еще не создали ни одного курса</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Certificates Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-gray-800 rounded-2xl border border-gray-700 shadow-lg p-6 sticky top-24">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                Сертификаты
                            </h2>
                            <a href="{{ route('certificates.index') }}" class="text-sm font-semibold text-violet-600 dark:text-violet-400 hover:text-violet-700 dark:hover:text-violet-300 transition-colors">
                                Все →
                            </a>
                        </div>
                        @php
                            $userCertificates = $user->certificates()->with('course')->orderBy('issued_at', 'desc')->limit(5)->get();
                        @endphp
                        <div class="space-y-4">
                            @forelse($userCertificates as $cert)
                                <a href="{{ route('certificates.show', $cert) }}" class="group block p-4 rounded-xl border border-gray-700 hover:border-amber-500 dark:hover:border-amber-500 hover:shadow-lg transition-all bg-gradient-to-br from-amber-50/50 to-orange-50/50 dark:from-amber-900/10 dark:to-orange-900/10">
                                    <h3 class="font-bold text-white mb-2 line-clamp-2 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                                        {{ $cert->course->title }}
                                    </h3>
                                    <p class="text-xs text-gray-400 mb-1">
                                        Выдан: {{ $cert->issued_at->format('d.m.Y') }}
                                    </p>
                                    <p class="text-xs font-mono text-gray-500 dark:text-gray-500">#{{ substr($cert->certificate_number, -8) }}</p>
                                </a>
                            @empty
                                <div class="text-center py-8">
                                    <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">У вас пока нет сертификатов</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
