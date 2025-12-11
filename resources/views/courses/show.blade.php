@extends("layout")

@section("main")
    <div class="min-h-screen py-4 md:py-8" x-data="{ openModules: {} }">
        <div class="border border-gray-600 rounded-xl container mx-auto px-2 sm:px-4">
            <div class="rounded-2xl p-4 sm:p-8 mb-6 sm:mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 items-center">
                    <div>
                        <h1 class="text-2xl sm:text-4xl md:text-5xl font-bold mb-3 text-white">{{ $course->title }}</h1>
                        <p class="text-base sm:text-lg text-gray-300 mb-4 sm:mb-6 leading-relaxed">{{ $course->description }}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                            <p class="text-gray-400 text-sm">Автор: 
                                <span class="text-white font-medium">{{ optional($course->teacher)->name }}</span>
                            </p>
                            <p class="text-gray-400 text-sm">Категория: 
                                <span class="text-white font-medium">{{ optional($course->category)->name }}</span>
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                            <span class="text-xl sm:text-2xl font-bold text-[#7cdebe]">
                                {{ $course->price }} $
                            </span>
                            @auth
                                <button type="button" class="js-fav-toggle px-4 py-2 bg-[#0f172a] border border-gray-700 text-white rounded-xl text-sm sm:text-base font-medium transition hover:border-emerald-500" data-course-id="{{ $course->id }}" data-is-favorite="{{ ($isFavorite ?? false) ? '1' : '0' }}">
                                    <span class="fav-label">{{ ($isFavorite ?? false) ? 'Убрать из избранного' : 'В избранное' }}</span>
                                </button>
                            @endauth
                            @auth
                            @if($user->role === 'student')
                                @if($isEnrolled ?? false)
                                    <form action="{{ route('unenrollCourse', $course) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm sm:text-base font-medium transition">
                                            Отписаться от курса
                                        </button>
                                    </form>
                                @elseif($isPending ?? false)
                                    <span class="bg-yellow-500/20 text-yellow-200 px-4 py-2 rounded-xl text-sm sm:text-base font-medium">
                                        Заявка отправлена, ожидает одобрения
                                    </span>
                                @else
                                    <form action="{{ route('enrollCourse', $course) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-4 py-2 rounded-xl text-sm sm:text-base font-medium transition">
                                            Записаться на курс
                                        </button>
                                    </form>
                                @endif
                            @endif
                            @if(!empty($canEdit) && $canEdit)
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('editCourse', $course) }}" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-4 py-2 rounded-xl text-sm sm:text-base font-medium transition">
                                        Редактировать
                                    </a>
                                    <form method="POST" action="{{ route('destroyCourse', $course) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm sm:text-base font-medium transition" onclick="return confirm('Удалить?')">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @endauth
                        </div>
                    </div>
                    <div>
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-48 sm:h-56 md:h-64 object-cover rounded-2xl">
                        @else
                            <div class="h-40 sm:h-48 flex items-center justify-center rounded-2xl border border-gray-600">
                                <h3 class="text-2xl sm:text-3xl font-bold text-white text-center px-4">{{ $course->title }}</h3>
                            </div>
                        @endif
                        @auth
                            <p class="mt-2 text-xs sm:text-base text-gray-300 text-center">
                                Прогресс курса: <span class="font-semibold">{{ $progress ?? 0 }}%</span>
                                @if(!empty($isCompleted) && $isCompleted)
                                    — <span class="text-emerald-500 font-semibold">Курс завершён!</span>
                                    @if($course->hasCertificateForUser($user))
                                        <br>
                                        <a href="{{ route('certificates.index') }}" class="text-emerald-400 hover:text-emerald-300 text-sm underline">
                                            Сертификат доступен
                                        </a>
                                    @endif
                                @endif
                            </p>
                        @endauth
                    </div>
                </div>
                @if(($canEdit ?? false) && ($pendingEnrollmentsCount ?? 0) > 0)
                        <div class="mb-6 mt-4 bg-yellow-500/20 border border-yellow-500/50 text-yellow-200 px-4 py-3 rounded-xl">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <p class="font-semibold">У вас {{ $pendingEnrollmentsCount }} {{ $pendingEnrollmentsCount == 1 ? 'заявка' : 'заявок' }} на запись</p>
                                    <p class="text-xs mt-1 opacity-75">Требуется ваше одобрение</p>
                                </div>
                                <a href="{{ route('courseEnrollments', $course) }}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap">
                                    Перейти к заявкам
                                </a>
                            </div>
                        </div>
                    @endif
                <div class="rounded-2xl p-4 sm:p-8 mt-10 sm:mt-16">
                    <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-white">Модули и уроки</h2>
                    @auth
                    @if(!empty($canEdit) && $canEdit)
                        <a href="{{ route('createModule', $course) }}" class="mb-6 inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-4 py-2 rounded-xl text-sm sm:text-base font-medium transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
                            </svg>
                            Добавить модуль
                        </a>
                    @endif

                    @if($user->role === 'student' && ($isPending ?? false))
                        <div class="mb-6 bg-yellow-500/20 border border-yellow-500/50 text-yellow-200 px-4 py-3 rounded-xl">
                            <p class="text-sm">Ваша заявка ожидает одобрения преподавателем/администратором.</p>
                            <p class="text-xs mt-1 opacity-75">После одобрения откроется полный доступ к курсу.</p>
                        </div>
                    @elseif($user->role === 'student' && !($isEnrolled ?? false))
                        <div class="mb-6 bg-yellow-500/20 border border-yellow-500/50 text-yellow-200 px-4 py-3 rounded-xl">
                            <p class="text-sm">Запишитесь на курс, чтобы получить доступ ко всем модулям и урокам.</p>
                            <p class="text-xs mt-1 opacity-75">Ниже показаны только бесплатные превью уроки.</p>
                        </div>
                    @endif
                    @endauth

                    @if($course->modules->isEmpty())
                        @if($user->role === 'student' && !($isEnrolled ?? false))
                            <p class="text-gray-400 text-center py-6 sm:py-12">Запишитесь на курс, чтобы увидеть модули и уроки</p>
                        @else
                            <p class="text-gray-400 text-center py-6 sm:py-12">Модули не добавлены</p>
                        @endif
                    @else
                        <div class="space-y-4 sm:space-y-6">
                            @foreach($course->modules as $moduleIndex => $module)
                            <div class="border border-gray-700 rounded-2xl overflow-hidden" x-data="{ isOpen: false }">
                                <div class="bg-[#1f2937] p-4 sm:p-6 cursor-pointer flex justify-between items-center" @click="isOpen = !isOpen">
                                    <div class="flex items-center gap-3">
                                        <span class="text-white font-bold text-lg">{{ $module->order ?? $moduleIndex + 1 }}</span>
                                        @if($hasAccess ?? true)
                                            <a class="text-white hover:underline text-sm sm:text-base" href="{{ route('showModule', [$course, $module]) }}">
                                                {{ $module->title }}
                                            </a>
                                        @else
                                            <span class="text-white text-sm sm:text-base">{{ $module->title }}</span>
                                        @endif
                                    </div>
                                    <svg class="w-5 sm:w-6 h-5 sm:h-6 text-gray-400 transform transition" :class="{'rotate-180': isOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <div x-show="isOpen" x-collapse>
                                    <div class="p-4 sm:p-6 space-y-3 sm:space-y-4">
                                        @forelse($module->lessons as $lessonIndex => $lesson)
                                        <div class="bg-[#182023] rounded-xl p-4 sm:p-6 border border-gray-700">
                                            <div class="flex flex-col sm:flex-row justify-between gap-3 sm:gap-0">
                                                <div class="flex-1">
                                                    @if($lesson->can_access ?? true)
                                                        <a href="{{ route('showLesson', [$course, $module, $lesson]) }}">
                                                    @endif
                                                        <div class="flex items-center gap-3 mb-2">
                                                            <div class="relative w-8 h-8 sm:w-10 sm:h-10 bg-gray-700 rounded-lg flex items-center justify-center text-sm sm:text-base">
                                                                {{ $lesson->order ?? $lessonIndex + 1 }}
                                                                @auth
                                                                    @if($lesson->completions->where('user_id', auth()->id())->isNotEmpty())
                                                                        <div class="absolute -top-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center">
                                                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                                            </svg>
                                                                        </div>
                                                                    @endif
                                                                @endauth
                                                            </div>
                                                            <div>
                                                                <h4 class="text-base sm:text-lg font-semibold text-white {{ !($lesson->can_access ?? true) ? 'opacity-50' : '' }}">
                                                                    {{ $lesson->title }}
                                                                    @if($lesson->is_free_preview)
                                                                        <span class="text-xs text-emerald-400 ml-2">(Бесплатный превью)</span>
                                                                    @endif
                                                                </h4>
                                                                <p class="text-gray-400 text-xs sm:text-sm">
                                                                    {{ $lesson->duration }} минут
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @if($lesson->can_access ?? true)
                                                        </a>
                                                    @else
                                                        <p class="text-xs text-gray-500 mt-2">Запишитесь на курс для доступа</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <p class="text-gray-500 text-sm text-center">Уроков пока нет</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="rounded-2xl p-4 sm:p-8 mt-10 sm:mt-8">
                    <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-white text-center">
                        Комментарии к курсу
                    </h2>
                    <form method="POST" action="{{ route('storeCourseComment', $course) }}">
                        @csrf
                        <textarea name="comment" class="w-full p-3 sm:p-4 rounded-xl bg-[#1f2937] text-white border border-gray-600 text-sm focus:outline-none" rows="4" placeholder="Ваш комментарий" required></textarea>
                        <input type="hidden" name="parent_id" id="course_parent_id">
                        <button type="submit" class="mt-2 sm:mt-3 bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-4 sm:px-6 py-2 rounded-xl font-medium text-sm sm:text-base transition">
                            Отправить
                        </button>
                    </form>
                    <div class="flex flex-col gap-4 mt-6">
                        @if($course->courseComments->whereNull('parent_id')->count() > 0)
                            @foreach($course->courseComments->whereNull('parent_id') as $comment)
                                @include('courses.comment-item', ['comment'=>$comment,'level'=>0,'course'=>$course,'user'=>$user])
                            @endforeach
                        @else
                            <p class="text-gray-500 text-sm text-center">Комментариев пока нет</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@auth
<script>
    (function() 
    {
        function initFavorite() {
            const btn = document.querySelector('.js-fav-toggle');
            if (!btn) {
                return;
            }
            
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!token) {
                console.error('CSRF token not found');
                return;
            }

            console.log('CSRF token found');

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
                    
                    if (!res.ok) {
                        const errorText = await res.text();
                        console.error('Error response:', errorText);
                        let errorData = {};
                        try {
                            errorData = JSON.parse(errorText);
                        } catch (e) {}
                        throw new Error(errorData.message || 'Request failed');
                    }
                    
                    const data = await res.json();
                    
                    const newState = !!data.is_favorite;
                    btn.dataset.isFavorite = newState ? '1' : '0';
                    
                    const label = btn.querySelector('.fav-label');
                    if (label) {
                        label.textContent = newState ? 'Убрать из избранного' : 'В избранное';
                    }
                } catch (e) {
                    console.error('Favorite toggle error:', e);
                    alert('Не удалось обновить избранное: ' + e.message);
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