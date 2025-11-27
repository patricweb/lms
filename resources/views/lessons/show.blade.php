@extends("layout")

@section("main")
    <div class="min-h-screen py-8">
        <div class="border border-gray-600 rounded-2xl container mx-auto px-4">
            <div class="rounded-2xl p-8 mb-8">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">{{ $lesson->title }}</h1>
                <p class="text-gray-300 mb-6">
                    Модуль: 
                    <a href="{{ route('showModule', ['course' => $course, 'module' => $module]) }}" class="text-[#7cdebe] hover:underline">{{ $module->title }}</a> | 
                    Курс: 
                    <a href="{{ route('showCourse', $course) }}" class="text-[#7cdebe] hover:underline">{{ $course->title }}</a>
                </p>
                <div class="rounded-2xl p-6 mb-8">
                    <h2 class="text-2xl font-bold text-white mb-4">Инфо урока</h2>
                    <p class="text-gray-300"><strong>Порядок:</strong> {{ $lesson->order }}</p>
                    <p class="text-gray-300"><strong>Длительность:</strong> {{ $lesson->duration }} мин</p>
                </div>
                @if($lesson->video_url)
                <div class="ratio ratio-16x9 mb-6">
                    <iframe class="rounded-xl" src="{{ str_replace('watch?v=', 'embed/', $lesson->video_url) }}" allowfullscreen></iframe>
                </div>
                @endif
                <div class="bg-[#182023] border border-gray-700 rounded-2xl p-6 mb-6">
                    {!! $lesson->content !!}
                </div>
                @if($lesson->completions()->where('user_id', $user->id)->exists())
                <div class="bg-emerald-500 text-white px-6 py-3 rounded-xl font-medium inline-flex items-center gap-2 mb-6">
                    Урок завершён!
                </div>
                @else
                <form method="POST" action="{{ route('completeLesson', ['course' => $course, 'lesson' => $lesson->id]) }}" class="mb-6">
                    @csrf
                    <button type="submit" class="bg-[#7cdebe] hover:bg-emerald-400 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200 transform hover:scale-105">
                        Отметить как пройденный
                    </button>
                </form>
                @endif
                @if($canEdit)
                <div class="flex gap-3 mb-6">
                    <a href="{{ route('editLesson', ['course' => $course, 'module' => $module, 'lesson' => $lesson]) }}" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200">
                        Редактировать урок
                    </a>
                    <form method="POST" action="{{ route('deleteLesson', ['course' => $course, 'module' => $module, 'lesson' => $lesson]) }}" class="inline" onsubmit="return confirm('Удалить урок?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200">
                            Удалить урок
                        </button>
                    </form>
                </div>
                @endif
            </div>
            <div class="rounded-2xl p-8 bg-[#182023] border border-gray-700 mb-8">
                @auth
                <form method="POST" action="{{ route('storeLessonComment', ['course' => $course, 'module' => $module, 'lesson' => $lesson]) }}" class="mb-6">
                    @csrf
                    <textarea name="comment" class="w-full p-4 rounded-xl bg-gray-900 text-white border border-gray-700" placeholder="Ваш комментарий к уроку..." rows="3" required></textarea>
                    <input type="hidden" name="parent_id" value="">
                    <button type="submit" class="mt-3 bg-[#7cdebe] hover:bg-emerald-400 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200">
                        Отправить комментарий
                    </button>
                </form>
                @else
                <div class="text-center p-6 bg-gray-900 rounded-xl border border-gray-700">
                    <a href="{{ route('login') }}" class="bg-[#7cdebe] hover:bg-emerald-400 text-gray-900 px-6 py-3 rounded-xl font-medium transition-all duration-200">
                        Войдите, чтобы комментировать
                    </a>
                </div>
                @endauth
                <div class="mt-6">
                    <h2 class="text-2xl font-bold mb-4 text-white">Комментарии</h2>
                    @if($lesson->lessonComments->whereNull('parent_id')->count() > 0)
                        @foreach($lesson->lessonComments->whereNull('parent_id') as $comment)
                            @include('lessons.comment-item', ['comment' => $comment, 'level' => 0, 'course' => $course, 'module' => $module, 'lesson' => $lesson, 'user' => $user])
                        @endforeach
                    @else
                        <p class="text-gray-400">Комментариев пока нет. Будьте первым!</p>
                    @endif
                </div>
            </div>
            <div class="flex justify-center mb-8">
                <a href="{{ route('showModule', ['course' => $course, 'module' => $module]) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 inline-flex items-center gap-2">
                    Назад к модулю
                </a>
            </div>
        </div>
    </div>
@endsection