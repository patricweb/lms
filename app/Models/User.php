<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Course;
use App\Models\Favorite;

class User extends Authenticatable {

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_super_admin'
    ];

    protected $hidden = ['password'];

    protected function casts(): array {
        return [
            'password' => 'hashed',
            'is_super_admin' => 'boolean'
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true;
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

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
            ->withPivot('enrolled_at', 'status')
            ->withTimestamps();
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'favorites')
            ->withTimestamps();
    }

    public function hasFavoritedCourse(Course $course): bool
    {
        return $this->favorites()->where('course_id', $course->id)->exists();
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}