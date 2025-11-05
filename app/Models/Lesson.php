<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video_url',
        'order',
        'duration',
        'is_free_preview'
    ];

    protected $casts = [
        'is_free_preview' => 'boolean'
    ];

    public function course() 
    {
        return $this->belongsTo(Course::class);
    }

    public function completions()
    {
        return $this->hasMany(Completion::class);
    }

    public function lessonComments()
    {
        return $this->hasMany(LessonComment::class);
    }
}
