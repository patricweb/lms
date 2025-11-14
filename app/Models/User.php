<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function courses(): HasMany
    { 
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function completions(): HasMany
    { 
        return $this->hasMany(Completion::class); 
    }

    public function courseComments(): HasMany
    { 
        return $this->hasMany(CourseComment::class); 
    }

    public function lessonComments(): HasMany
    { 
        return $this->hasMany(LessonComment::class); 
    }
}