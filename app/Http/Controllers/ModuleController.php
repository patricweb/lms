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

        $module->load('lessons', 'course');

        $canEdit = (($user->role === 'teacher' && $user->id === $module->course->teacher_id) || $user->role === 'admin');

        return view('modules.show', compact('module', 'canEdit', 'user'));
    }

    public function create(Course $course)
    {
        $user = Auth::user();
        if ($user->role !== 'teacher' && $user->role !== 'admin') {
            return view('errors.403');
        }

        return view('modules.create', compact('course'));
    }

    public function save(Request $request, Course $course)
    {
        $user = Auth::user();
        if ($user->role !== 'teacher' && $user->role !== 'admin') {
            return view('errors.403');
        }

        $validated = $request->validate([
            'title'       => 'required|min:3|max:255',
            'description' => 'nullable|min:5',
            'order'       => 'required|numeric|min:1|unique:modules,order,NULL,id,course_id,' . $course->id
        ]);

        $validated['course_id'] = $course->id;

        Module::create($validated);

        return redirect()->route('showCourse', $course)->with('success', 'Модуль добавлен!');
    }

    public function edit(Module $module)
    {
        $user = Auth::user();
        if (($user->role === 'teacher' && $user->id !== $module->course->teacher_id) || $user->role === 'student') {
            return view('errors.403');
        }

        return view('modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        $user = Auth::user();
        if (($user->role === 'teacher' && $user->id !== $module->course->teacher_id) || $user->role === 'student') {
            return view('errors.403');
        }

        $validated = $request->validate([
            'title'       => 'required|min:3|max:255',
            'description' => 'nullable|min:5',
            'order'       => 'required|numeric|min:1|unique:modules,order,' . $module->id . ',id,course_id,' . $module->course_id
        ]);

        $module->update($validated);

        return redirect()->route('showCourse', $module->course)->with('success', 'Модуль обновлён!');
    }

    public function delete(Course $course, Module $module)
    {
        $user = Auth::user();

        if ($user->role === 'teacher' && $user->id !== $course->teacher_id) {
            return view('errors.403');
        }

        if ($user->role === 'student') {
            return view('errors.403');
        }

        $module->delete();

        return redirect()->route('showCourse')->with('success', 'Модуль удален!');
    }
}
