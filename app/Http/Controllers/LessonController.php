<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lesson;
use App\Models\Completion;
use App\Models\Course;
use App\Models\Module;
use App\Models\Enrollment;
use App\Models\Certificate;

class LessonController extends Controller
{
    public function show(Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/register');
        }

        $canEdit = (($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin');
        $isEnrolled = $course->isEnrolledByUser($user);
        $isTeacherOrAdmin = ($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin';
        $hasAccess = $isTeacherOrAdmin || $isEnrolled || $lesson->is_free_preview;

        if (!$hasAccess && $user->role === 'student') 
        {
            return redirect()->route('showCourse', $course);
        }

        $lesson->load([
            'completions' => function ($query) use ($user) 
            {
                $query->where('user_id', $user->id);
            },
            'lessonComments' => function ($query) 
            {
                $query->with([
                    'user',
                    'parent.user',
                    'replies' => function ($q) 
                    {
                        $q->with(['user', 'parent.user']);
                    }
                ])->whereNull('parent_id');
            }
        ]);

        $previousLesson = $this->getPreviousLesson($course, $lesson);
        $nextLesson = $this->getNextLesson($course, $lesson);

        return view('lessons.show', compact('lesson', 'module', 'course', 'canEdit', 'user', 'hasAccess', 'previousLesson', 'nextLesson'));
    }

    private function getPreviousLesson(Course $course, Lesson $currentLesson)
    {
        $allLessons = $course->lessons()->orderBy('order')->get();
        
        $currentIndex = $allLessons->search(function ($lesson) use ($currentLesson) 
        {
            return $lesson->id === $currentLesson->id;
        });

        if ($currentIndex === false || $currentIndex === 0) 
        {
            return null;
        }

        return $allLessons[$currentIndex - 1];
    }

    private function getNextLesson(Course $course, Lesson $currentLesson)
    {
        $allLessons = $course->lessons()->orderBy('order')->get();
        
        $currentIndex = $allLessons->search(function ($lesson) use ($currentLesson) 
        {
            return $lesson->id === $currentLesson->id;
        });

        if ($currentIndex === false || $currentIndex === $allLessons->count() - 1) 
        {
            return null;
        }

        return $allLessons[$currentIndex + 1];
    }

    public function nextLesson(Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/login');
        }

        $canEdit = (($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin');
        $isEnrolled = $course->isEnrolledByUser($user);
        $isTeacherOrAdmin = ($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin';
        $hasAccess = $isTeacherOrAdmin || $isEnrolled || $lesson->is_free_preview;

        if (!$hasAccess && $user->role === 'student') 
        {
            return redirect()->route('showCourse', $course);
        }

        if (!$lesson->completions()->where('user_id', $user->id)->exists()) 
        {
            Completion::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'completed_at' => now(),
            ]);
        }

        $nextLesson = $this->getNextLesson($course, $lesson);

        if ($nextLesson) 
        {
            $nextModule = $nextLesson->module;
            
            return redirect()->route('showLesson', [
                'course' => $course,
                'module' => $nextModule,
                'lesson' => $nextLesson
            ]);
        }

        return redirect()->route('showCourse', $course);
    }

    public function create(Course $course, Module $module)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/register');
        }

        if ($user->role !== 'teacher' && $user->role !== 'admin') 
        {
            return view('errors.403');
        }

        return view('lessons.create', compact('course', 'module'));
    }

    public function store(Request $request, Course $course, Module $module)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/register');
        }

        if ($user->role !== 'teacher' && $user->role !== 'admin') 
        {
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

        return redirect()->route('showModule', ['course' => $course, 'module' => $module]);
    }

    public function edit(Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/register');
        }
        
        if (($user->role === 'teacher' && $user->id !== $course->teacher_id) || $user->role === 'student')
        {
            return view('errors.403');
        }

        return view('lessons.edit', compact('course', 'module', 'lesson'));
    }

    public function update(Request $request, Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/register');
        }

        if (($user->role === 'teacher' && $user->id !== $course->teacher_id) || $user->role === 'student')
        {
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

        return redirect()->route('showModule', compact('course', 'module'));
    }

    public function destroy(Course $course, Module $module, Lesson $lesson)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/register');
        }

        if (($user->role === 'teacher' && $user->id !== $course->teacher_id) || $user->role === 'student') 
        {
            return view('errors.403');
        }

        $lesson->delete();

        return redirect()->route('showModule', compact('course', 'module'));
    }

    public function complete(Request $request, $courseId, $lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);

        $user = Auth::user();

        if (!$user)
        {
            return redirect('/login');
        }

        if ($lesson->completions()->where('user_id', $user->id)->exists())
        {
            return back();
        }

        Completion::create([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'completed_at' => now(),
        ]);

        $course = $lesson->course;
        if ($course->isCompletedByUser($user) && !$course->hasCertificateForUser($user)) {
            $certificate = Certificate::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'certificate_number' => Certificate::generateCertificateNumber(),
                'issued_at' => now(),
            ]);
        }

        return back();
    }
}