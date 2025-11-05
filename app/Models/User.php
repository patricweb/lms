<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar'
    ];

    protected $hidden = ['password'];

    protected function casts(): array {
        return ['password' => 'hashed'];
    }

    public function courses()
    { 
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function completions()
    { 
        return $this->hasMany(Completion::class); 
    }

    public function quizAttempts() 
    { 
        return $this->hasMany(QuizAttempt::class); 
    }

    public function courseComments() 
    { 
        return $this->hasMany(CourseComment::class); 
    }

    public function lessonComments() 
    { 
        return $this->hasMany(LessonComment::class); 
    }
}