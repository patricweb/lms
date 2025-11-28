@extends("layout")

@section("main")
    <div class="min-h-screen py-10">
        <div class="container mx-auto px-4 border border-gray-700 rounded-2xl p-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">{{ $lesson->title }}</h1>
            <p class="text-gray-400 mb-6 text-sm">
                Модуль:
                <a href="{{ route('showModule', ['course' => $course, 'module' => $module]) }}" class="text-[#7cdebe] hover:underline">{{ $module->title }}</a> &nbsp;|&nbsp;
                    Курс:
                <a href="{{ route('showCourse', $course) }}" class="text-[#7cdebe] hover:underline">{{ $course->title }}</a>
            </p>
            <div class="bg-[#1f2937] border border-gray-600 rounded-2xl p-6 mb-8">
                <h2 class="text-2xl font-semibold text-white mb-3">Информация</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-gray-300">
                    <p><strong>Порядок:</strong> {{ $lesson->order }}</p>
                    <p><strong>Длительность:</strong> {{ $lesson->duration }} мин</p>
                </div>
            </div>
            @endif
            <div class="bg-[#162026] border border-gray-600 rounded-2xl p-6 mb-8 text-gray-200 content-style">
                {!! $lesson->content !!}
            </div>
            @if($lesson->completions()->where('user_id', $user->id)->exists())
                <div class="inline-flex items-center gap-2 bg-emerald-500 text-gray-900 px-6 py-3 rounded-xl mb-8 font-medium">
                    Урок завершён!
                </div>
            @else
                <form method="POST" action="{{ route('completeLesson', ['course' => $course, 'lesson' => $lesson->id]) }}" class="mb-8">
                    @csrf
                    <button class="bg-[#7cdebe] hover:bg-emerald-400 text-gray-900 px-6 py-3 rounded-xl font-medium transition-transform hover:scale-105">
                        Отметить как пройденный
                    </button>
                </form>
            @endif
            @if($canEdit)
            <div class="flex gap-3 mb-10">
                <a href="{{ route('editLesson', ['course' => $course, 'module' => $module, 'lesson' => $lesson]) }}" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-6 py-3 rounded-xl font-medium transition">
                    Редактировать
                </a>
                <form method="POST" action="{{ route('deleteLesson', ['course' => $course, 'module' => $module, 'lesson' => $lesson]) }}" onsubmit="return confirm('Удалить урок?')">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl font-medium transition">
                        Удалить
                    </button>
                </form>
            </div>
            @endif
            <div class="bg-[#1f2937] border border-gray-600 rounded-2xl p-6 mb-10">
                <h2 class="text-2xl font-bold mb-5 text-white">Комментарии</h2>
                @auth
                <form method="POST" action="{{ route('storeLessonComment', ['course' => $course, 'module' => $module, 'lesson' => $lesson]) }}" class="mb-6">
                    @csrf
                    <textarea name="comment" class="w-full p-4 rounded-xl bg-gray-900 text-white border border-gray-700" placeholder="Ваш комментарий к уроку..." rows="3" required></textarea>
                    <button class="mt-3 bg-[#7cdebe] hover:bg-emerald-400 text-gray-900 px-6 py-3 rounded-xl font-medium transition">
                        Отправить
                    </button>
                </form>
                @else
                <div class="text-center p-6 bg-gray-900 rounded-xl border border-gray-700">
                    <a href="{{ route('login') }}" class="bg-[#7cdebe] hover:bg-emerald-400 text-gray-900 px-6 py-3 rounded-xl font-medium">
                        Войдите, чтобы оставить комментарий
                    </a>
                </div>
                @endauth
                <div class="mt-6">
                    @if($lesson->lessonComments->whereNull('parent_id')->count() > 0)
                        @foreach($lesson->lessonComments->whereNull('parent_id') as $comment)
                            @include('lessons.comment-item', ['comment' => $comment, 'level' => 0, 'course' => $course, 'module' => $module, 'lesson' => $lesson, 'user' => $user])
                        @endforeach
                    @else
                        <p class="text-gray-400">Комментариев пока нет. Будьте первым!</p>
                    @endif
                </div>
            </div>
            <div class="flex justify-center">
                <a href="{{ route('showModule', ['course' => $course, 'module' => $module]) }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-medium transition inline-flex items-center gap-2">
                    ← Назад к модулю
                </a>
            </div>
        </div>
    </div>
@endsection
