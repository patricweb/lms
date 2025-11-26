<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseComment;
use App\Models\Course;

class CourseCommentsController extends Controller
{
    public function index(Course $course)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }

        $comments = $course->courseComments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id')
            ->latest()
            ->paginate(10);

        return view('course-comments.index', compact('comments', 'course', 'user'));
    }

    public function store(Request $request, Course $course)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }

        $validated = $request->validate([
            'comment' => 'required|min:3|max:1000',
            'parent_id' => 'nullable|exists:course_comments,id'
        ]);

        $validated['user_id'] = $user->id;
        $validated['course_id'] = $course->id;

        CourseComment::create($validated);

        return back()->with('success', $request->parent_id ? 'Ответ добавлен!' : 'Комментарий добавлен!');
    }

    public function destroy(Course $course, CourseComment $comment)
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