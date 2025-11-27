<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use App\Models\User;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/register');
        }

        $allCourses = Course::with(['lessons' => fn($q) =>
            $q->with(['completions' => fn($cq) => $cq->where('user_id', $user->id)])
        ])->get();

        if ($user->role === 'student')
        {
            $allCourses = $allCourses->filter(fn($course) => $course->is_published && $course->lessons->count() > 0);
        }

        $startedCourses = $allCourses->filter(function ($course) use ($user) 
        {
            $totalLessons = $course->lessons->count();

            if ($totalLessons === 0) return false;

            $completedLessons = $course->lessons->filter(fn($lesson) => $lesson->completions->isNotEmpty())->count();

            return $completedLessons > 0 && $completedLessons < $totalLessons;
        });

        $completedCourses = $allCourses->filter(function ($course) use ($user)
        {
            $totalLessons = $course->lessons->count();

            if ($totalLessons === 0) return false;

            $completedLessons = $course->lessons->filter(fn($lesson) => $lesson->completions->isNotEmpty())->count();

            return $completedLessons === $totalLessons;
        });

        $createdCourses = in_array($user->role, ['teacher', 'admin'])
            ? $user->courses()->with(['lessons' => fn($q) => $q->with('completions')])->get()->map(function ($course)
            {
                $studentsCount = $course->lessons->flatMap->completions->pluck('user_id')->unique()->count();

                $course->students_count = $studentsCount;

                return $course;
            })
            : collect();

        $editMode = request()->get('edit', false);

        return view('users.profile', compact('user', 'startedCourses', 'completedCourses', 'createdCourses', 'editMode'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('avatar'))
        {
            if ($user->avatar)
            {
                Storage::disk('public')->delete($user->avatar);
            }

            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $user->update($validated);

        return redirect()->route('profile');
    }
}