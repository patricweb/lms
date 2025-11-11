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
    }
}
