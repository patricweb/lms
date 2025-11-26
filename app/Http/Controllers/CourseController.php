<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;

class CourseController extends Controller
{
    public function courses(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }

        $query = Course::with(['category', 'teacher']);

        // ====== Поиск ======
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // ====== Категории ======
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // ====== Статус (для teacher/admin) ======
        if ($user->role !== 'student' && $request->status) {
            switch ($request->status) {
                case 'all':
                    break;
                case 'published':
                    $query->where('is_published', true);
                    if ($user->role === 'teacher') {
                        $query->where('teacher_id', $user->id);
                    }
                    break;
                case 'draft':
                    $query->where('is_published', false);
                    if ($user->role === 'teacher') {
                        $query->where('teacher_id', $user->id);
                    }
                    break;
            }
        }

        // ====== Тип цены ======
        if ($request->price_type) {
            if ($request->price_type === 'free') {
                $query->where('price', 0);
            } elseif ($request->price_type === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        // ====== Мин/Макс цена ======
        if ($request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }

        // ====== Дата создания ======
        if ($request->date_filter) {
            $now = now();
            switch ($request->date_filter) {
                case '24h': $query->where('created_at', '>=', $now->subDay()); break;
                case '7d': $query->where('created_at', '>=', $now->subDays(7)); break;
                case 'month': $query->where('created_at', '>=', $now->subMonth()); break;
                case 'year': $query->where('created_at', '>=', $now->subYear()); break;
            }
        }

        // ====== Фильтр по преподавателю ======
        $teachers = [];
        if ($user->role !== 'student') {
            $teachers = User::where('role', 'teacher')->get();
            if ($request->teacher_id) {
                $query->where('teacher_id', $request->teacher_id);
            }
        }

        // ====== Ограничения по ролям ======
        if ($user->role === 'teacher') {
            $query->where(function($q) use ($user) {
                $q->where('is_published', true)
                ->orWhere('teacher_id', $user->id);
            });
        } elseif ($user->role === 'student') {
            $query->where('is_published', true);
        }

        if ($user->role === 'teacher' || $user->role === 'admin')
        {
            if ($request->my_only) {
                $query->where('teacher_id', $user->id);
            }
        }

        // ====== Сортировка ======
        if ($request->sort) {
            switch ($request->sort) {
                case 'created_asc': $query->orderBy('created_at', 'asc'); break;
                case 'created_desc': $query->orderBy('created_at', 'desc'); break;
                case 'price_asc': $query->orderBy('price', 'asc'); break;
                case 'price_desc': $query->orderBy('price', 'desc'); break;
                case 'title_asc': $query->orderBy('title', 'asc'); break;
                case 'title_desc': $query->orderBy('title', 'desc'); break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $courses = $query->paginate(9)->withQueryString();
        $categories = Category::all();

        return view('courses.index', compact('courses', 'user', 'categories', 'teachers'));
    }

    public function show(Course $course)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/register');
        }

        $course->load([
            'teacher',
            'category',
            'modules.lessons',
            'courseComments' => function ($query) {
                $query->with([
                    'user',
                    'parent.user',
                    'replies' => function ($q) {
                        $q->with(['user', 'parent.user']);
                    }
                ])->whereNull('parent_id');
            }
        ]);

        $progress = $course->getProgressForUser($user);
        $isCompleted = $course->isCompletedByUser($user);

        $canEdit = (($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin');

        return view('courses.show', compact('course', 'progress', 'isCompleted', 'canEdit', 'user'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role !== 'teacher' && $user->role !== 'admin') {
            return view('errors.403');
        }


        $categories = Category::all();

        return view('courses.create', compact('categories'));
    }

    public function save(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'teacher' && $user->role !== 'admin') {
            return view('errors.403');
        }


        $validated = $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('thumbnail'))
        {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $validated['teacher_id'] = $user->id;
        $validated['is_published'] = false;

        $course = Course::create($validated); 

        return redirect()->route('courses', $course)->with('success', 'Курс создан успешно!');
    }

    public function edit(Course $course)
    {
        $user = Auth::user();

        if ($user->role === 'teacher' && $user->id !== $course->teacher_id) {
            return view('errors.403');
        }

        if ($user->role === 'student') {
            return view('errors.403');
        }       

        $categories = Category::all();

        return view('courses.edit', compact('course', 'categories'));
    }

    public function update (Request $request, Course $course)
    {
        $user = Auth::user();

        if ($user->role === 'teacher' && $user->id !== $course->teacher_id) {
            return view('errors.403');
        }

        if ($user->role === 'student') {
            return view('errors.403');
        }

        $validated = $request->validate([
            'title' => 'nullable|min:3|max:255',
            'description' => 'nullable|min:10',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'boolean'
        ]);

        if ($request->hasFile('thumbnail'))
        {
            if ($course->thumbnail)
            {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnail', 'public');
        }

        $course->update($validated);

        return redirect()->route('showCourse', $course)->with('success', 'Курс успешно обновлен!');
    }

    public function destroy(Course $course)
    {
        $user = Auth::user();

        if ($user->role === 'teacher' && $user->id !== $course->teacher_id) {
            return view('errors.403');
        }

        if ($user->role === 'student') {
            return view('errors.403');
        }

        $course->delete();

        return redirect()->route('courses')->with('success', "Курс успешно удален");
    }
}
