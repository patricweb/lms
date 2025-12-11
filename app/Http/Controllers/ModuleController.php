<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Module;

class ModuleController extends Controller
{
    public function show(Course $course, Module $module)
    {
        $user = Auth::user();

        if (!$user)
        {
            return redirect('/register');
        }

        $module->load([
            'lessons' => function ($query) use ($user) 
            {
                $query->with(['completions' => function ($q) use ($user) 
                {
                    $q->where('user_id', $user->id);
                }]);
            },
            'course'
        ]);

        $canEdit = (($user->role === 'teacher' && $user->id === $module->course->teacher_id) || $user->role === 'admin');

        $totalLessons = 0;

        $completedLessons = 0;

        $progress = 0;

        if ($user->role === 'student')
        {
            $totalLessons = $module->lessons->count();
            $completedLessons = $module->lessons->filter(fn($lesson) => $lesson->isCompletedByUser($user))->count();
            $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        }

        return view('modules.show', compact('module', 'canEdit', 'user', 'totalLessons', 'completedLessons', 'progress'));
    }

    public function create(Course $course)
    {
        $user = Auth::user();

        if ($user->role !== 'teacher' && $user->role !== 'admin')
        {
            return view('errors.403');
        }

        $defaultOrder = $course->modules()->count() + 1;

        return view('modules.create', compact('course', 'defaultOrder'));
    }

    public function save(Request $request, Course $course)
    {
        $user = Auth::user();

        if ($user->role !== 'teacher' && $user->role !== 'admin')
        {
            return view('errors.403');
        }

        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|min:5',
            'order' => 'required|numeric|min:1|unique:modules,order,NULL,id,course_id,' . $course->id
        ]);

        $validated['course_id'] = $course->id;

        Module::create($validated);

        return redirect()->route('showCourse', $course);
    }

    public function edit(Course $course, Module $module)
    {
        $user = Auth::user();

        if (($user->role === 'teacher' && $user->id !== $module->course->teacher_id) || $user->role === 'student')
        {
            return view('errors.403');
        }

        return view('modules.edit', compact('module', 'course'));
    }

    public function update(Request $request, Course $course, Module $module)
    {
        $user = Auth::user();

        if (($user->role === 'teacher' && $user->id !== $course->teacher_id) || $user->role === 'student')
        {
            return view('errors.403');
        }

        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|min:5',
            'order' => 'required|numeric|min:1|unique:modules,order,' . $module->id . ',id,course_id,' . $course->id
        ]);

        $module->update($validated);

        return redirect()->route('showCourse', $course);
    }

    public function delete(Course $course, Module $module)
    {
        $user = Auth::user();

        if ($user->role === 'teacher' && $user->id !== $course->teacher_id)
        {
            return view('errors.403');
        }

        if ($user->role === 'student')
        {
            return view('errors.403');
        }

        $module->delete();

        return redirect()->route('showCourse', $course);
    }
}