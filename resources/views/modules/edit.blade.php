@extends("layout")

@section("main")
    <div class="min-h-screen py-8 sm:py-12 lg:py-16 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-[#182023] border border-gray-700 rounded-2xl shadow-2xl overflow-hidden">
                <div class="px-6 py-8 sm:px-10 sm:py-10 lg:px-12 lg:py-12 border-b border-gray-700 bg-[#1a2226]">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white leading-tight">
                        Редактировать модуль
                        <span class="block mt-2 text-xl sm:text-2xl font-medium text-[#7cdebe]">
                            "{{ $module->title }}"
                        </span>
                        <span class="block mt-3 text-lg text-gray-400">
                            в курсе: <span class="text-gray-200">"{{ $course->title }}"</span>
                        </span>
                    </h1>
                </div>
                <div class="p-6 sm:p-8 lg:p-12">
                    <form method="POST" action="{{ route('updateModule', ['course' => $course, 'module' => $module]) }}" class="space-y-8">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label for="title" class="block text-gray-300 text-sm font-medium">
                                    Название модуля <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title', $module->title) }}" class="w-full px-4 py-3.5 rounded-xl bg-gray-900/70 border border-gray-600 text-white placeholder-gray-500 focus:border-[#7cdebe] focus:ring-2 focus:ring-[#7cdebe]/20 transition" placeholder="Введите название модуля" required>
                                @error('title')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-1">
                                <label for="order" class="block text-gray-300 text-sm font-medium">
                                    Порядок модуля <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="order" id="order" value="{{ old('order', $module->order) }}" min="1" class="w-full px-4 py-3.5 rounded-xl bg-gray-900/70 border border-gray-600 text-white focus:border-[#7cdebe] focus:ring-2 focus:ring-[#7cdebe]/20 transition" required>
                                @error('order')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label for="description" class="block text-gray-300 text-sm font-medium">
                                Описание модуля (необязательно)
                            </label>
                            <textarea name="description" id="description" rows="6" class="w-full px-4 py-3.5 rounded-xl bg-gray-900/70 border border-gray-600 text-white placeholder-gray-500 resize-none focus:border-[#7cdebe] focus:ring-2 focus:ring-[#7cdebe]/20 transition" placeholder="Расскажите, о чём этот модуль...">{{ old('description', $module->description) }}</textarea>
                            @error('description')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t border-gray-700 mt-10">
                            <a href="{{ route('showCourse', $course) }}" class="px-8 py-3.5 bg-gray-700 hover:bg-gray-600 text-white font-medium rounded-xl transition text-center order-2 sm:order-1">
                                ← Назад к курсу
                            </a>
                            <button type="submit" class="px-8 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-black font-bold rounded-xl transition transform hover:scale-105 order-1 sm:order-2">
                                Сохранить изменения
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection