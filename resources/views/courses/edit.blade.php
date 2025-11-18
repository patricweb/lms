@extends('layout')

@section('main')
    <form action="{{ route('updateCourse', $course) }}" 
        method="POST" 
        enctype="multipart/form-data" 
        class="space-y-6">

        @csrf
        @method('PUT')

        <!-- Title -->
        <div>
            <label class="block text-gray-300 mb-1">Название курса</label>
            <input type="text" name="title" value="{{ old('title', $course->title) }}"
                class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600">
        </div>

        <!-- Description -->
        <div>
            <label class="block text-gray-300 mb-1">Описание</label>
            <textarea name="description" rows="4"
                    class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600">{{ old('description', $course->description) }}</textarea>
        </div>

        <!-- Price -->
        <div>
            <label class="block text-gray-300 mb-1">Цена (может быть пустой)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $course->price) }}"
                class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600">
        </div>

        <!-- Category -->
        <div>
            <label class="block text-gray-300 mb-1">Категория</label>
            <select name="category_id"
                    class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" 
                        {{ $cat->id == $course->category_id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Thumbnail -->
        <div>
            <label class="block text-gray-300 mb-1">Миниатюра</label>

            @if($course->thumbnail)
                <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                    class="h-32 rounded mb-2">
            @endif

            <input type="file" name="thumbnail"
                class="block w-full text-gray-300">
        </div>

        <!-- Publish -->
        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_published" value="1"
                {{ $course->is_published ? 'checked' : '' }}
                class="w-5 h-5">
            <label class="text-gray-300">Опубликовать курс</label>
        </div>

        <!-- Submit -->
        <button type="submit"
                class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold">
            Сохранить изменения
        </button>
    </form>
@endsection