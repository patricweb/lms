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
        if (!$user) {
            return redirect('/register');
        }

        // Загружаем все курсы с lessons и completions для user (eager load)
        $allCourses = Course::with(['lessons' => function ($q) use ($user) {
            $q->with(['completions' => fn($cq) => $cq->where('user_id', $user->id)]);
        }])->get();

        // PHP filter для startedCourses
        $startedCourses = $allCourses->filter(function ($course) use ($user) {
            $totalLessons = $course->lessons->count();
            $completedLessons = $course->lessons->filter(fn($lesson) => $lesson->completions->where('user_id', $user->id)->isNotEmpty())->count();
            return $completedLessons > 0 && $completedLessons < $totalLessons;
        });

        // PHP filter для completedCourses
        $completedCourses = $allCourses->filter(function ($course) use ($user) {
            $totalLessons = $course->lessons->count();
            $completedLessons = $course->lessons->filter(fn($lesson) => $lesson->completions->where('user_id', $user->id)->isNotEmpty())->count();
            return $completedLessons === $totalLessons;
        });

        // Фикс createdCourses: Загружаем с relations, PHP count students (unique user_id)
        $createdCourses = in_array($user->role, ['teacher', 'admin']) 
            ? $user->courses()->with(['lessons' => fn($q) => $q->with('completions')])->get()->map(function ($course) {
                $studentsCount = $course->lessons->flatMap->completions->pluck('user_id')->unique()->count();
                $course->students_count = $studentsCount;
                return $course;
            }) : collect();

        return view('users.profile', compact('user', 'startedCourses', 'completedCourses', 'createdCourses'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Профиль обновлён!');
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }
}