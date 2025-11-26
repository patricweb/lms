@extends("layout")
@section("main")
<div class="min-h-screen py-8" x-data="{ openModules: {} }">
    <div class="border border-gray-600 rounded-xl container mx-auto px-4">
        <div class="rounded-2xl p-8 mb-8">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">{{ $course->title }}</h1>
                    <p class="text-lg text-gray-300 mb-6 leading-relaxed">{{ $course->description }}</p>
                    <div class="grid grid-cols-2 gap-4 mb-2">
                        <div class="flex items-center gap-3">
                            <div>
                                <p class="text-gray-400 text-sm">Автор: <span class="text-white font-medium">{{ optional($course->teacher)->name }}</span></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div>
                                <p class="text-gray-400 text-sm">Категория: <span class="text-white font-medium">{{ optional($course->category)->name }}</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-2xl font-bold text-[#7cdebe]">{{ $course->price }} $</span>
                        @auth
                            @if(!empty($canEdit) && $canEdit)
                                <a href="{{ route('editCourse', $course) }}" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200">
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
                        <div class="h-48 flex items-center justify-center rounded-2xl border border-gray-600">
                            <h3 class="text-3xl font-bold text-white text-center px-4">{{ $course->title }}</h3>
                        </div>
                    @endif

                    @auth
                        <p class="mt-2 text-gray-300 text-center">
                            Прогресс курса: <span class="font-semibold">{{ $progress ?? 0 }}%</span>
                            @if(!empty($isCompleted) && $isCompleted)
                                — <span class="text-emerald-500 font-semibold">Курс завершён!</span>
                            @endif
                        </p>
                    @endauth
                </div>

            </div>

            <!-- Modules and Lessons Section -->
            <div class="rounded-2xl p-8 mt-16">
                <h2 class="text-3xl font-bold mb-8 text-white">Модули и уроки</h2>
                @auth
                    @if(!empty($canEdit) && $canEdit)
                        <div class="mb-6">
                            <a href="{{ route('createModule', $course) }}" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200 inline-flex items-center gap-2">
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
                            <div class="border border-gray-700 rounded-2xl overflow-hidden" x-data="{ isOpen: false }">
                                <div class="bg-[#1f2937] p-6 cursor-pointer" @click="isOpen = !isOpen">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 flex items-center justify-center">
                                                <span class="text-white font-bold text-lg">{{ $module->order ?? $moduleIndex + 1 }}</span>
                                            </div>
                                            <div>
                                                <h3 class="text-xl font-semibold text-white">
                                                    <a href="{{ route('showModule', [$course, $module]) }}" class="hover:underline">
                                                        {{ $module->title }}
                                                    </a>
                                                </h3>
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
                                            <div class="bg-[#182023] rounded-xl p-6 border border-gray-700">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <a href="{{ route('showLesson', [$course, $module, $lesson]) }}" class="block">
                                                            <div class="flex items-center gap-4 mb-3">
                                                                <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center">
                                                                    <span class="font-bold">{{ $lesson->order ?? $lessonIndex + 1 }}</span>
                                                                </div>
                                                                <div>
                                                                    <h4 class="text-lg font-semibold text-white">{{ $lesson->title }}</h4>
                                                                    <p class="text-gray-400 text-sm">{{ $lesson->duration }} минут</p>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    @auth
                                                        <div class="ml-4">
                                                            @if($lesson->completions->where('user_id', auth()->id())->isEmpty())
                                                                <form method="POST" action="{{ route('completeLesson', ['course' => $course->id, 'lesson' => $lesson->id]) }}" class="d-inline">
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
            <div class="rounded-2xl p-8 mt-8">
                <h2 class="text-3xl font-bold mb-8 text-white text-center">Комментарии к курсу</h2>
                <div class="flex flex-col gap-8">
                    <!-- Форма добавления комментария/ответа -->
                        <form method="POST" action="{{ route('storeCourseComment', $course) }}" class="w-full">
                            @csrf
                            <textarea name="comment" class="w-full p-4 rounded-xl bg-[#1f2937] text-white border border-gray-600 focus:outline-none" placeholder="Ваш комментарий" rows="4" required></textarea>
                            <input type="hidden" name="parent_id" id="course_parent_id" value="">
                            <button type="submit" class="mt-3 bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-6 py-2 rounded-xl font-medium transition-all duration-200">
                                Отправить
                            </button>
                            @if(old('parent_id'))
                                <small class="text-gray-400 block mt-1">Ответ будет добавлен к выбранному комментарию.</small>
                            @endif
                        </form>

                    <!-- Список комментариев -->
                    <div class="flex flex-col gap-4">
                        @if($course->courseComments->whereNull('parent_id')->count() > 0)
                            @foreach($course->courseComments->whereNull('parent_id') as $comment)
                                @include('courses.comment-item', ['comment' => $comment, 'level' => 0, 'course' => $course, 'user' => $user])
                            @endforeach
                        @else
                            <p class="text-gray-400">Комментариев пока нет. Будьте первым!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection