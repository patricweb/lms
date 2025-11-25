@extends('layout')

@section('main')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h2>Курс: <a href="{{ route('showCourse', $module->course) }}">{{ $module->course->title }}</a></h2>
            <h3>{{ $module->title }}</h3>
            @if($module->description)
                <p class="lead">{{ $module->description }}</p>
            @endif
            <p>Порядок: {{ $module->order }}</p>
        </div>
        <div class="col-md-4">
            @if($user->role === 'student')
                @php
                    $totalLessons = $module->lessons->count();
                    $completedLessons = $module->lessons->filter(fn($lesson) => $lesson->isCompletedByUser($user))->count();
                    $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                @endphp
                <div class="card">
                    <div class="card-body">
                        <h6>Ваш прогресс</h6>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $progress }}%"></div>
                        </div>
                        <small>{{ $completedLessons }} / {{ $totalLessons }} уроков завершено</small>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <hr>

    <h2>Уроки модуля</h2>
    @if($module->lessons->count() > 0)
        <div class="list-group">
            @foreach($module->lessons as $lesson)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5><a href="{{ route('showLesson', ['course' => $module->course, 'module' => $module, 'lesson' => $lesson]) }}">{{ $lesson->title }}</a></h5>
                        <p class="mb-0">{{ Str::limit($lesson->content, 100) }}</p>
                        @if($lesson->video_url)
                            <small class="text-muted">Видео: {{ $lesson->video_url }}</small>
                        @endif
                        <small class="text-muted">Порядок: {{ $lesson->order }} | Длительность: {{ $lesson->duration }} мин</small>
                        @if($user->role === 'student' && $lesson->isCompletedByUser($user))
                            <span class="badge bg-success ms-2">Завершено</span>
                        @endif
                    </div>
                    <div class="btn-group" role="group">
                        @if($canEdit)
                            <a href="{{ route('editLesson', ['course' => $module->course, 'module' => $module, 'lesson' => $lesson]) }}" class="btn btn-sm btn-warning">Редактировать</a>
                            <form method="DELETE" action="{{ route('deleteLesson', ['course' => $module->course, 'module' => $module, 'lesson' => $lesson]) }}" class="d-inline" onsubmit="return confirm('Удалить урок?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                            </form>
                        @elseif($user->role === 'student')
                            <a href="{{ route('completeLesson', ['course' => $module->course, 'lessonId' => $lesson->id]) }}" class="btn btn-sm btn-primary">Завершить</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">В модуле пока нет уроков. <a href="{{ route('createLesson', ['course' => $module->course, 'module' => $module]) }}">Добавить урок</a></p>
    @endif

    @if($canEdit)
        <div class="mt-4">
            <a href="{{ route('createLesson', ['course' => $module->course, 'module' => $module]) }}" class="btn btn-success">Добавить урок</a>
            <a href="{{ route('editModule', ['course' => $module->course, 'module' => $module]) }}" class="btn btn-warning">Редактировать модуль</a>
            <form method="POST" action="{{ route('deleteModule', ['course' => $module->course, 'module' => $module]) }}" class="d-inline" onsubmit="return confirm('Удалить модуль и все уроки?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Удалить модуль</button>
            </form>
        </div>
    @endif

    <a href="{{ route('showCourse', $module->course) }}" class="btn btn-secondary mt-3">Назад к курсу</a>
</div>

@endsection