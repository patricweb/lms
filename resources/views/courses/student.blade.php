@extends('layout')

@section('main')
<div class="min-h-screen bg-[#182023] py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-[#7cdebe] mb-6">Доступные курсы</h1>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($courses as $course)
                <div class="bg-[#18181b] rounded-2xl border border-gray-700 overflow-hidden hover:border-[#7cdebe] transition-all duration-300">
                    <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/400x200' }}" 
                        alt="{{ $course->title }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-white mb-2">{{ $course->title }}</h2>
                        <p class="text-gray-400 mb-4">{{ Str::limit($course->description, 80) }}</p>
                        <p class="text-gray-300 mb-2">Автор: <span class="text-[#7cdebe]">{{ $course->teacher->name }}</span></p>
                        <p class="text-gray-300 mb-4">Категория: <span class="text-[#7cdebe]">{{ $course->category->name }}</span></p>
                        <a href="{{ route('showCourse', $course) }}" class="px-4 py-2 bg-[#7cdebe] hover:bg-emerald-400 text-gray-900 rounded-lg font-medium">Перейти к курсу</a>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 col-span-full">Курсы не найдены</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $courses->links() }}
        </div>
    </div>
</div>
@endsection
