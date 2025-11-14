<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if (!$user) 
        {
            return redirect('/register');
        }

        
    }
}
