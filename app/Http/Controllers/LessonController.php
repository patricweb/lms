<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Completion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if (!$user) 
        {
            return redirect('/register');
        }

        return view('lessons.show');
    }

    public function complete(Lesson $lesson)
    {
        $user = Auth::user();

        if ($lesson->completions()->where('user_id', $user->id)->exists()) {
            return back()->with('info', 'Урок уже отмечен как пройденный');
        }

        Completion::create([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Урок отмечен как пройденный!');
    }
}