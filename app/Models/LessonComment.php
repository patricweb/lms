<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonComment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'lesson_id',
        'comment',
        'parent_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function parent()
    {
        return $this->belongsTo(LessonComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(LessonComment::class, 'parent_id');
    }
}
