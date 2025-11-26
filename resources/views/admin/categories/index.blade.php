@extends('layout')

@section('main')
    <div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto bg-[#1f2326] border border-gray-700 rounded-2xl shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">Категории</h1>
                <a href="{{ route('categoriesCreate') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg font-medium transition transform hover:scale-105 shadow hover:shadow-emerald-500/25">
                    Создать
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-[#25292c]">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">ID</th>
                            <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">Название</th>
                            <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">Slug</th>
                            <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">Курсов</th>
                            <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">Описание</th>
                            <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($categories as $category)
                        <tr class="hover:bg-gray-800">
                            <td class="px-4 py-2 text-gray-300">{{ $category->id }}</td>
                            <td class="px-4 py-2 text-gray-300">{{ $category->name }}</td>
                            <td class="px-4 py-2 text-gray-300">{{ $category->slug }}</td>
                            <td class="px-4 py-2 text-gray-300">{{ $category->courses_count }}</td>
                            <td class="px-4 py-2 text-gray-300">{{ Str::limit($category->description ?? '', 50) }}</td>
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('categoriesDestroy', $category) }}" class="inline" onsubmit="return confirm('Удалить категорию и все курсы?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded transition">
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
