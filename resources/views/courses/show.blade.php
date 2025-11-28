@extends("layout")

@section("main")
<div class="min-h-screen py-4 md:py-8" x-data="{ openModules: {} }">
    <div class="border border-gray-600 rounded-xl container mx-auto px-2 sm:px-4">
        <div class="rounded-2xl p-4 sm:p-8 mb-6 sm:mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 items-center">
                <div>
                    <h1 class="text-2xl sm:text-4xl md:text-5xl font-bold mb-3 text-white">{{ $course->title }}</h1>
                    <p class="text-base sm:text-lg text-gray-300 mb-4 sm:mb-6 leading-relaxed">{{ $course->description }}</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                        <p class="text-gray-400 text-sm">Автор: 
                            <span class="text-white font-medium">{{ optional($course->teacher)->name }}</span>
                        </p>
                        <p class="text-gray-400 text-sm">Категория: 
                            <span class="text-white font-medium">{{ optional($course->category)->name }}</span>
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                        <span class="text-xl sm:text-2xl font-bold text-[#7cdebe]">
                            {{ $course->price }} $
                        </span>
                        @auth
                        @if(!empty($canEdit) && $canEdit)
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('editCourse', $course) }}" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-4 py-2 rounded-xl text-sm sm:text-base font-medium transition">
                                    Редактировать
                                </a>
                                <form method="POST" action="{{ route('destroyCourse', $course) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm sm:text-base font-medium transition" onclick="return confirm('Удалить?')">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        @endif
                        @endauth
                    </div>
                </div>
                <div>
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-48 sm:h-56 md:h-64 object-cover rounded-2xl">
                    @else
                        <div class="h-40 sm:h-48 flex items-center justify-center rounded-2xl border border-gray-600">
                            <h3 class="text-2xl sm:text-3xl font-bold text-white text-center px-4">{{ $course->title }}</h3>
                        </div>
                    @endif
                    @auth
                        <p class="mt-2 text-xs sm:text-base text-gray-300 text-center">
                            Прогресс курса: <span class="font-semibold">{{ $progress ?? 0 }}%</span>
                            @if(!empty($isCompleted) && $isCompleted)
                                — <span class="text-emerald-500 font-semibold">Курс завершён!</span>
                            @endif
                        </p>
                    @endauth
                </div>
            </div>
            <div class="rounded-2xl p-4 sm:p-8 mt-10 sm:mt-16">
                <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-white">Модули и уроки</h2>
                @auth
                @if(!empty($canEdit) && $canEdit)
                    <a href="{{ route('createModule', $course) }}" class="mb-6 inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-4 py-2 rounded-xl text-sm sm:text-base font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
                        </svg>
                        Добавить модуль
                    </a>
                @endif
                @endauth
                @if($course->modules->isEmpty())
                    <p class="text-gray-400 text-center py-6 sm:py-12">Модули не добавлены</p>
                @else
                    <div class="space-y-4 sm:space-y-6">
                        @foreach($course->modules as $moduleIndex => $module)
                        <div class="border border-gray-700 rounded-2xl overflow-hidden" x-data="{ isOpen: false }">
                            <div class="bg-[#1f2937] p-4 sm:p-6 cursor-pointer flex justify-between items-center" @click="isOpen = !isOpen">
                                <div class="flex items-center gap-3">
                                    <span class="text-white font-bold text-lg">{{ $module->order ?? $moduleIndex + 1 }}</span>
                                    <a class="text-white hover:underline text-sm sm:text-base" href="{{ route('showModule', [$course, $module]) }}">
                                        {{ $module->title }}
                                    </a>
                                </div>
                                <svg class="w-5 sm:w-6 h-5 sm:h-6 text-gray-400 transform transition" :class="{'rotate-180': isOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                            <div x-show="isOpen" x-collapse>
                                <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                                    @forelse($module->lessons as $lessonIndex => $lesson)
                                    <div class="bg-[#182023] rounded-xl p-4 sm:p-6 border border-gray-700">
                                        <div class="flex flex-col sm:flex-row justify-between gap-3 sm:gap-0">
                                            <div class="flex-1">
                                                <a href="{{ route('showLesson', [$course, $module, $lesson]) }}">
                                                    <div class="flex items-center gap-3 mb-2">
                                                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-700 rounded-lg flex items-center justify-center text-sm sm:text-base">
                                                            {{ $lesson->order ?? $lessonIndex + 1 }}
                                                        </div>
                                                        <div>
                                                            <h4 class="text-base sm:text-lg font-semibold text-white">
                                                                {{ $lesson->title }}
                                                            </h4>
                                                            <p class="text-gray-400 text-xs sm:text-sm">
                                                                {{ $lesson->duration }} минут
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            @auth
                                            <div>
                                                @if($lesson->completions->where('user_id', auth()->id())->isEmpty())
                                                    <form method="POST" action="{{ route('completeLesson', ['course' => $course->id, 'lesson' => $lesson->id]) }}">
                                                        @csrf
                                                        <button type="submit" class="w-full sm:w-auto bg-[#7cdebe] hover:bg-emerald-400 text-gray-900 px-4 py-2 rounded-xl text-sm font-medium transition">
                                                            Пройдено
                                                        </button>
                                                    </form>
                                                @else
                                                    <div class="bg-emerald-500 text-white px-4 py-2 rounded-xl text-xs sm:text-sm inline-flex gap-2">
                                                        ✔ Пройдено
                                                    </div>
                                                @endif
                                            </div>
                                            @endauth
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-gray-500 text-sm text-center">Уроков пока нет</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="rounded-2xl p-4 sm:p-8 mt-10 sm:mt-8">
                <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-white text-center">
                    Комментарии к курсу
                </h2>
                <form method="POST" action="{{ route('storeCourseComment', $course) }}">
                    @csrf
                    <textarea name="comment" class="w-full p-3 sm:p-4 rounded-xl bg-[#1f2937] text-white border border-gray-600 text-sm focus:outline-none" rows="4" placeholder="Ваш комментарий" required></textarea>
                    <input type="hidden" name="parent_id" id="course_parent_id">
                    <button type="submit" class="mt-2 sm:mt-3 bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-4 sm:px-6 py-2 rounded-xl font-medium text-sm sm:text-base transition">
                        Отправить
                    </button>
                </form>
                <div class="flex flex-col gap-4 mt-6">
                    @if($course->courseComments->whereNull('parent_id')->count() > 0)
                        @foreach($course->courseComments->whereNull('parent_id') as $comment)
                            @include('courses.comment-item', ['comment'=>$comment,'level'=>0,'course'=>$course,'user'=>$user])
                        @endforeach
                    @else
                        <p class="text-gray-500 text-sm text-center">Комментариев пока нет</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection