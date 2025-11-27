<div class="border-l-4 border-gray-600 pl-4 py-3 mb-3 {{ $level > 0 ? 'ml-' . ($level * 6) : '' }}" x-data="{ showReplyForm: false }">
	<div class="flex gap-2 items-center mb-1">
		<strong class="text-white">{{ $comment->user->name }}</strong>
		<small class="text-gray-400 text-sm">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
	</div>
	@if($level > 0 && $comment->parent)
	<small class="text-gray-400 mb-1 block">Ответ для {{ $comment->parent->user->name }}</small>
	@endif
	<p class="text-gray-200 mb-2">{{ $comment->comment }}</p>
	@auth
	<div class="flex gap-2 mb-2">
		<button @click="showReplyForm = !showReplyForm" class="px-3 py-1 border border-emerald-500 text-emerald-400 rounded hover:bg-emerald-500 hover:text-gray-900 transition">
			Ответить
		</button>
		@if($user->id === $comment->user_id || $user->role === 'admin')
		<form method="POST" action="{{ route('deleteLessonComment', ['course' => $course, 'module' => $module, 'lesson' => $lesson, 'comment' => $comment]) }}" class="inline" onsubmit="return confirm('Удалить?')">
			@csrf
			@method('DELETE')
			<button type="submit" class="px-3 py-1 border border-red-500 text-red-400 rounded hover:bg-red-500 hover:text-white transition">
				Удалить
			</button>
		</form>
		@endif
	</div>
	@endauth
	<div x-show="showReplyForm" x-transition class="mt-2 p-3 bg-[#1f2937] border border-gray-600 rounded">
		<form method="POST" action="{{ route('storeLessonComment', ['course' => $course, 'module' => $module, 'lesson' => $lesson]) }}">
			@csrf
			<input type="hidden" name="parent_id" value="{{ $comment->id }}">
			<textarea name="comment" class="w-full bg-[#182023] text-white rounded p-2 border border-gray-600 outline-none" placeholder="Ваш ответ..." rows="2" required autofocus></textarea>
			<div class="flex justify-end gap-2 mt-2">
				<button type="submit" class="px-3 py-1 bg-emerald-500 text-gray-900 rounded hover:bg-emerald-600 transition">Отправить</button>
				<button type="button" @click="showReplyForm = false" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 transition">Отмена</button>
			</div>
		</form>
	</div>
	@if($comment->replies->count() > 0)
        <div class="mt-2">
            @foreach($comment->replies as $reply)
                @include('lessons.comment-item', ['comment' => $reply, 'level' => $level + 1, 'course' => $course, 'module' => $module, 'lesson' => $lesson, 'user' => $user])
            @endforeach
        </div>
	@endif
</div>