<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson;
use App\Models\Completion;
use App\Models\Course;
use App\Models\Module;

class LessonController extends Controller
{
    public function show(Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }

        $lesson->load([
            'completions' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },
            'lessonComments' => function ($query) {
                $query->with([
                    'user',
                    'parent.user',  // Загружаем parent для "Ответ для"
                    'replies' => function ($q) {
                        $q->with(['user', 'parent.user']);  // Для replies и их parent
                    }
                ])->whereNull('parent_id');  // Root только
            }
        ]);

        $canEdit = (($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin');
        return view('lessons.show', compact('lesson', 'module', 'course', 'canEdit', 'user'));
    }

    public function create(Course $course, Module $module)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }
        if ($user->role !== 'teacher' && $user->role !== 'admin') {
            return view('errors.403');
        }

        return view('lessons.create', compact('course', 'module'));
    }

    public function store(Request $request, Course $course, Module $module)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }
        if ($user->role !== 'teacher' && $user->role !== 'admin') {
            return view('errors.403');
        }

        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'video_url' => 'nullable|url',
            'order' => 'required|numeric|min:1|unique:lessons,order,NULL,id,course_id,' . $course->id . ',module_id,' . $module->id,
            'duration' => 'required|numeric|min:1',
            'is_free_preview' => 'boolean'
        ]);

        $validated['course_id'] = $course->id;
        $validated['module_id'] = $module->id;
        Lesson::create($validated);

        return redirect()->route('showModule', ['course' => $course, 'module' => $module])->with('success', 'Урок добавлен!');
    }

    public function edit(Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }
        if (($user->role === 'teacher' && $user->id !== $course->teacher_id) || $user->role === 'student') {
            return view('errors.403');
        }

        return view('lessons.edit', compact('course', 'module', 'lesson'));
    }

    public function update(Request $request, Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }
        if (($user->role === 'teacher' && $user->id !== $course->teacher_id) || $user->role === 'student') {
            return view('errors.403');
        }

        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'video_url' => 'nullable|url',
            'order' => 'required|numeric|min:1|unique:lessons,order,' . $lesson->id . ',id,course_id,' . $course->id . ',module_id,' . $module->id,
            'duration' => 'required|numeric|min:1',
            'is_free_preview' => 'boolean'
        ]);

        $lesson->update($validated);
        return redirect()->route('showModule', ['course' => $course, 'module' => $module])->with('success', 'Урок обновлён!');
    }

    public function destroy(Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }
        if (($user->role === 'teacher' && $user->id !== $course->teacher_id) || $user->role === 'student') {
            return view('errors.403');
        }

        $lesson->delete();  // Soft delete, т.к. trait есть
        return redirect()->route('showModule', ['course' => $course, 'module' => $module])->with('success', 'Урок удалён!');
    }

    public function complete(Request $request, $courseId, $lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        // Проверка, если урок уже завершён
        if ($lesson->completions()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'Урок уже отмечен как пройденный');
        }

        Completion::create([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Урок отмечен как пройденный!');
    }
}