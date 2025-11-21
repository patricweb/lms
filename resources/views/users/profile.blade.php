@extends("layout")

@section("main")
<div class="min-h-screen bg-[#182023] py-8">
    <div class="container mx-auto px-4">
        <!-- Profile Header -->
        <section class="relative bg-[#18181b] rounded-2xl p-8 mb-8 border border-gray-700 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500/5 to-emerald-500/5"></div>
            <div class="relative z-10 grid md:grid-cols-2 gap-8 items-center">
                <div class="flex items-center space-x-6">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Аватар" class="w-32 h-32 rounded-full object-cover ring-4 ring-purple-500/20 shadow-xl">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gradient-to-r from-purple-500 to-emerald-500 flex items-center justify-center ring-4 ring-purple-500/20 shadow-xl">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h2>
                        <p class="text-gray-300 mb-1">Email: {{ $user->email }}</p>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r @if($user->role === 'student') from-blue-500 to-blue-600 @elseif($user->role === 'teacher') from-yellow-500 to-yellow-600 @else from-red-500 to-red-600 @endif text-white">
                            {{ $user->role === 'student' ? 'Студент' : ($user->role === 'teacher' ? 'Преподаватель' : 'Админ') }}
                        </span>
                    </div>
                </div>
                <div class="flex justify-end">
                    <div class="space-x-3">
                        <a href="{{ route('courses') }}" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Курсы
                        </a>
                        <a href="{{ route('logout') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 transform hover:scale-105">
                            Выйти
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Edit Profile Section -->
        <section class="bg-[#18181b] rounded-2xl p-8 mb-8 border border-gray-700">
            <h3 class="text-2xl font-bold text-white mb-6">Редактировать профиль</h3>
            <form method="POST" action="{{ route('profileUpdate') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Имя</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-3 bg-[#1e2a2e] border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition duration-200 @error('name') border-red-500 ring-red-500 @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="avatar" class="block text-sm font-medium text-gray-300 mb-2">Аватар</label>
                        <input type="file" name="avatar" id="avatar" class="w-full px-4 py-3 bg-[#1e2a2e] border border-gray-600 rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 @error('avatar') border-red-500 ring-red-500 @enderror" accept="image/*">
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg">
                    Сохранить изменения
                </button>
            </form>
            @if(session('success'))
                <div class="mt-4 p-4 bg-emerald-900 border border-emerald-700 rounded-xl text-emerald-100">
                    {{ session('success') }}
                </div>
            @endif
        </section>

        <!-- Courses Sections -->
        <div class="space-y-12">
            @if($startedCourses->count() > 0)
                <section>
                    <h3 class="text-2xl font-bold text-white mb-6">Курсы, которые вы начали</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($startedCourses as $course)
                            <div class="bg-[#18181b] rounded-2xl overflow-hidden border border-gray-700 hover:border-yellow-500 transition-all duration-300 transform hover:-translate-y-2 shadow-sm">
                                <div class="p-6">
                                    <h4 class="font-bold text-white mb-3 text-lg"><a href="{{ route('courses.show', $course) }}" class="hover:text-yellow-400">{{ $course->title }}</a></h4>
                                    <p class="text-gray-400 mb-4 leading-relaxed">{{ Str::limit($course->description, 120) }}</p>
                                    <div class="w-full bg-gray-700 rounded-full h-2 mb-3">
                                        <div class="bg-yellow-500 h-2 rounded-full transition-all duration-300" style="width: {{ $course->getProgressForUser($user) }}%"></div>
                                    </div>
                                    <p class="text-sm text-gray-400 mb-4">{{ $course->getProgressForUser($user) }}% прогресс</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-900 text-yellow-200">В процессе</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($completedCourses->count() > 0)
                <section>
                    <h3 class="text-2xl font-bold text-white mb-6">Завершённые курсы</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($completedCourses as $course)
                            <div class="bg-[#18181b] rounded-2xl overflow-hidden border border-gray-700 hover:border-emerald-500 transition-all duration-300 transform hover:-translate-y-2 shadow-sm">
                                <div class="p-6">
                                    <h4 class="font-bold text-white mb-3 text-lg"><a href="{{ route('showCourse', $course) }}" class="hover:text-emerald-400">{{ $course->title }}</a></h4>
                                    <p class="text-gray-400 mb-4 leading-relaxed">{{ Str::limit($course->description, 120) }}</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-900 text-emerald-200">Завершён!</span>
                                    <p class="text-sm text-gray-400 mt-2">Дата: {{ $course->completionDateForUser($user)?->format('d.m.Y') ?? 'Неизвестно' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($createdCourses->count() > 0)
                <section>
                    <h3 class="text-2xl font-bold text-white mb-6">Ваши созданные курсы</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($createdCourses as $course)
                            <div class="bg-[#18181b] rounded-2xl overflow-hidden border border-gray-700 hover:border-purple-500 transition-all duration-300 transform hover:-translate-y-2 shadow-sm">
                                <div class="p-6">
                                    <h4 class="font-bold text-white mb-3 text-lg"><a href="{{ route('showCourse', $course) }}" class="hover:text-purple-400">{{ $course->title }}</a></h4>
                                    <p class="text-gray-400 mb-3 leading-relaxed">{{ Str::limit($course->description, 120) }}</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $course->is_published ? 'emerald' : 'yellow' }}-900 text-{{ $course->is_published ? 'emerald' : 'yellow' }}-200">
                                        {{ $course->is_published ? 'Опубликован' : 'Черновик' }}
                                    </span>
                                    <p class="text-sm text-gray-400 mb-4">Студентов: {{ $course->students_count ?? $course->lessons->flatMap->completions->unique('user_id')->count() }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('editCourse', $course) }}" class="inline-flex items-center gap-2 bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                            Редактировать
                                        </a>
                                        <form method="POST" action="{{ route('destroyCourse', $course) }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200" onclick="return confirm('Удалить курс?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($createdCourses->isEmpty() && in_array(auth()->user()->role, ['teacher', 'admin']))
                <section class="bg-[#18181b] rounded-2xl p-8 border border-gray-700 text-center">
                    <svg class="w-20 h-20 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-white mb-2">У вас нет созданных курсов</h3>
                    <p class="text-gray-400 mb-6">Начните создавать контент для студентов</p>
                    <a href="{{ route('courses.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-8 py-3 rounded-xl font-medium transition-all duration-200 inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Создать первый курс
                    </a>
                </section>
            @endif
        </div>
    </div>
</div>
@endsection