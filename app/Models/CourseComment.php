<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'course_id',
        'commnet',
        'parent_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(CourseComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(CourseComment::class, 'parent_id');
    }
}
