@extends('layout')

@section('main')
    <div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold text-white mb-8">Админский дашборд</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-[#1f2326] rounded-2xl shadow-md p-6 flex flex-col justify-between border border-gray-700 hover:bg-[#25292c] transition">
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-4">Пользователи: {{ $totalUsers }}</h2>
                        <ul class="text-gray-300 space-y-1">
                            @foreach($usersByRole as $role => $count)
                                <li>{{ ucfirst($role) }}: {{ $count }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="{{ route('usersIndex') }}" class="mt-4 inline-block text-center bg-[#2a2e31] text-white font-medium py-2 px-4 rounded-lg hover:bg-[#3a3f44] transition">
                        Управление
                    </a>
                </div>
                <div class="bg-[#1f2326] rounded-2xl shadow-md p-6 flex flex-col justify-between border border-gray-700 hover:bg-[#25292c] transition">
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-4">Категории: {{ $totalCategories }}</h2>
                        <ul class="text-gray-300 space-y-1">
                            @foreach($categoriesWithCourses as $cat)
                                <li>{{ $cat->name }}: {{ $cat->courses_count }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="{{ route('categoriesIndex') }}" class="mt-4 inline-block text-center bg-[#2a2e31] text-white font-medium py-2 px-4 rounded-lg hover:bg-[#3a3f44] transition">
                        Управление
                    </a>
                </div>
                <div class="bg-[#1f2326] rounded-2xl shadow-md p-6 flex flex-col justify-between border border-gray-700 hover:bg-[#25292c] transition">
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-4">Курсы: {{ $totalCourses }}</h2>
                        <p class="text-gray-300">Опубликовано: {{ $publishedCourses }}</p>
                    </div>
                    <a href="{{ route('courses') }}" class="mt-4 inline-block text-center bg-[#2a2e31] text-white font-medium py-2 px-4 rounded-lg hover:bg-[#3a3f44] transition">
                        Управление
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
