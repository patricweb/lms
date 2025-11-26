@extends('layout')

@section('main')
    <div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto bg-[#1f2326] border border-gray-700 rounded-2xl shadow-md p-6">
            <h1 class="text-2xl font-bold text-white mb-6">Создать категорию</h1>
            <form method="POST" action="{{ route('categoriesStore') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-gray-300 mb-2">Название</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 rounded-lg bg-[#25292c] border border-gray-600 text-white placeholder-gray-400 focus:outline-none">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-300 mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" required class="w-full px-4 py-2 rounded-lg bg-[#25292c] border border-gray-600 text-white placeholder-gray-400 focus:outline-none">
                    @error('slug') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-gray-300 mb-2">Описание</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-2 rounded-lg bg-[#25292c] border border-gray-600 text-white placeholder-gray-400 focus:outline-none">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-3 mt-4">
                    <button type="submit"
                            class="bg-emerald-500 hover:bg-emerald-600 text-white font-medium px-6 py-2 rounded-lg transition transform hover:scale-105 shadow hover:shadow-emerald-500/25">
                        Создать
                    </button>
                    <a href="{{ route('categoriesIndex') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium px-6 py-2 rounded-lg transition transform hover:scale-105 shadow hover:shadow-gray-700/25">
                        Назад
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
