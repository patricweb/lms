@extends("layout")

@section("main")
    <div class="min-h-screen py-8 sm:py-12 lg:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="border border-gray-600 rounded-2xl py-8 sm:py-10 lg:py-12 px-6 sm:px-8 lg:px-12 bg-[#121517] shadow-2xl">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 lg:mb-12 gap-6 lg:gap-8">
                    <div class="flex items-center gap-5 lg:gap-7 w-full sm:w-auto">
                        <div class="relative group">
                            <div class="w-20 h-20 sm:w-24 lg:w-28 sm:h-24 lg:h-28 rounded-2xl bg-gray-800 flex items-center justify-center text-2xl sm:text-3xl font-bold text-white shadow-xl ring-4 ring-gray-800">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            @if($editMode)
                                <form action="{{ route('profileUpdate') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    <input type="text" name="name" value="{{ $user->name }}" class="bg-transparent border-b-2 border-gray-500 text-white text-xl lg:text-2xl font-medium outline-none w-full max-w-xs focus:border-[#7cdebe] transition" required autofocus>
                                    <div class="text-sm lg:text-base text-gray-400">{{ $user->email }}</div>
                                    <div class="flex flex-wrap gap-3 pt-3">
                                        <button type="submit" class="px-5 py-2 bg-[#7cdebe] text-black rounded-lg hover:bg-[#69c9a9] text-sm font-medium transition">
                                            Save
                                        </button>
                                        <a href="{{ route('profile') }}" class="px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 text-sm font-medium transition">
                                            Cancel
                                        </a>
                                    </div>
                                </form>
                            @else
                                <div>
                                    <h1 class="text-2xl sm:text-3xl lg:text-4xl text-white font-bold truncate">
                                        {{ $user->name }}
                                    </h1>
                                    <div class="text-sm lg:text-base text-gray-400 mt-1">{{ $user->email }}</div>
                                    <div class="text-sm lg:text-base text-gray-500 mt-1 capitalize">{{ $user->role }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if(!$editMode)
                        <a href="{{ route('profile', ['edit' => 1]) }}" class="w-full sm:w-auto px-6 py-3 text-sm lg:text-base rounded-xl bg-emerald-500 text-black hover:bg-emerald-600 font-bold transition whitespace-nowrap text-center">
                            Edit Profile
                        </a>
                    @endif
                </div>
                <div class="flex flex-wrap gap-6 lg:gap-10 text-sm lg:text-base text-gray-300 mb-10 lg:mb-14 border-b border-gray-700 pb-8">
                    <div>Started: <span class="text-white font-semibold">{{ $startedCourses->count() }}</span></div>
                    <div>Finished: <span class="text-white font-semibold">{{ $completedCourses->count() }}</span></div>
                    @if(in_array($user->role, ['teacher','admin']))
                        <div>Created: <span class="text-white font-semibold">{{ $createdCourses->count() }}</span></div>
                    @endif
                </div>
                <div class="space-y-12 lg:space-y-16">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-semibold text-white mb-6">Continue learning</h2>
                        <div class="space-y-4">
                            @forelse($startedCourses as $course)
                                @php $progress = $course->getProgressForUser($user); @endphp
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 py-5 px-4 rounded-xl hover:bg-[#1a1c1d] transition-all border border-transparent hover:border-gray-700">
                                    @if($course->image)
                                        <img src="{{ asset('storage/' . $course->image) }}" class="w-full sm:w-24 lg:w-32 h-20 sm:h-16 lg:h-20 rounded-lg object-cover">
                                    @endif
                                    <div class="flex-1 w-full">
                                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                            <h3 class="text-white font-medium text-lg">{{ $course->title }}</h3>
                                            <a href="{{ route('showCourse', $course->id) }}" class="text-[#7cdebe] text-sm hover:underline whitespace-nowrap">
                                                Continue
                                            </a>
                                        </div>
                                        <div class="mt-3">
                                            <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
                                                <div class="h-2 bg-[#7cdebe] transition-all duration-700" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <p class="text-gray-500 text-xs mt-2">{{ $progress }}% completed</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">No active courses yet</p>
                            @endforelse
                        </div>
                    </div>
                    @if($user->role === 'student' && isset($enrolledCourses))
                        <div>
                            <h2 class="text-xl lg:text-2xl font-semibold text-white mb-6">Мои курсы</h2>
                            <div class="space-y-4">
                                @forelse($enrolledCourses as $course)
                                    @php $progress = $course->getProgressForUser($user); @endphp
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 py-5 px-4 rounded-xl hover:bg-[#1a1c1d] transition-all border border-transparent hover:border-gray-700">
                                        @if($course->thumbnail)
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full sm:w-24 lg:w-32 h-20 sm:h-16 lg:h-20 rounded-lg object-cover">
                                        @endif
                                        <div class="flex-1 w-full">
                                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                                <h3 class="text-white font-medium text-lg">{{ $course->title }}</h3>
                                                <a href="{{ route('showCourse', $course) }}" class="text-[#7cdebe] text-sm hover:underline whitespace-nowrap">
                                                    Открыть
                                                </a>
                                            </div>
                                            <div class="mt-3">
                                                <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
                                                    <div class="h-2 bg-[#7cdebe] transition-all duration-700" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <p class="text-gray-500 text-xs mt-2">{{ $progress }}% завершено</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 italic">Вы еще не записались ни на один курс</p>
                                @endforelse
                            </div>
                        </div>
                    @endif
                    @if(isset($favoriteCourses))
                        <div>
                            <h2 class="text-xl lg:text-2xl font-semibold text-white mb-6">Избранные курсы</h2>
                            <div class="space-y-4">
                                @forelse($favoriteCourses as $course)
                                    @php $progress = $course->getProgressForUser($user); @endphp
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 py-5 px-4 rounded-xl hover:bg-[#1a1c1d] transition-all border border-transparent hover:border-gray-700">
                                        @if($course->thumbnail)
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full sm:w-24 lg:w-32 h-20 sm:h-16 lg:h-20 rounded-lg object-cover">
                                        @endif
                                        <div class="flex-1 w-full">
                                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                                                <h3 class="text-white font-medium text-lg">{{ $course->title }}</h3>
                                                <a href="{{ route('showCourse', $course) }}" class="text-[#7cdebe] text-sm hover:underline whitespace-nowrap">
                                                    Открыть
                                                </a>
                                            </div>
                                            <div class="mt-3">
                                                <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
                                                    <div class="h-2 bg-[#7cdebe] transition-all duration-700" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <p class="text-gray-500 text-xs mt-2">{{ $progress }}% завершено</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 italic">Пока нет избранных курсов</p>
                                @endforelse
                            </div>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-xl lg:text-2xl font-semibold text-white mb-6">Completed</h2>
                        <div class="space-y-4">
                            @forelse($completedCourses as $course)
                                @php $date = $course->completionDateForUser($user); @endphp
                                <div class="flex justify-between items-center py-5 px-4 rounded-xl hover:bg-[#1a1c1d] transition-all border border-transparent hover:border-gray-700">
                                    <div>
                                        <h3 class="text-white font-medium text-lg">{{ $course->title }}</h3>
                                        <p class="text-gray-500 text-xs mt-1">
                                            Completed: {{ $date?->format('M d, Y') ?? '-' }}
                                        </p>
                                        @if($course->hasCertificateForUser($user))
                                            <a href="{{ route('certificates.index') }}" class="text-emerald-400 text-xs mt-1 inline-block hover:underline">
                                                Сертификат доступен
                                            </a>
                                        @endif
                                    </div>
                                    <div class="flex gap-2">
                                    <a href="{{ route('showCourse', $course->id) }}" class="text-[#7cdebe] text-sm hover:underline whitespace-nowrap">
                                        View
                                    </a>
                                        @if($course->hasCertificateForUser($user))
                                            <a href="{{ route('certificates.index') }}" class="text-emerald-400 text-sm hover:underline whitespace-nowrap">
                                                Сертификат
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">No completed courses yet</p>
                            @endforelse
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl lg:text-2xl font-semibold text-white">Мои сертификаты</h2>
                            <a href="{{ route('certificates.index') }}" class="text-[#7cdebe] text-sm hover:underline">
                                Все сертификаты →
                            </a>
                        </div>
                        @php
                            $userCertificates = $user->certificates()->with('course')->orderBy('issued_at', 'desc')->limit(3)->get();
                        @endphp
                        <div class="space-y-4">
                            @forelse($userCertificates as $cert)
                                <div class="flex justify-between items-center py-5 px-4 rounded-xl hover:bg-[#1a1c1d] transition-all border border-transparent hover:border-gray-700">
                                    <div>
                                        <h3 class="text-white font-medium text-lg">{{ $cert->course->title }}</h3>
                                        <p class="text-gray-500 text-xs mt-1">
                                            Выдан: {{ $cert->issued_at->format('d.m.Y') }}
                                        </p>
                                        <p class="text-gray-600 text-xs mt-1 font-mono">#{{ $cert->certificate_number }}</p>
                                    </div>
                                    <a href="{{ route('certificates.show', $cert) }}" class="text-[#7cdebe] text-sm hover:underline whitespace-nowrap">
                                        Просмотр
                                    </a>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">У вас пока нет сертификатов</p>
                            @endforelse
                        </div>
                    </div>
                    @if(in_array($user->role, ['teacher','admin']))
                        <div>
                            <h2 class="text-xl lg:text-2xl font-semibold text-white mb-6">Your courses</h2>
                            <div class="space-y-4">
                                @forelse($createdCourses as $course)
                                    <div class="flex justify-between items-center py-5 px-4 rounded-xl hover:bg-[#1a1c1d] transition-all border border-transparent hover:border-gray-700">
                                        <h3 class="text-white font-medium text-lg">{{ $course->title }}</h3>
                                        <a href="{{ route('editCourse', $course->id) }}" class="text-[#7cdebe] text-sm hover:underline whitespace-nowrap">
                                            Edit
                                        </a>
                                    </div>
                                @empty
                                    <p class="text-gray-500 italic">You haven't created any courses yet</p>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection