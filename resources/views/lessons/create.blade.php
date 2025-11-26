@extends("layout")

@section("main")
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-5xl mx-auto bg-[#182023] border border-gray-700 rounded-2xl p-8">
            <h1 class="text-3xl font-bold text-white mb-6">
                Создать урок для модуля "{{ $module->title }}" (курс "{{ $course->title }}")
            </h1>
            <form method="POST" action="{{ route('storeLesson', ['course' => $course, 'module' => $module]) }}" class="space-y-6">
                @csrf
                <div class="flex flex-col gap-6">
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-gray-300 mb-1">Название урока</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">
                        </div>
                        <div>
                            <label for="order" class="block text-gray-300 mb-1">Порядок урока</label>
                            <input type="number" name="order" id="order" value="{{ old('order', $module->lessons->count() + 1) }}" min="1" required class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">
                        </div>
                        <div>
                            <label for="duration" class="block text-gray-300 mb-1">Длительность (мин)</label>
                            <input type="number" name="duration" id="duration" value="{{ old('duration') }}" min="1" required class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_free_preview" id="is_free_preview" value="1" {{ old('is_free_preview') ? 'checked' : '' }} class="w-5 h-5 bg-gray-900 border-gray-600">
                            <label for="is_free_preview" class="text-gray-300">Бесплатный предпросмотр</label>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="video_url" class="block text-gray-300 mb-1">URL видео (опционально, YouTube)</label>
                            <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}" class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">
                        </div>
                        <div>
                            <label for="content" class="block text-gray-300 mb-1">Содержание урока</label>
                            <textarea name="content" id="content" rows="10" required class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">{{ old('content') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('showModule', ['course' => $course, 'module' => $module]) }}" class="px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition">
                        Назад к модулю
                    </a>
                    <button type="submit" class="px-6 py-3 bg-emerald-500 text-gray-900 rounded-xl hover:bg-emerald-600 transition">
                        Создать урок
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
