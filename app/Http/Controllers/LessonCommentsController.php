<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LessonComment;  // Импорт модели комментария
use App\Models\Lesson;         // Импорт для $lesson
use App\Models\Module;         // Импорт для $module
use App\Models\Course;         // Импорт для $course (критично!)

class LessonCommentsController extends Controller
{
    public function index(Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }

        $comments = $lesson->lessonComments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id')
            ->latest()
            ->paginate(10);

        return view('lesson-comments.index', compact('comments', 'lesson', 'module', 'course', 'user'));
    }

    public function store(Request $request, Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }

        $validated = $request->validate([
            'comment' => 'required|min:3|max:1000',
            'parent_id' => 'nullable|exists:lesson_comments,id'
        ]);

        $validated['user_id'] = $user->id;
        $validated['lesson_id'] = $lesson->id;

        LessonComment::create($validated);

        return back()->with('success', $request->parent_id ? 'Ответ добавлен!' : 'Комментарий добавлен!');
    }

    public function destroy(Course $course, Module $module, Lesson $lesson, LessonComment $comment)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }

        if ($user->id !== $comment->user_id && $user->role !== 'admin') {
            return back()->with('error', 'Нет прав на удаление.');
        }

        $comment->replies()->delete();
        $comment->delete();

        return back()->with('success', 'Комментарий удалён!');
    }
}