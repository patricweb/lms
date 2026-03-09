@extends('layout')

@section('main')
    <div class="min-h-screen py-8 lg:py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-violet-400 via-purple-400 to-fuchsia-400 bg-clip-text text-transparent mb-2">
                        Каталог курсов
                    </h1>
                    <p class="text-gray-400">Изучайте новое и развивайтесь с нашими курсами</p>
                </div>
                @auth
                    @if($user->role === 'teacher' || $user->role === 'admin')
                        <a href="{{ route('createCourse') }}" class="group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg shadow-violet-500/50 hover:shadow-violet-500/70">
                            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Создать курс
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Filters Section -->
            <div class="mb-8 bg-gray-900/80 backdrop-blur-sm rounded-2xl border border-gray-800 p-6 shadow-2xl">
                <form method="GET" class="space-y-4">
                    <!-- Search and Basic Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="relative md:col-span-2 lg:col-span-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Поиск курсов..." 
                                   autocomplete="off"
                                   class="w-full pl-10 pr-4 py-3 bg-black text-gray-100 border border-gray-800 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition-all">
                            <div id="search-results" class="hidden absolute top-full left-0 right-0 mt-2 bg-gray-900 border border-gray-800 rounded-xl shadow-2xl z-50 max-h-96 overflow-y-auto"></div>
                        </div>
                        
                        <select name="category_id" class="w-full px-4 py-3 bg-black text-gray-100 border border-gray-800 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition-all">
                            <option value="">Все категории</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="price_type" class="w-full px-4 py-3 bg-black text-gray-100 border border-gray-800 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition-all">
                            <option value="">Все цены</option>
                            <option value="free" {{ request('price_type') == 'free' ? 'selected' : '' }}>Бесплатные</option>
                            <option value="paid" {{ request('price_type') == 'paid' ? 'selected' : '' }}>Платные</option>
                        </select>

                        <select name="sort" class="w-full px-4 py-3 bg-black text-gray-100 border border-gray-800 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition-all">
                            <option value="created_desc" {{ request('sort')=='created_desc' ? 'selected' : '' }}>Сначала новые</option>
                            <option value="created_asc" {{ request('sort')=='created_asc' ? 'selected' : '' }}>Сначала старые</option>
                            <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Цена: дешевле</option>
                            <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Цена: дороже</option>
                            <option value="title_asc" {{ request('sort')=='title_asc' ? 'selected' : '' }}>Название A-Z</option>
                            <option value="title_desc" {{ request('sort')=='title_desc' ? 'selected' : '' }}>Название Z-A</option>
                        </select>
                    </div>

                    <!-- Additional Filters Row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <select name="date_filter" class="w-full px-4 py-3 bg-black text-gray-100 border border-gray-800 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition-all">
                            <option value="">Все даты</option>
                            <option value="24h" {{ request('date_filter') == '24h' ? 'selected' : '' }}>Последние 24 часа</option>
                            <option value="7d" {{ request('date_filter') == '7d' ? 'selected' : '' }}>Последние 7 дней</option>
                            <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>Последний месяц</option>
                            <option value="year" {{ request('date_filter') == 'year' ? 'selected' : '' }}>Последний год</option>
                        </select>

                        <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Мин. цена" class="w-full px-4 py-3 bg-black text-gray-100 border border-gray-800 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition-all">

                        <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Макс. цена" class="w-full px-4 py-3 bg-black text-gray-100 border border-gray-800 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition-all">

                        @if($user->role !== 'student')
                        <select name="teacher_id" class="w-full px-4 py-3 bg-black text-gray-100 border border-gray-800 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition-all">
                            <option value="">Все преподаватели</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="status" class="w-full px-4 py-3 bg-black text-gray-100 border border-gray-800 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none transition-all">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Все</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Опубликованные</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновики</option>
                        </select>
                        @endif
                    </div>

                    <!-- Checkboxes Row -->
                    <div class="flex flex-wrap gap-4 items-center">
                        @if($user->role === 'student')
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="my_courses" value="1" {{ request('my_courses') ? 'checked' : '' }} class="w-5 h-5 text-violet-500 bg-black border-gray-800 rounded focus:ring-violet-500 focus:ring-2 transition-all">
                            <span class="text-sm font-medium text-gray-300 group-hover:text-violet-400 transition-colors">Мои курсы</span>
                        </label>
                        @endif
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="favorites" value="1" {{ request('favorites') ? 'checked' : '' }} class="w-5 h-5 text-violet-500 bg-black border-gray-800 rounded focus:ring-violet-500 focus:ring-2 transition-all">
                            <span class="text-sm font-medium text-gray-300 group-hover:text-violet-400 transition-colors">Избранные</span>
                        </label>
                        @if($user->role === 'teacher' || $user->role === 'admin')
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="my_only" value="1" {{ request('my_only') ? 'checked' : '' }} class="w-5 h-5 text-violet-500 bg-black border-gray-800 rounded focus:ring-violet-500 focus:ring-2 transition-all">
                            <span class="text-sm font-medium text-gray-300 group-hover:text-violet-400 transition-colors">Только мои</span>
                        </label>
                        @endif
                        
                        <div class="ml-auto flex gap-3">
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-violet-500/25 hover:shadow-violet-500/40">
                                Применить
                            </button>
                            <a href="{{ route('courses') }}" class="px-6 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold rounded-xl transition-all">
                                Сбросить
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Courses Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($courses as $course)
                    <div class="group bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden hover:border-violet-500 transition-all duration-300 hover:shadow-2xl hover:shadow-violet-500/20 transform hover:-translate-y-2">
                        <!-- Image -->
                        <div class="relative h-48 overflow-hidden">
                            @if($course->thumbnail)
                                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-violet-600 via-purple-600 to-fuchsia-600 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Favorite Button -->
                            @auth
                                <button type="button"
                                        class="js-fav-toggle absolute top-3 right-3 w-10 h-10 rounded-full flex items-center justify-center bg-black/90 backdrop-blur-sm hover:bg-black border border-gray-800 shadow-lg transition-all z-10 cursor-pointer"
                                        data-course-id="{{ $course->id }}"
                                        data-is-favorite="{{ $course->isFavorite ? '1' : '0' }}"
                                        title="{{ $course->isFavorite ? 'Убрать из избранного' : 'В избранное' }}"
                                        style="pointer-events: auto;">
                                    <span class="fav-icon">
                                        @if($course->isFavorite)
                                            <svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        @endif
                                    </span>
                                </button>
                            @endauth

                            <!-- Price Badge -->
                            <div class="absolute bottom-3 left-3">
                                <span class="px-3 py-1.5 bg-black/95 backdrop-blur-sm text-violet-400 font-bold rounded-lg shadow-lg">
                                    {{ $course->price > 0 ? $course->price . ' $' : 'Бесплатно' }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Category Badge -->
                            @if($course->category)
                                <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium bg-violet-900/30 text-violet-300 rounded-full mb-3">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    {{ $course->category->name }}
                                </span>
                            @endif

                            <h3 class="text-xl font-bold text-white mb-2 line-clamp-2 group-hover:text-violet-400 transition-colors">
                                {{ $course->title }}
                            </h3>
                            <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ Str::limit($course->description, 100) }}
                            </p>
                            
                            <!-- Progress Bar -->
                            @auth
                                @if(($course->progress ?? 0) > 0)
                                    <div class="mb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-xs font-medium text-gray-400">Прогресс</span>
                                            <span class="text-xs font-bold {{ ($course->isCompleted ?? false) ? 'text-violet-400' : 'text-violet-400' }}">
                                                {{ $course->progress ?? 0 }}%
                                                @if($course->isCompleted ?? false)
                                                    <span class="ml-1">✓</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="w-full h-2 bg-gray-800 rounded-full overflow-hidden">
                                            <div class="h-full transition-all duration-500 {{ ($course->isCompleted ?? false) ? 'bg-gradient-to-r from-violet-600 to-purple-600' : 'bg-gradient-to-r from-violet-500 to-purple-500' }}" 
                                                 style="width: {{ max($course->progress ?? 0, 1) }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            @endauth

                            <!-- Meta Info -->
                            <div class="flex items-center justify-between text-xs text-gray-400 mb-4">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>{{ $course->teacher->name ?? 'Не указан' }}</span>
                                </div>
                                @if(!$course->is_published)
                                    <span class="px-2 py-1 bg-amber-900/30 text-amber-300 rounded-full font-medium">
                                        Черновик
                                    </span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('showCourse', $course) }}" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold rounded-xl text-center transition-all duration-200 shadow-md shadow-violet-500/25 hover:shadow-violet-500/40">
                                    Открыть
                                </a>
                                @if(($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin')
                                    <form action="{{ route('destroyCourse', $course) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить этот курс?')" class="px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-md shadow-red-500/25 hover:shadow-red-500/40">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-gray-900 rounded-2xl border border-gray-800 p-12 text-center">
                        <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Курсы не найдены</h3>
                        <p class="text-gray-400 mb-6">Попробуйте изменить фильтры или параметры поиска.</p>
                        <a href="{{ route('courses') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-violet-500/25 hover:shadow-violet-500/40">
                            Сбросить фильтры
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($courses->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-gray-900 rounded-xl border border-gray-800 p-2 shadow-lg">
                        {{ $courses->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    @auth
    <script>
        (function() {
            function initFavorites() {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (!token) return;
                
                const buttons = document.querySelectorAll('.js-fav-toggle');
                buttons.forEach((btn) => {
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
                            
                            if (!res.ok) throw new Error('Request failed');
                            
                            const data = await res.json();
                            const newState = !!data.is_favorite;
                            newBtn.dataset.isFavorite = newState ? '1' : '0';
                            
                            const icon = newBtn.querySelector('.fav-icon');
                            if (icon) {
                                if (newState) {
                                    icon.innerHTML = '<svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z"/></svg>';
                                } else {
                                    icon.innerHTML = '<svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                }
                            }
                            newBtn.title = newState ? 'Убрать из избранного' : 'В избранное';
                        } catch (e) {
                            console.error('Favorite toggle error:', e);
                            alert('Не удалось обновить избранное');
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
