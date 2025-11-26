@extends("layout")
@section("main")
<div class="min-h-screen py-8 px-4">
    <div class="max-w-4xl mx-auto bg-[#182023] border border-gray-700 rounded-2xl p-8">
        <h1 class="text-3xl font-bold text-white mb-6">
            Создать модуль для курса "{{ $course->title }}"
        </h1>

        @if(session('success'))
            <div class="bg-emerald-500 text-gray-900 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('saveModule', $course) }}" method="POST" class="space-y-6">
            @csrf
            <div class="flex flex-col gap-6">

                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-gray-300 mb-1">Название модуля</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">
                    </div>

                    <div>
                        <label for="order" class="block text-gray-300 mb-1">Порядок модуля</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $defaultOrder) }}" min="1" required
                               class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="description" class="block text-gray-300 mb-1">Описание модуля</label>
                        <textarea name="description" id="description" rows="5"
                                  class="w-full p-3 rounded-xl bg-gray-900 text-white border border-gray-600 outline-none">{{ old('description') }}</textarea>
                    </div>
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('showCourse', $course) }}"
                   class="px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition">
                    Назад к курсу
                </a>
                <button type="submit" class="px-6 py-3 bg-emerald-500 text-gray-900 rounded-xl hover:bg-emerald-600 transition">
                    Создать модуль
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
