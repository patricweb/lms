<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function courseComments(): HasMany
    {
        return $this->hasMany(CourseComment::class);
    }

    public function getProgressForUser(User $user): int {
        $total = $this->lessons->count();
        $completed = $this->lessons->whereHas('completions', fn($q) => $q->where('user_id', $user->id))->count();
        return $total > 0 ? round(($completed / $total) * 100) : 0;
    }

    public function isCompletedByUser(User $user): bool {
        $progress = $this->getProgressForUser($user);
        $avgScore = $this->quizzes->avg(fn($quiz) => $quiz->quizAttempts()->where('user_id', $user->id)->latest()->first()?->score ?? 0);
        return $progress === 100 && $avgScore > 70;
    }

    public function completionDateForUser(User $user)
    {
        return $this->lessons->flatMap(fn($l) => $l->completions->where('user_id', $user->id))->max('completed_at');    
    }
}
