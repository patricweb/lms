@extends("layout")

@section("main")
    <div class="min-h-screen py-8 lg:py-12" x-data="{ openModules: {} }">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Course Header -->
            <div class="bg-gray-800 rounded-3xl border border-gray-700 shadow-2xl overflow-hidden mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8 lg:p-12">
                    <!-- Left Column - Info -->
                    <div class="space-y-6">
                        <!-- Title & Description -->
                        <div>
                            <h1 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-violet-400 via-purple-400 to-fuchsia-400 bg-clip-text text-transparent mb-4">
                                {{ $course->title }}
                            </h1>
                            <p class="text-lg text-gray-400 leading-relaxed">
                                {{ $course->description }}
                            </p>
                        </div>

                        <!-- Meta Info -->
                        <div class="flex flex-wrap gap-4">
                            @if($course->category)
                                <div class="flex items-center gap-2 px-4 py-2 bg-violet-900/30 rounded-xl">
                                    <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <span class="text-sm font-semibold text-violet-300">{{ $course->category->name }}</span>
                                </div>
                            @endif
                            <div class="flex items-center gap-2 px-4 py-2 bg-blue-900/30 rounded-xl">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-sm font-semibold text-blue-300">{{ optional($course->teacher)->name ?? 'Не указан' }}</span>
                            </div>
                        </div>

                        <!-- Price & Actions -->
                        <div class="flex flex-wrap items-center gap-4 pt-4 border-t border-gray-700">
                            <div class="text-3xl font-bold bg-gradient-to-r from-violet-400 to-purple-400 bg-clip-text text-transparent">
                                {{ $course->price > 0 ? $course->price . ' $' : 'Бесплатно' }}
                            </div>
                            
                            @auth
                                <!-- Favorite Button -->
                                <button type="button"
                                        class="js-fav-toggle flex items-center gap-2 px-5 py-2.5 bg-gray-700 border-2 border-gray-600 hover:border-red-500 text-gray-300 rounded-xl font-semibold transition-all"
                                        data-course-id="{{ $course->id }}"
                                        data-is-favorite="{{ ($isFavorite ?? false) ? '1' : '0' }}">
                                    <svg class="w-5 h-5 {{ ($isFavorite ?? false) ? 'text-red-500 fill-current' : 'text-gray-400' }}" viewBox="0 0 24 24" fill="{{ ($isFavorite ?? false) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2">
                                        <path d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z"/>
                                    </svg>
                                    <span class="fav-label">{{ ($isFavorite ?? false) ? 'В избранном' : 'В избранное' }}</span>
                                </button>

                                <!-- Enrollment Actions -->
                                @if($user->role === 'student')
                                    @if($isEnrolled ?? false)
                                        <form action="{{ route('unenrollCourse', $course) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold transition-all shadow-lg shadow-red-500/25">
                                                Отписаться
                                            </button>
                                        </form>
                                    @elseif($isPending ?? false)
                                        <span class="px-5 py-2.5 bg-amber-900/30 border-2 border-amber-500 text-amber-300 rounded-xl font-semibold">
                                            Ожидает одобрения
                                        </span>
                                    @else
                                        <form action="{{ route('enrollCourse', $course) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white rounded-xl font-semibold transition-all shadow-lg shadow-violet-500/25 hover:shadow-violet-500/40">
                                                Записаться на курс
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                <!-- Edit Actions -->
                                @if(!empty($canEdit) && $canEdit)
                                    <div class="flex gap-3">
                                        <a href="{{ route('editCourse', $course) }}" class="px-5 py-2.5 bg-gradient-to-r from-violet-500 to-fuchsia-500 hover:from-violet-600 hover:to-fuchsia-600 text-white rounded-xl font-semibold transition-all shadow-lg shadow-blue-500/25">
                                            Редактировать
                                        </a>
                                        <form method="POST" action="{{ route('destroyCourse', $course) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-semibold transition-all shadow-lg shadow-red-500/25" onclick="return confirm('Вы уверены, что хотите удалить этот курс?')">
                                                Удалить
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <!-- Progress (if enrolled) -->
                        @auth
                            @if(($progress ?? 0) > 0)
                                <div class="pt-4 border-t border-gray-700">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-semibold text-gray-300">Прогресс курса</span>
                                        <span class="text-lg font-bold {{ !empty($isCompleted) && $isCompleted ? 'text-violet-400' : 'text-blue-400' }}">
                                            {{ $progress ?? 0 }}%
                                            @if(!empty($isCompleted) && $isCompleted)
                                                <span class="ml-1">✓</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="w-full h-3 bg-gray-700 rounded-full overflow-hidden">
                                        <div class="h-full transition-all duration-700 {{ !empty($isCompleted) && $isCompleted ? 'bg-gradient-to-r from-violet-500 to-purple-500' : 'bg-gradient-to-r from-violet-500 to-fuchsia-500' }}" 
                                             style="width: {{ max($progress ?? 0, 1) }}%"></div>
                                    </div>
                                    @if(!empty($isCompleted) && $isCompleted && $course->hasCertificateForUser($user))
                                        <a href="{{ route('certificates.index') }}" class="inline-flex items-center gap-2 mt-3 px-4 py-2 bg-violet-900/30 hover:bg-violet-900/50 text-violet-300 rounded-xl font-semibold transition-colors text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                            </svg>
                                            Сертификат доступен
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endauth
                    </div>

                    <!-- Right Column - Image -->
                    <div class="flex items-center justify-center">
                        @if($course->thumbnail)
                            <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-64 lg:h-80 object-cover rounded-2xl shadow-2xl ring-4 ring-slate-700">
                        @else
                            <div class="w-full h-64 lg:h-80 rounded-2xl bg-gradient-to-br from-violet-500 via-purple-500 to-fuchsia-500 flex items-center justify-center shadow-2xl">
                                <div class="text-center p-8">
                                    <svg class="w-20 h-20 text-white/80 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <h3 class="text-2xl font-bold text-white">{{ $course->title }}</h3>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pending Enrollments Alert -->
                @auth
                    @if(($canEdit ?? false) && ($pendingEnrollmentsCount ?? 0) > 0)
                        <div class="bg-amber-900/20 border-t border-amber-800 p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-amber-200">
                                        У вас {{ $pendingEnrollmentsCount }} {{ $pendingEnrollmentsCount == 1 ? 'заявка' : 'заявок' }} на запись
                                    </p>
                                    <p class="text-sm text-amber-300 mt-1">Требуется ваше одобрение</p>
                                </div>
                                <a href="{{ route('courseEnrollments', $course) }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-semibold transition-all shadow-lg shadow-amber-500/25 whitespace-nowrap">
                                    Перейти к заявкам
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Modules & Lessons -->
            <div class="bg-gray-800 rounded-3xl border border-gray-700 shadow-xl p-8 mb-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-white flex items-center gap-3">
                        <span class="w-1 h-10 bg-gradient-to-b from-violet-500 to-purple-500 rounded-full"></span>
                        Модули и уроки
                    </h2>
                    @auth
                        @if(!empty($canEdit) && $canEdit)
                            <a href="{{ route('createModule', $course) }}" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white rounded-xl font-semibold transition-all shadow-lg shadow-violet-500/25">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Добавить модуль
                            </a>
                        @endif
                    @endauth
                </div>

                @auth
                    @if($user->role === 'student' && ($isPending ?? false))
                        <div class="mb-6 bg-amber-900/20 border-2 border-amber-700 rounded-xl p-4">
                            <p class="text-sm font-semibold text-amber-200">
                                Ваша заявка ожидает одобрения преподавателем/администратором.
                            </p>
                            <p class="text-xs text-amber-300 mt-1">
                                После одобрения откроется полный доступ к курсу.
                            </p>
                        </div>
                    @elseif($user->role === 'student' && !($isEnrolled ?? false))
                        <div class="mb-6 bg-blue-900/20 border-2 border-blue-700 rounded-xl p-4">
                            <p class="text-sm font-semibold text-blue-200">
                                Запишитесь на курс, чтобы получить доступ ко всем модулям и урокам.
                            </p>
                            <p class="text-xs text-blue-300 mt-1">
                                Ниже показаны только бесплатные превью уроки.
                            </p>
                        </div>
                    @endif
                @endauth

                @if($course->modules->isEmpty())
                    <div class="text-center py-16">
                        <div class="w-20 h-20 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <p class="text-gray-400">
                            @if($user->role === 'student' && !($isEnrolled ?? false))
                                Запишитесь на курс, чтобы увидеть модули и уроки
                            @else
                                Модули не добавлены
                            @endif
                        </p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($course->modules as $moduleIndex => $module)
                            <div class="border-2 border-gray-700 rounded-2xl overflow-hidden hover:border-violet-500 transition-all" x-data="{ isOpen: {{ $moduleIndex === 0 ? 'true' : 'false' }} }">
                                <!-- Module Header -->
                                <button @click="isOpen = !isOpen" class="w-full bg-gradient-to-r from-slate-700 to-slate-800 p-6 flex justify-between items-center hover:from-violet-900/20 hover:to-purple-900/20 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gradient-to-r from-violet-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                            {{ $module->order ?? $moduleIndex + 1 }}
                                        </div>
                                        <div class="text-left">
                                            @if($hasAccess ?? true)
                                                <a href="{{ route('showModule', [$course, $module]) }}" class="text-xl font-bold text-white hover:text-violet-400 transition-colors" @click.stop>
                                                    {{ $module->title }}
                                                </a>
                                            @else
                                                <span class="text-xl font-bold text-white">{{ $module->title }}</span>
                                            @endif
                                            <p class="text-sm text-gray-400 mt-1">{{ $module->lessons->count() }} {{ $module->lessons->count() == 1 ? 'урок' : 'уроков' }}</p>
                                        </div>
                                    </div>
                                    <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" :class="{'rotate-180': isOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <!-- Lessons -->
                                <div x-show="isOpen" x-collapse class="bg-gray-800">
                                    <div class="p-6 space-y-3">
                                        @forelse($module->lessons as $lessonIndex => $lesson)
                                            @php
                                                $isCompleted = auth()->check() && $lesson->completions->where('user_id', auth()->id())->isNotEmpty();
                                            @endphp
                                            <a href="{{ ($lesson->can_access ?? true) ? route('showLesson', [$course, $module, $lesson]) : '#' }}" 
                                               class="group flex items-center gap-4 p-4 rounded-xl border-2 {{ ($lesson->can_access ?? true) ? 'border-gray-700 hover:border-violet-500 hover:shadow-lg bg-gray-800' : 'border-gray-600 bg-gray-700/50 opacity-60' }} transition-all">
                                                <div class="relative flex-shrink-0">
                                                    <div class="w-12 h-12 {{ ($lesson->can_access ?? true) ? 'bg-gradient-to-r from-violet-500 to-purple-500' : 'bg-gray-400' }} rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                                        {{ $lesson->order ?? $lessonIndex + 1 }}
                                                    </div>
                                                    @if($isCompleted)
                                                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-violet-500 rounded-full flex items-center justify-center ring-2 ring-slate-800">
                                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-lg font-bold text-white group-hover:text-violet-400 transition-colors mb-1">
                                                        {{ $lesson->title }}
                                                        @if($lesson->is_free_preview)
                                                            <span class="ml-2 text-xs font-semibold px-2 py-0.5 bg-violet-900/30 text-violet-300 rounded-full">Бесплатный превью</span>
                                                        @endif
                                                    </h4>
                                                    <div class="flex items-center gap-3 text-sm text-gray-400">
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            {{ $lesson->duration }} мин
                                                        </span>
                                                        @if($isCompleted)
                                                            <span class="text-violet-400 font-semibold">Завершено</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if($lesson->can_access ?? true)
                                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-violet-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                @else
                                                    <span class="text-xs text-gray-400">Запишитесь на курс</span>
                                                @endif
                                            </a>
                                        @empty
                                            <p class="text-center text-gray-400 py-4">Уроков пока нет</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Comments Section -->
            <div class="bg-gray-800 rounded-3xl border border-gray-700 shadow-xl p-8">
                <h2 class="text-3xl font-bold text-white mb-8 flex items-center gap-3">
                    <span class="w-1 h-10 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></span>
                    Комментарии к курсу
                </h2>

                @auth
                    <form method="POST" action="{{ route('storeCourseComment', $course) }}" class="mb-8">
                        @csrf
                        <div class="space-y-4">
                            <textarea name="comment" 
                                      class="w-full p-4 rounded-xl bg-gray-900 text-white border-2 border-gray-600 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 outline-none transition-all resize-none" 
                                      rows="4" 
                                      placeholder="Напишите ваш комментарий..." 
                                      required></textarea>
                            <input type="hidden" name="parent_id" id="course_parent_id">
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white font-semibold rounded-xl transition-all shadow-lg shadow-violet-500/25">
                                Отправить комментарий
                            </button>
                        </div>
                    </form>
                @endauth

                <div class="space-y-6">
                    @if($course->courseComments->whereNull('parent_id')->count() > 0)
                        @foreach($course->courseComments->whereNull('parent_id') as $comment)
                            @include('courses.comment-item', ['comment'=>$comment,'level'=>0,'course'=>$course,'user'=>$user])
                        @endforeach
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <p class="text-gray-400">Комментариев пока нет. Будьте первым!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @auth
    <script>
        (function() {
            function initFavorite() {
                const btn = document.querySelector('.js-fav-toggle');
                if (!btn) return;
                
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                if (!token) return;

                btn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const courseId = btn.dataset.courseId;
                    const isFavorite = btn.dataset.isFavorite === '1';
                    const url = isFavorite
                        ? `/courses/${courseId}/unfavorite`
                        : `/courses/${courseId}/favorite`;

                    btn.disabled = true;
                    btn.style.opacity = '0.5';
                    
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
                        btn.dataset.isFavorite = newState ? '1' : '0';
                        
                        const label = btn.querySelector('.fav-label');
                        const svg = btn.querySelector('svg');
                        if (label) {
                            label.textContent = newState ? 'В избранном' : 'В избранное';
                        }
                        if (svg) {
                            if (newState) {
                                svg.classList.remove('text-gray-400');
                                svg.classList.add('text-red-500', 'fill-current');
                                svg.setAttribute('fill', 'currentColor');
                            } else {
                                svg.classList.remove('text-red-500', 'fill-current');
                                svg.classList.add('text-gray-400');
                                svg.setAttribute('fill', 'none');
                            }
                        }
                    } catch (e) {
                        console.error('Favorite toggle error:', e);
                        alert('Не удалось обновить избранное');
                    } finally {
                        btn.disabled = false;
                        btn.style.opacity = '1';
                    }
                });
            }
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initFavorite);
            } else {
                initFavorite();
            }
        })();
    </script>
    @endauth
@endsection
