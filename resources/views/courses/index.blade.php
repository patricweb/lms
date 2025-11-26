@extends('layout')

@section('main')
<div class="min-h-screen bg-[#182023] py-8">
    <div class="container mx-auto px-4">
        {{-- Заголовок --}}
        <div class="mb-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <h1 class="text-3xl font-bold text-[#7cdebe]">
                Курсы
                @if(($user->role === 'teacher' || $user->role === 'admin') && request('my_only'))
                    (только мои)
                @endif
            </h1>
            @auth
                @if($user->role === 'teacher' || $user->role === 'admin')
                    <a href="{{ route('createCourse') }}" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-4 py-2 rounded-lg font-medium transition">
                        + Добавить курс
                    </a>
                @endif
            @endauth
        </div>

        {{-- Фильтры --}}
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-6 items-end">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Поиск..." class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">

            <select name="category_id" class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">
                <option value="">Все категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="date_filter" class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">
                <option value="">Все даты</option>
                <option value="24h" {{ request('date_filter') == '24h' ? 'selected' : '' }}>Последние 24 часа</option>
                <option value="7d" {{ request('date_filter') == '7d' ? 'selected' : '' }}>Последние 7 дней</option>
                <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>Последний месяц</option>
                <option value="year" {{ request('date_filter') == 'year' ? 'selected' : '' }}>Последний год</option>
            </select>

            <select name="price_type" class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">
                <option value="">Все цены</option>
                <option value="free" {{ request('price_type') == 'free' ? 'selected' : '' }}>Бесплатные</option>
                <option value="paid" {{ request('price_type') == 'paid' ? 'selected' : '' }}>Платные</option>
            </select>

            <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Мин цена" 
                   class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">
            <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Макс цена" 
                   class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">

            @if($user->role !== 'student')
            <select name="teacher_id" class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">
                <option value="">Все преподаватели</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Все</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Опубликованные</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновики</option>
            </select>
            @endif

            @if($user->role === 'teacher' || $user->role === 'admin')
            <label class="flex items-center gap-2 text-gray-300 cursor-pointer">
                <input type="checkbox" name="my_only" value="1" {{ request('my_only') ? 'checked' : '' }} class="w-4 h-4 text-purple-500 bg-gray-700 border-gray-600 rounded">
                Только мои
            </label>
            @endif

            <select name="sort" class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">
                <option value="created_desc" {{ request('sort')=='created_desc' ? 'selected' : '' }}>Сначала новые</option>
                <option value="created_asc" {{ request('sort')=='created_asc' ? 'selected' : '' }}>Сначала старые</option>
                <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Цена: дешевле</option>
                <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Цена: дороже</option>
                <option value="title_asc" {{ request('sort')=='title_asc' ? 'selected' : '' }}>Название A-Z</option>
                <option value="title_desc" {{ request('sort')=='title_desc' ? 'selected' : '' }}>Название Z-A</option>
            </select>

            <div class="lg:col-span-3 flex flex-wrap gap-2 mt-4 justify-end">
                <button type="submit" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-gray-900 rounded font-medium transition">Применить</button>
                <a href="{{ route('courses') }}" class="px-5 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded font-medium transition">Сбросить</a>
            </div>
        </form>

        {{-- Список курсов --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($courses as $course)
                <div class="bg-[#18181b] rounded-lg border border-gray-700 overflow-hidden">
                    @if($course->thumbnail)
                        <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-44 object-cover">
                    @else
                        <div class="h-44 flex items-center justify-center bg-[#1f2937]">
                            <h3 class="text-2xl font-bold text-[#7cdebe] text-center px-2">{{ $course['title'] }}</h3>
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-white mb-1">{{ $course->title }}</h3>
                        <p class="text-gray-400 text-sm mb-2">{{ Str::limit($course->description, 100) }}</p>
                        <p class='text-white'>Цена: {{ $course->price > 0 ? $course->price.' $' : 'Бесплатно' }}</p>
                        <br>

                        <div class="flex flex-wrap gap-1 text-xs mb-2">
                            <span class="bg-gray-700 text-white px-2 py-1 rounded-full">Категория: {{ $course->category->name ?? 'Не указана' }}</span>
                            <span class="bg-gray-700 text-white px-2 py-1 rounded-full">Автор: {{ $course->teacher->name ?? 'Не указан' }}</span>
                            <span class="bg-gray-700 text-white px-2 py-1 rounded-full">{{ $course->is_published ? 'Опубликован' : 'Черновик' }}</span>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('showCourse', $course) }}" class="px-3 py-1 bg-emerald-400 text-gray-900 rounded font-medium">Открыть</a>
                            @if(($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin')
                                <form action="{{ route('destroyCourse', $course) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Удалить курс?')" class="px-3 py-1 bg-red-500 text-white rounded font-medium">Удалить</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-[#18181b] rounded-lg border border-gray-700 p-6 text-center">
                    <h3 class="text-lg font-semibold text-white mb-1">Курсы не найдены</h3>
                    <p class="text-gray-400 text-sm">Попробуйте изменить фильтры или поиск.</p>
                </div>
            @endforelse
        </div>

        {{-- Пагинация --}}
        <div class="mt-6">
            {{ $courses->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
