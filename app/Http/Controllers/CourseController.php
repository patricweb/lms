<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Favorite;
use Symfony\Component\HttpFoundation\Response;

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

        if ($request->search)
        {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->category_id)
        {
            $query->where('category_id', $request->category_id);
        }

        if ($user->role !== 'student' && $request->status)
        {
            switch ($request->status)
            {
                case 'all':
                    break;
                case 'published':
                    $query->where('is_published', true);
                    if ($user->role === 'teacher')
                    {
                        $query->where('teacher_id', $user->id);
                    }
                    break;
                case 'draft':
                    $query->where('is_published', false);
                    if ($user->role === 'teacher')
                    {
                        $query->where('teacher_id', $user->id);
                    }
                    break;
            }
        }

        if ($request->price_type)
        {
            if ($request->price_type === 'free')
            {
                $query->where('price', 0);
            } elseif ($request->price_type === 'paid')
            {
                $query->where('price', '>', 0);
            }
        }

        if ($request->price_min)
        {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->price_max)
        {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->date_filter) 
        {
            $now = now();
            switch ($request->date_filter) {
                case '24h': 
                    $query->where('created_at', '>=', $now->subDay());
                    break;
                case '7d': 
                    $query->where('created_at', '>=', $now->subDays(7));
                    break;
                case 'month': 
                    $query->where('created_at', '>=', $now->subMonth()); 
                    break;
                case 'year': 
                    $query->where('created_at', '>=', $now->subYear()); 
                    break;
            }
        }

        $teachers = [];

        if ($user->role !== 'student') 
        {
            $teachers = User::where('role', 'teacher')->get();

            if ($request->teacher_id)
            {
                $query->where('teacher_id', $request->teacher_id);
            }
        }
        if ($user->role === 'teacher')
        {
            $query->where(function($q) use ($user)
            {
                $q->where('is_published', true)->orWhere('teacher_id', $user->id);
            });
        } else        if ($user->role === 'student') 
        {
            $query->where('is_published', true);
        }

        // Фильтр "Мои курсы" - только записанные курсы
        if ($request->my_courses && $user->role === 'student')
        {
            $enrolledCourseIds = Enrollment::where('user_id', $user->id)
                ->where('status', 'active')
                ->pluck('course_id');
            $query->whereIn('id', $enrolledCourseIds);
        }

        // Фильтр избранного
        if ($request->favorites)
        {
            $favoriteCourseIds = Favorite::where('user_id', $user->id)->pluck('course_id');
            $query->whereIn('id', $favoriteCourseIds);
        }

        if ($user->role === 'teacher' || $user->role === 'admin')
        {
            if ($request->my_only)
            {
                $query->where('teacher_id', $user->id);
            }
        }
        if ($request->sort) 
        {
            switch ($request->sort) {
                case 'created_asc': 
                    $query->orderBy('created_at', 'asc'); 
                    break;
                case 'created_desc': 
                    $query->orderBy('created_at', 'desc'); 
                    break;
                case 'price_asc': 
                    $query->orderBy('price', 'asc'); 
                    break;
                case 'price_desc': 
                    $query->orderBy('price', 'desc'); 
                    break;
                case 'title_asc': 
                    $query->orderBy('title', 'asc'); 
                    break;
                case 'title_desc': 
                    $query->orderBy('title', 'desc'); 
                    break;
            }
        } else 
        {
            $query->orderBy('created_at', 'desc');
        }

        $courses = $query->paginate(9)->withQueryString();

        // Добавляем прогресс для каждого курса
        foreach ($courses as $course) {
            $course->progress = $course->getProgressForUser($user);
            $course->isCompleted = $course->isCompletedByUser($user);
            $course->isEnrolled = $course->isEnrolledByUser($user);
            $course->isFavorite = $course->isFavoritedByUser($user);
        }

        $categories = Category::all();

        return view('courses.index', compact('courses', 'user', 'categories', 'teachers'));
    }

    public function show(Course $course)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/register');
        }

        $course->load([
            'teacher',
            'category',
            'modules.lessons' => function ($query) use ($user) {
                $query->with(['completions' => function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                }]);
            },
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

        // Проверяем запись на курс
        $isEnrolled = $course->isEnrolledByUser($user);
        $isPending = $course->enrollments()
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();
        $isFavorite = $course->isFavoritedByUser($user);
        
        // Преподаватели и админы имеют доступ к своим курсам
        $hasAccess = $isEnrolled || 
                     ($user->role === 'teacher' && $user->id === $course->teacher_id) || 
                     $user->role === 'admin';

        // Для незаписанных студентов показываем только бесплатные превью уроки
        if (!$hasAccess && $user->role === 'student') {
            foreach ($course->modules as $module) {
                // Фильтруем уроки - оставляем только бесплатные превью
                $module->lessons = $module->lessons->filter(function($lesson) {
                    return $lesson->is_free_preview;
                });
                
                // Если в модуле нет бесплатных превью, скрываем модуль
                if ($module->lessons->isEmpty()) {
                    $module->should_hide = true;
                }
            }
            
            // Убираем модули без бесплатных превью
            $course->modules = $course->modules->filter(function($module) {
                return !($module->should_hide ?? false);
            });
        }

        // Добавляем информацию о доступе к каждому уроку
        foreach ($course->modules as $module) {
            foreach ($module->lessons as $lesson) {
                $lesson->can_access = $hasAccess || $lesson->is_free_preview;
            }
        }

        // Количество заявок в ожидании для отображения автору курса/админу
        $pendingEnrollmentsCount = ($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin'
            ? $course->enrollments()->where('status', 'pending')->count()
            : 0;

        return view('courses.show', compact('course', 'progress', 'isCompleted', 'canEdit', 'user', 'isEnrolled', 'isPending', 'isFavorite', 'hasAccess', 'pendingEnrollmentsCount'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role !== 'teacher' && $user->role !== 'admin') 
        {
            return view('errors.403');
        }


        $categories = Category::all();

        return view('courses.create', compact('categories'));
    }

    public function save(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'teacher' && $user->role !== 'admin') 
        {
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

        return redirect()->route('courses', $course);
    }

    public function edit(Course $course)
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

        $categories = Category::all();

        return view('courses.edit', compact('course', 'categories'));
    }

    public function update (Request $request, Course $course)
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

        return redirect()->route('showCourse', $course);
    }

    public function destroy(Course $course)
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

        $course->delete();

        return redirect()->route('courses');
    }

    public function enroll(Course $course)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/login');
        }

        // Преподаватели и админы автоматически имеют доступ к своим курсам
        if ($user->role === 'teacher' && $user->id === $course->teacher_id) 
        {
            return redirect()->route('showCourse', $course)
                ->with('info', 'Вы являетесь преподавателем этого курса');
        }

        // Проверяем, не записан ли уже
        if ($course->isEnrolledByUser($user)) 
        {
            return redirect()->route('showCourse', $course)
                ->with('info', 'Вы уже записаны на этот курс');
        }

        // Проверяем существующую запись (в т.ч. pending/cancelled)
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) 
        {
            // Обновляем существующую запись
            $existingEnrollment->update([
                'status' => 'pending',
                'enrolled_at' => now()
            ]);
        } 
        else 
        {
            // Создаем новую запись
            Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'enrolled_at' => now(),
                'status' => 'pending'
            ]);
        }

        return redirect()->route('showCourse', $course)
            ->with('success', 'Заявка отправлена. Ожидайте одобрения преподавателем/администратором.');
    }

    public function unenroll(Course $course)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/login');
        }

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->first();

        if ($enrollment) 
        {
            $enrollment->update(['status' => 'cancelled']);
            
            return redirect()->route('courses')
                ->with('success', 'Вы отписались от курса');
        }

        return redirect()->route('showCourse', $course);
    }

    public function enrollments(Course $course)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/login');
        }

        // Проверяем права доступа
        if (!(($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin')) 
        {
            return response()->view('errors.403', [], 403);
        }

        // Загружаем заявки с информацией о пользователях
        $pendingEnrollments = $course->enrollments()
            ->where('status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $activeEnrollments = $course->enrollments()
            ->where('status', 'active')
            ->with('user')
            ->orderBy('enrolled_at', 'desc')
            ->paginate(20);

        $cancelledEnrollments = $course->enrollments()
            ->where('status', 'cancelled')
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('courses.enrollments', compact('course', 'pendingEnrollments', 'activeEnrollments', 'cancelledEnrollments', 'user'));
    }

    public function approveEnrollment(Course $course, Enrollment $enrollment)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        if (!(($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin')) {
            return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
        }

        if ($enrollment->course_id !== $course->id) {
            return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
        }

        $enrollment->update([
            'status' => 'active',
            'enrolled_at' => now()
        ]);

        return redirect()->route('courseEnrollments', $course)
            ->with('success', 'Заявка от ' . $enrollment->user->name . ' одобрена');
    }

    public function rejectEnrollment(Course $course, Enrollment $enrollment)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        if (!(($user->role === 'teacher' && $user->id === $course->teacher_id) || $user->role === 'admin')) {
            return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
        }

        if ($enrollment->course_id !== $course->id) {
            return response()->view('errors.403', [], Response::HTTP_FORBIDDEN);
        }

        $enrollment->update(['status' => 'cancelled']);

        return redirect()->route('courseEnrollments', $course)
            ->with('success', 'Заявка от ' . $enrollment->user->name . ' отклонена');
    }

    public function favorite(Course $course, Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect('/login');
        }

        Favorite::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        if ($request->wantsJson() || $request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_favorite' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Курс добавлен в избранное');
    }

    public function unfavorite(Course $course, Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect('/login');
        }

        Favorite::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->delete();

        if ($request->wantsJson() || $request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_favorite' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Курс удалён из избранного');
    }
}
