@extends("layout")

@section("main")

<div class="min-h-screen py-10 ">
    <div class="max-w-6xl mx-auto border border-gray-600 rounded-xl py-8 px-8 bg-[#121517]">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-6">
            <div class="flex items-center gap-6">
                <label class="relative group">
                        <div class="w-24 h-24 sm:w-20 sm:h-20 rounded-xl bg-gray-800 flex items-center justify-center text-xl text-white shadow">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                </label>
                @if($editMode)
                    <form action="{{ route('profileUpdate') }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                        @csrf
                        <input type="text" name="name" value="{{ $user->name }}" class="bg-transparent border-b border-gray-600 text-white text-xl outline-none w-44 sm:w-56" required>
                        <div class="text-sm text-gray-400">{{ $user->email }}</div>
                        <div class="flex gap-3 pt-2">
                            <button class="px-4 py-1 bg-[#7cdebe] text-black rounded hover:bg-[#69c9a9] text-sm transition">
                                Save
                            </button>
                            <a href="{{ route('profile') }}" class="px-4 py-1 bg-gray-700 text-white rounded hover:bg-gray-600 text-sm transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                @else
                    <div>
                        <h1 class="text-2xl text-white font-semibold">{{ $user->name }}</h1>
                        <div class="text-sm text-gray-400 mt-1">{{ $user->email }}</div>
                        <div class="text-sm text-gray-500 mt-1 capitalize">{{ $user->role }}</div>
                    </div>
                @endif
            </div>
            @if(!$editMode)
                <a href="{{ route('profile', ['edit' => 1]) }}" class="px-4 py-2 text-sm rounded-lg bg-emerald-500 text-black hover:bg-emerald-600 transition">Edit profile</a>
            @endif
        </div>
        <div class="flex flex-wrap gap-6 text-sm text-gray-300 mb-10">
            <div>Started: <span class="text-white font-medium">{{ $startedCourses->count() }}</span></div>
            <div>Finished: <span class="text-white font-medium">{{ $completedCourses->count() }}</span></div>
            @if(in_array($user->role,['teacher','admin']))
                <div>Created: <span class="text-white font-medium">{{ $createdCourses->count() }}</span></div>
            @endif
        </div>
        <div class="space-y-12">
            <div>
                <h2 class="text-lg font-medium text-white mb-4">Continue learning</h2>
                @forelse($startedCourses as $course)
                    @php $progress = $course->getProgressForUser($user); @endphp
                    <div class="flex items-center gap-4 py-4 border-b border-gray-800 hover:bg-[#1a1c1d] transition rounded px-2">
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" class="w-16 h-10 rounded object-cover opacity-90">
                        @endif
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <h3 class="text-white">{{ $course->title }}</h3>
                                <a href="{{ route('showCourse', $course->id) }}" class="text-[#7cdebe] text-xs hover:underline">
                                    Continue →
                                </a>
                            </div>
                            <div class="w-full h-1 bg-gray-700 mt-2 rounded overflow-hidden">
                                <div class="h-1 bg-[#7cdebe]" style="width: {{ $progress }}%"></div>
                            </div>
                            <p class="text-gray-500 text-xs mt-1">{{ $progress }}% completed</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No active courses</p>
                @endforelse
            </div>
            <div>
                <h2 class="text-lg font-medium text-white mb-4">Completed</h2>
                @forelse($completedCourses as $course)
                    @php $date = $course->completionDateForUser($user); @endphp
                    <div class="py-4 border-b border-gray-800 hover:bg-[#1a1c1d] transition px-2 rounded">
                        <div class="flex justify-between items-center">
                            <h3 class="text-white">{{ $course->title }}</h3>
                            <a href="{{ route('showCourse',$course->id) }}" class="text-[#7cdebe] text-xs hover:underline">
                                View →
                            </a>
                        </div>
                        <div class="text-gray-500 text-xs mt-1">
                            Completed: {{ $date ? $date->format('M d, Y') : '-' }}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No completed courses</p>
                @endforelse
            </div>
            @if(in_array($user->role, ['teacher','admin']))
                <div>
                    <h2 class="text-lg font-medium text-white mb-4">Your courses</h2>
                    @forelse($createdCourses as $course)
                        <div class="py-4 border-b border-gray-800 flex justify-between items-center hover:bg-[#1a1c1d] transition px-2 rounded">
                            <h3 class="text-white">{{ $course->title }}</h3>
                            <a href="{{ route('editCourse', $course->id) }}" class="text-[#7cdebe] text-xs hover:underline">
                                Edit →
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Nothing created yet</p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</div>
@endsection