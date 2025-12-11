<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Enrollment;
use App\Models\Favorite;
use App\Models\Certificate;
use App\Models\User;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'category_id',
        'teacher_id',
        'thumbnail',
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function modules(): HasMany 
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function courseComments(): HasMany
    {
        return $this->hasMany(CourseComment::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withPivot('enrolled_at', 'status')
            ->withTimestamps();
    }

    public function isEnrolledByUser(User $user): bool
    {
        return $this->enrollments()->where('user_id', $user->id)
            ->where('status', 'active')
            ->exists();
    }

    public function isFavoritedByUser(User $user): bool
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function getProgressForUser(User $user): int 
    {
        $total = $this->lessons()->count();
        $completed = $this->lessons()->whereHas('completions', fn($q) => $q->where('user_id', $user->id))->count();
        return $total > 0 ? round(($completed / $total) * 100) : 0;
    }

    public function isCompletedByUser(User $user): bool 
    {
        $progress = $this->getProgressForUser($user);
        return $progress === 100;
    }

    public function completionDateForUser(User $user)
    {
        return $this->lessons->flatMap(fn($l) => $l->completions->where('user_id', $user->id))->max('completed_at');    
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function hasCertificateForUser(User $user): bool
    {
        return $this->certificates()->where('user_id', $user->id)->exists();
    }
}
