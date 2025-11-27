@extends("layout")

@section("main")
    <div class="min-h-screen py-8 sm:py-12 lg:py-16 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-[#182023] border border-gray-700 rounded-2xl shadow-2xl overflow-hidden">
                <div class="px-6 py-8 sm:px-10 sm:py-10 lg:px-12 lg:py-12 border-b border-gray-700 bg-[#1a2226]">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white leading-tight">
                        Создать модуль
                        <span class="block mt-2 text-xl sm:text-2xl font-medium text-[#7cdebe]">
                            для курса "{{ $course->title }}"
                        </span>
                    </h1>
                </div>
                <div class="p-6 sm:p-8 lg:p-12">
                    <form action="{{ route('saveModule', $course) }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="block text-gray-300 mb-1 text-sm font-medium">Название модуля</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none focus:border-[#7cdebe] focus:ring-2 focus:ring-[#7cdebe]/20 transition">
                                @error('title')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="order" class="block text-gray-300 mb-1 text-sm font-medium">Порядок модуля</label>
                                <input type="number" name="order" id="order" value="{{ old('order', $defaultOrder) }}" min="1" required class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none focus:border-[#7cdebe] focus:ring-2 focus:ring-[#7cdebe]/20 transition">
                                @error('order')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="description" class="block text-gray-300 mb-1 text-sm font-medium">Описание модуля</label>
                            <textarea name="description" id="description" rows="5" class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none resize-none focus:border-[#7cdebe] focus:ring-2 focus:ring-[#7cdebe]/20 transition">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col sm:flex-row justify-end gap-3 mt-6 pt-6 border-t border-gray-700">
                            <a href="{{ route('showCourse', $course) }}" class="px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition text-center order-2 sm:order-1 font-medium">
                                Назад к курсу
                            </a>
                            <button type="submit" class="px-6 py-3 bg-emerald-500 text-gray-900 rounded-xl hover:bg-emerald-600 transition font-bold order-1 sm:order-2 transform hover:scale-105">
                                Создать модуль
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection