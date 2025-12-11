@extends('layout')

@section('main')
    <div class="min-h-screen bg-[#182023] py-8">
        <div class="container mx-auto px-4">
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
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-6 items-end">
                <div class="relative">
                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Поиск курсов..." autocomplete="off" class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">
                    <div id="search-results" class="hidden absolute top-full left-0 right-0 mt-1 bg-[#111418] border border-gray-700 rounded-lg shadow-lg z-50 max-h-96 overflow-y-auto"></div>
                </div>
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
                <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Мин цена" class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">
                <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Макс цена" class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">
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
                <select name="sort" class="w-full px-3 py-2 rounded bg-[#111418] text-white border border-gray-700 focus:border-purple-500 outline-none">
                    <option value="created_desc" {{ request('sort')=='created_desc' ? 'selected' : '' }}>Сначала новые</option>
                    <option value="created_asc" {{ request('sort')=='created_asc' ? 'selected' : '' }}>Сначала старые</option>
                    <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Цена: дешевле</option>
                    <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Цена: дороже</option>
                    <option value="title_asc" {{ request('sort')=='title_asc' ? 'selected' : '' }}>Название A-Z</option>
                    <option value="title_desc" {{ request('sort')=='title_desc' ? 'selected' : '' }}>Название Z-A</option>
                </select>
                @if($user->role === 'student')
                <label class="flex items-center gap-2 text-gray-300 cursor-pointer">
                    <input type="checkbox" name="my_courses" value="1" {{ request('my_courses') ? 'checked' : '' }} class="w-4 h-4 text-purple-500 bg-gray-700 border-gray-600 rounded">
                    Только мои курсы
                </label>
                @endif
                <label class="flex items-center gap-2 text-gray-300 cursor-pointer">
                    <input type="checkbox" name="favorites" value="1" {{ request('favorites') ? 'checked' : '' }} class="w-4 h-4 text-purple-500 bg-gray-700 border-gray-600 rounded">
                    Избранные
                </label>
                @if($user->role === 'teacher' || $user->role === 'admin')
                <label class="flex items-center gap-2 text-gray-300 cursor-pointer">
                    <input type="checkbox" name="my_only" value="1" {{ request('my_only') ? 'checked' : '' }} class="w-4 h-4 text-purple-500 bg-gray-700 border-gray-600 rounded">
                    Только мои
                </label>
                @endif
                <div class="lg:col-span-3 flex flex-wrap gap-2 mt-4 justify-end">
                    <button type="submit" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-gray-900 rounded font-medium transition">Применить</button>
                    <a href="{{ route('courses') }}" class="px-5 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded font-medium transition">Сбросить</a>
                </div>
            </form>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($courses as $course)
                    <div class="bg-[#18181b] rounded-lg border border-gray-700 overflow-hidden relative">
                        @if($course->thumbnail)
                            <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-44 object-cover">
                        @else
                            <div class="h-44 flex items-center justify-center bg-[#1f2937]">
                                <h3 class="text-2xl font-bold text-[#7cdebe] text-center px-2">{{ $course['title'] }}</h3>
                            </div>
                        @endif
                        @auth
                            <button type="button" class="js-fav-toggle absolute top-3 right-3 w-9 h-9 rounded-full flex items-center justify-center bg-[#0f172a]/80 hover:bg-[#0f172a] border border-gray-700 text-sm transition z-10 cursor-pointer" data-course-id="{{ $course->id }}" data-is-favorite="{{ $course->isFavorite ? '1' : '0' }}" title="{{ $course->isFavorite ? 'Убрать из избранного' : 'В избранное' }}" style="pointer-events: auto;">
                                <span class="fav-icon">
                                    @if($course->isFavorite)
                                        <svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-white/60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @endif
                                </span>
                            </button>
                        @endauth
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-white mb-1">{{ $course->title }}</h3>
                            <p class="text-gray-400 text-sm mb-2">{{ Str::limit($course->description, 100) }}</p>
                            @auth
                                @if(($course->progress ?? 0) > 0)
                                    <div class="mb-3">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-xs text-gray-400">Прогресс</span>
                                            <span class="text-xs font-semibold {{ ($course->isCompleted ?? false) ? 'text-emerald-400' : 'text-[#7cdebe]' }}">
                                                {{ $course->progress ?? 0 }}%
                                                @if($course->isCompleted ?? false)
                                                    ✓
                                                @endif
                                            </span>
                                        </div>
                                        <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-2 transition-all duration-300 {{ ($course->isCompleted ?? false) ? 'bg-emerald-500' : 'bg-[#7cdebe]' }}" style="width: {{ max($course->progress ?? 0, 1) }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            @endauth
                            <p class='text-white mb-2'>Цена: {{ $course->price > 0 ? $course->price.' $' : 'Бесплатно' }}</p>
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
            <div class="mt-6">
                {{ $courses->withQueryString()->links() }}
            </div>
        </div>
    </div>
    @auth
    <script>
        (function() 
        {
            function initFavorites() {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (!token) {
                    console.error('CSRF token not found');
                    return;
                }
                const buttons = document.querySelectorAll('.js-fav-toggle');
                buttons.forEach((btn, index) => {
                    const newBtn = btn.cloneNode(true);
                    btn.parentNode.replaceChild(newBtn, btn);
                    newBtn.addEventListener('click', async (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        const courseId = newBtn.dataset.courseId;
                        const isFavorite = newBtn.dataset.isFavorite === '1';
                        const url = isFavorite
                            ? `/courses/${courseId}/unfavorite`
                            : `/courses/${courseId}/favorite`;
                        newBtn.disabled = true;
                        newBtn.style.opacity = '0.5';
                        
                        try {
                            const res = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': token,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                credentials: 'same-origin'
                            });
                            
                            if (!res.ok) {
                                const errorText = await res.text();
                                console.error('Error response:', errorText);
                                let errorData = {};
                                try {
                                    errorData = JSON.parse(errorText);
                                } catch (e) {
                                    console.error('Failed to parse error:', e);
                                }
                                throw new Error(errorData.message || 'Request failed');
                            }
                            
                            const data = await res.json();

                            const newState = !!data.is_favorite;
                            newBtn.dataset.isFavorite = newState ? '1' : '0';
                            
                            const icon = newBtn.querySelector('.fav-icon');
                            if (icon) {
                                if (newState) {
                                    icon.innerHTML = '<svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z"/></svg>';
                                } else {
                                    icon.innerHTML = '<svg class="w-5 h-5 text-white/60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" xmlns="http://www.w3.org/2000/svg"><path d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                }
                            }
                            newBtn.title = newState ? 'Убрать из избранного' : 'В избранное';
                        } catch (e) {
                            console.error('Favorite toggle error:', e);
                            alert('Не удалось обновить избранное: ' + e.message);
                        } finally {
                            newBtn.disabled = false;
                            newBtn.style.opacity = '1';
                        }
                    });
                });
            }
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initFavorites);
            } else {
                initFavorites();
            }
        })();
    </script>
    @endauth
@endsection
