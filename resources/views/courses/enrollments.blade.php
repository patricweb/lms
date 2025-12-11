@extends("layout")

@section("main")
    <div class="min-h-screen py-4 md:py-8" x-data="{ activeTab: 'pending' }">
        <div class="border border-gray-600 rounded-xl container mx-auto px-2 sm:px-4">
            <div class="rounded-2xl p-4 sm:p-8 mb-6 sm:mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-2 text-white">Заявки на курс</h1>
                        <a href="{{ route('showCourse', $course) }}" class="text-[#7cdebe] hover:underline text-sm">
                            ← Вернуться к курсу: {{ $course->title }}
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 mb-6 border-b border-gray-700">
                    <button @click="activeTab = 'pending'" 
                            :class="activeTab === 'pending' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-gray-400 hover:text-white'"
                            class="px-4 py-2 font-medium transition border-b-2">
                        В ожидании ({{ $pendingEnrollments->total() }})
                    </button>
                    <button @click="activeTab = 'active'" 
                            :class="activeTab === 'active' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-gray-400 hover:text-white'"
                            class="px-4 py-2 font-medium transition border-b-2">
                        Одобренные ({{ $activeEnrollments->total() }})
                    </button>
                    <button @click="activeTab = 'cancelled'" 
                            :class="activeTab === 'cancelled' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-gray-400 hover:text-white'"
                            class="px-4 py-2 font-medium transition border-b-2">
                        Отклоненные ({{ $cancelledEnrollments->total() }})
                    </button>
                </div>

                <div x-show="activeTab === 'pending'" class="tab-content">
                    @if($pendingEnrollments->count() > 0)
                        <div class="space-y-3">
                            @foreach($pendingEnrollments as $enrollment)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-gray-700 rounded-xl px-4 py-3 bg-[#161b1f]">
                                    <div class="text-white">
                                        <div class="font-semibold">{{ $enrollment->user->name }}</div>
                                        <div class="text-sm text-gray-400">{{ $enrollment->user->email }}</div>
                                        <div class="text-xs text-gray-500">Заявка подана: {{ $enrollment->created_at?->format('d.m.Y H:i') }}</div>
                                    </div>
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('approveEnrollment', ['course' => $course, 'enrollment' => $enrollment]) }}">
                                            @csrf
                                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-gray-900 px-4 py-2 rounded-lg text-sm font-medium transition">
                                                Одобрить
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('rejectEnrollment', ['course' => $course, 'enrollment' => $enrollment]) }}">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                                Отклонить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $pendingEnrollments->links() }}
                        </div>
                    @else
                        <p class="text-gray-400 text-center py-8">Нет заявок в ожидании</p>
                    @endif
                </div>

                <div x-show="activeTab === 'active'" class="tab-content" style="display: none;">
                    @if($activeEnrollments->count() > 0)
                        <div class="space-y-3">
                            @foreach($activeEnrollments as $enrollment)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-gray-700 rounded-xl px-4 py-3 bg-[#161b1f]">
                                    <div class="text-white">
                                        <div class="font-semibold">{{ $enrollment->user->name }}</div>
                                        <div class="text-sm text-gray-400">{{ $enrollment->user->email }}</div>
                                        <div class="text-xs text-gray-500">Одобрено: {{ $enrollment->enrolled_at?->format('d.m.Y H:i') }}</div>
                                    </div>
                                    <div class="text-emerald-400 text-sm font-medium">
                                        ✓ Одобрено
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $activeEnrollments->links() }}
                        </div>
                    @else
                        <p class="text-gray-400 text-center py-8">Нет одобренных заявок</p>
                    @endif
                </div>

                <div x-show="activeTab === 'cancelled'" class="tab-content" style="display: none;">
                    @if($cancelledEnrollments->count() > 0)
                        <div class="space-y-3">
                            @foreach($cancelledEnrollments as $enrollment)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-gray-700 rounded-xl px-4 py-3 bg-[#161b1f]">
                                    <div class="text-white">
                                        <div class="font-semibold">{{ $enrollment->user->name }}</div>
                                        <div class="text-sm text-gray-400">{{ $enrollment->user->email }}</div>
                                        <div class="text-xs text-gray-500">Отклонено: {{ $enrollment->updated_at?->format('d.m.Y H:i') }}</div>
                                    </div>
                                    <div class="text-red-400 text-sm font-medium">
                                        ✗ Отклонено
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $cancelledEnrollments->links() }}
                        </div>
                    @else
                        <p class="text-gray-400 text-center py-8">Нет отклоненных заявок</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection