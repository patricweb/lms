@extends('layout')

@section('main')
<div class="max-w-4xl mx-auto pt-10">

    <!-- Header -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-white tracking-tight">Редактирование курса</h1>
    </div>

    <form action="{{ route('updateCourse', $course) }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="space-y-10">

        @csrf
        @method('PUT')

        <!-- Section 1 -->
        <div class="bg-[#111418] border border-gray-800 rounded-xl shadow-lg shadow-black/30 p-8 space-y-6">

            <h2 class="text-xl font-semibold text-white">Основная информация</h2>

            <!-- Title -->
            <div class="space-y-2">
                <label class="text-gray-300 font-medium">Название курса</label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}"
                       class="w-full bg-[#0d1013] text-white px-4 py-3 rounded-lg border border-gray-700
                              focus:border-purple-500 focus:ring focus:ring-purple-700/30 outline-none transition">
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label class="text-gray-300 font-medium">Описание</label>
                <textarea name="description" rows="5"
                    class="w-full bg-[#0d1013] text-white px-4 py-3 rounded-lg border border-gray-700
                           focus:border-purple-500 focus:ring focus:ring-purple-700/30 outline-none transition">{{ old('description', $course->description) }}</textarea>
            </div>

            <!-- Price -->
            <div class="space-y-2">
                <label class="text-gray-300 font-medium">Цена</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $course->price) }}"
                       class="w-full bg-[#0d1013] text-white px-4 py-3 rounded-lg border border-gray-700
                              focus:border-purple-500 focus:ring focus:ring-purple-700/30 outline-none transition">
            </div>

        </div>

        <!-- Section 2 -->
        <div class="bg-[#111418] border border-gray-800 rounded-xl shadow-lg shadow-black/30 p-8 space-y-6">

            <h2 class="text-xl font-semibold text-white">Категория и миниатюра</h2>

            <!-- Category -->
            <div class="space-y-2">
                <label class="text-gray-300 font-medium">Категория</label>
                <select name="category_id"
                        class="w-full bg-[#0d1013] text-white px-4 py-3 rounded-lg border border-gray-700
                               focus:border-purple-500 focus:ring focus:ring-purple-700/30 transition">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" 
                            {{ $cat->id == $course->category_id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Thumbnail -->
            <div class="space-y-3">
                <label class="text-gray-300 font-medium">Миниатюра курса</label>

                @if($course->thumbnail)
                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                        class="h-48 w-full object-cover rounded-lg border border-gray-700 shadow-md">
                @endif

                <input type="file" name="thumbnail"
                    class="w-full text-gray-300 bg-[#0d1013] border border-gray-700 p-2 rounded-lg cursor-pointer
                           file:bg-[#1a1f24] file:text-gray-300 file:border-0 file:px-4 file:py-2 file:rounded-lg
                           hover:file:bg-purple-700/60 transition">
            </div>

        </div>

        <!-- Section 3 -->
        <div class="bg-[#111418] border border-gray-800 rounded-xl shadow-lg shadow-black/30 p-8 space-y-6">

            <h2 class="text-xl font-semibold text-white">Публикация</h2>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_published" value="1"
                    {{ $course->is_published ? 'checked' : '' }}
                    class="w-5 h-5 bg-[#0d1013] border-gray-600 rounded cursor-pointer
                           checked:bg-purple-600 checked:border-purple-600 transition">
                <label class="text-gray-300 font-medium">Опубликовать курс</label>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="pt-4 mb-6">
            <button type="submit"
                class="px-10 py-3 bg-purple-600 hover:bg-purple-700 text-white text-lg rounded-xl font-semibold
                       shadow-lg shadow-purple-800/30 transition active:scale-95">
                Сохранить изменения
            </button>
        </div>

    </form>
</div>
@endsection
