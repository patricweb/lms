@extends("layout")
@section("main")
<div class="min-h-screen bg-[#182023] py-8" x-data="{ openModules: {} }">
    <div class="container mx-auto px-4">
        <div class="bg-[#18181b] rounded-2xl p-8 mb-8 border border-gray-700">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 text-[#7cdebe]">{{ $course->title }}</h1>
                    <p class="text-lg text-gray-300 mb-6 leading-relaxed">{{ $course->description }}</p>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Автор</p>
                                <p class="text-white font-medium">{{ optional($course->teacher)->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-400 text-sm">Категория</p>
                                <p class="text-white font-medium">{{ optional($course->category)->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-2xl font-bold text-[#7cdebe]">{{ $course->price }} руб.</span>
                        @auth
                            @if(!empty($canEdit) && $canEdit)
                                <a href="{{ route('editCourse', $course) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200">
                                    Редактировать
                                </a>
                                <form method="POST" action="{{ route('destroyCourse', $course) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200" onclick="return confirm('Удалить?')">
                                        Удалить
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="relative">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-64 object-cover rounded-2xl">
                    @else
                        <div class="h-48 flex items-center justify-center bg-[#1f2937] rounded-2xl">
                            <h3 class="text-3xl font-bold text-[#7cdebe] text-center px-4">
                                {{ $course->title }}
                            </h3>
                        </div>
                    @endif
                    @auth
                        <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-[#18181b] border border-gray-700 rounded-xl p-4 w-4/5">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-300">Прогресс</span>
                                <span class="text-[#7cdebe] font-bold">{{ $progress ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-[#7cdebe] h-2 rounded-full transition-all duration-300" style="width: {{ $progress ?? 0 }}%"></div>
                            </div>
                            @if(!empty($isCompleted) && $isCompleted)
                                <div class="mt-3 bg-emerald-500 text-white text-center py-2 rounded-lg font-medium">
                                    ✓ Курс завершён!
                                </div>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Modules and Lessons Section -->
            <div class="bg-[#18181b] rounded-2xl p-8 border border-gray-700">
                <h2 class="text-3xl font-bold mb-8 text-white text-center">Модули и уроки</h2>
                @auth
                    @if(!empty($canEdit) && $canEdit)
                        <div class="text-center mb-6">
                            <a href="{{ route('createModule', $course) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 inline-flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Добавить модуль
                            </a>
                        </div>
                    @endif
                @endauth

                @if($course->modules->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Модули не добавлены</h3>
                        <p class="text-gray-400 mb-6">Начните создавать учебный контент для этого курса</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($course->modules as $moduleIndex => $module)
                            <div class="border border-gray-700 rounded-2xl overflow-hidden hover:border-purple-500 transition-all duration-300" x-data="{ isOpen: false }">
                                <div class="bg-[#1f2937] p-6 cursor-pointer" @click="isOpen = !isOpen">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                                                <span class="text-white font-bold text-lg">{{ $module->order ?? $moduleIndex + 1 }}</span>
                                            </div>
                                            <div>
                                                <h3 class="text-xl font-semibold text-white">
                                                    <a href="{{ route('showModule', [$course, $module]) }}" class="hover:underline">
                                                        {{ $module->title }}
                                                    </a>
                                                </h3>
                                                <p class="text-gray-400">{{ $module->description }}</p>
                                            </div>
                                        </div>
                                        <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-300" :class="{ 'rotate-180': isOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div x-show="isOpen" x-collapse>
                                    <div class="p-6 space-y-4">
                                        @forelse($module->lessons as $lessonIndex => $lesson)
                                            <div class="bg-[#182023] rounded-xl p-6 border border-gray-700 hover:border-[#7cdebe] transition-all duration-300">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <a href="{{ route('showLesson', [$course, $module, $lesson]) }}" class="block hover:text-[#7cdebe] transition-colors duration-200">
                                                            <div class="flex items-center gap-4 mb-3">
                                                                <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
                                                                    <span class="text-[#7cdebe] font-bold">{{ $lesson->order ?? $lessonIndex + 1 }}</span>
                                                                </div>
                                                                <div>
                                                                    <h4 class="text-lg font-semibold text-white">{{ $lesson->title }}</h4>
                                                                    <p class="text-gray-400 text-sm">{{ $lesson->duration }} минут</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    @auth
                                                        <div class="ml-4 flex-shrink-0">
                                                            @if($lesson->completions->where('user_id', auth()->id())->isEmpty())
                                                                <form method="POST" action="{{ route('completeLesson', ['course' => $course->id, 'lessonId' => $lesson->id]) }}" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="bg-[#7cdebe] hover:bg-emerald-400 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200 transform hover:scale-105">
                                                                        Отметить пройденным
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <div class="bg-emerald-500 text-white px-6 py-3 rounded-xl font-medium inline-flex items-center gap-2">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                    Пройдено
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endauth
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-8">
                                                <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-gray-500 mb-4">Уроки пока не добавлены</p>
                                                @auth
                                                    @if(!empty($canEdit) && $canEdit)
                                                        <a href="{{ route('createLesson', [$course, $module]) }}" class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 inline-flex items-center gap-2 mx-auto">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                            Добавить урок
                                                        </a>
                                                    @endif
                                                @endauth
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Comments Section (новая секция для комментариев к курсу) -->
            <div class="bg-[#18181b] rounded-2xl p-8 border border-gray-700 mt-8">
                <h2 class="text-3xl font-bold mb-8 text-white text-center">Комментарии к курсу</h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="md:col-span-1">
                        <!-- Список комментариев (root) -->
                        <div class="card-body">
                            @if($course->courseComments->whereNull('parent_id')->count() > 0)
                                @foreach($course->courseComments->whereNull('parent_id') as $comment)
                                    @include('courses.comment-item', ['comment' => $comment, 'level' => 0, 'course' => $course, 'user' => $user])
                                @endforeach
                            @else
                                <p class="text-muted">Комментариев пока нет. Будьте первым!</p>
                            @endif
                        </div>
                    </div>

                    <div class="md:col-span-1">
                        <!-- Форма добавления комментария/ответа (встроенная) -->
                        @auth
                            <form method="POST" action="{{ route('storeCourseComment', $course) }}" class="card mt-3">
                                @csrf
                                <div class="card-body">
                                    <textarea name="comment" class="form-control" placeholder="Ваш комментарий или ответ..." rows="3" required></textarea>
                                    <input type="hidden" name="parent_id" id="course_parent_id" value="">
                                    <button type="submit" class="btn btn-primary mt-2">Отправить</button>
                                    @if(old('parent_id'))
                                        <small class="text-muted">Ответ будет добавлен к выбранному комментарию.</small>
                                    @endif
                                </div>
                            </form>
                        @else
                            <div class="card mt-3">
                                <div class="card-body text-center">
                                    <a href="{{ route('login') }}" class="btn btn-primary">Войдите, чтобы комментировать</a>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection