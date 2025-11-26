<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;

class AdminController extends Controller
{
    public function admin()
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect('/register');
        }
        if ($currentUser->role !== 'admin' && !$currentUser->isSuperAdmin()) {
            return view('errors.403');
        }

        // Статистика пользователей
        $totalUsers = User::count();
        $usersByRole = User::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role');

        // Статистика категорий
        $totalCategories = Category::count();
        $categoriesWithCourses = Category::withCount('courses')->get(['id', 'name', 'courses_count']);

        // Статистика курсов
        $totalCourses = Course::count();
        $publishedCourses = Course::where('is_published', true)->count();

        return view('admin.admin', compact(
            'totalUsers', 'usersByRole',
            'totalCategories', 'categoriesWithCourses',
            'totalCourses', 'publishedCourses'
        ));
    }

    public function usersIndex()
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect('/register');
        }
        if ($currentUser->role !== 'admin' && !$currentUser->isSuperAdmin()) {
            return view('errors.403');
        }

        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function usersShow(User $user)
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect('/register');
        }
        if ($currentUser->role !== 'admin' && !$currentUser->isSuperAdmin()) {
            return view('errors.403');
        }

        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Супер-админа нельзя редактировать.');
        }

        return view('admin.users.show', compact('user'));
    }

    public function usersUpdateRole(Request $request, User $user)
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect('/register');
        }
        if ($currentUser->role !== 'admin' && !$currentUser->isSuperAdmin()) {
            return view('errors.403');
        }

        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Супер-админа нельзя менять.');
        }

        $request->validate([
            'role' => 'required|in:student,teacher,admin'
        ]);

        $user->update(['role' => $request->role]);
        return redirect(route('usersIndex'))->with('success', 'Роль обновлена.');
    }

    public function usersDestroy(User $user)
    {
        $currentUser = Auth::user();
        if (!$currentUser) { 
            return redirect('/register');
        }
        if ($currentUser->role !== 'admin' && !$currentUser->isSuperAdmin()) {
            return view('errors.403');
        }

        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Супер-админа нельзя удалить.');
        }

        $user->delete();
        return back()->with('success', 'Пользователь удалён.');
    }

    public function categoriesIndex()
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect('/register');
        }
        if ($currentUser->role !== 'admin' && !$currentUser->isSuperAdmin()) {
            return view('errors.403');
        }

        $categories = Category::withCount('courses')->latest()->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function categoriesCreate()
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect('/register');
        }
        if ($currentUser->role !== 'admin' && !$currentUser->isSuperAdmin()) {
            return view('errors.403');
        }

        return view('admin.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect('/register');
        }
        if ($currentUser->role !== 'admin' && !$currentUser->isSuperAdmin()) {
            return view('errors.403');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories',
            'description' => 'nullable|string'
        ]);

        Category::create($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Категория создана.');
    }

    public function categoriesDestroy(Category $category)
    {
        $currentUser = Auth::user();
        if (!$currentUser) {
            return redirect('/register');
        }
        if ($currentUser->role !== 'admin' && !$currentUser->isSuperAdmin()) {
            return view('errors.403');
        }

        $category->delete();
        return back()->with('success', 'Категория и все курсы удалены.');
    }
}