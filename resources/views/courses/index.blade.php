@extends('layout')

@section('main')
<div class="min-h-screen bg-[#182023] py-8">
    <div class="container mx-auto px-4">
        {{-- Заголовок --}}
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-4xl font-bold text-[#7cdebe]">
                Курсы
                @if(($user->role === 'teacher' || $user->role === 'admin') && request('my_only'))
                    (только мои)
                @endif
            </h1>
            @auth
                @if($user->role === 'teacher' || $user->role === 'admin')
                    <a href="{{ route('createCourse') }}" class="inline-flex items-center gap-2 bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-xl font-medium transition">
                        Добавить курс
                    </a>
                @endif
            @endauth
        </div>

        {{-- Фильтры --}}
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6 items-end">
            {{-- Поиск --}}
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Поиск..." 
                   class="w-full px-4 py-2 rounded-lg bg-[#111418] text-white border border-gray-700 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition duration-200">
            
            {{-- Категории --}}
            <select name="category_id" class="w-full px-4 py-2 rounded-lg bg-[#111418] text-white border border-gray-700 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition duration-200">
                <option value="">Все категории</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            
            {{-- Дата создания --}}
            <select name="date_filter" class="w-full px-4 py-2 rounded-lg bg-[#111418] text-white border border-gray-700 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition duration-200">
                <option value="">Все даты</option>
                <option value="24h" {{ request('date_filter') == '24h' ? 'selected' : '' }}>Последние 24 часа</option>
                <option value="7d" {{ request('date_filter') == '7d' ? 'selected' : '' }}>Последние 7 дней</option>
                <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>Последний месяц</option>
                <option value="year" {{ request('date_filter') == 'year' ? 'selected' : '' }}>Последний год</option>
            </select>
            
            {{-- Тип цены --}}
            <select name="price_type" class="w-full px-4 py-2 rounded-lg bg-[#111418] text-white border border-gray-700 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition duration-200">
                <option value="">Все цены</option>
                <option value="free" {{ request('price_type') == 'free' ? 'selected' : '' }}>Бесплатные</option>
                <option value="paid" {{ request('price_type') == 'paid' ? 'selected' : '' }}>Платные</option>
            </select>
            
            {{-- Мин/Макс цена --}}
            <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Мин цена" 
                   class="w-full px-4 py-2 rounded-lg bg-[#111418] text-white border border-gray-700 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition duration-200">
            <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Макс цена" 
                   class="w-full px-4 py-2 rounded-lg bg-[#111418] text-white border border-gray-700 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition duration-200">
            
            {{-- Преподаватель (teacher/admin) --}}
            @if($user->role !== 'student')
            <select name="teacher_id" class="w-full px-4 py-2 rounded-lg bg-[#111418] text-white border border-gray-700 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition duration-200">
                <option value="">Все преподаватели</option>
                @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->name }}
                </option>
                @endforeach
            </select>
            @endif
            
            {{-- Статус (только teacher/admin) --}}
            @if($user->role !== 'student')
            <select name="status" class="w-full px-4 py-2 rounded-lg bg-[#111418] text-white border border-gray-700 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition duration-200">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Все</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Опубликованные</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновики</option>
            </select>
            @endif
            
            {{-- Только мои (teacher) --}}
            @if($user->role === 'teacher' || $user->role === 'admin')
            <label class="flex items-center gap-2 text-gray-300 cursor-pointer">
                <input type="checkbox" name="my_only" value="1" {{ request('my_only') ? 'checked' : '' }} class="w-4 h-4 text-purple-500 bg-gray-700 border-gray-600 rounded focus:ring-purple-500 focus:ring-2">
                Только мои
            </label>
            @endif
            
            {{-- Сортировка --}}
            <select name="sort" class="w-full px-4 py-2 rounded-lg bg-[#111418] text-white border border-gray-700 outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition duration-200">
                <option value="created_desc" {{ request('sort')=='created_desc' ? 'selected' : '' }}>Сначала новые</option>
                <option value="created_asc" {{ request('sort')=='created_asc' ? 'selected' : '' }}>Сначала старые</option>
                <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Цена: дешевле</option>
                <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Цена: дороже</option>
                <option value="title_asc" {{ request('sort')=='title_asc' ? 'selected' : '' }}>Название A-Z</option>
                <option value="title_desc" {{ request('sort')=='title_desc' ? 'selected' : '' }}>Название Z-A</option>
            </select>
            
            {{-- Кнопки --}}
            <div class="lg:col-span-3 flex justify-end gap-2 mt-4">
                <button type="submit" class="px-6 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-medium transition duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    Применить
                </button>
                <a href="{{ route('courses') }}" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-medium transition duration-200 text-center">
                    Сбросить
                </a>
            </div>
        </form>

        {{-- Список курсов --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($courses as $course)
                <div class="bg-[#18181b] rounded-2xl border border-gray-700 overflow-hidden hover:border-purple-500 transition-all duration-300 shadow-sm">
                    @if($course->thumbnail)
                        <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="h-48 flex items-center justify-center bg-[#1f2937]">
                            <h3 class="text-3xl font-bold text-[#7cdebe] text-center px-4">
                                {{ $course['title'] }}
                            </h3>
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-white mb-3">{{ $course->title }}</h3>
                        <p class="text-gray-400 text-sm mb-3">{{ Str::limit($course->description, 120) }}</p>

                        {{-- Бэйджи --}}
                        <div class="flex flex-wrap gap-2 text-xs">
                            <span class="bg-gray-700 text-white px-2 py-1 rounded-full">Категория: {{ $course->category->name ?? 'Не указана' }}</span>
                            <span class="bg-gray-700 text-white px-2 py-1 rounded-full">Автор: {{ $course->teacher->name ?? 'Не указан' }}</span>
                            <span class="bg-gray-700 text-white px-2 py-1 rounded-full">Цена: {{ $course->price > 0 ? $course->price.' ₽' : 'Бесплатно' }}</span>
                            <span class="bg-gray-700 text-white px-2 py-1 rounded-full">{{ $course->is_published ? 'Опубликован' : 'Черновик' }}</span>
                        </div>

                        {{-- Кнопки --}}
                        <div class="mt-4 flex flex-wrap gap-3 items-center">
                            <a href="{{ route('showCourse', $course) }}" class="px-4 py-2 bg-[#7cdebe] hover:bg-emerald-400 text-gray-900 rounded-lg font-medium transition">Открыть</a>
                            @if(($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin')
                                <a href="{{ route('editCourse', $course) }}" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-medium transition">Редактировать</a>
                                <form action="{{ route('destroyCourse', $course) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Удалить курс?')" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition">Удалить</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-[#18181b] rounded-2xl border border-gray-700 p-8 text-center">
                    <h3 class="text-xl font-semibold text-white mb-2">Курсы не найдены</h3>
                    <p class="text-gray-400">Попробуйте изменить фильтры или поиск.</p>
                </div>
            @endforelse
        </div>

        {{-- Пагинация --}}
        <div class="mt-8">
            {{ $courses->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
