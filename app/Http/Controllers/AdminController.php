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
        $loggedUser = Auth::user();

        if (!$loggedUser)
        {
            return redirect('/register');
        }

        if ($loggedUser->role !== 'admin' && !$loggedUser->isSuperAdmin())
        {
            return view('errors.403');
        }

        $totalUsers = User::count();

        $usersByRole = User::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role');

        $totalCategories = Category::count();

        $categoriesWithCourses = Category::withCount('courses')->get(['id', 'name', 'courses_count']);

        $totalCourses = Course::count();

        $publishedCourses = Course::where('is_published', true)->count();

        return view('admin.admin', compact('totalUsers', 'usersByRole','totalCategories', 'categoriesWithCourses','totalCourses', 'publishedCourses'));
    }

    public function usersIndex()
    {
        $loggedUser = Auth::user();

        if (!$loggedUser)
        {
            return redirect('/register');
        }

        if ($loggedUser->role !== 'admin' && !$loggedUser->isSuperAdmin())
        {
            return view('errors.403');
        }

        $users = User::latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function usersShow(User $user)
    {
        $loggedUser = Auth::user();

        if (!$loggedUser)
        {
            return redirect('/register');
        }

        if ($loggedUser->role !== 'admin' && !$loggedUser->isSuperAdmin())
        {
            return view('errors.403');
        }

        if ($user->isSuperAdmin()) 
        {
            return back();
        }

        return view('admin.users.show', compact('user'));
    }

    public function usersUpdateRole(Request $request, User $user)
    {
        $loggedUser = Auth::user();

        if (!$loggedUser) {
            return redirect('/register');
        }

        if ($loggedUser->role !== 'admin' && !$loggedUser->isSuperAdmin()) {
            return view('errors.403');
        }

        if ($user->isSuperAdmin()) {
            return back();
        }

        $request->validate([
            'role' => 'required|in:student,teacher,admin'
        ]);

        $user->update(['role' => $request->role]);

        return redirect(route('usersIndex'));
    }

    public function usersDestroy(User $user)
    {
        $loggedUser = Auth::user();

        if (!$loggedUser)
        { 
            return redirect('/register');
        }

        if ($loggedUser->role !== 'admin' && !$loggedUser->isSuperAdmin())
        {
            return view('errors.403');
        }

        if ($user->isSuperAdmin())
        {
            return back();
        }

        $user->delete();

        return back();
    }

    public function categoriesIndex()
    {
        $loggedUser = Auth::user();

        if (!$loggedUser) 
        {
            return redirect('/register');
        }

        if ($loggedUser->role !== 'admin' && !$loggedUser->isSuperAdmin())
        {
            return view('errors.403');
        }

        $categories = Category::withCount('courses')->latest()->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function categoriesCreate()
    {
        $loggedUser = Auth::user();

        if (!$loggedUser)
        {
            return redirect('/register');
        }

        if ($loggedUser->role !== 'admin' && !$loggedUser->isSuperAdmin())
        {
            return view('errors.403');
        }

        return view('admin.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        $loggedUser = Auth::user();

        if (!$loggedUser)
        {
            return redirect('/register');
        }

        if ($loggedUser->role !== 'admin' && !$loggedUser->isSuperAdmin())
        {
            return view('errors.403');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories',
            'description' => 'nullable|string'
        ]);

        Category::create($request->all());

        return redirect()->route('categoriesIndex');
    }

    public function categoriesDestroy(Category $category)
    {
        $loggedUser = Auth::user();

        if (!$loggedUser)
        {
            return redirect('/register');
        }

        if ($loggedUser->role !== 'admin' && !$loggedUser->isSuperAdmin())
        {
            return view('errors.403');
        }

        $category->delete();
        return back();
    }
}