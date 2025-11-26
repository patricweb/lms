@extends("layout")
@section("main")
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <h1>{{ $lesson->title }}</h1>
            <p><small class="text-muted">Модуль: <a href="{{ route('showModule', ['course' => $course, 'module' => $module]) }}">{{ $module->title }}</a> | Курс: <a href="{{ route('showCourse', $course) }}">{{ $course->title }}</a></small></p>
            
            @if($lesson->video_url)
                <div class="ratio ratio-16x9 mb-4">
                    <iframe src="{{ str_replace('watch?v=', 'embed/', $lesson->video_url) }}" allowfullscreen></iframe>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    {!! $lesson->content !!}
                </div>
            </div>

            @if($user->role === 'student')
                @if($lesson->completions()->where('user_id', $user->id)->exists())
                    <div class="alert alert-success mt-3">Урок завершён!</div>
                @else
                    <form method="POST" action="{{ route('completeLesson', ['course' => $course, 'lessonId' => $lesson->id]) }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-primary">Отметить как пройденный</button>
                    </form>
                @endif
            @endif

            @if($canEdit)
                <div class="mt-3">
                    <a href="{{ route('editLesson', ['course' => $course, 'module' => $module, 'lesson' => $lesson]) }}" class="btn btn-warning">Редактировать урок</a>
                    <form method="POST" action="{{ route('deleteLesson', ['course' => $course, 'module' => $module, 'lesson' => $lesson]) }}" class="d-inline" onsubmit="return confirm('Удалить урок?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </div>
            @endif

            <!-- Основная форма для root-комментария (сразу после урока) -->
            @auth
                <form method="POST" action="{{ route('storeLessonComment', ['course' => $course, 'module' => $module, 'lesson' => $lesson]) }}" class="card mt-3">
                    @csrf
                    <div class="card-body">
                        <textarea name="comment" class="form-control" placeholder="Ваш комментарий к уроку..." rows="3" required></textarea>
                        <input type="hidden" name="parent_id" value="">
                        <button type="submit" class="btn btn-primary mt-2">Отправить комментарий</button>
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

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Инфо урока</div>
                <div class="card-body">
                    <p><strong>Порядок:</strong> {{ $lesson->order }}</p>
                    <p><strong>Длительность:</strong> {{ $lesson->duration }} мин</p>
                    <p><strong>Бесплатный предпросмотр:</strong> {{ $lesson->is_free_preview ? 'Да' : 'Нет' }}</p>
                </div>
            </div>

            <!-- Список комментариев (root) -->
            <div class="card mt-3">
                <div class="card-header">
                    Комментарии
                </div>
                <div class="card-body">
                    @if($lesson->lessonComments->whereNull('parent_id')->count() > 0)
                        @foreach($lesson->lessonComments->whereNull('parent_id') as $comment)
                            @include('lessons.comment-item', ['comment' => $comment, 'level' => 0, 'course' => $course, 'module' => $module, 'lesson' => $lesson, 'user' => $user])
                        @endforeach
                    @else
                        <p class="text-muted">Комментариев пока нет. Будьте первым!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('showModule', ['course' => $course, 'module' => $module]) }}" class="btn btn-secondary mt-4">Назад к модулю</a>
</div>

@endsection