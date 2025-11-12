<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Category;

class CourseController extends Controller
{
    public function courses(Request $request)
    {
        $user = Auth::user();
        if (!$user) 
        {
            return redirect('/register');
        }

        $query = Course::with(['category', 'teacher']);

        if ($request->$search)
        {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        if ($request->category_id)
        {
            $query->where('category_id', $request->category_id);
        }

        if ($request->sort)
        {
            $query->orderby($request->sort, $request->order ?? 'desc');
        }
        else
        {
            $query->orderBy('created_at', 'desc');
        }

        if ($user->role === 'admin')
        {
            if ($request->my_only)
            {
                $query->where('teacher_id', $user->id);
            }

            $courses = $query->paginate(10);
            return view('coures.admin', compact('courses', 'user'));
        }
        elseif ($user->role === 'teacher') 
        {
            if ($request->my_only)
            {
                $query->where('teacher_id', $user->id);
            }
            $courses = $query->paginate(10);
            return view('courses.teacher', compact('courses', 'user'));
        }
        else 
        {
            $query->published();
            $courses = $query->paginate(10);
            return view('courses.student', compact('courses', 'user'));
        }
    }

    public function show(Course $course)
    {
        $user = Auth::user();
        if (!$user)
        {
            return redirect('/register');
        }

        $course->load(['modules.lessons', 'quizzes']);

        $progress = $course->getProgressForUser($user);
        $isCompleted = $course->isCompletedByUser($user);

        $canEdit = ($user->role === 'teacher' && $user->id === $course->teacher_id || $user->role === 'admin');

        return view('courses.show', compact('course', 'progress', 'isCompleted', 'canEdit', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->role !== 'teacher' || $user->role !== 'admin')
        {
            return view('errors.403');
        }

        $categories = Category::all();

        return view('courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'teacher' || $user->role !== 'admin')
        {
            return view('errors.403');
        }
    }
}
