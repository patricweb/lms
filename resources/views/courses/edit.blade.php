@extends('layout')

@section('main')
    <div class="max-w-4xl mx-auto pt-10 bg-[#111418]  border border-gray-600 px-6 rounded-xl mt-2 mb-2">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-white tracking-tight">Редактирование курса</h1>
        </div>
        <form action="{{ route('updateCourse', $course) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            @method('PUT')
            <div class=" p-8 space-y-6">
                <h2 class="text-xl font-semibold text-white">Основная информация</h2>
                <div class="space-y-2">
                    <label class="text-gray-300 font-medium">Название курса</label>
                    <input type="text" name="title" value="{{ old('title', $course->title) }}" class="w-full bg-[#0d1013] text-white px-4 py-3 rounded-lg border border-gray-700 outline-none transition">
                </div>
                <div class="space-y-2">
                    <label class="text-gray-300 font-medium">Описание</label>
                    <textarea name="description" rows="5" class="w-full bg-[#0d1013] text-white px-4 py-3 rounded-lg border border-gray-700 outline-none transition">{{ old('description', $course->description) }}</textarea>
                </div>
                <div class="space-y-2">
                    <label class="text-gray-300 font-medium">Цена</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $course->price) }}" class="w-full bg-[#0d1013] text-white px-4 py-3 rounded-lg border border-gray-700 outline-none transition">
                </div>
            </div>
            <div class="p-8 space-y-6">
                <h2 class="text-xl font-semibold text-white">Категория и миниатюра</h2>
                <div class="space-y-2">
                    <label class="text-gray-300 font-medium">Категория</label>
                    <select name="category_id" class="w-full bg-[#0d1013] text-white px-4 py-3 rounded-lg border border-gray-700 transition">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" 
                                {{ $cat->id == $course->category_id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-3">
                    <label class="text-gray-300 font-medium">Миниатюра курса</label>
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}"
                            class="h-48 w-full object-cover rounded-lg border border-gray-700 shadow-md">
                    @endif
                    <input type="file" name="thumbnail" class="w-full text-gray-300 bg-[#0d1013] border border-gray-700 p-2 rounded-lg cursor-pointer file:bg-[#1a1f24] file:text-gray-300 file:border-0 file:px-4 file:py-2 file:rounded-lg">
                </div>
            </div>
            <div class="p-8 space-y-6">
                <h2 class="text-xl font-semibold text-white">Публикация</h2>
                <div class="flex items-center gap-3">
                    <input id='course' type="checkbox" name="is_published" value="1" class="w-5 h-5 bg-[#0d1013] border-gray-600 rounded cursor-pointer" {{ $course->is_published ? 'checked' : '' }}>
                    <label for='course' class="text-gray-300 font-medium">Опубликовать курс</label>
                </div>
            </div>
            <div class="pt-4 mb-6">
                <button type="submit"
                    class="px-10 py-3 bg-emerald-600 hover:bg-emerald-700 text-text-gray-900 text-lg rounded-xl font-semibold transition">
                    Сохранить изменения
                </button>
            </div>
        </form>
    </div>
@endsection
