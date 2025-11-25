<div class="border-bottom pb-3 mb-3 {{ $level > 0 ? 'ms-' . ($level * 3) : '' }}" x-data="{ showReplyForm: false }">
    <div class="d-flex justify-content-between">
        <strong>{{ $comment->user->name }}</strong>
        <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
    </div>
    @if($level > 0 && $comment->parent)
        <small class="text-muted mb-1 d-block">Ответ для {{ $comment->parent->user->name }}</small>
    @endif
    <p class="mb-2">{{ $comment->comment }}</p>
    @auth
        <div class="btn-group btn-group-sm">
            <button @click="showReplyForm = true" class="btn btn-outline-primary">Ответить</button>
            @if($user->id === $comment->user_id || $user->role === 'admin')
                <form method="DELETE" action="{{ route('deleteLessonComment', ['course' => $course, 'module' => $module, 'lesson' => $lesson, 'comment' => $comment]) }}" class="d-inline" onsubmit="return confirm('Удалить?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Удалить</button>
                </form>
            @endif
        </div>
    @endauth

    <!-- Динамическая форма ответа (показывается под комментарием) -->
    <div x-show="showReplyForm" x-transition class="mt-2 p-3 bg-light border rounded">
        <form method="POST" action="{{ route('storeLessonComment', ['course' => $course, 'module' => $module, 'lesson' => $lesson]) }}">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <div class="mb-3">
                <textarea name="comment" class="form-control" placeholder="Ваш ответ..." rows="2" required autofocus></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Отправить ответ</button>
            <button type="button" @click="showReplyForm = false" class="btn btn-secondary btn-sm">Отмена</button>
        </form>
    </div>

    <!-- Рекурсия: Replies -->
    @if($comment->replies->count() > 0)
        <div class="mt-2">
            @foreach($comment->replies as $reply)
                @include('lessons.comment-item', ['comment' => $reply, 'level' => $level + 1, 'course' => $course, 'module' => $module, 'lesson' => $lesson, 'user' => $user])
            @endforeach
        </div>
    @endif
</div>