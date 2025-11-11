<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function courses()
    {
        $user = Auth::user();

        if(!$user)
        {
            return redirect('/register');
        }

        if (auth()->user()->role === 'admin') 
        {
            return view('courses.admin');
        }
        elseif (auth()->user()->role === 'teacher')
        {
            return view('courses.teacher');
        }
        else{
            return view('courses.student');
        }
    }
}
